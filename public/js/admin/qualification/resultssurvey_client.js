$(function(){
  table_results();
  $('#date_to_search').datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months",
    endDate: '-1m',
    autoclose: true,
    clearBtn: true
  });
  $('#date_to_search').val('').datepicker('update');

  $('#Fecha').datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months",
    endDate: '-1m',
    autoclose: true,
    clearBtn: true
  });
  $('#Fecha').val('').datepicker('update');

  moment.locale('es');
});

$('.filtrarDashboard').on('click',function(){
table_results();
});



function table_results() {
  var objdata = $('#search_info').find("select,textarea, input").serialize();

  $.ajax({
      type: "POST",
      url: "/get_table_results",
      data: objdata,
      success: function (data){
        //console.log(data);
        create_table_results(data, $('#table_results_full'));
        document.getElementById("table_results_full_wrapper").childNodes[0].setAttribute("class", "form-inline");
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function create_table_results(datajson, table) {
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_with_pdf_dashboardNPS);
  vartable.fnClearTable();
  var suma = 0;
  $.each(JSON.parse(datajson), function(index, status){

    vartable.fnAddData([
      status.Venue,
      status.Cliente,
      //status.Comentario,
      getValueCurrent(status.NPS),
      status.IT,
      '<div class="text-center">'+
      '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.id+'" data[hotel_id]="'+status.hotels_id+'" data[cliente]="'+status.Cliente+'" data[correo]="'+status.Cliente_email+'" data[it]="'+status.IT+'" data[it_email]="'+status.IT_email+'" data[comentario]="'+status.Comentario+'" data[nps]="'+status.NPS+'" class="btn btn-default btn-sm" role="button" data-target="#modal-edithotcl"><span class="fas fa-envelope"></span></a>'+
      '</div>',
    ]);
  });
}
var correo_itc='';
var hotel_id='';
function enviar(e){
  //console.log(e);
  var id= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  var date = $('#date_to_search').val();
  hotel_id =e.getAttribute('data[hotel_id]');
  $('#ModalMail').modal('show');
  console.log(id);
  if( id!="-"){
  $.ajax({
       type: "POST",
       url: './survey_viewresults_modal',
       data: { id:id,date:date,hotel_id:hotel_id, _token : _token},
       success: function (data) {
         //console.log(data);
         $('#Cliente').val(data[0].Cliente);
         $('#Correo').val(data[0].Cliente_email);
         $('#ITC').val(data[0].IT);
         $('#Comentario_actual').val(data[0].Comentario);
         $('#calif_1').html('');
         var calif_1=getValueCurrent(data[0].NPS);
         $('#calif_1').append(calif_1);

         $('#Comentario_anterior').val(data[0].Comentario1);
         $('#calif_2').html('');
         var calif_2=getValueCurrent(data[0].NPS1);
         $('#calif_2').append(calif_2);

         if($('#date_to_search').val() != ''){
           var date = $('#date_to_search').val();
         }else{
           var date = new Date().toISOString().slice(0,10);
         }
         $('#mes_1').html('');
         $('#mes_2').html('');
         $('#mes_1').append('<span class="badge badge-dark">'+moment(date).subtract(1,'month').format('MMMM.')+'</span>');
         $('#mes_2').append('<span class="badge badge-dark">'+moment(date).subtract(2,'month').format('MMMM.')+'</span>');

       },
       error: function (data) {
         console.log('Error:', data);
       }
   });
   }else{
    $('#Cliente').val(e.getAttribute('data[cliente]'));
    $('#Correo').val(e.getAttribute('data[correo]'));
    $('#Comentario_actual').val(e.getAttribute('data[comentario]'));
    $('#ITC').val(e.getAttribute('data[it]'));
    $('#calif_1').html('');
    var calif_1=getValueCurrent(e.getAttribute('data[nps]'));
    $('#calif_1').append(calif_1);
    $('#calif_2').html('');
     $('#Comentario_anterior').val('');

     if($('#date_to_search').val() != ''){
       var date = $('#date_to_search').val();
     }else{
       var date = new Date().toISOString().slice(0,10);
     }
     $('#mes_1').html('');
     $('#mes_2').html('');
     $('#mes_1').append('<span class="badge badge-dark">'+moment(date).format('MMMM.')+'</span>');
     $('#mes_2').append('<span class="badge badge-dark">'+moment(date).subtract(1,'month').format('MMMM.')+'</span>');

}
correo_itc=e.getAttribute('data[it_email]').split(',');
console.log(correo_itc);
}

$('#sent').on('click',function(){
    var _token = $('input[name="_token"]').val();
    var correocli=$('#Correo').val();
    var comentario_correo= $('#Comentario_correo').val();
    var cliente = $('#Cliente').val();

    if($('#date_to_search').val() != ''){
      var date = $('#date_to_search').val();
    }else{
      var date = new Date().toISOString().slice(0,10);
    }
    //console.log(moment(date).format('MMM.'));
    $.ajax({
      type:"POST",
      url:"/sent_survey_client",
      data:{_token:_token,date:date,cliente:cliente,correocli:correocli,itc_email:correo_itc,comentario:comentario_correo},
      success:function(data){
        //console.log(data);
        $('#ModalMail').modal('hide');
        Swal.fire("Operación Completada!", ":)", "success");
        setTimeout(function(){
          Swal.close();
        },1000);
      },
      error: function(data){
        console.log('Error: '+data);
      }

    })



});

function getValueCurrent(qty) {
  var retval;
  var val=qty;
  switch(val){
    case 'Pr':
      retval = '<span class="badge badge-success">Promotor</span>';
      break;
    case 'Ps':
      retval = '<span class="badge badge-warning">Pasivo</span>';
      break;
    case 'D':
      retval = '<span class="badge badge-danger">Detractor</span>';
      break;
    case 'NA':
      retval = '<span class="badge badge-danger">Sin calificación</span>';
      break;
    default:
      retval = '<span class="badge badge-danger">Sin calificación</span>';
  }
  return retval;
}


$('#Fecha').on('change',function(){
  var _token = $('input[name="_token"]').val();
  var correo = $('#Correo').val();
  var fecha = $('#Fecha').val();
  console.log(fecha);
$.ajax({
  type:"POST",
  url:"/get_history_surveyresult_modal",
  data:{_token:_token,hotel_id:hotel_id,correo:correo,date:fecha},
  success:function(data){
    //console.log(data);
    if(data.length != 0){


    $('#Cliente').val(data[0].Cliente);
    $('#Correo').val(data[0].Cliente_email);
    $('#ITC').val(data[0].IT);
    $('#Comentario_actual').val(data[0].Comentario);
    $('#calif_1').html('');
    var calif_1=getValueCurrent(data[0].NPS);
    $('#calif_1').append(calif_1);

    $('#Comentario_anterior').val(data[0].Comentario1);
    $('#calif_2').html('');
    var calif_2=getValueCurrent(data[0].NPS1);
    $('#calif_2').append(calif_2);

    $('#mes_1').html('');
    $('#mes_2').html('');
    $('#mes_1').append('<span class="badge badge-dark">'+moment(fecha).format('MMMM.')+'</span>');
    $('#mes_2').append('<span class="badge badge-dark">'+moment(fecha).subtract(1,'month').format('MMMM.')+'</span>');

  }else{
        $('#calif_1').html('');
        $('#calif_2').html('');
        $('#Comentario_actual').val('');
        $('#Comentario_anterior').val('');

        $('#mes_1').html('');
        $('#mes_2').html('');
        $('#mes_1').append('<span class="badge badge-dark">'+moment(fecha).format('MMMM.')+'</span>');
        $('#mes_2').append('<span class="badge badge-dark">'+moment(fecha).subtract(1,'month').format('MMMM.')+'</span>');
  }

  },
  error:function(data){

  }

});


});
