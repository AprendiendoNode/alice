@php
  $date = \Carbon\Carbon::now();
  $date2 = \Carbon\Carbon::now();
  $date = $date->format('d-m-Y');
  $day = $date2->format('d');
  $total_cargos = 0.0;
  $total_abonos = 0.0;  
@endphp
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
          @endphp
        <tr>
            <td><input type="hidden" value="{{$data->id}}"></td>
            <td>{{$data->mov}}</td>
            <td>
              <select style="width:300px;" class="form-control form-control-sm cuenta_contable select2">
                @foreach ($cuentas_contables as $cuenta_data)
                  <option value="{{$cuenta_data->id}}">{{$cuenta_data->cuenta}} {{$cuenta_data->nombre}}</option>
                @endforeach
              </select>
            </td>
            <td>{{$day}}</td>
            <td></td>
            <td class=""><input style="width:180px;text-align:right" class="form-control form-control-sm" type="text" value="{{$data->name}} {{$date}}"></td>
            <td><input style="width:120px;text-align:right" class="form-control form-control-sm cargos" type="text" value="{{number_format($data->cargo, 2, '.', '')}}" ></td>
            <td><input style="width:120px;text-align:right" class="form-control form-control-sm" abonos" type="text" value="{{number_format($data->abono, 2, '.', '')}}" ></td> 
            <td></td>
        </tr>
        @endforeach    
      </tbody>
    </table>
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