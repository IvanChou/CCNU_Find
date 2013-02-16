define(["jquery"],function($){

    /* 除了第一次打开，以后每次都要先渐变去除内容然后才载入新的内容 */

    var isInit = true,_content = $("#content , #sidebar"),_body = $("html, body");

    return function(callback){

        callback = callback || $.noop;

        if(isInit){
            _content.fadeOut(0);
            callback();
            isInit = false;
            return;
        }

        _content.fadeOut(200);
        _body.animate({ scrollTop: 0 }, 200);
        setTimeout(function(){
            _content.html("");
            callback();
        },200)

    }

});