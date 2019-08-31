var select_total = document.getElementById("select_totales");
select_total.addEventListener('change', get_totales);

function show_linea_base(){
  let vtc = parseFloat(document.getElementById('vtc_cotizador').value);
  if(!isNaN(vtc)){
    let total = get_totales();
    set_table_objetivos(total);
    $('#modal_linea_base').modal('show');
  }else{
    Swal.fire('Este proyecto no tiene un cotizador asociado','','warning');
  }
}

function get_totales(){
  let select_totales = document.getElementById('select_totales').value;
  let total_usd = 0.0;
  if(select_totales == 1){
    total_usd = remove_commas(document.getElementById('total_usd_base').value);// Linea Base
    set_linea_base();
    set_table_objetivos(total_usd);
  }else{
    total_usd = remove_commas(document.getElementById('total_usd_invertido').value);// Real invertido
    set_inversion_real();
    set_table_objetivos(total_usd);
  }

  return total_usd;
}

function set_linea_base(){
  let total_ea = document.getElementById('total_ea_base').value;
  let total_ena = document.getElementById('total_ena_base').value;
  let total_mo = document.getElementById('total_mo_base').value;
  let total_usd_objetivo = document.getElementById('total_usd_base').value;

  document.getElementById('total_ea_objetivo').value = total_ea;
  document.getElementById('total_ena_objetivo').value = total_ena;
  document.getElementById('total_mo_objetivo').value = total_mo;
  document.getElementById('total_usd_objetivo').value = total_usd_objetivo;
}

function set_inversion_real(){
  let total_ea = document.getElementById('total_ea_invertido').value;
  let total_ena = document.getElementById('total_ena_invertido').value;
  let total_mo = document.getElementById('total_mo_invertido').value;
  let total_usd_objetivo = document.getElementById('total_usd_invertido').value;

  document.getElementById('total_ea_objetivo').value = total_ea;
  document.getElementById('total_ena_objetivo').value = total_ena;
  document.getElementById('total_mo_objetivo').value = total_mo;
  document.getElementById('total_usd_objetivo').value = total_usd_objetivo;
}

function get_gastos(total){
  let mantto = 0.0;
  let gasto_mtto_percent = parseFloat(document.getElementById("gasto_mtto_percent").value);
  let enlace = document.getElementById("enlace").value;
  enlace = parseFloat(enlace) * 1.1;
  let total_inversion = parseFloat(total);
  let plazo = parseInt(document.getElementById("plazo").value);
  let interes = parseFloat(document.getElementById('credito_mensual_percent').value) / 100;
  interes = interes / 12;
  let capex = parseFloat(document.getElementById("capex").value);
  let deposito = parseFloat(document.getElementById("deposito").value);
  let credito_mensual = 0.0;
  let total_gastos = 0.0;

  credito_mensual =  ((total_inversion - capex  - deposito) * interes  )  /  (1 - Math.pow(1 + interes, - plazo));
  mantto = (total_inversion * parseFloat(gasto_mtto_percent)) / 100;
  enlace += (enlace * 0.10)

  total_gastos = enlace + mantto + credito_mensual;
console.log(mantto);
  return total_gastos;

}

function set_table_objetivos(total){
  let total_inversion = total;
  let vtc = parseFloat(document.getElementById('vtc_cotizador').value);
  let renta = parseFloat(document.getElementById("servicio_mensual").value);
  let enlace = document.getElementById("enlace").value;
  enlace = parseFloat(enlace) * 1.1;
  let plazo = parseInt(document.getElementById("plazo").value);
  let capex = document.getElementById("capex").value;
  let deposito = document.getElementById("deposito").value;
  let total_gastos = get_gastos(total_inversion);
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
  var mantenimiento = remove_commas(document.getElementById('gasto_mtto').value);
  mantenimiento = parseFloat(mantenimiento);
  var flujo_neto = renta - mantenimiento;
  var suma_total = total_inversion;
  var vpc = 0.0;
  var tir =  .000000;
  var tir_anualizado = 0.00;
  console.log(flujo_neto);
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
  document.getElementById("utilidad_mensual").innerHTML = format_number(utilidad_mensual);
  document.getElementById("utilidad_mensual_percent").innerHTML = Math.round(utilidad_mensual_percent);
  document.getElementById("utilidad_proyecto").innerHTML = format_number(utilidad_proyecto);
  document.getElementById("utilidad_inversion").innerHTML = Math.round(utilidad_inversion);
  document.getElementById("utilidad_3_anios").innerHTML = format_number(utilidad_3_anios);
  document.getElementById("utilidad_3_anios_percent").innerHTML = format_number(utilidad_3_anios_minimo);
  document.getElementById("renta_mensual_inversion").innerHTML = Math.round(renta_mensual_inversion);
  document.getElementById("utilidad_renta").innerHTML = parseInt(utilidad_renta_percent);
  document.getElementById("tiempo_retorno").innerHTML = format_number(tiempo_retorno);
  document.getElementById("vtc").innerHTML = format_number(vtc);
  document.getElementById("vtc_percent").innerHTML = parseInt(vtc_percent);
  document.getElementById("tir").innerHTML = parseInt(tir_anualizado);

  parametros_objetivos(Math.round(renta_mensual_inversion), Math.round(utilidad_inversion), tir, utilidad_renta_percent, tiempo_retorno, utilidad_3_anios_minimo);
}

function get_linea_base(){

}

function get_tir(){
  let renta = parseFloat(document.getElementById("servicio_mensual").value);
  let plazo = parseInt(document.getElementById("plazo").value);
  let total_inversion = get_totales();
  total_inversion = parseFloat(total_inversion);
  let anio = parseInt(plazo) / 12;
  anio = Math.round(anio);
  let tir =  (renta * 12 * anio) / total_inversion;
  tir = tir - 1;
  tir = tir / anio;
  tir = tir * 100;

  return tir;

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
