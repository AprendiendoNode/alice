$(function() {
  $('#filter_date_from').datepicker({
    language: 'es',
    format: 'dd-mm-yyyy',
    viewMode: "days",
    minViewMode: "days",
    endDate: '1d',
    autoclose: true,
    clearBtn: true
  });

  $('#filter_date_to').datepicker({
    language: 'es',
    format: 'dd-mm-yyyy',
    viewMode: "days",
    minViewMode: "days",
    endDate: '1d',
    autoclose: true,
    clearBtn: true
  });
});

function enviar(e, editing){
  var valor = e.getAttribute('value');

  $.ajax({
		type: "POST",
		url: "/purchases/modal_purchase",
		data: { valor : valor, _token : $('input[name="_token"]').val() },
		success: function (data){

      $('#modalFolio').text(data[0].name);
      $('#modalNombre').text(data[0].name_fact);
      $('#modalFechaReg').text(data[0].date);
      $('#modalFechaFact').text(data[0].fecha_fact);
      $('#modalFechaVenc').text(data[0].fecha_venc);

      $('#modalTerminoPago').text(data[0].payment_terms);
      $('#modalFormaPago').text(data[0].payment_ways);
      $('#modalMetodoPago').text(data[0].payment_methods);
      $('#modalUsoCFDI').text(data[0].cfdi_uses);
      $('#modalMoneda').text(data[0].currencies);

      $('#montoLetras').text("(" + NumeroALetras(parseFloat(data[0].amount_total).toFixed(2)) + " " + data[0].currencies + ")");
      $('#totales1').text("$ " + parseFloat(data[0].total_sin_desc).toFixed(2));
      $('#totales2').text("$ " + parseFloat(data[0].amount_discount).toFixed(2));
      $('#totales3').text("$ " + parseFloat(data[0].amount_untaxed).toFixed(2));
      $('#totales4').text("$ " + parseFloat(data[0].impuestos).toFixed(2));
      $('#totales5').text("$ " +parseFloat(data[0].amount_total).toFixed(2));

      $.ajax({
    		type: "POST",
    		url: "/purchases/modal_purchase_lines",
    		data: { valor : valor, _token : $('input[name="_token"]').val() },
    		success: function (data){

    		  console.log(data);

    		  get_modal_purchase_table(data, $("#table_modal_purchase"));

          $('#modal-purchase-view').modal('show');

    		},
    		error: function (err) {
    		  Swal.fire({
    		     type: 'error',
    		     title: 'Oops...',
    		     text: err.statusText,
    		   });
    		}
    	});
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
function enviartwo(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();

  Swal.fire({
    title: "¿Estás seguro?",
    html: "Se denegará la compra.!<br><br><textarea rows='3' placeholder='Añadir comentario' class='form-control' id='comentario'></textarea>",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Continuar",
    cancelButtonText: "Cancelar!",
  }).then((result) => {
    var comment = $('#comentario').val();
    if (comment === "") {
      Swal.fire("Operación abortada!", "Añada un comentario de denegación.", "error");
    }else{
      $.ajax({
          type: "POST",
          url: "/purchases/deny_purchase",
          data: { idents: valor, comm: comment, _token : _token },
          success: function (data){
            // console.log(data);
            if (data === 'true') {
              Swal.fire("Operación Completada!", "La compra ha sido denegada.", "success");
              gen_purchases_auto();
            }else{
              Swal.fire("Operación abortada!", "No cuenta con el permiso o esta ya se encuentra denegada :) Nota: Si la compra ya esta confirmada no se puede denegar", "error");
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
      });
    }
  })

}

function get_modal_purchase_table(datajson, table){
  console.log(datajson);
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_modal_purchase);
  vartable.fnClearTable();
  $.each(datajson, function(index, status){
    vartable.fnAddData([
        parseInt(status.quantity),
        status.name,
        status.descripcion,
        parseFloat(status.price_unit).toFixed(2),
        parseFloat(status.imp_sin_desc).toFixed(2),
        parseFloat(status.imp_con_desc).toFixed(2)
      ]);
  });
}

var Configuration_table_responsive_modal_purchase= {
  "order": [[ 1, "asc" ]],
  "select": true,
  "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  /*"select": {
    'style': 'multi',
  },*/
  /*buttons: [
    {
      extend: 'excelHtml5',
      title: 'Facturas',
      init: function(api, node, config) {
         $(node).removeClass('btn-secondary')
      },
      text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
      titleAttr: 'Excel',
      className: 'btn btn-success btn-sm',
      exportOptions: {
          columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
      },
    },
    {
      extend: 'csvHtml5',
      title: 'Facturas',
      init: function(api, node, config) {
         $(node).removeClass('btn-secondary')
      },
      text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
      titleAttr: 'CSV',
      className: 'btn btn-primary btn-sm',
      exportOptions: {
        columns: [ 0, 1, 2, 3, 4, 5]
      },
    }
  ],*/
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
  },
};

//Funcionalidad para convertir numero a letras

function Unidades(num){

  switch(num)
  {
    case 1: return "UN";
    case 2: return "DOS";
    case 3: return "TRES";
    case 4: return "CUATRO";
    case 5: return "CINCO";
    case 6: return "SEIS";
    case 7: return "SIETE";
    case 8: return "OCHO";
    case 9: return "NUEVE";
  }

  return "";
}

function Decenas(num){

  decena = Math.floor(num/10);
  unidad = num - (decena * 10);

  switch(decena)
  {
    case 1:
      switch(unidad)
      {
        case 0: return "DIEZ";
        case 1: return "ONCE";
        case 2: return "DOCE";
        case 3: return "TRECE";
        case 4: return "CATORCE";
        case 5: return "QUINCE";
        default: return "DIECI" + Unidades(unidad);
      }
    case 2:
      switch(unidad)
      {
        case 0: return "VEINTE";
        default: return "VEINTI" + Unidades(unidad);
      }
    case 3: return DecenasY("TREINTA", unidad);
    case 4: return DecenasY("CUARENTA", unidad);
    case 5: return DecenasY("CINCUENTA", unidad);
    case 6: return DecenasY("SESENTA", unidad);
    case 7: return DecenasY("SETENTA", unidad);
    case 8: return DecenasY("OCHENTA", unidad);
    case 9: return DecenasY("NOVENTA", unidad);
    case 0: return Unidades(unidad);
  }
}//Unidades()

function DecenasY(strSin, numUnidades){
  if (numUnidades > 0)
    return strSin + " Y " + Unidades(numUnidades)

  return strSin;
}//DecenasY()

function Centenas(num){

  centenas = Math.floor(num / 100);
  decenas = num - (centenas * 100);

  switch(centenas)
  {
    case 1:
      if (decenas > 0)
        return "CIENTO " + Decenas(decenas);
      return "CIEN";
    case 2: return "DOSCIENTOS " + Decenas(decenas);
    case 3: return "TRESCIENTOS " + Decenas(decenas);
    case 4: return "CUATROCIENTOS " + Decenas(decenas);
    case 5: return "QUINIENTOS " + Decenas(decenas);
    case 6: return "SEISCIENTOS " + Decenas(decenas);
    case 7: return "SETECIENTOS " + Decenas(decenas);
    case 8: return "OCHOCIENTOS " + Decenas(decenas);
    case 9: return "NOVECIENTOS " + Decenas(decenas);
  }

  return Decenas(decenas);
}//Centenas()

function Seccion(num, divisor, strSingular, strPlural){
  cientos = Math.floor(num / divisor)
  resto = num - (cientos * divisor)

  letras = "";

  if (cientos > 0)
    if (cientos > 1)
      letras = Centenas(cientos) + " " + strPlural;
    else
      letras = strSingular;

  if (resto > 0)
    letras += "";

  return letras;
}//Seccion()

function Miles(num){
  divisor = 1000;
  cientos = Math.floor(num / divisor)
  resto = num - (cientos * divisor)

  strMiles = Seccion(num, divisor, "UN MIL", "MIL");
  strCentenas = Centenas(resto);

  if(strMiles == "")
    return strCentenas;

  return strMiles + " " + strCentenas;

}//Miles()

function Millones(num){
  divisor = 1000000;
  cientos = Math.floor(num / divisor)
  resto = num - (cientos * divisor)

  strMillones = Seccion(num, divisor, "UN MILLON", "MILLONES");
  strMiles = Miles(resto);

  if(strMillones == "")
    return strMiles;

  return strMillones + " " + strMiles;

}//Millones()

function NumeroALetras(num){
  var data = {
    numero: num,
    enteros: Math.floor(num),
    centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
    letrasCentavos: "",
    letrasMonedaPlural: "",
    letrasMonedaSingular: ""
  };

  if (data.centavos > 0)
    data.letrasCentavos = "CON " + data.centavos + "/100 ";

  if(data.enteros == 0)
    return "CERO " + data.letrasMonedaPlural + " " + data.letrasCentavos + "";
  if (data.enteros == 1)
    return Millones(data.enteros) + " " + data.letrasMonedaSingular + " " + data.letrasCentavos;
  else
    return Millones(data.enteros) + " " + data.letrasMonedaPlural + " " + data.letrasCentavos ;
}//NumeroALetras()
