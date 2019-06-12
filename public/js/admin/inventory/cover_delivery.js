$(function() {
  $(".select_one").select2();
  document.getElementById("captura_pdf_general").style.display="block";
});

$('#btn_generar').on('click', function(e){
  var cadena= $('#select_one').val();

  if (cadena == "") {

  }else{
    document.getElementById("captura_pdf_general").style.display="block";
    fillHeaders();
    general_table_equipment();
    graph_equipment();
    graph_modelos();

  }
});

$('#select_one').on('change',function(){
    var grupo = "GRUPO : " + $('select[id="select_one"] option:selected').text();
    $('#name_group').text(grupo);
})

function headersEmpty() {
  $("#name_htl").empty();
  $("#id_proyect").empty();
  $("#country").empty();
  $("#state").empty();
  $("#dir").empty();
}

function fillHeaders() {
  headersEmpty();
  var cadena= $('#select_one').val();
  var _token = $('input[name="_token"]').val();
  var datax;
  console.log(cadena);
  $.ajax({
    type: "POST",
    url: "/cover_delivery_header",
    data: { data_one : cadena,  _token : _token },
    success: function (data){
      if ($.trim(data)){
        datax = JSON.parse(data);
        console.log(datax);
        $("#name_htl").text(datax[0].Nombre);
        $("#id_proyect").text(datax[0].id_proyecto);
        $("#dir").text(datax[0].Direccion);
        $("#country").text(datax[0].Pais);
        $("#state").text(datax[0].Estado);
      }
      else{
        $("#name_htl").text('');
        $("#id_proyect").text('');
        $("#country").text('');
        $("#state").text('');
        $("#dir").text('');
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
      url: "/cover_dist_groups_disp",
      data: { data_one : cadena,  _token : _token },
      success: function (data){
        //console.log("equipos"+data);
        $.each(JSON.parse(data),function(index, objdata){
          data_name.push(objdata.Equipo + ' = ' + objdata.Cantidad);
          data_count.push({ value: objdata.Cantidad, name: objdata.Equipo + ' = ' + objdata.Cantidad},);
        });
        graph_barras_two('main_equipos', data_name, data_count);

      },
      error: function (data) {
        console.log('Error:', data);

      }
  });

}

function graph_modelos() {
  var cadena= $('#select_one').val();
  var _token = $('input[name="_token"]').val();
  //var data_count2 = [120, 132, 101, 134, 90, 230, 210];
  //var data_name2 = ["WS-C2960S-24PS-L","Smart Zone","FW7541D-NG1","GB-BACE-3150","GS2210-24HP","Zone Director"];
  var data_count = [];
  var data_name = [];

  $.ajax({
      type: "POST",
      url: "/cover_dist_groups_models",
      data: { data_one : cadena,  _token : _token },
      success: function (data){
        console.log(data);
        $.each(JSON.parse(data),function(index, objdata){
          data_name.push(objdata.Modelo + ' = ' + objdata.Cantidad);
          data_count.push({ value: objdata.Cantidad, name: objdata.Modelo + ' = ' + objdata.Cantidad},);
        });
        graph_area_three_default('main_modelos', data_name, data_count, 'Equipamiento', 'Modelos & Unidades','right', 90, 8);
        //console.log(data_count);
      },
      error: function (data) {
        console.log('Error:', data);
        //alert('3');
      }
  });


}


function general_table_equipment() {
  var cadena= $('#select_one').val();
  var hotel= $('#name_htl').val();
  var _token = $('input[name="_token"]').val();

  var datax =
  [{"equipo":"Switch","mac":"54:3D:37:0C:EE:90","serie":"911302002193","modelo":"WS-C2960S-24PS-L","descripcion":"HRPC-HAB_7352","marca":"Cisco","estado":"Activo","servicio":"Arrendamiento"},{"equipo":"Antena","mac":"54:3D:37:0C:EE:90","serie":"911302002193","modelo":"zf7025","descripcion":"HRPC-HAB_7352","marca":"RUCKUS AP","estado":"Inactivo","servicio":"Arrendamiento"},{"equipo":"Zone Director","mac":"54:3D:37:0C:EE:90","serie":"911302002193","modelo":"zf7025","descripcion":"HRPC-HAB_7352","marca":"RUCKUS AP","estado":"Procesando","servicio":"Arrendamiento"}
  ];

  var data_data = [];

  $.ajax({
    type: "POST",
    url: "/cover_delivery_groups",
    data: { data_one : cadena,  data_two : hotel,  _token : _token },
    success: function (data){
      $.each(JSON.parse(data),function(index, objdata){
        data_data.push({"ubicacion": objdata.Ubicacion,"equipo": objdata.Equipo,"mac": objdata.MAC,"serie": objdata.Serie,"modelo": objdata.Modelo,"descripcion": objdata.Descripcion,"marca": objdata.Marca,"estado": objdata.Estado});
      });
      table_equipment(data_data, $("#table_equipment"));
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function table_equipment(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple);
  vartable.fnClearTable();
  $.each(datajson, function(index, status){

    vartable.fnAddData([
      status.ubicacion,
      status.equipo,
      status.mac,
      status.serie,
      status.modelo,
      status.descripcion,
      status.marca,
      status.estado,
      "<center><kbd style='background-color:grey'>"+status.estado+"</kbd></center>",
      //status.servicio
    ]);
  });
}



// Exportacion del pdf

$('.btn-export').on('click', function(){

  var quotes = document.getElementById('captura_pdf_general');
       //! MAKE YOUR PDF
       var pdf = new jsPDF('p', 'pt', 'letter');
       html2canvas(quotes, {

       }).then(canvas => {
         for (var i = 0; i <= quotes.clientHeight / 980; i++) {
             //! This is all just html2canvas stuff
             var srcImg = canvas;
             var sX = 0;
             var sY = 1190 * i; // start 1100 pixels down for every new page
             var sWidth = 1600;
             var sHeight = 1250;
             var dX = 0;
             var dY = 0;
             var dWidth = 1250;
             var dHeight = 1150;

             window.onePageCanvas = document.createElement("canvas");
             onePageCanvas.setAttribute('width', 1330);
             onePageCanvas.setAttribute('height', 1100);
             var ctx = onePageCanvas.getContext('2d');
             ctx.clearRect( 0 , 0 , canvas.width, canvas.height );
             ctx.fillStyle="#FFFFFF";
             ctx.fillRect(0 , 0 , canvas.width, canvas.height);

             // details on this usage of this function:
             // https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API/Tutorial/Using_images#Slicing
             ctx.drawImage(srcImg, sX, sY, sWidth, sHeight, dX, dY, dWidth, dHeight);

             // document.body.appendChild(canvas);
             var canvasDataURL = onePageCanvas.toDataURL("image/JPEG", 1.0);

             var width = onePageCanvas.width;
             var height = onePageCanvas.clientHeight;

             //! If we're on anything other than the first page,
             // add another page
             if (i > 0) {
                 pdf.addPage(612, 791); //8.5" x 11" in pts (in*72)
             }
             //! now we declare that we're working on that page
             pdf.setPage(i + 1);
             //! now we add content to that page!
             pdf.addImage(canvasDataURL, 'JPEG', 20, 40, (width * .62), (height * .62));

         }//Fin for


          pdf.save('Reporte de Grupos.pdf');
       });
       //Fin canvas


  });//Fin funcion exports

  function general_table_equipment() {
  var cadena= $('#select_one').val();
  var hotel= $('#name_htl').val();
  var _token = $('input[name="_token"]').val();

  var datax =
  [{"equipo":"Switch","mac":"54:3D:37:0C:EE:90","serie":"911302002193","modelo":"WS-C2960S-24PS-L","descripcion":"HRPC-HAB_7352","marca":"Cisco","estado":"Activo","servicio":"Arrendamiento"},{"equipo":"Antena","mac":"54:3D:37:0C:EE:90","serie":"911302002193","modelo":"zf7025","descripcion":"HRPC-HAB_7352","marca":"RUCKUS AP","estado":"Inactivo","servicio":"Arrendamiento"},{"equipo":"Zone Director","mac":"54:3D:37:0C:EE:90","serie":"911302002193","modelo":"zf7025","descripcion":"HRPC-HAB_7352","marca":"RUCKUS AP","estado":"Procesando","servicio":"Arrendamiento"}
  ];

  var data_data = [];

  $.ajax({
    type: "POST",
    url: "/cover_delivery_groups",
    data: { data_one : cadena,  data_two : hotel,  _token : _token },
    success: function (data){
      $.each(JSON.parse(data),function(index, objdata){
        data_data.push({"ubicacion": objdata.Ubicacion,"equipo": objdata.Equipo,"mac": objdata.MAC,"serie": objdata.Serie,"modelo": objdata.Modelo,"descripcion": objdata.Descripcion,"marca": objdata.Marca,"estado": objdata.Estado});
      });
      table_equipment(data_data, $("#table_equipment"));
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
