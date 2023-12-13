class UserEditComponent extends Fronty.ModelComponent {
    constructor(usersModel, userModel, router) {
      super(Handlebars.templates.useredit, usersModel);
      this.usersModel = usersModel;
      this.userModel = userModel;
      this.addModel('user', userModel);
      this.router = router;
  
      this.userService = new UserService();
  
      this.addEventListener('click', '#savebutton', () => {
        // Lógica para editar el usuario existente
      });
    }
  
    onStart() {
      var selectedId = this.router.getRouteQueryParam('id');
      if (selectedId != null) {
        this.userService.findUser(selectedId)
          .then((user) => {
            this.usersModel.setSelectedUser(user);
          });
      }
    }
  }
  