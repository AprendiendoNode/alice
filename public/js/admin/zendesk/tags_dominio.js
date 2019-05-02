$('#btnaplicar').on('click', function(e){
  let estado = $('#select_three').val();
  if (estado === "1") {
    //Gráfica por año.
    showOptionsGraph1();
  }else if(estado === "2"){
    //Gráfica por mes.
    showOptionsGraph2();
  }
  else {
    console.log('Elija una opcion de la lista');
  }
  $("#select_three").select2("val", "");
});

$("#btnacerrar1").click(function(event) {
  noshowOptions();
});

$("#btnacerrar2").click(function(event) {
  noshowOptions();
});

$('#boton-aplica-filtro9').on('click', function(e){
  graph_graphAnio();
});

$('#boton-aplica-filtro10').on('click', function(e){
  graph_graphMes();
});

// Graph por año.
function showOptionsGraph1() {
  /*
  document.getElementById("showornot1").style.display="block";
  document.getElementById("showornot2").style.display="none";
  document.getElementById("divoption").style.display="none";
  document.getElementById("graphicDominioTagAnio").style.display="block";
  document.getElementById("graphicDominioTagMes").style.display="none";
  */
  $("#showornot1").show();
  $("#showornot2").hide();
  $("#divoption").hide();

  $("#graphicDominioTagAnio").show();
  $("#graphicDominioTagMes").hide();
}
// Graph por mes.
function showOptionsGraph2() {
  /*
  document.getElementById("showornot2").style.display="block";
  document.getElementById("showornot1").style.display="none";
  document.getElementById("divoption").style.display="none";
  document.getElementById("graphicDominioTagAnio").style.display="none";
  document.getElementById("graphicDominioTagMes").style.display="block";
  */

  $("#showornot2").show();
  $("#showornot1").hide();
  $("#divoption").hide();
  $("#graphicDominioTagAnio").hide();
  $("#graphicDominioTagMes").show();
}

function noshowOptions() {
  /*
  document.getElementById("divoption").style.display="block";
  document.getElementById("showornot2").style.display="none";
  document.getElementById("showornot1").style.display="none";
  document.getElementById("graphicDominioTagAnio").style.display="none";
  document.getElementById("graphicDominioTagMes").style.display="none";
  */
  $("#divoption").show();
  $("#showornot2").hide();
  $("#showornot1").hide();
  $("#graphicDominioTagAnio").hide();
  $("#graphicDominioTagMes").hide();
}

function graph_graphMes(){
    let dataDomi = [];
    let dataTag = [];
    let dataTickets = [];
    let item = [];
    var _token = $('input[name="_token"]').val();
    let postData = $("#omega10").find("select,textarea, input").serialize();

    $.ajax({
      url: "/getDomTagM",
      type: "POST",
      data: postData,
      success: function (data) {
        console.log(data);
        $.each(JSON.parse(data), function(index, dataA){
          // AGREGAR DATOS A ARRAY.
          dataDomi.push(dataA.Domi);
          dataTag.push(dataA.Tag);
          dataTickets.push(dataA.Tickets);
          item.push({value: dataA.Tickets, name: dataA.Tag});
        });
        graph_mes('maingraphicDominioTagMes', 'maingraphicDominioTagMes2', dataDomi, dataTag, dataTickets, item);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
}

function graph_graphAnio(){
    let dataDomi = [];
    let dataTag = [];
    let dataTickets = [];
    let item = [];
    var _token = $('input[name="_token"]').val();
    let postData = $("#omega9").find("select,textarea, input").serialize();
    $.ajax({
      url: "/getDomTagA",
      type: "POST",
      data: postData,
      success: function (data) {
        console.log(data);
        $.each(JSON.parse(data), function(index, dataA){
          // AGREGAR DATOS A ARRAY.
          dataDomi.push(dataA.Domi);
          dataTag.push(dataA.Tag);
          dataTickets.push(dataA.Tickets);
          item.push({value: dataA.Tickets, name: dataA.Tag});
        });
          graph_anio('maingraphicDominioTagAnio', 'maingraphicDominioTagAnio2', dataDomi, dataTag, dataTickets, item);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
}
