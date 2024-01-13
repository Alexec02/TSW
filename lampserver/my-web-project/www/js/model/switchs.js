class SwitchsModel extends Fronty.Model {

  constructor() {
    super('SwitchsModel'); //call super

    // model attributes
    this.switchs = [];

    this.subscriptions = [];

  }

  setSelectedSwitch(switchs) {
    this.set((self) => {
      self.selectedSwitch = switchs;
    });
  }

  setSwitchs(switchs) {
    this.set((self) => {
      self.switchs = switchs;
    });
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
