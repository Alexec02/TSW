class SwitchsService {
  constructor() {

  }

  findAllSwitchs() {
    return $.get(AppConfig.backendServer+'/rest/switchs');
  }

  findSwitch(publicid=NULL,privateid=NULL) {
    return $.get(AppConfig.backendServer+'/rest/switchs/' + publicid + privateid);
  }

  deleteSwitch(publicid=NULL,privateid=NULL) {
    return $.ajax({
      url: AppConfig.backendServer+'/rest/switchs/' + publicid + privateid,
      method: 'DELETE'
    });
  }

  saveSwitch(switchs) {
    return $.ajax({
      url: AppConfig.backendServer+'/rest/switchs/' + switchs.publicid + switchs.privateid,
      method: 'PUT',
      data: JSON.stringify(switchs),
      contentType: 'application/json'
    });
  }

  addSwicth(switchs) {
    return $.ajax({
      url: AppConfig.backendServer+'/rest/switchs',
      method: 'POST',
      data: JSON.stringify(switchs),
      contentType: 'application/json'
    });
  }

}
