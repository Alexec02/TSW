class SwitchsComponent extends Fronty.ModelComponent {
  constructor(switchsModel, userModel, router) {
    super(Handlebars.templates.swicthtable, switchsModel, null, null);
    
    
    this.switchsModel = switchsModel;
    this.userModel = userModel;
    this.addModel('user', userModel);
    this.router = router;

    this.switchsService = new SwitchsService();

  }

  onStart() {
    this.updateSwitchs();
  }

  updateSwitchs() {
    this.switchsService.findAllSwitchs().then((data) => {

      this.switchsModel.setSwitchs(
        // create a Fronty.Model for each item retrieved from the backend
        data.map(
          (item) => new SwitchModel(item.publicid,item.privateid, item.nombre, item.estado, item.ultima_modificaion, item.encendido_hasta, item.descripcion, item.alias)
      ));
    });
  }

  // Override
  createChildModelComponent(className, element, id, modelItem) {
    return new SwitchRowComponent(modelItem, this.userModel, this.router, this);
  }
}

class SwitchRowComponent extends Fronty.ModelComponent {
  constructor(switchModel, userModel, router, switchsComponent) {
    super(Handlebars.templates.switchrow, switchModel, null, null);
    
    this.switchsComponent = switchsComponent;
    
    this.userModel = userModel;
    this.addModel('user', userModel); // a secondary model
    
    this.router = router;

    this.addEventListener('click', '.remove-button', (event) => {
      if (confirm(I18n.translate('Are you sure?'))) {
       // var publicid = event.target.getAttribute('publicid');
        var privateid = event.target.getAttribute('privateid');
        this.switchsComponent.switchsService.deleteSwitch(privateid)  
               .fail(() => {
            alert('switch cannot be deleted')
          })
          .always(() => {
            this.switchsComponent.updateSwitchs();
          });
      }
    });

    this.addEventListener('click', '.edit-button', (event) => {
      var publicid = event.target.getAttribute('publicid');
        var privateid = event.target.getAttribute('privateid');
        this.switchsComponent.switchsService.editSwitch(publicid,privateid)
          .fail(() => {
            alert('switch cannot be edited')
          })
          .always(() => {
            this.switchsComponent.updateSwitchs();
          });
    });
  }

}
