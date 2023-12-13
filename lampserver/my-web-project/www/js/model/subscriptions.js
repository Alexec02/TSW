class SubscriptionsModel extends Fronty.Model {
    constructor() {
      super('SubscriptionsModel');
      this.subscriptions = [];
    }
  
    setSelectedSubscription(subscription) {
      this.set((self) => {
        self.selectedSubscription = subscription;
      });
    }
  
    setSubscriptions(subscriptions) {
      this.set((self) => {
        self.subscriptions = subscriptions;
      });
    }
  }
  