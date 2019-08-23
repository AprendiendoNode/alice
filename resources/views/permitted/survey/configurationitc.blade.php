@extends('layouts.admin')

@section('contentheader_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  Configuración de mis sitios
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('breadcrumb_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  Configuración de mis sitios
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('content')
  {{-- @if( auth()->user()->can('View cover') ) --}}


    <div class="row">
      <div class="col-md-12 grid-margin-onerem  stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="mt-2 card-title">Esta sección nos permite gestionar los clientes de tus sitios asignados.</p>
            <div class="d-flex justify-content-center pt-3"></div>

            <div class="row">
              <div class="col-12">
                <div class="table-responsive">
                  <table id="table_config" name='table_config' class="table table-striped border display nowrap" style="width:100%; font-size: 10px;">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Estatus</th>
                        <th>Estado</th>
                        <th>Fecha corresponde</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Opciones</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div id="modal_customer_invoice_send_mail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalmail" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <!--Content-->
        <div class="modal-content">
          <!--Header-->
          <div class="modal-header">
            <h4 class="modal-title" id="modalmail"> {{ __('customer_invoice.text_modal_send_mail')}} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="white-text">&times;</span>
            </button>
          </div>
          <!--Body-->
          <form id="form" name="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" id="tken_b" name="tken_b" value="">

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="form-group form-group-sm">
                          <label for="to" class="control-label">Para <span class="required text-danger">*</span></label>
                          <select id='to' name='to[]' class="form-control" multiple="multiple">
                          </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12">
                      <div class="form-group form-group-sm">
                        <label for="attach" class="control-label">CC</label>
                        <select id='attach' name='attach[]' class="form-control" multiple="multiple">
                        </select>
                      </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <div class="pull-right">
                <button type="submit" class="btn btn-xs btn-info "> <i class="fa fa-filter"> Enviar</i></button>
                <button type="button" class="btn btn-xs btn-danger" data-dismiss="modal"> <i class="fa fas fa-times"> {{ __('general.button_close') }} </i></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div id="modal_customer_nps" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalmail" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <!--Content-->
        <div class="modal-content">
          <!--Header-->
          <div class="modal-header">
            <h4 class="modal-title" id="modalmail"> Hotel asignado </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="white-text">&times;</span>
            </button>
          </div>
          <!--Body-->
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12 col-xs-12">
                  <div class="form-group form-group-sm">
                    <label for="message_site" class="control-label">Hotel</label>
                  </div>
                  <textarea name="message_site" id="message_site" class="form-control" rows="5"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="pull-right">
              <button type="button" class="btn btn-xs btn-danger" data-dismiss="modal"> <i class="fa fas fa-times"> {{ __('general.button_close') }} </i></button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /modal about -->
  {{-- @else --}}
  {{-- @endif --}}
@endsection

@push('scripts')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.css') }}" type="text/css" />
  <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2-bootstrap.min.css') }}" type="text/css" />
  <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/select2/dist/js/i18n/es-MX.js') }}" type="text/javascript"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

  <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

  <script src="{{ asset('js/admin/questionnaire/configitc.js')}}"></script>
  {{-- @else --}}
  {{-- @endif  --}}
@endpush
