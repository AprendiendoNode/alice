$(function () {
  //Create New PAC
  $('#creatnewpac').formValidation({
   framework: 'bootstrap',
   excluded: ':disabled',
   fields: {
     name: {
       validators: {
         notEmpty: {
           message: 'El campo es obligatorio'
         }
       }
     },
     code: {
       validators: {
         notEmpty: {
           message: 'El campo es obligatorio'
         }
       }
     },
     ws_url: {
       validators: {
         notEmpty: {
           message: 'El campo es obligatorio'
         }
       }
     },
     username: {
       validators: {
         notEmpty: {
           message: 'El campo es obligatorio'
         }
       }
     },
     password: {
       validators: {
         notEmpty: {
           message: 'El campo es obligatorio'
         }
       }
     },
   }
  })
  .on('success.form.fv', function(e) {
     e.preventDefault();
     var form = $('#creatnewpac')[0];

  });
});
function resetFormPac() {
  $(".check-change").text('');
  $("#creatnewpac")[0].reset();
  $('#creatnewpac').data('formValidation').resetForm($('#creatnewpac'));
}

$(".pac").on("click", function () {
  resetFormPac();
});

//Table PAC
function get_info_pacs() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: "/pacs_show",
      data: { _token : _token },
      success: function (data){
        table_pacs(data, $("#all_registered_pac"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function table_pacs(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_classification);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    var badge_test = '<span class="badge badge-success badge-pill text-uppercase text-white"><i class="fas fa-check-square"></i></span>';
    if (status.test) {
        badge_test = '<span class="badge badge-danger badge-pill text-uppercase text-white"><i class="fas fa-times"></i></span>';
    }
    var badge_status = '<span class="badge badge-success badge-pill text-uppercase text-white">Habilitado</span>';
    if (status.status) {
        badge_status = '<span class="badge badge-danger badge-pill text-uppercase text-white">Inhabilitado</span>';
    }
    vartable.fnAddData([
      status.name,
      status.code,
      status.ws_url,
      status.username,
      badge_test,
      badge_status,
      '<a href="javascript:void(0);" onclick="editar_work(this)" class="btn btn-primary  btn-sm" value="'+status.id+'"><i class="fas fa-pencil-alt btn-icon-prepend fastable"></i></a><a href="javascript:void(0);" onclick="destroy_work(this)" class="btn btn-danger btn-sm" value="'+status.id+'"><i class="fas fa-trash btn-icon-prepend fastable"></i></a>'
    ]);
  });
}
