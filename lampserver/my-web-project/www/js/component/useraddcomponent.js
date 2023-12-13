class UserAddComponent extends Fronty.ModelComponent {
    constructor(usersModel, userModel, router) {
      super(Handlebars.templates.useredit, usersModel);
      this.usersModel = usersModel;
      this.userModel = userModel;
      this.addModel('user', userModel);
      this.router = router;
  
      this.userService = new UserService();
  
      this.addEventListener('click', '#savebutton', () => {
        // Lógica para agregar un nuevo usuario
      });
    }
  
    onStart() {
      this.usersModel.setSelectedUser(new UserModel());
    }
  }
  