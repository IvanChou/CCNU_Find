define(["core/backbone"],function(){

    return Backbone.Model.extend({

        /*根据id获得最后的url*/
        url : function(){
            return ['#item/',this.get("id")].join("");
        }

    });

});