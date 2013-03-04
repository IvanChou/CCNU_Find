$(document).ready(function(){
    $("#contact, #home, #manage").css('min-height',$(window).height());

    $("head").append($('<style>.bs-docs-example:after { content: " 你可以不坑爹么？" }</style>'));

    $.post("http://www.ccnufind.ic/api/?method=read&target=sort",{},function(result){
        var node, i = result.length;

        while(i--) {
            node = '<li><a href="#" id="' + result[i].sort_code + '">' + result[i].sort_name + '</a></li>';
            $("#my_sort").after(node);
        }
    },"json")

    $(".sidebar-nav ul").delegate("li:not(.nav-header)","click",function(){
        $(".sidebar-nav ul li").removeClass("active");
        $(this).addClass("active");

        return false;
    })

});