var map;
var marker;
var markas = [];
var infowindow;
var markerCluster;

$(function() {
  init();
  graph_tree_one();
  graph_tree_two();
  graph_resumen();
  general_table_equipment();
});

function init() {
  map = new google.maps.Map(document.getElementById('googlemap'), {
    zoom: 5,
    center: new google.maps.LatLng(20.960072,-77.264404),
  });
  infowindow = new google.maps.InfoWindow;
  addLocation();
}

function addLocation(){
  let contentstring;
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "./geoHotel",
    data: { _token : _token },
    success: function (data) {
      var obj = JSON.parse(data);
      console.log(obj);
      var length = Object.keys(obj).length;
      console.log(length);

      for (var i = 0; i < length; i++) {
        marker = new google.maps.Marker({
             position: new google.maps.LatLng(obj[i].Latitude, obj[i].Longitude),
             map: map
        });
        markas.push(marker);

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            contentstring = "<div style=\"overflow: hidden;\"><b>Hotel:<\/b> " + obj[i].Nombre_hotel +"<br><b>Dirección:<\/b> " + obj[i].Direccion +"<br><b>Latitude:<\/b> " + obj[i].Latitude + "<br><b>Longitude:<\/b> " + obj[i].Longitude;
            infowindow.setContent(contentstring);
            infowindow.open(map, marker);
          }
        })(marker, i));
      }
      markerCluster = new MarkerClusterer(map, markas,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});

    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function graph_tree_one() {
  var _token = $('input[name="_token"]').val();
  var data1 = {
      "name": "SITWIFI",
      "children": [
          {
              "name": "Republica dominicana",
              "children": [
                  {"name": "Punta Cana: 1483", "value": 1483}
              ]
          },
          {
              "name": "Jamaica",
              "children": [
                  {"name": "Ocho rios: 298", "value": 298},
                  {"name": "Negril: 149", "value": 149}
              ]
          },
          {
              "name": "Mexico",
              "children": [
                  {"name": "Nayarit:267", "value": 267},
                  {"name": "Chiapas: 117", "value": 117},
                  {"name": "Queretaro: 50", "value": 50},
                  {"name": "San luis potosi: 121", "value": 121},
                  {"name": "Puebla: 22", "value": 22},
                  {"name": "Sonora:56", "value": 56},
                  {"name": "Sinaloa: 19", "value": 19},
                  {"name": "Nuevo leon: 60", "value": 60},
                  {"name": "Morelos: 38", "value": 38},
                  {"name": "Guerrero:177", "value": 117},
                  {"name": "Los cabos: 174", "value": 174},

                  {"name": "Tabasco:104", "value": 174},
                  {"name": "Monterrey: 45", "value": 174},
                  {"name": "Guadalajara: 32", "value": 174},
                  {"name": "Chihuahua: 26", "value": 174},
                  {"name": "Guanajuato: 8", "value": 174},
                  {"name": "Zacatecas: 11", "value": 174},
                  {"name": "Tamaulipas:80", "value": 174},
                  {"name": "Campeche:29", "value": 174},
                  {"name": "Baja california:345", "value": 174},
                  {"name": "Veracruz: 94", "value": 174},
                  {"name": "Yucatan: 60", "value": 174},
                  {"name": "Tijuana: 30", "value": 174},
                  {"name": "Quintana roo: 11961", "value": 174},
                  {"name": "Toluca: 43", "value": 174},
                  {"name": "Morelia: 1", "value": 174},
                  {"name": "Aguascalientes: 115", "value": 174},
                  {"name": "Toluca: 43", "value": 174},
                  {"name": "Colima: 5", "value": 174},
                  {"name": "Coahuila: 102", "value": 174},
                  {"name": "Jalisco: 128", "value": 174},
                  {"name": "Ciudad de mexico: 1326", "value": 174}
             ]
          }
      ]
  };
  function_tree('main_country', 'Distribución de antenas', 'País & Estado', data1);
}

function graph_tree_two() {
  var _token = $('input[name="_token"]').val();
  var data1 = {
      "name": "SITWIFI",
      "children": [
          {
              "name": "Republica dominicana",
              "children": [
                  {"name": "Hospitalidad: 492", "value": 492}
              ]
          },
          {
              "name": "Jamaica",
              "children": [
                  {"name": "Hospitalidad: 1483", "value": 1483}
              ]
          },
          {
              "name": "Mexico",
              "children": [
                  {"name": "Aeropuertos:239", "value": 239},
                  {"name": "Educación: 2275", "value": 2275},
                  {"name": "Eventos: 7", "value": 7},
                  {"name": "Hospitalidad: 13556", "value": 13556},
                  {"name": "Oficinas: 152", "value": 152},
                  {"name": "Parques:73", "value": 73},
                  {"name": "Plaza: 165", "value": 165},
                  {"name": "Restaurantes: 11", "value": 11},
                  {"name": "Retail: 6", "value": 6},
                  {"name": "Transporte: 134", "value": 134},
                  {"name": "Sitwifi:958", "value": 958}
             ]
          }
      ]
  };
  function_tree('main_pais_vertical', 'Distribución de antenas', 'País & Vertical', data1);
}
function graph_resumen() {
  var _token = $('input[name="_token"]').val();
  var data_count = [{value:15646, name:'Mexico = 15646'},{value:447, name:'Jamaica = 447'},{value:1483, name:'Republica dominicana = 1483'}];
  var data_name = ["Mexico = 15646","Jamaica = 447","Republica dominicana = 1483"];
  graph_douhnut_default('main_distribution', 'Distribución de antenas', 'País', data_name, data_count);
}

$('#select_two').on('change', function(e){
  var id= $(this).val();
  var _token = $('input[name="_token"]').val();

  if (id != ''){
    general_table_equipment();
  }
  else {
    menssage_toast('Mensaje', '2', 'Seleccione un hotel!' , '3000');
  }
});

function general_table_equipment() {
  var _token = $('input[name="_token"]').val();
  var indent = $('#select_two').val();
  $.ajax({
      type: "POST",
      url: "/detailed_equipament_all",
      data: { ident: indent,_token : _token },
      success: function (data){
        table_equipment(data, $("#table_equipment_all"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function table_equipment(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_distribution);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){ //Este es el bueno
    vartable.fnAddData([
      status.Nombre_hotel,
      status.name,
      status.ModeloNombre,
      status.Cantidad,
      "<center><kbd style='background-color:grey'>"+status.Nombre_estado+"</kbd></center>",
    ]);
  });
}
