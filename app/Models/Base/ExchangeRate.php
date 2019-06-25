<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use \Cache;

class ExchangeRate extends Model
{
    const TOKEN_BANXICO = 'cd4a8be7819b7aa51f2e7924168acc79bc8f8b0a9d7d0caf3c1439aab03df07b';
    const SERIE_COMPRA = 'SF43787'; // Tipo de cambio pesos por dólar E.U.A. Interbancario a 48 horas Apertura compra
    const SERIE_VENTA = 'SF43784'; // Tipo de cambio Pesos por dólar E.U.A. Interbancario a 48 horas Cierre venta
    const SERIE_FIX = 'SF43718';

    public static function getExchangeRateCompra()
    {
      $query = 'https://www.banxico.org.mx/SieAPIRest/service/v1/series/' . SELF::SERIE_COMPRA . '/datos/oportuno?token=' . SELF::TOKEN_BANXICO;

      return json_decode(file_get_contents($query), true);
    }

    public static function getExchangeRateVenta()
    {
      $query = 'https://www.banxico.org.mx/SieAPIRest/service/v1/series/' . SELF::SERIE_VENTA . '/datos/oportuno?token=' . SELF::TOKEN_BANXICO;

      return json_decode(file_get_contents($query), true);
    }

    public static function getExchangeRateFix()
    {
      $query = 'https://www.banxico.org.mx/SieAPIRest/service/v1/series/' . SELF::SERIE_FIX . '/datos/oportuno?token=' . SELF::TOKEN_BANXICO;

      return json_decode(file_get_contents($query), true);
    }

}
