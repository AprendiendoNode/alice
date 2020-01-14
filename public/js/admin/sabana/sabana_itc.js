$(function() {
  $(".first_tab").champ();
  $(".select2").select2();
  $("#select_proyecto").addClass("d-none");
  $("#select_sitio").addClass("d-none");
  $('#date_to_search').datepicker({
    language: 'es',
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    startDate: '2018',
    endDate: '-0y',
    autoclose: true,
    clearBtn: true
  }).datepicker("setDate",'now');


    $('#date_presupuesto').datepicker({
      language: 'es',
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
      startDate: '2019',
      endDate: '-0y',
      autoclose: true,
      clearBtn: true
    }).datepicker("setDate",'now');

    var date = (new Date()).toString().split(" ");

    $('#date_consumos').datepicker({
      language: 'es',
      format: "yyyy-mm",
      viewMode: "months",
      minViewMode: "months",
      endDate: '1m',
      autoclose: true,
      clearBtn: true
    }).datepicker("setDate",'now');


  //Por sitio
  $("#select_itc").on('change', function(e) {
    var _token = $('input[name="_token"]').val();
    var itc = $('#select_itc').val();
    var itc_email=$('#select_itc').find(':selected').data("email");
    $(".first_tab").addClass("d-none");
    //$("#cargando").removeClass("d-none");
    $('#gral_sitio').removeClass('d-none');//Muestra la informacion por sitio
    $('#gral_cadena').addClass('d-none');//oculta la informacion por cadena.
    loading(1000);
    //TEMPORAL PRESUPUESTO CADENA
    $("#terminado_presupuesto_cadena").removeClass("d-none");
    $("#construyendo_presupuesto_cadena").addClass("d-none");

    $.ajax({
      type: "POST",
      url: "/informacionITC",
      data: { itc : itc, _token : _token },
      success: function (data){
        //console.log(data);
        $('#imagenCliente').attr("src", "../images/users/pictures/default.png");
        $("#imagenCliente").attr("src", $('#select_itc').find(':selected').data("foto"));
        $("#nombreITC").text($('#select_itc').find(':selected').data("name"));
        $("#correoITC").text($('#select_itc').find(':selected').data("email"));
        $("#localizacionITC").text($('#select_itc').find(':selected').data("city"));
        $("#total_sitios").text(data.length-1);
        generate_table_info_sitios(data, $('#info_sitios'));
        $.ajax({
          type: "POST",
          url: "/antenasITC",
          data: { itc : itc, _token : _token },
          success: function (data){
            //console.log(data);
            $("#total_antenas").text(data[0].cantidad);
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
        $.ajax({
          type: "POST",
          url: "/viaticos_x_mes",
          data: { itc : itc, _token : _token },
          success: function (data){
            graph_viaticos_x_mes('graph_viaticos_x_mes', Object.values(data[0]), Object.values(data[1]));
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
    get_nps_hotel(itc);
    get_nps_comment(itc);
    //get_graph_equipments(itc);
    //get_graph_equipments_status(itc);
    get_table_tickets(itc_email);
    get_graph_tickets_type(itc_email);
    get_graph_tickets_status(itc_email);
    //getFoliosByHotel(itc);
    getViaticsByHotel(itc);
    getProjects(itc);
  });

  $('#graph_calificaciones_x_mes').on('click', function(){
    $('li[rel=tab_1_2]').tooltip().addClass("active"); //Mostrar la pestaña de NPS
    $('.tab_1_2').addClass("active"); //Mostrar la pestaña de NPS del acordeón
    $('.tab_content.tab_1_2').css("display","block"); //Mostrar el div de NPS
    $('li[rel=tab_1_1]').tooltip().removeClass("active"); //Ocultar la pestaña de general
    $('.tab_1_1').removeClass("active"); //Ocultar la pestaña de general del acordeón
    $('.tab_content.tab_1_1').css("display","none"); //Ocultar el div de general
  });

  $('#graph_viaticos_x_mes').on('click', function(){
    $('li[rel=tab_1_4]').tooltip().addClass("active"); //Mostrar la pestaña de viáticos
    $('.tab_1_4').addClass("active"); //Mostrar la pestaña de viáticos del acordeón
    $('.tab_content.tab_1_4').css("display","block"); //Mostrar el div de viáticos
    $('li[rel=tab_1_1]').tooltip().removeClass("active"); //Ocultar la pestaña de general
    $('.tab_1_1').removeClass("active"); //Ocultar la pestaña de general del acordeón
    $('.tab_content.tab_1_1').css("display","none"); //Ocultar el div de general
  });

  $('.filtrarDashboard').on('click', function(){
    get_nps_hotel($('#cliente').val());
  });

  $('#box_promotores').on('click', function(){
    boxes_cali_modal('box_promo');
    $('#modal-view-ppd').modal('show');
  });
  $('#box_pasivos').on('click', function(){
    boxes_cali_modal('box_pas');
    $('#modal-view-ppd').modal('show');
  });
  $('#box_detractores').on('click', function(){
    boxes_cali_modal('box_detra');
    $('#modal-view-ppd').modal('show');
  });

  function boxes_cali_modal(encuestas) {
    var _token = $('meta[name="csrf-token"]').attr('content');
    var anio = $('#date_to_search').val();
    var id = $('#cliente').val();
    var cadena = $('#proyecto').val();
    var tipo = parseInt($('#tipo_sabana').val());

    if(tipo == 1) {
      //TODO SITWIFI
    } else if(tipo == 2) {
      $.ajax({
          type: "POST",
          url: "/sabana_modal_encuestas_cadena",
          data: { _token: _token, anio: anio, encuestas: encuestas, cadena: cadena },
          success: function (data){
            table_boxes_cali(data, $('#table_boxes_ppd'));
            document.getElementById("table_boxes_ppd_wrapper").childNodes[0].setAttribute("class", "form-inline");
          },
          error: function (data) {
            console.log('Error:', data);
          }
      });
    } else if(tipo == 3) {
      $.ajax({
          type: "POST",
          url: "/sabana_modal_encuestas",
          data: { _token: _token, anio: anio, encuestas: encuestas, hotel: id },
          success: function (data){
            table_boxes_cali(data, $('#table_boxes_ppd'));
            document.getElementById("table_boxes_ppd_wrapper").childNodes[0].setAttribute("class", "form-inline");
          },
          error: function (data) {
            console.log('Error:', data);
          }
      });
    }

  }

  function table_boxes_cali(datajson, table) {
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_responsive_simple_two);
    vartable.fnClearTable();
    $.each(JSON.parse(datajson), function(index, status){
      vartable.fnAddData([
        status.Cliente,
        status.Sitio,
        status.IT,
        status.fecha_update,
        status.comentario,
        getValueCurrent(status.NPS),
      ]);
    });
  }

  function get_nps_hotel(idcadena){
    var _token = $('meta[name="csrf-token"]').attr('content');
    var anio = $('#date_to_search').val();
    var id= idcadena;
    $.ajax({
      type: "POST",
      url: "/get_nps_hotel",
      data: { _token : _token, id: id, anio: anio },
      success: function (data){
        //console.log(data);
        //console.log(data[0]['nps']);
        //graph_nps_hotel('main_nps',data[0]['nps']);
        graph_gauge_hotel('main_nps_hotel', 'NPS', '100', '100', data[0]['nps']);
        $('#total_promotores').text(data[0]['pr']);
        $('#total_pasivos').text(data[0]['ps']);
        $('#total_detractores').text(data[0]['d']);
        $('#unanswered').text(data[0]['abstenidos']);
        //$('#total_survey').text(data[0]['enviadas']);
        //$('#answered').text(data[0]['respondieron']);
        //$('#unanswered').text(data[0]['abstenidos']);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });

  }

  function get_nps_cadena(idcadena){
    var _token = $('meta[name="csrf-token"]').attr('content');
    var anio = $('#date_to_search').val();
    var id= idcadena;
    $.ajax({
      type: "POST",
      url: "/get_nps_cadena",
      data: { _token : _token, id: id, anio: anio },
      success: function (data){
        //console.log(data);
        //console.log(data[0]['nps']);
        //graph_nps_hotel('main_nps',data[0]['nps']);
        graph_gauge_hotel('main_nps_hotel', 'NPS', '100', '100', data[0]['nps']);
        $('#total_promotores').text(data[0]['pr']);
        $('#total_pasivos').text(data[0]['ps']);
        $('#total_detractores').text(data[0]['d']);
        //$('#total_survey').text(data[0]['enviadas']);
        //$('#answered').text(data[0]['respondieron']);
        //$('#unanswered').text(data[0]['abstenidos']);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });

  }
  function generate_table_info_sitios(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table);
    vartable.fnClearTable();
    var sumaNPS = 0;
    var sumaFact = 0;
    var meses = [];
    $.each(datajson, function(index, status){

      if(index == 0) {
        $("#NPS1").text(status.NPS1); meses.push(status.NPS1);
        $("#NPS2").text(status.NPS2); meses.push(status.NPS2);
        $("#NPS3").text(status.NPS3); meses.push(status.NPS3);
        $("#NPS4").text(status.NPS4); meses.push(status.NPS4);
        $("#NPS5").text(status.NPS5); meses.push(status.NPS5);
        $("#NPS6").text(status.NPS6); meses.push(status.NPS6);
        $("#NPS7").text(status.NPS7); meses.push(status.NPS7);
        $("#NPS8").text(status.NPS8); meses.push(status.NPS8);
        $("#NPS9").text(status.NPS9); meses.push(status.NPS9);
        $("#NPS10").text(status.NPS10); meses.push(status.NPS10);
        $("#NPS11").text(status.NPS11); meses.push(status.NPS11);
        $("#NPS12").text(status.NPS12); meses.push(status.NPS12);
      } else {
        sumaNPS += parseInt(status.NPS_resul);
        sumaFact += status.facturacion == null ? 0 : parseInt(status.facturacion);
        vartable.fnAddData([
          status.sitio,
          '<a href="javascript:void(0);" id="ver-'+status.hotel_id+'-'+status.sitio+'" class="ver_antenas_sitio">'+status.aps+'</a>',
          status.facturacion == null ? 0 : parseInt(status.facturacion),
          status.NPS1,
          status.NPS2,
          status.NPS3,
          status.NPS4,
          status.NPS5,
          status.NPS6,
          status.NPS7,
          status.NPS8,
          status.NPS9,
          status.NPS10,
          status.NPS11,
          status.NPS12,
          status.NPS_resul
          //status.aps + ' <button id="ver-'+status.id+'-'+status.sitio+'" class="btn btn-default btn-sm ver_antenas_sitio"><span class="fa fa-eye"></span></button>',
        ]);
      }

    });

    $("#npsPromedio").text(parseInt(sumaNPS / parseInt($("#total_sitios").text())));
    $("#total_faturacion").text(sumaFact);

    var promotores = [], pasivos = [], detractores = [];

    for(var i = 0; i < 12 ; i++) { //Las clases mes y promotor, pasivo o detractor se añaden directamente desde la base de datos.
      promotores[i] = $(".mes"+(i+1)+".promotor").length;
      pasivos[i] = $(".mes"+(i+1)+".pasivo").length;
      detractores[i] = $(".mes"+(i+1)+".detractor").length;
    }

    graph_calificaciones_x_mes('graph_calificaciones_x_mes', meses, promotores, pasivos, detractores);
  }

  $(document).on("click", ".ver_antenas_sitio", function() {
    var boton = $(this)[0].id.split("-");
    $("#modal-antenas-sitioLabel").text("Antenas del sitio "+boton[2]+":");
    var _token = $('meta[name="csrf-token"]').attr('content');
    var itc = $('#select_itc').val();
    $.ajax({
      type: "POST",
      url: "/tabla_antenas_sitio",
      data: { _token : _token, sitio: boton[1], itc: itc },
      success: function (data){

        table_antenas(data, $("#tabla_antenas"));

        $('#modal-antenas-sitio').modal('show');

      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  });

  $('#total_antenas').on('click', function(){
    $("#modal-antenas-sitioLabel").text("Antenas:");
    var _token = $('meta[name="csrf-token"]').attr('content');
    var itc = $('#select_itc').val();
    $.ajax({
      type: "POST",
      url: "/tabla_antenas_ITC",
      data: { _token : _token, itc: itc },
      success: function (data){

        table_antenas(data, $("#tabla_antenas"));

        $('#modal-antenas-sitio').modal('show');

      },
      error: function (data) {
        console.log('Error:', data);
      }
    });

  });

  function table_antenas(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_antenas);
    vartable.fnClearTable();

    $.each(datajson, function(index, status){

      vartable.fnAddData([
        status.modelo,
        status.MAC,
        status.Serie,
        '<span class="badge badge-pill text-white bg-success">Activo en sitio</span>',
        status.Fecha_Registro
      ]);
    });

  }

  $(document).on("click", ".verAnexos", function() {
    var cm = $(this)[0].id.split("~");
    $('#anexosModalLabel').text('Anexos del contrato maestro: '+cm[2]);
    var _token = $('meta[name="csrf-token"]').attr('content');
    var id = cm[1];
//    console.log(id);
    $.ajax({
      type: "POST",
      url: "/get_all_annexes_by_master",
      data: { _token : _token, id: id },
      success: function (data){

        //console.log(data);

        //Montos de diferentes filas montados en la misma tabla
        var correctData = [], savedKeys = [];

        data.forEach(function(row) {
          var i = savedKeys.indexOf(row.key);
          if(i < 0) {
            if(row.moneda.startsWith("MXN")) {
              row.pesos = row.monto;
              row.dolares = null;
            } else {
              row.dolares = row.monto;
              row.pesos = null;
            }
            correctData.push(row);
            savedKeys.push(row.key);
          } else {
            if(row.moneda.startsWith("MXN")) {
              correctData[i].pesos = row.monto;
            } else {
              correctData[i].dolares = row.monto;
            }
          }
        });

        //console.log(correctData);

        table_annexes(correctData, $("#all_annexes"));

        $('#anexosModal').modal('show');

      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  });

  function get_nps_comment(idcadena){
    var _token = $('meta[name="csrf-token"]').attr('content');
    var id= idcadena;
    //console.log(id);
    $.ajax({
      type: "POST",
      url: "/get_nps_comment_hotel",
      data: { _token : _token, id: id },
      success: function (data){
        //console.log(data);
        table_comments_hotel(data,$('#nps_comments'));
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });

  }

  function get_nps_comment_cadena(idcadena){
    var _token = $('meta[name="csrf-token"]').attr('content');
    var id= idcadena;
    //console.log(id);
    $.ajax({
      type: "POST",
      url: "/get_nps_comment_cadena",
      data: { _token : _token, id: id },
      success: function (data){
        //console.log(data);
        table_comments_hotel(data,$('#nps_comments'));
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });

  }

  function table_comments_hotel(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table);
    vartable.fnClearTable();
    //console.log(datajson);
    $.each(datajson, function(index, status){

      var span_calificacion = '';
      full_star ='<span class="fas fa-star text-warning"></span>';
      empty_star='<span class="far fa-star "></span>';
      switch (status.nps ) {
        case 'Pr':
        span_calificacion = full_star.repeat(5);
          break;
        case 'Ps':
          span_calificacion = full_star.repeat(3) + empty_star.repeat(2);
          break;
        case 'D':
            span_calificacion = empty_star.repeat(5);
          break;
        default:

      }
      vartable.fnAddData([
        status.it,
        status.sitio,
        span_calificacion,
        status.cliente,
        status.comentario,
        status.fecha

      ]);
    });
  }

  function get_table_tickets(itc_email){
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: "/get_tickets_by_itc",
        data: { itc_email: itc_email, _token : _token },
        success: function (data){
          //console.log(data);
          generate_table_tickets(data, $('#table_tickets_itc'));
          //document.getElementById("table_budget_wrapper").childNodes[0].setAttribute("class", "form-inline");
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
  }

  function get_graph_tickets_type(itc_email){
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: "/get_ticketsxtipo_itc",
        data: { itc_email: itc_email, _token : _token },
        success: function (data){
          //console.log(data);
          if(data==''){
            data=[{},{},{},{},{}] //Necesario para evitar errores cuando es vacio.
          }
          //console.log(data);
          graph_tickets_type('graph_type_tickets',data);
          //document.getElementById("table_budget_wrapper").childNodes[0].setAttribute("class", "form-inline");
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
  }


  function get_graph_tickets_status(itc_email){
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: "/get_ticketsxstatus_itc",
        data: { itc_email: itc_email, _token : _token },
        success: function (data){
          //console.log(data);
          graph_tickets_status('graph_status_tickets',data);
          //document.getElementById("table_budget_wrapper").childNodes[0].setAttribute("class", "form-inline");
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
  }


function overflow(numrow){
  var tabla=document.getElementById("table_budget_site").getElementsByTagName("tr");
  tabla[numrow].style.backgroundColor = "yellow";
}

function morethan100(number){
var val=''
number>100? val='<span style="color:red; font-weight:bold;">'+number+'%'+'</span>': val='<span style="font-weight:bold;">'+number+'%'+'</span>';
return val;
}

function generate_table_tickets(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table);
  vartable.fnClearTable();
  //color: ['#474B4F','#ff5400','#e92e29','#FFDE40','#4dd60d','#00BFF3','#096dc9','#f90000'],
  var type='';
  var status='';
  var priority='';
  $.each(datajson, function(index, data){
    switch (data.type) {
      case 'incident':
      type='<span class="badge badge-pill text-white" style="background-color:#ff5400">incident</span>';
        break;
      case 'problem':
      type='<span class="badge badge-pill text-white" style="background-color:#e92e29">problem</span>';
        break;
      case 'question':
      type='<span class="badge badge-pill text-white" style="background-color:#FFDE40">question</span>';
        break;
      case 'task':
      type='<span class="badge badge-pill text-white" style="background-color:#4dd60d">task</span>';
        break;
      case '':
      type='<span class="badge badge-pill text-white" style="background-color:#474B4F">other</span>';
        break;
    }
      switch (data.status) {
        case 'solved':
        status='<span class="badge badge-pill text-white bg-primary" >solved</span>';
          break;
        case 'open':
        status='<span class="badge badge-pill text-white" style="background-color:#4dd60d">open</span>';
          break;
        case 'closed':
        status='<span class="badge badge-pill text-white" style="background-color:#474B4F">closed</span>';
          break;
      }

      switch (data.priority) {
        case 'high':
        priority='<span class="badge badge-pill text-white" style="background-color:#ff5400">high</span>';
          break;
        case 'urgent':
        priority='<span class="badge badge-pill text-white" style="background-color:#e92e29">urgent</span>';
          break;
        case 'low':
        priority='<span class="badge badge-pill bg-secondary text-white" >low</span>';
          break;
        case 'normal':
        priority='<span class="badge badge-pill text-white bg-primary" >normal</span>';
          break;
        case '':
        priority='<span class="badge badge-pill text-white" style="background-color:#474B4F">not assigned</span>';
          break;
      }

    vartable.fnAddData([
      '<small>'+data.id_ticket+'</small>',
      type,
      '<small>'+data.subject+'</small>',
      status,
      priority,
      '<small>'+data.via_channel+'</small>',
      '<small>'+data.satisfaction_rating+'</small>',
	    '<small>'+ data.via_from_name+'</small>',
      '<small>'+data.created_at+'</small>',
      '<small>'+data.itc+'</small>'
    ]);
  });
}

function getViaticsByHotel(itc){
  var id = itc;
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "/get_viatics_gastos_itc",
    data: { id : id, _token : _token },
    success: function (data){
      //console.log(data);

      var data2 = [], savedGastos = [];
      var montoTotal=0;
      data.forEach(function(row){
        var i = savedGastos.indexOf(row.name.toLowerCase().trim());
        if(i < 0) {
          data2.push({
            cantidad: row.aprobado,
            tipo: row.name
          });
          savedGastos.push(row.name.toLowerCase().trim());
        } else {
          data2[i].cantidad += row.aprobado;
        }
        montoTotal+=parseFloat(row.aprobado);

      });
      $("#cargando").addClass("d-none");
      $(".first_tab").removeClass("d-none");

      $('#total_viatic').text("$" + montoTotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " MXN");
      //console.log(data2);
      graph_equipments('graph_viatics', data2, "", "PAGADOS"); //El string PAGADOS no debe ser cambiado!
      viatics_table(data, $("#table_viatics"));
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function viatics_table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_antenas);
  vartable.fnClearTable();
  var site="";
  $.each(datajson, function(index, status){
    status.sitio  == "undefined"? site="":site=status.sitio,

  vartable.fnAddData([
    //site,
    status.folio,
    status.name,
    status.date_start,
    status.date_end,
    "$" + status.solicitado.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " MXN",
    "$" + status.aprobado.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " MXN",
    '<span class="badge  badge-pill badge-success">'+status.estado+'</span>',
    status.usuario,
    '<a href="javascript:void(0);" onclick="enviar_via(this)" value="'+status.id+'" class="btn btn-default btn-sm" role="button"><span class="far fa-edit"></span></a>',
    ]);
  });
}

  var Configuration_table = {
    //"order": [[ 0, "asc" ]],
    paging: true,
    //"pagingType": "simple",
    "iDisplayLength": 100,
    Filter: true,
    searching: true,
    ordering:false,
    "select": false,
    "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
    dom:"<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-12'p>>",
    buttons: [],
    bInfo: true,
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
      }
    }
  }

  var Configuration_table_equipments = {
    "order": [[ 0, "asc" ]],
    paging: true,
    //"pagingType": "simple",
    deferRender:true,
    Filter: true,
    searching: true,
    ordering: true,
    "bSortClasses": false,
    "select": false,
    "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
    "columnDefs": [
                { //Subida 1
                    "targets": 0,
                    "width": "1%",
                    "className": "text-center",
                },
                {
                    "targets": 1,
                    "width": "1%",
                    "className": "text-center",
                },
                {
                    "targets": 2,
                    "width": "3%",
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
                    "width": "0.2%",
                    "className": "text-center",
                },
                {
                    "targets": 6,
                    "width": "0.2%",
                    "className": "text-center",
                },
                {
                    "targets": 7,
                    "width": "0.2%",
                    "className": "text-center",
                }
            ],
        //    "select": {
        //        'style': 'multi',
        //    },
    // "columnDefs": [
    //     {
    //       "targets": 0,
    //       "width": "1%",
    //     },
    // ],
    // "select": {
    //     'style': 'multi',
    // },
    //ordering: false,
    //"pageLength": 5,
    dom:"<'row'<'col-sm-6'B><'col-sm-2'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",

    bInfo: true,
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="fas fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          return 'Reporte de equipos.';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        exportOptions: {
            columns: [ 0,1,2,3,4,5,6,7],
            modifier: {
                page: 'all',
            }
        },
        className: 'btn btn-sm btn-success',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="fas fa-file-csv"></i> CSV',
        titleAttr: 'CSV',
        title: function ( e, dt, node, config ) {
          return 'Reporte de equipos.';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        exportOptions: {
            columns: [ 0,1,2,3,4,5,6,7],
            modifier: {
                page: 'all',
            }
        },
        className: 'btn btn-sm btn-info',
      },
      {
        extend: 'pdf',
        text: '<i class="fas fa-file-pdf"></i>  PDF',
        title: function ( e, dt, node, config ) {
          return 'Reporte de equipos.';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        exportOptions: {
            columns: [ 0,1,2,3,4,5,6,7],
            modifier: {
                page: 'all',
            }
        },
        className: 'btn btn-sm btn-danger',
      },
  /*    {
        extend: 'print',
        text: '<i class="fas fa-file"></i>  PRINT',
        title: function ( e, dt, node, config ) {
          return 'Reporte de equipos.';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        exportOptions: {
            columns: [ 0,1,2,3,4,5,6,7],
            modifier: {
                page: 'all',
            }
        },
        className: 'btn btn-sm btn-warning',
      }*/
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
      }
    }
  }

  function graph_gauge_hotel(title, grapname, valuemin, valuemax, valor) {
    //$('#'+title).width($('#'+title).width());
    //$('#'+title).height($('#'+title).height());

   var chart = document.getElementById(title);
    var resizeMainContainer = function () {
     chart.style.width = 320+'px';
     chart.style.height = 320+'px';
   };
    resizeMainContainer();
      var myChart = echarts.init(chart);
    var option = {
      tooltip : {
          formatter: "{a} <br/>{b} : {c}"
      },
      grid: {
          show : true,
          containLabel: false,
          backgroundColor: 'transparent',
          borderColor: '#ccc',
          borderWidth: 0,
          top: -10,
          x: 5,
          y: 0,
          x2: 5,
          y2: 0,
      },
      toolbox: {
          feature: {
            restore : {show: false, title : 'Recargar'},
            saveAsImage : {show: false , title : 'Guardar'}
          }
      },
      series: [
          {
              name: grapname,
              type: 'gauge',
              splitNumber: 20,
              min: -valuemin,
              max: valuemax,
              detail: {formatter:'{value}'},
              data: [{value: valor, name: grapname}],
              axisLine: {            // 坐标轴线
                  lineStyle: {       // 属性lineStyle控制线条样式
                      color: [[0.85, '#f0120a'],[0.90, '#f5e60c'],[1, '#0fe81e']],
                      width: 30
                  }
              },
              axisLabel: {           // 坐标轴文本标签，详见axis.axisLabel
                  textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                      color: 'auto',
                      fontSize: 10,

                  }
              },
          }
      ]
    };

    myChart.setOption(option);

    $(window).on('resize', function(){
        if(myChart != null && myChart != undefined){


           //chart.style.width = 100+'%';
           //chart.style.height = 100+'%';
           chart.style.width = $(window).width()*0.5;
           chart.style.height = $(window).width()*0.5;
            myChart.resize();

        }
    });
  }

  function graph_equipments(title,data,text,subtext) {
    //$('#'+title).width($('#'+title).width());
    //$('#'+title).height($('#'+title).height());

   var chart = document.getElementById(title);
    var resizeMainContainer = function () {
     chart.style.width = 720+'px';
     chart.style.height = 320+'px';
   };
    resizeMainContainer();
      var myChart = echarts.init(chart);
      var group=[];
      var i=0;

      data.forEach(function(element){
      if(subtext == "PAGADOS" || subtext == "PESOS") group[i] = {value:element.cantidad,name: element.tipo+' ($'+element.cantidad.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' MXN)'};
      else if(subtext == "DÓLARES") group[i] = {value:element.cantidad,name: element.tipo+' ($'+element.cantidad.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' USD)'};
      else group[i] = {value:element.cantidad,name: element.tipo+' ('+element.cantidad+')'};
      i++;
      });

      option = {
          title : {
              text: text,
              subtext: subtext,
              x:'center'
          },
           //color: ['#AD50D0','#00EEB1','#00CAE5','#DB3841','#D87DAF','#2B4078','#AD50D0','#AD50D0'],
           color: ['#00BFF3','#EF5BA1','#FFDE40','#474B4F','#ff5400','#4dd60d','#096dc9','#f90000'],
          tooltip : {
              trigger: 'item',
              formatter: "{a} <br/>{b} : {c} ({d}%)"
          },
          legend: {
              orient: 'vertical',
              left: 60+'px',

          },
          series : [
              {
                  name: subtext,
                  type: 'pie',
                  radius : '55%',
                  center: ['50%', '60%'],
                  data:group,
                  itemStyle: {
                      emphasis: {
                          shadowBlur: 10,
                          shadowOffsetX: 0,
                          shadowColor: 'rgba(0, 0, 0, 0.5)'
                      }
                  }
              }
          ]
      };


    myChart.setOption(option);

    $(window).on('resize', function(){
        if(myChart != null && myChart != undefined){
           //chart.style.width = 100+'%';
           //chart.style.height = 100+'%';
           chart.style.width = $(window).width()*0.5;
           chart.style.height = $(window).width()*0.5;
            myChart.resize();

        }
    });
  }

function graph_tickets_type(title,data) {
  //$('#'+title).width($('#'+title).width());
  //$('#'+title).height($('#'+title).height());

 var chart = document.getElementById(title);
  var resizeMainContainer = function () {
   chart.style.width = 420+'px';
   chart.style.height = 320+'px';
 };
  resizeMainContainer();
    var myChart = echarts.init(chart);
    var group=[];
    var titles=[];
    var i=0;

    data.forEach(function(element){
    element.type=="" ?  element.type="other": element.type;
    group[i] ={name: element.type,type: 'bar',label: {normal: {show: true,position: 'inside'}},data: [element.cantidad]};
    titles[i] = element.type;
    i++;
    });
    //console.log(titles);
    //console.log(group);


    option = {
        title: {
            text: 'Tickets por tipo',
            x:'center'
        },
        legend: {
            data: titles,
            orient: 'vertical',
            right: -10,
            top: 40,
            bottom: 20,

        },
        //color: ['#00BFF3','#EF5BA1','#FFDE40','#474B4F','#ff5400','#4dd60d','#096dc9','#f90000'],
        color: ['#474B4F','#ff5400','#e92e29','#FFDE40','#4dd60d','#00BFF3','#096dc9','#f90000'],
        toolbox: {},
        tooltip: {},
        xAxis: {type: 'category'},
        yAxis: {},
        series:group,
    };


  myChart.setOption(option);

  $(window).on('resize', function(){
      if(myChart != null && myChart != undefined){
         //chart.style.width = 100+'%';
         //chart.style.height = 100+'%';
         chart.style.width = $(window).width()*0.5;
         chart.style.height = $(window).width()*0.5;
          myChart.resize();

      }
  });
}

function graph_calificaciones_x_mes(title, meses, promotores, pasivos, detractores) {
  //$('#'+title).width($('#'+title).width());
  //$('#'+title).height($('#'+title).height());

 var chart = document.getElementById(title);
  var resizeMainContainer = function () {
    chart.style.width = '40vw';
    chart.style.height = 300+'px';
 };
    resizeMainContainer();
    var myChart = echarts.init(chart);
    var group=[];
    var titles=[];
    var i=0;

    /*data.forEach(function(element){
    element.type=="" ?  element.type="other": element.type;
    group[i] ={name: element.type,type: 'bar',label: {normal: {show: true,position: 'inside'}},data: [element.cantidad]};
    titles[i] = element.type;
    i++;
  });*/
    //console.log(titles);
    //console.log(group);


    option = {
      title: {
          text: 'Calificaciones x mes'
      },
      tooltip: {
          trigger: 'axis'
      },
      legend: {
        top: '10%',
          data: ['Promotores', 'Pasivos', 'Detractores']
      },
      grid: {
          containLabel: true
      },
      xAxis: {
          type: 'category',
          boundaryGap: true,
          data: meses,
          axisTick: {
              alignWithLabel: true
          },
          axisLabel : {
             show: true,
             interval: '0',
             rotate: 45
          }
      },
      yAxis: {
          type: 'value'
      },
      series: [
          {
              name: 'Promotores',
              type: 'line',
              data: promotores
          },
          {
              name: 'Pasivos',
              type: 'line',
              data: pasivos
          },
          {
              name: 'Detractores',
              type: 'line',
              data: detractores
          }
      ],
      color: ['green','orange', 'red']
    };


  myChart.setOption(option);

  $(window).on('resize', function(){
      if(myChart != null && myChart != undefined){
        //chart.style.width = 100+'%';
        //chart.style.height = 100+'%';
        chart.style.width = "40vw";
        chart.style.height = $(window).width()*0.5;
         myChart.resize();

      }
  });
}

function graph_viaticos_x_mes(title, meses, gastos) {
 var chart = document.getElementById(title);
  var resizeMainContainer = function () {
    chart.style.width = '40vw';
    chart.style.height = 300+'px';
 };
    resizeMainContainer();
    var myChart = echarts.init(chart);


    option = {
      title: {
          text: 'Viáticos x mes'
      },
      tooltip: {
          trigger: 'axis'
      },
      legend: {
        top: '10%',
          data: ['Promotores', 'Pasivos', 'Detractores']
      },
      grid: {
          containLabel: true
      },
      xAxis: {
          type: 'category',
          boundaryGap: true,
          data: meses,
          axisTick: {
              alignWithLabel: true
          },
          axisLabel : {
             show: true,
             interval: '0',
             rotate: 45
          }
      },
      yAxis: {
          type: 'value'
      },
      series: [
          {
              name: 'Viáticos',
              type: 'line',
              data: gastos,
              label: {
                show: true
              }
          }
      ],
      color: ['brown']
    };

  myChart.setOption(option);

  $(window).on('resize', function(){
      if(myChart != null && myChart != undefined){
         myChart.resize();
      }
  });
}

function graph_tickets_status(title,data) {
  //$('#'+title).width($('#'+title).width());
  //$('#'+title).height($('#'+title).height());

 var chart = document.getElementById(title);
  var resizeMainContainer = function () {
   chart.style.width = 420+'px';
   chart.style.height = 320+'px';
 };
  resizeMainContainer();
    var myChart = echarts.init(chart);
    var group=[];
    var i=0;

    data.forEach(function(element){
    group[i] = {value:element.cantidad,name: element.status+' ('+element.cantidad+')'};
    i++;
    });

    /*option = {
        title : {
            text: 'Clasificación',
            subtext: 'Tipo de equipo',
            x:'center'
        },
         //color: ['#AD50D0','#00EEB1','#00CAE5','#DB3841','#D87DAF','#2B4078','#AD50D0','#AD50D0'],
         color: ['#00BFF3','#EF5BA1','#FFDE40','#474B4F','#ff5400','#4dd60d','#096dc9','#f90000'],
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            left: 'right',

        },
        series : [
            {
                name: 'Tipo de equipo',
                type: 'pie',
                radius : '55%',
                center: ['50%', '60%'],
                data:group,
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    }; */

    option = {
      title : {
          text: 'Tickets por estado',
          x:'center'
      },
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b}: {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            x: 'right',
            //data:['1','2','3','4','5']
        },
        color: ['#00BFF3','#EF5BA1','#FFDE40','#474B4F','#ff5400','#4dd60d','#096dc9','#f90000'],
        series: [
            {
                name:'Estado',
                type:'pie',
                radius: ['50%', '70%'],
                avoidLabelOverlap: false,
                label: {
                    normal: {
                        show: false,
                        position: 'center'
                    },
                    emphasis: {
                        show: true,
                        textStyle: {
                            fontSize: '25',
                            fontWeight: 'bold'
                        }
                    }
                },
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                data:group
            }
        ]
    };


  myChart.setOption(option);

  $(window).on('resize', function(){
      if(myChart != null && myChart != undefined){
         //chart.style.width = 100+'%';
         //chart.style.height = 100+'%';
         chart.style.width = $(window).width()*0.5;
         chart.style.height = $(window).width()*0.5;
          myChart.resize();

      }
  });
}

  var Configuration_table_antenas = {
    "order": [[ 0, "asc" ]],
    paging: true,
    //"pagingType": "simple",
    Filter: true,
    searching: true,
    ordering: true,
    "select": false,
    "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
    // "columnDefs": [
    //     {
    //       "targets": 0,
    //       "width": "1%",
    //     },
    // ],
    // "select": {
    //     'style': 'multi',
    // },
    //ordering: false,
    //"pageLength": 5,
    dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

    bInfo: true,
    "createdRow": function ( row, data, index ) {

  },
    "footerCallback": function(row, data, start, end, display){

    },
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
      }
    }
  }

});


function enviar_pres(e) {
  var valor= e.getAttribute('value');
  $('#id_annex').val(valor);
  $('#modal-view-presupuesto').modal('show');
  $('.modal-title').text('Presupuesto');
  // $('#modal-view-presupuesto').modal('hide');
  get_table_estimation(valor);
  //console.log(valor);
}

function get_table_estimation(id_anexo){
  //console.log(id_anexo);
  var _token = $('meta[name="csrf-token"]').attr('content');
  const headers = new Headers({
    "Accept": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": _token
  });
  //var id_anexo = $('#id_annex').val();
  var init = { method: 'get',
               headers: headers,
               credentials: "same-origin",
               cache: 'default' };
  if(id_anexo != null && id_anexo != undefined){
    fetch(`/estimation_site_table/id_anexo/${id_anexo}`, init)
      .then(response => {
        return response.text();
      })
      .then(data => {
        $('#presupuesto_anual').html('');
        $('#presupuesto_anual').html(data);
      })
      .catch(error => {
        console.log(error);
      })
  }
}

$('.closeModal').on('click', function(){
  $('#tpgeneral').val('');
  $('#date_to_search_tc').val('');
  $('#presupuesto_anual').html('');
});

function enviar_via(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  var fecha = $('#date_to_search').val();
  $('.no_aprobar_en_gastos').css("display","none");
  cabecera_viatic(valor, _token);
  cuerpo_viatic(valor, _token);
  timeline(valor, _token);
  $('#obj').val(valor);
  // totales_concept_zsa(valor, _token);
  $('#modal-view-viatics').modal('show');
}
// Exportacion del pdf
$('.btn-export').on('click', function(){
    $("#captura_table_general").hide();
    $(".hojitha").css("border", "");
    html2canvas(document.getElementById("captura_pdf_general")).then(function(canvas) {
      var ctx = canvas.getContext('2d');
      ctx.rect(0, 0, canvas.width, canvas.height);
          var imgData = canvas.toDataURL("image/jpeg", 1.0);
          var correccion_landscape = 0;
          var correccion_portrait = 0;
          if(canvas.height > canvas.width) {
              var orientation = 'portrait';
              correccion_portrait = 1;
              correccion_landscape = 0;
              var imageratio = canvas.height/canvas.width;
          }
          else {
              var orientation = 'landscape';
              correccion_landscape = 0;
              correccion_portrait = 0;
              var imageratio = canvas.width/canvas.height;
          }
          if(canvas.height < 900) {
              fontsize = 16;
          }
          else if(canvas.height < 2300) {
              fontsize = 11;
          }
          else {
              fontsize = 6;
          }

          var margen = 0;//pulgadas

          // console.log(canvas.width);
          // console.log(canvas.height);

         var pdf  = new jsPDF({
                      orientation: orientation,
                      unit: 'in',
                      format: [16+correccion_portrait, (16/imageratio)+margen+correccion_landscape]
                    });

          var widthpdf = pdf.internal.pageSize.width;
          var heightpdf = pdf.internal.pageSize.height;
          pdf.addImage(imgData, 'JPEG', 0, margen, widthpdf, heightpdf-margen);
          pdf.save("Solicitud de viaticos.pdf");
          $(".hojitha").css("border", "1px solid #ccc");
          $(".hojitha").css("border-bottom-style", "hidden");
    });
});

function getValueCurrent(qty) {
  var retval;
  var val=qty;
  switch(val){
    case 'Pr':
      retval = '<span class="badge badge-pill badge-success">Promotor</span>';
      break;
    case 'Ps':
      retval = '<span class="badge badge-pill badge-warning">Pasivo</span>';
      break;
    case 'D':
      retval = '<span class="badge badge-pill badge-danger">Detractor</span>';
      break;
    case 'NA':
      retval = '<span class="badge badge-pill badge-danger">Sin calificación</span>';
      break;
    default:
      retval = '<span class="badge badge-pill badge-danger">Sin calificación</span>';
  }
  return retval;
}

function getProjects(itc){
  var _token = $('input[name="_token"]').val();
  $.ajax({
      type: "POST",
      url: "/get_projects_itc",
      data: {itc_id : itc, _token : _token},
      success: function (data){
        //console.log(data[0]);
        //console.log(data[1]);
        //Doc P
        $('#total_auth_p').text(data[0].Total_autorizado);
        $('#total_sol_p').text(data[0].Total_solicitudes);
        $('#autorizado_p').text(data[0].Autorizado);
        $('#entregado_p').text(data[0].Entregado);
        $('#revisado_p').text(data[0].Revisado);
        $('#nuevo_p').text(data[0].Nuevo);
        //Doc M
        $('#total_auth_m').text(data[1].Total_autorizado);
        $('#total_sol_m').text(data[1].Total_solicitudes);
        $('#autorizado_m').text(data[1].Autorizado);
        $('#entregado_m').text(data[1].Entregado);
        $('#revisado_m').text(data[1].Revisado);
        $('#nuevo_m').text(data[1].Nuevo);


      },
      error: function (data) {
        console.log('Error:', data);
      }
  });


      $.ajax({
        type: "POST",
        url: "/get_graph_docx",
        data: { itc_id : itc,tipo_doc:1, _token : _token },
        success: function (data){
          //console.log(data);
          //Gráfica DOC P
          graph_document('graph_doc_p',data);
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });




}

function loading(time){
  let timerInterval

Swal.fire({
  title: 'Cargando información!',
  html: 'Buscando en los registros <b></b> .',
  timer: time,
  timerProgressBar: true,
  onBeforeOpen: () => {
    Swal.showLoading()
    /*timerInterval = setInterval(() => {
      Swal.getContent().querySelector('b')
        .textContent = Swal.getTimerLeft()
    }, 100) */
  },
  onClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.timer
  ){
    //Otra accion
  }
})
}


function graph_document(title,data) {

 var chart = document.getElementById(title);
  var resizeMainContainer = function () {
   chart.style.width = 420+'px';
   chart.style.height = 320+'px';
 };
  resizeMainContainer();
    var myChart = echarts.init(chart);
    var auxdate=[];
    var date=[];
    var count=[];
    var quantity=[];
    var aux_amount=[];
    var amount=[];
    var i=0;

    data.forEach(function(element){
    auxdate[i] = element.fecha; //Metemos las fechas en un array
    aux_amount[i]= parseFloat(element.total_usd);
    count[i] = i;//array de las posiciones
    i++;
    });
    //console.log(Math.max.apply(null,amount));
    auxdate.sort();//Ordenamos los elementos
    var current = null;
    var cnt=0;
    var k=0;
    var testamount=0;

    for (var j = 0; j < auxdate.length; j++) { //Revisamos cuantas veces se repitio 'X' fecha
      if (auxdate[j] != current) {
          if (cnt > 0) {
              console.log(current + ' repitio --> ' + cnt + 'veces');
              quantity[k]=cnt;
              k++;
              testamount+=aux_amount[j];
          }
          current = auxdate[j];
          cnt = 1;
          testamount=0;
          testamount+=aux_amount[j];
      } else {
          cnt++;
          testamount+=aux_amount[j];
          amount[k]= parseFloat(testamount.toFixed(2));
      }
    }
    k++;
    if (cnt > 0) {
        console.log(current + ' rep --> ' + cnt + ' veces');
        quantity[k]=cnt;
    }

  //console.log(amount);
  console.log('count: ' +count);
  console.log('date: '+date);
  option = {
      title: {
          text: 'Documento P',
          subtext: 'Resultados'
      },
      tooltip: {
          trigger: 'axis',
          axisPointer: {
              type: 'cross',
              label: {
                  backgroundColor: '#283b56'
              }
          }
      },
      legend: {
          data:['Cantidad', 'Monto']
      },
      toolbox: {
          show: true,
          feature: {
              dataView: {readOnly: false},
              restore: {},
              saveAsImage: {}
          }
      },
      dataZoom: {
          show: false,
          start: 0,
          end: 100
      },
      xAxis: [
          {
              type: 'category',
              boundaryGap: true,
              data: [1,2],
          },
          {
              type: 'category',
              boundaryGap: true,
              data: [1,2],//count,
          }
      ],
      yAxis: [
          {
              type: 'value',
              scale: true,
              name: '',
              max: Math.max.apply(null,amount),///Cantidad máxima del monto aprobado
              min: 0,
              boundaryGap: [0.2, 0.2]
          },
          {
              type: 'value',
              scale: true,
              name: '',
              max: Math.max.apply(null,quantity.filter(Boolean)),//Cantidad máxima de documentos P autorizados
              min: 0,
              boundaryGap: [0.2, 0.2]
          }
      ],
      series: [
          {
              name: 'Cantidad',
              type: 'bar',
              xAxisIndex: 1,
              yAxisIndex: 1,
              data: quantity.filter(Boolean),//Barra cantidad
          },
          {
              name: 'Monto',
              type: 'line',
              data: amount,//Linea monto
          }
      ]
  };


  myChart.setOption(option);

  $(window).on('resize', function(){
      if(myChart != null && myChart != undefined){
         //chart.style.width = 100+'%';
         //chart.style.height = 100+'%';
         chart.style.width = $(window).width()*0.5;
         chart.style.height = $(window).width()*0.5;
          myChart.resize();

      }
  });
}
