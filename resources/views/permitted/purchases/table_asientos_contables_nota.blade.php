@php
  $total_cargos = 0.0;
  $total_abonos = 0.0;
@endphp
<div class="row">
  <input id="date_resive" name="date_resive" type="hidden" value="{{$date_rest}}">

  <div class="form-group col-md-3">
    <label class="" for="type_poliza">Tipo:</label>
    <select class="form-control form-control-sm mb-2 mr-sm-2" id="type_poliza" name="type_poliza" >
      <option value="" selected>Selecciona...</option>
      @foreach ($tipos_poliza as $poliza_data)
        <option value="{{$poliza_data->id}}">{{$poliza_data->clave}} {{$poliza_data->descripcion}}</option>
      @endforeach
    </select>
  </div>

  <div class="form-group col-md-2">
    <label class="" for="">Número:</label>
  <input type="number" class="form-control form-control-sm mb-2 mr-sm-2" id="num_poliza" name="num_poliza" value="{{$next_id_num}}">
  </div>

  <div class="form-group col-md-2">
    <label class="" for="day_poliza">Día:</label>
    <input readonly type="number" class="form-control form-control-sm mb-2 mr-sm-2" name="day_poliza" id="day_poliza" placeholder="">
  </div>
  <div class="form-group col-md-2">
    <label class="" for="mes_poliza">Mes:</label>
    <input readonly type="text" class="form-control form-control-sm mb-2 mr-sm-2" name="mes_poliza" id="mes_poliza">
  </div>
  <div class="form-group col-md-3">
    <label class="" for="mes_poliza">Descripción:</label>
    <input type="text" class="form-control form-control-sm mb-2 mr-sm-2" name="descripcion_poliza" id="descripcion_poliza">
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
