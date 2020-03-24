$(function() {
  moment.locale('es');
  const startOfMonth = moment().startOf('month').format('YYYY-MM');
  //-----------------------------------------------------------
  if ($("#message").length) {
    quill = new Quill('#message', {
      modules: {
        toolbar: [
          [{
            header: [1, 2, false]
          }],
          ['bold', 'italic', 'underline'],
        ]
      },
      placeholder: 'Ingresé su mensaje...',
      theme: 'snow' // or 'bubble'
    });
  }
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
        url: "/sales/credit-notes-search",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data){
          if (typeof data !== 'undefined' && data.length > 0) {
            table_filter(data, $("#table_filter_fact"));
            // console.log(data.length);
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
  //-----------------------------------------------------------
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
  $("#filter_customer_id").select2();
  //-----------------------------------------------------------
});

function table_filter(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_doctypes);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, information){
    var status = information.status;
    var mail = information.mail_sent;
    var contabilizado = information.contabilizado;
    var html = "";

    if (parseInt(status) == OPEN) {
        html = '<span class="badge badge-info">'+text_status_open+'</span>';
    } else if (parseInt(status) == PAID) {
        html = '<span class="badge badge-primary">'+text_status_paid+'</span>';
    } else if (parseInt(status) == CANCEL) {
        html = '<span class="badge badge-secondary">'+text_status_cancel+'</span>';
    } else if (parseInt(status) == RECONCILED) {
        html = '<span class="badge badge-success">'+text_status_reconciled+'</span>';
    }

    if (parseInt(mail) != 0) {
        mail_status = '<i class="fas fa-check text-success"></i>';
    }
    else {
      mail_status = '<i class="fas fa-times text-danger"></i>';
    }
    var a01 = '', a02 = '', a03 = '', a04 = '', a05 = '', a06 = '', a07 = '', a08 = '', a09 = '', a10 = '', a11 = '', a12 = '', a13 = '';


    a01 = '<div class="btn-group">';
    a02 = '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>';
    a03 = '<div class="dropdown-menu">';
    a04 = '<a class="dropdown-item" target="_blank" href="/sales/customer-invoice-pdf/'+information.id+'"><i class="fa fa-eye"></i> '+button_show+'</a>';

    if ( parseInt(status) == OPEN || parseInt(status) == RECONCILED || parseInt(status) == CANCEL && information.uuid != ""  ) {
      a05 = '<a class="dropdown-item" href="/sales/customer-credit-notes/download-xml/'+information.id+'"><i class="far fa-file-code"></i> '+button_download_xml+'</a>';
      a06 = '<a class="dropdown-item" href="javascript:void(0);" onclick="link_send_mail(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-envelope"></i> '+button_send_mail+'</a>';
    }
    if (parseInt(mail) == 0) {
      a07 = '<a class="dropdown-item" href="javascript:void(0);" onclick="mark_sent(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-hand-paper"></i> '+text_mark_sent+'</a>';
    }
    if (parseInt(status) == RECONCILED) {
      a08 = '<a class="dropdown-item" href="javascript:void(0);" onclick="mark_open(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-hand-paper"></i> '+text_mark_open+'</a>';
    }
    if (parseInt(status) == OPEN) {
      a09 = '<a class="dropdown-item" href="javascript:void(0);" onclick="mark_reconciled(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-hand-paper"></i> '+text_mark_reconciled+'</a>';
    }
    if ( information.uuid != "" ) {
      a10 = '<a class="dropdown-item" href="javascript:void(0);" onclick="link_status_sat(this)" value="'+information.id+'" datas="'+information.name+'" ><i class="far fa-question-circle"></i> '+button_status_sat+'</a>';
    }
    if ( parseInt(status) != CANCEL ) {
      a11 = '<div class="dropdown-divider"></div>';
      a12 = '<a class="dropdown-item" href="javascript:void(0);"  onclick="link_cancel(this)" value="'+information.id+'" datas="'+information.name+'"><i class="fas fa-trash-alt"></i>'+button_cancel+'</a>';
      a13 = '</div>';
    }
    var a14 = '</div>';

    if ( parseInt(contabilizado) != 0 ) {
      status_contabilizado = '<i class="fas fa-check text-success"></i>';
    }
    else {
      status_contabilizado = '<i class="fas fa-times text-danger"></i>';
    }

    var dropdown = a01+a02+a03+a04+a05+a06+a07+a08+a09+a10+a11+a12+a13+a14;

    vartable.fnAddData([
      information.id,
      dropdown,
      status_contabilizado,
      information.name,
      information.date,
      information.uuid,
      information.customer,
      information.date_due,
      information.currency,
      information.amount_total,
      information.balance,
      mail_status,
      html,
      information.contabilizado,
      parseInt(status),
    ]);
  });
}

$('.table-responsive').on('show.bs.dropdown', function () {
     $('.table-responsive').css( "overflow", "inherit" );
});

$('.table-responsive').on('hide.bs.dropdown', function () {
     $('.table-responsive').css( "overflow", "auto" );
})

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
            if(rowData[13] == 1 || rowData[14] == 4){
              this.api().cell(td).checkboxes.disable();
              if(rowData[13] == 1){
                $(td).parent().attr('style', 'background: #D6FFBE !important');
              }
              if(rowData[14] == 4){
                $(td).parent().attr('style', 'background: #ff9090 !important');
              }
            }
          }
        },
        "className": "text-center",
      },
      {
          "targets": 10,
          "className": "text-center",
      },
      {
          "targets": 11,
          "className": "text-center",
      },
      {
          "targets": 2,
          "className": "text-center",
      },
      {
          "targets": 13,
          "className": "text-center",
          "visible": false,
          "searchable": false
      },
      {
          "targets": 14,
          "className": "text-center",
          "visible": false,
          "searchable": false
      }
  ],
  dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    "order": [[ 7, "asc" ]],
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
            Swal.fire('Debe selecionar al menos una nota de credito','','warning')
          }
          else {
            let _token = $('meta[name="csrf-token"]').attr('content');
            $("#tabla_asiento_contable tbody").empty();
            $('#errores_element').hide();

            $.ajax({
              type: "POST",
              url: '/sales/get_note_credit_mov_data_cfdi',
              data: {facturas: JSON.stringify(facturas) , date:$('#filter_date_from').val(),  _token : _token},
              success: function (data) {
                let suma_cargos = 0.0;
                let suma_abonos = 0.0;

                $('#data_asientos').html(data);

                var req_date=$('#date_resive').val();
                var inputDayDate = moment().format('DD');
                var inputMonthDate = moment(req_date).format('MMMM');

                $('#day_poliza').val(inputDayDate);
                $('#mes_poliza').val(inputMonthDate);

                $("#modal_view_poliza").modal("show");
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
        }
      },
      {
        extend: 'excelHtml5',
        title: 'Facturas',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
        titleAttr: 'Excel',
        className: 'btn btn-success btn-sm',
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
        },
      },
      {
        extend: 'csvHtml5',
        title: 'Facturas',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
        titleAttr: 'CSV',
        className: 'btn btn-primary btn-sm',
        exportOptions: {
          columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
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
             url: '/sales/customer-credit-notes/mark-sent',
             data: {token_b : valor, _token : _token},
             success: function (data) {
              if(data.status == 200){
                Swal.fire('Operación completada!', '', 'success')
                .then(()=> {
                  location.href ="/sales/credit-notes-history";
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
//Marcar como abierta
function mark_open(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');
  var folio = e.getAttribute('datas');
  Swal.fire({
    title: '¿Estás seguro?',
    text: "Se marcara como abierta, la nota de credito con folio: "+folio,
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
             url: '/sales/customer-credit-notes/mark-open',
             data: {token_b : valor, _token : _token},
             success: function (data) {
              if(data.status == 200){
                Swal.fire('Operación completada!', '', 'success')
                .then(()=> {
                  location.href ="/sales/credit-notes-history";
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
    });
}
//Marcar como reconciliado
function mark_reconciled(e) {
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');
  var folio = e.getAttribute('datas');
  Swal.fire({
    title: '¿Estás seguro?',
    text: "Se marcara como conciliada, la nota de credito con folio: "+folio,
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
             url: '/sales/customer-credit-notes/mark-reconciled',
             data: {token_b : valor, _token : _token},
             success: function (data) {
              if(data.status == 200){
                Swal.fire('Operación completada!', '', 'success')
                .then(()=> {
                  location.href ="/sales/credit-notes-history";
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
    });
}
//Modal para estatus de CFDI
function link_status_sat(e){
  var valor= e.getAttribute('value');
  var folio= e.getAttribute('datas');
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
       type: "POST",
       url: '/sales/customer-credit-notes/modal-status-sat',
       data: {token_b : valor, _token : _token},
       success: function (data) {
         $('#text_a').text(data.uuid);
         $('#text_b').text(data.folio);
         $('#text_e').text(data.text_is_cancelable_cfdi);
         $('#text_f').text(data.text_status_cfdi);
         $('#modal_customer_invoice_status_sat').modal('show');
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
//Cancelacion de CFDi
function link_cancel(e){
  var valor= e.getAttribute('value');
  var folio= e.getAttribute('datas');
  var _token = $('meta[name="csrf-token"]').attr('content');
  Swal.fire({
  title: '¿Estás seguro de cancelar la nota de credito '+folio+'?',
  html: "Esta acción no se podrá deshacer una vez confirmada la cancelación"+'<br>',
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
           url: '/sales/customer-credit-notes/destroy',
           data: {token_b : valor, _token : _token},
           success: function (data) {
             if(data.status == 200){
               Swal.fire('Operación completada!', '', 'success')
               .then(()=> {
                 location.href ="/sales/credit-notes-history";
               });
             }
             else if (data.status == 422){
               Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text:  'La nota de credito '+folio+','+' cuenta con poliza, para realizar esta acción necesitas eliminar primero la poliza generada',
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

//Modal para envio de correo
function link_send_mail(e){
  var valor= e.getAttribute('value');
  var folio= e.getAttribute('datas');
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
       type: "POST",
       url: '/sales/customer-credit-notes/modal-send-mail',
       data: {token_b : valor, _token : _token},
       success: function (data) {
         $("#modal_customer_invoice_send_mail").modal("show");
         /*Quill editor*/
            var inicio = 'Le remitimos adjunta la siguiente factura:';
            var factura = 'Factura= '+data.customer_invoice.name;
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
             placeholder: "@lang('general.text_select')",
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
             placeholder: "@lang('general.text_select')",
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
         // console.log(data.files);
         // console.log(data.files_selected);
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

  fetch('customer-invoices-sendmail-fact', miInit)
    .then(res => {
      return res.json();
    })
    .then(data => {
      if(data.code == 200){
        Swal.fire(data.message,'','success');
      }else{
        Swal.fire(data.message,'','error');
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
function check_totales_asientos(total_cargos,total_abonos){
  if(parseFloat(total_cargos) != parseFloat(total_abonos)){
    return false;
  }else{
    return true
  }
}
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


$('#form_save_asientos_contables').on('submit', function(e){
  e.preventDefault();
  var data_A = $('#type_poliza').val();
  var data_B = $('#descripcion_poliza').val();
  if (data_A == '' || data_B == '') {
    $('#errores_element').show();
    if ( data_A == '' ) {
      $('#txt_a').show();
    }
    if ( data_B == '' ) {
      $('#txt_b').show();
    }
  }
  else{
    $('#errores_element').hide();
    $('#txt_a').hide();
    $('#txt_b').hide();

    // e.preventDefault();
    let total_cargos = remove_commas($('#total_cargos').val());
    total_cargos = parseFloat(total_cargos);
    let total_abonos = remove_commas($('#total_abonos').val());
    total_abonos = parseFloat(total_abonos);
    if(check_totales_asientos(total_cargos, total_abonos)){

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
           return fetch('/sales/customer-polizas-save-movs-egresos', miInit)
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
        // console.log(result.value);
        if (result.value == "true") {
          Swal.fire({
            title: 'Poliza guardada',
            text: "",
            type: 'success',
          }).then(function (result) {
            if (result.value) {
              window.location = "/sales/credit-notes-history";
            }
          })
        }
        else{
          Swal.fire(
            'No se guardo la poliza','','warning'
          )
        }
      })
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




function save_poliza() {
  let total_cargos = remove_commas($('#total_cargos').val());
  total_cargos = parseFloat(total_cargos);
  let total_abonos = remove_commas($('#total_abonos').val());
  total_abonos = parseFloat(total_abonos);

  if(check_totales_asientos(total_cargos, total_abonos)){
    Swal.fire({
      title: "Estás seguro?",
      text: "",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: 'Confirmar',
      confirmButtonColor: '#3085d6',
      cancelButtonText: 'Cancelar',
      cancelButtonColor: '#d33',
    }).then((result) => {
    });
  }
  else{
    Swal.fire(
      'Los totales no coinciden',
      'Revisar los saldos de los cargos y abonos',
      'warning'
    );
  }
}
function save_poliza2() {
  let total_cargos = remove_commas($('#total_cargos').val());
  total_cargos = parseFloat(total_cargos);
  let total_abonos = remove_commas($('#total_abonos').val());
  total_abonos = parseFloat(total_abonos);

  if(check_totales_asientos(total_cargos, total_abonos)){
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
        var _token = $('meta[name="csrf-token"]').attr('content');
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
            "fecha" : fecha,
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

         return fetch('/accounting/customer-polizas-save-movs', miInit)
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
      // console.log(result.value);
      if (result.value == "true") {
        Swal.fire({
          title: 'Poliza guardada',
          text: "",
          type: 'success',
        }).then(function (result) {
          if (result.value) {
            // window.location = "/accounting/customer-polizas-show";
          }
        })
      }else{
        Swal.fire(
          'No se guardo la poliza','','warning'
        )
      }
    })
  }
  else{
    Swal.fire(
      'Los totales no coinciden',
      'Revisar los saldos de los cargos y abonos',
      'warning'
    );
  }
}
