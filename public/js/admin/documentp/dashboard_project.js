var _token = $('input[name="_token"]').val();

const headers = new Headers({
  "Accept": "application/json",
  "X-Requested-With": "XMLHttpRequest",
  "X-CSRF-TOKEN": _token
})

var initGet = { method: 'get',
                  headers: headers,
                  credentials: "same-origin",
                  cache: 'default' };

(function(){
  moment.locale('es');
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

  graph_atraso_proyectos();
  graph_atraso_motivos();
  graph_rentas_perdidas();
  graph_presupuesto_ejercido_prom();
  get_table_filterby_servicio();
  get_table_filterby_atrasos();
  get_calif_project();
  count_projects_instalation();
})()

function get_calif_project(){
  let total_rojo = document.getElementById('total_rojo').innerHTML;
  let total_amarillo = document.getElementById('total_amarillo').innerHTML;
  let total_verde = document.getElementById('total_verde').innerHTML;
  let total = parseInt(total_rojo) + parseInt(total_amarillo) + parseInt(total_verde)

  let calif = parseInt(total_verde) / total;
  calif *= 100;
  calif = parseInt(calif);
  document.getElementById('calif_projects').innerHTML = `${calif} %`;

  if(calif > 76){
    document.getElementById('calif_projects').style.color = "green";
  }else if(calif > 51  && calif < 76){
    document.getElementById('calif_projects').style.color = "#FFBE00";
  }else{
    document.getElementById('calif_projects').style.color = "red";
  }


}

function count_projects_instalation(){
  let total_rojo = document.getElementById('total_rojo').innerHTML;
  let total_amarillo = document.getElementById('total_amarillo').innerHTML;
  let total_verde = document.getElementById('total_verde').innerHTML;
  let total = parseInt(total_rojo) + parseInt(total_amarillo) + parseInt(total_verde)

  document.getElementById('total_project_instalation').innerHTML = total;
}

$('#select_tipo_servicio').on('change', function(){
  let tipo_servicio = document.getElementById('select_tipo_servicio').value;
  let atraso = document.getElementById('select_atraso').value;
  fetch(`/get_table_atraso_filterby_servicio/${tipo_servicio}/${atraso}`, initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        table_atrasos_filterby_servicio(data, $('#table_atrasos'));
      }
    })
    .catch(err => {
      console.log(err);
    })

})

$('#select_atraso').on('change', function(){
  let tipo_servicio = document.getElementById('select_tipo_servicio').value;
  let atraso = document.getElementById('select_atraso').value;
  fetch(`/get_table_atraso_filterby_servicio/${tipo_servicio}/${atraso}`, initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        table_atrasos_filterby_servicio(data, $('#table_atrasos'));
      }
    })
    .catch(err => {
      console.log(err);
    })

})

$('#select_motivo_atraso').on('change', function(){
  let motivo_atraso = document.getElementById('select_motivo_atraso').value;
  fetch(`/get_table_atraso_filterby_motivo/id/${motivo_atraso}`, initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        table_atrasos_filterby_motivo(data, $('#tabla_atraso_x_motivo'));
      }
    })
    .catch(err => {
      console.log(err);
    })
})

function get_table_filterby_servicio(){
  let tipo_servicio = document.getElementById('select_tipo_servicio').value;
  let atraso = document.getElementById('select_atraso').value;
  fetch(`/get_table_atraso_filterby_servicio/${tipo_servicio}/${atraso}`, initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        table_atrasos_filterby_servicio(data, $('#table_atrasos'));
      }
    })
    .catch(err => {
      console.log(err);
    })
}

function get_table_filterby_atrasos(){
  let motivo_atraso = document.getElementById('select_motivo_atraso').value;
  fetch(`/get_table_atraso_filterby_motivo/id/${motivo_atraso}`, initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        table_atrasos_filterby_motivo(data, $('#tabla_atraso_x_motivo'));
      }

    })
    .catch(err => {
      console.log(err);
    })
}

function table_atrasos_filterby_servicio(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_responsive_simple_two_asc);
    vartable.fnClearTable();
    datajson.forEach(key => {
      vartable.fnAddData([
        key.nombre_proyecto,
        key.tipo_servicio,
        key.atraso_compra,
        key.atraso_instalacion,
        key.itc,
        '<a target="_blank" href="/documentp_invoice/'+ key.id + '/ '+ key.documentp_cart_id +'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Imprimir" role="button"><span class="fas fa-file-pdf"></span></a>',
      ]);
    });

}
function table_atrasos_filterby_motivo(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_responsive_simple_two_asc);
    vartable.fnClearTable();
    datajson.forEach(key => {
      vartable.fnAddData([
        key.nombre_proyecto,
        key.motivo,
        key.atraso_compra,
        key.atraso_instalacion,
        key.itc,
        '<a target="_blank" href="/documentp_invoice/'+ key.id + '/ '+ key.documentp_cart_id +'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Imprimir" role="button"><span class="fas fa-file-pdf"></span></a>',
      ]);
    });

}

function graph_atraso_proyectos(){

  fetch('/get_delay_projects', initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        graph_barras_delay_projects('graphicAtrasos',data);
      }
    })
    .catch(err => {
      console.log(err);
    })
}

function graph_rentas_perdidas(){
  var data_count = [21,23,43,67,18];
  var data_name = ['Cliente Nuevo', 'Ampliación', 'Renovación', 'Venta', 'F & F'];

  fetch('/get_rentas_perdidas', initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){

        // data.forEach(key => {
        //     data_name.push(key.motivo);
        //     data_count.push({ value: key.cantidad, name: key.motivo + ' = ' + key.cantidad},);
        // })
        graph_barras_rentas_perdidas('graphicRentasDia',data_name, data_count);
      }

    })
    .catch(err => {
      console.log(err);
    })
}

function graph_atraso_motivos(){
  var data_count = [];
  var data_name = [];

  fetch('/get_delay_motives', initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){

        data.forEach(key => {
            data_name.push(key.motivo);
            data_count.push({ value: key.cantidad, name: key.motivo + ' = ' + key.cantidad},);
        })
        graph_barras_motives('graphicMotives',data_name, data_count);
      }

    })
    .catch(err => {
      console.log(err);
    })
}

function graph_rentas_perdidas(){
  var data_count = [];
  var data_name = ['Cliente Nuevo', 'Ampliación', 'Renovación', 'Venta', 'F & F'];

  fetch('/get_rentas_perdidas', initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        graph_barras_rentas_perdidas('graphicRentasDia',data_name, data);
      }

    })
    .catch(err => {
      console.log(err);
    })
}

function graph_presupuesto_ejercido_prom(){
  // var data_count = [];
  // var data_name = ['Cliente Nuevo', 'Ampliación', 'Renovación', 'Venta', 'F & F'];

  fetch('/get_presupuesto_ejercido_prom', initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        graph_barras_presupuesto('graphicPresupuestoEjercido',data);
      }

    })
    .catch(err => {
      console.log(err);
    })
}

function graph_barras_delay_projects(title, data) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
    },
    legend: {
        data: ['Compras', 'Instalación']
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
            data : ['Cliente Nuevo','Ampliación','Renovación','Venta','F & F'],
            axisTick: {
                alignWithLabel: true
            },
            axisLabel : {
               show:true,
               interval: 'auto',    // {number}
               margin: 10,
               rotate: 0,
               formatter: '{value}',
               textStyle: {
                  //  color: 'blue',
                   fontFamily: 'sans-serif',
                   fontSize: 10,
                   fontStyle: 'normal',
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
            name: 'Compras',
            type: 'bar',
            barGap: 0,
            itemStyle: {
              normal: {
                label : {
                    show: true,
                    position: 'top',
                    textStyle: {
                      color: '#000'
                    },
                },
              }
            },
            data: [data[0].atraso_compra, data[1].atraso_compra, data[2].atraso_compra, data[4].atraso_compra, data[5].atraso_compra]
        },
        {
            name: 'Instalación',
            type: 'bar',
            itemStyle: {
              normal: {
                label : {
                    show: true,
                    position: 'top',
                    textStyle: {
                      color: '#000'
                    }
                },

              }
            },
            data: [data[0].atraso_instalacion, data[1].atraso_instalacion, data[2].atraso_instalacion, data[4].atraso_instalacion, data[5].atraso_instalacion]
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

function graph_barras_motives(title, campoa, campob) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {

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
               margin: 10,
               rotate: 20,
               formatter: '{value}',
               textStyle: {
                  //  color: 'blue',
                   fontFamily: 'sans-serif',
                   fontSize: 10,
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
            name:'',
            type:'bar',
            position: 'top',
            barWidth: '60%',
            data:campob,
            itemStyle: {
              normal: {
                  label : {
                      show: true,
                      position: 'top',
                      textStyle: {
                        color: '#000'
                      },
                  },
                  color: function(params) {
                      var colorList = [
                        '#DD4B39','#00C0EF', '#605CA8', '#FF851B',
                        '#00A65A','#C1232B','#B5C334','#FCCE10',
                        '#DD4B39','#00C0EF','#605CA8', '#FF851B'
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

function graph_barras_rentas_perdidas(title, campoa, data) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    title: {
       text: '',
       subtext: '',
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
    legend: {
        data: ['Cliente','Equipo','Comercial', 'Acceso', 'Material', 'Otros']
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
               margin: 10,
               rotate: 0,
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
            name:'',
            type:'bar',
            position: 'top',
            barWidth: '60%',
            data: [data[1].renta_perdida,
                   data[0].renta_perdida,
                   data[4].renta_perdida,
                   data[5].renta_perdida,
                   data[2].renta_perdida],
            itemStyle: {
              normal: {
                  label : {
                      show: true,
                      position: 'top',
                      textStyle: {
                        color: '#000'
                      },
                  },
                  color: function(params) {
                      // build a color map as your need.
                      var colorList = [
                          '#D7504B','#27727B','#FAD860','#F0805A','#26C0C0',
                          '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD'
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

function graph_barras_presupuesto(title, data) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
    },
    legend: {
        data: ['% Presupuesto ejercido', '% Instalado']
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
            data : ['Cliente Nuevo','Ampliación','Renovación','Venta','F & F'],
            axisTick: {
                alignWithLabel: true
            },
            axisLabel : {
               show:true,
               interval: 'auto',    // {number}
               margin: 10,
               formatter: '{value}',
               textStyle: {
                  //  color: 'blue',
                   fontFamily: 'sans-serif',
                   fontSize: 10,
                   fontStyle: 'normal',
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
            name: '% Presupuesto ejercido',
            type: 'bar',
            barGap: 0,
            itemStyle: {
              normal: {
                label : {
                    show: true,
                    position: 'top',
                    textStyle: {
                      color: '#000'
                    },
                },
              }
            },
            data: [data[1].presupuesto_prom, data[0].presupuesto_prom, data[4].presupuesto_prom, data[5].presupuesto_prom, data[2].presupuesto_prom]
        },
        {
            name: '% Instalado',
            type: 'bar',
            itemStyle: {
              normal: {
                label : {
                    show: true,
                    position: 'top',
                    textStyle: {
                      color: '#000'
                    }
                },

              }
            },
            data: [data[1].instalacion_prom, data[0].instalacion_prom, data[4].instalacion_prom, data[5].instalacion_prom, data[2].instalacion_prom]
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
