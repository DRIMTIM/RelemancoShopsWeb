
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
VALUES(10, 22, 'Marihuana MUJICA', 'faso.jpg', 'Como el asado del pepe, pero nada que ver.');