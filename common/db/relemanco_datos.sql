
/***********************************************************/
/*                                                         */
/*      RelemancoShops - Juego de Datos de Prueba          */
/*    Cualquier coincidencia con la realidad es pura       */
/*                    casualidad                           */
/*                                                         */
/***********************************************************/

/* CATEGORIAS */
INSERT INTO categorias (nombre, descripcion) VALUES ("Accesorios para Vehículos", "Accesorios para Vehículos");
INSERT INTO categorias (nombre, descripcion) VALUES ("Animales y Mascotas", "Animales y Mascotas");
INSERT INTO categorias (nombre, descripcion) VALUES ("Arte y Antigüedades", "Arte y Antigüedades");
INSERT INTO categorias (nombre, descripcion) VALUES ("Bebés", "Bebés");
INSERT INTO categorias (nombre, descripcion) VALUES ("Cámaras y Accesorios", "Cámaras y Accesorios");
INSERT INTO categorias (nombre, descripcion) VALUES ("Celulares y Telefonía", "Celulares y Telefonía");
INSERT INTO categorias (nombre, descripcion) VALUES ("Coleccionables", "Coleccionables");
INSERT INTO categorias (nombre, descripcion) VALUES ("Computación", "Computación");
INSERT INTO categorias (nombre, descripcion) VALUES ("Consolas y Videojuegos", "Consolas y Videojuegos");
INSERT INTO categorias (nombre, descripcion) VALUES ("Deportes y Fitness", "Deportes y Fitness");
INSERT INTO categorias (nombre, descripcion) VALUES ("Electrodomésticos y Aires Ac.", "Electrodomésticos y Aires Ac.");
INSERT INTO categorias (nombre, descripcion) VALUES ("Electrónica, Audio y Video", "Electrónica, Audio y Video");
INSERT INTO categorias (nombre, descripcion) VALUES ("Hogar, Muebles y Jardín", "Hogar, Muebles y Jardín");
INSERT INTO categorias (nombre, descripcion) VALUES ("Industrias y Oficinas", "Industrias y Oficinas");
INSERT INTO categorias (nombre, descripcion) VALUES ("Instrumentos Musicales", "Instrumentos Musicales");
INSERT INTO categorias (nombre, descripcion) VALUES ("Joyas y Relojes", "Joyas y Relojes");
INSERT INTO categorias (nombre, descripcion) VALUES ("Juegos y Juguetes", "Juegos y Juguetes");
INSERT INTO categorias (nombre, descripcion) VALUES ("Música, Libros y Películas", "Música, Libros y Películas");
INSERT INTO categorias (nombre, descripcion) VALUES ("Ropa, Calzados y Accesorios", "Ropa, Calzados y Accesorios");
INSERT INTO categorias (nombre, descripcion) VALUES ("Salud y Belleza", "Salud y Belleza");
INSERT INTO categorias (nombre, descripcion) VALUES ("Otras categorías", "Otras categorías");
INSERT INTO categorias (nombre, descripcion) VALUES ("Comestibles", "Comestibles");

/* PRIORIDADES */
INSERT INTO prioridades (nombre, descripcion) VALUES ("URGENTE", "Urgente.");
INSERT INTO prioridades (nombre, descripcion) VALUES ("ALTA", "Prioridad alta.");
INSERT INTO prioridades (nombre, descripcion) VALUES ("MEDIA", "Prioridad media.");
INSERT INTO prioridades (nombre, descripcion) VALUES ("BAJA", "Prioridad baja");

/* ESTADOS */
INSERT INTO estados (nombre, descripcion) VALUES ("RELEVADA", "Estado de una ruta al ser relevada.");
INSERT INTO estados (nombre, descripcion) VALUES ("ASIGNADO", "Estado de un comercio al ser asignado a una ruta.");
INSERT INTO estados (nombre, descripcion) VALUES ("DISPONIBLE", "Estado de un comercio o una ruta al estar disponible para ser asignado o ser relevada.");
INSERT INTO estados (nombre, descripcion) VALUES ("RELEVADO", "Estado de un comercio al ser relevado.");
INSERT INTO estados (nombre, descripcion) VALUES ("PENDIENTE", "Estado de un comercio o una ruta al estar asignado/a y en proceso de ser relevado/a.");

/*PRODUCTOS*/
INSERT INTO PHP.productos(productos.id, productos.id_categoria, productos.nombre, productos.imagen, productos.descripcion)
VALUES(1, 22, 'Aceite de Girasol BENFAST', 'aceite.jpg', 'Aceite 0 calorias');

INSERT INTO PHP.productos(productos.id, productos.id_categoria, productos.nombre, productos.imagen, productos.descripcion)
VALUES(2, 22, 'Aceitunas Los Nietitos', 'aceitunas.jpg', 'Aceite 0 calorias');

INSERT INTO PHP.productos(productos.id, productos.id_categoria, productos.nombre, productos.imagen, productos.descripcion)
VALUES(3, 22, 'Mermelada JOYAREAL', 'jalea.jpg', 'Jalea de frutas');

INSERT INTO PHP.productos(productos.id, productos.id_categoria, productos.nombre, productos.imagen, productos.descripcion)
VALUES(4, 22, 'Melones VEDRULERIA DODERA SA', 'melon.jpg', 'Melones bien frescos');

INSERT INTO PHP.productos(productos.id, productos.id_categoria, productos.nombre, productos.imagen, productos.descripcion)
VALUES(5, 22, 'Brownies de Cannabis', 'brouniFaso.jpg', 'Brownies de Cannabis  0% Grasa');

INSERT INTO PHP.productos(productos.id, productos.id_categoria, productos.nombre, productos.imagen, productos.descripcion)
VALUES(6, 17, 'Juguete Se Me ChispoTeo', 'chavo.jpg', 'Juguete del Chavo del 8');

INSERT INTO PHP.productos(productos.id, productos.id_categoria, productos.nombre, productos.imagen, productos.descripcion)
VALUES(7, 22, 'Cheetos', 'chetos.jpg', 'PEPSICO');

INSERT INTO PHP.productos(productos.id, productos.id_categoria, productos.nombre, productos.imagen, productos.descripcion)
VALUES(8, 22, 'Coca Cola 600ML', 'coca.jpg', 'COCA COLA COMPANY');

INSERT INTO PHP.productos(productos.id, productos.id_categoria, productos.nombre, productos.imagen, productos.descripcion)
VALUES(9, 22, 'Duraznos En Almibar DOS CABALLOS', 'durazno.jpg', 'Cocktail de frutas magike');

INSERT INTO PHP.productos(productos.id, productos.id_categoria, productos.nombre, productos.imagen, productos.descripcion)
VALUES(10, 22, 'Marihuana MUJICA', 'faso2.jpg', 'Como el asado del pepe, pero nada que ver.');


/*LOCALIZACION DE COMERCIOS*/
INSERT INTO localizacion (id, latitud, longitud, nota) VALUES (1, -34.917606, -56.161835, 'EL Luisito SHOP');
INSERT INTO localizacion (id, latitud, longitud, nota) VALUES (2, -34.921337, -56.161663, 'Devoto 35');
INSERT INTO localizacion (id, latitud, longitud, nota) VALUES (3, -34.925243, -56.16106, 'LEOS PANADERIA');
INSERT INTO localizacion (id, latitud, longitud, nota) VALUES (4, -34.92426, -56.154312, 'FARMASHOP 27');
INSERT INTO localizacion (id, latitud, longitud, nota) VALUES (5, -34.913666, -56.15409, 'ALTA YANTA SHOP');

/*COMERCIOS*/
INSERT INTO comercios (id, id_localizacion, id_prioridad, nombre) VALUES (1, 1, 1, 'EL Luisito SHOP');
INSERT INTO comercios (id, id_localizacion, id_prioridad, nombre) VALUES (2, 2, 2, 'Devoto 35');
INSERT INTO comercios (id, id_localizacion, id_prioridad, nombre) VALUES (3, 3, 3, 'LEOS PANADERIA');
INSERT INTO comercios (id, id_localizacion, id_prioridad, nombre) VALUES (4, 4, 2, 'FARMASHOP 27');
INSERT INTO comercios (id, id_localizacion, id_prioridad, nombre) VALUES (5, 5, 1, 'ALTA YANTA SHOP');

/*PRODUCTOS ASIGNADOS*/
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (1, 1, 432.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (1, 2, 12.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (1, 3, 14.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (2, 1, 156.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (2, 2, 978.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (2, 3, 565.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (2, 4, 114.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (2, 5, 64.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (2, 6, 55.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (2, 7, 21.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (2, 8, 555.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (2, 9, 666.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (2, 10, 542.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (3, 1, 121.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (3, 2, 11.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (3, 8, 5.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (3, 9, 32.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (3, 10, 22.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (4, 6, 977.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (4, 8, 986.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (4, 10, 112.00);
INSERT INTO productosComercioStock (id_comercio, id_producto, cantidad) VALUES (5, 4, 333.00);
