define(["model/common_item","text!template/common_item.html","core/backbone"],

    function(Item,common_item){

        return Backbone.View.extend({

            model : Item,

            template: _.template(common_item),

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