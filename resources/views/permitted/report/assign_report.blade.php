@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View assign report') )
    {{ trans('message.title_reports') }}
  @else
    {{ trans('message.title_reports') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View assign report') )
    {{ trans('message.breadcrumb_assign_report') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  <!-- Crear -->
  <div id="modal-CreatReport" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalreportbyhotel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalreportbyhotel">{{ trans('message.creatusers') }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="re_data_type" name="re_data_type" class="forms-sample" action="">
                {{ csrf_field() }}
                <div class="form-group row">
                  <label for="select_one" class="col-sm-3 col-form-label">{{ trans('message.hotel') }}<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="select_one" name="select_one" class="form-control form-control-sm required">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($hotels as $data_hotel)
                        <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="select_two" class="col-sm-3 col-form-label">{{ trans('message.type') }}<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="select_two" name="select_two" class="form-control form-control-sm required">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($types as $data_types)
                        <option value="{{ $data_types->id }}"> {{ $data_types->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                <button type="button" class="btn btn-danger waves-effect form_creat_user" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

  @if( auth()->user()->can('View assign report') )
    <div class="row">
      <div class="col-md-12 grid-margin-onerem  stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">Asignación de tipos de reportes</p>
            <p class="mb-4">Para comenzar esta sección nos permite gestionar los reportes para cada hotel registrado en el sistema.</p>
            <div class="d-flex justify-content-center pt-3">
            </div>
            <div class="row">
              <div class="col-12">
                <div class="table-responsive">
                  <table id="example_conf_hotel" name='example_conf_hotel' class="table table-striped border display nowrap" style="width:100%; font-size: 10px;">
                    <thead>
                      <tr>
                        <th>Sitio</th>
                        <th>Reporte</th>
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
  @else
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View assign report') )
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

    <!-- FormValidation -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <script src="{{ asset('js/admin/report/assign_report_one.js')}}"></script>
  @else
  @endif
@endpush
