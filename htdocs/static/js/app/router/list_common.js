define(["view/nav","view/list_content","view/sort_sidebar"],
    function(setNav,getListView,getSideNavView){

        var ListView , SideNavVIew ,sort;

        return function(page,type){

            if(arguments.length===2){
                sort = arguments[0];
                page = arguments[1];
            }

            ListView =  getListView(type,sort,page);
            SideNavVIew = getSideNavView(type);

            new ListView;
            new SideNavVIew;

            setNav.call(this,type);
        }

    });