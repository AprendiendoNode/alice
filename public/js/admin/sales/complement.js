$(function(){
  //Inicializamos el date picker con sus configuraciones para la fecha actual con la que se va a timbrar
  $("#form input[name='date']").daterangepicker({
     //container:'#ModalDataDif',
      singleDatePicker: true,
      timePicker: true,
      timePicker24Hour: true,
      showDropdowns: true,
      minDate: moment(),
      //maxDate : moment().add(3, 'days'),
      locale: {
          format: "DD-MM-YYYY HH:mm:ss"
      },
      autoUpdateInput: true
  }, function (chosen_date) {
      $("#form input[name='date']").val(chosen_date.format("DD-MM-YYYY HH:mm:ss"));
  });

  $( "#ModalDataDif" ).scroll(function() {
      $("#form input[name='date']").datepicker('place')
  });

  get_complements();//Obtenemos todos las facturas con saldos pendientes

  function get_complements(){
    var _token = $('input[name="_token"]').val();

    $.ajax({
      type: "POST",
      url: "get_data_complements",
      data: { _token : _token},
      success: function (data){
        //console.log(data);
        table_complements(data,$('#table_complements'));
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });

  }

  //LLenamos la tabla con las facturas
  function table_complements(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_responsive_complement);
    vartable.fnClearTable();

    $.each(datajson, function(index, status){
      vartable.fnAddData([
        status.customer_invoice_id,
        status.name,
        status.date_due,
        status.uuid,
        status.customers,
        status.currencies,
        status.total,
        status.saldo,
      ]);
    });
  }
  var Configuration_table_responsive_complement={
    "select": true,
    "columnDefs": [
      { //Subida 1
        "targets": 0,
        "checkboxes": {
          'selectRow': true
        },
        "width": "1%",
      },
      {
        "targets": 1,
        "width": "1%",
        "className": "text-center fix-colums",
      },
      {
        "targets": 2,
        "width": "1%",
        "className": "text-center fix-colums",
      },
      {
        "targets": 3,
        "width": "1%",
        "className": "text-center fix-columns",
      },
      {
        "targets": 4,
        "width": "1%",
        "className": "text-center fix-columns",
      },
      {
        "targets": 5,
        "width": "0.2%",
        "className": "text-center fix-columns",
      },
      {
        "targets": 6,
        "width": "0.2%",
        "className": "text-center fix-columns",
      },
      {
        "targets": 7,
        "width": "0.2%",
        "className": "text-center fix-columns",
      }
    ],
    "select": {
      'style': 'multi',
    },
    dom:  "<'row'<'col-sm-6'B><'col-sm-2'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
    {
      text: '<i class="fa fa-check margin-r5"></i> Crear Pago',
      titleAttr: 'Crear Pago',
      className: 'btn btn-sm bg-dark m-1',
      init: function(api, node, config) {
         $(node).removeClass('btn-default')
      },
        action: function ( e, dt, node, config ) {
            //alert( 'Button activated' );
            var rows_selected = $("#table_complements").DataTable().column(0).checkboxes.selected();
            var _token = $('input[name="_token"]').val();

            var valores= new Array();//Creamos un array con los id
            $.each(rows_selected, function(index, rowId){
                //alert( rowId);
               valores.push(rowId);
           });
           if ( valores.length === 0){
             Swal.fire("Operación abortada", "Ninguna fila seleccionada :(", "error");
           }else{
             $('#ModalDataDif').modal('show');
           }


        }
    },
    {
      extend: 'excelHtml5',
      text: '<i class="fas fa-file-excel"></i> Excel',
      titleAttr: 'Excel',
      title: function ( e, dt, node, config ) {
        return 'Reporte.';
      },
      init: function(api, node, config) {
         $(node).removeClass('btn-default')
      },
      exportOptions: {
          columns: [ 1,2,3,4,5,6],
          modifier: {
              page: 'all',
          }
      },
      className: 'btn btn-success btn-sm m-1',
    },
    {
      extend: 'csvHtml5',
      text: '<i class="fas fa-file-csv"></i> CSV',
      titleAttr: 'CSV',
      title: function ( e, dt, node, config ) {
        return 'Reporte.';
      },
      init: function(api, node, config) {
         $(node).removeClass('btn-default')
      },
      exportOptions: {
          columns: [ 1,2,3,4,5,6],
          modifier: {
              page: 'all',
          }
      },
      className: 'btn btn-info btn-sm m-1',
    },
    {
      extend: 'pdf',
      orientation: 'landscape',
      text: '<i class="fas fa-file-pdf"></i>  PDF',
      title: function ( e, dt, node, config ) {
        return 'Reporte.';
      },
      init: function(api, node, config) {
         $(node).removeClass('btn-default')
      },
      exportOptions: {
          columns: [ 1,2,3,4,5,6],
          modifier: {
              page: 'all',
          }
      },
      className: 'btn btn-danger btn-sm m-1',
    }
    ],
    "order": [[ 0, "asc" ]],
    paging: true,
    //"pagingType": "simple",
    Filter: true,
    searching: true,
    "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
    //ordering: false,
    //"pageLength": 5,
    bInfo: false,
        language:{
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
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

  //Cuando el tipo de moneda cambie en el modal se le asiga 1 o en dado caso el tipo de cambio actual
  $('#currency_id').on("change", function(){
    var valor = $(this).val();
    var token = $('input[name="_token"]').val();
    if (valor === '1') {
      $('#currency_value').val('1');
    }else{
      $.ajax({
          url: "/sales/customer-invoices/currency_now",
          type: "POST",
          // dataType: "JSON",
          data: { _token : token, id_currency: valor },
          success: function (data) {
            console.log(data);
            $('#currency_value').val(data);
          },
          error: function (error, textStatus, errorThrown) {
              if (error.status == 422) {
                  var message = error.responseJSON.error;
                  $("#general_messages").html(alertMessage("danger", message));
              } else {
                  alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
              }
          }
      });
    }
  });
});
