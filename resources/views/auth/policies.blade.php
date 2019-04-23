@extends('layouts.auth')

@section('content')
<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth px-0">
      <div class="row w-100 mx-0">
        <div class="col-md-10 mx-auto">
          <main role="main" class="container">
            <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-secondary rounded box-shadow">
              <img class="mr-3" src="{{ asset('/img/website/alice.svg') }}" alt="" width="48" height="48">
              <div class="lh-100">
                <h6 class="mb-0 text-white lh-100">Sitwifi</h6>
                <small>Aviso de Privacidad General</small>
              </div>
            </div>

            <div class="my-3 p-3 bg-white rounded box-shadow">
              <h6 class="border-bottom border-gray pb-2 mb-0 text-left">Ultima actualización: 15-dic-15</h6>
              <div class="text-muted pt-3">
                <p class="text-justify lh-200 small">
                  En cumplimiento con la Ley Federal de Protección de Datos Personales en Posesión de los Particulares (LFPDPPP), y con el fin de asegurar la protección y privacidad de los datos personales, así como regular el acceso, rectificación, cancelación y oposición del manejo de los mismo,  de conformidad con lo establecido por los artículos 15, 16 y 17 de la LFPDPPP,</span>
                  <strong class="text-gray-dark">SITWIFI S.A. C.V.</strong>(SITWIFI), con domicilio en Calle Hamburgo 159 Col Juárez, C.P. 06600 México D.F., mismo que señala para todos los efectos legales derivados del manejo de la información proporcionada en los formularios de registro de datos personales contenidos en el sitio web www.sitwifi.com y los demás sitios web de su propiedad, o por vía electrónica, óptica, sonora, visual o por cualquier otro medio o tecnología (el “Sitio”), está comprometida y es responsable de la protección y tratamiento de sus datos personales.
                </p>
                <p class="text-justify lh-200 small">
                  <strong class="d-block text-gray-dark text-uppercase">Datos personales recabados</strong>
                  Los datos que Usted proporcione en este Sitio, a través de los formatos de registro que SITWIFI pone a su disposición son comunicados por Usted de forma libre y voluntaria por lo que Usted declara que los siguientes datos personales de contacto y/o de identificación proporcionados:
                  <li class="lh-200 small">Nombre, Sexo, Edad, Domicilio, Correo Electrónico, Fecha De Nacimiento, Estado Civil, Número Telefónico, Nacionalidad y/o Tipo de Equipo.</li>
                </p>
                <p class="text-justify lh-200 small">
                  Al ingresar sus datos personales en el Sitio, usted acepta este Aviso de Privacidad y usted otorga su consentimiento y/o autorización expresa a SITWIFI para recolectar, procesar/tratar, utilizar y almacenar su información personal para las finalidades que son descritas a continuación:
                </p>

                <p class="text-justify lh-200 small">
                  <strong class="d-block text-gray-dark text-uppercase">Finalidad del tratamiento de los datos.</strong>
                  Los datos personales que se proporcione a SITWIFI; en los formularios de registro contenidos en el Sitio, y los demás portales de su propiedad, vía electrónica, óptica, sonora, visual, signos inequívocos u otra tecnología, que actualmente o en el futuro se encuentren en sus bases de datos, poseen su autorización voluntaria como titular de los mismos, dando consentimiento para que  SITWIFI; sus filiales; subsidiarias; o terceros de acuerdo a la naturaleza de sus funciones, puedan utilizar; tratar; recolectar; procesar; y/o almacenar su información, incluso los Datos Personales sensibles, incluidos los envíos por correo electrónico, telefonía celular (mensaje SMS, MMS, entre otros) o todo medio de comunicación electrónica similar o que pueda llegar a desarrollarse, para evaluar la calidad en el servicio;  informarle de todos los beneficios de servicios y productos manejados con fines promocionales; para  otorgarle los servicios que puede usted obtener por la descarga de aplicaciones tecnológicas en sus aplicativos móviles, para información estadística y generación de reportes; análisis de uso de productos; para encuestas de calidad y satisfacción; estadísticas para el envío de avisos acerca de productos y servicios operados; así como para brindarle soporte técnico, así como para todos los fines relacionados con el cumplimiento de nuestras obligaciones de conformidad con lo establecido en nuestros términos y condiciones y compartir su información con terceros para el cumplimiento de los fines anteriores.
                </p>

                <p class="text-justify lh-200 small">
                  <strong class="d-block text-gray-dark text-uppercase">Finalidad secundarias.</strong>
                  Asimismo, le informamos que sus datos personales se tratarán para fines mercadotécnicos, publicitarios y de prospección comercial, incluyendo el ofrecimiento y promoción de bienes y servicios de SITWIFI, sus Afiliadas y sus clientes. No obstante lo anterior, Usted puede manifestar su negativa para que sus datos no sean tratados para los fines descritos en este párrafo a través del procedimiento detallado en el presente Aviso de Privacidad.
                </p>
                <p class="text-justify lh-200 small">
                  Al proporcionarnos sus datos, Usted acepta de manera tácita que tratemos dichos datos para los fines señalados con anterioridad.
                </p>

                <p class="text-justify lh-200 small">
                  <strong class="d-block text-gray-dark text-uppercase">Como limitar el uso o divulgacion de los datos personales.</strong>
                  SITWIFI, ha adoptado los niveles de seguridad y de protección de datos personales requeridos por Ley, sin perjuicio de que pueda implementar otros medios y medidas técnicas para evitar la alteración, acceso no autorizado de manera enunciativa no limitativa, de los datos personales proporcionados por Usted.
                </p>

                <p class="text-justify lh-200 small">
                  La información proporcionada puede ser revocada en cualquier momento de acuerdo al procedimiento que se menciona en el presente aviso de privacidad, exceptuando aquellas que: deban ser tratadas por disposición legal; se refieran a las partes de un contrato privado, social o administrativo y sean necesarios para su desarrollo y cumplimiento; cuando obstaculice actuaciones judiciales o administrativas vinculadas a obligaciones fiscales, la investigación y persecución de delitos o la actualización de sanciones administrativas; aquellas que sean necesarias para proteger los intereses jurídicamente tutelados del titular; sean necesarias para realizar una acción en función del interés público; sean necesarios para cumplir con una obligación legalmente adquirida por Usted.
                </p>

                <p class="text-justify lh-200 small">
                  Para el ejercicio de sus Derechos ARCO (Acceso, Rectificación, Cancelación y Oposición) el titular deberá enviar a SITWIFI S.A. C.V., una solicitud por escrito a la dirección: <strong class="text-gray-dark">contacto@sitwifi.com</strong>, a través de la cual podrá explicar cuáles son los datos personales que desea rectificar, revocar o eliminar, debiendo redactar en idioma español una nota dirigida al Responsable de Datos Personales, que deberá contener:
                </p>

                <p class="text-justify lh-200 small">
                  <li class="lh-200 small">Nombre del titular</li>
                  <li class="lh-200 small">Domicilio u otro medio para comunicarle la respuesta (si no cumple con este requisito se tendrá por no presentada la solicitud)</li>
                  <li class="lh-200 small">Documentos que acrediten su personalidad (IFE, pasaporte, cartilla, cédula profesional. En caso de actuar a través de un representante legal, será necesario acreditar la personalidad a través de un poder otorgado e identificación.</li>
                  <li class="lh-200 small">Descripción clara y precisa de los datos personales respecto de los cuales se busca ejercer los Derechos ARCO</li>
                  <li class="lh-200 small">Cualquier otro elemento o documentación que facilite la localización de sus datos personales.</li>
                </p>

                <p class="text-justify lh-200 small">
                  <strong class="d-block text-gray-dark text-uppercase">Transferencias de datos</strong>
                  El Titular de la Información entiende y acepta que SITWIFI, y/o cualquiera de sus subsidiarias y/o filiales, podrá transferir sus datos personales a: una afiliada con la finalidad de ofrecerle otros productos y servicios, autoridades judiciales, mexicanas y extranjeras, con la finalidad de dar cumplimiento a la ley, notificaciones, requerimientos u oficios de carácter judicial, algún tercero con el que SITWIFI y/o sus Afiliadas hayan celebrado un contrato con la finalidad de ofrecer y promover productos y/o servicios de dicho tercero a través del Sitio, algún tercero con el que SITWIFI y/o sus afiliadas hayan celebrado un contrato y ofrezcan productos y servicios mediante sus plataformas o medios tecnológicos con la finalidad de ofrecer y promover productos y/o servicios de dicho tercero a través del Sitio, proveedores de servicios de internet sobre la cual esté montada la plataforma o infraestructura tecnológica de SITWIFI, y en sí a cualquier terceros, para que realicen en su nombre y representación ciertas tareas relacionadas con las actividades comerciales y de promoción de sus productos y/o servicios. Estas terceras partes pueden tratar los datos y/ o tomar decisiones sobre ellos como parte de la prestación de sus servicios, para lo cual SITWIFI, seleccionara proveedores que considere confiables y que se comprometan, mediante un contrato u otros medios legales aplicables, a implementar las medidas de seguridad necesarias para garantizar un nivel de protección adecuado a sus datos personales.
                </p>
                <p class="text-justify lh-200 small">
                  <strong class="d-block text-gray-dark text-uppercase">Modificaciones al presente aviso de privacidad</strong>
                  SITWIFI se reserva el derecho de modificar total o parcialmente los términos y condiciones de este Aviso de Privacidad, en cuyo caso notificaremos estos cambios a través de nuestro sitio web www.sitwifi.com. Por lo que le recomendamos visitarlo periódicamente. O enviar un correo electrónico a <strong class="text-gray-dark">contacto@sitwifi.com</strong>
                </p>
              </div>
            </div>


          </main>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
