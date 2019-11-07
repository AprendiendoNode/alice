$(document).ready(function(){
  const startOfMonth = moment().startOf('month').format('DD/MM/YYYY');
  const endOfMonth   = moment().endOf('month').format('DD/MM/YYYY');
  $('#start').val(startOfMonth);
  $('#end').val(endOfMonth);

});

if ($().datepicker) {
    var isRtl = false;
    $(".input-daterange").datepicker({
       autoclose: true,
       rtl: isRtl,
       format: 'dd/mm/yyyy',
       orientation: "bottom left",
       language: 'es',
    });
}

$(function() {
  //-----------------------------------------------------------
  $("#search").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    errorPlacement: function (error, element) {
        var attr = $('[name="'+element[0].name+'"]').attr('datas');
        if (element[0].id === 'fileInput') {
          error.insertAfter($('#cont_file'));
        }
        else {
          if(attr == 'sel_desarrollo'){
            error.insertAfter($('#cont_desarrollo'));
          }
          else if(attr == 'sel_estatus'){
            error.insertAfter($('#cont_estatus'));
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
      submitHandler: function(e){
        busqueda();
        busqueda_dos();
      }
  });
  //-----------------------------------------------------------
});


//-Contract Not Venue ----------------------------------------------------------
function busqueda() {
  var form = $('#search')[0];
  var formData = new FormData(form);
  $.ajax({
    type: "POST",
    url: "/contract_expiration_notvenue",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data){
      fill_table_notvenue(data, $("#all_notvenue"));
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

function fill_table_notvenue(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_payment_tracking);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, information){
    var aa = '<a href="javascript:void(0);" onclick="getInvoiceContract(this)" data-file="' + information.file + '" class="btn btn-info btn-sm" role="button"><i class="fas fa-cloud-download-alt" aria-hidden="true"></i> Descargar..</a>';
    var ab = '<a href="javascript:void(0);" onclick="getInfoContract(this)" value="' + information.contract_master_id + '" class="btn btn-success  btn-sm" role="button"><i class="fas fa-info-circle" aria-hidden="true"></i> Contratos anexos..</a>';
    var ac = aa + ab;
    vartable.fnAddData([
      (index+1),
      information.key_annexes,
      information.classifications,
      information.vertical,
      information.cadena,
      information.key_master,
      information.itc,
      information.date_scheduled_end,
      ac
    ]);
  });
}


//-Contract Venue --------------------------------------------------------------
function busqueda_dos() {
  var form = $('#search')[0];
  var formData = new FormData(form);
  $.ajax({
    type: "POST",
    url: "/contract_expiration_venue",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data){
      fill_table_venue(data, $("#all_venue"));
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
function fill_table_venue(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_payment_tracking);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, information){
    var aa = '<a href="javascript:void(0);" onclick="getInvoiceContract(this)" data-file="' + information.file + '" class="btn btn-info btn-sm" role="button"><i class="fas fa-cloud-download-alt" aria-hidden="true"></i> Descargar..</a>';
    var ab = '<a href="javascript:void(0);" onclick="getInfoContract(this)" value="' + information.contract_master_id + '" class="btn btn-success  btn-sm" role="button"><i class="fas fa-info-circle" aria-hidden="true"></i> Contratos anexos..</a>';
    var ac = aa + ab;
    vartable.fnAddData([
      (index+1),
      information.key_annexes,
      information.classifications,
      information.vertical,
      information.cadena,
      information.key_master,
      information.itc,
      information.date_scheduled_end,
      ac
    ]);
  });
}

var Configuration_table_payment_tracking = {
  paging: true,
  //"pagingType": "simple",
  Filter: false,
  searching: false,
  "aLengthMenu": [[-1, 5, 10, 25], ["Todos los ", 5, 10, 25]],
  ordering: false,
    //"pageLength": 5,
  bInfo: false,
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

function getInvoiceContract(ev){
 var token = $('input[name="_token"]').val();
 var file =  $(ev).data('file');
 $.ajax({
   type: "POST",
   url: "/downloadInvoiceContract",
   data: { file : file , _token : token },
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
    }
    else{
      Swal.fire({
          type: 'error',
          title: 'Oops...',
          text: 'Este contrato no tiene un archivo adjunto',
        });
      }
    },
    error: function (response) {
    }
  });
}

function getInfoContract(e) {
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
       type: "POST",
       url: '/contract_expiration_info',
       data: {value : valor, _token : _token},
       success: function (data) {
         if (data != []) {
            $('#modal-Edit').modal('show');
            fill_table_anexos(data, $("#all_anexos"));
             $("#all_anexos").css('width', '100%');
             $('#all_anexos').DataTable().draw(true);
         }
         else {
           Swal.fire({
             type: 'error',
             title: 'Error encontrado..',
             text: 'Realice la operacion nuevamente!',
           });
         }
           //$('#modal-Edit').modal('show');
       },
       error: function (data) {
         alert('Error:', data);
       }
   })

}

function fill_table_anexos(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_anexosfilter);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, information){
    vartable.fnAddData([
      (index+1),
      information.key,
      information.date_signature, /*Fecha Firma de contrato:*/
      information.date_scheduled_start, /*Fecha Inicio de contrato(Programada):*/
      information.date_scheduled_end, /**/
      information.date_real /**/
    ]);
  });
}

var Configuration_table_anexosfilter = {
  "scrollY": 200,
  "scrollX": true,
  "aLengthMenu": [[5, 10, 25 , -1], [5, 10, 25, "Todos"]],
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
}
