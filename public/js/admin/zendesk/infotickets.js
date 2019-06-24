var tags_multi = ['antena', 'dispositivo', 'enlace', 'cableado'];
$(function() {
  $(".select2").select2({
    dropdownParent: $("#modal-view-info-ticket"),
    width: '65%'
  });
  $('#select_public').select2({dropdownParent: $("#modal-view-info-ticket")});
  // $('.tagEdit').tagEditor({placeholder: 'Enter tags ...'});
  moment.locale('es');
  $('#datepickerMonthticket').datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "years",
    minViewMode: "months",
  });
  $('.input-daterange').datepicker({language: 'es', format: "yyyy-mm", viewMode: "years", minViewMode: "months",});
  header_a();
  graph_graph_tickets();
  ticket_table();
});

var mesyearnow = moment().format("YYYY-MM");
var mesyearnowminus = moment().subtract(2, 'months').format('YYYY-MM');

$('#datepickerMonthticket').val(mesyearnow);
$('#datepickerMonthticket').children().val(mesyearnow);
$('#date_start').val(mesyearnowminus);
$('#date_start').children().val(mesyearnowminus);
$('#date_end').val(mesyearnow);
$('#date_end').children().val(mesyearnow);

$('.btn_search').on('click', function(){
  header_a();
  ticket_table();
  graph_graph_tickets();
});
$('.btn_search2').on('click', function(){
  header_a();
  ticket_table();
  graph_graph_tickets();
});
function header_a(){
  var objData = $("#generate_myticket2").find("select,textarea, input").serialize();
  $.ajax({
    type: "POST",
    url: "/search_data_traf_tickets",
    data: objData,
    success: function (data){
      // datax = JSON.parse(data);
      // console.log(data);
      $("#tickets_all").text(data[0].all);
      $("#tickets_a").text(data[0].open);
      $("#tickets_b").text(data[0].pending);
      $("#tickets_c").text(data[0].hold);
      $("#tickets_d").text(data[0].solved);
      $("#tickets_e").text(data[0].closed);
      $("#ticket_act_time").text(data[0].time);
    },
    error: function (data) {
    console.log('Error:', data);
    }
  });
}
function ticket_table() {
  var objData = $('#generate_myticket2').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/get_table_ticket",
      data: objData,
      success: function (data){
        // console.log(data);
        gen_ticket_table(data, $("#table_tickets"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function gen_ticket_table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_ticket);
  vartable.fnClearTable();
  $.each(datajson, function(index, status){
  vartable.fnAddData([
    status.id,
    status.asunto,
    status.nombre_solicitante,
    status.prioridad,
    get_square(status.status),
    '<a href="javascript:void(0);" onclick="enviar(this)" title="Ver info" value="'+status.id+'" class="btn btn-primary btn-xs" role="button" data-target="#modal-concept"><span class="fa fa-envelope"></span></a><a href="https://sitwifi.zendesk.com/agent/tickets/'+status.id+'" title="Ir a Zendesk" target="_blank" class="btn bg-orange btn-xs" role="button"><span class="fa fa-external-link-square"></span> Zendesk</a>',
    ]);
  });
}
function get_square(status) {
  $string_s = "";
  switch(status) {
    case 'open':
        $string_s = '<span class="description-percentage text-red"><i class="fa fa-square"></i>'+status+'</span>';
        break;
    case 'pending':
        $string_s = '<span class="description-percentage text-blue"><i class="fa fa-square"></i>'+status+'</span>';
        break;
    case 'hold':
        $string_s = '<span class="description-percentage text-black"><i class="fa fa-square"></i>'+status+'</span>';
        break;
    case 'closed':
        $string_s = '<span class="description-percentage text-gray"><i class="fa fa-square"></i>'+status+'</span>';
        break;
    case 'solved':
        $string_s = '<span class="description-percentage text-purple"><i class="fa fa-square"></i>'+status+'</span>';
        break;
    case 'new':
        $string_s = '<span class="description-percentage text-yellow"><i class="fa fa-square"></i>'+status+'</span>';
        break;
    default:
        $string_s = '<span class="description-percentage text-brown"><i class="fa fa-square"></i>Borrado</span>';
  }
  return $string_s;
}
function graph_graph_tickets() {
  var objData = $("#generate_myticket2").find("select,textarea, input").serialize();
  var dataTimesSolucion2 = [];
  var dataTimesFirstR2 = [];
  var dataTimesName2 = [];
  $.ajax({
    url: "/get_graph_time_ticket",
    type: "POST",
    data: objData,
    success: function (data) {
      // console.log(data);
      $.each(data, function(index, dataTime){
          dataTimesSolucion2.push(dataTime.FistResolutionTimeMin);
          dataTimesFirstR2.push(dataTime.PrimeraRespuestaMin);
          dataTimesName2.push(dataTime.dia);
        });
        graph_barras_ticket_time('maingraphicTicketsR', dataTimesName2, dataTimesFirstR2, dataTimesSolucion2);

    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
function graph_barras_ticket_time(title, dias, dataTimesFirstR2, dataTimesSolucion2) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    title: {
       text: '',
       padding: 20,
       subtext:  '',
       textStyle: {
        color: '#449D44',
        fontStyle: 'normal',
        fontWeight: 'normal',
        fontFamily: 'sans-serif',
        fontSize: 18,
        align: 'left',
        verticalAlign: 'bottom',
        width: '20%',
        textBorderColor: 'transparent',
        textBorderWidth: 0,
        textShadowColor: 'transparent',
        textShadowBlur: 0,
        textShadowOffsetX: 0,
        textShadowOffsetY: 0,
       },
       subtextStyle: {
        padding: 20,
        color: '#449D44',
        fontStyle: 'normal',
        fontWeight: 'normal',
        fontFamily: 'sans-serif',
        fontSize: 10,
        align: 'left',
        verticalAlign: 'bottom',
        width: '20%',
        textBorderColor: 'transparent',
        textBorderWidth: 0,
        textShadowColor: 'transparent',
        textShadowBlur: 0,
        textShadowOffsetX: 0,
        textShadowOffsetY: 0,
       },
    },
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type: 'cross',
            label: {
                backgroundColor: '#6a7985'
            }
        }
    },
    legend: {
      data:['Primera Respuesta (minutos)', 'Tiempo de solución (minutos)']
    },
    toolbox: {
        show : false,
        feature : {
            dataView : {show: false, readOnly: false, title : 'Datos', lang: ['Vista de datos', 'Cerrar', 'Actualizar']},
            magicType : {
              show: true,
              type: ['line', 'bar'],
              title : {
                line : 'Gráfico de líneas',
                bar : 'Gráfico de barras',
                stack : 'Acumular',
                tiled : 'Tiled',
                force: 'Cambio de diseño orientado a la fuerza',
                chord: 'Interruptor del diagrama de acordes',
                pie: 'Gráfico circular',
                funnel: 'Gráfico de embudo'
              },
            },
            restore : {show: false, title : 'Recargar'},
            saveAsImage : {show: true , title : 'Guardar'}
        }
    },
    calculable : true,
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : dias,
            axisTick: {
                alignWithLabel: true
            },
            axisLabel : {
               show:true,
               interval: 'auto',    // {number}
               rotate: 30,
               margin: 10,
               formatter: '{value}',
               textStyle: {
                   fontFamily: 'sans-serif',
                   fontSize: 10,
                   fontStyle: 'italic',
                   fontWeight: 'bold'
               }
            }
        }
    ],
    yAxis : [
        {
            type : 'value',
            boundaryGap: [0, 0.1]
        }
    ],
    series : [
      {
          name:'Primera Respuesta (minutos)',
          type:'line',
          smooth:true,
          itemStyle: {normal: {areaStyle: {type: 'default'}}},
          data: dataTimesFirstR2
      },
      {
          name:'Tiempo de solución (minutos)',
          type:'line',
          smooth:true,
          itemStyle: {normal: {areaStyle: {type: 'default'}}},
          data: dataTimesSolucion2
      }
    ]
  };
  myChart.setOption(option);

  $(window).on('resize', function(){
      if(myChart != null && myChart != undefined){
          myChart.resize();
      }
  });
}

function enviar(e){
  var valor= e.getAttribute('value');
  $('#id_ticket').val(valor);
  var _token = $('input[name="_token"]').val();
  enable_fields();
  //$('#comment_section').show();
  $.ajax({
      type: "POST",
      url: "/get_info_reg_ticket",
      data: { ticket : valor , _token : _token },
      success: function (data){
        // console.log(data);
        datax = JSON.parse(data);
        if (data === '0') {
          swal("Error", "RecordNotFound: El ticket no fue encontrado o ha sido borrado del sistema.", "error");
        }else{
          // console.log(datax);
          // console.log(datax['ticket'].custom_fields[0].value);
          if (datax['ticket'].status === "solved" || datax['ticket'].status === "closed") {
            disable_fields();
            //$('#comment_section').hide();
          }
          $("#title_ticket").text(datax['ticket'].subject);
          if (!datax['ticket'].via_from_address) {$("#email_ticket").text('No proveído');}else{$("#email_ticket").text(datax['ticket'].via_from_address);}
          if (!datax['ticket'].via_from_name) {$("#remitente_ticket").text('No proveído');}else{$("#remitente_ticket").text(datax['ticket'].via_from_name);}
          
          $("#hora_levantamiento").text(datax['ticket'].created_at);
          $("#levantamiento_ticket").text(datax['ticket'].via.channel);
          if (!datax['ticket'].custom_fields[0]) {$('#nom_cliente').val('');}else{$('#nom_cliente').val(datax['ticket'].custom_fields[0].value);}
          if (!datax['ticket'].custom_fields[1]) {$('#empresa').val('');}else{$('#empresa').val(datax['ticket'].custom_fields[1].value);}
          if (!datax[0]['id_sitio']) {$('#select_site').val('').trigger('change');}else{$('#select_site').val(datax[0]['id_sitio']).trigger('change');}

          if (!datax[0]['itc']) {$('#select_itc').val('').trigger('change');}else{$('#select_itc').val(datax[0]['itc']).trigger('change');}

          if (!datax['ticket'].type) {$("#select_type").val('').trigger('change');}else{$("#select_type").val(datax['ticket'].type).trigger('change');}
          if (!datax['ticket'].priority) {$("#select_priority").val('').trigger('change');}else{$("#select_priority").val(datax['ticket'].priority).trigger('change');}
          if (!datax['ticket'].status) {$('#select_status').val('').trigger('change');}else{$('#select_status').val(datax['ticket'].status).trigger('change');}
          // console.log(datax['ticket'].tags.length);
          $('.tagEdit').tagEditor('destroy');
          if (datax['ticket'].tags.length > 0) {
            // Tiene info.
            $('.tagEdit').tagEditor({initialTags: datax['ticket'].tags,placeholder: 'Enter tags ...'});
            // $('#select_tags').empty();
            // $.each(datax['ticket'].tags, function(index, tags){
            //   $('#select_tags').append('<option value="'+tags+'" selected>'+tags+'</option>');
            // });
          }else{
            //  No tiene info.
            $('.tagEdit').tagEditor({placeholder: 'Enter tags ...'});
          }

          $('#comment').val('\n\nAtentamente.\n'+auth_name+'.');
          var size = datax['comments'].length;
          var cont = size;
          //console.log(datax['comments'][0].author_id);
          $("#global_mensajes").empty();
          
          while(cont--){
            if (datax['comments'][cont].public === true) {
              $("#global_mensajes").append('<p style="padding-left: 20px;">' + datax['comments'][cont].author_id +': </p>' + datax['comments'][cont].html_body);
            }else{
              $("#global_mensajes").append('<div class="interno"><p style="padding-left: 20px;">' + datax['comments'][cont].author_id + ': </p>' + datax['comments'][cont].html_body + '</div>');
            }
          }
          $('#modal-view-info-ticket').modal('show');
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
$('#update_status').on('click', function(){
  // var type_update = 1;
  $('#update_status').prop('disabled', 'disabled');
  var type_text = $('#select_type').val();
  var priority_text = $('#select_priority').val();
  var tags = $('#select_tags').tagEditor('getTags')[0].tags;
  var itc = $('#select_itc').val();
  var status_text = $('#select_status').val();
  var sitio_id = $('#select_site').val();
  var name_cliente = $('#nom_cliente').val();
  var empresa = $('#empresa').val();
  // var ticket_comment = $('#comment').val();
  var publicB = $('#select_public').val();
  var _token = $('input[name="_token"]').val();
  var id_ticket = $('#id_ticket').val();
  var data_form = { _token : _token, empresa: empresa, nom_cliente:name_cliente, select_type: type_text, select_site: sitio_id, select_tags: tags, select_itc: itc,select_priority: priority_text ,select_status: status_text, id_ticket: id_ticket };
  if (status_text === "" || sitio_id === "" || type_text === "") {
    swal("Error", "Modifique el estatus, tipo o sitio :(", "error");
  }else if (status_text === "solved") {
    swal("Error", "Añada un comentario para cerrar un ticket.", "error");
    $('#update_status').prop('disabled', false);
  }else{
    $.ajax({
        type: "POST",
        url: "/update_ticket_sc",
        data: data_form,
        success: function (data){
          //console.log(data);
          $('#comment').val('');
          $('#select_public').val('1').trigger('change');
          swal("Success", "Ticket Actualizado correctamente :)", "success");
          $('#update_status').prop('disabled', false);
          $('#modal-view-info-ticket').modal('toggle');
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
  }
});
$('#submit_ticket').on('click', function(){
  // var type_update = 2;
  $('#submit_ticket').prop('disabled', 'disabled');
  var status_text = $('#select_status').val();
  var ticket_comment = $('#comment').val();
  var type_text = $('#select_type').val();
  var priority_text = $('#select_priority').val();
  var name_cliente = $('#nom_cliente').val();
  var empresa = $('#empresa').val();
  var formData = new FormData($('#update_myticket')[0]);
  if (status_text === "" || ticket_comment === "") {
    swal("Error", "Llene los campos necesarios :(", "error");
  }else if (status_text === "solved") {
    if (name_cliente === "" || empresa === "" || priority_text === "" || type_text === "") {
      swal("Error", "Llene los campos necesarios para cerrar el ticket (cliente, empresa, tipo y prioridad)", "error");
    }else{
      swal({
        title: "Estás seguro?",  
        text: "El ticket se  marcará como resuelto!",
        type: "warning",
        // html: true,
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Continuar.!",
        cancelButtonText: "Cancelar.!",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm) {
        if (isConfirm) {
          $('.cancel').prop('disabled', 'disabled');
          $('.confirm').prop('disabled', 'disabled');
          var _token = $('input[name="_token"]').val();
          var name_cliente = $('#nom_cliente').val();
          var empresa = $('#empresa').val();
          // formData.append('empresa', $('#empresa').val());
          $.ajax({
              type: "POST",
              url: "/update_ticket_sc",
              data: formData,
              contentType: false,
              processData: false,
              success: function (data){
                // console.log(data);
                $('#comment').val('');
                $('#select_public').val('1').trigger('change');
                swal("Success", "Ticket cerrado correctamente :)", "success");
                $('#submit_ticket').prop('disabled', false);
                $('#modal-view-info-ticket').modal('toggle');
              },
              error: function (data) {
                console.log('Error:', data);
              }
          });
        } else {
          swal("Operación abortada", "Ticket no actualizado. :)", "error");
        }
      });
    }
  }else{
    $.ajax({
      type: "POST",
      url: "/update_ticket_sc",
      data: formData,
      // data: { _token : _token, type: type_text,  sitio: sitio_id, priority: priority_text, tags: tags,status: status_text, comment: ticket_comment, public: publicB, id_ticket: id_ticket },
      contentType: false,
      processData: false,
      success: function (data){
        // console.log(data);
        $('#comment').val('');
        $('#select_public').val('1').trigger('change');
        swal("Success", "Ticket Actualizado correctamente :)", "success");
        $('#submit_ticket').prop('disabled', false);
        $('#modal-view-info-ticket').modal('toggle');
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
});
function update_modal(comment, status){
  var texto = '<div class="zd-comment"><p dir="auto">'+comment+'</p></div>';
  $("#estatus_ticket").text(status);
  $('#select_status').val('').trigger('change');
  $("#global_mensajes").append(texto);
  $('#comment').val('');
}
$('#close_modal').on('change', function(){
  clean_fields();
});
function disable_fields() {
  $('#select_type').prop('disabled', 'disabled');
  $('#select_priority').prop('disabled', 'disabled');
  $('#select_status').prop('disabled', 'disabled');
  $('#comment').prop('disabled', 'disabled');
  $('#submit_ticket').prop('disabled', 'disabled');
  $('#select_itc').prop('disabled', 'disabled');
  $('#select_public').prop('disabled', 'disabled');
  // $('#select_tags').prop('disabled', 'disabled');
}
function enable_fields() {
  $('#select_type').prop('disabled', false);
  $('#select_priority').prop('disabled', false);
  $('#select_status').prop('disabled', false);
  $('#comment').prop('disabled', false);
  $('#submit_ticket').prop('disabled', false);
  $('#select_itc').prop('disabled', false);
  $('#select_public').prop('disabled', false);

}
function clean_fields() {
  $('#select_type').val('').trigger('change');
  $('#select_priority').val('').trigger('change');
  $('#select_status').val('').trigger('change');
  $('#comment').val('');
  // $('#select_itc').val('').trigger('change');
  // $('#select_public').val('').trigger('change');
}

var Configuration_table_responsive_ticket= {
        "order": [[ 1, "asc" ]],
        "select": true,
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "columnDefs": [
            {
                "targets": 0,
                "width": "0.1%",
                "className": "text-center",
            },
            {
                "targets": 1,
                "width": "1%",
                "className": "text-center",
            },
            {
                "targets": 2,
                "width": "1%",
                "className": "text-center",
            },
            {
                "targets": 3,
                "width": "1%",
                "className": "text-center",
            },
            {
                "targets": 4,
                "width": "1%",
                "className": "text-center",
            },
            {
                "targets": 5,
                "width": "0.1%",
                "className": "text-center",
            }

        ],
        dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
          {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Excel',
            titleAttr: 'Excel',
            title: function ( e, dt, node, config ) {
              var ax = 'Mis estadisticas';
              return ax;
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 0,1,2,3 ],
                modifier: {
                    page: 'all',
                }
            },
            className: 'btn btn-success',
          },
          {
            extend: 'csvHtml5',
            text: '<i class="fa fa-file-text-o"></i> CSV',
            titleAttr: 'CSV',
            title: function ( e, dt, node, config ) {
              var ax = 'Mis estadisticas';
              return ax;
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 0,1,2,3 ],
                modifier: {
                    page: 'all',
                }
            },
            className: 'btn btn-info',
          },
          {
            extend: 'pdf',
            text: '<i class="fa fa-file-pdf-o"></i>  PDF',
            title: function ( e, dt, node, config ) {
              var ax = 'Mis estadisticas';
              return ax;
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 0,1,2,3 ],
                modifier: {
                    page: 'all',
                }
            },
            className: 'btn btn-danger',
          }
        ],
        language:{
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "<i class='fa fa-search'></i> Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
              "sFirst":    "Primero",
              "sLast":     "Último",
              "sNext":     "Siguiente",
              "sPrevious": "Anterior"
            },
            "oAria": {
              "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
              "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            'select': {
                'rows': {
                    _: "%d Filas seleccionadas",
                    0: "Haga clic en una fila para seleccionarla",
                    1: "Fila seleccionada 1"
                }
            }
        },
};