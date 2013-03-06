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
        var login_name = $(".form-signin input:text").val();
        var login_psw = $(".form-signin input:password").val();
        if(login_name && login_psw) {
            login_psw = $.sha1(login_psw);
        } else return false;

        $.post("../api/?method=read&target=admin",{login_name:login_name,login_psw:login_psw},function(result){
            if(result[0] === 0) {
                return false;
            }

            $.cookie('safe_code',result[2],{ expires: 30 });
            self.location = url;
            return true;

        },"json");

        return false;

    })

});