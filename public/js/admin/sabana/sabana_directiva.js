$(function(){
var _token = $('input[name="_token"]').val();

/*$('#date_select').datepicker({
  language: 'es',
  format: "yyyy",
  viewMode: "years",
  minViewMode: "years",
  //startDate: '2016',
  endDate: '-0y',
  autoclose: true,
  clearBtn: true
}).datepicker("setDate",'now')*/;

$('#date_select').val((new Date).getFullYear());

var anio = parseInt($('#date_select').val());

$('.spinnerPlus').on('click',function(){
  anio++;
  $('#date_select').val(anio)
  llenar_tablas();
});

$('.spinnerMinus').on('click',function(){
  anio--;
  $('#date_select').val(anio)
  llenar_tablas();
});

llenar_tablas();

function llenar_tablas() {
  $.ajax({
    type:"POST",
    url:"getAllCadena",
    data:{ anio:anio, _token:_token },
    success:function(data){
      var data1=data;
      $.ajax({
        type:"POST",
        url:"/getAllSites",
        data:{ anio:anio, _token:_token },
        success:function(data){
          var data_sites=data;
          table_general(data1,data_sites,$('#table_budget_cadena'));
        },
        error:function(data){
          console.log('Error:', data);
        }
      });

    },
    error:function(data){
      console.log('Error:', data);
    }
  });


//ajax pruebas



$.ajax({
type:"POST",
url:"getAllCadenaBudget",
data:{ anio:anio,_token:_token },
success:function(data){
table_budget(data,$('#table_budget_months'));
},
error:function(data){
console.log(data);
}
})

}
/*$('#boton-aplica-filtro').on('click',function(){
  anio = parseInt($('#date_select').val());
  llenar_tablas();
});*/

function table_general(data,data_sites, table) {
  /*table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_cadena);*/
  var totalFacturado=0;
  var date_gantt=0;
  var date_gantt_end=0;
  var cadenas= new Array();
  //vartable.fnClearTable();
  var first_elem={id: "SIT1", "text":"SITWIFI", "start_date":new Date(anio,00,01),"end_date":new Date(anio,11,31),progress: 1,open: true};
  cadenas.push(first_elem);
  var i=2;
  var ejercido=0;
  //CADENAS
  $.each(data, function(index, status){
  /*  vartable.fnAddData([
    status.cadena.charAt(0).toUpperCase()+status.cadena.toLowerCase().slice(1),
    '$'+parseFloat(status.USD).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    '$'+parseFloat(status.presupuesto_anual_USD).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    '<a href="javascript:void(0);" onclick="enviar_cadena(this)" value="'+status.cadena_id+'" class="btn btn-sm btn-outline-primary" role="button" data-toggle="tooltip" data-placement="right" title="Más información"><span class="fas fa-info-circle"></span></a>',
  ]);*/

    totalFacturado+=parseFloat(status.USD);
    ejercido+=parseFloat(status.mantto);

    date_real= parseInt(status.date_real.toString().split("-")[0]);
    if (date_real>anio){
    date_gantt=date_real;
  }else{
    date_gantt=anio;
    }

    //console.log("cadena: "+status.cadena + " año: "+ status.date_real.toString().split("-")[0]);
    if(status.fecha_vence.split("-")[0] > anio) {
      status.fecha_vence = anio+"-12-31";
    }
    var aux_cad={id:"C"+status.cadena_id, "text":status.cadena.toString().trim(), "start_date":new Date(date_gantt,00,01),"date_real":status.date_real.toString().split("-").reverse().join("-"),"end_date":status.fecha_vence.toString().split("-").reverse().join("-"),"mensualidad":parseFloat(status.USD).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),"presupuesto_anual_USD":parseFloat(status.presupuesto_anual_USD).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),"ejercido":parseFloat(status.mantto).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),"xejercer":(parseFloat(status.presupuesto_anual_USD)-parseFloat(status.mantto)).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),progress: (parseFloat(status.mantto)/parseFloat(status.presupuesto_anual_USD)).toFixed(2), open: false,parent:"SIT1"};
    cadenas.push(aux_cad);
    i++;
    date_gantt=0;
  });
  //SITIOS de cada cadena
  $.each(data_sites, function(index, status){
    //console.log('sitio'+status.Nombre_hotel+' Ejercido:'+status.mantto);
    //console.log((parseFloat(status.presupuesto_anual_USD)-parseFloat(status.mantto)).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    if(status.fecha_vence.split("-")[0] > anio) {
      status.fecha_vence = anio+"-12-31";
    }
    date_real= parseInt(status.date_real.toString().split("-")[0]);
    date_gantt= date_real>anio? date_real:anio;
    var aux_sitios={id: status.hotel_id, "text":status.Nombre_hotel.toString().trim(), "start_date":new Date(date_gantt,00,01),"date_real":status.date_real.toString().split("-").reverse().join("-"),"end_date":status.fecha_vence.toString().split("-").reverse().join("-"),"mensualidad":parseFloat(status.USD).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),"presupuesto_anual_USD": parseFloat(status.presupuesto_anual_USD).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),"ejercido":parseFloat(status.mantto).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),"xejercer":(parseFloat(status.presupuesto_anual_USD)-parseFloat(status.mantto)).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),progress: (parseFloat(status.mantto)/parseFloat(status.presupuesto_anual_USD)).toFixed(2),color:"gray",open: true,parent:"C"+status.cadena_id};
    cadenas.push(aux_sitios);
    date_gantt=0;
  });

  //data_ejercido.splice(0,1);//Necesario para quitar el presupuesto total del array

  load_gantt(cadenas,'gantt_cadenas');
  var pres_a=(totalFacturado.toFixed(2)*0.70);
  var xejercer=(pres_a-ejercido);
console.log(ejercido/pres_a);
  $('#total_ejercido').text(ejercido.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  $('#total_fact').text(totalFacturado.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  $('#total_pres').text(pres_a.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  $('#total_xejercer').text(xejercer.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  $('#total_percent').text(((xejercer*100)/pres_a).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
  var taskObj=gantt.getTask("SIT1");
  taskObj.mensualidad=totalFacturado.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  taskObj.presupuesto_anual_USD=pres_a.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  taskObj.ejercido=ejercido.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  taskObj.xejercer=xejercer.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  taskObj.progress=(parseFloat(ejercido)/parseFloat(pres_a)).toFixed(1);
  gantt.updateTask("SIT1"); //renders the updated task

}

var secondGridColumns = {
  columns: [
    {
      name: "Ene.", label: "Fact. Mensual.",color:"black",width: 30, align: "right", template: function (task) {
        return "$"+task.mensualidad;
      }
    },
    {
      name: "Feb.", width: 30, label: "Pres. Anual.",align: "right", template: function (task) {
        return "$"+ task.presupuesto_anual_USD;
      }
    },
    {
      name: "Mar.", width: 30, label: "Ejercido.",align: "right", template: function (task) {
        return "$"+ task.ejercido;
      }
    },
    {
      name: "Abr.", width: 30, label: "Por ejercer.", align: "right",template: function (task) {
        return "$"+task.xejercer;
      }
    },
    {
      name: "May.", width: 30, label: "Estado",  align: "center",template: function (task) {
        var progress = task.progress || 0;
        return Math.floor(progress * 100) + "%";
      }
    },/*
    {
      name: "Jun.", width: 30, label: "Jun.", template: function (task) {
        return (task.duration * 100);
      }
    },
    {
      name: "Jul.", width: 30, label: "Jul.", template: function (task) {
        return (task.duration * 100);
      }
    },
    {
      name: "Ago.", width: 30, label: "Ago.", template: function (task) {
        return (task.duration * 100);
      }
    },
    {
      name: "Sep.", width: 30, label: "Sep.", template: function (task) {
        return (task.duration * 100);
      }
    },
    {
      name: "Oct.", width: 30, label: "Oct.", template: function (task) {
        return (task.duration * 100);
      }
    },
    {
      name: "Nov.", width: 30, label: "Nov.", template: function (task) {
        return (task.duration * 100);
      }
    },
    {
      name: "Dec.", width: 30, label: "Dec.", template: function (task) {
        return (task.duration * 100);
      }
    },*/
  ]
};


var Configuration_table_responsive_cadena={
      "order": [[ 0, "asc" ]],
      paging: true,
      //"pagingType": "simple",
      Filter: true,
      searching: true,
      "aLengthMenu": [[10, 15, 25, -1], [10, 15, 25, "All"]],
      //ordering: false,
      //"pageLength": 5,
      "columnDefs": [
          {
              "targets": 0,
              "className": "text-left",//String a la izquierda
          },
          {
              "targets": 1,
              "className": "text-right", //Numeros a la derecha
          },
          {
              "targets": 2,
              "className": "text-right",
          },
          {
              "targets": 3,
              "className": "text-center",
          },
      ],
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

function load_gantt(data,title){
  //console.log(data);
  var chart = document.getElementById(title);
   chart.style.width = $(window).width()*0.5;
   chart.style.height = $(window).width()*0.5;


   if (gantt.$container) {
   gantt.clearAll();
   }

    gantt.config.readonly = true; //Modo lectura

    gantt.config.scales = [//Multiples escalas
    {unit: "year", step: 1, format: "%Y"},//Escala por año
    {unit: "month", step: 1, format: "%M"}//Escala por mes
    ];
    //gantt.config.scale_unit = "month";//Escala a meses
    //gantt.config.date_scale = "%Y-%M"; //AÑO-MES
    gantt.config.columns = [ //Re-definición de las columnas
    {name:"text", label:"<div class='searchEl'>Proyecto <input id='search' type='hidden'"+
      "placeholder='Buscar...'></div>", width:145, tree:true},
    /*{name:"date_real", label:"Fecha de inicio", width:85,align:"center" },
    {name:"end_date", label:"Fecha de Fin", width:85,align:"center" },*/
      // other columns
    ];
    //Cambia los iconos de folder y sus elementos child
    gantt.templates.grid_folder = function(item) { return "<div class='" + (item.$open ? "far fa-building" : "fas fa-building") + "'></div>"; }; gantt.templates.grid_file = function(item) { return "<div class='gantt_tree_icon '><i class='fas fa-map-marked-alt'></i></div>"; };

    gantt.config.duration_unit = "month";//Duración de la tarea

    //gantt.config.fit_tasks = true; //Fit task

    gantt.config.min_column_width = 30;//Ancho columna task
    gantt.config.scale_height = 45;//Alto fila
    gantt.config.row_height = 22;
    //console.log(" input año: "+anio);
    //console.log("año actual "+new Date().getFullYear());

    gantt.config.layout = {
      css: "gantt_container",
      rows: [
        {
          cols: [
            {view: "grid",  scrollY: "scrollVer"},
            {resizer: true, width: 1},
            {view: "timeline", scrollX: "scrollHor", scrollY: "scrollVer"},
            {resizer: true, width: 1},
            {view: "grid", bind: "task", scrollY: "scrollVer", config: secondGridColumns},
            {view: "scrollbar", id: "scrollVer"}
          ]

        },
        {view: "scrollbar", id: "scrollHor", height: 20}
      ]
    };

    gantt.templates.task_class  = function(start, end, task){

    switch (true){
        case task.duration<=6:
        return "high";
        break;
        case task.duration<=11:
        return "medium";
        break;
        case task.duration>11:
        return "low";
        break;
    }
  };

    //Tooltip mouse:hover (informacion)
    gantt.templates.tooltip_text = function(start,end,task){
    return "<b>Proyecto:</b> "+task.text+"<br/><b>Estado:</b> " + task.progress*100+'%'
    +"<br/><b>Facturación  Mensual: $</b> " + task.mensualidad+"<br/><b>Presupuesto anual: $</b> " + task.presupuesto_anual_USD
    +"<br/><b>Ejercido: $</b> " +task.ejercido;
    };

    //Colorear celdas especificas
    gantt.templates.scale_cell_class = function(date){
        if(date.getFullYear()){
          //console.log(date.getFullYear());
            return "year";
        }
    };

     gantt.attachEvent("onTaskClick", function(id,e){//Si detecta un clic hace algo
         //gantt.message({type:"info", text:"Proyecto:"+id});
         //$('#modal_presupuesto').modal('show');
         return true;
     });
     gantt.init(title); //Inicialización de la gráfica.

     var tasks = {
       data: data,
       links: []
     };
     gantt.parse(tasks);


     //Funcionalidad para buscar  en gantt
     var inputEl = document.getElementById('search');

      inputEl.oninput = function(){
        gantt.refreshData();
      }

      function hasSubstr(parentId){
        var task = gantt.getTask(parentId);
        if(task.text.toLowerCase().indexOf(inputEl.value.toLowerCase() ) !== -1)
          return true;

        var child = gantt.getChildren(parentId);
        for (var i = 0; i < child.length; i++) {
          if (hasSubstr(child[i]))
            return true;
        }
        return false;
      }

      gantt.attachEvent("onBeforeTaskDisplay", function(id, task){
        if (hasSubstr(id))
          return true;

          return false;
      });



      $(document).ready(function(){
        $("#hide").on('click',function(){
          $(".gantt_grid").toggle();
         $('.gantt_task').addClass('w-100');
        });
        $("#reload").on('click',function(){

        });
      });


}

});
function enviar_cadena(e){
  var idcadena= e.getAttribute('value');
  var anio = parseInt($('#date_select').val());
  var _token = $('input[name="_token"]').val();

  $.ajax({
    type:"POST",
    url:"/getBudgetSiteMonth",
    data:{ anio:anio,idcadena:idcadena, _token:_token },
    success:function(data)
    {
      //console.log(data);
      table_sites(data,$('#table_sites'));
    },
    error:function(data)
    {
      console.log('Error: '+data);
    }
  });
  $('#modal_presupuesto').modal('show');
}

function table_sites(data,table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_sites);
  vartable.fnClearTable();
  var mensual = 0;
  var suma=0;
  $.each(data, function(index, status){
    suma =(parseFloat(status.enero) +parseFloat(status.febrero) + parseFloat(status.marzo) + parseFloat(status.abril) + parseFloat(status.mayo) +parseFloat(status.junio)
    + parseFloat(status.julio) + parseFloat(status.agosto) +parseFloat(status.septiembre) + parseFloat(status.octubre) + parseFloat(status.noviembre) + parseFloat(status.diciembre));

    mensual = parseInt((suma*100)/status.presupuesto_anual_USD);
    isNaN(mensual)==true? mensual=0:mensual;
    vartable.fnAddData([
    status.Nombre_hotel.charAt(0).toUpperCase()+status.Nombre_hotel.toLowerCase().slice(1),
    '$'+parseFloat(status.USD).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    '$'+parseFloat(status.presupuesto_anual_USD).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    '$'+status.enero,
    '$'+status.febrero,
    '$'+status.marzo,
    '$'+status.abril,
    '$'+status.mayo,
    '$'+status.junio,
    '$'+status.julio,
    '$'+status.agosto,
    '$'+status.septiembre,
    '$'+status.octubre,
    '$'+status.noviembre,
    '$'+status.diciembre,
    morethan100(mensual)
    ]);
  });

}

function table_budget(data,table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_resp1);
  vartable.fnClearTable();
  var mensual = 0;
  var suma=0;
  var numrow=1;
  $.each(data, function(index, status){

    suma =(parseFloat(status.enero) +parseFloat(status.febrero) + parseFloat(status.marzo) + parseFloat(status.abril) + parseFloat(status.mayo) +parseFloat(status.junio)
    + parseFloat(status.julio) + parseFloat(status.agosto) +parseFloat(status.septiembre) + parseFloat(status.octubre) + parseFloat(status.noviembre) + parseFloat(status.diciembre));

    mensual = parseInt((suma*100)/status.presupuesto_anual_USD);
    isNaN(mensual)==true? mensual=0:mensual;
    //console.log(mensual);
    vartable.fnAddData([
      status.cadena,
      '$'+parseFloat(status.USD).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$'+parseFloat(status.presupuesto_anual_USD).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$'+parseFloat(status.enero).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$'+parseFloat(status.febrero).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$'+parseFloat(status.marzo).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$'+parseFloat(status.abril).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$'+parseFloat(status.mayo).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$'+parseFloat(status.junio).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$'+parseFloat(status.julio).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$'+parseFloat(status.septiembre).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$'+parseFloat(status.agosto).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$'+parseFloat(status.octubre).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$'+parseFloat(status.noviembre).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$'+parseFloat(status.diciembre).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      morethan100(mensual),
      '<a href="javascript:void(0);" onclick="enviar_cadena(this)" value="'+status.cadena_id+'" class="btn btn-sm btn-outline-primary" role="button" data-toggle="tooltip" data-placement="right" title="Más información"><span class="fas fa-info-circle"></span></a>',
    ]);

    /*mensual>100?overflow(numrow): '';
    suma>status.presupuesto_anual_USD?overflow(numrow):'';
    numrow++;*/
  });
}

function morethan100(number){
var val=''
number>100? val='<span style="color:red; font-weight:bold;">'+number+'%'+'</span>': val='<span style="font-weight:bold;">'+number+'%'+'</span>';
return val;
}


var Configuration_table_responsive_sites={
      "order": [[ 0, "asc" ]],
      paging: true,
      //"pagingType": "simple",
      Filter: true,
      searching: true,
      "aLengthMenu": [[10, 15, 25, -1], [10, 15, 25, "All"]],
      //ordering: false,
      //"pageLength": 5,
      "columnDefs": [
          {
              "targets": 0,
              "className": "text-left",//String a la izquierda
          },
          {
              "targets": 1,
              "className": "text-left",//String a la izquierda
          },
          {
              "targets": 2,
              "className": "text-center", //Numeros a la derecha
          },
          {
              "targets": 3,
              "className": "text-center",
          },
          {
              "targets": 4,
              "className": "text-center",
          },
          {
              "targets": 5,
              "className": "text-right",
          },
          {
              "targets": 6,
              "className": "text-right",
          },
          {
              "targets": 7,
              "className": "text-right",
          },

      ],
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

var Configuration_table_resp1={
      "order": [[ 0, "asc" ]],
      paging: true,
      //"pagingType": "simple",
      Filter: true,
      searching: true,
      "aLengthMenu": [[10, 15, 25, -1], [10, 15, 25, "All"]],
      //ordering: false,
      //"pageLength": 5,
      "columnDefs": [
          {
              "targets": 0,
              "className": "text-left",//String a la izquierda
          },
          {
              "targets": 1,
              "className": "text-left",//String a la izquierda
          },
          {
              "targets": 2,
              "className": "text-right", //Numeros a la derecha
          },
          {
              "targets": 3,
              "className": "text-right",
          },
          {
              "targets": 4,
              "className": "text-right",
          },
          {
              "targets": 5,
              "className": "text-right",
          },
          {
              "targets": 6,
              "className": "text-right",
          },
          {
              "targets": 7,
              "className": "text-right",
          },
          {
              "targets": 8,
              "className": "text-right",
          },
          {
              "targets": 9,
              "className": "text-right",
          },
          {
              "targets": 10,
              "className": "text-right",
          },
          {
              "targets": 11,
              "className": "text-right",
          },
          {
              "targets": 12,
              "className": "text-right",
          },
          {
              "targets": 13,
              "className": "text-right",
          },
          {
              "targets": 14,
              "className": "text-right",
          },
          {
              "targets": 15,
              "className": "text-right",
          },
          {
              "targets": 16,
              "className": "text-right",
          },

      ],
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
