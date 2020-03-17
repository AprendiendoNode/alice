$(document).ready(function(){
  const startOfMonth = moment().startOf('month').format('YYYY/MM/DD');
  //const endOfMonth   = moment().endOf('month').format('DD/MM/YYYY');
  $('#start').val(startOfMonth);
  //$('#end').val(endOfMonth);
  $("#start").datepicker({
    language: 'es',
     //rtl: isRtl,
     format: 'yyyy-mm-dd',
     //orientation: "bottom left",
     autoclose: true,
     clearBtn:true,
  }).datepicker('update');//.datepicker("setDate",'now');
  busqueda();
//$('.btnGenerar').click();
});


$('.btnGenerar').on('click',function(){
busqueda();
});
//-Contract Not Venue ----------------------------------------------------------
function busqueda() {
  var fecha=$('#start').val();
  var _token = $('input[name="_token"]').val();
  //Vigentes por vencer
  $.ajax({
    type: "POST",
    url: "/vigencia_contratos_12meses",
    data: {_token:_token,start:fecha},
    success: function (data){
      fill_table_notvenue(data, $("#all_notvenue"));
    },
    error: function (err) {
      Swal.fire({
          type: 'error',
          title: 'Oops...',
          text: err.statusText,
        });
    }
  });
//Vencidos

$.ajax({
  type: "POST",
  url: "/vigencia_contratos_vencidos_12meses",
  data: {_token:_token,start:fecha},
  success: function (data){
    fill_table_notvenue_vencidos(data, $("#all_notvenue_vencidos"));
  },
  error: function (err) {
    Swal.fire({
        type: 'error',
        title: 'Oops...',
        text: err.statusText,
      });
  }
});

}


var doceMt=0,onceMt=0,seisMt=0;
function fill_table_notvenue(datajson, table){
  doceMt=0,onceMt=0,seisMt=0;
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_payment_tracking);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, information){
    var aa = '<a href="javascript:void(0);" onclick="getInvoiceContract(this)" data-file="' + information.file + '" class="btn btn-sm " style="background-color:#e32916; color:white;" role="button"><i class="fas fa-cloud-download-alt" aria-hidden="true"></i> Descargar..</a>';
    var ab = '<a href="javascript:void(0);" onclick="getInfoContract(this)" value="' + information.contract_master_id + '" class="btn btn-sm" style="background-color:#2c3e50; color:white;" role="button"><span class="fas fa-info-circle"></span>Contratos anexos</a>';
    var ac = aa + ab;
    vartable.fnAddData([
      '<div class="text-center"><span class="badge  text-white" style="background-color:#11cd3b">Vigente</span></div>',
      information.cadena,
      information.vertical,
      information.classifications,
      information.key_annexes,
      //information.key_master,
      information.itc,
      information.date_scheduled_end,
      verify_status(information.vencido_xvencer), //ff5400
      //ac
    ]);
  });
var cantidades=[{name: '+12 Meses',type: 'bar',label: {normal: {show: true,position: 'inside'}},data: [doceMt]},
                {name: '7-11 Meses',type: 'bar',label: {normal: {show: true,position: 'inside'}},data: [onceMt]},
                {name: '-6 Meses',type: 'bar',label: {normal: {show: true,position: 'inside'}},data: [seisMt]}]
//var data=[{},{},{},{},{}]; //Necesario para evitar errores cuando es vacio.
var color=['#11cd3b','#ff5400','#e92e29','#FFDE40','#4dd60d','#00BFF3','#096dc9','#f90000'];
graph_tickets_type('graph_vigentes',cantidades,'Contratos vigentes',color);
}

var ven_doceMt=0,ven_onceMt=0,ven_seisMt=0;
function fill_table_notvenue_vencidos(datajson, table){
  ven_doceMt=0,ven_onceMt=0,ven_seisMt=0;
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_payment_tracking);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, information){

    vartable.fnAddData([
      '<div class="text-center"><span class="badge  text-white" style="background-color:#ff0000">Vencido</span></div>',
      information.cadena,
      information.vertical,
      information.classifications,
      information.key_annexes,
      //information.key_master,
      information.itc,
      information.date_scheduled_end,
      verify_status_vencido(information.meses_vencido)
      //'<div class="text-center"><span class="badge badge-pill text-white" style="background-color:#ff0000">'++'</span></div>'
      //ac
    ]);



  });
var cantidades=[{name: '+12 Meses',type: 'bar',label: {normal: {show: true,position: 'inside'}},data: [ven_doceMt]},
                {name: '7-11 Meses',type: 'bar',label: {normal: {show: true,position: 'inside'}},data: [ven_onceMt]},
                {name: '-6 Meses',type: 'bar',label: {normal: {show: true,position: 'inside'}},data: [ven_seisMt]}]
//var data=[{},{},{},{},{}]; //Necesario para evitar errores cuando es vacio.
var color=['#e92e29','#ff5400','#f1c40f','#32312f','#4dd60d','#00BFF3','#096dc9','#f90000'];
graph_tickets_type('graph_vencidos',cantidades,'Contratos vencidos',color);
}

function verify_status(num){
  //return "";
  switch(true){
      case (num<=6):
      seisMt++;
      return '<div class="text-center"><span class="badge badge-pill text-white" style="background-color:#ff0000">'+num+'</span></div>';
      break;
      case (num<=11 && num>6):
      onceMt++;
      return '<div class="text-center"><span class="badge badge-pill text-white" style="background-color:#ff5400">'+num+'</span></div>';
      break;
      case (num>11):
      doceMt++;
      return '<div class="text-center"><span class="badge badge-pill text-white" style="background-color:#11cd3b">'+num+'</span></div>';
      break;
  }
}

function verify_status_vencido(num){
  //return "";
  switch(true){
      case (num<=6):
      ven_seisMt++;
      return '<div class="text-center"><span class="badge badge-pill text-white" style="background-color:#f1c40f">'+num+'</span></div>';
      break;
      case (num<=11 && num>6):
      ven_onceMt++;
      return '<div class="text-center"><span class="badge badge-pill text-white" style="background-color:#ff5400">'+num+'</span></div>';
      break;
      case (num>11):
      ven_doceMt++;
      return '<div class="text-center"><span class="badge badge-pill text-white" style="background-color:#e92e29">'+num+'</span></div>';
      break;
  }
}


function graph_tickets_type(title,data,graph_title,color) {
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
            text: graph_title,
            x:'center'
        },
        legend: {
            data: ['+12 Meses','7-11 Meses','-6 Meses'],
            orient: 'horizontal',
            right: 0,
            top: 23,
            bottom: 30,

        },
        //color: ['#00BFF3','#EF5BA1','#FFDE40','#474B4F','#ff5400','#4dd60d','#096dc9','#f90000'],
        color: color,
        toolbox: {},
        tooltip: {},
        xAxis: {type: 'category'},
        yAxis: {},
        series:data,
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


//-Contract Venue --------------------------------------------------------------
function busqueda_dos() {
  var form = $('#search')[0];
  var formData = new FormData(form);
  $.ajax({
    type: "POST",
    url: "/contract_expiration_venue",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data){
      fill_table_venue(data, $("#all_venue"));
    },
    error: function (err) {
      Swal.fire({
          type: 'error',
          title: 'Oops...',
          text: err.statusText,
        });
    }
  });
}
function fill_table_venue(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_payment_tracking);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, information){
    var aa = '<a href="javascript:void(0);" onclick="getInvoiceContract(this)" data-file="' + information.file + '" class="btn btn-info btn-sm" role="button"><i class="fas fa-cloud-download-alt" aria-hidden="true"></i> Descargar..</a>';
    var ab = '<a href="javascript:void(0);" onclick="getInfoContract(this)" value="' + information.contract_master_id + '" class="btn btn-success  btn-sm" role="button"><i class="fas fa-info-circle" aria-hidden="true"></i> Contratos anexos..</a>';
    var ac = aa + ab;
    vartable.fnAddData([
      (index+1),
      information.key_annexes,
      information.classifications,
      information.vertical,
      information.cadena,
      information.key_master,
      information.itc,
      information.date_scheduled_end,
      ac
    ]);
  });
}

var Configuration_table_payment_tracking = {
  paging: true,
  //"pagingType": "simple",
  Filter: true,
  searching: true,
  "aLengthMenu": [[5, 10, 25,-1], [ 5, 10, 25,"Todos"]],
  ordering: true,
  //"pageLength": 5,
  bInfo: true,
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

function getInvoiceContract(ev){
 var token = $('input[name="_token"]').val();
 var file =  $(ev).data('file');
 $.ajax({
   type: "POST",
   url: "/downloadInvoiceContract",
   data: { file : file , _token : token },
   xhrFields: {responseType: 'blob'},
   success: function(response, status, xhr){
     console.log(response);
     if(response !== '[object Blob]'){
     var filename = "";
     var disposition = xhr.getResponseHeader('Content-Disposition');
        if (disposition) {
          var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
          var matches = filenameRegex.exec(disposition);
          if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
        }
        var linkelem = document.createElement('a');
        try {
            var blob = new Blob([response], { type: 'application/octet-stream' });
            if (typeof window.navigator.msSaveBlob !== 'undefined') {
                //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                window.navigator.msSaveBlob(blob, filename);
            } else {
                var URL = window.URL || window.webkitURL;
                var downloadUrl = URL.createObjectURL(blob);
                if (filename) {
                    // use HTML5 a[download] attribute to specify filename
                    var a = document.createElement("a");
                    // safari doesn't support this yet
                    if (typeof a.download === 'undefined') {
                        window.location = downloadUrl;
                    } else {
                        a.href = downloadUrl;
                        a.download = filename;
                        document.body.appendChild(a);
                        a.target = "_blank";
                        a.click();
                    }
                } else {
                    window.location = downloadUrl;
                }
            }
        } catch (ex) {
            console.log(ex);
        }
    }
    else{
      Swal.fire({
          type: 'error',
          title: 'Oops...',
          text: 'Este contrato no tiene un archivo adjunto',
        });
      }
    },
    error: function (response) {
    }
  });
}

function getInfoContract(e) {
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
       type: "POST",
       url: '/contract_expiration_info',
       data: {value : valor, _token : _token},
       success: function (data) {
         if (data != []) {
            $('#modal-Edit').modal('show');
            fill_table_anexos(data, $("#all_anexos"));
             $("#all_anexos").css('width', '100%');
             $('#all_anexos').DataTable().draw(true);
         }
         else {
           Swal.fire({
             type: 'error',
             title: 'Error encontrado..',
             text: 'Realice la operacion nuevamente!',
           });
         }
           //$('#modal-Edit').modal('show');
       },
       error: function (data) {
         alert('Error:', data);
       }
   })

}

function fill_table_anexos(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_anexosfilter);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, information){
    vartable.fnAddData([
      (index+1),
      information.key,
      information.date_signature, /*Fecha Firma de contrato:*/
      information.date_scheduled_start, /*Fecha Inicio de contrato(Programada):*/
      information.date_scheduled_end, /**/
      information.date_real /**/
    ]);
  });
}

var Configuration_table_anexosfilter = {
  "scrollY": 200,
  "scrollX": true,
  "aLengthMenu": [[5, 10, 25 , -1], [5, 10, 25, "Todos"]],
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
