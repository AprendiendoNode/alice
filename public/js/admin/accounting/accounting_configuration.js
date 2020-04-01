
function modal_periodo_actual(){
    get_periodo_actual();
    $('#modal-periodo-actual').modal('show');
}

function modal_cerrar_periodo(){
    get_periodo_actual();
    $('#modal-periodo-cierre').modal('show');
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
            console.log(data);
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
