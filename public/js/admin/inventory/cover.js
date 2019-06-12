$(function() {
  $(".select2").select2();
  document.getElementById("client_updl").style.display="none";
  document.getElementById("captura_pdf_general").style.display="none";

  //graph_equipment();
  //graph_modelos();


});

$('#btn_generar').on('click', function(e){
  var cadena= $('#select_one').val();
  if (cadena == "") {

  }else{
    $("#validate_client")[0].reset();
    $('#validate_client').data('formValidation').resetForm($('#validate_client'));
    document.getElementById("client_updl").style.display="block";
    document.getElementById("captura_pdf_general").style.display="block";

    fillHeaders();
    graph_equipment();
    graph_modelos();
  }
});

function headersEmpty() {
  $("#name_htl").empty();
  $("#id_proyect").empty();
  // URL de imagen
  $("#client_img").attr("src","../images/hotel/Default.svg");

  $("#email").empty();
  $("#tel").empty();
  $("#empresa").empty();
  $("#responsable").empty();
  $("#area").empty();
  $("#dir").empty();
  $("#tel_empresa").empty();
  $("#correo_empresa").empty();

  $("#cliente_nombre").empty();
  $("#cliente_responsable").empty();
  $("#cliente_ubi").empty();
  $("#cliente_dir").empty();
  $("#cliente_tel").empty();
  $("#cliente_email").empty();


  $("#fecha_ini").empty();
  $("#fecha_fin").empty();
}

function fillHeaders() {
  headersEmpty();
  var cadena= $('#select_one').val();
  var _token = $('input[name="_token"]').val();
  var datax;
  console.log(cadena);
  $.ajax({
    type: "POST",
    url: "/cover_header",
    data: { data_one : cadena,  _token : _token },
    success: function (data){
      console.log(data);
      if (data == null || data == '[]') {
        $("#name_htl").text('');
        $("#id_proyect").text('');
        $("#client_img").attr("src","../images/hotel/Default.svg");
        $("#email").text('');
        $("#tel").text('');
        $("#empresa").text('');
        $("#responsable").text('');
        $("#area").text('');
        $("#dir").text('');
        $("#tel_empresa").text('');
        $("#correo_empresa").text('');
        $("#cliente_nombre").text('');
        $("#cliente_responsable").text('');
        $("#cliente_ubi").text('');
        $("#cliente_dir").text('');
        $("#cliente_tel").text('');
        $("#cliente_email").text('');
        $("#fecha_ini").text('');
        $("#fecha_fin").text('');
      }
      else {
        if ($.trim(data)){
          datax = JSON.parse(data);
          $("#name_htl").text(datax[0].Nombre_hotel);
          $("#id_proyect").text(datax[0].id_proyecto);
          // URL de imagen
          $("#client_img").attr("src","../images/hotel/"+datax[0].Logo);
          $("#email").text(datax[0].sucuralcorreo);
          $("#tel").text(datax[0].sucursalphone);
          $("#empresa").text(datax[0].empresa_name);
          $("#responsable").text(datax[0].empresa_responsable);
          $("#area").text(datax[0].empresa_area);
          $("#dir").text(datax[0].empresa_addr);
          $("#tel_empresa").text(datax[0].empresa_phone);
          $("#correo_empresa").text(datax[0].empresa_email);
          $("#cliente_nombre").text(datax[0].Nombre_hotel);
          $("#cliente_responsable").text(datax[0].cliente_nombre);
          $("#cliente_ubi").text(datax[0].ubicacion);
          $("#cliente_dir").text(datax[0].cliente_direccion);
          $("#cliente_tel").text(datax[0].cliente_tele);
          $("#cliente_email").text(datax[0].cliente_email);
          $("#fecha_ini").text(datax[0].fecha_inicio);
          $("#fecha_fin").text(datax[0].fecha_fin);
        }
        else{
          // alert('sindatos');
          $("#name_htl").text('');
          $("#id_proyect").text('');
          // URL de imagen
          $("#client_img").attr("src","../images/hotel/Default.svg");
          $("#email").text('');
          $("#tel").text('');
          $("#empresa").text('');
          $("#responsable").text('');
          $("#area").text('');
          $("#dir").text('');
          $("#tel_empresa").text('');
          $("#correo_empresa").text('');
          $("#cliente_nombre").text('');
          $("#cliente_responsable").text('');
          $("#cliente_ubi").text('');
          $("#cliente_dir").text('');
          $("#cliente_tel").text('');
          $("#cliente_email").text('');
          $("#fecha_ini").text('');
          $("#fecha_fin").text('');
        }
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function graph_equipment() {
  var cadena= $('#select_one').val();
  var _token = $('input[name="_token"]').val();
  // var data_count2 = [{value:335, name:'Antenas = 335'},{value:310, name:'Smart Zone = 310'},{value:234, name:'Sonda = 234'},{value:135, name:'SW = 135'},{value:1315, name:'Zequenze = 1315'},{value:1548, name:'Zone Director = 1548'}];
  // var data_name2 = ["Antenas = 335","Smart Zone = 310","Sonda = 234","SW = 135","Zequenze = 1315","Zone Director = 1548"];
  var data_count = [];
  var data_name = [];

  $.ajax({
      type: "POST",
      url: "/cover_dist_equipos",
      data: { data_one : cadena,  _token : _token },
      success: function (data){
        //console.log(data);
        $.each(JSON.parse(data),function(index, objdata){
          data_name.push(objdata.Equipo + ' = ' + objdata.count);
          data_count.push({ value: objdata.count, name: objdata.Equipo + ' = ' + objdata.count},);
        });
        graph_barras_two('main_equipos', data_name, data_count);
        //console.log(data_count);
      },
      error: function (data) {
        console.log('Error:', data);
        //alert('3');
      }
  });
  //graph_barras_two('main_equipos', data_name2, data_count2);
}

function graph_modelos() {
  var cadena= $('#select_one').val();
  var _token = $('input[name="_token"]').val();
  var data_count2 = [120, 132, 101, 134, 90, 230, 210];
  var data_name2 = ["WS-C2960S-24PS-L","Smart Zone","FW7541D-NG1","GB-BACE-3150","GS2210-24HP","Zone Director"];
  var data_count = [];
  var data_name = [];

  $.ajax({
      type: "POST",
      url: "/cover_dist_modelos",
      data: { data_one : cadena,  _token : _token },
      success: function (data){
        //console.log(data);
        $.each(JSON.parse(data),function(index, objdata){
          data_name.push(objdata.ModeloNombre + ' = ' + objdata.count);
          data_count.push({ value: objdata.count, name: objdata.ModeloNombre + ' = ' + objdata.count},);
        });
        graph_area_three_default('main_modelos', data_name, data_count, 'Equipamiento', 'Modelos & Unidades','right', 90, 8);
        //console.log(data_count);
      },
      error: function (data) {
        console.log('Error:', data);
        //alert('3');
      }
  });

  //graph_area_three_default('main_modelos', data_name, data_count, 'Equipamiento', 'Modelos & Unidades','right', 90, 8);
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
              fontsize = 18;
          }
          else if(canvas.height < 2300) {
              fontsize = 14;
          }
          else {
              fontsize = 8;
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
          pdf.save("Carta de entrega.pdf");
          $(".hojitha").css("border", "1px solid #ccc");
          $(".hojitha").css("border-bottom-style", "hidden");
    });
  });
