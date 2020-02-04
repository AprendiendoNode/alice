$(function(){
  var _token = $('input[name="_token"]').val();
  $(".select2").select2();
$('#select_sitios').on('change',function(){
  hotel_id =$('#select_sitios').val();
  //console.log(hotel_id);

  socket.emit('init', {

      hotel_id: hotel_id

  });
});

var oklogo,okmapa;
 $('#LogoFile').on('change',function(){
   var fileInput = $('#LogoFile');
   //var filePath = $('#LogoFile').value;
    var size=$('#LogoFile')[0].files[0].size;
   //console.log(size);
   var extension=$('#LogoFile').val().replace(/^.*\./, '');

   if(extension != 'jpg'&& extension != 'jpeg' && extension != 'png'){
     //console.log("Archivo incorrecto "+ extension +" No es valido");
     $('#lblogo').removeClass('btn-warning');
     $('#lblogo').addClass('btn-danger');
     $('#txtLogo').text('Seleccione otro archivo');
     oklogo=false;
     return false;
   }else{
     //console.log("Correcto");
     $('#lblogo').removeClass('btn-danger');
     $('#lblogo').removeClass('btn-warning');
     $('#lblogo').addClass('btn-success');
     $('#txtLogo').text('Logo cargado');
     oklogo=true;
   }
});

$('#MapFile').on('change',function(){
  var fileInput = $('#MapFile');
  //var filePath = $('#MapFile').value;
  var extension=$('#MapFile').val().replace(/^.*\./, '');

  if(extension != 'jpg'&& extension != 'jpeg' && extension != 'png'){
    //console.log("Archivo incorrecto "+ extension +" No es valido");
    $('#lbmap').removeClass('btn-warning');
    $('#lbmap').addClass('btn-danger');
    $('#txtMap').text('Seleccione otro archivo');
    okmapa=false;

    return false;
  }else{
    //console.log("Correcto");
    var size=$('#MapFile')[0].files[0].size;
   //console.log(size);
    $('#lbmap').removeClass('btn-danger');
    $('#lbmap').removeClass('btn-warning');
    $('#lbmap').addClass('btn-success');
    $('#txtMap').text('Mapa cargado ('+size+'Kb)');
    okmapa=true;
  }
});

$('#submit_site').on('click',function(){
var _token = $('input[name="_token"]').val();
var form_site = $('#form_site')[0];
var form = new FormData(form_site);

$.ajax({
  type:"POST",
  url:"/savesite",
  processData: false,
  contentType: false,
  data:form,
  success:function(data){
    console.log(data);
  },
  error:function(data){
    console.log(data);
  }
});

});



});
