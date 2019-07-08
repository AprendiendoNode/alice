var _token = $('input[name="_token"]').val();

const headers = new Headers({
  "Accept": "application/json",
  "X-Requested-With": "XMLHttpRequest",
  "X-CSRF-TOKEN": _token
})

var initGet = {
    method: 'get',
    headers: headers,
    credentials: "same-origin",
    cache: 'default'
};

(function(){
  getAllBranchOffice(initGet);
}())


$('#select_paises').on('change', function(){
  let id = $(this).val();
  let select_states = document.getElementById('select_estados');

  while (select_states.firstChild) {
    select_states.removeChild(select_states.firstChild);
  }

  fetch(`/base/state-country/${id}`, initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      data.forEach(function(key) {
        let option = document.createElement("option");
        option.value = key.id;
        option.text = key.name;
        select_states.add(option);
      });
    })
    .catch(err => {
      console.log(err);
    })
})

$('#select_estados').on('change', function(){
  let id = $(this).val();
  let select_ciudades = document.getElementById('select_ciudades');

  while (select_ciudades.firstChild) {
    select_ciudades.removeChild(select_ciudades.firstChild);
  }

  fetch(`/base/cities-state/${id}`, initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      data.forEach(function(key) {
        let option = document.createElement("option");
        option.value = key.id;
        option.text = key.name;
        select_ciudades.add(option);
      });
    })
    .catch(err => {
      console.log(err);
    })
})

$('#select_paises_edit').on('change', function(){
  let id = $(this).val();
  let select_states = document.getElementById('select_estados_edit');

  while (select_states.firstChild) {
    select_states.removeChild(select_states.firstChild);
  }

  fetch(`/base/state-country/${id}`, initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      data.forEach(function(key) {
        let option = document.createElement("option");
        option.value = key.id;
        option.text = key.name;
        select_states.add(option);
      });
    })
    .catch(err => {
      console.log(err);
    })
})

$('#select_estados_edit').on('change', function(){
  let id = $(this).val();
  let select_ciudades = document.getElementById('select_ciudades_edit');

  while (select_ciudades.firstChild) {
    select_ciudades.removeChild(select_ciudades.firstChild);
  }

  fetch(`/base/cities-state/${id}`, initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      data.forEach(function(key) {
        let option = document.createElement("option");
        option.value = key.id;
        option.text = key.name;
        select_ciudades.add(option);
      });
    })
    .catch(err => {
      console.log(err);
    })
})

$('#createBranchOffice').formValidation({
 framework: 'bootstrap',
 excluded: ':disabled',
   fields: {
     inputCreateName: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     inputZipCode: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     inputCreatOrden: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     select_paises: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     select_estados: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     select_ciudades: {
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

      var form = $('#createBranchOffice')[0];
      var formData = new FormData(form);

      var myInit = {
          method: 'post',
          headers: headers,
          credentials: "same-origin",
          body:formData,
          cache: 'default'
      };

      fetch('/base/branch-office-store',myInit)
        .then(response => {
          return response.json();
        })
        .then(data => {
          if(data.status == 200){
            let timerInterval;
            Swal.fire({
              type: 'success',
              title: 'Operación Completada!',
              html: 'Aplicando los cambios.',
              timer: 2000,
              onBeforeOpen: () => {
                Swal.showLoading()
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
                window.location.href = "/base/branch-office";
              }
            });
          }
        })
        .catch(err => {
          console.log(err);
          Swal.fire({
             type: 'error',
             title: 'Error encontrado..',
             text: 'Operacion cancelada',
           });
        })
});
//Editar Usuario
$('#editBranchOffice').formValidation({
  framework: 'bootstrap',
  excluded: ':disabled',
    fields: {
      inputEditName: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputZipCode: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inpuEditOrden: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      select_paises_edit: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      select_estados_edit: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      select_ciudades_edit: {
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
  var objData = $("#editBranchOffice").find("select,textarea, input").serialize();
  $.ajax({
    type: "POST",
    url: '/base/branch-office-update',
    data: objData,
    success: function (data) {
      if (data.status == '200') {
        $('#modal-Edit-Branch').modal('toggle');
        menssage_toast('Mensaje', '4', 'Sucursal actualizada!' , '3000');
        getAllBranchOffice(initGet);
      }else{
        menssage_toast('Mensaje', '2', 'Ocurrio un error!' , '3000');
      }
    },
    error: function (data) {
      console.log(data);
      menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
    }
  });
  $("#editBranchOffice")[0].reset();
  $('#editBranchOffice').data('formValidation').resetForm($('#editBranchOffice'));
});

function getAllBranchOffice(init){

  fetch("/base/get-all-branch", init)
    .then(response => {
      return response.json();
    })
    .then(data => {
      table_exchange_rate(data, $('#table_branch'));
    })
    .catch(err => {
      console.log(err);
    })
}

function table_exchange_rate(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_classification);
  vartable.fnClearTable();

  datajson.forEach(key => {
    var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Habilitado</span>';
    if (key.status == 0) {
      badge='<span class="badge badge-danger badge-pill text-uppercase text-white">Inhabilitado</span>';
    }
    vartable.fnAddData([
      key.name,
      key.email,
      key.phone,
      key.country,
      key.state,
      key.city,
      badge,
      '<a href="javascript:void(0);" onclick="editar_branch(this)" class="btn btn-primary  btn-sm mr-2 p-1" value="'+key.id+'"><i class="fas fa-pencil-alt btn-icon-prepend fastable"></i></a>'
    ]);
  })

}

//Mostrar - Edit branch-office
function editar_branch(e){
  var valor = e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');

  $.ajax({
       type: "POST",
       url: '/base/branch-office-edit',
       data: {id : valor, _token : _token},
       success: function (data) {
          $("#editBranchOffice")[0].reset();
          $('#editBranchOffice').data('formValidation').resetForm($('#editBranchOffice'));

         if (data != []) {
           $('#id_branch').val(data[0].id);
           $('#inputEditName').val(data[0].name);
           $('#inputEditEmail').val(data[0].email);
           $('#inputEditPhone').val(data[0].phone);
           $('#inputEditPhoneMobile').val(data[0].phone_mobile);
           $('#inputEditOrden').val(data[0].sort_order);
           $('#datainfoEdit').val(data[0].comment);
           $('[name="select_paises_edit"]').val(data[0].country_id);
           $('[name="select_estados_edit"]').val(data[0].state_id);
           $('[name="select_ciudades_edit"]').val(data[0].city_id);
           $('#inputZipCodeEdit').val(data[0].postcode);
           $('#inputEditAddress_1').val(data[0].address_1);
           $('#inputEditAddress_2').val(data[0].address_2);
           $('#inputEditAddress_3').val(data[0].address_3);
           $('#inputEditAddress_4').val(data[0].address_4);
           $('#inputEditAddress_5').val(data[0].address_5);
           $('#inputEditAddress_6').val(data[0].address_6);

           data[0].status == '0' ? $("#statusEdit").prop('checked', false).change() : $('#statusEdit').prop('checked', true).change();


           $('#modal-Edit-Branch').modal('show');
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
  "pageLength": 5,
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
