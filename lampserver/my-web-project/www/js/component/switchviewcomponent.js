class SwitchViewComponent extends Fronty.ModelComponent {
  constructor(switchsModel, userModel, router) {
    super(Handlebars.templates.switchview, switchsModel);

    this.switchsModel = switchsModel; // switchs
    this.userModel = userModel; // global
    this.addModel('user', userModel);
    this.router = router;

    this.switchsService = new SwitchsService();

    this.addEventListener('click', '#savecommentbutton', () => {
      var publicid = this.router.getRouteQueryParam('publicid');
      var privateid = this.router.getRouteQueryParam('privateid');
      this.switchsService.createComment(publicid, privateid, {
          content: $('#commentcontent').val()
        })
        .then(() => {
          $('#commentcontent').val('');
          this.loadSwitch(publicid, privateid);
        })
        .fail((xhr, errorThrown, statusText) => {
          if (xhr.status == 400) {
            this.switchsModel.set(() => {
              this.switchsModel.commentErrors = xhr.responseJSON;
            });
          } else {
            alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
          }
        });
    });
  }

  onStart() {
    var publicid = this.router.getRouteQueryParam('publicid');
    var privateid = this.router.getRouteQueryParam('privateid');
    this.loadSwitch(publicid,privateid);
  }

  loadSwitch(publicid,privateid) {
    if (publicid != null || privateid != null) {
      this.switchsService.findSwitch(publicid,privateid)
        .then((switchs) => {
          this.switchsModel.setSelectedSwitch(switchs);
        });
    }
  }
}
