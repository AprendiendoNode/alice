# Solicitud de compra
 - [General](#head1)

## <a name="head1">Solicitud de compra</a>
Este apartado nos permite crear documentos P y M para solicitud de compra de materiales ya sea para un proyecto nuevo o de mantenimiento segun sea el caso
![image](/images/docs/documentp/solicitud_compra_form.png)

## <a name="requirements">Llenar formulario</a> :pencil:
Primero tenemos que llenar todos los campos obligatorios que nos pide el formulario:<br><br>

- Tipo Documento:
Seleccionar el tipo de documento de la solicitud( P | M)
en caso de que sea un documento M se nos dara la opcion de elegir el sitio al que se le cargara la compra.

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

> {warning} Tipo de cambio con el que se cotizaran los productos que se agreguen en la solicitud.
El monto de los productos sera en USD, en caso de que el precio de algun producto sea en pesos (MXN) el sistema realizara la conversion a USD de forma automatica con el tipo de cambio que tenga este campo.

## <a name="head1">Agregar equipo activo</a>
El siguiente paso es seleccionar el equipo activo que se utilizara en el proyecto con sus cantidades. Posteriormente al hacer click en buscar equipo activo, el sistema mostrara el equipo seleccionado con una sugerencia de zone director, el modelo del zone director propuesto sera deacuerdo a la cantidad de AP's aolicitada.
![image](/images/docs/documentp/seleccionarEA.png)

 > {info}Para agregar el producto a la solicitud debera hacer click al boton rojo debajo de la informacion del producto. En el siguiente paso se le mostrara un resumen de su pedido y podra editar la cantidad solicitada o eliminar el producto en caso de error.

 ## <a name="head1">Agregar equipo no activo</a>

 Despues de agregar el equipo activo podra agregar equipo no activo(Materiales de instalacion) de igual forma que el paso anterior al hacer click en el boton Buscar materiales, el sistema le mostrara una lista de materiales con sus cantidades sugeridas segun el numero de AP'S elegidas anteriormente.
![image](/images/docs/documentp/seleccionarENA.png)

 Al agregar el material si el campo ***cantidad requerida*** esta vacio, tomara la ***cantidad sugerida*** para el pedido. Si desea agregar otra cantidad diferente al que el sistema le sugiere puede hacerlo en el campo ***cantidad requerida*** y esta se tomara en cuenta en la solicitud.

## <a name="head1">Agregar materiales extra</a>

  PENDIENTE POR FUTURAS ACTUALIZACIONES

## <a name="head1">Resumen de pedido</a>

En el siguiente paso del formulario se mostrara un resumen de su pedido, aqui podra editar las cantidades y eliminar productos del pedido. Se le mostrara una tabla con la informacion de los productos que solicito ordenados por ***equipo activo*** , ***materiales*** y ***mano de obra***. 
Puede agregar mas materiales en el paso anterior si lo requiere.  
![image](/images/docs/documentp/resumenPedido.png)

## <a name="head1">Guardar pedido</a>

Para finalizar debera hacer clic en el boton submit y le aparecera una ventana de confirmacion, seleccionar confirmar para guardar la solicitud.
![image](/images/docs/documentp/confirmarCompra.png)

> {success} Su solicitud pasara por autorizacion de parte de gerencia de soporte o instalaciones y por ultimo por gerencia de compras.
Podra editar su solicitud de compra las veces que asi lo requiera antes de que sea aprobado. Despues de ser autorizada su solicitud, solo dispondra de un limite de 3 ediciones y en la ultima edicion tendra un tiempo de 4 horas  para enviar su ultima edicion.

Para visualizar su solicitud debera ir al historial de documento P o documento M que se encuentra en el menu de ***proyectos***. <br>

![image](/images/docs/documentp/historialCompras.png)

Al dar clic en el boton rojo en su solicitud se desplegara un menu opciones con diferentes acciones que puede realizar

- ***Editar***

Lo enviara a una ventana para editar su solicitud de compra.

- ***Ver pedido***

Se mostrara una ventana con informacion del estatus de su pedido
![image](/images/docs/documentp/verPedido.png)

- ***Kick off***

- ***Ir a cotizador***

- ***Imprimir productos***

Renderiza un pdf con la lista de productos del pedido



