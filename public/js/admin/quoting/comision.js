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
  let percent_colaborador = parseInt(document.getElementById('percent_colaborador').value);
  let percent_contacto = parseInt(document.getElementById('percent_contacto').value);
  let percent_cierre = parseInt(document.getElementById('percent_cierre').value);
  let percent_externo1 = parseInt(document.getElementById('percent_externo1').value);
  let percent_externo2 = parseInt(document.getElementById('percent_externo2').value);
  let suma_percent = 0;

  suma_percent = percent_comission_itc + percent_comision_vendedor + percent_inside_sales + percent_colaborador + percent_contacto + percent_cierre + percent_externo1 + percent_externo2;
  console.log(suma_percent);

  if(suma_percent > 100){
    Swal.fire(``,'El porcentaje total de la comisión supera el 100%', 'warning');
    e.value = 0;
    calcularComision(e);
  }else{
    document.getElementById('amount_comission_itc').value = format_number((total_comision *  percent_comission_itc)  / 100);
    document.getElementById('amount_comision_vendedor').value = format_number((total_comision *  percent_comision_vendedor)  / 100);
    document.getElementById('amount_inside_sales').value = format_number((total_comision *  percent_inside_sales)  / 100);
    document.getElementById('amount_colaborador').value = format_number((total_comision *  percent_colaborador)  / 100);
    document.getElementById('amount_contacto').value = format_number((total_comision *  percent_contacto)  / 100);
    document.getElementById('amount_cierre').value = format_number((total_comision *  percent_cierre)  / 100);
    document.getElementById('amount_externo1').value = format_number((total_comision *  percent_externo1)  / 100);
    document.getElementById('amount_externo2').value = format_number((total_comision *  percent_externo2)  / 100);
  }
}

function save_comision(){

  let id = document.getElementById('id').value;
  let itconciergecomision = document.getElementById('itconciergecomision').value;
  let vendedor = document.getElementById('vendedor').value;
  let inside_sales = document.getElementById('inside_sales').value;
  let colaborador = document.getElementById('colaborador').value;
  let contacto_comercial = document.getElementById('contacto_comercial').value;
  let cierre = document.getElementById('cierre').value;
  let comision_externo = document.getElementById('comision_externo').value;
  let comision_externo_2 = document.getElementById('comision_externo_2').value;
  let amount_comission_itc = document.getElementById('amount_comission_itc').value;
  let amount_comision_vendedor = document.getElementById('amount_comision_vendedor').value;
  let amount_inside_sales = document.getElementById('amount_inside_sales').value;
  let amount_comission_itc = document.getElementById('amount_comission_itc').value;
  let amount_comission_itc = document.getElementById('amount_comission_itc').value;
  let amount_comission_itc = document.getElementById('amount_comission_itc').value;
  let amount_comission_itc = document.getElementById('amount_comission_itc').value;
  let amount_comission_itc = document.getElementById('amount_comission_itc').value;


  var _token = $('input[name="_token"]').val();

  const headers = new Headers({
      "Accept": "application/json",
      "X-Requested-With": "XMLHttpRequest",
      "X-CSRF-TOKEN": _token
  })

  var data = {
    id: id,
    itconciergecomision: itconciergecomision,
    vendedor: vendedor,
    inside_sales: inside_sales,
    colaborador: colaborador,
    contacto_comercial: contacto_comercial,
    cierre: cierre,
    comision_externo: comision_externo,
    comision_externo_2: comision_externo_2
  }

  const headers2 = new Headers({
        "Accept": "application/json",
        'Content-Type': 'application/json',
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-TOKEN": _token
  })


  var miInit = {
    method: 'post',
    headers: headers2,
    credentials: "same-origin",
    body: JSON.stringify(data),
    cache: 'default' };



  Swal.fire({
    title: '¿Estas seguro?',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
      Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      )
    }
  })

}

//Formato numerico: 00,000.00
function format_number(number){
  return number.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function remove_commas(number){
  return number.replace(/,/g, "");
}
