$(function () {
  $('#date_to_search').datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months",
    endDate: '1m',
    autoclose: true,
    clearBtn: true
  });
  get_billing_report();
});

$("#search_info").validate({
  ignore: "input[type=hidden]",
  errorClass: "text-danger",
  successClass: "text-success",
  rules: {
  },
  messages: {
  },
  submitHandler: function(e){
    var form = $('#search_info')[0];
    var formData = new FormData(form);
    $.ajax({
      type: "POST",
      url: "/accounting/get_billing_report",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data){
        console.log(data);
        table_billing(data, $("#table_billing"));
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

function get_billing_report(){
    var form = $('#search_info')[0];
    var formData = new FormData(form);
    $.ajax({
      type: "POST",
      url: "/accounting/get_billing_report",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data){
        console.log(data);
        table_billing(data, $("#table_billing"));
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

function table_billing(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_responsive_customers);
    vartable.fnClearTable();
      var intVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\$,]/g, '')*1 :
            typeof i === 'number' ?
                i : 0;
      };

    let suma_untaxed = 0.0;
    let suma_discount = 0.0;
    let suma_tax = 0.0;
    let suma_tax_ret = 0.0;
    let suma_total = 0.0;

    let suma_untaxed_c = 0.0;
    let suma_discount_c = 0.0;
    let suma_tax_c = 0.0;
    let suma_tax_ret_c = 0.0;
    let suma_total_c = 0.0;

    let suma_untaxed_final = 0.0;
    let suma_discount_final = 0.0;
    let suma_tax_final = 0.0;
    let suma_tax_ret_final = 0.0;
    let suma_total_final = 0.0;
   
    $.each(datajson, function(index, data){

      if (data.N == 'A') {
        suma_untaxed = (intVal(suma_untaxed) + intVal(data.amount_untaxed));
        suma_discount = (intVal(suma_discount) + intVal(data.amount_discount));
        suma_tax = (intVal(suma_tax) + intVal(data.amount_tax));
        suma_tax_ret = (intVal(suma_tax_ret) + intVal(data.amount_tax_ret));
        suma_total = (intVal(suma_total) + intVal(data.amount_total));
      }else{
        suma_untaxed_c = (intVal(suma_untaxed_c) + intVal(data.amount_untaxed));
        suma_discount_c = (intVal(suma_discount_c) + intVal(data.amount_discount));
        suma_tax_c = (intVal(suma_tax_c) + intVal(data.amount_tax));
        suma_tax_ret_c = (intVal(suma_tax_ret_c) + intVal(data.amount_tax_ret));
        suma_total_c = (intVal(suma_total_c) + intVal(data.amount_total));
      }

      vartable.fnAddData([
        data.code,
        data.serie,
        data.folio,
        data.date,
        data.control_id,
        data.name,
        data.status,
        data.N,
        data.amount_untaxed,
        data.amount_discount,
        data.amount_tax,
        data.amount_tax_ret,
        data.amount_total,
        data.currency_value,
        data.uuid,
        data.key_master,
        data.reference
      ]);
    });
    console.log(suma_untaxed_c);
    console.log(suma_discount_c);
    console.log(suma_tax_c);
    console.log(suma_tax_ret_c);
    console.log(suma_total_c);

    suma_untaxed_final = (suma_untaxed - suma_untaxed_c);
    suma_discount_final = (suma_discount- suma_discount_c);
    suma_tax_final = (suma_tax - suma_tax_c);
    suma_tax_ret_final = (suma_tax_ret - suma_tax_ret_c);
    suma_total_final = (suma_total - suma_total_c);

    $('#suma_untaxed').text(suma_untaxed.toFixed(3));
    $('#suma_discount').text(suma_discount.toFixed(3));
    $('#suma_tax').text(suma_tax.toFixed(3));
    $('#suma_tax_ret').text(suma_tax_ret.toFixed(3));
    $('#suma_total').text(suma_total.toFixed(3));

    $('#suma_untaxed_c').text(suma_untaxed_c.toFixed(3));
    $('#suma_discount_c').text(suma_discount_c.toFixed(3));
    $('#suma_tax_c').text(suma_tax_c.toFixed(3));
    $('#suma_tax_ret_c').text(suma_tax_ret_c.toFixed(3));
    $('#suma_total_c').text(suma_total_c.toFixed(3));

    $('#suma_untaxed_final').text(suma_untaxed_final.toFixed(3));
    $('#suma_discount_final').text(suma_discount_final.toFixed(3));
    $('#suma_tax_final').text(suma_tax_final.toFixed(3));
    $('#suma_tax_ret_final').text(suma_tax_ret_final.toFixed(3));
    $('#suma_total_final').text(suma_total_final.toFixed(3));
  }

var Configuration_table_responsive_customers = {
    dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
        {
          extend: 'excelHtml5',
          title: 'Reporte facturación',
          init: function(api, node, config) {
             $(node).removeClass('btn-secondary')
          },
          text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
          titleAttr: 'Excel',
          className: 'btn btn-success btn-sm',
          exportOptions: {
              columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
          },
        },
        {
          extend: 'csvHtml5',
          title: 'Reporte facturación',
          init: function(api, node, config) {
             $(node).removeClass('btn-secondary')
          },
          text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
          titleAttr: 'CSV',
          className: 'btn btn-primary btn-sm',
          exportOptions: {
              columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
          },
        }
    ],
    "processing": true,
    /*"createdRow": function ( row, data, index ) {
      if (data[7] == 'A') { 
        $('td', row).eq(8).addClass('acredor');
        $('td', row).eq(9).addClass('acredor');
        $('td', row).eq(10).addClass('acredor');
        $('td', row).eq(11).addClass('acredor');
        $('td', row).eq(12).addClass('acredor');
      }else{
        $('td', row).eq(8).addClass('cargo');
        $('td', row).eq(9).addClass('cargo');
        $('td', row).eq(10).addClass('cargo');
        $('td', row).eq(11).addClass('cargo');
        $('td', row).eq(12).addClass('cargo');
      }
    },
    "footerCallback": function(row, data, start, end, display){
      var api = this.api(), data;
      var suma = 0;
      var colCount = 13;
      var colCountDyn = 0;

      var intVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\$,]/g, '')*1 :
            typeof i === 'number' ?
                i : 0;
      };

      api.columns('.sum_col').every( function () {
        // fila = api.row(this).data();
        // console.log(fila);
        // if (row == []) {
        //   console.log('empty');
        // }else{
        //   console.log(row[7]);
        // }

        suma = this
            .data()
            .reduce( function (a, b) {
              // console.log(b);
                return intVal(a) + intVal(b);
            }, 0 );

            suma = suma.toFixed(3);
            var total  = suma.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

           if(parseInt(total) < 0) this.footer().innerHTML = "<span class='negative'>("+total+")</span>"

           else this.footer().innerHTML = total;
      } );
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
      }
    }
  };
  