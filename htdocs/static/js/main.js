(function(){

    require.config({
        paths: {
            jquery: 'require-jquery'
        }
    });

    $(document).ready(function(){
        require(["app/router/init"]);
    })

})();