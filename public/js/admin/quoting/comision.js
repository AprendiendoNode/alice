function show_comision(){
  let vtc = parseFloat(document.getElementById('vtc_cotizador').value);
  if(!isNaN(vtc)){
    $('#modal_comision').modal('show');
  }else{
    Swal.fire('Este proyecto no tiene un cotizador asociado','','warning');
  }
}

function calcularComision(e){
  e.value = parseInt(e.value);
  let total_comision = parseFloat(document.getElementById("total_comision").innerHTML.replace(/,/g, ""));
  let percent_comission_itc = parseInt(document.getElementById('percent_comission_itc').value);
  let percent_comision_vendedor = parseInt(document.getElementById('percent_comision_vendedor').value);
  let percent_inside_sales = parseInt(document.getElementById('percent_inside_sales').value);
  let percent_contacto = parseInt(document.getElementById('percent_contacto').value);
  let percent_cierre = parseInt(document.getElementById('percent_cierre').value);
  let percent_externo1 = parseInt(document.getElementById('percent_externo1').value);
  let percent_externo2 = parseInt(document.getElementById('percent_externo2').value);
  let suma_percent = 0;

  suma_percent = percent_comission_itc + percent_comision_vendedor + percent_inside_sales + percent_contacto + percent_cierre + percent_externo1 + percent_externo2;
  console.log(suma_percent);

  if(suma_percent > 100){
    Swal.fire(``,'El porcentaje total de la comisión supera el 100%', 'warning');
    e.value = 0;
    calcularComision(e);
  }else{
    document.getElementById('amount_comission_itc').value = format_number((total_comision *  percent_comission_itc)  / 100);
    document.getElementById('amount_comision_vendedor').value = format_number((total_comision *  percent_comision_vendedor)  / 100);
    document.getElementById('amount_inside_sales').value = format_number((total_comision *  percent_inside_sales)  / 100);
    document.getElementById('amount_contacto').value = format_number((total_comision *  percent_contacto)  / 100);
    document.getElementById('amount_cierre').value = format_number((total_comision *  percent_cierre)  / 100);
    document.getElementById('amount_externo1').value = format_number((total_comision *  percent_externo1)  / 100);
    document.getElementById('amount_externo2').value = format_number((total_comision *  percent_externo2)  / 100);
  }
}

//Formato numerico: 00,000.00
function format_number(number){
  return number.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function remove_commas(number){
  return number.replace(/,/g, "");
}
