define(["model/card_item","text!template/card_item.html","core/backbone"],

    function(CardItem,card_item){

        return Backbone.View.extend({

            model : CardItem,

            tagName:  "tr",

            template: _.template(card_item),

            events: {
                "click"   : "href"
            },

            href : /**
             * 点击时跳转到对应的URL
             * @returns {*}
             */
                function(){
                return appRouter.navigate(this.model.url(),true);
            },

            render: function() {
                this.model.hideCard();
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            }

        });

    });