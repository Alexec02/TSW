class SwitchsService {
  constructor() {

  }

  findAllSwitchs() {
    return $.get(AppConfig.backendServer+'/rest/switchs');
  }

  findSwitch(publicid,privateid) {
    return $.get(AppConfig.backendServer+'/rest/switchs/' + publicid + privateid);
  }

  deleteSwitch(publicid,privateid) {
    return $.ajax({
      url: AppConfig.backendServer+'/rest/switchs/' + publicid + privateid,
      method: 'DELETE'
    });
  }

  saveSwitch(switchs) {
    return $.ajax({
      url: AppConfig.backendServer+'/rest/swicths/' + switchs.publicid + switchs.privateid,
      method: 'PUT',
      data: JSON.stringify(switchs),
      contentType: 'application/json'
    });
  }

  addSwicth(switchs) {
    return $.ajax({
      url: AppConfig.backendServer+'/rest/swicths',
      method: 'POST',
      data: JSON.stringify(swicths),
      contentType: 'application/json'
    });
  }

}
