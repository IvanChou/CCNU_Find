$(document).ready(function(){
    var my_table = $("#my_table");

    $("#contact, #home, #manage").css('min-height',$(window).height());

    $("head").append($('<style>.bs-docs-example:after { content: " 你可以不坑爹么？" }</style>'));

    $.get("../api/?method=read&target=catalog",function(result){
        var node, i = result.length;

        while(i--) {
            node = '<li class="my_sorts"><a href="#" id="' + result[i].sort_code + '">' + result[i].sort_name + '</a></li>';
            $("#my_sort").after(node);
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
        var line = $(this).parents("tr");
        var id = line.children(":first").html();
        $.post("../api/?method=delete",{id:id,safe_code:"safe"},function(result){
            if(result[0] === 0) {
                push_error(result[1]);
                return false;
            }

            line.fadeOut(function(){line.remove();});
            return true;
        })
    });

    get_list();

    var box = new BlackBox();
    box.config.clickBackgrounEffert = 'close';
    my_table.on("click","tr td a",function(){
        var url = $(this).attr('href');
        box.iframe(url);
        return false;
    });

});

function get_list() {
    var type = $(".sidebar-nav ul li.active.my_types a").attr("id");
    var sort = $(".sidebar-nav ul li.active.my_sorts a").attr("id");
    var state = $(".sidebar-nav ul li.active.my_states a").attr("id");
    var url = "../api/?method=read&target=" + type;
    sort && (url += "&sort=" + sort);
    state && (url += "&state=" + state);
    clear_page();

    $.get(url,function(result){
        if(result === false) {
            push_error('好像请求服务器失败了，换个浏览器试试。');
            return false;
        }

        var node, i;
        if(result.length === 0) push_warning('啊咧，这个分类下一条信息都没有哦，是这样吧？');
        for(i in result) {
            node = build_line(result[i]);
            $("#my_table").append(node);
        }
        return true;

    },"json")
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
    var id = $(obj).parents("tr").children(":first").html();
    $.post("../api/?method=update",{id:id,state:state,safe_code:"safe"},function(result){
        if(result[0] === 0) {
            push_error(result[1]);
            return false;
        }

        $(obj).siblings().removeClass("disabled");
        $(obj).addClass("disabled");
        return true;
    },"json")
}

function push_error(string) {
    var node = '<div class="alert fade in alert-error my_alert">';
    node += '<button type="button" class="close" data-dismiss="alert">×</button><strong>o_O~ 出错鸟：</strong>';
    node += string;
    node += '</div>';

    $("div.navbar.navbar-fixed-top").append(node);
}

function push_warning(string) {
    var node = '<div class="alert fade in my_alert">';
    node += '<button type="button" class="close" data-dismiss="alert">×</button><strong>=。= 前面有情况：</strong>';
    node += string;
    node += '</div>';

    $("div.navbar.navbar-fixed-top").append(node);
}

function clear_page() {
    $("#my_table").empty();
    $(".my_alert").remove();
}