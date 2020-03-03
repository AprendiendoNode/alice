graph_equipments_status('graph_garantia','');


function graph_equipments_status(title,data) {
  //$('#'+title).width($('#'+title).width());
  //$('#'+title).height($('#'+title).height());
  //console.log('entra');
 var chart = document.getElementById(title);
  var resizeMainContainer = function () {
   chart.style.width = 520+'px';
   chart.style.height = 320+'px';
 };
  resizeMainContainer();
    var myChart = echarts.init(chart);
    var group=[];
    var titles=[];
    var i=0;


    option = {
        title: {
            text: '',
            subtext: ''
        },
        color: ['#00BFF3','#EF5BA1','#FFDE40','#474B4F','#ff5400','#4dd60d','#096dc9','#f90000'],
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        legend: {
            data: [ 'Promedio Mensual']
        },
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
            data: ['Antena', 'Icomera Gateway', 'Laptop', 'Regulador', 'Sonda', 'Sonic Wall','SW','UPS','Zequenze']
        },
        series: [
            {
                name: 'Promedio Mensual',
                type: 'bar',
                data: [10, 0,0,1,0,0,0,0,0]
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
