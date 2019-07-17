<?php

namespace App\Helpers;

use App\Models\Base\Company;
use App\Models\Base\DocumentType;
use App\Models\Base\Pac;
use App\Models\Sales\CustomerInvoice;
use App\Models\Sales\CustomerPayment;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use SoapClient;
use ZipArchive;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Helper
{

    /**
     * Funcion para subir archivos solo imagenes
     *
     * @param $key
     * @param $path
     * @param string $disk
     * @return string
     * @throws \Exception
     */
    public static function uploadFileImage($key, $path)
    {
        request()->file($key)->store(self::setDirectory($path));

        return request()->file($key)->hashName();
    }

    /**
     * Retorna el direactorio de la empresa si no existe lo crea
     *
     * @param string $disk
     * @return string
     * @throws \Exception
     */
    public static function directoryCompany(){
        try {

            $company = self::defaultCompany();
            $company_path = 'default';
            if(!empty($company)){
                $company_path = !empty($company->taxid) ? $company->taxid : $company_path;
            }

            if(!\Storage::exists($company_path)){
                \Storage::makeDirectory($company_path, 0777, true); //creates directory
            }

            return $company_path;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Crear directorio con el default de la empresa, si no existe lo crea
     *
     * @param string $disk
     * @param $path
     * @return string
     * @throws \Exception
     */
    public static function setDirectory($path){
        $company_path = self::directoryCompany();
        $path = $company_path . '/' . $path;
        if(!\Storage::exists($path)){
            \Storage::makeDirectory($path, 0777, true); //creates directory
        }
        return $path;
    }

    /**
     * Funcion obtenida para convertir el numero de serie de un certificado de la corona.com.mx
     *
     * http://www.lacorona.com.mx/fortiz/sat/cfdcvali.phps
     *
     * @param $serial_number
     * @return string
     */
    public static function certificateNumber($serial_number): string
    {
        $hex = self::bcdechex($serial_number);
        $ser = '';
        for ($i = 1; $i < @strlen($hex); $i = $i + 2) {
            $ser .= substr($hex, $i, 1);
        }

        return $ser;
    }

    public static function bcdechex($dec)
    {
        $last = bcmod($dec, 16);
        $remain = bcdiv(bcsub($dec, $last), 16);
        if ($remain == 0) {
            return dechex($last);
        } else {
            return self::bcdechex($remain) . dechex($last);
        }
    }



    /**
     * Consecutivo por tipo de documento
     *
     * @param $code
     * @return array
     * @throws \Exception
     */
    public static function getNextDocumentTypeByCode($code)
    {
        try {
            $data = [];
            $document_type = DocumentType::where('code', '=', $code)->first();
            if (!empty($document_type)) {
                $document_type->current_number += $document_type->increment_number;
                $data['serie'] = $document_type->prefix;
                $data['folio'] = $document_type->current_number;
                $data['name'] = $document_type->prefix . $document_type->current_number;
                $data['id'] = $document_type->id;
                $document_type->update();
            } else {
                throw new \Exception(__('document_type.error_next_document_type'));
            }
            if (empty($data['id']) || empty($data['name'])) {
                throw new \Exception(__('document_type.error_next_document_type'));
            }
            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }


    /**
     * Crea directorios para CFDI's
     *
     * @return string
     * @throws \Exception
     */
    public static function makeDirectoryCfdi($path_xml)
    {
        try {
            $tmp_path = date('Y') . '/' . date('m');
            if (!\Storage::exists($path_xml . $tmp_path)) {
                \Storage::makeDirectory($path_xml . $tmp_path, 0777, true, true);
            }

            return $tmp_path;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Funcion para convertir el saldo a pesos solo cuando el pago es en MXN
     *
     * @param $currency
     * @param $amount
     * @param $currency_code
     * @param null $currency_value
     * @param int $decimal_place
     * @return float|int
     */
    public static function convertBalanceCurrency($currency, $amount, $currency_code, $currency_value = null,$decimal_place=2)
    {
        if (!empty($currency) && $currency->code == 'MXN' && $currency_code != 'MXN' && !empty($currency_value)) {
            $amount = self::roundDown($amount * $currency_value, $decimal_place);
        }

        return $amount;
    }

    /**
     * Funcion para convertir el saldo a pesos solo cuando el pago es en MXN
     *
     * @param $currency
     * @param $amount
     * @param $currency_code
     * @param null $currency_value
     * @param int $decimal_place
     * @return float|int
     */
    public static function invertBalanceCurrency($currency, $amount, $currency_code, $currency_value = null,$decimal_place=2)
    {
        if (!empty($currency) && $currency->code == 'MXN' && $currency_code != 'MXN' && !empty($currency_value)) {
            $amount = self::roundDown($amount / $currency_value, $decimal_place);
        }

        return $amount;
    }

    /**
     * Redondeo hacia abajo
     *
     * @param $decimal
     * @param $precision
     * @return float|int
     */
    public static function roundDown($decimal, $precision)
    {
        $sign = $decimal > 0 ? 1 : -1;
        $base = pow(10, $precision);
        return floor(abs($decimal) * $base) / $base * $sign;
    }

    /**
     * Obtiene empresa default
     *
     * @return mixed
     */
    public static function defaultCompany(){
      return Company::get()->first();
    }

    //Fechas --------------------------------------------------------------------------
    /**
     * Convierte fecha tiempo a sql para guardar
     *
     * @param $date
     * @return mixed
     */
    public static function dateTimeToSql($date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    /**
     * Crea fecha tiempo a apartir de una fecha en formato BD
     *
     * @param $datetime
     * @return mixed
     */
    public static function createDateTimeFromSql($datetime)
    {
        return \Date::createFromFormat('Y-m-d H:i:s', $datetime);
    }
    /**
     * Crear fecha a partir de fecha configurada y convierte a sql para guardar
     *
     * @param $datetime
     * @return mixed
    */
    public static function convertSqlToDateTime($datetime)
    {
        return self::dateTime(self::createDateTimeFromSql($datetime));
    }
    //CFDI --------------------------------------------------------------------------
    /**
     * Crea directorios para CFDI's
     *
     * @return string
     * @throws \Exception
     */
    public static function makeDirectoryCfdi($path_xml)
    {
        try {
            $tmp_path = date('Y') . '/' . date('m');
            if (!\Storage::exists($path_xml . $tmp_path)) {
                \Storage::makeDirectory($path_xml . $tmp_path, 0777, true, true);
            }

            return $tmp_path;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
