/* Main mvcblog-front script */

//load external resources
function loadTextFile(url) {
  return new Promise((resolve, reject) => {
    $.get({
      url: url,
      cache: true,
      beforeSend: function( xhr ) {
        xhr.overrideMimeType( "text/plain" );
      }
    }).then((source) => {
      resolve(source);
    }).fail(() => reject());
  });
}


// Configuration
var AppConfig = {
  backendServer: 'http://localhost'
  //backendServer: '/mvcblog'
}

Handlebars.templates = {};
Promise.all([
    I18n.initializeCurrentLanguage('js/i18n'),
    loadTextFile('templates/components/main.hbs').then((source) =>
      Handlebars.templates.main = Handlebars.compile(source)),
    loadTextFile('templates/components/language.hbs').then((source) =>
      Handlebars.templates.language = Handlebars.compile(source)),
    loadTextFile('templates/components/user.hbs').then((source) =>
      Handlebars.templates.user = Handlebars.compile(source)),
    loadTextFile('templates/components/login.hbs').then((source) =>
      Handlebars.templates.login = Handlebars.compile(source)),
    loadTextFile('templates/components/switchs-index.hbs').then((source) =>
      Handlebars.templates.switchsindex = Handlebars.compile(source)),
    loadTextFile('templates/components/switchs-view.hbs').then((source) =>
      Handlebars.templates.switchsview = Handlebars.compile(source)),
      loadTextFile('templates/components/switch-edit.hbs').then((source) =>
      Handlebars.templates.switchedit = Handlebars.compile(source)),
      loadTextFile('templates/components/switchs-add.hbs').then((source) =>
      Handlebars.templates.switchsadd = Handlebars.compile(source)),
    loadTextFile('templates/components/switch-row.hbs').then((source) =>
      Handlebars.templates.switchrow = Handlebars.compile(source)),
    loadTextFile('templates/components/subscription-row.hbs').then((source) =>
      Handlebars.templates.subscriptionrow = Handlebars.compile(source)),
  ])
  .then(() => {
    $(() => {
      new MainComponent().start();
    });
  }).catch((err) => {
    alert('FATAL: could not start app ' + err);
  });
