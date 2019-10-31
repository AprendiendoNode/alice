# Cotizador
Este modulo nos permite crear cotizaciones para nuevos proyectos y saber deacuerdo a los parametros si la realizacion del proyecto es factible. El cotizador se llena en 3 pasos como se muestra a continuacion.


 - [General](#head1)
 - [Llenar formulario](#formNew)
 - [Agregar productos](#agregarProductos)
 - [Resumen de cotizacion](#resumen)
 

## <a name="formNew">1.- Llenar formulario</a> :pencil:
Primero tenemos que llenar todos los campos obligatorios que nos pide el formulario, esta separado en 2 secciones: datos del sitio y los datos financieros.<br><br>

![image](/images/docs/quoting/formNuevoCotizador.png)

<h5 class="text-danger">* DATOS DEL SITIO</h5>

- Tipo Documento:
C (Cotizacion)

- Nombre del proyecto:

Nombre del sitio en donde se llevara la instalacion. Dejar vacio este campo si es un Documento M.

- Num. sitios: 

Numero de sitios que tiene el proyecto.

- Vertical: 

Seleccionar la vertical al que pertenece el sitio (Hoteleria, educacion, etc.).

- Grupo / Nombre: 

Nombre de la cadena o grupo del sitio.

- Num. oportunidad: 

Numero de oportunidad en el salesforce, dejar vacio si no se tiene esta informacion.

- Densidad: 

Numero de habitaciones o usuarios del sitio.

- IT Concierge: 

Personal de soporte que sera responsable del sitio. 

- Propietario de la cuenta: 

Personal del area comercial.

- Tipo de servicio: 

Tipo de servicio que se realizara( Cliente nuevo, renovacion, ampliacion, etc.).

- Lugar de la instalacion: 

Donde se realizara la instalacion (Local o foranea).

- Tipo de cambio

> {warning} Tipo de cambio con el que se cotizaran los productos que se agreguen al cotizador.
El monto de los productos sera en USD, en caso de que el precio de algun producto sea en pesos (MXN) el sistema realizara la conversion a USD de forma automatica con el tipo de cambio que tenga este campo.

<h5 class="text-danger">* DATOS FINANCIEROS</h5>

- Vigencia(Plazo): 

Numero de meses que durara el contrato del servicio administrado con el cliente.

- Servicio mensual: 

Monto en USD que se le cobrara al cliente de forma mensual durante la vigencia del proyecto.

- Renta anticipada: 

Monto en USD que abonara el cliente en caso de que aplique.

- Enlace

Costo del enlace USD en caso de que aplique

- Instalaciones(%)

Porcentaje de instalaciones

- Deposito en garantia

Deposito del cliente en caso de que aplique

- Utilidad venta EA %

Utilidad de venta de equipo activo

- Indirectos(%)

Porcentaje de indirectos

## <a name="servicio_mensual">Calculo de servicio mensual automatico</a> 
El boton de ***Calcular servicio mensual***, realizara el calculo de la renta mensual de forma que cumpla con los parametros financieros para que el proyecto sea rentable.

![image](/images/docs/quoting/servicio_mensual_boton.png)

Al dar clic aparecera un mensaje de espera.<br><br>
![image](/images/docs/quoting/buscandoObjetivo.png)

Cuando se encuentre el objetivo del servicio mensual a cobrar aparecera un mensaje de confirmacion. <br><br>
![image](/images/docs/quoting/servicioMensualAlert.png)

Posteriormente en la tabla de objetivos aparecera todos los parametros con los objetivos esperados. <br><br>

![image](/images/docs/quoting/Objetivos.png)

 > {info} En la parte de abajo del formulario del cotizador apareceran unas tablas con metricas financieras que se actualizan automaticamente al modificar los datos financieros del cotizador.

 ![image](/images/docs/quoting/tablasParametros.png)

 ## <a name="agregarProductos">2.- Agregar productos al cotizador</a>

En el siguiente paso debera agregar productos al cotizador, dispondra de un apartado para agregar equipo activo como AP'S, Switches y firewalls con los modelos y cantidades que necesite.<br><br>

Al terminar de seleccionar el equipo activo, debera hacer clic en el boton ***Buscar Equipo Activo*** . Para agregar al cotizador debe hacer clic al boton rojo del producto. <br><br>

![image](/images/docs/quoting/agregarEA.png)

Al dar clic en el boton ***Buscar Materiales*** . Se cargara un listado de productos con las cantidades sugeridas deacuerdo al numero de antenas seleccionadas en el paso anterior. Puede elegir agregar el producto con la cantidad sugerida o ingresar una cantidad diferente en campo cantidad requerida que se encuentra en el producto.  <br><br>

![image](/images/docs/quoting/agregarENA.png)

Despues tendra la opcion de ***Agregar mano de obra*** si el proyecto lo requiere y se cargaran los productos de mano de obra de forma automatica al cotizador.   <br><br>

## <a name="resumen">3.- Resumen de cotizacion </a>
En el tercer paso se le mostrara un resumen del cotizador con los productos que agrego, desde aqui puede editar las cantidades, y eliminar productos. Si desea cambiar los datos financieros o agregar mas productos puede volver a los pasos anteriores.

![image](/images/docs/quoting/resumenCotizacion.png)

> {danger} Tenga en cuenta que al modificar los productos y datos finacieros los parametros de los objetivos cambiaran y tendra que volver a calcular el servicio mensual nuevamente para que el objetivo se ajuste a un valor rentable.<br><br>

Por ultimo debera hacer clic al boton ***Guardar cotizacion*** para finalizar.<br><br>

![image](/images/docs/quoting/guardarCotizacion.png)

> {success} El sistema hara una serie de validaciones y le pondra un estatus al cotizador en automatico:

- Fuera de parametros

Si el cotizador no cumple con los parametros de la tabla de objetivos o si el monto total de la inversion supera los 50000 USD, se marcara con el estatus ***Fuera de parametros*** y debera solicitar autorizacion por parte de la direccion para poder descargar la propuesta comercial del cliente. <br><br>      

![image](/images/docs/quoting/fueraParametros.png)

- Autorizado

Si el cotizador cumple con los parametros de los objetivos y el monto total de la inversion no supera los 50000 USD, se marcara con el estatus ***Autorizado***. <br><br>      

![image](/images/docs/quoting/autorizado.png)






