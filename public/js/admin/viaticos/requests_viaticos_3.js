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
  table_permission_three();
});
// Configuracion de table de estatus verifica*
var Configuration_table_responsive_checkbox_move_viatic_n3= {
  "order": [[ 0, "desc" ]],
  "select": true,
  "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  "autoWidth": false,
  "columnDefs": [
    { //Subida 1
      "targets": 0,
      "checkboxes": {
        'selectRow': true
      },
      "width": "0.5%",
      "createdCell": function (td, cellData, rowData, row, col){
        // console.log(cellData);
        if (cellData == '<input type="checkbox" class="dt-checkboxes" disabled="">') {

        }
        else{
          if ( cellData >=0 ) {
            if(rowData[11] != 'Verifica' && rowData[11] != 'Pendiente'){
              this.api().cell(td).checkboxes.disable();
            }
          }
        }
      }
    },
    {
      "targets": 1,
      "width": "1%",
      "className": "text-center fix-columns",
    },
    {
      "targets": 2,
      "width": "1%",
      "className": "text-center fix-columns",
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
          cancelButtonText: 'Cancelar'
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
              Swal.fire("Operación abortada", "Ningún viático seleccionado :(", "error");
            }
            else {
              $.ajax({
                type: "POST",
                url: "/send_item_verifica",
                data: { idents: JSON.stringify(valores), _token : _token },
                success: function (data){
                  if (data === 'true') {
                    Swal.fire("Operación Completada!", "Los viáticos seleccionados han sido afectados.", "success");
                    table_permission_three();
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
  table_permission_three();
});

function table_permission_three() {
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/view_request_via_three",
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
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_checkbox_move_viatic_n3);
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
    '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.id+'" class="btn btn-default btn-xs" role="button" data-target="#modal-concept" title="Ver"><span class="fa fa-eye"></span></a><a href="javascript:void(0);" onclick="enviartwo(this)" value="'+status.id+'" class="btn btn-danger btn-xs" role="button" data-target="#modal-deny" title="Denegar Solicitud"><span class="fa fa-ban"></span></a>',
    status.estado
    ]);
  });
}
function enviar(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  var fecha = $('#date_to_search').val();
  $('#id_viatic').val(valor);
  $.ajax({
      type: "POST",
      url: "/view_pertain_viatic_ur_n3",
      data: { date_to_search: fecha, viatic : valor , _token : _token },
      success: function (data){
        if (data === "0") { // NO SE NECESITA APROBAR VERIFICA
          console.log('NO SE NECESITA APROBAR VERIFICA');
          cabecera_viatic(valor, _token);
          cuerpo_viatic(valor, _token);
          timeline(valor, _token);
          totales_concept_zsa(valor, _token);
          disable_apr_deny(valor);
          enable_buttons(valor, fecha);
          $('#modal-view-concept').modal('show');
        }
        if (data === "1") { //NECESITA APROBAR VERIFICA
          console.log('NECESITA APROBAR VERIFICA');
          cabecera_viatic(valor, _token);
          cuerpo_viatic(valor, _token);
          timeline(valor, _token);
          totales_concept_zsa(valor, _token);
          enable_apr_deny(valor);
          enable_buttons(valor, fecha);
          $('#modal-view-concept').modal('show');
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function disable_apr_deny(id_v) {
  $('#dny_viatic').addClass("disabled");
  $('#dny_viatic').prop("disabled", true);
  $('#aprv_viatic').addClass("disabled");
  $('#aprv_viatic').prop("disabled", true);

  $('#dny_viatic').val(id_v);
  $('#aprv_viatic').val(id_v);
}
function enable_apr_deny(id_v) {
  $('#dny_viatic').removeClass("disabled");
  $('#dny_viatic').prop("disabled", false);

  $('#aprv_viatic').removeClass("disabled");
  $('#aprv_viatic').prop("disabled", false);

  $('#dny_viatic').val(id_v);
  $('#aprv_viatic').val(id_v);
}
function enable_buttons(id_v, date) {
  var _token = $('input[name="_token"]').val();
  var state = 3;
  $.ajax({
      type: "POST",
      url: "/view_request_via_btns",
      data: { _token : _token, id_viatic: id_v ,date:date, state:state},
      success: function (data){
        //console.log(data);
        if (data[0].next === null) {
          $('#next_btn').addClass("disabled");
          $('#next_btn').prop("disabled", true);
          $('#next_btn').val(data[0].next);
        }else{
          $('#next_btn').removeClass("disabled");
          $('#next_btn').prop("disabled", false);
          $('#next_btn').val(data[0].next);
        }
        if (data[0].prev === null) {
          $('#prev_btn').addClass("disabled");
          $('#prev_btn').prop("disabled", true);
          $('#prev_btn').val(data[0].prev);
        }else{
          $('#prev_btn').removeClass("disabled");
          $('#prev_btn').prop("disabled", false);
          $('#prev_btn').val(data[0].prev);
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
$('#dny_viatic').on('click', function(){
  var valor = $(this).val();
  $('#modal-view-deny').modal('show');
  $('#hidden_viatic').val(valor);
});
$('#aprv_viatic').on('click', function(){
  var id_viatic = $(this).val();
  var _token = $('input[name="_token"]').val();

  Swal.fire({
    title: '¿Estás seguro?',
    text: "!Se aprobará el viático seleccionado!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Continuar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.value) {
      $('.cancel').prop('disabled', 'disabled');
      $('.confirm').prop('disabled', 'disabled');
       // Iterate over all selected checkboxes
      var valores= new Array();
      valores.push(id_viatic);
      if ( valores.length === 0){
        Swal.fire("Operación abortada", "Ningún viático seleccionado :(", "error");
      }
      else {
        $.ajax({
            type: "POST",
            url: "/send_item_verifica",
            data: { idents: JSON.stringify(valores), _token : _token, stat: 1},
            success: function (data){
              if (data === 'true') {
                Swal.fire("Operación Completada!", "El viático seleccionado ha sido afectado.", "success");
                disable_apr_deny(id_viatic);
                cabecera_viatic(id_viatic, _token);
                cuerpo_viatic(id_viatic, _token);
                timeline(id_viatic, _token);
                totales_concept_zsa(id_viatic, _token);
                table_permission_three();
              }
              if (data === 'false') {
                Swal.fire("Operación Completada!", "El viático seleccionado no ha sido afectado.", "error");
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
});
$('#next_btn').on('click', function(){
  //console.log($(this).val());
  var _token = $('input[name="_token"]').val();
  var valor = $(this).val();
  var date_s = $('#date_to_search').val();
  cabecera_viatic(valor, _token);
  cuerpo_viatic(valor, _token);
  timeline(valor, _token);
  totales_concept_zsa(valor, _token);
  $('#id_viatic').val(valor);
  enable_buttons(valor, date_s);
});
$('#prev_btn').on('click', function(){
  //console.log('click');
  var _token = $('input[name="_token"]').val();
  var valor = $(this).val();
  var date_s = $('#date_to_search').val();
  cabecera_viatic(valor, _token);
  cuerpo_viatic(valor, _token);
  timeline(valor, _token);
  totales_concept_zsa(valor, _token);
  $('#id_viatic').val(valor);
  enable_buttons(valor, date_s);
});

// Exportacion del pdf
$('.btn-export').on('click', function(){
    $("#captura_table_general").hide();
    $(".hojitha").css("border", "");
    html2canvas(document.getElementById("captura_pdf_general")).then(function(canvas) {
      var ctx = canvas.getContext('2d');
      ctx.rect(0, 0, canvas.width, canvas.height);
          var imgData = canvas.toDataURL("image/jpeg", 1.0);
          var correccion_landscape = 0;
          var correccion_portrait = 0;
          if(canvas.height > canvas.width) {
              var orientation = 'portrait';
              correccion_portrait = 1;
              correccion_landscape = 0;
              var imageratio = canvas.height/canvas.width;
          }
          else {
              var orientation = 'landscape';
              correccion_landscape = 0;
              correccion_portrait = 0;
              var imageratio = canvas.width/canvas.height;
          }
          if(canvas.height < 900) {
              fontsize = 16;
          }
          else if(canvas.height < 2300) {
              fontsize = 11;
          }
          else {
              fontsize = 6;
          }

          var margen = 0;//pulgadas

          // console.log(canvas.width);
          // console.log(canvas.height);

         var pdf  = new jsPDF({
                      orientation: orientation,
                      unit: 'in',
                      format: [16+correccion_portrait, (16/imageratio)+margen+correccion_landscape]
                    });

          var widthpdf = pdf.internal.pageSize.width;
          var heightpdf = pdf.internal.pageSize.height;
          pdf.addImage(imgData, 'JPEG', 0, margen, widthpdf, heightpdf-margen);
          pdf.save("Solicitud de viaticos.pdf");
          $(".hojitha").css("border", "1px solid #ccc");
          $(".hojitha").css("border-bottom-style", "hidden");
    });
});
//Deny en modal
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
  if (comment === "") {
    Swal.fire("Operación abortada!", "Escriba un comentario.", "error");
  }else{
    $.ajax({
      type: "POST",
      url: "/deny_viatic",
      data: { idents: valor, _token : _token, comment: comment },
      success: function (data){
        //console.log(data);
        if (data === 'true') {
          Swal.fire("Operación Completada!", "El viatico ha sido denegado.", "success");
          table_permission_one();
          $('#comment_deny').val('');
          $('#modal-view-deny').modal('hide');
        }
        if (data === 'false') {
          Swal.fire("Operación abortada!", "No cuenta con el permiso o ya se encuentra denegado :)", "error");
          $('#comment_deny').val('');
          $('#modal-view-deny').modal('hide');
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
});
//Denegar solicitud
function enviartwo_cambiar(e){
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
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.value) {
      $.ajax({
          type: "POST",
          url: "/deny_viatic",
          data: { idents: valor, _token : _token },
          success: function (data){
            if (data === 'true') {
              Swal.fire("Operación Completada!", "El viatico ha sido denegado.", "success");
              table_permission_three();
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
