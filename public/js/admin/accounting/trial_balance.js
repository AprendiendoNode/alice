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

function generate_table(){
  let _token = $('meta[name="csrf-token"]').attr('content');
  let date_month = document.getElementById('date_month').value;
  
  $("#table_balance").DataTable().destroy();
  $("#table_balance").DataTable({
    processing:true,
    serverSide:true,
    "lengthMenu": [[-1], ["Todos"]],
    ajax:{
      "type": "POST",
      url:"/accounting/get_balance_by_month",
      "data":function(d){ //Lo que se envia al servidor
        d._token = _token;
        d.date_month = date_month;
      },
      dataFilter: function(inData){
        var array=JSON.parse(inData);
        var data = JSON.stringify(array);
        return data;
      }
    },
    columns:[
      {data:'cuenta',name:'cuenta'},
      {data:'NA',name:'NA'},
      {data:'nombre',name:'nombre'},
      {data:'sdo_inicial',name:'sdo_inicial'},
      {data:'cargos',name:'cargos'},
      {data:'abonos',name:'abonos'},
      {data:'sdo_final',name:'sdo_final'}
    ],
    "columnDefs": [
      {
        "targets": [1],
        "width": "1%",
        "className": "text-center",
      },
      {
          "targets": [3,4,5,6],
          "width": "1%",
          "className": "text-right",
      }
    ],
    buttons: [
      {
        extend: 'pdf',
        text: '<i class="far fa-file-pdf"></i>  PDF',
        title: function ( e, dt, node, config ) {
          
          return 'Balanza de comprobacion <p>Sitwifi</p>';
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
        customize: function(doc) {
          
          doc.defaultStyle.fontSize = 7; //<-- set fontsize to 16 instead of 10 
       } ,
        className: 'btn btn-danger',
      },
      {
        extend: 'excelHtml5',
        text: '<i class="far fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          let date_month = document.getElementById('date_month').value;
          
          return `Balanza de comprobacion `;
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
    }
  });
}

$('#form-balance').on('submit', function(e){
  e.preventDefault();
  generate_table();
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