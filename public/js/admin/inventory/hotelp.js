$(function() {
  $(".select2").select2();
  document.getElementById("captura_pdf_general").style.display="none";
  // graph_aps();
  // graph_swith();
  // graph_resumen();
  // graph_modelos();
  // general_table_resumen();
  // general_table_rent_vent();
  // general_table_demo_stock();
});

$('#select_one').on('change', function(e){
  var id= $(this).val();
  var _token = $('input[name="_token"]').val();

  if (id != ''){
    let parsed;
    let countH = 0;
    let datax;
      $.ajax({
        type: "POST",
        url: "/detailed_pro_stat",
        data: { numero : id , _token : _token },
        success: function (data){
          datax = JSON.parse(data);
          countH = datax.length;
          // console.log(datax);
          // console.log(countH);
          if (countH === 0) {
            //console.log('Nating');
            $('#select_two').empty();
            $('#select_two').append('<option value="" selected>Elije</option>');
          }else{
            $('#select_two').empty();
            $('#select_two').append('<option value="" selected>Elije</option>');

            for (var i = 0; i < countH; i++) {
              //console.log(data[i].id);
              // console.log(data[i].Nombre_hotel);
              //$("#select_two option").prop("selected", false);
              $('#select_two').append('<option value="'+datax[i].id+'" selected>'+ datax[i].status +'</option>');
              $('#select_two').val(datax[0].id).trigger('change');
            }
          }

        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
  }
  else {
      $('#select_two').empty();
      $('#select_two').append('<option value="" selected>Elije</option>');
      $("#select_two").select2({placeholder: "Elija"});
  }
});

$('#select_two').on('change', function(e){
  var id= $(this).val();
  var cadena= $('#select_one').val();
  var _token = $('input[name="_token"]').val();

  if (id != ''){
    let data_data = [];
      $.ajax({
        type: "POST",
        url: "/detailed_pro_tab",
        data: { status : id , cadena : cadena , _token : _token },
        success: function (data){
          //console.log(data);
          $.each(JSON.parse(data),function(index, objdata){
            data_data.push({"equipo": objdata.Venue,"noap": objdata.AP,"nozd": objdata.ZD,"nosmz": objdata.SMZ,"nosw": objdata.SW,"nosonda": objdata.Sonda,"nozq": objdata.ZQ, "sonic": objdata.SonicWall, "icomera": objdata.Icomera});
          });
          table_resumen(data_data, $("#table_resume"));

        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
  }
  else {
    console.log('toast error');
  }
});

$('#btn_generar').on('click', function(e){
  var cadena= $('#select_one').val();
  if (cadena == "") {

  }else{
    document.getElementById("captura_pdf_general").style.display="block";
    headersEmpty();
    fillHeaders();

    graph_aps();
    graph_swith();

    graph_resumen();
    graph_modelos();
    table_resumen_gen(cadena);
  }
});



function resetselecttype() {
  $('#select_two').empty();
  $('#select_two').append('<option value="">Elije</option>');

  $('#select_two').prop('selectedIndex',0);
  $("#select_two").select2({placeholder: "Elija"});
}

function headersEmpty() {
  $("#name_htl").empty();
  $("#email").empty();
  $("#tel").empty();

  // URL de imagen
  $("#img_htl").attr("src","../images/hotel/Default.svg");

  //$("#client").text();
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

      $("#name_htl").text(datax[0].name);
      $("#email").text(datax[0].correo);
      $("#tel").text(datax[0].phone);

      //URL de imagen
      $("#img_htl").attr("src","../images/hotel/"+datax[0].dirlogo1);

    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function graph_aps() {
  var cadena= $('#select_one').val();
  var _token = $('input[name="_token"]').val();

  // var data_count = [{value:335, name:'Ap Stock = 335'},{value:310, name:'Ap Renta = 310'},{value:234, name:'Ap Prestamo = 234'},{value:135, name:'Ap Venta = 135'},{value:1315, name:'Ap Demo = 1315'}];
  // var data_name = ["Ap Stock = 335","Ap Renta = 310","Ap Prestamo = 234","Ap Venta = 135","Ap Demo = 1315"];
  var data_name = [];
  var data_count = [];

  $.ajax({
      type: "POST",
      url: "/detailed_pro_ap",
      data: { data_one : cadena,  _token : _token },
      success: function (data){
        //console.log(data);
        $.each(JSON.parse(data),function(index, objdata){
          data_name.push(objdata.concepto + ' = ' + objdata.count);
          data_count.push({ value: objdata.count, name: objdata.concepto + ' = ' + objdata.count},);
        });
        graph_pie_default_three('main_aps', data_name, data_count, 'APS', 'Concepto & Unidad');
        //console.log(data_count);

      },
      error: function (data) {
        console.log('Error:', data);
        //alert('3');
      }
  });
  //graph_pie_default_three('main_aps', data_name, data_count, 'APS', 'Concepto & Unidad');
}

function graph_swith() {
  var cadena= $('#select_one').val();
  var _token = $('input[name="_token"]').val();
  // var data_count = [{value:110, name:'Switch Stock = 110'},{value:10, name:'Switch Renta = 10'},{value:18, name:'Switch Prestamo = 18'},{value:45, name:'Switch Venta = 45'},{value:15, name:'Switch Demo = 15'}];
  // var data_name = ["Switch Stock = 110","Switch Renta = 10","Switch Prestamo = 18","Switch Venta = 45","Switch Demo = 15"];
  var data_name = [];
  var data_count = [];

  $.ajax({
      type: "POST",
      url: "/detailed_pro_sw",
      data: { data_one : cadena,  _token : _token },
      success: function (data){
        //console.log(data);
        $.each(JSON.parse(data),function(index, objdata){
          data_name.push(objdata.concepto + ' = ' + objdata.count);
          data_count.push({ value: objdata.count, name: objdata.concepto + ' = ' + objdata.count},);
        });
        graph_pie_default_three('main_switch', data_name, data_count, 'Switch', 'Concepto & Unidad');
        //console.log(data_count);

      },
      error: function (data) {
        console.log('Error:', data);
        //alert('3');
      }
  });

  //graph_pie_default_three('main_switch', data_name, data_count, 'Switch', 'Concepto & Unidad');
}

function graph_resumen() {
  var cadena= $('#select_one').val();
  var _token = $('input[name="_token"]').val();
  // var data_count = [{value:75, name:'Antenas = 75'},{value:2, name:'Smart Zone = 2'},{value:1, name:'Sonda = 1'},{value:46, name:'SW = 46'},{value:1, name:'Zequenze = 1'},{value:3, name:'Zone Director = 3'}];
  // var data_name = ["Antenas = 75","Smart Zone = 2","Sonda = 1","SW = 46","Zequenze = 1","Zone Director = 3"];
  var data_name = [];
  var data_count = [];

  $.ajax({
      type: "POST",
      url: "/detailed_pro_dispro",
      data: { data_one : cadena,  _token : _token },
      success: function (data){
        //console.log(data);
        $.each(JSON.parse(data),function(index, objdata){
          data_name.push(objdata.Equipo + ' = ' + objdata.count);
          data_count.push({ value: objdata.count, name: objdata.Equipo + ' = ' + objdata.count},);
        });
        graph_barras_three('main_equipos', data_name, data_count, 'Distribución', 'Equipos & Cantidades');
        //graph_pie_default_three('main_switch', data_name, data_count, 'Switch', 'Concepto & Unidad');
        //console.log(data_count); G08550488

      },
      error: function (data) {
        console.log('Error:', data);
        //alert('3');
      }
  });


  //graph_barras_three('main_equipos', data_name, data_count, 'Distribución', 'Equipos & Cantidades');
}

function graph_modelos() {
  var cadena= $('#select_one').val();
  var _token = $('input[name="_token"]').val();
  // var data_count = [120, 132, 101, 134, 90, 230, 210];
  // var data_name = ["WS-C2960S-24PS-L","Smart Zone","FW7541D-NG1","GB-BACE-3150","GS2210-24HP","Zone Director"];

  var data_name = [];
  var data_count = [];

  $.ajax({
      type: "POST",
      url: "/detailed_pro_modpro",
      data: { data_one : cadena,  _token : _token },
      success: function (data){
        //console.log(data);
        $.each(JSON.parse(data),function(index, objdata){
          data_name.push(objdata.ModeloNombre);
          data_count.push(objdata.count);
        });
        graph_area_three_default('main_modelos', data_name, data_count, 'Equipamiento', 'Modelos & Unidades','right', 90, 8);
        //console.log(data_count); G08550488

      },
      error: function (data) {
        console.log('Error:', data);
        //alert('3');
      }
  });

  //graph_area_three_default('main_modelos', data_name, data_count, 'Equipamiento', 'Modelos & Unidades','right', 90, 8);
}

function general_table_resumen() {
  var cadena= $('#select_one').val();
  var status = $('#select_two').val();
  var _token = $('input[name="_token"]').val();

  var data =  [{"equipo":"UNICO 20°87°","noap":"10","nosw":"12","nozd":"125","nosonda":"1","nosonic":"0","nozq":"1"},
  {"equipo":"Hard Rock Cancún","noap":"10","nosw":"12","nozd":"12","nosonda":"12","nosonic":"0","nozq":"1"},
  {"equipo":"Hard Rock Vallarta","noap":"10","nosw":"12","nozd":"26","nosonda":"1","nosonic":"0","nozq":"1"},
  {"equipo":"Hard Rock Riviera Maya","noap":"10","nosw":"12","nozd":"85","nosonda":"1","nosonic":"0","nozq":"1"},
  {"equipo":"Hard Rock Riviera Convenciones","noap":"10","nosw":"12","nozd":"65","nosonda":"1","nosonic":"0","nozq":"1"},
  {"equipo":"Hard Rock Punta Cana","noap":"10","nosw":"12","nozd":"47","nosonda":"1","nosonic":"0","nozq":"1"}
  ];

  var data_data = [];

  // $.ajax({
  //   type: "POST",
  //   url: "/detailed_hotel_table",
  //   data: { data_one : cadena,  data_two : status,  _token : _token },
  //   success: function (data){
  //     console.log(data);
  //     // $.each(JSON.parse(data),function(index, objdata){
  //     //   data_data.push({"equipo": objdata.Equipo,"mac": objdata.MAC,"serie": objdata.Serie,"modelo": objdata.ModeloNombre,"descripcion": objdata.Descripcion,"marca": objdata.Nombre_marca,"estado": objdata.Nombre_estado, "servicio": objdata.Nombre_servicio});
  //     // });
  //     //table_resumen(data_data, $("#table_resume"));
  //   },
  //   error: function (data) {
  //     console.log('Error:', data);
  //   }
  // });

  table_resumen(data, $("#table_resume"));
}

function general_table_rent_vent() {
  var _token = $('input[name="_token"]').val();
  var data =  [{"equipo":"UNICO 20°87°","n1":"10","n2":"12","n3":"125","n4":"1","n5":"0","n6":"1","n7":"1","n8":"0","n9":"1"},
              {"equipo":"Hard Rock Cancún","n1":"10","n2":"12","n3":"12","n4":"12","n5":"0","n6":"1","n7":"1","n8":"0","n9":"1"},
              {"equipo":"Hard Rock Vallarta","n1":"10","n2":"12","n3":"26","n4":"1","n5":"0","n6":"1","n7":"1","n8":"0","n9":"1"},
              {"equipo":"Hard Rock Riviera Maya","n1":"10","n2":"12","n3":"85","n4":"1","n5":"0","n6":"1","n7":"1","n8":"0","n9":"1"},
              {"equipo":"Hard Rock Riviera Convenciones","n1":"10","n2":"12","n3":"65","n4":"1","n5":"0","n6":"1","n7":"1","n8":"0","n9":"1"},
              {"equipo":"Hard Rock Punta Cana","n1":"10","n2":"12","n3":"47","n4":"1","n5":"0","n6":"1","n7":"1","n8":"0","n9":"1"}
  ];
  table_rent_vent(data, $("#table_rent_prest"));
}

function general_table_demo_stock() {
  var _token = $('input[name="_token"]').val();
  var data =  [{"equipo":"UNICO 20°87°","n1":"10","n2":"12","n3":"125","n4":"1","n5":"0","n6":"1"},
              {"equipo":"Hard Rock Cancún","n1":"10","n2":"12","n3":"12","n4":"12","n5":"0","n6":"1"},
              {"equipo":"Hard Rock Vallarta","n1":"10","n2":"12","n3":"26","n4":"1","n5":"0","n6":"1"},
              {"equipo":"Hard Rock Riviera Maya","n1":"10","n2":"12","n3":"85","n4":"1","n5":"0","n6":"1"},
              {"equipo":"Hard Rock Riviera Convenciones","n1":"10","n2":"12","n3":"65","n4":"1","n5":"0","n6":"1"},
              {"equipo":"Hard Rock Punta Cana","n1":"10","n2":"12","n3":"47","n4":"1","n5":"0","n6":"1"}
  ];
  table_demo_stock(data, $("#table_demo_stock"));
}

function table_resumen(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_with_pdf_two);
  vartable.fnClearTable();
  // $.each(JSON.parse(datajson), function(index, status){ //Este es el bueno

  $.each(datajson, function(index, status){
    vartable.fnAddData([
      status.equipo,
      status.noap,
      status.nozd,
      status.nosmz,
      status.nosw,
      status.nosonda,
      status.nozq,
      status.sonic,
      status.icomera
    ]);
  });
}

function table_rent_vent(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_with_pdf_two);
  vartable.fnClearTable();
  // $.each(JSON.parse(datajson), function(index, status){ //Este es el bueno
  $.each(datajson, function(index, status){
    vartable.fnAddData([
      status.equipo,
      status.n1,
      status.n2,
      status.n3,
      status.n4,
      status.n5,
      status.n6,
      status.n7,
      status.n8,
      status.n9
    ]);
  });
}

function table_demo_stock(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_with_pdf_two);
  vartable.fnClearTable();
  // $.each(JSON.parse(datajson), function(index, status){ //Este es el bueno
  $.each(datajson, function(index, status){
    vartable.fnAddData([
      status.equipo,
      status.n1,
      status.n2,
      status.n3,
      status.n4,
      status.n5,
      status.n6
    ]);
  });
}

$('.btn-export').on('click', function(){
    $("#captura_table_general").hide();

    $(".hojitha").css("border", "");
    html2canvas(document.getElementById("hojitha_cont")).then(function(canvas) {
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
          pdf.save("Detalllado.pdf");
          $(".hojitha").css("border", "1px solid #ccc");
          $(".hojitha").css("border-bottom-style", "hidden");
    });
  });

function table_resumen_gen(data1) {
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "/detailed_pro_gen",
    data: { cadena : data1 , _token : _token },
    success: function (data){
      table_res_gen(data, $("#table_resume_general"));
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function table_res_gen(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_with_pdf_two);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    vartable.fnAddData([
      status.Venue,
      status.AP,
      status.ZD,
      status.SMZ,
      status.SW,
      status.Sonda,
      status.ZQ,
      status.SonicWall,
      status.Icomera,
    ]);
  });
}
