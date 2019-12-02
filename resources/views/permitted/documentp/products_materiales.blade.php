<ul id="lista-productos2" class="cards" style="position: relative;">
@foreach($products_materiales as $product)
  <li class="cards__item mt-2">
    <div class="card">
      <div class="header">
        <span class="categoria">{{$product->categoria}}</span>
        <img class="img-fluid" src="{{ asset("images/storage/$product->image") }}" alt="">
      </div>
      <div class="card__content">
        <div class="card__title">
          @php
            $productFull = $product->name;
            $tam = strlen ($productFull);
            if ($tam > 35){
              $productRec = substr($productFull,0, 35);
              echo $productRec;
              echo '<a class="" data-toggle="tooltip" data-placement="top" title="'.$productFull.'">...</a>';
            }else{
              echo $productFull;
            }
          @endphp
        </div>
        <div class="row d-flex justify-content-center">
          <div class="col-8">
            <p class=" text-price">$
              <span class="card_price">{{number_format($product->price, 2, '.', ',')}}</span>
              <span class="card_currency">{{$product->currency}}</span>
            </p>
          </div>
          <div class="col-4 text-center">
            <a tabindex="0" class="info-product" role="button" data-toggle="popover" data-trigger="focus" data-content="{{$product->name}}">
              <i class="fas fa-info"></i>
            </a>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <h6>Cant. Sugerida</h6>
            <input readonly width="20" type="number" class="form-control cant_sug" name="" value="{{$product->cantidad}}">
          </div>
          <div class="col-6">
            <h6>Cant. Requerida</h6>
            <input min="0" type="number" class="form-control cant_req" name="" value="0">
          </div>
        </div>
        <button type="button"
              data-id="{{$product->id}}"
              data-descripcion="{{$product->name}}"
              data-price="{{$product->price}}"
              data-proveedor="{{$product->provedor}}"
              data-codigo="{{$product->code}}"
              data-num-parte="{{$product->num_parte}}"
              data-currency="{{$product->currency}}"
              data-currency-id="{{$product->currency_id}}"
              data-categoria-id="{{$product->categoria_id}}"
              data-discount="{{$product->discount}}"
              class="btn btn-danger agregar-carrito-material">
             <i class="fas fa-cart-plus"></i>
          </button>
      </div>
    </div>
  </li>
@endforeach
</ul>

{{ $products_materiales->render() }}

<script type="text/javascript" src="{{asset('js/admin/documentp/carrito_materiales.js?v=2.0.0')}}"></script>
<script type="text/javascript" src="{{asset('js/admin/documentp/carrito_categorias.js?v=2.0.0')}}"></script>
<script type="text/javascript">
  $("[data-toggle=popover]").popover();
</script>
