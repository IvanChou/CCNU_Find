define(["app/view/nav","app/view/card_sidebar","app/view/home_content"],function(setNav,CardSidebar,homeContent){

    return function(){
        setNav("home");
        new CardSidebar;
        new homeContent;
    }

});