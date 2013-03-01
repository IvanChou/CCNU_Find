define(["text!template/sort_sidebar.html","core/backbone"],

    function(sort_sidebar){

        var sorts = [

            {name:'书籍资料',url:'books'},
            {name:'衣服饰品',url:'apparels'},
            {name:'随身物品',url:'belongs'},
            {name:'电子数码',url:'electronics'},
            {name:'卡类证件',url:'cards'},
            {name:'其他物品',url:'others'}

        ];

        return function(target){

            return Backbone.View.extend({

                el: $("#sidebar"),

                sideNavTemplate: _.template(sort_sidebar),

                initialize : function(){

                    this.$el.html(this.sideNavTemplate({
                        'target' : target,
                        'sorts' : sorts
                    })).fadeIn("fast");
                }

            });
        };

    });