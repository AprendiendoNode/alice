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
