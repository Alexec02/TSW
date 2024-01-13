class SwitchsComponent extends Fronty.ModelComponent {
  constructor(switchsModel, userModel, subscriptionsModel, router) {
    super(Handlebars.templates.switchsindex, switchsModel, null, null);
    
    this.switchsModel = switchsModel;
    this.userModel = userModel;
    this.addModel('user', userModel);
    this.router = router;

    this.switchsService = new SwitchsService();
    this.subscriptionService = new SubscriptionService();
  }

  onStart() {
    this.updateSwitchs();
  }

  updateSwitchs() {
  this.switchsService.findAllSwitchs().then((data) => {
    this.switchsModel.setSwitchs(data.map(
      (item) => new SwitchModel(item.public_id, item.private_id, item.nombre, item.estado, item.tiempo_modificacion, item.encendido_hasta, item.descripcion, item.alias)
    ));

  });
  this.subscriptionService.findAllSubscriptions().then((data) => {
    this.switchsModel.setSubscriptions(data.map(
      (item) => new SwitchModel(item.public_id, null, item.nombre, item.estado, item.tiempo_modificacion, item.encendido_hasta, item.descripcion, item.alias)
    ));
  });
  
  
}

  createChildModelComponent(className, element, id, modelItem) {
    if (className=="SwitchRowComponent"){
      return new SwitchRowComponent(modelItem, this.userModel, this.router, this);
    }else{
      return new SubscriptionRowComponent(modelItem, this.userModel, this.router, this);
    }
  }
}


class SwitchRowComponent extends Fronty.ModelComponent {
  constructor(switchsModel, userModel, router, switchsComponent) {
    super(Handlebars.templates.switchrow, switchsModel, null, null);
    
    this.switchsComponent = switchsComponent;
    this.switchsModel = switchsModel;
    this.userModel = userModel;
    this.addModel('user', userModel); // a secondary model
    
    this.router = router;

    this.addEventListener('click', '.remove-button', (event) => {
      if (confirm(I18n.translate('Are you sure?'))) {
       // var publicid = event.target.getAttribute('publicid');
        var privateid = event.target.getAttribute('item');
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
      var privateid = event.target.getAttribute('item');
      console.log(privateid);
      //this.loadSwitch(privateid);
      this.switchsComponent.switchsService.findSwitch(null,privateid)
      .then((switchs) => {
        this.switchsComponent.switchsModel.setSelectedSwitch(switchs);// no va
        switchs.encendido_hasta = 0;
        switchs.estado = 0;
        this.switchsComponent.switchsService.saveSwitch(switchs)
          .fail(() => {
            alert('switch cannot be edited')
          })
          .always(() => {
            this.switchsComponent.updateSwitchs();
          });
      });
        
        
      });
      //console.log(this.switchsComponent.switchsModel.selectedSwitch);
      
  }

  loadSwitch(privateid) {
    this.switchsComponent.switchsService.findSwitch(null,privateid)
      .then((switchs) => {
        console.log(switchs);
        this.switchsComponent.switchsModel.setSelectedSwitch(switchs);// no va
        console.log(this.switchsComponent.switchsModel.selectedSwitch);
      });
  }
}


class SubscriptionRowComponent extends Fronty.ModelComponent {
  constructor(switchModel, userModel, router, switchsComponent) {
    super(Handlebars.templates.subscriptionrow, switchModel, null, null);
    
    this.switchsComponent = switchsComponent;
    
    this.userModel = userModel;
    this.addModel('user', userModel); // a secondary model
    
    this.router = router;

    this.addEventListener('click', '.remove-button', (event) => {
      if (confirm(I18n.translate('Are you sure?'))) {
        var publicid = event.target.getAttribute('item');
        this.switchsComponent.subscriptionService.deleteSubscription(publicid)  
               .fail(() => {
            alert('switch cannot be deleted')
          })
          .always(() => {
            this.switchsComponent.updateSwitchs();
          });
      }
    });
  }

}

