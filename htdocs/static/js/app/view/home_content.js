define(["app/collection/item_list","app/view/item","core/backbone"],function(List,itemView){

    var findList , claimList;

    return Backbone.View.extend({

        el: $("#content"),

        contentTemplate: $('#home-template').html(),

        initialize : function(){

            this.$el.html(this.contentTemplate).fadeIn("fast");

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