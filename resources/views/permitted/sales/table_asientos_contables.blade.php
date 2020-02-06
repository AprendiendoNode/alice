@php
  $date = \Carbon\Carbon::now();
  $date2 = \Carbon\Carbon::now();
  $date = $date->format('d-m-Y');
  $day = $date2->format('d');
  $total_cargos = 0.0;
  $total_abonos = 0.0;  
@endphp
<div class="row">
  <div class="form-group col-md-3">
    <label class="" for="type_poliza">Tipo:</label>
    <select class="form-control form-control-sm mb-2 mr-sm-2" id="type_poliza" name="type_poliza" >
      @foreach ($tipos_poliza as $poliza_data)      
        <option value="{{$poliza_data->id}}">{{$poliza_data->clave}} {{$poliza_data->descripcion}}</option>  
      @endforeach
    </select>
  </div>

  <div class="form-group col-md-2">
    <label class="" for="">Número:</label>
    <input type="number" class="form-control form-control-sm mb-2 mr-sm-2" id="num_poliza" name="num_poliza"  placeholder="">
  </div>

  <div class="form-group col-md-2">
    <label class="" for="day_poliza">Día:</label>
    <input readonly type="number" class="form-control form-control-sm mb-2 mr-sm-2" name="day_poliza" id="day_poliza" placeholder="">
  </div>
  <div class="form-group col-md-3">
    <label class="" for="mes_poliza">Mes:</label>
    <input readonly type="text" class="form-control form-control-sm mb-2 mr-sm-2" name="mes_poliza" id="mes_poliza">
  </div>
</div>
<!--------------Movimientos contables-----------> 
<div class="col-12 table-responsive">
    <table id="tabla_asiento_contable" class="table table-sm">
      <thead class="bg-secondary text-white">
        <tr>
          <th></th>
          <th>Mov.</th>
          <th>Cuenta</th>
          <th>Dia</th>
          <th>T.C.</th>
          <th>Nombre</th>
          <th>Cargo</th>
          <th>Abono</th>
          <th>Referencia</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($asientos as $data)
          @php
              $total_cargos+=$data->cargo;
              $total_abonos+=$data->abono;
              $fecha = strtotime($data->fecha);
              $date = date("d-m-Y", $fecha);
              $day = date("d", $fecha);
          @endphp
        <tr>
            <td><input class="id_factura" type="hidden" value="{{$data->customer_invoice_id}}"></td>
            <td>{{$data->mov}}</td>
            <td>
              <select style="width:280px;" class="form-control form-control-sm cuenta_contable select2">
                @foreach ($cuentas_contables as $cuenta_data)
                  @if ($cuenta_data->id == $data->cuenta_contable_id)
                    <option selected value="{{$cuenta_data->id}}">{{$cuenta_data->cuenta}} {{$cuenta_data->nombre}}</option> 
                  @else
                    <option value="{{$cuenta_data->id}}">{{$cuenta_data->cuenta}} {{$cuenta_data->nombre}}</option>
                  @endif   
                @endforeach
              </select>
            </td>
            <td><input style="width:58px;text-align:left" class="form-control form-control-sm dia" readonly type="number" value="{{$day}}"></td>
            <td><input style="width:94px;text-align:center" class="form-control form-control-sm tipo_cambio" readonly type="number" value="{{$data->tipo_cambio}}"></td>
            <td class=""><input style="width:170px;text-align:right" readonly class="form-control form-control-sm nombre" type="text" value="{{$data->name}} {{$date}}"></td>
            <td><input onblur="suma_total_asientos();" style="width:115px;text-align:right" class="form-control form-control-sm cargos" type="text" value="{{number_format($data->cargo, 2, '.', '')}}" ></td>
            <td><input onblur="suma_total_asientos();" style="width:115px;text-align:right" class="form-control form-control-sm abonos"  type="text" value="{{number_format($data->abono, 2, '.', '')}}" ></td> 
            <td><input style="width:135px;text-align:center" class="form-control form-control-sm referencia" type="text" value=""></td>
        </tr>
        @endforeach    
      </tbody>
    </table>
    <!--------------TOTALES----------->  
    <div class="row mt-5">
      <div class="form-inline col-md-8">
        
      </div>
      <div class="form-inline col-md-4">
        <label class="" for="">Totales: </label>
        <input style="width:130px;" value="{{ number_format($total_cargos, 2, '.', ',')}}" readonly type="text" class="form-control form-control-sm mb-2 mr-sm-2 text-right font-weight-bold" name="total_cargos" id="total_cargos" >
        <input style="width:130px;" value="{{ number_format($total_abonos, 2, '.', ',')}}" readonly type="text" class="form-control form-control-sm mb-2 mr-sm-2 text-right font-weight-bold" name="total_abonos" id="total_abonos" >
      </div>
    </div>
  </div>