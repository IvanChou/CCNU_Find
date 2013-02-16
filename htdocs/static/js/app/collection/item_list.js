define(["app/model/item","core/backbone"],function(Item){

    return Backbone.Collection.extend({

        model: Item,

        fetchOption : {
            url : 'api/',
            data : {
                method : 'read',
                target : 'find',
                page : -1
            }
        },

        setFetchOption : function(key,value){
            this.fetchOption.data[key] = value;
        }

    });

});