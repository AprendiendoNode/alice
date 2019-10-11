<html lang="en">
<head>
<meta charset="UTF-8">
<title>
  Propuesta Comercial
</title>

<style type="text/css">
    * {
        font-family: Arial,sans-serif, Verdana;
    }

    @page {
            margin: 2cm 2cm;
    }

    .page-break {
        page-break-after: always;
    }

    table{
        font-size: x-small;
        border-collapse: collapse;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }

    table#products{
      width: 100%;
      margin-left: 5%;
    }

    table#products td, table#products th {
      border: 1px solid #D1D1D1;
    }

    table#products tfoot td, table#products tfoot th {
      border-bottom: 1px solid white !important;
    }

    ul {
      list-style: none; /* Remove default bullets */
    }

    ul li::before {
      content: "\2022";  /* Add content: \2022 is the CSS Code/unicode for a bullet */
      color: #FF8C00; /* Change the color */
      font-weight: bold; /* If you want it to be bold */
      display: inline-block; /* Needed to add space between the bullet and the text */
      width: 1em; /* Also needed for space (tweak if needed) */
      margin-left: -1em; /* Also needed for space (tweak if needed) */
    }

    .gray {
        background-color: lightgray;
    }
    .red-color{
      color: #D5232C;
    }
    .bg-blue{
      background-color: #035AA6 !important;
      color: white;
      font-weight: bold;
    }

    .description{
      font-size: 11px;
      font-weight: bold;
    }

    .text-center{
      text-align: center;
    }

    .what-do-it p{
      font-size: 13px;
      text-align: justify;
    }

    .customers-info p{
      font-size: 13px;
      line-height: 2px;
    }

    .tipo_propuesta h3{
      text-align: center;
      text-decoration: underline;
      color: #EE7100;
    }

    .propuesta_header{
      width:70%;
      height: 100px;
      margin-left: 15%;
      text-align: center;
    }

    .propuesta_header div{
      text-align: center;
      display:inline-block;
      height: 100px;
    }

    .lista_servicios{
      margin-top: 0.5cm;
      text-align: justify;
    }

    .lista_servicios{
      width: 85%;
    }

    .lista_servicios ul li{
      font-size: 13px;
      line-height: 1.3em;
    }

    .condiciones_comerciales{
      margin-top: 0.5cm;
    }

    .condiciones_comerciales ul{
      width: 85%;
      font-size: 13px;
      display:inline-block;
    }

    .condiciones_comerciales ul li{
      margin-top: .3em;
      text-align: justify;
    }

    .text-white{
      color: white;
    }

    .text-bold{
      font-weight: bold;
    }

    header {        
      position: fixed;
      top: -2cm;
      left: 0px;
      right: -40px;
      height: 50px;      
    }

</style>

</head>
<body>
  <header>
    <table width="100%">
      <tr>
          <td align="right" valign="top"><img width="180" src="{{ public_path('/img/company/sitwifi_logo.jpg') }}"/></td>
      </tr>
    </table>
  </header>

  <main>
    <h2 class="text-center">Servicio Administrado – {{$documentp->nombre_proyecto}}</h2>
    <div class="what-do-it">
      <h3>¿Qué hacemos?</h3>
      <p>Somos una empresa enfocada a dar soluciones INTEGRALES de ACCESO INALÁMBRICO a INTERNET,
        implementando soluciones a la medida para cada cliente, tomando en cuenta sus necesidades técnicas y
        financieras. A través de estudios de cobertura y demanda, diseñamos la infraestructura de red para las
        necesidades específicas de cada cliente, recomendando los equipos adecuados para su óptima operación.</p>
    </div>
    <div class="customers-info">
      <h3>Algunos de nuestros clientes</h3>
      <p>Hotelería: Hard Rock, Palace Resorts, H10, Iberostar, Grupo Karisma</p>
      <p>Educación: UDLA, Aliat, UVM, Oxford, UNLA.</p>
      <p>Aeropuertos: Costa Rica y 36 en México</p>
    </div>
    <div class="tipo_propuesta">
      <h3>Propuesta de Renovación</h3>
    </div>
    <br><br>

    <div class="propuesta_header">
      <div class="" style="width:50%;background: #D9D9D9;font-size:13px;">
        <p class="text-center">Propuesta Económica</p>
        <p class="text-center">Servicio administrado</p>
        @php
          $date = \Carbon\Carbon::now()->addMonth();
          $date = $date->format('d-m-Y');
        @endphp
        <p class="text-center">Vigencia {{$date}}</p>
      </div>
      <div style="width:45%;background: #D90000;font-size:14px;">
        <p class="text-center text-white text-bold">Costo total mensual</p>
        <p class="text-center text-white text-bold">${{$documentp->servicio_mensual}} USD</p>
        <p class="text-center text-white text-bold">{{$documentp->plazo}} meses</p>
      </div>
    </div>
    <div style="font-size:13px;" class="">
      <ul>
        <li>Sin IVA</li>
        <li>Dólares americanos</li>
        <li>Equipo no activo actual y Renovación del equipo activo enlistado</li>
      </ul>
    </div>

    <div style="width:90%;margin-left:2%;">
      <h3>Detalle de Equipo a suministrar en Proyecto</h3>
      <table id="products">
        <thead class="bg-blue">
          <tr>
            <th>Producto</th>
            <th align="center">Descripción</th>
            <th align="center">Marca</th>
            <th align="center">Unidad</th>
            <th align="center">Cantidad</th>
          </tr>
        </thead>
        <tbody>
          @foreach($equipo_activo as $products)
            <tr>
              <td>{{$products->producto}}</td>
              <td>{{$products->description_long}}</td>
              <td>{{$products->marca}}</td>
              <td align="center">PZA</td>
              <td align="center">{{(int)$products->cantidad}}</td>
            </tr>
          @endforeach
          
        </tbody>
      </table>
    </div>

    <div class="lista_servicios">
        <h3>Servicios incluidos</h3>
        <ul>
          @foreach($servicios as $servicio)
            <li style="margin-bottom:10px;">{{$servicio->name}}</li>
          @endforeach
        </ul>
    </div>
  
    <!--CONDICIONES COMERCIALES-->
    <div class="page-break"></div>
    
    <div class="condiciones_comerciales">
      <h3>Condiciones comerciales</h3>
      <ul class="one_column">
        @foreach($condiciones as $condicion)
            <li style="margin-bottom:10px;">{{$condicion->name}}</li>
        @endforeach
      </ul>
    </div>


  </main>

</body>
</html>
