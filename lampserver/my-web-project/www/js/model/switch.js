class SwitchModel extends Fronty.Model {

  constructor(public_id, private_id, nombre, estado, tiempo_modificacion, encendido_hasta, descripcion, alias) {
    super('SwitchModel'); //call super
    
    if (public_id) {
      this.public_id = public_id;
    }
    
    if (private_id) {
      this.private_id = private_id;
    }
    
    if (alias) {
      this.alias = alias;
    }
    
    if (nombre) {
      this.nombre = nombre;
    }
    
    if (estado) {
      this.estado = estado;
    }
    
    if (tiempo_modificacion) {
      this.tiempo_modificacion = tiempo_modificacion;
    }
    
    if (encendido_hasta) {
      this.encendido_hasta = encendido_hasta;
    }
    
    if (descripcion) {
      this.descripcion = descripcion;
    }
  }
  /*setTitle(title) {
    this.set((self) => {
      self.title = title;
    });
  }

  setAuthor_id(author_id) {
    this.set((self) => {
      self.author_id = author_id;
    });
  }*/

}
