@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View add request of travel expenses') )
    {{ trans('message.viaticos_add_request') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View add request of travel expenses') )
    {{ trans('message.viaticos') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View add request of travel expenses') )
      <!--  Content create survey -->
      <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div style="padding:10px; width: 100%">
                    @if (session('status'))
                    <div class="alert alert-success">
                      {{ session('status') }}
                    </div>
                    @endif
                    <div id="exampleValidator" class="wizard">
                        <ul class="wizard-steps" role="tablist">
                            <li class="active" role="tab">
                                <h4><span><i class="fa fa-address-card"></i></span>Requerimientos</h4>
                            </li>
                            <li role="tab">
                                <h4><span><i class="fa fa-list-ol"></i></span>Conceptos</h4>
                            </li>
                            <!-- <li role="tab">
                                <h4><span><i class="fa fa-save"></i></span>Password</h4> </li> -->
                        </ul>
                        <form id="validation" name="validation" class="form-horizontal" action="{{ url('create_viatic_new') }}" method="POST" >
                          {{ csrf_field() }}
                            <div class="wizard-content">
                                <div class="wizard-pane active" role="tabpanel">
                                  <div class="row">
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6"></div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                      <div class="form-group">
                                        <label class="col-xs-2 control-label">Prioridad</label>
                                        <div class="col-xs-10 selectContainer">
                                            <select name="priority_id" class="form-control">
                                                @forelse ($priority as $data_priority)
                                                  @if ($data_priority->id === 1)
                                                    <option value="{{ $data_priority->id }}" selected> {{ $data_priority->name }} </option>
                                                  @else
                                                    <option value="{{ $data_priority->id }}"> {{ $data_priority->name }} </option>
                                                  @endif
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                      </div>

                                    </div>
                                  </div>


                                    <div class="row">
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <label class="col-xs-2 control-label">Servicio</label>
                                          <div class="col-xs-10 selectContainer">
                                              <select name="service_id" class="form-control">
                                                  <option value="" selected></option>
                                                  @forelse ($service as $data_service)
                                                    <option value="{{ $data_service->id }}"> {{ $data_service->name }} </option>
                                                  @empty
                                                  @endforelse
                                              </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <label class="col-xs-2 control-label">Autoriza</label>
                                          <div class="col-xs-10 selectContainer">
                                              <select name="gerente_id" class="form-control">
                                                  <option value="" selected></option>
                                                  @forelse ($jefe as $data_jefe)
                                                    <option value="{{ $data_jefe->id }}"> {{ $data_jefe->Nombre }} </option>
                                                  @empty
                                                  @endforelse
                                              </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <label class="col-xs-2 control-label">Departamento</label>
                                          <div class="col-xs-10 selectContainer">
                                              <select name="beneficiario_id" class="form-control benef">
                                                <option value="" selected></option>
                                                @forelse ($beneficiary as $data_beneficiary)
                                                  <option value="{{ $data_beneficiary->id }}"> {{ $data_beneficiary->name }} </option>
                                                @empty
                                                @endforelse
                                              </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <label class="col-xs-2 control-label">Solicitante</label>
                                          <div class="col-xs-10 selectContainer">
                                              <select name="user_id" class="form-control">
                                                <option value="" selected></option>
                                              </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                           <label class="col-xs-3 control-label">Fecha Inicio</label>
                                           <div class="col-xs-9 dateContainer">
                                               <div class="input-group input-append date" id="startDatePicker" name="startDatePicker">
                                                   <input type="text" class="form-control" name="startDate" />
                                                   <span class="input-group-addon add-on"><span class="far fa-calendar-alt fa-3x"></span></span>
                                               </div>
                                           </div>
                                        </div>
                                      </div>
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <label class="col-xs-3 control-label">Fecha Fin</label>
                                          <div class="col-xs-9 dateContainer">
                                              <div class="input-group input-append date" id="endDatePicker" name="endDatePicker">
                                                  <input type="text" class="form-control" name="endDate" />
                                                  <span class="input-group-addon add-on"><span class="far fa-calendar-alt fa-3x"></span></span>
                                              </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                           <label class="col-xs-3 control-label">Lugar Origen</label>
                                           <div class="col-xs-9">
                                               <input type="text" class="form-control" name="place_o" />
                                           </div>
                                        </div>
                                      </div>
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                           <label class="col-xs-3 control-label">Lugar Destino</label>
                                           <div class="col-xs-9">
                                               <input type="text" class="form-control" name="place_d" />
                                           </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-lg-12">
                                        <div class="form-group">
                                          <label class="col-xs-1 control-label">Descripción</label>
                                          <div class="col-xs-11">
                                              <textarea class="form-control" name="descripcion" rows="3"></textarea>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <!--..........................................................................-->
                                </div>

                                <div class="wizard-pane" id="validationW2" role="tabpanel">



                                    <div class="row">
                                      <!-- <input type="text" name="array_vacio" id="array_vacio"> -->

                                        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1">
                                          <label for="ejemplo_email_3" class="control-label">{{ trans('general.cadena') }}</label>
                                            <select name="c_venue[0].venue" class="form-control info-cadena"  data_row="0">
                                                <option value="" selected>Elige {{ trans('general.hotel') }}</option>
                                                <option value="31"> SITWIFI </option>
                                                <option value="103">Prospectos ( Comercial )</option>
                                                @forelse ($cadena as $data_cadena)
                                                  @if($data_cadena->id != 103 && $data_cadena->id != 31)
                                                    <option  value="{{ $data_cadena->id }}"> {{ $data_cadena->name }} </option>
                                                  @endif
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2">
                                          <label for="ejemplo_email_3" class="col-xs-12">{{ trans('general.hotel') }}</label>
                                          <select name="c_hotel[0].hotel" class="form-control">
                                              <option value="" selected>Elige {{ trans('general.hotel') }}</option>
                                          </select>
                                        </div>

                                        <!-- input de fecha  -->

                                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2" style="width: 10%">
                                          <label for="ejemplo_email_3" class="col-xs-12">Fecha</label>
                                          <input class="form-control pickerV" type="text" name="c_date[0]">
                                        </div>

                                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2">
                                            <label for="ejemplo_email_3" class="col-xs-12">Concepto</label>
                                            <select name="c_concept[0].concept" class="form-control">
                                                <option value="" selected>Elige concepto</option>
                                                @forelse ($concept as $data_concept)
                                                  <option value="{{ $data_concept->id }}"> {{ $data_concept->name }} </option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1" style="width: 12.499999995%">
                                            <label for="ejemplo_email_3" class="col-xs-12">Cantidad</label>
                                            <select name="c_cant[0].cant" class="form-control">
                                                <option value="" selected>Elige</option>
                                                @for ($i = 1; $i <= 50; $i++)
                                                    <option value="{{ $i }}"> {{ $i }} </option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2" style="width: 12.499999995%">
                                            <label for="ejemplo_email_3" class="col-xs-12">Costo</label>
                                            <input type="text" class="form-control" name="c_priceuni[0].priceuni" placeholder="Costo" />
                                        </div>
                                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2">
                                            <label for="ejemplo_email_3" class="col-xs-12">Subtotal</label>
                                            <input type="text" class="form-control subtotal" name="c_price[0].price" placeholder="Subtotal" readonly/>
                                        </div>

                                        <br></br>
                                        <br></br>

                                        <div class="col-xs-8 pull-right" style="width: 100%">
                                          <div class="form-group pull-right">
                                            <label for="ejemplo_email_3" class="col-xs-3">Justificación</label>
                                            <div class="col-xs-9">
                                              <input type="text" class="form-control" name="c_just[0].just"/>
                                            </div>
                                          </div>
                                        </div>

                                    </div>


                                    <!-- Div de copia Add button. -->
                                    <div class="form-group hide mt-3" id="optionTemplate">
                                      <div class="row">
                                        <div class="col-md-11 col-lg-11 col-sm-11 col-xs-11">&nbsp;</div>
                                        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1">
                                            <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 info-cadena">
                                          <select name="venue" class="form-control info-cadena" data_row="">
                                              <option value="" selected>Elige Proyecto</option>
                                              @forelse ($cadena as $data_cadena)
                                                <option value="{{ $data_cadena->id }}"> {{ $data_cadena->name }} </option>
                                              @empty
                                              @endforelse
                                          </select>
                                        </div>
                                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2">
                                          <select name="hotel" class="form-control">
                                              <option value="" selected>Elige Sitio</option>
                                          </select>
                                        </div>

                                        <!-- input de fecha  -->
                                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2" style="width: 10%">
                                          <input class="form-control pickerV" type="text" name="date">
                                        </div>

                                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2">
                                          <select name="concept" class="form-control">
                                              <option value="" selected>Elige Concepto</option>
                                              @forelse ($concept as $data_concept)
                                                <option value="{{ $data_concept->id }}"> {{ $data_concept->name }} </option>
                                              @empty
                                              @endforelse
                                          </select>
                                        </div>
                                        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1" style="width: 12.499999995%">
                                          <select name="cant" class="form-control">
                                            <option value="" selected>Elige cantidad</option>
                                            @for ($i = 1; $i <= 50; $i++)
                                                <option value="{{ $i }}"> {{ $i }} </option>
                                            @endfor
                                          </select>
                                        </div>
                                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2" style="width: 12.499999995%">
                                          <input type="text" class="form-control" name="priceuni" placeholder="Costo" />
                                        </div>
                                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2">
                                          <input type="text" class="form-control subtotal" name="price" placeholder="Subtotal" readonly/>
                                        </div>

                                        <div class="mt-1 col-xs-8 pull-right" style="width: 100%">
                                          <div class="form-group pull-right">
                                            <label for="ejemplo_email_3" class="col-xs-3">Justificación</label>
                                            <div class="col-xs-9">
                                              <input type="text" class="form-control" name="just"/>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <!--  <div class="col-xs-6 pull-left">
                                        <select name="slc_plantilla" id="slc_plantilla" class="form-control select2">
                                          <option value="" selected>Elige plantilla</option>
                                            @forelse ($plantilla as $data_plantilla)
                                              <option value="{{ $data_plantilla->id }}"> {{ $data_plantilla->name }} </option>
                                            @empty
                                            @endforelse
                                        </select>
                                      </div>
                                      <div class="col-xs-4">
                                        <button class="btn btn-primary" type="button" id="btn_plantilla">Añadir</button>
                                      </div> -->
                                      <div class="col-md-11 col-lg-11 col-sm-11 col-xs-11">&nbsp;</div>
                                      <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1">
                                          <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
                                      </div>
                                    </div>

                                    <br>


                                    <div class="form-group">
                                      <div class="col-lg-3 float-right">
                                        <div class="form-group float-right">
                                           <label class="col-xs-2 control-label">Total</label>
                                           <div class="col-xs-10">
                                               <input type="text" class="form-control" name="totales" readonly/>
                                           </div>
                                          <div class="float-right">
                                           <span class="text-danger">Nota: Cantidades en MXN</span>
                                          </div>
                                        </div>
                                      </div>

                                    </div>

                                    <div class="row">
                                      <!-- <div class="col-lg-8">
                                        <textarea name="obs_conc" class="form-control" placeholder="Favor de justificar conceptos." style="width: 100%; height:100px;"></textarea>
                                      </div> -->
                                    </div>

                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
      </div>
      @else
        <!--NO VER-->
      @endif
@endsection

@push('scripts')
    @if( auth()->user()->can('View add request of travel expenses') )

          <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
          <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

          <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/css/wizard.css')}}" >

          <!-- Form Wizard JavaScript -->
          <script src="{{ asset('plugins/jquery-wizard-master/dist/jquery-wizard.js')}}"></script>
          <!-- FormValidation -->
          <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
          <!-- FormValidation plugin and the class supports validating Bootstrap form -->
          <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
          <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>
          <style media="screen">
            .wizard-steps{display:table;width:100%}
            .wizard-steps>li{
              display:table-cell;
              padding:10px 20px;
              background:#f7fafc
            }
            .wizard-steps>li span{
              border-radius:100%;
              border:1px solid rgba(120,130,140,.13);
              width:40px;
              height:40px;
              display:inline-block;
              vertical-align:middle;
              padding-top:9px;
              margin-right:8px;
              text-align:center
            }
            .wizard-content{
              padding:25px;
              border-color:rgba(120,130,140,.13);
              margin-bottom:30px
            }
            .wizard-steps>li.current,.wizard-steps>li.done{
              background:#228AE6;
              color:#fff
             }
             .wizard-steps>li.current span,.wizard-steps>li.done span{
               border-color:#fff;color:#fff
             }
             .wizard-steps>li.current h4,.wizard-steps>li.done h4{
               color:#fff
             }
             .wizard-steps>li.done{
               background:#1ED760
             }
             .wizard-steps>li.error{
               background:#E73431
             }
          </style>
          <script src="{{ asset('js/admin/viaticos/add_request2_via.js?v=2.0.0')}}"></script>

        @else
          <!--NO VER-->
        @endif
@endpush
