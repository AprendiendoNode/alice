$(function () {



});

function data_new_product(producto){

   const newProduct = {
       descripcion: producto.descripcion,
       precio: producto.precio,
       cant_anterior: 0.0,
       cant_actual: producto.cant_req,
       accion : 'Agregado'
   }

   add_product_log(newProduct);

}

function data_delete_product(descripcion,precio, cantidad,total){

  const deleteProduct = {
      descripcion: descripcion,
      precio: precio,
      cant_anterior: parseFloat(cantidad),
      cant_actual: 0.0,
      accion : 'Eliminado'
  }

  add_product_log(deleteProduct);

}

function data_update_cant_product(descripcion,precio, oldValue, newValue){
//  console.log(oldValue);
  const updateProduct = {
      descripcion: descripcion,
      precio: precio,
      cant_anterior: oldValue,
      cant_actual: newValue,
      accion : 'Actualizado'
  }
  add_product_log(updateProduct);
}

function add_product_log(producto){
    guardarProductoLocalStorageLog(producto);
}

function guardarProductoLocalStorageLog(producto){
    let productos;

    productos = obtenerProductosLocalStorageLog();
    productos.push(producto);

    localStorage.setItem('productos_log', JSON.stringify(productos));
}

function obtenerProductosLocalStorageLog(){
    let productosSS;

    if(localStorage.getItem('productos_log') === null){
        productosSS = [];
    }else{
        productosSS = JSON.parse(localStorage.getItem('productos_log'));
    }

    return productosSS;
}

function leerLocalStorageLog(){
    let productosSS;

    productosSS = obtenerProductosLocalStorageLog();

}
