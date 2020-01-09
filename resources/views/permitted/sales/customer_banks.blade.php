@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View companies') )
    Datos de los clientes
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View companies') )
    Datos de los clientes
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View companies') )
<form id="form" name="form" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="col-md-12 col-xl-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body dashboard-tabs p-0">
                <ul class="nav nav-tabs px-4" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="accounts-tab" data-toggle="tab" href="#accounts" role="tab" aria-controls="accounts" aria-selected="false"><i class="fas fa-money-check-alt"></i> Cuentas bancarias</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!--Tab bank customers-->
                    <div class="tab-pane fade show active" id="accounts" role="tabpanel" aria-labelledby="accounts-tab">
                        <div class="media">
                            <div class="media-body">
                                <!---------------------------------------------------------------------------------->
                                <div class="row">

                                  <div class="form-group form-group-sm">
                                    Seleccione el cliente
                                  <select id="select_customer"class="form-control input-sm" name="item_bank_account[' + item_bank_account_row + '][bank_id]" id="item_bank_account_bank_id_' + item_bank_account_row + '" required>
                                  <option selected="selected" value="">@lang('message.selectopt')</option>
                                    @forelse ($customers as $customer_data)
                                    <option value="{{ $customer_data->id  }}">{{ $customer_data->name }}</option>
                                    @empty
                                    @endforelse
                                  </select>
                                  </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="table-responsive">
                                            <!--<div class="hidden" id="delete_items_bank_account">
                              @foreach(old('delete_item_bank_account',[]) as $tmp)
                                  <input type="text" name="delete_item_bank_account[]" value="{{ $tmp }}"/>
                              @endforeach
                            </div>-->
                                            <table class="table table-items table-condensed table-hover table-bordered table-striped" id="items_bank_account">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" class="text-center">Opciones</th>
                                                        <th width="15%" class="text-center">Banco</th>
                                                        <th width="15%" class="text-center">Moneda</th>
                                                        <th width="25%" class="text-center">Número de cuenta</th>
                                                        <th width="25%%" class="text-left">Descripción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Items -->

                                                    <!-- /Items -->
                                                    <!-- Agregar nuevo item -->
                                                    <tr id="add_item_bank_account">
                                                        <td class="text-center">
                                                            <button type="button" onclick="addItemBankAccount();" class="btn btn-xs btn-primary" style="margin-bottom: 0;">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </td>
                                                        <td class="text-right" colspan="4"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!---------------------------------------------------------------------------------->

                                @php
                                // print_r($items_bank_account);
                                // print_r($company_account);
                                @endphp
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <button class="btn btn-danger mt-2 mt-xl-0">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</form>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View companies') )
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

    <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

    <script src="{{ asset('js/admin/sales/customer_banks.js')}}"></script>

    <script type="text/javascript">
        function deleteItemBankAccount(id) {
            if(id) {
                let html = '<input type="text" name="delete_item_bank_account[]" value="'+id+'"/>';
                $('#form #delete_items_bank_account').append(html);
            }
        }

        var item_bank_account_row ='';//Revisa el original, este esta vacío para que funcione.
        function addItemBankAccount() {
            var html = '';
            html += '<tr id="item_bank_account_row_' + item_bank_account_row + '">';
            html += '<td class="text-center" style="vertical-align: middle;">';
            html += '<button type="button" onclick="$(\'#item_bank_account_row_' + item_bank_account_row + '\').remove();" class="btn btn-xs btn-danger" style="margin-bottom: 0;">';
            html += '<i class="fas fa-trash-alt"></i>';
            html += '</button>';
            html += '<input type="hidden" name="item_bank_account[' + item_bank_account_row + '][id]" id="item_bank_account_id_' + item_bank_account_row + '" /> ';
            html += '</td>';

            html += '<td>';
            html += '<div class="form-group form-group-sm">';
            html += '<select class="form-control input-sm" name="item_bank_account[' + item_bank_account_row + '][bank_id]" id="item_bank_account_bank_id_' + item_bank_account_row + '" required>';
            html += '<option selected="selected" value="">@lang('message.selectopt')</option>';
              @forelse ($banks as $banks_data)
              html += '<option value="{{ $banks_data->id  }}">{{ $banks_data->name }}</option>';
              @empty
              @endforelse
            html += '</select>';
            html += '</div>';
            html += '</td>';

            html += '<td>';
            html += '<div class="form-group form-group-sm">';
            html += '<select class="form-control input-sm" name="item_bank_account[' + item_bank_account_row + '][currency_id]" id="item_bank_account_currency_id_' + item_bank_account_row + '" required>';
            html += '<option selected="selected" value="">@lang('message.selectopt')</option>';
            @forelse ($currencies as $currencies_data)
            html += '<option value="{{ $currencies_data->id  }}">{{ $currencies_data->name }}</option>';
            @empty
            @endforelse
            html += '</select>';
            html += '</div>';
            html += '</td>';

            html += '<td>';
            html += '<div class="form-group form-group-sm">';
            html += '<input type="text" class="form-control input-sm text-center" name="item_bank_account[' + item_bank_account_row + '][account_number]" id="item_bank_account_account_number_' + item_bank_account_row + '" required />';
            html += '</div>';
            html += '</td>';

            html += '<td>';
            html += '<div class="form-group form-group-sm">';
            html += '<input type="text" class="form-control input-sm" name="item_bank_account[' + item_bank_account_row + '][name]" id="item_bank_account_name_' + item_bank_account_row + '" required />';
            html += '</div>';
            html += '</td>';


            html += '</tr>';

            $("#form #items_bank_account tbody #add_item_bank_account").before(html);

            item_bank_account_row++;
        }

        //Carga datos

        $('#select_customer').on('change',function(){
          $('#items_bank_account tbody tr').html('');
          var customer_id = $('#select_customer').val();
          var _token = $('input[name="_token"]').val();

          $.ajax({
            type: 'POST',
            url: "/sales/load-data-customer",
            data: {customer_id:customer_id,_token:_token},
            success: function (data){
              //console.log(data);
              var item_bank_account_row=0;
              data.forEach(function(element){
                //console.log(element);
                var html = '';
                html += '<tr id="item_bank_account_row_' + item_bank_account_row + '">';
                html += '<td class="text-center" style="vertical-align: middle;">';
                html += '<button type="button" onclick="$(\'#item_bank_account_row_' + item_bank_account_row + '\').remove();" class="btn btn-xs btn-danger" style="margin-bottom: 0;">';
                html += '<i class="fas fa-trash-alt"></i>';
                html += '</button>';
                html += '<input type="hidden" name="item_bank_account[' + item_bank_account_row + '][id]" id="item_bank_account_id_' + item_bank_account_row + '" /> ';
                html += '</td>';

                html += '<td>';
                html += '<div class="form-group form-group-sm">';
                html += '<select class="form-control input-sm" name="item_bank_account[' + item_bank_account_row + '][bank_id]" id="item_bank_account_bank_id_' + item_bank_account_row + '" required>';
                html += '<option selected="selected" value=""></option>';
                @forelse ($banks as $banks_data)
                if(element.bank_id=={{ $banks_data->id  }}){
                html += '<option value="{{ $banks_data->id  }}" selected>{{ $banks_data->name }}</option>';
                }else{
                html += '<option value="{{ $banks_data->id  }}">{{ $banks_data->name }}</option>';
                }
                @empty
                @endforelse
                html += '</select>';
                html += '</div>';
                html += '</td>';

                html += '<td>';
                html += '<div class="form-group form-group-sm">';
                html += '<select class="form-control input-sm" name="item_bank_account[' + item_bank_account_row + '][currency_id]" id="item_bank_account_currency_id_' + item_bank_account_row + '" required>';
                html += '<option selected="selected" value=""></option>';
                @forelse ($currencies as $currencies_data)
                if(element.currency_id=={{ $currencies_data->id  }}){
                html += '<option value="{{ $currencies_data->id  }}" selected>{{ $currencies_data->name }}</option>';
                }else{
                html += '<option value="{{ $currencies_data->id  }}">{{ $currencies_data->name }}</option>';
                }
                @empty
                @endforelse
                html += '</select>';
                html += '</div>';
                html += '</td>';

                html += '<td>';
                html += '<div class="form-group form-group-sm">';
                html += '<input type="text" class="form-control input-sm text-center" value='+element.account_number+' name="item_bank_account[' + item_bank_account_row + '][account_number]" id="item_bank_account_account_number_' + item_bank_account_row + '" required />';
                html += '</div>';
                html += '</td>';

                html += '<td>';
                html += '<div class="form-group form-group-sm">';
                html += '<input type="text" class="form-control " value='+element.descripcion+'  name="item_bank_account[' + item_bank_account_row + '][name]" id="item_bank_account_name_' + item_bank_account_row + '" required />';
                html += '</div>';
                html += '</td>';


                html += '</tr>';

                $("#form #items_bank_account tbody #add_item_bank_account").before(html);

                item_bank_account_row++;

              });

            },
            error: function (data) {
              Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Algo salió mal!',
                footer: 'Por favor contacta al equipo de desarrollo.'
              });
            }
          });



        });

      $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
      });
    </script>

    <style media="screen">
      .select2-selection__rendered {
        line-height: 44px !important;
        padding-left: 20px !important;
      }
      .select2-selection {
        height: 42px !important;
      }
      .select2-selection__arrow {
        height: 36px !important;
      }
      .toggle.btn {
        min-width: 5rem !important;
      }
      #img_preview {
        margin-top: 20px;
        height: 30%;
        width: 30%;
      }
      #ads {
          margin: 20px 0 0 0;
      }
      #ads .card-notify-badge {
          position: absolute;
          left: 0px;
          top: -10px;
          background: #f2d900;
          text-align: center;
          border-radius: 30px 30px 30px 30px;
          color: #000;
          padding: 5px 20px;
          font-size: 14px;

      }
      #ads .card-detail-badge {
          background: #f2d900;
          text-align: center;
          border-radius: 30px 30px 30px 30px;
          color: #000;
          padding: 5px 10px;
          font-size: 14px;
      }
      .tab-content {
      	border: 1px solid $border-color;
      	border-top: 0;
      	padding: 2rem 1.5rem;
      	text-align: justify;
      	&.tab-content-vertical {
      		border-top: 1px solid $border-color;
      	}
      	&.tab-content-vertical-custom {
      		border: 0;
      		padding-top: 0;
      	}
      	&.tab-content-custom-pill {
      		border: 0;
      		padding-left: 0;
      	}
      }
      .test_btm {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        padding-top: 1;
        display: block;
        height: calc(1.8em + 0.75rem);
        padding: 0.5rem 0.75rem;
        line-height: 1.5;
      }
      /**/
      .custom-file {
      	position: relative;
      	display: inline-block;
      	width: 100%;
        height: calc(1.8em + 0.75rem) !important;
      	margin-bottom: 0
      }

      .custom-file-input {
      	position: relative;
      	z-index: 3;
      	width: 100%;
        height: calc(1.8em + 0.75rem) !important;
      	margin: 0;
      	opacity: 0
      }

      .custom-file-input:focus~.custom-file-control {
      	border-color: #007bff !important;
      	box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .25)
      }

      .custom-file-input:focus~.custom-file-control::before {
      	border-color: #007bff !important;
      }

      .custom-file-label {
      	position: absolute;
      	top: 0;
      	right: 0;
      	left: 0;
      	z-index: 1;
      	height: calc(2.25rem + 2px);
      	padding: .375rem .75rem;
      	line-height: 1.5;
      	color: #495057;
      	background-color: #fff;
      	border: 1px solid #ced4da;
      	border-radius: .25rem
      }

      .custom-file-label::after {
      	position: absolute;
      	top: 0;
      	right: 0;
      	bottom: 0;
      	z-index: 3;
      	display: block;
      	height: calc(calc(2.25rem + 2px) - 1px * 2);
      	padding: .375rem .75rem;
      	line-height: 1.5;
      	color: #fff;
      	content: "Subir";
      	background-color: #007bff !important;
      	border-left: 1px solid #007bff !important;
      	border-radius: 0 .25rem .25rem 0
      }
      /**/
      .custom-file-input.is-valid~.custom-file-label,
      .was-validated .custom-file-input:valid~.custom-file-label {
      	border-color: #28a745
      }

      .custom-file-input.is-valid~.custom-file-label::before,
      .was-validated .custom-file-input:valid~.custom-file-label::before {
      	border-color: inherit
      }

      .custom-file-input.is-valid~.valid-feedback,
      .custom-file-input.is-valid~.valid-tooltip,
      .was-validated .custom-file-input:valid~.valid-feedback,
      .was-validated .custom-file-input:valid~.valid-tooltip {
      	display: block
      }

      .custom-file-input.is-valid:focus~.custom-file-label,
      .was-validated .custom-file-input:valid:focus~.custom-file-label {
      	box-shadow: 0 0 0 .2rem rgba(40, 167, 69, .25)
      }
      .custom-file-input.is-invalid~.custom-file-label,
      .was-validated .custom-file-input:invalid~.custom-file-label {
      	border-color: #dc3545
      }

      .custom-file-input.is-invalid~.custom-file-label::before,
      .was-validated .custom-file-input:invalid~.custom-file-label::before {
      	border-color: inherit
      }

      .custom-file-input.is-invalid~.invalid-feedback,
      .custom-file-input.is-invalid~.invalid-tooltip,
      .was-validated .custom-file-input:invalid~.invalid-feedback,
      .was-validated .custom-file-input:invalid~.invalid-tooltip {
      	display: block
      }

      .custom-file-input.is-invalid:focus~.custom-file-label,
      .was-validated .custom-file-input:invalid:focus~.custom-file-label {
      	box-shadow: 0 0 0 .2rem rgba(220, 53, 69, .25)
      }
    </style>
    @else
    @endif
@endpush
