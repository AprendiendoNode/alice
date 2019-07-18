$(function() {

  moment.locale('es');
  $('#startDate').datepicker({
    language: 'es',
    format: "yyyy-mm-dd",
    viewMode: "days",
    minViewMode: "days",
    endDate: '1m',
    autoclose: true,
    clearBtn: true
  });

  $('#endDate').datepicker({
    language: 'es',
    format: "yyyy-mm-dd",
    viewMode: "days",
    minViewMode: "days",
    endDate: '1m',
    autoclose: true,
    clearBtn: true
  });


  $('#startDate').val('').datepicker('update');
  $('#endDate').val('').datepicker('update');

});

$("#boton-aplica-filtro").click(function(event) {
  get_table_viatics();
});

$("#filterOption").on("change", function(){
  var idFilter = $(this).val();
  select1 = document.getElementById('service');
  select2 = document.getElementById('group');
  select3 = document.getElementById('sitio');
  select4 = document.getElementById('users');
  div = document.getElementById('container_select');

  if(idFilter == 0){

    select1.style.display = "none";
    select2.style.display = "none";
    select3.style.display = "none";
    select4.style.display = "none";

  }else if(idFilter == 1){

    select1.style.display = "inline-block";
    select2.style.display = "none";
    select3.style.display = "none";
    select4.style.display = "none";

  }else if(idFilter == 2){

    select1.style.display = "none";
    select2.style.display = "inline-block";
    select3.style.display = "none";
    select4.style.display = "none";

  }
  else if(idFilter == 3){

    select1.style.display = "none";
    select2.style.display = "none";
    select3.style.display = "inline-block";
    select4.style.display = "none";

  }
  else if(idFilter == 4){

    select1.style.display = "none";
    select2.style.display = "none";
    select3.style.display = "none";
    select4.style.display = "inline-block";

  }


console.log(div);
});

function get_table_viatics() {
  var _token = $('input[name="_token"]').val();
  var start = $('#startDate').val();
  var end = $('#endDate').val();
  var filterOption = $("#filterOption").val();
  var id = 0;
  if(filterOption == 1){
    id = $("#service").val();
  }else if(filterOption == 2){
    id = $("#group").val();
  }else if(filterOption == 3){
    id = $("#sitio").val();
  }else if(filterOption == 4){
    id = $("#users").val();
  }

  $.ajax({
      type: "POST",
      url: "/view_request_via_weekly",
      data: {startDate: start, endDate: end, filterOption: filterOption, id: id , _token: _token},
      success: function (data){
        console.log(data);
        viatics_table(data, $("#table_viatics"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function viatics_table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_viatic_weekly);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
  vartable.fnAddData([
    status.folio,
    status.sitios,
    status.date_start,
    status.date_end,
    status.transp_aerea,
    status.transp_terrestre,
    status.hospedaje,
    status.alimentacion,
    status.diversos,
    status.solicitado,
    status.aprobado,
    '<span class="label label-default">'+status.estado+'</span>',
    status.usuario,
    '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.id+'" class="btn btn-default btn-sm" role="button" data-target="#modal-concept"><span class="far fa-edit"></span></a>',
    ]);
  });
}
function enviar(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  var fecha = $('#date_to_search').val();
  cabecera_viatic(valor, _token);
  cuerpo_viatic(valor, _token);
  timeline(valor, _token);
  // totales_concept_zsa(valor, _token);
  $('#modal-view-concept').modal('show');
}
// Exportacion del pdf
$('.btn-export').on('click', function(){
    $("#captura_table_general").hide();
    $(".hojitha").css("border", "");
    html2canvas(document.getElementById("captura_pdf_general")).then(function(canvas) {
      var ctx = canvas.getContext('2d');
      ctx.rect(0, 0, canvas.width, canvas.height);
          var imgData = canvas.toDataURL("image/jpeg", 1.0);
          var correccion_landscape = 0;
          var correccion_portrait = 0;
          if(canvas.height > canvas.width) {
              var orientation = 'portrait';
              correccion_portrait = 1;
              correccion_landscape = 0;
              var imageratio = canvas.height/canvas.width;
          }
          else {
              var orientation = 'landscape';
              correccion_landscape = 0;
              correccion_portrait = 0;
              var imageratio = canvas.width/canvas.height;
          }
          if(canvas.height < 900) {
              fontsize = 16;
          }
          else if(canvas.height < 2300) {
              fontsize = 11;
          }
          else {
              fontsize = 6;
          }

          var margen = 0;//pulgadas

          // console.log(canvas.width);
          // console.log(canvas.height);

         var pdf  = new jsPDF({
                      orientation: orientation,
                      unit: 'in',
                      format: [16+correccion_portrait, (16/imageratio)+margen+correccion_landscape]
                    });

          var widthpdf = pdf.internal.pageSize.width;
          var heightpdf = pdf.internal.pageSize.height;
          pdf.addImage(imgData, 'JPEG', 0, margen, widthpdf, heightpdf-margen);
          pdf.save("Solicitud de viaticos.pdf");
          $(".hojitha").css("border", "1px solid #ccc");
          $(".hojitha").css("border-bottom-style", "hidden");
    });
});

var Configuration_table_responsive_viatic_weekly= {
  "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  "columnDefs": [
    {
        "targets": 0,
        "width": "1%",
        "className": "text-center",
    },
    {
        "targets": 1,
        "width": "0.2%",
        "className": "text-center",
    },
    {
        "targets": 2,
        "width": "0.2%",
        "className": "text-center",
    },
    {
        "targets": 3,
        "width": "0.2%",
        "className": "text-center",
    },
    {
        "targets": 4,
        "width": "0.2%",
        "className": "text-center",
    },
    {
        "targets": 5,
        "width": "1%",
        "className": "text-center",
    },
    {
        "targets": 6,
        "width": "0.2%",
        "className": "text-center",
    },
    {
        "targets": 7,
        "width": "1%",
        "className": "text-center",
    },
    {
        "targets": 8,
        "width": "0.2%",
        "className": "text-center",
    },
    {
        "targets": 9,
        "width": "0.2%",
        "className": "text-center",
    },
    {
        "targets": 10,
        "width": "0.2%",
        "className": "text-center",
    },
    {
        "targets": 11,
        "width": "0.2%",
        "className": "text-center",
    },
    {
        "targets": 12,
        "width": "2%",
        "className": "text-center",
    },
    {
        "targets": 13,
        "width": "0.2%",
        "className": "text-center",
    }
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
            ax= '- Periodo: ' + $('input[name="startDate"]').val() + ' a ' +  $('input[name="endDate"]').val();
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
            columns: [ 0,1,2,3,4,5,6,7,8,9,10,11,12 ],
            modifier: {
                page: 'all',
            }
        },
        className: 'btn bg-olive custombtntable',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="fa fa-file-text-o"></i> CSV',
        titleAttr: 'CSV',
        title: function ( e, dt, node, config ) {
          var ax = '';
          if($('input[name="date_to_search"]').val() != ''){
            ax= '- Periodo: ' + $('input[name="startDate"]').val() + ' a ' +  $('input[name="endDate"]').val();
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
            columns: [ 0,1,2,3,4,5,6,7,8,9,10,11,12 ],
            modifier: {
                page: 'all',
            }
        },
        className: 'btn btn-info',
      },
      {
        extend: 'pdf',
        text: '<i class="fa fa-file-pdf-o"></i>  PDF',
        title: function ( e, dt, node, config ) {
          var ax = '';
          if($('input[name="date_to_search"]').val() != ''){
            ax= '- Periodo: ' + $('input[name="startDate"]').val() + ' a ' +  $('input[name="endDate"]').val();
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
            columns: [ 0,1,2,3,4,5,6,7,8,9,10,11,12 ],
            modifier: {
                page: 'all',
            }
        },
        className: 'btn btn-danger',
        orientation: 'landscape'
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
