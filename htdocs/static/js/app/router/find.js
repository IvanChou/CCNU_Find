define(["router/list_common"],

    function(list_common){

        return function(page){

            list_common.call(this,arguments,"find");

        }

    }

);