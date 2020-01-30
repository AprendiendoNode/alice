$(function() {
  $('.cuenta_contable').select2();
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
            url: "/sales/customer-polizas-search",
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
      if ( parseInt(status) == OPEN || parseInt(status) == PAID || parseInt(status) == CANCEL && information.uuid != ""  ) {
        a05 = '<a class="dropdown-item" href="/sales/customer-invoices/download-xml/'+information.id+'"><i class="far fa-file-code"></i>Descargar XML</a>';
        
      }
        a06 = '<a class="dropdown-item" href="javascript:void(0);" onclick="contabilizar_poliza(this)" value="'+information.id+'" datas="'+information.name+'"><i class="fas fa-wallet"></i> Contabilizar</a>';
      if ( information.uuid != "" ) {
        a19 = '<a class="dropdown-item" href="javascript:void(0);" onclick="cancel_poliza(this)" value="'+information.id+'" datas="'+information.name+'" ><i class="fas fa-file-alt"></i> Cancelar póliza</a>';
      }
      
      var a18 = '</div>';
      var dropdown = a01+a02+a03+a04+a05+a06+a07+a08+a09+a10+a11+a12+a19+a13+a14+a15+a16+a17+a18;

      vartable.fnAddData([
        dropdown,
        information.name,
        information.date,
        information.uuid,
        information.customer,
        information.date_due,
        information.currency,
        information.amount_total,
        information.balance,
      ]);
    });
  }

  $('.table-responsive').on('show.bs.dropdown', function () {
       $('.table-responsive').css( "overflow", "inherit" );
  });

  $('.table-responsive').on('hide.bs.dropdown', function () {
       $('.table-responsive').css( "overflow", "auto" );
  })

  
    $(".swal-wide").scrollTop(0);
    var $options = $("#aux > option").clone();
    $('#banco').append($options);
    // $('#factura').val(name_fact);
    $('.datepicker').datepicker({
      language: 'es',
      format: "yyyy-mm-dd",
      viewMode: "days",
      minViewMode: "days",
      //endDate: '1m',
      autoclose: true,
      clearBtn: true
    });
  
 
  var Configuration_table_responsive_history={
    dom: "<'row'<'col-sm-3'l><'col-sm-9'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    "order": [[ 0, "asc" ]],
    paging: true,
    //"pagingType": "simple",
    Filter: true,
    searching: false,
    "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
    //ordering: false,
    //"pageLength": 5,
    bInfo: false,
        language:{
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
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
  }

  var Configuration_table_responsive_doctypes = {
    "columnDefs": [
        
    ],
    dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      "order": [[ 7, "asc" ]],
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

function cancel_poliza(e){
  let id_invoice = e.getAttribute('value');
  let _token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      type: "POST",
      url: '/sales/customer-polizas-cancel',
      data: {id_invoice : id_invoice, _token : _token},
      success: function (data) {
        if(data.code == 200){
          Swal.fire('Operación completada!', data.message, 'success')
          .then(()=> {
            location.href ="/sales/customer-polizas-show";
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

function contabilizar_poliza(e){
  let id_invoice = e.getAttribute('value');
  let _token = $('meta[name="csrf-token"]').attr('content');
  let today = new Date();
  let dd = String(today.getDate()).padStart(2, '0');
  let mes = moment().format('MMMM');
  let mes_digit =  moment().format('MM');
  let year = moment().format('YYYY');
  
  $('#day_poliza').val(dd);
  $('#mes_poliza').val(mes);
  $("#tabla_asiento_contable tbody").empty();

  $.ajax({
      type: "POST",
      url: '/sales/customer-polizas-getdata',
      data: {id_invoice : id_invoice, _token : _token},
      success: function (data) {
        
        let suma_cargos = 0.0;
        let suma_abonos = 0.0;
        data.forEach(function(key){

          let abono = format_number(parseFloat(key.abono));
          let cargo = format_number(parseFloat(key.cargo));
          suma_abonos+= parseFloat(key.abono);
          suma_cargos+= parseFloat(key.cargo);

          $('#tabla_asiento_contable > tbody:last-child').append(
          `<tr>
            <td>${key.mov}</td>
            <td>
              <select style="width:200px;" class="form-control form-control-sm cuenta_contable select2">
                <option value=""></option>
                <option value="">2121</option>
              </select>
            </td>
            <td>${dd}</td>
            <td>${key.currency_id}</td>
            <td class=""><input style="width:180px;text-align:right" class="form-control form-control-sm" type="text" value="${key.name} ${dd}/${mes_digit}/${year}"></td>
            <td><input style="width:120px;text-align:right" class="form-control form-control-sm cargos" type="text" value="${cargo}" ></td>
            <td><input style="width:120px;text-align:right" class="form-control form-control-sm" abonos" type="text" value="${abono}" ></td> 
            <td></td>
            </tr>
            `
          );
          
        });

        $('#total_cargos').val(format_number(suma_cargos));
        $('#total_abonos').val(format_number(suma_abonos));
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


//Formato numerico: 00,000.00
function format_number(number){
  return number.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function remove_commas(number){
  return number.replace(/,/g, "");
}
