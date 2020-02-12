var quill;
$(function() {
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
  $("#filter_status").select2({ width: '80%' });
  $("#form input[name='filter_date_from']").daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      locale: {
          format: 'DD-MM-YYYY'
      },
      autoUpdateInput: false
  }, function (chosen_date) {
      $("#form input[name='filter_date_from']").val(chosen_date.format('DD-MM-YYYY'));
  });
  $("#form input[name='filter_date_to']").daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      locale: {
          format: 'DD-MM-YYYY'
      },
      autoUpdateInput: false,
  }, function (chosen_date) {
      $("#form input[name='filter_date_to']").val(chosen_date.format('DD-MM-YYYY'));
  });
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
            // if (typeof data !== 'undefined' && data.length > 0) {
            //   console.log(data.length);
            // }
            // else {
            //
            // }
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

  a05 = '<a class="dropdown-item" href="javascript:void(0);" onclick="link_send_mail(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-envelope"></i> Enviar correo electrónico</a>';

  if (parseInt(mail) == 0) {
    a06 = '<a class="dropdown-item" href="javascript:void(0);" onclick="mark_sent(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-hand-paper"></i> Marcar como enviada</a>';
  }
  if ( parseInt(poliza) != 1 ) {
    a07 = '<a class="dropdown-item" href="javascript:void(0);" onclick="mark_sent_poliza(this)" value="'+information.id+'" datas="'+information.name+'"><i class="fas fa-paper-plane"></i> Enviar a poliza</a>';
  }
  if ( parseInt(status) != CANCELADO ) {
    a08 = '<div class="dropdown-divider"></div>';
    a09 = '<a class="dropdown-item" href="javascript:void(0);"  onclick="link_cancel(this)" value="'+information.id+'" datas="'+information.name+'"><i class="fas fa-trash-alt"></i> Cancelar</a>';
    a10 = '</div>';
  }
  var a11 = '</div>';

  var dropdown = a01+a02+a03+a04+a05+a06+a07+a08+a09+a10+a11;

  vartable.fnAddData([
    dropdown,
    information.name,
    information.customers,
    information.date,
    information.currencies,
    information.amount_total,
    information.balance,
    mail_status,
    html
  ]);
});
}
var Configuration_table_responsive_doctypes = {
  "columnDefs": [
      {
          "targets": 1,
          "className": "text-center",
      }
  ],
  dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    "order": [[ 3, "asc" ]],
    buttons: [

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
