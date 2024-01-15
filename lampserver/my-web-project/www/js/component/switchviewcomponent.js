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
        .then((switchData) => {
          console.log('Switch data:', switchData);

          // Assuming setSelectedSwitch is a method in your switchsModel
          this.switchsModel.setSelectedSwitch(switchData);

          // Render the template with the updated data
          this.render();
        })
        .catch((error) => {
          console.error('Error fetching switch data:', error);
        });
    }
  }
}
