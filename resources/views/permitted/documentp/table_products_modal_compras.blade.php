<style media="screen">

table{
    border-collapse: collapse;
}
tfoot tr td{
    font-weight: bold;
}

table td, table th {
  border-bottom: 1px solid #D1D1D1;
}

table tbody tr:nth-child(odd) {background: #F7F2F2}

table tfoot td, table tfoot th {
  border-bottom: 1px solid white !important;
}

.p-left{
  padding-left: 8px !important;
}

</style>
<p><strong class="text-danger">Tipo de cambio: $<span>{{$tipo_cambio}}</span> </strong></p>
<div class="table-responsive">
  <table id="products" width="100%">
    <thead style="background-color: #0E2A38;color:white;">
      <tr>
        <th>Descripción</th>
        <th align="center">Cant. Sug.</th>
        <th align="center">Cant. Req.</th>
        <th class="text-center">Precio unitario</th>
        <th class="text-center">Moneda</th>
        <th class="text-center">Desc. %</th>
        <th class="text-center">Total</th>
        <th class="text-center">Total USD</th>
        <th class="text-center">Recibido</th>
        <th class="text-center" style="min-width: 80px;">% de compra</th>
        <th class="text-center">Orden de compra</th>
        <th class="text-center">Fecha de entrega</th>
        <th width="90" class="text-center">Estatus</th>
      </tr>
    </thead>
    <tbody>
      @php
        $total_ea = 0.0;
        $total_materiales = 0.0;
        $total_mano_obra = 0.0;
        $background_progress = "bg-warning";
      @endphp

      @foreach($equipo_activo as $producto)
        @php
        if($producto->order_status_id == 4) $background_progress  = "bg-success";
        else if($producto->order_status_id >= 5) $background_progress  = "bg-primary";
        else $background_progress  = "bg-warning";
        @endphp
        <tr id="{{$producto->id}}">
          <td class="descripcion">{{$producto->producto}}</td>
          <td align="center">{{$producto->cantidad_sugerida}}</td>
          <td class="text-bold" align="center">{{$producto->cantidad}}</td>
          <td align="right">{{number_format($producto->precio, 2, '.', ',')}}</td>
          <td align="center">{{$producto->currency}}</td>
          <td align="center">{{$producto->descuento}}</td>
          <td align="right">{{number_format($producto->total, 2, '.', ',')}}</td>
          <td class="p-left" align="right">{{ number_format($producto->total_usd, 2, '.', ',')}}</td>
          <td align="center">
            <a id="cant_req" href="javascript:void(0);"
            data-type="text"
            data-cant="{{$producto->cantidad}}"
            data-pk="{{$producto->id}}"
            data-title="cantidad"
            data-value="{{$producto->cantidad_recibida}}" data-name="cant_req" class="set-cant-req"></a></td>
          <td  style="vertical-align: center;">
              <div style="height: 14px;width:{{$producto->porcentaje_compra}}%" class="progress-bar {{$background_progress}}  progress-bar-striped" role="progressbar"
                aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{$producto->porcentaje_compra}}">
                <span>{{$producto->porcentaje_compra}}%</span>
              </div>
          </td>
          <td align="center">
            <a href="javascript:void(0);"
               data-type="text"
               data-pk="{{$producto->id}}"
               data-title="orden-compra"
               data-value="{{$producto->purchase_order}}"
               data-name="orden-compra"
               class="set-purchase-order">

            </a>
          </td>
          <td align="center">
            <a href="javascript:void(0);"
               data-type="text"
               data-pk="{{$producto->id}}"
               data-title="Fecha de entrega"
               data-value="{{ ($producto->fecha_entrega != null ? date("d-m-Y", strtotime($producto->fecha_entrega))  : $producto->fecha_entrega) }}"
               data-name="fecha-entrega"
               class="set-fecha-entrega">

            </a>
          </td>
          <td align="center">
            <a id="cant_req" href="javascript:void(0);"
            data-type="select"
            data-cant="{{$producto->cantidad}}"
            data-pk="{{$producto->id}}"
            data-title="Estatus"
            data-source="{{$status}}"
            data-value="{{$producto->order_status_id}}" data-name="status" class="set-status"></a></td>
        </tr>
      @php $total_ea += $producto->total_usd @endphp
      @endforeach

      <tr class="bg-blue text-bold">
          <td></td>
          <td colspan="5"></td>
          <td colspan="5" align="right">Total Equipo Activo USD</td>
          <td colspan="3" align="right">$ {{ number_format($total_ea, 2, '.', ',') }}</td>
      </tr>

      @foreach($materiales as $producto)
        @php
          if($producto->order_status_id == 4) $background_progress  = "bg-success";
          else if($producto->order_status_id >= 5) $background_progress  = "bg-primary";
          else $background_progress  = "bg-warning";
        @endphp
        <tr id="{{$producto->id}}">
          <td class="descripcion">{{$producto->producto}}</td>
          <td align="center">{{$producto->cantidad_sugerida}}</td>
          <td class="text-bold" align="center">{{$producto->cantidad}}</td>
          <td align="right">{{number_format($producto->precio, 2, '.', ',')}}</td>
          <td align="center">{{$producto->currency}}</td>
          <td align="center">{{$producto->descuento}}</td>
          <td align="right">{{number_format($producto->total, 2, '.', ',')}}</td>
          <td class="p-left" align="right">{{ number_format($producto->total_usd, 2, '.', ',')}}</td>
          <td align="center">
            <a id="cant_req" href="javascript:void(0);"
            data-type="text"
            data-cant="{{$producto->cantidad}}"
            data-pk="{{$producto->id}}"
            data-title="cantidad"
            data-value="{{$producto->cantidad_recibida}}" data-name="cant_req" class="set-cant-req"></a></td>
            <td  style="vertical-align: center;">
                <div style="height: 14px;width:{{$producto->porcentaje_compra}}%" class="progress-bar {{$background_progress}}  progress-bar-striped" role="progressbar"
                  aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{$producto->porcentaje_compra}}">
                  <span>{{$producto->porcentaje_compra}}%</span>
                </div>
            </td>
          <td align="center">
            <a href="javascript:void(0);"
               data-type="text"
               data-pk="{{$producto->id}}"
               data-title="orden-compra"
               data-value="{{$producto->purchase_order}}"
               data-name="orden-compra"
               class="set-purchase-order">

            </a>
          </td>
          <td align="center">
            <a href="javascript:void(0);"
               data-type="text"
               data-pk="{{$producto->id}}"
               data-title="Fecha de entrega"
               data-value="{{ ($producto->fecha_entrega != null ? date("d-m-Y", strtotime($producto->fecha_entrega))  : $producto->fecha_entrega) }}"
               data-name="fecha-entrega"
               class="set-fecha-entrega">

            </a>
          </td>
          <td align="center">
            <a id="cant_req" href="javascript:void(0);"
            data-type="select"
            data-cant="{{$producto->cantidad}}"
            data-pk="{{$producto->id}}"
            data-title="Estatus"
            data-source="{{$status}}"
            data-value="{{$producto->order_status_id}}" data-name="status" class="set-status"></a></td>
        </tr>
      @php  $total_materiales += $producto->total_usd @endphp
      @endforeach

      <tr class="bg-blue text-bold">
          <td></td>
          <td colspan="5"></td>
          <td colspan="5" align="right">Total Materiales USD</td>
          <td colspan="3" align="right">$ {{ number_format($total_materiales, 2, '.', ',') }}</td>
      </tr>

      @if ($mano_obra != '[]')
        @foreach($mano_obra as $producto)
          @php
            if($producto->order_status_id == 4) $background_progress  = "bg-success";
            else if($producto->order_status_id >= 5) $background_progress  = "bg-primary";
            else $background_progress  = "bg-warning";
          @endphp
          <tr id="{{$producto->id}}">
            <td class="descripcion">{{$producto->producto}}</td>
            <td align="center">{{$producto->cantidad_sugerida}}</td>
            <td class="text-bold" align="center">{{$producto->cantidad}}</td>
            <td align="right">{{number_format($producto->precio, 2, '.', ',')}}</td>
            <td align="center">{{$producto->currency}}</td>
            <td align="center">{{$producto->descuento}}</td>
            <td align="right">{{number_format($producto->total, 2, '.', ',')}}</td>
            <td class="p-left" align="right">{{ number_format($producto->total_usd, 2, '.', ',')}}</td>
            <td align="center">
              <a id="cant_req" href="javascript:void(0);"
              data-type="text"
              data-cant="{{$producto->cantidad}}"
              data-pk="{{$producto->id}}"
              data-title="cantidad"
              data-value="{{$producto->cantidad_recibida}}" data-name="cant_req" class="set-cant-req"></a></td>
              <td  style="vertical-align: center;">
                  <div style="height: 14px;width:{{$producto->porcentaje_compra}}%" class="progress-bar {{$background_progress}}  progress-bar-striped" role="progressbar"
                    aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{$producto->porcentaje_compra}}">
                    <span>{{$producto->porcentaje_compra}}%</span>
                  </div>
              </td>
            <td align="center">
              <a href="javascript:void(0);"
                 data-type="text"
                 data-pk="{{$producto->id}}"
                 data-title="orden-compra"
                 data-value="{{$producto->purchase_order}}"
                 data-name="orden-compra"
                 class="set-purchase-order">

              </a>
            </td>
            <td align="center">
              <a href="javascript:void(0);"
                 data-type="text"
                 data-pk="{{$producto->id}}"
                 data-title="Fecha de entrega"
                 data-value="{{ ($producto->fecha_entrega != null ? date("d-m-Y", strtotime($producto->fecha_entrega))  : $producto->fecha_entrega) }}"
                 data-name="fecha-entrega"
                 class="set-fecha-entrega">

              </a>
            </td>
            <td align="center">
              <a id="cant_req" href="javascript:void(0);"
              data-type="select"
              data-cant="{{$producto->cantidad}}"
              data-pk="{{$producto->id}}"
              data-title="Estatus"
              data-source="{{$status}}"
              data-value="{{$producto->order_status_id}}" data-name="status" class="set-status"></a></td>
          </tr>
        @php $total_mano_obra += $producto->total_usd @endphp
        @endforeach
      @else

      @endif
      <tr class="bg-blue text-bold">
          <td></td>
          <td colspan="5"></td>
          <td colspan="5" align="right">Total Mano de obra USD</td>
          <td colspan="3" align="right">$ {{ number_format($total_mano_obra, 2, '.', ',') }}</td>
      </tr>
    </tbody>

    <tfoot>
      <tr>
          <td></td>
          <td colspan="3"></td>
          <td align="right"></td>
          <td align="right">-</td>
      </tr>
        <tr>
            <td></td>
            <td id="" rowspan="4" colspan="4"> </td>
            <td colspan="6" align="right">Total Equipo Activo USD</td>
            <td colspan="3" class="text-danger" align="right">$ {{ number_format($total_ea, 2, '.', ',') }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td colspan="5" align="right">Total Material USD</td>
            <td colspan="3" class="text-danger" align="right">$ {{ number_format($total_materiales, 2, '.', ',') }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td colspan="5" align="right">Total Mano de obra USD</td>
            <td colspan="3" class="text-danger" align="right">$ {{ number_format($total_mano_obra, 2, '.', ',') }}</td>
        </tr>
        <tr>
          @php
            $total = 0.0;
            $total = $total_ea + $total_materiales + $total_mano_obra;
          @endphp
            <td></td>
            <td></td>
            <td colspan="5" align="right">Total USD</td>
            <td colspan="3" class="text-danger" align="right" class="">$ {{ number_format($total, 2, '.', ',') }}</td>
        </tr>
    </tfoot>
  </table>
</div>
<script type="text/javascript">
$( document ).ready(function() {

  var _token = $('input[name="_token"]').val();

  const headers = new Headers({
    "Accept": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": _token
  })

  var miInit = { method: 'get',
                    headers: headers,
                    credentials: "same-origin",
                    cache: 'default' };

    //Configuracion de x-editable jquery
    $.fn.editable.defaults.mode = 'inline';
    $.fn.editable.defaults.ajaxOptions = {type:'POST'};

    $('.set-cant-req').editable({
        container: 'body',
        type : 'number',
        validate: function(newValue) {
          if($.trim(newValue) == '')
              return 'Este campo es requerido';
          else if(!isFinite(newValue))
              return 'Debe ingresar un valor númerico';
          else if(parseFloat(newValue) > $(this).data('cant'))
              return 'El número no puede exceder a la cantidad solicitada: ' + $(this).data('cant');
          else if(newValue <  0)
              return 'No puede ingresar valores negativos';
        },
        success: function(response, newValue) {
          var id = $(this).data('pk');
          var cantidad_pedida = $(this).data('cant');
          var cant = newValue;
          let porcentaje_compra = percent(cant, cantidad_pedida);

          fetch(`/update_cant_cart/${id}/${cant}/${porcentaje_compra}`,  miInit)
              .then(response => {
                return response.text();
              })
              .then(data => {
                update_percent_progress(id, porcentaje_compra);

              })
              .catch(error => {
                console.log(error);
              })

        }
    });

    $('.set-status').editable({
        container: 'body',
        success: function(response, newValue) {
          var id = $(this).data('pk');
          var status = newValue;

          fetch(`/update_status_product/${id}/${status}`,  miInit)
              .then(response => {
                return response.text();
              })
              .then(data => {
                if(status >= 5){
                  $( "#" + `${id}`).find( "div.progress-bar").removeClass( "bg-success" ).addClass( "bg-primary" );
                }
                else if(status == 4){
                  $( "#" + `${id}`).find( "div.progress-bar").removeClass( "bg-warning" ).addClass( "bg-success" );
                }
                else if(status == 3){
                  $( "#" + `${id}`).find( "div.progress-bar").removeClass( "bg-success" ).addClass( "bg-warning" );
                }
              })
              .catch(error => {
                console.log(error);
              })
        }
    });

    $('.set-purchase-order').editable({
        container: 'body',
        validate: function(newValue) {
          if($.trim(newValue) == '')
              return 'Este campo es requerido';
        },
        success: function(response, newValue) {
          var id = $(this).data('pk');
          var order = newValue;
          console.log(order);
          fetch(`/update_purchase_order/${id}/${order}`,  miInit)
              .then(response => {
                return response.text();
              })
              .then(data => {

              })
              .catch(error => {
                console.log(error);
              })
        }
    });

    $('.set-fecha-entrega').editable({
        type: 'text',
        placeholder:'dd-mm-aaaa',
        container: 'body',
        validate: function(newValue) {
          var pattern =/^([0-9]{2})\-([0-9]{2})\-([0-9]{4})$/;
          if($.trim(newValue) == '')
              return 'Este campo es requerido';
          if (!pattern.test(newValue)) {
              return 'Formato de fecha invalido';
            }
        },
        success: function(response, newValue) {
          var id = $(this).data('pk');
          var date = newValue;
          console.log(date);
          fetch(`/update_fecha_entrega/${id}/${date}`,  miInit)
              .then(response => {
                return response.text();
              })
              .then(data => {
                if(data != 'true'){
                  menssage_toast('Error', '2', 'Formato de fecha incorrecto' , '3000');
                }
              })
              .catch(error => {
                console.log(error);
              })
        }
    });

    // Calculo porcentaje de compra
    function  percent(cant_recibida, cantidad_pedida){
      var percent_sale = cant_recibida * 100 / cantidad_pedida;
      return parseFloat(percent_sale).toFixed(2);
    }
    // Actualizo el porcentaje de compras en el DOM
    function update_percent_progress(id, porcentaje_compra){
      $( "#" + `${id}`).find( "div.progress-bar" ).css( "width", porcentaje_compra + '%' );
      $( "#" + `${id}`).find( "div.progress-bar").find("span").text(porcentaje_compra + '%');
      if(porcentaje_compra == 100.00){
        $( "#" + `${id}`).find( "div.progress-bar").removeClass( "bg-warning" ).addClass( "bg-success" );
      }else if(porcentaje_compra > 0.0 && porcentaje_compra < 100){
        $( "#" + `${id}`).find( "div.progress-bar").removeClass( "bg-success" ).addClass( "bg-warning" );
      }else if(porcentaje_compra == 0.0) {
        $( "#" + `${id}`).find( "div.progress-bar").removeClass( "bg-success" ).addClass( "bg-warning" );
      }


    }

});
</script>
<style media="screen">
.progress-bar{
  margin: 4px !important;
  color: #393E46;
}

.bg-primary{
  background-color: #0078BF !important;
}

.bg-blue{
  background-color: #0078BF !important;
  color: white;
}

.text-bold{
  font-weight: bold;
}

table#products{
  font-size: 13px
}

table#products thead tr th{
  padding: 0px 2px;
  font-size: 12px;
}

table#products tbody tr td{
  padding: 0px 3px;
}

.descripcion, .set-status{
  font-size: 12px !important;
}

.editable-error-block{
  position: absolute;
  background-color:  white;
  margin-top: 35px !important;
}


</style>
