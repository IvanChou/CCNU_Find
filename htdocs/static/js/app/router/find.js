define(["app/view/nav","app/view/list_content","app/view/side_nav"],function(setNav,getListView,getSideNavView){

    var ListView , SideNavVIew ,sort;

    return function(page){

        if(arguments.length===2){
            sort = arguments[0];
            page = arguments[1];
        }

        ListView =  getListView('find',sort,page);
        SideNavVIew = getSideNavView('find');

        new ListView;
        new SideNavVIew;

        setNav("find");
    }

});