define(["app/collection/card_list","app/view/card_item","core/backbone"],function(CardList,CardItemView){

    var cardList;

    return  Backbone.View.extend({

        el: $("#sidebar"),

        sidebarTemplate: $('#card-sidebar-template').html(),

        initialize: function(){
            cardList = new CardList;
            this.$el.html(this.sidebarTemplate).fadeIn("fast");
            this.input = this.$("#the_card_id");
            this.table = this.$("table");
            this.listenTo(cardList, 'reset', this.render);
            cardList.fetch(cardList.fetchOption);
        },

        render : function(){
            cardList.each(this.addOne,this)
        },

        addOne : function(cardItem){
            var view = new CardItemView({model: cardItem,className:"transition"});
            this.table.append(view.render().el);
        },

        /*学号搜索的相关内容*/

        events: {
            "focus #the_card_id"   : "hideInput",
            "blur #the_card_id"   : "showInput",
            "click #find_card"  : "findCart"
        },

        getUserInput : function(){
            var _input = $.trim(this.input.val());
            if(_input === "输入你的学号" )return '';
            return _input;
        },

        hideInput : function(){
            if(this.getUserInput())return;
            this.input.val("");
        },

        showInput : function(){
            if(this.getUserInput())return;
            this.input.val("输入你的学号");
        },

        findCart : function(){
            var _card = this.getUserInput();
            if(!_card)return;
            return appRouter.navigate(["#card/",_card].join(""),true);
        }

    });

});