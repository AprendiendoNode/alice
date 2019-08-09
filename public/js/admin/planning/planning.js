$(function () {
   management_products();
});

function management_products() {
  var _token = $('input[name="_token"]').val();
  $.ajax({
      type: "POST",
      url: "/product_management_r",
      data: { _token : _token },
      success: function (data){
        table_management_products(data, $("#table_manag_products"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function table_management_products(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_product);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    vartable.fnAddData([
      status.codigo,
      status.modelo,
      status.descripcion,
      status.categoria,
      status.proveedor,
      status.precio,
      status.currency,
      status.status,
      '<a href="javascript:void(0);" onclick="enviar_edit(this)" value="'+status.id+'" class="btn btn-info btn-xs" role="button" data-target="#editprod"><i class="fa fa-pencil-square-o margin-r5"></i></a> ',
    ]);
  });
}

var Configuration_table_responsive_product= {
  dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        text: '<i class="fa fa-plus margin-r5"></i> Nuevo producto',
        titleAttr: 'Nuevo producto',
        className: 'btn btn-success creataddproduct',
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        action: function ( e, dt, node, config ) {
          $('#modal-CreatProduct').modal('show');
          if (document.getElementById("creatproductsystem")) {
            $("#creatproductsystem")[0].reset();
            var validator = $( "#creatproductsystem" ).validate();
            validator.resetForm();
            $('#img_preview').attr("src",'images/hotel/Default.svg');

          }
        }
      },
      {
        text: '<i class="fa fa-plus margin-r5"></i> Nuevo Marca',
        titleAttr: 'Nuevo Marca',
        className: 'btn btn-success addmarca',
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        action: function ( e, dt, node, config ) {
          $('#modal-CreatMarca').modal('show');
          if (document.getElementById("creatmodelmarca")) {
            $('#creatmodelmarca')[0].reset();
            $('#creatmodelmarca').data('formValidation').resetForm();
          }
        }
      },
      {
        extend: 'excelHtml5',
        title: 'Export of user data',
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
        title: 'Export of user data',
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


function enviar_edit(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  $('#modal-Editprod').modal('show');
  $('#fsd').val(valor);
  $.ajax({
       type: "POST",
       url: '/product_management_e',
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
