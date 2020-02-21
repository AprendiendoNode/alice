<html lang="en">
<head>
<meta charset="UTF-8">
<title>
  
</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }

    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }

    .header_address{
      line-height: .3rem;
    }

    .header_address h4{
      font-size: 1.5rem;
    }

    .header_address h5{
      font-size: 1.2rem;
      line-height: .1rem !important;
    }

    .text-center{
      text-align: center;
    }

    .text-address{
      font-size: 14px;
      line-height: .7rem;
    }

    .row{
      width: 100%;
    }

    .customer_info{
      height: 120px;
      border: 1px solid #000;
      border-radius: 5px;
      margin-top: 5px;
      font-size: 12px;
    }

    .customer_info div{
      padding: 0rem 2px;
    }

    .customer_info div p{
      line-height: .2rem;
      font-weight: bold;
    }

    .customer_info div span{
      font-weight: normal;
    }

    .header{
      border: 1px solid #000;
      border-radius: 5px;
      margin-top: 20px;
      font-size: 9px;
      height: 80px;
    }

    .header div{
      display: inline-block;
      width: 32%;
      padding: 1.2rem 1px;
      font-weight: bold;
      text-align: left;
    }

    .header div span{
      font-weight: normal !important;
    }

    .header div p{
      line-height: .6rem;
      display: block;
    }

    .product_description{
      height: 100px;
      border: 1px solid #000;
      border-radius: 5px;
      margin-top: 5px;
      font-size: 12px;
    }

    .transparent{
      color: white;
    }

    .text-bold{
      font-weight: bold;
    }

    #table_products{
      margin-top: 10px;
      border: 2px solid;
      border-radius: 15px;
    }

    

    #table_totales{
      margin-top: 10px;
      border: 2px solid black;
      border-radius: 15px;
    }

    .text-white{
      color: #fff;
    }

</style>

</head>
<body>

  <table width="100%">
    <tr>
        <td style="width:20%;" valign="top"><img width="130" src="{{ public_path('images/storage/SIT070918IXA/files/companies/logo.png') }}"/></td>
        <td class="header_address" style="width:60%;" class="" align="center">
            <h4>SITWIFI, S.A DE C.V.</h4>
            <p class="text-address">HAMBURGO No. Ext. 159 No. Int. PISO 1 </p>
            <p>Col. JUAREZ CP 06600</p>
            <p>Delg. CUAUHTÉMOC CIUDAD DE MÉXICO </p>
            <h5>R.F.C. SIT070918IXA</h5>
        </td>
        <td style="width:20%;" valign="top"></td>
    </tr>
  </table>

  <table width="100%">
    <tr>
      <td style="width:60%;">
        <h4>PROVEEDOR: {{ $order_purchases[0]->provider }}</h4>
        <h4>RFC: {{ $order_purchases[0]->taxid }}</h4>
        <h4>TEL: {{ $order_purchases[0]->phone }}</h4>
      </td>
      <td style="width:40%;">
        <h4>ORDEN No.: {{ $order_purchases[0]->num_order }}</h4>
        <h4>FECHA: {{ $order_purchases[0]->date }} </h4>
        <h4 class="text-white">-</h4>
      </td>
    </tr>
  </table>

  <table id="table_products" width="100%">
    <thead>
      <tr>       
        <th align="center">CANTIDAD</th>
        <th colspan="2" align="center">PRODUCTO</th>
        <th>COSTO U.</th>
        <th>MONEDA</th>
        <th>SUBTOTAL</th>
        <th>DESCUENTO</th>
        <th>TOTAL C/DESC.</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($products as $product)
          <tr>
            <td class="text-center">{{$product->Cantidad}}</td>
            <td colspan="2">{{$product->name}}</td>
            <td class="text-right">{{ number_format($product->price, 2, '.', ',') }}</td>
            <td>{{$product->code}}</td>
            <td class="text-right">{{$product->subtotal}}</td>
            <td style="text-align: center">{{ number_format($product->descuento, 2, '.', ',') }}</td>
            <td style="text-align: right">{{$product->total}}</td>
          </tr>
      @endforeach
    </tbody>
  </table>

  
  <table id="table_totales" width="100%">
    <tr>
      <td style="width:70%;">
        <p class="text-white">-</p>
        <p class="text-white">-</p>
        <p class="text-white">-</p>
        <p class="text-bold">({{$ammount_letter}} {{$products[0]->code}})</p>
      </td>
      <td style="width:20%;">
        <p class="text-bold">SUBTOTAL: </p>
        <p class="text-bold">DESCUENTO:</p>
        <p class="text-bold">I.V.A.</p>
        <p class="text-bold">TOTAL</p>
      </td>
      <td style="width:20%;">
        <p class="text-bold">$ {{ number_format($order_purchases[0]->subtotal, 2,'.', ',')  }}</p>
        <p class="text-bold">$ {{ number_format($order_purchases[0]->descuento, 2,'.', ',')  }}</p>
        <p class="text-bold">$ {{ number_format($order_purchases[0]->iva_amount, 2,'.', ',')  }}</p>
        <p class="text-bold">$ {{ number_format($order_purchases[0]->total, 2,'.', ',')  }}</p>
      </td class="text-bold">
    </tr>
  </table>

</body>
</html>
