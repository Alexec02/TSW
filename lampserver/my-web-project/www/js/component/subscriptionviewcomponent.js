class SubscriptionViewComponent extends Fronty.ModelComponent {
    constructor(subscriptionsModel, userModel, router) {
      super(Handlebars.templates.subscriptionview, subscriptionsModel);
      this.subscriptionsModel = subscriptionsModel;
      this.userModel = userModel;
      this.addModel('user', userModel);
      this.router = router;
  
      this.subscriptionService = new SubscriptionService();
  
      this.addEventListener('click', '#savebutton', () => {
        // Lógica para guardar comentarios en la suscripción
      });
    }
  
    onStart() {
      var selectedId = this.router.getRouteQueryParam('id');
      this.loadSubscription(selectedId);
    }
  
    loadSubscription(subscriptionId) {
      if (subscriptionId != null) {
        this.subscriptionService.findSubscription(subscriptionId)
          .then((subscription) => {
            this.subscriptionsModel.setSelectedSubscription(subscription);
          });
      }
    }
  }
  