class SwitchViewComponent extends Fronty.ModelComponent {
  constructor(switchsModel, userModel, router) {
    super(Handlebars.templates.switchsview, switchsModel);

    this.switchsModel = switchsModel;
    this.userModel = userModel;
    this.addModel('user', userModel);
    this.router = router;

    this.switchsService = new SwitchsService();

    console.log('SwitchViewComponent constructor called');
  }

  onStart() {
    console.log('SwitchViewComponent onStart called');
    var publicid = this.router.getRouteQueryParam('public_id');
    var privateid = this.router.getRouteQueryParam('private_id');
    this.loadSwitch(publicid, privateid);
  }

  loadSwitch(publicid, privateid) {
    if (publicid || privateid) {
      this.switchsService.findSwitch(publicid, privateid)
        .then((item) => {
          console.log('Switch data:', item);

          // Assuming setSelectedSwitch is a method in your switchsModel
          if (privateid){
            this.switchsModel.setSelectedSwitch(new SwitchModel(null, item.private_id, item.nombre, item.estado, item.tiempo_modificacion, item.encendido_hasta, item.descripcion, item.alias));
          }else{
            this.switchsModel.setSelectedSwitch(new SwitchModel(item.public_id, null, item.nombre, item.estado, item.tiempo_modificacion, item.encendido_hasta, item.descripcion, item.alias));
          }
          //this.switchsModel.setSelectedSwitch(new SwitchModel(item.public_id, null, item.nombre, item.estado, item.tiempo_modificacion, item.encendido_hasta, item.descripcion, item.alias));
          
          
          // Render the template with the updated data
          this.render();
        })
        .catch((error) => {
          console.error('Error fetching switch data:', error);
        });
    }
  }
}
