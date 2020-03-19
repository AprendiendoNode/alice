$(function() {
  getCxCdata();
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
          
          
        }
    });

    function getCxCdata(){
      var form = $('#form')[0];
          var formData = new FormData(form);
          /*  DATA CXC */
          $.ajax({
            type: "POST",
            url: "/accounting/cxc_data",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
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
                            <a class="dropdown-item" href="javascript:void(0);" onclick="" data-id=""  value=""><span class="fa fa-eye"></span> Ver factura</a>
                            </div>
                        </div>`;  

      vartable.fnAddData([
        dropdown,
        information.cliente,
        information.fecha,
        information.documento,
        information.vencimiento,
        `$${information.Por_Vencer}`,
        `$${information._0_30_dias}`,
        `$${information._31_60_dias}`,
        `$${information._61_90_dias}`,
        `$${information._91_120_dias}`,
        `$${information._121_150_dias}`,
        `$${information._151_180_dias}`,
        `$${information.mas_de_180_dias}`,
        `$${information._1mes}`,
        `$${information._2meses}`,
        `$${information.mas_de_3meses}`,
        information.moneda,
        `$${information.total}`,
        information.semana
      ]);
    });
  }

  var Configuration_table_responsive_cxc = {
    "order": [[ 1, "asc" ]],
    "select": false,
    "aLengthMenu": [[25, -1], [25, "Todos"]],
    "columnDefs": [
      {
        "targets" : [2, 4, 16, 18],
        "className" : "text-center"
      },
      {
        "targets" : [ 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 17],
        "className" : "text-right"
      },  
    ],
    dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",

      buttons: [
        {
          extend: 'excelHtml5',
          title: 'Cuentas x cobrar',
          init: function(api, node, config) {
             $(node).removeClass('btn-secondary')
          },
          text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
          titleAttr: 'Excel',
          className: 'btn btn-success btn-sm',
          exportOptions: {
              columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]
          },
        },
        {
          extend: 'csvHtml5',
          title: 'Cuentas x cobrar',
          init: function(api, node, config) {
             $(node).removeClass('btn-secondary')
          },
          text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
          titleAttr: 'CSV',
          className: 'btn btn-primary btn-sm',
          exportOptions: {
            columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]
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
  