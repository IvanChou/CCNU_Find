(function(){

    require.config({
        paths: {
            jquery: 'require-jquery',
            text : 'core/text',
            collection : 'app/collection',
            model : 'app/model',
            router : 'app/router',
            template : 'app/template',
            view : 'app/view'
        },
        /**
         * 更新文件时需更新版本号
         */
        urlArgs: "version=20130203f"
    });

    $(document).ready(
        /**
         * 引入路由
         */
        function(){
            require(["router/init"],function(site_setup){
                site_setup.apply(this);
            });
    })

})();