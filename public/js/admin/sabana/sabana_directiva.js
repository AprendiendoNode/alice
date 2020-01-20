$(function(){
var _token = $('input[name="_token"]').val();

$('#date_select').datepicker({
  language: 'es',
  format: "yyyy",
  viewMode: "years",
  minViewMode: "years",
  //startDate: '2016',
  endDate: '-0y',
  autoclose: true,
  clearBtn: true
}).datepicker("setDate",'now');

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
                  $.ajax({
                    type:"POST",
                    url:"/getAllDocM_Ejer",
                    data:{ anio:anio, _token:_token },
                    success:function(data){
                      var data_ejercido = data;
                      table_general(data1,data_sites,data_ejercido,$('#table_budget_cadena'));
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

    },
    error:function(data){
      console.log('Error:', data);
    }
  });
}
/*$('#boton-aplica-filtro').on('click',function(){
  anio = parseInt($('#date_select').val());
  llenar_tablas();
});*/

function table_general(data,data_sites,data_ejercido, table) {
  /*table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_cadena);*/
  var totalFacturado=0;
  var date_gantt=0;
  var date_gantt_end=0;
  var cadenas= new Array();
  //vartable.fnClearTable();
  var first_elem={id: "SIT1", "text":"SITWIFI", "start_date":new Date(anio,00,01),"end_date":"01-04-2029",progress: 1,open: true};
  cadenas.push(first_elem);
  var i=2;
  var ejercido=parseFloat(data_ejercido[0].equipo_act)+parseFloat(data_ejercido[0].mantto);

  $('#total_ejercido').text(ejercido.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  //CADENAS
  $.each(data, function(index, status){
    /*vartable.fnAddData([
    status.cadena.charAt(0).toUpperCase()+status.cadena.toLowerCase().slice(1),
    '$'+parseFloat(status.USD).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    '$'+parseFloat(status.presupuesto_anual_USD).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    '<a href="javascript:void(0);" onclick="enviar_cadena(this)" value="'+status.cadena_id+'" class="btn btn-sm btn-outline-primary" role="button" data-toggle="tooltip" data-placement="right" title="Más información"><span class="fas fa-info-circle"></span></a>',
  ]);*/

    totalFacturado+=parseFloat(status.USD);

    date_real= parseInt(status.date_real.toString().split("-")[0]);
    if (date_real>anio){
    date_gantt=date_real;
  }else{
    date_gantt=anio;
    }

    //console.log("cadena: "+status.cadena + " año: "+ status.date_real.toString().split("-")[0]);
    var aux_cad={id:"C"+status.cadena_id, "text":status.cadena.toString().trim(), "start_date":new Date(date_gantt,00,01),"date_real":status.date_real.toString().split("-").reverse().join("-"),"end_date":status.fecha_vence.toString().split("-").reverse().join("-"),"mensualidad":parseFloat(status.USD).toFixed(2),"presupuesto_anual_USD":parseFloat(status.presupuesto_anual_USD).toFixed(2),progress: 1, open: false,parent:"SIT1"};
    cadenas.push(aux_cad);
    i++;
    date_gantt=0;
  });
  //SITIOS de cada cadena
  $.each(data_sites, function(index, status){
    //console.log('sitio'+status.Nombre_hotel);
    date_real= parseInt(status.date_real.toString().split("-")[0]);
    date_gantt= date_real>anio? date_real:anio;
    var aux_sitios={id: status.hotel_id, "text":status.Nombre_hotel.toString().trim(), "start_date":new Date(date_gantt,00,01),"date_real":status.date_real.toString().split("-").reverse().join("-"),"end_date":status.fecha_vence.toString().split("-").reverse().join("-"),"mensualidad":parseFloat(status.USD).toFixed(2),"presupuesto_anual_USD": parseFloat(status.presupuesto_anual_USD).toFixed(2),progress: 1,color:"gray",open: true,parent:"C"+status.cadena_id};
    cadenas.push(aux_sitios);
    date_gantt=0;
  });

  //data_ejercido.splice(0,1);//Necesario para quitar el presupuesto total del array

  load_gantt(cadenas,'gantt_cadenas');
  var pres_a=(totalFacturado.toFixed(2)*0.70);
  var xejercer=(pres_a-ejercido);
  $('#total_fact').text(totalFacturado.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  $('#total_pres').text(pres_a.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  $('#total_xejercier').text(xejercer.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  $('#total_percent').text(((xejercer*100)/pres_a).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
  var taskObj=gantt.getTask("SIT1");
  taskObj.mensualidad=totalFacturado.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  taskObj.presupuesto_anual_USD=pres_a.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

}




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
    {name:"text", label:"<div class='searchEl'>Proyecto <input id='search' type='text'"+
      "placeholder='Buscar...'></div>", width:145, tree:true},
    {name:"date_real", label:"Fecha de inicio", width:85,align:"center" },
    {name:"end_date", label:"Fecha de Fin", width:85,align:"center" },
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

    gantt.templates.task_class  = function(start, end, task){

    switch (true){
        case task.duration<2:
        return "high";
        break;
        case task.duration<=8:
        return "medium";
        break;
        case task.duration>=9:
        return "low";
        break;
    }
  };

    //Tooltip mouse:hover (informacion)
    gantt.templates.tooltip_text = function(start,end,task){
    return "<b>Proyecto:</b> "+task.text+"<br/><b>Duración:</b> " + task.duration
    +" Meses"+"<br/><b>Facturación  Mensual: $</b> " + task.mensualidad+"<br/><b>Presupuesto anual: $</b> " + task.presupuesto_anual_USD;
    //+"<br/><b>Ejercido: $</b> " + task.ejercido;
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
    url:"/getAllSites",
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
  $.each(data, function(index, status){
    vartable.fnAddData([
    status.hotel_id,
    status.Nombre_hotel.charAt(0).toUpperCase()+status.Nombre_hotel.toLowerCase().slice(1),
    status.key,
    status.date_real,
    status.fecha_vence,
    status.meses_restantes,
    '$'+parseFloat(status.USD).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    '$'+parseFloat(status.presupuesto_anual_USD).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    ]);
  });

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
