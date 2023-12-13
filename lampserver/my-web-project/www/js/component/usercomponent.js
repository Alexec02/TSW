class UserComponent extends Fronty.ModelComponent {
    constructor(usersModel, userModel, router) {
      super(Handlebars.templates.user, usersModel);
      this.usersModel = usersModel;
      this.userModel = userModel;
      this.addModel('user', userModel);
      this.router = router;
  
      this.userService = new UserService();
  
      //Eventos y lógica específica para el componente User
    }
  
    //Métodos adicionales 
  }
  