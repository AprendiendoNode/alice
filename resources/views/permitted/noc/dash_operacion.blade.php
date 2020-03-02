@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View noc') )
    <strong>Dashboard de operaciones</strong>
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View noc') )

  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View noc') )
    NOC
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
        <div class="card">
            <div class="card-body">
              <div class="text-center">
                <h4>Dashboard de operaciones</h4>
                <br>

                <div class="">


                </div>

                <div class="">
                  <h4>Equipo activo Monitoreado</h4>
                  <br>
                  <table id="table_sitios" class="table table-striped table-bordered compact-tab table-hover">
                    <thead class="bg-aqua text-center">
                      <tr>
                        <th>Equipo Activo.</th>
                        <th>Propietario</th>
                        <th>Hospitalidad</th>
                        <th>Educación</th>
                        <th>Aeropuertos y terminales</th>
                        <th>Transporte Terrestre</th>
                        <th>Corporativo</th>
                        <th>Retail</th>
                        <th>Galerías</th>
                        <th>Otros</th>
                      </tr>
                    </thead>
                    <tbody class="text-center"style="font-size: 11px;">


                    </tbody>
                  </table>
                </div>

              </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')

    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <style media="screen">
    .tableFixHead          { overflow-y: auto; height: 620px; }
    .tableFixHead thead th { position: sticky !important; top: 0; }
    .bg-aqua{
    background: #02948c;
    }
    </style>
@endpush
