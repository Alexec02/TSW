class SubscriptionComponent extends Fronty.ModelComponent {
    constructor(subscriptionsModel, userModel, router) {
      super(Handlebars.templates.subscription, subscriptionsModel);
      this.subscriptionsModel = subscriptionsModel;
      this.userModel = userModel;
      this.addModel('user', userModel);
      this.router = router;
  
      this.subscriptionService = new SubscriptionService();
  
      // Eventos y lógica específica para el componente Subscription
    }
  
    // Métodos adiccionales
  }
  