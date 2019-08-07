var token = $('input[name="_token"]').val();
$(function(){
  cx_sat.unshift({value: 0, text: "Elija..."});
  //console.log(cx_sat);
  mens_tb(token);
  $('.dateInput').datepicker({
    language: 'es',
    format: "yyyy-mm-dd",
    viewMode: "days",
    minViewMode: "days",
    autoclose: true,
    clearBtn: true
  });
  $('.dateInput').val('').datepicker('update');
}());

$(".btnsave2").click(function () {
  var formData = new FormData($('#form')[0]);
  var token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "/recordmens_data",
    data: formData,
    contentType: false,
    processData: false,
    success: function(data)
    {
      if (data === '1') {
        swal("Operación Completada!", "El pago ha sido programado.", "success");
        mens_tb(token);
        $('#modal_default').modal('hide');
      }
      else{
        swal("Operación abortada!", "No se realizo ningun cambio.", "error");
        $('#modal_default').modal('hide');
      }
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      // Our error logic here
      var msg = '';
      if (jqXHR.status === 0) {
        msg = 'Not connect.\n Verify Network.';
      } else if (jqXHR.status == 404) {
        msg = 'Requested page not found. [404]';
      } else if (jqXHR.status == 500) {
        msg = 'Internal Server Error [500].';
      } else if (exception === 'parsererror') {
        msg = 'Requested JSON parse failed.';
      } else if (exception === 'timeout') {
        msg = 'Time out error.';
      } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
      } else {
        msg = 'Uncaught Error.\n' + jqXHR.responseText;
      }
      console.log(msg);
    }
  });
});

function mens_tb(token) {
  var _token = token;
  $.ajax({
      type: "POST",
      url: "/recordmens",
      data: { _token : _token },
      success: function (data){
        generate_table(data, $('#mens_table'));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function generate_table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable({
      "order": [[ 0, "asc" ]],
      paging: true,
      //"pagingType": "simple",
      Filter: true,
      searching: true,
      "select": true,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      "columnDefs": [
          {
            "targets": 0,
            "checkboxes": {
              'selectRow': true
            },
            "width": "1%",
            "createdCell": function (td, cellData, rowData, row, col){

            }
          },
          {
              "type": "html",
              "targets": [5,11,12,13,14,15,16,17,18],
          }
      ],
      "select": {
          'style': 'multi',
      },
      //ordering: false,
      //"pageLength": 5,
      dom: "<'row'<'col-sm-6'B><'col-sm-3'l><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
        {
          text: '<i class="fa fa-check margin-r5"></i> Aplicar fechas',
          titleAttr: 'Aplicar fechas seleccionadas',
          className: 'btn btn-basic aux',
          init: function(api, node, config) {
             $(node).removeClass('btn-default')
          },
          action: function ( e, dt, node, config ) {
            // $('#modal-confirmation').modal('show');
            swal({
              title: "Estás seguro?",
              text: "Se aplicará la fecha a los seleccionados.!",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Continuar.!",
              cancelButtonText: "Cancelar.!",
              closeOnConfirm: false,
              closeOnCancel: false
            },
            function(isConfirm) {
              if (isConfirm) {
                $('.cancel').prop('disabled', 'disabled');
                $('.confirm').prop('disabled', 'disabled');
                var rows_selected = $("#mens_table").DataTable().column(0).checkboxes.selected();
                var fc = $('#date_compromise').val();
                var ff = $('#date_factura').val();
                var _token = $('input[name="_token"]').val();
                // Iterate over all selected checkboxes
                var valores= new Array();
                $.each(rows_selected, function(index, rowId){
                    valores.push(rowId);
                });
                if ( valores.length === 0){
                  swal("Operación abortada", "Ningún registro seleccionado :(", "error");
                }
                else {
                    $.ajax({
                        type: "POST",
                        url: "/send_dates_cxp",
                        data: { idents: JSON.stringify(valores), _token: _token, date_compromise: fc, date_factura: ff },
                        success: function (data){
                          //console.log(data);
                          if (data === '1') {
                            swal("Operación Completada!", "Los registros seleccionados han sido afectados.", "success");
                            mens_tb(token);
                          }
                          if (data === '0') {
                            swal("Operación abortada!", "Favor de seleccionar una fecha para aplicar la operación.", "error");
                          }
                        },
                        error: function (data) {
                          console.log('Error:', data);
                        }
                    });
                }

              } else {
                swal("Operación abortada", "Ningún registro afectado :)", "error");
              }
            });
          }
        },
        {
          text: '<i class="fa fa-check margin-r5"></i> Aprobar / facturación.',
          titleAttr: 'Aprobado para facturación.',
          className: 'btn btn-warning aux',
          init: function(api, node, config) {
            $(node).removeClass('btn-default')
          },
          action: function ( e, dt, node, config ) {
            // $('#modal-confirmation').modal('show');
            swal({
              title: "Estás seguro?",
              text: "Se pasaran a facturación todos los registros seleccionados.!",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Continuar.!",
              cancelButtonText: "Cancelar.!",
              closeOnConfirm: false,
              closeOnCancel: false
            },
            function(isConfirm) {
              if (isConfirm) {
                $('.cancel').prop('disabled', 'disabled');
                $('.confirm').prop('disabled', 'disabled');
                var rows_selected = $("#mens_table").DataTable().column(0).checkboxes.selected();
                var _token = $('input[name="_token"]').val();
                // Iterate over all selected checkboxes
                var valores= new Array();
                $.each(rows_selected, function(index, rowId){
                  valores.push(rowId);
                });
                if ( valores.length === 0){
                  swal("Operación abortada", "Ningún registro seleccionado :(", "error");
                }
                else {
                  $.ajax({
                    type: "POST",
                    url: "/send_contracts_fact",
                    data: { idents: JSON.stringify(valores), _token : _token },
                    success: function (data){
                      console.log(data);
                      if (data === '1') {
                        swal("Operación Completada!", "Los registros seleccionados han sido afectados.", "success");
                        mens_tb(token);
                      }else {
                        swal("Operación abortada!", "Los registros seleccionados no han sido afectados.", "error");
                        mens_tb(token);
                      }
                    },
                    error: function (data) {
                      console.log('Error:', data);
                    }
                  });
                }

              } else {
                swal("Operación abortada", "Ningúna registro afectado :)", "error");
              }
            });
          }
        },
        {
          text: '<i class="fa fa-check margin-r5"></i> Cambio de concepto.',
          titleAttr: 'Cambio de concepto para facturación.',
          className: 'btn btn-info aux',
          init: function(api, node, config) {
            $(node).removeClass('btn-default')
          },
          action: function ( e, dt, node, config ) {
            // $('#modal-confirmation').modal('show');
            swal({
              title: "Estás seguro?",
              text: "Se cambiará el concepto de los elementos seleccionados!",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Continuar.!",
              cancelButtonText: "Cancelar.!",
              closeOnConfirm: false,
              closeOnCancel: false
            },
            function(isConfirm) {
              if (isConfirm) {
                $('.cancel').prop('disabled', 'disabled');
                $('.confirm').prop('disabled', 'disabled');
                var rows_selected = $("#mens_table").DataTable().column(0).checkboxes.selected();
                var _token = $('input[name="_token"]').val();
                var concept = $('#upd_concept').val();
                // Iterate over all selected checkboxes
                var valores= new Array();
                $.each(rows_selected, function(index, rowId){
                  valores.push(rowId);
                });
                if ( valores.length === 0 || concept === ""){
                  swal("Operación abortada", "Ningún registro seleccionado, seleccione un concepto de facturación y un contrato.", "error");
                }
                else {
                  $.ajax({
                    type: "POST",
                    url: "/send_conceptsat",
                    data: { idents: JSON.stringify(valores),concept: concept, _token : _token },
                    success: function (data){
                      console.log(data);
                      if (data === '1') {
                        swal("Operación Completada!", "Los registros seleccionados han sido afectados.", "success");
                        $('#upd_concept').val('').trigger('change');
                        mens_tb(token);
                      }else {
                        swal("Operación abortada!", "Los registros seleccionados no han sido afectados.", "error");
                        mens_tb(token);
                      }
                    },
                    error: function (data) {
                      console.log('Error:', data);
                    }
                  });
                }
              } else {
                swal("Operación abortada", "Ningúna registro afectado :)", "error");
              }
            });
          }
        },
        {
          extend: 'excelHtml5',
          text: '<i class="far fa-file-excel"></i> Excel',
          titleAttr: 'Excel',
          title: function ( e, dt, node, config ) {
            return 'Reporte de mensualidades';
          },
          init: function(api, node, config) {
             $(node).removeClass('btn-default')
          },
          className: 'btn btn-success custombtntable aux',
        }
      ],
      //bInfo: false,
      "drawCallback": function( settings ) {
        var api = this.api();
        var _token = $('input[name="_token"]').val();
          // Output the data for the visible rows to the browser's console
          // console.log( api.rows( {page:'current'} ).data() );
          /*
            editable_monto
            editable_descuento
            editable_iva
            editable_tc
          */
          //getSelectStatus();
          //Editable 0 - editable_concept
          $('.editable_concept', api.table().body())
            .editable({
              mode: 'inline',
              type: 'select',
              source: cx_sat,
              success : function(response, newValue) {
                var current_pk = $(this).data('pk');
                console.log(current_pk);
                console.log(newValue);
                $.ajax({
                    type: "POST",
                    url: "/upd_conceptsat",
                    data: {
                      _token : _token,
                      v_data  : current_pk,
                      v_reg  : newValue,
                    },
                    success: function (data){
                      if (data === '1') {
                        swal("Operación completada!", "Operation complete", "success");
                      }
                      else{
                        swal("Operación abortada!", ":)", "error");
                      }
                    },
                    error: function (data) {
                      console.log('Error:', data);
                    }
                });
              }
            })
            .off('hidden')
            .on('hidden', function(e, reason){
              var current_pk = $(this).data('pk');
              if(reason === 'save') {
                // var xxx2= $('#conc_'+current_pk).attr('data-value', $(this).find(":selected").val());
                // console.log(xxx2);
                //api.rows().invalidate('dom').draw();
              }
            });
          //Editable 1 - editable_monto
            $('.editable_monto', api.table().body())
              .editable({ mode: 'inline', emptytext: '0' })
              .off('hidden')
              .on('hidden', function(e, reason) {
                 var current_pk = $(this).data('pk');
                 if(reason === 'save') {
                     $('#mt_'+current_pk).attr('data-order', $(this).text());
                     $('#mt_'+current_pk).attr('data-value', $(this).text());
                     $('#mt_'+current_pk).editable('setValue',$(this).text());

                         var monto = $('#mt_'+current_pk).attr('data-value');
                     var descuento = $('#ds_'+current_pk).attr('data-value');
                      var subtotal = (monto-descuento).toFixed(2);
                       var org_iva = $('#iva_'+current_pk).attr('data-value');
                           var iva = '1.'+$('#iva_'+current_pk).attr('data-value');
                     var mens_civa = (subtotal*iva).toFixed(2);

                    var mens_rf_tc = $('#tc_'+current_pk).attr('data-value');
                    if (mens_rf_tc <= 0) { typo_c = 1; }
                    else {  typo_c = $('#tc_'+current_pk).attr('data-value'); }

                    var mens_total = mens_civa * typo_c;
                    var men_total = mens_total.toFixed(2);

                    //Sobre escritura
                    $('#ds_'+current_pk).editable('setValue',descuento);
                   $('#iva_'+current_pk).editable('setValue',org_iva);
                    $('#tc_'+current_pk).editable('setValue',mens_rf_tc);

                    $('#sub_'+current_pk).text(subtotal);
                  $('#msiva_'+current_pk).text(mens_civa);
                     $('#mf_'+current_pk).text(men_total);

                     $.ajax({
                         type: "POST",
                         url: "/upd_monthly",
                         data: {
                           _token : _token,

                           v_data  : current_pk,
                           v_monto : monto,
                           v_desct : descuento,
                           v_subtt : subtotal,
                             v_iva : org_iva,
                          v_ms_iva : mens_civa,
                          v_typecb : mens_rf_tc,
                          v_mens_t : men_total,
                         },
                         success: function (data){
                           if (data === '1') {
                             mens_tb(token);
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
          //Editable 2 - editable_descuento
            $('.editable_descuento', api.table().body())
              .editable({ mode: 'inline', emptytext: '0' })
              .off('hidden')
              .on('hidden', function(e, reason) {
                 var current_pk = $(this).data('pk');
                 if(reason === 'save') {
                   $('#ds_'+current_pk).attr('data-order', $(this).text());
                   $('#ds_'+current_pk).attr('data-value', $(this).text());
                   $('#ds_'+current_pk).editable('setValue',$(this).text());

                           var monto = $('#mt_'+current_pk).attr('data-value');
                       var descuento = $('#ds_'+current_pk).attr('data-value');
                        var subtotal = (monto-descuento).toFixed(2);
                         var org_iva = $('#iva_'+current_pk).attr('data-value');
                             var iva = '1.'+$('#iva_'+current_pk).attr('data-value');
                       var mens_civa = (subtotal*iva).toFixed(2);

                      var mens_rf_tc = $('#tc_'+current_pk).attr('data-value');
                      if (mens_rf_tc <= 0) { typo_c = 1; }
                      else {  typo_c = $('#tc_'+current_pk).attr('data-value'); }

                      var mens_total = mens_civa * typo_c;
                      var men_total = mens_total.toFixed(2);

                      //Sobre escritura
                      $('#ds_'+current_pk).editable('setValue',descuento);
                     $('#iva_'+current_pk).editable('setValue',org_iva);
                      $('#tc_'+current_pk).editable('setValue',mens_rf_tc);

                      $('#sub_'+current_pk).text(subtotal);
                    $('#msiva_'+current_pk).text(mens_civa);
                       $('#mf_'+current_pk).text(men_total);
                       $.ajax({
                           type: "POST",
                           url: "/upd_monthly",
                           data: {
                             _token : _token,

                             v_data  : current_pk,
                             v_monto : monto,
                             v_desct : descuento,
                             v_subtt : subtotal,
                               v_iva : org_iva,
                            v_ms_iva : mens_civa,
                            v_typecb : mens_rf_tc,
                            v_mens_t : men_total,
                           },
                           success: function (data){
                             if (data === '1') {
                               mens_tb(token);
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
          //Editable 3 - editable_iva
            $('.editable_iva', api.table().body())
              .editable({ mode: 'inline', emptytext: '0' })
              .off('hidden')
              .on('hidden', function(e, reason) {
                  var current_pk = $(this).data('pk');
                  if(reason === 'save') {
                    $('#iva_'+current_pk).attr('data-order', $(this).text());
                    $('#iva_'+current_pk).attr('data-value', $(this).text());
                    $('#iva_'+current_pk).editable('setValue',$(this).text());

                          var monto = $('#mt_'+current_pk).attr('data-value');
                      var descuento = $('#ds_'+current_pk).attr('data-value');
                       var subtotal = (monto-descuento).toFixed(2);
                        var org_iva = $('#iva_'+current_pk).attr('data-value');
                            var iva = '1.'+$('#iva_'+current_pk).attr('data-value');
                      var mens_civa = (subtotal*iva).toFixed(2);

                     var mens_rf_tc = $('#tc_'+current_pk).attr('data-value');
                     if (mens_rf_tc <= 0) { typo_c = 1; }
                     else {  typo_c = $('#tc_'+current_pk).attr('data-value'); }

                     var mens_total = mens_civa * typo_c;
                     var men_total = mens_total.toFixed(2);

                     //Sobre escritura
                     $('#ds_'+current_pk).editable('setValue',descuento);
                    $('#iva_'+current_pk).editable('setValue',org_iva);
                     $('#tc_'+current_pk).editable('setValue',mens_rf_tc);

                     $('#sub_'+current_pk).text(subtotal);
                   $('#msiva_'+current_pk).text(mens_civa);
                      $('#mf_'+current_pk).text(men_total);
                      $.ajax({
                          type: "POST",
                          url: "/upd_monthly",
                          data: {
                            _token : _token,

                            v_data  : current_pk,
                            v_monto : monto,
                            v_desct : descuento,
                            v_subtt : subtotal,
                              v_iva : org_iva,
                           v_ms_iva : mens_civa,
                           v_typecb : mens_rf_tc,
                           v_mens_t : men_total,
                          },
                          success: function (data){
                            if (data === '1') {
                              mens_tb(token);
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
          //Editable 4 - editable_tc
            $('.editable_tc', api.table().body())
              .editable({ mode: 'inline', emptytext: '0' })
              .off('hidden')
              .on('hidden', function(e, reason) {
                  var current_pk = $(this).data('pk');
                  if(reason === 'save') {
                    $('#tc_'+current_pk).attr('data-order', $(this).text());
                    $('#tc_'+current_pk).attr('data-value', $(this).text());
                    $('#tc_'+current_pk).editable('setValue',$(this).text());

                            var monto = $('#mt_'+current_pk).attr('data-value');
                        var descuento = $('#ds_'+current_pk).attr('data-value');
                         var subtotal = (monto-descuento).toFixed(2);
                          var org_iva = $('#iva_'+current_pk).attr('data-value');
                              var iva = '1.'+$('#iva_'+current_pk).attr('data-value');
                        var mens_civa = (subtotal*iva).toFixed(2);

                       var mens_rf_tc = $('#tc_'+current_pk).attr('data-value');
                       if (mens_rf_tc <= 0) { typo_c = 1; }
                       else {  typo_c = $('#tc_'+current_pk).attr('data-value'); }

                       var mens_total = mens_civa * typo_c;
                       var men_total = mens_total.toFixed(2);

                       //Sobre escritura
                       $('#ds_'+current_pk).editable('setValue',descuento);
                      $('#iva_'+current_pk).editable('setValue',org_iva);
                       $('#tc_'+current_pk).editable('setValue',mens_rf_tc);

                       $('#sub_'+current_pk).text(subtotal);
                     $('#msiva_'+current_pk).text(mens_civa);
                        $('#mf_'+current_pk).text(men_total);
                        $.ajax({
                            type: "POST",
                            url: "/upd_monthly",
                            data: {
                              _token : _token,

                              v_data  : current_pk,
                              v_monto : monto,
                              v_desct : descuento,
                              v_subtt : subtotal,
                                v_iva : org_iva,
                             v_ms_iva : mens_civa,
                             v_typecb : mens_rf_tc,
                             v_mens_t : men_total,
                            },
                            success: function (data){
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
    }
  );
  vartable.fnClearTable();
  // console.log(datajson);
  suma_totales(datajson);
  $.each(JSON.parse(datajson), function(index, data){
    vartable.fnAddData([
        data.id,
        data.cxclassification,
        data.vertical,
        data.cadena,
        data.key,
        //data.concepto,
        '<a href="javascript:void(0);" id="conc_'+data.id+'" name="conc_'+data.id+'" data-type="select" data-pk="'+ data.id + '" data-url="" data-title="Cambiar concepto" data-value="'+ data.concepto+'" class="editable_concept"></a>',
        data.num_mes_actual,
        data.num_mes_saldo,
        data.num_mes_total,
        data.date_real,
        data.date_final,
        data.currencies,
        '<a href="javascript:void(0);" id="mt_'+data.id+'"    name="mt_'+data.id+'" data-type="text" data-pk="'+ data.id + '" data-url="" data-title="Nuevo monto" data-value="' + data.monto + '"class="editable_monto"></a>',
        '<a href="javascript:void(0);" id="ds_'+data.id+'"    name="ds_'+data.id+'" data-type="text" data-pk="'+ data.id + '" data-url="" data-title="Nuevo descuento" data-value="' + data.descuento + '"class="editable_descuento"></a>',
                                '<span id="sub_'+data.id+'"   name="sub_'+data.id+'">'+data.subtotal+'</span>',
        '<a href="javascript:void(0);" id="iva_'+data.id+'"   name="iva_'+data.id+'" data-type="text" data-pk="'+ data.id +'" data-url="" data-title="Nuevo iva" data-value="' + data.iva_value + '"class="editable_iva"></a>',
                                '<span id="msiva_'+data.id+'" name="msiva_'+data.id+'" style="font-weight:bold;">'+data.mensualidad_civa+'</span>',
        '<a href="javascript:void(0);" id="tc_'+data.id+'"    name="tc_'+data.id+'" data-type="text" data-pk="'+ data.id + '" data-url="" data-title="Nuevo tipo de cambio" data-value="' + data.exchange_range_value + '"class="editable_tc"></a>',
                                '<span id="mf_'+data.id+'"    name="mf_'+data.id+'" style="font-weight:bold;">'+data.monto_final+'</span>',
        '<a href="javascript:void(0);" onclick="adelete(this)" value="'+data.id+'" class="btn btn-danger btn-xs" role="button" data-target="#modal-deny" title="Eliminar"><span class="far fa-trash-alt"></span></a>',
      ]);
  });
  document.getElementById("mens_table_wrapper").setAttribute("class", "dataTables_wrapper form-inline dt-bootstrap no-footer");
  /*var g = document.getElementsByClassName("dt-buttons")[0];
  console.log(g);
  g.style.width = "100%";
  var s = document.getElementsByClassName("dataTables_length")[0].childNodes[0].childNodes[1];
  console.log(s);
  //l.style.width = "100%";
  s.style.display = "inline-block";*/
}

function suma_totales(datajson){
  var suma_monto_total = 0.0;
  $.each(JSON.parse(datajson), function(index, data){
    if(data.monto_final != null){
      suma_monto_total = suma_monto_total + parseFloat(data.monto_final);
    }
  })
  let total_mens = suma_monto_total.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  $('#total_mxn').val(total_mens);
}

function getSelectStatus() {
    var valorsiro = "";
    return $.ajax({
        type: "POST",
        url: "/get_contract_status",
        data: { _token : token },
        //async: false,
        success: function (data){
          valorsiro = data;
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
}

$(".reload_table").click(function () {
  mens_tb(token);
  swal("Operación Completada!", ":)", "success");
});

$(".add_record").click(function () {
  $('#modal_default').modal('show'); // show bootstrap modal
  $('.modal-title').text('Añadir Concepto'); // Set Title to Bootstrap modal title

  $('.addmens')[0].reset();
  $('.addmens').data('formValidation').resetForm($('.addmens'));
  $('#monto').val(0);
  $('#descuento').val(0);
  $('#iva').val(0);
  $('#tc').val(0);
});

function adelete(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  var fecha = $('#date_to_search').val();
  swal({
    title: "Estás seguro?",
    text: "Se eliminará el registro actual.!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Continuar.!",
    cancelButtonText: "Cancelar.!",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm) {
    if (isConfirm) {
      $.ajax({
          type: "POST",
          url: "/delrecord_data",
          data: { val: valor, _token : _token },
          success: function (data) {
            if (data == '1') {
              swal("Operación completada!", " Registrada :)", "success");
              mens_tb(token);
            }
            else {
              swal("Operación abortada", "No hay conexión a internet :(", "error");
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
      });
    }
    else {
      swal("Operación abortada", "Ningún registro afectado :)", "error");
    }
  });
}

$(".btnupdetc").click(function () {
  swal({
    title: "Estás seguro?",
    text: "Se actualizarán todos los tipos de cambio con la moneda seleccionada.!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Continuar.!",
    cancelButtonText: "Cancelar.!",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm) {
    if (isConfirm) {
      $('.cancel').prop('disabled', 'disabled');
      $('.confirm').prop('disabled', 'disabled');
      var tc= $('#tpgeneral').val();
      var cn= $('#updcurrency').val();
      var _token = $('input[name="_token"]').val();
      if (tc != '' && cn != '' ) {
        var formData = new FormData($('#form_tc')[0]);
        $.ajax({
          type: "POST",
          url: "/createtc_gen",
          data: formData,
          contentType: false,
          processData: false,
          success: function(data)
          {
            if (data === '1') {
              swal("Operación Completada!", ":)", "success");
              mens_tb(token);
            }
            if (data === '0') {
              swal("Operación abortada!", ":(", "success");
            }
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            // Our error logic here
            var msg = '';
            if (jqXHR.status === 0) {
              msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
              msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
              msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
              msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
              msg = 'Time out error.';
            } else if (exception === 'abort') {
              msg = 'Ajax request aborted.';
            } else {
              msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            console.log(msg);
          }
        });
      }
      else {
        swal("Operación abortada", "Los dos campos son obligatorios :)", "error");
      }
    }
    else {
      swal("Operación abortada", "Ningún registro afectado :)", "error");
    }
  });
});
$('.btnupdeiva').click(function(){
  swal({
    title: "Estás seguro?",
    text: "Se actualizarán todos los campos de iva con lo insertado.!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Continuar.!",
    cancelButtonText: "Cancelar.!",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm) {
    if (isConfirm) {
      $('.cancel').prop('disabled', 'disabled');
      $('.confirm').prop('disabled', 'disabled');
      var iva= $('#iva_general').val();
      var _token = $('input[name="_token"]').val();
      if (iva != '' ) {
        var formData = new FormData($('#form_iva')[0]);
        $.ajax({
          type: "POST",
          url: "/update_ivacxc",
          data: formData,
          contentType: false,
          processData: false,
          success: function(data)
          {
            if (data === '1') {
              swal("Operación Completada!", ":)", "success");
              mens_tb(token);
            }
            if (data === '0') {
              swal("Operación abortada!", ":(", "success");
            }
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            // Our error logic here
            var msg = '';
            if (jqXHR.status === 0) {
              msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
              msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
              msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
              msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
              msg = 'Time out error.';
            } else if (exception === 'abort') {
              msg = 'Ajax request aborted.';
            } else {
              msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            console.log(msg);
          }
        });
      }
      else {
        swal("Operación abortada", "El campo de iva es obligatorio :)", "error");
      }
    }
    else {
      swal("Operación abortada", "Ningún registro afectado :)", "error");
    }
  });
});
$(".btnupdefc").click(function(){
  swal({
    title: "Estás seguro?",
    text: "Se actualizarán todas las fechas de compromiso con lo seleccionado.!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Continuar.!",
    cancelButtonText: "Cancelar.!",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm){
    if (isConfirm) {
      $('.cancel').prop('disabled', 'disabled');
      $('.confirm').prop('disabled', 'disabled');
      var fc = $('#date_compromise').val();
      var ff = $('#date_factura').val();

      if (fc != '' || ff != '') {
        var formData = new FormData($('#form_fc_ff')[0]);
        $.ajax({
          type: "POST",
          url: "/createf_compromise",
          data: formData,
          contentType: false,
          processData: false,
          success: function(data)
          {
            //console.log(data);
            if (data === '1') {
              swal("Operación Completada!", ":)", "success");
              mens_tb(token);
            }
            if (data === '0') {
              swal("Operación abortada!", ":(", "success");
            }
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            // Our error logic here
            var msg = '';
            if (jqXHR.status === 0) {
              msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
              msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
              msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
              msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
              msg = 'Time out error.';
            } else if (exception === 'abort') {
              msg = 'Ajax request aborted.';
            } else {
              msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            console.log(msg);
          }
        });
      }
      else {
        swal("Operación abortada", "El campo de fecha es obligatorio :)", "error");
      }
    }
    else {
      swal("Operación abortada", "Ningún registro afectado :)", "error");
    }
  });
});
/*$(".btnupdconcepts").click(function(){
  console.log('click');
});
$(".btnupdeff").click(function(){
  alert("update factura.");
});*/
function limpiar1_anexos1() {
  $("#sel_anexo_vertical option[value!='']").remove();
  $("#sel_anexo_cadenas option[value!='']").remove();
  $("#sel_to_anexo option[value!='']").remove();

  $('#form').formValidation('revalidateField', 'sel_anexo_vertical');
  $('#form').formValidation('revalidateField', 'sel_anexo_cadenas');
  $('#form').formValidation('revalidateField', 'sel_to_anexo');
}
function limpiar1_anexos2() {
  $("#sel_anexo_cadenas option[value!='']").remove();
  $("#sel_to_anexo option[value!='']").remove();
  $('#form').formValidation('revalidateField', 'sel_anexo_cadenas');
  $('#form').formValidation('revalidateField', 'sel_to_anexo');
}

//Elija las opciones
(function() {
  $('#form').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      sel_anexo_service: {
          validators: {
              notEmpty: {
                  message: 'Please select a service.'
              }
          }
      },
      sel_anexo_vertical: {
          validators: {
              notEmpty: {
                  message: 'Please select a vertical.'
              }
          }
      },
      sel_anexo_cadenas: {
          validators: {
              notEmpty: {
                  message: 'Please select a group.'
              }
          }
      },
      sel_to_anexo: {
          validators: {
              notEmpty: {
                  message: 'Please select a contract annex.'
              }
          }
      },
      concept: {
          validators: {
              notEmpty: {
                  message: 'Please select a concept.'
              }
          }
      },
      currency: {
          validators: {
              notEmpty: {
                  message: 'Please select a type of currency.'
              }
          }
      },
      monto: {
        validators: {
          notEmpty: {
            message: 'The amount is required.'
          },
          stringLength: {
            min: 1,
            message: 'The amount must have at least 1 characters',
          },
        }
      },
      descuento: {
        validators: {
          notEmpty: {
            message: 'The amount is required.'
          },
          stringLength: {
            min: 1,
            message: 'The amount must have at least 1 characters',
          },
        }
      },
      iva: {
        validators: {
          notEmpty: {
            message: 'The amount is required.'
          },
          stringLength: {
            min: 1,
            message: 'The amount must have at least 1 characters',
          },
        }
      },
      tc: {
        validators: {
          notEmpty: {
            message: 'The amount is required.'
          },
          stringLength: {
            min: 1,
            message: 'The amount must have at least 1 characters',
          },
        }
      },
    }
  })
  .on('success.form.fv', function(e) {
    e.preventDefault();
    var formData = new FormData($('#form')[0]);
    var token = $('input[name="_token"]').val();
    var texto_key =$("#sel_to_anexo option:selected").text();
    formData.append('key_cont', texto_key);

    $.ajax({
      type: "POST",
      url: "/recordmens_data",
      data: formData,
      contentType: false,
      processData: false,
      success: function(data)
      {
        if (data === '1') {
          swal("Operación Completada!", "El pago ha sido programado.", "success");
          mens_tb(token);
          $('#modal_default').modal('hide');
        }
        else{
          swal("Operación abortada!", "No se realizo ningun cambio.", "error");
          $('#modal_default').modal('hide');
        }
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        // Our error logic here
        var msg = '';
        if (jqXHR.status === 0) {
          msg = 'Not connect.\n Verify Network.';
        } else if (jqXHR.status == 404) {
          msg = 'Requested page not found. [404]';
        } else if (jqXHR.status == 500) {
          msg = 'Internal Server Error [500].';
        } else if (exception === 'parsererror') {
          msg = 'Requested JSON parse failed.';
        } else if (exception === 'timeout') {
          msg = 'Time out error.';
        } else if (exception === 'abort') {
          msg = 'Ajax request aborted.';
        } else {
          msg = 'Uncaught Error.\n' + jqXHR.responseText;
        }
        console.log(msg);
      }
    });
  });
})();

$('#sel_anexo_service').on('change', function(e){
  var val = $(this).val();
  var _token = $('input[name="_token"]').val();
  if (val != '') {
    $.ajax({
      type: "POST",
      url: "/idproy_search_vertical_by_class",
      data: { valor : val , _token : _token },
      success: function (data){
        count_data = data.length;
        limpiar1_anexos1();
        if (count_data > 0) {
          $.each(JSON.parse(data),function(index, objdata){
            $('#sel_anexo_vertical').append('<option value="'+objdata.id+'">'+ objdata.name +'</option>');
          });
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
  else {
    limpiar1_anexos1();
  }
});

$('#sel_anexo_vertical').on('change', function(e){
  var val = $(this).val();
  var _token = $('input[name="_token"]').val();
  if (val != '') {
    $.ajax({
      type: "POST",
      url: "/idproy_search_cadena_by_vert",
      data: { valor : val , _token : _token },
      success: function (data){
        count_data = data.length;
        limpiar1_anexos2();
        if (count_data > 0) {
          $.each(JSON.parse(data),function(index, objdata){
            $('#sel_anexo_cadenas').append('<option value="'+objdata.id+'">'+ objdata.cadena +'</option>');
          });
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
  else {
    limpiar1_anexos2();
  }
});

$('#sel_anexo_cadenas').on('change', function(e){
  var val = $(this).val();
  var _token = $('input[name="_token"]').val();
  if (val != '') {
    $.ajax({
      type: "POST",
      url: "/idproyanexo_search_by_cadena",
      data: { valor : val , _token : _token },
      success: function (data){
        count_data = data.length;
        $("#sel_to_anexo option[value!='']").remove();
        $('#form').formValidation('revalidateField', 'sel_to_anexo');
        if (count_data > 0) {
          $("#sel_to_anexo option[value!='']").remove();
          $.each(JSON.parse(data),function(index, objdata){
            $('#sel_to_anexo').append('<option value="'+objdata.contrat_id+'">'+ objdata.key +'</option>');
          });
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
  else {
    $("#sel_to_anexo option[value!='']").remove();
  }
});

$('#monto').on('blur', function() {
  var monto = this.value;
  var descuento = $('#descuento').val();
  var iva = '1.'+$('#iva').val();
  var m_tc = $('#tc').val();
  var subtotal = (monto-descuento).toFixed(2);
  var mens_civa = (subtotal* iva).toFixed(2);

  if (m_tc <= 0) { typo_c = 1; }
  else {  typo_c = $('#tc').val(); }

  var mens_total = mens_civa * typo_c;
  var men_total = mens_total.toFixed(2);

  $('#mens_iva').val(mens_civa);
  $('#mfinal').val(men_total);
});

$('#iva').on('blur', function() {
  var monto = $('#monto').val();
  var descuento = $('#descuento').val();
  var iva = '1.'+this.value;
  var m_tc = $('#tc').val();
  var subtotal = (monto-descuento).toFixed(2);
  var mens_civa = (subtotal*iva).toFixed(2);

  if (m_tc <= 0) { typo_c = 1; }
  else {  typo_c = $('#tc').val(); }

  var mens_total = mens_civa * typo_c;
  var men_total = mens_total.toFixed(2);

  $('#mens_iva').val(mens_civa);
  $('#mfinal').val(men_total);
});

$('#descuento').on('blur', function() {
  var monto = $('#monto').val();
  var descuento = this.value;
  var iva = '1.'+$('#iva').val();
  var m_tc = $('#tc').val();
  var subtotal = (monto-descuento).toFixed(2);
  var mens_civa = (subtotal*iva).toFixed(2);

  if (m_tc <= 0) { typo_c = 1; }
  else {  typo_c = $('#tc').val(); }

  var mens_total = mens_civa * typo_c;
  var men_total = mens_total.toFixed(2);

  $('#mens_iva').val(mens_civa);
  $('#mfinal').val(men_total);
});

$('#tc').on('blur', function() {
  var monto = $('#monto').val();
  var descuento = $('#descuento').val();
  var iva = '1.'+$('#iva').val();
  var m_tc = this.value;
  var subtotal = (monto-descuento).toFixed(2);
  var mens_civa = (subtotal*iva).toFixed(2);

  if (m_tc <= 0) { typo_c = 1; }
  else {  typo_c = $('#tc').val(); }

  var mens_total = mens_civa * typo_c;
  var men_total = mens_total.toFixed(2);

  $('#mens_iva').val(mens_civa);
  $('#mfinal').val(men_total);
});
