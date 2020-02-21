$(window).on("load", function() {

  var areaActual;

  $.contextMenu({
      selector: '.ui-widget-content',
      trigger: (($(window).width() < 700) ? 'left' : 'right'),
      events: {
         show : function(options) {
           ctrl_status = 0;
           try {
             $(".blink").resizable('disable');
           } catch(e) {}
           $('#mapa').contextMenu(false);
           //$("#"+this[0].id).css("opacity", "0.5");
           if(!$("#"+this[0].id).hasClass("ui-selected")) {
             $(".blink").removeClass('ui-selected');
             $("#"+this[0].id).addClass("ui-selected");
           }
         },
         hide : function(options) {
           ctrl_status = 1;
           if($(".ui-selected").length == 0) {
             $(".blink").resizable('enable');
           }
           $('#mapa').contextMenu(true);
           //$("#"+this[0].id).css("opacity", "1");
           //$("#"+this[0].id).removeClass("ui-selected");
         }
      },
      callback: function(key, options) {

        var areaId = this[0].id;

        areaActual = allAreas.filter(function (area) {

          return area.id == areaId.split("area")[1];

        });

        elementsarray = [];

        $(".ui-selected").each(function (index, element) {
    	    elementsarray.push(parseInt(element.getAttribute("id").replace('area','')));
        });

          switch(key) {

            case "nombre":

              $("#nuevoNombre").val(areaActual[0].nombre);

              $("#CambiarNombre").modal("show");

              break;

            case "estado":

              $("#nuevoEstado").val(areaActual[0].estado);

              $("#CambiarEstado").modal("show");

              break;

            case "piso":

              $("#nuevoPiso").val(areaActual[0].piso);
              $("#nuevoPiso").trigger('change');

              $("#CambiarPisoMenu").modal("show");

              break;

            case "eliminar":

              $("#EliminarArea").modal("show");

              break;

          }

      },
      items: {
          "ver": {name: "Ver detalles", icon: "fas fa-eye"},
          "nombre": {name: "Cambiar nombre", icon: "fas fa-edit"},
          "estado": {name: "Cambiar estado", icon: "fas fa-sync-alt"},
          "piso": {name: "Cambiar piso", icon: "fas fa-clone"},
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

    $("#CambiarNombre").modal("hide");

  });

  $("#CambiarEstadoButton").click(function() {

    var estado = $("#nuevoEstado").val();

    socket.emit('nuevoEstado', {

      estado: estado,
      area: elementsarray,//$('#selected_area').val(),
      hotel_id: hotel_id

    });

    $("#CambiarEstado").modal("hide");

  });

  $("#CambiarPisoMenuButton").click(function() {

    var piso = $("#nuevoPiso").val();

    pisoActual = piso;

    socket.emit('nuevoPiso', {

      piso: piso,
      area: elementsarray,//$('#selected_area').val(),
      hotel_id: hotel_id

    });

    $("#CambiarPisoMenu").modal("hide");

  });

  $("#EliminarAreaButton").click(function() {

    socket.emit('eliminarArea', {

      area: elementsarray,//$('#selected_area').val(),
      hotel_id: hotel_id

    });

    $("#EliminarArea").modal("hide");

  });

});
