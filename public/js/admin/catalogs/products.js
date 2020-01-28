$(function() {
  $('.cuenta_contable').select2();
});

var _token = $('input[name="_token"]').val();

const headers = new Headers({
  "Accept": "application/json",
  "X-Requested-With": "XMLHttpRequest",
  "X-CSRF-TOKEN": _token
})

var miInitGet = { method: 'get',
                  headers: headers,
                  credentials: "same-origin",
                  cache: 'default' };

  $(function() {
    // We can attach the `fileselect` event to all file inputs on the page
    $(document).on('change', ':file', function() {
      var input = $(this),
          numFiles = input.get(0).files ? input.get(0).files.length : 1,
          label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
      input.trigger('fileselect', [numFiles, label]);
    });
    // We can watch for our custom `fileselect` event like this
    $(document).ready( function() {
        $(':file').on('fileselect', function(event, numFiles, label) {
            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;
            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }
        });
    });
    get_info_products();
    createEvent_Mensualidad();
    createEvent_Mensualidad2();

    var _token = $('input[name="_token"]').val();

    const headers = new Headers({
      "Accept": "application/json",
      "X-Requested-With": "XMLHttpRequest",
      "X-CSRF-TOKEN": _token
    })

    var miInit = { method: 'post',
                      headers: headers,
                      credentials: "same-origin",
                      cache: 'default' };

    $('#creatcategories').formValidation({
     framework: 'bootstrap',
     excluded: ':disabled',
     fields: {
       inputCreatName: {
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

     }
    })
    .on('success.form.fv', function(e) {
          e.preventDefault();
          var form = $('#creatcategories')[0];
          var formData = new FormData(form);
          $.ajax({
            type: "POST",
            url: "/catalogs/categories-create",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
              if (data == 'abort') {
                Swal.fire({
                   type: 'error',
                   title: 'Error encontrado..',
                   text: 'Realice la operacion nuevamente!',
                 });
              }
              else if (data == 'false') {
                Swal.fire({
                   type: 'error',
                   title: 'Error encontrado..',
                   text: 'Ya existe!',
                 });
              }
              else {
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

                      fetch('/catalogs/categories-show', miInit)
                            .then(function(response){
                              return response.json();
                            })
                            .then(function(data){
                              /* Remove all options from the select list */
                              $('#sel_categoria').empty();
                              $('#sel_categoria').append($('<option>', {
                                  value: '',
                                  text: 'Elegir'
                              }));
                                /* Insert the new ones from the array above */
                              data.forEach(function(key) {
                                var opt = document.createElement('option');
                                    opt.text = key.name;
                                    opt.value = key.id;
                                    $('#sel_categoria').append(opt);;
                              });
                            })
                            .catch(function(error){
                                    console.log(error);
                            });

                    }
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

    $('#creatmodels').formValidation({
     framework: 'bootstrap',
     excluded: ':disabled',
     fields: {
       inputCreatName: {
         validators: {
           notEmpty: {
             message: 'The field is required'
           }
         }
       },
       inputCreatCosto: {
         validators: {
           notEmpty: {
             message: 'The field is required'
           }
         }
       },
       select_onemoneda: {
         validators: {
           notEmpty: {
             message: 'The field is required'
           }
         }
       },
       select_onemarca: {
         validators: {
           notEmpty: {
             message: 'The field is required'
           }
         }
       },
       select_oneespec: {
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

     }
    })
    .on('success.form.fv', function(e) {
          e.preventDefault();
          var form = $('#creatmodels')[0];
          var formData = new FormData(form);
          $.ajax({
            type: "POST",
            url: "/catalogs/models-create",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
              if (data == 'abort') {
                Swal.fire({
                   type: 'error',
                   title: 'Error encontrado..',
                   text: 'Realice la operacion nuevamente!',
                 });
              }
              else if (data == 'false') {
                Swal.fire({
                   type: 'error',
                   title: 'Error encontrado..',
                   text: 'Ya existe!',
                 });
              }
              else {
                  let timerInterval;
                  Swal.fire({
                    type: 'success',
                    title: 'Operación Completada!',
                    html: 'Aplicando los cambios.',
                    timer: 2500,
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
                      fetch('/catalogs/models-show', miInit)
                            .then(function(response){
                              return response.json();
                            })
                            .then(function(data){
                              /* Remove all options from the select list */
                              $('#sel_modelo').empty();
                              $('#sel_modelo').append($('<option>', {
                                  value: '',
                                  text: 'Elegir'
                              }));
                                /* Insert the new ones from the array above */
                              data.forEach(function(key) {
                                var opt = document.createElement('option');
                                    opt.text = key.ModeloNombre;
                                    opt.value = key.id;
                                    $('#sel_modelo').append(opt);;
                              });
                            })
                            .catch(function(error){
                                    console.log(error);
                            });
                    }
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


    //estatus
    $('#creatstates').formValidation({
     framework: 'bootstrap',
     excluded: ':disabled',
     fields: {
       inputCreatName: {
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
     }
    })
    .on('success.form.fv', function(e) {
          e.preventDefault();
          var form = $('#creatstates')[0];
          var formData = new FormData(form);
          $.ajax({
            type: "POST",
            url: "/catalogs/products-status-create",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
              if (data == 'abort') {
                Swal.fire({
                   type: 'error',
                   title: 'Error encontrado..',
                   text: 'Realice la operacion nuevamente!',
                 });
              }
              else if (data == 'false') {
                Swal.fire({
                   type: 'error',
                   title: 'Error encontrado..',
                   text: 'Ya existe!',
                 });
              }
              else {
                  let timerInterval;
                  Swal.fire({
                    type: 'success',
                    title: 'Operación Completada!',
                    html: 'Aplicando los cambios.',
                    timer: 2500,
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
                      fetch('/catalogs/products-status-show', miInit)
                            .then(function(response){
                              return response.json();
                            })
                            .then(function(data){
                              /* Remove all options from the select list */
                              $('#sel_estatus').empty();
                              $('#sel_estatus').append($('<option>', {
                                  value: '',
                                  text: 'Elegir'
                              }));
                                /* Insert the new ones from the array above */
                              data.forEach(function(key) {
                                var opt = document.createElement('option');
                                    opt.text = key.name;
                                    opt.value = key.id;
                                    $('#sel_estatus').append(opt);;
                              });
                            })
                            .catch(function(error){
                                    console.log(error);
                            });
                    }
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



  });

  $(".addcategorias").on("click",function(){
    $('#modal-CreatNew-Category').modal('show');
    if (document.getElementById("creatcategories")) {
      $('#creatcategories')[0].reset();
      $('#creatcategories').data('formValidation').resetForm($('#creatcategories'));
      $('#inputCreatOrden').val(0);
    }
  })

  $(".addmodel").on("click",function(){
    $('#modal-CreatNew-Model').modal('show');
    if (document.getElementById("creatmodels")) {
      $('#creatmodels')[0].reset();
      $('#creatmodels').data('formValidation').resetForm($('#creatmodels'));
      $('#inputCreatOrden').val(0);
    }
  })

  $(".addstatus").on("click",function(){
    $('#modal-CreatNew-Estatus').modal('show');
    if (document.getElementById("creatstates")) {
      $('#creatstates')[0].reset();
      $('#creatstates').data('formValidation').resetForm($('#creatstates'));
      $('#inputCreatOrden').val(0);
    }
  })

  function testDecimals(currentVal) {
    var count;
    currentVal.match(/\./g) === null ? count = 0 : count = currentVal.match(/\./g);
    return count;
  }
  function replaceCommas(yourNumber) {
    var components = yourNumber.toString().split(".");
    if (components.length === 1)
    components[0] = yourNumber;
    components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    if (components.length === 2)
    components[1] = components[1].replace(/\D/g, "");
    return components.join(".");
  }
  function createEvent_Mensualidad () {
    const element = document.querySelector('[name="inputCreatcoindefault"]')
    element.addEventListener('keyup', function(event) {
      //Convertir formato pesos
      if (event.which >= 37 && event.which <= 40) {
        event.preventDefault();
      }
      var currentVal = $(this).val();
      var testDecimal = testDecimals(currentVal);
      if (testDecimal.length > 1) {
        currentVal = currentVal.slice(0, -1);
      }
      $(this).val(replaceCommas(currentVal));
    });
  };
  function createEvent_Mensualidad2 () {
    const element = document.querySelector('[name="inputEditcoindefault"]')
    element.addEventListener('keyup', function(event) {
      //Convertir formato pesos
      if (event.which >= 37 && event.which <= 40) {
        event.preventDefault();
      }
      var currentVal = $(this).val();
      var testDecimal = testDecimals(currentVal);
      if (testDecimal.length > 1) {
        currentVal = currentVal.slice(0, -1);
      }
      $(this).val(replaceCommas(currentVal));
    });
  };
  function filePreview(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        var result=e.target.result;
        $('#img_preview').attr("src",result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  function editfilePreview(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        var result=e.target.result;
        $('#edit_img_preview').attr("src",result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#fileInput").change(function () {
    filePreview(this);
  });
  $("#editfileInput").change(function () {
    editfilePreview(this);
  });

function get_info_products(){
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: "/catalogs/products-show",
      data: { _token : _token },
      success: function (data){
        table_product(data, $("#table_product"));
      },
      error: function (data) {
        console.log('Error:', data.statusText);
      }
  });
}
function table_product(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_products);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, information){
    var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">SI</span>';
    if (information.status == '0') {
      badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">NO</span>';
    }
    vartable.fnAddData([
      `<div class="btn-group">
          <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
          </button>
          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="javascript:void(0);" onclick="edit_product(this)" class="btn btn-primary  btn-sm" value="${information.id}"><i class="fas fa-pencil-alt"></i> Editar</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="edit_cc_modal(this)" class="btn btn-dark  btn-sm" value="${information.id}"><i class="fas fa-plus"></i> Agregar cuenta contable</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="view_cc_modal(this)" class="btn btn-dark  btn-sm" value="${information.id}"><i class="fas fa-eye"></i> Ver cuentas asignadas</a>
          </div>
      </div>`,
      information.name,
      information.code,
      information.model,
      information.manufacturer,
      information.unit_measure,
      information.sat_product,
      information.sort_order,
      '<span class="badge badge-secondary badge-pill text-uppercase text-white">'+information.status_name+'</span>',
      badge
    ]);
  });
}

var Configuration_table_responsive_products = {
  dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        text: '<i class="fas fa-plus-circle fastable mt-2"></i> Crear nuevo',
        titleAttr: 'Crear nuevo',
        className: 'btn btn-danger btn-sm',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        action: function ( e, dt, node, config ) {
          $('#modal-CreatNew').modal('show');
          if (document.getElementById("creatproductsystem")) {
            $("#creatproductsystem")[0].reset();
            // var validator = $( "#creatproductsystem" ).validate();
            // validator.resetForm();
            $('#inputCreatOrden').val(0);
            $('#img_preview').attr("src",'../img/company/Default.svg');
          }
        }
      },
      {
        extend: 'excelHtml5',
        title: 'Productos',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
        titleAttr: 'Excel',
        className: 'btn btn-success btn-sm',
        exportOptions: {
            columns: [ 0, 1, 2, 3]
        },
      },
      {
        extend: 'csvHtml5',
        title: 'Productos',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
        titleAttr: 'CSV',
        className: 'btn btn-primary btn-sm',
        exportOptions: {
            columns: [ 0, 1, 2, 3]
        },
      }
  ],
  "processing": true,
  language:{
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "<i class='fa fa-search'></i> Buscar:",
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
};

$(".onlynumber").keypress(function (e) {
  //if the letter is not digit then display error and don't type anything
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
    //display error message
    // $("#errmsg").html("Digits Only").show().fadeOut("slow");
    return false;
  }
});

function edit_product(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  $('#modal-Edit').modal('show');
  $('#fsd').val(valor);
  $.ajax({
       type: "POST",
       url: '/catalogs/products-edit',
       data: { value : valor, _token : _token},
       success: function (data) {

         $('#_token_c').val(data[0].id);
         $('#inputEditkey').val(data[0].code);
         $('#inputEditpart').val(data[0].num_parte);
         $('#inputEditname').val(data[0].name);
         $('#inputEditcoindefault').val(data[0].price);
         $('#inputEditdescription').val(data[0].description);
         $('#inputEditcomment').val(data[0].comment);
         $('#edit_discount').val(data[0].discount);

         $('[name="edit_sel_categoria"]').val(data[0].categoria_id).trigger('change');
         $('[name="editsel_modal_coin"]').val(data[0].currency_id).trigger('change');
         $('[name="sel_especification_edit"]').val(data[0].especifications_id).trigger('change');
         $('[name="edit_sel_modelo"]').val(data[0].modelo_id).trigger('change');
         $('[name="editsel_modal_proveedor"]').val(data[0].proveedor_id).trigger('change');
         $('[name="edit_sel_unit"]').val(data[0].unit_measure_id).trigger('change');
         $('[name="edit_sel_satserv"]').val(data[0].sat_product_id).trigger('change');


         $('#inputEditManufacter').val(data[0].manufacturer);
         $('[name="edit_sel_estatus"]').val(data[0].status_id).trigger('change');
         $('#edit_img_preview').attr("src", '../images/storage/'+data[0].image);
         $('#inputEditOrden').val(data[0].sort_order);

         //
        if(data[0].categoria_id == 12){
          $('#div_edit_tuberia').removeClass("d-none");
          $('[name="edit_sel_material"]').val(data[0].product_material_id);
          $('[name="edit_sel_type"]').val(data[0].product_type_material_id);
          $('[name="edit_sel_unit_product"]').val(data[0].product_measure_id).trigger('change');
        }else{
          $('#div_edit_tuberia').addClass("d-none");
        }


         if (data[0].status == '0')
         {
           $("#editstatus").prop('checked', false).change();
         }
         else {
           $('#editstatus').prop('checked', true).change();
         }
       },
       error: function (data) {
         alert('Error:', data);
       }
   })
}


$('#sel_material').on('change', function(){
  let material = $(this).val();
  fetch(`/getTypeMaterial/material/${material}`,  miInitGet)
      .then(function(response){
        return response.json();
      })
      .then(function(data){
        $('#sel_type').empty();
        $('#sel_type').append("<option value='0'>Elegir...</option>");
        $.each(data, function(i, key) {
          $('#sel_type').append("<option value="+key.id+">"+key.name+"</option>");
        });
      })
      .catch(function(error){
        console.log(error);
      })
})

$('#edit_sel_material').on('change', function(){
  let material = document.getElementById('edit_sel_material').value;
  console.log(material);
  fetch(`/getTypeMaterial/material/${material}`,  miInitGet)
      .then(function(response){
        return response.json();
      })
      .then(function(data){
        $('#edit_sel_type').empty();
        $('#edit_sel_type').append("<option value='0'>Elegir...</option>");
        $.each(data, function(i, key) {
          $('#edit_sel_type').append("<option value="+key.id+">"+key.name+"</option>");
        });
      })
      .catch(function(error){
        console.log(error);
      })
})

$('#sel_categoria').on('change', function(){
  let categoria = $(this).val();
  
  if(categoria == 12){
    $('#div_tuberia').removeClass("d-none");
  }else{
    $('#div_tuberia').addClass("d-none");
  }
  
})

$('#edit_sel_categoria').on('change', function(){
  let categoria = $(this).val();
  if(categoria == 12){
    $('#div_edit_tuberia').removeClass("d-none");
  }else{
    $('#div_edit_tuberia').addClass("d-none");
  }
  
})

function edit_cc_modal(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  
    $('.cuenta_contable').val(null).trigger('change');
    //$('#cuenta_complementaria').val(null).trigger('change');
    //$('#cuenta_anticipo').val(null).trigger('change');
    
    $.ajax({
      type: "POST",
      url: '/catalogs/products-edit',
      data: {value : valor, _token : _token},
      success: function (data) {

        if (data != []) {        
          $("#id_product_cc").val(valor);
          $('#customer_name').val(data[0].name);    
          //get_data_integracion_contable(id_cliente_prov);
          $('#modal-integracion-contable').modal('show');
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

function view_cc_modal(e){
  var valor = e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  $("#tabla_productos_cc tbody tr").remove();
    
    $.ajax({
      type: "POST",
      url: '/catalogs/get_cc_products',
      data: {id_product : valor, _token : _token},
      success: function (data) {

        if (data != []) {        
          $.each(data, function( i, key ) {
           
            $('#tabla_productos_cc tbody').append('<tr id="' + key.id + '"><td>'
              + key.products + '</td><td>'    
              + key.cuenta + '</td><td>'
              + key.nombre + '</td><td>'
              + '<button type="button" onclick="delete_cc_product('+key.id+');;deleteRow(this);" class="btn borrar" data-id="' + key.id + '" href="#"><i class="fa fa-trash text-danger"></i></button></td>'
              + '</td></tr>');
           });

          $('#modal-cc-products').modal('show');
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

function delete_cc_product(id_cc_product){
    $.ajax({
      type: "POST",
      url: '/catalogs/delete_cc_product',
      data: {id_cc : id_cc_product, _token : _token},
      success: function (data, textStatus, xhr) {

        if (xhr.status == 200) {        
          Swal.fire({
            type: 'success',
            title: 'Operacion realizada',
            text: 'Se elimino la cuenta contable del producto!',
          });
        }
        else {
          Swal.fire({
            type: 'error',
            title: 'Error encontrado..',
            text: 'No se elimino la cuenta contable del producto!',
          });
        }
      
      },
      error: function (data) {
        alert('Error:', data);
      }
  })
}

//Elimino la columna  seleccionada de la tabla de cuentas contables 

function deleteRow(fila) {
  var row = fila.parentNode.parentNode;
  row.parentNode.removeChild(row);
}

$("#form_integration_cc").on("submit", function(e){
  e.preventDefault();

  var form = $('#form_integration_cc')[0];
  var formData = new FormData(form);

    $.ajax({
      type: "POST",
      url: "/catalogs/save_integration_cc_products",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data, textStatus, xhr){
        
        let timerInterval;
        Swal.fire({
          type: 'success',
          title: 'Operación Completada!',
          html: 'Aplicando los cambios.',
          timer: 2500,
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
          console.log(result);
          if (xhr.status == 200) {
            //window.location.href = "/catalogs/products";
          }
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
})