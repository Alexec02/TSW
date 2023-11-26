class SwitchModel extends Fronty.Model {

  constructor(publicid, privateid, nombre, estado, ultima_modificaion, encendido_hasta, descripcion, alias) {
    super('SwitchModel'); //call super
    
    if (publicid) {
      this.publicid = publicid;
    }
    
    if (privateid) {
      this.privateid = privateid;
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
    
    if (ultima_modificaion) {
      this.ultima_modificaion = ultima_modificaion;
    }
    
    if (encendido_hasta) {
      this.encendido_hasta = encendido_hasta;
    }
    
    if (descripcion) {
      this.descripcion = descripcion;
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
