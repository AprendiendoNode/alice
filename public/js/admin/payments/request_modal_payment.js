function enviar(e){
   var valor= e.getAttribute('value');
   var _token = $('input[name="_token"]').val();
   data_basic_venues(valor, _token);
   data_basic(valor, _token);
   data_basic_bank(valor, _token);
   accounting_account(valor, _token);

  $("input[type=checkbox]").prop('checked', '');
  $("input[type=radio]").prop('checked', '');
  $("#rec_venues_table tbody").children().remove();
  $("#rec_facts_table tbody").children().remove();

  if ( $("#id_xs").length > 0 ) { $("#id_xs").val(valor); }

  $('#modal-view-concept').modal('show');

}

$(".btn-print-invoice").on('click',function(){
  var token = $('input[name="_token"]').val();
  var id = $("#id_xs").val();
  console.log(id);
  $.ajax({
    type: "POST",
    url: "/downloadInvoicePay",
    data: { id_fact : id , _token : token },
    xhrFields: {responseType: 'blob'},
    success: function(response, status, xhr){
      console.log(response);
    if(response !== '[object Blob]'){

      var filename = "";
      var disposition = xhr.getResponseHeader('Content-Disposition');

                  if (disposition) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                  }
                  var linkelem = document.createElement('a');
                  try {
                      var blob = new Blob([response], { type: 'application/octet-stream' });

                      if (typeof window.navigator.msSaveBlob !== 'undefined') {
                          //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                          window.navigator.msSaveBlob(blob, filename);
                      } else {
                          var URL = window.URL || window.webkitURL;
                          var downloadUrl = URL.createObjectURL(blob);

                          if (filename) {
                              // use HTML5 a[download] attribute to specify filename
                              var a = document.createElement("a");
                              // safari doesn't support this yet
                              if (typeof a.download === 'undefined') {
                                  window.location = downloadUrl;
                              } else {
                                  a.href = downloadUrl;
                                  a.download = filename;
                                  document.body.appendChild(a);
                                  a.target = "_blank";
                                  a.click();
                              }
                          } else {
                              window.location = downloadUrl;
                          }
                      }

                  } catch (ex) {
                      console.log(ex);
                  }
                }else{
                  swal("Factura no disponible", "", "error");
                }
              },
              error: function (response) {

              }

        });

});


$(".btn-print-pdf").on('click',function(){
  var token = $('input[name="_token"]').val();
  var id = $("#id_xs").val();
  console.log(id);
  $.ajax({
    type: "POST",
    url: "/downloadInvoicePdf",
    data: { id_fact : id , _token : token },
    xhrFields: {responseType: 'blob'},
    success: function(response, status, xhr){
      console.log(response);
    if(response !== '[object Blob]'){

      var filename = "";
      var disposition = xhr.getResponseHeader('Content-Disposition');

                  if (disposition) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                  }
                  var linkelem = document.createElement('a');
                  try {
                      var blob = new Blob([response], { type: 'application/octet-stream' });

                      if (typeof window.navigator.msSaveBlob !== 'undefined') {
                          //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                          window.navigator.msSaveBlob(blob, filename);
                      } else {
                          var URL = window.URL || window.webkitURL;
                          var downloadUrl = URL.createObjectURL(blob);

                          if (filename) {
                              // use HTML5 a[download] attribute to specify filename
                              var a = document.createElement("a");
                              // safari doesn't support this yet
                              if (typeof a.download === 'undefined') {
                                  window.location = downloadUrl;
                              } else {
                                  a.href = downloadUrl;
                                  a.download = filename;
                                  document.body.appendChild(a);
                                  a.target = "_blank";
                                  a.click();
                              }
                          } else {
                              window.location = downloadUrl;
                          }
                      }

                  } catch (ex) {
                      console.log(ex);
                  }
                }else{
                  swal("Factura no disponible", "", "error");
                }
              },
              error: function (response) {

              }

        });

    });

//
//
function data_basic(campoa, campob){

  $.ajax({
    type: "POST",
    url: "/view_gen_sol_pay",
    data: { pay : campoa , _token : campob },
    success: function (data){
      if (data == null || data == '[]') {
          $("#fecha_ini").text('No disponible.');
          $("#fecha_pay").text('No disponible.');
          $("#rec_proy").val('No disponible.');
          $("#folio").val('No disponible.');
          $("#numfact").val('No disponible.');
          $("#rec_order_purchase").val('No disponible');
          $("#rec_proveedor").val('No disponible.');
          $("#rec_description").val('No disponible.');
          $("#rec_observation").val('No disponible.');
          $("#rec_name_project").val('No disponible.');
          $("#rec_class_cost").val('No disponible.');
          $("#rec_application").val('No disponible.');
          $("#rec_option_proy").val('No disponible.');
          $("#rec_priority").val('No disponible.');
      }
      else {
        var subtotal = 0.0;
        var iva = 0.0;
        var total = 0.0;
        var monto_iva = 0.0;
        var percent_iva = 0;
        if ($.trim(data)){
                  console.log(data);
                  $("#fecha_ini").text(data[0].date_solicitude);
                  $("#fecha_pay").text(data[0].date_limit);
                  $("#rec_priority").val(data[0].priority);
                  $("#rec_order_purchase").val(data[0].purchase_order);
                  $("#rec_proy").val(data[0].cadena);
                  $("#rec_sitio").val(data[0].hotel);
                  $("#numfact").val(data[0].factura);
                  $("#folio").val(data[0].folio);
                  $("#rec_proveedor").val(data[0].proveedor);
                  $("#rec_description").val(data[0].concept_pay);
                  $("#rec_observation").val(data[0].comentario);
                  $("#rec_way_pay").val(data[0].way_pay);
                  disable_buttons(data[0].estatus);

                  $("#rec_venues_table tbody tr").each(function(row, tr){
                      percent_iva = $(tr).find('td:eq(5)').text();
                      monto_iva = $(tr).find('td:eq(6)').text(); // valor de la celda monto iva
                      iva += parseFloat(monto_iva);
                  });

                  monto = parseFloat(data[0].monto);
                  iva = parseFloat(data[0].monto_iva).toFixed(2);
                  $('#iva').val("$" + iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                  subtotal = monto -  iva;
                  total = data[0].monto_str;

                  var cadena = NumeroALetras(data[0].monto);

                  subtotal = parseFloat(subtotal).toFixed(2);
                  subtotal = subtotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                  monto = parseFloat(monto).toFixed(2);
                  total = monto.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                  $("#amountText").val(cadena + data[0].moneda);
                  $("#rec_monto").val("$ " + total);
                  $("#subtotal").val("$" + subtotal);
                  $("#total").val("$" + total);


        }
        else{
                $("#fecha_ini").text('No disponible.');
                $("#fecha_pay").val('No disponible.');
                $("#rec_proy").val('No disponible.');
                $("#rec_sitio").val('No disponible.');
                $("#folio").val('No disponible.');
                $("#rec_proveedor").val('No disponible.');
                $("#rec_monto").val('No disponible.');
                $("#rec_type_mont").val('');
                $("#rec_description").val('No disponible.');
                $("#rec_way_pay").val('No disponible.');

                $("#rec_name_project").val('No disponible.');
                $("#rec_class_cost").val('No disponible.');
                $("#rec_application").val('No disponible.');
                $("#rec_option_proy").val('No disponible.');
        }

      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function data_basic_bank(campoa, campob){
  $.ajax({
    type: "POST",
    url: "/view_gen_sol_pay_bank",
    data: { pay : campoa , _token : campob },
    success: function (data){
      if (data == null || data == '[]') {
          $("#rec_bank").val('No disponible.');
          $("#rec_cuenta").val('No disponible.');
          $("#rec_clabe").val('No disponible.');
          $("#rec_reference").val('No disponible.');
      }
      else {
        if ($.trim(data)){
          datax = JSON.parse(data);
          $("#rec_bank").val(datax[0].banco);
          $("#rec_cuenta").val(datax[0].cuenta);
          $("#rec_clabe").val(datax[0].clabe);
          $("#rec_reference").val(datax[0].referencia);
        }
        else{
          $("#rec_bank").val('No disponible.');
          $("#rec_cuenta").val('No disponible.');
          $("#rec_clabe").val('No disponible.');
          $("#rec_reference").val('No disponible.');
        }
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}


function  data_basic_venues(campoa, campob){
  console.log(campoa);
  $.ajax({
    type: "POST",
    url: "/view_gen_sol_venues",
    data: { pay : campoa , _token : campob },
    success: function (data){
      if (data == null || data == '[]') {
        console.log("No disponible");
      }
      else {
        datax = JSON.parse(data);
        console.log(datax);
        $.each( datax, function( i, venue ) {
          if(venue.id_anexo == null){
            venue.id_anexo = "No disponible";
          }
          if(venue.id_ubicacion == null){
            venue.id_ubicacion = "No disponible";
          }
          var amount = parseFloat(venue.amount).toFixed(2);
          $('#rec_venues_table').append('<tr><td>' + venue.cadena +
                                        '</td><td>' + venue.Sitio +
                                        '</td><td>' + venue.id_anexo  +
                                        '</td><td>'+  venue.id_ubicacion +
                                        '</td><td>'+  "$" + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +
                                        '</td><td>'+  venue.iva  +
                                        '</td><td>'+  venue.amount_iva + '</td></tr>');
        });

      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

//Funcionalidad para convertir numero a letras

function disable_buttons(status){
  if( status == 3 || status == 4 || status == 6){
    $('.btn-print-invoice').prop( "disabled", false);
    $('.btn-print-pdf').prop( "disabled", false);
    $('.btn-export').prop( "disabled", false);
  }else{
    $('.btn-print-invoice').prop( "disabled", true);
    $('.btn-print-pdf').prop( "disabled", true);
    $('.btn-export').prop( "disabled", true);
  }

}

function Unidades(num){

  switch(num)
  {
    case 1: return "UN";
    case 2: return "DOS";
    case 3: return "TRES";
    case 4: return "CUATRO";
    case 5: return "CINCO";
    case 6: return "SEIS";
    case 7: return "SIETE";
    case 8: return "OCHO";
    case 9: return "NUEVE";
  }

  return "";
}

function Decenas(num){

  decena = Math.floor(num/10);
  unidad = num - (decena * 10);

  switch(decena)
  {
    case 1:
      switch(unidad)
      {
        case 0: return "DIEZ";
        case 1: return "ONCE";
        case 2: return "DOCE";
        case 3: return "TRECE";
        case 4: return "CATORCE";
        case 5: return "QUINCE";
        default: return "DIECI" + Unidades(unidad);
      }
    case 2:
      switch(unidad)
      {
        case 0: return "VEINTE";
        default: return "VEINTI" + Unidades(unidad);
      }
    case 3: return DecenasY("TREINTA", unidad);
    case 4: return DecenasY("CUARENTA", unidad);
    case 5: return DecenasY("CINCUENTA", unidad);
    case 6: return DecenasY("SESENTA", unidad);
    case 7: return DecenasY("SETENTA", unidad);
    case 8: return DecenasY("OCHENTA", unidad);
    case 9: return DecenasY("NOVENTA", unidad);
    case 0: return Unidades(unidad);
  }
}//Unidades()

function DecenasY(strSin, numUnidades){
  if (numUnidades > 0)
    return strSin + " Y " + Unidades(numUnidades)

  return strSin;
}//DecenasY()

function Centenas(num){

  centenas = Math.floor(num / 100);
  decenas = num - (centenas * 100);

  switch(centenas)
  {
    case 1:
      if (decenas > 0)
        return "CIENTO " + Decenas(decenas);
      return "CIEN";
    case 2: return "DOSCIENTOS " + Decenas(decenas);
    case 3: return "TRESCIENTOS " + Decenas(decenas);
    case 4: return "CUATROCIENTOS " + Decenas(decenas);
    case 5: return "QUINIENTOS " + Decenas(decenas);
    case 6: return "SEISCIENTOS " + Decenas(decenas);
    case 7: return "SETECIENTOS " + Decenas(decenas);
    case 8: return "OCHOCIENTOS " + Decenas(decenas);
    case 9: return "NOVECIENTOS " + Decenas(decenas);
  }

  return Decenas(decenas);
}//Centenas()

function Seccion(num, divisor, strSingular, strPlural){
  cientos = Math.floor(num / divisor)
  resto = num - (cientos * divisor)

  letras = "";

  if (cientos > 0)
    if (cientos > 1)
      letras = Centenas(cientos) + " " + strPlural;
    else
      letras = strSingular;

  if (resto > 0)
    letras += "";

  return letras;
}//Seccion()

function Miles(num){
  divisor = 1000;
  cientos = Math.floor(num / divisor)
  resto = num - (cientos * divisor)

  strMiles = Seccion(num, divisor, "UN MIL", "MIL");
  strCentenas = Centenas(resto);

  if(strMiles == "")
    return strCentenas;

  return strMiles + " " + strCentenas;

}//Miles()

function Millones(num){
  divisor = 1000000;
  cientos = Math.floor(num / divisor)
  resto = num - (cientos * divisor)

  strMillones = Seccion(num, divisor, "UN MILLON", "MILLONES");
  strMiles = Miles(resto);

  if(strMillones == "")
    return strMiles;

  return strMillones + " " + strMiles;

}//Millones()

function NumeroALetras(num){
  var data = {
    numero: num,
    enteros: Math.floor(num),
    centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
    letrasCentavos: "",
    letrasMonedaPlural: "",
    letrasMonedaSingular: ""
  };

  if (data.centavos > 0)
    data.letrasCentavos = "CON " + data.centavos + "/100 ";

  if(data.enteros == 0)
    return "CERO " + data.letrasMonedaPlural + " " + data.letrasCentavos + "";
  if (data.enteros == 1)
    return Millones(data.enteros) + " " + data.letrasMonedaSingular + " " + data.letrasCentavos;
  else
    return Millones(data.enteros) + " " + data.letrasMonedaPlural + " " + data.letrasCentavos ;
}//NumeroALetras()

function accounting_account(campoa, campob){
  $.ajax({
    type: "POST",
    url: "/cc_account",
    data: { idpay : campoa , _token : campob },
    success: function (data){
      if (data == null || data == '[]') {
          $("#cc_key").val('No disponible.');
      }
      else {
        if ($.trim(data)){
          datax = JSON.parse(data);
          $("#cc_key").val(datax[0].keyname);
        }
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
