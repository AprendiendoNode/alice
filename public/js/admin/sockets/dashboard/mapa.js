$(window).on("load", function() {

  //SHORTROUTES, TEMPORAL UBICATION
  $(document).keydown(function(e) {
      if (e.keyCode == 17 && ctrl_status > 0) { //ctrl key
        ctrl_status = 2;
        $('.blink').draggable('disable');
        $('.blink').resizable('disable');
      }
  });

  $(document).keyup(function(e) {
      if (e.keyCode == 17 && ctrl_status > 0) { //ctrl key
        ctrl_status = 1;
        $('.blink').draggable('enable');
        if($(".ui-selected").length == 0) {
          $('.blink').resizable('enable');
        }
      }
  });

  /*$("#mapa").draggable({
    containment: "#containment-wrapper",
    stop: function(e, ui) { ajustarMapa(1); }
  });*/

  $("#mapa").resizable({
    containment: "#containment-wrapper",
    minHeight: 250,
    minWidth: 400,
    stop: function(e, ui) {
      ui.element.css(ui.originalSize);
      ajustarMapa(2);
      $("#salvarMovimientos").addClass("d-none");
      $("#descartarMovimientos").addClass("d-none");
      $(".descartar").addClass("d-none");
      toastr.error('', '!Haz Click Derecho -> Orientación para cambiar el tamaño del mapa!', {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      });
    }
  });

  $( "#mapa" ).selectable({
    filter: ".blink",
    tolerance: "fit",
    stop: function() {
      if($(".ui-selected").length > 0) {
        $(".blink").resizable('disable');
        $(".ui-selected").contextMenu(true);
        $(".blink:not(.ui-selected)").contextMenu(false);
      } else {
        $(".blink").contextMenu(true);
      }
    },
    unselected: function(event,ui){
      if(ctrl_status != 2) {
        $('.blink').resizable('enable');
      }
    }
  });

  $(".row-select, .row-buttons").click(function() {
    $(".blink").removeClass("ui-selected");
    $('.blink').resizable('enable');
    try {
      $('.blink').contextMenu(true);
    } catch(e) {}
    elementsarray=[];
  });

  if($(window).width() < 700) {

    //$("#mapa").draggable("destroy");
   //$("#mapa").resizable("destroy");
   $("#mapa").selectable("destroy");

  } else  {

    $("#agregarHabitacion").removeClass("d-none");
    $("#agregarSitio").removeClass("d-none");
    $("#BtnGeneral").removeClass("mx-auto");

  }

  socket.on('actualizarMapa', function(hotel) {

    width = hotel[0].width;
    height = hotel[0].height;
    left = hotel[0].left;
    _top = hotel[0].top;
    hotel_mapa = hotel[0].mapa;

    actualizarMapa();

  });

  function actualizarMapa() {
    var urlarray=(window.location.href).split("/");
    var image_url=urlarray[0]+'//'+urlarray[2]+'/'+hotel_mapa;
    $("#mapa").css("width", width + "%");
    $("#mapa").css("height", height + "%");
    $("#mapa").css("left", left + "%");
    $("#mapa").css("top", _top + "%");

    $.get(image_url).done(function() {
        $("#mapa").css("background-image", "linear-gradient(rgba(0, 0, 0, 0.350), rgba(0, 0,0, 0.350)), url(" + hotel_mapa + ")");
    }).fail(function() {
        $("#mapa").css("background-image", "url('images/storage/sockets/img/mapas/mapa_generico.svg')");
        $('#mapa').addClass('text-center');
    });
    $("#mapa").css("background-position", "center center");
    $("#mapa").css("background-repeat", "no-repeat");
    $("#mapa").css("background-size", "100% 100%");
    $("#mapa").css("background-color", "white");
  }

  function ajustarMapa(action) {

    $("#salvarMovimientos").removeClass("d-none");
    $("#descartarMovimientos").removeClass("d-none");
    $(".descartar").removeClass("d-none");

    var anchoBase = $("#containment-wrapper").width();
    var largoBase = $("#containment-wrapper").height();
    var anchoMapa = $("#mapa").width();
    var largoMapa = $("#mapa").height();
    var leftMapa = $("#mapa").css("left").split("px")[0];
    var topMapa = $("#mapa").css("top").split("px")[0];
    if(parseInt(leftMapa) < 0) leftMapa = 0;
    if(parseInt(topMapa) < 0) topMapa = 0;

    width = Math.ceil(((anchoMapa * 100) / anchoBase));
    height = Math.ceil(((largoMapa * 100) / largoBase));
    left = Math.ceil(((leftMapa * 100) / anchoBase));
    _top = Math.ceil(((topMapa * 100) / largoBase));

    if(action == 1) {

      $("#mapa").css("left", left + "%");
      $("#mapa").css("top", _top + "%");

    } else {

      $("#mapa").css("width", width + "%");
      $("#mapa").css("height", height + "%");

    }

  }

  $("#salvarMovimientos").click(function() {

    $("#salvarMovimientos").addClass("d-none");
    $("#descartarMovimientos").addClass("d-none");
    $(".descartar").addClass("d-none");

    var areasCambiadas = [];

    cambios.forEach(function(id) {

      allAreas.filter(function (area) {

        if(area.id == id) areasCambiadas.push(area);

        return true;

      });

    });

    $(".blink").removeClass("ui-selected");

    socket.emit('sincronizacion', {

        sitio: hotel_id,
        width: width,
        height: height,
        left: left,
        _top: _top,
        allAreas: areasCambiadas

    });

    toastr.success('', '!Mapa sincronizado con éxito!', {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "1500",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    });

  });

  $("#descartarMovimientos").click(function() {

    $("#salvarMovimientos").addClass("d-none");
    $("#descartarMovimientos").addClass("d-none");
    $(".descartar").addClass("d-none");

    socket.emit('descartar', {

        hotel_id: hotel_id

    });

    toastr.error('', '!Cambios descartados!', {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "1500",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    });

  });

});
