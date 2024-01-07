class SwitchAddComponent extends Fronty.ModelComponent {
  constructor(switchsModel, userModel, router) {
    super(Handlebars.templates.switchedit, switchsModel);
    this.switchsModel = switchsModel; // posts
    
    this.userModel = userModel; // global
    this.addModel('user', userModel);
    this.router = router;

    this.switchsService = new SwitchsService();

    this.addEventListener('click', '#savebutton', () => {
      var newSwitch = {};
      newSwitch.title = $('#nombre').val();
      newSwitch.descripcion = $('#descripcion').val();
      newSwitch.author_id = this.userModel.currentUser;
      this.switchsService.addSwitch(newSwitch)
        .then(() => {
          this.router.goToPage('switchs');
        })
        .fail((xhr, errorThrown, statusText) => {
          if (xhr.status == 400) {
            this.switchsModel.set(() => {
              this.switchsModel.errors = xhr.responseJSON;
            });
          } else {
            alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
          }
        });
    });
  }
  
  onStart() {
    this.switchsModel.setSelectedSwitch(new SwitchModel());
  }
}
