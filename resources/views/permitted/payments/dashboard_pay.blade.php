@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View dashboard payment notification') )
    {{ trans('message.pay_dashboard_request') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View dashboard payment notification') )
    {{ trans('message.subtitle_pay_dash') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View dashboard payment notification') )
    {{ trans('message.breadcrumb_pay_dashboard') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View dashboard payment notification') )

      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <form id="search_info" name="search_info" class="form-inline" method="post">
              {{ csrf_field() }}
                <div class="input-group">
                  <span class="input-group-addon"><i class="fas fa-calendar-alt fa-3x"></i></span>
                  <input id="date_to_search" type="text" class="form-control" name="date_to_search">
                </div>
                <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                  <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
                </button>
            </form>
        </div>
      </div>
     <!-- End filter date -->

      <div class="row">

        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
          <div class="row">
            <!-- /.col -->
              <div class="col-md-3">
                <div class="row pt-10">
                  <div class="col-sm-12 col-xs-12">
                    <div class="card">
                      <div class="description-block card-body text-center">
                        <h3 id="sol_a" class="description-header text-primary"></h3>
                        <b><span class="description-text">{{ trans('dpay.sol_a') }}</span></b>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-12 col-xs-12">
                    <div class="card">
                      <div class="description-block card-body text-center">
                        <h3 id="sol_b" class="description-header text-danger"></h3>
                        <b><span class="description-text">{{ trans('dpay.sol_b') }}</span></b>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-12 col-xs-12">
                    <div class="card">
                      <div class="description-block card-body text-center">
                        <h3 id="sol_c" class="description-header text-warning"></h3>
                        <b><span class="description-text">{{ trans('dpay.sol_c') }}</span></b>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
              </div>
              <!-- /.col-md-4 -->
              <div class="col-md-6">
                  <div class="clearfix"  style="background: #ffffff;">
                    <div id="main_grap_payment_per_month" style="width: 100%; min-height: 300px; border:1px solid #ccc;"></div>
                  </div>
              </div>
              <div class="col-md-3">
                <div class="row pt-10">
                  <div class="col-sm-12 col-xs-12">
                    <div class="card">
                      <div class="description-block card-body text-center">
                        <h3 id="sol_d" class="description-header text-primary"></h3>
                        <b><span class="description-text">{{ trans('dpay.sol_d') }}</span></b>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-12 col-xs-12">
                    <div class="card">
                      <div class="description-block card-body text-center">
                        <h3 id="sol_e" class="description-header text-danger"></h3>
                        <b><span class="description-text">{{ trans('dpay.sol_e') }}</span></b>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-12 col-xs-12">
                    <div class="card">
                      <div class="description-block card-body text-center">
                        <h3 id="sol_g" class="description-header text-warning"></h3>
                        <b><span class="description-text">{{ trans('dpay.sol_g') }}</span></b>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
              </div>
          </div> <!-- /. row -->
          <div class="row">
            <div class="col-md-4 m-auto">
              <div class="card">
                <div class="description-block card-body text-center">
                  <h3 id="sol_f" class="description-header text-success"></h3>
                  <b><span class="description-text">{{ trans('dpay.sol_f') }}</span></b>
                </div>
              </div>
            </div>
          </div>
        </div>   <!-- /. col-6-->
      </div>     <!-- /. row -->
      <!------------------------------------------------------------------------>
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
        <div class="row margin-top-large">
          <div class="col-md-6">
            <div class="clearfix">
              <div id="main_grap_current" style="width: 102%; min-height: 460px; border:1px solid #ccc;padding:10px;"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="clearfix">
                <div id="main_grap_waypay" style="width: 102%; height: 920px; border:1px solid #ccc;padding:10px;"></div>
            </div>
          </div>

        </div>
      </div> <!-- /. col-12-->

      <!------------------------------------------------------------------------>
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
        <div class="row margin-top-large">

          <div class="col-md-12">
            <div class="card">

              <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                Clasificación del gasto
              </h4>
              <div class="description-block card-body">
                <div class="table-responsive" style="background: #ffffff;">
                  <table id="table_classification" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Servicios</th>
                        <th>Cantidad</th>
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
      </div> <!-- /. col-12-->


    @else
      @include('default.denied')
    @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View dashboard payment notification') )
    <style media="screen">
      .pt-10 {
        padding-top: 10px;
      }
    </style>
    <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/payments/dashboard_request_payment.js')}}"></script>
  @else
    <!--NO VER-->
  @endif
@endpush
