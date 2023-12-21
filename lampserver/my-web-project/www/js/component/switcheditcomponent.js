class SwitchEditComponent extends Fronty.ModelComponent {
  constructor(switchsModel, userModel, router) {
    super(Handlebars.templates.switchedit, switchsModel);
    this.switchsModel = switchsModel; // switchs
    this.userModel = userModel; // global
    this.addModel('user', userModel);
    this.router = router;

    this.switchsService = new SwitchsService();

    this.addEventListener('click', '#savebutton', () => {
      this.switchsModel.selectedSwitch.estado = $('#estado').val();
      this.switchsModel.selectedSwitch.publicid = $('#publicid').val();
      this.switchsModel.selectedSwitch.privateid = $('#privateid').val();
      this.switchsModel.selectedSwitch.nombre = $('#nombre').val();
      this.switchsModel.selectedSwitch.encendido_hasta = $('#encendido_hasta').val();
      this.switchsService.saveSwitch(this.switchsModel.selectedSwitch)
        .then(() => {
          this.switchsModel.set((model) => {
            model.errors = []
          });
          this.router.goToPage('switchs');
        })
        .fail((xhr, errorThrown, statusText) => {
          if (xhr.status == 400) {
            this.switchsModel.set((model) => {
              model.errors = xhr.responseJSON;
            });
          } else {
            alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
          }
        });

    });
  }

  onStart() {
    var privateid = this.router.getRouteQueryParam('id');
    var publicid = this.router.getRouteQueryParam('id');
    if (privateid != null || publicid != null ) {
      this.switchsService.findSwitch(privateid, publicid)
        .then((switchs) => {
          this.switchsModel.setSelectedSwitch(switchs);
        });
    }
  }
}
