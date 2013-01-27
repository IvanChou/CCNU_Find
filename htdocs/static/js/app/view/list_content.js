define(["app/collection/item_list","app/view/item","core/backbone"],function(List,itemView){

    var list,navStatus = [true,true];

    return function (target,sort,page){

        page = page > 0 ? page : 1;

        sort = sort ? sort : 'all';

         return Backbone.View.extend({

            el : $("#content"),

            contentTemplate :_.template($("#list-template").html()),

            initialize : function(){

                this.$el.html(this.contentTemplate({
                    title : {
                        'claim' : '招领信息列表',
                        'find' : '寻物信息列表'
                    }[target]
                })).fadeIn("fast");

                this.listContent = $("#list_content");
                list = new List;
                list.setFetchOption('target',target);
                list.setFetchOption('page',page);
                list.setFetchOption('sort',sort);
                this.listenTo(list, 'reset', this.render);
                list.fetch(list.fetchOption);
            },

             render : function(){
                 this.renderNavigate();
                 var i = 0;
                 list.each(function(item){
                    i+=1;
                    if(i<11)this.addOne(item);
                 },this);
             },

             addOne : function(Item){
                 var view = new itemView({model: Item});
                 this.listContent.append(view.render().el);
             },

             //根据返回和当前页面生成翻页
             renderNavigate : function(){
                 navStatus[0] = true;
                 navStatus[1] = true;
                 if(page<2&&list.length<11)return;
                 var navigateTemplate = _.template($("#navigate-template").html());
                 this.$el.append(navigateTemplate({
                    currentPage : page,
                    currentUrl : [target,sort].join("/"),
                    isNextPage : list.length > 10
                 }))
             }

        })
    };

});