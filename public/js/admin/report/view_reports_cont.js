$(function() {
  moment.locale('es');
  $(".select2").select2();
  $('.datepickermonth').datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months",
    endDate: '1m',
    autoclose: true,
    clearBtn: true
  });
  $('.datepickermonth').val('').datepicker('update');
});

$('#btn_generar').on('click', function(e){
  var cadena= $('#select_one').val();
  //console.log(cadena);
  if (cadena == "") {

  }else{
    //document.getElementById("captura_pdf_general").style.display="block";
    empty_header();
    fillHeaders();
    table_gigabyte_cont();
    table_user_cont();
    table_device();
  }
});

function empty_header() {
  $("#client_name").empty();
  // URL de imagen
  $("#client_img").attr("src","../images/hotel/Sin_imagen.png");
  $("#email").empty();
  $("#tel").empty();
}

function fillHeaders() {
  var cadena= $('#select_one').val();
  var _token = $('input[name="_token"]').val();
  var datax;
  $.ajax({
    type: "POST",
    url: "/detailed_pro_head",
    data: { data_one : cadena,  _token : _token },
    success: function (data){
      datax = JSON.parse(data);
      //console.log(data);

      $("#client_name").text(datax[0].name);
      $("#email").text(datax[0].correo);
      $("#tel").text(datax[0].phone);

      //URL de imagen
      $("#client_img").attr("src","../images/hotel/"+datax[0].dirlogo1);

    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function table_user_cont() {
  var cadena= $('#select_one').val();
  var date = $('#calendar_fecha').val();
  var _token = $('input[name="_token"]').val();

  var data_data = [];
  $.ajax({
    type: "POST",
    url: "/get_user_cont",
    data: {data_one : cadena , data_two : date , _token : _token},
    success: function (data){
      remplazar_thead_th($("#table_cont_user"), 1 ,12);
      table_conc_two(data, $("#table_cont_user"));
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
function table_conc_two(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_with_contenado_a);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    vartable.fnAddData([
      status.Nombre_hotel,
      status.a12,
      status.a11,
      status.a10,
      status.a9,
      status.a8,
      status.a7,
      status.a6,
      status.a5,
      status.a4,
      status.a3,
      status.a2,
      status.a1,
      status.Promedio
    ]);
  });
}

function table_gigabyte_cont() {
  var cadena= $('#select_one').val();
  var date = $('#calendar_fecha').val();
  var _token = $('input[name="_token"]').val();
  $.ajax({
      type: "POST",
      url: "/get_gb_cont",
      data: {data_one : cadena , data_two : date , _token : _token},
      success: function (data){
        remplazar_thead_th($("#table_cont_gb"), 1 ,12);
        table_conc_one(data, $("#table_cont_gb"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });

}
function table_conc_one(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_with_contenado_b);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    vartable.fnAddData([
      status.Nombre_hotel,
      status.a12,
      status.a11,
      status.a10,
      status.a9,
      status.a8,
      status.a7,
      status.a6,
      status.a5,
      status.a4,
      status.a3,
      status.a2,
      status.a1,
      status.Promedio
    ]);
  });
}


function table_device() {
  var cadena= $('#select_one').val();
  var date = $('#calendar_fecha').val();
  var _token = $('input[name="_token"]').val();

  $.ajax({
      type: "POST",
      url: "/get_device_cont",
      data: {data_one : cadena , data_two : date , _token : _token},
      success: function (data){
        remplazar_thead_th($("#table_cont_devices"), 1 ,12);
        table_anual_device(data, $("#table_cont_devices"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function table_anual_device(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_with_contenado_c);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
  vartable.fnAddData([
    status.Nombre_hotel,
    status.a12,
    status.a11,
    status.a10,
    status.a9,
    status.a8,
    status.a7,
    status.a6,
    status.a5,
    status.a4,
    status.a3,
    status.a2,
    status.a1,
    status.Promedio
    ]);
  });
}

function remplazar_thead_th(table, posicionini, posicionfin) {
  var datepicker3 = $('#calendar_fecha').val();
  if (datepicker3 == ''){
    var datepicker3 = moment().subtract(1, 'months').format('YYYY-MM');
  }
  var datemod = datepicker3.split("-");
  var goodFormat = datemod[0] + "-" + datemod[1];
  var j= posicionfin-posicionini;

  for (var i = posicionini; i <= posicionfin; i++) {
    table.DataTable().columns(i).header().to$().text(
      moment(goodFormat).subtract(j, 'months').format('MMMM YYYY')
    );
    j--;
  }
}

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
    pdf.save("Reporte Mensual.pdf");
    $(".hojitha").css("border", "1px solid #ccc");
    $(".hojitha").css("border-bottom-style", "hidden");
    $("#captura_table_general").css("border-top-style", "hidden");
    $('#captura_table_general').show(); //muestro mediante id
  });
});
