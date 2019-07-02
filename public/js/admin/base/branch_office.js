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
  fetch(`/base/state-country/${id}`, initGet)
    .then(response => {
      return response.json();
    })
    .then(data => {
      console.log(data);
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
          console.log(data);
        })
        .catch(err => {
          console.log(err);
        })
});
