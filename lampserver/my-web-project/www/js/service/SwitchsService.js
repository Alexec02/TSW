class SwitchsService {
  constructor() {

  }

  findAllSwitchs() {
    return $.get(AppConfig.backendServer+'/rest/switchs');
  }

  findSwitch(publicid=NULL,privateid=NULL) {
    if(publicid!=null && privateid!=null){
      return $.get(AppConfig.backendServer+'/rest/switchs/' + publicid + '/' + privateid);
    }else if(privateid!=null){
      console.log("find private "+privateid)
      return $.get(AppConfig.backendServer+'/rest/switchs//' + privateid );
    }else{
      return $.get(AppConfig.backendServer+'/rest/switchs/' + publicid + '/' );
    }
    
  }

  deleteSwitch(privateid=NULL) {
    return $.ajax({
      url: AppConfig.backendServer+'/rest/switchs/' +privateid,
      method: 'DELETE'
    });
  }

  saveSwitch(switchs) {
    return $.ajax({
      url: AppConfig.backendServer+'/rest/switchs/' + switchs.private_id,
      method: 'PUT',
      data: JSON.stringify(switchs),
      contentType: 'application/json'
    });
  }

  addSwitch(newSwitch) {
    return $.ajax({
      url: AppConfig.backendServer + '/rest/switchs',
      method: 'POST',
      data: JSON.stringify(newSwitch),
      contentType: 'application/json'
    });
  }

}
