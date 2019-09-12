$(function() {
  createEventListener_filePdf();
  createEventListener_fileXml();
});

function modalPendiente() {
    $('#modalPendiente').modal('toggle');
    $.ajax({
      type: "POST",
      url: "/find_fact_pend",
      data: { _token : $('input[name="_token"]').val() },
      success: function (data){
          $('#info_fact_pend').val('').trigger('change');
          $('[name="info_fact_pend"] option[value!=""]').remove();
          $.each(JSON.parse(data),function(index, objdata){
            $('[name="info_fact_pend"]').append('<option value="'+objdata.id+'">'+ objdata.folio +'</option>');
          });
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
};


$('#info_fact_pend').on('change', function(e){
  var id_pay = $(this).val();
  if (id_pay != '') {
    $.ajax({
      type: "POST",
      url: "/get_data_fact_by_drive",
      data: { data_one : id_pay, _token : $('input[name="_token"]').val() },
      success: function (data){
        datax = JSON.parse(data);
        if (datax == null || datax == '[]') {
          $('#validation_modal_fact').find('input:text').val('');
          $('#validation_modal_fact').find('input:file').val('');
          $('input[name="info_nofact"]').prop("readonly", true);
        }
        else {
            $("#info_proveedor").val(datax[0].folio);
            $("#info_cantidad").val(datax[0].monto_str);
            $("#info_orden").val(datax[0].concept_pay);
            // $("#info_nofact").val(datax[0].date_solicitude);
            $("#info_nofact").val(datax[0].factura);
            $('input[name="info_nofact"]').prop("readonly", false);
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
  else {
    $('input[name="info_nofact"]').prop("readonly", true);
    $('#validation_modal_fact').find('input:text').val('');
    $('#validation_modal_fact').find('input:file').val('');
  }
});

$("#validation_modal_fact").validate({
    ignore: '*:not([name])', //Fixes your name issue
    rules: {
      file_pdf: {
        extension: 'pdf',
      },
      file_xml: {
        extension: 'xlsx',
      },
    },
    messages: {

    },
    debug: true,
    errorElement: "label",
    errorPlacement: function(error, element) {
      console.log(element);
      if (element[0].id === 'file_pdf') {
        error.insertAfter($('#cont_1'));
      }
      else if (element[0].id === 'file_xml') {
        error.insertAfter($('#cont_2'));
      }
      else{
         error.insertAfter(element);
      }
    },
    submitHandler: function(form){
      /*----------------------------------------------------------------------*/
        swal({
          title: "Estás seguro?",
          text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
          type: "warning",
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
            // The AJAX
            var form = $('#validation_modal_fact')[0];
            var formData = new FormData(form);
            $.ajax({
              type: 'POST',
              url: "/add_fact_pend_by_drive",
              data: formData,
              contentType: false,
              processData: false,
              success: function (data){
                datax = data;
                if (datax != '0') {
                  $('#modalPendiente').modal('toggle');
                  swal("Operación Completada!", ":)", "success");
                }
                else {
                  $('#modalPendiente').modal('toggle');
                  swal("Operación abortada", "Error al registrar intente otra vez :(", "error");
                }

                $("#validation_modal_fact")[0].reset();
                var validator = $( "#validation_modal_fact" ).validate();
                validator.resetForm();
              },
              error: function (data) {
                $('#modalPendiente').modal('toggle');
                swal("Operación abortada", "Ningúna operación afectuada :)", "error");
              }
            });
          }
          else {
            $('#modalPendiente').modal('toggle');
            swal("Operación abortada", "Ningúna operación afectuada :)", "error");
          }
        });
      /*----------------------------------------------------------------------*/
    }
});

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

function modalToggle(url, name, size) {
  $("#modal-preview").html("");
  $("#modal-preview").append('<embed src="'+url+'" frameborder="0" style="width: 100%; height: 70vh;">');
  $("#modal-name").text(name);
  $("#modal-size").text(size);
  $('#previewInfo').modal('toggle');
}
