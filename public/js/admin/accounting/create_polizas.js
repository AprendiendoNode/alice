$(function(){
    //$('.cuenta_contable').select2();
    /*Configura datepicker*/
  $("#form_create_asientos_contables input[name='date_poliza']").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    //minDate: moment(),
    locale: {
        format: "DD-MM-YYYY"
    },
    autoUpdateInput: false,
    }, function (chosen_date) {
        $("#form_create_asientos_contables input[name='date_poliza']").val(chosen_date.format("DD-MM-YYYY"));
        set_date_inputs(chosen_date);
    });

})

$('#add_mov_cc').on('click', function(){
    let tr_last = $('#create_asiento_contable tbody tr:last');
    let trTemplateMov = $('#trTemplateMov'); 
    trTemplateMov.clone().removeClass('d-none').insertAfter(tr_last);
    trTemplateMov.find('.cuenta_contable').addClass('required', true);
})

function delete_mov_cc(e){
    let row = e.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

function set_date_inputs(chosen_date){
    let dia = moment(chosen_date).format("DD");
    let mes = moment(chosen_date).format("MMMM");
    let date_invoice = chosen_date.format("YYYY-MM-DD");

    $('#day_poliza').val(dia);
    $('#mes_poliza').val(mes);
    $('#date_invoice').val(date_invoice);

    let list = document.getElementsByClassName('dia');
    
    for (let n = 0; n < list.length; ++n) {
        list[n].value= dia;
    }
    
}

$("#form_create_asientos_contables").on('submit', function(e){
    e.preventDefault();
    let total_cargos = remove_commas($('#total_cargos').val());
    total_cargos = parseFloat(total_cargos);
    let total_abonos = remove_commas($('#total_abonos').val());
    total_abonos = parseFloat(total_abonos);

  if(check_totales_asientos(total_cargos, total_abonos)){

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
        var asientos = [];

        $('#create_asiento_contable tbody tr').each(function(row, tr){
          let cuenta_contable = $(tr).find('.cuenta_contable').val();
          let dia = $(tr).find('.dia').val();
          let tipo_cambio = $(tr).find('.tipo_cambio').val();
          let nombre = $(tr).find('.nombre').val();
          let cargo = $(tr).find('.cargos').val();
          let abono = $(tr).find('.abonos').val();
          let referencia = $(tr).find('.referencia').val();

          element = {
            "cuenta_contable_id" : cuenta_contable,
            "dia" : dia,
            "tipo_cambio" : tipo_cambio,
            "nombre" : nombre,
            "cargo" : parseFloat(cargo),
            "abono" : parseFloat(abono),
            "referencia" : referencia
          }

          asientos.push(element);

        });
        
        let form = $('#form_create_asientos_contables')[0];
        let formData = new FormData(form);

        formData.append('movs_polizas',JSON.stringify(asientos));
        formData.append('total_cargos_format',total_cargos);
        formData.append('total_abonos_format',total_abonos);

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

         return fetch('/accounting/customer-polizas-create-movs', miInit)
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
  
      if (result.value == 1) {
        Swal.fire({
          title: 'Poliza guardada',
          text: "",
          type: 'success',
        }).then(function (result) {
          if (result.value) {
            window.location = "/accounting/view-create-polizas";
          }
        })
      }else if(result.value == 2){
        Swal.fire(
          'El periodo se encuentra cerrado','Ingrese la poliza con una fecha del periodo actual','warning'
        )
      }else{
        Swal.fire(
          'Ocurrio un error', '', 'error'
        )
      }
    })

  }else{
    Swal.fire(
      'Los totales no coinciden',
      'Revisar los saldos de los cargos y abonos',
      'warning'
    );
  }
})