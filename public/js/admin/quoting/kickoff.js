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
check_administracion.addEventListener('click', (e) => {
  approval_administracion(e);
});
check_comercial.addEventListener('click', (e) => {
  approval_comercial(e);
});
check_proyectos.addEventListener('click', (e) => {
  approval_proyectos(e);
});
check_soporte.addEventListener('click', (e) => {
  approval_soporte(e);
});
check_planeacion.addEventListener('click', (e) => {
  approval_planeacion(e);
});
check_itconcierge.addEventListener('click', (e) => {
  approval_itconcierge(e);
});
check_servicio_cliente.addEventListener('click', (e) => {
  approval_servicio_cliente(e);
});
check_facturacion.addEventListener('click', (e) => {
  approval_facturacion(e);
});
check_legal.addEventListener('click', (e) => {
  approval_legal(e);
});
check_director_operaciones.addEventListener('click', (e) => {
  approval_director_operaciones(e);
});
check_director_general.addEventListener('click', (e) => {
  approval_director_general(e);
});

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

function approval_administracion(e){
  e.preventDefault();
  e.stopPropagation();
  var id = document.getElementById('id').value;
  var plazo = document.getElementById('plazo').value;
  var rfc = document.getElementById('rfc').value;
  var fecha_inicio = document.getElementById('fecha_inicio').value;
  fecha_inicio = invertirFecha(fecha_inicio);
  var miInit = {
    method: 'get',
    headers: headers,
    credentials: "same-origin",
    cache: 'default' };

    Swal.fire({
      title: "¿Los datos del contrato son correctos?",
      type: "warning",
      //html:
      // `<div class="text-left ml-5"><h6><i class="fas fa-check text-success"></i> Fecha de inicio: ${fecha_inicio}</h6>` +
      // `<h6><i class="fas fa-check text-success"></i> Vigencia: ${plazo} meses</h6>` +
      // `<h6><i class="fas fa-check text-success"></i> RFC: ${rfc}</h6></div>`,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirmar',
      cancelButtonText: 'Cancelar',
      showLoaderOnConfirm: true,
      preConfirm: () => {

         return fetch(`/approval_administracion/id_doc/${id}`, miInit)
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
      if(result.value == "1"){
        document.getElementById("check_administracion").checked = true;
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
      }else if(result.value == "2"){
        document.getElementById("check_administracion").checked = true;
        document.getElementById("check_administracion").disabled = true;
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

}

/***********************************************************/
function approval_comercial(e){
  e.preventDefault();
  e.stopPropagation();
  var id = document.getElementById('id').value;
  var miInit = {
    method: 'get',
    headers: headers,
    credentials: "same-origin",
    cache: 'default' };

    Swal.fire({
      title: "¿Las condiciones comerciales son correctas?",
      type: "warning",
      // html:
      // `<div class="text-left ml-5"><h6><i class="fas fa-check text-success"></i> Fecha de inicio: </h6>` +
      // `<h6><i class="fas fa-check text-success"></i> Vigencia:  meses</h6>` +
      // `<h6><i class="fas fa-check text-success"></i> RFC: </h6></div>`,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirmar',
      cancelButtonText: 'Cancelar',
      showLoaderOnConfirm: true,
      preConfirm: () => {

         return fetch(`/approval_comercial/id_doc/${id}`, miInit)
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
      if(result.value == "1"){
        document.getElementById("check_comercial").checked = true;
        document.getElementById("check_comercial").disabled = true;
        Swal.fire({
          title: 'Aprobado por:',
          text: "Dirección Comercial",
          type: 'success',
        }).then(function (result) {
          if (result.value) {
            location.reload();
          }
        })
      }else if(result.value == "2"){
        document.getElementById("check_comercial").checked = true;
        document.getElementById("check_comercial").disabled = true;
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

}
/***********************************************************/
function approval_proyectos(e){
  e.preventDefault();
  e.stopPropagation();
  var id = document.getElementById('id').value;
  var miInit = {
    method: 'get',
    headers: headers,
    credentials: "same-origin",
    cache: 'default' };

    Swal.fire({
      title: "¿Los datos de instalación son correctos?",
      type: "warning",
      // html:
      // `<div class="text-left ml-5"><h6><i class="fas fa-check text-success"></i> Fecha de inicio instalación: </h6>` +
      // `<h6><i class="fas fa-check text-success"></i> Fecha de término instalación:  </h6>` +
      // `<h6><i class="fas fa-check text-success"></i> Fecha de Acta de Entrega de la Instalación: </h6></div>`,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirmar',
      cancelButtonText: 'Cancelar',
      showLoaderOnConfirm: true,
      preConfirm: () => {

         return fetch(`/approval_proyectos/id_doc/${id}`, miInit)
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
      if(result.value == "1"){
        document.getElementById("check_proyectos").checked = true;
        document.getElementById("check_proyectos").disabled = true;
        Swal.fire({
          title: 'Aprobado por:',
          text: "Gerencia proyectos e instalaciones",
          type: 'success',
        }).then(function (result) {
          if (result.value) {
            location.reload();
          }
        })
      }else if(result.value == "2"){
        document.getElementById("check_proyectos").checked = true;
        document.getElementById("check_proyectos").disabled = true;
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

  }

/***********************************************************/
function approval_soporte(e){
  e.preventDefault();
  e.stopPropagation();
  var id = document.getElementById('id').value;
  var miInit = {
    method: 'get',
    headers: headers,
    credentials: "same-origin",
    cache: 'default' };

    Swal.fire({
      title: "¿Los datos de soporte son correctos?",
      type: "warning",
      // html:
      // `<div class="text-left ml-5"><h6><i class="fas fa-check text-success"></i> Fecha de inicio instalación: </h6>` +
      // `<h6><i class="fas fa-check text-success"></i> Fecha de término instalación:  </h6>` +
      // `<h6><i class="fas fa-check text-success"></i> Fecha de Acta de Entrega de la Instalación: </h6></div>`,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirmar',
      cancelButtonText: 'Cancelar',
      showLoaderOnConfirm: true,
      preConfirm: () => {

         return fetch(`/approval_soporte/id_doc/${id}`, miInit)
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
      if(result.value == "1"){
        document.getElementById("check_soporte").checked = true;
        document.getElementById("check_soporte").disabled = true;
        Swal.fire({
          title: 'Aprobado por:',
          text: "Gerencia soporte",
          type: 'success',
        }).then(function (result) {
          if (result.value) {
            location.reload();
          }
        })
      }else if(result.value == "2"){
        document.getElementById("check_soporte").checked = true;
        document.getElementById("check_soporte").disabled = true;
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

  }

/***********************************************************/
  function approval_planeacion(e){
    e.preventDefault();
    e.stopPropagation();
    var id = document.getElementById('id').value;
    var miInit = {
      method: 'get',
      headers: headers,
      credentials: "same-origin",
      cache: 'default' };

      Swal.fire({
        title: "¿Los datos de compras son correctos?",
        type: "warning",
        //html:
        // `<div class="text-left ml-5"><h6><i class="fas fa-check text-success"></i> Fecha entrega EA: </h6>` +
        // `<h6><i class="fas fa-check text-success"></i> Fecha entrega ENA:  </h6>` +
        // `<h6><i class="fas fa-check text-success"></i> Fecha de contratación de enlace: </h6></div>`,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: () => {

           return fetch(`/approval_planeacion/id_doc/${id}`, miInit)
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
        if(result.value == "1"){
          document.getElementById("check_planeacion").checked = true;
          document.getElementById("check_planeacion").disabled = true;
          Swal.fire({
            title: 'Aprobado por:',
            text: "Gerente de Compras",
            type: 'success',
          }).then(function (result) {
            if (result.value) {
              location.reload();
            }
          })
        }else if(result.value == "2"){
          document.getElementById("check_planeacion").checked = true;
          document.getElementById("check_planeacion").disabled = true;
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

    }

/***********************************************************/
    function approval_itconcierge(e){
      e.preventDefault();
      e.stopPropagation();
      var id = document.getElementById('id').value;
      var miInit = {
        method: 'get',
        headers: headers,
        credentials: "same-origin",
        cache: 'default' };

        Swal.fire({
          title: "¿Los datos de soporte son correctos?",
          type: "warning",
          // html:
          // `<div class="text-left ml-5"><h6><i class="fas fa-check text-success"></i> IT Concierge: </h6>` +
          // `<h6><i class="fas fa-check text-success"></i> Nombre de TI del Cliente:  </h6>` +
          // `<h6><i class="fas fa-check text-success"></i> Licencias: </h6></div>`,
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Confirmar',
          cancelButtonText: 'Cancelar',
          showLoaderOnConfirm: true,
          preConfirm: () => {

             return fetch(`/approval_itconcierge/id_doc/${id}`, miInit)
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
          if(result.value == "1"){
            document.getElementById("check_itconcierge").checked = true;
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
          }else if(result.value == "2"){
            document.getElementById("check_itconcierge").checked = true;
            document.getElementById("check_itconcierge").disabled = true;
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

      }


      /***********************************************************/
      function approval_servicio_cliente(e){
        e.preventDefault();
        e.stopPropagation();
        var id = document.getElementById('id').value;
        var miInit = {
          method: 'get',
          headers: headers,
          credentials: "same-origin",
          cache: 'default' };

          Swal.fire({
            title: "¿Los datos de soporte son correctos?",
            type: "warning",
            // html:
            // `<div class="text-left ml-5"><h6><i class="fas fa-check text-success"></i> IT Concierge: </h6>` +
            // `<h6><i class="fas fa-check text-success"></i> Nombre de TI del Cliente:  </h6>` +
            // `<h6><i class="fas fa-check text-success"></i> Licencias: </h6></div>`,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {

               return fetch(`/approval_servicio_cliente/id_doc/${id}`, miInit)
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
            if(result.value == "1"){
              document.getElementById("check_servicio_cliente").checked = true;
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
            }else if(result.value == "2"){
              document.getElementById("check_servicio_cliente").checked = true;
              document.getElementById("check_servicio_cliente").disabled = true;
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


        }

      function approval_facturacion(e){
        e.preventDefault();
        e.stopPropagation();
        var id = document.getElementById('id').value;
        var miInit = {
          method: 'get',
          headers: headers,
          credentials: "same-origin",
          cache: 'default' };

          Swal.fire({
            title: "¿Los datos del contrato son correctos?",
            type: "warning",
            // html:
            // `<div class="text-left ml-5"><h6><i class="fas fa-check text-success"></i> Fecha de inicio: </h6>` +
            // `<h6><i class="fas fa-check text-success"></i> Vigencia:  meses</h6>` +
            // `<h6><i class="fas fa-check text-success"></i> RFC: </h6></div>`,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {

               return fetch(`/approval_facturacion/id_doc/${id}`, miInit)
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
            if(result.value == "1"){
              document.getElementById("check_facturacion").checked = true;
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
            }else if(result.value == "2"){
              document.getElementById("check_facturacion").checked = true;
              document.getElementById("check_facturacion").disabled = true;
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

        }

/***********************************************************/
      function approval_legal(e){
        e.preventDefault();
        e.stopPropagation();
        var id = document.getElementById('id').value;
        var miInit = {
          method: 'get',
          headers: headers,
          credentials: "same-origin",
          cache: 'default' };

          Swal.fire({
            title: "¿Los datos del contrato son correctos?",
            type: "warning",
            //html:
            // `<div class="text-left ml-5"><h6><i class="fas fa-check text-success"></i> Fecha de inicio: </h6>` +
            // `<h6><i class="fas fa-check text-success"></i> Vigencia:  meses</h6>` +
            // `<h6><i class="fas fa-check text-success"></i> RFC: </h6></div>`,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {

               return fetch(`/approval_legal/id_doc/${id}`, miInit)
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
            if(result.value == "1"){
              document.getElementById("check_legal").checked = true;
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
            }else if(result.value == "2"){
              document.getElementById("check_legal").checked = true;
              document.getElementById("check_legal").disabled = true;
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

        }

/***********************************************************/
        function approval_director_operaciones(e){
          e.preventDefault();
          e.stopPropagation();
          var id = document.getElementById('id').value;
          var miInit = {
            method: 'get',
            headers: headers,
            credentials: "same-origin",
            cache: 'default' };

            Swal.fire({
              title: "¿Los datos de soporte e instalación son correctos?",
              type: "warning",
              // html:
              // `<div class="text-left ml-5"><h6><i class="fas fa-check text-success"></i> Fecha de inicio: </h6>` +
              // `<h6><i class="fas fa-check text-success"></i> Vigencia:  meses</h6>` +
              // `<h6><i class="fas fa-check text-success"></i> RFC: </h6></div>`,
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Confirmar',
              cancelButtonText: 'Cancelar',
              showLoaderOnConfirm: true,
              preConfirm: () => {

                 return fetch(`/approval_director_operaciones/id_doc/${id}`, miInit)
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
              if(result.value == "1"){
                document.getElementById("check_director_operaciones").checked = true;
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
              }else if(result.value == "2"){
                document.getElementById("check_director_operaciones").checked = true;
                document.getElementById("check_director_operaciones").disabled = true;
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

          }

          /***********************************************************/

          function approval_director_general(e){
            e.preventDefault();
            e.stopPropagation();
            var id = document.getElementById('id').value;
            var miInit = {
              method: 'get',
              headers: headers,
              credentials: "same-origin",
              cache: 'default' };

              Swal.fire({
                title: "¿Los datos son correctos?",
                type: "warning",
                // html:
                // `<div class="text-left ml-5"><h6><i class="fas fa-check text-success"></i> Fecha de inicio: </h6>` +
                // `<h6><i class="fas fa-check text-success"></i> Vigencia:  meses</h6>` +
                // `<h6><i class="fas fa-check text-success"></i> RFC: </h6></div>`,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: () => {

                   return fetch(`/approval_director_general/id_doc/${id}`, miInit)
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
                if(result.value == "1"){
                  document.getElementById("check_director_general").checked = true;
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
                }else if(result.value == "2"){
                  document.getElementById("check_director_general").checked = true;
                  document.getElementById("check_director_general").disabled = true;
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

          }




//Formatea la fecha dd/mm/aaaa
function invertirFecha(f) {
    var fechaDividida = f.split("-");
    var fechaInvertida = fechaDividida.reverse();
    return fechaInvertida.join("-");
  }

function genTablesite(id_contract) {
  $.ajax({
      type: "POST",
      url: "/data_contractsite",
      data: { id_contract : id_contract , _token : _token },
      success: function (data){
        generate_site(data, $("#table_site"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function get_ids_anexos(cadena, key){

    $.ajax({
      type: "POST",
      url: "/get_ids_contract_anexo_v2",
      data: { id_cadena : cadena, key : key ,  _token : _token },
      success: function (data){
        console.log(data);
        data.forEach(contrato => {
          $('#sel_anexo').append($('<option>', {
            value: contrato.contrat_id,
            text : contrato.key
          }));
        });
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
}

$('#cadena').on('change', function(){
  document.getElementById('nombre_sitio').value = '';
  document.getElementById('id_hotel').value = '';
  document.getElementById('id_ubicacion').value = '';
  var cadena = $(this).val();
  $.ajax({
    type: "POST",
    url: "/idproy_search_by_cadena",
    data: { valor : cadena , _token : _token },
    success: function (data){
      count_data = data.length;
      if (count_data > 0) {
        // $('#sel_master_to_anexo').append('<option value="1"> Opcion 1</option>');
        $('[name="sel_master_to_anexo"] option[value!=""]').remove();
        $.each(JSON.parse(data),function(index, objdata){
          $('#sel_master_to_anexo').append('<option value="'+objdata.id+'">'+ objdata.key +'</option>');
        });
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
})


$("#sel_master_to_anexo").on('change', function(){
  var cadena = $("#cadena").val();
  var key = $("#sel_master_to_anexo option:selected").text();

  $('#sel_anexo').empty().append('<option selected="selected" value="test">Elegir</option>');
  get_ids_anexos(cadena, key);

});

$('#sel_anexo').on('change', function(){
  var id = $(this).val();
  get_data_anexos(id);
})


  function get_data_anexos(id_contract){

  $.ajax({
    type: "POST",
    url: "/get_data_master_anexo",
    data: { id_contract : id_contract , _token : _token },
    success: function (data){
      document.getElementById('nombre_sitio').value = data[0].sitio;
      document.getElementById('id_hotel').value = data[0].hotel_id;
      document.getElementById('id_ubicacion').value = data[0].id_ubicacion;
      document.getElementById('rfc').value = data[0].rfc;
      document.getElementById('razon_social').value = data[0].razon_social;
      document.getElementById('contacto').value = data[0].contacto;
      document.getElementById('telefono').value = data[0].telefono;
      document.getElementById('email').value = data[0].email;
      document.getElementById('direccion').value = data[0].direccion;
      document.getElementById('fecha_inicio').value = data[0].fecha_inicio;
      document.getElementById('fecha_termino').value = data[0].fecha_termino;
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });


}

$('#match_contract_button').on('click', function(){
  let id = document.getElementById('id').value;
  let hotel_id = document.getElementById('id_hotel').value;
  let cadena = document.getElementById('cadena').value;
  let rfc = document.getElementById('rfc').value;
  let razon_social = document.getElementById('razon_social').value;
  let contacto = document.getElementById('contacto').value;
  let telefono = document.getElementById('telefono').value;
  let email = document.getElementById('email').value;
  let direccion = document.getElementById('direccion').value;
  let fecha_inicio = document.getElementById('fecha_inicio').value;
  let fecha_termino = document.getElementById('fecha_termino').value;

  const headers2 = new Headers({
      "Accept": "application/json",
      'Content-Type': 'application/json',
      "X-Requested-With": "XMLHttpRequest",
      "X-CSRF-TOKEN": _token
  })
  var data = {
    id: id,
    cadena: cadena,
    hotel_id: hotel_id,
    rfc: rfc,
    razon_social: razon_social,
    contacto: contacto,
    telefono: telefono,
    email: email,
    direccion: direccion,
    fecha_inicio: fecha_inicio,
    fecha_termino: fecha_termino
  }
  var miInit = {
    method: 'post',
    headers: headers2,
    credentials: "same-origin",
    body: JSON.stringify(data),
    cache: 'default' };


  if(cadena != '' && hotel_id != ''){
    fetch('/update_kickoff_contract',miInit)
      .then(function(response){
        return response.text();
      })
      .then(function(data){
        if(data == "true"){
          Swal.fire('Datos guardados','', 'success');
        }else{
          Swal.fire('Ocurrio un error al guardar','', 'errr');
        }
      })
      .catch(function(error){
        console.log(error);
      })
  }else{
    Swal.fire('No se ha seleccionado un contrato','', 'warning')
  }


  });
