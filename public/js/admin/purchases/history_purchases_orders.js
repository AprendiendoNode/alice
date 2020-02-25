//Configuracion de x-editable jquery
$.fn.editable.defaults.mode = 'popup';
$.fn.editable.defaults.ajaxOptions = {type:'POST'};

var _token = $('input[name="_token"]').val();
const headers = new Headers({
    "Accept": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": _token
})


$(function() {
  //-----------------------------------------------------------
  moment.locale('es');
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
  //-----------------------------------------------------------
  $("#form").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    errorPlacement: function (error, element) {
        var attr = $('[name="'+element[0].name+'"]').attr('datas');      
          if(attr == 'date'){
            error.insertAfter($('#date'));
          }    
      },
      submitHandler: function(e){
        var form = $('#form')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/purchases/get-history-orders",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            table_orders(data, $("#tabla_productos"));
            if (typeof data !== 'undefined' && data.length > 0) {
              console.log(data.length);
            }
            else {

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
  $("#form input[name='date']").daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      locale: {
          format: 'DD-MM-YYYY'
      },
      autoUpdateInput: false
  }, function (chosen_date) {
      $("#form input[name='date']").val(chosen_date.format('DD-MM-YYYY'));
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
});

function table_orders(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_orders);
  vartable.fnClearTable();
  
  $.each(datajson, function(index, information){
    let dropdown = `<div class="btn-group">
                      <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item" target="_blank" href="/purchases/print-order-purchase/${information.id}/${information.order_cart_id}" ><span class="far fa-file-pdf"></span> Imprimir orden</a>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_order(${information.id})" data-id="${information.id}"><span class="fas fa-window-close"></span> Eliminar orden</a>
                      </div>
                    </div>`;    
    
    vartable.fnAddData([
      information.id,
      dropdown,
      information.fecha,
      information.num_order,
      information.provider,
      format_number(parseFloat(information.total)),
      `<a href="javascript:void(0)" data-type="select" data-pk="${information.id}" data-title="Estatus" data-value="${information.order_status_id}" class="set-status-order">`,
      information.date_delivery,    
      information.order_address
    ]);
  });
}

/**************************ELIMINANDO POLIZAS***********************************/
function delete_order(id_order){
    
  let _token = $('input[name="_token"]').val();
  let data = {
    id: id_order
  };

  Swal.fire({
    title: "¿Estás seguro?",
    text: "Se eliminara esta orden de compra",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Confirmar',
    cancelButtonText: 'Cancelar',
    showLoaderOnConfirm: true,
    preConfirm: () => {
         
      const headers = new Headers({        
         "Accept": "application/json",
         "X-Requested-With": "XMLHttpRequest",
         'Content-Type': 'application/json',
         "X-CSRF-TOKEN": _token
      })

      var miInit = { method: 'post',
                         headers: headers,
                         credentials: "same-origin",
                         body: JSON.stringify(data),
                         cache: 'default' };

       return fetch('/purchases/delete-order-purchase', miInit)
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
    console.log(result.value);
    if (result.value == "1") {
      Swal.fire({
        title: 'Orden eliminada',
        text: "",
        type: 'success',
      }).then(function (result) {
        if (result.value) {
          window.location = "/purchases/view_history_order_purchases";
        }
      })
    }else if(result.value == "2"){
      Swal.fire('No tienes permiso para borrar ordenes de compra', 'Contacte a su administrador', 'error');
    }else{
      Swal.fire(
        'No se cancelo la orden de compra','','warning'
      )
    }
  })

}

function setStatusOrder(id, status){
  var _token = $('input[name="_token"]').val();
  $.ajax({
      type: "POST",
      url: "/purchases/set-status-order",
      data: { id : id, status : status, _token : _token },
      success: function (data){
        console.log(data);
        if(data.status == 200){
          menssage_toast('Mensaje', '3', 'Estatus actualizado' , '2000');
        }else{
          menssage_toast('Error', '2', 'Ocurrio un error inesperado' , '3000');
        }
      },
      error: function (data) {
        console.log('Error:', data);
        menssage_toast('Error', '2', 'Ocurrio un error inesperado' , '3000');
      }
  });
}

/**********************************************************************************/

var Configuration_table_orders = {
  "order": [[ 2, "desc" ]],
  "select": false,
  "aLengthMenu": [[10, 25, -1], [10, 25, "All"]],
  "fnDrawCallback": function() {
    var source = [{'value': 1, 'text': 'Nuevo'}, {'value': 2, 'text': 'Enviado a proveeedor'}];
    $('.set-status-order').editable({
        type : 'text',
        source: function() {
        return source;
      },
      success: function(response, newValue) {
        var id = $(this).data('pk');
        setStatusOrder(id, newValue);
      }
    });
  },
  "columnDefs": [
    {
      "targets": 0,
      "checkboxes": {
        'selectRow': true
      },
      "width": "0.1%",
      "createdCell": function (td, cellData, rowData, row, col){
        
      },  
      "className": "text-center",
      "visible": false,
    },
    {
      "targets": 1,
      "width": "1.0%",
    },
    {
      "targets": 2,
      "width": "1.0%",
      "className": "text-center",
    },
    {
      "targets": 3,
      "width": ".5%",
      "className": "text-center"
    },
    {
      "targets": 4,
      "width": "1.0%",
    },
    {
      "targets": 5,
      "width": ".5%",
      "className": "text-center",
    },
    {
      "targets": 6,
      "width": "1.0%",
      "className": "text-center",
    },
    {
      "targets": 7,
      "width": "1.0%",
    },
    {
      "targets": 8,
      "width": "1.0%",
    }
  ],
  dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    
    buttons: [
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
            columns: [ 2, 3, 4, 5, 6]
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
          columns: [ 2, 3, 4, 5, 6]
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

//Formato numerico: 00,000.00
function format_number(number){
    return number.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function remove_commas(number){
  return number.replace(/,/g, "");
}


