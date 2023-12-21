class SubscriptionViewComponent extends Fronty.ModelComponent {
    constructor(subscriptionsModel, userModel, router) {
      super(Handlebars.templates.subscriptionview, subscriptionsModel);
      this.subscriptionsModel = subscriptionsModel;
      this.userModel = userModel;
      this.addModel('user', userModel);
      this.router = router;
  
      this.subscriptionService = new SubscriptionService();
  
      this.addEventListener('click', '#savecommentbutton', () => {
        var publicid = this.router.getRouteQueryParam('publicid');
        var privateid = this.router.getRouteQueryParam('privateid');
        this.subscriptionsService.createComment(publicid, privateid, {
            content: $('#commentcontent').val()
          })
          .then(() => {
            $('#commentcontent').val('');
            this.loadSubscription(publicid, privateid);
          })
          .fail((xhr, errorThrown, statusText) => {
            if (xhr.status == 400) {
              this.subscriptionsModel.set(() => {
                this.subscriptionsModel.commentErrors = xhr.responseJSON;
              });
            } else {
              alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
            }
          });
      });
    }
  
    onStart() {
      var publicid = this.router.getRouteQueryParam('publicid');
        var privateid = this.router.getRouteQueryParam('privateid');
      this.loadSubscription(publicid, privateid);
    }
  
    loadSubscription(publicid, privateid) {
      if (publicid != null || privateid != null) {
        this.subscriptionService.findSubscription(publicid, privateid)
          .then((subscription) => {
            this.subscriptionsModel.setSelectedSubscription(subscription);
          });
      }
    }
  }
  