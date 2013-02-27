define(["core/backbone"],function(){

    return Backbone.Model.extend({

        url : /**
         * 根据当前ID获取最后的URL地址
         * @returns {string}
         */
            function(){
            return ['#item/',this.get("id")].join("");
        }

    });

});