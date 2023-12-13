class UserViewComponent extends Fronty.ModelComponent {
    constructor(usersModel, userModel, router) {
      super(Handlebars.templates.userview, usersModel);
      this.usersModel = usersModel;
      this.userModel = userModel;
      this.addModel('user', userModel);
      this.router = router;
  
      this.userService = new UserService();
  
      this.addEventListener('click', '#savebutton', () => {
        // Lógica para guardar comentarios en el usuario
      });
    }
  
    onStart() {
      var selectedId = this.router.getRouteQueryParam('id');
      this.loadUser(selectedId);
    }
  
    loadUser(userId) {
      if (userId != null) {
        this.userService.findUser(userId)
          .then((user) => {
            this.usersModel.setSelectedUser(user);
          });
      }
    }
  }
  