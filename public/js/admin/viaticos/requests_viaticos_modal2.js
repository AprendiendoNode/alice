// console.log(cadenas);
// console.log(concepts);
$(".btn-sit").click(function(event) {
  var get = $('#obj').val();
  var _token = $('input[name="_token"]').val();
  $("#obj_cob").val(get);
  $('#modal-view-concept-approve2').modal('show');
  table_concept_onex(get, _token);

});

$(".btn-all").click(function(event) {
  $('#modal-view-concept').modal('toggle');
  $('#modal-view-concept-approve2').modal('toggle');
});

function table_concept_onex(campoa, campob) {
  $.ajax({
      type: "POST",
      url: "/update_data_conp",
      data: { viatic : campoa , _token : campob },
      success: function (data){
        //console.log(data);
        viatics_table_concept_newa(data, $("#tableconcept2"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function getValueCant(qty) {
    var retval;
    var val=qty;
    var valorsiro = "";
    for (var i = 0; i <= 50; i++) {
      if (val === i) {
        valorsiro = valorsiro+'<option value="'+i+'" selected>'+i+'</option>';
      }
      else{
        valorsiro = valorsiro+'<option value="'+i+'">'+i+'</option>';
      }
    }
    return valorsiro;
}
function get_cadenas() {
  // $count_cadenas = cadenas.length;
  // var valorsiro = '<option value="" selected>Elija...</option>';
  var valorsiro = "";
  for (var i = 0; i < cadenas.length; i++) {
    valorsiro = valorsiro+'<option value="'+cadenas[i].id+'">'+cadenas[i].name+'</option>';
  }
  return valorsiro;
}
function get_concepts() {
  var valorsiro = '<option value="" selected>Elija...</option>';
  for (var i = 0; i < concepts.length; i++) {
    valorsiro = valorsiro+'<option value="'+concepts[i].id+'">'+concepts[i].name+'</option>';
  }
  return valorsiro;
}
// testear funcion. (llena el select de sitios dinamicamente en base a cadena on change.)
    function createEventListenerSites (id) {
      const element = document.querySelector('[name="c_cadena['+id+']"]')
      element.addEventListener('change', function() {
        // var name = this.name;
        // console.log(name);
        var _token = $('input[name="_token"]').val();
        $.ajax({
          type: "POST",
          url: "./viat_find_hotel",
          data: { numero : this.value , _token : _token },
          success: function (data){
            if (data === '[]') {
              // $('[name="book['+id+'].hotel"]').empty();
              $('[name="c_hotel['+id+']"] option[value!=""]').remove();
              // $('[name="book['+id+'].hotel"]').append('<option value="" selected>Elige hotel</option>');
            }
            else{
              $('[name="c_hotel['+id+']"] option[value!=""]').remove();
              // $('[name="book['+id+'].hotel"]').empty();
              // $('[name="book['+id+'].hotel"]').append('<option value="" selected>Elige hotel</option>');
              $.each(JSON.parse(data),function(index, objdata){
                $('[name="c_hotel['+id+']"]').append('<option value="'+objdata.id+'">'+ objdata.Nombre_hotel +'</option>');
              });
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
        // $('#validation').data('formValidation').resetField($('[name="c_hotel['+id+'].hotel"]'));
      });
    }
//
function createEventListener_edit_amount (id) {
  const element = document.querySelector('[name="c_cant['+id+']"]')
  element.addEventListener('change', function() {
    var total = 0,
        valor = this.value;
        total = document.getElementsByName('m_ind['+id+']')[0].value;
        total = (total == null || total == undefined || total == "") ? 0 : total;
        var total2 = (parseInt(total) * parseInt(valor));
        $('[name="subt_['+id+']"]').val(total2);
  });
}
function createEventListener_edit_priceuni (id) {
  const element = document.querySelector('[name="m_ind['+id+']"]')
  element.addEventListener('keyup', function() {
    var total = 0,
        valor = this.value;
        valor = parseInt(valor); // Convertir el valor a un entero (número).
        total = document.getElementsByName('c_cant['+id+']')[0].value;
        total = (total == null || total == undefined || total == "") ? 0 : total;
        var total2 = (parseInt(total) * parseInt(valor));
        $('[name="subt['+id+']"]').val(total2);
  });
}
function viatics_table_concept_newa(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_concept);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    var cant = getValueCant(status.cantidad);
    vartable.fnAddData([
      '',
      '<input class="col-xs-1 hidden" style="display:none;"type="text" id="ident[]" name="ident[]" value="'+status.id+'">'+status.cadena,
      status.sitio,
      status.Concepto,
      '<select size="1" id="c_cant['+index+']" name="c_cant['+index+']"><option value="">Elija</option>'+cant+'</select>',
      '<input class="col-xs-12" type="text" id="m_ind['+index+']" name="m_ind['+index+']" value="'+status.amount+'">',
      '<input class="col-xs-12" type="text" id="subt['+index+']" name="subt['+index+']" value="'+status.total+'">',
      status.justificacion
    ]);
    createEventListener_edit_amount(index);
    createEventListener_edit_priceuni(index);
  });
}

$('.addButton').on('click', function(){
  $('#new_data').val(1);
  var table = $("#tableconcept2").DataTable();
  // table.fnClearTable();
  var count_rows = table.rows().count();
  // console.log(table.rows().count());
  // for (var i = 0; i < count_rows; i++) {
  //   console.log(i);
  // }
  // count_rows = count_rows  + 1;
  var chains = get_cadenas();
  var conceptos = get_concepts();
  var cant = getValueCant("");
  // console.log(chains);
  table.row.add([
      '',
      '<select size="1" id="c_cadena['+count_rows+']" name="c_cadena['+count_rows+']"><option value="">Elija...</option>'+chains+'</select>',
      // '<input class="col-xs-1 hidden" type="text" id="ident[]" name="ident[]" value="10">'+'status.cadena',
      '<select size="1" id="c_hotel['+count_rows+']" name="c_hotel['+count_rows+']"><option value="">Elija...</option></select>',
      '<select size="1" id="c_concept['+count_rows+']" name="c_concept['+count_rows+']"><option value="">Elija...</option>'+conceptos+'</select>',
      '<select size="1" id="c_cant['+count_rows+']" name="c_cant['+count_rows+']"><option value="">Elija...</option>'+cant+'</select>',
      '<input class="col-xs-12" type="text" id="m_ind['+count_rows+']" name="m_ind['+count_rows+']" value="0">',
      '<input class="col-xs-12" type="text" id="subt['+count_rows+']" name="subt['+count_rows+']" value="0">',
      '<input class="col-xs-12" type="text" id="c_just['+count_rows+']" name="c_just['+count_rows+']" placeholder="Justificación">'
  ]).draw(false);
  createEventListenerSites(count_rows);
  createEventListener_edit_amount(count_rows);
  createEventListener_edit_priceuni(count_rows);
});

$('.btn-save-conceptnew').on('click', function(){
  var table = $('#tableconcept2').DataTable();
  var _token = $('input[name="_token"]').val();
  var id_viatic = $('#obj_cob').val();
  var new_data = $('#new_data').val();
  var comprueba = table.$('input, select, :hidden').serialize();

  if (comprueba != '') {
    var datax = table.$('input, select, :hidden').serialize() + '&id_via=' + id_viatic + '&new_data=' + new_data + '&_token=' + _token;
    $.ajax({
      type: "POST",
      url: "/update_conceptable",
      data: datax,
      success: function (data){
        console.log(data);
        if (data === '1') {
          $('#modal-view-concept').modal('toggle');
          $('#modal-view-concept-approve2').modal('toggle');
          swal("Operación Completada!", "Datos actualizados correctamente", "success");
        }
        else {
          // $('#modal-view-concept').modal('toggle');
          // $('#modal-view-concept-approve2').modal('toggle');
          swal("Operación abortada", "Revisa que todos los campos esten correctamente llenados si no consulta al administrador.", "error");
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
  else{
    swal("Operación abortada", "Ningúna operación afectuada :)", "error");
  }
});

var Configuration_table_responsive_simple_concepts_viatic_all = {
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
      dom: "<'row'<'col-sm-6'B><'col-sm-2'l><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
        {
          text: '<i class="fa fa-check margin-r5"></i> Aplicar fechas',
          titleAttr: 'Aplicar fechas seleccionadas',
          className: 'btn bg-navy',
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
          className: 'btn bg-yellow',
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
          className: 'btn bg-green',
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
          text: '<i class="fas fa-file-excel"></i> Excel',
          titleAttr: 'Excel',
          title: function ( e, dt, node, config ) {
            return 'Reporte de mensualidades';
          },
          init: function(api, node, config) {
             $(node).removeClass('btn-default')
          },
          className: 'btn bg-olive custombtntable',
        }
      ],
      //bInfo: false,
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
