//Configuracion de x-editable jquery
$.fn.editable.defaults.mode = 'popup';
$.fn.editable.defaults.ajaxOptions = {type:'POST'};

var _token = $('input[name="_token"]').val();
const headers = new Headers({
  "Accept": "application/json",
  "X-Requested-With": "XMLHttpRequest",
  "X-CSRF-TOKEN": _token
})

const miInit = { method: 'get',
                  headers: headers,
                  credentials: "same-origin",
                  cache: 'default' };
$(function() {
  get_shopping_cart();
 });

 function get_shopping_cart(){
   let id = $('#id_documentp').val();

   fetch(`/get_shopping_cart/id/${id}`, miInit)
         .then(function(response){
           return response.json();
         })
         .then(function(products){
           localStorage.clear();
           console.log(products);
           products.forEach(product => {
             let producto = {
                 id: product.product_id,
                 id_key: product.id,
                 descripcion: product.producto,
                 codigo: product.code,
                 precio: product.precio,
                 categoria: product.categoria,
                 categoria_id: product.categoria_id,
                 num_parte: product.num_parte,
                 currency: product.currency,
                 currency_id: product.currency_id,
                 proveedor: product.proveedor,
                 descuento: product.descuento,
                 cant_sug: parseFloat(product.cantidad_sugerida),
                 cant_req: parseFloat(product.cantidad),
                 precio_total : product.total,
                 precio_total_usd : product.total_usd
             }
             addProductCart(producto);

           });


         })
         .catch(function(error){
                 console.log(error);
         });

 }

 function addProductCart(producto){
    addProductLocalStorage(producto);
 }

 function addProductLocalStorage(producto){
     let productos;

     productos = obtenerProductosLocalStorage();
     productos.push(producto);

     localStorage.setItem('productos', JSON.stringify(productos));
 }


/*
* Funciones para manipular productos del localStorage
* y tabla de productos de pedidos.
*/

//Tipo de cambio
function exchange_rate(){
   var tipo_cambio = document.getElementById('tipo_cambio').value;
   var productosLS = obtenerProductosLocalStorage();
   let productoNew = [];

   if(productosLS != '[]'){
     productosLS.forEach((productoLS, index) => {
       var descuento = parseInt(productoLS.descuento);
       var cant_req = parseFloat(productoLS.cant_req);
       var precio = parseFloat(productoLS.precio)
       var currency_id = productoLS.currency_id;
       var precioTotal = 0.0;
       productoNew = productoLS;

       if(currency_id == 1){
         precioTotal = precio * cant_req;
         precioTotal = precioTotal - percent(descuento, precioTotal);
         productoNew.precio_total_usd = ( precioTotal / parseFloat(tipo_cambio) ).toFixed(2);
         productosLS.splice(index, 1, productoNew);
       }

     })
     localStorage.setItem('productos', JSON.stringify(productosLS));

   }

}

//Calculo de porcentaje
function percent(num, amount){
  return (num * amount) / 100;
}

function sumaTotales(){
  var productosLS = obtenerProductosLocalStorage();
  var total_eqactivo = 0.0;
  var total_materiales = 0.0;
  var total_sitwifi = 0.0;
  var total_viaticos = 0.0;
  //Separo en diferentes arreglos del Local Storage  segun la clasificacion de un producto
  let equipo_activo = productosLS.filter(producto => producto.categoria_id == 4  || producto.categoria_id == 6 || producto.categoria_id == 14);
  let materiales= productosLS.filter(producto => producto.categoria_id != 4  && producto.categoria_id != 6 && producto.categoria_id != 7 && producto.categoria_id != 14 && producto.categoria_id != 15);
  let sitwifi= productosLS.filter(producto => producto.categoria_id == 7 );
  let viaticos = productosLS.filter(producto => producto.categoria_id == 15 );

  //Sumando totales por categorias
  equipo_activo.forEach(function(producto){
    total_eqactivo += parseFloat(producto.precio_total_usd);
  });
  materiales.forEach(function(producto){
    total_materiales += parseFloat(producto.precio_total_usd);
  });
  sitwifi.forEach(function(producto){
    total_sitwifi += parseFloat(producto.precio_total_usd);
  });
  viaticos.forEach(function(producto){
    total_viaticos += parseFloat(producto.precio_total_usd);
  });
  //Actualizando montos totales en el DOM
  document.getElementById("total_eqactivo").innerHTML = (total_eqactivo.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  document.getElementById("total_eqactivo_footer").innerHTML = (total_eqactivo.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

  document.getElementById("total_materiales").innerHTML =  (total_materiales.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  document.getElementById("total_materiales_footer").innerHTML = (total_materiales.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

  document.getElementById("total_sitwifi").innerHTML = (total_sitwifi.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  document.getElementById("total_sitwifi_footer").innerHTML = (total_sitwifi.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

  document.getElementById("total_viaticos").innerHTML = (total_viaticos.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  document.getElementById("total_viaticos_footer").innerHTML = (total_viaticos.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  //Total global
  document.getElementById("total_global").innerHTML = ((total_materiales + total_eqactivo + total_sitwifi + total_viaticos).toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

}

// Funcion para mofdificar datos al actualizar una cantidad de la tabla de pedidos
function update_cantidades(id, cant_req, oldValue){
  let tipo_cambio = document.getElementById('tipo_cambio').value;
  let productosLS;
  let currency_id = 0;
  let precio = 0.0;
  let precioTotal = 0.0;
  let precioTotalUSD = 0.0;
  let descuento = 0.0;
  let productoNew = [];
  var row_precio_total, row_precio_total_usd;
  productosLS = obtenerProductosLocalStorage();

  productosLS.forEach((productoLS, index) => {
      //Buscando producto a actualizar
      if(productoLS.id == id){
        productoNew = productoLS;
        precio = productoLS.precio;
        descuento = productoLS.descuento;
        precioTotal = parseFloat(cant_req) * parseFloat(precio);
        precioTotal -= percent(descuento, parseFloat(precioTotal));
        row_precio_total = document.getElementById(productoLS.id);
        row_precio_usd = document.getElementById(productoLS.id);
        //Actualizando cantidades
        productoNew.precio_total = precioTotal.toFixed(2);
        productoNew.cant_req = cant_req;
        productoNew.descuento = descuento;

        if(productoLS.currency_id == 1){
          precioTotalUSD  = parseFloat(precioTotal) / parseFloat(tipo_cambio);
          productoNew.precio_total_usd = precioTotalUSD.toFixed(2);
          row_precio_total.getElementsByClassName('precio_total')[0].innerHTML= precioTotal.toFixed(2);
          row_precio_total.getElementsByClassName('precio_total_usd')[0].innerHTML= precioTotalUSD.toFixed(2);

        }else{
          productoNew.precio_total_usd = precioTotal.toFixed(2);
          row_precio_total.getElementsByClassName('precio_total')[0].innerHTML= precioTotal.toFixed(2);
          row_precio_total.getElementsByClassName('precio_total_usd')[0].innerHTML= precioTotal.toFixed(2);
        }
          data_update_cant_product(productoNew.descripcion,productoNew.precio, oldValue, cant_req);
        //Remplazo el index del arreglo de LOcal Storage con las nuevas cantidades
        productosLS.splice(index, 1, productoNew);


      }
  });
  localStorage.setItem('productos', JSON.stringify(productosLS));
  sumaTotales();
}

function update_mano_de_obra(){

  var num_aps = 0;
  var productos = obtenerProductosLocalStorage();
    //Filtro de antenas
  var products_aps = productos.filter(producto =>
                     producto.codigo.substring(0, 3) == 'API' || producto.codigo.substring(0, 3) == 'APE');

    var mo_products = productos.filter(producto => producto.categoria_id == 7);
    /* Si es mayor a 0 significa que se agrego mano de obra por
       parte del usuario y se procede a recalcular las cantidades */
    if(mo_products.length > 0){
      $.each(products_aps, function( i, key ) {
        num_aps += key.cant_req;
      })

      new_products =  productos.filter(producto => producto.categoria_id != 7);
      localStorage.setItem('productos', JSON.stringify(new_products));

      $.ajax({
          url : `/items/ajax/four/0/${num_aps}`
      }).done(function (data) {
        var productosLS = obtenerProductosLocalStorage();
          data.forEach(element => {
            var productosLS = obtenerProductosLocalStorage();
            var id_product = element.id;
            if(productosLS == '[]'){
              //Primer producto del carrito
              leerDatosProductMO(element);
            }else {
              let count =  productosLS.filter(producto => producto.id == id_product);
              (count.length == 1) ? console.log("producto existe") : leerDatosProductMO(element);
            }
          })
            generate_table_products();
            menssage_toast('Mensaje', '4', 'Mano de obra actualizada' , '2000');
          }).fail(function () {
              Swal.fire("Ocurrio un error al actualizar mano de obra","","error");
          });//Fin funcion ajax

      }//fin if
}

function update_price_unit(id, newPrice){
  let tipo_cambio = document.getElementById('tipo_cambio').value;
  let productosLS;
  let currency_id = 0;
  let nuevo_precio = newPrice;
  let precio = 0.0;
  let descuento = 0.0
  let precioTotal = 0.0;
  let precioTotalUSD = 0.0;
  let productoNew = [];
  var row_precio_total, row_precio_total_usd;
  productosLS = obtenerProductosLocalStorage();

  productosLS.forEach((productoLS, index) => {
      //Buscando producto a actualizar
      if(productoLS.id == id){
        productoNew = productoLS;
        precio = parseFloat(nuevo_precio);
        descuento = productoLS.descuento;
        cant_req = productoLS.cant_req;
        precioTotal = parseFloat(cant_req) * parseFloat(precio);
        precioTotal -= percent(productoLS.descuento, parseFloat(precioTotal));
        row_precio_total = document.getElementById(productoLS.id);
        row_precio_usd = document.getElementById(productoLS.id);
        //Actualizando cantidades
        productoNew.precio_total = precioTotal.toFixed(2);
        productoNew.cant_req = cant_req;
        productoNew.precio = precio.toFixed(2);

        if(productoLS.currency_id == 1){
          precioTotalUSD  = parseFloat(precioTotal) / parseFloat(tipo_cambio);
          productoNew.precio_total_usd = precioTotalUSD.toFixed(2);
          row_precio_total.getElementsByClassName('precio_total')[0].innerHTML= precioTotal.toFixed(2);
          row_precio_total.getElementsByClassName('precio_total_usd')[0].innerHTML= precioTotalUSD.toFixed(2);

        }else{
          productoNew.precio_total_usd = precioTotal.toFixed(2);
          row_precio_total.getElementsByClassName('precio_total')[0].innerHTML= precioTotal.toFixed(2);
          row_precio_total.getElementsByClassName('precio_total_usd')[0].innerHTML= precioTotal.toFixed(2);
        }

        //Remplazo el index del arreglo de LOcal Storage con las nuevas cantidades
        productosLS.splice(index, 1, productoNew);


      }
  });
  localStorage.setItem('productos', JSON.stringify(productosLS));
  sumaTotales();
}

function generate_table_products(){
  // Tabla de productos del Documento P
  var productos = obtenerProductosLocalStorage();
  //Filtrar productos por categoria
  let equipo_activo = productos.filter(producto => producto.categoria_id == 4  || producto.categoria_id == 6 || producto.categoria_id == 14);
  let materiales= productos.filter(producto => producto.categoria_id != 4  && producto.categoria_id != 6  &&
                                                producto.categoria_id != 7 && producto.categoria_id != 14 && producto.categoria_id != 15);
  let sitwifi= productos.filter(producto => producto.categoria_id == 7 );
  let viaticos = productos.filter(producto => producto.categoria_id == 15 );

  $("#tabla_productos tbody tr").remove();
  var total_eq_activo = 0.0;
  var total_materiales = 0.0;
  var total_sitwifi = 0.0;
  var total_viaticos = 0.0;
  $.each(equipo_activo, function( i, key ) {
    total_eq_activo += parseFloat(key.precio_total_usd);
    $('#tabla_productos tbody').append('<tr id="' + key.id + '"><td>'
      + key.cant_sug + '</td>'
      + '<td><a id="cant_req" href="" data-type="text" data-pk="'+ key.id + '" data-clave="' + key.codigo + '" data-title="Cantidad" data-value="' + key.cant_req + '" data-name="cant_req" class="set-cant-req"></a></td><td class="descripcion">'
      + key.descripcion.toUpperCase() + '</td><td>'
      + key.categoria + '</td><td>'
      + key.codigo + '</td><td>'
      + key.proveedor + '</td><td>'
      + key.num_parte + '</td><td>'
      + key.descuento + '</td><td class="precio">'
      + key.precio.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td><td>'
      + key.currency + '</td><td class="precio_total">'
      + key.precio_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td><td class="precio_total_usd">'
      + key.precio_total_usd.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td><td>'
      + '<button type="button" onclick="eliminarProductoLocalStorage('+key.id+');deleteRow(this);" class="btn borrar" data-id="' + key.id + '" href="#"><i class="fa fa-trash text-danger"></i></button></td>'
      + '</td></tr>');
   });
   $('#tabla_productos tbody').append(
     `<tr style="font-weight:bold !important"; class="bg-primary"><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="3">Total Equipo Activo:</td><td>DLLS</td><td id="total_eqactivo" colspan="2">$</td></tr>`);
      document.getElementById("total_eqactivo").innerHTML = "$" + (total_eq_activo.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      document.getElementById("total_eqactivo_footer").innerHTML =  (total_eq_activo.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
   $.each(materiales, function( i, key ) {
     total_materiales += parseFloat(key.precio_total_usd);
     $('#tabla_productos tbody').append('<tr id="' + key.id + '"><td>'
       + key.cant_sug + '</td>'
       + '<td><a id="cant_req" href="" data-type="text" data-pk="'+ key.id + '" data-clave="' + key.codigo + '" data-title="cantidad" data-value="' + key.cant_req + '" data-name="cant_req" class="set-cant-req"></a></td><td class="descripcion">'
       + key.descripcion.toUpperCase() + '</td><td>'
       + key.categoria + '</td><td>'
       + key.codigo + '</td><td>'
       + key.proveedor + '</td><td>'
       + key.num_parte + '</td><td>'
       + key.descuento + '</td><td class="precio">'
       + key.precio.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td><td>'
       + key.currency + '</td><td class="precio_total">'
       + key.precio_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td><td class="precio_total_usd">'
       + key.precio_total_usd.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td><td>'
       + '<button type="button" onclick="eliminarProductoLocalStorage('+key.id+');deleteRow(this);" class="btn borrar" data-id="' + key.id + '" href="#"><i class="fa fa-trash text-danger"></i></button></td>'
       + '</td></tr>');
    });
    $('#tabla_productos tbody').append(
      `<tr style="font-weight:bold !important"; class="bg-primary"><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="3">Total Materiales:</td><td>DLLS</td><td id="total_materiales" colspan="2">$0.00</td></tr>`);
      document.getElementById("total_materiales").innerHTML = "$" + (total_materiales.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      document.getElementById("total_materiales_footer").innerHTML = (total_materiales.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    $.each(sitwifi, function( i, key ) {
      total_sitwifi += parseFloat(key.precio_total_usd);
      $('#tabla_productos tbody').append('<tr id="' + key.id + '"><td>'
        + key.cant_sug + '</td>'
        + '<td><a id="cant_req" href="" data-type="text" data-pk="'+ key.id + '" data-clave="' + key.codigo + '" data-title="cantidad" data-value="' + key.cant_req + '" data-name="cant_req" class="set-cant-req"></a></td><td class="descripcion">'
        + key.descripcion.toUpperCase() + '</td><td>'
        + key.categoria + '</td><td>'
        + key.codigo + '</td><td>'
        + key.proveedor + '</td><td>'
        + key.num_parte + '</td><td>'
        + key.descuento + '</td><td class="precio">'
        + '<a href="#" data-type="text" data-descripcion="' + key.descripcion + '" data-precio="' + key.precio + '" data-pk="' + key.id + '" data-url="" data-title="precio" data-value="' + key.precio+ '" data-name="precio" class="set-price"></a></td><td class="precio">'
        + key.currency + '</td><td class="precio_total">'
        + key.precio_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td><td class="precio_total_usd">'
        + key.precio_total_usd.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td><td>'
        + '<button type="button" onclick="eliminarProductoLocalStorage('+key.id+');deleteRow(this);" class="btn borrar" data-id="' + key.id + '" href="#"><i class="fa fa-trash text-danger"></i></button></td>'
        + '</td></tr>');
     });
     $('#tabla_productos tbody').append(
      `<tr style="font-weight:bold !important"; class="bg-primary"><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="3">Total Mano de obra:</td><td>DLLS</td><td id="total_sitwifi" colspan="2">$0.00</td></tr>`);
       document.getElementById("total_sitwifi").innerHTML = "$" + (total_sitwifi.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
       document.getElementById("total_sitwifi_footer").innerHTML =  (total_sitwifi.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
       $.each(viaticos, function( i, key ) {
        total_viaticos += parseFloat(key.precio_total_usd);
        $('#tabla_productos tbody').append('<tr id="' + key.id + '"><td>'
          + key.cant_sug + '</td>'
          + '<td><a id="cant_req" href="" data-type="text" data-pk="'+ key.id + '" data-clave="' + key.codigo + '" data-title="cantidad" data-value="' + key.cant_req + '" data-name="cant_req" class="set-cant-req"></a></td><td class="descripcion">'
          + key.descripcion.toUpperCase() + '</td><td>'
          + key.categoria.toUpperCase() + '</td><td>'
          + key.codigo + '</td><td>'
          + key.proveedor + '</td><td>'
          + key.num_parte + '</td><td>'
          + key.descuento + '</td><td>'
          + '<a href="#" data-type="text" data-descripcion="' + key.descripcion + '" data-precio="' + key.precio + '" data-pk="' + key.id + '" data-url="" data-title="precio" data-value="' + key.precio+ '" data-name="precio" class="set-price"></a></td><td class="precio">'
          + key.currency + '</td><td class="precio_total">'
          + key.precio_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td><td class="precio_total_usd">'
          + key.precio_total_usd.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td><td>'
          + '<button type="button" onclick="eliminarProductoLocalStorage('+key.id+');deleteRow(this);" class="btn borrar" data-id="' + key.id + '" href="#"><i class="fa fa-trash text-danger"></i></button></td>'
          + '</td></tr>');
       });
       $('#tabla_productos tbody').append(
        `<tr style="font-weight:bold !important"; class="bg-primary"><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="3">Total viaticos:</td><td>DLLS</td><td id="total_viaticos" colspan="2">$0.00</td></tr>`);
         document.getElementById("total_viaticos").innerHTML = "$" + (total_viaticos.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
         document.getElementById("total_viaticos_footer").innerHTML =  (total_viaticos.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
       //Total global
       document.getElementById("total_global").innerHTML = ((total_materiales + total_eq_activo + total_sitwifi + total_viaticos).toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

  //  Fix de errorres en validate
  $('.set-cant-req').on('shown', function() {
      var $innerForm = $(this).data('editable').input.$input.closest('form');
      var $outerForm = $innerForm.parents('form').eq(0);
      $innerForm.data('validator', $outerForm.data('validator'));
  });

  $('.set-price').on('shown', function() {
      var $innerForm = $(this).data('editable').input.$input.closest('form');
      var $outerForm = $innerForm.parents('form').eq(0);
      $innerForm.data('validator', $outerForm.data('validator'));
  });

  // Funcion para detectar cambio en alguna cantidad de un producto
  $('.set-cant-req').editable({
      container: 'body',
      type : 'number',
      validate: function(newValue) {
        if($.trim(newValue) == '')
            return 'Este campo es requerido';
        else if(!isFinite(newValue))
            return 'Debe ingresar un valor númerico';
        else if(newValue <= 0)
            return 'Debe ingresar un valor mayor a 0';
      },
      success: function(response, newValue) {
        var id = $(this).data('pk');
        var oldValue = $(this).text();
        var clave = $(this).data('clave').substring(0, 3);
        var num_aps = 0;
        update_cantidades(id, parseFloat(newValue), oldValue);
        document.getElementById(id).style.background = "#BDD3DE";
        if(clave == 'API' || clave == 'APE'){
          update_mano_de_obra();
        }

      }// Fin susccess

  });// fin set-cant-req


  //Funcion para detectar cambio en algun precio unitario de un producto
  $('.set-price').editable({
      type : 'number',
      validate: function(newValue) {
        if($.trim(newValue) == '')
            return 'Este campo es requerido';
        else if(!isFinite(newValue))
            return 'Debe ingresar un valor númerico';
        else if(newValue < 0)
            return 'No puede ingresar una cantidad negativa';
      },
      success: function(response, newValue) {
        var id = $(this).data('pk');
        update_price_unit(id, newValue);
        document.getElementById(id).style.background = "#BDD3DE";
      }
  });

}//Fin funcion

// Funcion para modificar datos al actualizar el descuento de un producto
function update_decuento(id, desq){
  let tipo_cambio = document.getElementById('tipo_cambio').value;
  let productosLS;
  let currency_id = 0;
  let precio = 0.0;
  let precioTotal = 0.0;
  let precioTotalUSD = 0.0;
  let descuento = parseInt(desq);
  let productoNew = [];
  var row_precio_total, row_precio_total_usd;
  productosLS = obtenerProductosLocalStorage();

  productosLS.forEach((productoLS, index) => {
      //Buscando producto a actualizar
      if(productoLS.id == id){
        productoNew = productoLS;
        precio = productoLS.precio;
        cant_req = productoLS.cant_req;
        precioTotal = parseFloat(cant_req) * parseFloat(precio);
        precioTotal -= percent(descuento, parseFloat(precioTotal));
        row_precio_total = document.getElementById(productoLS.id);
        row_precio_usd = document.getElementById(productoLS.id);
        //Actualizando cantidades
        productoNew.precio_total = precioTotal.toFixed(2);
        productoNew.cant_req = cant_req;
        productoNew.descuento = descuento;

        if(productoLS.currency_id == 1){
          precioTotalUSD  = parseFloat(precioTotal) / parseFloat(tipo_cambio);
          productoNew.precio_total_usd = precioTotalUSD.toFixed(2);
          row_precio_total.getElementsByClassName('precio_total')[0].innerHTML= precioTotal.toFixed(2);
          row_precio_total.getElementsByClassName('precio_total_usd')[0].innerHTML= precioTotalUSD.toFixed(2);

        }else{
          productoNew.precio_total_usd = precioTotal.toFixed(2);
          row_precio_total.getElementsByClassName('precio_total')[0].innerHTML= precioTotal.toFixed(2);
          row_precio_total.getElementsByClassName('precio_total_usd')[0].innerHTML= precioTotal.toFixed(2);
        }

        //Remplazo el index del arreglo de LOcal Storage con las nuevas cantidades
        productosLS.splice(index, 1, productoNew);


      }
  });
  localStorage.setItem('productos', JSON.stringify(productosLS));
  sumaTotales();
}

function obtenerProductosLocalStorage(){
    let productosLS;

    if(localStorage.getItem('productos') === null){
        productosLS = [];
    }else{
        productosLS = JSON.parse(localStorage.getItem('productos'));
    }

    return productosLS;
}

// Muestra los productos de LocalStorage en el carrito
function leerLocalStorage(){
    let productosLS;
    productosLS = obtenerProductosLocalStorage();
}

//Elimina un producto del local storage
function eliminarProductoLocalStorage(producto){
    let productosLS;
    productosLS = obtenerProductosLocalStorage();

    productosLS.forEach((productoLS, index) => {
        if(productoLS.id == producto){

            productosLS.splice(index, 1);
        }
    });

    localStorage.setItem('productos', JSON.stringify(productosLS));
    sumaTotales();
}

//Elimino la columna  seleccionada de la tabla de pedidos

function deleteRow(fila) {
  var row = fila.parentNode.parentNode;
  var descripcion = row.querySelector(".descripcion").closest("td").innerText;
  var precio = row.querySelector(".precio").closest("td").innerText;
  var cantidad = row.querySelector(".set-cant-req").closest("td a").innerText;
  data_delete_product(descripcion,precio ,cantidad);
  row.parentNode.removeChild(row);
}


/*
*******************************************************************************
*/


/*
*  Formulario steps wizard
*/

$.validator.addMethod('filesize', function(value, element, param) {

return this.optional(element) || (element.files[0].size <= param)
});

//Formulario documento P
var form_master = $(".validation-wizard-master").show();

$(".validation-wizard-master").steps({
    headerTag: "h6",
    bodyTag: "section",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: "Submit"
    },
    onStepChanging: function (event, currentIndex, newIndex) {
      if(newIndex == 1){
        // Tabla de productos del Documento P
        var productos = obtenerProductosLocalStorage();
        generate_table_products(productos);
        //update_mano_de_obra();
      }

        return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form_master.find(".body:eq(" + newIndex + ") label.error").remove(), form_master.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form_master.validate().settings.ignore = ":disabled,:hidden", form_master.valid())
    },
    onFinishing: function (event, currentIndex) {
        return form_master.validate().settings.ignore = ":disabled", form_master.valid()
    },
    onFinished: function (event, currentIndex) {
      event.preventDefault();
        // swal("form_master Submitted!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.");
      /************************************************************************************/
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
          let productosLS;
          var _token = $('input[name="_token"]').val();
          let total_ea = 0.0;
          let total_ena = 0.0;
          let total_mo = 0.0;
          let total_viaticos = 0.0;
          let total = 0.0;
          let id = $('#id_documentp').val();
           productosLS = localStorage.getItem('productos');
           productosLogLS = localStorage.getItem('productos_log');
           total_ea = document.getElementById('total_eqactivo_footer').innerHTML;
           total_ena = document.getElementById('total_materiales_footer').innerHTML;
           total_mo = document.getElementById('total_sitwifi_footer').innerHTML;
           total_viaticos = document.getElementById('total_viaticos_footer').innerHTML;
           total = document.getElementById('total_global').innerHTML;

           var form = $('#validation_master')[0];
           var formData = new FormData(form);

           formData.append('id', id);
           formData.append('shopping_cart',productosLS);
           formData.append('productos_log',productosLogLS);
           formData.append('total_ea',total_ea.replace(/,/g, ""));
           formData.append('total_ena',total_ena.replace(/,/g, ""));
           formData.append('total_mo',total_mo.replace(/,/g, ""));
           formData.append('total_viaticos',total_viaticos.replace(/,/g, ""));
           formData.append('total',total.replace(/,/g, ""));

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

           return fetch('/edit_documentp', miInit)
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
        if (result.value) {
          console.log(result);
          localStorage.clear();
          Swal.fire({
            title: 'Documento actualizado',
            text: "",
            type: 'success',
          }).then(function (result) {
            if (result.value) {
              window.location = "/view_history_documentp";
            }
          })
        }else{
          Swal.showValidationMessage(
            `Ocurrio un error inesperado`
          )
        }
      })
      /************************************************************************************/
    }
}), $(".validation-wizard-master").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    highlight: function (element, errorClass) {
        $(element).removeClass(errorClass)
    },
    unhighlight: function (element, errorClass) {
        $(element).removeClass(errorClass)
    },
    errorPlacement: function (error, element) {
        // error.insertAfter(element);
        if (element[0].id === 'fileInput') {
          error.insertAfter($('#cont_file'));
        }
        else {
          error.insertAfter(element);
        }
    },
    rules: {
      type_service: {
        required: true
      },
      vertical: {
        required: true
      },
      itc: {
        required: true
      },
      comercial: {
        required: true
      },
      lugar_instalacion: {
        required: true
      },
      tipo_cambio: {
        required: true
      },
    },

})
var conceptIndex = 0,
    conceptIndex1 = 0,
    conceptIndex2 = 0,
    conceptIndex3 = 0,
    conceptIndex4 = 0,
    constante_eliminar = [],
    constante_eliminar_1 = [],
    constante_eliminar_2 = [],
    constante_eliminar_3 = [],
    constante_eliminar_4 = [],
    constante_a = 0,
    max_options = 7,
    max_options1 = 1,
    max_options2 = 3;
    max_options3 = 1;
    max_options4 = 1;


    $(".validation-wizard-master").on('click', '.addButtonAP', function(){
      if( constante_eliminar.length === 0) {
        if(conceptIndex <= max_options) {
          conceptIndex++;
          var $template = $('#optionTemplateAP'),
          $clone  = $template
            .clone()
            .removeClass('d-none')
            .removeAttr('id')
            .attr('data-book-index', conceptIndex)
            .insertBefore($template);
          // Update the name attributes
          $clone
            .find('[name="aps_modelo"]').attr('name', 'aps_modelo[' + conceptIndex + ']').attr('data_row', conceptIndex).addClass("required").end()
            .find('[name="aps_cant"]').attr('name', 'aps_cant[' + conceptIndex + ']').addClass("required").end();
        }
        else{
          Swal.fire("Operación abortada", "Excediste el limite de campos permitidos  :(", "error");
        }
      }
      else {
        /*INICIO DE LA SECCION-- Reutilizo index eliminados. */
          var ordenando_array = constante_eliminar.sort();
          index_reutilizado = ordenando_array[0];
    
          var $template = $('#optionTemplateAP'),
          $clone  = $template
            .clone()
            .removeClass('d-none')
            .removeAttr('id')
            .attr('data-book-index', index_reutilizado)
            .insertBefore($template);
    
          $clone
              .find('[name="aps_modelo"]').attr('name', 'aps_modelo[' + index_reutilizado + ']').attr('data_row', index_reutilizado).addClass("required").end()
              .find('[name="aps_cant"]').attr('name', 'aps_cant[' + index_reutilizado + ']').addClass("required").end();
    
          //Elimino el primero elemento del array
          ordenando_array.shift();
      }
    });
    
    $(".validation-wizard-master").on('click','.removeButtonAP',function(){
      var $row  = $(this).parents('.clone'),
          index = $row.attr('data-book-index');
          // Remove element containing the option
          $row.remove();
          //Añado el index a reutilizar en la inserción
          constante_eliminar.push(index);
          // createEvent_llenarmoneda ();
    });
    
    $(".validation-wizard-master").on('click', '.addButtonFW', function(){
      if( constante_eliminar_1.length === 0) {
        if(conceptIndex1 <= max_options1) {
          conceptIndex1++;
          var $template = $('#optionTemplateFIRE'),
          $clone  = $template
            .clone()
            .removeClass('d-none')
            .removeAttr('id')
            .attr('data-book-index', conceptIndex1)
            .insertBefore($template);
          // Update the name attributes
          $clone
            .find('[name="firew_mod"]').attr('name', 'firew_mod[' + conceptIndex1 + ']').attr('data_row', conceptIndex1).addClass("required").end()
            .find('[name="firew_cant"]').attr('name', 'firew_cant[' + conceptIndex1 + ']').addClass("required").end();
    
    
            //createEvent_Mensualidad (conceptIndex1);
    
        }
        else{
          Swal.fire("Operación abortada", "Excediste el limite de campos permitidos  :(", "error");
        }
      }
      else {
        /*INICIO DE LA SECCION-- Reutilizo index eliminados. */
          var ordenando_array = constante_eliminar_1.sort();
          index_reutilizado = ordenando_array[0];
    
          var $template = $('#optionTemplateFIRE'),
          $clone  = $template
            .clone()
            .removeClass('d-none')
            .removeAttr('id')
            .attr('data-book-index', index_reutilizado)
            .insertBefore($template);
    
          $clone
              .find('[name="firew_mod"]').attr('name', 'firew_mod[' + index_reutilizado + ']').attr('data_row', index_reutilizado).addClass("required").end()
              .find('[name="firew_cant"]').attr('name', 'firew_cant[' + index_reutilizado + ']').addClass("required").end();
    
          //Elimino el primero elemento del array
          ordenando_array.shift();
      }
    });
    
    $(".validation-wizard-master").on('click','.removeButtonFW',function(){
      var $row  = $(this).parents('.clone'),
          index = $row.attr('data-book-index');
          // Remove element containing the option
          $row.remove();
          //Añado el index a reutilizar en la inserción
          constante_eliminar_1.push(index);
          // createEvent_llenarmoneda ();
    });
    
    $(".validation-wizard-master").on('click', '.addButtonSW', function(){
      if( constante_eliminar_2.length === 0) {
        if(conceptIndex2 <= max_options2) {
          conceptIndex2++;
          var $template = $('#optionTemplateSW'),
          $clone = $template
            .clone()
            .removeClass('d-none')
            .removeAttr('id')
            .attr('data-book-index', conceptIndex2)
            .insertBefore($template);
            // Update the name attributes
          $clone
            .find('[name="switches_mod"]').attr('name', 'switches_mod[' + conceptIndex2 + ']').attr('data_row', conceptIndex2).addClass("required").end()
            .find('[name="switches_cant"]').attr('name', 'switches_cant[' + conceptIndex2 + ']').addClass("required").end();
        }
        else{
          Swal.fire("Operación abortada", "Excediste el limite de campos permitidos  :(", "error");
        }
      }
      else {
        /*INICIO DE LA SECCION-- Reutilizo index eliminados. */
          var ordenando_array = constante_eliminar_2.sort();
          index_reutilizado = ordenando_array[0];
    
          var $template = $('#optionTemplateSW'),
          $clone = $template
            .clone()
            .removeClass('d-none')
            .removeAttr('id')
            .attr('data-book-index', index_reutilizado)
            .insertBefore($template);
    
          $clone
              .find('[name="switches_mod"]').attr('name', 'switches_mod[' + index_reutilizado + ']').attr('data_row', index_reutilizado).addClass("required").end()
              .find('[name="switches_cant"]').attr('name', 'switches_cant[' + index_reutilizado + ']').addClass("required").end();
    
        //Elimino el primero elemento del array
          ordenando_array.shift();
      }
    });
    
    $(".validation-wizard-master").on('click','.removeButtonSW',function(){
      var $row  = $(this).parents('.clone'),
          index = $row.attr('data-book-index');
          // Remove element containing the option
          $row.remove();
          //Añado el index a reutilizar en la inserción
          constante_eliminar_2.push(index);
    });

    

    $(".validation-wizard-master").on('click', '.addButtonGabinetes', function(){
      if( constante_eliminar_4.length === 0) {
        if(conceptIndex4 <= max_options4) {
          conceptIndex4++;
          var $template = $('#optionTemplateGabinetes'),
          $clone = $template
            .clone()
            .removeClass('d-none')
            .removeAttr('id')
            .attr('data-book-index', conceptIndex4)
            .insertBefore($template);
            // Update the name attributes
          $clone
            .find('[name="gabinetes_select"]').attr('name', 'gabinetes_select[' + conceptIndex4 + ']').attr('data_row', conceptIndex4).addClass("required").end()
            .find('[name="bobinas_cant"]').attr('name', 'bobinas_cant[' + conceptIndex4 + ']').addClass("required").end();
        }
        else{
          Swal.fire("Operación abortada", "Excediste el limite de campos permitidos  :(", "error");
        }
      }
      else {
        /*INICIO DE LA SECCION-- Reutilizo index eliminados. */
          var ordenando_array = constante_eliminar_4.sort();
          index_reutilizado = ordenando_array[0];
    
          var $template = $('#optionTemplateGabinetes'),
          $clone = $template
            .clone()
            .removeClass('d-none')
            .removeAttr('id')
            .attr('data-book-index', index_reutilizado)
            .insertBefore($template);
    
          $clone
              .find('[name="gabinetes_select"]').attr('name', 'gabinetes_select[' + index_reutilizado + ']').attr('data_row', index_reutilizado).addClass("required").end()
              .find('[name="bobinas_cant"]').attr('name', 'bobinas_cant[' + index_reutilizado + ']').addClass("required").end();
    
        //Elimino el primero elemento del array
          ordenando_array.shift();
      }
    });
    
    $(".validation-wizard-master").on('click','.removeButtonGabinetes',function(){
      var $row  = $(this).parents('.clone'),
          index = $row.attr('data-book-index');
          // Remove element containing the option
          $row.remove();
          //Añado el index a reutilizar en la inserción
          constante_eliminar_4.push(index); 
    });