DROP TABLE IF EXISTS administradores, rutasRelevadorComercio, agendaComercios, dias,
productosPedidos, productosComercioStock, productos, contratos, comercios, pedidos,
relevadores, rutas, empresas, localizacion, categorias, prioridades, estados;

CREATE TABLE
localizacion(

  	id bigint NOT NULL AUTO_INCREMENT,
  	latitud FLOAT(10,6) NOT NULL,
  	longitud FLOAT(10,6) NOT NULL,
    nota varchar(100),
  	PRIMARY KEY (id)

);

CREATE TABLE
empresas(

    id bigint NOT NULL AUTO_INCREMENT,
    id_localizacion bigint NOT NULL,
    nombre varchar(80) NOT NULL,
    descripcion varchar(500),
    PRIMARY KEY (id),
    FOREIGN KEY(id_localizacion) REFERENCES localizacion(id) ON DELETE CASCADE

);

CREATE TABLE
dias(

    id smallint NOT NULL AUTO_INCREMENT,
    nombre varchar(20) NOT NULL,
    PRIMARY KEY (id)

);

CREATE TABLE
categorias(

    id bigint NOT NULL AUTO_INCREMENT,
    nombre varchar(80) NOT NULL,
    descripcion varchar(200),
    PRIMARY KEY (id)

);

CREATE TABLE
prioridades(

    id smallint NOT NULL AUTO_INCREMENT,
    nombre varchar(50) NOT NULL,
    descripcion varchar(100),
    PRIMARY KEY (id)

);

CREATE TABLE
estados(

    id smallint NOT NULL AUTO_INCREMENT,
    nombre varchar(50) NOT NULL,
    descripcion varchar(200),
    PRIMARY KEY (id)

);

CREATE TABLE
administradores(

    id bigint NOT NULL AUTO_INCREMENT,
    user_id int(11) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY(user_id) REFERENCES profile(user_id) ON DELETE CASCADE

);

CREATE TABLE
relevadores(

  	id bigint NOT NULL AUTO_INCREMENT,
    user_id int(11) NOT NULL,
    id_localizacion bigint NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY(user_id) REFERENCES profile(user_id) ON DELETE CASCADE,
    FOREIGN KEY(id_localizacion) REFERENCES localizacion(id) ON DELETE CASCADE

);

CREATE TABLE
comercios(

  	id bigint NOT NULL AUTO_INCREMENT,
  	id_localizacion bigint NOT NULL,
    id_prioridad smallint NOT NULL,
  	nombre varchar(100) NOT NULL,
  	PRIMARY KEY (id),
  	FOREIGN KEY(id_localizacion) REFERENCES localizacion(id) ON DELETE CASCADE,
    FOREIGN KEY(id_prioridad) REFERENCES prioridades(id) ON DELETE CASCADE

);

CREATE TABLE
productos(

    id bigint NOT NULL AUTO_INCREMENT,
    id_categoria bigint NOT NULL,
    nombre varchar(80) NOT NULL,
    imagen varchar(100),
    descripcion varchar(200),
    PRIMARY KEY (id),
    FOREIGN KEY(id_categoria) REFERENCES categorias(id) ON DELETE CASCADE

);

CREATE TABLE
productosComercioStock(

    id_comercio bigint NOT NULL,
    id_producto bigint NOT NULL,
    cantidad DECIMAL(10,2),
    PRIMARY KEY (id_comercio, id_producto),
    FOREIGN KEY(id_producto) REFERENCES productos(id) ON DELETE CASCADE,
    FOREIGN KEY(id_comercio) REFERENCES comercios(id) ON DELETE CASCADE

);

CREATE TABLE
contratos(

  	id bigint NOT NULL AUTO_INCREMENT,
    id_empresa bigint NOT NULL,
    id_comercio bigint NOT NULL,
    fecha_desde TIMESTAMP NOT NULL,
    fecha_hasta TIMESTAMP NOT NULL,
  	PRIMARY KEY (id),
    FOREIGN KEY(id_empresa) REFERENCES empresas(id) ON DELETE CASCADE,
    FOREIGN KEY(id_comercio) REFERENCES comercios(id) ON DELETE CASCADE

);

CREATE TABLE
pedidos(

	id bigint NOT NULL AUTO_INCREMENT,
    id_comercio bigint NOT NULL,
    fecha_realizado TIMESTAMP NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY(id_comercio) REFERENCES comercios(id) ON DELETE CASCADE

);

CREATE TABLE
productosPedidos(

    id_pedido bigint NOT NULL,
    id_producto bigint NOT NULL,
    cantidad DECIMAL(10,2),
    FOREIGN KEY(id_pedido) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY(id_producto) REFERENCES productos(id) ON DELETE CASCADE

);

CREATE TABLE
rutas(

	id bigint NOT NULL AUTO_INCREMENT,
    fecha_asignada TIMESTAMP NOT NULL,
    id_estado smallint NOT NULL,
    PRIMARY KEY (id)

);

CREATE TABLE
rutasRelevadorComercio(

    id_ruta bigint NOT NULL,
    id_relevador bigint NOT NULL,
    id_comercio bigint NOT NULL,
    fecha_relevada TIMESTAMP NOT NULL,
    FOREIGN KEY(id_ruta) REFERENCES rutas(id) ON DELETE CASCADE,
    FOREIGN KEY(id_relevador) REFERENCES relevadores(id) ON DELETE CASCADE,
    FOREIGN KEY(id_comercio) REFERENCES comercios(id) ON DELETE CASCADE

);

CREATE TABLE
agendaComercios(

    id_dia smallint NOT NULL,
    id_relevador bigint NOT NULL,
    id_comercio bigint NOT NULL,
    FOREIGN KEY(id_dia) REFERENCES dias(id) ON DELETE CASCADE,
    FOREIGN KEY(id_relevador) REFERENCES relevadores(id) ON DELETE CASCADE,
    FOREIGN KEY(id_comercio) REFERENCES comercios(id) ON DELETE CASCADE

);
