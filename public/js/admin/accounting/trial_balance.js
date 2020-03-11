var token = $('input[name="_token"]').val();
$(function(){
  // cx_sat.unshift({value: 0, text: "Elija..."});
  //console.log(cx_sat);
  // balance_table(token);

  $("#date_month").datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months",
    endDate: '0m',
    autoclose: true,
    clearBtn: true
  });


}());

function balance_table() {
  var objData = $("#form-balance").find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/accounting/get_balance_by_month",
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
        data.cuenta,
        data.NA,
        data.nombre,
        data.sdo_inicial,
        data.cargos,
        data.abonos,
        data.sdo_final
      ]);
  });
  document.getElementById("table_balance_wrapper").setAttribute("class", "dataTables_wrapper form-inline dt-bootstrap4 no-footer");
}

$('#form-balance').on('submit', function(e){
  e.preventDefault();
  balance_table();
})


var Configuration_table_responsive_balance = {
  "aLengthMenu": [[-1], ["Todos"]],
  "columnDefs": [
      {
          "targets": [0,2],
          "width": "1%",
          "className": "text-left",
      },
      {
        "targets": 1,
        "width": "1%",
        "className": "text-center",
      },
      {
        "targets": [3,4,5,6],
        "width": "1%",
        "className": "text-right",
      },
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
        let date_month = document.getElementById('date_month').value;
        
        return 'Balanza de comprobacion - Periodo:'+ date_month;
      },
      init: function(api, node, config) {
         $(node).removeClass('btn-default')
      },
      exportOptions: {
          columns: [ 0,1,2,3,4,5,6 ],
          modifier: {
              page: 'all',
          }
      },
      className: 'btn btn-success',
    },
    {
      text: '<i class="fas fa-file-pdf"></i> PDF',
      titleAttr: 'Descargar PDF',
      className: 'btn btn-danger',
      init: function(api, node, config) {
        $(node).removeClass('btn-default')
      },
      action: function ( e, dt, node, config ) {
          var _token = $('input[name="_token"]').val();
          let date_month = document.getElementById('date_month').value;

          if(date_month != '' && date_month != undefined){
            window.open(
               `/accounting/balance_general_pdf/${date_month}`,
              '_blank' 
            );
          }else{
            Swal.fire('Debe seleccionar un periodo','','warning');
          }
          
          
        
      }
    },
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