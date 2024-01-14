class SubscriptionService {
  constructor() {

  }

  findAllSubscriptions() {
    return $.get(AppConfig.backendServer+'/rest/subscription');
  }

  findSubscription(publicid,privateid) {
    return $.get(AppConfig.backendServer+'/rest/subscription/' + publicid + privateid);
  }

  deleteSubscription(publicid,user) {
    return $.ajax({
      url: AppConfig.backendServer+'/rest/subscription/' + publicid +'/'+ user,
      method: 'DELETE'
    });
  }

  saveSubscription(subscriptions) {
    return $.ajax({
      url: AppConfig.backendServer+'/rest/subscription/' + subscriptions.publicid + switchs.privateid,
      method: 'PUT',
      data: JSON.stringify(subscriptions),
      contentType: 'application/json'
    });
  }

  addSubscription(subscription) {
    return $.ajax({
      url: AppConfig.backendServer+'/rest/subscription',
      method: 'POST',
      data: JSON.stringify(subscription),
      contentType: 'application/json'
    });
  }

}
