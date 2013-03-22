$(document).ready(function(){
    $.boxLoad();

    safe_code = $.cookie('safe_code');
    if(safe_code) {
        $.post("../api/?method=read&target=login",{safe_code:safe_code},function(result){
            if(result[0] === 0) {
                self.location = 'signin.html';
            } else {
                $(".navbar-link").html(result[2]).tooltip();
                $("body").removeAttr("style");
                initialize();
            }
        },"json")
    } else self.location = 'signin.html';

});

function initialize() {
    var my_table = $("#my_table");

    $("#contact, #home, #manage").css('min-height',$(window).height());

    $("head").append($('<style>.bs-docs-example:after { content: " 你可以不坑爹么？" }</style>'));

    $.post("../api/?method=read&target=catalog",function(result){
        var node, i = result.length;

        while(i--) {
            node = '<li class="my_sorts"><a href="#" id="' + result[i].sort_code + '">' + result[i].sort_name + '</a></li>';
            $("#my_sort").after(node);
            node = '<tr><td>' + result[i].id + '</td><td>' + result[i].sort_name + '</td><td>' + result[i].sort_code + '</td>';
            node += '<td><a href="#myModal" role="button" class="btn btn-mini" data-toggle="modal">Change</a></td></tr>';
            $(".my_sort tbody").prepend(node);
        }
    },"json");

    $.post("../api/?method=read&target=admin",function(result){
        var node, i = result.length;
        while(i--) {
            node = '<tr><td>' + (i+1) +'</td><td>' + result[i] + '</td>';
            node += '<td><a href="#myModal" role="button" class="btn btn-mini" data-toggle="modal">Change</a></td></tr>';
            $(".my_user tbody").prepend(node);
        }
    },"json");

    $(".sidebar-nav ul").delegate("li:not(.nav-header)","click",function(){
        if($(this).hasClass("active") === true) return false;
        var group = $(this).attr("class");
        $(".sidebar-nav ul li." + group).removeClass("active");
        $(this).addClass("active");

        get_list();

        return false;
    });

    my_table.on("click","tr td .btn-group button",function(){
        if($(this).hasClass("disabled")) return false;
        switch ($(this).html()) {
            case "进行" :
                set_state(this,"process");break;
            case "完成" :
                set_state(this,"success");break;
            case "过期" :
                set_state(this,"locked");break;
            default :
                return false;
        }
        return true;
    });

    my_table.on("click","tr td button.close",function(){
        $.boxLoad();

        var line = $(this).parents("tr");
        var id = line.children(":first").html();
        $.post("../api/?method=delete",{id:id,safe_code:"safe"},function(result){
            $.closeBox();
            if(feed_back(result)){
                line.fadeOut(function(){line.remove();});
            }
        },"json");
    });

    $(".my_sort tbody").on("click","tr td a",function(){
        var tr = $(this).parents("tr");
        var id = tr.children(":first").html();
        $("#myModalLabel").html("栏目修改 <span class=\"label label-info\">#"+id+"</span>");
        $("#sort_id").val(id);
        $("#frt_input").val(tr.children(":eq(1)").html());
        $("#sec_input").val(tr.children(":eq(2)").html());

    });

    $(".my_user tbody").on("click","tr td a",function(){
        var tr = $(this).parents("tr");
        var id = tr.children(":first").html();
        var user = tr.children(":eq(1)").html();
        $("#sort_id").val("");
        $("#myModalLabel").html("帐户修改 <span class=\"label label-info\">#"+id+"</span>");
        $("#frt_input").val(user).attr("placeholder", user);
        $("#sec_input").val("").attr("placeholder","新秘密 不修改留空");
    });

    $("#my_submit").click(function(){
        var id = $("#sort_id").val();

        (id === "") ? change_admin() : change_sort(id);

    });

    get_list();

    var box = new BlackBox();
    box.config.clickBackgrounEffert = 'close';
    my_table.on("click","tr td a",function(){
        var url = $(this).attr('href');
        box.iframe(url);
        return false;
    });

    $("input:text").focus(function(){
        $(this).parents(".control-group").removeClass("error");
    });

    $(".navbar-link").click(function(){
        $.removeCookie('safe_code');
        self.location = '../';
    })
}

function get_list() {
    var type = $(".sidebar-nav ul li.active.my_types a").attr("id");
    var sort = $(".sidebar-nav ul li.active.my_sorts a").attr("id");
    var state = $(".sidebar-nav ul li.active.my_states a").attr("id");
    var url = "../api/?method=read&target=" + type;
    sort && (url += "&sort=" + sort);
    state && (url += "&state=" + state);
    $.boxLoad();
    clear_page();

    $.post(url,function(result){
        $.closeBox();

        if(result === false) {
            feed_back(new Array(0,'好像请求失败了，换个浏览器试试。'));
            return false;
        }

        var node, i;
        if(result.length === 0) feed_back(new Array(1,'啊咧，这个分类还没信息，对吧？'));
        for(i in result) {
            node = build_line(result[i]);
            $("#my_table").append(node);
        }
        return true;

    },"json");
}

function build_line(obj) {
    var html = "<tr>\n";
    html += "<td>" + obj.id +"</td>";
    html += "<td><a href='../#item/" + obj.id + "'>" + obj.name + "</td>";
    html += "<td>" + obj.stu_id + "</td>";
    html += "<td class=\"my_time\">" + obj.time + "</td>";

    html += "<td><div class=\"btn-group\">";
    html += "<button class=\"btn btn-mini";
        (obj.state == "process") && (html += " disabled");
    html += "\">进行</button><button class=\"btn btn-mini";
        (obj.state == "success") && (html += " disabled");
    html += "\">完成</button><button class=\"btn btn-mini";
        (obj.state == "locked") && (html += " disabled");
    html += "\">过期</button></div></td>";

    html += "<td><button class=\"close\">&times;</button></td>";
    html += "</tr>";

    return html;
}

function set_state(obj,state) {
    $.boxLoad();

    var id = $(obj).parents("tr").children(":first").html();
    $.post("../api/?method=update",{id:id,state:state,safe_code:"safe"},function(result){
        $.closeBox();
        if(feed_back(result)){
            $(obj).siblings().removeClass("disabled");
            $(obj).addClass("disabled");
        }
    },"json")
}

function change_sort(id) {
    var first = $("#frt_input_group");
    var second = $("#sec_input_group");
    var sort_name = $("#frt_input").val();
    var sort_code = $("#sec_input").val();
    var sc_regex = /^[a-z]{1,16}$/;

    if (!sc_regex.exec(sort_code)) {
        second.addClass("error");
        second.find("span").html("仅限小写字母");
        return false;
    }

    $.boxLoad();
    $.post("../api/?method=update&target=sort",{id:id,sort_name:sort_name,sort_code:sort_code,safe_code:"safe"},function(result){
        $.closeBox();
        if(feed_back(result)) {
            $(".my_sort tbody tr").each(function(){
                if($(this).children(":first").html() == id) {
                    $(this).children(":eq(1)").html(sort_name);
                    $(this).children(":eq(2)").html(sort_code);
                }
            });
            $('#myModal').modal('hide');
        }
    },"json");
    return true;
}

function change_admin() {
    var first = $("#frt_input");
    var old_name = first.attr("placeholder");
    var new_name = first.val();
    var pwd = $("#sec_input").val();

    new_name || (new_name = old_name);
    if(new_name == old_name && !pwd) return false;
    var data = pwd ? {old:old_name,new:new_name,pwd: $.sha1(pwd)} : {old:old_name,new:new_name};

    $.boxLoad();
    $.post("../api/?method=update&target=admin",data,function(result){
        $.closeBox();
        if(feed_back(result)) {
            $('#myModal').modal('hide');
            setTimeout('location.reload()',1000);
        }
    },"json");
    return true;
}

function feed_back(array) {
    var type = array[0] === 1 ? "success" : "error";

    $.globalMessenger().post({
        message: array[1],
        type: type,
        showCloseButton: true
    });

    return (array[0] === 1);
}

function clear_page() {
    $("#my_table").empty();
    $(".my_alert").remove();
}