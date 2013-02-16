define(["core/backbone"],function(){

    var _this_change_card = [];

    return Backbone.Model.extend({

        /*出于隐私考虑，将学号的第六位隐蔽*/
        hideCard : function(){
            _this_change_card.length = 0;
            _this_change_card = (""+this.get("card_id")).split("");
           _this_change_card[5] = '*';
            return this.set( "card_id",_this_change_card.join(""));
        },

        /*根据id获得最后的url*/
        url : function(){
            return ['#item/',this.get("id")].join("");
        }

   });

});