define(["app/model/card_item","core/backbone"],function(CardItem){

    return Backbone.View.extend({

        model : CardItem,

        tagName:  "tr",

        template: _.template($('#card-item-template').html()),

        events: {
            "click"   : "href"
        },

        href : function(){
            return appRouter.navigate(this.model.url(),true);
        },

        render: function() {
            this.model.hideCard();
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        }

    });

});