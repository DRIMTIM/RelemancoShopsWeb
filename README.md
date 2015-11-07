# RelemancoShopsWeb

Planificacion:

Arquitectura:

Nacho:

- Puesta a punto del repositorio central y de aplicación mobile, pasaje del modelo de datos a esquema SQL,.

Diego:

- Elección del entorno de trabajo para implementar la aplicación mobile.


Requisitos funcionales del BACKEND:

<b>Jona</b>:

● ABM de Usuarios relevadores (Ej: Juan, Diego, etc)

● Asignación de Rutas por día por relevador (automática y manual)

Nacho:

● ABM de categoría de productos (ej: Ropa y Accesorios, Bebidas, Comidas, etc)

● ABM de productos (Ej. Coca Cola 600mL, Galletita Oreo Chica, etc)

● ABM Comercios (Ej: La Pasiva, Almacén Ananais, etc)

● ABMs (Los que se requieran del modelo, coordinar con Jona)

● Estadísticas (ej: Gráficas de stock de productos, relevador más eficiente, etc)


Requisitos funcionales del FRONTEND:

Nacho (se reutiliza del Backend):

● Registro de Usuarios Relevadores (al menos un medio social ej. Google y registro

normal). Siempre el registro queda pendiente de que el usuario Administrador lo habilite luego.

Diego:

● Ver mis recorridos: Posibilidad de ver mis recorridos, eligiendo un día puedo ver el

recorrido que tuve asignado y que fue lo que registre.


Requisitos funcionales de API:

Jona:

● POST /apivN/login ­ Permite el login de los usuarios relevadores

● GET /apivN/rutas/ID_RELEVADOR ­ Permite obtener la ruta de usuario relevador

Nacho:

● POST /apivN/stock/save ­ Permite guardar el stock que se registro en un comercio

● POST /apivN/pedido/save ­ Permite tomar un pedido de un comercio

(Se puede realizar mas urls, estas son solas las sugeridas)


Requisitos funcionales de Aplicación Mobile:

Diego:

- Las siguientes pantallas: Login, Rutas, Stock y Pedido.

Nacho:

- La pantalla Home.
