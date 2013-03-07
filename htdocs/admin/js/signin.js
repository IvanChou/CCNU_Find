$(document).ready(function(){
    safe_code = $.cookie('safe_code');
    url = window.location.href.slice(0,-11);

    if(safe_code) {
        $.post("../api/?method=read&target=admin",{safe_code:safe_code},function(result){
            if(result[0] === 1) {
                $.cookie('safe_code',safe_code,{ expires: 7 });
                self.location = url;
            }
        },"json")
    }

    $(".form-signin button").click(function(){
        var form = $(".form-signin");
        var login_name = form.find("input:text").val();
        var login_psw = form.find("input:password").val();
        var remember = form.find("input:checked").val();

        login_name || form.children("div:first").addClass("error");
        login_psw || form.children("div:eq(1)").addClass("error");

        if(login_name && login_psw) {
            login_psw = $.sha1(login_psw);
        } else return false;

        $.boxLoad();
        $.post("../api/?method=read&target=admin",{login_name:login_name,login_psw:login_psw},function(result){
            $.closeBox();
            if(result[0] === 0) {
                form.children("div:first").addClass("warning");
                error(result[1]);}
            else if(result[0] === 2) {
                form.children("div:eq(1)").addClass("warning");
                error(result[1]);}
            else {
                (remember && $.cookie('safe_code',result[2],{ expires: 30 })) || $.cookie('safe_code',result[2]);
                self.location = url;
            }

        },"json");

        return false;

    })

    $("input").focus(function(){
        $(this).parent().removeClass("error");
        $(this).parent().removeClass("warning");
    })

});

function error(str) {
    $.globalMessenger().post({
        message: result[1],
        type: 'error',
        showCloseButton: true
    });
}