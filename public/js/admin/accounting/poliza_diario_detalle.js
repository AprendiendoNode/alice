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
          $.ajax({
            type: "POST",
            url: "/accounting/get_diario_detalle",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
                console.log(data);
              table_filter(data, $("#tabla_diario_general"));
              if (typeof data !== 'undefined' && data.length > 0) {
                console.log(data.length);
              }
              else {

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
    /*$("#form input[name='filter_date_to']").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD-MM-YYYY'
        },
        autoUpdateInput: false,
    }, function (chosen_date) {
        $("#form input[name='filter_date_to']").val(chosen_date.format('DD-MM-YYYY'));
    });*/
    $("#filter_customer_id").select2();
    //-----------------------------------------------------------
  });

function table_filter(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_diario_polizas);
    vartable.fnClearTable();
    
    $.each(datajson, function(index, information){
      let dropdown = `<div class="btn-group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                          <a class="dropdown-item" href="javascript:void(0);" onclick="" data-id="${information.id}"  value="${information.id}"><span class="fa fa-eye"></span> Ver detalle</a>
                  
                        </div>
                      </div>`;    
      let mes = moment().month(information.mes - 1).format("MMMM");
      vartable.fnAddData([
        information.id,//Id de poliza
        dropdown,
        '',
        information.cuenta,
        information.nombre,
        information.dia,
        information.exchange_rate,
        information.descripcion,
        format_number(parseFloat(information.cargos)),
        format_number(parseFloat(information.abonos)),
        information.referencia,
        information.created_at,
        information.updated_at
      ]);
    });
  }

  var Configuration_table_diario_polizas = {
    "order": [[ 0, "asc" ]],
    "select": true,
    "aLengthMenu": [[10, 25, -1], [10, 25, "All"]],
    "columnDefs": [
      {
        "targets": 0,
        "checkboxes": {
          'selectRow': true
        },
        "width": "0.1%",
        "createdCell": function (td, cellData, rowData, row, col){
          
        },  
        "className": "text-center",
        "visible": false,
      },
      {
        "targets": 1,
        "width": "1.0%",
      },
      {
        "targets": 2,
        "width": "1.0%",
        "className": "text-center",
      },
      {
        "targets": 3,
        "width": ".5%",
        "className": "text-left",
      },
      {
        "targets": 4,
        "width": "1.0%",
      },
      {
        "targets": 5,
        "width": ".5%",
        "className": "text-center",
      },
      {
        "targets": 6,
        "width": "1.0%",
        "className": "text-center",
      },
      {
        "targets": 7,
        "width": "1.0%",
      },
      {
        "targets": 8,
        "width": "1.0%",
        "className": "text-right font-weight-bold",
      },
      {
        "targets": 9,
        "width": "1.0%",
        "className": "text-right font-weight-bold",
      },
      {
        "targets": 10,
        "width": ".7%",
      },
      {
        "targets": 10,
        "width": ".7%",
      }   
    ],
    dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      
      buttons: [
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