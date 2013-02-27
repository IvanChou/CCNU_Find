define(["view/reset","core/backbone"],

    function(reset){

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

            initialize: /**
             *每个路由对应一个router里面文件的名称
             *当当前URL匹配时候会引入对应的文件，并执行返回的方法
             */
                function() {
                _.map(this.routes,function(value,key){
                    this._setRoutes.call(this,key,value)
                },this)
            },

            _setRoutes : /**
             * 根据路由的参数还引入相应的函数并执行，并初始化页面
             * @param key
             * @param value
             * @private
             */
                function(key,value){
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


        return function(){
            window.appRouter = new AppRouter;
            Backbone.history.start();
        }

    });