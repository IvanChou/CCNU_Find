define(["core/backbone"],function(){

    var _current;

    return Backbone.Model.extend({

        hideCard : /**
         * 将学号的六七位隐藏
         * @returns {*}
         */
            function(){
            _current = (""+this.get("card_id")).split("");
            _current[5] = '*';
            _current[6] = '*';
            return this.set( "card_id",_current.join(""));
        },

        url : /**
         * 根据当前ID获取最后的URL地址
         * @returns {string}
         */
            function(){
            return ['#item/',this.get("id")].join("");
        }

    });

});