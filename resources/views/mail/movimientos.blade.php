<head>
  <style type="text/css">
    table.greyGridTable {
      border: 2px solid #FFFFFF;
      width: 100%;
      text-align: center;
      border-collapse: collapse;
    }
    table.greyGridTable td, table.greyGridTable th {
      border: 1px solid #FFFFFF;
      padding: 3px 4px;
    }
    table.greyGridTable tbody td {
      font-size: 13px;
    }
    table.greyGridTable td:nth-child(even) {
      background: #EBEBEB;
    }
    table.greyGridTable thead {
      background: #FFFFFF;
      border-bottom: 4px solid #333333;
    }
    table.greyGridTable thead th {
      font-size: 15px;
      font-weight: bold;
      color: #333333;
      text-align: center;
      border-left: 2px solid #333333;
    }
    table.greyGridTable thead th:first-child {
      border-left: none;
    }

    table.greyGridTable tfoot td {
      font-size: 14px;
    }
  </style>
</head>
<section >
     <table width="100%" cellpadding="0" cellspacing="0" style="width: 100%; margin: 0;  padding: 0;  -premailer-width: 100%;  -premailer-cellpadding: 0;  -premailer-cellspacing: 0;  background-color: #F2F4F6;">
      <tr>
        <td align="center">
          <table  width="100%" cellpadding="0" cellspacing="0" style=" width: 100%; margin: 0;  padding: 0;  -premailer-width: 100%;  -premailer-cellpadding: 0;  -premailer-cellspacing: 0;">

            <tr>
              <td  style="padding: 25px 0; text-align: center;">
                <img src="http://alice.sitwifi.com/img/company/sitwifi_logo.jpg" style="width: 10%; text-align: center;" alt="Logo">
                <br>
                <hr style=" border: 1px solid #F15C22; border-radius: 100px ;   height: 0px;   text-align: center;">
                <!--
                <p class="email-masthead_name" style=" font-size: 12px; font-weight: bold;  color: #bbbfc3;  text-decoration: none;  text-shadow: 0 1px 0 white;">
                Bien
                </p>
                -->
              </td>
            </tr>
            <tr>
              <td  width="100%" cellpadding="0" cellspacing="0" style="width: 100%; margin: 0;  padding: 0;  -premailer-width: 100%;  -premailer-cellpadding: 0;  -premailer-cellspacing: 0;  border-top: 1px solid #EDEFF2;  border-bottom: 1px solid #EDEFF2;  background-color: #FFFFFF;">
                <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" style="width: 570px; margin: 0 auto; padding: 0; -premailer-width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; background-color: #FFFFFF;">
                  <tr>
                      <td style="padding: 35px;">
                        <h1 style="margin-top: 0; color: #2F3133;  font-size: 19px;  font-weight: bold;  text-align: left;">Notificacion de movimientos.</h1>

                        <p style="margin-top: 0;
                                  color: #74787E;
                                  line-height: 1.5em;
                                  font-size: 12px;
                                  text-align: left;">Movimiento realizado por: <strong>{{Auth::user()->name}}.</strong></p>

                        <p style="margin-top: 0;
                                  color: #74787E;
                                  line-height: 1.5em;
                                  font-size: 12px;
                                  text-align: left;">Estimado: 
                                  @foreach ($data2 as $datos)
                                    <strong>{{$datos}},</strong>
                                  @endforeach
                                  se ha realizado un movimiento de equipo en sus hoteles asignados.
                                </p>
                        
                        <table class="greyGridTable">
                          <caption><small>Equipo Origen</small></caption>
                          <thead>
                          <tr>
                          <th> <small>Origen.</small> </th>
                          <th> <small>Equipo.</small> </th>
                          <th> <small>Marca.</small> </th>
                          <th> <small>Mac.</small> </th>
                          <th> <small>Serie.</small> </th>
                          <th> <small>Modelo.</small> </th>
                          <th> <small>Estado Origen..</small> </th>
                          </tr>
                          </thead>
                          <tbody>
                          @for ($i = 0; $i < count($data); $i++)
                            <tr>
                              <td>{{$data[$i]['cliente_o']}}</td>
                              <td>{{$data[$i]['equipo']}}</td>
                              <td>{{$data[$i]['marca']}}</td>
                              <td>{{$data[$i]['mac']}}</td>
                              <td>{{$data[$i]['serie']}}</td>
                              <td>{{$data[$i]['modelo']}}</td>
                              <td>{{$data[$i]['estado_o']}}</td>
                            </tr>
                          @endfor
                          </tbody>
                        </table>

                        </br>

                        <table class="greyGridTable">

                          <caption><small>Destino.</small></caption>
                          <thead>
                          <tr>
                          <th> <small>Destino.</small> </th>
                          <th> <small>Equipo.</small> </th>
                          <th> <small>Marca.</small> </th>
                          <th> <small>Mac.</small> </th>
                          <th> <small>Serie.</small> </th>
                          <th> <small>Modelo.</small> </th>
                          <th> <small>Estado Destino.</small> </th>
                          </tr>
                          </thead>
                          <tbody>
                          @for ($i = 0; $i < count($data); $i++)                           
                            <tr>
                              <td>{{$data[$i]['cliente_d']}}</td>
                              <td>{{$data[$i]['equipo']}}</td>
                              <td>{{$data[$i]['marca']}}</td>
                              <td>{{$data[$i]['mac']}}</td>
                              <td>{{$data[$i]['serie']}}</td>
                              <td>{{$data[$i]['modelo']}}</td>
                              <td>{{$data[$i]['estado_d']}}</td>
                            </tr>
                          @endfor
                          </tbody>
                        </table>


                        <p style="margin-top: 20;
                                  color: #74787E;
                                  line-height: 1.5em;
                                  text-align: left;
                                  font-size: 12px;
                                  text-align: left;"><strong>{{Carbon\Carbon::now()->toCookieString()}}</strong></p>

                      </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table align="center" width="570" cellpadding="0" cellspacing="0" style="width: 570px; margin: 0 auto; padding: 0; -premailer-width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; text-align: center;">
                  <tr>
                    <td align="center" style="padding: 35px;">
                      <p style="margin-top: 0;
                          color: #74787E;
                          font-size: 12px;
                          line-height: 1.5em;
                          text-align: center;">&copy; 2017 SitWifi. Todos los derechos reservados.</p>
                      <p  style="margin-top: 0;
                          color: #74787E;
                          font-size: 12px;
                          line-height: 1.5em;
                          text-align: center;">
                        Sucursal Cancún
                        <br>Av. Yaxchilan Esq. Bacalar Lote 1-01 Mz 02 Super Manzana 17, Cancún QR.
                        <br>Teléfono: 01 800 884 4630
                      </p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
     </table>
   </section>
