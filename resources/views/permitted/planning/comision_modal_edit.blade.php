

<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

<script type="text/javascript">
  var item_relation_contact_row = "{{ $item_contact_row }}";
  var item_relation_cierre_row = "{{ $item_cierre_row }}";
  var item_relation_vendedor_row = "{{ $item_vendedor_row }}";
  var item_relation_colaborador_row = "{{ $item_colaborador_row }}";
  
  $(function() {
    
    item_relation_contact_row = 0;
    item_relation_cierre_row = 0;
    item_relation_vendedor_row = 0;
    item_relation_colaborador_row = 0;

    $('#cont_vtc').change(function() {
      if ($(this).prop('checked') == true) {  $('#cont_vtc').val(1);  }
      else {  $('#cont_vtc').val(0);  }
    });
    $('#cont_venue').change(function() {
      if ($(this).prop('checked') == true) {  $('#cont_venue').val(1);  }
      else {  $('#cont_venue').val(0);  }
    });
    $('#comp_ingreso').change(function() {
      if ($(this).prop('checked') == true) {  $('#comp_ingreso').val(1);  }
      else {  $('#comp_ingreso').val(0);  }
    });

    $('#comision').change(function() {
      if ($(this).prop('checked') == true) {
        cont_vtc = 1;
        $('#div_comisiones').show();
        $("#sel_inside_sales").prop('required',true);
        $("#sel_itconcierge_comision").prop('required',true);
        $('#comision').val(cont_vtc);
      }
      else {
        cont_vtc = 0;
        $('#comision').val(cont_vtc);
        $('#div_comisiones').hide();
        $("#sel_inside_sales").prop('required',false);
        $("#sel_itconcierge_comision").prop('required',false);
      }

      $('#sel_type_comision').val('').trigger('change');
      $('#sel_inside_sales').val('').trigger('change');
      $('#sel_itconcierge_comision').val('').trigger('change');
      $("#item_politica input[type=text]").val('');
      delete_row_table_a();
      delete_row_table_b();
      delete_row_table_c();
      delete_row_table_d();
    });
    $('#sel_type_comision').on('change', function(e){
      var group = $(this).val();
      data_comision(group);
    });
  });

  function addItemCont() {
    let politica = $("select[name='sel_type_comision']").val();
    if (politica != '') {
      var html = '';
      html += '<tr id="item_row_' + item_relation_contact_row + '">';

      html += '<td class="text-center" style="vertical-align: middle;">';
      html += '<button type="button" onclick="$(\'#item_row_' + item_relation_contact_row + '\').remove();" class="btn btn-xs btn-danger" style="margin-bottom: 0; padding: 1px 3px;">';
      html += '<i class="fa fa-trash" style="font-size: 1rem;"></i>';
      html += '</button>';
      html += '<input type="hidden" name="item[' + item_relation_contact_row + '][id]" id="item_id_' + item_relation_contact_row + '" /> ';
      html += '</td>';

      html += '<td>';
      html += '<div class="form-group form-group-sm">';
      html += '<select class="form-control input-sm col-contact-int" name="item[' + item_relation_contact_row + '][contactInt]" id="item_contactInt_' + item_relation_contact_row + '" data-row="' + item_relation_contact_row + '">'
      html += '<option selected="selected" value="">@lang('message.selectopt')</option>';
      @forelse ($kickoff_colaboradores as $kickoff_colaboradores_data)
      html += '<option value="{{ $kickoff_colaboradores_data->id  }}">{{ $kickoff_colaboradores_data->name }}</option>';
      @empty
      @endforelse
      html += '</select>';
      html += '</div>';
      html += '</td>';

      html += '<td>';
      html += '<div class="form-group form-group-sm">';
      html += '<input type="text" class="form-control input-sm text-right col-contact" name="item[' + item_relation_contact_row + '][contact]" id="item_contact_' + item_relation_contact_row + '" step="any"/>';
      html += '</div>';
      html += '</td>';

      html += '<td>';
      html += '<div class="form-group form-group-sm">';
      html += '<input type="text" class="form-control input-sm text-right col-porcentaje" name="item[' + item_relation_contact_row + '][porcentaje]" id="item_porcentaje_' + item_relation_contact_row + '" required step="any" maxlength="10" />';
      html += '</div>';
      html += '</td>';

      html += '</tr>';

      $("#validation_anexo #item_contact tbody #add_item_contact").before(html);
      item_relation_contact_row++;
    }
    else {
      $('#sel_inside_sales').val('').trigger('change');
      $('#sel_itconcierge_comision').val('').trigger('change');
      Swal.fire({
         type: 'error',
         title: 'Oops...',
         text: 'Selecciona la politica de comisión',
       });
    }
  }

  function addItemCierre() {
    let politica = $("select[name='sel_type_comision']").val();
    if (politica != '') {
      var html = '';
      html += '<tr id="item_cierre_row_' + item_relation_cierre_row + '">';

      html += '<td class="text-center" style="vertical-align: middle;">';
      html += '<button type="button" onclick="$(\'#item_cierre_row_' + item_relation_cierre_row + '\').remove();" class="btn btn-xs btn-danger" style="margin-bottom: 0; padding: 1px 3px;">';
      html += '<i class="fa fa-trash" style="font-size: 1rem;"></i>';
      html += '</button>';
      html += '<input type="hidden" name="item_cierre[' + item_relation_cierre_row + '][id]" id="item_cierre_id_' + item_relation_cierre_row + '" /> ';
      html += '</td>';

      html += '<td>';
      html += '<div class="form-group form-group-sm">';
      html += '<select class="form-control input-sm col-cierre-contact-int" name="item_cierre[' + item_relation_cierre_row + '][contactInt]" id="item_cierre_contactInt_' + item_relation_cierre_row + '" data-row="' + item_relation_cierre_row + '">'
      html += '<option selected="selected" value="">@lang('message.selectopt')</option>';
      @forelse ($kickoff_colaboradores as $kickoff_colaboradores_data)
      html += '<option value="{{ $kickoff_colaboradores_data->id  }}">{{ $kickoff_colaboradores_data->name }}</option>';
      @empty
      @endforelse
      html += '</select>';
      html += '</div>';
      html += '</td>';

      html += '<td>';
      html += '<div class="form-group form-group-sm">';
      html += '<input type="text" class="form-control input-sm text-right col-cierre-contact" name="item_cierre[' + item_relation_cierre_row + '][contact]" id="item_cierre_contact_' + item_relation_cierre_row + '" step="any" />';
      html += '</div>';
      html += '</td>';

      html += '<td>';
      html += '<div class="form-group form-group-sm">';
      html += '<input type="text" class="form-control input-sm text-right col-cierre-porcentaje" name="item_cierre[' + item_relation_cierre_row + '][porcentaje]" id="item_cierre_porcentaje_' + item_relation_cierre_row + '" required step="any" maxlength="10" />';
      html += '</div>';
      html += '</td>';

      html += '</tr>';
      $("#validation_anexo #item_cierre tbody #add_item_cierre").before(html);
      item_relation_cierre_row++;
    }
    else {
      $('#sel_inside_sales').val('').trigger('change');
      $('#sel_itconcierge_comision').val('').trigger('change');
      Swal.fire({
         type: 'error',
         title: 'Oops...',
         text: 'Selecciona la politica de comisión',
       });
    }
  }

  function addItemVendedor() {
    let politica = $("select[name='sel_type_comision']").val();
    if (politica != '') {
      var html = '';
      html += '<tr id="item_vendedor_row_' + item_relation_vendedor_row + '">';

      html += '<td class="text-center" style="vertical-align: middle;">';
      html += '<button type="button" onclick="$(\'#item_vendedor_row_' + item_relation_vendedor_row + '\').remove();" class="btn btn-xs btn-danger" style="margin-bottom: 0; padding: 1px 3px;">';
      html += '<i class="fa fa-trash" style="font-size: 1rem;"></i>';
      html += '</button>';
      html += '<input type="hidden" name="item_vendedor[' + item_relation_vendedor_row + '][id]" id="item_vendedor_id_' + item_relation_vendedor_row + '" /> ';
      html += '</td>';

      html += '<td>';
      html += '<div class="form-group form-group-sm">';
      html += '<select class="form-control input-sm col-vendedor-contact" name="item_vendedor[' + item_relation_vendedor_row + '][contact]" id="item_vendedor_contact_' + item_relation_vendedor_row + '" data-row="' + item_relation_vendedor_row + '" required>'
      html += '<option selected="selected" value="">@lang('message.selectopt')</option>';
      @forelse ($kickoff_vendedores as $kickoff_vendedores_data)
      html += '<option value="{{ $kickoff_vendedores_data->user_id  }}">{{ $kickoff_vendedores_data->user }}</option>';
      @empty
      @endforelse
      html += '</select>';
      html += '</div>';
      html += '</td>';

      html += '</tr>';

      $("#validation_anexo #item_vendedor tbody #add_item_vendedor").before(html);
      item_relation_vendedor_row++;
    }
    else {
      $('#sel_inside_sales').val('').trigger('change');
      $('#sel_itconcierge_comision').val('').trigger('change');
      Swal.fire({
         type: 'error',
         title: 'Oops...',
         text: 'Selecciona la politica de comisión',
       });
    }
  }

  function addItemColaborador() {
    let politica = $("select[name='sel_type_comision']").val();
    if (politica != '') {
      var html = '';
      html += '<tr id="item_colaborador_row_' + item_relation_colaborador_row + '">';

      html += '<td class="text-center" style="vertical-align: middle;">';
      html += '<button type="button" onclick="$(\'#item_colaborador_row_' + item_relation_colaborador_row + '\').remove();" class="btn btn-xs btn-danger" style="margin-bottom: 0; padding: 1px 3px;">';
      html += '<i class="fa fa-trash" style="font-size: 1rem;"></i>';
      html += '</button>';
      html += '<input type="hidden" name="item_colaborador[' + item_relation_colaborador_row + '][id]" id="item_colaborador_id_' + item_relation_colaborador_row + '" /> ';
      html += '</td>';

      html += '<td>';
      html += '<div class="form-group form-group-sm">';
      html += '<select class="form-control input-sm col-colaborador-contact" name="item_colaborador[' + item_relation_colaborador_row + '][contact]" id="item_colaborador_contact_' + item_relation_colaborador_row + '" data-row="' + item_relation_colaborador_row + '" required>'
      html += '<option selected="selected" value="">@lang('message.selectopt')</option>';
      @forelse ($kickoff_colaboradores as $kickoff_colaboradores_data)
      html += '<option value="{{ $kickoff_colaboradores_data->id  }}">{{ $kickoff_colaboradores_data->name }}</option>';
      @empty
      @endforelse
      html += '</select>';
      html += '</div>';
      html += '</td>';

      html += '</tr>';

      $("#validation_anexo #item_colaborador tbody #add_item_colaborador").before(html);
      item_relation_colaborador_row++;
    }
    else {
      $('#sel_inside_sales').val('').trigger('change');
      $('#sel_itconcierge_comision').val('').trigger('change');
      Swal.fire({
         type: 'error',
         title: 'Oops...',
         text: 'Selecciona la politica de comisión',
       });
    }
  }

  function data_comision(identX){
    var id = identX;
    var _token = $('input[name="_token"]').val();
    $.ajax({
      type: "POST",
      url: "/search_politica",
      data: { _token : _token,  text: id},
      success: function (data){
        count_data = data.length;
        if (count_data > 2) {
          datax = JSON.parse(data);
          $('input[name="politica_name"]').val(datax[0].politica.toUpperCase());
          $('input[name="politica_retencion"]').val(datax[0].retenciones);
          $('input[name="politica_asignado"]').val(datax[0].monto_asignado);
          $('input[name="politica_contacto"]').val(datax[0].contacto);
          $('input[name="politica_cierre"]').val(datax[0].cierre);
          $('input[name="politica_itc"]').val(datax[0].itc);
          $('input[name="politica_insidesales"]').val(datax[0].inside_sales);
        }
        else {
          $('input[name="politica_name"]').val('');
          $('input[name="politica_retencion"]').val('0');
          $('input[name="politica_asignado"]').val('0');
          $('input[name="politica_contacto"]').val('0');
          $('input[name="politica_cierre"]').val('0');
          $('input[name="politica_itc"]').val('0');
          $('input[name="politica_insidesales"]').val('0');
        }
      },
      error: function (error, textStatus, errorThrown) {
          if (error.status == 422) {
              var message = error.responseJSON.error;
              // $("#general_messages").html(alertMessage("danger", message));
              Swal.fire("Operación abortada", message, "error");
          }
          else {
              alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
          }
      }
    });
  }
</script>

