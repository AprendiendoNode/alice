function graph_barras_uno_zendesk(title, fecha_inicio, fecha_final, totallast, promYearLast2, totalnow, promYearnow2, dataTicketYearLastP, dataTicketYearNowP, titlepral) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    title: {
       text: titlepral,
       subtext: 'Total de tickets en el año ' + fecha_inicio + ': ' + totallast + ' con un promedio de: ' + promYearLast2 + ' por mes' + '\n' + 'Total de tickets en el año ' + fecha_final + ': ' + totalnow + ' con un promedio de: ' + promYearnow2 + ' por mes',
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
    // color: ['#3398DB'],
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
    },
    legend: {
        data:['Año ' + fecha_inicio, 'Año ' + fecha_final]
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
            data : ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
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
                  //  color: 'blue',
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
          name:'Año ' + fecha_inicio,
          type: 'bar',
          data: dataTicketYearLastP,
          itemStyle: {
            normal: {
              label : {
                  show: true,
                  position: 'inside',
                  formatter: function (params) {
                    for (var i = 0, l = option.xAxis[0].data.length; i < l; i++) {
                      if (option.xAxis[0].data[i] == params.name) {
                        return dataTicketYearLastP[i];
                      }
                    }
                  },
                  textStyle: {
                    color: '#fff'
                  }
              },
            }
          }
      },
      {
          name:'Año ' + fecha_final,
          type: 'bar',
          data: dataTicketYearNowP,
          itemStyle: {
            normal: {
              label : {
                show: true,
                position: 'inside',
                formatter: function (params) {
                  for (var i = 0, l = option.xAxis[0].data.length; i < l; i++) {
                    if (option.xAxis[0].data[i] == params.name) {
                      return dataTicketYearNowP[i];
                    }
                  }
                },
                textStyle: {
                  color: '#000'
                }
              },
            }
          },
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

function graph_two(title, data_name, dataAgentName, dataAgentTickets){
    var myChart = echarts.init(document.getElementById(title));

    var optionTwo= {
      title : {
          text: data_name,
          subtext: '',
          show: false,
      },
      color: ['#FF7D0A'],
      tooltip : {
          trigger: 'axis'
      },
      legend: {
          data:['Tickets']
      },
      toolbox: {
          show : true,
          feature : {
              mark : {show: false},
              dataView : {readOnly:false},
              magicType : {show: false, type: ['line', 'bar', 'stack', 'tiled']},
              restore : {show: true},
              saveAsImage : {show: false}
          }
      },
      calculable : true,
      xAxis : [
          {
              type : 'category',
              boundaryGap : false,
              data : dataAgentName,
              axisLabel : {
                align: 'right',
                margin:-10,
                inside : true,
                rotate :30,

                textStyle:{
                  fontSize: '10',

                }
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
              name:'Tickets',
              type:'line',
              smooth:true,
              itemStyle: {normal: {areaStyle: {type: 'default'}}},
              data: dataAgentTickets
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

function graph_barras_tres_zendesk(title, promPrim, promSol, dataTimesName2, dataTimesFirstR2, dataTimesSolucion2, titlepral) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    title: {
       text: titlepral,
       padding: 20,
       subtext:  'Promedio mensual de primera respuesta: ' + promPrim + '\t' + ' Promedio mensual de tiempo de solución: ' + promSol,
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
            data : dataTimesName2,
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

function graph_five(title,promWeek,dataWeekTickets, dataWeekPrimeraRespuesta, dataWeekCreated, dataWeek){
   var myChart = echarts.init(document.getElementById(title));

   var optionFive = {
     title : {
         text: '',
         subtext: 'Promedio de primera respuesta en minutos: ' + promWeek,
         show : true
     },
     color: ['#0F5E8C'],
     tooltip : {
         trigger: 'axis'
     },
     legend: {
         data:['Primera Respuesta']
     },
     toolbox: {
         show : true,
         feature : {
             mark : {show: false},
             dataView : {show: false, readOnly: false},
             magicType : {show: false, type: ['line', 'bar']},
             restore : {show: true},
             saveAsImage : {show: false}
         }
     },
     calculable : true,
     xAxis : [
         {
             type : 'category',
             axisLabel : {
               inside : true,
               margin:-20,
               align: 'center',
               rotate : 15,

               textStyle:{
                 fontSize: '10',

               }
             },
             data : dataWeekCreated
         }
     ],
     yAxis : [
         {
             type : 'value'
         }
     ],
     series : [
         {
             name:'Primera Respuesta',
             type:'bar',
             data: dataWeekPrimeraRespuesta,
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

function graph_barras_siete_zendesk(title, dataDomainNameIT, dataDomainCantd, titlepral) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    title: {
       text: titlepral,
       padding: 20,
       subtext:  'Tickets por dominio',
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
       show: false,
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
      data: ['Tickets Cerrados']
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
        left: '5%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : dataDomainNameIT,
            axisTick: {
                alignWithLabel: true
            },
            axisLabel : {
               show:true,
               interval: 'auto',    // {number}
               rotate: 40,
               margin: 10,
               formatter: '{value}',
               textStyle: {
                   fontFamily: 'sans-serif',
                   fontSize: 8,
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
          name:'Tickets Cerrados',
          type:'line',
          smooth:true,
          itemStyle: {normal: {areaStyle: {type: 'default'}}},
          data: dataDomainCantd
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

function graph_barras_ocho_a_zendesk(title, total, promxhora, dataFecha,dataTickets, titlepral) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    title: {
       text: titlepral,
       padding: 20,
       subtext: 'Total de tickets: ' + total + '  Promedio de tickets por hora: ' + promxhora,
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
      data:['Tickets Abiertos']
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
        left: '5%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis : [
        {
            type : 'category',
            data : dataFecha,
            axisTick: {
                alignWithLabel: true
            },
            axisLabel : {
               show:true,
               interval: 'auto',    // {number}
               rotate: 40,
               margin: 10,
               formatter: '{value}',
               textStyle: {
                   fontFamily: 'sans-serif',
                   fontSize: 8,
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
          name:'Tickets Abiertos',
          type:'bar',
          itemStyle: {normal: {areaStyle: {type: 'default'}}},
          data: dataTickets
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

function graph_barras_ocho_b_zendesk(title, total, promxhora, dataHorario2, dataTickets2, titlepral) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    title: {
       text: titlepral,
       padding: 20,
       subtext: 'Total de tickets: ' + total + '  Promedio de tickets por hora: ' + promxhora,
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
    color: ['#3398DB'],
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
      data:['Tickets Abiertos']
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
        left: '5%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis : [
        {
            type : 'category',
            data : dataHorario2,
            axisTick: {
                alignWithLabel: true
            },
            axisLabel : {
               show:true,
               interval: 'auto',    // {number}
               rotate: 40,
               margin: 10,
               formatter: '{value}',
               textStyle: {
                   fontFamily: 'sans-serif',
                   fontSize: 8,
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
          name:'Tickets Abiertos',
          type:'bar',
          itemStyle: {normal: {areaStyle: {type: 'default'}}},
          data: dataTickets2
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

function graph_pie_uno_zendesk(title, dataTagName, item, titlepral, subtitulopral){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
        title : {
            show: false,
            text: titlepral,
            subtext: subtitulopral,
            x:'center',
            textStyle: {
             color: '#449D44',
             fontStyle: 'normal',
             fontWeight: 'normal',
             fontFamily: 'sans-serif',
             fontSize: 18,
             align: 'center',
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
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)",
            textStyle: {
             fontStyle: 'normal',
             fontWeight: 'normal',
             fontFamily: 'sans-serif',
             fontSize: 12,
           },
        },
        legend: {
            // type: 'scroll',
            orient: 'horizontal',
            // right: 10,
            // top: 10,
            bottom: 10,
            data: dataTagName,
            textStyle: {
              fontSize: 8
            },
        },
        series : [
            {
                name: 'Valores',
                type: 'pie',
                radius : '45%',
                center: ['50%', '40%'],
                data:item,
                itemStyle: {
                    emphasis: {
                        shadowBlur: 5,
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
          myChart.resize();
      }
  });
}

function graph_barras_seis_zendesk(title, dataTagName, dataTagsCantidad, titlepral) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    title: {
       show:false,
       text: titlepral,
       padding: 20,
       subtext: '',
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
    color: ['#3398DB'],
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
      data:['Etiquetas']
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
        left: '5%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis : [
        {
            type : 'category',
            data : dataTagName,
            axisTick: {
                alignWithLabel: true
            },
            axisLabel : {
               show:true,
               interval: 'auto',    // {number}
               rotate: 40,
               margin: 10,
               formatter: '{value}',
               textStyle: {
                   fontFamily: 'sans-serif',
                   fontSize: 8,
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
          name:'Etiquetas',
          type:'bar',
          itemStyle: {normal: {areaStyle: {type: 'default'}}},
          data: dataTagsCantidad
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

  function graph_four(title,dataTimesRM, dataTimesMonthRM, dataTimesTotTick){
    var myChart = echarts.init(document.getElementById(title));

    var optionFour= {
      title : {
          text: '世界人口总量',
          subtext: '数据来自网络',
          show: false,
      },
      tooltip : {
          trigger: 'axis'
      },
      legend: {
          data:['Año Actual']
      },
      toolbox: {
          show : true,
          feature : {
              mark : {show: false},
              dataView : {readOnly:false},
              magicType : {show: false, type: ['line', 'bar', 'stack', 'tiled']},
              restore : {show: true},
              saveAsImage : {show: false}
          }
      },
      calculable : true,
      xAxis : [
          {
              type : 'value',
              boundaryGap : [0, 0.01]
          }
      ],
      yAxis : [
          {
              type : 'category',
              data : ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
          }
      ],
      series : [
          {
              name:'Año Actual',
              type:'bar',
              itemStyle: {
                normal: {
                  label : {
                    show: true,
                    position: 'insideLeft',
                    formatter: function (params) {
                      for (var i = 0, l = optionFour.yAxis[0].data.length; i < l; i++) {
                        if (optionFour.yAxis[0].data[i] == params.name) {
                          return dataTimesRM[i];
                        }
                      }
                    },
                    textStyle: {
                      color: '#fff'
                    }
                  },

                  color: 'purple'
                }
              },
              data: dataTimesRM
          }
      ]

    };

    myChart.setOption(optionFour);

    $(window).on('resize', function(){
        if(myChart != null && myChart != undefined){
            myChart.resize();
        }
    });

  }

  function graph_five(title,promWeek,dataWeekTickets, dataWeekPrimeraRespuesta, dataWeekCreated, dataWeek){
    var myChart = echarts.init(document.getElementById(title));

    var optionFive = {
      title : {
          text: '',
          subtext: 'Promedio de primera respuesta en minutos: ' + promWeek,
          show : true
      },
      color: ['#0F5E8C'],
      tooltip : {
          trigger: 'axis'
      },
      legend: {
          data:['Primera Respuesta']
      },
      toolbox: {
          show : true,
          feature : {
              mark : {show: false},
              dataView : {show: false, readOnly: false},
              magicType : {show: false, type: ['line', 'bar']},
              restore : {show: true},
              saveAsImage : {show: false}
          }
      },
      calculable : true,
      xAxis : [
          {
              type : 'category',
              axisLabel : {
                inside : true,
                margin:-20,
                align: 'center',
                rotate : 15,

                textStyle:{
                  fontSize: '10',

                }
              },
              data : dataWeekCreated
          }
      ],
      yAxis : [
          {
              type : 'value'
          }
      ],
      series : [
          {
              name:'Primera Respuesta',
              type:'bar',
              data: dataWeekPrimeraRespuesta,
          }
      ]
    };

    myChart.setOption(optionFive);

  }

  function graph_mes(title, title2, dataDomi, dataTag, dataTickets, item){
    var myChartM =  echarts.init(document.getElementById(title));
    var myChartM2 = echarts.init(document.getElementById(title2));

    var optionM = {
      title : {
          text: '某站点用户访问来源',
          subtext: '纯属虚构',
          x:'center',
          show: false
      },
      tooltip : {
          trigger: 'item',
          formatter: "{a} <br/>{b} : {c} ({d}%)"
      },
      legend: {
          orient : 'horizontal',
          x : 'center',
          y: 'bottom',
          textStyle: {
            fontSize: 10
          },
          data: dataTag
      },
      calculable : true,
      series : [
          {
              name:'Valores',
              type:'pie',
              radius : '45%',
              center: ['50%', 120],
              data: item
          }
      ]
    };

    var optionM2 = {
      tooltip : {
          trigger: 'axis',
          axisPointer : {
              type: 'shadow'
          }
      },
      color: ['#12403E'],
      legend: {
          data:['Etiquetas']
      },
      toolbox: {
          show : true,
          feature : {
              mark : {show: false},
              magicType : {show: false, type: ['line', 'bar', 'stack', 'tiled']},
              restore : {show: true},
              saveAsImage : {show: false}
          }
      },
      calculable : true,
      xAxis : [
          {
              type : 'category',
              axisLabel : {
                inside : true,
                rotate : 30,
                margin: -20,
                align: 'center',
                textStyle:{
                  fontSize: '9',

                }
              },
              data : dataTag
          }
      ],
      yAxis : [
          {
              type : 'value',
              splitArea : {show : true}
          }
      ],
      grid: {
          x2:40
      },
      series : [
          {
              name:'Etiquetas',
              type:'bar',
              data: dataTickets
          }
      ]
    };
    myChartM.setOption(optionM);
    myChartM2.setOption(optionM2);
  }

  function graph_anio(title, title2, dataDomi, dataTag, dataTickets, item){
    var myChartF = echarts.init(document.getElementById(title));
    var myChartF2 = echarts.init(document.getElementById(title2));

    var optionF = {
      title : {
          text: '某站点用户访问来源',
          subtext: '纯属虚构',
          x:'center',
          show: false
      },
      tooltip : {
          trigger: 'item',
          formatter: "{a} <br/>{b} : {c} ({d}%)"
      },
      legend: {
          orient : 'horizontal',
          x : 'center',
          y: 'bottom',
          textStyle: {
            fontSize: 10
          },
          data: dataTag
      },
      calculable : true,
      series : [
          {
              name:'Valores',
              type:'pie',
              radius : '45%',
              center: ['50%', 120],
              data: item
          }
      ]
    };

    var optionF2 = {
      tooltip : {
          trigger: 'axis',
          axisPointer : {
              type: 'shadow'
          }
      },
      legend: {
          data:['Etiquetas']
      },
      toolbox: {
          show : true,
          feature : {
              mark : {show: false},
              magicType : {show: false, type: ['line', 'bar', 'stack', 'tiled']},
              restore : {show: true},
              saveAsImage : {show: false}
          }
      },
      calculable : true,
      xAxis : [
          {
              type : 'category',
              axisLabel : {
                inside : true,
                align: 'center',
                margin: -30,
                rotate : 30,

                textStyle:{
                  fontSize: '9',

                }
              },
              data : dataTag
          }
      ],
      yAxis : [
          {
              type : 'value',
              splitArea : {show : true}
          }
      ],
      grid: {
          x2:40
      },
      series : [
          {
              name:'Etiquetas',
              type:'bar',
              data: dataTickets
          }
      ]
    };

    myChartF.setOption(optionF);
    myChartF2.setOption(optionF2);
    $(window).on('resize', function(){
        if(myChartF != null && myChartF2 != undefined){
            myChartF.resize();
            myChartF2.resize();
        }
    });
  }
