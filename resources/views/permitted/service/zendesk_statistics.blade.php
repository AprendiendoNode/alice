@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View statistics tickets') )
    {{ trans('message.breadcrumb_staticket') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View statistics tickets') )
    {{ trans('message.breadcrumb_staticket') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View statistics tickets') )
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <form id="search_tickets" name="search_tickets" class="form-inline">
                  {{ csrf_field() }}
                  <div class="input-group mb-2 mr-sm-2">
                    <h5>Periodo.</h5>
                  </div>
                  <div class="input-group mb-2 mr-sm-2">
                    <input type="text" class="form-control" id="datepickerMonthticket" name="datepickerMonthticket">
                  </div>
                  <div class="input-group mb-2 mr-sm-2">
                    <button type="button" class="btn btn-outline-primary btn_search"> <i class="fas fa-filter" style="margin-right: 4px;"></i> Filtrar</button>
                  </div>
                </form>
              </div>
              <div class="col-12 mt-4">
                <div class="table-responsive">
                  <table id="table_tickets" name='table_tickets' class="table table-striped border display nowrap" style="width:100%; font-size: 10px;">
                    <thead>
                      <tr>
                        <th> <small>ITC</small> </th>
                        <th> <small>Tickets abiertos</small> </th>
                        <th> <small>Tickets pendientes</small> </th>
                        <th> <small>Tickets en espera</small> </th>
                        <th> <small>Tickets resueltos</small> </th>
                        <th> <small>Tickets cerrados</small> </th>
                        <th> <small>Total de Tickets</small> </th>
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
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View statistics tickets') )
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/zendesk/infoadmintickets.js')}}"></script>

  @else
  @endif
@endpush
