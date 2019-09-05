$(function() {
  var state = 0;
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
  table_permission_zero();
});

$("#boton-aplica-filtro").click(function(event) {
  table_permission_zero();
});

function enviar(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  var date_s = $('#date_to_search').val();
  cabecera_viatic(valor, _token);
  cuerpo_viatic(valor, _token);
  timeline(valor, _token);
  totales_concept_zsa(valor, _token);
  $('#id_viatic').val(valor);
  enable_buttons(valor, date_s);
  $('#modal-view-concept').modal('show');
}

function enable_buttons(id_v, date) {
  var _token = $('input[name="_token"]').val();
  var state = 0;
  $('#dny_viatic').addClass("disabled");
  $('#dny_viatic').prop("disabled", true);
  $('#aprv_viatic').addClass("disabled");
  $('#aprv_viatic').prop("disabled", true);
  $.ajax({
      type: "POST",
      url: "/view_request_via_btns",
      data: { _token : _token, id_viatic: id_v ,date:date, state:state},
      success: function (data){
        console.log(data);
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

function table_permission_zero() {
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/view_request_via_zero",
      data: objData,
      success: function (data){
        //console.log(data);
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
  var vartable = table.dataTable(Configuration_table_responsive_viatic_zero);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    var priority_s="";
    if(status.prioridad == 'Urgente'){ priority_s="<span class='label label-danger'>"+status.prioridad+"</span>"; }
    else { priority_s="<span class='label label-default'>"+status.prioridad+"</span>"; }
  vartable.fnAddData([
    status.folio,
    status.name,
    status.date_start,
    status.date_end,
    status.solicitado,
    status.aprobado,
    '<span class="label label-default">'+status.estado+'</span>',
    priority_s,
    '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.id+'" class="btn btn-default btn-sm" role="button" data-target="#modal-concept"><span class="far fa-edit"></span></a>',
    ]);
  });
}

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
