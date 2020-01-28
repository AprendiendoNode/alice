$(function() {
  $('select').css('font-size', '11px');
  $('.datepickercomplete').datepicker({
    language: 'es',
    format: "yyyy-mm-dd",
    autoclose: true,
    clearBtn: true
  });
  $('.datepickercomplete').val('').datepicker('update');



  $('#date_start_cont').change(function(){
      var dateStart = $(this).val();
      var contando = $('.xf').length;
      var nomes= $('#sel_no_month').val();

      if (dateStart != '') {
        if (nomes != '') {
          var xmas = moment(dateStart, 'YYYY-MM-DD').add('months', nomes);
          var xmas2= moment(xmas).format('YYYY-MM-DD');
          $('input[name="date_end_cont_sist"]').val(xmas2);
        }
      }
      else {
        $('input[name="date_end_cont_sist"]').val('');
        $('#sel_no_month').val('').trigger('change');
      }
  });

  $("#sel_no_month").on('change',function(){
    var val = $(this).val();
    var dateStart= $('#date_start_cont').val();
    var contando = $('.xf').length;

    if ( val != '') {
      if (dateStart!=''){
        var xmas = moment(dateStart, 'YYYY-MM-DD').add('months', val);
        var xmas2= moment(xmas).format('YYYY-MM-DD');
        $('input[name="date_end_cont_sist"]').val(xmas2);


      }
      else{
        Swal.fire("Operación abortada!", "Ingresa una fecha de inicio. :(", "error");
        $('input[name="date_end_cont_sist"]').val('');
        $('#sel_no_month').val('').trigger('change');
      }
    }
    else {
      if (dateStart==''){
        Swal.fire("Operación abortada!", "Ingresa una fecha de inicio. :(", "error");
      }
      else{
        Swal.fire("Operación abortada!", "Selecciona un mes valido. :(", "error");
      }
    }
  });

  $("#Creatnewsite").validate({
      ignore: "input[type=hidden]",
      errorClass: "text-danger",
      successClass: "text-success",
      errorPlacement: function (error, element) {
        error.insertAfter(element);
      },
      rules: {
      },
      messages: {
      },
      // debug: true,
      // errorElement: "label",
      submitHandler: function(form){
        // swal("Operación abortada", "Ningúna operación afectuada, Ingrese la latitud y longitud :)", "error");
              Swal.fire({
              title: "Estás seguro?",
              text: "Se añadira este nuevo sitio al anexo.!",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Continuar.!",
              cancelButtonText: "Cancelar.!",
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
      }).then((result) => {
        if (result.value) {
          // The AJAX
          var form = $('#Creatnewsite')[0];
          var formData = new FormData(form);
          var idanexo =$('#sel_anexo option:selected').val();
          formData.append('id_anexo', idanexo);
          $.ajax({
            type: 'POST',
            url: "/addsiteanexocont",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
              datax = data;
              if (datax != '0') {
                $('#modal-Creatsite').modal('toggle');
                var id_contrat = $('#sel_anexo option:selected').val();
                // console.log(id_contrat);
                genTablesite(id_contrat);
                Swal.fire("Operación Completada!", ":)", "success");
              }
              else {
                $('#modal-Creatsite').modal('toggle');
                Swal.fire("Operación abortada", "Error al registrar intente otra vez :(", "error");
              }
            },
            error: function (data) {
              $('#modal-Creatsite').modal('toggle');
              $("#Creatnewsite")[0].reset();
              var validator = $( "#Creatnewsite" ).validate();
              validator.resetForm();
              Swal.fire("Operación abortada", "Ningúna operación afectuada :)", "error");
            }
          });
        }//ifresult
        else {
          Swal.fire("Operación abortada", "Ningúna operación afectuada :)", "error");
          $("#Creatnewsite")[0].reset();
          var validator = $( "#Creatnewsite" ).validate();
          validator.resetForm();
          $('#modal-CreatProduct').modal('toggle');
        }
      })
//---------------
      }
  });
});

function limpiar1_anexos1() {
  $("#sel_anexo_vertical option[value!='']").remove();
  $("#sel_anexo_cadenas option[value!='']").remove();
  $('input[name="key_anexo_verticals"]').val('');
  $('input[name="key_anexo_cadena"]').val('');
  $('input[name="key_anexo_contrato"]').val('');
  $('input[name="key_anexo_sitio"]').val('');
}

function limpiar2_anexo1() {
  $("#sel_anexo_cadenas option[value!='']").remove();
  $('input[name="key_anexo_cadena"]').val('');
  $('input[name="key_anexo_contrato"]').val('');
  $('input[name="key_anexo_sitio"]').val('');
}
function limpiar3_anexo1() {
  $("#sel_master_to_anexo option[value!='']").remove();
  $('input[name="key_anexo_sitio"]').val('');
}

$(".validation-wizard-anexo").on('click','.addcadenaanexo',function(){
    $('#modal_cadena').modal('show');
});


$(".validation-wizard-anexo").on('change','#sel_anexo_service',function(){
  var group = $(this).val();
  if (group != '') {
    $.ajax({
      type: "POST",
      url: "/idproy_search_key_one",
      data: { valor : group , _token : _token },
      success: function (data){
        datax = JSON.parse(data);
        $('input[name="key_anexo_service"]').val(datax[0].letter);
        $('#sel_anexo_vertical').val('').trigger('change');
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
    $.ajax({
         type: "POST",
         url: "/idproy_search_vertical_by_class",
         data: { valor : group , _token : _token },
         success: function (data){
           count_data = data.length;
           limpiar1_anexos1();
           if (count_data > 0) {
             $.each(JSON.parse(data),function(index, objdata){
               $('#sel_anexo_vertical').append('<option value="'+objdata.id+'">'+ objdata.name +'</option>');
             });
           }
         },
         error: function (data) {
           console.log('Error:', data);
         }
       });
  }
  else {
     limpiar1_anexos1();
     $('input[name="key_anexo_service"]').val('');
  }
});

$(".validation-wizard-anexo").on('change','#sel_anexo_vertical',function(){
  var group = $(this).val();
  if (group != '') {
    $.ajax({
      type: "POST",
      url: "/idproy_search_key_two",
      data: { valor : group , _token : _token },
      success: function (data){
        datax = JSON.parse(data);
        $('input[name="key_anexo_verticals"]').val(datax[0].key);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
    $.ajax({
      type: "POST",
      url: "/idproy_search_cadena_by_vert",
      data: { valor : group , _token : _token },
      success: function (data){
        count_data = data.length;
        limpiar2_anexo1();
        if (count_data > 0) {
          $.each(JSON.parse(data),function(index, objdata){
            $('#sel_anexo_cadenas').append('<option value="'+objdata.id+'">'+ objdata.cadena +'</option>');
          });
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
  else{
    limpiar2_anexo1();
    $('input[name="key_anexo_verticals"]').val('');
  }
});

$(".validation-wizard-anexo").on('change','#sel_anexo_cadenas',function(){
  $('#sel_anexo').empty().append('<option selected="selected" value="test">Elegir</option>');
  var group = $(this).val();
  if (group != '') {
    $.ajax({
      type: "POST",
      url: "/idproy_search_key_three",
      data: { valor : group , _token : _token },
      success: function (data){
        datax = JSON.parse(data);
        $('input[name="key_anexo_cadena"]').val(datax[0].key);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
    $.ajax({
      type: "POST",
      url: "/idproy_search_by_cadena",
      data: { valor : group , _token : _token },
      success: function (data){
        count_data = data.length;
        limpiar3_anexo1();
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
  }
  else {
    $('input[name="key_anexo_contrato"]').val('');
    $('input[name="key_anexo_cadena"]').val('');
    $('input[name="key_anexo_sitio"]').val('');
  }
});



/*
* Update anexos
*/

$(".validation-wizard-anexo").on('change','#sel_master_to_anexo',function(){
  var service = $("#sel_anexo_service").val();
  var vertical = $("#sel_anexo_vertical").val();
  var cadena = $("#sel_anexo_cadenas").val();
  var key = $("#sel_master_to_anexo").val();

  $('#sel_anexo').empty().append('<option selected="selected" value="test">Elegir</option>');
  get_ids_anexos(service, vertical, cadena, key);

});


$(".validation-wizard-anexo").on('change','#sel_anexo',function(){
  var id_contrat = $(this).val();
  // alert(id_contrat);
  genTablesite(id_contrat);
  get_data_anexos(id_contrat);
  getCommission(id_contrat);
  genTablecoin(id_contrat);
  getRfcSitesAnnexes(id_contrat);
});
function genTablesite(id_contract) {
  $.ajax({
      type: "POST",
      url: "/data_contractsite",
      data: { id_contract : id_contract , _token : _token },
      success: function (data){
        generate_site(data, $("#table_site"));
        var array=JSON.parse(data);
        get_switch(array[0]['vtc'],array[0]['venue'],array[0]['compartir_ingreso']);
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function get_switch(vtc,venue,comp_ingreso){

if(vtc==1){
        setSwitchery(switchery[0],true);
}else{
  setSwitchery(switchery[0],false);
}
if(venue==1){
        setSwitchery(switchery[1],true);
}else{
  setSwitchery(switchery[1],false);
}
if(comp_ingreso==1){
        setSwitchery(switchery[2],true);
}else{
  setSwitchery(switchery[2],false);
}


}

function getRfcSitesAnnexes(id_anexo){
	$('#rz_annexo').text('');
	$('#rfc_annexo').text('');
	$('#sitios_anexos').empty();
	if(id_anexo != ''){
		$.ajax({
			type: "POST",
			url: "/getRfcSitesAnnexes",
			data: { id_anexo : id_anexo , _token : _token },
			success: function (data){
				console.log(data);
				$('#rz_annexo').text(data[0].customers);
				$('#rfc_annexo').text(data[0].taxid);

				data.forEach(sitio => {
					$('#sitios_anexos').append(`<li>${sitio.Nombre_hotel}</li>`);
				  });

			},
			error: function (data) {
			  console.log('Error:', data);
			}
		});
	}

}


function generate_site(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable({
      "order": [[ 0, "asc" ]],
      paging: true,
      //"pagingType": "simple",
      Filter: true,
      searching: true,
      "select": true,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      //ordering: false,
      //"pageLength": 5,
      dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
        {
          text: '<i class="fa fa-plus margin-r5"></i> Añadir',
          titleAttr: 'Crear nueva asignación',
          className: 'btn btn-success creataddsite',
          init: function(api, node, config) {
             $(node).removeClass('btn-default')
          },
          action: function ( e, dt, node, config ) {
            $('#modal-Creatsite').modal('show');
            if (document.getElementById("Creatnewsite")) {
              $('#Creatnewsite')[0].reset();
            }
          }
        },
        {
          extend: 'excelHtml5',
          title: 'Sitios',
          init: function(api, node, config) {
             $(node).removeClass('btn-default')
          },
          text: '<i class="fa fa-file-excel-o margin-r5"></i> Excel',
          titleAttr: 'Excel',
          className: 'btn bg-olive custombtntable',
          exportOptions: {
              columns: [ 0, 1, 2]
          },
        },
        {
          extend: 'csvHtml5',
          title: 'Sitios',
          init: function(api, node, config) {
             $(node).removeClass('btn-default')
          },
          text: '<i class="fa fa-file-text-o margin-r5"></i> CSV',
          titleAttr: 'CSV',
          className: 'btn btn-info',
          exportOptions: {
              columns: [ 0, 1, 2]
          },
        }
      ],
      language:{
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_",
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
    }
  );
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, data){
    vartable.fnAddData([
        data.contract_sites_id,
        data.cadena,
        data.sitio,
        data.id_ubicacion,
        '<a href="javascript:void(0);" onclick="deletesite(this)" value="'+data.contract_sites_id+'" class="btn btn-danger btn-xs" role="button" title="Eliminar"><span class="fa fa-trash"></span></a>',
      ]);
  });
}

function editsite(e){
  var valor= e.getAttribute('value');
  $.ajax({
    type: "POST",
    url: "/data_editcontractsite",
    data: { id : valor , _token : _token },
    success: function (data){
      datax = JSON.parse(data);
      $('#cadena_edit').val(datax[0].cadena_id).trigger('change');
      $('#site_edit').val(datax[0].hotel_id).trigger('change');
      $('#id_ubicacion_edit').val(datax[0].id_ubicacion);
      $('#modal_edit_site').modal('show');
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

//cadena add
$('#cadena_add').on('change', function(e){
  var id= $(this).val();
  $.ajax({
    type: "POST",
    url: "/idproy_search_hotel_by_cadena",
    data: { valor : id , _token : _token },
    success: function (data){
      count_data = data.length;
      $('#site_add option[value!=""]').remove();
      if (count_data > 0) {
        $.each(JSON.parse(data),function(index, objdata){
          $('#site_add').append('<option value="'+objdata.id+'">'+ objdata.sitio +'</option>');
        });
        $('#id_ubicacion_add').val('');
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
});
$('#site_add').on('change', function(e){
  var id= $(this).val();
  // alert(id);
  $.ajax({
    type: "POST",
    url: "/search_idubicacion",
    data: { valor : id , _token : _token },
    success: function (data){
      datax = JSON.parse(data);
      if (datax[0].id_ubicacion !== null) {
        $('#id_ubicacion_add').val(datax[0].id_ubicacion);
      }
      else {
        $('#id_ubicacion_add').val('No Disponible');
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
});

function deletesite(e){
  var valor= e.getAttribute('value');
  // console.log(valor);
      Swal.fire({
        title: "Estás seguro?",
        text: "Espere mientras realiza la operación. Aparecera una ventana de dialogo al terminar.!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Continuar.!",
        cancelButtonText: "Cancelar.!",
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/delete_hotel_anexo",
          data: { valor : valor , _token : _token },
          success: function (data){
            datax = JSON.parse(data);
            if (datax[0].resultado == 1) {
              var id_contrat = $('#sel_anexo option:selected').val();
              genTablesite(id_contrat);
              Swal.fire("Operación success", "Cambio efectuado :)", "success");
            }
            else{
              Swal.fire("Operación abortada", "Problema de conexión :(", "error");
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
      }//if result.value
      else
      {
        Swal.fire("Operación abortada", "Ningúna cambio efectuado :)", "error");
      }
    })
  //------------
}

function get_ids_anexos(service, vertical, cadena, key){

  $.ajax({
    type: "POST",
    url: "/get_ids_contract_anexo",
    data: { id_service : service, id_vertical : vertical , id_cadena : cadena, key : key ,  _token : _token },
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

// Obteniendo datos del anexo

function get_data_anexos(id_contract){
  $.ajax({
    type: "POST",
    url: "/get_data_anexos",
    data: { id_contract : id_contract , _token : _token },
    success: function (data){
      var key = $("#sel_anexo option:selected").text();
      console.log(key);
      $("input[name='key_anexo_contrato']").val(key.charAt(8));
      $("input[name='key_anexo_sitio']").val(key.charAt(10));

      var month_select = document.getElementById("sel_no_month");
      var option_month;
      var itc_select = document.getElementById("sel_itconcierge");
      var option_itc;
      var executive_select = document.getElementById("sel_business_executive");
      var option_executive;
      var status_select = document.getElementById("sel_estatus_anexo");
      var option_status;

      var unit_select = document.getElementById("sel_unitmeasure");
      var option_unit_select;

      var prodsat_select = document.getElementById("sel_satproduct");
      var option_prodsat_select;

      var payterm_select = document.getElementById("payment_term_id");
      var option_payterm_select;

      var payway_select = document.getElementById("payment_way_id");
      var option_payway_select;

      var paymethod_select = document.getElementById("payment_method_id");
      var option_paymethod_select;

      var cfdi_select = document.getElementById("cfdi_use_id");
      var option_cfdi_select;


      $("#description_fact").val(data[0].description_fact);

      $("#contract_signature_date").val(data[0].date_signature);
      $("#date_start_cont").val(data[0].date_scheduled_start);
      $("#date_end_cont_sist").val(data[0].date_scheduled_end);
      $("#contract_real_date").val(data[0].date_real);

      // $("#edit_num_vto").val(data[0].number_expiration);

      // Setting unitMeasure
      for (var i=0; i < unit_select.options.length; i++) {
          option_unit_select = unit_select.options[i];
          if (option_unit_select.value == data[0].unit_measure_id) {
              option_unit_select.setAttribute('selected', true);
          }else{
              option_unit_select.removeAttribute('selected');
          }
      }
      // Setting satProduct
      for (var i=0; i < prodsat_select.options.length; i++) {
          option_prodsat_select = prodsat_select.options[i];
          if (option_prodsat_select.value == data[0].sat_product_id) {
              option_prodsat_select.setAttribute('selected', true);
          }else{
              option_prodsat_select.removeAttribute('selected');
          }
      }
      // Setting satPaymentterm
      for (var i=0; i < payterm_select.options.length; i++) {
          option_payterm_select = payterm_select.options[i];
          if (option_payterm_select.value == data[0].payment_term_id) {
              option_payterm_select.setAttribute('selected', true);
          }else{
              option_payterm_select.removeAttribute('selected');
          }
      }
      // Setting satPaymentway
      for (var i=0; i < payway_select.options.length; i++) {
          option_payway_select = payway_select.options[i];
          if (option_payway_select.value == data[0].payment_way_id) {
              option_payway_select.setAttribute('selected', true);
          }else{
              option_payway_select.removeAttribute('selected');
          }
      }
      // Setting satPaymentmethod
      for (var i=0; i < paymethod_select.options.length; i++) {
          option_paymethod_select = paymethod_select.options[i];
          if (option_paymethod_select.value == data[0].payment_method_id) {
              option_paymethod_select.setAttribute('selected', true);
          }else{
              option_paymethod_select.removeAttribute('selected');
          }
      }
      // Setting satCfdiuse
      for (var i=0; i < cfdi_select.options.length; i++) {
          option_cfdi_select = cfdi_select.options[i];
          if (option_cfdi_select.value == data[0].cfdi_user_id) {
              option_cfdi_select.setAttribute('selected', true);
          }else{
              option_cfdi_select.removeAttribute('selected');
          }
      }
      // setting number months
      for (var i=0; i < month_select.options.length; i++) {
          option_month = month_select.options[i];
          if (option_month.value == data[0].number_months) {
              option_month.setAttribute('selected', true);
          }else{
              option_month.removeAttribute('selected');
          }
      }
      // Setting ITC
      for (var i=0; i < itc_select.options.length; i++) {
          option_itc = itc_select.options[i];
          if (option_itc.value == data[0].itconcierge_id) {
              option_itc.setAttribute('selected', true);
          }else{
              option_itc.removeAttribute('selected');
          }
      }
      //Setting
      for (var i=0; i < executive_select.options.length; i++) {
          option_executive = executive_select.options[i];
          if (option_executive.value == data[0].business_user_id) {
              option_executive.setAttribute('selected', true);
          }else{
              option_executive.removeAttribute('selected');
          }
      }
      //Setting status contract
      for (var i=0; i < status_select.options.length; i++) {
          option_status = status_select.options[i];
          if (option_status.value == data[0].contract_status_id) {
              option_status.setAttribute('selected', true);
          }else{
              option_status.removeAttribute('selected');
          }
      }

    },
    error: function (data) {
      console.log('Error:', data);
    }
  });


}

//Actualizando anexos

var form_anexo = $(".validation-wizard-anexo").show();

$(".validation-wizard-anexo").steps({
    headerTag: "h6",
    bodyTag: "section",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: "Submit"
    },
    onStepChanging: function (event, currentIndex, newIndex) {
        return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form_anexo.find(".body:eq(" + newIndex + ") label.error").remove(), form_anexo.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form_anexo.validate().settings.ignore = ":disabled,:hidden", form_anexo.valid())
    },
    onFinishing: function (event, currentIndex) {
        return form_anexo.validate().settings.ignore = ":disabled", form_anexo.valid()
    },
    onFinished: function (event, currentIndex) {
      event.preventDefault();
        // swal("form_master Submitted!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.");

              Swal.fire({
                title: "Estás seguro?",
                text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Continuar.!",
                cancelButtonText: "Cancelar.!",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
      }).then((result) => {
        if (result.value) {
          var form = $('#validation_anexo')[0];
          var formData = new FormData(form);
          var digit = $("#sel_anexo option:selected").val();

          formData.append('digit', digit);
          formData.append('cont_vtc', cont_vtc);
          formData.append('cont_venue', cont_venue);
          formData.append('comp_ingreso', comp_ingreso);

          $.ajax({
            type: "POST",
            url: "/update_contract_anexo",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){

              if(data == "true"){

                let timerInterval;
                Swal.fire({
                  type: 'success',
                  title: 'Contrato anexo actualizado',
                  html: 'Se estan aplicando los cambios.',
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
                    window.location.href = "/cont_edit_cont";
                  }
                });


              }else{
                Swal.fire("Error al actualizar contrato", "", "error");
              }


            },
            error: function (data) {
              console.log('Error:', data);
              Swal.close();
            }

          })

        }//if result.value
        else {
          Swal.fire("Operación abortada", "Ningúna operación efectuada :)", "error");
        }
      })
      /************************************************************************************/

    }
}), $(".validation-wizard-anexo").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    highlight: function (element, errorClass) {
        $(element).removeClass(errorClass)
    },
    unhighlight: function (element, errorClass) {
        $(element).removeClass(errorClass)
    },
    errorPlacement: function (error, element) {
        var attr = $('[name="'+element[0].name+'"]').attr('datas');
        // console.log(element[0].name);
        // console.log(attr);
        // console.log($('[name="'+element[0].name+'"]'));

        if (element[0].id === 'fileInputAnexo') {
          error.insertAfter($('#cont_file_anexo'));
        }
        else {
          if(attr == 'tp_forma'){
            error.insertAfter($('#cont_tp'));
          }
          else if(attr == 'tp_valor'){
            error.insertAfter($('#cont_tp'));
          }
          else {
            error.insertAfter(element);
          }
        }
    },
    rules: {
        contact_email: {
          email: true
        },
        fileInputAnexo: {
          extension: 'pdf',
          filesize: 20000000
        },
        contact_telephone: {
          required: true,
          number: true,
          minlength: 7,
          maxlength: 10
        },
    },
    messages: {
            fileInput:{
                filesize:" file size must be less than 20 MB.",
                accept:"Please upload .pdf file of notice.",
                required:"Please upload file."
            }
    },
})

//COIN
function genTablecoin(id_contract) {
  $.ajax({
      type: "POST",
      url: "/data_contractcoin",
      data: { id_contract : id_contract , _token : _token },
      success: function (data){
        generate_coin(data, $("#table_coin"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function generate_coin(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable({
      "order": [[ 0, "asc" ]],
      paging: true,
      //"pagingType": "simple",
      Filter: true,
      searching: true,
      "select": true,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      //ordering: false,
      //"pageLength": 5,
      dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
        {
          text: '<i class="fa fa-plus margin-r5"></i> Añadir',
          titleAttr: 'Crear nueva monto',
          className: 'btn btn-success creataddcoin',
          init: function(api, node, config) {
             $(node).removeClass('btn-default')
          },
          action: function ( e, dt, node, config ) {
            $('#modal-Creatcoin').modal('show');
            if (document.getElementById("Creatnewcoin")) {
              $('#Creatnewcoin')[0].reset();
            }
          }
        },
        {
          extend: 'excelHtml5',
          title: 'Monedas',
          init: function(api, node, config) {
             $(node).removeClass('btn-default')
          },
          text: '<i class="fa fa-file-excel-o margin-r5"></i> Excel',
          titleAttr: 'Excel',
          className: 'btn bg-olive custombtntable',
          exportOptions: {
              columns: [ 0, 1, 2]
          },
        },
        {
          extend: 'csvHtml5',
          title: 'Monedas',
          init: function(api, node, config) {
             $(node).removeClass('btn-default')
          },
          text: '<i class="fa fa-file-text-o margin-r5"></i> CSV',
          titleAttr: 'CSV',
          className: 'btn btn-info',
          exportOptions: {
              columns: [ 0, 1, 2]
          },
        }
      ],
      language:{
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_",
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
    }
  );
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, data){
    vartable.fnAddData([
        data.id,
        data.quantity,
        data.currency,
        data.exchange_range,
        data.exchange_range_value,
        data.iva,
        data.descuento,
        `<a href="javascript:void(0);" onclick="modal_edit_coin(this)" value="${data.id}" class="btn btn-primary btn-xs" role="button" title="Editar"><span class="fas fa-edit"></span></a>
         <a href="javascript:void(0);" onclick="deletecoin(this)" value="${data.id}" class="btn btn-danger btn-xs ml-2" role="button" title="Eliminar"><span class="fa fa-trash"></span></a>`,
      ]);
  });
}

function operationadd(){
  var mensualidad = $('#mensualidad_add').val().replace(/,/g, ''),
      tipo_moneda = $('#moneda_add').val(),
tipo_forma_cambio = $('#formatcoption').val(),
      tipo_cambio = $('#formatcvalue').val(),
        descuento = $('#descuento_add').val(),
        monto_descuento = $('#monto_descuento_add').val(),
        monto_con_descuento = $('#monto_con_descuento_add').val(),
        valor_iva = $('#iva_add').val(),
        unir_iva = '1.'+valor_iva,
       mensconiva = 0;

       mensualidad = (mensualidad == null || mensualidad == undefined || mensualidad == "") ? 0 : mensualidad;
      tipo_cambio = (tipo_cambio == null || tipo_cambio == undefined || tipo_cambio == "") ? 0 : tipo_cambio;

    if(tipo_moneda == '1') {
      mensconiva = mensualidad * unir_iva;
      // $('[name="formatcoption"').val('2').trigger('change');
      $('input[name="formatcvalue"]').prop("readonly", true);
      $('input[name="formatcvalue"]').val('');
    }
    else {
      if(tipo_forma_cambio == ''){
        mensconiva = mensualidad * unir_iva;
        $('input[name="formatcvalue"]').prop("readonly", true);
        $('input[name="formatcvalue"]').val('');
      }
      if(tipo_forma_cambio == '1'){
        tranformar_tc = mensualidad * tipo_cambio;
        mensconiva = tranformar_tc * unir_iva;
      }
      if(tipo_forma_cambio == '2'){
        mensconiva = mensualidad * unir_iva;
        $('input[name="formatcvalue"]').prop("readonly", true);
        $('input[name="formatcvalue"]').val('');
      }
    }

    //Calculando descuento
    monto_descuento = (descuento * mensconiva) / 100;
    monto_con_descuento = parseFloat(mensconiva) - parseFloat(monto_descuento);

    $('#mensconiva_add').val(parseFloat(mensconiva).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#monto_descuento_add').val(parseFloat(monto_descuento).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#monto_con_descuento_add').val(parseFloat(monto_con_descuento).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

}

function operationedit(){
  var mensualidad = $('#mensualidad_edit').val().replace(/,/g, ''),
      tipo_moneda = $('#moneda_edit').val(),
tipo_forma_cambio = $('#formatcoption_edit').val(),
      tipo_cambio = $('#formatcvalue_edit').val(),
        valor_iva = $('#iva_edit').val(),
        descuento = $('#descuento_edit').val(),
        monto_descuento = $('#monto_descuento_edit').val(),
        monto_con_descuento = $('#monto_con_descuento_edit').val(),
        unir_iva = '1.'+valor_iva,
       mensconiva = 0;

       mensualidad = (mensualidad == null || mensualidad == undefined || mensualidad == "") ? 0 : mensualidad;
      tipo_cambio = (tipo_cambio == null || tipo_cambio == undefined || tipo_cambio == "") ? 0 : tipo_cambio;

    if(tipo_moneda == '1') {
      mensconiva = mensualidad * unir_iva;
      // $('[name="formatcoption"').val('2').trigger('change');
      $('input[name="formatcvalue_edit"]').prop("readonly", true);
      $('input[name="formatcvalue_edit"]').val('');
    }
    else {
      if(tipo_forma_cambio == ''){
        mensconiva = mensualidad * unir_iva;
        $('input[name="formatcvalue_edit"]').prop("readonly", true);
        $('input[name="formatcvalue_edit"]').val('');
      }
      if(tipo_forma_cambio == '1'){
        tranformar_tc = mensualidad * tipo_cambio;
        mensconiva = tranformar_tc * unir_iva;
      }
      if(tipo_forma_cambio == '2'){
        mensconiva = mensualidad * unir_iva;
        $('input[name="formatcvalue_edit"]').prop("readonly", true);
        $('input[name="formatcvalue_edit"]').val('');
      }
    }

    //Calculando descuento
    monto_descuento = (descuento * mensconiva) / 100;
    monto_con_descuento = parseFloat(mensconiva) - parseFloat(monto_descuento);

    $('#mensconiva_edit').val(parseFloat(mensconiva).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#monto_descuento_edit').val(parseFloat(monto_descuento).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#monto_con_descuento_edit').val(parseFloat(monto_con_descuento).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

}


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

/*
  **** EVENTOS ADD COIN  *****
*/

$("#mensualidad_add").on("keyup", function(event) {
  //Convertir formato pesos
  if (event.which >= 37 && event.which <= 40) {
      event.preventDefault();
  }
  var currentVal = this.value;
  var testDecimal = testDecimals(currentVal);
  if (testDecimal.length > 1) {
      currentVal = currentVal.slice(0, -1);
  }
  $(this).val(replaceCommas(currentVal));
  //---------------------------------------------------------------
  operationadd();
  //---------------------------------------------------------------
});

$("#moneda_add").on('change',function(){
  var change_coin = $(this).val();
  if (change_coin == '') {
    $('[name="formatcoption"').val('').trigger('change');
    $('input[name="formatcvalue"]').prop("readonly", true);
    $('input[name="formatcvalue"]').val('');
    operationadd();
  }
  else if (change_coin == '1') {
    // console.log(2);
    $('[name="formatcoption"').val('2').trigger('change');
    $('input[name="formatcvalue"]').prop("readonly", true);
    $('input[name="formatcvalue"]').val('');
    operationadd();
  }
  else{
    $('input[name="formatcvalue"]').prop("readonly", false);
    $('input[name="formatcvalue"]').val('');
    operationadd();
  }
      // operationadd();
});
$("#formatcoption").on('change',function(){
  var change_option = $(this).val();
  if (change_option == '' || change_option == '2') {
    $('input[name="formatcvalue"]').prop("readonly", true);
    $('input[name="formatcvalue"]').val('');
  }
  else {
    $('input[name="formatcvalue"]').prop("readonly", false);
    $('input[name="formatcvalue"]').val('');
  }
  operationadd();
});
$("#formatcvalue").on("keyup", function(event) {
  operationadd();
});
$("#iva_add").on('change',function(){
  operationadd();
});
$("#descuento_add").on('keyup',function(event){
  operationadd();
});

/*
  **** EVENTOS EDIT COIN  *****
*/

$("#mensualidad_edit").on("keyup", function(event) {
  //Convertir formato pesos
  if (event.which >= 37 && event.which <= 40) {
      event.preventDefault();
  }
  var currentVal = this.value;
  var testDecimal = testDecimals(currentVal);
  if (testDecimal.length > 1) {
      currentVal = currentVal.slice(0, -1);
  }
  $(this).val(replaceCommas(currentVal));
  //---------------------------------------------------------------
  operationedit();
  //---------------------------------------------------------------
});

$("#moneda_edit").on('change',function(){
  var change_coin = $(this).val();
  if (change_coin == '') {
    $('[name="formatcoption"').val('').trigger('change');
    $('input[name="formatcvalue_edit"]').prop("readonly", true);
    $('input[name="formatcvalue_edit"]').val('');
    operationedit();
  }
  else if (change_coin == '1') {
    // console.log(2);
    $('[name="formatcoption"').val('2').trigger('change');
    $('input[name="formatcvalue_edit"]').prop("readonly", true);
    $('input[name="formatcvalue_edit"]').val('');
    operationedit();
  }
  else{
    $('input[name="formatcvalue_edit"]').prop("readonly", false);
    $('input[name="formatcvalue_edit"]').val('');
    operationedit();
  }
      // operationadd();
});
$("#formatcoption_edit").on('change',function(){
  var change_option = $(this).val();
  if (change_option == '' || change_option == '2') {
    $('input[name="formatcvalue_edit"]').prop("readonly", true);
    $('input[name="formatcvalue_edit"]').val('');
  }
  else {
    $('input[name="formatcvalue_edit"]').prop("readonly", false);
    $('input[name="formatcvalue_edit"]').val('');
  }
  operationedit();
});
$("#formatcvalue_edit").on("keyup", function(event) {
  operationedit();
});
$("#iva_edit").on('change',function(){
  operationedit();
});
$("#descuento_edit").on('keyup',function(event){
  operationedit();
});


/** ******************************************************** */

$("#Creatnewcoin").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    errorPlacement: function (error, element) {
      error.insertAfter(element);
    },
    rules: {
    },
    messages: {
    },
    // debug: true,
    // errorElement: "label",
    submitHandler: function(form){
      // swal("Operación abortada", "Ningúna operación afectuada, Ingrese la latitud y longitud :)", "error");
      Swal.fire({
        title: "Estás seguro?",
        text: "Se añadira una nueva moneda al anexo.!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Continuar.!",
        cancelButtonText: "Cancelar.!",
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
      }).then((result) => {
        if (result.value) {
          // The AJAX
          var form = $('#Creatnewcoin')[0];
          var formData = new FormData(form);
          var idanexo =$('#sel_anexo option:selected').val();
          formData.append('id_anexo', idanexo);
          $.ajax({
            type: 'POST',
            url: "/addcoinanexocont",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
              //console.log(data);
              datax = data;
              if (datax != '0') {
                $('#modal-Creatcoin').modal('toggle');
                var id_contrat = $('#sel_anexo option:selected').val();
                genTablecoin(id_contrat);
                Swal.fire("Operación Completada!", ":)", "success");
              }
              else {
                $('#modal-Creatcoin').modal('toggle');
                Swal.fire("Operación abortada", "Error al registrar intente otra vez :(", "error");
              }
            },
            error: function (data) {
              $('#modal-Creatcoin').modal('toggle');
              $("#Creatnewcoin")[0].reset();
              var validator = $( "#Creatnewcoin" ).validate();
              validator.resetForm();
              Swal.fire("Operación abortada", "Ningúna operación afectuada :)", "error");
            }
          });
        } //if result.value
        else {
          Swal.fire("Operación abortada", "Ningúna operación afectuada :)", "error");
          $("#Creatnewcoin")[0].reset();
          var validator = $( "#Creatnewcoin" ).validate();
          validator.resetForm();
          $('#modal-Creatcoin').modal('toggle');
        }
      })
      //------------------
    }
});

/**************************************************************************/
$("#Editnewcoin").validate({
  ignore: "input[type=hidden]",
  errorClass: "text-danger",
  successClass: "text-success",
  errorPlacement: function (error, element) {
    error.insertAfter(element);
  },
  rules: {
  },
  messages: {
  },
  // debug: true,
  // errorElement: "label",
  submitHandler: function(form){
    // swal("Operación abortada", "Ningúna operación afectuada, Ingrese la latitud y longitud :)", "error");
    Swal.fire({
      title: "Estás seguro?",
      text: "",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Continuar.!",
      cancelButtonText: "Cancelar.!",
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
    }).then((result) => {
      if (result.value) {
        // The AJAX
        var form = $('#Editnewcoin')[0];
        var formData = new FormData(form);
        var idanexo =$('#sel_anexo option:selected').val();
        formData.append('id_anexo', idanexo);
        $.ajax({
          type: 'POST',
          url: "/editcoinanexocont",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            //console.log(data);
            datax = data;
            if (datax != '0') {

              var id_contrat = $('#sel_anexo option:selected').val();
              genTablecoin(id_contrat);
              Swal.fire("Operación Completada!", ":)", "success");
            }
            else {
              Swal.fire("Operación abortada", "Error al registrar intente otra vez :(", "error");
            }
          },
          error: function (data) {
            Swal.fire("Operación abortada", "Ocurrio un error inesperado", "error");
          }
        });
      } //if result.value
      else {
        Swal.fire("Operación abortada", "Ningúna operación afectuada :)", "error");
        $("#Creatnewcoin")[0].reset();
        var validator = $( "#Creatnewcoin" ).validate();
        validator.resetForm();
        $('#modal-Creatcoin').modal('toggle');
      }
    })
    //------------------
  }
});

function deletecoin(e){
  var valor= e.getAttribute('value');
  Swal.fire({
    title: "Estás seguro?",
    text: "Espere mientras realiza la operación. Aparecera una ventana de dialogo al terminar.!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Continuar.!",
    cancelButtonText: "Cancelar.!",
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
  }).then((result) => {
    if (result.value) {
      $.ajax({
        type: "POST",
        url: "/delete_coin_anexo",
        data: { valor : valor , _token : _token },
        success: function (data){
          datax = JSON.parse(data);
          if (datax[0].resultado == 1) {
            var id_contrat = $('#sel_anexo option:selected').val();
            genTablecoin(id_contrat);
            Swal.fire("Operación success", "Cambio efectuado :)", "success");
          }
          else{
            Swal.fire("Operación abortada", "Problema de conexión :(", "error");
          }
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
    }//if result.value
    else{
      Swal.fire("Operación abortada", "Ningúna cambio efectuado :)", "error");
    }
  })
  //------------
}

function modal_edit_coin(e){
  var valor = e.getAttribute('value');
  $('#mensualidad_edit').val();
  $('#moneda_edit').val();
  $('#formatcoption_edit').val();
  $('#iva_edit').val();
  $('#descuento_edit').val();
  $('#monto_descuento_edit').val();
  $('#monto_sin_descuento_edit').val();

   $.ajax({
    type: "POST",
    url: "/getContractsPaymentsDataById",
    data: { id_coin : valor , _token : _token },
    success: function (data){
      $('#contract_payment_id').val(valor);
      $('#mensualidad_edit').val(data[0].quantity);
      $('#moneda_edit').val(data[0].currency_id).trigger('change');
      $('#formatcoption_edit').val(data[0].exchange_range_id).trigger('change');
      $('#iva_edit').val(data[0].iva).trigger('change');
      $('#descuento_edit').val(data[0].descuento);
      $('#monto_descuento_edit').val(data[0].monto_descuento);
      $('#monto_sin_descuento_edit').val(data[0].monto_sin_descuento);
      operationedit();
      $('#modal-Editcoin').modal('show');
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });

}
