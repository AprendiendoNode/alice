@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View drive') )
    {{ trans('message.drive') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View drive') )

  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View drive') )
    {{ trans('message.drive') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View drive') )

    <div style="height: 600px;">
        <div id="fm"></div>
    </div>

    <!-- Modal Factura Pendiente -->
    <div id="modalPendiente" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar factura</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @if( auth()->user()->can('View add invoices by drive') )
                    <form id="validation_modal_fact" name="validation_modal_fact" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="info_fact_pend"> Selecciona el pago con factura pendiente:
                                <span class="danger">*</span>
                            </label>
                            <select class="form-control required" id="info_fact_pend" name="info_fact_pend" style="width:100%;">
                                <option value="" selected>{{ trans('pay.select_op') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="info_proveedor" class="control-label">Nombre del Proveedor:</label>
                            <input type="text" class="form-control" id="info_proveedor" name="info_proveedor" readonly>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="info_cantidad" class="control-label">Monto:</label>
                                <input type="text" class="form-control" id="info_cantidad" name="info_cantidad" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="info_orden" class="control-label">Orden de pago:</label>
                                <input type="text" class="form-control" id="info_orden" name="info_orden" readonly>
                            </div>
                        </div>

                        <center>
                            <label for="" class="col-md-12 control-label text-danger"><i class="fas fa-cloud-upload-alt" aria-hidden="true"></i> Importar facturas en PDF O XML</label>
                        </center>
                        <div class="row mb-2">
                            <div class="col-md-8 m-auto">
                              <div class="form-group">
                                  <label for="info_nofact" class="control-label">No. Factura:</label>
                                  <input type="text" class="form-control required" id="info_nofact" name="info_nofact" readonly>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8 m-auto">
                              <div class="input-group" id="cont_1">
                                  <label class="input-group-btn">
                                      <span class="btn btn-danger">
                                        <i class="far fa-file-pdf"></i>  PDF
                                        <input id="file_pdf" name="file_pdf" type="file" style="display: none;" class="required">
                                      </span>
                                  </label>
                                  <input type="text" class="form-control" readonly>
                              </div>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-md-8 m-auto">
                              <div class="input-group" id="cont_2">
                                  <label class="input-group-btn">
                                      <span class="btn btn-success">
                                        <i class="far fa-file-excel"></i> XLSX
                                        <input id="file_xml" name="file_xml" type="file" style="display: none;" class="required">
                                      </span>
                                  </label>
                                  <input type="text" class="form-control" readonly>
                              </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3 m-auto">
                              <div class="form-group mt-10">
                                  <button type="submit" class="btn btn-info"><i class="fa fa-bullseye margin-r5"></i> Guardar</button>
                              </div>
                          </div>
                        </div>

                    </form>
                    @else @include('default.denied') @endif
                </div>
                <!-- <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div> -->
            </div>

        </div>
    </div>

    <!-- Modal Preview -->
    <div class="modal fade" id="previewInfo" tabindex="-1" role="dialog" aria-labelledby="modalSlideUpLabel" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                      <p class="h4"><i class="fas fa-eye"></i> Vista previa</p>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                          <i class="fas fa-window-close"></i>
                      </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-9" id="modal-preview">

                            </div>
                            <div class="col-md-3 b-l b-grey" id="modal-info">
                                <ul class="no-style">
                                    <li><b>Name</b>: <p id="modal-name"></p></li>
                                    <li><b>Size</b>: <p id="modal-size"></p></li>
                                    <li class="hide"><b>Height</b>: <span id="modal-height"></span></li>
                                    <li class="hide"><b>Width</b>: <span id="modal-width"></span></li>
                                </ul>
                                <button class="btn btn-complete m-t-30 hide">Download file</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- End Modal Preview -->

    @else
      @include('default.denied')
    @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View drive') )

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
  <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
  <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
  <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>

  <script>
      $(document).ready(function(){
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          var groups = document.querySelectorAll('[role="group"]');
          var facturaPendiente = document.createElement("div");
          facturaPendiente.innerHTML = "<button type='button' class='btn btn-info mr-2' onclick='modalPendiente()'><i class='far fa-file-pdf'></i> Fact. Pendiente</button>";
          groups[0].prepend(facturaPendiente);
          groups[1].setAttribute("style", "display: none");
      });
  </script>

  <script src="{{ asset('js/admin/contract/drive.js?v=2.0.1')}}"></script>
  <script src="{{ asset('vendor/file-manager/js/file-manager.js?v=3.1') }}"></script>

  @else

  @endif
@endpush
