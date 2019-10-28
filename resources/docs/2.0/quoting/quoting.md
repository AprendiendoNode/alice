# Cotizador
Este modulo nos permite crear cotizaciones para nuevos proyectos y saber deacuerdo a los parametros si la realizacion del proyecto es factible. El cotizador se llena en 3 pasos como se muestra a continuacion.


 - [General](#head1)
 - [Llenar formulario](#formNew)
 

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

