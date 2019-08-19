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

$(document).ready(function(){

  $('#limitDatePicker').datepicker({
        format: 'dd/mm/yyyy'
  });

  $('#scheduledDatePick').datepicker({
        format: 'dd/mm/yyyy'
  });

  $('#provider').select2();


  //Validacion monto con excel
  $('#amount').on('keyup',function(){

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
      } else {
        subtotal += parseFloat($(this).val());
      }
    });

    if (checkbox.checked != true) {
      iva = parseFloat((subtotal * tasa)/100).toFixed(2);
      iva = parseFloat(iva);
      iva_format = parseFloat(iva).toFixed(2);
      total = parseFloat(subtotal + iva).toFixed(2);
      $('#iva').val(iva);
      $('#totales').val(total);
      $('#totales_format').val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
      $('#iva_format').val(iva_format.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }else{
      //console.log('esta marcado');
      $('#iva').val(0);
      $('#totales').val(subtotal);

      //$('#iva').prop( "disabled", false);
    }

  });


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
          $("#factura").parent().parent().addClass('has-error');
        }
      },
      error: function (data){
        console.log('Error:', data);
      }

    });

  });

  // Calcular iva
  $('#check_iva').on('change', function(){
    var checkbox = document.getElementById('check_iva');
    var monto = parseFloat($('#amount').val());
    var monto_excel = parseFloat($("#subtotal_excel").html());
    var iva = 0;
    var tasa = 16;
    var total = 0;
    var iva_format = "";
    var suma_total = 0.0;
    var suma_monto_iva = 0.0;

    var count = $('#preview_excel tbody tr').length;

    if(!isNaN(monto)){
      if (checkbox.checked != true) {
        //console.log('no esta marcado');
        iva = parseFloat((monto * tasa)/100);
        iva_format = parseFloat(iva).toFixed(2);
        total = parseFloat(monto + iva).toFixed(2);

        if(count =! 0){
          var monto_sitio = 0.0;
          $('#preview_excel tbody tr').each(function(row, tr){
              iva_percent = 16;
              monto_sitio = $(tr).find('td:eq(5)').text();
              $(tr).find('td:eq(6)').text(iva_percent); // valor de la celda monto iva
              $(tr).find('td:eq(7)').text(parseFloat((monto_sitio * tasa)/100).toFixed(2)); //MONTO IVA SITIO
              suma_monto_iva+= parseFloat($(tr).find('td:eq(7)').text());

          });
           suma_total = suma_monto_iva + parseFloat(monto_excel);
           console.log(monto_excel);
          $("#iva_total_excel").html(parseFloat(suma_monto_iva).toFixed(2));
          $("#total_excel").html(parseFloat(suma_total).toFixed(2));
        }

        $('#iva').val(iva);
        $('#iva_format').val(iva_format.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

        $('#totales').val(total);
        $('#totales_format').val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

      }else{

        if(count =! 0){
          $('#preview_excel tbody tr').each(function(row, tr){
              iva_percent = 0.00;
              $(tr).find('td:eq(6)').text(iva_percent); //IVA
              $(tr).find('td:eq(7)').text(0.00); //MONTO IVA
          });
          suma_total = suma_monto_iva + parseFloat(monto_excel);
          console.log(monto_excel);
          $("#iva_total_excel").html(parseFloat(suma_monto_iva).toFixed(2));
          $("#total_excel").html(parseFloat(suma_total).toFixed(2));
        }

        $('#iva').val(0);
        $('#iva_format').val(0);
        $('#totales').val(monto);
        $('#totales_format').val(monto.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

      }
    }

  });


  // The maximum number of options
  createEventListener_fileExcel();
  createEventListener_filePdf();
  createEventListener_fileXml();
  var constante_eliminar = [],
  constante_a = 0,
  max_options = 8,

  fileInput= {
    row: '.col-xs-2',   // The title is placed inside a <div class="col-xs-2"> element
    validators: {
      notEmpty: {
        message: 'The PDF file is required'
      },
      file: {
        extension: 'pdf',
        type: 'application/pdf',
        message: 'Please choose a PDF file'
      }
    }
  };

  $('#validation').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      file_excel: {
        validators:{
          notEmpty: {
              message: 'Seleccione un archivo.'
          },
          file: {
                  extension: 'xls,xlsx',
                  message: 'Seleccione un archivo de Excel.'
          }
        }
      },
      file_pdf: {
          validators: {
              file: {
                  extension: 'pdf',
                  type: 'application/pdf',
                  message: 'Por favor,seleccione un archivo PDF.'
              }
          }
      },
      file_xml: {
          validators: {
              file: {
                  extension: 'xml',
                  type: 'text/xml',
                  message: 'Selecciona un archivo xml.'
              }
          }
      },
      priority_viat: {
          validators: {
              notEmpty: {
                  message: 'Por favor, seleccione una prioridad.'
              }
          }
      },
      provider: {
          validators: {
              notEmpty: {
                  message: 'Por favor, seleccione un proveedor.'
              }
          }
      },
      amount: {
          validators: {
              notEmpty: {
                  message: 'Cantidad es requerida.'
              }
          }
      },
      amount_excel: {
          validators: {
              notEmpty: {
                  message: 'Cantidad es requerida.'
              }
          }
      },
      methodpay: {
        validators:{
          notEmpty: {
            message: 'Forma de pago es requerida.'
          }
        }
      },
      coin: {
        validators:{
          notEmpty: {
            message: 'El tipo de moneda es requerido.'
          }
        }
      },
      factura:{
        validators:{
          notEmpty: {
            message: 'Factura es requerida.'
          }
        }
      },
      concept_pay:{
        validators:{
          notEmpty: {
            message: 'El concepto de pago es requerido.'
          }
        }
      },
      bank: {
          validators: {
              notEmpty: {
                  message: 'Please select a bank.'
              }
          }
      },
      account: {
          validators: {
              notEmpty: {
                  message: 'Please select a account.'
              }
          }
      },
      observaciones: {
         validators: {
             notEmpty: {
                 message: 'La observación es requerida.'
             },
             stringLength: {
                 max: 700,
                 message: 'No puede escribir mas de 700 caracteres.'
             }
         }
      },
      'c_fileInput[0]':fileInput,
      'dyn_field[0]': field1,
    }
  })
  .on('change', '.changeField0', async function(){
    console.log('changeField0');
    var id = $(this).val();
    var name_key = $("option:selected",this).text();
    $('#cc_key').val(name_key);
    var check_data;
    //console.log('cambio: ' + id);
    if (conceptIndex === 0) {
      check_data = await get_dyn2_test(id);
      if (check_data === 0) {
        //console.log('Vacio: ' + check_data);
      }else{
        console.log('datos: ' + check_data);
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
            .find('.change_label').text('Nivel 2').end();

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
    var check_data2;
    //console.log('cambio: ' + id);

    if (conceptIndex === 1) {
      check_data2 = await get_dyn3_test(id);
      if (check_data2 === 0) {
        console.log('Vacio Level2: ' + check_data2);
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
  })
  // AJAX
  .on('success.form.fv', function(e) {
    e.preventDefault();

    /* ------------------------------- */
    swal({
      title: "¿Desea continuar?",
      text: "Espere mientras se sube la información.",
      type: "info",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Continuar.!",
      cancelButtonText: "Cancelar.!",
      closeOnConfirm: false,
      closeOnCancel: false,
      showLoaderOnConfirm: true,
    },
    function(isConfirm) {
      if (isConfirm) {
        var form = $('#validation')[0];
        var formData = new FormData(form);
        var arrrayMontosIva = [];
        var monto_iva = 0.0;
        var iva_percent = 0;
        var sites_data = [];
        if($('#check_iva').prop('checked') == false){
          $('#preview_excel tbody tr').each(function(row, tr){
              const data_site = {
                  grupo_id: $(tr).find('td:eq(0)').text(),
                  anexo_id: $(tr).find('td:eq(2)').text(),
                  amount: $(tr).find('td:eq(5)').text(),
              };
              iva_percent = 16;
              monto_iva = $(tr).find('td:eq(7)').text(); // valor de la celda monto iva
              arrrayMontosIva.push(monto_iva);
              sites_data.push(data_site);
          });
          console.log(sites_data);
          arrrayMontosIva.forEach( monto => {
              formData.append('monto_iva[]', monto);
          });
            formData.append('iva_percent', iva_percent);
        }else{
          //Sin iva
          $('#preview_excel tbody tr').each(function(row, tr){
            const data_site = {
                grupo_id: $(tr).find('td:eq(0)').text(),
                anexo_id: $(tr).find('td:eq(2)').text(),
                amount: $(tr).find('td:eq(5)').text(),
            };
            sites_data.push(data_site);
            arrrayMontosIva.push(monto_iva);
          });

          arrrayMontosIva.forEach( monto => {
              formData.append('monto_iva[]', monto);
          });
          formData.append('iva_percent', iva_percent);
        }
        console.log(sites_data);

        formData.append('data_sites', JSON.stringify(sites_data));

        $.ajax({
          type: "POST",
          url: "/create_pay_import",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){

            datax = JSON.parse(data);

               $('#title-alert').text('Operation complete!');
               $('#texto-alert').text('Su folio es ' + datax);
               // Reseteando valores del form
               $('#ajax-alert').removeClass();
               $('#ajax-alert').addClass('alert alert-success').show();

               $("#validation")[0].reset();
               $('#validation').data('formValidation').resetForm($('#validation'));
               $("#preview_excel tbody tr").remove();
               $("amount_excel").parent().parent().removeClass('has-success');

               $('#priority_viat option[value="2"]').prop('selected', 'selected').change();
               $("#provider").select2({placeholder: "Elija"});

               swal({title: "Solicitud de pago guardada", text: "Folio:" + data , type: "success"},
                   function(){
                       location.reload();
                   }
                );



          },
          error: function (data) {
            console.log('Error:', data);
            swal.close();
          }
        })

      }
      else {
        swal("Operación abortada", "Ningúna solicitud de pago afectada :)", "error");
      }
    });

  })

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
  console.log(conceptIndex);
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
});

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
      console.log(data);
      if (data === undefined || data.length === 0) {
        console.log('data vacia');
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
  $('[name="totales"]').val(total);
}

function createEventListener_fileExcel () {
  const element = document.querySelector('[name="file_excel"')
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

function createEventListener_filePdf () {
  const element = document.querySelector('[name="file_pdf"')
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


//Mensaje amountText

function mostrarMensaje(mensaje,clases){
    const div = document.createElement('div');
    div.classList = clases;

    div.appendChild(document.createTextNode(mensaje));

    const buscadorDiv = document.querySelector('#amount_info');
    buscadorDiv.appendChild(div);

    setTimeout(() => {
      buscadorDiv.removeChild(div);
    }, 5000);
}


//Datos bancarios

  $('#provider').on('change',function(){
    $('#bank').empty();
    $('#bank').append('<option value="">Elegir...</option>');
     getBank();
  });

  $('#file_excel').on('change', function(e){
    showDataExcel(e);
  });

  function showDataExcel(event)
  {
    var _token = $('input[name="_token"]').val();
    var file = event.target.files[0];
    var reader = new FileReader();
    var excelData = [];
    var element = {}
    var payments_json;
    var cont = 0;
    $("#img-loading").css('display','block');
    reader.onload = function (event) {
      var flag = 0;
        var data = event.target.result;
        var workbook = XLSX.read(data, {
            type: 'binary'
        });


        // Objeto de la hoja payments
      var XL_row_object = XLSX.utils.sheet_to_json(workbook.Sheets.Payments, {raw: true});
      //  console.log(XL_row_object);
      var payments = JSON.stringify(XL_row_object);
          payments_json = JSON.parse(payments);

          for (var i = 0; i < payments_json.length; i++)
          {
            if(payments_json[i]["grupo_id"] != "")
            {
              element = {grupo_id: payments_json[i]["grupo_id"], anexo_id:  payments_json[i]["anexo_id"], amount: payments_json[i]["amount"]};
              excelData.push(element);
            }else{
              break;
            }

          }
          //console.log(excelData);
        if(flag == 0){
          $.ajax({
            type: "POST",
            url: "/getDataExcel",
            data: { data_excel : excelData , _token : _token },
            success: function (data){
              console.log(data);
              var total = 0.0;
              var total_format = "";
              var monto_iva = 0.0;
              var monto_iva_format = "";
              var cantidad = 0.0;
              var total_iva = 0.0;
              var subtotal = 0.0;
              var tasa_iva = 0;
              if(data == 0){
                swal('Plantilla incorrecta','', 'error');
                $("#preview_excel tbody tr").remove();
              }else if(data ==1){
                swal('Las claves del grupo y anexo no coiciden','Favor de verificar los datos del excel', 'error');
                $("#preview_excel tbody tr").remove();
              }
              else{

                $("#img-loading").css('display','none');
                $("#preview_excel tbody tr").remove();
                var checkbox = document.getElementById('check_iva');
                if (checkbox.checked != true) {
                  tasa_iva = 16;
                }
                $.each(data, function( i, key ) {

                  cantidad = parseFloat(key.cantidad);
                  subtotal += cantidad;
                  monto_iva = (cantidad * tasa_iva) / 100;
                  total_iva += monto_iva;
                  monto_iva_format = parseFloat(monto_iva).toFixed(2);
                  total += (cantidad + monto_iva);

                  $('#preview_excel').append('<tr><td>'
                                                           + key.grupo[0].id + '</td><td>'
                                                           + key.grupo[0].name + '</td><td>'
                                                           + key.anexo[0].id + '</td><td>'
                                                           + key.anexo[0].Nombre_hotel + '</td><td>'
                                                           + key.id_proyecto[0].id_proyecto + '</td><td>'
                                                           + key.cantidad + '</td><td>'
                                                           + 16 + '</td><td>'
                                                           + monto_iva_format + '</td><td>'
                                                           + '</td></tr>');
                 });

                $('#subtotal_excel').html(parseFloat(subtotal).toFixed(2));
                $('#iva_total_excel').html(parseFloat(total_iva).toFixed(2));
                total_format = parseFloat(total).toFixed(2);
                var total_excel_format = total_format.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                $('#total_excel').html(parseFloat(total).toFixed(2));
                var amount = $('#totales').val();

                validarMontos(amount, total);

              }
            },
            error: function (data){
              console.log('Error:', data);
            }

          });
        }else{
          swal('Debe llenar todos los campos','LLene los datos faltantes de la plantilla de Excel y vuelva a intentar', 'error');
          $('#file_excel').val('');


        }
      };


    reader.onerror = function (ex) {
        console.log(ex);
    };

    reader.readAsBinaryString(file);

  }

  //  Funcion para Validar montos de sitios en excel y  monto global

  function validarMontos(amount , amountExcel){
    console.log(amount);
    console.log(amountExcel);
    if(amount != amountExcel){
      mostrarMensaje('Los cantidades no coinciden. Favor de revisar que el monto total de los sitios coincida con la factura','bg-danger alert');

      $('#totales_format').parent().parent().addClass('has-error');
      $('#file_excel').parent().parent().addClass('has-error');
      $('#total_excel').parent().parent().addClass('text-danger');
    }else{
      $('#totales_format').parent().parent().removeClass('has-error');
      $('#file_excel').parent().parent().removeClass('has-error');
      $('#total_excel').parent().parent().removeClass('text-danger');

      $('#totales_format').parent().parent().addClass('has-success');
      $('#file_excel').parent().parent().addClass('has-sucess');
      $('#total_excel').parent().parent().addClass('text-success');
    }
  }

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
    //$('#account').append('<option value="">Elegir...</option>');
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
          console.log(datax);
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
  })
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
            console.log(data);
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

  $("#amount").on("blur", function(){
    var amount = parseFloat($("#totales").val());
    var total_excel = parseFloat($("#total_excel").html());
    validarMontos(amount, total_excel);
  });


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
