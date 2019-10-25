function enviar(e){
  var element = e;
  var _token = $('input[name="_token"]').val();

  const headers = new Headers({
    "Accept": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": _token
  })

  var miInit = { method: 'get',
                    headers: headers,
                    credentials: "same-origin",
                    cache: 'default' };

  let id_documentp = element.dataset.id;
  let id_cart = element.dataset.cart;

  data_header(miInit, id_documentp);
  data_cotizador_objetivos(miInit, id_documentp);
  checks_approvals_propuesta(miInit, id_documentp);
  data_table_products(miInit, id_documentp, id_cart);
  $('#modal-view-concept').modal('show');

}

function send_mail_propuesta_comercial(e){
  var element = e;
  let id_documentp = element.dataset.id;
  var _token = $('input[name="_token"]').val();

  const headers = new Headers({
    "Accept": "application/json",
    'Content-Type': 'application/json',
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": _token
  })

  var miInit = { method: 'post',
                    headers: headers,
                    credentials: "same-origin",
                    body: JSON.stringify({id: id_documentp}),
                    cache: 'default' };  

  Swal.fire({
          title: "Confirmar envio de propuesta comercial",
          text: "",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Confirmar',
          cancelButtonText: 'Cancelar',
          showLoaderOnConfirm: true,
          preConfirm: () => {

             return fetch('/send_pdf_propuesta_comercial', miInit)
                   .then(function(response){
                     if (!response.ok) {
                        throw new Error(response.statusText)
                      }
                     return response.text();
                   })
                   .catch(function(error){
                     Swal.showValidationMessage(
                       `Request failed: ${error}`
                     )
                   });
          }//Preconfirm
        }).then((result) => {
          if (result.value) {
            var data = JSON.parse(result.value);
            console.log();
            Swal.fire({
              title: 'Correo enviado a',
              text: `${data.email}`,
              type: 'success',
            }).then(function (result) {
              
            })
          }else{
            Swal.fire(
              'Error al enviar correo','','error'
            )
          }
        })

}


function editar(e){
  var element = e;
  var _token = $('input[name="_token"]').val();
  let id_documentp = element.dataset.id;
  var form = $('#form_edit_docp');
  $('#id_docp2').val(id_documentp);

  form.submit();

}

function kickoff(e){
  var element = e;
  var _token = $('input[name="_token"]').val();
  let id_documentp = element.dataset.id;
  var form = $('#form_edit_kickoff');
  $('#id_doc_3').val(id_documentp);

  form.submit();

}

function data_header(miInit, id_documentp){

  fetch(`/documentp_header/data/${id_documentp}`,  miInit)
      .then(response => {
        return response.json();
      })
      .then(data => {
        console.log(data);
        if(data == null || data == '[]'){
          $('#tipo_doc').text('');
          $('#fecha').text('');
          $('#folio').text('');
          $('#itc').text('');
          $('#comercial').text('');
          $('#proyecto').text('');
          $('#vertical').text('');
          $('#tipo').text('');
          $('#instalacion').text('');
          $('#densidad').text('');
          $('#sitios').text('');
          $('#num_oportunidad').text('');
          $('#servicio_mensual').text('');
          $('#plazo').text('');
          $('#renta_anticipada').text('');
          $('#capex').text('');
        }else{
          $('#tipo_doc').text('Documento C');
          let nombre_proyecto = data[0].nombre_proyecto;
          nombre_proyecto == null ?   $('#proyecto').text(data[0].anexo) :  $('#proyecto').text(data[0].nombre_proyecto);
          $('#fecha').text(data[0].fecha);
          $('#folio').text(data[0].folio);
          $('#itc').text(data[0].ITC);
          $('#comercial').text(data[0].comercial);
          $('#vertical').text(data[0].vertical);
          $('#tipo').text(data[0].tipo_servicio);
          $('#instalacion').text(data[0].lugar_instalacion);
          $('#densidad').text(data[0].densidad);
          $('#sitios').text(data[0].sitios);
          $('#num_oportunidad').text(data[0].num_oportunidad);
          $('#servicio_mensual').text(data[0].servicio_mensual);
          $('#plazo').text(data[0].plazo);
          $('#renta_anticipada').text(data[0].renta_anticipada);
          $('#capex').text(data[0].capex);
           let id_documentp = data[0].id;
           document.getElementById('button_history').dataset.id = id_documentp;
        }
        

      })
      .catch(error => {
        console.log(error);
      })
}

function data_deny(miInit, id_documentp){

  fetch(`/documentp_header/data_deny/${id_documentp}`,  miInit)
      .then(response => {
        return response.json();
      })
      .then(data => {
        $('#observaciones').html('');
        if(data != null || data != '[]'){
          let html = `<ul>`;
          $.each(data, function( i, key ) {
            html +=`<li>` + key.name + ` - ` + key.description + ` - ` + key.created_at  + `</li`;
          })
          html +=`</ul>`;
          $('#observaciones').html(html);
        }else{

        }

      })
      .catch(error => {
        console.log(error);
      })
}

function data_table_products(miInit, id_documentp, id_cart){

  fetch(`/quoting_table_products/${id_documentp}/${id_cart}`,  miInit)
      .then(response => {
        return response.text();
      })
      .then(html => {
        $('#data_products').html(html);
      })
      .catch(error => {
        console.log(error);
      })
}

function checks_approvals_propuesta(miInit, id_documentp){

  fetch(`/get_approvals_propuesta_comercial/${id_documentp}`,  miInit)
      .then(response => {
        return response.text();
      })
      .then(html => {
        $('#checks_propuesta_comercial').html(html);
      })
      .catch(error => {
        console.log(error);
      })
}

function data_cotizador_objetivos(miInit, id_documentp){
  fetch(`/get_quoting_objetives/${id_documentp}`,  miInit)
      .then(response => {
        return response.json();
      })
      .then(data => {
        console.log(data);
        document.getElementById("utilidad_mensual").innerHTML = data[0].utilidad_mensual;
        document.getElementById("utilidad_proyecto").innerHTML = data[0].utilidad_proyecto;
        document.getElementById("utilidad_inversion").innerHTML = data[0].utilidad_inversion;
        document.getElementById("utilidad_3_anios").innerHTML = data[0].utilidad_3_anios;
        document.getElementById("utilidad_3_anios_percent").innerHTML = data[0].utilidad_3_anios_min;
        document.getElementById("renta_mensual_inversion").innerHTML = data[0].renta_mensual_inversion;
        document.getElementById("utilidad_renta").innerHTML = data[0].utilidad_renta_percent;
        document.getElementById("tiempo_retorno").innerHTML = data[0].tiempo_retorno;
        document.getElementById("vtc").innerHTML = data[0].vtc;
        document.getElementById("tir").innerHTML = data[0].tir;

        parametros_objetivos(data[0].renta_mensual_inversion, 
          data[0].utilidad_inversion, 
          data[0].tir, 
          data[0].utilidad_renta_percent,
          data[0].tiempo_retorno,
          data[0].utilidad_3_anios_min);
      })
      .catch(error => {
        console.log(error);
      })
}

function parametros_objetivos(percentRentaMensualInversion, percentUtilidadInversion, percentTir, percentUtilidadRenta, tiempoRetorno, utilidad3Minimo){

  let utilidad_3_anios_min = parseFloat(utilidad3Minimo);
  let utilidad_3_anios = parseFloat(document.getElementById('utilidad_3_anios').innerHTML);

  let renta_mensual_inversion_icon = document.getElementById('renta_mensual_inversion_icon');
  let utilidad_inversion_icon = document.getElementById('utilidad_inversion_icon');
  let utilidad_3_anios_percent_icon = document.getElementById('utilidad_3_anios_percent_icon');
  let utilidad_renta_icon = document.getElementById('utilidad_renta_icon');
  let tiempo_retorno_icon = document.getElementById('tiempo_retorno_icon');
  let tir_icon = document.getElementById('tir_icon');

  percentRentaMensualInversion >= 7.0 ? set_icons(renta_mensual_inversion_icon, true) : set_icons(renta_mensual_inversion_icon, false);

  percentUtilidadInversion >= 2.0 ? set_icons(utilidad_inversion_icon, true) : set_icons(utilidad_inversion_icon, false);

  parseFloat(utilidad_3_anios) >= utilidad_3_anios_min ? set_icons(utilidad_3_anios_percent_icon, true) : set_icons(utilidad_3_anios_percent_icon, false);

  percentUtilidadRenta >= 33.0 ? set_icons(utilidad_renta_icon, true) : set_icons(utilidad_renta_icon, false);

  tiempoRetorno <= 18 ? set_icons(tiempo_retorno_icon, true) : set_icons(tiempo_retorno_icon, false);

  percentTir >= 50.0 ? set_icons(tir_icon, true) : set_icons(tir_icon, false);

}

function set_icons(element, flag){
  element.className = '';
  flag == true ? element.classList.add('fa', 'fa-check', 'text-success') : element.classList.add('fa', 'fa-times', 'text-danger');
}

function show_logs(e){
  var element = e;
  var _token = $('input[name="_token"]').val();

  const headers = new Headers({
    "Accept": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": _token
  })

  var miInit = { method: 'get',
                    headers: headers,
                    credentials: "same-origin",
                    cache: 'default' };

  let id_documentp = element.dataset.id;

  data_table_logs(miInit, id_documentp);

  $('#modal-logs').modal('show');

}


function data_table_logs(miInit, id_documentp){

  fetch(`/documentp_table_logs/data/${id_documentp}`,  miInit)
      .then(response => {
        return response.json();
      })
      .then(data => {
        $("#table_documentp_logs tbody").empty();
        $.each(data, function( i, key ) {
          $('#table_documentp_logs tbody').append(
            '<tr><td>' + key.created_at + '</td><td>'
            + key.cantidad_anterior + '</td><td>'
            + key.cantidad_actual + '</td><td>'
            + key.descripcion + '</td><td>'
            + key.accion + '</td><td>'
            + key.usuario + '</td></tr>'
            );
         });
      })
      .catch(error => {
        console.log(error);
      })
}


var Configuration_table_responsive_logs= {
        "order": [[ 0, "desc" ]],
        "select": true,
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "columnDefs": [
            {
                "targets": 0,
                "width": "1%",
                "className": "text-center",
            },
            {
              "targets": 1,
              "width": "0.5%",
              "className": "text-center",
            },
            {
              "targets": 2,
              "width": "0.5%",
              "className": "text-right",
            },
            {
              "targets": 3,
              "width": "1.5%",
              "className": "text-right",
            },
            {
              "targets": 4,
              "width": "0.5%",
              "className": "text-right",
            },
            {
              "targets": 5,
              "width": "0.5%",
              "className": "text-right",
            }
        ],
        dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [

        ],
        language:{
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "<i class='fa fa-search'></i> Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
              "sFirst":    "Primero",
              "sLast":     "Último",
              "sNext":     "Siguiente",
              "sPrevious": "Anterior"
            },
            "oAria": {
              "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
              "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            'select': {
                'rows': {
                    _: "%d Filas seleccionadas",
                    0: "Haga clic en una fila para seleccionarla",
                    1: "Fila seleccionada 1"
                }
            }
        },
    };

    //Formato numerico: 00,000.00
function format_number(number){
  return number.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function remove_commas(number){
  return number.replace(/,/g, "");
}

    // FIX SCROLLBAR MODAL
    $(document).on('hidden.bs.modal', '.modal', function () {
        $('.modal:visible').length && $(document.body).addClass('modal-open');
    });
