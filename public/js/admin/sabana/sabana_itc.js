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
    clearBtn: true,
    orientation: 'bottom'
  }).datepicker("setDate",'now');


    $('#date_presupuesto').datepicker({
      language: 'es',
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
      startDate: '2019',
      endDate: '-0y',
      autoclose: true,
      clearBtn: true,
      orientation: 'bottom'
    }).datepicker("setDate",'now');

    var date = (new Date()).toString().split(" ");

    $('#date_consumos').datepicker({
      language: 'es',
      format: "yyyy-mm",
      viewMode: "months",
      minViewMode: "months",
      endDate: '1m',
      autoclose: true,
      clearBtn: true,
      orientation: 'bottom'
    }).datepicker("setDate",'now');

    $('.filtro_viaticos, .filtro_tickets').datepicker({
      language: 'es',
      format: "yyyy-mm-dd",
      viewMode: "days",
      minViewMode: "days",
      autoclose: true,
      clearBtn: true,
      orientation: 'bottom'
    });

    $("#filtro1_viaticos").val("2018-01-01");
    $("#filtro2_viaticos").val("2038-01-01");
    $("#filtro1_tickets").val("2012-01-01");
    $("#filtro2_tickets").val("2032-01-01");


  //Por sitio
  $("#select_itc").on('change', function(e) {
    var itc = $('#select_itc').val();
    var itc_email=$('#select_itc').find(':selected').data("email");
    $(".first_tab").addClass("d-none");
    //$("#cargando").removeClass("d-none");
    $('#gral_sitio').removeClass('d-none');//Muestra la informacion por sitio
    $('#gral_cadena').addClass('d-none');//oculta la informacion por cadena.
    loading(3000);
    //TEMPORAL PRESUPUESTO CADENA
    $("#terminado_presupuesto_cadena").removeClass("d-none");
    $("#construyendo_presupuesto_cadena").addClass("d-none");

    generalITC(itc);
    get_nps_itc(itc);
    get_nps_comment(itc);
    //get_graph_equipments(itc);
    //get_graph_equipments_status(itc);
    get_table_tickets(itc_email);
    get_graph_tickets_type(itc_email);
    get_graph_tickets_status(itc_email);
    //getFoliosByHotel(itc);
    getViaticsByITC(itc);
    getProjects(itc);
  });

  $('#filtroGeneral').on('change', function(e) {
    var itc = $('#select_itc').val();
    var filtro = $('#filtroGeneral').val();
    generalITC(itc);
  });

  $('#graph_calificaciones_x_mes').on('click', function(){
    $('li[rel=tab_1_2]').tooltip().addClass("active"); //Mostrar la pestaña de NPS
    $('.tab_1_2').addClass("active"); //Mostrar la pestaña de NPS del acordeón
    $('.tab_content.tab_1_2').css("display","block"); //Mostrar el div de NPS
    $('li[rel=tab_1_1]').tooltip().removeClass("active"); //Ocultar la pestaña de general
    $('.tab_1_1').removeClass("active"); //Ocultar la pestaña de general del acordeón
    $('.tab_content.tab_1_1').css("display","none"); //Ocultar el div de general
    $('html, body').animate({scrollTop:0}, 'slow');
  });

  $('#graph_viaticos_x_mes').on('click', function(){
    $('li[rel=tab_1_4]').tooltip().addClass("active"); //Mostrar la pestaña de viáticos
    $('.tab_1_4').addClass("active"); //Mostrar la pestaña de viáticos del acordeón
    $('.tab_content.tab_1_4').css("display","block"); //Mostrar el div de viáticos
    $('li[rel=tab_1_1]').tooltip().removeClass("active"); //Ocultar la pestaña de general
    $('.tab_1_1').removeClass("active"); //Ocultar la pestaña de general del acordeón
    $('.tab_content.tab_1_1').css("display","none"); //Ocultar el div de general
    $('html, body').animate({scrollTop:0}, 'slow');
  });

  $('#graph_doc_p, #graph_doc_m').on('click', function(){
    $('li[rel=tab_1_5]').tooltip().addClass("active"); //Mostrar la pestaña de proyectos
    $('.tab_1_5').addClass("active"); //Mostrar la pestaña de proyectos del acordeón
    $('.tab_content.tab_1_5').css("display","block"); //Mostrar el div de proyectos
    $('li[rel=tab_1_1]').tooltip().removeClass("active"); //Ocultar la pestaña de general
    $('.tab_1_1').removeClass("active"); //Ocultar la pestaña de general del acordeón
    $('.tab_content.tab_1_1').css("display","none"); //Ocultar el div de general
    $('html, body').animate({scrollTop:0}, 'slow');
  });

  $('.filtrarDashboard').on('click', function(){
    get_nps_itc($('#select_itc').val());
  });

  $('#filtrarViaticos').on('click', function(){
    getViaticsByITC($('#select_itc').val());
  });

  $('#filtrarTickets').on('click', function(){
    var itc_email=$('#select_itc').find(':selected').data("email");
    get_table_tickets(itc_email);
    get_graph_tickets_type(itc_email);
    get_graph_tickets_status(itc_email);
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
    var id = $('#select_itc').val();

      $.ajax({
          type: "POST",
          url: "/sabana_itc_modal_encuestas",
          data: { _token: _token, anio: anio, encuestas: encuestas, itc: id },
          success: function (data){
            table_boxes_cali(data, $('#table_boxes_ppd'));
            document.getElementById("table_boxes_ppd_wrapper").childNodes[0].setAttribute("class", "form-inline");
          },
          error: function (data) {
            console.log('Error:', data);
          }
      });

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

  function generalITC(itc) {
    var filtro = $('#filtroGeneral').val();
    var _token = $('input[name="_token"]').val();
    $.ajax({
      type: "POST",
      url: "/informacionITC",
      data: { itc : itc, filtro: filtro,  _token : _token },
      success: function (data){
        //console.log(data);
        $("#imagenCliente").attr("src", $('#select_itc').find(':selected').data("avatar"));
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
            $("#footer_total_antenas").text(data[0].cantidad);
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
        $.ajax({
          type: "POST",
          url: "/viaticos_x_mes",
          data: { itc : itc, filtro: filtro, _token : _token },
          success: function (data){
            var meses = Object.values(data[0]), gastos = Object.values(data[1]);
            if(filtro <= 6) {
              meses.splice(0, 12 - filtro);
              gastos.splice(0, 12 - filtro);
            }
            graph_viaticos_x_mes('graph_viaticos_x_mes', meses, gastos);
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
        $.ajax({
          type: "POST",
          url: "/get_graph_docx",
          data: { itc_id : itc, filtro: filtro, tipo_doc : 1, _token : _token },
          success: function (data){
            var meses = Object.values(data[0]), montos = Object.values(data[1]), cantidades = Object.values(data[2]);
            if(filtro <= 6) {
              meses.splice(0, 12 - filtro);
              montos.splice(0, 12 - filtro);
              cantidades.splice(0, 12 - filtro);
            }
            graph_document('graph_doc_p', 'Doc. P (USD Entregados)', meses, montos, cantidades);
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
        $.ajax({
          type: "POST",
          url: "/get_graph_docx",
          data: { itc_id : itc, filtro: filtro, tipo_doc : 2, _token : _token },
          success: function (data){
            var meses = Object.values(data[0]), montos = Object.values(data[1]), cantidades = Object.values(data[2]);
            if(filtro <= 6) {
              meses.splice(0, 12 - filtro);
              montos.splice(0, 12 - filtro);
              cantidades.splice(0, 12 - filtro);
            }
            graph_document('graph_doc_m', 'Doc. M (USD Entregados)', meses, montos, cantidades);
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
  }

  function get_nps_itc(itc){
    var _token = $('meta[name="csrf-token"]').attr('content');
    var anio = $('#date_to_search').val();
    var mes = $('#date_to_search_nps_mes').val();
    var id= itc;
    $.ajax({
      type: "POST",
      url: "/get_nps_itc",
      data: { _token : _token, itc: id, anio: anio },
      success: function (data){
        //console.log(data);
        //console.log(data[0]['nps']);
        //graph_nps_hotel('main_nps',data[0]['nps']);
        graph_gauge_nps('main_nps_anio', anio, '100', '100', data[0]['nps']);
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
    $.ajax({
      type: "POST",
      url: "/get_nps_itc_mensual",
      data: { _token : _token, itc: id, anio: anio, mes: mes },
      success: function (data){
        //console.log(data);
        //console.log(data[0]['nps']);
        //graph_nps_hotel('main_nps',data[0]['nps']);
        graph_gauge_nps('main_nps_mes', $( "#date_to_search_nps_mes option:selected" ).text(), '100', '100', data[0]['nps']);
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
    var celdasNPS = [];
    var sitios_sin_calif = 0;
    var filtro = $('#filtroGeneral').val();
    $.each(datajson, function(index, status){

      if(index == 0) {
        $("#NPS1").text(status.Cal1); meses.push(status.Cal1);
        $("#NPS2").text(status.Cal2); meses.push(status.Cal2);
        $("#NPS3").text(status.Cal3); meses.push(status.Cal3);
        $("#NPS4").text(status.Cal4); meses.push(status.Cal4);
        $("#NPS5").text(status.Cal5); meses.push(status.Cal5);
        $("#NPS6").text(status.Cal6); meses.push(status.Cal6);
        $("#NPS7").text(status.Cal7); meses.push(status.Cal7);
        $("#NPS8").text(status.Cal8); meses.push(status.Cal8);
        $("#NPS9").text(status.Cal9); meses.push(status.Cal9);
        $("#NPS10").text(status.Cal10); meses.push(status.Cal10);
        $("#NPS11").text(status.Cal11); meses.push(status.Cal11);
        $("#NPS12").text(status.Cal12); meses.push(status.Cal12);
      } else {
        if(parseInt(status.NPS_resul) == 255) {
          sitios_sin_calif++;
          status.NPS_resul = "-";
        } else {
          sumaNPS += parseInt(status.NPS_resul);
        }
        sumaFact += status.facturacion == null ? 0 : parseInt(status.facturacion);
        vartable.fnAddData([
          status.sitio,
          '<a href="javascript:void(0);" id="ver-'+status.hotel_id+'-'+status.sitio+'" class="ver_antenas_sitio">'+status.aps+'</a>',
          (status.facturacion == null ? 0 : parseInt(status.facturacion)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
          '<span class="iconito fecha:11 hotel:'+status.hotel_id+'">'+status.Cal1+'</span>',
          '<span class="iconito fecha:10 hotel:'+status.hotel_id+'">'+status.Cal2+'</span>',
          '<span class="iconito fecha:9 hotel:'+status.hotel_id+'">'+status.Cal3+'</span>',
          '<span class="iconito fecha:8 hotel:'+status.hotel_id+'">'+status.Cal4+'</span>',
          '<span class="iconito fecha:7 hotel:'+status.hotel_id+'">'+status.Cal5+'</span>',
          '<span class="iconito fecha:6 hotel:'+status.hotel_id+'">'+status.Cal6+'</span>',
          '<span class="iconito fecha:5 hotel:'+status.hotel_id+'">'+status.Cal7+'</span>',
          '<span class="iconito fecha:4 hotel:'+status.hotel_id+'">'+status.Cal8+'</span>',
          '<span class="iconito fecha:3 hotel:'+status.hotel_id+'">'+status.Cal9+'</span>',
          '<span class="iconito fecha:2 hotel:'+status.hotel_id+'">'+status.Cal10+'</span>',
          '<span class="iconito fecha:1 hotel:'+status.hotel_id+'">'+status.Cal11+'</span>',
          '<span class="iconito fecha:0 hotel:'+status.hotel_id+'">'+status.Cal12+'</span>',
          '<span id="prom'+index+'">'+status.NPS_resul+'</span>',
          //status.aps + ' <button id="ver-'+status.id+'-'+status.sitio+'" class="btn btn-default btn-sm ver_antenas_sitio"><span class="fa fa-eye"></span></button>',
        ]);
        if(filtro == 6) {
          celdasNPS.push(status.Cal7,status.Cal8,status.Cal9,status.Cal10,status.Cal11,status.Cal12);
        } else if(filtro == 3) {
          celdasNPS.push(status.Cal10,status.Cal11,status.Cal12);
        }
      }

    });

    $("#footer_total_sitios").text(parseInt($("#total_sitios").text()));
    $("#total_faturacion").text(sumaFact.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $("#footer_total_facturacion").text(sumaFact.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $("#npsPromedio").text(Math.round(sumaNPS / (parseInt($("#total_sitios").text()) - sitios_sin_calif)));
    $("#footer_npsPromedio").text(Math.round(sumaNPS / (parseInt($("#total_sitios").text()) - sitios_sin_calif)));

    if($("#hayFact").length == 0) { //Filtro de facturación
      var column = vartable.api().columns(2);
      column.visible(!column.visible());
    }

    var extra = 0;

    if(filtro <= 6) { //Mostras meses seleccionados y ajustar parámetros para la gráfica de calificaciones NPS
      for(var i = 3 ; i < (15 - filtro) ; i++) {
        var column = vartable.api().columns(i);
        column.visible(!column.visible());
      }
      meses.splice(0, 12 - filtro);
      extra = 12 - filtro;
      recalcularPromediosNPS(celdasNPS, filtro);
    } else {
      filtro = 12;
    }

    var promotores = [], pasivos = [], detractores = [];

    for(var i = 0 ; i < filtro ; i++) { //Las clases mes y promotor, pasivo o detractor se añaden directamente desde la base de datos.
      promotores[i] = $(".mes"+(i+1+extra)+".promotor").length;
      pasivos[i] = $(".mes"+(i+1+extra)+".pasivo").length;
      detractores[i] = $(".mes"+(i+1+extra)+".detractor").length;
      var total_icons = promotores[i] + pasivos[i] + detractores[i];
      if(total_icons != 0) {
        $("#MES"+(i+1)).text(""+Math.round(((promotores[i] / total_icons) * 100 ) - ((detractores[i] / total_icons) * 100 )));
      } else {
        $("#MES"+(i+1)).text("-");
      }
    }

    graph_calificaciones_x_mes('graph_calificaciones_x_mes', meses, promotores, pasivos, detractores);
  }

  function recalcularPromediosNPS(celdasNPS, filtro) {

    var sumaNPS = 0, sitios_sin_calif = 0;

    for(var i = 0; i < parseInt($("#total_sitios").text()) ; i++) {

      var promotores = 0, detractores = 0, calis = 0;

      for(var j = i * filtro ; j < (i * filtro + parseInt(filtro)) ; j++ ) {

        if(celdasNPS[j].indexOf("promotor") >= 0) {
          promotores += 1;
          calis++;
        } else if(celdasNPS[j].indexOf("pasivo") >= 0) {
          calis++;
        } else if(celdasNPS[j].indexOf("detractor") >= 0) {
          detractores += 1;
          calis++;
        }

      }

      if(calis > 0) {
        var aux = parseInt(((promotores / calis) * 100 ) - ((detractores / calis) * 100 ));
        $("#prom"+(i+1)).text(aux+"");
        sumaNPS += aux;
      } else {
        sitios_sin_calif++;
        $("#prom"+(i+1)).text("-");
      }

    }

    $("#npsPromedio").text(Math.round(sumaNPS / (parseInt($("#total_sitios").text()) - sitios_sin_calif)));
    $("#footer_npsPromedio").text(Math.round(sumaNPS / (parseInt($("#total_sitios").text()) - sitios_sin_calif)));

  }

  $(document).on("click", ".iconito", function() {
    var classes = this.classList;
    var icon_mes = classes[1].split(":")[1];
    var icon_hotel = classes[2].split(":")[1];
    var fecha = new Date();
    if(parseInt(fecha.getMonth()) + 1 < 10) {
      fecha = fecha.getFullYear() + "-" + "0" + parseInt((fecha.getMonth()) + 1) +"-" + "01";
    } else {
      fecha = fecha.getFullYear() + "-" + parseInt((fecha.getMonth()) + 1) +"-" + "01";
    }
    var filtro = $('#filtroGeneral').val();
    if(filtro > 12) {
      fecha = filtro + "-12-01";
    }
    var mes_reciente = fecha.split("-")[1];
    var mes_seleccionado = mes_reciente - icon_mes;
    if(mes_seleccionado <= 0) {
      var mes_seleccionado = 12 + mes_seleccionado;
      if(mes_seleccionado < 10) {
        fecha = (fecha.split("-")[0] - 1) + "-0" + mes_seleccionado + "-01";
      } else {
        fecha = (fecha.split("-")[0] - 1) + "-" + mes_seleccionado + "-01";
      }
    } else {
      if(mes_seleccionado < 10) {
        fecha = fecha.split("-")[0] + "-0" + mes_seleccionado + "-01";
      } else {
        fecha = fecha.split("-")[0] + "-" + mes_seleccionado + "-01";
      }
    }
    var _token = $('meta[name="csrf-token"]').attr('content');
    var itc = $('#select_itc').val();
    $.ajax({
      type: "POST",
      url: "/sabana_itc_modal_encuestas_hover",
      data: { _token : _token, fecha: fecha, hotel: icon_hotel, itc: itc },
      success: function (data){

        if(data.length > 0) {

          var splash = "";

          switch (data[0].NPS) {
            case "Pr":
              splash = "success";
              break;
            case "Ps":
              splash = "warning";
              break;
            default:
              splash = "error";
          }

          var months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

          Swal.fire(
            "<span style='color: gray;'>" + data[0].Sitio + " " + fecha.split("-")[0] + "-" + months[parseInt(fecha.split("-")[1]) - 1] + "</span>",
            "<span style='font-weight: bold;'>" + data[0].Cliente + ": </span>" + data[0].comentario,
            splash
          );

        }

      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  });

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

  $('#total_antenas, #footer_total_antenas').on('click', function(){
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
        (status.estado == '1') ? '<span class="badge badge-pill text-white bg-success">Activo en sitio</span>' : '<span class="badge badge-pill text-white" style="background-color:#0DCAD6;">Propiedad del Cliente</span>',
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

  function get_nps_comment(itc){
    var _token = $('meta[name="csrf-token"]').attr('content');
    var id= itc;
    //console.log(id);
    $.ajax({
      type: "POST",
      url: "/get_nps_comment_itc",
      data: { _token : _token, itc: id },
      success: function (data){
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
        status.fecha.split(" ")[0]

      ]);
    });
  }

  function get_table_tickets(itc_email){
    /*var fecha1 = $('#filtro1_tickets').val();
    var fecha2 = $('#filtro2_tickets').val();
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: "/get_tickets_by_itc",
        data: { itc_email: itc_email, fecha1: fecha1, fecha2: fecha2, _token : _token },
        success: function (data){
          //console.log(data);*/
          generate_table_tickets(itc_email);
          /*//document.getElementById("table_budget_wrapper").childNodes[0].setAttribute("class", "form-inline");
          $('#total_tickets').text(data.length);
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });*/
  }

  function get_graph_tickets_type(itc_email){
    var fecha1 = $('#filtro1_tickets').val();
    var fecha2 = $('#filtro2_tickets').val();
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: "/get_ticketsxtipo_itc",
        data: { itc_email: itc_email, fecha1: fecha1, fecha2: fecha2, _token : _token },
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
    var fecha1 = $('#filtro1_tickets').val();
    var fecha2 = $('#filtro2_tickets').val();
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: "/get_ticketsxstatus_itc",
        data: { itc_email: itc_email, fecha1: fecha1, fecha2: fecha2, _token : _token },
        success: function (data){
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

function generate_table_tickets(itc_email){
  var _token = $('meta[name="csrf-token"]').attr('content');
  var fecha1 = $('#filtro1_tickets').val();
  var fecha2 = $('#filtro2_tickets').val();
  $("#table_tickets_itc").DataTable().destroy();
  $("#table_tickets_itc").DataTable({
    processing:true,
    serverSide:true,
    ajax:{
      "type": "POST",
      url:"/get_tickets_by_itc",
      "data":function(d){ //Lo que se envia al servidor
        d._token = _token;
        d.itc_email = itc_email;
        d.fecha1 = fecha1;
        d.fecha2 = fecha2;
      },
      dataFilter:function(inData){ //Lo que regresa el servidor
        var array=JSON.parse(inData);
        $('#total_tickets').text(array.recordsTotal);
        //console.log(array);
        //console.log(array.data[0]['tipo']);
        $.each(array.data, function(index, status){
          //console.log(status);
          switch (status.type) {
            case 'incident':
            status.type='<span class="badge badge-pill text-white" style="background-color:#ff5400">incident</span>';
              break;
            case 'problem':
            status.type='<span class="badge badge-pill text-white" style="background-color:#e92e29">problem</span>';
              break;
            case 'question':
            status.type='<span class="badge badge-pill text-white" style="background-color:#FFDE40">question</span>';
              break;
            case 'task':
            status.type='<span class="badge badge-pill text-white" style="background-color:#4dd60d">task</span>';
              break;
            case '':
            status.type='<span class="badge badge-pill text-white" style="background-color:#474B4F">other</span>';
              break;
          }
            switch (status.status) {
              case 'solved':
              status.status='<span class="badge badge-pill text-white bg-primary" >solved</span>';
                break;
              case 'open':
              status.status='<span class="badge badge-pill text-white" style="background-color:#4dd60d">open</span>';
                break;
              case 'closed':
              status.status='<span class="badge badge-pill text-white" style="background-color:#474B4F">closed</span>';
                break;
            }

            switch (status.priority) {
              case 'high':
              status.priority='<span class="badge badge-pill text-white" style="background-color:#ff5400">high</span>';
                break;
              case 'urgent':
              status.priority='<span class="badge badge-pill text-white" style="background-color:#e92e29">urgent</span>';
                break;
              case 'low':
              status.priority='<span class="badge badge-pill bg-secondary text-white" >low</span>';
                break;
              case 'normal':
              status.priority='<span class="badge badge-pill text-white bg-primary" >normal</span>';
                break;
              case '':
              status.priority='<span class="badge badge-pill text-white" style="background-color:#474B4F">not assigned</span>';
                break;
            }
        });
        var data = JSON.stringify(array);
        return data;
      }
    },
    columns:[
            {data:'id_ticket',name:'id_ticket'},
            {data:'type',name:'type'},
            {data:'subject',name:'subject'},
            {data:'status',name:'status'},
            {data:'priority',name:'priority'},
            {data:'via_channel',name:'via_channel'},
            {data:'satisfaction_rating',name:'satisfaction_rating'},
            {data:'via_from_name',name:'via_from_name'},
            {data:'created_at',name:'created_at'},
            {data:'itc',name:'itc'}
          ],
  });
}

function getViaticsByITC(itc){
  var id = itc;
  var fecha1 = $('#filtro1_viaticos').val();
  var fecha2 = $('#filtro2_viaticos').val();
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "/get_viatics_gastos_itc",
    data: { id : id, fecha1: fecha1, fecha2: fecha2,_token : _token },
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

  function graph_gauge_nps(title, grapname, valuemin, valuemax, valor) {
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
   var myChart = echarts.init(chart);
   var mostrar = true, hoverSize = 12;
    var resizeMainContainer = function () {
      if($(window).width() <= 1058) {
        mostrar = false;
        hoverSize = 8;
      } else {
        mostrar = true;
        hoverSize = 12;
      }
        chart.style.width = '80vw';
        chart.style.height = 320+'px';
      myChart.resize();
   };
    resizeMainContainer();

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
              subtext: "",
              x:'center'
          },
           //color: ['#AD50D0','#00EEB1','#00CAE5','#DB3841','#D87DAF','#2B4078','#AD50D0','#AD50D0'],
           color: ['red','green','blue','brown','olive','fuchsia'],
          tooltip : {
              trigger: 'item',
              formatter: "{a} <br/>{b} : ({d}%)",
              position: ['5%', '50%'],
              textStyle: {
                  fontSize: hoverSize
              }
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
                  label: {
                    show: mostrar
                  },
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
      resizeMainContainer();
    });
  }

function graph_tickets_type(title,data) {
  //$('#'+title).width($('#'+title).width());
  //$('#'+title).height($('#'+title).height());

 var chart = document.getElementById(title);
 var myChart = echarts.init(chart);
 myChart.clear();
  var resizeMainContainer = function () {
    if($(window).width() <= 575) {
      chart.style.width = '90vw';
      chart.style.height = 300+'px';
    } else {
      chart.style.width = '40vw';
      chart.style.height = 300+'px';
    }
    myChart.resize();
 };
  resizeMainContainer();

    var group=[];
    var titles=[];
    var i=0;

    data.forEach(function(element){
    element.type=="" ?  element.type="other": element.type;
    group[i] ={
      name: element.type,
      type: 'bar',
      label: {
        normal: {
          show: true,
          position: 'inside',
          fontSize: '20',
          fontWeight: 'bold'
        }
      },
      data: [element.cantidad]
    };
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
            orient: 'horizontal',
            left: 'center',
            top: 30,
            bottom: 20,

        },
        //color: ['#00BFF3','#EF5BA1','#FFDE40','#474B4F','#ff5400','#4dd60d','#096dc9','#f90000'],
        color: ['#474B4F','#ff5400','#e92e29','purple','#4dd60d','#00BFF3','#096dc9','#f90000'],
        toolbox: {},
        tooltip: {},
        xAxis: {type: 'category'},
        yAxis: {show: false},
        series:group,
    };


  myChart.setOption(option);

  $(window).on('resize', function(){
    resizeMainContainer();
  });
}

function graph_calificaciones_x_mes(title, meses, promotores, pasivos, detractores) {
  //$('#'+title).width($('#'+title).width());
  //$('#'+title).height($('#'+title).height());

 var chart = document.getElementById(title);

    var myChart = echarts.init(chart);
    var group=[];
    var titles=[];
    var i=0;
    var rotar = 45;
    var tamanio = 12;

    if($(window).width() <= 575) {
      rotar = 90;
      tamanio = 8;
    }

    var resizeMainContainer = function () {
      if($(window).width() <= 575) {
        chart.style.width = '100vw';
        chart.style.height = 300+'px';
      } else {
        chart.style.width = '40vw';
        chart.style.height = 300+'px';
      }
      myChart.resize();
   };
resizeMainContainer();
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
          text: 'Calificaciones (NPS)'
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
             rotate: rotar,
             fontSize: tamanio
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
    resizeMainContainer();
  });
}

function graph_viaticos_x_mes(title, meses, gastos) {
  var chart = document.getElementById(title);

     var myChart = echarts.init(chart);
     var group=[];
     var titles=[];
     var i=0;
     var rotar = 45;
     var tamanio = 12;

     if($(window).width() <= 575) {
       rotar = 90;
       tamanio = 8;
     }

     var resizeMainContainer = function () {
       if($(window).width() <= 575) {
         chart.style.width = '100vw';
         chart.style.height = 300+'px';
       } else {
         chart.style.width = '40vw';
         chart.style.height = 300+'px';
       }
       myChart.resize();
    };
 resizeMainContainer();


    option = {
      title: {
          text: 'Viáticos (MXN Pagados)'
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
             rotate: rotar,
             fontSize: tamanio
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
    resizeMainContainer();
  });
}

function graph_tickets_status(title,data) {
  //$('#'+title).width($('#'+title).width());
  //$('#'+title).height($('#'+title).height());

 var chart = document.getElementById(title);
 var myChart = echarts.init(chart);
  var resizeMainContainer = function () {
    if($(window).width() <= 575) {
      chart.style.width = '90vw';
      chart.style.height = 300+'px';
    } else {
      chart.style.width = '40vw';
      chart.style.height = 300+'px';
    }
    myChart.resize();
 };
  resizeMainContainer();

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
            show: false,
            trigger: 'item',
            formatter: "{a} <br/>{b}: {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            x: 'right',
            top: 30
            //data:['1','2','3','4','5']
        },
        color: ['#00BFF3','#EF5BA1','brown','#474B4F','#ff5400','olive','#096dc9','#f90000'],
        series: [
            {
                name:'Estado',
                type:'pie',
                radius: ['50%', '70%'],
                avoidLabelOverlap: false,
                label: {
                    normal: {
                        show: false,
                        position: 'center',
                        fontSize: '22',
                        fontWeight: 'bold'
                    },
                    emphasis: {
                        show: true,
                        textStyle: {
                            fontSize: '22',
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
    resizeMainContainer();
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


function graph_document(title, name, meses, montos, cantidades) {
  var chart = document.getElementById(title);

     var myChart = echarts.init(chart);
     var group=[];
     var titles=[];
     var i=0;
     var rotar = 45;
     var tamanio = 12;

     if($(window).width() <= 575) {
       rotar = 90;
       tamanio = 8;
     }

     var resizeMainContainer = function () {
       if($(window).width() <= 575) {
         chart.style.width = '90vw';
         chart.style.height = 300+'px';
       } else {
         chart.style.width = '40vw';
         chart.style.height = 300+'px';
       }
       myChart.resize();
    };
 resizeMainContainer();

     var max_monto = montos, max_cantidad = cantidades, vacios = [];

     for(var i = 0; i < montos.length ; i++) {

       max_monto[i] = parseInt(max_monto[i]);
       max_cantidad[i] = parseInt(max_cantidad[i]);
       vacios.push("");

     }
     max_monto = parseInt(Math.max.apply(Math, max_monto) * 1.2);
     //max_cantidad = parseInt(Math.max.apply(Math, max_cantidad) * 1.2);
     max_cantidad = Math.max.apply(Math, max_cantidad) + 1;

     option = {
         title: {
             text: name
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
         grid: {
             containLabel: true
         },
         legend: {
             top: '10%',
             data:['Cantidad', 'Monto']
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
                 data: meses,
                 axisTick: {
                     alignWithLabel: true
                 },
                 axisLabel : {
                    show: true,
                    interval: '0',
                    rotate: rotar,
                    fontSize: tamanio
                 }
             },
             {
                 type: 'category',
                 boundaryGap: true,
                 data: vacios
             }
         ],
         yAxis: [
             {
                 type: 'value',
                 scale: true,
                 name: '',
                 max: max_monto,
                 min: 0,
                 boundaryGap: [0.2, 0.2],
                 axisLabel: {
                   //fontSize: 9,
                   //show: false
                 }
             },
             {
                 type: 'value',
                 scale: true,
                 name: '',
                 max: max_cantidad,
                 min: 0,
                 boundaryGap: [0.2, 0.2],
                 axisLabel: {
                   //fontSize: 9,
                   //show: false
                 }
             }
         ],
         series: [
             {
                 name: 'Monto',
                 type: 'line',
                 data: montos,
                 label: {
                   show: true
                 }
             },
             {
                 name: 'Cantidad',
                 type: 'bar',
                 xAxisIndex: 1,
                 yAxisIndex: 1,
                 data: cantidades,
                 label: {
                   show: true
                 }
             }
         ],
         color: ['darkblue', 'lightgray']
     };

   myChart.setOption(option);

   $(window).on('resize', function(){
     resizeMainContainer();
   });
}
