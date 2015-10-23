DROP TABLE IF EXISTS ADMINISTRADORES, AGENDA, RUTAS_RELEVADOR_COMERCIO,
PRODUCTOS_PEDIDOS, PRODUCTOS_COMERCIO_STOCK, PEDIDOS_COMERCIOS, PRODUCTOS, CONTRATOS, COMERCIOS, PEDIDOS,
RELEVADORES, RUTAS, EMPRESAS, DIAS, LOCALIZACION, CATEGORIAS, PRIORIDADES, ESTADOS;

CREATE TABLE
LOCALIZACION(

  	id bigint NOT NULL AUTO_INCREMENT,
  	latitud DECIMAL(19,2),
  	longitud DECIMAL(19,2),
  	PRIMARY KEY (id)

);

CREATE TABLE
EMPRESAS(

    id bigint NOT NULL AUTO_INCREMENT,
    id_localizacion bigint NOT NULL,
    nombre varchar(80) NOT NULL,
    descripcion varchar(500),
    PRIMARY KEY (id),
    FOREIGN KEY(id_localizacion) REFERENCES LOCALIZACION(id) ON DELETE CASCADE

);

CREATE TABLE
DIAS(

    id smallint NOT NULL AUTO_INCREMENT,
    nombre varchar(20) NOT NULL,
    PRIMARY KEY (id)

);

CREATE TABLE
CATEGORIAS(

    id bigint NOT NULL AUTO_INCREMENT,
    nombre varchar(80) NOT NULL,
    descripcion varchar(200),
    PRIMARY KEY (id)

);

CREATE TABLE
PRIORIDADES(

    id smallint NOT NULL AUTO_INCREMENT,
    nombre varchar(50) NOT NULL,
    PRIMARY KEY (id)

);

CREATE TABLE
ESTADOS(

    id smallint NOT NULL AUTO_INCREMENT,
    nombre varchar(50) NOT NULL,
    descripcion varchar(200),
    PRIMARY KEY (id)

);

CREATE TABLE
ADMINISTRADORES(

    id bigint NOT NULL AUTO_INCREMENT,
    id_estado smallint NOT NULL,
    apellido varchar(80) NOT NULL,
    email varchar(50) NOT NULL UNIQUE,
  	fechaNac TIMESTAMP NOT NULL,
    nombre varchar(50) NOT NULL,
    pass varchar(32) NOT NULL,
    celular varchar(20) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY(id_estado) REFERENCES ESTADOS(id) ON DELETE CASCADE

);

CREATE TABLE
RELEVADORES(

  	id bigint NOT NULL AUTO_INCREMENT,
    id_estado smallint NOT NULL,
    id_localizacion bigint NOT NULL,
  	nombre varchar(50) NOT NULL,
  	apellido varchar(50) NOT NULL,
  	email varchar(50) NOT NULL UNIQUE,
  	fechaNac TIMESTAMP NOT NULL,
  	timeZone varchar(20) NOT NULL,
  	celular varchar(20) NOT NULL,
  	pass varchar(32) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY(id_localizacion) REFERENCES LOCALIZACION(id) ON DELETE CASCADE,
    FOREIGN KEY(id_estado) REFERENCES ESTADOS(id) ON DELETE CASCADE

);

CREATE TABLE
COMERCIOS(

  	id bigint NOT NULL AUTO_INCREMENT,
  	id_localizacion bigint NOT NULL,
    id_prioridad smallint NOT NULL,
  	nombre varchar(100) NOT NULL,
  	PRIMARY KEY (id),
  	FOREIGN KEY(id_localizacion) REFERENCES LOCALIZACION(id) ON DELETE CASCADE,
    FOREIGN KEY(id_prioridad) REFERENCES PRIORIDADES(id) ON DELETE CASCADE

);

CREATE TABLE
PRODUCTOS(

    id bigint NOT NULL AUTO_INCREMENT,
    id_categoria bigint NOT NULL,
    nombre varchar(80) NOT NULL,
    imagen varchar(100),
    descripcion varchar(200),
    PRIMARY KEY (id),
    FOREIGN KEY(id_categoria) REFERENCES CATEGORIAS(id) ON DELETE CASCADE

);

CREATE TABLE
PRODUCTOS_COMERCIO_STOCK(

    id_comercio bigint NOT NULL,
    id_producto bigint NOT NULL,
    cantidad DECIMAL(10,2),
    PRIMARY KEY (id_comercio, id_producto),
    FOREIGN KEY(id_producto) REFERENCES PRODUCTOS(id) ON DELETE CASCADE,
    FOREIGN KEY(id_comercio) REFERENCES COMERCIOS(id) ON DELETE CASCADE

);

CREATE TABLE
CONTRATOS(

  	id bigint NOT NULL AUTO_INCREMENT,
    id_empresa bigint NOT NULL,
    id_comercio bigint NOT NULL,
    fecha_desde TIMESTAMP NOT NULL,
    fecha_hasta TIMESTAMP NOT NULL,
  	PRIMARY KEY (id),
    FOREIGN KEY(id_empresa) REFERENCES EMPRESAS(id) ON DELETE CASCADE,
    FOREIGN KEY(id_comercio) REFERENCES COMERCIOS(id) ON DELETE CASCADE

);

CREATE TABLE
PEDIDOS(

	id bigint NOT NULL AUTO_INCREMENT,
    fecha_realizado TIMESTAMP NOT NULL,
    PRIMARY KEY (id)

);

CREATE TABLE
PRODUCTOS_PEDIDOS(

    id_pedido bigint NOT NULL,
    id_producto bigint NOT NULL,
    cantidad DECIMAL(10,2),
    FOREIGN KEY(id_pedido) REFERENCES PEDIDOS(id) ON DELETE CASCADE,
    FOREIGN KEY(id_producto) REFERENCES PRODUCTOS(id) ON DELETE CASCADE

);

CREATE TABLE
PEDIDOS_COMERCIOS(

    id_pedido bigint NOT NULL,
    id_comercio bigint NOT NULL,
    cantidad DECIMAL(10,2),
    FOREIGN KEY(id_pedido) REFERENCES PEDIDOS(id) ON DELETE CASCADE,
    FOREIGN KEY(id_comercio) REFERENCES COMERCIOS(id) ON DELETE CASCADE

);

CREATE TABLE
RUTAS(

	id bigint NOT NULL AUTO_INCREMENT,
    fecha_asignada TIMESTAMP NOT NULL,
    id_estado smallint NOT NULL,
    PRIMARY KEY (id)

);

CREATE TABLE
RUTAS_RELEVADOR_COMERCIO(

    id_ruta bigint NOT NULL,
    id_relevador bigint NOT NULL,
    id_comercio bigint NOT NULL,
    fecha_relevada TIMESTAMP NOT NULL,
    FOREIGN KEY(id_ruta) REFERENCES RUTAS(id) ON DELETE CASCADE,
    FOREIGN KEY(id_relevador) REFERENCES RELEVADORES(id) ON DELETE CASCADE,
    FOREIGN KEY(id_comercio) REFERENCES COMERCIOS(id) ON DELETE CASCADE

);

CREATE TABLE
AGENDA(

    id_dia smallint NOT NULL,
    id_relevador bigint NOT NULL,
    id_comercio bigint NOT NULL,
    FOREIGN KEY(id_dia) REFERENCES DIAS(id) ON DELETE CASCADE,
    FOREIGN KEY(id_relevador) REFERENCES RELEVADORES(id) ON DELETE CASCADE,
    FOREIGN KEY(id_comercio) REFERENCES COMERCIOS(id) ON DELETE CASCADE

);
