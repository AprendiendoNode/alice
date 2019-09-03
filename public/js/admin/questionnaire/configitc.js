$(function () {
  get_info_user();
  //-----------------------------------------------------------
  $("#form").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    errorPlacement: function (error, element) {
      },
      rules: {
      },
      messages: {
      },
      submitHandler: function(e){
        var form = $('#form')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/send_survey_mail",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            var message = data.success;
            $('#modal_customer_invoice_send_mail').modal('toggle');
            Swal.fire({
                type: 'success',
                title: 'Good job!',
                text: message,
              });
          },
          error: function (error, textStatus, errorThrown) {
            $('#modal_customer_invoice_send_mail').modal('toggle');
            if (error.status == 422) {
                var message = error.responseJSON.error;

                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: message,
                  });
            }
            else {
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText,
                  });
            }
          }
        });
      }
  });
  //-----------------------------------------------------------
});
function get_info_user(){
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: "/configure_survey_admin_sit_show",
      data: { _token : _token },
      success: function (data){
        table_config(data, $("#table_config"));
      },
      error: function (data) {
        console.log('Error:', data.statusText);
      }
  });
}

function table_config(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_pacs);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, information){
    var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Activo</span>';
    if (information.estatus_id == '2') {
      badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">Inactivo</span>';
    }

    var badgetwo = '<span class="badge badge-success badge-pill text-uppercase text-white">Contestada</span>';
    if (information.estatus_res == '1') {
      badgetwo= '<span class="badge badge-danger badge-pill text-uppercase text-white">No contestada</span>';
    }
    var option_a ='<a href="javascript:void(0);" onclick="link_send_mail(this)" datas="'+information.email+'" class="btn btn-info  btn-sm" value="'+information.id+'"><i class="far fa-share-square btn-icon-prepend fastable"></i> Reenviar Mail</a>';
    var option_b ='<a href="javascript:void(0);" onclick="view_hotel(this)" datas="'+information.user_id+'" class="btn btn-warning  btn-sm" value="'+information.id+'"><i class="fas fa-search btn-icon-prepend fastable"></i> Ver Hotel</a>';
    var union = option_a + option_b;
    vartable.fnAddData([
      information.user,
      information.email,
      badge,
      badgetwo,
      information.fecha_corresponde,
      information.fecha_inicial,
      information.fecha_fin,
      union
    ]);
  });
}

var Configuration_table_responsive_pacs = {
  dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        title: 'Encuestados',
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
        title: 'Encuestados',
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

//Modal para envio de correo
function link_send_mail(e){
  var valor= e.getAttribute('value');
  var email= [e.getAttribute('datas')];
  var _token = $('meta[name="csrf-token"]').attr('content');
  $("#modal_customer_invoice_send_mail").modal("show");
  //Correos para
  $("#modal_customer_invoice_send_mail .modal-body select[name='to\[\]']").select2({
    placeholder: "@lang('general.text_select')",
    theme: "bootstrap",
    width: "auto",
    dropdownAutoWidth: true,
    language: "{{ str_replace('_', '-', app()->getLocale()) }}",
    tags: true,
    disabled: true,
    tokenSeparators: [',', ' '],
      data: email
  });
  $("#modal_customer_invoice_send_mail .modal-body select[name='to\[\]']").val(email).trigger("change");
  //Correos para
  $("#modal_customer_invoice_send_mail .modal-body select[name='attach\[\]']").select2({
      placeholder: "Mail",
      theme: "bootstrap",
      width: "auto",
      dropdownAutoWidth: true,
      language: "{{ str_replace('_', '-', app()->getLocale()) }}",
      tags: true,
      tokenSeparators: [',', ' '],
  });
  $('#tken_b').val(valor);
}

function view_hotel(e){
  var valor= e.getAttribute('value');
  var user= e.getAttribute('datas');
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
       type: "POST",
       url: '/search_hotel_u',
       data: {token_b : user, _token : _token},
       success: function (data) {
         if (data != '') {
           var x='';
           $.each(JSON.parse(data), function(index, status){
             x=x+status.Nombre_hotel+'\n';
           });
           $('#message_site').val(x);
           $('#message_site').prop('disabled', true);
           $('#modal_customer_nps').modal('show');
         }
         else {
           $('#message_site').val('');
           $('#message_site').prop('disabled', true);
           $('#modal_customer_nps').modal('show');
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
