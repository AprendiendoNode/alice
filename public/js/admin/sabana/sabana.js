$(function() {
  $(".first_tab").champ();
  $(".select2").select2();
  $("#cliente").on('change', function(e) {
    var _token = $('input[name="_token"]').val();
    var cadena = $('#cliente').val();
    $(".first_tab").addClass("d-none");
    $("#cargando").removeClass("d-none");
    $.ajax({
      type: "POST",
      url: "/informacionCliente",
      data: { cliente : cadena, _token : _token },
      success: function (data){
        //console.log(data);
        $("#imagenCliente").attr("src", "../images/hotel/" + data[0].dirlogo1);
        $("#itcCliente").text(data[1].name + " -> " + data[1].email);
        $("#cuartosCliente").text(data[0].num_hab == null ? "Sin informacion" : data[0].num_hab);
        $("#telefonoCliente").text(data[0].Telefono);
        $("#direccionCliente").text(data[0].Direccion);
        $("#correoCliente").text(data[2].correo == null ? "Sin informacion" : data[2].correo);
        $("#cargando").addClass("d-none");
        $(".first_tab").removeClass("d-none");
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
get_info_equipments(cadena);
get_nps_hotel(cadena);

  });


  function get_nps_hotel(idcadena){
    var _token = $('meta[name="csrf-token"]').attr('content');
    var id= idcadena;
    //console.log(id);
    $.ajax({
      type: "POST",
      url: "/get_nps_hotel",
      data: { _token : _token, id: id },
      success: function (data){
        //console.log(data);
        //console.log(data[0]['nps']);
        //graph_nps_hotel('main_nps',data[0]['nps']);
        graph_gauge_hotel('main_nps_hotel', 'NPS', '100', '100', data[0]['nps']);
        $('#total_promotores').text(data[0]['pr']);
        $('#total_pasivos').text(data[0]['ps']);
        $('#total_detractores').text(data[0]['d']);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });

  }

  function get_info_equipments(idcadena) {
    var _token = $('meta[name="csrf-token"]').attr('content');
    var id= idcadena;
    $.ajax({
      type: "POST",
      url: "/get_all_equipmentsbyhotel",
      data: { _token : _token, id: id },
      success: function (data){

        table_equipments(data, $("#all_equipments"));

      },
      error: function (data) {
        console.log('Error:', data);
      }
    });

  }

  function table_equipments(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_equipments);
    vartable.fnClearTable();
    $.each(datajson, function(index, status){
      var span_identificador = '';
      if (status.estado == '1') { span_identificador = '<span class="badge badge-pill badge-success">Activo en Sitio</span>';}
      if (status.estado == '2') { span_identificador = '<span class="badge badge-pill badge-danger">Baja</span>';}
      if (status.estado == '3') { span_identificador = '<span class="badge badge-pill badge-warning text-white">Bodega</span>';}
      if (status.estado == '4') { span_identificador = '<span class="badge badge-pill badge-dark">Stock</span>';}
      if (status.estado == '5') { span_identificador = '<span class="badge badge-pill badge-info">Prestamo</span>';}
      if (status.estado == '6') { span_identificador = '<span class="badge badge-pill badge-primary">Venta</span>';}
      if (status.estado == '7') { span_identificador = '<span class="badge badge-pill badge-info">Propiedad del Cliente</span>';}
      if (status.estado == '8') { span_identificador = '<span class="badge badge-pill badge-secondary">Demo</span>';}
      if (status.estado == '9') { span_identificador = '<span class="badge badge-pill badge-secondary">Asignado [SITWIFI]</span>';}
      if (status.estado == '10') { span_identificador = '<span class="badge badge-pill badge-danger">Descontinuado</span>';}
      vartable.fnAddData([
        status.tipo,
        status.modelo,
        status.MAC,
        status.Serie,
        status.Descripcion,
        span_identificador,
        status.Fecha_Registro,
        status.Fecha_Baja

      ]);
    });
  }



  var Configuration_table_equipments = {
    "order": [[ 0, "asc" ]],
    paging: true,
    //"pagingType": "simple",
    Filter: true,
    searching: true,
    ordering: true,
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
            "select": {
                'style': 'multi',
            },
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
                      color: [[0.85, '#E73231'],[0.90, '#FFBF00'],[1, '#0B610B']],
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
           chart.style.width = 100+'%';
           chart.style.height = 100+'%';
            myChart.resize();

        }
    });
  }
});
