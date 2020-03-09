$('#btn_cl_diario').on('click',function(){

var _token = $('meta[name="csrf-token"]').attr('content');

var calendario_hoy = $('#calendario_hoy').val();
var documentacion_tickets = $('#documentacion_tickets').val();
var uniforme = $('#uniforme').val();
var llave_uniforme = $('#llave_uniforme').val();
var gym = $('#gym').val();
var mantener_orden = $('#mantener_orden').val();
var trato_cordial = $('#trato_cordial').val();
var calendario_2dias = $('#calendario_2dias').val();
var diagnosticar_equipos = $('#diagnosticar_equipos').val();
var current_date= new Date().toISOString().slice(0,10);
var itc_id = $('#select_itc').val();

$.ajax({
  type:"POST",
  url:"/cl_diario_itc",
  data:{_token:_token,calendario_hoy:calendario_hoy,documentacion_tickets:documentacion_tickets,uniforme:uniforme,llave_uniforme:llave_uniforme,
        gym:gym,mantener_orden:mantener_orden,trato_cordial:trato_cordial,calendario_2dias:calendario_2dias,diagnosticar_equipos:diagnosticar_equipos,
        fecha:current_date,itc_id:itc_id},
  success:function(data){
    Swal.fire({
      position: 'center',
      type: 'success',
      title: 'Checklist guardado!',
      showConfirmButton: false,
      timer: 1200
    })

    //console.log(data);
  },
  error:function(data){
    Swal.fire({
       position: 'center',
       type: 'error',
       title: 'Oops...',
       text: data,
    });
    console.log("error: " + data);
  }
})


});


$('#cliente_5dia').on('change',function(){
  var cliente=$('#cliente_5dia').val();
  if(cliente!=0){
    $('#btn_cl_5dia').removeClass('disabled');
  }else{
    $('#btn_cl_5dia').addClass('disabled');
  }

});

$('#btn_cl_5dia').on('click',function(){
    var _token = $('meta[name="csrf-token"]').attr('content');
    var reporte =$('#reporte_red').val();
    var nps = $('#nps').val();
    var factura_cliente = $('#factura_cliente').val();
    var memoria_tecnica = $('#memoria_tecnica').val();
    var inventario_actualizado = $('#inventario_actualizado').val();
    var current_date= new Date().toISOString().slice(0,10);
    var itc_id = $('#select_itc').val();
    var sitio = $('#cliente_5dia').val();

    $.ajax({
      type:"POST",
      url:"/cl_5dia_itc",
      data:{_token:_token,reporte:reporte,nps:nps,factura_cliente:factura_cliente,memoria_tecnica:memoria_tecnica,
            inventario_actualizado:inventario_actualizado,fecha:current_date,itc_id:itc_id,sitio:sitio},
      success:function(data){
        console.log(data);
      },
      error:function(data){
        console.log('Error en: '+data);
      }
    });

});
