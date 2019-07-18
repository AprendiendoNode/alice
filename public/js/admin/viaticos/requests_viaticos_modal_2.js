function enviar(e){
  var valor= e.getAttribute('value');
  var fecha = $('#date_to_search').val();
  var _token = $('input[name="_token"]').val();
  $.ajax({
      type: "POST",
      url: "/view_pertain_viatic_ur",
      data: { date_to_search: fecha, viatic : valor , _token : _token },
      success: function (data){
        if (data === "0") { // NO SE NECESITA APROBAR CONCEPTOS
          console.log('NO SE NECESITA APROBAR CONCEPTOS');
          cabecera_viatic(valor, _token);
          cuerpo_viatic(valor, _token);
          timeline(valor, _token);
          totales_concept_zsa(valor, _token);
          $('#modal-view-concept').modal('show');
        }
        if (data === "1") { //NECESITA APROBAR CONCEPTOS
          console.log('NECESITA APROBAR CONCEPTOS');
          table_concept_one(valor, _token);
          $('#modal-view-concept-approve').modal('show');
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function timeline(campoa, campob){
  $.ajax({
    type: "POST",
    url: "/search_data_timeline",
    data: { viatic : campoa , _token : campob },
    success: function (data){
      datax = JSON.parse(data);

      $("#timeline_a").text(datax[0].Nombre1);
      $("#timeline_b").text(datax[0].Nombre2);
      $("#timeline_c").text(datax[0].Nombre3);
      $("#timeline_d").text(datax[0].Nombre4);
      $("#timeline_e").text(datax[0].Nombre5);
      $("#timeline_f").text(datax[0].Nombre6);

      if(datax[0].Firma1 != 'N/A'){  $("#firma_1").attr("src","../images/storage/signature/"+datax[0].Firma1); }
      else {  $("#firma_1").attr("src","../images/hotel/Default.svg");  }

      if(datax[0].Firma2 != 'N/A'){  $("#firma_2").attr("src","../images/storage/signature/"+datax[0].Firma2); }
      else {  $("#firma_2").attr("src","../images/hotel/Default.svg");  }

      if(datax[0].Firma3 != 'N/A'){  $("#firma_3").attr("src","../images/storage/signature/"+datax[0].Firma3); }
      else {  $("#firma_3").attr("src","../images/hotel/Default.svg");  }

      if(datax[0].Firma4 != 'N/A'){  $("#firma_3").attr("src","../images/storage/signature/"+datax[0].Firma4); }
      else {  $("#firma_3").attr("src","../images/hotel/Default.svg");  }


      //console.log(data);
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function cabecera_viatic(campoa, campob){
  $.ajax({
    type: "POST",
    url: "/view_request_show_viatic_up",
    data: { viatic : campoa , _token : campob },
    success: function (data){
      if (data == null || data == '[]') {
        $("#folio_solicitud").text('');
        $("#name_user").text('');
        $("#correo_user").text('');
        $("#tipo_beneficiario").text('');
        $("#responsable").text('');
        $("#status_solicitud").text('');
        $("#status_prioridad").text('');
        $("#fecha_ini").text('');
        $("#fecha_fin").text('');
        $("#observaciones_a").text('');
        $("#observaciones_b").text('');
      }
      else {
        if ($.trim(data)){
          datax = JSON.parse(data);
          //console.log(datax);
          $("#folio_solicitud").text(datax[0].Folio);
          $("#name_user").text(datax[0].Nombre);
          $("#correo_user").text(datax[0].Correo);
          $("#responsable").text(datax[0].Gerente);
          $("#tipo_beneficiario").text(datax[0].Beneficiario);
          $("#fecha_ini").text(datax[0].Fechainicio);
          $("#fecha_fin").text(datax[0].FechaFinal);
          $("#status_solicitud").text(datax[0].EstadoSolicitud);
          $("#status_prioridad").text(datax[0].Prioridad);
          $("#observaciones_a").text(datax[0].Descripcion);
          $("#observaciones_b").text(datax[0].observacion);
        }
        else{
          $("#folio_solicitud").text('');
          $("#name_user").text('');
          $("#correo_user").text('');
          $("#tipo_beneficiario").text('');
          $("#responsable").text('');
          $("#status_solicitud").text('');
          $("#status_prioridad").text('');
          $("#fecha_ini").text('');
          $("#fecha_fin").text('');
          $("#observaciones_a").text('');
          $("#observaciones_b").text('');
        }
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function cuerpo_viatic(campoa, campob){
  $.ajax({
    type: "POST",
    url: "/view_request_show_viatic_down",
    data: { viatic : campoa , _token : campob },
    success: function (data){
      //console.log(data);
      table_concept(data, $("#table_concept"));
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function table_concept(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_add_concept);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){ //Este es el bueno
    vartable.fnAddData([
      status.Concepto,
      status.total,
      status.Estatus,
      status.Hotel,
      status.justificacion
    ]);
  });
}

var Configuration_table_responsive_simple_add_concept={
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

function totales_concept_zsa(campoa, campob){
  $.ajax({
    type: "POST",
    url: "/view_request_total_concept_viatic",
    data: { viatic : campoa , _token : campob },
    success: function (data){
      if (data == null || data == '[]') {
        $("#total_aprob").text('');
        $("#total_direct").text('');
        $("#total_denegado").text('');
      }
      else {
        if ($.trim(data)){
          datax = JSON.parse(data);
          $("#total_aprob").text(datax[0].suma);
          $("#total_denegado").text(datax[1].suma);
          $("#total_direct").text(datax[2].suma);
        }
        else{
          $("#total_aprob").text('');
          $("#total_direct").text('');
          $("#total_denegado").text('');
        }
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
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
