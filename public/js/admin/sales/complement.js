$(function(){

  var json_data, monedas_iguales = [];

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

             var i = 0, entrar = true;
             monedas_iguales = [];
             clientes_iguales = [];

             var selected_complements = json_data.filter(function (data) {
               if(data.customer_invoice_id == valores[i]) {
                 if(i == 0) {
                   monedas_iguales.push(data.currencies);
                   clientes_iguales.push(data.customer_id);
                 } else if(monedas_iguales.indexOf(data.currencies) < 0) {
                   Swal.fire("Operación abortada", "Facturas con diferente moneda :(", "error");
                   entrar = false;
                 } else if(clientes_iguales.indexOf(data.customer_id) < 0) {
                   Swal.fire("Operación abortada", "Facturas con diferente cliente :(", "error");
                   entrar = false;
                 }
                 i++;
                 return data.customer_invoice_id;
               }
             });

             if(entrar) {
               //console.log(selected_complements);
               $('#ModalDataDif').modal('show');
               fillSelected(selected_complements,$('#table_selected_complements'));
               $('#currency_id').val(selected_complements[0].currency_id);
               $('#currency_id').change();
               $('#mount_pagado').val(0);
             }

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

var datafactura, datafactura_total, datafactura_saldo, cantidades_pagadas;

  function fillSelected(data,table){//Llena la tabla del modal con las facturas seleccionadas
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table);
    vartable.fnClearTable();

    datafactura = [];
    cantidades_pagadas = [];
    datafactura_total = 0;
    datafactura_saldo = 0;

    $.each(data, function(index, status){
      vartable.fnAddData([
        status.customer_invoice_id,
        status.name,
        status.date_due,
        status.uuid,
        status.customers,
        status.currencies,
        status.total,
        status.saldo,
        '<input id="cp-'+status.customer_invoice_id+'" class="pagada input-sm" type="number" step="0.01" name="">',
      ]);

      var rowfactura = [];

      rowfactura[0]=data[index].customer_invoice_id;
      rowfactura[1]=data[index].date_due;
      rowfactura[2]=data[index].customer_id;
      rowfactura[3]=data[index].uuid;
      rowfactura[4]=parseFloat(data[index].total);
      rowfactura[5]=parseFloat(data[index].saldo);
      rowfactura[6]=data[index].currencies;
      rowfactura[7]=data[index].folio;
      rowfactura[8]=data[index].currency_id;

      datafactura.push(rowfactura);
      cantidades_pagadas.push(0);

      datafactura_total += rowfactura[4];
      datafactura_saldo += rowfactura[5];

    });

    $('#mount_total').val(datafactura_total);
    $('#mount_saldo').val(datafactura_saldo);

  }

  $(document).on('keyup', '.pagada', function(e) {

    var id = $(this)[0].id;
    var valor = $('#'+id).val() * $('#currency_value').val();

    var comparacion = datafactura.filter(function (row) {
      if(row[0] == id.split("-")[1]) {

        if(valor > (row[5] * $('#currency_value').val()) || valor == 0) {
          //console.log("Pasado");
          $('#'+id).val("");
        }

        return "Ok";
      }
    });

    suma_pagadas();

  });

  function suma_pagadas() {

    var sum = 0;

    $(".pagada").each(function(index) {
      sum += parseFloat($(this)[0].value);
      cantidades_pagadas[index] = parseFloat($(this)[0].value);
    });

    $('#mount_pagado').val(sum);

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
    formData.append("item_relation",JSON.stringify(datafactura));
    formData.append("cantidades_pagadas",JSON.stringify(cantidades_pagadas));
    formData.append("date_due","27-12-2019"); //PENDIENTE DE CAMBIAR
    formData.append("customer_id",datafactura[0][2]);

    if($('#branch_office_id').val() == "" || $('#date').val() == "" || $('#payment_way_id').val() == "" || $('#cfdi_relation_id').val() == "") {
      Swal.fire("Operación abortada", "Todos los campos son obligatorios.", "error");
    } else if($('#mount_pagado').val() == 0 || isNaN($('#mount_pagado').val())) {
      Swal.fire("Operación abortada", "Monto no válido :(", "error");
    } else {
      console.log("OK");
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
      
    }

  });

});
