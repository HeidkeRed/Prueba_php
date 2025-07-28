Nombre: Cesar Enrique Bravo Garcia
Posición Deseada: Fullstack
Conocimiento en PHP: 70%
Conocimiento en python: 70%
Conocimiento en C#: 60%
Correo de contacto: cebg_slp@hotmail.com
Nivel elegido  para resolver el assessment: Intermedio

Instrucciones de Instalación:
Una vez descargado el proyecto mediate GitHub EN LA RAMA MASTER se seguirán en este orden los pasos:

MUY IMPORTANTE CAMBIAR EL NOMBRE DE LA CARPETA A Proceso_seleccion, YA QUE AL DESCARGAR LA CARPETA POR GITHUB TENDRA OTRO NOMBRE

En caso de utilizar XAMPP
1.Copia la carpeta del proyecto a: C:\xampp\htdocs\

2.Asegúrate de que Apache y MySQL estén corriendo desde el panel de XAMPP.

En caso de utilizar XAMPP
Copia la carpeta del proyecto a: C:\wamp64\www\Proceso_seleccion (o C:\wamp\www\)

2. Abre el panel de WAMP y enciende Apache y MySQL.


INSTRUCCIONES PARA INCIALIZAR BASE DE DATOS

1- Dirigirse a la carpeta Install y ingresar al tienda.sql, dependiendo de nuesto eleccion nos dirigismo a php my admin o a nuestro Mysql
para copiar toda la base de datos (tienda.sql) y ejecutar el script

2. Nos dirigimos en Install/config.php y deberemos ajustar las siguientes variables de conexión según tu configuración:
    $host = 'localhost:3307';
    $dbname = 'tienda3';
    $user = 'root';
    $password = '';
Por defecto en el script se crea la base de datos con nombre tienda3, pero se puede cambiar el nombre lo unico a cambiar sera el host, user y colocar tu contraseña, en caso de no usar una se deja en blanco como en el
ejemplo de arriba

3.Abre en tu navegador la siguiente URL para verificar la vista principal del proyecto:
http://localhost/Proceso_seleccion/public_html/index.php (XAMPP & WAMPSERVER)
Debera de cargar la vista (Funciona tanto para XAMPP como para WAMPServer)

4. Por último, inicializa los datos del sistema accediendo a:
http://localhost/Proceso_seleccion/install/init_db.php
Si el proceso es exitoso, se mostrará un mensaje de confirmación.
Además, puedes consultar el registro detallado en:
install/init_db.log


LISTA DE ACTIVIDADES LOGRADAS

Creación de la base de datos 
NIVEL BÁSICO 
1. Se requiere un script que deberá contener la creación de un mínimo de 3 tablas donde se 
guardará la información del producto, comentarios y categoría del producto. Deberá 
guardarse como mínimo el modelo, especificaciones, categoría o clasificación del producto y 
precio del producto; para los comentarios se deberán guardar mínimo texto, nombre y 
calificación del comentario. Y para las categorías deberán tener la capacidad de estar 
anidadas.

2. Cada tabla deberá tener un código para insertar no menos de 10 registros por cada una y no 
hay limitación en las columnas: 
TABLA 1 - Tabla de productos información básica 
● Modelo 
● Especificaciones 
● Precio 
● Categoría principal 
● Marca (solo para nivel intermedio y avanzado de PHP) 
● Modelo (solo para nivel intermedio y avanzado de PHP) 
TABLA 2 - Tabla de comentarios 
● Texto 
● Nombre de la persona que comenta 
● Calificación 
TABLA 3 - Tabla de Categorías de Productos (Tipos, Clases o Familias de Productos) 
● Nombre 
● Clase Padre a la que pertenece

INTERMEDIO 
Adicional a los requerimientos del nivel básico, deberás agregar los siguientes puntos: 
1. Crear una vista de los productos con sus comentarios, ordenados por mejor calificación 
promedio. (El cual se accede desde Proceso_seleccion/public_html/prodcutos_mejores_calificados.php)

2. Cada tabla debe de tener sus índices, llaves foráneas y constraints. 
3. Crear una tabla de accesorios asociados a la categoría del producto. 
4. Como parte del script agregar el código para modificar la tabla de productos  agregando 
una nueva columna con la cantidad de visitas a cada producto.

AVANZADO 
Adicional a los puntos que conjuntan el nivel básico e intermedio, deberás incorporar las siguientes 
actividades:  
1. Agregar una tabla o al menos 2 columnas de metainformación que se actualice 
automáticamente, relacionada a cada producto para guardar sus estadísticas como fecha de 
registro, fecha de modificación, cantidad de visitas, cantidad de “likes”, etc. 
2. Hacer un procedimiento o similar para calcular una mensualidad con base en el precio de 
lista a 6 y 12 meses a 10% de interés anual. 
3. Crear una vista donde liste 10 productos en orden aleatorio con base en una clasificación y 
muestre la mensualidad calculada. (El cual se accede desde Proceso_seleccion/public_html/productos_msi.php)

////////////////////////////////////////////////////////////////

SCRIPT PHP DE INICIALIZACIÓN DE LA BASE DE DATOS 
BÁSICO 
1. Deberá utilizar PDO para conectarse con la base de datos y hacer un script en el nivel básico 
que agregue otros 10 registros a cada tabla. El script deberá generar un log donde reporte 
los errores y la cantidad de registros insertados.

INTERMEDIO 
1. Hacer un código donde genere 200 productos de forma aleatoria con especificaciones, 
marcas y modelos utilizando términos técnicos y precios en un rango de 10,000 hasta 
60,000 MXN. 
2. Hacer un código Lorem Ipsum para inicializar los comentarios con textos y calificaciones 
aleatorias, con un mínimo de 1,000 comentarios repartidos entre los productos.

/////////////////////////////////////////////////////////////////

CARPETA PUBLIC_HTML 

BÁSICO 
1. Crear un home que muestre el listado de categorías padres dentro de un menú. 
2. Listado de 10 productos seleccionados aleatoriamente bajo el texto de productos 
destacados. 
3. Debajo un listado de mínimo 10 productos más vendidos con base en su clasificación. 
4. Cuando se dé click en una categoría, se abrirán categorías hijas y se mostrarán los dos 
listados, tanto destacados como de más vendidos filtrados por la categoría seleccionada. 
5. Finalmente al visitar un producto se abrirá una nueva página donde se mostrará el detalle 
del producto con sus especificaciones y comentarios.
 
INTERMEDIO 
1. El listado de productos destacados y más vendidos deberá ser mostrado en páginas para 
poder consultar todos los productos que aplican. (Aplica solamente al escoger una subcategoría)