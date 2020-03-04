var token = $('input[name="_token"]').val();
$(function(){
  // cx_sat.unshift({value: 0, text: "Elija..."});
  //console.log(cx_sat);
  // balance_table(token);

  $("#startDatePicker").datepicker({
    format: 'yyyy-mm-dd'
  });

  $("#endDatePicker").datepicker({
    format: 'yyyy-mm-dd'
  });
  //balance_table();
}());

function balance_table() {
  var objData = $("#validation").find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/accounting/get_balance_data",
      data: objData,
      success: function (data){
        console.log(data);
        generate_table(data, $('#table_balance'));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function generate_table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_balance);
  vartable.fnClearTable();

  $.each(datajson, function(index, data){
    vartable.fnAddData([
        data.cliente,
        data.taxid,
        data.numid,
        data.cc,
        data.currencies,
        data.customer_id,
        data.amount_discount,
        data.amount_untaxed,
        data.amount_tax,
        data.amount_tax_ret,
        data.amount_total,
        data.balance
      ]);
  });
  document.getElementById("table_balance_wrapper").setAttribute("class", "dataTables_wrapper form-inline dt-bootstrap4 no-footer");
}


var Configuration_table_responsive_balance = {
  "order": [[ 1, "asc" ]],
  "select": true,
  "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  "columnDefs": [
      {
          "targets": [0,1,2,3,4,5],
          "width": "1%",
          "className": "text-center",
      },
      {
          "targets": 6,
          "width": "0.2%",
          "className": "text-center",
      },
      {
          "targets": 7,
          "width": "1%",
          "className": "text-center",
      },
      {
          "targets": 8,
          "width": "1%",
          "className": "text-center",
      },
      {
          "targets": 9,
          "width": "0.5%",
          "className": "text-center",
      },
      {
          "targets": 10,
          "width": "0.5%",
          "className": "text-center",
      },
      {
          "targets": 11,
          "width": "0.5%",
          "className": "text-center",
      }
  ],
  "select": {
    'style': 'multi',
  },
  buttons: [
    {
      extend: 'excelHtml5',
      text: '<i class="far fa-file-excel"></i> Excel',
      titleAttr: 'Excel',
      title: function ( e, dt, node, config ) {
        var ax = '';
        if($('input[name="startDate"]').val() != '' && $('input[name="endDate"]').val() != ''){
          ax= '- Periodo: ' + $('input[name="startDate"]').val() + " - " + $('input[name="endDate"]').val();
        }
        else {
          txx='- Periodo: ';
          var fecha = new Date();
          var ano = fecha.getFullYear();
          var mes = fecha.getMonth()+1;
          var fechita = ano+'-'+mes;
          ax = txx+fechita;
        }
        return 'Historial de pago '+ax;
      },
      init: function(api, node, config) {
         $(node).removeClass('btn-default')
      },
      exportOptions: {
          columns: [ 0,1,2,3,4,5,6,7,8,9 ],
          modifier: {
              page: 'all',
          }
      },
      className: 'btn btn-success',
    },
    {
      extend: 'pdf',
      text: '<i class="far fa-file-pdf"></i>  PDF',
      title: function ( e, dt, node, config ) {
        var ax = '';
        if($('input[name="date_to_search"]').val() != ''){
          ax= '- Periodo: ' + $('input[name="date_to_search"]').val();
        }
        else {
          txx='- Periodo: ';
          var fecha = new Date();
          var ano = fecha.getFullYear();
          var mes = fecha.getMonth()+1;
          var fechita = ano+'-'+mes;
          ax = txx+fechita;
        }
        return 'Historial de pago '+ax;
      },
      init: function(api, node, config) {
        $(node).removeClass('btn-default')
      },
      exportOptions: {
        columns: [ 1,2,3,4,5,6 ],
        modifier: {
          page: 'all',
        }
      },
      className: 'btn btn-danger',
    }
  ],
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
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