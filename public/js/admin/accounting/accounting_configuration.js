
function modal_periodo_actual(){
    $('#modal-periodo-actual').modal('show');
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
