$(window).on("load",function(){

$.contextMenu({
  selector:'#mapa',
  trigger:(($(window).width() < 700) ? 'left' : 'right'),
  events:{
    show: function(options){
      //console.log("abierto");
    },
    hide:function(options){
      //console.log("cerrado");
    }
  },
  callback:function(key,options){
    switch (key) {
      case "mapa":
        $('#modalañadir').modal("show");
        break;
      case "Completa":
        $('#blob-containment-wrapper').addClass("d-none");
        $('#containment-wrapper').css("width", "100%");
        $('#containment-wrapper').css("height", "85vh");
        break;
      case "Centrada":
        $('#blob-containment-wrapper').removeClass("d-none");
        $('#blob-containment-wrapper').css("width", "15%");
        $('#containment-wrapper').css("width", "70%");
        $('#containment-wrapper').css("height", "160vh");
        break;
      case "Izquierda":
        $('#blob-containment-wrapper').addClass("d-none");
        $('#containment-wrapper').css("width", "70%");
        $('#containment-wrapper').css("height", "160vh");
        break;
      case "Derecha":
        $('#blob-containment-wrapper').removeClass("d-none");
        $('#blob-containment-wrapper').css("width", "30%");
        $('#containment-wrapper').css("width", "70%");
        $('#containment-wrapper').css("height", "160vh");
        break;
    }
  },
  items:{
    mapa: { name: "Cargar mapa", icon: "fas fa-map-marked-alt" },
    Orientacion: {
        name: "Orientación",
        icon:"fas fa-arrows-alt",
        items: {
            Completa: {name: "Completa", icon: "fas fa-stop"},
            Centrada: {name: "Centrada", icon: "fas fa-pause"},
            Izquierda: {name: "Izquierda", icon: "fas fa-caret-square-left"},
            Derecha: {name: "Derecha", icon: "fas fa-caret-square-right"},
        }
    }
  }

});

});
