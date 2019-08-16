var _token = $('input[name="_token"]').val();
const headers = new Headers({
    "Accept": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": _token
})

var form_kickoff = document.getElementById("form_kickoff");
var check_administracion = document.getElementById("check_administracion");
var check_comercial = document.getElementById("check_comercial");
var check_proyectos = document.getElementById("check_proyectos");
var check_soporte = document.getElementById("check_soporte");
var check_planeacion = document.getElementById("check_planeacion");
//EVENT LISTENERS CHECKBOX APPROVALS
check_administracion.addEventListener('change', approval_administracion);
check_comercial.addEventListener('change', approval_comercial);
check_proyectos.addEventListener('change', approval_proyectos);
check_soporte.addEventListener('change', approval_soporte);
check_planeacion.addEventListener('change', approval_planeacion);

/********* UPDATE KICKOFF *********/
form_kickoff.onsubmit = function(e){
  e.preventDefault();

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

      var form = $('#form_kickoff')[0];
      var formData = new FormData(form);
      var miInit = {
        method: 'post',
        headers: headers,
        credentials: "same-origin",
        body:formData,
        cache: 'default' };

       return fetch('/update_kickoff', miInit)
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
    console.log(result.value);
    if (result.value == "true") {
      console.log(result);
      localStorage.clear();
      Swal.fire({
        title: 'Documento A actualizado',
        text: "",
        type: 'success',
      }).then(function (result) {

      })
    }else{
      Swal.fire(
        'Datos no actualizados','','error'
      )
    }
  })
}
/***********************************************************/

function approval_administracion(){
  var id = document.getElementById('id').value;
  var miInit = {
    method: 'get',
    headers: headers,
    credentials: "same-origin",
    cache: 'default' };

     fetch(`/approval_administracion/id_doc/${id}`, miInit)
         .then(function(response){
           if (!response.ok) {
              throw new Error(response.statusText)
            }
           return response.text();
         })
         .then(function(data){
           if(data == "1"){
             document.getElementById("check_administracion").disabled = true;
             Swal.fire({
               title: 'Aprobado por:',
               text: "Dirección de Administración y Finanzas",
               type: 'success',
             }).then(function (result) {
               if (result.value) {
                 location.reload();
               }
             })
           }else if(data == "2"){
             Swal.fire({
               title: 'Cotizador autorizado por comité',
               text: "Este documento se ha convertido a Documento P",
               type: 'success',
             }).then(function (result) {
               if (result.value) {
                 location.reload();
               }
             })
           }
         })
         .catch(function(error){
           Swal.fire(
             `Request failed: ${error}`
           )
         });
}

function approval_comercial(){
  var id = document.getElementById('id').value;
  var miInit = {
    method: 'get',
    headers: headers,
    credentials: "same-origin",
    cache: 'default' };

     fetch(`/approval_comercial/id_doc/${id}`, miInit)
         .then(function(response){
           if (!response.ok) {
              throw new Error(response.statusText)
            }
           return response.text();
         })
         .then(function(data){
           if(data == "1"){
             document.getElementById("check_comercial").disabled = true;
             Swal.fire({
               title: 'Aprobado por:',
               text: "Comercial",
               type: 'success',
             }).then(function (result) {
               if (result.value) {
                 location.reload();
               }
             })
           }else if(data == "2"){
             Swal.fire({
               title: 'Cotizador autorizado por comité',
               text: "Este documento se ha convertido a Documento P",
               type: 'success',
             }).then(function (result) {
               if (result.value) {
                 location.reload();
               }
             })
           }
         })
         .catch(function(error){
           Swal.fire(
             `Request failed: ${error}`
           )
         });
}

function approval_proyectos(){
  var id = document.getElementById('id').value;
  var miInit = {
    method: 'get',
    headers: headers,
    credentials: "same-origin",
    cache: 'default' };

     fetch(`/approval_proyectos/id_doc/${id}`, miInit)
         .then(function(response){
           if (!response.ok) {
              throw new Error(response.statusText)
            }
           return response.text();
         })
         .then(function(data){
           if(data == "1"){
             document.getElementById("check_proyectos").disabled = true;
             Swal.fire({
               title: 'Aprobado por:',
               text: "Proyectos e instalaciones",
               type: 'success',
             }).then(function (result) {
               if (result.value) {
                 location.reload();
               }
             })
           }else if(data == "2"){
             Swal.fire({
               title: 'Cotizador autorizado por comité',
               text: "Este documento se ha convertido a Documento P",
               type: 'success',
             }).then(function (result) {
               if (result.value) {
                 location.reload();
               }
             })
           }
         })
         .catch(function(error){
           Swal.fire(
             `Request failed: ${error}`
           )
         });
  }

function approval_soporte(){
  var id = document.getElementById('id').value;
  var miInit = {
    method: 'get',
    headers: headers,
    credentials: "same-origin",
    cache: 'default' };

     fetch(`/approval_soporte/id_doc/${id}`, miInit)
         .then(function(response){
           if (!response.ok) {
              throw new Error(response.statusText)
            }
           return response.text();
         })
         .then(function(data){
           if(data == "1"){
             document.getElementById("check_soporte").disabled = true;
             Swal.fire({
               title: 'Aprobado por:',
               text: "Soporte",
               type: 'success',
             }).then(function (result) {
               if (result.value) {
                 location.reload();
               }
             })
           }else if(data == "2"){
             Swal.fire({
               title: 'Cotizador autorizado por comité',
               text: "Este documento se ha convertido a Documento P",
               type: 'success',
             }).then(function (result) {
               if (result.value) {
                 location.reload();
               }
             })
           }
         })
         .catch(function(error){
           Swal.fire(
             `Request failed: ${error}`
           )
         });
  }

  function approval_planeacion(){
    var id = document.getElementById('id').value;
    var miInit = {
      method: 'get',
      headers: headers,
      credentials: "same-origin",
      cache: 'default' };

       fetch(`/approval_planeacion/id_doc/${id}`, miInit)
           .then(function(response){
             if (!response.ok) {
                throw new Error(response.statusText)
              }
             return response.text();
           })
           .then(function(data){
             if(data == "1"){
               document.getElementById("check_planeacion").disabled = true;
               Swal.fire({
                 title: 'Aprobado por:',
                 text: "Planeación y estrategia",
                 type: 'success',
               }).then(function (result) {
                 if (result.value) {
                   location.reload();
                 }
               })
             }else if(data == "2"){
               Swal.fire({
                 title: 'Cotizador autorizado por comité',
                 text: "Este documento se ha convertido a Documento P",
                 type: 'success',
               }).then(function (result) {
                 if (result.value) {
                   location.reload();
                 }
               })
             }
           })
           .catch(function(error){
             Swal.fire(
               `Request failed: ${error}`
             )
           });
    }
