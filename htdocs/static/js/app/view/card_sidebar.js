define(["collection/card_list","view/card_item","text!template/card_sidebar.html","core/backbone"],

    function(CardList,CardItemView,card_sidebar){

        var cardList;

        return  Backbone.View.extend({

            el: $("#sidebar"),

            initialize: function(){
                cardList = new CardList;
                this.$el.html(card_sidebar).fadeIn("fast");
                this.input = this.$("#the_card_id");
                this.table = this.$("table");
                this.listenTo(cardList, 'reset', this.render);
                cardList.fetch(cardList.fetchOption);
            },

            render : function(){
                cardList.each(this.addOne,this)
            },

            addOne : /**
             * 生成一卡通列表
             * @param cardItem
             */
                function(cardItem){
                var view = new CardItemView({model: cardItem,className:"transition"});
                this.table.append(view.render().el);
            },

            events: {
                "focus #the_card_id"   : "hideInput",
                "blur #the_card_id"   : "showInput",
                "click #find_card"  : "findCart"
            },

            getUserInput : /**
             * 获取到用户输入的内容
             * @returns {String}
             */
                function(){
                var _input = $.trim(this.input.val());
                if(_input === "输入你的学号" )return '';
                return _input;
            },

            hideInput : /**
             * 搜索框获得焦点时隐藏提示
             */
                function(){
                if(this.getUserInput())return;
                this.input.val("");
            },

            showInput : /**
             * 搜索框失去焦点时如果没有内容显示提示
             */
                function(){
                if(this.getUserInput())return;
                this.input.val("输入你的学号");
            },

            findCart : /**
             * 根据用户的输入跳转至搜索页
             */
                function(){
                var _card = this.getUserInput();
                if(_card){
                    appRouter.navigate(["#card/",_card].join(""),true);
                }
            }

        });

    });