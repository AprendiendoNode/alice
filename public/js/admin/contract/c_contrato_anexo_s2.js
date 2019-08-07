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

$(function() {
  $('select').css('font-size', '11px');
  $('.datepickercomplete').datepicker({
    language: 'es',
    format: "yyyy-mm-dd",
    autoclose: true,
    clearBtn: true
  });
  $('.datepickercomplete').val('').datepicker('update');

  createEvent_Mensualidad (0);
  createEvent_Moneda(0);
  createEvent_Optc(0);
  createEvent_tc(0);
  createEvent_iva(0);
  createEvent_checkiva(0);

  $('#date_start_cont').change(function(){
      var dateStart = $(this).val();
      var contando = $('.xf').length;
      var nomes= $('#sel_no_month').val();

      if (dateStart != '') {
        if (nomes != '') {
          var xmas = moment(dateStart, 'YYYY-MM-DD').add('months', nomes);
          var xmas2= moment(xmas).format('YYYY-MM-DD');
          $('input[name="date_end_cont_sist"]').val(xmas2);

          for (var i = 0; i < $('.xf').length; i++) {
            if($('input[name="c_price[' + i + '].price"]').length){
              mensualidad_data(i, nomes);
            }
          }
        }
      }
      else {
        $('input[name="date_end_cont_sist"]').val('');
        $('#sel_no_month').val('').trigger('change');
        for (var i = 0; i < $('.xf').length; i++) {
           $('input[name="c_price[' + i + '].price"]').val('');
                 $('[name="c_coin[' + i + '].coin"]').val('').trigger('change');
             $('[name="c_tcambopt[' + i + '].tcambopt"]').val('').trigger('change');
               $('[name="c_valiva[' + i + '].valiva"]').val('16').trigger('change');
           $('input[name="c_tcamb[' + i + '].tcamb"]').val('');
           $('input[name="c_tcamb[' + i + '].tcamb"]').prop("readonly", true);
             $('[name="c_montoiva[' + i + '].montoiva"]').val('');
              $('[name="c_vtcreal[' + i + '].vtcreal"]').val('');
           $('[name="c_vtcdinamic[' + i + '].vtcdinamic"]').val('');
        }

      }
  });

});


function createEvent_Mensualidad (id) {
  const element = document.querySelector('[name="c_price['+id+'].price"]')
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
    //-----------------------
    var vtc_real = 0,
      vtc_dinamico = 0,
      iva = 0,
      iva_info = 0,
      tipo_forma_cambio = 0,
      tipo_cambio = 0,
      tipo_moneda = 0,
      mensualidad = this.value.replace(/,/g, ''),
      total_meses = 0,
      tranformar_tc = 0,
      unir_iva= 0;
      tranformar_iva = 0,
      mensualidad_civa = 0,
      total_vtc_d = 0,
      tranformar_vtcdinamic_iva = 0;

      var dateNow = moment().format('YYYY-MM-DD');
      var dateEnd= $('#date_end_cont_sist').val();
      var mesesVTCdinac = moment(dateEnd, 'YYYY-MM-DD').diff(dateNow, 'months');

      tipo_moneda = $('select[name="c_coin[' + id + '].coin"]').val();
      tipo_forma_cambio = $('select[name="c_tcambopt[' + id + '].tcambopt"]').val();
      tipo_cambio = $('[name="c_tcamb['+id+'].tcamb"]').val();
      iva = $('select[name="c_valiva[' + id + '].valiva"]').val();
      unir_iva = '1.'+iva;
      total_meses = $( "#sel_no_month" ).val();

      tipo_cambio = (tipo_cambio == null || tipo_cambio == undefined || tipo_cambio == "") ? 0 : tipo_cambio;

      if(tipo_forma_cambio == ''){
        tipo_cambio = 0;
        tranformar_tc = mensualidad * tipo_cambio;
        total = tranformar_tc * total_meses;
        total_vtc_d = tranformar_tc * mesesVTCdinac;
        $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
      }
      if(tipo_forma_cambio == '1'){
        if (tipo_moneda == '1'){
          tipo_cambio = 0;
          total = mensualidad * total_meses;
          total_vtc_d = mensualidad * mesesVTCdinac;

          $('[name="c_tcambopt['+id+'].tcambopt"]').val('2').trigger('change');
          $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
        }
        else {
          tranformar_tc = mensualidad * tipo_cambio;
          total = tranformar_tc * total_meses;
          total_vtc_d = tranformar_tc * mesesVTCdinac;

        }
      }
      if(tipo_forma_cambio == '2'){
        tipo_cambio = 0;
        total = mensualidad * total_meses;
        total_vtc_d = mensualidad * mesesVTCdinac;
        $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
      }
      if(  $('[name="c_checkiva['+id+'].checkiva"]').is(':checked') ) {
        // console.log('checked');
        $('[name="c_valiva['+id+'].valiva"]').val('0').trigger('change');
        tranformar_iva = total;
        mensualidad_civa = mensualidad;
        tranformar_vtcdinamic_iva = total_vtc_d;
        if (tranformar_vtcdinamic_iva < 0) {
          tranformar_vtcdinamic_iva = 0;
        }
      }
      else {
        // console.log('unchecked');
        mensualidad_civa = mensualidad*unir_iva;
        tranformar_iva = total*unir_iva;
        tranformar_vtcdinamic_iva = total_vtc_d;
        if (tranformar_vtcdinamic_iva < 0) {
          tranformar_vtcdinamic_iva = 0;
        }
      }
      // console.log(mesesVTCdinac);
      $('[name="c_tcamb['+id+'].tcamb"]').val(tipo_cambio);

      $('[name="c_montoiva['+id+'].montoiva"]').val(parseFloat(mensualidad_civa).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
      $('[name="c_vtcreal['+id+'].vtcreal"]').val(total.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
      $('[name="c_vtcdinamic['+id+'].vtcdinamic"]').val(tranformar_vtcdinamic_iva.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  });
}

function createEvent_Moneda(id){
  const element = document.querySelector('[name="c_coin['+id+'].coin"]')
  element.addEventListener('change', function() {
    var tipo_moneda = this.value,
        contar_select = $('.coin').length,
        operation_xyz=0,
        donde_toy = $(this).attr('name'),
        id_donde_toy = donde_toy.match(/\d+/);

    var vtc_real = 0,
        vtc_dinamico = 0,
        iva = 0,
        iva_info = 0,
        tipo_forma_cambio = 0,
        tipo_cambio = 0,
        mensualidad = 0,
        total_meses = 0,
        tranformar_tc = 0,
        unir_iva= 0;
        tranformar_iva = 0,
        mensualidad_civa = 0,
        total_vtc_d = 0,
        tranformar_vtcdinamic_iva = 0;

        if (tipo_moneda != '') {
          for (var i = 0; i < contar_select; i++) {
            var val_rec = $('select[name="c_coin[' + i + '].coin"]').val();
            var posicion = 'c_coin[' + i + '].coin';
            if (donde_toy != posicion) {
              if (tipo_moneda === val_rec) {
                $(this).val('').trigger('change');
                $('[name="c_tcambopt[' + id_donde_toy + '].tcambopt"]').val('').trigger('change');
                $('[name="c_valiva[' + id_donde_toy + '].valiva"]').val('16').trigger('change');
                $('input[name="c_tcamb[' + id_donde_toy + '].tcamb"]').val('');
                $('input[name="c_tcamb[' + id_donde_toy + '].tcamb"]').prop("readonly", true);
                $('[name="c_montoiva[' + id_donde_toy + '].montoiva"]').val('');
                $('[name="c_vtcreal[' + id_donde_toy + '].vtcreal"]').val('');
                $('[name="c_vtcdinamic[' + id_donde_toy + '].vtcdinamic"]').val('');
                console.log('coinciden');
                swal("Operación abortada", "No puedes repetir una modena ya seleccionada  :(", "error");
              }
              else {
                //--------------------------------------------------------------------------------------------------------------------------
                var dateNow = moment().format('YYYY-MM-DD');
                var dateEnd= $('#date_end_cont_sist').val();
                var mesesVTCdinac = moment(dateEnd, 'YYYY-MM-DD').diff(dateNow, 'months');

                mensualidad = $('input[name="c_price[' + id + '].price"]').val().replace(/,/g, '');
                tipo_forma_cambio = $('select[name="c_tcambopt[' + id + '].tcambopt"]').val();
                tipo_cambio = $('[name="c_tcamb['+id+'].tcamb"]').val();
                iva = $('select[name="c_valiva[' + id + '].valiva"]').val();
                total_meses = $( "#sel_no_month" ).val();
                unir_iva = '1.'+iva;
                tipo_moneda = $('select[name="c_coin[' + id + '].coin"]').val();

                mensualidad = (mensualidad == null || mensualidad == undefined || mensualidad == "") ? 0 : mensualidad;
                tipo_cambio = (tipo_cambio == null || tipo_cambio == undefined || tipo_cambio == "") ? 0 : tipo_cambio;
                total_meses = (total_meses == null || total_meses == undefined || total_meses == "") ? 0 : total_meses;
                if (tipo_moneda === '1'){
                  console.log('Pa1');
                  tipo_cambio = 0;
                  total = mensualidad * total_meses;
                  total_vtc_d = mensualidad * mesesVTCdinac;
                  $('[name="c_tcambopt['+id+'].tcambopt"]').val('2').trigger('change');
                  $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
                }
                else{
                  if(tipo_forma_cambio == ''){
                    tipo_cambio = 0;
                    tranformar_tc = mensualidad * tipo_cambio;
                    total = tranformar_tc * total_meses;
                    total_vtc_d = tranformar_tc * mesesVTCdinac;
                    $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
                  }
                  if(tipo_forma_cambio == '1'){
                    if (tipo_moneda == '1'){
                      tipo_cambio = 0;
                      total = mensualidad * total_meses;
                      total_vtc_d = mensualidad * mesesVTCdinac;
                      $('[name="c_tcambopt['+id+'].tcambopt"]').val('2').trigger('change');
                      $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
                    }
                    else {
                      $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", false);
                      tranformar_tc = mensualidad * tipo_cambio;
                      total = tranformar_tc * total_meses;
                      total_vtc_d = tranformar_tc * mesesVTCdinac;
                    }
                  }
                  if(tipo_forma_cambio == '2'){
                    tipo_cambio = 0;
                    total = mensualidad * total_meses;
                    total_vtc_d = mensualidad * mesesVTCdinac;
                    $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
                  }
                }

                if(  $('[name="c_checkiva['+id+'].checkiva"]').is(':checked') ) {
                  // console.log('checked');
                  $('[name="c_valiva['+id+'].valiva"]').val('0').trigger('change');
                  tranformar_iva = total;
                  tranformar_vtcdinamic_iva = total_vtc_d;
                  mensualidad_civa = mensualidad;
                  if (tranformar_vtcdinamic_iva < 0) {
                    tranformar_vtcdinamic_iva = 0;
                  }
                }
                else {
                  // console.log('unchecked');
                  tranformar_iva = total*unir_iva;
                  mensualidad_civa = mensualidad*unir_iva;

                  tranformar_vtcdinamic_iva = total_vtc_d;
                  if (tranformar_vtcdinamic_iva < 0) {
                    tranformar_vtcdinamic_iva = 0;
                  }
                }

                $('[name="c_tcamb['+id+'].tcamb"]').val(tipo_cambio);
                $('[name="c_montoiva['+id+'].montoiva"]').val(parseFloat(mensualidad_civa).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('[name="c_vtcreal['+id+'].vtcreal"]').val(total.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('[name="c_vtcdinamic['+id+'].vtcdinamic"]').val(tranformar_vtcdinamic_iva.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                //----------------------------------------------------------------------------------------------------------------------------
              }
            }
          }
        }
  });
}

function createEvent_Moneda2(id){
  const element = document.querySelector('[name="c_coin['+id+'].coin"]')
  element.addEventListener('change', function() {
    var vtc_real = 0,
        vtc_dinamico = 0,
        iva = 0,
        iva_info = 0,
        tipo_forma_cambio = 0,
        tipo_cambio = 0,
        tipo_moneda = this.value,
        mensualidad = 0,
        total_meses = 0,
        tranformar_tc = 0,
        unir_iva= 0;
        tranformar_iva = 0,
        total_vtc_d = 0,
        tranformar_vtcdinamic_iva = 0;

        var dateNow = moment().format('YYYY-MM-DD');
        var dateEnd= $('#date_end_cont_sist').val();
        var mesesVTCdinac = moment(dateEnd, 'YYYY-MM-DD').diff(dateNow, 'months');
        // console.log(mesesVTCdinac);

        mensualidad = $('input[name="c_price[' + id + '].price"]').val().replace(/,/g, '');
        // tipo_moneda = $('select[name="c_coin[' + id + '].coin"]').val();
        tipo_forma_cambio = $('select[name="c_tcambopt[' + id + '].tcambopt"]').val();
        tipo_cambio = $('[name="c_tcamb['+id+'].tcamb"]').val();
        iva = $('select[name="c_valiva[' + id + '].valiva"]').val();
        total_meses = $( "#sel_no_month" ).val();
        unir_iva = '1.'+iva;

        mensualidad = (mensualidad == null || mensualidad == undefined || mensualidad == "") ? 0 : mensualidad;
        tipo_cambio = (tipo_cambio == null || tipo_cambio == undefined || tipo_cambio == "") ? 0 : tipo_cambio;
        total_meses = (total_meses == null || total_meses == undefined || total_meses == "") ? 0 : total_meses;

        if (tipo_moneda === '1'){
          tipo_cambio = 0;
          total = mensualidad * total_meses;
          total_vtc_d = mensualidad * mesesVTCdinac;
          $('[name="c_tcambopt['+id+'].tcambopt"]').val('2').trigger('change');
          $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
        }
        else{
          if(tipo_forma_cambio == ''){
            tipo_cambio = 0;
            tranformar_tc = mensualidad * tipo_cambio;
            total = tranformar_tc * total_meses;
            total_vtc_d = tranformar_tc * mesesVTCdinac;
            $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
          }
          if(tipo_forma_cambio == '1'){
            if (tipo_moneda == '1'){
              tipo_cambio = 0;
              total = mensualidad * total_meses;
              total_vtc_d = mensualidad * mesesVTCdinac;
              $('[name="c_tcambopt['+id+'].tcambopt"]').val('2').trigger('change');
              $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
            }
            else {
              $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", false);
              tranformar_tc = mensualidad * tipo_cambio;
              total = tranformar_tc * total_meses;
              total_vtc_d = tranformar_tc * mesesVTCdinac;
            }
          }
          if(tipo_forma_cambio == '2'){
            tipo_cambio = 0;
            total = mensualidad * total_meses;
            total_vtc_d = mensualidad * mesesVTCdinac;
            $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
          }
        }

        if(  $('[name="c_checkiva['+id+'].checkiva"]').is(':checked') ) {
          // console.log('checked');
          $('[name="c_valiva['+id+'].valiva"]').val('0').trigger('change');
          tranformar_iva = total;
          tranformar_vtcdinamic_iva = total_vtc_d;
          if (tranformar_vtcdinamic_iva < 0) {
            tranformar_vtcdinamic_iva = 0;
          }
        }
        else {
          // console.log('unchecked');
          tranformar_iva = total*unir_iva;
          tranformar_vtcdinamic_iva = total_vtc_d;
          if (tranformar_vtcdinamic_iva < 0) {
            tranformar_vtcdinamic_iva = 0;
          }
        }

        $('[name="c_tcamb['+id+'].tcamb"]').val(tipo_cambio);
        $('[name="c_montoiva['+id+'].montoiva"]').val(tranformar_iva.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('[name="c_vtcreal['+id+'].vtcreal"]').val(total.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('[name="c_vtcdinamic['+id+'].vtcdinamic"]').val(tranformar_vtcdinamic_iva.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));


  });
}

function createEvent_Optc(id){
  const element = document.querySelector('[name="c_tcambopt['+id+'].tcambopt"]')
  element.addEventListener('change', function() {
    var vtc_real = 0,
        vtc_dinamico = 0,
        iva = 0,
        iva_info = 0,
        tipo_forma_cambio = this.value,
        tipo_cambio = 0,
        tipo_moneda = 0,
        mensualidad = 0,
        total_meses = 0,
        tranformar_tc = 0,
        unir_iva= 0;
        tranformar_iva = 0,
        mensualidad_civa= 0,
        total_vtc_d = 0,
        tranformar_vtcdinamic_iva = 0;

        var dateNow = moment().format('YYYY-MM-DD');
        var dateEnd= $('#date_end_cont_sist').val();
        var mesesVTCdinac = moment(dateEnd, 'YYYY-MM-DD').diff(dateNow, 'months');
        // console.log(mesesVTCdinac);

        tipo_moneda = $('select[name="c_coin[' + id + '].coin"]').val();
        tipo_cambio = $('[name="c_tcamb['+id+'].tcamb"]').val();
        mensualidad = $('input[name="c_price[' + id + '].price"]').val().replace(/,/g, '');
        total_meses = $( "#sel_no_month" ).val();
        iva = $('select[name="c_valiva[' + id + '].valiva"]').val();
        unir_iva = '1.'+iva;

        mensualidad = (mensualidad == null || mensualidad == undefined || mensualidad == "") ? 0 : mensualidad;
        tipo_cambio = (tipo_cambio == null || tipo_cambio == undefined || tipo_cambio == "") ? 0 : tipo_cambio;
        total_meses = (total_meses == null || total_meses == undefined || total_meses == "") ? 0 : total_meses;

        if (tipo_moneda == '1'){
          tipo_cambio = 0;
          total = mensualidad * total_meses;
          total_vtc_d = mensualidad * mesesVTCdinac;
          $('[name="c_tcambopt['+id+'].tcambopt"]').val('2').trigger('change');
          $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
        }
        else{
          if(tipo_forma_cambio == ''){
            tipo_cambio = 0;
            tranformar_tc = mensualidad * tipo_cambio;
            total = tranformar_tc * total_meses;
            total_vtc_d = tranformar_tc * mesesVTCdinac;
            $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
          }
          if(tipo_forma_cambio == '1'){
            if (tipo_moneda == '1'){
              tipo_cambio = 0;
              total = mensualidad * total_meses;
              total_vtc_d = mensualidad * mesesVTCdinac;
              $('[name="c_tcambopt['+id+'].tcambopt"]').val('2').trigger('change');
              $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
            }
            else {
              $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", false);
              tranformar_tc = mensualidad * tipo_cambio;
              total = tranformar_tc * total_meses;
              total_vtc_d = tranformar_tc * mesesVTCdinac;
            }
          }
          if(tipo_forma_cambio == '2'){
            tipo_cambio = 0;
            total = mensualidad * total_meses;
            total_vtc_d = mensualidad * mesesVTCdinac;
            $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
          }
        }
        if(  $('[name="c_checkiva['+id+'].checkiva"]').is(':checked') ) {
          // console.log('checked');
          $('[name="c_valiva['+id+'].valiva"]').val('0').trigger('change');
          tranformar_iva = total;
          tranformar_vtcdinamic_iva = total_vtc_d;
          mensualidad_civa = mensualidad;
          if (tranformar_vtcdinamic_iva < 0) {
            tranformar_vtcdinamic_iva = 0;
          }
        }
        else {
          // console.log('unchecked');
          tranformar_iva = total*unir_iva;
          tranformar_vtcdinamic_iva = total_vtc_d;
          mensualidad_civa = mensualidad*unir_iva;

          if (tranformar_vtcdinamic_iva < 0) {
            tranformar_vtcdinamic_iva = 0;
          }
        }
        $('[name="c_tcamb['+id+'].tcamb"]').val(tipo_cambio);
        $('[name="c_montoiva['+id+'].montoiva"]').val(parseFloat(mensualidad_civa).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('[name="c_vtcreal['+id+'].vtcreal"]').val(total.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('[name="c_vtcdinamic['+id+'].vtcdinamic"]').val(tranformar_vtcdinamic_iva.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  });
}

function createEvent_tc(id){
  const element = document.querySelector('[name="c_tcamb['+id+'].tcamb"]')
  element.addEventListener('keyup', function() {
    var vtc_real = 0,
        vtc_dinamico = 0,
        iva = 0,
        iva_info = 0,
        tipo_forma_cambio = 0,
        tipo_cambio = this.value,
        tipo_moneda = 0,
        mensualidad = 0,
        total_meses = 0,
        tranformar_tc = 0,
        unir_iva= 0;
        tranformar_iva = 0,
        mensualidad_civa = 0,
        total_vtc_d = 0,
        tranformar_vtcdinamic_iva = 0;

        var dateNow = moment().format('YYYY-MM-DD');
        var dateEnd= $('#date_end_cont_sist').val();
        var mesesVTCdinac = moment(dateEnd, 'YYYY-MM-DD').diff(dateNow, 'months');

        tipo_forma_cambio = $('select[name="c_tcambopt[' + id + '].tcambopt"]').val();
        mensualidad = $('input[name="c_price[' + id + '].price"]').val().replace(/,/g, '');
        tipo_moneda = $('select[name="c_coin[' + id + '].coin"]').val();
        iva = $('select[name="c_valiva[' + id + '].valiva"]').val();
        unir_iva = '1.'+iva;
        total_meses = $( "#sel_no_month" ).val();

        if(tipo_forma_cambio == '1'){
          if (tipo_moneda == '1'){
            tipo_cambio = 0;
            total = mensualidad * total_meses;
            total_vtc_d = mensualidad * mesesVTCdinac;
            $('[name="c_tcambopt['+id+'].tcambopt"]').val('2').trigger('change');
            $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
          }
          else {
            $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", false);
            tranformar_tc = mensualidad * tipo_cambio;
            total = tranformar_tc * total_meses;
            total_vtc_d = tranformar_tc * mesesVTCdinac;
          }
        }
        if(  $('[name="c_checkiva['+id+'].checkiva"]').is(':checked') ) {
          $('[name="c_valiva['+id+'].valiva"]').val('0').trigger('change');
          tranformar_iva = total;
          tranformar_vtcdinamic_iva = total_vtc_d;
          mensualidad_civa = mensualidad;
          if (tranformar_vtcdinamic_iva < 0) {
            tranformar_vtcdinamic_iva = 0;
          }
        }
        else {
          tranformar_iva = total*unir_iva;
          tranformar_vtcdinamic_iva = total_vtc_d;
          mensualidad_civa = mensualidad*unir_iva;
          if (tranformar_vtcdinamic_iva < 0) {
            tranformar_vtcdinamic_iva = 0;
          }
        }
        $('[name="c_tcamb['+id+'].tcamb"]').val(tipo_cambio);
        $('[name="c_montoiva['+id+'].montoiva"]').val(parseFloat(mensualidad_civa).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('[name="c_vtcreal['+id+'].vtcreal"]').val(total.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('[name="c_vtcdinamic['+id+'].vtcdinamic"]').val(tranformar_vtcdinamic_iva.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

  });
}

function createEvent_iva(id){
  const element = document.querySelector('[name="c_valiva['+id+'].valiva"]')
  element.addEventListener('change', function() {
    var vtc_real = 0,
        vtc_dinamico = 0,
        iva = this.value,
        iva_info = 0,
        tipo_forma_cambio = 0,
        tipo_cambio = 0,
        tipo_moneda = 0,
        mensualidad = 0,
        total_meses = 0,
        tranformar_tc = 0,
        unir_iva= 0;
        tranformar_iva = 0,
        mensualidad_civa = 0,
        total_vtc_d = 0,
        tranformar_vtcdinamic_iva = 0;

        var dateNow = moment().format('YYYY-MM-DD');
        var dateEnd= $('#date_end_cont_sist').val();
        var mesesVTCdinac = moment(dateEnd, 'YYYY-MM-DD').diff(dateNow, 'months');

    tipo_moneda = $('select[name="c_coin[' + id + '].coin"]').val();
    tipo_forma_cambio = $('select[name="c_tcambopt[' + id + '].tcambopt"]').val();
    tipo_cambio = $('[name="c_tcamb['+id+'].tcamb"]').val();
    mensualidad = $('input[name="c_price[' + id + '].price"]').val().replace(/,/g, '');
    total_meses = $( "#sel_no_month" ).val();
    unir_iva = '1.'+iva;

    mensualidad = (mensualidad == null || mensualidad == undefined || mensualidad == "") ? 0 : mensualidad;
    tipo_cambio = (tipo_cambio == null || tipo_cambio == undefined || tipo_cambio == "") ? 0 : tipo_cambio;
    total_meses = (total_meses == null || total_meses == undefined || total_meses == "") ? 0 : total_meses;

    if(tipo_forma_cambio == ''){
      tipo_cambio = 0;
      tranformar_tc = mensualidad * tipo_cambio;
      total = tranformar_tc * total_meses;
      total_vtc_d = tranformar_tc * mesesVTCdinac;
      $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
    }
    if(tipo_forma_cambio == '1'){
      if (tipo_moneda == '1'){
        tipo_cambio = 0;
        total = mensualidad * total_meses;
        total_vtc_d = mensualidad * mesesVTCdinac;
        $('[name="c_tcambopt['+id+'].tcambopt"]').val('2').trigger('change');
        $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
      }
      else {
        tranformar_tc = mensualidad * tipo_cambio;
        total = tranformar_tc * total_meses;
        total_vtc_d = tranformar_tc * mesesVTCdinac;
      }
    }
    if(tipo_forma_cambio == '2'){
      tipo_cambio = 0;
      total = mensualidad * total_meses;
      total_vtc_d = mensualidad * mesesVTCdinac;
      $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
    }

    if(  $('[name="c_checkiva['+id+'].checkiva"]').is(':checked') ) {
      $('[name="c_valiva['+id+'].valiva"]').val('0').trigger('change');
      tranformar_iva = total;
      tranformar_vtcdinamic_iva = total_vtc_d;
      mensualidad_civa = mensualidad;
      if (tranformar_vtcdinamic_iva < 0) {
        tranformar_vtcdinamic_iva = 0;
      }
    }
    else {
      tranformar_iva = total*unir_iva;
      tranformar_vtcdinamic_iva = total_vtc_d;
      mensualidad_civa = mensualidad*unir_iva;
      if (tranformar_vtcdinamic_iva < 0) {
        tranformar_vtcdinamic_iva = 0;
      }
    }
    $('[name="c_tcamb['+id+'].tcamb"]').val(tipo_cambio);
    $('[name="c_montoiva['+id+'].montoiva"]').val(parseFloat(mensualidad_civa).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('[name="c_vtcreal['+id+'].vtcreal"]').val(total.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('[name="c_vtcdinamic['+id+'].vtcdinamic"]').val(tranformar_vtcdinamic_iva.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

  });
}

function createEvent_checkiva(id){
  const element = document.querySelector('[name="c_checkiva['+id+'].checkiva"]')
  element.addEventListener('change', function() {
    var vtc_real = 0,
        vtc_dinamico = 0,
        iva = 0,
        iva_info = 0,
        tipo_forma_cambio = 0,
        tipo_cambio = 0,
        tipo_moneda = 0,
        mensualidad = 0,
        total_meses = 0,
        tranformar_tc = 0,
        unir_iva= 0;
        tranformar_iva = 0,
        mensualidad_civa = 0,
        total_vtc_d = 0,
        tranformar_vtcdinamic_iva = 0;

        var dateNow = moment().format('YYYY-MM-DD');
        var dateEnd= $('#date_end_cont_sist').val();
        var mesesVTCdinac = moment(dateEnd, 'YYYY-MM-DD').diff(dateNow, 'months');

        total_meses = $( "#sel_no_month" ).val();
        mensualidad = $('input[name="c_price[' + id + '].price"]').val().replace(/,/g, '');
        tipo_moneda = $('select[name="c_coin[' + id + '].coin"]').val();
        tipo_forma_cambio = $('select[name="c_tcambopt[' + id + '].tcambopt"]').val();
        tipo_cambio = $('[name="c_tcamb['+id+'].tcamb"]').val();
        iva = $('select[name="c_valiva[' + id + '].valiva"]').val();
        unir_iva = '1.'+iva;

        mensualidad = (mensualidad == null || mensualidad == undefined || mensualidad == "") ? 0 : mensualidad;
        tipo_cambio = (tipo_cambio == null || tipo_cambio == undefined || tipo_cambio == "") ? 0 : tipo_cambio;
        total_meses = (total_meses == null || total_meses == undefined || total_meses == "") ? 0 : total_meses;


        if (tipo_moneda == '1'){
          tipo_cambio = 0;
          $('[name="c_tcambopt['+id+'].tcambopt"]').val('2').trigger('change');
          $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
        }

        if(tipo_forma_cambio == ''){
          tipo_cambio = 0;
          tranformar_tc = mensualidad * tipo_cambio;
          total = tranformar_tc * total_meses;
          total_vtc_d = tranformar_tc * mesesVTCdinac;
          $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
        }
        if(tipo_forma_cambio == '1'){
          if (tipo_moneda == '1'){
            tipo_cambio = 0;
            total = mensualidad * total_meses;
            total_vtc_d = mensualidad * mesesVTCdinac;
            $('[name="c_tcambopt['+id+'].tcambopt"]').val('2').trigger('change');
            $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
          }
          else {
            tranformar_tc = mensualidad * tipo_cambio;
            total = tranformar_tc * total_meses;
            total_vtc_d = tranformar_tc * mesesVTCdinac;
          }
        }
        if(tipo_forma_cambio == '2'){
          tipo_cambio = 0;
          total = mensualidad * total_meses;
          total_vtc_d = mensualidad * mesesVTCdinac;
          $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
        }

      if(this.checked) {
        $('[name="c_valiva['+id+'].valiva"]').val('0').trigger('change');
        tranformar_iva = total;
        tranformar_vtcdinamic_iva = total_vtc_d;
        mensualidad_civa= mensualidad;
        if (tranformar_vtcdinamic_iva < 0) {
          tranformar_vtcdinamic_iva = 0;
        }
        // console.log('NO calcular iva');
      }
      else {
        tranformar_iva = total*unir_iva;
        tranformar_vtcdinamic_iva = total_vtc_d;
        mensualidad_civa= mensualidad*unir_iva;
        if (tranformar_vtcdinamic_iva < 0) {
          tranformar_vtcdinamic_iva = 0;
        }
        // console.log('Calcular iva');
      }
      $('[name="c_tcamb['+id+'].tcamb"]').val(tipo_cambio);
      $('[name="c_montoiva['+id+'].montoiva"]').val(parseFloat(mensualidad_civa).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
      $('[name="c_vtcreal['+id+'].vtcreal"]').val(total.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
      $('[name="c_vtcdinamic['+id+'].vtcdinamic"]').val(tranformar_vtcdinamic_iva.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  });
}

var conceptIndex = 0,
    constante_eliminar = [],
    constante_a = 0,
    max_options = 2;

$(".validation-wizard-anexo").on('click','.addButton',function(){
  if( constante_eliminar.length === 0) {
    if(conceptIndex <= max_options) {
      conceptIndex++;
      var $template = $('#optionTemplateAnexo'),
      $clone  = $template
        .clone()
        .removeClass('hide')
        .removeAttr('id')
        .attr('data-book-index', conceptIndex)
        .insertBefore($template);
      // Update the name attributes
      $clone
        .find('[name="price"]').attr('name', 'c_price[' + conceptIndex + '].price').attr('data_row', conceptIndex).end()
        .find('[name="coin"]').attr('name', 'c_coin[' + conceptIndex + '].coin').end()
        .find('[name="tcambopt"]').attr('name', 'c_tcambopt[' + conceptIndex + '].tcambopt').end()
        .find('[name="tcamb"]').attr('name', 'c_tcamb[' + conceptIndex + '].tcamb').end()
        .find('[name="valiva"]').attr('name', 'c_valiva[' + conceptIndex + '].valiva').end()
        .find('[name="montoiva"]').attr('name', 'c_montoiva[' + conceptIndex + '].montoiva').end()
        .find('[name="vtcreal"]').attr('name', 'c_vtcreal[' + conceptIndex + '].vtcreal').end()
        .find('[name="vtcdinamic"]').attr('name', 'c_vtcdinamic[' + conceptIndex + '].vtcdinamic').end()
        .find('[name="checkiva"]').attr('name', 'c_checkiva[' + conceptIndex + '].checkiva').end();


        $('input[name="c_price[' + conceptIndex + '].price"]').addClass("moneditas");
        $('input[name="c_price[' + conceptIndex + '].price"]').addClass("xf");

        $('select[name="c_coin[' + conceptIndex + '].coin"]').addClass("required");
        $('select[name="c_coin[' + conceptIndex + '].coin"]').addClass("coin");

        $('.moneditas').each(function() {
          $(this).rules("add",
                {
                  required: true,
                  number: true,
                });
        });
        createEvent_Mensualidad (conceptIndex);
        createEvent_Moneda(conceptIndex);
        createEvent_Optc(conceptIndex);
        createEvent_tc(conceptIndex);
        createEvent_iva(conceptIndex);
        createEvent_checkiva(conceptIndex);
    }
    else{
      swal("Operación abortada", "Excediste el limite de campos permitidos  :(", "error");
    }
  }
  else {
    /*INICIO DE LA SECCION-- Reutilizo index eliminados. */
      var ordenando_array = constante_eliminar.sort();
      index_reutilizado = ordenando_array[0];

      var $template = $('#optionTemplateAnexo'),
      $clone  = $template
        .clone()
        .removeClass('hide')
        .removeAttr('id')
        .attr('data-book-index', index_reutilizado)
        .insertBefore($template);

      $clone
          .find('[name="price"]').attr('name', 'c_price[' + index_reutilizado + '].price').attr('data_row', index_reutilizado).end()
          .find('[name="coin"]').attr('name', 'c_coin[' + index_reutilizado + '].coin').end()
          .find('[name="tcambopt"]').attr('name', 'c_tcambopt[' + index_reutilizado + '].tcambopt').end()
          .find('[name="tcamb"]').attr('name', 'c_tcamb[' + index_reutilizado + '].tcamb').end()
          .find('[name="valiva"]').attr('name', 'c_valiva[' + index_reutilizado + '].valiva').end()
          .find('[name="montoiva"]').attr('name', 'c_montoiva[' + conceptIndex + '].montoiva').end()
          .find('[name="vtcreal"]').attr('name', 'c_vtcreal[' + index_reutilizado + '].vtcreal').end()
          .find('[name="vtcdinamic"]').attr('name', 'c_vtcdinamic[' + index_reutilizado + '].vtcdinamic').end()
          .find('[name="checkiva"]').attr('name', 'c_checkiva[' + index_reutilizado + '].checkiva').end();


          $('input[name="c_price[' + index_reutilizado + '].price"]').addClass("xf");
          $('input[name="c_price[' + index_reutilizado + '].price"]').addClass("moneditas");

          $('select[name="c_coin[' + index_reutilizado + '].coin"]').addClass("required");
          $('select[name="c_coin[' + index_reutilizado + '].coin"]').addClass("coin");

          $('.moneditas').each(function() {
            $(this).rules("add",
                  {
                    required: true,
                    number: true,
                    min: 1,
                    max: 99999
                  });
          });
          createEvent_Mensualidad (index_reutilizado);
          createEvent_Moneda(index_reutilizado);
          createEvent_Optc(index_reutilizado);
          createEvent_tc(index_reutilizado);
          createEvent_iva(index_reutilizado);
          createEvent_checkiva(index_reutilizado);

    //Elimino el primero elemento del array
      ordenando_array.shift();

  }
});

$(".validation-wizard-anexo").on('click','.removeButton',function(){
  var $row  = $(this).parents('.clone'),
      index = $row.attr('data-book-index');
  // Remove element containing the option
      $row.remove();
  //Añado el index a reutilizar en la inserción
      constante_eliminar.push(index);
      // createEvent_llenarmoneda ();
});

$(".validation-wizard-anexo").on('change','#sel_no_month',function(){
  var val = $(this).val();
  var dateStart= $('#date_start_cont').val();
  var contando = $('.xf').length;

  if ( val != '') {
    if (dateStart!=''){
      var xmas = moment(dateStart, 'YYYY-MM-DD').add('months', val);
      var xmas2= moment(xmas).format('YYYY-MM-DD');
      $('input[name="date_end_cont_sist"]').val(xmas2);

      for (var i = 0; i < $('.xf').length; i++) {
        if($('input[name="c_price[' + i + '].price"]').length){
          mensualidad_data(i, val);
        }
      }
    }
    else{
      swal("Operación abortada!", "Ingresa una fecha de inicio. :(", "error");
      $('input[name="date_end_cont_sist"]').val('');
      $('#sel_no_month').val('').trigger('change');
    }
  }
  else {
    if (dateStart==''){
      swal("Operación abortada!", "Ingresa una fecha de inicio. :(", "error");
    }
    else{
      swal("Operación abortada!", "Selecciona un mes valido. :(", "error");
    }
  }
});

function mensualidad_data(id, campoa){
  var vtc_real = 0,
      vtc_dinamico = 0,
      iva = 0,
      iva_info = 0,
      tipo_forma_cambio = 0,
      tipo_cambio = 0,
      tipo_moneda = 0,
      mensualidad = 0,
      total_meses = 0,
      tranformar_tc = 0,
      unir_iva= 0;
      tranformar_iva = 0,
      total_vtc_d = 0,
      tranformar_vtcdinamic_iva = 0;

      var dateNow = moment().format('YYYY-MM-DD');
      var dateEnd= $('#date_end_cont_sist').val();
      var mesesVTCdinac = moment(dateEnd, 'YYYY-MM-DD').diff(dateNow, 'months');

      mensualidad = $('input[name="c_price[' + id + '].price"]').val().replace(/,/g, '');
      tipo_moneda = $('select[name="c_coin[' + id + '].coin"]').val();
      tipo_forma_cambio = $('select[name="c_tcambopt[' + id + '].tcambopt"]').val();
      tipo_cambio = $('[name="c_tcamb['+id+'].tcamb"]').val();
      iva = $('select[name="c_valiva[' + id + '].valiva"]').val();
      total_meses = $( "#sel_no_month" ).val();
      unir_iva = '1.'+iva;

      mensualidad = (mensualidad == null || mensualidad == undefined || mensualidad == "") ? 0 : mensualidad;
      tipo_cambio = (tipo_cambio == null || tipo_cambio == undefined || tipo_cambio == "") ? 0 : tipo_cambio;
      total_meses = (total_meses == null || total_meses == undefined || total_meses == "") ? 0 : total_meses;


      if (tipo_moneda == '1'){
        tipo_cambio = 0;
        $('[name="c_tcambopt['+id+'].tcambopt"]').val('2').trigger('change');
        $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
      }

      if(tipo_forma_cambio == ''){
        tipo_cambio = 0;
        tranformar_tc = mensualidad * tipo_cambio;
        total = tranformar_tc * total_meses;
        total_vtc_d = tranformar_tc * mesesVTCdinac;
        $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
      }
      if(tipo_forma_cambio == '1'){
        if (tipo_moneda == '1'){
          tipo_cambio = 0;
          total = mensualidad * total_meses;
          total_vtc_d = mensualidad * mesesVTCdinac;
          $('[name="c_tcambopt['+id+'].tcambopt"]').val('2').trigger('change');
          $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
        }
        else {
          $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", false);
          tranformar_tc = mensualidad * tipo_cambio;
          total = tranformar_tc * total_meses;
          total_vtc_d = tranformar_tc * mesesVTCdinac;
        }
      }
      if(tipo_forma_cambio == '2'){
        tipo_cambio = 0;
        total = mensualidad * total_meses;
        total_vtc_d = mensualidad * mesesVTCdinac;
        $('input[name="c_tcamb[' + id + '].tcamb"]').prop("readonly", true);
      }

      if(  $('[name="c_checkiva['+id+'].checkiva"]').is(':checked') ) {
        // console.log('checked');
        $('[name="c_valiva['+id+'].valiva"]').val('0').trigger('change');
        tranformar_iva = total;
        tranformar_vtcdinamic_iva = total_vtc_d;
        if (tranformar_vtcdinamic_iva < 0) {
          tranformar_vtcdinamic_iva = 0;
        }
      }
      else {
        // console.log('unchecked');
        tranformar_iva = total*unir_iva;
        tranformar_vtcdinamic_iva = total_vtc_d;
        if (tranformar_vtcdinamic_iva < 0) {
          tranformar_vtcdinamic_iva = 0;
        }
      }

      $('[name="c_tcamb['+id+'].tcamb"]').val(tipo_cambio);
      $('[name="c_montoiva['+id+'].montoiva"]').val(tranformar_iva.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
      $('[name="c_vtcreal['+id+'].vtcreal"]').val(total.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
      $('[name="c_vtcdinamic['+id+'].vtcdinamic"]').val(tranformar_vtcdinamic_iva.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

}


function createEvent_verfcoin(id){
  var contando = $('.coin').length;
  if ( contando == '1') {
    console.log('solo el primer select');
  }
  else{
    console.log(contando);
  }
}
