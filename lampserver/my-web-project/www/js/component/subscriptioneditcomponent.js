class SubscriptionEditComponent extends Fronty.ModelComponent {
    constructor(subscriptionsModel, userModel, router) {
      super(Handlebars.templates.subscriptionedit, subscriptionsModel);
      this.subscriptionsModel = subscriptionsModel;
      this.userModel = userModel;
      this.addModel('user', userModel);
      this.router = router;
  
      this.subscriptionService = new SubscriptionService();
  
      this.addEventListener('click', '#savebutton', () => {
        // Lógica para editar la suscripción existente
      });
    }
  
    onStart() {
      var selectedId = this.router.getRouteQueryParam('id');
      if (selectedId != null) {
        this.subscriptionService.findSubscription(selectedId)
          .then((subscription) => {
            this.subscriptionsModel.setSelectedSubscription(subscription);
          });
      }
    }
  }
  