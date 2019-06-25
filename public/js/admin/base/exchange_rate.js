var _token = $('input[name="_token"]').val();
const headers = new Headers({
  "Accept": "application/json",
  "X-Requested-With": "XMLHttpRequest",
  "X-CSRF-TOKEN": _token
})

var miInit = { method: 'get',
                  headers: headers,
                  credentials: "same-origin",
                  cache: 'default' };

(function(){
  get_exchange();

  //Edit exchange
  $('#editexchange').formValidation({
     framework: 'bootstrap',
     excluded: ':disabled',
     fields: {
       tipo_cambio: {
         validators: {
           notEmpty: {
             message: 'The field is required'
           }
         }
       },
     }
  })
  .on('success.form.fv', function(e) {
       e.preventDefault();
       var form = $('#editexchange')[0];
       var formData = new FormData(form);
       $.ajax({
         type: "POST",
         url: "/base/update_rate",
         data: formData,
         contentType: false,
         processData: false,
         success: function (data){
            if (data.status  == 200) {
              let timerInterval;
              Swal.fire({
                type: 'success',
                title: 'Operación Completada!',
                html: 'Aplicando los cambios.',
                timer: 2500,
                onBeforeOpen: () => {
                  Swal.showLoading ()
                  timerInterval = setInterval(() => {
                    Swal.getContent().querySelector('strong')
                  }, 100)
                },
                onClose: () => {
                  clearInterval(timerInterval)
                }
              }).then((result) => {
                if (
                  // Read more about handling dismissals
                  result.dismiss === Swal.DismissReason.timer
                ) {
                  window.location.href = "/base/exchange_rate";
                }
              });

            }else{
             Swal.fire({
                type: 'error',
                title: 'Error encontrado..',
                text: '',
              });
           }
         },
         error: function (err) {
           Swal.fire({
              type: 'error',
              title: 'Oops...',
              text: err.statusText,
            });
         }
       });
     });
})()

function get_exchange() {
  fetch('/base/show_rate', miInit)
    .then(function(response){
      return response.json();
    })
    .then(function(data){
      table_exchange_rate(data, $("#exchange_rate"));
    })
    .catch(function(error){
      console.log(error);
    });
}

function table_exchange_rate(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_classification);
  vartable.fnClearTable();
  $.each(datajson, function(index, key){
    vartable.fnAddData([
      key.current_date,
      key.current_rate,
      key.moneda,
      key.code_banxico,
      key.modified_rate,
      key.updated_uid,
      '<a href="javascript:void(0);" onclick="editar_exchange(this)" class="btn btn-primary  btn-sm mr-2" value="'+key.id+'"><i class="fas fa-pencil-alt btn-icon-prepend fastable"></i></a>'
    ]);
  });
}

//Mostrar - Edit exchange
function editar_exchange(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');

  $.ajax({
       type: "POST",
       url: '/base/edit_rate',
       data: {value : valor, _token : _token},
       success: function (data) {
          $("#editexchange")[0].reset();
          $('#editexchange').data('formValidation').resetForm($('#editexchange'));

         if (data != []) {
             $('#id_exchange').val(data[0].id);
             $('#tipo_cambio').val(data[0].modified_rate);

            $('#modal-Edit-Exchange').modal('show');
         }
         else {
           Swal.fire({
             type: 'error',
             title: 'Error encontrado..',
             text: 'Realice la operacion nuevamente!',
           });
         }
       },
       error: function (data) {
         alert('Error:', data);
       }
   })
}

var Configuration_table_responsive_simple_classification={
  dom: "<'row'<'col-sm-3'l><'col-sm-9'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
  "order": [[ 0, "desc" ]],
  paging: true,
  //"pagingType": "simple",
  Filter: true,
  searching: true,
  "aLengthMenu": [[3, 5, 10, 25, -1], [3, 5, 10, 25, "Todos"]],
  //ordering: false,
  //"pageLength": 5,
  bInfo: false,
      language:{
              "sProcessing":     "Procesando...",
              "sLengthMenu":     "Mostrar _MENU_ registros",
              "sZeroRecords":    "No se encontraron resultados",
              "sEmptyTable":     "Ningún dato disponible",
              "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
              "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
              "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
              "sInfoPostFix":    "",
              "sSearch":         "Buscar:",
              "sUrl":            "",
              "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
              "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                  "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                  "sSortDescending": ": Activar para ordenar la columna de manera descendente"
              }
      }
}
