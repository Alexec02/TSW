create database tsw;
CREATE USER 'tswuser'@'localhost' IDENTIFIED BY 'tswpass';
GRANT ALL PRIVILEGES ON tsw.* TO 'tswuser'@'localhost' WITH GRANT OPTION;

create table users(
  alias varchar(20) not null,
  correo varchar(100) not null,
  contrasena varchar(100) not null,
  CONSTRAINT pk_users primary key (alias)
);

create table switch(
  public_id varchar(50) not null,
  private_id varchar(50) not null,
  alias varchar(20) not null,
  nombre varchar(100) not null,
  estado int default 0,
  tiempo_modificacion timestamp not null,
  constraint pk_switch primary key (public_id,private_id,alias),
  constraint fk_switch foreign key (alias) references users(alias) on delete cascade
);

insert into users(alias,correo,contrasena) values('admin','admin@gmail.com','admin');
insert into users(alias,correo,contrasena) values('User','user@gmail.com','user');

DELIMITER $$
CREATE TRIGGER switch_id_generator
BEFORE INSERT ON switch
FOR EACH ROW
BEGIN
    -- Generar valores aleatorios para public_id y private_id
    SET NEW.public_id = UUID();
    SET NEW.private_id = UUID();
END;
$$
DELIMITER ;

insert into switch(public_id,private_id,alias,nombre,tiempo_modificacion) values('','','admin','Primer switch',CURRENT_TIME);
insert into switch(public_id,private_id,alias,nombre,tiempo_modificacion) values('','','User','Segundo switch',CURRENT_TIME);
insert into switch(public_id,private_id,alias,nombre,tiempo_modificacion) values ('','','User','Otro switch',CURRENT_TIME);
