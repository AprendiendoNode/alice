const headers = new Headers({
  "Accept": "application/json",
  "X-Requested-With": "XMLHttpRequest",
  "X-CSRF-TOKEN": $('input[name="_token"]').val()
});
$(function() {
  moment.locale('es');
  $('#date_to_search').datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months",
    endDate: '1m',
    autoclose: true,
    clearBtn: true
  });
  $('#date_to_search').val('').datepicker('update');
  table_permission_one();
});
$('.confirm').on('click', function(){

});
// Configuracion de table de estatus verifica*
var Configuration_table_responsive_checkbox_move_viatic_n1= {
  "order": [[ 8, "desc" ]],
  "select": true,
  "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  "columnDefs": [
    { //Subida 1
      "targets": 0,
      "checkboxes": {
        'selectRow': true
      },
      "width": "1%",
      "createdCell": function (td, cellData, rowData, row, col){
        if ( cellData > 0 ) {
          if(rowData[11] != 'Nuevo'){
            this.api().cell(td).checkboxes.disable();
          }
        }
      }
    },
    {
      "targets": 1,
      "width": "1%",
      "className": "text-center fix-colums",
    },
    {
      "targets": 2,
      "width": "1%",
      "className": "text-center fix-colums",
    },
    {
      "targets": 3,
      "width": "1%",
      "className": "text-center fix-columns",
    },
    {
      "targets": 4,
      "width": "1%",
      "className": "text-center fix-columns",
    },
    {
      "targets": 5,
      "width": "0.2%",
      "className": "text-center fix-columns",
    },
    {
      "targets": 6,
      "width": "0.2%",
      "className": "text-center fix-columns",
    },
    {
      "targets": 7,
      "width": "0.2%",
      "className": "text-center fix-columns",
    },
    {
      "targets": 8,
      "width": "0.2%",
      "className": "text-center fix-columns",
    },
    {
      "targets": 9,
      "width": "1%",
      "className": "text-center fix-columns",
    },
    {
      "targets": 10,
      "width": "1%",
      "className": "text-center fix-columns",
    },
    {
      "targets": 11,
      "visible": false,
      "searchable": false
    }
  ],
  "select": {
    'style': 'multi',
  },
  dom: "<'row'<'col-sm-6'B><'col-sm-2'l><'col-sm-4'f>>" +
  "<'row'<'col-sm-12'tr>>" +
  "<'row'<'col-sm-5'i><'col-sm-7'p>>",
  buttons: [
    {
      text: '<i class="fa fa-check margin-r5"></i> Aprobar Marcados',
      titleAttr: 'Aprobar Marcados',
      className: 'btn bg-navy',
      init: function(api, node, config) {
        $(node).removeClass('btn-default')
      },
      action: function ( e, dt, node, config ) {
        // $('#modal-confirmation').modal('show');
        Swal.fire({
          title: '¿Estás seguro?',
          text: "!Se aprobarán todos los viáticos seleccionados!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Continuar',
          cancelButtonText: "Cancelar",
        }).then((result) => {
          if (result.value) {
            $('.cancel').prop('disabled', 'disabled');
            $('.confirm').prop('disabled', 'disabled');
            var rows_selected = $("#table_viatics").DataTable().column(0).checkboxes.selected();
            var _token = $('input[name="_token"]').val();
            // Iterate over all selected checkboxes
            var valores= new Array();
            $.each(rows_selected, function(index, rowId){
              valores.push(rowId);
            });
            if ( valores.length === 0){
              //$('#select_type').prop('disabled', false);
              Swal.fire("Operación abortada", "Ningún viático seleccionado :(", "error");
            }
            else {
              $.ajax({
                type: "POST",
                url: "/send_item_nuevo",
                data: { idents: JSON.stringify(valores), _token : _token },
                success: function (data){
                  if (data === 'true') {
                    Swal.fire("Operación Completada!", "Los viáticos seleccionados han sido afectados.", "success");
                    table_permission_one();
                  }
                  if (data === 'false') {
                    Swal.fire("Operación Completada!", "Los viáticos seleccionados han sido afectados.", "success");
                  }
                },
                error: function (data) {
                  console.log('Error:', data);
                }
              });
            }
          } else {
            Swal.fire("Operación abortada", "Ningún viático afectado :)", "error");
          }
        });
        $('#table_viatics').css({
          padding:0,
          margin:0
        });
        $('#table_viatics').addClass('fix-table');
      }
    },
    {
      extend: 'excelHtml5',
      text: '<i class="fas fa-file-excel"></i> Excel',
      titleAttr: 'Excel',
      title: function ( e, dt, node, config ) {
        return 'Reporte de viaticos.';
      },
      init: function(api, node, config) {
        $(node).removeClass('btn-default')
      },
      exportOptions: {
        columns: [ 1,2,3,4,5,6,7,8,9],
        modifier: {
          page: 'all',
        }
      },
      className: 'btn btn-success',
    },
    {
      extend: 'csvHtml5',
      text: '<i class="fas fa-file-csv"></i> CSV',
      titleAttr: 'CSV',
      title: function ( e, dt, node, config ) {
        return 'Reporte de viaticos.';
      },
      init: function(api, node, config) {
        $(node).removeClass('btn-default')
      },
      exportOptions: {
        columns: [ 1,2,3,4,5,6,7,8,9],
        modifier: {
          page: 'all',
        }
      },
      className: 'btn btn-info',
    },
    {
      extend: 'pdf',
      text: '<i class="fas fa-file-pdf"></i>  PDF',
      title: function ( e, dt, node, config ) {
        return 'Reporte de viaticos.';
      },
      init: function(api, node, config) {
        $(node).removeClass('btn-default')
      },
      exportOptions: {
        columns: [ 1,2,3,4,5,6,7,8,9],
        modifier: {
          page: 'all',
        }
      },
      className: 'btn btn-danger',
    }
  ],
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
    },
    'select': {
      'rows': {
        _: "%d Filas seleccionadas",
        0: "Haga clic en una fila para seleccionarla",
        1: "Fila seleccionada 1"
      }
    }
  },
};

$("#boton-aplica-filtro").click(function(event) {
  table_permission_one();
});

function table_permission_one() {
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/view_request_via_one",
      data: objData,
      success: function (data){
        viatics_table(data, $("#table_viatics"));
        document.getElementById("table_viatics_wrapper").childNodes[0].setAttribute("class", "form-inline");
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function viatics_table(datajson, table){
  //$('#observation').val('');
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_checkbox_move_viatic_n1);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    var priority_s="";
    if(status.prioridad == 'Urgente'){ priority_s="<span class='label label-danger'>"+status.prioridad+"</span>"; }
    else { priority_s="<span class='label label-default'>"+status.prioridad+"</span>"; }
  vartable.fnAddData([
    status.id,
    status.folio,
    status.name,
    status.date_start,
    status.date_end,
    status.solicitado,
    status.aprobado,
    '<span class="label label-default">'+status.estado+'</span>',
    priority_s,
    status.usuario,
    '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.id+'" class="btn btn-default btn-xs" role="button" data-target="#modal-concept" title="Aprobar conceptos"><span class="far fa-edit"></span></a><a href="javascript:void(0);" onclick="enviartwo(this)" value="'+status.id+'" class="btn btn-danger btn-xs" role="button" data-target="#modal-deny" title="Denegar Solicitud"><span class="fa fa-ban"></span></a>',
    status.estado,
    ]);
  });
}

//Parte para aprobar conceptos ----->
function table_concept_one(campoa, campob) {
  $.ajax({
      type: "POST",
      url: "/view_concept_via_one",
      data: { viatic : campoa , _token : campob },
      success: function (data){
        console.log(campoa);
        console.log(data);
        $("#id_viatic").val(campoa);
        viatics_table_concept(data, $("#tableconcept"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
async function getValueStatus(qty) {
    var retval;
    var val=qty;
    var valorsiro = "";
    // try{
    //   const result = await $.ajax({
    //       type: "POST",
    //       url: "/search_all_status_concep",
    //       data: { val: val , _token : $('input[name="_token"]').val() },
    //   });
    //   return result;
    // }catch (error){
    //   console.log(error)
    // }
    return $.ajax({
        type: "POST",
        url: "/search_all_status_concep",
        data: { val: val , _token : $('input[name="_token"]').val() },
        //async: false,
        error: function (data) {
          console.log('Error:', data);
        }
    });
    //return valorsiro;
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
function createEventListener_amount (id) {
  const element = document.querySelector('[name="c_cant_['+id+']"]')
  element.addEventListener('change', function() {
    var total = 0,
        valor = this.value;
        valor = parseInt(valor); // Convertir el valor a un entero (número).
        //console.log(valor);

        total = document.getElementsByName('m_ind_['+id+']')[0].value;
        //console.log(total);

        // Aquí valido si hay un valor previo, si no hay datos, le pongo un cero "0".
        total = (total == null || total == undefined || total == "") ? 0 : total;
        // console.log(total);

        /* Esta es la suma.*/
        var total2 = (parseInt(total) * parseInt(valor));
        //console.log(total2);

        /* Cambiamos el valor del Subtotal*/
        $('[name="subt_['+id+']"]').val(total2);
  });
}
function createEventListener_priceuni (id) {
  const element = document.querySelector('[name="m_ind_['+id+']"]')
  element.addEventListener('keyup', function() {
    var total = 0,
        valor = this.value;
        valor = parseInt(valor); // Convertir el valor a un entero (número).
        //console.log(valor);

        total = document.getElementsByName('c_cant_['+id+']')[0].value;
        //console.log(total);

        // Aquí valido si hay un valor previo, si no hay datos, le pongo un cero "0".
        total = (total == null || total == undefined || total == "") ? 0 : total;
        // console.log(total);

        /* Esta es la suma.*/
        var total2 = (parseInt(total) * parseInt(valor));
        // console.log(total2);

        /* Cambiamos el valor del Subtotal*/
        $('[name="subt_['+id+']"]').val(total2);
        // eventListenerSubtotal();
  });
}
function viatics_table_concept(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_concept);
  vartable.fnClearTable();
  $('#dyn_ids').empty();
  let array_status = [];
  let datajson2 = datajson;
  for (const item of datajson2){
    array_status.push(getValueStatus(item.Estatus));
  }
  const end_loop = datajson.length;
    (async () => {
      for (let i = 0; i < end_loop; i++) {
        console.log('for index: '+i);

        let cant = getValueCant(datajson[i].cantidad);
        //console.log('valor cantidad: '+datajson[i].cantidad);
        let finished = 0;
        //const content = await rawResponse;
        array_status[i].then(function(result){
          //console.log(result);
          $('#dyn_ids').append('<input class="col-xs-1" type="text" id="ident['+i+']" name="ident['+i+']" value="'+datajson[i].id+'" hidden>');
          vartable.fnAddData([
            datajson[i].id,
            datajson[i].Cadena,
            datajson[i].Hotel,
            datajson[i].Concepto,
            '<select size="1" id="c_cant_['+i+']" name="c_cant_['+i+']"><option value="">Elija</option>'+cant+'</select>',
            '<input class="col-xs-12" type="text" id="m_ind_['+i+']" name="m_ind_['+i+']" value="'+datajson[i].amount+'">',
            '<input class="col-xs-12" type="text" id="subt_['+i+']" name="subt_['+i+']" value="'+datajson[i].total+'">',
            '<select size="1" id="status['+i+']" name="status['+i+']"><option value="">Elija</option>'+result+'</select>',
            datajson[i].justificacion,
          ]);
          createEventListener_amount(i);
          createEventListener_priceuni(i);
        });
      }
    })();
  // $.each(datajson, function(index, status){
  //   console.log('for index: '+index);
  //   var cant = getValueCant(status.cantidad);
  //   //var estado = getValueStatus(status.Estatus);
  //   //var estado = "";
  //   //$.when(getValueStatus(status.Estatus)).done(function(response){document.write(response);})

  //   var something = (async () => {
  //     const rawResponse = await getValueStatus(status.Estatus);
  //     const content = await rawResponse;
  //     console.log('for promise: '+index);
  //     $('#dyn_ids').append('<input class="col-xs-1" type="text" id="ident['+index+']" name="ident['+index+']" value="'+status.id+'" hidden>');
  //     vartable.fnAddData([
  //       '<input class="col-xs-1" type="text" id="ident['+index+']" name="ident['+index+']" value="'+status.id+'">',
  //       status.Cadena,
  //       status.Hotel,
  //       status.Concepto,
  //       '<select size="1" id="c_cant_['+index+']" name="c_cant_['+index+']"><option value="">Elija</option>'+cant+'</select>',
  //       '<input class="col-xs-12" type="text" id="m_ind_['+index+']" name="m_ind_['+index+']" value="'+status.amount+'">',
  //       '<input class="col-xs-12" type="text" id="subt_['+index+']" name="subt_['+index+']" value="'+status.total+'">',
  //       '<select size="1" id="status['+index+']" name="status['+index+']"><option value="">Elija</option>'+content+'</select>',
  //       status.justificacion,
  //     ]);
  //     createEventListener_amount(index);
  //     createEventListener_priceuni(index);
  //   })();

    // $.when(getValueStatus(status.Estatus)).then(function(response){
    //   //$('#observation').val(status.observacion);
    //   console.log('for then: '+index);
    //   $('#dyn_ids').append('<input class="col-xs-1" type="text" id="ident['+index+']" name="ident['+index+']" value="'+status.id+'" hidden>');
    //   vartable.fnAddData([
    //     '<input class="col-xs-1" type="text" id="ident['+index+']" name="ident['+index+']" value="'+status.id+'">',
    //     status.Cadena,
    //     status.Hotel,
    //     status.Concepto,
    //     '<select size="1" id="c_cant_['+index+']" name="c_cant_['+index+']"><option value="">Elija</option>'+cant+'</select>',
    //     '<input class="col-xs-12" type="text" id="m_ind_['+index+']" name="m_ind_['+index+']" value="'+status.amount+'">',
    //     '<input class="col-xs-12" type="text" id="subt_['+index+']" name="subt_['+index+']" value="'+status.total+'">',
    //     '<select size="1" id="status['+index+']" name="status['+index+']"><option value="">Elija</option>'+response+'</select>',
    //     status.justificacion,
    //     ]);
    //     createEventListener_amount(index);
    //     createEventListener_priceuni(index);
    //   });
  //});
}

//Deny en modal.
function enviartwo(e) {
  var valor= e.getAttribute('value');
  $('#modal-view-deny').modal('show');
  $('#hidden_viatic').val(valor);
}
$('#deny_request_v').on('click', function(){
  //var valor= e.getAttribute('value');
  var valor= $('#hidden_viatic').val();
  var _token = $('input[name="_token"]').val();
  var comment = $('#comment_deny').val();
  $(this).attr("disabled", true);
  if (comment === "") {
    Swal.fire("Operación abortada!", "Escriba un comentario.", "error");
  }else{
    $.ajax({
      type: "POST",
      url: "/deny_viatic",
      data: { idents: valor, _token : _token, comment: comment },
      success: function (data){
        // console.log(data);
        if (data === 'true') {
          Swal.fire("Operación Completada!", "El viatico ha sido denegado.", "success");
          table_permission_one();
          $('#comment_deny').val('');
          $('#modal-view-deny').modal('hide');
          $(this).attr("disabled", false);
        }
        if (data === 'false') {
          Swal.fire("Operación abortada!", "No cuenta con el permiso o ya se encuentra denegado :)", "error");
          $('#comment_deny').val('');
          $('#modal-view-deny').modal('hide');
          $(this).attr("disabled", false);
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }

});
//Denegar solicitud
function enviartwo_borrar(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();

  Swal.fire({
    title: '¿Estás seguro?',
    text: "!Se denegará la solicitud!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Continuar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.value) {
      $.ajax({
          type: "POST",
          url: "/deny_viatic",
          data: { idents: valor, _token : _token },
          success: function (data){
            if (data === 'true') {
              Swal.fire("Operación Completada!", "El viatico ha sido denegado.", "success");
              table_permission_one();
            }
            if (data === 'false') {
              Swal.fire("Operación abortada!", "No cuenta con el permiso o esta ya se encuentra denegado :)", "success");
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
      });
    } else {
      Swal.fire("Operación abortada", "Ningún viático afectado :)", "error");
    }
  });
}
$('.btn-save-concept').on('click', function(){
  var table = $('#tableconcept').DataTable();
  //var observation = $('#observation').val();
  var _token = $('input[name="_token"]').val();
  var id_viatic = $('#id_viatic').val();
  var serial = table.$('input, select').serialize() + '&id_via=' + id_viatic + '&_token=' + _token;
  //var datax = table.$(":input,:hidden, select").serialize() + '&_token=' + _token;
  var datax = serial + '&' + $('#dyn_ids :input').serialize();
  //console.log(datax);
  $.ajax({
      type: "POST",
      url: "/insert_request_1_data",
      data: datax,
      success: function (data){
        // console.log(data);
        if (data === '1') {
          $('#modal-view-concept-approve').modal('toggle');
          table_permission_one();
          Swal.fire("Operación Completada!", "Los cambios han sido guardados.", "success");
        }else{
          //$('#modal-view-concept-approve').modal('toggle');
          Swal.fire("Operación abortada", "No se realizaron cambios, Favor de revisar los datos.", "error");
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
});
