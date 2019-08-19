@extends('layouts.admin')

@section('contentheader_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
    {{ trans('invoicing.companies') }}
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('breadcrumb_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
    {{ trans('invoicing.companies') }}
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('content')
  {{-- @if( auth()->user()->can('View cover') ) --}}
<form id="form" name="form" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="col-md-12 col-xl-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body dashboard-tabs p-0">
        <ul class="nav nav-tabs px-4" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true"><i class="fas fa-search"></i> General</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false"><i class="fas fa-address-card"></i> Dirección</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="certificate-tab" data-toggle="tab" href="#certificate" role="tab" aria-controls="certificate" aria-selected="false"><i class="fas fa-key"></i> Certificado de sello digital</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="accounts-tab" data-toggle="tab" href="#accounts" role="tab" aria-controls="accounts" aria-selected="false"><i class="fas fa-money-check-alt"></i> Cuentas bancarias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="setting-tab" data-toggle="tab" href="#setting" role="tab" aria-controls="setting" aria-selected="false"><i class="fas fa-tools"></i> Configuración</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
            <div class="media">
              <div class="media-body">
                <!-------------------------------------------------------------------------------->
                <div class="row">
                  <!-------------------------------------------------------------------------------->
                  <div id="ads" class="col-md-6">
                    <div class="card rounded">
                      <div class="card-image">
                        <span class="card-notify-badge">Preview</span>
                        <img id="img_preview" name="img_preview" src="@forelse ($company as $data_company) {{ '../images/storage/'.$data_company->image }} @empty {{ asset('img/company/Default.svg') }}  @endforelse" alt="Alternate Text" class="img-responsive mx-auto d-block"/>
                      </div>
                      <div class="mt-3">
                        <div class="form-group">
                          <div id="cont_file" class="">
                            <div class="input-group">
                              <label class="input-group-btn">
                                <span class="btn btn-primary">
                                  Imagen <input id="fileInput" name="fileInput" type="file" style="display: none;"
                                  @if(isset($question_a))
                                      @if ($question_a == '0')
                                        class="required"
                                      @else
                                        class=""
                                      @endif
                                  @endif
                                  >
                                </span>
                              </label>
                              <input type="text" class="form-control" value="@forelse ($company as $data_company) {{ '../images/storage/'.$data_company->image }} @empty {{ asset('img/company/Default.svg') }}  @endforelse" readonly>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label for="inputCreatName" class="col-sm-3 col-form-label">Nombre <span style="color: red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm required" id="inputCreatName" name="inputCreatName" placeholder="Nombre de la empresa"
                          value="@if(isset($company[0]->name)){{$company[0]->name}}@endif" maxlength="60">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputCreatRFC" class="col-sm-3 col-form-label">RFC <span style="color: red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm required" id="inputCreatRFC" name="inputCreatRFC" placeholder="RFC"
                        value="@if(isset($company[0]->taxid)){{$company[0]->taxid}}@endif" maxlength="12">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputCreatEmail" class="col-sm-3 col-form-label">Correo electrónico<span style="color: red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="email" class="form-control form-control-sm required" id="inputCreatEmail" name="inputCreatEmail" placeholder="Correo electrónico"
                        value="@if(isset($company[0]->email)){{$company[0]->email}}@endif" maxlength="100">
                      </div>
                    </div>
                  </div>
                  <!-------------------------------------------------------------------------------->
                  <div class="col-md-12">
                    <div class="row mt-3">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Telefono:</label>
                          <input maxlength="12" type="text" class="form-control onlynumber" id="inputCreatPhone" name="inputCreatPhone"
                          value="@if(isset($company[0]->phone)){{$company[0]->phone}}@endif" placeholder="Ingrese el núm. telefono">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Telefono movil:</label>
                          <input maxlength="12" type="text" class="form-control onlynumber" id="inputCreatMobile" name="inputCreatMobile"
                          value="@if(isset($company[0]->phone_mobile)){{$company[0]->phone_mobile}}@endif" placeholder="Ingrese el núm. telefono movil">
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="select_seven" class="col-md-12 col-form-label ml-0">Régimen fiscal<span style="color: red;">*</span></label>
                          <div class="col-md-12 ml-0">
                            <select  id="select_seven" name="select_seven" class="form-control form-control-sm required"  style="width: 100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @forelse ($taxregimen as $taxregimen_data)
                                @if(isset($company[0]->tax_regimen_id))
                                  @if ($company[0]->tax_regimen_id === $taxregimen_data->id)
                                    <option value="{{ $taxregimen_data->id  }}" selected>{{ $taxregimen_data->name }}</option>
                                  @else
                                    <option value="{{ $taxregimen_data->id  }}">{{ $taxregimen_data->name }}</option>
                                  @endif
                                @else
                                  <option value="{{ $taxregimen_data->id  }}">{{ $taxregimen_data->name }}</option>
                                @endif
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row mt-3">
                          <label for="status" class="col-md-12 control-label">Estatus</label>
                          <div class="col-md-12 mb-3">
                            <input id="status" name="status" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="@if(isset($company[0]->status)){{$company[0]->status}}@else{{0}}@endif">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="datainfo">Información adicional</label>
                          <textarea class="form-control" id="datainfo" name="datainfo" rows="4">@if(isset($company[0]->comment)){{$company[0]->comment}}@endif</textarea>
                        </div>
                      </div>

                    </div>
                  </div>
                  <!-------------------------------------------------------------------------------->
                </div>
                <!-------------------------------------------------------------------------------->
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
            <div class="media">
              <div class="media-body">
                <!-------------------------------------------------------------------------------->
                <div class="row">
                  <div class="col-md-12">
                    <!-------------------------------------------------------------------------------->
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Direccion:<span style="color: red;">*</span></label>
                          <input maxlength="100" type="text" class="form-control required" id="inputCreatAddress_1" name="inputCreatAddress_1" placeholder="Direccion"
                          value="@if(isset($company[0]->address_1)){{$company[0]->address_1}}@endif">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Num. Ext:</label>
                          <input type="text" class="form-control" id="inputCreatAddress_2" name="inputCreatAddress_2" placeholder="" maxlength="50"
                          value="@if(isset($company[0]->address_2)){{$company[0]->address_2}}@endif">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Num Int.</label>
                          <input type="text" class="form-control" id="inputCreatAddress_3" name="inputCreatAddress_3" placeholder="" maxlength="50"
                          value="@if(isset($company[0]->address_3)){{$company[0]->address_3}}@endif">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Colonia:</label>
                          <input type="text" class="form-control" id="inputCreatAddress_4" name="inputCreatAddress_4" placeholder="" maxlength="100"
                          value="@if(isset($company[0]->address_4)){{$company[0]->address_4}}@endif">
                        </div>
                      </div>
                    </div>
                    <!-------------------------------------------------------------------------------->
                  </div>
                </div>
                <!-------------------------------------------------------------------------------->
                <div class="row mt-3">
                  <div class="col-md-12">
                    <!-------------------------------------------------------------------------------->
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Localidad:</label>
                          <input type="text" class="form-control" id="inputCreatAddress_5" name="inputCreatAddress_5" placeholder="" maxlength="50"
                          value="@if(isset($company[0]->address_5)){{$company[0]->address_5}}@endif">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Referencia:</label>
                          <input type="text" class="form-control" id="inputCreatAddress_6" name="inputCreatAddress_6" placeholder="" maxlength="50"
                          value="@if(isset($company[0]->address_6)){{$company[0]->address_6}}@endif">
                        </div>
                      </div>
                    </div>
                    <!-------------------------------------------------------------------------------->
                  </div>
                </div>
                <!-------------------------------------------------------------------------------->
                <div class="row mt-3">
                  <div class="col-md-12">
                    <!-------------------------------------------------------------------------------->
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="select_six" class="control-label">Paises:<span style="color: red;">*</span></label>
                            <select id="select_six" name="select_six" class="form-control required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @forelse ($countries as $countries_data)
                                @if(isset($company[0]->country_id))
                                  @if ($company[0]->country_id === $countries_data->id)
                                    <option value="{{ $countries_data->id }}" selected> {{ $countries_data->name }} </option>
                                  @else
                                    <option value="{{ $countries_data->id }}"> {{ $countries_data->name }} </option>
                                  @endif
                                @else
                                  <option value="{{ $countries_data->id }}"> {{ $countries_data->name }} </option>
                                @endif
                              @empty
                              @endforelse
                            </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="select_eight" class="control-label">Estados:<span style="color: red;">*</span></label>
                            <select id="select_eight" name="select_eight" class="form-control required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @forelse ($states as $states_data)
                                @if(isset($company[0]->state_id))
                                  @if ($company[0]->state_id === $states_data->id)
                                    <option value="{{ $states_data->id }}" selected> {{ $states_data->name }} </option>
                                  @else
                                    <option value="{{ $states_data->id }}"> {{ $states_data->name }} </option>
                                  @endif
                                @else
                                  <option value="{{ $states_data->id }}"> {{ $states_data->name }} </option>
                                @endif
                              @empty
                              @endforelse
                            </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="select_nine" class="control-label">Ciudades:<span style="color: red;">*</span></label>
                            <select id="select_nine" name="select_nine" class="form-control required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @forelse ($cities as $cities_data)
                                @if(isset($company[0]->city_id))
                                  @if ($company[0]->city_id === $cities_data->id)
                                    <option value="{{ $cities_data->id }}" selected> {{ $cities_data->name }} </option>
                                  @else
                                    <option value="{{ $cities_data->id }}"> {{ $cities_data->name }} </option>
                                  @endif
                                @else
                                  <option value="{{ $cities_data->id }}"> {{ $cities_data->name }} </option>
                                @endif
                              @empty
                              @endforelse
                            </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Codigo Postal: <span style="color: red;">*</span></label>
                          <input type="text" class="form-control required onlynumber" id="inputPostcode" name="inputPostcode" placeholder="" maxlength="5"
                          value="@if(isset($company[0]->postcode)){{$company[0]->postcode}}@endif">
                        </div>
                      </div>



                    </div>
                    <!-------------------------------------------------------------------------------->
                  </div>
                </div>
                <!-------------------------------------------------------------------------------->
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="certificate" role="tabpanel" aria-labelledby="certificate-tab">
            <div class="media">
              <div class="media-body">
                <!-------------------------------------------------------------------------------->
                <input class="form-control" type="hidden" placeholder="" id="file_pfx" name="file_pfx" value="">

                <div class="row">
                  <div class="col-md-12">
                    <div  class="form-group row">
                      <label for="select_six" class="col-sm-3 col-form-label">Certificado (.cer)<span style="color: red;">*</span></label>
                      <div class="col-sm-9">
                <!-----><div id="cont_file_file_cer"><!----->
                          <div class="input-group mb-3">
                            <div class="custom-file">
                                <input  datas="file_file_cer" type="file"
                                @if(isset($question_a))
                                    @if ($question_a == '0')
                                      class="btn btn-danger custom-file-input required"
                                    @else
                                      class="btn btn-danger custom-file-input"
                                    @endif
                                @endif
                                id="file_file_cer" name="file_file_cer" value="">
                                <label class="custom-file-label" for="file_file_cer">Choose file</label>
                            </div>
                            <div class="input-group-append">
                              <button class="btn btn-danger test_btm" type="button">Eliminar</button>
                            </div>
                          </div>
                <!-----></div><!----->
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="select_six" class="col-sm-3 col-form-label">Llave privada (.key)<span style="color: red;">*</span></label>
                      <div class="col-sm-9">
                <!-----><div id="cont_file_file_key"><!----->
                          <div class="input-group mb-3">
                            <div class="custom-file">
                                <input datas="file_file_key" type="file"
                                @if(isset($question_a))
                                    @if ($question_a == '0')
                                      class="btn btn-danger custom-file-input required"
                                    @else
                                      class="btn btn-danger custom-file-input"
                                    @endif
                                @endif
                                id="file_file_key" name="file_file_key" value="">
                                <label class="custom-file-label" for="file_file_key"> Choose file</label>
                            </div>
                            <div class="input-group-append">
                              <button class="btn btn-danger test_btm" type="button">Eliminar</button>
                            </div>
                          </div>
                <!-----></div><!----->
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="password_key" class="col-sm-3 col-form-label">Contraseña de llave privada <span style="color: red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text"
                        @if(isset($question_a))
                            @if ($question_a == '0')
                              class="form-control form-control-sm required"
                            @else
                              class="form-control form-control-sm"
                            @endif
                        @endif
                        class="form-control form-control-sm required"
                        id="password_key" name="password_key" placeholder="Contraseña" maxlength="60">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="certificate_number" class="col-sm-3 col-form-label">Número certificado</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="certificate_number" name="certificate_number" placeholder="" maxlength="60" readonly
                        value="@if(isset($company[0]->certificate_number)){{$company[0]->certificate_number}}@endif">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="date_start" class="col-sm-3 col-form-label">Fecha inicial</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm datepickercomplete onlynumber" id="date_start" name="date_start" placeholder="" value="@if(isset($company[0]->date_start)){{$company[0]->date_start}}@endif" readonly>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="date_end" class="col-sm-3 col-form-label">Fecha final</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm datepickercomplete onlynumber" id="date_end" name="date_end" placeholder="" value="@if(isset($company[0]->date_end)){{$company[0]->date_end}}@endif"readonly>
                      </div>
                    </div>

                  </div>
                </div>
                <!-------------------------------------------------------------------------------->
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="accounts" role="tabpanel" aria-labelledby="accounts-tab">
            <div class="media">
              <div class="media-body">
                <!---------------------------------------------------------------------------------->
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="table-responsive">
                            <div class="hidden" id="delete_items_bank_account">
                              @foreach(old('delete_item_bank_account',[]) as $tmp)
                                  <input type="text" name="delete_item_bank_account[]" value="{{ $tmp }}"/>
                              @endforeach
                            </div>
                            <table class="table table-items table-condensed table-hover table-bordered table-striped"
                                    id="items_bank_account">
                                <thead>
                                <tr>
                                    <th width="5%"
                                        class="text-center">Opciones</th>
                                    <th width="15%"
                                        class="text-center">Banco</th>
                                    <th width="15%"
                                        class="text-center">Moneda</th>
                                    <th width="25%"
                                        class="text-center">Número de cuenta</th>
                                    <th width="40%"
                                        class="text-left">Descripción</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Items -->
                                @php
                                    $item_bank_account_row = 0;
                                    $items_bank_account = old('item_bank_account',$company_account);
                                    //$items_bank_account = old('item_bank_account',[]);
                                @endphp
                                @foreach ($items_bank_account as $item_bank_account_row => $item)
                                    @php
                                    // echo $item_bank_account_row.'/';
                                    // print_r($item);
                                    @endphp
                                    <tr id="item_bank_account_row_{{ $item_bank_account_row }}">
                                        <td class="text-center"
                                            style="vertical-align: middle;">
                                            <button type="button"
                                                    onclick="deleteItemBankAccount('{{old('item_bank_account.' . $item_bank_account_row . '.id',$item->id)}}');$('#item_bank_account_row_{{ $item_bank_account_row }}').remove();"
                                                    class="btn btn-xs btn-danger"
                                                    style="margin-bottom: 0;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                            <!-- input hidden -->
                                            <input type="hidden"
                                                id="item_bank_account_id_{{ $item_bank_account_row }}"
                                                name="item_bank_account[{{ $item_bank_account_row }}][id]"
                                                value="{{ old('item_bank_account.' . $item_bank_account_row . '.id',$item->id) }}">
                                        </td>
                                        <td>
                                          <div class="form-group form-group-sm">
                                            @php
                                            // echo $item->bank_id;
                                            @endphp

                                            <select class="form-control input-sm"  id="item_bank_account{{ $item_bank_account_row.'['.$item->bank_id.']' }}" name="item_bank_account[{{ $item_bank_account_row }}][bank_id]" required>
                                              <option selected="selected" value="">{{ trans('message.selectopt') }}</option>
                                              @forelse ($banks as $banks_data)
                                                {{-- <option value="{{ $banks_data->id  }}">{{ $banks_data->name }}</option> --}}
                                                @if(isset($item->bank_id))
                                                    @if ($item->bank_id === $banks_data->id)
                                                      <option value="{{ $banks_data->id  }}" selected>{{ $banks_data->name }}</option>
                                                    @else
                                                      <option value="{{ $banks_data->id  }}">{{ $banks_data->name }}</option>
                                                    @endif
                                                @else
                                                  <option value="{{ $banks_data->id  }}">{{ $banks_data->name }}</option>
                                                @endif
                                              @empty
                                              @endforelse
                                            </select>
                                          </div>
                                        </td>
                                        <td>
                                          <div class="form-group form-group-sm">
                                            <select class="form-control input-sm"  id="item_bank_account{{ $item_bank_account_row.'['.$item->currency_id.']'}}" name="item_bank_account[{{ $item_bank_account_row }}][currency_id]" required>
                                              <option selected="selected" value="">{{ trans('message.selectopt') }}</option>
                                              @forelse ($currencies as $currencies_data)
                                                @if(isset($item->currency_id))
                                                    @if ($item->currency_id === $currencies_data->id)
                                                      <option value="{{ $currencies_data->id  }}" selected>{{ $currencies_data->name }}</option>
                                                    @else
                                                      <option value="{{ $currencies_data->id  }}">{{ $currencies_data->name }}</option>
                                                    @endif
                                                @else
                                                  <option value="{{ $currencies_data->id  }}">{{ $currencies_data->name }}</option>
                                                @endif
                                              @empty
                                              @endforelse
                                            </select>
                                          </div>
                                        </td>
                                        <td>
                                          <div class="form-group form-group-sm">
                                            <input type="text" class="form-control input-sm text-center"
                                            id="item_bank_account{{ $item_bank_account_row.'['.$item->account_number.']'}}"
                                            name="item_bank_account[{{ $item_bank_account_row }}][account_number]"
                                            value="{{old('item_bank_account.' . $item_bank_account_row . '.account_number',$item->account_number)}}"
                                            required />
                                          </div>
                                        </td>
                                        <td>
                                          <div class="form-group form-group-sm">
                                            <input type="text" class="form-control input-sm"
                                            id="item_bank_account{{ $item_bank_account_row.'['.$item->name.']'}}"
                                            name="item_bank_account[{{ $item_bank_account_row }}][name]"
                                            value="{{ old('item_bank_account.' . $item_bank_account_row . '.name',$item->name)}}"
                                             required />
                                          </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @php
                                    $item_bank_account_row++;
                                @endphp
                                <!-- /Items -->
                                <!-- Agregar nuevo item -->
                                <tr id="add_item_bank_account">
                                    <td class="text-center">
                                        <button type="button"
                                                onclick="addItemBankAccount();"
                                                class="btn btn-xs btn-primary"
                                                style="margin-bottom: 0;">
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
          <div class="tab-pane fade" id="setting" role="tabpanel" aria-labelledby="setting-tab">
            <div class="media">
              <div class="media-body">
                <div class="row mt-3">
                  <div class="col-md-12">
                    <!-------------------------------------------------------------------------------->
                    <div class="row">

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="select_cfdi" class="control-label">Versión de CFDI<span style="color: red;">*</span></label>
                          <select id="select_cfdi" name="select_cfdi" class="form-control required" style="width:100%;">
                            <option value="cfdi33">CFDI 3.3</option>
                          </select>
                        </div>
                      </div>


                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="select_pacs" class="control-label">Seleccion de PAC:<span style="color: red;">*</span></label>
                          <select id="select_pacs" name="select_pacs" class="form-control required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @forelse ($pacs as $pacs_data)
                                @if(isset($pacs2[0]->value))
                                    @if ($pacs2[0]->value === '0')
                                      <option value="{{ $pacs_data->id  }}">{{ $pacs_data->name }}</option>
                                    @elseif($pacs2[0]->value == $pacs_data->id)
                                      <option value="{{ $pacs_data->id  }}" selected>{{ $pacs_data->name }}</option>
                                    @else
                                      <option value="{{ $pacs_data->id  }}">{{ $pacs_data->name }}</option>
                                    @endif
                                @else
                                  <option value="{{ $pacs_data->id  }}">{{ $pacs_data->name }}</option>
                                @endif
                              @empty
                              @endforelse
                          </select>
                        </div>
                      </div>
                    </div>
                    <!-------------------------------------------------------------------------------->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-muted">
          @if(isset($question_a))
              @if ($question_a == '0')
                <button class="btn btn-danger mt-2 mt-xl-0">Crear</button>
              @else
                <button class="btn btn-danger mt-2 mt-xl-0">Actualizar</button>
              @endif
          @endif
        </div>
      </div>
    </div>
  </div>
</form>
  {{-- @else --}}
  {{-- @endif --}}
@endsection

@push('scripts')
    {{-- @if( auth()->user()->can('View cover') ) --}}
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
    <script src="{{ asset('js/admin/base/default_companies.js')}}"></script>
    @if(isset($question_a))
        @if ($question_a == '0')
          <script src="{{ asset('js/admin/base/companies.js')}}"></script>
        @else
          <script src="{{ asset('js/admin/base/act_companies.js')}}"></script>
        @endif
    @endif

    <script type="text/javascript">
        function deleteItemBankAccount(id) {
            if(id) {
                let html = '<input type="text" name="delete_item_bank_account[]" value="'+id+'"/>';
                $('#form #delete_items_bank_account').append(html);
            }
        }

        var item_bank_account_row = "{{ $item_bank_account_row }}";

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
    {{-- @else --}}
    {{-- @endif  --}}
@endpush
