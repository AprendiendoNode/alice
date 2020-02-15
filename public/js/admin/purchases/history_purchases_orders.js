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
                
                      </div>
                    </div>`;    
    
    vartable.fnAddData([
      information.id,
      dropdown,
      information.fecha,
      information.num_order,
      information.provider,
      format_number(parseFloat(information.total)),
      information.order_status,
      information.date_delivery,    
      information.order_address
    ]);
  });
}

var Configuration_table_orders = {
  "order": [[ 3, "asc" ]],
  "select": true,
  "aLengthMenu": [[10, 25, -1], [10, 25, "All"]],
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


