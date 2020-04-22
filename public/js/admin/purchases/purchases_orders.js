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
    let doc_id = $(this).val()
    let provider_id = $('#provider_id').val();
    getProvidersFromProject(doc_id);
    getProductsFromProjectsByProvider(doc_id, provider_id);
})

$('#provider_id').on('change', function(){
  let doc_id = $('#id_doc').val();
  let provider_id = $(this).val();

  getProductsFromProjectsByProvider(doc_id, provider_id);
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
          $('#provider_id').empty();
          $('#provider_id').append(`<option value="">Elige un proveedor</option>`);
          $.each(data, function(i, key) {
            $('#provider_id').append(`<option value="${key.id}">${key.proveedor}</option>`);
        });
            console.log(data);
        })
        .catch(function(error){
            Swal.showValidationMessage(
                `Request failed: ${error}`
            )
        });
}

function getProductsFromProjectsByProvider(doc_id, provider_id){

    var miInit = {
        method: 'get',
        headers: headers,
        credentials: "same-origin",
        cache: 'default' };

        
    fetch(`/purchases/getProductsFromProjectsByProvider/doc_id/${doc_id}/provider_id/${provider_id}`, miInit)
        .then(function(response){
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(function(data){
            generate_table_products(data);
        })
        .catch(function(error){
            Swal.showValidationMessage(
                `Request failed: ${error}`
            )
        });
}

function generate_table_products(products){

    $("#tabla_productos tbody tr").remove();

    $.each(products, function( i, key ) {
        let cantidad = parseInt(key.cantidad);
        let descuento = parseInt(key.descuento);
        let precio = parseFloat(key.precio);
        let subtotal = precio * cantidad;
        let percent_amount = percent(descuento, subtotal);

        $('#tabla_productos tbody').append(`
            <tr>
                <td id='${key.product_id}'><input value="${key.product_id}" class="product_id" type="hidden"></td>
                <td class="text-center">${cantidad}</td>
                <td><input onblur="update_cantidades(this);"  value="${cantidad}" type="number" class="form-control form-control-sm cantidad" min="1" max="${cantidad}" required style="width:60px;text-align: right;"></td>
                <td class="producto">${key.product}</td>
                <td class="text-right precio">${precio}</td>
                <td class="text-right code">${key.currencies.substring(0, 3)}</td>
                <td class="text-right subtotal">${subtotal.toFixed(2)}</td>
                <td><input style="width:50px" onblur="update_cantidades(this);" value="${key.descuento}" class="descuento_percent form-control form-control-sm" type="number"></td>
                <td class="text-center descuento">${percent_amount.toFixed(2)}</td>
				        <td class="text-right total">${key.total}</td>
				        <td><button type="button" onclick="deleteRow(this);" class="btn borrar" data-id="' + key.id + '" href="#"><i class="fa fa-trash text-danger"></i></button></td>
            </tr>
            `
        );
    });

    sumaTotales();
    
}

$("#form").on("submit", function(e){
  e.preventDefault();

  var _token = $('input[name="_token"]').val();   
  var element = {}
  let products = [];
  let currencies = [];

  $('#tabla_productos tbody tr').each(function(row, tr){
    let product_id = $(tr).find('.product_id').val();
    let cantidad = $(tr).find('.cantidad').val();
    let precio = $(tr).find('.precio').text();
    let currency = $(tr).find('.code').text();
    let subtotal = $(tr).find('.subtotal').text();
    let descuento = $(tr).find('.descuento').text();
    let descuento_percent = $(tr).find('.descuento_percent').val();
    let total = $(tr).find('.total').text();
    
    element = {
      "product_id" : product_id,
      "cantidad" : cantidad,
      "precio" : precio,
      "code" : currency,
      "subtotal" : subtotal,
      "descuento" : descuento,
      "descuento_percent" : descuento_percent,
      "total" : parseFloat(total)        
    }

    products.push(element);
    currencies.push(element.code);

  });

  var uniqueItems = Array.from(new Set(currencies));

  if(uniqueItems.length === 1){
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
        
          let form = $('#form')[0];
          let formData = new FormData(form);
      
          formData.append('products',JSON.stringify(products)); 
          formData.append('subtotal',remove_commas($('#subtotal').text()));
          formData.append('descuento',remove_commas($('#descuento').text()));
          formData.append('iva',remove_commas($('#iva').text()));
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
  }else{
    Swal.fire('Orden con diferentes monedas','La orden de compra solo deben tener productos de una sola moneda', 'error');
  }
  
  
})

// Funcion para mofdificar datos al actualizar una cantidad de la tabla de pedidos
function update_cantidades(e){
  let tr = e.parentNode.parentNode;
  let precio = parseFloat($(tr).find('.precio').text());
  let cantidad = parseInt($(tr).find('.cantidad').val());
  let descuento = parseFloat($(tr).find('.descuento_percent').val());
  let total = 0.0;
  let subtotal = precio * cantidad;
 
  let percent_amount = percent(descuento, subtotal);
  total = subtotal - percent_amount;

  $(tr).find('.subtotal').text(subtotal.toFixed(2));
  $(tr).find('.descuento').text(percent_amount.toFixed(2));
  $(tr).find('.total').text(total.toFixed(2));

  sumaTotales();  
}

function sumaTotales(){
  let element = {}
  let products = [];
  let total_products = 0.0;
  let total_subtotal = 0.0;
  let total_descuento = 0.0;
  var iva = 0.0;
  $('#tabla_productos tbody tr').each(function(row, tr){
    let product_id = $(tr).find('.product_id').val();
    let cantidad = $(tr).find('.cantidad').val();
    let precio = $(tr).find('.precio').text();
    let descuento = $(tr).find('.descuento').text();
    let subtotal = $(tr).find('.subtotal').text();
    let total = $(tr).find('.total').text();
    
    element = {
      "product_id" : product_id,
      "cantidad" : cantidad,
      "precio" : precio,
      "descuento" : descuento,
      "subtotal" : subtotal,
      "total" : parseFloat(total)        
    }
    products.push(element);
  });

  products.forEach(function(product){
    total_subtotal += parseFloat(product.subtotal);
    total_descuento += parseFloat(product.descuento);
    total_products += parseFloat(product.total);
  });

  iva = total_products * .16;
  
  $('#descuento').text(format_number(total_descuento));
  $('#subtotal').text(format_number(total_subtotal));
  $('#iva').text(format_number(iva));
  $('#total').text(format_number(total_products + iva));
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

//Filtrar valores unicos

function onlyUnique(value, index, self) { 
  return self.indexOf(value) === index;
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

