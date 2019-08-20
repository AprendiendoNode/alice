$(function() {
  $(".select2").select2();
})

$('#boton-aplica-filtro').on('click',function(){
  table_permission();
});

$("#searchFolio").on("submit", function(e){
  e.preventDefault();
})

$("#hotel").on('change',function(){

  $('#idFolio').empty();
  $('#idFolio').append('<option value="0">Elegir...</option>');
  getFoliosByHotel();
});
$("#proveedor").on('change',function(){

  $('#idFolio').empty();
  $('#idFolio').append('<option value="0">Elegir...</option>');
  getFoliosByProveedor();
});

$("#searchFolio").on('keyup',function(){
  var term = $(this).val();
  var _token = $('input[name="_token"]').val();
  var datax;
  $("#folios").empty();
  $.ajax({
      type: "POST",
      url: "/search_folio",
      data: {data_one: term, _token : _token },
      success: function (data){

        datax = JSON.parse(data);

        if ($.trim(data)){
          $.each(datax.results, function(i, item) {
              $("#folios").append("<option value='" + item.folio + "'>");
          });
        }
          payments_table(datax.folioData, $("#table_pays"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });

})

function getFoliosByHotel(){
  var id = parseInt($("#hotel").val());
  console.log(id);
  var _token = $('input[name="_token"]').val();
  var datax;
  $.ajax({
    type: "POST",
    url: "/get_payment_folios",
    data: { id : id, _token : _token },
    success: function (data){

      datax = JSON.parse(data);
      console.log(datax);
      payments_table(datax, $("#table_pays"));

    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

//SIERRA BEGIN

function getFoliosByProveedor(){
  var id = parseInt($("#proveedor").val());
  console.log(id);
  var _token = $('input[name="_token"]').val();
  var datax;
  $.ajax({
    type: "POST",
    url: "/get_payment_by_proveedor",
    data: { id : id, _token : _token },
    success: function (data){
      // datax = JSON.parse(data);
      // console.log(data);
      payments_table(data, $("#table_pays"));

    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

//SIERRA END

function payments_table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_pay);
  vartable.fnClearTable();
  //console.log(datajson);
  $.each(datajson, function(index, value){
    vartable.fnAddData([
      value.factura,
      value.proveedor,
      '<span class="label label-primary">'+value.estatus+'</span>',
      value.monto_str,
      value.elaboro,
      value.fecha_solicitud,
      value.fecha_limite,
      '<a href="javascript:void(0);" onclick="enviar(this)" value="'+value.id+'" class="btn btn-default btn-sm" role="button" data-target="#modal-concept"><i class="far fa-edit" aria-hidden="true"></i></a>',
      ]);
  });
}


var Configuration_table_responsive_pay= {
        "order": [[ 1, "asc" ]],
        "select": true,
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "columnDefs": [
            {
                "targets": 0,
                "width": "1%",
                "className": "text-center",
            },
            {
                "targets": 1,
                "width": "1%",
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
                "width": "0.4%",
                "className": "text-center",
            },
            {
                "targets": 7,
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
              return 'Historial de pago '+ax;
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
              return 'Historial de pago '+ax;
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
              return 'Historial de pago '+ax;
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
              pdf.save("Solicitud de pago.pdf");
              $(".hojitha").css("border", "1px solid #ccc");
              $(".hojitha").css("border-bottom-style", "hidden");
        });
      });
