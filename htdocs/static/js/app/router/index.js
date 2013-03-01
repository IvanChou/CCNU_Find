define(["view/nav","view/card_sidebar","view/index_content"],
    function(setNav,CardSidebar,homeContent){

    return function(){
        setNav.call(this,("home"));
        new CardSidebar;
        new homeContent;
    }

});