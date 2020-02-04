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
      case "test2":

        break;
      default:

    }
  },
  items:{
    "mapa":{name:"Cargar mapa",icon:"fas fa-map-marked-alt"},
    //"test2":{name:"test2",icon:"fas fa-eye"}
  }

});

});
