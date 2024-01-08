class MainComponent extends Fronty.RouterComponent {
  constructor() {
    super('frontyapp', Handlebars.templates.main, 'maincontent');

    // models instantiation
    // we can instantiate models at any place
    this.userModel = new UserModel();
    this.switchsModel = new SwitchsModel();
    this.userService = new UserService();

    super.setRouterConfig({
      switchs: {
        component: new SwitchsComponent(this.switchsModel, this.userModel, this),
        title: 'Switchs'
      },
      /*'view-switch': {
        component: new SwitchViewComponent(this.switchsModel, this.userModel, this),
        title: 'Switch'
      },*/
      'edit-switch': {
        component: new SwitchEditComponent(this.switchsModel, this.userModel, this),
        title: 'Edit Switch'
      },
      'add-switch': {
        component: new SwitchAddComponent(this.switchsModel, this.userModel, this),
        title: 'Add Switch'
      },
      login: {
        component: new LoginComponent(this.userModel, this),
        title: 'Login'
      },
      defaultRoute: 'login'
    });
    
    Handlebars.registerHelper('currentPage', () => {
          return super.getCurrentPage();
    });

    this.addChildComponent(this._createUserBarComponent());
    this.addChildComponent(this._createLanguageComponent());

  }

  start() {
    this.userService.loginWithSessionData()
      .then((logged) => {
        if (logged != null) {
          this.userModel.setLoggeduser(logged);
          this.goToPage('switchs'); // Redirige a switchs si hay un usuario logueado
        } else {
          this.goToPage('login'); // Redirige a la página de login si no hay usuario logueado
        }
        super.start(); // Llama a start después de la redirección
      });
  }

  _createUserBarComponent() {
    var userbar = new Fronty.ModelComponent(Handlebars.templates.user, this.userModel, 'userbar');

    userbar.addEventListener('click', '#logoutbutton', () => {
      this.userModel.logout();
      this.userService.logout();
    });

    return userbar;
  }

  _createLanguageComponent() {
    var languageComponent = new Fronty.ModelComponent(Handlebars.templates.language, this.routerModel, 'languagecontrol');
    // language change links
    languageComponent.addEventListener('click', '#englishlink', () => {
      I18n.changeLanguage('default');
      document.location.reload();
    });

    languageComponent.addEventListener('click', '#spanishlink', () => {
      I18n.changeLanguage('es');
      document.location.reload();
    });

    return languageComponent;
  }
}
