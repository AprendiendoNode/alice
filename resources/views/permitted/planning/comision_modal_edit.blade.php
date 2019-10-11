<!--  MODAL COMISIONES -->
<div id="modal_comision" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cálculo de comisión</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col-4">
            <h6>Proyecto: {{ $document[0]->nombre_proyecto }}</h6>
          </div>
          <div class="col-4">
            <h6>Tipo servicio: {{ $document[0]->tipo_servicio }}</h6>
          </div>
          <div class="col-4">
            <h6 class="text-danger">Monto de comisión: $ <span id="total_comision">{{ number_format($comision, 2,'.', ',') }} USD</span> </h6>
          </div>
        </div>
        <div class=" mb-2">
          <div class="col-12 text-center bg-dark text-white p-1 mb-2">
            <label class="mb-0" for="">Comisión</label>
          </div>
          <div class="form-row d-flex align-items-center mb-2">
            <div class="col-5 col-md-3">
              <label  for="">Contácto</label>
            </div>
            <div class="col-7 col-md-4">
              <input id="contacto_comercial" name="contacto_comercial" value="{{ $kickoff_comisiones->contacto }}" type="text" class="form-control form-control-sm">
            </div>
            <div class="col-8 col-md-3 input-group">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">$</div>
              </div>
              <input id="amount_contacto" readonly type="text"  class="form-control form-control-sm text-dark text-right" id="inlineFormInputGroup" value="{{ $kickoff_comisiones->amount_contacto }}">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">USD</div>
              </div>
            </div>
            <div class="col-4 col-md-2 input-group">
              <input id="percent_contacto" onblur="calcularComision(this);" type="number" class="form-control form-control-sm text-right" min="0" max="100" id="inlineFormInputGroup" value="{{ $kickoff_comisiones->percent_contacto }}">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">%</div>
              </div>
            </div>
          </div><!------------------------------------------------------->
          <div class="form-row d-flex align-items-center mb-2">
            <div class="col-5 col-md-3">
              <label  for="">Cierre</label>
            </div>
            <div class="col-7 col-md-4">
              <input id="cierre" name="cierre" value="{{ $kickoff_comisiones->cierre }}" type="text" class="form-control form-control-sm">
            </div>
            <div class="col-8 col-md-3 input-group">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">$</div>
              </div>
              <input id="amount_cierre" readonly type="text"  class="form-control form-control-sm text-dark text-right" id="inlineFormInputGroup" value="{{ $kickoff_comisiones->amount_cierre }}">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">USD</div>
              </div>
            </div>
            <div class="col-4 col-md-2 input-group">
              <input id="percent_cierre" type="number" onblur="calcularComision(this);" class="form-control form-control-sm text-right" min="0" max="100" id="inlineFormInputGroup" value="{{ $kickoff_comisiones->percent_cierre }}">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">%</div>
              </div>
            </div>
          </div><!------------------------------------------------------->
          <div class="form-row d-flex align-items-center mb-2">
            <div class="col-5 col-md-3">
              <label  for="">Inside Sales</label>
            </div>
            <div class="col-7 col-md-4">
              <select id="inside_sales" name="inside_sales" type="text" class="form-control form-control-sm">
                @if($kickoff_comisiones->inside_sales == 4)
                  <option selected value="4">Sin asignar</option>
                @else
                  <option value="4">Sin asignar</option>
                @endif
                @foreach ($inside_sales as $inside_sales_data)
                  @if($inside_sales_data->user_id == $kickoff_comisiones->inside_sales)
                    <option selected value="{{$inside_sales_data->user_id}}">{{$inside_sales_data->user}}</option>
                  @else
                    <option value="{{$inside_sales_data->user_id}}">{{$inside_sales_data->user}}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="col-8 col-md-3 input-group">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">$</div>
              </div>
              <input id="amount_inside_sales" readonly type="text"  class="form-control form-control-sm text-dark text-right" id="inlineFormInputGroup" value="{{$kickoff_comisiones->amount_inside_sales}}">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">USD</div>
              </div>
            </div>
            <div class="col-4 col-md-2 input-group">
              <input id="percent_inside_sales" onblur="calcularComision(this);" type="number" class="form-control form-control-sm text-right" min="0" max="100" id="inlineFormInputGroup" value="{{$kickoff_comisiones->percent_inside_sales}}">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">%</div>
              </div>
            </div>
          </div><!------------------------------------------------------->
          <div class="form-row d-flex align-items-center mb-2">
            <div class="col-5 col-md-3">
              <label for="">IT Concierge</label>
            </div>
            <div class="col-7 col-md-4">
              <select id="itconciergecomision" name="itconciergecomision" disabled type="text" class="form-control form-control-sm">
                <option value="{{$document[0]->itc_id}}">{{$document[0]->ITC}}</option>
              <select>
            </div>
            <div class="col-8 col-md-3 input-group">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">$</div>
              </div>
              <input id="amount_comission_itc" readonly type="text" class="form-control form-control-sm text-dark text-right" id="inlineFormInputGroup"  value="{{$kickoff_comisiones->amount_itc}}">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">USD</div>
              </div>
            </div>
            <div class="col-4 col-md-2 input-group">
              <input id="percent_comission_itc" value="{{$kickoff_comisiones->percent_itc}}" onblur="calcularComision(this);" type="number" class="form-control form-control-sm text-right" min="0" max="100" id="inlineFormInputGroup">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">%</div>
              </div>
            </div>
          </div><!------------------------------------------------------->
          <div class="form-row d-flex align-items-center mb-2">
            <div class="col-5 col-md-3">
              <label  for="">Vendedor</label>
            </div>
            <div class="col-7 col-md-4">
              <select id="vendedor" name="vendedor" type="text" class="form-control form-control-sm">
                @if($kickoff_comisiones->vendedor == 4)
                  <option selected value="4">Sin asignar</option>
                @else
                  <option value="4">Sin asignar</option>
                @endif
                @foreach ($vendedores as $vendedor)
                  @if($vendedor->user_id == $kickoff_comisiones->vendedor)
                    <option selected value="{{$vendedor->user_id}}">{{$vendedor->user}}</option>
                  @else
                    <option value="{{$vendedor->user_id}}">{{$vendedor->user}}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="col-8 col-md-3 input-group">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">$</div>
              </div>
              <input id="amount_comision_vendedor" readonly type="text"  class="form-control form-control-sm text-dark text-right" id="inlineFormInputGroup" value="{{$kickoff_comisiones->amount_vendedor}}">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">USD</div>
              </div>
            </div>
            <div class="col-4 col-md-2 input-group">
              <input id="percent_comision_vendedor" onblur="calcularComision(this);" type="number" class="form-control form-control-sm text-right" min="0" max="100" id="inlineFormInputGroup" value="{{$kickoff_comisiones->percent_vendedor}}">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">%</div>
              </div>
            </div>
          </div><!------------------------------------------------------->
          <div class="form-row d-flex align-items-center mb-2">
            <div class="col-5 col-md-3">
              <label  for="">Colaborador</label>
            </div>
            <div class="col-7 col-md-4">
              <select id="colaborador" name="colaborador" type="text" class="form-control form-control-sm">
                @if($kickoff_comisiones->colaborador == 4)
                  <option selected value="4">Sin asignar</option>
                @else
                  <option value="4">Sin asignar</option>
                @endif
                @foreach ($colaboradores as $colaborador)
                  @if($colaborador->id == $kickoff_comisiones->colaborador)
                    <option selected value="{{$colaborador->id}}">{{$colaborador->name}}</option>
                  @else
                    <option value="{{$colaborador->id}}">{{$colaborador->name}}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="col-8 col-md-3 input-group">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">$</div>
              </div>
              <input id="amount_colaborador" readonly type="text"  class="form-control form-control-sm text-dark text-right" id="inlineFormInputGroup" value="{{$kickoff_comisiones->amount_colaborador}}">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">USD</div>
              </div>
            </div>
            <div class="col-4 col-md-2 input-group">
              <input id="percent_colaborador" onblur="calcularComision(this);" type="number" class="form-control form-control-sm text-right" min="0" max="100" id="inlineFormInputGroup" value="{{$kickoff_comisiones->percent_colaborador}}">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">%</div>
              </div>
            </div>
          </div><!------------------------------------------------------->   
          <div class="form-row d-flex align-items-center mb-2">
            <div class="col-5 col-md-3">
              <label  for="">Externo</label>
            </div>
            <div class="col-7 col-md-4">
              <input id="comision_externo" name="comision_externo" value="{{ $kickoff_comisiones->externo1 }}" type="text" class="form-control form-control-sm">
            </div>
            <div class="col-8 col-md-3 input-group">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">$</div>
              </div>
              <input id="amount_externo1" readonly type="text"  class="form-control form-control-sm text-dark text-right" id="inlineFormInputGroup" value="{{$kickoff_comisiones->amount_externo1}}">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">USD</div>
              </div>
            </div>
            <div class="col-4 col-md-2 input-group">
              <input id="percent_externo1" onblur="calcularComision(this);" type="number" class="form-control form-control-sm text-right" min="0" max="100" id="inlineFormInputGroup" value="{{$kickoff_comisiones->percent_externo1}}">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">%</div>
              </div>
            </div>
          </div><!------------------------------------------------------->
          <div class="form-row d-flex align-items-center mb-2">
            <div class="col-5 col-md-3">
              <label  for="">Externo 2</label>
            </div>
            <div class="col-7 col-md-4">
              <input id="comision_externo_2" name="comision_externo_2" value="{{ $kickoff_comisiones->externo2}}" type="text" class="form-control form-control-sm">
            </div>
            <div class="col-8 col-md-3 input-group">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">$</div>
              </div>
              <input id="amount_externo2" readonly type="text"  class="form-control form-control-sm text-dark text-right" id="inlineFormInputGroup" value="{{$kickoff_comisiones->amount_externo2}}">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">USD</div>
              </div>
            </div>
            <div class="col-4 col-md-2 input-group">
              <input id="percent_externo2" onblur="calcularComision(this);" type="number" class="form-control form-control-sm text-right" min="0" max="100" id="inlineFormInputGroup" value="{{$kickoff_comisiones->percent_externo2}}">
              <div class="input-group-prepend">
                <div class="input-group-text form-control-sm text-dark">%</div>
              </div>
            </div>
          </div>
          <div class="form-row d-flex align-items-center mb-2">
            <div class="col-5 col-md-3">
              <button class="btn btn-dark btn-block"  onclick="comisionByDefault();" type="button" name="button">Calcular politica de comisión</button>
            </div>
          </div>
       </div>
      </div>
      <div class="modal-footer">
          <button id="button_comision" type="button" onclick="save_comision();" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
  </div>
</div>
</div>
