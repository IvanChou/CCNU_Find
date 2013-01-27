define(["app/model/item","core/backbone"],function(Item){

    return Backbone.View.extend({

        model : Item,

        template: _.template($('#item-template').html()),

        events: {
            "click"   : "href"
        },

        href : function(){
            return appRouter.navigate(this.model.url(),true);
        },

        render: function() {
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        }

    });

});