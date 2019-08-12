// Funcion para detectar cuando el usuario esta inactivo
/*
var idleTime = 0;
//Zero the idle timer on mouse movement.
$(function() {

  var idleInterval = setInterval(timerIncrement, 60000); // 1 minute
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });


});

  function timerIncrement() {

    idleTime = idleTime + 1;
      if (idleTime > 120) { // <- minutos sin actividad
          window.location.href = '/logout';
      }
  }
*/
/*  -----------------------------------    */


function opacity_btn(campo) {
  setTimeout('$(".'+campo+'").css({ opacity: 0.5 })', 5000 );
}


function menssage_toast(title, campoa, contenido, tiempo){
  switch (campoa) {
    case '1':
      $.toast({
          heading: title,
          text: contenido,
          position: 'top-right',
          loaderBg: '#DFBE47',
          icon:'warning',
          textColor: 'white',
          hideAfter: tiempo,
          stack: 6
      });
      break;
    case '2':
      $.toast({
          heading: title,
          text: contenido,
          position: 'top-right',
          loaderBg: '#DFBE47',
          icon:'error',
          textColor: 'white',
          bgColor: 'rgba(169, 67, 66, 0.7)',
          hideAfter: tiempo,
          stack: 6
      });
      break;
    case '3':
      $.toast({
          heading: title,
          text: contenido,
          position: 'top-right',
          loaderBg: '#DFBE47',
          icon:'info',
          textColor: 'white',
          hideAfter: tiempo,
          stack: 6
      });
      break;
    case '4':
      $.toast({
          heading: title,
          text: contenido,
          position: 'top-right',
          loaderBg: '#DFBE47',
          icon:'success',
          textColor: 'white',
          hideAfter: tiempo,
          stack: 6
      });
      break;
  }
}

function validarInput(campo) {
  if (campo != '') {
    select=document.getElementById(campo).value;
    if( select == null || select == 0 ) {
      $('#'+campo).parent().attr("class", "form-group has-error");
      return false;
    }
    else {
      $("#"+campo).parent().attr("class","form-group has-default");
      return true;
    }
  };
}

function validarSelect(campo) {
  if (campo != '') {
    select=document.getElementById(campo).selectedIndex;
    if( select == null || select == 0 ) {
      $('#'+campo).parent().parent().attr("class", "form-group has-error");
      return false;
    }
    else {
      $("#"+campo).parent().parent().attr("class","form-group has-default");
      return true;
    }
  };
}

function validarconsidencias (campoa, campob){
  var var_length_a = $('#password').val();
  var var_length_b = $('#password_confirmation').val();

  var validad_a = false;
  var validad_b = false;
  var validad_c = false;

  if (var_length_a.length >= 6) {
    validad_a = true;
    //console.error('cumple password');
  }
  if (var_length_b.length >= 6) {
    validad_b = true;
    //console.error('cumple retry password');
  }
  if (validad_a == true &&  validad_b == true) {
      if( var_length_a === var_length_b ){
        //console.error('cumple ');
        return true;
      }
      else {
        //console.error('nocumple intert');
        return false;
      }
  }
  else {
    //console.error('nocumple 1');
    return false;
  }
}

function graph_barras(title, campoa, campob) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    color: ['#3398DB'],
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
    },
    toolbox: {
        show : true,
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
            data : campoa,
            axisTick: {
                alignWithLabel: true
            },
            axisLabel : {
               show:true,
               interval: 'auto',    // {number}
               rotate: 90,
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
            //
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'Cantidad',
            type:'bar',
            barWidth: '60%',
            data:campob,
            itemStyle: {
              normal: {
                  color: function(params) {
                      // build a color map as your need.
                      var colorList = [
                        '#DD4B39','#00C0EF', '#605CA8', '#FF851B','#00A65A',
                        '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
                          '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
                          '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
                      ];
                      return colorList[params.dataIndex]
                  }
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

function graph_barras_two(title, campoa, campob) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    title: {
       text: 'Distribución',
       subtext: 'Equipos & Cantidades',
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
    color: ['#3398DB'],
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
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
            data : campoa,
            axisTick: {
                alignWithLabel: true
            },
            axisLabel : {
               show:true,
               interval: 'auto',    // {number}
               rotate: 20,
               margin: 10,
               formatter: '{value}',
               textStyle: {
                  //  color: 'blue',
                   fontFamily: 'sans-serif',
                   fontSize: 12,
                   fontStyle: 'normal',
                   fontWeight: 'bold'
               }
            }
            //
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'Cantidad',
            type:'bar',
            barWidth: '60%',
            data:campob,
            itemStyle: {
              normal: {
                  color: function(params) {
                      // build a color map as your need.
                      var colorList = [
                        '#DD4B39','#00C0EF', '#605CA8', '#FF851B','#00A65A',
                        '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
                          '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
                          '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
                      ];
                      return colorList[params.dataIndex]
                  }
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

function graph_barras_three(title, campoa, campob, titlepral, subtitulopral) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
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
    color: ['#3398DB'],
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
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
            data : campoa,
            axisTick: {
                alignWithLabel: true
            },
            axisLabel : {
               show:true,
               interval: 'auto',    // {number}
               rotate: 20,
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
            //
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'Cantidad',
            type:'bar',
            barWidth: '60%',
            data:campob,
            itemStyle: {
              normal: {
                  color: function(params) {
                      // build a color map as your need.
                      var colorList = [
                        '#DD4B39','#00C0EF', '#605CA8', '#FF851B','#00A65A',
                        '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
                          '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
                          '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
                      ];
                      return colorList[params.dataIndex]
                  }
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

function graph_barras_three_background(title, campoa, campob, titlepral, subtitulopral, campoc) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    backgroundColor: campoc,
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
    color: ['#3398DB'],
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
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
            data : campoa,
            axisTick: {
                alignWithLabel: true
            },
            axisLabel : {
               show:true,
               interval: 'auto',    // {number}
               rotate: 45,
               margin: 10,
               formatter: '{value}',
               textStyle: {
                  //  color: 'blue',
                   fontFamily: 'sans-serif',
                   fontSize: 8,
                   fontStyle: 'italic',
                   fontWeight: 'bold'
               }
            }
            //
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'Cantidad',
            type:'bar',
            barWidth: '60%',
            data:campob,
            itemStyle: {
              normal: {
                  color: function(params) {
                      // build a color map as your need.
                      var colorList = [
                        '#DD4B39','#00C0EF', '#605CA8', '#FF851B','#00A65A',
                        '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
                          '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
                          '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
                      ];
                      return colorList[params.dataIndex]
                  }
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

function graph_barras_four(title, campoa, campob, titlepral, subtitulopral, font) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    title: {
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
    color: ['#3398DB'],
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
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
            data : campoa,
            axisTick: {
                alignWithLabel: true
            },
            axisLabel : {
               show:true,
               interval: 'auto',    // {number}
               rotate: 20,
               margin: 10,
               formatter: '{value}',
               textStyle: {
                  //  color: 'blue',
                   fontFamily: 'sans-serif',
                   fontSize: font,
                   fontStyle: 'italic',
                   fontWeight: 'bold'
               }
            }
            //
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'Cantidad',
            type:'bar',
            barWidth: '60%',
            data:campob,
            itemStyle: {
              normal: {
                  color: function(params) {
                      // build a color map as your need.
                      var colorList = [
                        '#DD4B39','#00C0EF', '#605CA8', '#FF851B','#00A65A',
                        '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
                          '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
                          '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
                      ];
                      return colorList[params.dataIndex]
                  }
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

function graph_pie_default(title, campoa, campob){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
        title : {
            show: false,
            text: 'title',
            subtext: 'subtitulo',
            x:'center'
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            type: 'scroll',
            orient: 'vertical',
            right: 10,
            top: 10,
            bottom: 20,
            data: campoa
        },
        series : [
            {
                name: 'Información',
                type: 'pie',
                radius : '55%',
                center: ['40%', '50%'],
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
  myChart.setOption(option);

  $(window).on('resize', function(){
      if(myChart != null && myChart != undefined){
          myChart.resize();
      }
  });
}

function graph_pie_default_two(title, campoa, campob){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
        title : {
            show: true,
            text: 'Resumen',
            subtext: 'Concepto & Unidad',
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
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            // type: 'scroll',
            orient: 'horizontal',
            // right: 10,
            // top: 10,
            bottom: 10,
            data: campoa
        },
        series : [
            {
                name: 'Información',
                type: 'pie',
                radius : '30%',
                center: ['50%', '50%'],
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
  myChart.setOption(option);

  $(window).on('resize', function(){
      if(myChart != null && myChart != undefined){
          myChart.resize();
      }
  });
}

function graph_pie_default_three(title, campoa, campob, titlepral, subtitulopral){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
        title : {
            show: true,
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
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            // type: 'scroll',
            orient: 'horizontal',
            // right: 10,
            // top: 10,
            bottom: 10,
            data: campoa
        },
        series : [
            {
                name: 'Información',
                type: 'pie',
                radius : '55%',
                center: ['50%', '50%'],
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
  myChart.setOption(option);

  $(window).on('resize', function(){
      if(myChart != null && myChart != undefined){
          myChart.resize();
      }
  });
}

function graph_area_one_default(title, campoa, campob){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
        title : {
            show: true,
            text: 'Equipamiento',
            subtext: 'Modelos & Unidades',
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
        tooltip : {
          trigger: 'axis',
          axisPointer: {
              type: 'cross',
              label: {
                  backgroundColor: '#6a7985'
              }
          }
        },
        legend: {
            data: campoa
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
                boundaryGap : false,
                data: campoa,
                axisTick: {
                    alignWithLabel: true
                },
                axisLabel : {
                   align: 'center',
                   show:true,
                   interval: 'auto',    // {number}
                   rotate: 30,
                   margin: 30,
                   formatter: '{value}',
                   textStyle: {
                      //  color: 'blue',
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
                type : 'value'
            }
        ],
        series : [
          {
              name:'Cantidad',
              type:'line',
              stack: '总量',
              itemStyle: {
                  normal: {
                      color: 'rgba(63, 191, 142, 1)'
                  }
              },
              areaStyle: {
                normal: {
                    color: 'rgba(63, 191, 142, 0.5)'
                }

                },
              data:campob,
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

function graph_area_three_default(title, campoa, campob, titlepral, subtitulopral, alignlabel, rotatelabel, marginlabel){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
        title : {
            show: true,
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
        tooltip : {
          trigger: 'axis',
          axisPointer: {
              type: 'cross',
              label: {
                  backgroundColor: '#6a7985'
              }
          }
        },
        legend: {
            data: campoa
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
                boundaryGap : false,
                data: campoa,
                axisTick: {
                    alignWithLabel: true
                },
                axisLabel : {
                   align: alignlabel,
                   show:true,
                   interval: 'auto',    // {number}
                   rotate: rotatelabel,
                   margin: marginlabel,
                   formatter: '{value}',
                   textStyle: {
                      //  color: 'blue',
                       fontFamily: 'sans-serif',
                       fontSize: 12,
                       fontStyle: 'normal',
                       fontWeight: 'bold'
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
              name:'Cantidad',
              type:'line',
              stack: '总量',
              itemStyle: {
                  normal: {
                      color: 'rgba(63, 191, 142, 1)'
                  }
              },
              areaStyle: {
                normal: {
                    color: 'rgba(63, 191, 142, 0.5)'
                }

                },
              data:campob,
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

function graph_area_four_default(title, campoa, campob, titlepral, subtitulopral, alignlabel, rotatelabel, marginlabel, colorlinea, colorarea){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
        title : {
            show: true,
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
        tooltip : {
          trigger: 'axis',
          axisPointer: {
              type: 'cross',
              label: {
                  backgroundColor: '#6a7985'
              }
          }
        },
        legend: {
            data: campoa
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
                boundaryGap : false,
                data: campoa,
                axisTick: {
                    alignWithLabel: true
                },
                axisLabel : {
                   align: alignlabel,
                   show:true,
                   interval: 'auto',    // {number}
                   rotate: rotatelabel,
                   margin: marginlabel,
                   formatter: '{value}',
                   textStyle: {
                      //  color: 'blue',
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
                type : 'value'
            }
        ],
        series : [
          {
              name:'Cantidad',
              type:'line',
              stack: '总量',
              itemStyle: {
                  normal: {
                      color: colorlinea
                  }
              },
              areaStyle: {
                normal: {
                    color: colorarea
                }

                },
              data:campob,
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

function graph_nested_pies(title, campoa, campob){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    tooltip: {
        trigger: 'item',
        formatter: "{a} <br/>{b}: {c} ({d}%)"
    },
    legend: {
        orient: 'vertical',
        x: 'left',
        data:campoa
    },
    series: [
        {
            name:'访问来源',
            type:'pie',
            selectedMode: 'single',
            radius: [0, '30%'],

            label: {
                normal: {
                    position: 'inner'
                }
            },
            labelLine: {
                normal: {
                    show: false
                }
            },
            data:campob
        },
        {
            name:'访问来源',
            type:'pie',
            radius: ['40%', '55%'],
            label: {
                normal: {
                    formatter: '{a|{a}}{abg|}\n{hr|}\n  {b|{b}：}{c}  {per|{d}%}  ',
                    backgroundColor: '#eee',
                    borderColor: '#aaa',
                    borderWidth: 1,
                    borderRadius: 4,
                    rich: {
                        a: {
                            color: '#999',
                            lineHeight: 22,
                            align: 'center'
                        },
                        hr: {
                            borderColor: '#aaa',
                            width: '100%',
                            borderWidth: 0.5,
                            height: 0
                        },
                        b: {
                            fontSize: 16,
                            lineHeight: 33
                        },
                        per: {
                            color: '#eee',
                            backgroundColor: '#334455',
                            padding: [2, 4],
                            borderRadius: 2
                        }
                    }
                }
            },
            data:campob
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

function graph_barras_min_max(title,campoa,campob) {
  var myChart = echarts.init(document.getElementById(title));
  var seriesLabel = {
      normal: {
          show: true,
          textBorderColor: '#333',
          textBorderWidth: 2
      }
  }

  var option = {
      title: {
          show: false,
          text: 'Title'
      },
      tooltip: {
          trigger: 'axis',
          axisPointer: {
              type: 'shadow'
          }
      },
      legend: {
          data: campoa
      },
      grid: {
          left: 100
      },
      toolbox: {
          show: true,
          feature: {
            dataView : {show: true, readOnly: false, title : 'Datos', lang: ['Vista de datos', 'Cerrar', 'Actualizar']},
            restore : {show: false, title : 'Recargar'},
            saveAsImage: {show: true , title : 'Guardar'}
          }
      },
      xAxis: {
          type: 'value',
          name: 'Tours',
          axisLabel: {
              formatter: '{value}'
          }
      },
      yAxis: {
          type: 'category',
          inverse: true,
          data: campoa,
          axisLabel: {
            fontSize: 8,
            fontStyle: 'italic',
            fontWeight: 'bold'
        }
      },
      series: [
          {
              name: 'No.',
              type: 'bar',
              data: campob,
              label: seriesLabel,
              markPoint: {
                  symbolSize: 1,
                  symbolOffset: [0, '50%'],
                  label: {
                     normal: {
                          formatter: '{a|{a}\n}{b|{b} }{c|{c}}',
                          backgroundColor: 'rgb(242,242,242)',
                          borderColor: '#aaa',
                          borderWidth: 1,
                          borderRadius: 3,
                          padding: [1, 5],
                          lineHeight: 26,
                          shadowBlur: 5,
                          shadowColor: '#000',
                          shadowOffsetX: 0,
                          shadowOffsetY: 1,
                          position: 'right',
                          distance: 5,
                          rich: {
                              a: {
                                  align: 'left',
                                  color: '#fff',
                                  fontSize: 10,
                                  textShadowBlur: 1,
                                  textShadowColor: '#000',
                                  textShadowOffsetX: 0,
                                  textShadowOffsetY: 1,
                                  textBorderColor: '#333',
                                  textBorderWidth: 1
                              },
                              b: {
                                   color: '#333',
                                   fontSize: 8
                              },
                              c: {
                                  //color: '#ff8811',
                                  //textBorderColor: '#000',
                                  //textBorderWidth: 1,
                                  fontSize: 8
                              }
                          }
                     }
                  },
                  data: [
                      {type: 'max', name: 'Max: '},
                      {type: 'min', name: 'Min: '}
                  ]
              },
              itemStyle: {
                normal: {
                    color: function(params) {
                        // build a color map as your need.
                        var colorList = [
                          '#DD4B39','#00C0EF', '#605CA8', '#FF851B','#00A65A',
                          '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
                            '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
                            '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
                        ];
                        return colorList[params.dataIndex]
                    }
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

function graph_barras_min_max_average(title, campoa, campob) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
      title : {
          show: false,
          text: 'Title',
          subtext: 'Subtitle'
      },
      tooltip : {
          trigger: 'axis'
      },
      legend: {
          data:campoa
      },
      toolbox: {
          show : true,
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
      xAxis : [
          {
              type : 'category',
              data : campoa,
              axisLabel : {
                 show:true,
                 interval: 'auto',    // {number}
                 rotate: 90,
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
          }
      ],
      yAxis : [
          {
              type : 'value'
          }
      ],
      series : [
          {
              name:'Datos',
              type:'bar',
              data: campob,
              markPoint : {
                itemStyle: {
                  normal: {
                      color: '#00C0EF',
                      borderColor:'#00C0EF',
                      borderWidth: '#00C0EF',
                      label: {
                        show: true,
                        formatter: null,
                        textStyle: {
                            color: '#ffff',
                            fontFamily: 'Arial, Verdana, sans...',
                            fontSize: 10,
                            fontStyle: 'normal',
                            fontWeight: 'normal',
                            },
                      },
                  },
                  emphasis: {
                    color: '#C1232B',
                    borderColor:'#C1232B',
                    borderWidth:'#C1232B',
                    label: {
                        show: true,
                        formatter: null,
                        textStyle: {
                                color: '#ffff',
                                fontFamily: 'Arial, Verdana, sans...',
                                fontSize: 9,
                                fontStyle: 'normal',
                                fontWeight: 'normal',
                        },
                    },
                  },
                },
                data : [
                      {type : 'max', name: 'Máximo'},
                      {type : 'min', name: 'Mínimo'}
                ]
              },
              markLine : {
                  itemStyle: {
                    normal: {
                        color: '#00C0EF',
                        lineStyle: {
                          color: '#605CA8',
                          type: 'solid',
                          // width: <各异>,
                          shadowColor: 'rgba(0,0,0,0)',
                          shadowBlur: 5,
                          shadowOffsetX: 3,
                          shadowOffsetY: 3,
                        },
                        label: {
                            show: true,
                            formatter: null,
                            textStyle: {
                              color:'#FF851B',
                              // align: <各异>,
                              // baseline: <各异>,
                              fontFamily: 'Arial, Verdana, sans...',
                              fontSize: 12,
                              fontStyle: 'normal',
                              fontWeight: 'normal',
                            },
                        },
                    },
                    emphasis: {
                        color:'#27727B',
                        lineStyle: {
                          color:'#FCCE10',
                          type: 'solid',
                          // width: <各异>,
                          shadowColor: 'rgba(0,0,0,0)',
                          shadowBlur: 5,
                          shadowOffsetX: 3,
                          shadowOffsetY: 3,
                        },
                        label: {
                            show: true,
                            formatter: null,
                            textStyle: {
                              color:'#26C0C0',
                              // align: <各异>,
                              // baseline: <各异>,
                              fontFamily: 'Arial, Verdana, sans...',
                              fontSize: 12,
                              fontStyle: 'normal',
                              fontWeight: 'normal',
                            },
                        },
                    },
                  },
                  data : [
                      {type : 'average', name: 'Promedio'}
                  ]
              },
              itemStyle: {
                normal: {
                    color: function(params) {
                        // build a color map as your need.
                        var colorList = [
                          '#DD4B39','#00C0EF', '#605CA8', '#FF851B','#00A65A',
                          '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
                            '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
                            '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
                        ];
                        return colorList[params.dataIndex]
                    }
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

function graph_barras__with_text_fly(title, campoa, campob) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    title: {
        show: false,
        text: 'Title',
        subtext: 'Subtitle'
    },
    tooltip: {
        trigger: 'axis',
        axisPointer: {
            type: 'shadow'
        }
    },
    toolbox: {
        show : true,
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
            restore : {show: true, title : 'Recargar'},
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
    xAxis: {
        type: 'value',
        boundaryGap: [0, 0.01]
    },
    yAxis: {
        type: 'category',
        data: campoa
    },
    label: {
            normal: {
                show: true,
                textBorderColor: '#333',
                textBorderWidth: 1,
                position: 'right',
                fontSize: 8,
            }
        },
    series: [
        {
            name: 'Cantidad',
            type: 'bar',
            data: campob,
            itemStyle: {
              normal: {
                  color: function(params) {
                      // build a color map as your need.
                      var colorList = [
                        '#DD4B39','#00C0EF', '#605CA8', '#FF851B','#00A65A',
                        '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
                          '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
                          '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
                      ];
                      return colorList[params.dataIndex]
                  }
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

function graph_brush(title, campoa, campob, campoc, campomax) {
  var myChart = echarts.init(document.getElementById(title));
  var itemStyle = {
    normal: {
    },
    emphasis: {
        barBorderWidth: 1,
        shadowBlur: 10,
        shadowOffsetX: 0,
        shadowOffsetY: 0,
        shadowColor: 'rgba(0,0,0,0.5)'
    }
  };
  var option = {
      backgroundColor: '#eee',
      legend: {
          data: ['Subida MB', 'Bajada MB'],
          align: 'left',
          left: 10
      },
      brush: {
          toolbox: ['rect', 'polygon', 'lineX', 'lineY', 'keep', 'clear'],
          xAxisIndex: 0
      },
      toolbox: {
          feature: {
              magicType: {
                  type: ['stack', 'tiled']
              },
              title: {
                line: 'for line charts',
                bar: 'for bar charts',
                stack: 'for stacked charts',
                tiled: 'for tiled charts',
              },
              dataView: {show: true, readOnly: false, title : 'Datos', lang: ['Vista de datos', 'Cerrar', 'Actualizar']},
              brush: {
                title: {
                  rect: 'Rectangle selection',
                  polygon: 'Polygon selection',
                  lineX: 'Horizontal selection',
                  lineY: 'Vertical selection',
                  keep: 'Keep previous select...',
                  clear: 'Clear selection',
                },
              }
          }
      },
      tooltip: {
          trigger: 'axis',
          axisPointer : {            // 坐标轴指示器，坐标轴触发有效
              type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
          }
      },
      xAxis: {
          data: campoa,
          name: 'X Axis',
          silent: false,
          axisLine: {onZero: true},
          splitLine: {show: false},
          splitArea: {show: false},
          axisLabel : {
                 show:true,
                 interval: 'auto',    // {number}
                 rotate: 90,
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
          inverse: false, //Invertir
          splitArea: {show: false}
      },
      grid: {
          left: 100
      },
      visualMap: {
          type: 'continuous',
          dimension: 1,
          text: ['High', 'Low'],
          inverse: false,
          itemHeight: 200,
          calculable: true,
          min: -campomax,
          max: campomax,
          top: 60,
          left: 10,
          inRange: {
              colorLightness: [0.4, 0.8]
          },
          outOfRange: {
              color: '#bbb'
          },
          controller: {
              inRange: {
                  color: '#2f4554'
              }
          }
      },
      series: [
          {
              name: 'Subida MB',
              type: 'bar',
              stack: 'one',
              itemStyle: itemStyle,
              data: campob
          },
          {
              name: 'Bajada MB',
              type: 'bar',
              stack: 'one',
              itemStyle: itemStyle,
              data: campoc
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

function graph_brush_horizontal(title, campoa, campob, campoc){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
      tooltip : {
          trigger: 'axis',
          axisPointer : {            // 坐标轴指示器，坐标轴触发有效
              type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
          }
      },
      legend: {
          data: ['Subida', 'Bajada'],
      },
      grid: {
          left: '3%',
          right: '4%',
          bottom: '3%',
          containLabel: true
      },
      xAxis : [
          {
              type : 'value'
          }
      ],
      yAxis : [
          {
              type : 'category',
              axisTick : {show: false},
              data : campoa,
              axisLabel : {
                 show:true,
                 interval: 'auto',    // {number}
                 textStyle: {
                    //  color: 'blue',
                     fontFamily: 'sans-serif',
                     fontSize: 8,
                     fontStyle: 'italic',
                     fontWeight: 'bold'
                 }
              }
          }
      ],
      series : [
          {
              name:'Subida',
              type:'bar',
              stack: '总量',
              label: {
                  normal: {
                      show: true
                  }
              },
              data:campob
          },
          {
              name:'Bajada',
              type:'bar',
              stack: '总量',
              label: {
                  normal: {
                      show: true,
                  }
              },
              data:campoc
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

var Configuration_table_one= {
  paging: false,
  Filter: false,
  searching: false,
  bInfo: false,
  "processing": true,
  "columnDefs": [
        { //Subida 1
            "targets": [3],
            "visible": false,
            "searchable": false
        },
        { //Bajada 1
            "targets": [4],
            "visible": false,
            "searchable": false
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
    }
  },
  "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // converting to interger to find total
                    var intVal = function ( i ) {
                      return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                  //CONTADOR DE ZEROS EN CADA COLUMNA
                    var nregister = api.column(3, { search:'applied' }).data().length;
                    var count_ene = api.column(3, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;

                    var count_feb = api.column(4, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;

                  //SUMA EN COLUMNAS
                    var monto_ene = api.column( 3 , { search:'applied' }).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    var monto_feb = api.column( 4 , { search:'applied' }).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                  //Columna de Promedio
                  var count_average_up = api.column(3, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;

                  var monto_average_up = api.column( 3 , { search:'applied' }).data().reduce( function (a, b) {
                          return intVal(a) + intVal(b);
                      }, 0 );

                  var count_average_down = api.column(4, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;

                  var monto_average_down = api.column( 4 , { search:'applied' }).data().reduce( function (a, b) {
                          return intVal(a) + intVal(b);
                      }, 0 );


                  //Asignación de valores
                    var nCells = row.getElementsByTagName('th');

                    nCells[0].innerHTML = 'PROMEDIO CONSUMIDO';

                    if (nregister != 0){
                      if (monto_average_up != 0) { nCells[1].innerHTML = parseFloat( monto_average_up / (nregister - count_average_up) ).toFixed(1) + 'GB'; } else { nCells[1].innerHTML =0; }
                      if (monto_average_down != 0) { nCells[2].innerHTML = parseFloat( monto_average_down / (nregister - count_average_down) ).toFixed(1) + 'GB'; } else { nCells[2].innerHTML =0; }
                    }
                    else {
                      nCells[1].innerHTML = 0;
                      nCells[2].innerHTML = 0;
                    }
    }
};

var Configuration_table_responsive= {
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="far fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          return 'Equipamiento de  '+ $('#select_two :selected').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn btn-success custombtntable btn-xs',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="far fa-file-alt"></i> CSV',
        titleAttr: 'CSV',
        title: function ( e, dt, node, config ) {
          return 'Equipamiento de  '+ $('#select_two :selected').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn btn-info btn-xs',
      } /*,
      {
        extend: 'pdf',
        text: '<i class="far fa-file-pdf"></i>  PDF',
        title: function ( e, dt, node, config ) {
          return 'Asignación de hoteles';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        exportOptions: {
            columns: [ 0, 1],
            modifier: {
                page: 'all',
            }
        },
        className: 'btn btn-danger btn-xs',
      }*/
  ],
  "processing": true,

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
};

var Configuration_table_responsive_with_pdf_dashboardNPS= {
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="far fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          return 'Resultados de la encuesta.';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn bg-olive custombtntable',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="far fa-file-alt"></i> CSV',
        titleAttr: 'CSV',
        title: function ( e, dt, node, config ) {
          return 'Resultados de la encuesta.';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn btn-info',
      },
      {
        extend: 'pdf',
        text: '<i class="far fa-file-pdf"></i>  PDF',
        title: function ( e, dt, node, config ) {
          return 'Resultados de la encuesta.';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        customize: function ( doc ) {
          doc.content.splice( 0, 0, {
            margin: [0, 0, 0, 12],
            alignment: 'left',
            columns : [
              {
                alignment: 'center',
                image:
                'data:image/png;base64,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'
              },
              {

              },
              {

              },
            ]
          } );
        },
        exportOptions: {
            modifier: {
                page: 'all'
            }
        },
        className: 'btn btn-danger',
      }
  ],
  "processing": true,

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
};

var Configuration_table_responsive_with_pdf_two= {
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="far fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          return 'Equipamiento de '+ $('#name_htl').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn btn-success custombtntable',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="far fa-file-alt"></i> CSV',
        titleAttr: 'CSV',
        title: function ( e, dt, node, config ) {
          return 'Equipamiento de '+ $('#name_htl').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn btn-info',
      },
      {
        extend: 'pdf',
        text: '<i class="far fa-file-pdf"></i>  PDF',
        title: function ( e, dt, node, config ) {
          return 'Equipamiento de '+ $('#name_htl').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        customize: function ( doc ) {
          doc.content.splice( 0, 0, {
            margin: [0, 0, 0, 12],
            alignment: 'left',
            columns : [
              {
                alignment: 'center',
                image:
                'data:image/png;base64,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'
              },
              {
                text: [
                  { text: '\n\Proyecto: ', fontSize: 10, bold: true },
                  { text: $('#name_htl').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Email: ', fontSize: 10, bold: true },
                  { text: $('#email').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Teléfono: ', fontSize: 10, bold: true },
                  { text: $('#tel').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Fecha de expedición: ', fontSize: 10, bold: true },
                  { text: $('#date').text()+'\n', fontSize: 10, italics: true },
                ]
              },
              {

              },
            ]
          } );
        },
        exportOptions: {
            modifier: {
                page: 'all'
            }
        },
        className: 'btn btn-danger',
      }
  ],
  "processing": true,

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
};

var Configuration_table_responsive_with_pdf= {
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="far fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          return 'Equipamiento de '+ $('#client').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn bg-olive custombtntable',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="far fa-file-alt"></i> CSV',
        titleAttr: 'CSV',
        title: function ( e, dt, node, config ) {
          $(node).removeClass('btn-default');
          return 'Equipamiento de '+ $('#client').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn btn-info',
      },
      {
        extend: 'pdf',
        text: '<i class="far fa-file-pdf"></i>  PDF',
        title: function ( e, dt, node, config ) {
          $(node).removeClass('btn-default');
          return 'Equipamiento de '+ $('#client').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        customize: function ( doc ) {
          doc.content.splice( 0, 0, {
            margin: [0, 0, 0, 12],
            alignment: 'left',
            columns : [
              {
                alignment: 'center',
                image:
                'data:image/png;base64,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'
              },
              {
                text: [
                  { text: '\n\nCliente: ', fontSize: 10, bold: true },
                  { text: $('#client').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Dirección: ', fontSize: 10, bold: true },
                  { text: $('#direccion').text()+'\n', fontSize: 10, italics: true },

                  { text: 'País: ', fontSize: 10, bold: true },
                  { text: $('#pais').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Estado: ', fontSize: 10, bold: true },
                  { text: $('#estado').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Servicio: ', fontSize: 10, bold: true},
                  { text: $('#servicio').text()+'\n', fontSize: 10, italics: true },
                ]
              },
              {

              },
            ]
          } );
        },
        exportOptions: {
            modifier: {
                page: 'all'
            }
        },
        className: 'btn btn-danger',
      }
  ],
  "processing": true,

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
};

var Configuration_table_responsive_two= {
  dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        text: '<i class="fa fa-user-plus margin-r5"></i> Crear Usuario',
        titleAttr: 'Crear Usuario',
        className: 'btn btn-success creatadduser',
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        action: function ( e, dt, node, config ) {
          $('#modal-CreatUser').modal('show');
          if (document.getElementById("creatusersystem")) {
            $('#creatusersystem')[0].reset();
          }
        }
      },
      {
        extend: 'excelHtml5',
        title: 'Export of user data',
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        text: '<i class="far fa-file-excel margin-r5"></i> Extraer a Excel',
        titleAttr: 'Excel',
        className: 'btn bg-olive custombtntable',
        exportOptions: {
            columns: [ 0, 1, 2]
        },
      },
      {
        extend: 'csvHtml5',
        title: 'Export of user data',
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        text: '<i class="far fa-file-alt margin-r5"></i> Extraer a CSV',
        titleAttr: 'CSV',
        className: 'btn btn-info',
        exportOptions: {
            columns: [ 0, 1, 2]
        },
      }
  ],
  "processing": true,
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
};

var Configuration_table_responsive_simple={
      "order": [[ 0, "desc" ]],
      paging: false,
      //"pagingType": "simple",
      Filter: false,
      searching: false,
      //"aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      //ordering: false,
      //"pageLength": 5,
      bInfo: false,
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
}
var Configuration_table_responsive_simple_asc={
      "order": [[ 0, "asc" ]],
      paging: false,
      //"pagingType": "simple",
      Filter: false,
      searching: false,
      //"aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      //ordering: false,
      //"pageLength": 5,
      bInfo: false,
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
}
var Configuration_table_responsive_simple_two={
      "order": [[ 0, "desc" ]],
      paging: true,
      //"pagingType": "simple",
      Filter: true,
      searching: true,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      //ordering: false,
      //"pageLength": 5,
      bInfo: false,
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
var Configuration_table_responsive_simple_two_asc={
      "order": [[ 0, "asc" ]],
      paging: true,
      //"pagingType": "simple",
      Filter: true,
      searching: true,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],

      bInfo: false,
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
var Configuration_table_responsive_distribution= {
  "order": [[ 0, "asc" ]],
  "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="far fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          return 'Distribución de equipamiento';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn bg-olive custombtntable',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="far fa-file-alt"></i> CSV',
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
  "processing": true,
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
};

var Configuration_table_responsive_with_cont_one_pdf= {
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="far fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          return $('#title').text() +' '+$('#client_name').text();
        },
        className: 'btn bg-olive custombtntable',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="far fa-file-alt"></i> CSV',
        titleAttr: 'CSV',
        title: function ( e, dt, node, config ) {
          return $('#title').text() +' '+$('#client_name').text();
        },
        className: 'btn btn-info',
      },
      {
        extend: 'pdf',
        orientation: 'landscape',
        text: '<i class="far fa-file-pdf"></i>  PDF',
        title: function ( e, dt, node, config ) {
          return $('#title').text() +' '+$('#client_name').text();
        },
        customize: function ( doc ) {
          doc.content.splice( 0, 0, {
            margin: [0, 0, 0, 12],
            alignment: 'left',
            columns : [
              {
                alignment: 'center',
                image:
                'data:image/png;base64,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'
              },
              {
                text: [
                  { text: '\n\Informe: ', fontSize: 10, bold: true },
                  { text: $('#title_table1').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Cadena: ', fontSize: 10, bold: true },
                  { text: $('#client_name').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Email: ', fontSize: 10, bold: true },
                  { text: $('#email').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Teléfono: ', fontSize: 10, bold: true },
                  { text: $('#tel').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Fecha de expedición: ', fontSize: 10, bold: true },
                  { text: $('#date').text()+'\n', fontSize: 10, italics: true },
                ]
              },
              {

              },
            ]
          } );
        },
        exportOptions: {
            modifier: {
                page: 'all'
            }
        },
        className: 'btn btn-danger',
      }
  ],
  "processing": true,

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
};

var Configuration_table_responsive_with_cont_two_pdf= {
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="far fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          return $('#title').text() +' '+$('#client_name').text();
        },
        className: 'btn bg-olive custombtntable',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="far fa-file-alt"></i> CSV',
        titleAttr: 'CSV',
        title: function ( e, dt, node, config ) {
          return $('#title').text() +' '+$('#client_name').text();
        },
        className: 'btn btn-info',
      },
      {
        extend: 'pdf',
        orientation: 'landscape',
        text: '<i class="far fa-file-pdf"></i>  PDF',
        title: function ( e, dt, node, config ) {
          return $('#title').text() +' '+$('#client_name').text();
        },
        customize: function ( doc ) {
          doc.content.splice( 0, 0, {
            margin: [0, 0, 0, 12],
            alignment: 'left',
            columns : [
              {
                alignment: 'center',
                image:
                'data:image/png;base64,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'
              },
              {
                text: [
                  { text: '\n\Informe: ', fontSize: 10, bold: true },
                  { text: $('#title_table2').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Cadena: ', fontSize: 10, bold: true },
                  { text: $('#client_name').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Email: ', fontSize: 10, bold: true },
                  { text: $('#email').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Teléfono: ', fontSize: 10, bold: true },
                  { text: $('#tel').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Fecha de expedición: ', fontSize: 10, bold: true },
                  { text: $('#date').text()+'\n', fontSize: 10, italics: true },
                ]
              },
              {

              },
            ]
          } );
        },
        exportOptions: {
            modifier: {
                page: 'all'
            }
        },
        className: 'btn btn-danger',
      }
  ],
  "processing": true,

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
};

var Configuration_table_responsive_with_pdf_client_hotel= {
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="far fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          return 'Relación cliente - hotel';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        exportOptions: {
            columns: [ 0, 1]
        },
        className: 'btn bg-olive custombtntable',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="far fa-file-alt"></i> CSV',
        titleAttr: 'CSV',
        title: function ( e, dt, node, config ) {
          return 'Relación cliente - hotel';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        exportOptions: {
            columns: [ 0, 1]
        },
        className: 'btn btn-info',
      },
      {
        extend: 'pdf',
        text: '<i class="far fa-file-pdf"></i>  PDF',
        title: function ( e, dt, node, config ) {
          return 'Relación cliente - hotel';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        exportOptions: {
            columns: [ 0, 1],
            modifier: {
                page: 'all',
            }
        },
        className: 'btn btn-danger',
      }
  ],
  "processing": true,

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
};

function getValueCurrentGeneral(qty) {
    var retval;
    var val=qty;
    if (val == 'Promotor') { retval = 10;}
    if (val == 'Pasivo') { retval = 8;}
    if (val == 'Detractor') { retval = 0;}
    return retval;
}
function getSpanCurrent(val){
  var retval;
  if (isNaN(val)) {
    retval = "";
  }else if(val >= 9 ){
    retval = '<span class="label label-success" id="pr">Promotor</span>';
  }else if(val >=7){
    retval = '<span class="label label-warning" id="ps">Pasivo</span>';
  }else if(val >= 0){
    retval = '<span class="label label-danger" id="det">Detractor</span>';
  }else{
    retval = "";
  }
  return retval;
}
var Configuration_table_responsive_with_pdf_survey_nps= {
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="far fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          return 'Resultados - Encuesta';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        exportOptions: {
            columns: [  0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17]
        },
        className: 'btn bg-olive custombtntable',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="far fa-file-alt"></i> CSV',
        titleAttr: 'CSV',
        title: function ( e, dt, node, config ) {
          return 'Resultados - Encuesta';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        exportOptions: {
            columns: [  0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17]
        },
        className: 'btn btn-info',
      },
      {
        extend: 'pdf',
        orientation: 'landscape',
        pageSize: 'LEGAL',
        text: '<i class="far fa-file-pdf"></i>  PDF',
        title: function ( e, dt, node, config ) {
          return 'Resultados - Encuesta';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        exportOptions: {
            columns: [ 0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17],
            modifier: {
                page: 'all',
            }
        },
        className: 'btn btn-danger',
      }
  ],
  "footerCallback": function(row, data, start, end, display){
    var api = this.api(), data;

    var suma = 0;
    var colCount = 13;
    var colCountDyn = 0;
    var intVal = function ( i ) {
      return typeof i === 'string' ?
          i.replace(/[\$,]/g, '')*1 :
          typeof i === 'number' ?
              i : 0;
    };
    for (colCount; colCount >= 2; colCount--) {
      testTotal = api
          .column(colCount, { page: 'current'})
          .data().toArray();

      tTlenght = testTotal.length -1;

      for (tTlenght; tTlenght >= 0; tTlenght--) {
        //console.log(tTlenght);
        html = $.parseHTML(testTotal[tTlenght]);
        if (html.length == 0) {
          suma = suma + 0;
        }else{
          $.each(html, function( i, el ) {
            //console.log(el.innerHTML);
            valor_func  = getValueCurrentGeneral(el.innerHTML);
            suma = suma + valor_func;
          });
          colCountDyn = colCountDyn + 1;
        }
        //console.log(html)
      }
      totalTot = (suma / colCountDyn).toFixed(2);
      totalTotspan = getSpanCurrent(totalTot);
      // Update footer
      $( api.column( colCount ).footer() ).html(
          //suma total: añadir division por #filas.
          totalTotspan
      );
      // console.log(colCountDyn);
      // console.log(suma);
      colCountDyn = 0;
      suma = 0;
    }

    var columnDataTotal = api
      .column(15)
      .data();
    var columnDataPage = api
      .column( 15, { page: 'current'} )
      .data();
    //columna 15 pruebas (NPS).
      total = api
          .column(15)
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );
      pageTotal = api
          .column( 15, { page: 'current'} )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );
      // Update footer
      $( api.column( 15 ).footer() ).html(
          //suma total: añadir division por #filas.
          'Promedio: ' + (pageTotal / columnDataPage.count()).toFixed(2) + ' | Total: ' + (total / columnDataTotal.count()).toFixed(2)
          //'$'+pageTotal +' ( $'+ total +' total)'
      );
  },
  // "footerCallback": function(row, data, start, end, display){
  //     var api = this.api(), data;
  //     var intVal = function ( i ) {
  //       return typeof i === 'string' ?
  //           i.replace(/[\$,]/g, '')*1 :
  //           typeof i === 'number' ?
  //               i : 0;
  //     };
  //     var colCount = 13;
  //     var colCountDyn = 0;

  //     for (colCount; colCount >= 2; colCount--) {
  //       var columnDataTotal = api
  //         .column(colCount)
  //         .data();

  //       var columnDataPage = api
  //         .column( colCount, { page: 'current'} )
  //         .data();

  //       //columna colCount pruebas (NPS).

  //         pageTotal = api
  //             .column( colCount, { page: 'current'} )
  //             .data()
  //             .reduce( function (a, b) {
  //                 return intVal(a) + intVal(b);
  //             }, 0 );

  //         testTotal = api
  //             .column(colCount, { page: 'current'})
  //             .data().toArray();
  //             //.eq(0);

  //         for (var n = testTotal.length; n >= 0; n--) {
  //           if (testTotal[n] != null){
  //               colCountDyn = colCountDyn + 1;
  //           }
  //         }
  //         //console.log(testTotal.length);

  //         totalTot = (pageTotal / colCountDyn).toFixed(2);

  //         // Update footer
  //         $( api.column( colCount ).footer() ).html(
  //             //suma total: añadir division por #filas.
  //             'Promedio: ' + totalTot
  //         );
  //         colCountDyn = 0;

  //     }
  //     var columnDataTotal = api
  //       .column(15)
  //       .data();
  //     var columnDataPage = api
  //       .column( 15, { page: 'current'} )
  //       .data();
  //     //columna 15 pruebas (NPS).
  //       total = api
  //           .column(15)
  //           .data()
  //           .reduce( function (a, b) {
  //               return intVal(a) + intVal(b);
  //           }, 0 );
  //       pageTotal = api
  //           .column( 15, { page: 'current'} )
  //           .data()
  //           .reduce( function (a, b) {
  //               return intVal(a) + intVal(b);
  //           }, 0 );
  //       // Update footer
  //       $( api.column( 15 ).footer() ).html(
  //           //suma total: añadir division por #filas.
  //           'Promedio: ' + (pageTotal / columnDataPage.count()).toFixed(2) + ' | Total: ' + (total / columnDataTotal.count()).toFixed(2)
  //           //'$'+pageTotal +' ( $'+ total +' total)'
  //       );
  //       //console.log('hola?');
  // },
  "processing": true,
  "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
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
};

var Configuration_table_responsive_with_contenado_a= {
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="far fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          return $('#title').text() +' '+$('#client_name').text()  +'-'+ $('#title_table1').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn bg-olive custombtntable',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="far fa-file-alt"></i> CSV',
        titleAttr: 'CSV',
        title: function ( e, dt, node, config ) {
          return $('#title').text() +' '+$('#client_name').text()  +'-'+ $('#title_table1').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn btn-info',
      },
      {
        extend: 'pdf',
        orientation: 'landscape',
        text: '<i class="far fa-file-pdf"></i>  PDF',
        title: function ( e, dt, node, config ) {
          return $('#title').text() +' '+$('#client_name').text()  +'-'+ $('#title_table1').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        customize: function ( doc ) {
          doc.content.splice( 0, 0, {
            margin: [0, 0, 0, 12],
            alignment: 'left',
            columns : [
              {
                alignment: 'center',
                image:
                'data:image/png;base64,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'
              },
              {
                text: [
                  { text: '\n\Informe: ', fontSize: 10, bold: true },
                  { text: $('#title_table1').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Cadena: ', fontSize: 10, bold: true },
                  { text: $('#client_name').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Email: ', fontSize: 10, bold: true },
                  { text: $('#email').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Teléfono: ', fontSize: 10, bold: true },
                  { text: $('#tel').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Fecha de expedición: ', fontSize: 10, bold: true },
                  { text: $('#date').text()+'\n', fontSize: 10, italics: true },
                ]
              },
              {

              },
            ]
          } );
        },
        exportOptions: {
            modifier: {
                page: 'all'
            }
        },
        className: 'btn btn-danger',
      }
  ],
  "processing": true,

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
};

var Configuration_table_responsive_with_contenado_b= {
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="far fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          return $('#title').text() +' '+$('#client_name').text()  +'-'+ $('#title_table2').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn bg-olive custombtntable',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="far fa-file-alt"></i> CSV',
        titleAttr: 'CSV',
        title: function ( e, dt, node, config ) {
          return $('#title').text() +' '+$('#client_name').text()  +'-'+ $('#title_table2').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn btn-info',
      },
      {
        extend: 'pdf',
        orientation: 'landscape',
        text: '<i class="far fa-file-pdf"></i>  PDF',
        title: function ( e, dt, node, config ) {
          return $('#title').text() +' '+$('#client_name').text()  +'-'+ $('#title_table2').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        customize: function ( doc ) {
          doc.content.splice( 0, 0, {
            margin: [0, 0, 0, 12],
            alignment: 'left',
            columns : [
              {
                alignment: 'center',
                image:
                'data:image/png;base64,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'
              },
              {
                text: [
                  { text: '\n\Informe: ', fontSize: 10, bold: true },
                  { text: $('#title_table2').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Cadena: ', fontSize: 10, bold: true },
                  { text: $('#client_name').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Email: ', fontSize: 10, bold: true },
                  { text: $('#email').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Teléfono: ', fontSize: 10, bold: true },
                  { text: $('#tel').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Fecha de expedición: ', fontSize: 10, bold: true },
                  { text: $('#date').text()+'\n', fontSize: 10, italics: true },
                ]
              },
              {

              },
            ]
          } );
        },
        exportOptions: {
            modifier: {
                page: 'all'
            }
        },
        className: 'btn btn-danger',
      }
  ],
  "processing": true,

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
};

var Configuration_table_responsive_with_contenado_c= {
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="far fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          return $('#title').text() +' '+$('#client_name').text()  +'-'+ $('#title_table3').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn bg-olive custombtntable',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="far fa-file-alt"></i> CSV',
        titleAttr: 'CSV',
        title: function ( e, dt, node, config ) {
          return $('#title').text() +' '+$('#client_name').text()  +'-'+ $('#title_table3').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn btn-info',
      },
      {
        extend: 'pdf',
        orientation: 'landscape',
        text: '<i class="far fa-file-pdf"></i>  PDF',
        title: function ( e, dt, node, config ) {
          return $('#title').text() +' '+$('#client_name').text()  +'-'+ $('#title_table3').text();
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        customize: function ( doc ) {
          doc.content.splice( 0, 0, {
            margin: [0, 0, 0, 12],
            alignment: 'left',
            columns : [
              {
                alignment: 'center',
                image:
                'data:image/png;base64,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'
              },
              {
                text: [
                  { text: '\n\Informe: ', fontSize: 10, bold: true },
                  { text: $('#title_table3').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Cadena: ', fontSize: 10, bold: true },
                  { text: $('#client_name').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Email: ', fontSize: 10, bold: true },
                  { text: $('#email').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Teléfono: ', fontSize: 10, bold: true },
                  { text: $('#tel').text()+'\n', fontSize: 10, italics: true },

                  { text: 'Fecha de expedición: ', fontSize: 10, bold: true },
                  { text: $('#date').text()+'\n', fontSize: 10, italics: true },
                ]
              },
              {

              },
            ]
          } );
        },
        exportOptions: {
            modifier: {
                page: 'all'
            }
        },
        className: 'btn btn-danger',
      }
  ],
  "processing": true,

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
};

var Configuration_table_responsive_with_pdf_enc_dominio= {
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="far fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          return 'Relación Encuestados';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4, 5]
        },
        className: 'btn bg-olive custombtntable',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="far fa-file-alt"></i> CSV',
        titleAttr: 'CSV',
        title: function ( e, dt, node, config ) {
          return 'Relación Encuestados';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4, 5]
        },
        className: 'btn btn-info',
      },
      {
        extend: 'pdf',
        // orientation: 'landscape',
        text: '<i class="far fa-file-pdf"></i>  PDF',
        title: function ( e, dt, node, config ) {
          return 'Relación Encuestados';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4, 5],
            modifier: {
                page: 'all',
            }
        },
        className: 'btn btn-danger',
      }
  ],
  "processing": true,

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
};

function function_tree(title, titlepral, subtitlepral, data1) {
  var myChart = echarts.init(document.getElementById(title));
  myChart.showLoading();
  var option= {
    title: {
       text: titlepral,
       subtext: subtitlepral,
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
        triggerOn: 'mousemove'
    },
    legend: {
        show : false,
        top: '2%',
        left: '3%',
        orient: 'vertical',
        data: [{
            name: 'tree1',
            icon: 'rectangle'
        }],
        borderColor: '#c23531'
    },
    series:[
        {
            type: 'tree',
            name: 'tree1',
            data: [data1],
            top: '5%',
            left: '7%',
            bottom: '%',
            right: '20%',
            symbolSize: 10,

            label: {
                normal: {
                    show: true,
                    position: 'right',
                    fontSize: 8,
                    padding:1,
                    shadowOffsetY: 170,
                    rotate: 0,
                    fontStyle: 'bold',
                    fontFamily: 'sans-serif',

                }
            },

            leaves: {
                label: {
                    margin: 8,
                    normal: {
                      show: true,
                      position: 'right',
                      fontSize: 8,
                      padding:1,
                      shadowOffsetY: 170,
                      rotate: 0,
                      fontStyle: 'bold',
                      fontFamily: 'sans-serif',
                    }
                }
            },

            expandAndCollapse: false,
            animationDuration: 550,
            animationDurationUpdate: 750

        }
    ]
  };

  myChart.hideLoading();

  myChart.setOption(option);
  $(window).on('resize', function(){
      if(myChart != null && myChart != undefined){
          myChart.resize();
      }
  });
}

function graph_douhnut_default(title, titlepral, subtitlepral, campoa, campob){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
        title : {
            show: true,
            text: titlepral,
            subtext: subtitlepral,
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
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            // type: 'scroll',
            orient: 'horizontal',
            // right: 10,
            // top: 10,
            bottom: 10,
            data: campoa
        },
        series : [
            {
                name: 'Información',
                type: 'pie',
                radius: ['50%', '70%'],
                avoidLabelOverlap: false,
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
  myChart.setOption(option);

  $(window).on('resize', function(){
      if(myChart != null && myChart != undefined){
          myChart.resize();
      }
  });
}

function graph_douhnut_two_default(title, titlepral, subtitlepral, positiontitle, campoa, campob){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
        title : {
            show: true,
            text: titlepral,
            subtext: subtitlepral,
            x: positiontitle,
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
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            // type: 'scroll',
            orient: 'horizontal',
            // right: 10,
            // top: 10,
            bottom: 10,
            data: campoa
        },
        series : [
            {
                name: 'Información',
                type: 'pie',
                radius: ['15%', '25%'],
                avoidLabelOverlap: false,
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
  myChart.setOption(option);

  $(window).on('resize', function(){
      if(myChart != null && myChart != undefined){
          myChart.resize();
      }
  });
}

function graph_douhnut_two_default_background(title, titlepral, subtitlepral, positiontitle, campoa, campob, campoc){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
        backgroundColor: campoc,
        title : {
            show: true,
            text: titlepral,
            subtext: subtitlepral,
            x: positiontitle,
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
        },
        textStyle : {
           // color: 'yellow',
           // decoration: 'none',
           fontFamily: 'Verdana, sans-serif',
           fontSize:10,
           fontStyle: 'italic',
           fontWeight: 'bold'
       },
        legend: {
            // type: 'scroll',
            orient: 'horizontal',
            // right: 10,
            // top: 10,
            bottom: 10,
            data: campoa
        },
        series : [
            {
                name: 'Información',
                type: 'pie',
                radius: ['15%', '25%'],
                avoidLabelOverlap: false,
                data:campob,
                itemStyle: {
                    emphasis: {
                        shadowBlur: 8,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
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


function graph_pie_default_four(title, campoa, campob, titlepral, subtitulopral, positiontitle){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
        title : {
            show: true,
            text: titlepral,
            subtext: subtitulopral,
            x:positiontitle,
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
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            // type: 'scroll',
            orient: 'horizontal',
            // right: 10,
            // top: 10,
            bottom: 10,
            data: campoa
        },
        series : [
            {
                name: 'Información',
                type: 'pie',
                radius : '30%',
                center: ['50%', '50%'],
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
  myChart.setOption(option);

  $(window).on('resize', function(){
      if(myChart != null && myChart != undefined){
          myChart.resize();
      }
  });
}
function graph_gauge(title, grapname, valuemin, valuemax, valor) {
  //function graph_gauge(title, campoa, campob) {
  var myChart = echarts.init(document.getElementById(title));
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
          myChart.resize();
      }
  });
}

function graph_pie_default_four_with_porcent(title, campoa, campob, titlepral, subtitulopral, positiontitle){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
        title : {
            show: true,
            text: titlepral,
            subtext: subtitulopral,
            x:positiontitle,
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
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            // type: 'scroll',
            orient: 'horizontal',
            // right: 10,
            // top: 10,
            bottom: 10,
            data: campoa
        },
        grid: {
          show: false,
          backgroundColor: '#fff'
        },
        color : ['#0B610B','#FFBF00', '#E73231', '#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'],
        series : [
            {
                name: 'Información',
                type: 'pie',
                radius : '50%',
                center: ['50%', '50%'],
                data:campob,
                itemStyle : {
                    normal : {
                        label : {
                            position : 'outside',
                            formatter : function (params) {
                              return (params.percent - 0).toFixed(2) + '%'
                            }
                        },
                        labelLine : {
                            show : true
                        }
                    },
                    emphasis : {
                        label : {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)',
                            show : true,
                            formatter : "{b}\n{d}%"
                        }
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

function graph_pie_default_four_with_porcent_background(title, campoa, campob, titlepral, subtitulopral, positiontitle, campoc){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
        backgroundColor: campoc,
        title : {
            show: true,
            text: titlepral,
            subtext: subtitulopral,
            x:positiontitle,
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
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            // type: 'scroll',
            orient: 'horizontal',
            // right: 10,
            // top: 10,
            bottom: 10,
            data: campoa
        },
        grid: {
          show: false,
          backgroundColor: '#fff'
        },
        color : ['#2f4554','#FFBF00', '#c4ccd3', '#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'],
        series : [
            {
                name: 'Información',
                type: 'pie',
                radius : '50%',
                center: ['50%', '50%'],
                data:campob,
                itemStyle : {
                    normal : {
                        label : {
                            position : 'outside',
                            formatter : function (params) {
                              return (params.percent - 0).toFixed(2) + '%'
                            }
                        },
                        labelLine : {
                            show : true
                        }
                    },
                    emphasis : {
                        label : {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)',
                            show : true,
                            formatter : "{b}\n{d}%"
                        }
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

function graph_bar_with_three_val_insideRight(title, data_name, campom, campoa, campob, campoc){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
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
        data: campom,
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
                  color: '#00A65A',
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
                  color: '#FCCE10',
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
                  color: '#C1232B',
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

function graph_bar_with_four_val_insideRight(title, data_name, campom, campoa, campob, campoc, campod){
  var myChart = echarts.init(document.getElementById(title));
  var option = {
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
        data: campom,
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
        {
            name: data_name[3],
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
                  color: '#749f83',
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


function grap_user_vs_request(title, data_name, campom, campoa, campob){
  var myChart = echarts.init(document.getElementById(title));
  var colors = ['#5793f3', '#d14a61', '#675bba'];
  var option = {
    color: colors,
    tooltip: {
        trigger: 'none',
        axisPointer: {
            type: 'cross'
        }
    },
    legend: {
        data: data_name,

    },
    grid: {
        top: 70,
        bottom: 50
    },
    xAxis: [
        {
            type: 'category',
            axisTick: {
                alignWithLabel: true
            },
            axisLine: {
                onZero: false,
                lineStyle: {
                    color: colors[0]
                }
            },
            axisLabel : {
               show:true,
               interval: 'auto',    // {number}
               rotate: 15,
               margin: 10,
               formatter: '{value}',
               textStyle: {
                  //  color: 'blue',
                   fontFamily: 'sans-serif',
                   fontSize: 8,
                   fontStyle: 'italic',
                   fontWeight: 'bold'
               }
            },
            axisPointer: {
                label: {
                    formatter: function (params) {
                        return 'Valor  ' + params.value
                            + (params.seriesData.length ? '：' + params.seriesData[0].data : '');
                    }
                }
            },
            data: campom,

        },
        {
            type: 'category',
            axisTick: {
                alignWithLabel: true
            },
            axisLine: {
                onZero: false,
                lineStyle: {
                    color: colors[1]
                }
            },
            axisLabel : {
               show:true,
               interval: 'auto',    // {number}
               rotate: 15,
               margin: 10,
               formatter: '{value}',
               textStyle: {
                  //  color: 'blue',
                   fontFamily: 'sans-serif',
                   fontSize: 8,
                   fontStyle: 'italic',
                   fontWeight: 'bold'
               }
            },
            axisPointer: {
                label: {
                    formatter: function (params) {
                        return 'Valor  ' + params.value
                            + (params.seriesData.length ? '：' + params.seriesData[0].data : '');
                    }
                }
            },
            data: campom
        }
    ],
    yAxis: [
        {
            type: 'value'
        }
    ],
    series: [
        {
            name: data_name[0],
            type:'line',

            smooth: true,
            data: campoa
        },
        {
            name: data_name[1],
            type:'line',
            xAxisIndex: 1,
            smooth: true,
            data: campob
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

function main_gra_grade_avg_per_month(title, campoa, campob, titlepral, subtitulopral) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
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
    color: ['#3398DB'],
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
    },
    toolbox: {
        show : false,
        feature : {
            dataView : {show: false, readOnly: false, title : 'Datos', lang: ['Vista de datos', 'Cerrar', 'Actualizar']},
            magicType : {
              show: false,
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
            data : campoa,
            axisTick: {
                alignWithLabel: true
            },
            axisLabel : {
               show:true,
               interval: 'auto',    // {number}
               rotate: 20,
               margin: 10,
               formatter: '{value}',
               textStyle: {
                  //  color: 'blue',
                   fontFamily: 'sans-serif',
                   fontSize: 8,
                   fontStyle: 'italic',
                   fontWeight: 'bold'
               }
            }
            //
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'Cantidad',
            type:'bar',
            barWidth: '60%',
            data:campob,
            itemStyle: {
              normal: {
                  color: function(params) {
                      // build a color map as your need.
                      var colorList = [
                        '#DD4B39','#00C0EF', '#605CA8', '#FF851B','#00A65A',
                        '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
                          '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
                          '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
                      ];
                      return colorList[params.dataIndex]
                  }
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


//Nuevas tablas con checkbox

var Configuration_table_responsive_checkbox_one= {
        "order": [[ 1, "asc" ]],
        "select": true,
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "columnDefs": [
            { //Subida 1
                "targets": 0,
                "checkboxes": {
                  'selectRow': true
                },
                "width": "1%",
            },
            {
                "targets": 4,
                "className": "text-center",
            }
        ],
        "select": {
            'style': 'multi',
        },
        dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
          {
            extend: 'excelHtml5',
            text: '<i class="far fa-file-excel"></i> Excel',
            titleAttr: 'Excel',
            title: function ( e, dt, node, config ) {
              return 'Reporte de Bajas.';
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 1,2,3,4,5,6,7,8],
                modifier: {
                    page: 'all',
                }
            },
            className: 'btn btn-success',
          },
          {
            extend: 'csvHtml5',
            text: '<i class="far fa-file-alt"></i> CSV',
            titleAttr: 'CSV',
            title: function ( e, dt, node, config ) {
              return 'Reporte de Bajas.';
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 1,2,3,4,5,6,7,8],
                modifier: {
                    page: 'all',
                }
            },
            className: 'btn btn-info',
          },
          {
            extend: 'pdf',
            text: '<i class="far fa-file-pdf"></i>  PDF',
            title: function ( e, dt, node, config ) {
              return 'Reporte de Bajas.';
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 1,2,3,4,5,6,7,8],
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


    var Configuration_table_responsive_checkbox_move= {
            "order": [[ 1, "asc" ]],
            "select": true,
            "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
            "columnDefs": [
                { //Subida 1
                    "targets": 0,
                    "checkboxes": {
                      'selectRow': true
                    },
                    "width": "1%",
                },
                {
                    "targets": 4,
                    "className": "text-center",
                },
                { //option edit
                    "targets": 9,
                    "width": "1%",
                },
            ],
            "select": {
                'style': 'multi',
            },
            dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
                  "<'row'<'col-sm-12'tr>>" +
                  "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
              {
                extend: 'excelHtml5',
                text: '<i class="far fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
                title: function ( e, dt, node, config ) {
                  return 'Reporte de equipamiento.';
                },
                init: function(api, node, config) {
                   $(node).removeClass('btn-default')
                },
                exportOptions: {
                    columns: [ 1,2,3,4,5,6,7,8],
                    modifier: {
                        page: 'all',
                    }
                },
                className: 'btn btn-success btn-xs',
              },
              {
                extend: 'csvHtml5',
                text: '<i class="far fa-file-alt"></i> CSV',
                titleAttr: 'CSV',
                title: function ( e, dt, node, config ) {
                  return 'Reporte de equipamiento.';
                },
                init: function(api, node, config) {
                   $(node).removeClass('btn-default')
                },
                exportOptions: {
                    columns: [ 1,2,3,4,5,6,7,8],
                    modifier: {
                        page: 'all',
                    }
                },
                className: 'btn btn-info btn-xs',
              },
              {
                extend: 'pdf',
                text: '<i class="far fa-file-pdf"></i>  PDF',
                title: function ( e, dt, node, config ) {
                  return 'Reporte de equipamiento.';
                },
                init: function(api, node, config) {
                   $(node).removeClass('btn-default')
                },
                exportOptions: {
                    columns: [ 1,2,3,4,5,6,7,8],
                    modifier: {
                        page: 'all',
                    }
                },
                className: 'btn btn-danger btn-xs',
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
        var Configuration_table_responsive_remove_item= {
                "order": [[ 1, "asc" ]],
                "select": true,
                "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
                "columnDefs": [
                    {
                        "targets": 6,
                        "width": "1%",
                        "className": "text-center",
                    }
                ],
                dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
                      "<'row'<'col-sm-12'tr>>" +
                      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [
                  {
                    extend: 'excelHtml5',
                    text: '<i class="far fa-file-excel"></i> Excel',
                    titleAttr: 'Excel',
                    title: function ( e, dt, node, config ) {
                      return 'Reporte de bajas - ' + $('input[name="date_start"]').val() +' a '+$('input[name="date_end"]').val();
                    },
                    init: function(api, node, config) {
                       $(node).removeClass('btn-default')
                    },
                    exportOptions: {
                        modifier: {
                            page: 'all',
                        }
                    },
                    className: 'btn btn-success',
                  },
                  {
                    extend: 'csvHtml5',
                    text: '<i class="far fa-file-alt"></i> CSV',
                    titleAttr: 'CSV',
                    title: function ( e, dt, node, config ) {
                      return 'Reporte de bajas - ' + $('input[name="date_start"]').val() +' a '+$('input[name="date_end"]').val();
                    },
                    init: function(api, node, config) {
                       $(node).removeClass('btn-default')
                    },
                    exportOptions: {
                        modifier: {
                            page: 'all',
                        }
                    },
                    className: 'btn btn-info',
                  },
                  {
                    extend: 'pdf',
                    text: '<i class="far fa-file-pdf"></i>  PDF',
                    title: function ( e, dt, node, config ) {
                      return 'Reporte de bajas - ' + $('input[name="date_start"]').val() +' a '+$('input[name="date_end"]').val();
                    },
                    init: function(api, node, config) {
                       $(node).removeClass('btn-default')
                    },
                    exportOptions: {
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
        var Configuration_table_clear= {
              "order": [[ 0, "asc" ]],
              "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
              "columnDefs": [
                  {
                      "targets": 4,
                      "className": "text-center",
                      "width": "1%",
                  },
              ],
              Filter: false,
              searching: true,
              bInfo: false,
              "processing": true,
              "columnDefs": [
                    { //Subida 1
                        "targets": [3],
                        "visible": false,
                        "searchable": false
                    },
                    { //Bajada 1
                        "targets": [4],
                        "visible": false,
                        "searchable": false
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

        var Configuration_table_clearx2= {
              "order": [[ 0, "asc" ]],
              "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
              "columnDefs": [
                  {
                      "targets": 4,
                      "className": "text-center",
                      "width": "1%",
                  },
              ],
              Filter: false,
              searching: true,
              bInfo: false,
              "processing": true,
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
        function input_mac(name_d){
          $("#"+name_d).keyup(function(){
            this.value =
              (this.value.toUpperCase()
              .replace(/[^\d|A-Z]/g, '')
              .match(/.{1,2}/g) || [])
              .join(":")
        	});
        }
        function input_number(name_d){
          $('#'+name_d).on('input', function () {
              this.value = this.value.replace(/[^0-9]/g,'');
          });
        }
        var Configuration_table_responsive_asignacion_htype= {
                "order": [[ 1, "asc" ]],
                "select": true,
                "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
                "columnDefs": [
                    {
                        "targets": 1,
                        "width": "1%",
                        "className": "text-center",
                    },
                    {
                        "targets": 2,
                        "width": "1%",
                        "className": "text-center",
                    }
                ],
                dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
                      "<'row'<'col-sm-12'tr>>" +
                      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [
                  {
                    extend: 'excelHtml5',
                    text: '<i class="far fa-file-excel"></i> Excel',
                    titleAttr: 'Excel',
                    title: function ( e, dt, node, config ) {
                      return 'Asignación de hoteles';
                    },
                    init: function(api, node, config) {
                       $(node).removeClass('btn-default')
                    },
                    exportOptions: {
                        columns: [ 0,1 ],
                        modifier: {
                            page: 'all',
                        }
                    },
                    className: 'btn btn-success',
                  },
                  {
                    extend: 'csvHtml5',
                    text: '<i class="far fa-file-alt"></i> CSV',
                    titleAttr: 'CSV',
                    title: function ( e, dt, node, config ) {
                      return 'Asignación de hoteles';
                    },
                    init: function(api, node, config) {
                       $(node).removeClass('btn-default')
                    },
                    exportOptions: {
                        columns: [ 0,1],
                        modifier: {
                            page: 'all',
                        }
                    },
                    className: 'btn btn-info',
                  },
                  {
                    extend: 'pdf',
                    text: '<i class="far fa-file-pdf"></i>  PDF',
                    title: function ( e, dt, node, config ) {
                      return 'Asignación de hoteles';
                    },
                    init: function(api, node, config) {
                       $(node).removeClass('btn-default')
                    },
                    exportOptions: {
                        columns: [ 0, 1],
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

        var Configuration_table_responsive_viatic_zero= {
          "order": [[ 0, "desc" ]],
          "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
          "columnDefs": [
            {
                "targets": 0,
                "width": "1%",
                "className": "text-center",
            },
            {
                "targets": 1,
                "width": "4%",
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
                "width": "1%",
                "className": "text-center",
            },
            {
                "targets": 6,
                "width": "0.5%",
                "className": "text-center",
            },
            {
                "targets": 7,
                "width": "0.5%",
                "className": "text-center",
            },
            {
                "targets": 8,
                "width": "1%",
                "className": "text-center",
            }
          ],
          dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
                  "<'row'<'col-sm-12'tr>>" +
                  "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
              {
                extend: 'excelHtml5',
                text: '<i class="far fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
                title: function ( e, dt, node, config ) {
                  return 'Resumen de viáticos';
                },
                init: function(api, node, config) {
                    $(node).removeClass('btn-default')
                },
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6 ],
                    modifier: {
                        page: 'all',
                    }
                },
                className: 'btn bg-olive custombtntable',
              },
              {
                extend: 'csvHtml5',
                text: '<i class="far fa-file-alt"></i> CSV',
                titleAttr: 'CSV',
                title: function ( e, dt, node, config ) {
                  return 'Resumen de viáticos';
                },
                init: function(api, node, config) {
                    $(node).removeClass('btn-default')
                },
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6 ],
                    modifier: {
                        page: 'all',
                    }
                },
                className: 'btn btn-info',
              },
              {
                extend: 'pdf',
                text: '<i class="far fa-file-pdf"></i>  PDF',
                title: function ( e, dt, node, config ) {
                  return 'Resumen de viáticos';
                },
                init: function(api, node, config) {
                    $(node).removeClass('btn-default')
                },
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6 ],
                    modifier: {
                        page: 'all',
                    }
                },
                className: 'btn btn-danger',
              }
          ],
          "processing": true,
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
        };

        var Configuration_table_responsive_viatic_one= {
          "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
          "columnDefs": [
            {
                "targets": 0,
                "width": "1%",
                "className": "text-center",
            },
            {
                "targets": 1,
                "width": "3%",
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
                "width": "0.2%",
                "className": "text-center",
            },
            {
                "targets": 5,
                "width": "0.2%",
                "className": "text-center",
            },
            {
                "targets": 6,
                "width": "1%",
                "className": "text-center",
            },
            {
                "targets": 7,
                "width": "2%",
                "className": "text-center",
            },
            {
                "targets": 8,
                "width": "1%",
                "className": "text-center",
            }
          ],
          dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
                  "<'row'<'col-sm-12'tr>>" +
                  "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
              {
                extend: 'excelHtml5',
                text: '<i class="far fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
                title: function ( e, dt, node, config ) {
                  return 'Resumen de viáticos';
                },
                init: function(api, node, config) {
                    $(node).removeClass('btn-default')
                },
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6 ],
                    modifier: {
                        page: 'all',
                    }
                },
                className: 'btn bg-olive custombtntable',
              },
              {
                extend: 'csvHtml5',
                text: '<i class="far fa-file-alt"></i> CSV',
                titleAttr: 'CSV',
                title: function ( e, dt, node, config ) {
                  return 'Resumen de viáticos';
                },
                init: function(api, node, config) {
                    $(node).removeClass('btn-default')
                },
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6 ],
                    modifier: {
                        page: 'all',
                    }
                },
                className: 'btn btn-info',
              },
              {
                extend: 'pdf',
                text: '<i class="far fa-file-pdf"></i>  PDF',
                title: function ( e, dt, node, config ) {
                  return 'Resumen de viáticos';
                },
                init: function(api, node, config) {
                    $(node).removeClass('btn-default')
                },
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6 ],
                    modifier: {
                        page: 'all',
                    }
                },
                className: 'btn btn-danger',
              }
          ],
          "processing": true,
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
        };

        var Configuration_table_responsive_viatic_all= {
          "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
          "columnDefs": [
            {
                "targets": 0,
                "width": "1%",
                "className": "text-center",
            },
            {
                "targets": 1,
                "width": "3%",
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
                "width": "0.2%",
                "className": "text-center",
            },
            {
                "targets": 5,
                "width": "0.2%",
                "className": "text-center",
            },
            {
                "targets": 6,
                "width": "1%",
                "className": "text-center",
            },
            {
                "targets": 7,
                "width": "2%",
                "className": "text-center",
            },
            {
                "targets": 8,
                "width": "1%",
                "className": "text-center",
            }
          ],
          dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
                  "<'row'<'col-sm-12'tr>>" +
                  "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
              {
                extend: 'excelHtml5',
                text: '<i class="far fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
                title: function ( e, dt, node, config ) {
                  var ax = '';
                  if($('input[name="date_to_search"]').val() != ''){
                    ax= '- Periodo: ' + $('input[name="date_to_search"]').val();
                  }
                  else {
                    txx='- Periodo: ';
                    var fecha = new Date();
                    var ano = fecha.getFullYear();
                    var mes = fecha.getMonth()+1;
                    var fechita = ano+'-'+mes;
                    ax = txx+fechita;
                  }

                  return 'Todos los viáticos solicitados' + ax;
                },
                init: function(api, node, config) {
                    $(node).removeClass('btn-default')
                },
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6,7 ],
                    modifier: {
                        page: 'all',
                    }
                },
                className: 'btn bg-olive custombtntable',
              },
              {
                extend: 'csvHtml5',
                text: '<i class="far fa-file-alt"></i> CSV',
                titleAttr: 'CSV',
                title: function ( e, dt, node, config ) {
                  var ax = '';
                  if($('input[name="date_to_search"]').val() != ''){
                    ax= '- Periodo: ' + $('input[name="date_to_search"]').val();
                  }
                  else {
                    txx='- Periodo: ';
                    var fecha = new Date();
                    var ano = fecha.getFullYear();
                    var mes = fecha.getMonth()+1;
                    var fechita = ano+'-'+mes;
                    ax = txx+fechita;
                  }
                  return 'Todos los viáticos solicitados' + ax;
                },
                init: function(api, node, config) {
                    $(node).removeClass('btn-default')
                },
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6,7 ],
                    modifier: {
                        page: 'all',
                    }
                },
                className: 'btn btn-info',
              },
              {
                extend: 'pdf',
                text: '<i class="far fa-file-pdf"></i>  PDF',
                title: function ( e, dt, node, config ) {
                  var ax = '';
                  if($('input[name="date_to_search"]').val() != ''){
                    ax= '- Periodo: ' + $('input[name="date_to_search"]').val();
                  }
                  else {
                    txx='- Periodo: ';
                    var fecha = new Date();
                    var ano = fecha.getFullYear();
                    var mes = fecha.getMonth()+1;
                    var fechita = ano+'-'+mes;
                    ax = txx+fechita;
                  }

                  return 'Todos los viáticos solicitados' + ax;
                },
                init: function(api, node, config) {
                    $(node).removeClass('btn-default')
                },
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6,7 ],
                    modifier: {
                        page: 'all',
                    }
                },
                className: 'btn btn-danger',
              }
          ],
          "processing": true,
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
        };
        var Configuration_table_responsive_simple_concept={
              "order": [[ 0, "asc" ]],
              "columnDefs": [
                {
                    "targets": 0,
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": 1,
                    "width": "2%",
                    "className": "text-center",
                },
                {
                    "targets": 2,
                    "width": "2%",
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
              paging: false,
              //"pagingType": "simple",
              Filter: false,
              searching: false,
              //"aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
              //ordering: true,
              //"pageLength": 5,
              bInfo: false,
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
        }
