var _token = $('input[name="_token"]').val();
const headers = new Headers({
    "Accept": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": _token
})


$(function() {
    $('#id_doc').select2();
    $('#provider_id').select2();

  //-----------------------------------------------------------
  $("#form input[name='date_delivery']").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    locale: {
        format: 'DD-MM-YYYY'
    },
    autoUpdateInput: false
  }, function (chosen_date) {
      $("#form input[name='date_delivery']").val(chosen_date.format('DD-MM-YYYY'));
  });

});

$('#id_doc').on('change', function(){
    let doc_id = $(this).val();
	getProductsFromProjectsByProvider(doc_id);
	getProvidersFromProject(doc_id);
})

function getProvidersFromProject(doc_id){

    var miInit = {
        method: 'get',
        headers: headers,
        credentials: "same-origin",
        cache: 'default' };

        
    fetch(`/purchases/getProvidersFromProject/doc_id/${doc_id}`, miInit)
        .then(function(response){
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(function(data){
            console.log(data);
        })
        .catch(function(error){
            Swal.showValidationMessage(
                `Request failed: ${error}`
            )
        });
}

function getProductsFromProjectsByProvider(doc_id){

    var miInit = {
        method: 'get',
        headers: headers,
        credentials: "same-origin",
        cache: 'default' };

        
    fetch(`/purchases/getProductsFromProjectsByProvider/doc_id/${doc_id}`, miInit)
        .then(function(response){
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(function(data){
            console.log(data);
            generate_table_products(data);
        })
        .catch(function(error){
            Swal.showValidationMessage(
                `Request failed: ${error}`
            )
        });
}

function generate_table_products(products){
    let subtotal = 0.0;
    let descuento = 0.0;
    let iva = 0.0;
    let total = 0.0;
    
    $("#tabla_productos tbody tr").remove();

    $.each(products, function( i, key ) {
        let cantidad = parseInt(key.cantidad);
        subtotal += parseFloat(key.total);
        descuento += parseFloat(key.descuento);
        total += parseFloat(key.total);
        
        $('#tabla_productos tbody').append(`
            <tr>
                <td id='${key.product_id}'><input value="${key.product_id}" class="product_id" type="hidden"></td>
                <td><input onblur="update_cantidades(this);"  value="${cantidad}" type="number" class="form-control form-control-sm cantidad" min="1" max="${cantidad}" required style="width:60px;text-align: right;"></td>
                <td class="producto">${key.producto}</td>
                <td class="text-right precio">${key.precio}</td>
                <td class="text-right code">${key.code}</td>
                <td class="text-center descuento">${key.descuento}</td>
				<td class="text-right subtotal">${key.total}</td>
				<td><button type="button" onclick="deleteRow(this);" class="btn borrar" data-id="' + key.id + '" href="#"><i class="fa fa-trash text-danger"></i></button></td></td>
            </tr>
            `
        );
    });
    $('#descuento').text(format_number(descuento));
	$('#subtotal').text(format_number(total));
	$('#total').text(format_number(total - descuento));
    
}

$("#form").on("submit", function(e){
    e.preventDefault();
    
    Swal.fire({
        title: "¿Estás seguro?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          
          var _token = $('input[name="_token"]').val();
          
          var element = {}
          var products = [];
  
          $('#tabla_productos tbody tr').each(function(row, tr){
            let product_id = $(tr).find('.product_id').val();
            let cantidad = $(tr).find('.cantidad').val();
            let precio = $(tr).find('.precio').text();
            let subtotal = $(tr).find('.subtotal').text();
            let descuento = $(tr).find('.descuento').text();
            let total = $(tr).find('.total').text();
            
            element = {
              "product_id" : product_id,
              "cantidad" : cantidad,
              "precio" : precio,
              "subtotal" : subtotal,
              "descuento" : descuento,
              "total" : parseFloat(total)        
            }
      
            products.push(element);
      
          });
          
          let form = $('#form')[0];
          let formData = new FormData(form);
      
          formData.append('products',JSON.stringify(products)); 
          formData.append('total',remove_commas($('#total').text()));
  
          const headers = new Headers({        
             "Accept": "application/json",
             "X-Requested-With": "XMLHttpRequest",
             "X-CSRF-TOKEN": _token
          })
  
          var miInit = { method: 'post',
                             headers: headers,
                             credentials: "same-origin",
                             body:formData,
                             cache: 'default' };

                             
  
           return fetch('/purchases/store-order', miInit)
                 .then(function(response){
                   if (!response.ok) {
                      throw new Error(response.statusText)
                    }
                   return response.text();
                 })
                 .catch(function(error){
                   Swal.showValidationMessage(
                     `Request failed: ${error}`
                   )
                 });
        }//Preconfirm
      }).then((result) => {
        console.log(result.value);
        if (result.value == "true") {
          Swal.fire({
            title: 'Orden de compra guardada',
            text: "",
            type: 'success',
          }).then(function (result) {
            if (result.value) {
              window.location = "/purchases/view_purchase_order";
            }
          })
        }else{
          Swal.fire(
            'No se guardo la orden de compra','','warning'
          )
        }
      })
})

// Funcion para mofdificar datos al actualizar una cantidad de la tabla de pedidos
function update_cantidades(e){
	let tr = e.parentNode.parentNode;
	let precio = parseFloat($(tr).find('.precio').text());
	let subtotal = 0.0;
	let descuento = $(tr).find('.descuento').text();
	let cantidad = parseInt($(tr).find('.cantidad').val());
	
	subtotal = cantidad * precio;
	
	total = subtotal - percent(descuento, subtotal);
	$(tr).find('.subtotal').text(total.toFixed(2));

    sumaTotales();  
}

function sumaTotales(){
	let element = {}
	let products = [];
	let total_products = 0.0;
	let subtotal = 0.0;
	let descuento = 0.0;
	$('#tabla_productos tbody tr').each(function(row, tr){
		let product_id = $(tr).find('.product_id').val();
		let cantidad = $(tr).find('.cantidad').val();
		let precio = $(tr).find('.precio').text();
		let descuento = $(tr).find('.descuento').text();
		let total = $(tr).find('.subtotal').text();
		
		element = {
		  "product_id" : product_id,
		  "cantidad" : cantidad,
		  "precio" : precio,
		  "descuento" : descuento,
		  "total" : parseFloat(total)        
		}
		products.push(element);
	});

	products.forEach(function(product){
		total_products += parseFloat(product.total);
		descuento += parseFloat(product.descuento);
	});

	$('#descuento').text(format_number(descuento));
	$('#subtotal').text(format_number(total_products));
	$('#total').text(format_number(total_products - descuento));
}

//Calculo de porcentaje
function percent(num, amount){
  return (num * amount) / 100;
}

function deleteRow(fila) {
    var row = fila.parentNode.parentNode;
	row.parentNode.removeChild(row);
	sumaTotales();
}

//Formato numerico: 00,000.00
function format_number(number){
    return number.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function remove_commas(number){
  return number.replace(/,/g, "");
}

/*********************** MODAL DE DIRECCIONES **************************/

$('#modal-address-button').on('click', function(){
	$('#modalAddress').modal('show');
})

$('#form-add-address-delivery').on('submit', function(e){
	e.preventDefault();
	var form = $('#form-add-address-delivery')[0];
	var formData = new FormData(form);
	      
	$.ajax({
		type: "POST",
		url: "/purchases/add-address-delivery",
		data: formData,
		contentType: false,
	    processData: false,
		success: function (data){
			Swal.fire('Direccion guardada', '', 'success');
			location.reload();	
		},
		error: function (err) {
			Swal.fire({
				type: 'error',
				title: 'Oops...',
				text: err.statusText,
			});
		}

	});
})

