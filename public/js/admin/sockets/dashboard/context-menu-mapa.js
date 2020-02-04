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
      case "orientacion":

        break;
      default:

    }
  },
  items:{
    mapa: { name: "Cargar mapa", icon: "fas fa-map-marked-alt" },
    fold1a: {
        name: "Orientación",
        icon:"fas fa-arrows-alt",
        items: {
            fold1a_key1: {name: "Completa", icon: "fas fa-stop"},
            fold1a_key2: {name: "Centrada", icon: "fas fa-pause"},
            fold1a_key3: {name: "Izquierda", icon: "fas fa-caret-square-left"},
            fold1a_key4: {name: "Derecha", icon: "fas fa-caret-square-right"},
        }
    }
  }

});

});
