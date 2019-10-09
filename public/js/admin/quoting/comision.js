function show_comision(){
  let vtc = parseFloat(document.getElementById('vtc_cotizador').value);
  if(!isNaN(vtc)){
    $('#modal_comision').modal('show');
  }else{
    Swal.fire('Este proyecto no tiene un cotizador asociado','','warning');
  }
}

function comisionByDefault(){
  let id = document.getElementById('id').value;
  let itconciergecomision = document.getElementById('itconciergecomision').value;
  let vendedor = document.getElementById('vendedor').value;
  let inside_sales = document.getElementById('inside_sales').value;
  let colaborador = document.getElementById('colaborador').value;
  let contacto_comercial = document.getElementById('contacto_comercial').value;
  let cierre = document.getElementById('cierre').value;
  let comision_externo = document.getElementById('comision_externo').value;
  let comision_externo_2 = document.getElementById('comision_externo_2').value;

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

  var _token = $('input[name="_token"]').val();

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
    text: "Se calculara los porcentajes deacuerdo a la politica de comisiones",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Continuar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.value) {
      fetch('/update_kickoff_comisionByDefault', miInit)
        .then(response => {
          if(response.ok) {
            Swal.fire('Comisión guardada','', 'success');
            return response.json();
          } else {
            Swal.fire('Ocurrio un error al guardar','', 'error');
          }
        })
        .then(data => {
          console.log(data);
          document.getElementById('amount_comission_itc').value =format_number(data.amount_itc);
          document.getElementById('amount_inside_sales').value = format_number(data.amount_inside_sales);
          document.getElementById('amount_contacto').value = format_number(data.amount_contacto);
          document.getElementById('amount_cierre').value = format_number(data.amount_cierre);

          document.getElementById('percent_comission_itc').value = data.percent_itc;
          document.getElementById('percent_inside_sales').value = data.percent_inside_sales;
          document.getElementById('percent_contacto').value = data.percent_contacto;
          document.getElementById('percent_cierre').value = data.percent_cierre;

          document.getElementById('amount_comision_vendedor').value = 0.00;
          document.getElementById('amount_colaborador').value = 0.00;
          document.getElementById('amount_externo1').value = 0.00;
          document.getElementById('amount_externo2').value = 0.00;
          document.getElementById('percent_colaborador').value = 0;
          document.getElementById('percent_comision_vendedor').value = 0;
          document.getElementById('percent_externo1').value = 0;
          document.getElementById('percent_externo2').value = 0;

        })
        .catch( error => {
          console.log('Hubo un problema con la petición:' + error.message);
        });
     }
  })

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
  let amount_colaborador = document.getElementById('amount_colaborador').value;
  let amount_contacto = document.getElementById('amount_contacto').value;
  let amount_cierre = document.getElementById('amount_cierre').value;
  let amount_externo1 = document.getElementById('amount_externo1').value;
  let amount_externo2 = document.getElementById('amount_externo2').value;
  let percent_comission_itc = document.getElementById('percent_comission_itc').value;
  let percent_comision_vendedor = document.getElementById('percent_comision_vendedor').value;
  let percent_inside_sales = document.getElementById('percent_inside_sales').value;
  let percent_colaborador = document.getElementById('percent_colaborador').value;
  let percent_contacto = document.getElementById('percent_contacto').value;
  let percent_cierre = document.getElementById('percent_cierre').value;
  let percent_externo1 = document.getElementById('percent_externo1').value;
  let percent_externo2 = document.getElementById('percent_externo2').value;


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
    comision_externo_2: comision_externo_2,
    amount_comision_itc: remove_commas(amount_comission_itc),
    amount_comision_vendedor: remove_commas(amount_comision_vendedor),
    amount_inside_sales: remove_commas(amount_inside_sales),
    amount_colaborador: remove_commas(amount_colaborador),
    amount_contacto: remove_commas(amount_contacto),
    amount_cierre: remove_commas(amount_cierre),
    amount_externo1: remove_commas(amount_externo1),
    amount_externo2: remove_commas(amount_externo2),
    percent_comission_itc: percent_comission_itc,
    percent_comision_vendedor: percent_comision_vendedor,
    percent_inside_sales: percent_inside_sales,
    percent_colaborador: percent_colaborador,
    percent_contacto: percent_contacto,
    percent_cierre: percent_cierre,
    percent_externo1: percent_externo1,
    percent_externo2: percent_externo2,
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
    text: "Se guardara la comision personalizada",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Continuar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.value) {
      fetch('/update_kickoff_comision', miInit)
        .then(response => {
          if(response.ok) {
            Swal.fire('Comisión guardada','', 'success');
            return response.text();
          } else {
            Swal.fire('Ocurrio un error al guardar','', 'error');
          }
        })
      .catch( error => {
        console.log('Hubo un problema con la petición Fetch:' + error.message);
      });
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
