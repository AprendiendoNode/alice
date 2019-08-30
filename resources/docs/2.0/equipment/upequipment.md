# Altas equipos
 - [Añadir equipos individuales](#head1)
 - [Añadir equipos masivos](#head2)

## <a name="head1">Añadir equipos individualmente</a> :computer:
El apartado de altas te hará una pregunta antes de iniciar con el registro.
![image](/images/docs/equipment/eq_individual1.png)<br>
En la cual tendrás que responder con un SI ó NO. Dependiendo de tu respuesta se habilitarán
ciertos campos.<br><br>
**A)Si tu respuesta fue SI**<br>
Te aparecerá una ventana similar a esta:<br>
![image](/images/docs/equipment/eq_individual2.png)<br><br>
Donde se te solicitará ciertos campos a llenar. Ahora te los mostrare como llenarlos de acuerdo a
cada campo.<br><br>
**La primera sección de la ventana anterior, te solicita lo siguiente.** <br>
![image](/images/docs/equipment/eq_individual3.png)<br><br>
Donde tendrás que ingresar<br>
1.-**El número de factura:** Que tiene como requerimiento ingresar 8 caracteres.<br>
2.-**Fecha de facturación:** Tienes que ingresar o seleccionar una fecha del desplegable que se te mostrara como en la siguiente imagen. El formato de la fecha es AÑO-MES-DIA (YYYY-MM-DD), Ejemplo: 2019-08-15.<br>
![image](/images/docs/equipment/eq_individual4.png)<br><br>
3.-**Proveedor:** Tienes que seleccionar un elemento de la lista desplegable, en dado caso que ya este registrado en el sistema.<br>
En el caso que no esté dado de alta en el sistema utilice el botón de nuevo proveedor. El cual nos mostrara una ventana modal, en la cual nos solicita cierta información requerida para dar de alta un nuevo proveedor. Automáticamente cuando se registre el proveedor se refrescará la lista desplegable de proveedores.<br><br>
**La segunda sección de la ventana anterior, te solicita lo siguiente.**<br>
![image](/images/docs/equipment/eq_individual5.png)<br><br>
Donde tendrás que ingresar<br>
1.-**MAC:** Tendrás que ingresar la dirección MAC del equipo. Automáticamente se aplica el formato de la MAC.<br> **Ejemplo: XX:XX:XX:XX:XX:XX:XX:XX<br>**
2.-**Núm. Serie:**  Tendrás que ingresar el número de serie del equipo, el cual consta de un mínimo de 10 caracteres.<br>
3.-**Grupo:** Este campo es opcional. Pero su función es para agrupar cada equipo que se registre en un grupo existente o nuevo. Puedes crear un grupo nuevo en el botón amarrillo que se encuentra junto a la lista desplegable de grupos. Una vez dado clic en el botón se mostrará una ventana modal solicitando el nombre del nuevo grupo.<br>
4.-**Descripción:** Nos permite añadir una breve información del equipo. Se solicita como mínimo 4 caracteres para continuar con el registro.<br>
5.-**Tipo de equipo:** Deberá de seleccionar un elemento de la lista desplegable.<br>
6.-**Marca:** Deberá seleccionar la marca del equipo en la lista desplegable, en dado caso que no exista usted lo puede añadir en el botón amarrillo junto a la lista desplegable.<br>
7.-**Modelo:** Deberá seleccionar el modelo del equipo en la lista desplegable, en dado caso que no exista usted lo puede añadir en el botón amarrillo junto a la lista desplegable.<br>
8.-**Estado:** Deberá de seleccionar un elemento de la lista desplegable.<br>
9.-**Sitio:** Deberá de seleccionar un sitio de la lista desplegable. De esta forma sabremos la ubicación o hacia donde está dirigido el equipo.<br>
10.-**Precio:** Deberá de introducir el monto del equipo y además deberá de seleccionar el tipo de moneda en la lista desplegable.<br><br>
**B) Si tu respuesta fue NO.**<br>
No se te solicitara los datos de facturación, pero si los demás campos. Ejemplo:<br>
![image](/images/docs/equipment/eq_individual5.png)<br><br>
## <a name="head2">Añadir equipos de forma masiva </a> :computer: :computer:
En este nuevo apartado podemos añadir equipos de forma masiva en alice a traves de un excel.<br>
Los pasos campos requeridos son identicos a los de "añadir equipo individual" con unas pequeñas variaciones que te mostraremos a continuación:<br>
![image](/images/docs/equipment/eq_masivos1.png)<br><br>
Como podrás observar hay 2 botones nuevos:<br>
1.-**Descargar plantilla vacia:** Este botón te permite descargar el formato de excel necesario para dar de alta muchos equipos de forma sencilla en unos pocos pasos.<br>
2.-**Subir plantilla excel:** Este botón te permite cargar el archivo de excel donde estan los datos de todos los equipos que quiera dar de alta.<br><br>
Primero pulse el botón de "Descargar plantilla vacia" y abra el archivo de excel.<br>
En el formato que se muestra a continuación deberá llenar **única y obligatoriamente** los campos de mac y serie **ambos sin signos de puntuacion y simbolos extraños**.Por ejemplo **XXXXXXXXXXXX** en total son 12 digitos para la mac.
![image](/images/docs/equipment/Excel.png)<br><br>
Al terminar de llenar el excel haga clic en el boton de "Subir plantilla de excel" para escoger su archivo, una vez cargado llene los campos requeridos por el formulario  de forma similar al ejemplo:<br>
![image](/images/docs/equipment/eq_masivos2.png)<br><br>
Por último haga clic en el boton de "Guardar".
