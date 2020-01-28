function enviar(e){
  var element = e;
  var _token = $('input[name="_token"]').val();

  const headers = new Headers({
    "Accept": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": _token
  })

  var miInit = { method: 'get',
                    headers: headers,
                    credentials: "same-origin",
                    cache: 'default' };

  let id_documentp = element.dataset.id;
  let id_cart = element.dataset.cart;

  
  data_table_products(miInit, id_documentp, id_cart);
  data_header(miInit, id_documentp);
  data_table_project_advance(miInit, id_documentp);
  data_status_users(miInit, id_documentp);
  data_deny(miInit, id_documentp);

  $('#modal-view-concept').modal('show');

  $('.set-cant-req').on('shown', function() {
      var $innerForm = $(this).data('editable').input.$input.closest('form');
      var $outerForm = $innerForm.parents('form').eq(0);
      $innerForm.data('validator', $outerForm.data('validator'));
  });

}

function addCommentModal(e){
  var element = e;
  let id_documentp = element.dataset.id;
  var _token = $('input[name="_token"]').val();
 console.log(id_documentp);
  document.getElementById('comment').value = '';

  const headers = new Headers({
    "Accept": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": _token
  })

  var miInit = { method: 'get',
                 headers: headers,
                 credentials: "same-origin",
                 cache: 'default' };

      fetch(`/get_comment_documentp_advance/id_doc/${id_documentp}`,  miInit)
        .then(response => {
          return response.json();
        })
        .then(data => {
            document.getElementById('id_doc').value = id_documentp;
            document.getElementById('comment').value = data[0].comentario_manager;
            $('#modal-add-comment').modal('show');
        })
        .catch(error => {
          console.log(error);
        })

}

$('#addComment').on('click', function(e){
  e.preventDefault();
  var _token = $('input[name="_token"]').val();
  let id_documentp = document.getElementById('id_doc').value;
  let comment = document.getElementById('comment').value;
 
  const headers = new Headers({
    "Accept": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": _token
  })
  var form = $('#form_add_comment')[0];
  var formData = new FormData(form);
  formData.append('id_doc', id_documentp);
 
  var miInit = { method: 'post',
                    headers: headers,
                    body: formData,
                    credentials: "same-origin",
                    cache: 'default' };

      fetch(`/set_comment_documentp_advance`,  miInit)
        .then(response => {
          return response.text();
        })
        .then(data => {
          console.log(data);
          if(data == "true"){
            menssage_toast('Mensaje', '3', 'Comentario agregado' , '2000');
          }else{
            menssage_toast('Mensaje', '2', 'Error inesperado' , '2000');
          }
        })
        .catch(error => {
          console.log(error);
        })

})

async function deny_docp(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();

  const {value: text} = await Swal.fire({
    title: 'Denegar documento',
    input: 'textarea',
    inputPlaceholder: 'Escriba un comentario para denegar el documento...',
    showCancelButton: true
  })

  if (text) {
    $.ajax({
      type: "POST",
      url: "/deny_documentp",
      data: { idents: valor, comm: text, _token : _token },
      success: function (data){
        if (data === 'true') {
          Swal.fire('Operación completada', 'El documento a sido denegado', 'success');
          table_permission_one();
        }
        if (data === 'false') {
        Swal.fire('Oops', '', 'Error');
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }else {
    Swal.fire('Debe escribir un comentario', '', 'warning');
  }

}

function editar(e){
  var element = e;
  var _token = $('input[name="_token"]').val();
  let id_documentp = element.dataset.id;
  var form = $('#form_edit_docp');
  $('#id_docp').val(id_documentp);

  form.submit();

}

function get_extension_file(filename){
	return filename.split('.').pop();
}

async function uploadActaEntrega(e){
  var element = e;
  let id_documentp = element.dataset.id;
  var _token = $('input[name="_token"]').val();

  const headers = new Headers({
    "Accept": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": _token
  })

  const { value: file } = await Swal.fire({
    title: 'Subir acta de entrega',
    input: 'file',
    inputAttributes: {
      accept: '.pdf , .doc , .docx',
      'aria-label': 'Buscar archivo'
    }
  })

  var initGet = { method: 'GET',
				headers: headers,
				credentials: "same-origin",
				cache: 'default' };
			
  // REVISO SI EL PROYECTO YA TIENE UNA ACTA DE ENTREGA SUBIDA
  const checkActaEntrega = await fetch(`/checkActaEntregaUpload/${id_documentp}`,  initGet)
  .then(result => result.json())
  .then(data => {
	  return data;
  });
  
  // SI EL USUARIO SELECCIONO UN ARCHIVO SE VALIDA LA EXTENSION Y SE PROCEDE A GUARDAR
  if (file) {
    var formData = new FormData();
    formData.append('id_documentp', id_documentp);
	formData.append('file', file);
	
    var init = { method: 'POST',
				headers: headers,
				credentials: "same-origin",
				body: formData,
				cache: 'default' };
	let extension = get_extension_file(file.name);

	if(extension == 'doc' || extension == 'docx' || extension == 'pdf'){
		
		if(checkActaEntrega == false){
			fetch(`/uploadActaEntrega`,  init)
				.then(response => {
					if(response.ok){
						Swal.fire('Archivo guardado', file.name,'success');
					}else{
						Swal.fire('Ocurrio un error','','error');
					}		
				})
				.catch(error => {
					console.log(error);
				}) 
		}else{
			Swal.fire({
				title: 'Este documento ya tiene un acta de entrega',
				text: "Desea sustituir el archivo existente?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Si, sustituir archivo!',
				cancelButtonText: 'Cancelar'
			  }).then((result) => {
				if (result.value) {
					fetch(`/uploadActaEntrega`,  init)
					.then(response => {
						if(response.ok){
							Swal.fire('Archivo guardado', file.name,'success');
						}else{
							Swal.fire('Ocurrio un error','','error');
						}		
					})
					.catch(error => {
						console.log(error);
					}) 
				}
			  })
		}
		 
	}else{
		Swal.fire('Archivo no valido', 
				'Solo puede subir archivos con las siguientes extensiones: .pdf, .doc, .docx' , 
				'warning');
	}                  
	              
  }else{
    Swal.fire('No selecciono ningun archivo', '' , 'warning');
  }

}

function downloadActaEntrega(e){
  var element = e;
  let id_documentp = element.dataset.id;
  var token = $('input[name="_token"]').val();

  $.ajax({
    type: "POST",
    url: "/downloadActaEntrega",
    data: { id_documentp : id_documentp , _token : token },
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
		}else{
			Swal.fire("El archivo no existe", "", "warning");
		}
		},
		error: function (response) {

		}

    });
}


function kickoff(e){
  var element = e;
  var _token = $('input[name="_token"]').val();
  let id_documentp = element.dataset.id;
  var form = $('#form_edit_kickoff');
  $('#id_doc_3').val(id_documentp);

  form.submit();

}

function editar_cotizador(e){
  var element = e;
  var _token = $('input[name="_token"]').val();
  let id_documentp = element.dataset.id;
  var form = $('#form_edit_cotizador');
  $('#id_docp_2').val(id_documentp);
  form.submit();
}

function data_header(miInit, id_documentp){

  fetch(`/documentp_header/data/${id_documentp}`,  miInit)
      .then(response => {
        return response.json();
      })
      .then(data => {
        if(data == null || data == '[]'){
          $('#id_doc').val('');
          $('#tipo_doc').text('');
          $('#fecha').text('');
          $('#folio').text('');
          $('#itc').text('');
          $('#comercial').text('');
          $('#proyecto').text('');
          $('#vertical').text('');
          $('#tipo').text('');
          $('#instalacion').text('');
          $('#densidad').text('');
          $('#sitios').text('');
          $('#num_oportunidad').text('');
          $('#comentario_compras').text('');
        }else{
          let type_doc = data[0].doc_type;
          type_doc == 1 ? $('#tipo_doc').text('Documento P') : $('#tipo_doc').text('Documento M');
          let nombre_proyecto = data[0].nombre_proyecto;
          nombre_proyecto == null ?   $('#proyecto').text(data[0].anexo) :  $('#proyecto').text(data[0].nombre_proyecto);
          //Formatear la fecha
          var fechainvertida=invertirFecha(data[0].fecha);
          $('#comentario_compras').text(data[0].comentario_compras);
          $('#fecha').text(fechainvertida);
          $('#id_doc').val(data[0].id);
          $('#folio').text(data[0].folio);
          $('#itc').text(data[0].ITC);
          $('#comercial').text(data[0].comercial);
          $('#vertical').text(data[0].vertical);
          $('#tipo').text(data[0].tipo_servicio);
          $('#instalacion').text(data[0].lugar_instalacion);
          $('#densidad').text(data[0].densidad);
          $('#sitios').text(data[0].sitios);
          $('#num_oportunidad').text(data[0].num_oportunidad);
          
           let id_documentp = data[0].id;
           document.getElementById('button_history').dataset.id = id_documentp;
        }

      })
      .catch(error => {
        console.log(error);
      })
}

function data_deny(miInit, id_documentp){

  fetch(`/documentp_header/data_deny/${id_documentp}`,  miInit)
      .then(response => {
        return response.json();
      })
      .then(data => {
        $('#observaciones').html('');
        if(data != null || data != '[]'){
          let html = `<ul>`;
          $.each(data, function( i, key ) {
            html +=`<li>` + key.name + ` - ` + key.description + ` - ` + invertirFecha(key.created_at.split(" ")[0])+ " " + key.created_at.split(" ")[1]  + `</li`;
          })
          html +=`</ul>`;
          $('#observaciones').html(html);
        }else{

        }

      })
      .catch(error => {
        console.log(error);
      })
}

function data_status_users(miInit, id_documentp){
  var reviso, autorizo, entrego = [];

  fetch(`/documentp_header/data_status_user/${id_documentp}`,  miInit)
      .then(response => {
        return response.json();
      })
      .then(data => {
        $('#reviso').html('');
        $('#autorizo').html('');
        $('#entrego').html('');
        if(data != null && data != '[]'){
          var html= `<ul>`;
          var html2= `<ul>`;
          var html3= `<ul>`;
          reviso = data.filter(val => val.status_id == 2);
          autorizo = data.filter(val => val.status_id == 3);
          entrego = data.filter(val => val.status_id == 5);

          $.each(reviso, function( i, key ) {
            html +=`<li>` + key.name + ` - ` + invertirFecha(key.created_at.split(" ")[0])+ " " + key.created_at.split(" ")[1]  + `</li>`;
          })
          html +=`</ul>`;
          $('#reviso').html(html);

          $.each(autorizo, function( i, key ) {
            html2 +=`<li>` + key.name + ` - ` + invertirFecha(key.created_at.split(" ")[0])+ " " + key.created_at.split(" ")[1]  + `</li>`;
          })
          html2 +=`</ul>`;
          $('#autorizo').html(html2);

          $.each(entrego, function( i, key ) {
            html3 +=`<li>` + key.name + ` - ` + invertirFecha(key.created_at.split(" ")[0])+ " " + key.created_at.split(" ")[1] + `</li>`;
          })
          html3 +=`</ul>`;
          $('#entrego').html(html3);

        }else{
          $('#reviso').html('');
          $('#autorizo').html('');
          $('#entrego').html('');
        }

      })
      .catch(error => {
        console.log(error);
      })
}

function data_table_products(miInit, id_documentp, id_cart){

  fetch(`/documentp_table_products/${id_documentp}/${id_cart}`,  miInit)
      .then(response => {
        return response.text();
      })
      .then(html => {
        $('#data_products').html(html);
      })
      .catch(error => {
        console.log(error);
      })
}

function data_table_project_advance(miInit, id_documentp){
  fetch(`/documentp_table_project_advance/id_doc/${id_documentp}`,  miInit)
      .then(response => {
        return response.text();
      })
      .then(html => {
        $('#data_installation').html(html);
      })
      .catch(error => {
        console.log(error);
      })

}

function save_comentario_compras(){

  fetch(`/documentp_table_project_advance/id_doc/${id_documentp}`,  miInit)
      .then(response => {
        return response.text();
      })
      .then(html => {
        $('#data_installation').html(html);
      })
      .catch(error => {
        console.log(error);
      })

}

function show_logs(e){
  var element = e;
  var _token = $('input[name="_token"]').val();

  const headers = new Headers({
    "Accept": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": _token
  })

  var miInit = { method: 'get',
                    headers: headers,
                    credentials: "same-origin",
                    cache: 'default' };

  let id_documentp = element.dataset.id;

  data_table_logs(miInit, id_documentp);

  $('#modal-logs').modal('show');

}

function show_logs_projects_advance(e){
  var element = e;
  id_documentp = document.getElementById('id_doc').value;
  var _token = $('input[name="_token"]').val();

  const headers = new Headers({
    "Accept": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": _token
  })

  var miInit = { method: 'get',
                    headers: headers,
                    credentials: "same-origin",
                    cache: 'default' };

  //let id_documentp = element.dataset.id;

  data_table_logs_advance_projects(miInit, id_documentp);

  $('#modal-logs_advance').modal('show');

}



function data_table_logs(miInit, id_documentp){

  fetch(`/documentp_table_logs/data/${id_documentp}`,  miInit)
      .then(response => {
        return response.json();
      })
      .then(data => {
        $("#table_documentp_logs tbody").empty();
        $.each(data, function( i, key ) {
          $('#table_documentp_logs tbody').append(
            '<tr><td>' + key.created_at + '</td><td>'
            + key.cantidad_anterior + '</td><td>'
            + key.cantidad_actual + '</td><td>'
            + key.descripcion + '</td><td>'
            + key.accion + '</td><td>'
            + key.usuario + '</td></tr>'
            );
         });
      })
      .catch(error => {
        console.log(error);
      })
}

function data_table_logs_advance_projects(miInit, id_documentp){

  fetch(`/documentp_table_logs_advance_projects/data/${id_documentp}`,  miInit)
      .then(response => {
        return response.json();
      })
      .then(data => {
        $("#table_documentp_logs_advance tbody").empty();
        $.each(data, function( i, key ) {
          $('#table_documentp_logs_advance tbody').append(
            '<tr><td>' + key.created_at + '</td><td>'
            + key.name + '</td>'
            );
         });
      })
      .catch(error => {
        console.log(error);
      })
}




var Configuration_table_responsive_logs= {
        "order": [[ 0, "desc" ]],
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
              "width": "0.5%",
              "className": "text-center",
            },
            {
              "targets": 2,
              "width": "0.5%",
              "className": "text-right",
            },
            {
              "targets": 3,
              "width": "1.5%",
              "className": "text-right",
            },
            {
              "targets": 4,
              "width": "0.5%",
              "className": "text-right",
            },
            {
              "targets": 5,
              "width": "0.5%",
              "className": "text-right",
            }
        ],
        dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [

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
//Formatea la fecha dd/mm/aa
    function invertirFecha(f) {
       var fechaDividida = f.split("-");
       var fechaInvertida = fechaDividida.reverse();
       return fechaInvertida.join("-");
   }

// FIX SCROLLBAR MODAL
$(document).on('hidden.bs.modal', '.modal', function () {
    $('.modal:visible').length && $(document.body).addClass('modal-open');
});
