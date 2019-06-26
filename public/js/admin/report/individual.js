Dropzone.autoDiscover = false;

$(function() {
  $(".select2").select2();

  $('.datepickermonth').datepicker({
    language: 'es',
    format: "yyyy-mm-dd",
    viewMode: "days",
    minViewMode: "days",
    endDate: '1m',
    autoclose: true,
    clearBtn: true
  });

  $('#month_upload_type').datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months",
    endDate: '-1m',
    autoclose: true,
    clearBtn: true
  });
  $('#month_upload_band').datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months",
    endDate: '-1m',
    autoclose: true,
    clearBtn: true
  });

  $('#month_comments').datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months",
    endDate: '-1m',
    autoclose: true,
    clearBtn: true
  });

  new Dropzone('#dropzone_client' ,{
    url: "/upload_client",
    paramName: 'phone_client',
    autoProcessQueue: false,
    acceptedFiles:'image/*',
    maxFilesize: 1,
    maxFiles: 1,
    addRemoveLinks: true,
    uploadMultiple: true,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    dictDefaultMessage: 'Arrastra la imagen para subirla',
    init: function() {
      var myDropzone = this;
      // this.on("addedfile", function(file) { menssage_toast('Mensaje', '4', 'Imagen cargada con exito' , '3000'); });
      // this.on("complete", function(file) {  myDropzone.removefile(file); });
      // this.on("errormultiple", function (file) { myDropzone.removefile(file); }););
      this.on("maxfilesexceeded", function(file){
        menssage_toast('Mensaje', '3', 'Se cambio la imagen anterior por la actual' , '3000');
        myDropzone.removeAllFiles();
        myDropzone.addFile(file);
      });
      this.on('error', function(file, response) {
        myDropzone.removeFile(file);
      });
      var submitImgClient = document.getElementById('cargarimgclient');
      submitImgClient.addEventListener("click", function(e) {
        // Make sure that the form isn't actually being sent.
        e.preventDefault();
        e.stopPropagation();
        myDropzone.processQueue();
      });
      //send all the form data along with the files:
      this.on("sendingmultiple", function(data, xhr, formData) {
          formData.append("select_one_type", $('#select_one_type').val());
          formData.append("month_upload_type", $("#month_upload_type").val());
      });
      this.on("successmultiple", function(files, response) {
        // Gets triggered when the files have successfully been sent.
        // Redirect user or notify of success
        if (response == '0') {
          myDropzone.removeAllFiles();
          menssage_toast('Mensaje', '2', 'Operation Abort - Este día ya fue capturado.' , '3000');
        }
        else {
          myDropzone.removeAllFiles();
          $('#form_img_upload_type')[0].reset();
          $('#select_one_type').prop('selectedIndex',0);
          $("#select_one_type").select2({placeholder: "Elija"});
          menssage_toast('Mensaje', '4', 'Imagen cargada con exito' , '3000');
        }
      });
    }
  });

  $('#generateimgtypeClear').on('click', function(){
    $('#select_one_type').val('').trigger('change');
    $('#month_upload_type').val('');
  });

  new Dropzone('#dropzone_band' ,{
    url: "/upload_banda",
    paramName: 'phone_band',
    autoProcessQueue: false,
    acceptedFiles:'image/*',
    maxFilesize: 1,
    maxFiles: 1,
    addRemoveLinks: true,
    uploadMultiple: true,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    dictDefaultMessage: 'Arrastra la imagen para subirla',
    init: function() {
      var myDropzone = this;
      // this.on("addedfile", function(file) { menssage_toast('Mensaje', '4', 'Imagen cargada con exito' , '3000'); });
      // this.on("complete", function(file) {  myDropzone.removefile(file); });
      // this.on("errormultiple", function (file) { myDropzone.removefile(file); }););
      this.on("maxfilesexceeded", function(file){
        menssage_toast('Mensaje', '3', 'Se cambio la imagen anterior por la actual' , '3000');
        myDropzone.removeAllFiles();
        myDropzone.addFile(file);
      });
      this.on('error', function(file, response) {
          myDropzone.removeFile(file);
      });
      var submitImgClient = document.getElementById('cargarimgband');
      submitImgClient.addEventListener("click", function(e) {
        // Make sure that the form isn't actually being sent.
        e.preventDefault();
        e.stopPropagation();
        myDropzone.processQueue();
      });
      //send all the form data along with the files:
      this.on("sendingmultiple", function(data, xhr, formData) {
          formData.append("select_one_band", $('#select_one_band').val());
          formData.append("month_upload_band", $("#month_upload_band").val());
      });
      this.on("successmultiple", function(files, response) {
        // Gets triggered when the files have successfully been sent.
        // Redirect user or notify of success
        if (response == '0') {
          myDropzone.removeAllFiles();
          menssage_toast('Mensaje', '2', 'Operation Abort - Este día ya fue capturado.' , '3000');
        }
        else {
          myDropzone.removeAllFiles();
          $('#form_img_band_upload')[0].reset();
          $('#select_one_band').prop('selectedIndex',0);
          $("#select_one_band").select2({placeholder: "Elija"});
          menssage_toast('Mensaje', '4', 'Imagen cargada con exito' , '3000');
        }
      });
    }
  });

});

$('#clearimgband').on('click', function(){
  $('#select_one_band').val('').trigger('change');
  $('#month_upload_band').val('');
});

$('#select_onet').on('change', function(){
  var _token = $('input[name="_token"]').val();
  var select1 = $('#select_onet').val();
  let dataselect = [];
  $('#select_two_zd').empty();
    $.ajax({
        type: "POST",
        url: "/get_zd_hotel",
        data: { _token : _token, select : select1 },
        success: function (data){
          //console.log(data);
          if (data && data.length) {
            //console.log('algo');
            dataselect.push({id : "", text : "Elija"});
            $.each(data, function(index, datos){
              dataselect.push({id: datos.id, text: datos.ip});
            });
            //console.log(dataselect);
            $('#select_two_zd').select2({
              data : dataselect
            });
          }else{
            //console.log('vacio');
            dataselect.push({id : "", text : "Elija"});
            dataselect.push({id : "0", text : "Default"});
            $('#select_two_zd').select2({
              data : dataselect
            });
          }
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
});

$('#generateGbInfo').on('click', function(e){
  var select1 = $('#select_onet').val();
  var select2 = $('#select_two_zd').val();
  var month = $('#month_trans_zd').val();
  var valuegb = $('#valorgb_trans').val();

  if (select1 === "" || select2 === "" || month === "" || valuegb.length === 0 || valuegb.length > 5) {
    menssage_toast('Mensaje', '2', 'LLene todos los campos correctamente.' , '3000');
    e.preventDefault();
  }else{
    //menssage_toast('Mensaje', '4', 'OK.' , '3000');
    gig_24();
  }

});

$('#generateGbClear').on('click', function(){
  clear_gb();
});

// function emptySelectZD() {
//   $('#select_two_zd').empty();
//   $('#select_two_zd').select2("destroy");
// }

function clear_gb() {
  $('#select_onet').val('').trigger('change');

  $('#select_two_zd').val('').trigger('change');

  $('#month_trans_zd').val('');
  $('#valorgb_trans').val('');
}

function clear_gb2() {
  //$('#select_onet').val('').trigger('change');

  //$('#select_two_zd').val('').trigger('change');

  $('#month_trans_zd').val('');
  $('#valorgb_trans').val('');
}

function gig_24() {
  var objData = $("#form_gb").find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/upload_gigs",
      data: objData,
      success: function (data){
        //console.log(data);
        if (data === "1") {
          clear_gb2();
          menssage_toast('Mensaje', '4', 'Datos del día insertados correctamente.' , '3000');
        }else{
          menssage_toast('Mensaje', '2', 'Este día ya fue capturado.' , '3000');
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

$('#generateUserInfo').on('click', function(e){
  var select = $('#select_one_device').val();

  var month = $('#month_device').val();
  var valueuser = $('#valor_users').val();

  if (select === "" || month === "" || valueuser.length === 0 || valueuser.length > 5) {
    menssage_toast('Mensaje', '2', 'LLene todos los campos correctamente.' , '3000');
    e.preventDefault();
  }else{
    //menssage_toast('Mensaje', '4', 'OK.' , '3000');
    device_authclient();
  }

});

$('#generateUserClear').on('click', function(){
  clear_user();
});

function clear_user() {
  $('#select_one_device').val('').trigger('change');
  $('#month_device').val('');
  $('#valor_users').val('');
}

function clear_user2() {
  //$('#select_one_device').val('').trigger('change');
  $('#month_device').val('');
  $('#valor_users').val('');
}

function device_authclient() {
  var objData = $("#form_device").find("select,textarea, input").serialize();

  $.ajax({
      type: "POST",
      url: "/upload_users",
      data: objData,
      success: function (data){
        //console.log(data);
        if (data === "1") {
          clear_user2();
          menssage_toast('Mensaje', '4', 'Datos del día insertados correctamente.' , '3000');
        }else{
          menssage_toast('Mensaje', '2', 'Este día ya fue capturado.' , '3000');
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

$('#generateComment').on('click', function(e){
  var select = $('#select_one_comments').val();

  var month = $('#month_comments').val();
  var comentario = $('#report_comment').val();

  if (select === "" || month === "" || comentario === '') {
    menssage_toast('Mensaje', '2', 'LLene todos los campos correctamente.' , '3000');
    e.preventDefault();
  }else{
    //menssage_toast('Mensaje', '4', 'OK.' , '3000');
    month_comment();
  }

});

$('#generateCommentClear').on('click', function(){
  clear_comments();
});

function month_comment() {
  var objData = $("#form_comments").find("select,textarea, input").serialize();

  $.ajax({
      type: "POST",
      url: "/upload_comments",
      data: objData,
      success: function (data){
        console.log(data);
        if (data === "1") {
          clear_user2();
          menssage_toast('Mensaje', '4', 'Datos del día insertados correctamente.' , '3000');
        }else{
          menssage_toast('Mensaje', '2', 'Este día ya fue capturado.' , '3000');
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function clear_comments() {
  $('#select_one_comments').val('').trigger('change');
  $('#month_comments').val('');
  $('#report_comment').val('');
}

function clear_comments2() {
  //$('#select_one_comments').val('').trigger('change');
  $('#month_comments').val('');
  $('#report_comment').val('');
}

function checkMAC(value) {
  let status = 0;
  let newstr = "";
  var parts = []
  valuestr = value.trim();
  countstr = valuestr.length;

  if (countstr === 17) {
    return status = 1;
  }else{
    return status;
  }
  return status;
}

function returnMAC(value) {
  //DBDBDBDBDBDB 5 espacios.
  //12 + 5 = 17
  //DB DB DB DB DB DB
  let status = 0;
  let newstr = "";
  var parts = []
  countstr = value.length;
  //console.log(value.length);
  if (countstr < 17) {
    parts = value.match(/[\s\S]{1,2}/g) || [];
    for (var i = 0; i < parts.length; i++) {
      newstr = newstr + parts[i] + ':';
    }
    //console.log(newstr);
    newstr = newstr.substr(0, newstr.length - 1);
    //console.log(newstr);
    return status = 1;
  }else if (countstr === 17) {
    return status = 1;
  }else{
    //console.log('string > 17');
    return status;
  }
  return status;
  // count = parts.length;
  // console.log(parts);
  // console.log(count);
}

$('#generateapsInfo').on('click', function(){
  //console.log('click');
  //form_aps
  let select_ap = $('#select_three').val();
  let fecha_aps = $('#fecha_aps').val();

  let mac1 = $('#mac1').val();
  let modelo1 = $('#modelo1').val();
  let cliente1 = $('#cliente1').val();
  let mac2 = $('#mac2').val();
  let modelo2 = $('#modelo2').val();
  let cliente2 = $('#cliente2').val();
  let mac3 = $('#mac3').val();
  let modelo3 = $('#modelo3').val();
  let cliente3 = $('#cliente3').val();
  let mac4 = $('#mac4').val();
  let modelo4 = $('#modelo4').val();
  let cliente4 = $('#cliente4').val();
  let mac5 = $('#mac5').val();
  let modelo5 = $('#modelo5').val();
  let cliente5 = $('#cliente5').val();

  //console.log(select_ap);
  //console.log(checkMAC(mac1));

  if (select_ap === '' || fecha_aps === '' ||
      mac1 === '' || modelo1 === '' || cliente1 === '' ||
      mac2 === '' || modelo2 === '' || cliente2 === '' ||
      mac3 === '' || modelo3 === '' || cliente3 === '' ||
      mac4 === '' || modelo4 === '' || cliente4 === '' ||
      mac5 === '' || modelo5 === '' || cliente5 === '')
  {
    menssage_toast('Mensaje', '2', 'Complete todos los campos correctamente.' , '3000');
  }else{
    if (checkMAC(mac1) && checkMAC(mac2) && checkMAC(mac3) && checkMAC(mac4) && checkMAC(mac5)) {
      //DBDBDBDBDBDB
      //DB:DB:DB:DB:DB:DB
      // Todo en orden... Insertar...
      //console.log('bien');
      top_five_ap();
    }else{
      menssage_toast('Mensaje', '2', 'Captura la MAC correctamente.' , '3000');
      //console.log('mal');
    }
  }
});


$('#generateapsClear').on('click', function(){
  clear_mostap();
});

function clear_mostap() {
  $('#select_three').val('').trigger('change');

  $('#fecha_aps').val('');
  $('#mac1').val('');
  $('#modelo1').val('');
  $('#cliente1').val('');
  $('#mac2').val('');
  $('#modelo2').val('');
  $('#cliente2').val('');
  $('#mac3').val('');
  $('#modelo3').val('');
  $('#cliente3').val('');
  $('#mac4').val('');
  $('#modelo4').val('');
  $('#cliente4').val('');
  $('#mac5').val('');
  $('#modelo5').val('');
  $('#cliente5').val('');

}

function clear_mostap2() {
  //$('#select_three').val('').trigger('change');
  $('#fecha_aps').val('');
  $('#mac1').val('');
  $('#modelo1').val('');
  $('#cliente1').val('');
  $('#mac2').val('');
  $('#modelo2').val('');
  $('#cliente2').val('');
  $('#mac3').val('');
  $('#modelo3').val('');
  $('#cliente3').val('');
  $('#mac4').val('');
  $('#modelo4').val('');
  $('#cliente4').val('');
  $('#mac5').val('');
  $('#modelo5').val('');
  $('#cliente5').val('');
}

function top_five_ap() {
  var objData = $("#form_aps").find("select,textarea, input").serialize();

  $.ajax({
      type: "POST",
      url: "/upload_mostap",
      data: objData,
      success: function (data){
      //console.log(data);
        if (data === "1") {
          clear_mostap2();
          menssage_toast('Mensaje', '4', 'Datos del día insertados correctamente.' , '3000');
        }else{
          menssage_toast('Mensaje', '2', 'Este día ya fue capturado.' , '3000');
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

$('#generatewlanClear').on('click', function(){
  clear_mostwlan();
});

$('#generatewlanInfo').on('click', function(){
  //console.log('click');
  //form_aps
  let select_wlan = $('#select_four').val();
  let fecha_wlan = $('#fecha_nwlan').val();

  let nombrew1 = $('#nombrew1').val();
  let clientew1 = $('#clientew1').val();

  // let nombrew2 = $('#nombrew2').val();
  // let clientew2 = $('#clientew2').val();

  // let nombrew3 = $('#nombrew3').val();
  // let clientew3 = $('#clientew3').val();

  // let nombrew4 = $('#nombrew4').val();
  // let clientew4 = $('#clientew4').val();

  // let nombrew5 = $('#nombrew5').val();
  // let clientew5 = $('#clientew5').val();

  if (select_wlan === '' || fecha_wlan === '' ||
      nombrew1 === '' || clientew1 === '')
  {
    menssage_toast('Mensaje', '2', 'Complete todos los campos correctamente.' , '3000');
  }else{
    //menssage_toast('Mensaje', '4', 'Correcto.' , '3000');
    top_five_wlan();
  }
});

function clear_mostwlan() {
  $('#select_four').val('').trigger('change');

  $('#fecha_nwlan').val('');

  $('#nombrew1').val('');
  $('#clientew1').val('');

  $('#nombrew2').val('');
  $('#clientew2').val('');

  $('#nombrew3').val('');
  $('#clientew3').val('');

  $('#nombrew4').val('');
  $('#clientew4').val('');

  $('#nombrew5').val('');
  $('#clientew5').val('');
}

function clear_mostwlan2() {
  //$('#select_four').val('').trigger('change');

  $('#fecha_nwlan').val('');

  $('#nombrew1').val('');
  $('#clientew1').val('');

  $('#nombrew2').val('');
  $('#clientew2').val('');

  $('#nombrew3').val('');
  $('#clientew3').val('');

  $('#nombrew4').val('');
  $('#clientew4').val('');

  $('#nombrew5').val('');
  $('#clientew5').val('');
}

function top_five_wlan() {
  var objData = $("#form_wlan").find("select,textarea, input").serialize();

  $.ajax({
      type: "POST",
      url: "/upload_mostwlan",
      data: objData,
      success: function (data){
        console.log(data);
        if (data === "1") {
          //clear_mostwlan2();
          menssage_toast('Mensaje', '4', 'Datos del día insertados correctamente.' , '3000');
        }else{
          menssage_toast('Mensaje', '2', 'Este día ya fue capturado.' , '3000');
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });

}
