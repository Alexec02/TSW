class SubscriptionModel extends Fronty.Model {
    constructor(publicid, privateid, alias, switchs) {
      super('SubscriptionModel');
  
      if (publicid) {
        this.publicid = publicid;
      }
  
      if (privateid) {
        this.privateid = privateid;
      }
  
      if (alias) {
        this.alias = alias;
      }
  
      if (switchs) {
        this.switchs = switchs;
      }
    }
  }
  
  