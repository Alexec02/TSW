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

    onStart() {
      this.updateSubscriptions();
    }

    updateSubscriptions() {
      this.subscriptionsService.findAllSubscriptions().then((data) => {
  
        this.subscriptionsModel.setSubscriptions(
          // create a Fronty.Model for each item retrieved from the backend
          data.map(
            (item) => new SubscriptionModel(item.publicid, item.privateid, item.alias, item.switchs)
        ));
      });
    }
  
    // Override
    createChildModelComponent(className, element, id, modelItem) {
      return new SubscriptionRowComponent(modelItem, this.userModel, this.router, this);
    }
  }
  
  class SubscriptionRowComponent extends Fronty.ModelComponent {
    constructor(subscriptionModel, userModel, router, switchsComponent) {
      super(Handlebars.templates.subscriptionrow, subscriptionModel, null, null);
      
      this.subscriptionsComponenent = SubscriptionComponent;
      

      this.userModel = userModel;
      this.addModel('user', userModel); // a secondary model
      
      this.router = router;
  
      this.addEventListener('click', '.remove-button', (event) => {
        if (confirm(I18n.translate('Are you sure?'))) {
          var publicid = event.target.getAttribute('publicid');
          var privateid = event.target.getAttribute('privateid');
          this.subscriptionsComponent.subscriptionsService.deleteSubsciption(publicid,privateid)
            .fail(() => {
              alert('subsciption cannot be deleted')
            })
            .always(() => {
              this.subcriptionsComponent.updateSwitchs();
            });
        }
      });
  
    
  }
}