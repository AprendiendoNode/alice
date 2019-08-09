function graph_one_pie_contract(title,campoa, campob){
    var myChart = echarts.init(document.getElementById(title));

    var optionOne = {
      title : {
          text: '',
          subtext: '',
          x:'center'
      },
      tooltip : {
          trigger: 'item',
          formatter: "{a} <br/>{b} : {c} ({d}%)"
      },
      legend: {
          orient: 'vertical',
          left: 'left',
          data: campoa
      },
      color: ['#E54958', '#00c0ef', '#605ca8', '#FF851B', '#00a65a', '#101D42'],
      series : [
          {
              name: 'Información',
              type: 'pie',
              radius : '35%',
              center: ['70%', '35%'],
              data:campob,
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

    myChart.setOption(optionOne);

    $(window).on('resize', function(){
        if(myChart != null && myChart != undefined){
            myChart.resize();
        }
    });

  }


    function graph_two_verticals(title,campoa, campob, titlepral, subtitulopral) {
      var myChart = echarts.init(document.getElementById(title));

      var optionTwo = {
          title: {
             text: titlepral,
             subtext: subtitulopral,
             textStyle: {
              color: '#449D44',
              fontStyle: 'normal',
              fontWeight: 'normal',
              fontFamily: 'sans-serif',
              fontSize: 18,
              align: 'left',
              verticalAlign: 'top',
              width: '100%',
              textBorderColor: 'transparent',
              textBorderWidth: 0,
              textShadowColor: 'transparent',
              textShadowBlur: 0,
              textShadowOffsetX: 0,
              textShadowOffsetY: 0,
            },
         },
          tooltip: {
              trigger: 'item',
              formatter: "{a} <br/>{b}: {c} ({d}%)"
          },
          legend: {
            type: 'scroll',
              orient: 'vertical',
              right: 10,
              top: 20,
              bottom: 20,
              data: campoa,
              selected: campoa.selected
          },
          color: ['#133046', '#15959F', '#F26144', '#F1E4B3', '#2D9F67', '#AF1044',
          '#DD4B39','#00C0EF', '#605CA8', '#FF851B','#00A65A',
          '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
            '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
            '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'],
          series: [
              {
                  name:'Información',
                  type:'pie',
                  radius: ['50%', '70%'],
                  center: ['20%', '50%'],
                  avoidLabelOverlap: false,
                  label: {
                      normal: {
                          show: false,
                          position: 'center'
                      },
                      emphasis: {
                          show: true,
                          textStyle: {
                              fontSize: '14',
                              fontWeight: 'bold'
                          }
                      }
                  },
                  labelLine: {
                      normal: {
                          show: false
                      }
                  },
                  data: campob
              }
          ]
      };

      myChart.setOption(optionTwo);

      $(window).on('resize', function(){
          if(myChart != null && myChart != undefined){
              myChart.resize();
          }
      });

    }

    function graph_two_verticals_aps(title,campoa, campob) {
      var myChart = echarts.init(document.getElementById(title));

      var optionTwo = {

          tooltip: {
              trigger: 'item',
              formatter: "{a} <br/>{b}: {c} ({d}%)"
          },
          legend: {
              orient: 'horizontal',
              data: campoa,
          },
          color: ['#133046', '#15959F', '#F26144', '#F1E4B3', '#2D9F67', '#AF1044',
          '#DD4B39','#00C0EF', '#605CA8', '#FF851B','#00A65A',
          '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
            '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
            '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'],
          series: [
              {
                  name:'Información',
                  type:'pie',
                  radius: '50%',
                  center: ['50%', '65%'],
                  avoidLabelOverlap: false,
                  label: {
                      normal: {
                          show: false,
                          position: 'center'
                      },
                      emphasis: {
                         shadowBlur: 10,
                         shadowOffsetX: 0,
                         shadowColor: 'rgba(0, 0, 0, 0.5)'
                      }
                      // emphasis: {
                      //     show: true,
                      //     textStyle: {
                      //         fontSize: '14',
                      //         fontWeight: 'bold'
                      //     }
                      // }
                  },
                  labelLine: {
                      normal: {
                          show: false
                      }
                  },
                  data: campob
              }
          ]
      };

      myChart.setOption(optionTwo);

      $(window).on('resize', function(){
          if(myChart != null && myChart != undefined){
              myChart.resize();
          }
      });

    }

    function graph_three_verticals(title,campoa, campob){
        var myChart = echarts.init(document.getElementById(title));

        var optionThree = {

            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                x: 'left',
                data: campoa
            },
            color: ['#C33325', '#105187', '#51578A', '#F1E4B3', '#F0F1D5', '#AF1044'],
            series: [
                {
                    name:'Información',
                    type:'pie',
                    radius: ['55%', '70%'],
                    avoidLabelOverlap: false,
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: true,
                            textStyle: {
                                fontSize: '14',
                                fontWeight: 'bold'
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    data: campob
                }
            ]
        };

        myChart.setOption(optionThree);

        $(window).on('resize', function(){
            if(myChart != null && myChart != undefined){
                myChart.resize();
            }
        });

      }

      function graph_four_vtc(title,data_name, data_month, campoa, campob, campoc){
          var myChart = echarts.init(document.getElementById(title));

          var optionFour = {
            tooltip : {
                trigger: 'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                data: data_name
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis:  {
                type: 'category',
                data: data_month,
                axisLabel : {
                   show:true,
                   interval: 'auto',    // {number}
                   rotate: 60,
                   margin: 6,
                   formatter: '{value}',
                   textStyle: {
                      //  color: 'blue',
                       fontFamily: 'sans-serif',
                       fontSize: 8,
                       fontStyle: 'italic',
                       fontWeight: 'bold'
                   }
                }
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name: data_name[0],
                    type: 'bar',
                    stack: '总量',
                    label: {
                        normal: {
                            show: true,
                            position: 'insideRight'
                        }
                    },
                    data: campoa,
                    itemStyle: {
                      normal: {
                          color: '#2f4554',
                          label : {
                              position : 'outside',
                              formatter : function (params) {
                                if (params.value > 0) {
                                  return params.value
                                }
                                else {
                                    return ''
                                }

                              }
                          },

                        }
                    }
                },
                {
                    name: data_name[1],
                    type: 'bar',
                    stack: '总量',
                    label: {
                        normal: {
                            show: true,
                            position: 'insideRight'
                        }
                    },
                    data: campob,
                    itemStyle: {
                      normal: {
                          color: '#FFBF00',
                          label : {
                              position : 'outside',
                              formatter : function (params) {
                                if (params.value > 0) {
                                  return params.value
                                }
                                else {
                                    return ''
                                }

                              }
                          },

                        }
                    }
                },
                {
                    name: data_name[2],
                    type: 'bar',
                    stack: '总量',
                    label: {
                        normal: {
                            show: true,
                            position: 'insideRight'
                        }
                    },
                    data: campoc,
                    itemStyle: {
                      normal: {
                          color: '#c4ccd3',
                          label : {
                              position : 'outside',
                              formatter : function (params) {
                                if (params.value > 0) {
                                  return params.value
                                }
                                else {
                                    return ''
                                }

                              }
                          },
                        }
                    }
                },

            ]
          };

          myChart.setOption(optionFour);

          $(window).on('resize', function(){
              if(myChart != null && myChart != undefined){
                  myChart.resize();
              }
          });

        }

    function graph_five_fact(title, title2, campoa, campob){
      var myChart = echarts.init(document.getElementById(title));

      var optionFive = {

        color: ['#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'],
        tooltip : {
            trigger: 'axis',
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis : [
            {
                type : 'category',
                data : campoa,
                boundaryGap: [0, 0.01],
                axisTick: {
                    alignWithLabel: true
                }
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'%',
                type:'bar',
                barWidth: '60%',
                data: campob,
            }
        ]
    };


      myChart.setOption(optionFive);

      $(window).on('resize', function(){
          if(myChart != null && myChart != undefined){
              myChart.resize();
          }
      });
    }


    /*
    Confoguracion datatables
    */

    var Configuration_table_new_contracts= {
      "order": [[ 0, "asc" ]],
      //paging: false,
      //bFilter: false,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      //ordering: false,
      "pagingType": "simple",
      "pageLength": 5,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
          {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Excel',
            titleAttr: 'Excel',
            title: function ( e, dt, node, config ) {
              return 'Nuevos contratos';
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            className: 'btn bg-olive custombtntable',
          },
          {
            extend: 'csvHtml5',
            text: '<i class="fa fa-file-text-o"></i> CSV',
            titleAttr: 'CSV',
            title: function ( e, dt, node, config ) {
              return 'Distribución de equipamiento';
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            className: 'btn btn-info',
          },
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
              "sSearch":         "Buscar:",
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
    };

    var Configuration_table_active_contracts22= {
      "order": [[ 0, "asc" ]],
      //paging: false,
  	  //bFilter: false,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  		//ordering: false,
      "pagingType": "simple",
      "pageLength": 5,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
          {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Excel',
            titleAttr: 'Excel',
            title: function ( e, dt, node, config ) {
              return 'Datos exportados';
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            className: 'btn bg-olive custombtntable',
          },
          {
            extend: 'csvHtml5',
            text: '<i class="fa fa-file-text-o"></i> CSV',
            titleAttr: 'CSV',
            title: function ( e, dt, node, config ) {
              return 'Datos exportados';
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            className: 'btn btn-info',
          },
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
              "sSearch":         "Buscar:",
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
    };
    var Configuration_table_active_contracts= {
      "order": [[ 0, "asc" ]],
      //paging: false,
  	  //bFilter: false,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  		//ordering: false,
      "pagingType": "simple",
      "pageLength": 5,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
          {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Excel',
            titleAttr: 'Excel',
            title: function ( e, dt, node, config ) {
              return 'Nuevos contratos';
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            className: 'btn bg-olive custombtntable',
          },
          {
            extend: 'csvHtml5',
            text: '<i class="fa fa-file-text-o"></i> CSV',
            titleAttr: 'CSV',
            title: function ( e, dt, node, config ) {
              return 'Distribución de equipamiento';
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            className: 'btn btn-info',
          },
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
              "sSearch":         "Buscar:",
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
    };

    var Configuration_table_expired_contracts= {
      "order": [[ 0, "asc" ]],
      //paging: false,
  	  //bFilter: false,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  		//ordering: false,
      "pagingType": "simple",
      "pageLength": 5,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
          {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Excel',
            titleAttr: 'Excel',
            title: function ( e, dt, node, config ) {
              return 'Nuevos contratos';
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            className: 'btn bg-olive custombtntable',
          },
          {
            extend: 'csvHtml5',
            text: '<i class="fa fa-file-text-o"></i> CSV',
            titleAttr: 'CSV',
            title: function ( e, dt, node, config ) {
              return 'Distribución de equipamiento';
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            className: 'btn btn-info',
          },
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
              "sSearch":         "Buscar:",
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
    };
