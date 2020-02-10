$(function() {
	$("#form").validate({
	  ignore: "input[type=hidden]",
	  errorClass: "text-danger",
	  successClass: "text-success",
	  errorPlacement: function (error, element) {
	      var attr = $('[name="'+element[0].name+'"]').attr('datas');
	      if (element[0].id === 'fileInput') {
	        error.insertAfter($('#cont_file'));
	      }
	      else {
	        if(attr == 'filter_date_from'){
	          error.insertAfter($('#date_from'));
	        }
	        else if (attr == 'filter_date_to'){
	          error.insertAfter($('#date_to'));
	        }
	        else {
	          error.insertAfter(element);
	        }
	      }
	    },
	    rules: {

	    },
	    messages: {
	    },
	    // debug: true,
	    // errorElement: "label",
	    submitHandler: function(e){
	      var form = $('#form')[0];
	      var formData = new FormData(form);
	      formData.append('filter_status', '2');
	      $.ajax({
	        type: "POST",
	        url: "/purchases/view_purchases_search",
	        data: formData,
	        contentType: false,
	        processData: false,
	        success: function (data){
	          // if (typeof data !== 'undefined' && data.length > 0) {console.log(data.length);}else {}
	          // console.log(data);
	          gen_payments_table(data, $("#table_filter_fact"));
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
	});
	gen_purchases_auto();
});

var Configuration_table_responsive_purchases_1= {
  "order": [[ 1, "asc" ]],
  "select": true,
  "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  "columnDefs": [
		{ //Subida 1
		  "targets": 0,
		  "checkboxes": {
		    'selectRow': true
		  },
		  "width": "0.1%",
		  "createdCell": function (td, cellData, rowData, row, col){
		    if ( cellData > 1 ) {
		      if(rowData[9] != 'Revisado'){
		        this.api().cell(td).checkboxes.disable();
		      }
		    }
		  }
		},
		{
		  "targets": 1,
		  "width": "0.5%",
		  "className": "text-center",
		},
		{
		  "targets": 2,
		  "width": "1%",
		  "className": "text-center",
		},
		{
		  "targets": 3,
		  "width": "0.2%",
		  "className": "text-center",
		},
		{
		  "targets": 4,
		  "width": "1%",
		  "className": "text-center",
		},
		{
		  "targets": 5,
		  "width": "1%",
		  "className": "text-center",
		},
		{
		  "targets": 6,
		  "width": "0.3%",
		  "className": "text-center",
		},
		{
		  "targets": 7,
		  "width": "0.5%",
		  "className": "text-center",
		},
		{
		  "targets": 8,
		  "width": "0.5%",
		  "className": "text-center",
		},
		{
		  "targets": 9,
		  "visible": false,
		  "searchable": false
		}
  ],
  "select": {
    'style': 'multi',
  },
  dom: "<'row'<'col-sm-6'B><'col-sm-2'l><'col-sm-4'f>>" +
  "<'row'<'col-sm-12'tr>>" +
  "<'row'<'col-sm-5'i><'col-sm-7'p>>",
  buttons: [
    {
      text: '<i class="fa fa-check margin-r5"></i> Autorizar Marcados',
      titleAttr: 'Autorizar Marcados',
      className: 'btn btn-warning',
      init: function(api, node, config) {
        $(node).removeClass('btn-default')
      },
      action: function ( e, dt, node, config ) {
        // $('#modal-confirmation').modal('show');
        Swal.fire({
          title: "¿Estás seguro?",
          text: "Se autorizarán todas las solicitudes seleccionadas!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Continuar",
          cancelButtonText: "Cancelar!"
        }).then((result) => {
          if(result.value){
            $('.cancel').prop('disabled', 'disabled');
            $('.confirm').prop('disabled', 'disabled');
            var rows_selected = $("#table_filter_fact").DataTable().column(0).checkboxes.selected();
            var _token = $('input[name="_token"]').val();
            // Iterate over all selected checkboxes
            var valores= new Array();
            $.each(rows_selected, function(index, rowId){
              valores.push(rowId);
            });
            // console.log(valores);
            if ( valores.length === 0){
              Swal.fire("Operación abortada", "No se seleccionó una compra :(", "error");
            }
            else {
            	// console.log('si hay checkboxes');
				$.ajax({
					type: "POST",
					url: "/purchases/send_purchase_two",
					data: { idents: JSON.stringify(valores), _token : _token },
					success: function (data){
						// console.log(data);
					  if (data === 'true') {
					    Swal.fire("Operación Completada!", "Las solicitudes seleccionadas han sido afectadas.", "success");
					    gen_purchases_auto();
					  }
					  if (data === 'false') {
					    swal("Operación abortada!", "Las solicitudes seleccionadas no han sido afectadas.", "error");
					  }
					},
					error: function (data) {
					  console.log('Error:', data);
					}
				});
            }
          }
        })
      }
    },
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

function gen_payments_table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_purchases_1);
  vartable.fnClearTable();
  // console.log(datajson);
  $.each(datajson, function(index, status){
    vartable.fnAddData([
        status.id,
        status.name,
        status.date,
        status.payment_terms,
        status.payment_methods,
        status.currencies,
        status.amount_total,
        // status.status,
        '<span class="badge badge-primary badge-pill px-1 text-white">'+status.estatus+'</span>',
        '<a href="javascript:void(0);" onclick="enviar(this, false)" value="'+status.id+'" class="btn btn-default btn-xs" role="button" data-target="#modal-concept"><span class="fa fa-eye"></span></a><a href="javascript:void(0);" onclick="enviartwo(this)" value="'+status.id+'" class="btn btn-danger btn-xs" role="button" data-target="#modal-deny" title="Denegar pago"><span class="fa fa-ban"></span></a>',
        status.estatus
      ]);
  });
}
function gen_purchases_auto() {
	var form = $('#form')[0];
	var formData = new FormData(form);
	formData.append('filter_status', '2');
	$.ajax({
		type: "POST",
		url: "/purchases/view_purchases_search",
		data: formData,
		contentType: false,
		processData: false,
		success: function (data){
		  // if (typeof data !== 'undefined' && data.length > 0) {console.log(data.length);}else {}
		  // console.log(data);
		  gen_payments_table(data, $("#table_filter_fact"));
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