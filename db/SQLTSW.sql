create table users(
  alias varchar2(20) not null,
  correo varchar2(100) not null,
  contraseña varchar2(100) not null,
  CONSTRAINT pk_users primary key (alias)
);

create table switch(
  public_id varchar2(50) not null,
  private_id varchar2(50) not null,
  user varchar2(20) not null,
  nombre varchar2(100) not null,
  estado int(1) default 0,
  tiempo_modificacion timestamp not null,
  constraint pk_switch primary key (public_id,private_id,user),
  constraint fk_switch foreign key (user) references users(alias) on delete cascade
);

insert into users(alias,correo,contraseña) values('admin','admin@gmail.com','admin');
insert into users(alias,correo,contraseña) values('User','user@gmail.com','user');

create TRIGGER generate_random_ids
AFTER INSERT ON switch
BEGIN
    UPDATE switch
    SET public_id = substr(upper(hex(randomblob(25))), 1, 50), private_id = substr(upper(hex(randomblob(25))), 1, 50), tiempo_modificacion=CURRENT_TIME
    WHERE rowid = NEW.rowid;
END;

insert into switch(public_id,private_id,user,nombre,tiempo_modificacion) values('','','admin','Primer switch',CURRENT_TIME);
insert into switch(public_id,private_id,user,nombre,tiempo_modificacion) values('','','User','Segundo switch',CURRENT_TIME);
insert into switch(public_id,private_id,user,nombre,tiempo_modificacion) values ('','','User','Otro switch',CURRENT_TIME);