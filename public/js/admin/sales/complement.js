$(function(){

  var json_data;

  //Inicializamos el date picker con sus configuraciones para la fecha actual con la que se va a timbrar
  $("#form_c input[name='date']").daterangepicker({
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
      $("#form_c input[name='date']").val(chosen_date.format("DD-MM-YYYY HH:mm:ss"));
  });

  $( "#ModalDataDif" ).scroll(function() {
      $("#form_c input[name='date']").datepicker('place')
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

    json_data = datajson;

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
  //Esta configuracion solo sirve para la tabla de facturas de la vista, NO REUTILIZAR
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

            var i = 0;
             var selected_complements = json_data.filter(function (data) {
               if(data.customer_invoice_id == valores[i]) {
                 i++;
                 return data.customer_invoice_id;
               }
             });

             //console.log(selected_complements);
             $('#ModalDataDif').modal('show');
             fillSelected(selected_complements,$('#table_selected_complements'));

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

var datafactura=[];
  function fillSelected(data,table){//Llena la tabla del modal con las facturas seleccionadas
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table);
    vartable.fnClearTable();

    $.each(data, function(index, status){
      vartable.fnAddData([
        status.customer_invoice_id,
        status.name,
        status.date_due,
        status.uuid,
        status.customers,
        status.currencies,
        '<input id="" type="number" class="input-sm" step="0.01" name="" value="">',
        //status.total,
        //status.saldo,
      ]);
      datafactura[0]=data[0].customer_invoice_id;
      datafactura[1]=data[0].date_due;
      datafactura[2]=data[0].customer_id;
      datafactura[3]=data[0].uuid;
    });

    $('#mount_total').val(data[0].total);
    $('#mount_saldo').val(data[0].saldo);




  }

  var Configuration_table = {
    //"select": true,
    "columnDefs": [
      { //Subida 1
        "targets": 0,
        "visible": false,
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
    ],
    /*"select": {
      'style': 'multi',
    },*/
    dom:  "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    "order": [[ 0, "asc" ]],
    paging: false,
    //"pagingType": "simple",
    Filter: false,
    searching: false,
    "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
    //ordering: false,
    //"pageLength": 5,
    buttons:[],
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

  $('#send_complement').on('click',function(){
    var _token = $('input[name="_token"]').val();
    var form = $('#form_c')[0];
    var formData = new FormData(form);
    formData.append("item_relation",datafactura[0]);
    formData.append("date_due","27-12-2019");
    formData.append("customer_id",datafactura[2]);



    $.ajax({
      type: "POST",
      url: "/sales/store_complement",
      data: formData ,
      contentType: false,
      processData: false,
      success: function (data){
        if (data == 'success') {
          let timerInterval;
          Swal.fire({
            type: 'success',
            title: 'La factura se ha generado con éxito!',
            html: 'Se estan aplicando los cambios.',
            timer: 2500,
            onBeforeOpen: () => {
              Swal.showLoading()
              timerInterval = setInterval(() => {
                Swal.getContent().querySelector('strong')
              }, 100)
            },
            onClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            if (
              // Read more about handling dismissals
              result.dismiss === Swal.DismissReason.timer
            ) {
              window.location.href = "/sales/customer-invoices-complement";
            }
          });
        }
        else {
          Swal.fire({
             type: 'error',
             title: 'Error encontrado..',
             text: 'Error al crear el  CFDI!',
           });
        }
        // console.log(data);
      },
      error: function (err) {
        Swal.fire({
           type: 'error',
           title: 'Oops...',
           text: err.statusText,
         });
      }
    });
    //
  });

});
