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
            url: "/accounting/customer-polizas-search",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
              table_filter(data, $("#table_filter_fact"));
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
    var vartable = table.dataTable(Configuration_table_responsive_doctypes);
    vartable.fnClearTable();
    $.each(JSON.parse(datajson), function(index, information){
      var status = information.status;
      var mail = information.mail_sent;     
      var html = "";

      if (parseInt(status) == OPEN) {
          html = '<span class="badge badge-info">{{__("customer_invoice.text_status_open")}}</span>';
      } else if (parseInt(status) == PAID) {
          html = '<span class="badge badge-primary">{{__("customer_invoice.text_status_paid")}}</span>';
      } else if (parseInt(status) == CANCEL) {
          html = '<span class="badge badge-default">{{__("customer_invoice.text_status_cancel")}}</span>';
      } else if (parseInt(status) == CANCEL_PER_AUTHORIZED) {
          html = '<span class="badge badge-dark">{{__("customer_invoice.text_status_cancel_per_authorized")}}</span>';
      } else if (parseInt(status) == RECONCILED) {
          html = '<span class="badge badge-success">{{__("customer_credit_note.text_status_reconciled")}}</span>';
      }

      if (parseInt(mail) != 0) {
          mail_status = '<i class="fas fa-check text-success"></i>';
      }
      else {
        mail_status = '<i class="fas fa-times text-danger"></i>';
      }

      var a01 = '<div class="btn-group">';
      var a02 = '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>';
      var a03 = '<div class="dropdown-menu">';
      var a04 = '<a class="dropdown-item" target="_blank" href="/sales/customer-invoice-pdfs/'+information.id+'"><i class="fa fa-eye"></i> Ver</a>';
      var a05 = '', a06 ='', a07 ='', a08 ='', a09 ='', a10 ='', a11 ='', a12 ='', a13 ='', a14 ='', a15 ='', a16='', a17='', a19='';
      
       
      if ( information.uuid != "" ) {
        a19 = '<a class="dropdown-item" href="javascript:void(0);" onclick="cancel_poliza(this)" value="'+information.id+'" datas="'+information.name+'" ><i class="fas fa-file-alt"></i> Cancelar póliza</a>';
      }
      
      var a18 = '</div>';
      var dropdown = a01+a02+a03+a04+a05+a06+a07+a08+a09+a10+a11+a12+a19+a13+a14+a15+a16+a17+a18;

      vartable.fnAddData([
        information.id,
        dropdown,
        information.name,
        information.date,
        information.uuid,
        information.customer,
        information.date_due,
        information.currency,
        information.amount_total,
        information.balance,
        information.contabilizado
      ]);
    });
  }
  
    $('.datepicker').datepicker({
      language: 'es',
      format: "yyyy-mm-dd",
      viewMode: "days",
      minViewMode: "days",
      //endDate: '1m',
      autoclose: true,
      clearBtn: true
    });
 
  var Configuration_table_responsive_doctypes = {
    "order": [[ 3, "asc" ]],
    "select": true,
    "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
    "columnDefs": [
      {
        "targets": 0,
        "checkboxes": {
          'selectRow': true
        },
        "width": "0.1%",
        "createdCell": function (td, cellData, rowData, row, col){
          if ( cellData > 0 ) {
            if(rowData[10] == 1){
              this.api().cell(td).checkboxes.disable();
              $(td).parent().attr('style', 'background: #D6FFBE !important');
            }           
          }
        },  
        "className": "text-center",
      },
      {
        "targets": 10,
        "width": "1.0%",
        "visible": false
      },
    ],
    dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      
      buttons: [
        {
          text: '<i class=""></i> Contabilizar',
          titleAttr: 'Contabilizar',
          className: 'btn bg-dark',
          init: function(api, node, config) {
            $(node).removeClass('btn-default')
          },
          action: function ( e, dt, node, config ) {
              
            var rows_selected = $("#table_filter_fact").DataTable().column(0).checkboxes.selected();
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

/*
*****************************  GUARDANDO PÓLIZAS ***************************
*/ 

$('#form_save_asientos_contables').on('submit', function(e){
  e.preventDefault();
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
          let id_factura = $(tr).find('.id_factura').val();
          let cuenta_contable = $(tr).find('.cuenta_contable').val();
          let dia = $(tr).find('.dia').val();
          let tipo_cambio = $(tr).find('.tipo_cambio').val();
          let nombre = $(tr).find('.nombre').val();
          let cargo = $(tr).find('.cargos').val();
          let abono = $(tr).find('.abonos').val();
          let referencia = $(tr).find('.referencia').val();    
          
          element = {
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
    
        let form = $('#form_save_asientos_contables')[0];
        let formData = new FormData(form);
    
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

         return fetch('/accounting/customer-polizas-save-movs', miInit)
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
          title: 'Poliza guardada',
          text: "",
          type: 'success',
        }).then(function (result) {
          if (result.value) {
            window.location = "/accounting/customer-polizas-show";
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

function cancel_poliza(e){
  let id_invoice = e.getAttribute('value');
  let _token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      type: "POST",
      url: '/accounting/customer-polizas-cancel',
      data: {id_invoice : id_invoice, _token : _token},
      success: function (data) {
        if(data.code == 200){
          Swal.fire('Operación completada!', data.message, 'success')
          .then(()=> {
            location.href ="/accounting/customer-polizas-show";
          });
        }
        
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

//Formato numerico: 00,000.00
function format_number(number){
  return number.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function remove_commas(number){
  return number.replace(/,/g, "");
}
