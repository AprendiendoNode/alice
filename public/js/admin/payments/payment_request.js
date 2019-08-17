let empty_array = [];
let array_suma = [];
var conceptIndex = 0,
field1= {
   validators: {
       notEmpty: {
           message: 'Por favor seleccione un Nivel 1.'
       }
   }
},
field2= {
   validators: {
       notEmpty: {
           message: 'Por favor seleccione un Nivel 2.'
       }
   }
},
field3= {
   validators: {
       notEmpty: {
           message: 'Por favor seleccione un Nivel 3.'
       }
   }
};
$(function() {
  $('#dyn_row_2').hide();
  $('#dyn_row_3').hide();
  $('#iva').hide();
  $('#totales').hide();
  createEventListener_file();
  createEventListener_fileXml();

  $('#exampleValidator').wizard({
    onInit: function() {
        $('#validation')
          .find('[name="priority_id"]')
            .select2()
            .change(function(e) {
                $('#validation').formValidation('revalidateField', 'priority_id');
            })
            .end()
          .find('[name="classif_id"]')
            .select2()
            .change(function(e) {
                $('#validation').formValidation('revalidateField', 'classif_id');
            })
            .end()
          .find('[name="date_limit"]')
            .datepicker({
              format: 'dd/mm/yyyy'
            })
            .change(function(e) {
                $('#validation').formValidation('revalidateField', 'date_limit');
            })
            .end()
          .find('[name="cadena_id"]')
            .select2()
            .change(function(e) {
                $('#validation').formValidation('revalidateField', 'cadena_id');
            })
            .end()
          .find('[name="sitio_id"]')
             .select2()
             .change(function(e) {
                 $('#validation').formValidation('revalidateField', 'sitio_id');
             })
             .end()
          .find('[name="provider"]')
             .select2()
             .change(function(e) {
                 $('#validation').formValidation('revalidateField', 'provider');
             })
             .end()
          .find('[name="factura"]')
             .change(function(e) {
                 $('#validation').formValidation('revalidateField', 'factura');
             })
             .end()
          .find('[name="description"]')
             .change(function(e) {
                 $('#validation').formValidation('revalidateField', 'description');
             })
             .end()
          .find('[name="methodpay"]')
             .change(function(e) {
                 $('#validation').formValidation('revalidateField', 'methodpay');
             })
             .end()
          .find('[name="price"]')
             .change(function(e) {
                 $('#validation').formValidation('revalidateField', 'price');
             })
             .end()
          .find('[name="iva"]')
             .change(function(e) {
                 $('#validation').formValidation('revalidateField', 'iva');
             })
             .end()
          .find('[name="coin"]')
             .change(function(e) {
                 $('#validation').formValidation('revalidateField', 'coin');
             })
             .end()
          .find('[name="observaciones"]')
             .change(function(e) {
                 $('#validation').formValidation('revalidateField', 'observaciones');
             })
             .end()
        .formValidation({
          framework: 'bootstrap',
          excluded: ':disabled',
          icon: {
             // valid: 'glyphicon glyphicon-ok',
             // invalid: 'glyphicon glyphicon-remove',
             // validating: 'glyphicon glyphicon-refresh' 187.189.63.72:1161
          },
          fields: {
            classif_id: {
               validators: {
                   notEmpty: {
                       message: 'Por favor seleccione un servicio.'
                   }
               }
            },
            'dyn_field[0]': field1,
            // 'dyn_field1': field2,
            // 'dyn_field2': field3,
            date_limit:{
              validators: {
                 notEmpty: {
                     message: 'Por favor seleccione una fecha.'
                 }
              }
            },
            cadena_id: {
               validators: {
                   notEmpty: {
                       message: 'Por favor seleccione una cadena.'
                   }
               }
            },
            sitio_id: {
               validators: {
                   notEmpty: {
                       message: 'Por favor seleccione un sitio.'
                   }
               }
            },
            provider: {
              validators: {
                  notEmpty: {
                     message: 'Por favor seleccione un proveedor.'
                  }
               }
            },
            purchase_order: {
              validators: {
                stringLength: {
                  max: 100,
                  message: 'Menos de 100 caracteres.'
                }
              }
            },
            factura: {
              validators: {
                  notEmpty: {
                      message: 'La factura es requerida.'
                  }
              }
            },
            description: {
              validators: {
                notEmpty: {
                  message: 'El concepto de pago es requerido.'
                },
                stringLength: {
                  max: 700,
                  message: 'El concepto de pago debe ser menos de 700 caracteres.'
                }
              }
            },
            methodpay: {
              validators: {
                notEmpty: {
                  message: 'Por favor seleccione un metodo de pago.'
                }
              }
            },
            coin: {
              validators: {
                notEmpty: {
                  message: 'Por favor seleccione el tipo de moneda.'
                }
              }
            },
            fileInput: {
              validators: {
                // notEmpty: {
                //   message: 'El archivo PDF es requerido.'
                // },
                file: {
                  extension: 'pdf',
                  type: 'application/pdf',
                  message: 'Por favor seleccione un archivo PDF.'
                }
              }
            },
            file_xml: {
                validators: {
                    file: {
                        extension: 'xml',
                        type: 'text/xml',
                        message: 'Please choose a xml file'
                    }
                }
            },
            price: {
              validators: {
                 notEmpty: {
                     message: 'El monto es requerido.'
                 },
                 numeric: {
                     message: 'El monto debe ser numerico.'
                 }
              }
            },
            iva: {
              validators: {
                 notEmpty: {
                     message: 'El IVA es requerido.'
                 },
                 numeric: {
                     message: 'El IVA debe ser numerico.'
                 }
              }
            },
            observaciones: {
              validators: {
                notEmpty: {
                  message: 'Por favor escriba sus observaciones.'
                }
              }
            }
          }
        })
        .on('change', '.changeField0', async function(){
          var id = $(this).val();
          var name_key = $("option:selected",this).text();
          $('#cc_key').val(name_key);
          $('#cc_key2').val(name_key);
          var check_data;
          //console.log('cambio: ' + id);
          if (conceptIndex === 0) {
            check_data = await get_dyn2_test(id);
            if (check_data === 0) {
              //console.log('Vacio: ' + check_data);
            }else{
              //console.log('datos: ' + check_data);
              conceptIndex = 1;
              var $template = $('#template_cc'),
                  $clone    = $template
                                  .clone()
                                  .removeClass('hide')
                                  .removeAttr('id')
                                  .addClass('level1')
                                  .attr('data-book-index', conceptIndex)
                                  .insertBefore($template);
              $clone
                  .find('[name="dyn_field"]').attr('name', 'dyn_field[' + conceptIndex + ']').attr('data_row', conceptIndex).addClass('changeField1').end()
                  .find('.change_label').text('Nivel 2:').end();
              fill_dyn2(check_data);

              $('#validation')
                .formValidation('addField', 'dyn_field[' + conceptIndex + ']', field2);
            }
          }else if(conceptIndex > 0){
            check_data = await get_dyn2_test(id);
            if (conceptIndex === 2) {
              console.log('Existe nivel 3');
                var $row  = $('.level2');
                //Remove field
                $('#validation')
                    .formValidation('removeField', $row.find('[name="dyn_field[' + conceptIndex + ']"]'))
                    $row.remove();
                conceptIndex = 1;
            }
            if (check_data === 0) {
              //console.log('Vacio: ' + check_data);
              var $row  = $('.level1');
              //Remove field
              $('#validation')
                  .formValidation('removeField', $row.find('[name="dyn_field[' + conceptIndex + ']"]'))
                  $row.remove();
              conceptIndex = 0;
            }else{
              //console.log('datos: ' + check_data);
              fill_dyn2(check_data);
            }
          }
        })
        .on('change', '.changeField1', async function(){
          var id = $(this).val();
          var name_key = $("option:selected",this).text();
          $('#cc_key').val(name_key);
          $('#cc_key2').val(name_key);
          var check_data2;
          //console.log('cambio: ' + id);

          if (conceptIndex === 1) {
            check_data2 = await get_dyn3_test(id);
            if (check_data2 === 0) {
              //console.log('Vacio Level2: ' + check_data2);
            }else{
              conceptIndex = 2;
              var $template = $('#template_cc'),
                  $clone    = $template
                                  .clone()
                                  .removeClass('hide')
                                  .removeAttr('id')
                                  .addClass('level2')
                                  .attr('data-book-index', conceptIndex)
                                  .insertBefore($template);
              $clone
                  .find('[name="dyn_field"]').attr('name', 'dyn_field[' + conceptIndex + ']').attr('data_row', conceptIndex).addClass('changeField2').end()
                  .find('.change_label').text('Nivel 3').end();
              //createEventListenerField1();
              fill_dyn3(check_data2);

              $('#validation')
                .formValidation('addField', 'dyn_field[' + conceptIndex + ']', field3);
              console.log(conceptIndex);
            }

          }else if(conceptIndex === 2){
            check_data2 = await get_dyn3_test(id);
            if (check_data2 === 0) {
              //console.log('Vacio: ' + check_data2);
              var $row  = $('.level2');
              //Remove field
              $('#validation')
                  .formValidation('removeField', $row.find('[name="dyn_field[' + conceptIndex + ']"]'))
                  $row.remove();
              conceptIndex = 1;
            }else{
              //console.log('datos: ' + check_data2);
              fill_dyn3(check_data2);
            }

            //get_dyn3(id);
          }
        })
        .on('change', '.changeField2', function(){
          var name_key = $("option:selected",this).text();
          $('#cc_key').val(name_key);
          $('#cc_key2').val(name_key);
        })
    },
    validator: function() {
       var fv = $('#validation').data('formValidation');
       var $this = $(this);
       // Validate the container
       fv.validateContainer($this);
       var isValidStep = fv.isValidContainer($this);
       if (isValidStep === false || isValidStep === null  || isValidStep === '') {
         console.log($this);
         console.log(isValidStep);
         //alert('false');
           return false;
       }
       return true;
    },
    onFinish: function() {
        var dataObj = $('#validation').find("select, textarea, input").serialize();
        //+'&cc_key='+
        //var dyn1 = $('.changeField0').val();
        var form = $('#validation')[0];
        var formData = new FormData(form);
        //console.log(formData);
        //console.log($('.changeField0').val());
        $.ajax({
            type: "POST",
            url: "/create_pay",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
              console.log(data);
              if (data === undefined || data.length === 0) {
                swal({
                  title: "Operación abortada!",
                  text: "Error al registrar intente otra vez :( ",
                  type: "error",
                  showCancelButton: false,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Continuar.!",
                  closeOnConfirm: true,
                  closeOnCancel: false
                },
                function(isConfirm){
                  location.reload(true);
                });
              }else{
                swal({
                  title: "Operación Completada!",
                  text: "Folio: " + data,
                  type: "success",
                  showCancelButton: false,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Continuar.!",
                  closeOnConfirm: true,
                  closeOnCancel: false
                },
                function(isConfirm){
                  location.reload(true);
                });
              }
            },
            error: function (data) {
              console.log('Error:', data);
              //swal("Operación abortada", "Error al registrar intente otra vez :(", "error");
              swal({
                title: "Operación abortada!",
                text: "Error al registrar intente otra vez :( ",
                type: "error",
                showCancelButton: false,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Continuar.!",
                closeOnConfirm: true,
                closeOnCancel: false
              },
              function(isConfirm){
                location.reload(true);
              });
            }
        });
        // document.getElementById("validation").submit();
        // $('#validation')[0].reset();
        // $('#exampleValidator').wizard('first');
        // $('#exampleValidator').wizard('reset');
        // // menssage_toast('Mensaje', '4', 'Operation complete!' , '3000');
        // $('#validation').data('formValidation').resetForm('true');
        // $('#exampleValidator').find('li.done').removeClass( "done" );

        //console.log('finito');
    },
    onSuccess: function(e) {
    }
  });

  $('#data_account_bank').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      reg_bancos: {
          validators: {
              notEmpty: {
                  message: 'Please select a bank.'
              }
          }
      },
      reg_coins: {
          validators: {
              notEmpty: {
                  message: 'Please select a type of currency.'
              }
          }
      },
      reg_cuenta: {
        validators: {
          notEmpty: {
            message: 'The account number is required.'
          },
          stringLength: {
            min: 4,
            message: 'The account number must have at least 4 characters',
          },
        }
      },
      reg_clabe: {
        validators: {
          notEmpty: {
            message: 'The  bank code is required.'
          },
          stringLength: {
            min: 4,
            message: 'The bank code must have at least 4 characters',
          },
        }
      },
      reg_reference: {
        validators: {
          notEmpty: {
            message: 'The reference number is required.'
          },
          stringLength: {
            min: 4,
            message: 'The reference number must have at least 4 characters',
          },
        }
      },
    }
  })
  .on('success.form.fv', function(e) {
    e.preventDefault();

    var id = $('#provider').val();
    var objData = $('#data_account_bank').find("select,textarea, input").serialize();
    $.ajax({
      type: "POST",
      url: "/setdata_bank",
      data: objData+ "&identificador=" + id,
      success: function (data){
        if (data == '1') {
          $('#modal_bank').modal('toggle');
          swal("Operación Completada!", ":)", "success");
          $('#bank').empty();
          $('#bank').append('<option value="">Elegir...</option>');
          getBank(); //Esta en el otro js
        }
        else {
          $('#modal_bank').modal('toggle');
          swal("Operación abortada", "Error al registrar intente otra vez :(", "error");
          $('#bank').empty();
          $('#bank').append('<option value="">Elegir...</option>');
          getBank(); //Esta en el otro js

        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  });
});

$('#classif_id').on('change',function(){
  var id = $(this).val();

  // $('#dyn_field[0]').empty();
  // $('#dyn_field[0]').append('<option value="">Elegir...</option>');
  if (conceptIndex === 2) {
    console.log('Existe nivel 3');
      var $row  = $('.level2');
      var $row2  = $('.level1');
      //Remove field
      $('#validation')
          .formValidation('removeField', $row.find('[name="dyn_field[' + conceptIndex + ']"]'))
          $row.remove()
          .formValidation('removeField', $row2.find('[name="dyn_field[' + conceptIndex + ']"]'))
          $row2.remove();

      conceptIndex = 0;
  }else if(conceptIndex === 1){
    console.log('Existe nivel 2');
      var $row  = $('.level1');
      //Remove field
      $('#validation')
          .formValidation('removeField', $row.find('[name="dyn_field[' + conceptIndex + ']"]'))
          $row.remove();
      conceptIndex = 0;
  }

  get_dyn1(id);
  summarize_chains(id);
});
function summarize_chains(id_classif) {
  var _token = $('input[name="_token"]').val();
  var datax = [];

  $.ajax({
    type: "POST",
    url: "/get_chainxclassif",
    data: { _token : _token, data_one: id_classif},
    success: function (data){
      //console.log(data);
      //cadena_id
      emptySelect('cadena_id');
      datax.push({id : "", text : "Elija ..."});
      $.each(data, function(index, datos){
        datax.push({id: datos.id, text: datos.cadena});
      });
      $('#validation').find('[name="cadena_id"]').select2({
        data : datax
      });
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
function get_dyn1(id_classif) {
  var _token = $('input[name="_token"]').val();
  var datax = [];
  $('#validation').find('[name="dyn_field[0]"]').select2();
  $.ajax({
    type: "POST",
    url: "/get_class_serv",
    data: { _token : _token,  data_one: id_classif},
    success: function (data){
      //console.log(data);
      // $('.changeField0').empty();
      // $('.changeField0').append('<option value="">Elegir...</option>');

      // $.each(data, function(i, item) {
      //     $('.changeField0').append("<option value="+item.id+">"+item.name+"</option>");
      // });
      // $('#validation').data('formValidation').resetField($('[name="dyn_field[0]"]'));
      emptySelect('dyn_field[0]');
      datax.push({id : "", text : "Elija ..."});
      $.each(data, function(index, datos){
        datax.push({id: datos.id, text: datos.key+' | '+datos.name});
      });
      $('#validation').find('[name="dyn_field[0]"]').select2({
        data : datax
      });
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
async function get_dyn2_test(id_serv) {
  var _token = $('input[name="_token"]').val();
  var datax = [];
  var res = 0;
  await $.ajax({
    type: "POST",
    url: "/get_serv_concept",
    data: { _token : _token,  data_one: id_serv},
    success: function (data){
      //console.log(data);
      if (data === undefined || data.length === 0) {
        //console.log('data vacia');
        res = 0;
      }else{
        datax.push({id : "", text : "Elija ..."});
        $.each(data, function(index, datos){
          datax.push({id: datos.id, text: datos.key+' | '+datos.name});
        });
        res = datax;
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
  return res;
}
function fill_dyn2(data) {
  $('#validation').find('[name="dyn_field[1]"]').select2();
  emptySelect('dyn_field[1]');
  $('#validation').find('[name="dyn_field[1]"]').select2({
    data : data
  });
}
async function get_dyn3_test(id_desc) {
  var _token = $('input[name="_token"]').val();
  var datax = [];
  var res = 0;
  await $.ajax({
    type: "POST",
    url: "/get_concept_desc",
    data: { _token : _token,  data_one: id_desc},
    success: function (data){
      if (data === undefined || data.length === 0) {
        res = 0;
      }else{
        datax.push({id : "", text : "Elija ..."});
        $.each(data, function(index, datos){
          datax.push({id: datos.id, text: datos.key+' | '+datos.name});
        });
        res = datax;
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
  return res;
}
function fill_dyn3(data) {
  $('#validation').find('[name="dyn_field[2]"]').select2();
  emptySelect('dyn_field[2]');
  $('#validation').find('[name="dyn_field[2]"]').select2({
    data : data
  });
}
function emptySelect(selects) {
  var formV = $('#validation');
  formV.find('[name="'+selects+'"]').empty();
  formV.find('[name="'+selects+'"]').select2("destroy");
  //formV.formValidation('enableValidator', 'dyn_field[1]');
  //formV.disableValidator('dyn_field[1]');
  formV.data('formValidation').resetField($('[name="'+selects+'"]'));
  // $('#'+ selects).empty();
  // $('#'+ selects).select2("destroy");
  //$('#validation').formValidation('enableFieldValidators', selects, true);
  //$('#validation').data('formValidation').resetField($('#'+selects));
}
//deprecado
function get_dyn2(id_serv) {
  var _token = $('input[name="_token"]').val();
  var datax = [];

  $('#validation').find('[name="dyn_field[1]"]').select2();

  $.ajax({
    type: "POST",
    url: "/get_serv_concept",
    data: { _token : _token,  data_one: id_serv},
    success: function (data){
      //console.log(data);
      emptySelect('dyn_field[1]');
      datax.push({id : "", text : "Elija ..."});
      $.each(data, function(index, datos){
        datax.push({id: datos.id, text: datos.name});
      });
      $('#validation').find('[name="dyn_field[1]"]').select2({
        data : datax
      });
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
//deprecado
function get_dyn3(id_desc) {
  var _token = $('input[name="_token"]').val();
  var datax = [];
  $('#validation').find('[name="dyn_field[2]"]').select2();

  $.ajax({
    type: "POST",
    url: "/get_concept_desc",
    data: { _token : _token,  data_one: id_desc},
    success: function (data){
      console.log(data);
      emptySelect('dyn_field[2]');
      datax.push({id : "", text : "Elija ..."});
      $.each(data, function(index, datos){
        datax.push({id: datos.id, text: datos.name});
      });
      $('#validation').find('[name="dyn_field[2]"]').select2({
        data : datax
      });
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
$('#cadena_id').on('change',function(){
  var id = $(this).val();
  //$('#idProject').text('');
  $('#sitio_id').empty();
  $('#sitio_id').append('<option value="">Elegir...</option>');
  // $('#provider').empty();
  // $('#provider').append('<option value="">Elegir...</option>');
  // $('#provider').val('').trigger('change');
  getHotels(id);
});


// $('#check_chain_anex').on('change', function(){
//   var checkbox = document.getElementById('check_chain_anex');
//   if (checkbox.checked != true) {
//     console.log('no esta marcado');
//   }else{
//     console.log('esta marcado');
//   }
// });

function getHotels(id_cadena) {
  var _token = $('input[name="_token"]').val();
  var datax;
  $.ajax({
    type: "POST",
    url: "/get_hotel_cadena",
    data: { data_one : id_cadena, _token : _token },
    success: function (data){
      console.log(data);
      datax = JSON.parse(data);
      if ($.trim(data)){
        $.each(datax, function(i, item) {
            $('#sitio_id').append("<option value="+item.id+">"+item.Nombre_hotel+"</option>");
        });
      }
      else{
        $("#sitio_id").text('');
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
function sumar() {
  var total = 0.00;
  var total_format = "";
  var subtotal = 0.00;
  var iva = 0.00;
  var iva_format = "";
  var tasa = 16;
  var isr = 0;
  var iva_reten = 0;
  var checkbox = document.getElementById('check_iva');
  var checkbox_isr = document.getElementById('check_isr');
  var check_isr =  checkbox_isr.checked == true;
  var check_iva = checkbox.checked == true;

  $(".monto").each(function() {
    if (isNaN(parseFloat($(this).val()))) {
      subtotal += 0;
    }else {
      subtotal += parseFloat($(this).val());
    }
  });

  if (!check_iva && !check_isr) {
    iva = parseFloat((subtotal * tasa)/100).toFixed(2);
    iva = parseFloat(iva);
    total = parseFloat(subtotal + iva).toFixed(2);
    $('#iva').val(iva);
    $('#totales').val(total);
    $('#totales_format').val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#iva_format').val(iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  }else{
    if (check_iva) {
      $('#iva').val(0);
      $('#totales_format').val(subtotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
      $('#totales').val(subtotal);
    }else{
      //console.log('no entro aqui!!!');
      iva = parseFloat((subtotal * tasa)/100);
      isr = parseFloat((subtotal * 10) /100);
      //console.log("ISR: " + isr);
      iva_reten = parseFloat((iva * 2) / 3);
      //console.log("iva_reten: " + iva_reten);
      total = parseFloat(((subtotal + iva) - isr) - iva_reten).toFixed(2);
      $('#iva').val(iva);
      $('#totales').val(total);
      $('#iva_format').val(iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
      $('#totales_format').val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }
  }
}
function sumariva(){
  var total = 0.00;
  var total_format = "";
  var subtotal = 0.00;
  var subtotal_format = "";
  var iva = 0.00;
  var iva_format = "";
  var tasa = 16;
  var checkbox = document.getElementById('check_iva');

  $(".monto").each(function() {
    if (isNaN(parseFloat($(this).val()))) {
      subtotal += 0;
    }else {
      subtotal += parseFloat($(this).val());
    }
  });
  iva = parseFloat($('#iva').val());
  total = parseFloat(subtotal + iva).toFixed(2);
  $('#totales').val(total);
}
$('#check_isr').on('change', function(){
  var checkbox = document.getElementById('check_isr');
  var monto = parseFloat($('#price').val()); //subtotal
  var iva = 0;
  var tasa = 16;
  var total = 0;
  var isr = 0;
  var iva_reten = 0;
  if (checkbox.checked != true) {
    //console.log('No esta marcado');
    iva = parseFloat((monto * tasa)/100);
    total = parseFloat(monto + iva).toFixed(2);
    $('#iva').val(iva);
    $('#totales').val(total);
    $('#iva_format').val(iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#totales_format').val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#validation').formValidation('revalidateField', 'iva');
  }else{
    $('#check_iva').prop('checked', false);
    iva = parseFloat((monto * tasa)/100);
    isr = parseFloat((monto * 10) /100);
    //console.log("ISR: " + isr);
    iva_reten = parseFloat((iva * 2) / 3);
    //console.log("iva_reten: " + iva_reten);
    total = parseFloat(((monto + iva) - isr) - iva_reten).toFixed(2);
    $('#iva').val(iva);
    $('#totales').val(total);
    $('#iva_format').val(iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#totales_format').val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#validation').formValidation('revalidateField', 'iva');
  }
});
$('#check_otros').on('change', function(){
  var checkbox = document.getElementById('check_otros');
  var monto = parseFloat($('#price').val());
  var iva = 0;
  var tasa = 16;
  var total = 0;
  if (checkbox.checked != true) {
    //console.log('No esta marcado');
    iva = parseFloat($('#iva').val());
    total = parseFloat($('#totales').val());
    $('#iva_format').val(iva);
    $('#totales_format').val(total);
    $('#iva_format').show();
    $('#totales_format').show();
    $('#iva').hide();
    $('#totales').hide();
    $('#iva').prop("readonly", true);
    $('#totales').prop("readonly", true);
    $('#validation').formValidation('revalidateField', 'iva');
  }else{
    //console.log('Esta marcado');
    $('#iva_format').hide();
    $('#totales_format').hide();
    $('#iva').show();
    $('#totales').show();
    $('#iva').prop("readonly", false);
    $('#totales').prop("readonly", false);
    $('#validation').formValidation('revalidateField', 'iva');
  }
});
$('#check_iva').on('change', function(){
  var checkbox = document.getElementById('check_iva');
  var monto = parseFloat($('#price').val());
  var iva = 0;
  var tasa = 16;
  var total = 0;
  if (checkbox.checked != true) {
    //console.log('no esta marcado');
    iva = parseFloat((monto * tasa)/100);
    total = parseFloat(monto + iva).toFixed(2);
    $('#iva').val(iva);
    $('#iva_format').val(iva.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#totales').val(total);
    $('#totales_format').val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#validation').formValidation('revalidateField', 'iva');
  }else{
    $('#check_isr').prop('checked', false);
    //console.log('esta marcado');
    $('#iva').val(0);
    $('#iva_format').val(0);
    $('#totales').val(monto);
    $('#totales_format').val(monto.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#validation').formValidation('revalidateField', 'iva');
  }
});
function createEventListener_file () {
  const element = document.querySelector('[name="fileInput"]')
  element.addEventListener('change', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

    input.trigger('fileselect', [numFiles, label]);
    var input = $(this).parents('.input-group').find(':text'),
    log = numFiles > 1 ? numFiles + ' files selected' : label;

    if( input.length ) {
      input.val(log);
    } else {
        if( log ) alert(log);
    }
  });
}
function createEventListener_fileXml () {
  const element = document.querySelector('[name="file_xml"')
  element.addEventListener('change', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

    input.trigger('fileselect', [numFiles, label]);
    var input = $(this).parents('.input-group').find(':text'),
    log = numFiles > 1 ? numFiles + ' files selected' : label;

    if( input.length ) {
      input.val(log);
    } else {
        if( log ) alert(log);
    }
  });
}
$('#sitio_id').on('change', function(e){
  var id= $(this).val();
  console.log(id);
  // $('#provider').empty();
  // $('#provider').append('<option value="">Elegir...</option>');
  $('#idUbication').val('');
  //getProyect(id);
  get_idubicacion(id);
  // getProveedor(id);
});
//deprecado.
function getProyect(id_proyect) {
  var id = id_proyect;
  var _token = $('input[name="_token"]').val();
  var datax;

  $.ajax({
    type: "POST",
    url: "/get_proyecto_hotel",
    data: { data_one : id, _token : _token },
    success: function (data){
      console.log(data);
      // datax = JSON.parse(data);
      // if ($.trim(data)){
      //     $('#idProject').val(datax[0].id_proyecto);
      //     $('#idProject2').val(datax[0].id_proyecto);
      // }
      // else{
      //   $("#sitio_id").text('');
      //   alert('error');
      // }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
//funcion para manuel
function get_idubicacion(idsearch) {
  var _token = $('input[name="_token"]').val();
  $.ajax({
      type: "POST",
      url: "/get_idubication_pay",
      data: { data_one : idsearch, _token : _token},
      success: function (data){
        //console.log(data);
        $('#idUbication').val(data);
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
//check_sin_factura
$('#check_factura_sin').on('change', function(){
  var checkbox = document.getElementById('check_factura_sin');
  var checkbox_p = document.getElementById('check_factura_pend');
  var bool_input = $('#bool_factura_s');
  var bool_input_p = $('#bool_factura_p');
  //.attr('checked','checked');
  //.removeAttr('checked');

  if (checkbox.checked != true) {
    //console.log('no esta marcado');
    if (checkbox_p.checked != true) {
      //console.log('no esta marcado pend');
      bool_input.val('false');
      $('#factura').prop('readonly', false);
      $('#factura').val('');
      $('#validation').data('formValidation').resetField($('#factura'));
    }else{
      //console.log('esta marcado pend');
      bool_input.val('false');
      $('#factura').prop('readonly', false);
      $('#factura').val('');
      $('#validation').data('formValidation').resetField($('#factura'));
      $('#check_factura_pend').prop('checked', false);
      bool_input_p.val('false');
    }
  }else{
    //console.log('esta marcado');
    bool_input.val('true');
    $('#factura').prop('readonly', true);
    $('#factura').val('sin_factura');
    $('#check_factura_pend').prop('checked', false);
    bool_input_p.val('false');
  }
});
//check_factura_pend
$('#check_factura_pend').on('change', function(){
  var checkbox = document.getElementById('check_factura_pend');
  var checkbox_s = document.getElementById('check_factura_sin');
  var bool_input = $('#bool_factura_p');
  var bool_input_s = $('#bool_factura_s');
  if (checkbox.checked != true) {
    //console.log('no esta marcado');
    if (checkbox_s.checked != true) {
      //console.log('no esta marcado pend');
      bool_input.val('false');
      $('#factura').prop('readonly', false);
      $('#factura').val('');
      $('#validation').data('formValidation').resetField($('#factura'));
    }else{
      //console.log('esta marcado pend');
      bool_input.val('false');
      $('#factura').prop('readonly', false);
      $('#factura').val('');
      $('#validation').data('formValidation').resetField($('#factura'));
      $('#check_factura_sin').prop('checked', false);
      bool_input_s.val('false');
    }
  }else{
    //console.log('esta marcado');
    bool_input.val('true');
    $('#factura').prop('readonly', true);
    $('#factura').val('factura_pendiente');
    $('#check_factura_sin').prop('checked', false);
    bool_input_s.val('false');
  }
});
//Datos bancarios
$('#provider').on('change',function(){
  $('#bank').empty();
  $('#bank').append('<option value="">Elegir...</option>');
  $('#account').empty();
  $('#account').append('<option value="">Elegir...</option>');
  $('#clabe').val('');
  $('#reference_banc').val('');
   getBank();
})
function getBank(){
  var id_client = $('#customer').val();
  var id_prov = $('#provider').val();

  var _token = $('input[name="_token"]').val();
  var datax;

  $.ajax({
    type: "POST",
    url: "/get_data_bank",
    data: { data_one : id_client, data_two : id_prov , _token : _token },
    success: function (data){
      if (data == null || data == '[]') {
        $('#bank').empty();
        $('#bank').append('<option value="">Elegir...</option>');
      }
      else{
        datax = JSON.parse(data);
        if ($.trim(data)){
          $.each(datax, function(i, item) {
            if(item.status == 1){
              $('#bank').append("<option selected value="+item.id+">"+item.banco+"</option>");
            }else{
              $('#bank').append("<option value="+item.id+">"+item.banco+"</option>");
            }

          });
        }
        else{
          $("#customer").text('');
          alert('error');
        }
      }
      getCuentaClabe();
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
$('#bank').on('change',function(){
  $('#account').empty();
  $('#account').append('<option value="">Elegir...</option>');
  $('#clabe').val('');
  $('#reference_banc').val('');
  getCuentaClabe();
})
function getCuentaClabe(){
  var id_bank  = $('#bank').val();
  var id_prov = $('#provider').val();

  var _token = $('input[name="_token"]').val();
  var datax;
  $.ajax({
    type: "POST",
    url: "/get_account_clabe",
    data: { data_one : id_prov, data_two : id_bank , _token : _token },
    success: function (data){
      if (data == null || data == '[]') {
        $('#account').empty();
        $('#account').append('<option value="">Elegir...</option>');
        $('#clabe').val('');
        $('#reference_banc').val('');
      }
      else{
        datax = JSON.parse(data);
        if ($.trim(data)){

          $.each(datax,function(i,item){
            if(i == 0){
              $('#account').append("<option selected value="+item.id+">"+item.cuenta+"</option>");
            }else{
              $('#account').append("<option value="+item.id+">"+item.cuenta+"</option>");
            }

            $('#clabe').val('');
            $('#reference_banc').val('');
          })
        }
        else{
          $('#clabe').val('');
          $('#reference_banc').val('');
        }
        var id_account = $('#account').val();
        getdataCuenta(id_account,_token);
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
//Cuenta
$('#account').on('change', function(e){
  var id= $(this).val();
  var _token = $('input[name="_token"]').val();
  $('#clabe').val('');
  $('#reference_banc').val('');
  getdataCuenta(id, _token);
});
function getdataCuenta(campoa, campob){
  $.ajax({
    type: "POST",
    url: "/get_data_accw",
    data: { data_one : campoa, _token : campob },
    success: function (data){
      if (data == null || data == '[]') {
        $('#reference_banc').val('');
        $('#clabe').val('');
      }
      else {
        if ($.trim(data)){
          datax = JSON.parse(data);
          console.log(datax);
          var currency = document.getElementById('clabe');
          currency.dataset.currency = datax[0].currency_id;
          $('#clabe').val(datax[0].clabe);
          $("#reference_banc").val(datax[0].referencia);
          checkCurrency();
        }
        else {
          $('#reference_banc').val('');
          $('#clabe').val('');
        }
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
//Validación factura
$("#factura").on("blur", function(){
  var factura = $(this).val();
  var proveedor = $("#provider").val();
  var nombre_proveedor = $( "#provider option:selected" ).text();
  var _token = $('input[name="_token"]').val();

  $.ajax({
    type: "POST",
    url: "/getStateFactura",
    data: { factura : factura , proveedor: proveedor , _token : _token },
    success: function (data){
    if(data == 1){
        swal('La factura: ' + factura + ' ya está registrada con el proveedor: ' + nombre_proveedor  , '', 'error');
        $("#factura").val('');
        $('#validation').data('formValidation').resetField($('#factura'));
        $("#factura").parent().parent().addClass('has-error');
      }
    },
    error: function (data){
      console.log('Error:', data);
    }

  });
});
function checkCurrency(){
  var coinBank;
  var coinId;
  var coinselect;
  var option;
  var coinselect = document.getElementById('coin');
  var inputclabe = document.getElementById('clabe');
  coinId = coinselect.value;
  coinBank = inputclabe.dataset.currency;
  if(coinBank != coinId){
    for (var i=0; i < coinselect.options.length; i++) {
        option = coinselect.options[i];
        if (option.value == coinBank) {
            option.setAttribute('selected', true);
        }else{
            option.removeAttribute('selected');
        }
    }
  }else{
    $("#coin").parent().parent().removeClass('has-error');
    $("#coin").parent().parent().addClass('has-sucess');
  }
}
