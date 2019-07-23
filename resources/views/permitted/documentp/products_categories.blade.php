<ul id="lista-productos3" class="cards" style="position: relative;">
@foreach($products_categories as $product)
<li style="width: 25% !important;" class="cards__item">
  <div class="card">
    <div class="header">
      <span class="categoria">{{$product->categoria}}</span>
      <img class="img-fluid" src="{{ asset("images/storage/$product->img") }} " alt="">
    </div>
    <div class="card__content">
      <div class="card__title">
        @php
        $productFull = $product->descripcion;
        $tam = strlen ($productFull);
        if ($tam > 35){
          $productRec = substr($productFull,0, 35);
          echo $productRec;
          echo '<a type="button" class="" data-toggle="tooltip" data-placement="top" title="'.$productFull.'">...Ver más</a>';
        }else{
          echo $productFull;
        }
        @endphp
      </div>
      <div class="row">
        <p class="col-md-12 text-price">$
          <span class="card_price">{{number_format($product->precio, 2, '.', ',')}}</span>
          <span class="card_currency">{{$product->currency}}</span>
        </p>

      </div>
      <div class="row">
        <div class="col-md-6">
        <h6>Cant. Sugerida</h6>
        <input readonly width="20" type="number" class="form-control cant_sug" name="" value="0">
        </div>
        <div class="col-md-6">
        <h6>Cant. Requerida</h6>
        <input min="0" type="number" class="form-control cant_req" name="" value="0">
        </div>
      </div>
      <br>
      <button type="button"
         data-id="{{$product->id}}"
         data-descripcion="{{$product->descripcion}}"
         data-price="{{$product->precio}}"
         data-proveedor="{{$product->proveedor}}"
         data-codigo="{{$product->codigo}}"
         data-num-parte="{{$product->num_parte}}"
         data-currency="{{$product->currency}}"
         data-currency-id="{{$product->currency_id}}"
         data-categoria-id="{{$product->categoria_id}}"
         class="boton rojo agregar-carrito-categorias">
         Añadir
       </button>
    </div>
  </div>
</li>
@endforeach
</ul>

{{ $products_categories->render() }}

<script type="text/javascript" src="{{asset('js/admin/documentp/carrito_categorias.js')}}"></script>
