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
          /*  DATA POLIZAS GENERAL */
          $.ajax({
            type: "POST",
            url: "/accounting/get_diario_general",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
              table_filter_general(data, $("#tabla_diario_general"));
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
          /*  DATA POLIZAS DETALLE */
          $.ajax({
            type: "POST",
            url: "/accounting/get_diario_detalle",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
                console.log(data);
              table_filter_detalle(data, $("#tabla_diario_detalle"));
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

function table_filter_general(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_diario_polizas_general);
    vartable.fnClearTable();
    
    $.each(datajson, function(index, information){
      let dropdown = `<div class="btn-group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                          <a class="dropdown-item" href="javascript:void(0);" onclick="get_movs_by_poliza(${information.id})" data-id="${information.id}"  value="${information.id}"><span class="fa fa-eye"></span> Ver detalle</a>
                          <a class="dropdown-item" href="javascript:void(0);" onclick="delete_poliza(${information.id})" data-id="${information.id}"><span class="fas fa-window-close"></span> Cancelar poliza</a>
                        </div>
                      </div>`;    
      let mes = moment().month(information.mes - 1).format("MMMM");
      vartable.fnAddData([
        information.id,//Id de poliza
        dropdown,
        information.anio,
        mes,
        `${information.clave} ${information.tipo_poliza}`,
        information.numero,
        information.dia,
        information.descripcion,
        format_number(parseFloat(information.total_cargos)),
        format_number(parseFloat(information.total_abonos)),
        information.created_at,
        information.updated_at
      ]);
    });
  }

  function table_filter_detalle(datajson, table){
      table.DataTable().destroy();
      var vartable = table.dataTable(Configuration_table_diario_polizas_detalle);
      vartable.fnClearTable();
      
      $.each(datajson, function(index, information){
        let dropdown = `<div class="btn-group">
                          <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="javascript:void(0);" onclick="get_movs_by_poliza(${information.poliza_id})" data-id="${information.poliza_id}"  value="${information.poliza_id}"><span class="fa fa-eye"></span> Ver detalle</a>                  
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

    function get_movs_by_poliza(id_poliza){
      let _token = $('meta[name="csrf-token"]').attr('content');
      
      $("#tabla_asiento_contable tbody").empty();
    
      $.ajax({
          type: "POST",
          url: '/accounting/get-movs-by-poliza',
          data: {poliza_id: id_poliza , _token : _token},
          success: function (data) {     
          
            $('#data_asientos').html(data);
            $("#modal_view_poliza").modal("show");
          },
          error: function (err) {
            Swal.fire({
                type: 'error',
                title: 'La poliza no existe...',
                text: err.statusText,
              });
          }
      })
    }
/**************************ELIMINANDO POLIZAS***********************************/
  function delete_poliza(id_poliza){
    
    let _token = $('input[name="_token"]').val();
    let data = {
      id_poliza: id_poliza
    };

    Swal.fire({
      title: "¿Estás seguro?",
      text: "Se eliminaran todos los movimientos de esta póliza",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirmar',
      cancelButtonText: 'Cancelar',
      showLoaderOnConfirm: true,
      preConfirm: () => {
           
        const headers = new Headers({        
           "Accept": "application/json",
           "X-Requested-With": "XMLHttpRequest",
           'Content-Type': 'application/json',
           "X-CSRF-TOKEN": _token
        })

        var miInit = { method: 'post',
                           headers: headers,
                           credentials: "same-origin",
                           body: JSON.stringify(data),
                           cache: 'default' };

         return fetch('/accounting/customer-polizas-delete', miInit)
               .then(function(response){
                 if (!response.ok) {
                    throw new Error(response.statusText)
                  }
                 return response.text();
               })
               .catch(function(error){
                 Swal.showValidationMessage(
                   `Request failed: ${error}`
                 )
               });
      }//Preconfirm
    }).then((result) => {
      if (result.value == 1) {
        Swal.fire({
          title: 'Poliza eliminada',
          text: "",
          type: 'success',
        }).then(function (result) {
          if (result.value) {
            window.location = "/accounting/view_diario_general";
          }
        })
      }else if(result.value == 2){
        Swal.fire(
          'El ejercicio se encuentra cerrado','No tienes permiso para eliminar polizas','warning'
        )
      }else if(result.value == 3){
        Swal.fire(
          'Este periodo se encuentra cerrado','No se permiten modificaciones','warning'
        )
      }else{
        Swal.fire(
          'No se guardo la poliza','','error'
        )
      }
    })

  }

/**********************************************************************************/

function get_movs_by_poliza(id_poliza){
  let _token = $('meta[name="csrf-token"]').attr('content');
  
  $("#tabla_asiento_contable tbody").empty();

  $.ajax({
      type: "POST",
      url: '/accounting/get-movs-by-poliza',
      data: {poliza_id: id_poliza , _token : _token},
      success: function (data) {     
       
        $('#data_asientos').html(data);
        $("#modal_view_poliza").modal("show");
      },
      error: function (err) {
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: err.statusText,
          });
      }
  })
}

/*
*****************************  ACTUALIZANDO PÓLIZAS ***************************
*/ 

$('#form_update_asientos_contables').on('submit', function(e){
  e.preventDefault();
  let date_invoice = remove_commas($('#date_invoice').val());
  let total_cargos = remove_commas($('#total_cargos').val());
  total_cargos = parseFloat(total_cargos);
  let total_abonos = remove_commas($('#total_abonos').val());
  total_abonos = parseFloat(total_abonos);

  if(check_totales_asientos(total_cargos, total_abonos)){

    Swal.fire({
      title: "¿Estás seguro?",
      text: "",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirmar',
      cancelButtonText: 'Cancelar',
      showLoaderOnConfirm: true,
      preConfirm: () => {
        
        var _token = $('input[name="_token"]').val();
        
        var element = {}
        var asientos = [];

        $('#tabla_asiento_contable tbody tr').each(function(row, tr){
          let id = $(tr).find('.id').val();
          let id_factura = $(tr).find('.id_factura').val();       
          let cuenta_contable = $(tr).find('.cuenta_contable').val();
          let dia = $(tr).find('.dia').val();
          let tipo_cambio = $(tr).find('.tipo_cambio').val();
          let nombre = $(tr).find('.nombre').val();
          let cargo = $(tr).find('.cargos').val();
          let abono = $(tr).find('.abonos').val();
          let referencia = $(tr).find('.referencia').val();    
          
          element = {
            "id" : id,
            "factura_id" : id_factura,
            "cuenta_contable_id" : cuenta_contable,
            "dia" : dia,
            "tipo_cambio" : tipo_cambio,
            "nombre" : nombre,
            "cargo" : parseFloat(cargo),
            "abono" : parseFloat(abono),
            "referencia" : referencia          
          }
    
          asientos.push(element);
    
        });
    
        let form = $('#form_update_asientos_contables')[0];
        let formData = new FormData(form);

        formData.append('date_invoice',date_invoice);
        formData.append('movs_polizas',JSON.stringify(asientos)); 
        formData.append('total_cargos_format',total_cargos);
        formData.append('total_abonos_format',total_abonos);  

        const headers = new Headers({        
           "Accept": "application/json",
           "X-Requested-With": "XMLHttpRequest",
           "X-CSRF-TOKEN": _token
        })

        var miInit = { method: 'post',
                           headers: headers,
                           credentials: "same-origin",
                           body:formData,
                           cache: 'default' };

         return fetch('/accounting/update-poliza-movs', miInit)
               .then(function(response){
                 if (!response.ok) {
                    throw new Error(response.statusText)
                  }
                 return response.text();
               })
               .catch(function(error){
                 Swal.showValidationMessage(
                   `Request failed: ${error}`
                 )
               });
      }//Preconfirm
    }).then((result) => {
      console.log(result.value);
      if (result.value == "true") {
        Swal.fire({
          title: 'Poliza actualizada',
          text: "",
          type: 'success',
        }).then(function (result) {
          if (result.value) {
            window.location = "/accounting/view_diario_general";
          }
        })
      }else{
        Swal.fire(
          'No se guardo la poliza','','warning'
        )
      }
    })

  }else{
    Swal.fire(
      'Los totales no coinciden',
      'Revisar los saldos de los cargos y abonos',
      'warning'
    );
  }
  
});

////////////////////////////////////////////////////////////////


  var Configuration_table_diario_polizas_general = {
    "order": [[ 3, "asc" ]],
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
        "className": "text-center",
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
        "targets": 11,
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

  var Configuration_table_diario_polizas_detalle = {
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

  /********************    funciones de ayuda    *******************/

  function check_totales_asientos(total_cargos,total_abonos){
    if(parseFloat(total_cargos) != parseFloat(total_abonos)){
      return false;
    }else{
      return true
    }
  }

  function suma_total_asientos(){
    let inputs_cargos = document.querySelectorAll('.cargos');
    let inputs_abonos = document.querySelectorAll('.abonos');
    let total_cargos = 0.0;
    let total_abonos = 0.0;
    
    for (i = 0; i < inputs_cargos.length; ++ i){
      total_cargos+= parseFloat(inputs_cargos[i].value);
    }
  
    for (i = 0; i < inputs_abonos.length; ++ i){
      total_abonos+= parseFloat(inputs_abonos[i].value);
    }
  
    $('#total_cargos').val(format_number(total_cargos));
    $('#total_abonos').val(format_number(total_abonos));
  
    if(check_totales_asientos(total_cargos,total_abonos)){
      $('#total_cargos').css('border-color', '#28a745');
      $('#total_abonos').css('border-color', '#28a745');
    }else{
      $('#total_cargos').css('border-color', '#dc3545');
      $('#total_abonos').css('border-color', '#dc3545');
    }
  
  }

  //Formato numerico: 00,000.00
  function format_number(number){
      return number.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
  
  function remove_commas(number){
    return number.replace(/,/g, "");
  }