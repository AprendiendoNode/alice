$(function() {
    //-----------------------------------------------------------
    moment.locale('es');
    if ($("#message").length) {
        quill = new Quill('#message', {
        modules: {
          toolbar: [
            [{
              header: [1, 2, false]
            }],
            ['bold', 'italic', 'underline'],
            // ['image', 'code-block']
          ]
        },
        placeholder: 'Ingresé su mensaje...',
        theme: 'snow' // or 'bubble'
      });
    }
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
            if(attr == 'filter_date_from'){
              error.insertAfter($('#date_from'));
            }
            else if (attr == 'filter_date_to'){
              error.insertAfter($('#date_to'));
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
          var form = $('#form')[0];
          var formData = new FormData(form);
          /*  DATA CXC */
          $.ajax({
            type: "POST",
            url: "/accounting/facturas_contabilizadas_data",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
                console.log(data);
              table_cxc(data, $("#table_cxc_fact"));
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
    $("#form input[name='filter_date_from']").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD-MM-YYYY'
        },
        autoUpdateInput: false
    }, function (chosen_date) {
        $("#form input[name='filter_date_from']").val(chosen_date.format('DD-MM-YYYY'));
    });
    $("#form input[name='filter_date_to']").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD-MM-YYYY'
        },
        autoUpdateInput: false,
    }, function (chosen_date) {
        $("#form input[name='filter_date_to']").val(chosen_date.format('DD-MM-YYYY'));
    });
    $("#filter_customer_id").select2();
    //-----------------------------------------------------------
  });

  function table_cxc(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_responsive_cxc);
    vartable.fnClearTable();
    $.each(datajson, function(index, information){
        let dropdown = `<div class="btn-group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="javascript:void(0);" onclick="get_movs_by_poliza(${information.id})" data-id="${information.id}"  value="${information.id}"><span class="fa fa-eye"></span> Ver factura</a>
                            </div>
                        </div>`;  

      vartable.fnAddData([
        information.id,
        dropdown,
        information.name,
        information.date,
        information.uuid,
        information.customer,
        information.date_due,
        information.currency.substring(0, 3),
        information.amount_total,
        information.balance,
        information.contabilizado,
        information.cobrado
      ]);
    });
  }

  var Configuration_table_responsive_cxc = {
    "order": [[ 3, "asc" ]],
    "select": true,
    "aLengthMenu": [[10, 25, -1], [10, 25, "Todos"]],
    "columnDefs": [
      {
        "targets": 0,
        "checkboxes": {
          'selectRow': true
        },
        "width": "0.1%",
        "createdCell": function (td, cellData, rowData, row, col){
          if ( cellData > 0 ) {
            if(rowData[11] == 1){
              this.api().cell(td).checkboxes.disable();
              $(td).parent().attr('style', 'background: #B4CEDB !important');
            }
          }
        },
        "className": "text-center",
      },
      {
        "targets": [10, 11],
        "width": "1.0%",
        "visible": false
      },
    ],
    dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",

      buttons: [
        {
          text: '<i class=""></i> Aplicar cobro',
          titleAttr: 'Aplicar cobro',
          className: 'btn btn-warning btn-sm',
          init: function(api, node, config) {
            $(node).removeClass('btn-default')
          },
          action: function ( e, dt, node, config ) {

            var rows_selected = $("#table_cxc_fact").DataTable().column(0).checkboxes.selected();
            var _token = $('input[name="_token"]').val();
            // Iterate over all selected checkboxes
            var facturas= new Array();
            $.each(rows_selected, function(index, rowId){
              facturas.push(rowId);
            });
            if ( facturas.length === 0){
              Swal.fire(
                'Debe selecionar al menos una factura',
                '',
                'warning'
              )
            }else{
              let _token = $('meta[name="csrf-token"]').attr('content');

              $("#tabla_asiento_contable tbody").empty();

              $.ajax({
                  type: "POST",
                  url: '/accounting/customer-polizas-get-movs',
                  data: {facturas: JSON.stringify(facturas) , _token : _token},
                  success: function (data) {

                    $('#data_asientos').html(data);
                    $('.cuenta_contable').select2();
                    let dia_factura = $('#dia_hidden').val();
                    let mes_factura = $('#mes_hidden').val();
                    let anio_factura = $('#anio_hidden').val();
                    let mes_format = moment(new Date(anio_factura, parseInt(mes_factura)- 1, dia_factura)).format('MMMM');

                    $('#mes_poliza').val(mes_format);
                  },
                  error: function (err) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: err.statusText,
                      });
                  }
              })

              $("#modal_view_poliza").modal("show");
            }


          }
        },
        {
          extend: 'excelHtml5',
          title: 'Facturas',
          init: function(api, node, config) {
             $(node).removeClass('btn-secondary')
          },
          text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
          titleAttr: 'Excel',
          className: 'btn btn-success btn-sm',
          exportOptions: {
              columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
          },
        },
        {
          extend: 'csvHtml5',
          title: 'Facturas',
          init: function(api, node, config) {
             $(node).removeClass('btn-secondary')
          },
          text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
          titleAttr: 'CSV',
          className: 'btn btn-primary btn-sm',
          exportOptions: {
            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
          },
        }
    ],
    "processing": true,
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

  //Formato numerico: 00,000.00
  function format_number(number){
    return number.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
  
  function remove_commas(number){
    return number.replace(/,/g, "");
  }
  