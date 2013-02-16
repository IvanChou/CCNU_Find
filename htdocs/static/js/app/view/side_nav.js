define(["core/backbone"],function(){

    var sorts = [

        {name:'书籍资料',url:'book'},
        {name:'衣服饰品',url:'apparel'},
        {name:'随身物品',url:'belongs'},
        {name:'电子数码',url:'electronics'},
        {name:'卡类证件',url:'card'},
        {name:'其他物品',url:'others'}

    ];

    return function(target){
        return Backbone.View.extend({

            el: $("#sidebar"),

            sideNavTemplate: _.template($("#side-sort-template").html()),

            initialize : function(){

                this.$el.html(this.sideNavTemplate({
                    'target' : target,
                    'sorts' : sorts
                })).fadeIn("fast");
            }

        });
    };

});