$(window).on("load", function() {

  var areaActual;

  $.contextMenu({
      selector: '.ui-widget-content',
      trigger: (($(window).width() < 700) ? 'left' : 'right'),
      events: {
         show : function(options) {
           //console.log('entro');
           $('#mapa').contextMenu(false);
           $("#"+this[0].id).css("opacity", "0.5");
         },
         hide : function(options) {
           $('#mapa').contextMenu(true);
           $("#"+this[0].id).css("opacity", "1");
         }
      },
      callback: function(key, options) {

        var areaId = this[0].id;

        areaActual = allAreas.filter(function (area) {

          return area.id == areaId.split("area")[1];

        });



          switch(key) {

            case "nombre":

              $("#nuevoNombre").val(areaActual[0].nombre);

              if(elementsarray.length==0){
              elementsarray.push(parseInt(areaActual[0].id));//$('#selected_area').val(areaActual[0].id);
              }

              $("#CambiarNombre").modal("show");

              break;

            case "estado":

              $("#nuevoEstado").val(areaActual[0].estado);

              if(elementsarray.length==0){
              elementsarray.push(parseInt(areaActual[0].id));//$('#selected_area').val(areaActual[0].id);
              }

              $("#CambiarEstado").modal("show");

              break;

            case "eliminar":

              if(elementsarray.length==0){
              elementsarray.push(parseInt(areaActual[0].id));//$('#selected_area').val(areaActual[0].id);
              }

              $("#EliminarArea").modal("show");

              break;

          }

      },
      items: {
          "ver": {name: "Ver detalles", icon: "fas fa-eye"},
          "nombre": {name: "Cambiar nombre", icon: "fas fa-edit"},
          "estado": {name: "Cambiar estado", icon: "fas fa-sync-alt"},
          "equipos": {name: "Gestionar equipos", icon: "fas fa-broadcast-tower"},
          "split": "---------",
          "eliminar": {name: "Eliminar", icon: "fas fa-trash-alt"}
      }
  });

  $("#CambiarNombreButton").click(function() {

    var nombre = $("#nuevoNombre").val();

    socket.emit('nuevoNombre', {

      nombre: nombre,
      area: elementsarray,//$('#selected_area').val(),
      hotel_id: hotel_id

    });
    elementsarray=[];
    $("#CambiarNombre").modal("hide");

  });

  $("#CambiarEstadoButton").click(function() {

    var estado = $("#nuevoEstado").val();

    socket.emit('nuevoEstado', {

      estado: estado,
      area: elementsarray,//$('#selected_area').val(),
      hotel_id: hotel_id

    });
    elementsarray=[];
    $("#CambiarEstado").modal("hide");

  });

  $("#EliminarAreaButton").click(function() {

    socket.emit('eliminarArea', {

      area: elementsarray,//$('#selected_area').val(),
      hotel_id: hotel_id

    });
    elementsarray=[];
    $("#EliminarArea").modal("hide");

  });

});
