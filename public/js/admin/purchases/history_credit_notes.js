var quill;
$(function() {
  moment.locale('es');

  const startOfMonth = moment().startOf('month').format('YYYY-MM');
  $('#filter_date_from').val(startOfMonth);
  $('#filter_date_from').datepicker({
    language: 'es',
    orientation: "bottom left",
    format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months",
    endDate: '1m',
    autoclose: true,
    clearBtn: true,
  });
  if ($("#message").length) {
      quill = new Quill('#message', {
      modules: {
        toolbar: [
          [{
            header: [1, 2, false]
          }],
          ['bold', 'italic', 'underline'],
          // ['image', 'code-block']
        ]
      },
      placeholder: 'Ingresé su mensaje...',
      theme: 'snow' // or 'bubble'
    });
  }
  $("#filter_customer_id").select2({ width: '90%' });

  //-----------------------------------------------------------
  $("#form").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    errorPlacement: function (error, element) {
        var attr = $('[name="'+element[0].name+'"]').attr('datas');
        if (element[0].id === 'fileInput') {
          error.insertAfter($('#cont_file'));
        }
        else {
          if(attr == 'filter_date_from'){
            error.insertAfter($('#date_from'));
          }
          else if (attr == 'filter_date_to'){
            error.insertAfter($('#date_to'));
          }
          else {
            error.insertAfter(element);
          }
        }
      },
      rules: {

      },
      messages: {
      },
      // debug: true,
      // errorElement: "label",
      submitHandler: function(e){
        var form = $('#form')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/purchases/credit-notes-history-search",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            table_filter(data, $("#table_filter_fact"));
          },
          error: function (err) {
            Swal.fire({
               type: 'error',
               title: 'Oops...',
               text: err.statusText,
             });
          }
        });
      }
  });
  //-----------------------------------------------------------
});

function table_filter(datajson, table){
table.DataTable().destroy();
var vartable = table.dataTable(Configuration_table_responsive_doctypes);
vartable.fnClearTable();
$.each(JSON.parse(datajson), function(index, information){
  var status = information.status;
  var mail = information.mail_sent;
  var poliza = information.poliza;
  var contabilizado = information.contabilizado;

  var ELABORADO = 1; //ELABORADO
  var REVISADO = 2;  //REVISADO
  var AUTORIZADO = 3;//AUTORIZADO
  var CANCELADO = 4; //CANCELADO
  var CONCILIADA = 5; //Conciliada

  var html = "";

  if (parseInt(status) == ELABORADO) {
      html = '<span class="badge badge-primary">Elaborado</span>';
  } else if (parseInt(status) == REVISADO) {
      html = '<span class="badge badge-success">Revisado</span>';
  } else if (parseInt(status) == AUTORIZADO) {
      html = '<span class="badge badge-warning">Autorizado</span>';
  } else if (parseInt(status) == CANCELADO) {
      html = '<span class="badge badge-danger">Cancelado</span>';
  } else if (parseInt(status) == CONCILIADA) {
      html = '<span class="badge badge-dark">Conciliada</span>';
  }
  if (parseInt(mail) != 0) {
      mail_status = '<i class="fas fa-check text-success"></i>';
  }
  else {
    mail_status = '<i class="fas fa-times text-danger"></i>';
  }
  var a01 = '', a02 = '', a03 = '', a04 = '', a05 = '', a06 = '', a07 = '', a08 = '', a09 = '', a10 = '';

  a01 = '<div class="btn-group">';
  a02 = '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>';
  a03 = '<div class="dropdown-menu">';
  a04 = '<a class="dropdown-item" target="_blank" href="/purchases/credit-notes-history/'+information.id+'"><i class="fa fa-eye"></i> Ver</a>';

  // a05 = '<a class="dropdown-item" href="javascript:void(0);" onclick="link_send_mail(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-envelope"></i> Enviar correo electrónico</a>';
  /*
   if (parseInt(mail) == 0) {
     a06 = '<a class="dropdown-item" href="javascript:void(0);" onclick="mark_sent(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-hand-paper"></i> Marcar como enviada</a>';
   }
  if ( parseInt(poliza) != 1 ) {
    a07 = '<a class="dropdown-item" href="javascript:void(0);" onclick="mark_sent_poliza(this)" value="'+information.id+'" datas="'+information.name+'"><i class="fas fa-paper-plane"></i> Enviar a poliza</a>';
  }
  */
  if ( parseInt(status) != CANCELADO &&  parseInt(contabilizado) == 0 ) {
    a08 = '<div class="dropdown-divider"></div>';
    a09 = '<a class="dropdown-item" href="javascript:void(0);"  onclick="link_cancel(this)" value="'+information.id+'" datas="'+information.name+'"><i class="fas fa-trash-alt"></i> Cancelar</a>';
    a10 = '</div>';
  }
  var a11 = '</div>';

  var dropdown = a01+a02+a03+a04+a08+a09+a10+a11;

  if ( parseInt(contabilizado) != 0 ) {
    status_contabilizado = '<i class="fas fa-check text-success"></i>';
  }
  else {
    status_contabilizado = '<i class="fas fa-times text-danger"></i>';
  }
  vartable.fnAddData([
    information.id,
    dropdown,
    information.name,
    information.customers,
    information.date,
    information.currencies,
    information.amount_total,
    information.balance,
    mail_status,
    html,
    status_contabilizado,
    information.contabilizado,
    parseInt(status),
  ]);
});
}
var Configuration_table_responsive_doctypes = {
  "select": true,
  "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  "columnDefs": [
      {
        "targets": 0,
        "checkboxes": {
          'selectRow': true
        },
        "width": "0.1%",
        "createdCell": function (td, cellData, rowData, row, col){
          if ( cellData > 0 ) {
            if(rowData[11] == 1){
              this.api().cell(td).checkboxes.disable();
              $(td).parent().attr('style', 'background: #D6FFBE !important');
            }
          }
        },
        "className": "text-center",
      },
      {
          "targets": 1,
          "className": "text-center",
      },
      {
          "targets": 8,
          "className": "text-center",
      },
      {
          "targets": 10,
          "className": "text-center",
      },
      {
          "targets": 11,
          "className": "text-center",
          "visible": false,
          "searchable": false
      }
  ],
  dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    "order": [[ 3, "asc" ]],
  buttons: [
      {
        text: '<i class=""></i> Contabilizar',
        titleAttr: 'Contabilizar',
        className: 'btn bg-dark',
        init: function(api, node, config) {
          $(node).removeClass('btn-default')
        },
        action: function ( e, dt, node, config ) {
          var rows_selected = $("#table_filter_fact").DataTable().column(0).checkboxes.selected();
          var _token = $('input[name="_token"]').val();
          var facturas= new Array();
          $.each(rows_selected, function(index, rowId){
            facturas.push(rowId);
          });
          if ( facturas.length === 0){
            Swal.fire('Debe selecionar al menos una factura','','warning')
          }
          else {
            let _token = $('meta[name="csrf-token"]').attr('content');
            $("#tabla_asiento_contable tbody").empty();
            $.ajax({
                type: "POST",
                url: '/purchases/get_note_cred_mov_data_dev_desc',
                data: {facturas: JSON.stringify(facturas) , date:$('#filter_date_from').val(),  _token : _token},
                success: function (data) {

                  let suma_cargos = 0.0;
                  let suma_abonos = 0.0;

                  $('#data_asientos').html(data);

                  var req_date=$('#date_resive').val();
                  var inputDayDate = moment(req_date).format('DD');
                  var inputMonthDate = moment(req_date).format('MMMM');

                  $('#day_poliza').val(inputDayDate);
                  $('#mes_poliza').val(inputMonthDate);

                  $("#modal_view_poliza").modal("show");

                  $('.cuenta_contable').select2();
                },
                error: function (err) {
                  Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: err.statusText,
                    });
                }
            })
          }
        }
      },
      {
        extend: 'excelHtml5',
        title: 'Nota de credito compras',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
        titleAttr: 'Excel',
        className: 'btn btn-success btn-sm',
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4]
        },
      },
      {
        extend: 'csvHtml5',
        title: 'Nota de credito compras',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
        titleAttr: 'CSV',
        className: 'btn btn-primary btn-sm',
        exportOptions: {
          columns: [ 0, 1, 2, 3, 4]
        },
      }
  ],
  "processing": true,
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
    }
  }
};

function mark_sent_poliza(e) {
  var valor= e.getAttribute('value');
  var folio= e.getAttribute('datas');
  var _token = $('meta[name="csrf-token"]').attr('content');
  Swal.fire({
  title: '¿Estás seguro de enviar a poliza, la siguiente nota de credito '+folio+'?',
  html: '',
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Confirmar',
  cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.value) {
      $.ajax({
           type: "POST",
           url: '/purchases/credit-notes-history/poliza',
           data: {token_b : valor, _token : _token},
           success: function (data) {
             if(data.status == 200){
               Swal.fire('Operación completada!', '', 'success')
               .then(()=> {
                 location.href ="/purchases/credit-notes-history";
               });
             }
             else {
               Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text:  'La nota de credito '+folio+', no se envio a polizas.' + data.error,
                });
             }
           },
           error: function (err) {
             Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: err.statusText,
              });
           }
      });
    }
  });
}
//Marcar como cancelada
function link_cancel(e){
  var valor= e.getAttribute('value');
  var folio= e.getAttribute('datas');
  var _token = $('meta[name="csrf-token"]').attr('content');
  Swal.fire({
  title: '¿Estás seguro de cancelar la nota de credito '+folio+'?',
  html: "Esta acción no se podrá deshacer una vez confirmada la cancelación"+'<br>'+'<strong>Revertira la operación de poliza</strong>',
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Confirmar',
  cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.value) {
      $.ajax({
           type: "POST",
           url: '/purchases/credit-notes-history/destroy',
           data: {token_b : valor, _token : _token},
           success: function (data) {
             if(data.status == 200){
               Swal.fire('Operación completada!', '', 'success')
               .then(()=> {
                 location.href ="/purchases/credit-notes-history";
               });
             }
             else {
               Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text:  'La nota de credito '+folio+', se encuentra cancelada.' + data.error,
                });
             }
           },
           error: function (err) {
             Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: err.statusText,
              });
           }
      });
    }
  });
}
//Marcar como enviada
function mark_sent(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');
  var folio = e.getAttribute('datas');
    Swal.fire({
    title: '¿Estás seguro?',
    text: "Se marcara como enviada, la nota de credito con folio: "+folio,
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.value) {
        $.ajax({
             type: "POST",
             url: '/purchases/credit-notes-history/mark-sent',
             data: {token_b : valor, _token : _token},
             success: function (data) {
              if(data.status == 200){
                Swal.fire('Operación completada!', '', 'success')
                .then(()=> {
                  location.href ="/purchases/credit-notes-history";
                });
              }
              else {
                Swal.fire({
                   type: 'error',
                   title: 'Oops... Error: '+data.status,
                   text: 'El recurso no se ha modificado',
                });
              }
             },
             error: function (err) {
               Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: err.statusText,
                });
             }
         })
      }
    })
}
//Modal para envio de correo
function link_send_mail(e){
  var valor= e.getAttribute('value');
  var folio= e.getAttribute('datas');
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
       type: "POST",
       url: '/purchases/credit-notes-history/modal-send-mail',
       data: {token_b : valor, _token : _token},
       success: function (data) {
         $("#modal_customer_invoice_send_mail").modal("show");
         /*Quill editor*/
            var inicio = 'Le remitimos adjunta la siguiente nota de credito de compra:';
            var factura = 'Compra= '+data.customer_invoice.name;
            var cliente = 'Cliente= '+data.customer_invoice.customer.name;
            var fecha = 'Fecha = '+data.customer_invoice.date;
            $("#to").html('');

            quill.setContents([
                { insert: inicio, attributes: { bold: true } },
                { insert: '\n' },
                { insert: factura, attributes: { bold: false } },
                { insert: '\n' },
                { insert: cliente, attributes: { bold: false } },
                { insert: '\n' },
                { insert: fecha, attributes: { bold: false } },
                { insert: '\n' }
              ]);


         $("#modal_customer_invoice_send_mail .modal-body select[name='to\[\]']").select2({
             placeholder: "Ingresé correo electrónico",
             theme: "bootstrap",
             width: "auto",
             dropdownAutoWidth: true,
             language: "{{ str_replace('_', '-', app()->getLocale()) }}",
             tags: true,
             tokenSeparators: [',', ' '],
             data: data.to_selected[0]
         });
         $("#modal_customer_invoice_send_mail .modal-body select[name='to\[\]']").val(data.to_selected).trigger("change");
         $('#to option').each(function(){
                $(this).prop('selected', true);
          });
         //Archivos
         $("#modal_customer_invoice_send_mail .modal-body select[name='attach\[\]']").select2({
             placeholder: "Archivos",
             theme: "bootstrap",
             width: "auto",
             dropdownAutoWidth: true,
             language: "{{ str_replace('_', '-', app()->getLocale()) }}",
             disabled: true,
             data: data.files_selected
         });
         $("#modal_customer_invoice_send_mail .modal-body select[name='attach\[\]']").val(data.files_selected).trigger("change");

         $("#customer_invoice_id").val(data.customer_invoice.id);
         $("#fact_name").val(data.customer_invoice.name);
         $("#cliente_name").val(data.customer_invoice.customer.name);
         //Asunto
         $("#subject").val(data.customer_invoice.name);
       },
       error: function (err) {
         Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: err.statusText,
          });
       }
  })
}
$('#send_mail_button').on('click', function(){
  let _token = $('meta[name="csrf-token"]').attr('content');
  let form = $('#form_email_fact')[0];
  let formData = new FormData(form);
  const headers = new Headers({
           "Accept": "application/json",
           "X-Requested-With": "XMLHttpRequest",
           "X-CSRF-TOKEN": _token
         })

  let miInit = { method: 'post',
                    headers: headers,
                    body: formData,
                    credentials: "same-origin",
                    cache: 'default' };

  fetch('credit-notes-history-sendmail', miInit)
    .then(res => {
      return res.json();
    })
    .then(data => {
      if(data.code == 200){
        $('#modal_customer_invoice_send_mail').modal('toggle');
        // Swal.fire(data.message,'','success');
        Swal.fire('Operación completada!', '', 'success')
        .then(()=> {
          location.href ="/purchases/credit-notes-history";
        });
      }else{
        Swal.fire('Ocurrio un error inesperado',
        'Revise que los correos sean validos.',
        'error');
      }
    })
    .catch(error => {
      Swal.fire('Ocurrio un error inesperado','','error');
    })
})
//LOGICA DE MODAL
//Formato numerico: 00,000.00
function format_number(number){
  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function remove_commas(number){
  return number.replace(/,/g, "");
}
function check_totales_asientos(total_cargos,total_abonos){
  if(parseFloat(total_cargos) != parseFloat(total_abonos)){
    return false;
  }else{
    return true
  }
}
$("#form_save_asientos_contables").on('change','#type_poliza',function(){
  var type = $(this).val();
  let _token = $('meta[name="csrf-token"]').attr('content');
  if (type != '') {
    $.ajax({
         type: "POST",
         url: '/purchases/credit-notes-history/contador',
         data: {document_type : type, _token : _token},
         success: function (data) {
           $('#num_poliza').val(data);
         },
         error: function (err) {
           Swal.fire({
              type: 'error',
              title: 'Oops...',
              text: err.statusText,
            });
         }
    });
  }
  else {
    $('#num_poliza').val(0);
  }
});

$('#form_save_asientos_contables').on('submit', function(e){
  e.preventDefault();
  var data_A = $('#type_poliza').val();
  var data_B = $('#descripcion_poliza').val();
  if (data_A == '' || data_B == '' || $('.cuenta_contable').val().trim() === '') {
    $('#errores_element').show();
    if ( data_A == '' ) {
      $('#txt_a').show();
    }
    if ( data_B == '' ) {
      $('#txt_b').show();
    }
    if ( $('.cuenta_contable').val().trim() === '' ) {
      $('#txt_c').show();
    }
  }
  else{
    $('#errores_element').hide();
    $('#txt_a').hide();
    $('#txt_b').hide();
    $('#txt_c').hide();

    // e.preventDefault();
    let total_cargos = remove_commas($('#total_cargos').val());
    total_cargos = parseFloat(total_cargos);
    let total_abonos = remove_commas($('#total_abonos').val());
    total_abonos = parseFloat(total_abonos);
    if(check_totales_asientos(total_cargos, total_abonos)){
      //---------------------------------------------------
      Swal.fire({
        title: "¿Estás seguro?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          var _token = $('input[name="_token"]').val();
          var element = {}
          var asientos = [];
          $('#tabla_asiento_contable tbody tr').each(function(row, tr){
            let id_factura = $(tr).find('.id_factura').val();
            let cuenta_contable = $(tr).find('.cuenta_contable').val();
            let dia = $(tr).find('.dia').val();
            let tipo_cambio = $(tr).find('.tipo_cambio').val();
            let nombre = $(tr).find('.nombre').val();
            let cargo = $(tr).find('.cargos').val();
            let abono = $(tr).find('.abonos').val();
            let referencia = $(tr).find('.referencia').val();
            let fecha = $(tr).find('.fechita').val();
            element = {
              "factura_id" : id_factura,
              "cuenta_contable_id" : cuenta_contable,
              "dia" : dia,
              "tipo_cambio" : tipo_cambio,
              "nombre" : nombre,
              "cargo" : parseFloat(cargo),
              "abono" : parseFloat(abono),
              "referencia" : referencia,
              "fecha" : fecha
            }
            asientos.push(element);
          });
          let form = $('#form_save_asientos_contables')[0];
          let formData = new FormData(form);
          formData.append('movs_polizas',JSON.stringify(asientos));
          formData.append('total_cargos_format',total_cargos);
          formData.append('total_abonos_format',total_abonos);
          const headers = new Headers({
             "Accept": "application/json",
             "X-Requested-With": "XMLHttpRequest",
             "X-CSRF-TOKEN": _token
          })
          var miInit = { method: 'post',
                             headers: headers,
                             credentials: "same-origin",
                             body:formData,
                             cache: 'default' };
           return fetch('/purchases/customer_polizas_movs_save', miInit)
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
        if (result.value == 1) {
          Swal.fire({
            title: 'Poliza guardada',
            text: "",
            type: 'success',
          }).then(function (result) {
            if (result.value) {
              window.location = "/purchases/credit-notes-history";
            }
          })
        }
        else if (result.value == 2){
          Swal.fire(
            'El ejercicio se encuentra cerrado','','warning'
          )
        }else if (result.value == 3){
          Swal.fire(
            'El periodo se encuentra cerrado','','warning'
          )
        }else{
          Swal.fire(
            'El periodo se encuentra cerrado','','warning'
          )
        }
      })
      //---------------------------------------------------
    }
    else{
      Swal.fire(
        'Los totales no coinciden',
        'Revisar los saldos de los cargos y abonos',
        'warning'
      );
    }
  }
});

function suma_total_asientos(){
  let inputs_cargos = document.querySelectorAll('.cargos');
  let inputs_abonos = document.querySelectorAll('.abonos');
  let total_cargos = 0.0;
  let total_abonos = 0.0;

  for (i = 0; i < inputs_cargos.length; ++ i){
    total_cargos+= parseFloat(inputs_cargos[i].value);
  }

  for (i = 0; i < inputs_abonos.length; ++ i){
    total_abonos+= parseFloat(inputs_abonos[i].value);
  }

  $('#total_cargos').val(format_number(total_cargos));
  $('#total_abonos').val(format_number(total_abonos));

  if(check_totales_asientos(total_cargos,total_abonos)){
    $('#total_cargos').css('border-color', '#28a745');
    $('#total_abonos').css('border-color', '#28a745');
  }else{
    $('#total_cargos').css('border-color', '#dc3545');
    $('#total_abonos').css('border-color', '#dc3545');
  }
}
