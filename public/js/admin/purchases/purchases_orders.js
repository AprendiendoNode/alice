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
        total += parseFloat(key.total_usd);
        
        $('#tabla_productos tbody').append(`
            <tr>
                <td id='${key.product_id}'><input value="${key.product_id}" class="product_id" type="hidden"></td>
                <td><input value="${cantidad}" type="number" class="form-control form-control-sm cantidad" min="1" max="${cantidad}" required style="width:60px;text-align: right;"></td>
                <td class="producto">${key.producto}</td>
                <td class="text-right precio">${key.precio}</td>
                <td class="text-right subtotal">${key.total}</td>
                <td class="text-center descuento">${key.descuento}</td>
                <td class="text-right total">${key.total_usd}</td>
                <td><button type="button" onclick="deleteRow(this);" class="btn borrar" data-id="' + key.id + '" href="#"><i class="fa fa-trash text-danger"></i></button></td></td>
            </tr>
            `
        );
    });
    $('#subtotal').text(format_number(subtotal));
    $('#descuento').text(format_number(descuento));
    $('#iva').text(format_number(iva));
    $('#total').text(format_number(total));
    
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
          console.log(products);
          let form = $('#form')[0];
          let formData = new FormData(form);
      
          formData.append('products',JSON.stringify(products)); 
  
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

function deleteRow(fila) {
    var row = fila.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

//Formato numerico: 00,000.00
function format_number(number){
    return number.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function remove_commas(number){
  return number.replace(/,/g, "");
}


