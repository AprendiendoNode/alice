graph_tickets('graph_tickets');

function graph_tickets(title) {
  var chart = document.getElementById(title);

     var myChart = echarts.init(chart);
     var group=[];
     var titles=[];
     var i=0;
     var rotar = 45;
     var tamanio = 12;

     var resizeMainContainer = function () {
       chart.style.width = '500px';
       chart.style.height = '300px';
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
          data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
          axisTick: {
              alignWithLabel: true
          },
          axisLabel : {
             show: true,
             interval: '0',
             //rotate: rotar,
             //fontSize: tamanio
          }
      },
      yAxis: {
          type: 'value'
      },
      series: [
          {
              name: 'Viáticos',
              type: 'line',
              data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
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
