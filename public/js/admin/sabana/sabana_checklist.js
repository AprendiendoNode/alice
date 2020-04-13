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
$('#btn_cl_principales').on('click',function(){

var _token = $('meta[name="csrf-token"]').attr('content');
var itc_id = $('#select_itc').val();
var form = $('#form_act_prin');
//var formData = new FormData(form);

form.append(`<input type="hidden" name="itc" value="${itc_id}" />`);
$.post('cl_act_prin', form.serialize(), response => {

  form[0].reset();

  Swal.fire('Checklist guardado', '', 'success');
});


});

$('#cliente_5dia').on('change',function(){
  var cliente=$('#cliente_5dia').val();
  if(cliente!=0){
    $('#btn_cl_5dia').removeClass('disabled');
    $('#btn_cl_5dia').show();
  }else{
    $('#btn_cl_5dia').addClass('disabled');
    $('#btn_cl_5dia').hide();
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
        Swal.fire({
          position: 'center',
          type: 'success',
          title: 'Checklist guardado!',
          showConfirmButton: false,
          timer: 1200
        })
      },
      error:function(data){
        Swal.fire({
           position: 'center',
           type: 'error',
           title: 'Oops...',
           text: data,
        });
        console.log('Error en: '+data);
      }
    });

});


$('#cliente_20dia').on('change',function(){
  var cliente=$('#cliente_20dia').val();
  if(cliente!=0){
    $('#btn_cl_20dia').removeClass('disabled');
    $('#btn_cl_20dia').show();
  }else{
    $('#btn_cl_20dia').addClass('disabled');
    $('#btn_cl_20dia').hide();
  }

});


$('#btn_cl_20dia').on('click',function(){
    var _token = $('meta[name="csrf-token"]').attr('content');
    var visita_cliente =$('#visita_cliente').val();
    var revisar_disp = $('#revisar_disp').val();
    var detectar_oportunidad = $('#detectar_oportunidad').val();
    var revisar_informacion = $('#revisar_informacion').val();
    var detecta_nuevas_oportunidades = $('#detecta_nuevas_oportunidades').val();
    var mantto = $('#mantto').val();
    var backup = $('#backup').val();
    var revisar_renovar = $('#revisar_renovar').val();
    var cliente_pago = $('#cliente_pago').val();

    var current_date= new Date().toISOString().slice(0,10);
    var itc_id = $('#select_itc').val();
    var sitio = $('#cliente_20dia').val();

    $.ajax({
      type:"POST",
      url:"/cl_20dia_itc",
      data:{_token:_token,visita_cliente:visita_cliente,revisar_disp:revisar_disp,detectar_oportunidad:detectar_oportunidad,revisar_informacion:revisar_informacion,
      detecta_nuevas_oportunidades:detecta_nuevas_oportunidades,mantto:mantto,backup:backup,revisar_renovar:revisar_renovar,cliente_pago:cliente_pago,fecha:current_date,
      itc_id:itc_id,sitio:sitio},
      success:function(data){
        Swal.fire({
          position: 'center',
          type: 'success',
          title: 'Checklist guardado!',
          showConfirmButton: false,
          timer: 1200
        })
      },
      error:function(data){
        Swal.fire({
           position: 'center',
           type: 'error',
           title: 'Oops...',
           text: data,
        });
        console.log('Error en: '+data);
      }
    });
});
