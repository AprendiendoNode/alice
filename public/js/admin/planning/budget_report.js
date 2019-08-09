var token = $('input[name="_token"]').val();
const headers = new Headers({
  "Accept": "application/json",
  "X-Requested-With": "XMLHttpRequest",
  "X-CSRF-TOKEN": token
});
$(function () {
   //management_products();
  moment.locale('es');
  $('.date_plug').datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "years",
    minViewMode: "years",
    endDate: '1y',
    autoclose: true,
    clearBtn: true
  });
  $('.date_plug').val('').datepicker('update');
  budget_tb(token);
});

function budget_tb(token) {
  var _token = token;
  var tipo_c = $('#tpgeneral').val();
  var year_budget = $('#date_to_search').val();
  $.ajax({
      type: "POST",
      url: "/get_budget_report_table",
      data: { tpgeneral: tipo_c, date: year_budget, _token : _token },
      success: function (data){
        // console.log(data);
        generate_table_budget(data, $('#table_budget'));
        $('#tpgeneral').val('');
        $('#date_to_search').val('');
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function generate_table_budget(datajson, table) {
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_budget);
  vartable.fnClearTable();
  $.each(datajson, function(index, data){
    vartable.fnAddData([
      // data.id,
      data.sitio,
      data.id_proyecto,
      data.id_ubicacion,
      data.moneda,
      data.renta,
      data.pres_mtto,
      data.pres_ejerc,
      data.diff,
      '<a href="javascript:void(0);" onclick="enviar(this)" value="'+data.sitio_id+'" class="btn btn-default btn-xs" role="button" data-target="#modal-concept"><span class="fa fa-eye"></span></a>',
    ]);
  });
}
function enviar(e) {
  var valor= e.getAttribute('value');
  $('#id_annex').val(valor);
  $('#modal-view-algo').modal('show');
  $('.modal-title').text('Desglose de montos.');
  // $('#modal-view-algo').modal('hide');
  get_desglose_table(valor);
  // console.log(valor);
}

function get_desglose_table(id_sitio) {
  var tipo_c = $('#tpgeneral').val();
  var date_search = $('#date_to_search_tc').val();
  $.ajax({
      type: "POST",
      url: "/get_desglose_payments_id",
      data: { _token : token, site_id : id_sitio, tipo_c : tipo_c, date : date_search },
      success: function (data){
        console.log(data);
        generate_table_desglose(data, $('#table_desglose'));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
$('.btnupdetc').on('click', function(){
  var tipo_c = $('#tpgeneral').val();
  var date_search = $('#date_to_search_tc').val();
  var id_sitio = $('#id_annex').val();
  $.ajax({
      type: "POST",
      url: "/get_desglose_payments_id",
      data: { _token : token, site_id : id_sitio, tipo_c : tipo_c, date : date_search },
      success: function (data){
        console.log(data);
        generate_table_desglose(data, $('#table_desglose'));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
});
function generate_table_desglose(datajson, table) {
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_budget_desglose);
  vartable.fnClearTable();
  $.each(datajson, function(index, data){
    vartable.fnAddData([
      data.folio,
      data.factura,
      data.proveedor,
      data.pago_USD
    ]);
  });
}
$('.filtrarBudgets').on('click', function(){
  //console.log('click');
  budget_tb(token);
});
function get_table_estimation(id_anexo){
  //var id_anexo = $('#id_annex').val();
  var init = { method: 'get',
               headers: headers,
               credentials: "same-origin",
               cache: 'default' };
  if(id_anexo != null && id_anexo != undefined){
    fetch(`/estimation_site_table/id_anexo/${id_anexo}`, init)
      .then(response => {
        return response.text();
      })
      .then(data => {
        $('#presupuesto_anual').html('');
        $('#presupuesto_anual').html(data);
      })
      .catch(error => {
        console.log(error);
      })
  }
}
$('.closeModal').on('click', function(){
  $('#tpgeneral').val('');
  $('#date_to_search_tc').val('');
  // $('#presupuesto_anual').html('');
});
var Configuration_table_responsive_budget= {
  "order": [[ 0, "asc" ]],
  paging: true,
  //"pagingType": "simple",
  Filter: true,
  searching: true,
  // "select": true,
  "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "All"]],
  "columnDefs": [
      /*{ //Subida 1
        "targets": 0,
        "checkboxes": {
          'selectRow': true
        },
        "width": "0.2%",
        "createdCell": function (td, cellData, rowData, row, col){

        }
      }, */
      {
        "targets": [0,1,2,3,4,5,6,7],
        "width": "1%",
        "className": "text-center",
      },
      {
        "targets": 8,
        "width": "0.2%",
        "className": "text-center",
      }
  ],
  // "select": {
  //     'style': 'multi',
  // },
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
  buttons: [
    {
      extend: 'excelHtml5',
      text: '<i class="fa fa-file-excel-o"></i> Excel',
      titleAttr: 'Excel',
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
          columns: [ 0,1,2,3,4 ],
          modifier: {
              page: 'all',
          }
      },
      className: 'btn btn-success',
    },
  ],
  /*"drawCallback": function( settings ) {
    var api = this.api();
    var _token = $('input[name="_token"]').val();
      //Editable monto equipo activo.
        $('.editable_monto1', api.table().body())
          .editable({ emptytext: '0' })
          .off('hidden')
          .on('hidden', function(e, reason) {
             var current_pk = $(this).data('pk');
             if(reason === 'save') {
                 $('#mt1_'+current_pk).attr('data-order', $(this).text());
                 $('#mt1_'+current_pk).attr('data-value', $(this).text());
                 $('#mt1_'+current_pk).editable('setValue',$(this).text());
                 var monto = $('#mt1_'+current_pk).attr('data-value');
                 $.ajax({
                     type: "POST",
                     url: "/edit_presupuesto",
                     data: {
                       _token : _token,
                       v_data  : current_pk,
                       v_monto : monto,
                       v_type : 1
                     },
                     success: function (data){
                      //console.log(data);
                       if (data === '1') {
                         swal("Operación completada!", "Operation complete", "success");
                       }
                       else{
                         swal("Operación abortada!", ":)", "success");
                       }
                     },
                     error: function (data) {
                       console.log('Error:', data);
                     }
                 });
             }
        });
      //Editable monto equipo no activo.
        $('.editable_monto2', api.table().body())
          .editable({ emptytext: '0' })
          .off('hidden')
          .on('hidden', function(e, reason) {
             var current_pk = $(this).data('pk');
             if(reason === 'save') {
                 $('#mt2_'+current_pk).attr('data-order', $(this).text());
                 $('#mt2_'+current_pk).attr('data-value', $(this).text());
                 $('#mt2_'+current_pk).editable('setValue',$(this).text());
                 var monto = $('#mt2_'+current_pk).attr('data-value');
                 $.ajax({
                     type: "POST",
                     url: "/edit_presupuesto",
                     data: {
                       _token : _token,
                       v_data  : current_pk,
                       v_monto : monto,
                       v_type : 2
                     },
                     success: function (data){
                      //console.log(data);
                       if (data === '1') {
                         swal("Operación completada!", "Operation complete", "success");
                       }
                       else{
                         swal("Operación abortada!", ":)", "success");
                       }
                     },
                     error: function (data) {
                       console.log('Error:', data);
                     }
                 });
             }
        });
      //Editable monto Licencias.
        $('.editable_monto3', api.table().body())
          .editable({ emptytext: '0' })
          .off('hidden')
          .on('hidden', function(e, reason) {
             var current_pk = $(this).data('pk');
             if(reason === 'save') {
                 $('#mt3_'+current_pk).attr('data-order', $(this).text());
                 $('#mt3_'+current_pk).attr('data-value', $(this).text());
                 $('#mt3_'+current_pk).editable('setValue',$(this).text());
                 var monto = $('#mt3_'+current_pk).attr('data-value');
                 $.ajax({
                     type: "POST",
                     url: "/edit_presupuesto",
                     data: {
                       _token : _token,
                       v_data  : current_pk,
                       v_monto : monto,
                       v_type : 3
                     },
                     success: function (data){
                        // console.log(data);
                        if (data === '1') {
                         swal("Operación completada!", "Operation complete", "success");
                        }
                        else{
                         swal("Operación abortada!", ":)", "success");
                        }
                     },
                     error: function (data) {
                       console.log('Error:', data);
                     }
                 });
             }
        });
      //Editable monto mano de obra.
        $('.editable_monto4', api.table().body())
          .editable({ emptytext: '0' })
          .off('hidden')
          .on('hidden', function(e, reason) {
             var current_pk = $(this).data('pk');
             if(reason === 'save') {
                 $('#mt4_'+current_pk).attr('data-order', $(this).text());
                 $('#mt4_'+current_pk).attr('data-value', $(this).text());
                 $('#mt4_'+current_pk).editable('setValue',$(this).text());
                 var monto = $('#mt4_'+current_pk).attr('data-value');
                 $.ajax({
                     type: "POST",
                     url: "/edit_presupuesto",
                     data: {
                       _token : _token,
                       v_data  : current_pk,
                       v_monto : monto,
                       v_type : 4
                     },
                     success: function (data){
                      //console.log(data);
                       if (data === '1') {
                         swal("Operación completada!", "Operation complete", "success");
                       }
                       else{
                         swal("Operación abortada!", ":)", "success");
                       }
                     },
                     error: function (data) {
                       console.log('Error:', data);
                     }
                 });
             }
        });
      //Editable monto Enlaces.
        $('.editable_monto5', api.table().body())
          .editable({ emptytext: '0' })
          .off('hidden')
          .on('hidden', function(e, reason) {
             var current_pk = $(this).data('pk');
             if(reason === 'save') {
                 $('#mt5_'+current_pk).attr('data-order', $(this).text());
                 $('#mt5_'+current_pk).attr('data-value', $(this).text());
                 $('#mt5_'+current_pk).editable('setValue',$(this).text());
                 var monto = $('#mt5_'+current_pk).attr('data-value');
                 $.ajax({
                     type: "POST",
                     url: "/edit_presupuesto",
                     data: {
                       _token : _token,
                       v_data  : current_pk,
                       v_monto : monto,
                       v_type : 5
                     },
                     success: function (data){
                      //console.log(data);
                       if (data === '1') {
                         swal("Operación completada!", "Operation complete", "success");
                       }
                       else{
                         swal("Operación abortada!", ":)", "success");
                       }
                     },
                     error: function (data) {
                       console.log('Error:', data);
                     }
                 });
             }
        });
      //Editable monto viáticos.
        $('.editable_monto6', api.table().body())
          .editable({ emptytext: '0' })
          .off('hidden')
          .on('hidden', function(e, reason) {
             var current_pk = $(this).data('pk');
             if(reason === 'save') {
                 $('#mt6_'+current_pk).attr('data-order', $(this).text());
                 $('#mt6_'+current_pk).attr('data-value', $(this).text());
                 $('#mt6_'+current_pk).editable('setValue',$(this).text());
                 var monto = $('#mt6_'+current_pk).attr('data-value');
                 $.ajax({
                     type: "POST",
                     url: "/edit_presupuesto",
                     data: {
                       _token : _token,
                       v_data  : current_pk,
                       v_monto : monto,
                       v_type : 6
                     },
                     success: function (data){
                      //console.log(data);
                       if (data === '1') {
                         swal("Operación completada!", "Operation complete", "success");
                       }
                       else{
                         swal("Operación abortada!", ":)", "success");
                       }
                     },
                     error: function (data) {
                       console.log('Error:', data);
                     }
                 });
             }
        });
  },*/
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
var Configuration_table_responsive_budget_desglose= {
  "order": [[ 0, "asc" ]],
  paging: true,
  //"pagingType": "simple",
  Filter: true,
  searching: true,
  // "select": true,
  "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "All"]],
  "columnDefs": [
      /*{ //Subida 1
        "targets": 0,
        "checkboxes": {
          'selectRow': true
        },
        "width": "0.2%",
        "createdCell": function (td, cellData, rowData, row, col){

        }
      }, */
      {
        "targets": [0,1,2,3],
        "width": "1%",
        "className": "text-center",
      }
  ],
  // "select": {
  //     'style': 'multi',
  // },
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
  buttons: [
    {
      extend: 'excelHtml5',
      text: '<i class="fa fa-file-excel-o"></i> Excel',
      titleAttr: 'Excel',
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
          columns: [ 0,1,2,3,4 ],
          modifier: {
              page: 'all',
          }
      },
      className: 'btn btn-success',
    },
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
