# RelemancoShopsWeb

<h3>Planificacion:</h3>

<h4>Arquitectura:</h4>

<b>Nacho:</b>

- Puesta a punto del repositorio central y de aplicación mobile, pasaje del modelo de datos a esquema SQL,.

<b>Diego:</b>

- Elección del entorno de trabajo para implementar la aplicación mobile.

<hr/>

<h4>Requisitos funcionales del BACKEND:</h4>

<b>Jona</b>:

● ABM de Usuarios relevadores (Ej: Juan, Diego, etc)

● Asignación de Rutas por día por relevador (automática y manual)

<b>Nacho</b>:

● ABM de categoría de productos (ej: Ropa y Accesorios, Bebidas, Comidas, etc)

● ABM de productos (Ej. Coca Cola 600mL, Galletita Oreo Chica, etc)

● ABM Comercios (Ej: La Pasiva, Almacén Ananais, etc)

● ABMs (Los que se requieran del modelo, coordinar con Jona)

● Estadísticas (ej: Gráficas de stock de productos, relevador más eficiente, etc)
<hr/>

<h4>Requisitos funcionales del FRONTEND:</h4>

<b>Nacho (se reutiliza del Backend):</b>

● Registro de Usuarios Relevadores (al menos un medio social ej. Google y registro

normal). Siempre el registro queda pendiente de que el usuario Administrador lo habilite luego.

<b>Diego</b>:

● Ver mis recorridos: Posibilidad de ver mis recorridos, eligiendo un día puedo ver el

recorrido que tuve asignado y que fue lo que registre.
<hr/>

<h4>Requisitos funcionales de API:</h4>

<b>Jona</b>:

● POST /apivN/login ­ Permite el login de los usuarios relevadores

● GET /apivN/rutas/ID_RELEVADOR ­ Permite obtener la ruta de usuario relevador

<b>Nacho</b>:

● POST /apivN/stock/save ­ Permite guardar el stock que se registro en un comercio

● POST /apivN/pedido/save ­ Permite tomar un pedido de un comercio

(Se puede realizar mas urls, estas son solas las sugeridas)
<hr/>

<h4>Requisitos funcionales de Aplicación Mobile:</h4>

<b>Diego:</b>

- Las siguientes pantallas: Login, Rutas, Stock y Pedido.

<b>Nacho:</b>

- La pantalla Home.
