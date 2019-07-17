// The maximum number of options
let empty_array = [];
let array_suma = [];

var conceptIndex = 0,
venue= {
 row: '.col-xs-2',   // The title is placed inside a <div class="col-xs-2"> element
 validators: {
     notEmpty: {
         message: 'Please select a venue.'
     }
 }
},
hotel= {
 row: '.col-xs-2',   // The title is placed inside a <div class="col-xs-2"> element
 validators: {
     notEmpty: {
         message: 'Please select a hotel.'
     }
 }
},
date_c= {
 row: '.col-xs-2',   // The title is placed inside a <div class="col-xs-2"> element
 validators: {
     notEmpty: {
         message: 'Please select a date.'
     },
     date: {
         format: 'DD/MM/YYYY',
         message: 'The end date is not a valid'
     }
 },
},
concept= {
 row: '.col-xs-2',   // The title is placed inside a <div class="col-xs-2"> element
 validators: {
     notEmpty: {
         message: 'Please select a concept.'
     }
 }
},
cant= {
 row: '.col-xs-1',   // The title is placed inside a <div class="col-xs-2"> element
 enabled: false,
 validators: {
     notEmpty: {
         message: 'Please select a amount.'
     }
 }
},
priceuni= {
 row: '.col-xs-1',   // The title is placed inside a <div class="col-xs-2"> element
 enabled: false,
 validators: {
    notEmpty: {
        message: 'The price is required'
    },
    numeric: {
        message: 'The price must be a numeric number'
    }
 }
},
price= {
 row: '.col-xs-1',   // The title is placed inside a <div class="col-xs-2"> element
 validators: {
    notEmpty: {
        message: 'The price is required'
    },
    numeric: {
        message: 'The price must be a numeric number'
    }
 }
},
just= {
  validators: {
     notEmpty: {
         message: 'The justification is required'
     },
     stringLength: {
         max: 800,
         message: 'The justification must be less than 800 characters long'
     }
  }
};
function eventListenerSubtotal(){
  var elemento = $('.subtotal');
  var elementos = $('.subtotal').length;
  var arrayID = [];
  var arraytotal = [];
  var total = 0;
  $.each( elemento, function(i, val){
      arrayID.push(  $(val).prop('name'));
      arraytotal.push(  isNaN( $(val).prop('value') ) ? 0 : $(val).prop('value'));
  });
  arraytotal.pop();
  for (var i = 0; i < arraytotal.length; i++) {
      total += arraytotal[i] << 0;
  }
  // remover último elemento
  arrayID.pop();
  // console.log(arrayID.length);
  // console.log(arrayID);
  // console.log(arraytotal);
  // console.log(total);
  $('[name="totales"]').val(total);
}
function createEventListener (id) {
  const element = document.querySelector('[name="c_venue['+id+'].venue"]')
  element.addEventListener('change', function() {
    // var name = this.name;
    // console.log(name);
    var _token = $('input[name="_token"]').val();
    $.ajax({
      type: "POST",
      url: "./viat_find_hotel",
      data: { numero : this.value , _token : _token },
      success: function (data){
        if (data === '[]') {
          // $('[name="book['+id+'].hotel"]').empty();
          $('[name="c_hotel['+id+'].hotel"] option[value!=""]').remove();
          // $('[name="book['+id+'].hotel"]').append('<option value="" selected>Elige hotel</option>');
        }
        else{
          $('[name="c_hotel['+id+'].hotel"] option[value!=""]').remove();
          // $('[name="book['+id+'].hotel"]').empty();
          // $('[name="book['+id+'].hotel"]').append('<option value="" selected>Elige hotel</option>');
          $.each(JSON.parse(data),function(index, objdata){
            $('[name="c_hotel['+id+'].hotel"]').append('<option value="'+objdata.id+'">'+ objdata.Nombre_hotel +'</option>');
          });
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
    $('#validation').data('formValidation').resetField($('[name="c_hotel['+id+'].hotel"]'));
  });
}
function createEventListenerDates(id){
  $('#validation').find('[name="c_date['+id+']"]')
    .datepicker({
      format: 'dd/mm/yyyy'
    })
    .on('changeDate', function(e) {
      $('#validation').formValidation('revalidateField', 'c_date['+id+']');
    }).end();
}
function createEventListenerConcept (id) {
  const element = document.querySelector('[name="c_concept['+id+'].concept"]')
  element.addEventListener('change', function() {
    var _token = $('input[name="_token"]').val();
    $.ajax({
      type: "POST",
      url: "./viat_find_concept",
      data: { numero : this.value , _token : _token },
      success: function (data){
        var dato_p = data;
        if (dato_p === '0' || dato_p === '') {
          $('#validation').formValidation('enableFieldValidators', 'c_priceuni[' + id + '].priceuni', false);
          $('#validation').data('formValidation').resetField($('[name="c_priceuni['+id+'].priceuni"]'));

          $('#validation').formValidation('enableFieldValidators', 'c_cant[' + id + '].cant', false);
          $('#validation').data('formValidation').resetField($('[name="c_cant['+id+'].cant"]'));

          $('[name="c_priceuni[' + id + '].priceuni"]').val('');
          $("[name='c_cant[" + id + "].cant'] option[value='']").prop('selected', true);

          $("[name='c_priceuni[" + id + "].priceuni']").prop('disabled', 'disabled');
          $("[name='c_cant[" + id + "].cant']").prop('disabled', 'disabled');
          $('[name="c_price['+id+'].price"]').val('0');
          eventListenerSubtotal();
          // console.log('C0');
        }
        if (dato_p === '1') {
          $('#validation').formValidation('enableFieldValidators', 'c_priceuni[' + id + '].priceuni', true);
          $('#validation').data('formValidation').resetField($('[name="c_priceuni['+id+'].priceuni"]'));

          $('#validation').formValidation('enableFieldValidators', 'c_cant[' + id + '].cant', true);
          $('#validation').data('formValidation').resetField($('[name="c_cant['+id+'].cant"]'));

          $('[name="c_priceuni[' + id + '].priceuni"]').val('');
          $("[name='c_cant[" + id + "].cant'] option[value='']").prop('selected', true);

          $("[name='c_priceuni[" + id + "].priceuni']").prop('disabled', false);
          $("[name='c_cant[" + id + "].cant']").prop('disabled', false);
          eventListenerSubtotal();
          // console.log('C1');
        }
        if (dato_p === '2') {
          $('#validation').formValidation('enableFieldValidators', 'c_priceuni[' + id + '].priceuni', false);
          $('#validation').data('formValidation').resetField($('[name="c_priceuni['+id+'].priceuni"]'));

          $('#validation').formValidation('enableFieldValidators', 'c_cant[' + id + '].cant', true);
          $('#validation').data('formValidation').resetField($('[name="c_cant['+id+'].cant"]'));

          $('[name="c_priceuni[' + id + '].priceuni"]').val(100);
          $("[name='c_cant[" + id + "].cant'] option[value='1']").prop('selected', true);

          $("[name='c_priceuni[" + id + "].priceuni']").prop('disabled', 'disabled');
          $("[name='c_cant[" + id + "].cant']").prop('disabled', false);
          $('[name="c_price['+id+'].price"]').val('100');
          eventListenerSubtotal();
        }

      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  });
}
function createEventListener_amount (id) {
  const element = document.querySelector('[name="c_cant['+id+'].cant"]')
  element.addEventListener('change', function() {
    var total = 0,
        valor = this.value;
        valor = parseInt(valor); // Convertir el valor a un entero (número).

        total = document.getElementsByName('c_priceuni['+id+'].priceuni')[0].value;
        // console.log(total);

        // Aquí valido si hay un valor previo, si no hay datos, le pongo un cero "0".
        total = (total == null || total == undefined || total == "") ? 0 : total;
        // console.log(total);

        /* Esta es la suma.*/
        var total2 = (parseInt(total) * parseInt(valor));
        // console.log(total2);

        /* Cambiamos el valor del Subtotal*/
        $('[name="c_price['+id+'].price"]').val(total2);
        eventListenerSubtotal();
  });
}
function createEventListener_priceuni (id) {
  const element = document.querySelector('[name="c_priceuni['+id+'].priceuni"]')
  element.addEventListener('keyup', function() {
    var total = 0,
        valor = this.value;
        valor = parseInt(valor); // Convertir el valor a un entero (número).

        total = document.getElementsByName('c_cant['+id+'].cant')[0].value;
        // console.log(total);

        // Aquí valido si hay un valor previo, si no hay datos, le pongo un cero "0".
        total = (total == null || total == undefined || total == "") ? 0 : total;
        // console.log(total);

        /* Esta es la suma.*/
        var total2 = (parseInt(total) * parseInt(valor));
        // console.log(total2);

        /* Cambiamos el valor del Subtotal*/
        $('[name="c_price['+id+'].price"]').val(total2);
        eventListenerSubtotal();
  });
}
function createEventListenerJust(id) {
  $('#validation').find('[name="c_just['+id+']"]')
    .change(function(e) {
      $('#validation').formValidation('revalidateField', 'c_just['+id+']');
  })
  .end()
}
$('.benef').on('change', function(e){
  var id= $(this).val();
  var _token = $('input[name="_token"]').val();
  if (id != ''){
    $.ajax({
      type: "POST",
      url: "./search_beneficiary",
      data: { numero : id , _token : _token },
      success: function (data){
        if (data === '[]') {
          $('[name="user_id"] option[value!=""]').remove();
        }
        else{
          $('[name="user_id"] option[value!=""]').remove();
          $.each(JSON.parse(data),function(index, objdata){
            $('[name="user_id"]').append('<option value="'+objdata.id+'">'+ objdata.nombre +'</option>');
          });
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
  else {
      $('[name="user_id"] option[value!=""]').remove();
  }
});

$('#btn_plantilla').on('click', function(){
  var id_plan = $('#slc_plantilla').val();
  var _token = $('input[name="_token"]').val();
  //console.log('click: ' + id_plan);
  // validar vacio.
  if (id_plan === "") {
    menssage_toast('Mensaje', '2', 'Seleccione una plantilla!' , '3000');
  }else{
    //console.log('aqui viene lo bueno');
    $.ajax({
        type: "POST",
        url: "/get_plantilla",
        async: false,
        data: { slc_plantilla : id_plan, _token : _token},
        success: function (data){
          console.log(data);
          // console.log(data[0].amount);
          // clonar con la información o funcion.
          //create_template(data);
          //add_values_dyn(data);
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
  }
});

function fill_selectH(id, id_cad) {
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "./viat_find_hotel",
    data: { numero : id_cad , _token : _token },
    success: function (data){
      if (data === '[]') {
        // $('[name="book['+id+'].hotel"]').empty();
        $('[name="c_hotel['+id+'].hotel"] option[value!=""]').remove();
        // $('[name="book['+id+'].hotel"]').append('<option value="" selected>Elige hotel</option>');
      }
      else{
        $('[name="c_hotel['+id+'].hotel"] option[value!=""]').remove();
        // $('[name="book['+id+'].hotel"]').empty();
        // $('[name="book['+id+'].hotel"]').append('<option value="" selected>Elige hotel</option>');
        $.each(JSON.parse(data),function(index, objdata){
          $('[name="c_hotel['+id+'].hotel"]').append('<option value="'+ objdata.id +'">'+ objdata.Nombre_hotel +'</option>');
        });
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
  //$('#validation').data('formValidation').resetField($('[name="c_hotel['+id+'].hotel"]'));
}

function add_values_dyn(data) {
  var cant;
  var index = 1;
  //fill_selectH(conceptIndex, data[0].cadena_id);
  if (data[0].cantidad === 0) {cant = ""}else{cant = data[0].cantidad}

  $('#validationW2')
    .find('[name="c_venue[' + 0 + '].venue"]').val(data[0].cadena_id).trigger('change').end()
    //.find('[name="c_hotel[' + 0 + '].hotel"]').val(data[0].hotel_id).trigger('change').end()
    .find('[name="c_date[' + 0 + ']"]').val(data[0].fecha_concept).end()
    .find('[name="c_concept[' + 0 + '].concept"]').val(data[0].list_concept_id).trigger('change').end()
    .find('[name="c_cant[' + 0 + '].cant"]').val(cant).trigger('change').end()
    .find('[name="c_priceuni[' + 0 + '].priceuni"]').val(data[0].amount).end();
  for (index; index < data.length; index++) {
    if (data[index].cantidad === 0) {cant = ""}else{cant = data[index].cantidad}
    $('#validationW2')
      .find('[name="c_venue[' + index + '].venue"]').val(data[index].cadena_id).trigger('change').end()
      //.find('[name="c_hotel[' + index + '].hotel"]').val(data[index].hotel_id).trigger('change').end()
      .find('[name="c_date[' + index + ']"]').val(data[index].fecha_concept).end()
      .find('[name="c_concept[' + index + '].concept"]').val(data[index].list_concept_id).trigger('change').end()
    .find('[name="c_cant[' + index + '].cant"]').val(data[index].cantidad).trigger('change').end()
    .find('[name="c_priceuni[' + index + '].priceuni"]').val(data[index].amount).end();
  }
}

(function() {
  $(".select2").select2();
  createEventListener (0);
  createEventListenerConcept (0);
 // $("[name='c_priceuni[" + 0 + "].priceuni']").prop('disabled', 'disabled');
 // $("[name='c_cant[" + 0 + "].cant']").prop('disabled', 'disabled');

 createEventListener_amount(0);
 createEventListener_priceuni(0);

 $('#exampleValidator').wizard({
   onInit: function() {
       $('#validation')
         .find('[name="priority_id"]')
            .select2()
            .change(function(e) {
                $('#validation').formValidation('revalidateField', 'priority_id');
            })
            .end()
         .find('[name="service_id"]')
            .select2()
            .change(function(e) {
                $('#validation').formValidation('revalidateField', 'service_id');
            })
            .end()
         .find('[name="beneficiario_id"]')
             .select2()
             .change(function(e) {
                 $('#validation').formValidation('revalidateField', 'beneficiario_id');
             })
             .end()
         .find('[name="cadena_id"]')
             .select2()
             .change(function(e) {
                 $('#validation').formValidation('revalidateField', 'cadena_id');
             })
             .end()
         .find('[name="user_id"]')
             .select2()
             .change(function(e) {
                 $('#validation').formValidation('revalidateField', 'user_id');
             })
             .end()
         .find('[name="gerente_id"]')
             .select2()
             .change(function(e) {
                 $('#validation').formValidation('revalidateField', 'gerente_id');
             })
             .end()
         .find('[name="startDate"]')
             .datepicker({
                 format: 'dd/mm/yyyy'
             })
             .on('changeDate', function(e) {
                 $('#validation').formValidation('revalidateField', 'startDate');
             })
             .end()
         .find('[name="endDate"]')
             .datepicker({
                 format: 'dd/mm/yyyy'
             })
             .on('changeDate', function(e) {
                 $('#validation').formValidation('revalidateField', 'endDate');
             })
             .end()
         .find('[name="c_date[0]"]')
             .datepicker({
                 format: 'dd/mm/yyyy'
             })
             .on('changeDate', function(e) {
                 $('#validation').formValidation('revalidateField', 'c_date[0]');
             })
             .end()
       .formValidation({
         framework: 'bootstrap',
         excluded: ':disabled',
         icon: {
             valid: 'glyphicon glyphicon-ok',
             invalid: 'glyphicon glyphicon-remove',
             validating: 'glyphicon glyphicon-refresh'
         },
         fields: {
           priority_id: {
               validators: {
                   notEmpty: {
                       message: 'Please select a service.'
                   }
               }
           },
           service_id: {
               validators: {
                   notEmpty: {
                       message: 'Please select a service.'
                   }
               }
           },
           beneficiario_id: {
               validators: {
                   notEmpty: {
                       message: 'Please select a beneficiary.'
                   }
               }
           },
           cadena_id: {
               validators: {
                   notEmpty: {
                       message: 'Please select a proyect.'
                   }
               }
           },
           user_id: {
               validators: {
                   notEmpty: {
                       message: 'Please select a user.'
                   }
               }
           },
           gerente_id: {
               validators: {
                   notEmpty: {
                       message: 'Please select a manager.'
                   }
               }
           },
           startDate: {
              validators: {
                  notEmpty: {
                      message: 'The start date is required'
                  },
                  date: {
                      format: 'DD/MM/YYYY',
                      max: 'endDate',
                      message: 'The start date is not a valid'
                  }
              }
           },
           endDate: {
              validators: {
                  notEmpty: {
                      message: 'The end date is required'
                  },
                  date: {
                      format: 'DD/MM/YYYY',
                      min: 'startDate',
                      message: 'The end date is not a valid'
                  }
              }
           },
           place_o: {
              validators: {
                  notEmpty: {
                      message: 'The origin place  is required'
                  }
              }
           },
           place_d: {
              validators: {
                  notEmpty: {
                      message: 'The destination place is required'
                  }
              }
           },
           descripcion: {
              validators: {
                  notEmpty: {
                      message: 'The description is required'
                  },
                  stringLength: {
                      max: 700,
                      message: 'The description must be less than 700 characters long'
                  }
              }
           },
           // obs_conc: {
           //    validators: {
           //        notEmpty: {
           //            message: 'The justification is required'
           //        },
           //        stringLength: {
           //            max: 2000,
           //            message: 'The justification must be less than 2000 characters long'
           //        }
           //    }
           // },
           'c_venue[0].venue': venue,
           'c_hotel[0].hotel': hotel,
           'c_date[0]': date_c,
           'c_concept[0].concept': concept,
           'c_cant[0].cant': cant,
           'c_priceuni[0].priceuni': priceuni,
           'c_just[0].just': just,
       }
      })
        // Add button click handler
        .on('click', '.addButton', function() {
            if (conceptIndex === 0) {
              conceptIndex++
            }
            var $template = $('#optionTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .attr('data-book-index', conceptIndex)
                                .insertBefore($template);
            // Update the name attributes
            $clone
                .find('[name="venue"]').attr('name', 'c_venue[' + conceptIndex + '].venue').attr('data_row', conceptIndex).end()
                .find('[name="hotel"]').attr('name', 'c_hotel[' + conceptIndex + '].hotel').end()
                .find('[name="date"]').attr('name', 'c_date[' + conceptIndex + ']').end()
                .find('[name="concept"]').attr('name', 'c_concept[' + conceptIndex + '].concept').end()
                .find('[name="cant"]').attr('name', 'c_cant[' + conceptIndex + '].cant').end()
                .find('[name="priceuni"]').attr('name', 'c_priceuni[' + conceptIndex + '].priceuni').end()
                .find('[name="price"]').attr('name', 'c_price[' + conceptIndex + '].price').end()
                .find('[name="just"]').attr('name', 'c_just[' + conceptIndex + '].just').end();
            createEventListener (conceptIndex);
            createEventListenerDates(conceptIndex);
            createEventListenerConcept (conceptIndex);
            createEventListener_amount (conceptIndex);
            createEventListener_priceuni(conceptIndex);
            createEventListenerJust(conceptIndex);

            // Add new fields
            // Note that we also pass the validator rules for new field as the third parameter
            $('#validation')
                .formValidation('addField', 'c_venue[' + conceptIndex + '].venue', venue)
                .formValidation('addField', 'c_hotel[' + conceptIndex + '].hotel', hotel)
                .formValidation('addField', 'c_date[' + conceptIndex + ']', date_c)
                .formValidation('addField', 'c_concept[' + conceptIndex + '].concept', concept)
                .formValidation('addField', 'c_cant[' + conceptIndex + '].cant', cant)
                .formValidation('addField', 'c_priceuni[' + conceptIndex + '].priceuni', priceuni)
                .formValidation('addField', 'c_just[' + conceptIndex + '].just', just);
            array_suma.push(conceptIndex);
            conceptIndex++;
            //console.log(array_suma);
        })
        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row  = $(this).parents('.form-group'),
                index = parseInt($row.attr('data-book-index'));

            //Remove field
            $('#validation')
                .formValidation('removeField', $row.find('[name="c_venue[' + index + '].venue"]'))
                .formValidation('removeField', $row.find('[name="c_hotel[' + index + '].hotel"]'))
                .formValidation('removeField', $row.find('[name="c_date[' + index + ']"]'))
                .formValidation('removeField', $row.find('[name="c_concept[' + index + '].concept"]'))
                .formValidation('removeField', $row.find('[name="c_cant[' + index + '].cant"]'))
                .formValidation('removeField', $row.find('[name="c_priceuni[' + index + '].priceuni"]'))
                .formValidation('removeField', $row.find('[name="c_just[' + index + '].just"]'))
            // Remove element containing the option
            $row.remove();

            eventListenerSubtotal();

            empty_array.push(index);

            //conceptIndex = conceptIndex - 1;
            console.log(empty_array);
        })
        .on('success.field.fv', function(e, data) {
          if (data.field === 'startDate' && !data.fv.isValidField('endDate')) {
              // We need to revalidate the end date
              data.fv.revalidateField('endDate');
          }
          if (data.field === 'endDate' && !data.fv.isValidField('startDate')) {
              // We need to revalidate the start date
              data.fv.revalidateField('startDate');
          }
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
      if (empty_array === undefined || empty_array == 0) {
        document.getElementById("validation").submit();
        $('#validation')[0].reset();
        $('#exampleValidator').wizard('first');
        $('#exampleValidator').wizard('reset');
        // menssage_toast('Mensaje', '4', 'Operation complete!' , '3000');
        $('#validation').data('formValidation').resetForm('true');
        $('#exampleValidator').find('li.done').removeClass( "done" );

      }else{
        rename_onSubmit(empty_array, array_suma);
        document.getElementById("validation").submit();
        $('#validation')[0].reset();
        $('#exampleValidator').wizard('first');
        $('#exampleValidator').wizard('reset');
        // menssage_toast('Mensaje', '4', 'Operation complete!' , '3000');
        $('#validation').data('formValidation').resetForm('true');
        $('#exampleValidator').find('li.done').removeClass( "done" );
      }
   },
   onSuccess: function(e) {
   }

  })
})();

function rename_onSubmit(empty_array, array_suma) {
  var indC = 0;

  var empty_size = empty_array.length;
  var suma_size = array_suma.length;

  for (var num = 1; num <= suma_size; num++) {
    if (inArray(num, empty_array)) {
      // true.
    }else{
      indC = indC + 1;
      // false.
      // rename fields.
      $('#validationW2')
        .find('[data-book-index="'+num+'"]').attr('data-book-index', indC).end()

        .find('[name="c_venue[' + num + '].venue"]').attr('name', 'c_venue[' + indC + '].venue').attr('data_row', indC).attr('data-fv-field', 'c_venue[' + indC + '].venue').attr('data-fv-icon-for', 'c_venue[' + indC + '].venue')
        .end()
        .find('i[data-fv-icon-for="c_venue[' + num + '].venue"]').attr('data-fv-icon-for','c_venue[' + indC + '].venue').end()
        .find('small[data-fv-for="c_venue[' + num + '].venue"]').attr('data-fv-for', 'c_venue[' + indC + '].venue').end()

        .find('[name="c_hotel[' + num + '].hotel"]').attr('name', 'c_hotel[' + indC + '].hotel').attr('data-fv-field', 'c_hotel[' + indC + '].hotel').attr('data-fv-icon-for', 'c_hotel[' + indC + '].hotel').end()
        .find('i[data-fv-icon-for="c_hotel[' + num + '].hotel"]').attr('data-fv-icon-for','c_hotel[' + indC + '].hotel').end()
        .find('small[data-fv-for="c_hotel[' + num + '].hotel"]').attr('data-fv-for', 'c_hotel[' + indC + '].hotel').end()


        .find('[name="c_date[' + num + ']"]').attr('name', 'c_date[' + indC + ']').attr('data-fv-field', 'c_date[' + indC + ']').attr('data-fv-icon-for', 'c_date[' + indC + ']').end()
        .find('i[data-fv-icon-for="c_date[' + num + ']"]').attr('data-fv-icon-for','c_date[' + indC + ']').end()
        .find('small[data-fv-for="c_date[' + num + ']"]').attr('data-fv-for', 'c_date[' + indC + ']').end()

        .find('[name="c_concept[' + num + '].concept"]').attr('name', 'c_concept[' + indC + '].concept').attr('data-fv-field', 'c_concept[' + indC + '].concept').attr('data-fv-icon-for', 'c_concept[' + indC + '].concept').end()
        .find('i[data-fv-icon-for="c_concept[' + num + '].concept"]').attr('data-fv-icon-for','c_concept[' + indC + '].concept').end()
        .find('small[data-fv-for="c_concept[' + num + '].concept"]').attr('data-fv-for', 'c_concept[' + indC + '].concept').end()

        .find('[name="c_cant[' + num + '].cant"]').attr('name', 'c_cant[' + indC + '].cant').attr('data-fv-field', 'c_cant[' + indC + '].cant').attr('data-fv-icon-for', 'c_cant[' + indC + '].cant').end()
        .find('i[data-fv-icon-for="c_cant[' + num + '].cant"]').attr('data-fv-icon-for','c_cant[' + indC + '].cant').end()
        .find('small[data-fv-for="c_cant[' + num + '].cant"]').attr('data-fv-for', 'c_cant[' + indC + '].cant').end()

        .find('[name="c_priceuni[' + num + '].priceuni"]').attr('name', 'c_priceuni[' + indC + '].priceuni').attr('data-fv-field', 'c_priceuni[' + indC + '].priceuni').attr('data-fv-icon-for', 'c_priceuni[' + indC + '].priceuni').end()
        .find('i[data-fv-icon-for="c_priceuni[' + num + '].priceuni"]').attr('data-fv-icon-for','c_priceuni[' + indC + '].priceuni').end()
        .find('small[data-fv-for="c_priceuni[' + num + '].priceuni"]').attr('data-fv-for', 'c_priceuni[' + indC + '].priceuni').end()

        .find('[name="c_price[' + num + '].price"]').attr('name', 'c_price[' + indC + '].price').attr('data-fv-field', 'c_price[' + indC + '].price').attr('data-fv-icon-for', 'c_price[' + indC + '].price').end()
        .find('i[data-fv-icon-for="c_price[' + num + '].price"]').attr('data-fv-icon-for','c_price[' + indC + '].price').end()
        .find('small[data-fv-for="c_price[' + num + '].price"]').attr('data-fv-for', 'c_price[' + indC + '].price').end()

        .find('[name="c_just[' + num + '].just"]').attr('name', 'c_just[' + indC + '].just').attr('data-fv-field', 'c_just[' + indC + '].just').attr('data-fv-icon-for', 'c_just[' + indC + '].just').end()
        .find('i[data-fv-icon-for="c_just[' + num + '].just"]').attr('data-fv-icon-for','c_just[' + indC + '].just').end()
        .find('small[data-fv-for="c_just[' + num + '].just"]').attr('data-fv-for', 'c_just[' + indC + '].just').end();
    }
  }
}
function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}

function create_template(data) {
  //conceptIndex++;
  //skip iteration 0, just rename.
  for (conceptIndex; conceptIndex < data.length; conceptIndex++) {
    if (conceptIndex === 0) {
      //console.log('entre una vez');
      fill_selectH(conceptIndex, data[0].cadena_id);
      // $('#validationW2')
      //   .find('[name="c_venue[' + conceptIndex + '].venue"]').val(data[0].cadena_id).change().end()
      //   .find('[name="c_hotel[' + conceptIndex + '].hotel"]').val(data[0].hotel_id).trigger('change').end();
      //   .find('[name="c_date[' + conceptIndex + ']"]').val(data[0].fecha_concept).end()
      //   .find('[name="c_concept[' + conceptIndex + '].concept"]').val(data[0].list_concept_id).change().end()
      continue;
    }else{
      fill_selectH(conceptIndex, data[conceptIndex].cadena_id);
      array_suma.push(conceptIndex);
      var $template = $('#optionTemplate'),
          $clone    = $template
                          .clone()
                          .removeClass('hide')
                          .removeAttr('id')
                          .attr('data-book-index', conceptIndex)
                          .insertBefore($template);
      // Update the name attributes
      $clone
        .find('[name="venue"]').attr('name', 'c_venue[' + conceptIndex + '].venue').attr('data_row', conceptIndex).end()
        .find('[name="hotel"]').attr('name', 'c_hotel[' + conceptIndex + '].hotel').end()
        .find('[name="date"]').attr('name', 'c_date[' + conceptIndex + ']').end()
        .find('[name="concept"]').attr('name', 'c_concept[' + conceptIndex + '].concept').end()
        .find('[name="cant"]').attr('name', 'c_cant[' + conceptIndex + '].cant').end()
        .find('[name="priceuni"]').attr('name', 'c_priceuni[' + conceptIndex + '].priceuni').end()
        .find('[name="price"]').attr('name', 'c_price[' + conceptIndex + '].price').end();
      createEventListener (conceptIndex);
      createEventListenerConcept (conceptIndex);
      createEventListener_amount (conceptIndex);
      createEventListener_priceuni(conceptIndex);

      // Add new fields
      // Note that we also pass the validator rules for new field as the third parameter
      $('#validationW2')
        .find(".pickerV")
          .datepicker({
             format: 'dd/mm/yyyy'
          })
          .on('changeDate', function(e) {
             $('#validation').formValidation('revalidateField', '.pickerV');
          })
          .end()
        .formValidation('addField', 'c_venue[' + conceptIndex + '].venue', venue)
        .formValidation('addField', 'c_hotel[' + conceptIndex + '].hotel', hotel)
        .formValidation('addField', 'c_date[' + conceptIndex + ']', date_c)
        .formValidation('addField', 'c_concept[' + conceptIndex + '].concept', concept)
        .formValidation('addField', 'c_cant[' + conceptIndex + '].cant', cant)
        .formValidation('addField', 'c_priceuni[' + conceptIndex + '].priceuni', priceuni);
    }
  }
  console.log(conceptIndex);
  console.log(array_suma);
}
