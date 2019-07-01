$(function () {

});

function get_info_company(){
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: "/base/companies-show",
      data: { _token : _token },
      success: function (data){
      
      },
      error: function (data) {
        console.log('Error:', data.statusText);
      }
  });
}
