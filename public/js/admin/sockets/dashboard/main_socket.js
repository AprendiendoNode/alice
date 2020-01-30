$(function(){
  var _token = $('input[name="_token"]').val();
  $(".select2").select2();
$('#select_sitios').on('change',function(){
  hotel_id =$('#select_sitios').val();
  console.log(hotel_id);

  socket.emit('init', {

      hotel_id: hotel_id

  });
});
});
