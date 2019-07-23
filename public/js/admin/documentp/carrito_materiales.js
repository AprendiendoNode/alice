$(function () {

  leerLocalStorage();

});


$(".agregar-carrito-material").on('click', function(e){
  const producto = e.target.parentElement.parentElement;
  var cant_sug = producto.getElementsByClassName("cant_sug")[0].value;
  var cant_req = producto.getElementsByClassName("cant_req")[0].value;
  var button =  producto.getElementsByTagName("button");
  var id_product =  $(button).attr('data-id');

  //Validaciones del producto
  if(cant_sug == 0 && cant_req == 0){
    menssage_toast('Error', '2', 'La cantidad sugerida o requerida debe ser mayor a 0' , '4000');
  }else if(cant_req < 0){
    menssage_toast('Error', '2', 'No se permiten valores negativos' , '4000');
  }else{
    var productosLS = obtenerProductosLocalStorage();

    if(productosLS == '[]'){
      //Primer producto del carrito
      leerDatosProduct(producto);
      menssage_toast('Mensaje', '3', 'Producto agregado' , '2000');
    }else {
      let count =  productosLS.filter(producto => producto.id == id_product);

      if(count.length == 1){
        //El producto existe
        menssage_toast('Error', '2', 'Este producto ya fue agregado al pedido' , '3000');
      }else{
        leerDatosProduct(producto);
        menssage_toast('Mensaje', '3', 'Producto agregado' , '2000');
      }

    }
  }

});

function leerDatosProduct(producto){
  var button =  producto.getElementsByTagName("button");
  var tipo_cambio = document.getElementById('tipo_cambio').value;
  var cant_sug = producto.getElementsByClassName("cant_sug")[0].value;
  var cant_req = producto.getElementsByClassName("cant_req")[0].value;
  var currency_id = $(button).attr('data-currency-id');
  var categoria_id = $(button).attr('data-categoria-id');
  var precio = $(button).attr('data-price');
  var precioTotal = 0.0;

  var precio_usd = 0.0;

  if(cant_req == 0){
    //Si  la cantidad requerida es 0 se toma en cuenta la cantidad sugerida como la cantidad de artculos solicitada
    cant_req = parseFloat(cant_sug);
  }else{
    cant_req = parseFloat(cant_req);
  }

  precioTotal = (parseFloat(cant_req) * parseFloat(precio));

  if(currency_id == 1){
    precio_usd = precioTotal / parseFloat(tipo_cambio);
  }else{
    precio_usd = precioTotal;
  }

   const infoProducto = {
       id: $(button).attr('data-id'),
       descripcion: $(button).attr('data-descripcion'),
       img: producto.querySelector('img').src,
       codigo: $(button).attr('data-codigo'),
       precio: precio,
       categoria: producto.querySelector('.categoria').innerText,
       categoria_id: categoria_id,
       num_parte:$(button).attr('data-num-parte'),
       currency: $(button).attr('data-currency'),
       currency_id: currency_id,
       proveedor: $(button).attr('data-proveedor'),
       descuento: 0,
       cant_sug: parseFloat(cant_sug),
       cant_req: cant_req,
       precio_total : precioTotal.toFixed(2),
       precio_total_usd : precio_usd.toFixed(2)
   }

   insertarCarrito(infoProducto);
}

function insertarCarrito(producto){
    guardarProductoLocalStorage(producto);
}

function eliminarProducto(e){
    e.preventDefault();
    let producto, productoId;

    if(e.target.classList.contains('borrar-producto')){
        e.target.parentElement.parentElement.remove();
        producto = e.target.parentElement.parentElement;
        productoId = producto.querySelector('a').getAttribute('data-id');
    }

    eliminarCursoLocalStorage(cursoId);
}

function vaciarCarrito(){
    listaCursos.innerHTML = '';

    vaciarLocalStorage();

    return false;
}

function guardarProductoLocalStorage(producto){
    let productos;

    productos = obtenerProductosLocalStorage();
    productos.push(producto);

    localStorage.setItem('productos', JSON.stringify(productos));
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

// Muestra los cursos de LocalStorage en el carrito
function leerLocalStorage(){
    let productosLS;

    productosLS = obtenerProductosLocalStorage();

}

function vaciarLocalStorage(){
    localStorage.clear();
}
