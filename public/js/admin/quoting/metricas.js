$("#indirectos").on("blur", function(){
  set_table_rubro();
  set_table_gastos();
})

$("#densidad").on("blur", function(){
  set_table_modelos();
  set_table_servadm();
})

$("#enlace").on("blur", function(){
  set_table_rubro();
  set_table_gastos();
  set_table_modelos();
  set_table_servadm();
  set_table_objetivos();
})

$("#servicio").on("blur", function(){
  set_table_rubro();
  set_table_gastos();
  set_table_modelos();
  set_table_servadm();
  set_table_objetivos();
})

$("#plazo").on("blur", function(){
  set_table_rubro();
  set_table_gastos();
  set_table_servadm();
  set_table_objetivos();
})

$("#capex").on("blur", function(){
  set_table_gastos();
  set_table_servadm();
})

$("#deposito").on("blur", function(){
  set_table_gastos();
  set_table_objetivos();
})

$("#renta").on("blur", function(){
  set_table_servadm();
})

$("#type_service").on("change", function(){
  set_table_rubro();
  set_table_gastos();
  set_table_servadm();
  set_table_objetivos();
})

$("tipo_cambio").on("blur", function(){
  set_table_rubro();
  set_table_gastos();
  set_table_modelos();
  set_table_servadm();
  set_table_objetivos();
})

$("#gasto_mtto_percent").on("blur", function(){
  set_table_gastos();
  set_table_objetivos();
})

$("#credito_mensual_percent").on("blur", function(){
  set_table_gastos();
  set_table_objetivos();
})




/*******************************************************************************
          FUNCIONES PARA ACTUALIZAR TABLAS FINANCIERAS DEL COTIZADOR
*******************************************************************************/

// Rubro - Inversiones
function set_table_rubro(){
  var productos = obtenerProductosLocalStorage();
  let total_eq_activo = 0.0;
  let total_materiales = 0.0;
  let total_mo = 0.0;
  let indirectos_percent = document.getElementById("indirectos").value;
  let indirectos = 0.0;
  let comision = get_comision();
  let equipo_percent = 0;
  let materiales_percent = 0;
  let mano_obra_percent = 0;
  let rubro_indirectos_percent = 0;
  let comision_percent = 0;
  let total_rubros = 0.0;

  if(productos.length != 0){
    let equipo_activo = productos.filter(producto => producto.categoria_id == 4  || producto.categoria_id == 6 || producto.categoria_id == 14);
    let materiales= productos.filter(producto => producto.categoria_id != 4  && producto.categoria_id != 6 && producto.categoria_id != 7 && producto.categoria_id != 14);
    let sitwifi= productos.filter(producto => producto.categoria_id == 7 );

    if(equipo_activo.length != 0){
      equipo_activo.forEach(function(producto) {
        total_eq_activo += parseFloat(producto.precio_total_usd);
      });
    }

    if(materiales.length != 0){
      materiales.forEach(function(producto) {
        total_materiales += parseFloat(producto.precio_total_usd);
      });
    }

    if(sitwifi.length != 0){
      sitwifi.forEach(function(producto) {
        total_mo += parseFloat(producto.precio_total_usd);
      });
    }

  }

  indirectos = ((total_eq_activo + total_materiales + total_mo) * parseInt(indirectos_percent)) / 100;
  total_rubros = total_eq_activo + total_materiales + total_mo + indirectos + comision;

  rubro_indirectos_percent = (indirectos /  total_rubros) * 100;
  equipo_percent = (total_eq_activo /  total_rubros) * 100;
  materiales_percent = (total_materiales /  total_rubros) * 100;
  mano_obra_percent =  (total_mo /  total_rubros) * 100;
  comision_percent =  (comision /  total_rubros) * 100;

  document.getElementById("rubro_ea").innerHTML = format_number(total_eq_activo);
  document.getElementById("rubro_ena").innerHTML = format_number(total_materiales);
  document.getElementById("rubro_mo").innerHTML = format_number(total_mo);
  document.getElementById("rubro_indirectos").innerHTML = format_number(indirectos);
  document.getElementById("rubro_comision").innerHTML = format_number(comision);
  document.getElementById("rubro_ea_percent").innerHTML = Math.round(equipo_percent);
  document.getElementById("rubro_ena_percent").innerHTML = Math.round(materiales_percent);
  document.getElementById("rubro_mo_percent").innerHTML = Math.round(mano_obra_percent);
  document.getElementById("rubro_comision_percent").innerHTML = Math.round(comision_percent);
  document.getElementById("rubro_indirectos_percent").innerHTML = Math.round(rubro_indirectos_percent);
  document.getElementById("total_rubros").innerHTML = format_number(total_eq_activo + total_materiales + total_mo + indirectos + comision);
}

function set_table_gastos(){
  let enlace = parseFloat(document.getElementById("enlace").value);
  let mantto = 0.0;
  let gasto_mtto_percent = parseFloat(document.getElementById("gasto_mtto_percent").value);
  let total_inversion = remove_commas(document.getElementById('total_rubros').innerHTML);
  total_inversion = parseFloat(total_inversion);
  let plazo = parseInt(document.getElementById('plazo').value);
  let interes = parseFloat(document.getElementById('credito_mensual_percent').value) / 100;
  interes = interes / 12;
  let deposito = parseFloat(document.getElementById('deposito').value);
  let capex = parseFloat(document.getElementById('capex').value);
  let credito_mensual = 0.0;
  let total_gastos = 0.0;

  credito_mensual =  ((total_inversion - capex  - deposito) * interes  )  /  (1 - Math.pow(1 + interes, - plazo));

  mantto = (total_inversion * parseFloat(gasto_mtto_percent)) / 100;
  enlace += (enlace * 0.10);

  document.getElementById("credito_mensual").innerHTML = format_number(credito_mensual);
  document.getElementById("gasto_enlace").innerHTML = format_number(enlace);
  document.getElementById("gasto_mtto").innerHTML = format_number(mantto);
  document.getElementById("total_gastos").innerHTML = format_number(enlace + mantto + credito_mensual);
}

function set_table_servadm(){
  let renta = document.getElementById("servicio").value;
  let enlace = document.getElementById("enlace").value;
  enlace = parseFloat(enlace) * 1.1;
  let densidad = document.getElementById("densidad").value;
  let capex = document.getElementById("capex").value;
  let renta_anticipada = document.getElementById("renta").value;
  let plazo = document.getElementById("plazo").value;
  let antenas = get_num_aps();
  let hab_antenas = 0;
  let serv_adm_habitacion = 0.0;

  if(antenas > 0 && parseInt(densidad) > 0){
    hab_antenas = parseInt(densidad) /  antenas;
    serv_adm_habitacion = ( parseFloat(renta) + enlace) / parseFloat(densidad);
  }

  document.getElementById("renta_enlace").innerHTML = format_number( parseFloat(renta) + parseFloat(enlace) ) ;
  document.getElementById("serv_capex").innerHTML = format_number(parseFloat(capex));
  document.getElementById("serv_renta").innerHTML = format_number(parseFloat(renta_anticipada));
  document.getElementById("serv_plazo").innerHTML = parseInt(plazo);
  document.getElementById("serv_hab_antenas").innerHTML = Math.round(hab_antenas);
  document.getElementById("serv_adm_habitacion").innerHTML = format_number(serv_adm_habitacion);
}

function set_table_modelos(){
  let densidad = document.getElementById("densidad").value;
  let renta = document.getElementById("servicio").value;
  let enlace = document.getElementById("enlace").value;
  let antenas = get_num_aps();
  let mens_hab = parseFloat(renta) / parseInt(densidad);
  let hab_enlace = ( parseFloat(renta) + (parseFloat(enlace) * 1.1 ) ) / parseInt(densidad);

  document.getElementById("modelo_serv_mens").innerHTML = format_number(parseFloat(renta));
  document.getElementById("modelo_enlace").innerHTML = format_number(parseFloat(enlace) * 1.1);
  document.getElementById("modelo_antenas").innerHTML = antenas;
  document.getElementById("modelo_mensual_hab").innerHTML = format_number(parseFloat(mens_hab));
  document.getElementById("modelo_hab_enlace").innerHTML = format_number(parseFloat(hab_enlace));
}

function set_table_objetivos(){
  let vtc = get_vtc();
  let total_mo = get_total_mo();
  let num_aps = get_num_aps();
  let renta = document.getElementById("servicio").value;
  let enlace = document.getElementById("enlace").value;
  enlace = parseFloat(enlace) * 1.1;
  let plazo = document.getElementById("plazo").value;
  let capex = document.getElementById("capex").value;
  let deposito = document.getElementById("deposito").value;
  let total_gastos = remove_commas(document.getElementById('total_gastos').innerHTML);
  let total_inversion = remove_commas(document.getElementById('total_rubros').innerHTML);

  let utilidad_mensual = parseFloat(renta) + enlace - parseFloat(total_gastos);
  let utilidad_mensual_percent = utilidad_mensual / (parseFloat(renta) + enlace);
  utilidad_mensual_percent *= 100;

  let utilidad_proyecto = utilidad_mensual * parseInt(plazo);
  let utilidad_3_anios = utilidad_mensual * 36;
  let utilidad_inversion = (utilidad_mensual / total_inversion) * 100;

  let renta_mensual_inversion = (parseFloat(renta) - enlace ) / ( parseFloat(total_inversion) - parseFloat(capex) - parseFloat(deposito));
  renta_mensual_inversion *= 100;

  let utilidad_renta_percent =  utilidad_mensual / (parseFloat(renta) - enlace);
  utilidad_renta_percent *= 100;

  let utilidad_3_anios_minimo = total_inversion  / 0.833333;

  let vtc_percent = (utilidad_mensual * plazo) / ( 7500000 * .35 );
  vtc_percent *= 100;

  let tiempo_retorno = (parseFloat(total_inversion) - parseFloat(capex) - parseFloat(deposito)) / (parseFloat(renta) - enlace);

  let costo_mo_ap = 0.0;
  let servicio_ap = 0.0;
  let tir = get_tir();

  if(num_aps != 0){
    costo_mo_ap = total_mo / num_aps;
    servicio_ap = parseFloat(renta) / num_aps;
  }

  document.getElementById("utilidad_mensual").innerHTML = format_number(utilidad_mensual);
  document.getElementById("utilidad_mensual_percent").innerHTML = Math.round(utilidad_mensual_percent);
  document.getElementById("utilidad_proyecto").innerHTML = format_number(utilidad_proyecto);
  document.getElementById("utilidad_inversion").innerHTML = Math.round(utilidad_inversion);
  document.getElementById("utilidad_3_anios").innerHTML = format_number(utilidad_3_anios);
  document.getElementById("utilidad_3_anios_percent").innerHTML = format_number(utilidad_3_anios_minimo);
  document.getElementById("renta_mensual_inversion").innerHTML = Math.round(renta_mensual_inversion);
  document.getElementById("utilidad_renta").innerHTML = format_number(utilidad_renta_percent);
  document.getElementById("tiempo_retorno").innerHTML = format_number(tiempo_retorno);
  document.getElementById("vtc").innerHTML = format_number(vtc);
  document.getElementById("vtc_percent").innerHTML = format_number(vtc_percent);
  document.getElementById("costo_mo_ap").innerHTML = format_number(costo_mo_ap);
  document.getElementById("serv_ap").innerHTML = format_number(servicio_ap);
  document.getElementById("tir").innerHTML = tir.toFixed(2);

  parametros_objetivos(Math.round(renta_mensual_inversion), Math.round(utilidad_inversion), tir, utilidad_renta_percent, tiempo_retorno, utilidad_3_anios_minimo);
}

/*****************************************************************************/

function get_vtc(){
  let vigencia = document.getElementById("plazo").value;
  let renta = document.getElementById("servicio").value;
  let enlace = document.getElementById("enlace").value;
  enlace = parseFloat(enlace) * 1.1;

  let vtc = parseFloat(vigencia) * ( parseFloat(renta) + enlace );

  return vtc;
}

function get_comision(){
  let vtc = get_vtc();
  let tipo_servicio = document.getElementById("type_service").value;
  let comision = 0.0;

  if(tipo_servicio == "1"){
    comision = vtc * .03;
  }else{
    comision = vtc * .02;
  }
  return comision;
}

function get_num_aps(){
  var num_aps = 0;
  var productos = obtenerProductosLocalStorage();
  //Filtro de nodos o aps
  var products_aps = productos.filter(producto =>
                      producto.codigo.substring(0, 3) == 'API' || producto.codigo.substring(0, 3) == 'APE');

  if(products_aps.length > 0){
    products_aps.forEach(function(key) {
      num_aps += parseFloat(key.cant_req);
    });
  }

  return parseInt(num_aps);
}

function get_total_mo(){
  var productos = obtenerProductosLocalStorage();
  var mo_products = productos.filter(producto => producto.categoria_id == 7);
  var total_mo = 0.0;

  if(mo_products.length > 0){
    mo_products.forEach(function(key) {
      total_mo += parseFloat(key.precio_total_usd);
    });
  }
   return total_mo;
}

function get_tir(){
  var renta = parseFloat(document.getElementById("servicio").value);
  var plazo = parseInt(document.getElementById("plazo").value);
  var total_inversion = remove_commas(document.getElementById('total_rubros').innerHTML);
  total_inversion = parseFloat(total_inversion);
  var mantenimiento = remove_commas(document.getElementById('gasto_mtto').innerHTML);
  mantenimiento = parseFloat(mantenimiento);
  var flujo_neto = renta - mantenimiento;
  var suma_total = total_inversion;
  var vpc = 0.0;
  var tir =  .000000;
  var tir_anualizado = 0.00;

  while (suma_total >= 1) {
    tir+=.000001;
    suma_total= 0.0;
    for (var i = 1; i <= 48; i++) {
      vpc = flujo_neto /   Math.pow(1 + tir, i);
      suma_total+= vpc;
    }
    suma_total-= total_inversion;
  }
  tir_anualizado = tir * 100 * 12;
  // console.log("tir: " + tir);
  // console.log("vpc: " + suma_total);
  return tir_anualizado;
}

//parametros de objetivos del proyectos
function parametros_objetivos(percentRentaMensualInversion, percentUtilidadInversion, percentTir, percentUtilidadRenta, tiempoRetorno, utilidad3Minimo){

  let utilidad_3_anios_min = parseFloat(utilidad3Minimo);
  let utilidad_3_anios = remove_commas(document.getElementById('utilidad_3_anios').innerHTML);

  let renta_mensual_inversion_icon = document.getElementById('renta_mensual_inversion_icon');
  let utilidad_inversion_icon = document.getElementById('utilidad_inversion_icon');
  let utilidad_3_anios_percent_icon = document.getElementById('utilidad_3_anios_percent_icon');
  let utilidad_renta_icon = document.getElementById('utilidad_renta_icon');
  let tiempo_retorno_icon = document.getElementById('tiempo_retorno_icon');
  let tir_icon = document.getElementById('tir_icon');

  percentRentaMensualInversion >= 7 ? set_icons(renta_mensual_inversion_icon, true) : set_icons(renta_mensual_inversion_icon, false);

  percentUtilidadInversion >= 2 ? set_icons(utilidad_inversion_icon, true) : set_icons(utilidad_inversion_icon, false);

  parseFloat(utilidad_3_anios) >= utilidad_3_anios_min ? set_icons(utilidad_3_anios_percent_icon, true) : set_icons(utilidad_3_anios_percent_icon, false);

  percentUtilidadRenta >= 33 ? set_icons(utilidad_renta_icon, true) : set_icons(utilidad_renta_icon, false);

  tiempoRetorno <= 18 ? set_icons(tiempo_retorno_icon, true) : set_icons(tiempo_retorno_icon, false);

  percentTir >= 50 ? set_icons(tir_icon, true) : set_icons(tir_icon, false);

}

function set_icons(element, flag){
  element.className = '';
  flag == true ? element.classList.add('fa', 'fa-check', 'text-success') : element.classList.add('fa', 'fa-times', 'text-danger');
}

//Formato numerico: 00,000.00
function format_number(number){
  return number.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function remove_commas(number){
  return number.replace(/,/g, "");
}
