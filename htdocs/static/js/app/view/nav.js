define(["jquery"],function($){

    /**
     根据传入值来设定当前的nav，可以传入的值为 'home' , 'find' , 'claim'
     * */

    var $head_nav_li = $("#head_nav").find("li");

    return function (page){

        page = (page === "find" || page === "claim") ? page : "";

        $head_nav_li.each(function(){
            var thisA = $(this)[0].childNodes[0];
            if($(thisA).attr("href")==="#"+page){
                thisA.className ="current";
            }else if(thisA.className =="current"){
                thisA.className = "";
            }
        });

    }

});