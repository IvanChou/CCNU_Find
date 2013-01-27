(function(window){

    require(["app/view/reset","core/backbone"],function(reset){

        var AppRouter = Backbone.Router.extend({

            routes: {
                "" : "index",
                "find" : "find",
                "find/:page" : "find",
                "find/:sort/:page" : "find",
                "claim" : "claim",
                "claim/:page" : "claim",
                "claim/:sort/:page" : "claim",
                "action/pick_up" : "pick_up",
                "action/lose" : "lose",
                "item/:id" : "item",
                "card/:id" : "card"
            },

            /*
            每个路由对应一个router里面文件的名称
            当当前URL匹配时候会引入对应的文件，并执行返回的方法
             * */
            initialize: function() {
                for(var key in this.routes){
                    if(!this.routes.hasOwnProperty(key))continue;
                    var value = this.routes[key];
                    this.setRoutes.call(this,key,value)
                }
            },

            setRoutes : function(key,value){
                this.route(key, value, function(){
                    var args = arguments;
                    reset(function(){
                        require([["app/router/",value].join("")],function(init){
                            init.apply(this,args);
                        });
                    });
                })
            }

        });

        window.appRouter = new AppRouter;
        Backbone.history.start();

    });

})(window);