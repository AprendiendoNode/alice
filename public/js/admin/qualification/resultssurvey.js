$(function() {
  moment.locale('es');
  $('#date_to_search').datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months",
    endDate: '-1m',
    autoclose: true,
    clearBtn: true
  });
  $('#date_to_search').val('').datepicker('update');
  table_nps();
});
$("#boton-aplica-filtro").click(function(event) {
  table_nps();
});

function table_nps() {
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/survey_viewresults",
      data: objData,
      success: function (data){
        //console.log(data);
        remplazar_thead_th($("#table_qualification"), 2 ,13);
        table_anual(data, $("#table_qualification"));
        document.getElementById("table_qualification_wrapper").childNodes[0].setAttribute("class", "form-inline");
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function getValueCurrent(qty) {
    var retval;
    var val=qty;
    if (val == 'Pr') { retval = '<span class="badge badge-success badge-pill text-white" id="pr">Promotor</span>';}
    if (val == 'Ps') { retval = '<span class="badge badge-warning badge-pill text-white" id="ps">Pasivo</span>';}
    if (val == 'D') { retval = '<span class="badge badge-danger badge-pill text-white" id="det">Detractor</span>';}
    if (val == '') { retval = '';}
    return retval;
}
function table_anual(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_with_pdf_survey_nps);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    var span_identificador = '';
    if (status.Indicator == '0') { span_identificador = '<span class="badge badge-warning badge-pill text-white">Mantuvo</span>';}
    if (status.Indicator == '1') { span_identificador = '<span class="badge badge-danger badge-pill text-white">Bajo</span>';}
    if (status.Indicator == '2') { span_identificador = '<span class="badge badge-success badge-pill text-white">Subio</span>';}
    if (status.Indicator == '') { span_identificador = '<span class="badge badge-secondary badge-pill text-white">Sin indicador</span>';}
  vartable.fnAddData([
    status.Vertical,
    status.Nombre_hotel,
    // status.a12,
    // status.a11,
    // status.a10,
    // status.a9,
    // status.a8,
    // status.a7,
    // status.a6,
    // status.a5,
    // status.a4,
    // status.a3,
    // status.a2,
    // status.a1,
    getValueCurrent(status.a12),
    getValueCurrent(status.a11),
    getValueCurrent(status.a10),
    getValueCurrent(status.a9),
    getValueCurrent(status.a8),
    getValueCurrent(status.a7),
    getValueCurrent(status.a6),
    getValueCurrent(status.a5),
    getValueCurrent(status.a4),
    getValueCurrent(status.a3),
    getValueCurrent(status.a2),
    getValueCurrent(status.a1),
    status.anio,
    status.NPS,
    span_identificador,
    status.Assigned_IT,
    '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.id_comment+'" class="btn btn-default btn-sm" role="button" data-target="#modal-edithotcl"><span class="fa fa-comments"></span></a>',
    ]);
  });
}
function remplazar_thead_th(table, posicionini, posicionfin) {
  var datepicker3 = $('#date_to_search').val();
  if (datepicker3 == ''){
    var datepicker3 = moment().subtract(1, 'months').format('YYYY-MM');
  }
  var datemod = datepicker3.split("-");
  var goodFormat = datemod[0] + "-" + datemod[1];
  var j= posicionfin-posicionini;

  for (var i = posicionini; i <= posicionfin; i++) {
    table.DataTable().columns(i).header().to$().text(
      moment(goodFormat).subtract(j, 'months').format('YYYY MMMM')
    );
    j--;
  }
}
function enviar(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  $('#comment_a').val('');
  $.ajax({
       type: "POST",
       url: './get_modal_comments',
       data: { sector : valor, _token : _token},
       success: function (data) {
        var datos = JSON.parse(data);
        if (datos.length != 0) {
          $('#comment_a').val(datos[0].respuesta);
          $('#modal-comments').modal('show');
        }
        else {
          $('#comment_a').val('Sin comentarios');
          $('#modal-comments').modal('show');
        }
       },
       error: function (data) {
         console.log('Error:', data);
       }
   })
}
