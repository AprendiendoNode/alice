$(function(){
  /*$('#table_contracts').on('click', 'thead tr th input[type="checkbox"]',function(e) {   
      alert('Clicked on "Select all"');   
  });*/
  moment.locale('es');
  let $dt = $('#table_contracts');
  $('#total').val(0);
  let $total = $('#total');
  
  // $('#table_contracts').DataTable().on('select', function( e, dt, type, indexes ){
  //   // console.log($('table_contracts').find('.selected'));
  //   // var rows_selected = $("#table_contracts").DataTable().column(0).checkboxes.selected().row().data();
  //   // console.log(rows_selected);
  //   let info = $("#table_contracts").DataTable().column(0).checkboxes.selected().row().data();
  //   let total = parseFloat($total.val());
  //   let price = parseFloat(info[5]);

  //   total +=  price;

  //   $total.val(total);
  // });
  // $('#table_contracts').DataTable().on('deselect', function( e, dt, type, indexes ){
  //   // console.log($('table_contracts').find('.selected'));
  //   // var rows_selected = $("#table_contracts").DataTable().column(0).checkboxes.selected().row().data();
  //   // console.log(rows_selected);
  //   let info = $("#table_contracts").DataTable().column(0).checkboxes.selected().row().data();
  //   let total = parseFloat($total.val());
  //   let price = parseFloat(info[5]);

  //   total +=  price * -1;

  //   $total.val(total);
  // });

  $dt.on('change', 'tbody input', function() {
    let info = $dt.DataTable().row($(this).closest('tr')).data();
    let total = parseFloat($total.val());
    let price = parseFloat(info[5]);

    total += this.checked ? price : price * -1;

    $total.val(total);
  });

  $dt.on('change', 'thead input', function (evt) {
    let checked = this.checked;
    let total = 0;
    let data = [];
    
    $dt.DataTable().data().each(function (info) {
      // var txt = info[0];    
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
    $total.val(total);
  });
  
  $("#form input[name='date']").daterangepicker({
      singleDatePicker: true,
      timePicker: true,
      timePicker24Hour: true,
      showDropdowns: true,
      minDate: moment(),
      maxDate : moment().add(3, 'days'),
      locale: {
          format: "DD-MM-YYYY HH:mm:ss"
      },
      autoUpdateInput: true
  }, function (chosen_date) {
      $("#form input[name='date']").val(chosen_date.format("DD-MM-YYYY HH:mm:ss"));
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
      // debug: true,
      // errorElement: "label",
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
});

function table_anexos(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_checkbox_move_viatic_n1);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    vartable.fnAddData([
      status.id_contract_master,
      status.cxclassification,
      status.vertical,
      status.cadena,
      status.key,
      status.sum_annexes,
      '',
      '<a href="javascript:void(0);" onclick="view_info(this)" class="btn btn-primary  btn-sm mr-2 p-1" value="'+status.id_contract_master+'"><i class="fas fa-eye btn-icon-prepend fastable"></i> informacion</a>'
    ]);
  });
}
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
  var vartable = table.dataTable(Configuration_table_responsive_simple_classification);
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

var Configuration_table_responsive_simple_classification={
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
          title: 'Oopss...',
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

// Configuracion de table de estatus verifica*
var Configuration_table_responsive_checkbox_move_viatic_n1= {
  "order": [[ 1, "desc" ]],
  "select": true,
  "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  "columnDefs": [
    { //Subida 1
      "targets": 0,
      "checkboxes": {
        // 'selectRow': true
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
    'selector': 'td:first-child'

  },
  dom: "<'row'<'col-sm-6'B><'col-sm-2'l><'col-sm-4'f>>" +
  "<'row'<'col-sm-12'tr>>" +
  "<'row'<'col-sm-5'i><'col-sm-7'p>>",
  buttons: [
    {
      extend: 'pdf',
      text: '<i class="fas fa-file-pdf"></i>  PDF',
      title: function ( e, dt, node, config ) {
        return 'Reporte de viaticos.';
      },
      init: function(api, node, config) {
        $(node).removeClass('btn-default')
      },
      exportOptions: {
        columns: [ 1,2,3,4,5,6,7,8,9],
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
