function modal_periodo_actual(){
    get_periodo_actual();
    $('#modal-periodo-actual').modal('show');
}

function modal_cerrar_periodo(){
    get_periodo_actual();
    $('#modal-periodo-cierre').modal('show');
}

function modal_cerrar_ejercicio(){
    
    $('#modal-ejercicio-cierre').modal('show');
}


function get_periodo_actual(){
    var form = $('#form')[0];
    var formData = new FormData(form);
    
    $.ajax({
        type: "POST",
        url: "/accounting/get_periodo_actual",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data){
            $('#fecha_inicio_ejercicio_actual_read').val(data[0].fecha_inicio_ejercicio);
            $('#fecha_final_ejercicio_actual_read').val(data[0].fecha_final_ejercicio);
            $('#periodo_actual_read').val(data[0].periodo);
            $('#fecha_inicial_periodo_actual_read').val(data[0].fecha_inicio_periodo);
            $('#fecha_final_periodo_actual_read').val(data[0].fecha_final_periodo);
        },
        error: function (err) {
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: err.statusText,
            });
        }
    });    
}

$('#ejercicio').on('change', function(){
    var _token = $('input[name="_token"]').val();
    let ejercicio = $(this).val();

    if(ejercicio != ''){
        $.ajax({
            type: "POST",
            url: "/accounting/get_periodos_by_year",
            data: { ejercicio : ejercicio, _token : _token },
            success: function (data){
                console.log(data);
                $('#periodo').empty();
                $('#periodo').append("<option value=''>Seleccionar periodo</option>");
                $.each(data, function(i, item) {
                    $('#periodo').append("<option value="+item.periodo+">"+item.periodo+"</option>");
                });
            },
            error: function (err) {
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: err.statusText,
                });
            }
        });
    } 

});

$('#periodo').on('change', function(){
    var _token = $('input[name="_token"]').val();
    let ejercicio = $('#ejercicio').val();
    let periodo = $(this).val();

    if(ejercicio != '' && periodo  != ''){
        $.ajax({
            type: "POST",
            url: "/accounting/get_periodo_month",
            data: { anio : ejercicio, periodo : periodo , _token : _token },
            success: function (data){
                $('#status_periodo').val(data[0].status);    
                $('#fecha_inicio_ejercicio_close').val(data[0].fecha_inicio_ejercicio);
                $('#fecha_final_ejercicio_close').val(data[0].fecha_final_ejercicio);
                $('#fecha_inicial_periodo_close').val(data[0].fecha_inicio_periodo);
                $('#fecha_final_periodo_close').val(data[0].fecha_final_periodo);
            },
            error: function (err) {
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: err.statusText,
                });
            }
        });
    } 

});

$('#form-cerrar-periodo').on('submit', function(e){
  e.preventDefault();
  
  let ejercicio = $('#ejercicio').val();
  let periodo = $('#periodo').val();

  if(ejercicio != '' && periodo  != ''){
      Swal.fire({
          title: "¿Estás seguro?",
          text: "No se podra revertir este cambio",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Confirmar',
          cancelButtonText: 'Cancelar',
          showLoaderOnConfirm: true,
          preConfirm: () => {
    
            var _token = $('input[name="_token"]').val();
            let form = $('#form-cerrar-periodo')[0];
            let formData = new FormData(form);  
    
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
    
             return fetch('/accounting/cerrarPeriodoMensual', miInit)
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
              title: 'Cierre del periodo realizado correctamente',
              text: "",
              type: 'success',
            }).then(function (result) {
              if (result.value) {
                window.location = "/accounting/view_accounting_configuration";
              }
            })
          }else{
            Swal.fire(
              'No se realizo el cierre del periodo','','error'
            )
          }
        })

  }else{
      Swal.fire(
          'Debe seleccionar el ejercicio','','error'
        )
  }

  
});
/***************************************************************/

$('#form-cerrar-ejercicio').on('submit', function(e){
    e.preventDefault();
    
    let ejercicio = $('#ejercicio_cierre_anual').val();
    let periodo = $('#periodo_cierre_anual').val();

    if(ejercicio != '' && periodo  != ''){
        Swal.fire({
            title: "¿Estás seguro?",
            text: "No se podra revertir este cambio",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
      
              var _token = $('input[name="_token"]').val();
              let form = $('#form-cerrar-ejercicio')[0];
              let formData = new FormData(form);  
      
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
      
               return fetch('/accounting/cerrar_ejercicio', miInit)
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
                title: 'Cierre del ejercicio realizado correctamente',
                text: "",
                type: 'success',
              }).then(function (result) {
                if (result.value) {
                  window.location = "/accounting/view_accounting_configuration";
                }
              })
            }else{
              Swal.fire(
                'No se realizo el cierre del ejercicio','','error'
              )
            }
          })

    }else{
        Swal.fire(
            'Debe seleccionar el ejercicio','','error'
          )
    }

    
});


