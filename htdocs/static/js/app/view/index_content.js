define(["collection/item_list","view/common_item","text!template/index_content.html","core/backbone"],

    function(List,itemView,index_content){

        var findList , claimList;

        return Backbone.View.extend({

            el: $("#content"),

            initialize : /**
             * 从服务器获取失物和招领数据并解析
             */
                function(){

                this.$el.html(index_content).fadeIn("fast");

                this.findContent = this.$("#home_find");
                this.claimContent = this.$("#home_claim");

                findList = new List;
                findList.setFetchOption('target','find');
                findList.setFetchOption('page',-1);
                this.listenTo(findList, 'reset', this.findRender);
                findList.fetch(findList.fetchOption);

                claimList = new List;
                claimList.setFetchOption('target','claim');
                claimList.setFetchOption('page',-1);
                this.listenTo(claimList, 'reset', this.claimRender);
                claimList.fetch(claimList.fetchOption);
            },

            findRender : function(){
                findList.each(this.addFind,this)
            },

            claimRender : function(){
                claimList.each(this.addClaim,this)
            },

            addFind : function(Item){
                var view = new itemView({model: Item});
                this.findContent.append(view.render().el);
            },

            addClaim : function(Item){
                var view = new itemView({model: Item});
                this.claimContent.append(view.render().el);
            }

        });

    });