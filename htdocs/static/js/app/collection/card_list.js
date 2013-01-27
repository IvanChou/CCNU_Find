define(["app/model/card_item","core/backbone"],function(CardItem){

    return Backbone.Collection.extend({

        model: CardItem,

        fetchOption : {
            url : 'api/',
            data : {
                method : 'read',
                target : 'card',
                page : -1
            }
        }
    });

});