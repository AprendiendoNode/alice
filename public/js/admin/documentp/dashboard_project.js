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

$('#date_to_search').datepicker({
  language: 'es',
  format: "yyyy-mm-dd",
  viewMode: "months",
  minViewMode: "months",
  endDate: '0m',
  autoclose: true,
  clearBtn: true
}).datepicker("setDate",'now');

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

  // graph_atraso_proyectos_ejecucion();
  // graph_atraso_proyectos_instalado();
  // graph_atraso_motivos_ejecucion();
  // graph_atraso_motivos_instalado();
  // graph_rentas_perdidas();
  // graph_rentas_perdidas_instalado();
  // graph_presupuesto_ejercido_prom();
  // get_table_filterby_servicio();
  // get_table_filterby_servicio_instalado()
  // get_table_filterby_atrasos();
  // get_table_filterby_atrasos_instalados();
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
  graph_gauge_hotel('main_nps', 'NPS', '0', '100', calif);
/*  document.getElementById('calif_projects').innerHTML = `${calif} %`;

  if(calif > 76){
    document.getElementById('calif_projects').style.color = "green";
  }else if(calif > 51  && calif < 76){
    document.getElementById('calif_projects').style.color = "#FFBE00";
  }else{
    document.getElementById('calif_projects').style.color = "red";
  }
*/

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

$('#select_tipo_servicio_instalado').on('change', function(){
  let tipo_servicio = document.getElementById('select_tipo_servicio_instalado').value;
  let atraso = document.getElementById('select_atraso_instalado').value;
  fetch(`/get_table_atraso_filterby_servicio_instalado/${tipo_servicio}/${atraso}`, initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        table_atrasos_filterby_servicio_instalado(data, $('#table_atrasos_instalado'));
      }
    })
    .catch(err => {
      console.log(err);
    })

})

$('#select_atraso_instalado').on('change', function(){
  let tipo_servicio = document.getElementById('select_tipo_servicio_instalado').value;
  let atraso = document.getElementById('select_atraso_instalado').value;
  fetch(`/get_table_atraso_filterby_servicio_instalado/${tipo_servicio}/${atraso}`, initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        table_atrasos_filterby_servicio_instalado(data, $('#table_atrasos_instalado'));
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

$('#select_motivo_atraso_instalado').on('change', function(){
  let motivo_atraso = document.getElementById('select_motivo_atraso_instalado').value;
  fetch(`/get_table_atraso_filterby_motivo_instalado/id/${motivo_atraso}`, initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        table_atrasos_filterby_motivo(data, $('#tabla_atraso_x_motivo_instalado'));
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

function get_table_filterby_servicio_instalado(){
  let tipo_servicio = document.getElementById('select_tipo_servicio').value;
  let atraso = document.getElementById('select_atraso').value;
  fetch(`/get_table_atraso_filterby_servicio_instalado/${tipo_servicio}/${atraso}`, initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        table_atrasos_filterby_servicio_instalado(data, $('#table_atrasos_instalado'));
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

function get_table_filterby_atrasos_instalados(){
  let motivo_atraso = document.getElementById('select_motivo_atraso').value;
  fetch(`/get_table_atraso_filterby_motivo_instalado/id/${motivo_atraso}`, initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        table_atrasos_filterby_motivo_instalado(data, $('#tabla_atraso_x_motivo_instalado'));
      }

    })
    .catch(err => {
      console.log(err);
    })
}


function table_atrasos_filterby_servicio(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_responsive_documentp);
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

function table_atrasos_filterby_servicio_instalado(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_responsive_documentp);
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
    var vartable = table.dataTable(Configuration_table_responsive_documentp);
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

function table_atrasos_filterby_motivo_instalado(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_responsive_documentp);
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

function graph_atraso_proyectos_ejecucion(){

  fetch('/get_delay_projects_ejecucion', initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        graph_barras_delay_projects_ejecucion('graphicAtrasos',data);
      }
    })
    .catch(err => {
      console.log(err);
    })
}

function graph_atraso_proyectos_instalado(){

  fetch('/get_delay_projects_instalado', initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        graph_barras_delay_projects_instalado('graphicAtrasosInstalado',data);
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

function graph_atraso_motivos_ejecucion(){
  var data_count = [];
  var data_name = [];

  fetch('/get_delay_motives_ejecucion', initGet)
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

function graph_atraso_motivos_instalado(){
  var data_count = [];
  var data_name = [];

  fetch('/get_delay_motives_instalado', initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){

        data.forEach(key => {
            data_name.push(key.motivo);
            data_count.push({ value: key.cantidad, name: key.motivo + ' = ' + key.cantidad},);
        })
        graph_barras_motives_instalado('graphicMotivesInstalado',data_name, data_count);
      }

    })
    .catch(err => {
      console.log(err);
    })
}

function graph_rentas_perdidas(){
  var data_count = [];
  var data_name = [];

  fetch('/get_rentas_perdidas', initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        let data_filter = data.filter(m => m.servicio != 'Mantenimiento' && m.servicio != 'Venta' && m.servicio != 'F & F');
        data_filter.forEach(key => {
            data_name.push(key.servicio);
            data_count.push(parseFloat(key.renta_perdida));
        })
        console.log(data_count);
        graph_barras_rentas_perdidas('graphicRentasDia',data_name, data_count);
      }

    })
    .catch(err => {
      console.log(err);
    })
}

function graph_rentas_perdidas_instalado(){
  var data_count = [];
  var data_name = [];

  fetch('/get_rentas_perdidas_instalado', initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      if(data != []){
        let data_filter = data.filter(m => m.servicio != 'Mantenimiento' && m.servicio != 'Venta' && m.servicio != 'F & F');
        data_filter.forEach(key => {
            data_name.push(key.servicio);
            data_count.push(parseFloat(key.renta_perdida));
        })

        graph_barras_rentas_perdidas_instalado('graphicRentasDiaInstalados',data_name, data_count);
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

function graph_barras_delay_projects_ejecucion(title, data) {
  var myChart = echarts.init(document.getElementById(title));

  var option = {
      title: {
         text: '',
         subtext: 'PROYECTOS EN EJECUCIÓN',
         subtextStyle: {
          color: '#003366',
          fontStyle: 'normal',
          fontWeight: 'normal',
          fontFamily: 'sans-serif',
          fontSize: 10,
          align: 'left',
          margin:10,
          verticalAlign: 'bottom',
          width: '100%'
        },
    },
    color: ['#28573D', '#00A34A', '#4cabce', '#e5323e'],
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
            data : ['Cliente Nuevo','Ampliación','Renovación'],
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
                   fontSize: 11,
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
            data: [data[0].atraso_compra, data[1].atraso_compra, data[2].atraso_compra]
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
            data: [data[0].atraso_instalacion, data[1].atraso_instalacion, data[2].atraso_instalacion]
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

function graph_barras_delay_projects_instalado(title, data) {
  var myChart = echarts.init(document.getElementById(title));

  var option = {
      title: {
         text: '',
         subtext: 'PROYECTOS INSTALADOS',
         subtextStyle: {
          color: '#003366',
          fontStyle: 'normal',
          fontWeight: 'normal',
          fontFamily: 'sans-serif',
          fontSize: 10,
          align: 'left',
          verticalAlign: 'top',
          width: '100%'
        },
    },
    color: ['#003366', '#006699', '#4cabce', '#e5323e'],
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
            data : ['Cliente Nuevo','Ampliación','Renovación'],
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
                   fontSize: 11,
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
            data: [data[0].atraso_compra, data[1].atraso_compra, data[2].atraso_compra]
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
            data: [data[0].atraso_instalacion, data[1].atraso_instalacion, data[2].atraso_instalacion]
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
    title: {
       text: '',
       subtext: 'PROYECTOS EN EJECUCIÓN',
       subtextStyle: {
        color: '#003366',
        fontStyle: 'normal',
        fontWeight: 'normal',
        fontFamily: 'sans-serif',
        fontSize: 10,
        align: 'left',
        margin:10,
        verticalAlign: 'bottom',
        width: '100%'
      },
    },
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
               rotate: 30,
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
                        '#00A34A'
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

function graph_barras_motives_instalado(title, campoa, campob) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    title: {
       text: '',
       subtext: 'PROYECTOS INSTALADOS',
       subtextStyle: {
        color: '#003366',
        fontStyle: 'normal',
        fontWeight: 'normal',
        fontFamily: 'sans-serif',
        fontSize: 10,
        align: 'left',
        margin:10,
        verticalAlign: 'bottom',
        width: '100%'
      },
    },
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
               rotate: 30,
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
                        '#003366'
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
       subtext: 'PROYECTOS EN EJECUCIÓN',
       textStyle: {
        color: '#003366',
        fontStyle: 'normal',
        fontWeight: 'normal',
        fontFamily: 'sans-serif',
        fontSize: 12,
        align: 'left',
        verticalAlign: 'top',
        width: '100%',
        textBorderColor: 'transparent',
        textBorderWidth: 0,
        textShadowColor: 'transparent'
      },
   },
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
        left: '1%',
        right: '1%',
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
                   fontSize: 11,
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
            data: data,
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
                          '#28573D'
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

function graph_barras_rentas_perdidas_instalado(title, campoa, data) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    title: {
       text: '',
       subtext: 'PROYECTOS INSTALADOS',
       textStyle: {
        color: '#003366',
        fontStyle: 'normal',
        fontWeight: 'normal',
        fontFamily: 'sans-serif',
        fontSize: 12,
        align: 'left',
        verticalAlign: 'top',
        width: '100%',
        textBorderColor: 'transparent',
        textBorderWidth: 0,
        textShadowColor: 'transparent'
      },
   },
    color: ['#003366'],
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
        left: '1%',
        right: '1%',
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
                   fontSize: 11,
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
            data: data,
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
                          '#003366'
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
    title: {
       text: '',
       subtext: 'PROYECTOS EN EJECUCIÓN',
       subtextStyle: {
        color: '#003366',
        fontStyle: 'normal',
        fontWeight: 'normal',
        fontFamily: 'sans-serif',
        fontSize: 10,
        align: 'left',
        verticalAlign: 'top',
        width: '100%'
      },
    },
    color: ['#28573D', '#00A34A', '#4cabce', '#e5323e'],
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


var Configuration_table_responsive_documentp= {
        "order": [[ 0, "asc" ]],
        "select": true,
        "aLengthMenu": [[5, 0, 0, -1], [5, 10, 25, "All"]],
        "columnDefs": [
            {
                "targets": 0,
                "width": "1.5%",
                "className": "text-left",
            },
            {
              "targets": 1,
              "width": "1%",
              "className": "text-center",
            },
            {
              "targets": 2,
              "width": "0.3%",
              "className": "text-center",
            },
            {
              "targets": 3,
              "width": "0.3%",
              "className": "text-center",
            },
            {
              "targets": 4,
              "width": "1.2%",
              "className": "text-center",
            },
            {
              "targets": 5,
              "width": "0.5%",
              "className": "text-center",
            }
        ],
        language:{
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible",
            "sInfo":           " _START_ - _END_ de un total de _TOTAL_ registros",
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
    };

    var Configuration_table_documentp_xstatus= {
            "order": [[ 1, "asc" ]],
            "select": true,
            "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
            "fnDrawCallback": function() {
              var source_colors = [{'value': 1, 'text': 'R'}, {'value': 2, 'text': 'A'}, {'value': 3, 'text': 'V'}, {'value': 4, 'text': 'B'}];
              var source_factura = [{'value': 0, 'text': 'No'}, {'value': 1, 'text': 'Si'}, {'value': 2, 'text': 'En proceso'}];

              /*$('.set-alert').editable({
                  type : '',
                  inputclass:'text-danger',
                  source: function() {
                  return source_colors;
                },
                success: function(response, newValue) {
                }
              });*/

              /*$('.set-facturacion').editable({
                  type : 'select',
                  source: function() {
                  return source_factura;
                },
                success: function(response, newValue) {
                  var id = $(this).data('pk');
                  console.log(newValue);
                  //setStatusFactura(id, newValue);
                }
              });*/

              /*$('.set-servmensual').editable({
                  type : 'text',
                  source: function() {
                  return source;
                },
                success: function(response, newValue) {
                  var id = $(this).data('pk');
                  //setServicioMensual(id, newValue);
                }
              });*/

            },
            "columnDefs": [
                {
                  "targets": 0,
                  "width": "0.5%",
                  "className": "text-center cell-large",
                  "visible": false
                },
                {
                  "targets": 1,
                  "width": "2.5%",
                  "className": "text-center status",
                },
                {
                  "targets": 2,
                  "width": "0.5%",
                  "className": "text-center",
                },
                {
                  "targets": 3,
                  "width": "0.2%",
                  "className": "text-center",
                },
                {
                  "targets": 4,
                  "width": "0.5%",
                  "className": "text-center",
                },
                {
                  "targets": 5,
                  "width": "0.5%",
                  "className": "text-center",
                },
                {
                  "targets": 6,
                  "width": "1%",
                  "className": "text-center",
                },
                {
                  "targets": 7,
                  "width": "1%",
                  "className": "text-center",
                },
                {
                  "targets": 8,
                  "width": "0.1%",
                  "className": "text-center",
                },
                {
                  "targets": 9,
                  "width": "0.1%",
                  "className": "text-center",
                },
                {
                  "targets": 10,
                  "width": "2%",
                  "className": "text-center",
                },
                {
                  "targets": 11,
                  "width": "2%",
                  "className": "text-center",
                },
                {
                  "targets": 12,
                  "width": "1%",
                  "className": "text-center ",
                },
                {
                  "targets": 13,
                  "width": "1%",
                  "className": "text-center cell-name",
                },
                {
                  "targets": 14,
                  "width": "1%",
                  "className": "text-center",
                },
                {
                  "targets": 15,
                  "width": "1%",
                  "className": "text-center",
                  "visible": false
                },
                {
                  "targets": 16,
                  "width": "1%",
                  "className": "text-center ",
                  "visible":  false
                },
                {
                  "targets": 17,
                  "width": "1%",
                  "className": "text-center",
                  "visible": false
                },
                {
                  "targets": 18,
                  "width": "1%",
                  "className": "text-center",
                  "visible": false
                },
                {
                  "targets": 19,
                  "width": "1%",
                  "className": "text-center",
                  "visible": false
                },
                /*{
                  "targets": 20,
                  "width": "1%",
                  "className": "text-center",
                  "visible": false
                }*/

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
                  return 'Avance de proyectos ';
                },
                init: function(api, node, config) {
                   $(node).removeClass('btn-default')
                },
                exportOptions: {
                    columns: [ 1,2,3,4,5,6,7,8,9,10,11,13,17,18,19,15 ],
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
                  return 'Avance de proyectos ';
                },
                init: function(api, node, config) {
                   $(node).removeClass('btn-default')
                },
                exportOptions: {
                    columns: [ 1,2,3,4,5,6,7,8,9,10,11,13,17,18,19,15 ],
                    modifier: {
                        page: 'all',
                    }
                },
                className: 'btn btn-info',
              },
              {
                extend: 'pdf',
                orientation: 'landscape',
                text: '<i class="fa fa-file-pdf-o"></i>  PDF',
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
                  return 'Avance de proyectos ';
                },
                init: function(api, node, config) {
                   $(node).removeClass('btn-default')
                },
                exportOptions: {
                    columns: [ 1,2,3,4,5,6,7,8,9,10,11,13,17,18,19,15 ],
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

    function documentp_table(datajson, table){
      table.DataTable().destroy();
      var vartable = table.dataTable(Configuration_table_documentp_xstatus);
      vartable.fnClearTable();
      let datajson_result = datajson.filter(data => data.status != 'Denegado' && data.alert != 4);
      let color = 'red';
      $.each(datajson_result, function(index, data){


        if(data.alert == 1){
          color = 'red';
        }else if(data.alert == 2) {
          color = 'yellow';
        }else if(data.alert == 3){
          color = 'green';
        }else{
          color = 'blue';
        }

        /*if(alert!=1){
        setAlert(id, 1);
      }*/
        vartable.fnAddData([
          `<div class="btn-group">
           <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fas fa-ellipsis-h"></i>
           </button>
           <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
               <a class="dropdown-item" href="javascript:void(0);" onclick="addCommentModal(this)" data-id="${data.id}" value="${data.id}"><i class="fas fa-comment-alt"></i> Añadir comentario</a>
               <a class="dropdown-item" href="javascript:void(0);" onclick="enviar(this)" data-id="${data.id}"  data-cart="${data.documentp_cart_id}" value="${data.id}"><i class="fas fa-shopping-cart"></i> Ver productos</a>
               <a class="dropdown-item" href="javascript:void(0);" onclick="uploadActaEntrega(this)" data-id="${data.id}" value="${data.id}"><i class="fas fa-upload"></i> Subir acta de entrega</a>
               <a class="dropdown-item" target="_blank" href="/documentp_invoice/${data.id}/${data.documentp_cart_id}"><span class="far fa-file-pdf"></span> Imprimir productos</a>
           </div>
         </div>`,
          '<a href="javascript:void(0)" style="background-color:' + color +';" data-type="select" data-pk="'+ data.id +'" data-title="Estatus" data-value="' + data.alert + '" class="set-alert"></a>',
          data.nombre_proyecto,
          isOverdue(data.total_global,data.fecha_inicio),//'<span class="badge badge-dark badge-pill">'+Math.floor(data.total_global)+'%</span>',
          invertirFecha(data.fecha_inicio),
          invertirFecha(data.fecha_fin),
          //invertirFecha(data.fecha_terminacion_real),
          '$' + data.total_usd.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
          isOverdue(data.presupuesto.slice(0,-1),data.fecha_entrega_ea),//'<span class="badge badge-success badge-pill">'+Math.floor(data.presupuesto.slice(0,-1))+'%</span>',
          data.fecha_entrega_ea,
          data.atraso,
          data.motivo,
          //invertirFecha(data.fecha_firma),
          data.atraso_instalacion,
          data.servicio,
          data.servicio_mensual,
          data.itc,
          '<a href="javascript:void(0)" data-type="select" data-pk="'+ data.id +'" data-title="Estatus" data-value="' + data.facturando + '" class="set-facturacion">',
          //invertirFecha(data.updated_at.split(" ")[0])+" "+ data.updated_at.split(" ")[1],
          data.alert,
          data.comentario,
          data.servicio_mensual,
          data.facturando
          ]);
            //console.log(data.fecha_inicio);
      });
      //Esconde la columna facturacion si el ID no es el de Sandra
      /*if (user_id!=21) { //21
        var column = vartable.api().columns(15);
        column.visible(!column.visible());
      }*/
    }

    function isOverdue(num,date){
    if(date!='-'){
      var current_date= new Date().toISOString().slice(0,10);
      var limit_date= new Date(date).toISOString().slice(0,10);
      switch (current_date<limit_date) {
        case true:
              return '<span class="badge badge-success badge-pill">'+Math.floor(num)+'%</span>';
          break;
        case false:
              return '<span class="badge badge-danger badge-pill">'+Math.floor(num)+'%</span>';
          break;
        default:
      }
    }else{
        return '<span class="badge badge-danger badge-pill">'+Math.floor(num)+'%</span>';
    }

    }

  //Formatea la fecha dd/mm/aaaa
      function invertirFecha(f) {
         var fechaDividida = f.split("-");
         var fechaInvertida = fechaDividida.reverse();
         return fechaInvertida.join("-");
     }

    $('#red').on('click',function(){
    var _token = $('input[name="_token"]').val();

      $.ajax({
      type:"POST",
      url:"/get_documentp_project_xstatus",
      data:{_token:_token,id_alert:1},
      success:function(data){
        //console.log(data);
        $('#modal_project_xstatus').modal('show');
        documentp_table(data,$('#table_documentp'));
      },
      error:function(data){

      }
      });

    });

    $('#yellow').on('click',function(){
    var _token = $('input[name="_token"]').val();

      $.ajax({
      type:"POST",
      url:"/get_documentp_project_xstatus",
      data:{_token:_token,id_alert:2},
      success:function(data){
        //console.log(data);
        $('#modal_project_xstatus').modal('show');
        documentp_table(data,$('#table_documentp'));
      },
      error:function(data){

      }
      });

    });

    $('#green').on('click',function(){
    var _token = $('input[name="_token"]').val();

      $.ajax({
      type:"POST",
      url:"/get_documentp_project_xstatus",
      data:{_token:_token,id_alert:3},
      success:function(data){
        //console.log(data);
        $('#modal_project_xstatus').modal('show');
        documentp_table(data,$('#table_documentp'));
      },
      error:function(data){

      }
      });

    });

    $('#blue').on('click',function(){
    var _token = $('input[name="_token"]').val();

      $.ajax({
      type:"POST",
      url:"/get_documentp_project_xstatus",
      data:{_token:_token,id_alert:4},
      success:function(data){
        //console.log(data);
        $('#modal_project_xstatus').modal('show');
        documentp_table(data,$('#table_documentp'));
      },
      error:function(data){
        console.log(data);
      }
      });

    });

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

    $('#date_to_search').on('change',function(){
      console.log('funciona');
    });
