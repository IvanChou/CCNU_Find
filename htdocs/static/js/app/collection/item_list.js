define(["model/common_item","core/backbone"],function(Item){

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

        setFetchOption : /**
         * 修改异步设置
         * @param key
         * @param value
         */
            function(key,value){
            this.fetchOption.data[key] = value;
        }

    });

});