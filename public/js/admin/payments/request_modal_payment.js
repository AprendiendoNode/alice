var modificando, sitios, payment, proveedor_id, moneda, tochange_account;

function enviar(e, editing){


  //If editing...just edit by users with edit permie and if the payments have status 1 or 2
   modificando = editing;

   if(modificando){
     tochange_account = true;
     $('.no_aprobar_en_gastos').addClass("d-none");
     createEventListener_filePdf();
     createEventListener_fileXml();
   } else {
     tochange_account = false;
     $('.no_aprobar_en_gastos').removeClass("d-none");
   }
   var valor= e.getAttribute('value');
   payment = valor;

   var _token = $('input[name="_token"]').val();
   data_basic_venues(payment, _token);

  $("input[type=checkbox]").prop('checked', '');
  $("input[type=radio]").prop('checked', '');
  $("#rec_venues_table tbody").children().remove();
  $("#rec_facts_table tbody").children().remove();

  if ( $("#id_xs").length > 0 ) { $("#id_xs").val(payment); }

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
        moneda = data[0].moneda;
        if ($.trim(data)){
                  console.log(data);
                  $("#fecha_ini").text(data[0].date_solicitude);
                  $("#fecha_pay").text(data[0].date_limit);
                  $("#fecha_pay_edit").val(data[0].date_limit);
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
                  $('#iva2').val("$" + iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
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

                  $("#totales_format").val(monto);
                  $("#totales").val(monto);

                  if(!modificando) {
                    $("#rec_venues_table tbody tr").each(function(row, tr){
                        monto_iva = $(tr).find('td:eq(6)').text();
                        $(tr).find('td:eq(6)').text("$"+monto_iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    });
                  }

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
  $.ajax({
    type: "POST",
    url: "/view_gen_sol_venues",
    data: { pay : campoa , _token : campob },
    success: function (data){
      sitios = 0;
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
          if(modificando && datax.length <= 1) {
            $('#column_title').text("Total");
            $('#rec_venues_table').append('<tr><td>' + venue.cadena +
                                          '</td><td>' + venue.Sitio +
                                          '</td><td>' + venue.id_anexo  +
                                          '</td><td>'+  venue.id_ubicacion +
                                          '</td><td><input type="text" style="width: 100%;" id="price" onkeyup="sumar();" value="'+amount.toString()+'"/>' +
                                          '</td><td><input type="text" style="width: 100%;" id="iva_format" value="'+venue.amount_iva+'" readonly/>' + '<input type="text" name="iva" style="width: 100%;" id="iva" value="'+venue.amount_iva+'" onkeyup="sumariva();" readonly/>' +
                                          '</td><td><input type="text" style="width: 100%;" id="totales_format" value="'+amount.toString()+'" readonly/>' + '<input type="text" style="width: 100%;" id="totales" value="'+amount.toString()+'" name="totales" readonly/>' +
                                          '</td><td><select id="rec_coin" style="width: 100%;" disabled></select></td></tr>');
          } else {
            $('#column_title').text("Monto IVA");
            $('#rec_venues_table').append('<tr><td>' + venue.cadena +
                                          '</td><td>' + venue.Sitio +
                                          '</td><td>' + venue.id_anexo  +
                                          '</td><td>'+  venue.id_ubicacion +
                                          '</td><td>'+  "$" + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +
                                          '</td><td>'+  venue.iva  +
                                          '</td><td>'+  venue.amount_iva + '</td></tr>');
          }
          sitios++;
        });
        $('#iva').hide();
        $('#totales').hide();
      }

      var _token = $('input[name="_token"]').val();

      data_basic(payment, _token);
      data_basic_bank(payment, _token);
      data_basic_firmas(payment, _token);
      accounting_account(payment, _token);

    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function sumar() { //Cambiando el monto
    var total = 0.00;
    var total_format = "";
    var subtotal = 0.00;
    var iva = 0.00;
    var iva_format = "";
    var tasa = 16;
    var isr = 0;
    var iva_reten = 0;
    var checkbox = document.getElementById('check_iva');
    var checkbox_isr = document.getElementById('check_isr');
    var check_isr = checkbox_isr.checked == true;
    var check_iva = checkbox.checked == true;

    $("#price").each(function() {
      console.log($(this).val());
        if (isNaN(parseFloat($(this).val()))) {
            subtotal += 0;
            $('#price').val(0);
        } else {
            subtotal += parseFloat($(this).val());
        }
    });

    $('#subtotal').val("$ " + subtotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

    if (!check_iva && !check_isr) {
        iva = parseFloat((subtotal * tasa) / 100).toFixed(2);
        iva = parseFloat(iva);
        total = parseFloat(subtotal + iva).toFixed(2);
        $('#iva').val(iva);
        $('#totales').val(total);
        $('#totales_format').val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#rec_monto').val("$ " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#total').val("$ " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#iva_format').val(iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#iva2').val("$ " + iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    } else {
        if (check_iva) {
            $('#iva').val(0);
            $('#totales_format').val(subtotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#rec_monto').val("$ " + subtotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#total').val("$ " + subtotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#totales').val(subtotal);
        } else {
            //console.log('no entro aqui!!!');
            iva = parseFloat((subtotal * tasa) / 100);
            isr = parseFloat((subtotal * 10) / 100);
            //console.log("ISR: " + isr);
            iva_reten = parseFloat((iva * 2) / 3);
            //console.log("iva_reten: " + iva_reten);
            total = parseFloat(((subtotal + iva) - isr) - iva_reten).toFixed(2);
            $('#iva').val(iva);
            $('#totales').val(total);
            $('#iva_format').val(iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#iva2').val("$ " + iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#totales_format').val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#rec_monto').val("$ " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#total').val("$ " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }
    }

}

function sumariva() {
    var total = 0.00;
    var total_format = "";
    var subtotal = 0.00;
    var subtotal_format = "";
    var iva = 0.00;
    var iva_format = "";
    var tasa = 16;
    var checkbox = document.getElementById('check_iva');

    $("#price").each(function() {
        if (isNaN(parseFloat($(this).val()))) {
            subtotal += 0;
        } else {
            subtotal += parseFloat($(this).val());
        }
    });

    if (parseFloat($('#iva').val()) >= 0) {
        iva = parseFloat($('#iva').val()); console.log("ok");
    } else {
        iva = 0;
        $('#iva').val(0);
    }

    total = parseFloat(subtotal + iva).toFixed(2);
    $('#totales').val(total);
    $('#rec_monto').val("$ " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#iva2').val("$ " + iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#total').val("$ " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
}
$('#check_isr').on('change', function() {
    var checkbox = document.getElementById('check_isr');
    var monto = parseFloat($('#price').val()); //subtotal
    var iva = 0;
    var tasa = 16;
    var total = 0;
    var isr = 0;
    var iva_reten = 0;
    if (checkbox.checked != true) {
        //console.log('No esta marcado');
        iva = parseFloat((monto * tasa) / 100);
        total = parseFloat(monto + iva).toFixed(2);
        $('#iva').val(iva);
        $('#totales').val(total);
        $('#iva_format').val(iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#iva2').val("$ " + iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#totales_format').val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#rec_monto').val("$ " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#total').val("$ " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        //$('#validation').formValidation('revalidateField', 'iva');
    } else {
        $('#check_iva').prop('checked', false);
        iva = parseFloat((monto * tasa) / 100);
        isr = parseFloat((monto * 10) / 100);
        //console.log("ISR: " + isr);
        iva_reten = parseFloat((iva * 2) / 3);
        //console.log("iva_reten: " + iva_reten);
        total = parseFloat(((monto + iva) - isr) - iva_reten).toFixed(2);
        $('#iva').val(iva);
        $('#totales').val(total);
        $('#iva_format').val(iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#iva2').val("$ " + iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#totales_format').val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#rec_monto').val("$ " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#total').val("$ " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        //$('#validation').formValidation('revalidateField', 'iva');
    }
});
$('#check_otros').on('change', function() {
    var checkbox = document.getElementById('check_otros');
    var monto = parseFloat($('#price').val());
    var iva = 0;
    var tasa = 16;
    var total = 0;
    if (checkbox.checked != true) {
        //console.log('No esta marcado');
        iva = parseFloat($('#iva').val());
        total = parseFloat($('#totales').val());
        $('#iva_format').val(iva);
        $('#iva2').val("$ " + iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#totales_format').val(total);
        $('#rec_monto').val("$ " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#total').val("$ " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#iva_format').show();
        $('#totales_format').show();
        $('#iva').hide();
        $('#totales').hide();
        $('#iva').prop("readonly", true);
        $('#totales').prop("readonly", true);
        //$('#validation').formValidation('revalidateField', 'iva');
    } else {
        //console.log('Esta marcado');
        $('#iva_format').hide();
        $('#totales_format').hide();
        $('#iva').show();
        $('#totales').show();
        $('#iva').prop("readonly", false);
        //$('#totales').prop("readonly", false);
        //$('#validation').formValidation('revalidateField', 'iva');
    }
});
$('#check_iva').on('change', function() {
    var checkbox = document.getElementById('check_iva');
    var monto = parseFloat($('#price').val());
    var iva = 0;
    var tasa = 16;
    var total = 0;
    if (checkbox.checked != true) {
        //console.log('no esta marcado');
        iva = parseFloat((monto * tasa) / 100);
        total = parseFloat(monto + iva).toFixed(2);
        $('#iva').val(iva);
        $('#iva_format').val(iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#iva2').val("$ " + iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#totales').val(total);
        $('#totales_format').val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#rec_monto').val("$ " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#total').val("$ " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        //$('#validation').formValidation('revalidateField', 'iva');
    } else {
        $('#check_isr').prop('checked', false);
        //console.log('esta marcado');
        $('#iva').val(0);
        $('#iva_format').val(0);
        $('#iva2').val("$ " + iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#totales').val(monto);
        $('#totales_format').val(monto.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#rec_monto').val("$ " + monto.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#total').val("$ " + monto.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        //$('#validation').formValidation('revalidateField', 'iva');
    }
});

$("#actualizar_solicitud").on('click', function() {
  var ordenDeCompra = $('#rec_order_purchase').val();
  var monto = parseFloat($('#price').val().replace(/,/g,""));
  var tasa = 16;
  var checkbox = document.getElementById('check_otros');
  var montoIVA, total;
  if (checkbox.checked != true) {
    montoIVA = parseFloat($('#iva_format').val().replace(/,/g,""));
    total = parseFloat($('#totales_format').val().replace(/,/g,""));
  } else {
    montoIVA = parseFloat($('#iva').val().replace(/,/g,""));
    total = parseFloat($('#totales').val().replace(/,/g,""));
  }
  //Monto, IVA (TASA), MontoIVA y total
  var concepto = $('#rec_description').val();
  var formaDePago = $('#rec_way_pay_edit').val();
  var banco = $('#rec_bank_edit').val();
  var cuenta = $('#rec_cuenta_edit').val();
  var clabe = $('#rec_clabe').val();
  var referencia = $('#rec_reference').val();
  var observacion = $('#rec_observation').val();
  var currency = $('#rec_coin').val();
  console.log("Enviar actualizaciones...");
  //console.log(montoIVA);
  //Subtotal ISR
  var token = $('input[name="_token"]').val();
  $.ajax({
      type: "POST",
      url: "/update_pay",
      data: { ordenDeCompra: ordenDeCompra, concepto: concepto, formaDePago: formaDePago, banco: banco, cuenta: cuenta, clabe: clabe, referencia: referencia,
        observacion: observacion, monto: monto, tasa: tasa, montoIVA: montoIVA, total: total, currency: currency, payment: payment, _token: token },
      success: function(data) {
          console.log(data);
          if (data === undefined || data.length === 0) {
            console.log("Pendiente...");
              swal({
                      title: "Operación abortada!",
                      text: "Error al actualizar intente otra vez :( ",
                      type: "error",
                      showCancelButton: false,
                      confirmButtonClass: "btn-danger",
                      confirmButtonText: "Continuar.!",
                      closeOnConfirm: true,
                      closeOnCancel: false
                  });
          } else {
              swal({
                      title: "Operación Completada!",
                      text: "Solicitud actualizada",
                      type: "success",
                      showCancelButton: false,
                      confirmButtonClass: "btn-danger",
                      confirmButtonText: "Continuar.!",
                      closeOnConfirm: true,
                      closeOnCancel: false
                  },
                  function(isConfirm) {
                      location.reload(true);
                  });
          }
      },
      error: function(data) {
          console.log('Error:', data);
          swal({
                  title: "Operación abortada!",
                  text: "Error al actualizar intente otra vez :( ",
                  type: "error",
                  showCancelButton: false,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Continuar.!",
                  closeOnConfirm: true,
                  closeOnCancel: false
              });
      }
  });
});

async function disable_buttons(status) {
    if(modificando && sitios <= 1) {
      console.log("Editando...");
      $('#rec_order_purchase').prop( "disabled", false);
      $('#rec_description').prop( "disabled", false);
      $('#rec_reference').prop( "disabled", false);
      $('#rec_observation').prop( "disabled", false);
      $('#iva_format').prop( "disabled", false);
      $('#price').prop( "disabled", false);
      $('.ivas').removeClass("d-none");
      $("#amountText").addClass("d-none");
      $("#rec_coin").removeClass("d-none");
      $('#actualizar_solicitud').removeClass("d-none");
      if($("#numfact").val() == "factura_pendiente") $("#actualizarFactura").removeClass("d-none");
      else $("#actualizarFactura").addClass("d-none");
      var token = $('input[name="_token"]').val();
      await $.ajax({
        type: "POST",
        url: "/get_coins",
        data: { _token : token },
        success: function (data){
          $('#rec_coin').empty();
          data.forEach(function(d) {
            $('#rec_coin').append("<option value="+d.id+">"+d.name+"</option>");
          });
          $("#rec_coin option:contains("+moneda+")").attr("selected", true);
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
      await $.ajax({
        type: "POST",
        url: "/edit_pay_ways",
        data: { _token : token },
        success: function (data){
          $('#rec_way_pay').addClass("d-none");
          $('#rec_way_pay_edit').removeClass("d-none");
          $('#rec_way_pay_edit').empty();
          data.forEach(function(d) {
            $('#rec_way_pay_edit').append("<option value="+d.id+">"+d.name+"</option>");
          });
          $("#rec_way_pay_edit option:contains("+$('#rec_way_pay').val()+")").attr("selected", true);
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
      await $.ajax({
        type: "POST",
        url: "/get_proveedor_banks",
        data: { pay_id: payment, _token : token },
        success: function (data){
          $('#rec_bank').addClass("d-none");
          $('#rec_bank_edit').removeClass("d-none");
          $('#rec_bank_edit').empty();
          data.forEach(function(d) {
            $('#rec_bank_edit').append("<option value="+d.id+">"+d.bank+"</option>");
            proveedor_id = d.proveedor_id;
          });
          $("#rec_bank_edit option:contains("+$('#rec_bank').val()+")").attr("selected", true);
          getCuentaClabe();
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
    } else {
      console.log("No se puede modificar / Pago realizado / Solicitud múltiple");
      $('#rec_order_purchase').prop( "disabled", true);
      $('#rec_description').prop( "disabled", true);
      $('#rec_reference').prop( "disabled", true);
      $('#rec_observation').prop( "disabled", true);
      $('#rec_way_pay').removeClass("d-none");
      $('#rec_way_pay_edit').addClass("d-none");
      $('#rec_bank').removeClass("d-none");
      $('#rec_bank_edit').addClass("d-none");
      $('#rec_cuenta').removeClass("d-none");
      $('#rec_cuenta_edit').addClass("d-none");
      $('.ivas').addClass("d-none");
      $('#iva_format').prop( "disabled", true);
      $('#price').prop( "disabled", true);
      $("#amountText").removeClass("d-none");
      $("#rec_coin").addClass("d-none");
      $('#actualizar_solicitud').addClass("d-none");
      $("#actualizarFactura").addClass("d-none");
    }
}

$('#rec_bank_edit').on('change', function() {
  getCuentaClabe();
});

function getCuentaClabe() {
  var id_bank = $('#rec_bank_edit').val();
  var id_prov = proveedor_id;
  var _token = $('input[name="_token"]').val();
  var datax;
  $.ajax({
      type: "POST",
      url: "/get_account_clabe",
      data: {
          data_one: id_prov,
          data_two: id_bank,
          _token: _token
      },
      success: function(data) {
        $('#rec_cuenta_edit').empty();
        $('#rec_cuenta').addClass("d-none");
        $('#rec_cuenta_edit').removeClass("d-none");
        if (data == null || data == '[]') {
            $('#rec_cuenta_edit').append('<option value="">Elegir...</option>');
        } else {
            datax = JSON.parse(data);
            if ($.trim(data)) {
                $.each(datax, function(i, item) {
                    $('#rec_cuenta_edit').append("<option value=" + item.id + ">" + item.cuenta + "</option>");
                });
                $("#rec_cuenta_edit option:contains("+$('#rec_cuenta').val()+")").attr("selected", true);
            }
            var id_account = $('#rec_cuenta_edit').val();
            getdataCuenta(id_account, _token);
        }
      },
      error: function(data) {
          console.log('Error:', data);
      }
  });
}

$('#rec_cuenta_edit').on('change', function(e) {
    var id = $(this).val();
    var _token = $('input[name="_token"]').val();
    getdataCuenta(id, _token);
});

function getdataCuenta(campoa, campob) {
    $.ajax({
        type: "POST",
        url: "/get_data_accw",
        data: {
            data_one: campoa,
            _token: campob
        },
        success: function(data) {
            if (data == null || data == '[]') {
                $('#rec_clabe').val('');
                if(tochange_account) {
                  tochange_account = false;
                } else {
                  $('#rec_reference').val('');
                }
            } else {
                if ($.trim(data)) {
                    datax = JSON.parse(data);
                    var currency = document.getElementById('rec_clabe');
                    currency.dataset.currency = datax[0].currency_id;
                    console.log("$" + currency.dataset.currency);
                    $('#rec_clabe').val(datax[0].clabe);
                    if(tochange_account) {
                      tochange_account = false;
                    } else {
                      $("#rec_reference").val(datax[0].referencia);
                    }
                    checkCurrency();
                } else {
                    $('#rec_clabe').val('');
                    $('#rec_reference').val('');
                }
            }
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
}

function data_basic_firmas(campoa, campob){
  $.ajax({
    type: "POST",
    url: "/view_gen_sol_firmas",
    data: { pay : campoa , _token : campob },
    success: function (data){

      if (data == null || data == '[]') {
          console.log('nada-statuses');
      }
      else {
        if ($.trim(data)){
          datax = JSON.parse(data);
          $("#rec_name_elaboro").text(datax[0].nombre1);
          $("#rec_name_reviso").text(datax[0].nombre2);
          $("#rec_name_auth").text(datax[0].nombre3);
          $("#rec_name_conf").text(datax[0].nombre4);
          // $("#rec_name_conf_del").text(datax[0].nombre5);
        }
        else{
          //$("#rec_observation").text('No disponible.');
        }
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

//Funcionalidad para convertir numero a letras

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

function checkCurrency() {
    var coinBank;
    var coinId;
    var option;
    var coinselect = document.getElementById('rec_coin');
    var inputclabe = document.getElementById('rec_clabe');
    coinId = coinselect.value;
    coinBank = inputclabe.dataset.currency;
    if (coinBank != coinId) {
        for (var i = 0; i < coinselect.options.length; i++) {
            option = coinselect.options[i];
            if (option.value == coinBank) {
                option.setAttribute('selected', true);
            } else {
                option.removeAttribute('selected');
            }
        }
    } else {
        $("#rec_coin").parent().parent().removeClass('has-error');
        $("#rec_coin").parent().parent().addClass('has-sucess');
    }
}

function modalPendiente() {
    $('#modal-view-concept').modal('toggle');
    $('#modalActualizarFactura').modal('toggle');
    $('#info_fact_pend').val(payment);
    $.ajax({
      type: "POST",
      url: "/get_data_fact_by_drive",
      data: { data_one : payment, _token : $('input[name="_token"]').val() },
      success: function (data){
        datax = JSON.parse(data);
        if (datax == null || datax == '[]') {
          $('#validation_modal_fact').find('input:text').val('');
          $('#validation_modal_fact').find('input:file').val('');
          $('input[name="info_nofact"]').prop("readonly", true);
        }
        else {
            $("#info_proveedor").val(datax[0].folio);
            $("#info_cantidad").val(datax[0].monto_str);
            $("#info_orden").val(datax[0].concept_pay);
            // $("#info_nofact").val(datax[0].date_solicitude);
            $("#info_nofact").val(datax[0].factura);
            $('input[name="info_nofact"]').prop("readonly", false);
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
};

$("#validation_modal_fact").validate({
    ignore: '*:not([name])', //Fixes your name issue
    rules: {
      file_pdf: {
        extension: 'pdf',
      },
      file_xml: {
        extension: 'xlsx',
      },
    },
    messages: {

    },
    debug: true,
    errorElement: "label",
    errorPlacement: function(error, element) {
      console.log(element);
      if (element[0].id === 'file_pdf') {
        error.insertAfter($('#cont_1'));
      }
      else if (element[0].id === 'file_xml') {
        error.insertAfter($('#cont_2'));
      }
      else{
         error.insertAfter(element);
      }
    },
    submitHandler: function(form){
            Swal.fire({
              title: "Estás seguro?",
              text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Continuar.!",
              cancelButtonText: "Cancelar.!",
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
      }).then((result) => {
        if (result.value) {
          // The AJAX
          var form = $('#validation_modal_fact')[0];
          var formData = new FormData(form);
          $.ajax({
            type: 'POST',
            url: "/add_fact_pend_by_drive",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
              datax = data;
              if (datax != '0') {
                $('#modalActualizarFactura').modal('toggle');
                Swal.fire("Operación Completada!", ":)", "success");
              }
              else {
                $('#modalActualizarFactura').modal('toggle');
                Swal.fire("Operación abortada", "Error al registrar intente otra vez :(", "error");
              }

              $("#validation_modal_fact")[0].reset();
              var validator = $( "#validation_modal_fact" ).validate();
              validator.resetForm();
            },
            error: function (data) {
              $('#modalActualizarFactura').modal('toggle');
              Swal.fire("Operación abortada", "Ningúna operación afectuada :)", "error");
            }
          });
        }//Fin if result.value
        else {
          $('#modalActualizarFactura').modal('toggle');
          Swal.fire("Operación abortada", "Ningúna operación afectuada :)", "error");
        }
      })

      /*----------------------------------------------------------------------*/
    }
});

$('.btn-export').on('click', function(){

    var _token = $('input[name="_token"]').val();

    var cc = $("#cc_key").val();
    var fecha_de_solicitud = $("#fecha_ini").text();
    var fecha_de_pago = $("#fecha_pay").text();
    var num_factura = $("#numfact").val();
    var orden_de_compra = $("#rec_order_purchase").val();
    var prioridad = $("#rec_priority").val();
    var folio = $("#folio").val();
    var proveedor = $("#rec_proveedor").val();
    var monto = $("#rec_monto").val();
    var monto_texto = $("#amountText").val();
    var valores_tabla = [];

    $("#rec_venues_table tbody tr").each(function(row, tr) {
      for(var i = 0; i < 7; i++) {
        valores_tabla.push($(tr).find('td:eq('+i+')').text());
      }
    });

    var concepto_de_pago = $("#rec_description").val();
    var forma_de_pago = $("#rec_way_pay").val();
    var banco = $("#rec_bank").val();
    var cuenta = $("#rec_cuenta").val();
    var clabe = $("#rec_clabe").val();
    var referencia = $("#rec_reference").val();
    var observaciones = $("#rec_observation").val();
    var subtotal = $("#subtotal").val();
    var iva = $("#iva2").val();
    var total = $("#total").val();

    $.ajax({
        type: "POST",
        url: "/export_pay",
        data: {
          prints: [cc, fecha_de_solicitud, fecha_de_pago, num_factura, orden_de_compra, prioridad, folio, proveedor, monto, monto_texto,
          concepto_de_pago, forma_de_pago, banco, cuenta, clabe, referencia, observaciones, subtotal, iva, total],
          tabla: valores_tabla,
          _token : _token
        },
        success: function (data) {
          var hiddenElement = document.createElement('a');
          hiddenElement.href = "data:application/pdf;base64," + data;
          hiddenElement.download = 'SOLICITUD DE PAGO.pdf';
          hiddenElement.click();
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });

    //GENERACIÓN DEL PDF ANTERIOR

    /*$("#captura_table_general").hide();

    $(".hojitha").css("border", "");
    html2canvas(document.getElementById("captura_pdf_general")).then(function(canvas) {
      var ctx = canvas.getContext('2d');
      ctx.rect(0, 0, canvas.width, canvas.height);
          var imgData = canvas.toDataURL("image/jpeg", 1.0);
          var correccion_landscape = 0;
          var correccion_portrait = 0;
          if(canvas.height > canvas.width) {
              var orientation = 'portrait';
              correccion_portrait = 1;
              correccion_landscape = 0;
              var imageratio = canvas.height/canvas.width;
          }
          else {
              var orientation = 'landscape';
              correccion_landscape = 0;
              correccion_portrait = 0;
              var imageratio = canvas.width/canvas.height;
          }
          if(canvas.height < 900) {
              fontsize = 16;
          }
          else if(canvas.height < 2300) {
              fontsize = 11;
          }
          else {
              fontsize = 6;
          }

          var margen = 0;//pulgadas

          // console.log(canvas.width);
          // console.log(canvas.height);

         var pdf  = new jsPDF({
                      orientation: orientation,
                      unit: 'in',
                      format: [16+correccion_portrait, (16/imageratio)+margen+correccion_landscape]
                    });

          var widthpdf = pdf.internal.pageSize.width;
          var heightpdf = pdf.internal.pageSize.height;
          pdf.addImage(imgData, 'JPEG', 0, margen, widthpdf, heightpdf-margen);
          pdf.save("Solicitud de pago.pdf");
          $(".hojitha").css("border", "1px solid #ccc");
          $(".hojitha").css("border-bottom-style", "hidden");
    });*/
  });

function createEventListener_filePdf () {
  const element = document.querySelector('[name="file_pdf"')
  element.addEventListener('change', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

    input.trigger('fileselect', [numFiles, label]);
    var input = $(this).parents('.input-group').find(':text'),
    log = numFiles > 1 ? numFiles + ' files selected' : label;

    if( input.length ) {
      input.val(log);
    } else {
        if( log ) alert(log);
    }
  });
}
function createEventListener_fileXml () {
  const element = document.querySelector('[name="file_xml"')
  element.addEventListener('change', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

    input.trigger('fileselect', [numFiles, label]);
    var input = $(this).parents('.input-group').find(':text'),
    log = numFiles > 1 ? numFiles + ' files selected' : label;

    if( input.length ) {
      input.val(log);
    } else {
        if( log ) alert(log);
    }
  });
}
