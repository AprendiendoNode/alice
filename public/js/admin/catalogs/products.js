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
  });

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
      information.name,
      information.code,
      information.model,
      information.manufacturer,
      information.unit_measure,
      information.sat_product,
      information.sort_order,
      '<span class="badge badge-secondary badge-pill text-uppercase text-white">'+information.status_name+'</span>',
      badge,
      '<a href="javascript:void(0);" onclick="edit_product(this)" class="btn btn-primary  btn-sm" value="'+information.id+'"><i class="fas fa-pencil-alt btn-icon-prepend fastable"></i></a>'
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
       data: { xy : valor, _token : _token},
       success: function (data) {
         var datosJ = JSON.parse(data);
         $('#inputEditkey').val(datosJ[0].codigo);
         $('#inputEditpart').val(datosJ[0].num_parte);
         $('#inputEditname').val(datosJ[0].descripcion);
         $('#inputEditcoindefault').val(datosJ[0].precio);

         $('[name="editsel_modal_coin"]').val(datosJ[0].currency_id).trigger('change');
         $('[name="editsel_modal_proveedor"]').val(datosJ[0].proveedor_id).trigger('change');
         $('[name="edit_sel_categoria"]').val(datosJ[0].categoria_id).trigger('change');
         $('[name="edit_sel_modelo"]').val(datosJ[0].modelo_id).trigger('change');
         $('[name="edit_sel_estatus"]').val(datosJ[0].status_id).trigger('change');
         $('#edit_img_preview').attr("src", 'images/storage/'+datosJ[0].img);
         $('input.dodoo').val('');

       },
       error: function (data) {
         alert('Error:', data);
       }
   })
}
