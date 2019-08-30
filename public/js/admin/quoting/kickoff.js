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
var check_itconcierge = document.getElementById("check_itconcierge");
var check_servicio_cliente = document.getElementById("check_servicio_cliente");
var check_facturacion = document.getElementById("check_facturacion");
var check_legal = document.getElementById("check_legal");
var check_director_operaciones = document.getElementById("check_director_operaciones");
var check_director_general = document.getElementById("check_director_general");
//EVENT LISTENERS CHECKBOX APPROVALS
check_administracion.addEventListener('change', approval_administracion);
check_comercial.addEventListener('change', approval_comercial);
check_proyectos.addEventListener('change', approval_proyectos);
check_soporte.addEventListener('change', approval_soporte);
check_planeacion.addEventListener('change', approval_planeacion);
check_itconcierge.addEventListener('change', approval_itconcierge);
check_servicio_cliente.addEventListener('change', approval_servicio_cliente);
check_facturacion.addEventListener('change', approval_facturacion);
check_legal.addEventListener('change', approval_legal);
check_director_operaciones.addEventListener('change', approval_director_operaciones);
check_director_general.addEventListener('change', approval_director_general);

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
                 text: "Compras",
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

    function approval_itconcierge(){
      var id = document.getElementById('id').value;
      var miInit = {
        method: 'get',
        headers: headers,
        credentials: "same-origin",
        cache: 'default' };

         fetch(`/approval_itconcierge/id_doc/${id}`, miInit)
             .then(function(response){
               if (!response.ok) {
                  throw new Error(response.statusText)
                }
               return response.text();
             })
             .then(function(data){
               if(data == "1"){
                 document.getElementById("check_itconcierge").disabled = true;
                 Swal.fire({
                   title: 'Aprobado por:',
                   text: "IT Concierge",
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

      function approval_servicio_cliente(){
        var id = document.getElementById('id').value;
        var miInit = {
          method: 'get',
          headers: headers,
          credentials: "same-origin",
          cache: 'default' };

           fetch(`/approval_servicio_cliente/id_doc/${id}`, miInit)
               .then(function(response){
                 if (!response.ok) {
                    throw new Error(response.statusText)
                  }
                 return response.text();
               })
               .then(function(data){
                 if(data == "1"){
                   document.getElementById("check_servicio_cliente").disabled = true;
                   Swal.fire({
                     title: 'Aprobado por:',
                     text: "Servicio al cliente",
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

      function approval_facturacion(){
        var id = document.getElementById('id').value;
        var miInit = {
          method: 'get',
          headers: headers,
          credentials: "same-origin",
          cache: 'default' };

           fetch(`/approval_facturacion/id_doc/${id}`, miInit)
               .then(function(response){
                 if (!response.ok) {
                    throw new Error(response.statusText)
                  }
                 return response.text();
               })
               .then(function(data){
                 if(data == "1"){
                   document.getElementById("check_facturacion").disabled = true;
                   Swal.fire({
                     title: 'Aprobado por:',
                     text: "Facturación",
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

      function approval_legal(){
        var id = document.getElementById('id').value;
        var miInit = {
          method: 'get',
          headers: headers,
          credentials: "same-origin",
          cache: 'default' };

           fetch(`/approval_legal/id_doc/${id}`, miInit)
               .then(function(response){
                 if (!response.ok) {
                    throw new Error(response.statusText)
                  }
                 return response.text();
               })
               .then(function(data){
                 if(data == "1"){
                   document.getElementById("check_legal").disabled = true;
                   Swal.fire({
                     title: 'Aprobado por:',
                     text: "Legal",
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

        function approval_director_operaciones(){
          var id = document.getElementById('id').value;
          var miInit = {
            method: 'get',
            headers: headers,
            credentials: "same-origin",
            cache: 'default' };

             fetch(`/approval_director_operaciones/id_doc/${id}`, miInit)
                 .then(function(response){
                   if (!response.ok) {
                      throw new Error(response.statusText)
                    }
                   return response.text();
                 })
                 .then(function(data){
                   if(data == "1"){
                     document.getElementById("check_director_operaciones").disabled = true;
                     Swal.fire({
                       title: 'Aprobado por:',
                       text: "Director de Operaciones",
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

          function approval_director_general(){
            var id = document.getElementById('id').value;
            var miInit = {
              method: 'get',
              headers: headers,
              credentials: "same-origin",
              cache: 'default' };

               fetch(`/approval_director_general/id_doc/${id}`, miInit)
                   .then(function(response){
                     if (!response.ok) {
                        throw new Error(response.statusText)
                      }
                     return response.text();
                   })
                   .then(function(data){
                     if(data == "1"){
                       document.getElementById("check_director_general").disabled = true;
                       Swal.fire({
                         title: 'Aprobado por:',
                         text: "Director General",
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
