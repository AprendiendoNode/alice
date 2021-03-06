$(window).on("load",function() {

  socket.on('actualizarAreas', function(areas) {

    $("#salvarMovimientos").addClass("d-none");
    $("#descartarMovimientos").addClass("d-none");
    $(".descartar").addClass("d-none");

    actualizarAreas(areas);

  });

  $("#AgregarAreaButton").click(function() {

    var nombre = $("#nombreArea").val();
    var estado = $("#estado").val();
    var piso = $("#pisoAgregarArea").val();

    if(piso == null) piso = "Piso 1";

    pisoActual = piso;

    socket.emit('nuevaArea', {
      nombre: nombre,
      estado: estado,
      hotel_id: hotel_id,
      piso: piso
    });

    $("#AgregarArea").modal("hide");
    $("#nombreArea").val("");
    $("#estado").val("0");

  });

  var distancias_left, distancias_top;

  function actualizarAreas(areas) {

    allAreas = areas;
    cambios = [];

    $(".blink").remove();

    areas.forEach(function(area) {

      $("#mapa").append( "<div id='area"+area.id+"' class='ui-widget-content resizable blink d-none' style='overflow: hidden;'></div>" );

      $(".blink").draggable({
        containment: "#mapa",
        start: function(e, ui) {
          if($(this).hasClass("ui-selected")) {
            $(".ui-selected").addClass("simultaneous-drag");
            distancias_left = [];
            distancias_top = [];
            $(".ui-selected").each(function (index, element) {
              distancias_left[index] = parseInt($(this).css('left')) - ui.offset.left;
              distancias_top[index] = parseInt($(this).css('top')) - ui.offset.top;
            });
          } else {
            $(".ui-selected").removeClass("simultaneous-drag");
          }
        },
        drag: function(e, ui) {
          $(".ui-selected.simultaneous-drag").each(function (index, element) {
            $(this).css('left', ui.offset.left + distancias_left[index]);
            $(this).css('top', ui.offset.top + distancias_top[index]);
          });
        },
        stop: function(e, ui) {
          ajustarArea($(this).attr("id"), 1);
          $(".ui-selected").each(function (index, element) {
            ajustarArea($(element).attr("id"), 1);
          });
        }
      });

      $(".blink").resizable({
        containment: "#mapa",
        minHeight: 18,
        minWidth: 18,
        stop: function(e, ui) { ajustarArea($(this).attr("id"), 2); }
      });

      $("#area"+area.id).append("<div class='area-font-size' style='font-family: Helvetica; font-weight: bold; text-align: center;'><p class='test-area' >"+area.nombre+"</p></div>");

      $("#area"+area.id).css("width", area.width + "%");
      //$("#area"+area.id).css("font-size", $("#area"+area.id).width() / 6 + "px");
      //$("#area"+area.id).css("line-height", $("#area"+area.id).width() / 6 + "px");
      $("#area"+area.id).css("height", area.height + "%");
      $("#area"+area.id).css("left", area.left + "%");
      $("#area"+area.id).css("top", area.top + "%");
      $("#area"+area.id).css("background-color", area.color);
      $("#area"+area.id).css("border", "0.1vw solid " + area.border);

    });

    if($(window).width() < 700) {

      $(".blink").draggable("destroy");
      $(".blink").resizable("destroy");

    }

    socket.emit('actualizarPisos', {

        hotel_id: hotel_id

    });

  }

  function ajustarArea(areaId, action) {

    $("#salvarMovimientos").removeClass("d-none");
    $("#descartarMovimientos").removeClass("d-none");
    $(".descartar").removeClass("d-none");

    var anchoBase = $("#mapa").width();
    var largoBase = $("#mapa").height();
    var anchoArea = $("#" + areaId).css("width").split("px")[0];
    var largoArea = $("#" + areaId).css("height").split("px")[0];
    var leftArea = $("#" + areaId).css("left").split("px")[0];
    var topArea = $("#" + areaId).css("top").split("px")[0];
    if(parseInt(leftArea) < 0) leftArea = 0;
    if(parseInt(topArea) < 0) topArea = 0;

    var widthArea = (anchoArea * 100) / anchoBase;
    var heightArea = (largoArea * 100) / largoBase;
    var leftArea = (leftArea * 100) / anchoBase;
    var topArea = (topArea * 100) / largoBase;

    var res = allAreas.filter(function (area) {

      return area.id == areaId.split("area")[1];

    });

    if(action == 1) {

      $("#" + areaId).css("left", leftArea + "%");
      $("#" + areaId).css("top", topArea + "%");
      res[0].left = leftArea;
      res[0].top = topArea;

    } else {

      //$("#" + areaId).css("font-size", $("#"+areaId).width() / 6 + "px");
      //$("#" + areaId).css("line-height", $("#"+areaId).width() / 6 + "px");
      $("#" + areaId).css("width", widthArea + "%");
      $("#" + areaId).css("height", heightArea + "%");
      res[0].width = widthArea;
      res[0].height = heightArea;

    }

    if(cambios.indexOf(res[0].id) < 0) cambios.push(res[0].id);

  }

});
