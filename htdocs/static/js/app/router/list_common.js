define(["view/nav","view/list_content","view/sort_sidebar"],
    function(setNav,getListView,getSideNavView){

        var ListView , SideNavVIew;

        return function(args,target){

            if(args.length===1){
                args[1] = 1;
            }

            ListView =  getListView(target,args[0],args[1]);
            SideNavVIew = getSideNavView(target);

            new ListView;
            new SideNavVIew;

            setNav.call(this,target);
        }

    });