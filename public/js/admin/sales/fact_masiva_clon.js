$(function(){
  moment.locale('es');
  let $dt = $('#table_contracts');
  $('#total').val(0);
  let $total = $('#total');
  $("#form input[name='description_month']").val(moment().format('MMMM YYYY').toUpperCase());

  $dt.on('change', 'tbody input', function() {
    let info = $dt.DataTable().row($(this).closest('tr')).data();
    let total = parseFloat($total.val().replace(/,/g, ""));
    let price = parseFloat(info[5]);
    let discount = parseFloat(info[6]);
    let monto_descuento = 0;
    discount = (discount / 100);
    monto_descuento = (price * discount);
    let price_discounted = (price - monto_descuento);
    // let test_monto = (0 - price);
    // console.log("monto descuento: " + monto_descuento + "  total con descuento: " + price_discounted + "  operacion: " + test_monto);

    total += this.checked ? price_discounted :  (0 - price_discounted);

    $total.val(total.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  });
  $dt.on('change', 'thead input', function (evt) {
    let checked = this.checked;
    let total = 0;
    let data = [];

    $dt.DataTable().data().each(function (info) {
      // var discount = info[6];
      if (checked) {
        total += parseFloat(info[5]);
        // txt = txt.substr(0, txt.length - 1) + ' checked>';
      } else {
        // txt = txt.replace(' checked', '');
      }
      // info[0] = txt;
      data.push(info);
    });
    // $dt.DataTable().clear().rows.add(data).draw();
    $total.val(total.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  });

  $("#form input[name='date']").daterangepicker({
      singleDatePicker: true,
      timePicker: true,
      timePicker24Hour: true,
      showDropdowns: true,
      minDate: moment().subtract(5, 'months'),
      maxDate : moment().add(3, 'days'),
      locale: {
          format: "DD-MM-YYYY HH:mm:ss"
      },
      autoUpdateInput: true,
  }, function (chosen_date) {
      var date_month = chosen_date.format("MMMM YYYY");
      $("#form input[name='date']").val(chosen_date.format("DD-MM-YYYY HH:mm:ss"));
      $("#form input[name='description_month']").val(date_month.toUpperCase());
  });
  /*Configura datepicker*/
  $("#form input[name='date_due']").daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      minDate: moment(),
      locale: {
          format: "DD-MM-YYYY"
      },
      autoUpdateInput: false,
  }, function (chosen_date) {
      $("#form input[name='date_due']").val(chosen_date.format("DD-MM-YYYY"));
  });
  /////////////////////////////////////////////////\
  $('#date_search').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
});
  //-----------------------------------------------------------
  $("#search_info").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    errorPlacement: function (error, element) {
        var attr = $('[name="'+element[0].name+'"]').attr('datas');
        if (element[0].id === 'fileInput') {
          error.insertAfter($('#cont_file'));
        }
        else {
          if(attr == 'sel_estatus'){
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
        var form = $('#search_info')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/sales/search_view_contracts",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            table_anexos(data, $("#table_contracts"));
            /*******************************************************************/
            $.ajax({
              type: "POST",
              url: "/sales/search_currency_contract",
              data: formData,
              contentType: false,
              processData: false,
              success: function (data){
                var c1=JSON.parse(data);
                if (c1.length != 0) {
                  $('#currency_value').val(c1[0].current_rate);
                }
                else {
                  $('#currency_value').val('');
                  Swal.fire({
                    type: 'error',
                    title: 'Oopss...',
                    text: 'Intente de nuevo...',
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
            /*******************************************************************/
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
            if(attr == 'sel_estatus'){
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
          if ( ! $.fn.DataTable.isDataTable( '#table_contracts' ) ) {
            Swal.fire({
              type: 'error',
              title: 'Oopss...',
              text: 'Inicializa los contratos, en base a la moneda seleccionada ',
            });
          }
          else {
            /*--Verificar si hay seleccionadas--*/
            var rows_selected = $("#table_contracts").DataTable().column(0).checkboxes.selected();
            var valores= new Array();
            $.each(rows_selected, function(index, rowId){
              valores.push(rowId);
            });
            if ( valores.length === 0){
              Swal.fire({
                type: 'error',
                title: 'Oopss...',
                text: 'Debe selecionar al menos un contrato maestro',
              });
            }
            else {
              var form = $('#form')[0];
              var formData = new FormData(form);
              formData.append('currency_id', $('#currency_id').val());
              formData.append('idents', JSON.stringify(valores));
              $.ajax({
                type: "POST",
                url: "/sales/view_contracts_create",
                data: formData,
                contentType: false,
                processData: false,
                success: function (data){
                  if(data == "success"){
                    let timerInterval;
                    Swal.fire({
                      type: 'success',
                      title: 'Operación Completada!',
                      html: 'Aplicando los cambios.',
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
                       window.location.href = "/sales/view_contracts";
                      }
                    });
                  }
                  else{
                    Swal.fire({
                      type: 'error',
                      title: 'Error encontrado..',
                      text: 'Realice la operacion nuevamente!',
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
            /*----------------------------------*/
          }
        }
    });
    //-----------------------------------------------------------
});


function table_anexos(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_classification);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    vartable.fnAddData([
      status.contract_annex_id,
      status.cxclassifications,
      status.verticals,
      status.cadenas,
      status.key,
      status.quantity,
      status.descuento,
      status.customers
      // '<a href="javascript:void(0)" data-type="select" data-pk="'+ status.id_contract_master +'" data-title="Clientes" data-value="' + status.rz_customer_id + '" class="set-clientes">' + status.customers + '</a>',
      // '<a href="javascript:void(0);" onclick="view_info(this)" class="btn btn-primary  btn-sm mr-2 p-1" value="'+status.id_contract_master+'"><i class="fas fa-eye btn-icon-prepend fastable"></i></a>'
    ]);
  });
}
var Configuration_table_responsive_simple_classification= {
        "order": [[ 1, "asc" ]],
        "select": true,
        "aLengthMenu": [[3, 5, 10, 25, -1], [3, 5, 10, 25, "Todos"]],
        "columnDefs": [
          { //Subida 1
            "targets": 0,
            "checkboxes": {
              // 'selectRow': true
            },
            "width": "0.2%",
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
            "width": "0.5%",
            "className": "text-center fix-columns",
          },
          {
            "targets": 4,
            "width": "0.5%",
            "className": "text-center fix-columns",
          },
          {
            "targets": 5,
            "width": "1%",
            "className": "text-center fix-columns",
          },
          {
            "targets": 6,
            "width": "1%",
            "className": "text-center fix-columns",
          },
        ],
        "select": {
          'style': 'multi',
          'selector': 'td:first-child'

        },
        /*"fnDrawCallback": function() {
          var _token = $('input[name="_token"]').val();
          var source_clientes;
          $.ajax({
            type: "POST",
            url: "/search_client_contract",
            data: { _token : _token },
            success: function (data) {
              source_clientes = data;
            },
            error: function (err){
              Swal.fire({
                type: 'error',
                title: 'Oopss...',
                text: err.statusText,
              });
            }
          });
          $('.set-clientes').editable({
              type : 'select',
              source: function() {
              return source_clientes;
            },
            success: function(response, newValue) {
              var id = $(this).data('pk');
               // $(this).attr('pk',newValue);
              // console.log(newValue);
              // setCliente(id, newValue);
            }
          });
        },*/
        dom: "<'row'<'col-sm-3'l><'col-sm-9'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
          {
            extend: 'pdf',
            text: '<i class="fas fa-file-pdf"></i>  PDF',
            title: function ( e, dt, node, config ) {
              return 'Sitios a facturar';
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
            className: 'btn btn-danger',
          }
        ],
        language:{
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros. ",
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
            },
            'select': {
                'rows': {
                    _: "%d Filas seleccionadas",
                    0: "Haga clic en una fila para seleccionarla",
                    1: "Fila seleccionada 1"
                }
            }
        },
    };

    function view_info(e){
      var valor = e.getAttribute('value');
      var _token = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
          type: "POST",
          url: "/sales/view_contracts_info",
          data: { id: valor, _token : _token },
          success: function (data){
            $('#modal-history').modal('show');
            table_salespersons(data, $("#payment_history_all"));
          },
          error: function (data) {
            console.log('Error:', data.statusText);
          }
      });
    }
    function table_salespersons(datajson, table){
      table.DataTable().destroy();
      var vartable = table.dataTable(Configuration_table_responsive_simple_modal);
      vartable.fnClearTable();
      $.each(JSON.parse(datajson), function(index, information){
        vartable.fnAddData([
          information.key,
          information.sitio,
          information.id_ubicacion,
          information.monto,
          information.currencies,
          information.exchange_range_value,
          information.iva,
          information.date_real,
          information.date_scheduled_start,
          information.date_scheduled_end,
          information.number_months,
        ]);
      });
    }
    var Configuration_table_responsive_simple_modal={
      dom: "<'row'<'col-sm-3'l><'col-sm-9'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      "order": [[ 0, "desc" ]],
      paging: true,
      //"pagingType": "simple",
      Filter: true,
      searching: true,
      "aLengthMenu": [[3, 5, 10, 25, -1], [3, 5, 10, 25, "Todos"]],
      //ordering: false,
      "pageLength": 5,
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
    function setCliente(id, newValue){
      var _token = $('input[name="_token"]').val();
      $.ajax({
          type: "POST",
          url: "/sales/set_cliente_contrato",
          data: { id_contract : id, id_rz : newValue, _token : _token },
          success: function (data){
            if(data == "abort"){
              Swal.fire({
                type: 'error',
                title: 'Error encontrado..',
                text: 'Realice la operacion nuevamente!',
              });
            }else{
              Swal.fire({
                type: 'success',
                title: 'Operación Completada!',
              });
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
      });
    }
    function default_currency() {
      var form = $('#search_info')[0];
      var formData = new formData(form);
      $.ajax({
        type: "POST",
        url: "/sales/search_currency_contract",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          if (data != []) {
            $('#currency_value').val(data.current_rate);
            // console.log(data);
          }
          else {
            Swal.fire({
              type: 'error',
              title: 'Oops, no se encontro el ultimo tipo de cambio, favor de llenar el campo TC*',
              text: 'Intente de nuevo...',
            });
          }
        },
        error: function (err){
          Swal.fire({
            type: 'error',
            title: 'Oopss...',
            text: err.statusText,
          });
        }
      });
    }
