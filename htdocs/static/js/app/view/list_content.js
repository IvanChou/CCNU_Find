define(["collection/item_list","view/common_item","text!template/list_content.html","text!template/list_navigate.html","core/backbone"],

    function(List,itemView,list_content,list_navigate){

        var list,navStatus = [true,true];

        return function (target,sort,page){

            page = page > 0 ? page : 1;
            sort = sort ? sort : 'all';

            return Backbone.View.extend({

                el : $("#content"),

                contentTemplate :_.template(list_content),

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

                renderNavigate : /**
                 * 根据当前内容生成翻页内容
                 */
                    function(){
                    navStatus[0] = true;
                    navStatus[1] = true;
                    if(page<2&&list.length<11)return;
                    var navigateTemplate = _.template(list_navigate);
                    this.$el.append(navigateTemplate({
                        currentPage : page,
                        currentUrl : [target,sort].join("/"),
                        isNextPage : list.length > 10
                    }))
                }

            })
        };

    });