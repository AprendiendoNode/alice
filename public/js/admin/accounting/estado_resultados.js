$(function() {
  moment.locale('es');
  $('#period_month').datepicker({
    language: 'es',
    format: " yyyy",
    viewMode: "years",
    minViewMode: "years",
    autoclose: true,
    clearBtn: true
  });
  const nowOfYear = moment().format('YYYY');
  // $('#period_month').val(nowOfYear).datepicker('update');

  $("#search").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    errorPlacement: function (error, element) {
      var attr = $('[name="'+element[0].name+'"]').attr('datas');
      if (element[0].id === 'fileInput') {
        error.insertAfter($('#cont_file'));
      }
      else {
        if(attr == 'sel_ingreso'){
          error.insertAfter($('#cont_ingreso'));
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
      busqueda();
    }
  });
});

function busqueda() {
  var form = $('#search')[0];
  var formData = new FormData(form);
  $.ajax({
    type: "POST",
    url: "/accounting/estado_resultados_search",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data){
      remplazar_thead_th_periodo($("#all_month"), 2 ,13);
      fill_table_periodo(data, $("#all_month"));
      pintar_celda($("#all_month"));

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


function remplazar_thead_th_periodo(table, posicionini, posicionfin) {
  var year = $('#period_month').val();
  var fecha = year+'-12-01';
  const nowOfYear = moment(fecha).format('YYYY-MM-DD');

  var j= posicionfin-posicionini;
  for (var i = posicionini; i <= posicionfin; i++) {
    table.DataTable().columns(i).header().to$().addClass('azul');
    table.DataTable().columns(i).header().to$().text(
      moment(nowOfYear,'YYYY-MM-DD').subtract(j, 'month').format('MMMM-YYYY')
    );
    j--;
  }
}

function pintar_celda(table) {
  // table.DataTable().
  // cells( function ( idx, data, node ) {
  //   return data == 'SUMA' ?
  //   true : false;
  // } ).nodes().to$().addClass('azul');

  table.DataTable().cells().every( function () {
    if ( this.data() == 'SUMA' ) { $(this.node()).addClass('sumita'); }
    if ( this.data() == 'TOTAL INGRESOS' ) { $(this.node()).addClass('red'); }
    if ( this.data() == 'COSTO SERVS ADMINISTRADOS' ) { $(this.node()).addClass('red'); }
    if ( this.data() == 'IMPORTACIONES' ) { $(this.node()).addClass('red'); }
    if ( this.data() == 'FELTES Y ENVÍOS' ) { $(this.node()).addClass('red'); }
    if ( this.data() == 'COSTO DE VENTA' ) { $(this.node()).addClass('red'); }
    if ( this.data() == 'COSTOS VMW' ) { $(this.node()).addClass('red'); }
    if ( this.data() == 'COSTO SUBARRENDAMIENTOS' ) { $(this.node()).addClass('red'); }
    if ( this.data() == 'TOTAL COSTO' ) { $(this.node()).addClass('red'); }
    if ( this.data() == 'RESULTADO BRUTO' ) { $(this.node()).addClass('red'); }
    if ( this.data() == 'COMPLEMENTO DE SUELDO' ) { $(this.node()).addClass('red'); }

    if ( this.data() == 'GASTOS DE COMERCIALIZACIÓN' ) { $(this.node()).addClass('red'); }
    if ( this.data() == 'EBITDA' ) { $(this.node()).addClass('red'); }
    if ( this.data() == 'EBIT' ) { $(this.node()).addClass('red'); }
    if ( this.data() == 'GASTOS FINANCIEROS' ) { $(this.node()).addClass('red'); }

    if ( this.data() == 'PRODUCTOS FINANCIEROS' ) { $(this.node()).addClass('red'); }
    if ( this.data() == 'COSTO INTEGRAL DE FINANCIAMIENTO' ) { $(this.node()).addClass('red'); }
    if ( this.data() == 'RESULTADO DEL EJERCICIO ANTES IMPTOS' ) { $(this.node()).addClass('red'); }

    if ( this.data() == 'ISR' ) { $(this.node()).addClass('red'); }
    if ( this.data() == 'PTU' ) { $(this.node()).addClass('red'); }
    if ( this.data() == 'RESULTADO DEL EJERCICIO NETO IMPTOS' ) { $(this.node()).addClass('red'); }

  });
}


function fill_table_periodo (datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_no_options_biweekly);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    vartable.fnAddData([
      status.cuenta,
      status.nombre,
      status.n01,
      status.n02,
      status.n03,
      status.n04,
      status.n05,
      status.n06,
      status.n07,
      status.n08,
      status.n09,
      status.n10,
      status.n11,
      status.n12,
      status.porcentaje,
      status.cr_rd,
      status.porcentaje_cr_rd,
    ]);
  });
}

var Configuration_table_no_options_biweekly = {
  paging: true,
  //"pagingType": "simple",
  Filter: false,
  searching: false,
  "aLengthMenu": [[-1, 5, 10, 25], ["Todos los ", 5, 10, 25]],
  ordering: false,
    //"pageLength": 5,
  // bInfo: false,
  "scrollX": true,
  fixedColumns:   {
      leftColumns: 2//Le indico que deje fijas solo las 2 primeras columnas
  },

  dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
  buttons: [
      {
        extend: 'excelHtml5',
        title: 'Estado de resultados',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
        titleAttr: 'Excel',
        className: 'btn btn-success btn-sm',
        exportOptions: {
            columns: [ 0, 1, 2, 3]
        },
      },
      {
        extend: 'csvHtml5',
        title: 'Estado de resultados',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
        titleAttr: 'CSV',
        className: 'btn btn-primary btn-sm',
        exportOptions: {
            columns: [ 0, 1, 2, 3]
        },
      }
  ],
  "processing": true,
  "rowCallback": function( row, data, index ) {
    // console.log(data[1]); //Columna 1

    if (data[1] = 'TOTAL COSTO') {
      // $(row).columns(3).addClass('azul');
    }

          // if (data.office == "London") {
          //   $('td', row).css('background-color', 'Red');
          // }
  },
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
