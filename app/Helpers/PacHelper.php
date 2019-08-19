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
// use NumberToWords\NumberToWords;
use SoapClient;
use ZipArchive;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Date\Date;
use \Carbon\Carbon;
use DB;

use \CfdiUtils\XmlResolver\XmlResolver;
use \CfdiUtils\CadenaOrigen\DOMBuilder;
class PacHelper
{

    /**
     * Almacenamiento local para archivos del SAT
     *
     * @return \CfdiUtils\XmlResolver\XmlResolver
     */
    public static function resourcePathCfdiUtils()
    {
        $path = \Storage::path('sat');
        return new \CfdiUtils\XmlResolver\XmlResolver($path);
    }

    /**
     * Valida acciones para timbrar
     *
     * @throws \Exception
     */
    public static function validateSatActions()
    {
        try {
            //Valida datos de empresa
            $company = Helper::defaultCompany();
            if (!empty($company)) {
                //Valida archivo cer
                if (empty($company->file_cer)) {
                    throw new \Exception(__('company.error_file_cer_empty'));
                }
                if (!\Storage::exists($company->pathFileCer()) || !\Storage::exists($company->pathFileCerPem())) {
                    throw new \Exception(__('company.error_file_cer_exists'));
                }
                //Valida archivo key
                if (empty($company->file_key)) {
                    throw new \Exception(__('company.error_file_key_empty'));
                }
                if (!\Storage::exists($company->pathFileKeyPassPem())) {
                    throw new \Exception(__('company.error_file_key_exists'));
                }
                //Valida vigencia de certificado
                if (!empty($company->date_start) && !empty($company->date_end)) {
                    if (\Date::parse($company->date_start)->greaterThan(\Date::now())) {
                        throw new \Exception(sprintf(__('company.error_file_cer_validity'),
                            Helper::convertSqlToDateTime($company->date_start),
                            Helper::convertSqlToDateTime($company->date_end)));
                    }
                    if (\Date::parse($company->date_end)->lessThan(\Date::now())) {
                        throw new \Exception(sprintf(__('company.error_file_cer_validity'),
                            Helper::convertSqlToDateTime($company->date_start),
                            Helper::convertSqlToDateTime($company->date_end)));
                    }
                }
            } else {
                throw new \Exception(__('company.error_company_exists'));
            }

            //Valida datos de pac
            $pac = Pac::findOrFail(setting('default_pac_id')); //PAC
            if (!empty($pac)) {
                $class_pac = $pac->code;
                if (!method_exists(self::class, $class_pac)) {
                    throw new \Exception(__('pac.error_pac_class_exists'));
                }
            } else {
                throw new \Exception(__('pac.error_pac_exists'));
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Valida acciones para cancelar timbrar
     *
     * @throws \Exception
     */
    public static function validateSatCancelActions($pac)
    {
        try {
            //Valida datos de empresa
            $company = Helper::defaultCompany();
            if (!empty($company)) {
                //Valida archivo cer
                if (empty($company->file_pfx)) {
                    throw new \Exception(__('company.error_file_pfx_empty'));
                }
                if (!\Storage::exists($company->pathFilePfx())) {
                    throw new \Exception(__('company.error_file_pfx_exists'));
                }
            } else {
                throw new \Exception(__('company.error_company_exists'));
            }

            //Valida datos de pac
            if (!empty($pac)) {
                $class_pac = $pac->code . 'Cancel';
                if (!method_exists(self::class, $class_pac)) {
                    throw new \Exception(__('pac.error_pac_class_exists'));
                }
            } else {
                throw new \Exception(__('pac.error_pac_exists'));
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Clase para timbrado de pruebas
     *
     * @param $tmp
     * @param null $creator
     * @return mixed
     * @throws \Exception
     */
    public static function pacTest($tmp, &$creator = null)
    {
        try {
            $pac = $tmp['pac']; //PAC
            $file_xml_pac = Helper::makeDirectoryCfdi($tmp['path_xml']) . '/' . Str::random(40) . '.xml';
            $uuid = '9FB6ED1A-5F37-4FEF-980A-'.strtoupper(Str::random(12));

            //Creación del nodo de LeyendasFiscales
            $timbreFiscalDigital = new \CfdiUtils\Nodes\Node(
                'tfd:TimbreFiscalDigital', // nombre del elemento raíz
                [ // nodos obligatorios de XML y del nodo
                    'xmlns:tfd' => 'http://www.sat.gob.mx/TimbreFiscalDigital',
                    'xsi:schemaLocation' => 'http://www.sat.gob.mx/TimbreFiscalDigital'
                        . ' http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd',
                    'Version' => '1.1',
                    'UUID' => $uuid,
                    'FechaTimbrado' => \Date::now()->format('Y-m-d\TH:i:s'),
                    'RfcProvCertif' => 'SFE0807172W7',
                    'SelloCFD' => 'W2Fr9AiEuUIFJUVRWMXWMHndDcwvpNCu2g0uTE58wutNkUgjq3J+5f7Kl/ygpAlQggmJB9dKBd2UsYjd94dGTvIso26CFdmW3QY+KBa5d/qpFBsnLxVq+NgP4l2MpAzMMlzD4AsyaTSPnKc6/xmFzIQszCEQ0DsQO+twW0VsxrI=',
                    'NoCertificadoSAT' => '20001000000300022779',
                    'SelloSAT' => 'a0U3KSPH6ouIzOnO3A5KUG+wKJ0Kg77SeDLdw8c4a4bLaib5dCxh4nv1Y/GFq7fgm3DQDCmPTzmcJ8BATwO8r9+e36Zcw0kHcVlJ8+VRz/oHYWyCgq4etsTybXtrqcnLeyCy6Oi38Yk/2lvEwnvtqSFSXrNTL/jA5ZEyeZxpwerGmuQ/NmUC4Ta5+DjjON7bZomfMNBMoAsnLj5uTEQa03mZGhbPg+h/RMLZ7GA2VXLFhxj68YXt/uR5tu4kJTjwTn0ZAK83wzYp68V2TJdEaW3JMLw/5EwXpqctV2drek3u2gt63S9Po2FHpmXDKVNM6LTw57iRQ8tnLSCeKP68Nw==',
                ]
            );

            //Agregar el nodo $timbreFiscalDigital a los complementos del CFDI
            $comprobante = $creator->comprobante();
            $comprobante->addComplemento($timbreFiscalDigital);

            //Guardar XML ya timbrado
            $creator->saveXml(\Storage::path($tmp['path_xml']) . $file_xml_pac);

            //Actualiza los datos para guardar
            $tmp['uuid'] = $uuid;
            $tmp['date'] = Helper::dateTimeToSql(\Date::now());
            $tmp['file_xml_pac'] = $file_xml_pac;

            return $tmp;
        } catch (\SoapFault $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Clase para obtener el estatus del UUID de pruebas
     *
     * @param $tmp
     * @return mixed
     * @throws \Exception
     */
    public static function pacTestStatus($tmp, $pac)
    {
        try {
            $data_status_sat = [
                'cancelable' => 1,
                'status_cancelled' => true,
                'pac_is_cancelable' => 'Pruebas',
                'pac_status' => 'Pruebas',
                'pac_status_cancelation' => 'Pruebas'
            ];

            return $data_status_sat;
        } catch (\SoapFault $e) {
            throw new \Exception($e->getMessage());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Clase para cancelar timbrado de pruebas
     *
     * @param $tmp
     * @return mixed
     * @throws \Exception
     */
    public static function pacTestCancel($tmp, $pac)
    {
        try {
            //Actualiza los datos para guardar
            $tmp['cancel_date'] = Helper::dateTimeToSql(\Date::now());
            $tmp['cancel_response'] = 'ok';

            return $tmp;
        } catch (\SoapFault $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Clase para timbrado con Edicom pruebas
     *
     * @param $tmp
     * @param null $creator
     * @return mixed
     * @throws \Exception
     */
    public static function edicomTest($tmp, &$creator = null)
    {
        try {
            $pac = $tmp['pac']; //PAC
            //
            $context_options = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $ssl_context = stream_context_create($context_options);
            $client = new SoapClient($pac->ws_url, array('stream_context' => $ssl_context));
            $params = array(
                'user' => $pac->username,
                'password' => Crypt::decryptString($pac->password),
                'file' => \Storage::get($tmp['path_xml'] . $tmp['file_xml']),
            );
            //Metodo de timbrado
            $response = $client->__soapCall('getCfdiTest', array('parameters' => $params));
            $result = $response->getCfdiTestReturn;

            //Crear archivo Zip con el contenido de la respuesta
            $path_temp = \Storage::path('temp-xml/');
            $file_zip = Str::random(40) . '.zip';
            \Storage::put('temp-xml/' . $file_zip, $result);

            //Renombra los archivos dentro del zip y los extrae en la carpeta de CFDI
            $file_xml_pac = Str::random(40) . '.xml';
            $list_tmp = Zipper::make($path_temp . $file_zip)->listFiles();
            $zip = new ZipArchive;
            $res = $zip->open($path_temp . $file_zip);
            if ($res == true) {
                if (!empty($list_tmp[0])) {
                    $zip->renameName($list_tmp[0], $file_xml_pac);
                }
                $zip->close();
            }
            Zipper::make($path_temp . $file_zip)->extractTo(\Storage::path($tmp['path_xml']) . Helper::makeDirectoryCfdi($tmp['path_xml']));

            //Obtiene datos del CFDI ya timbrado
            $cfdi = \CfdiUtils\Cfdi::newFromString(\Storage::get($tmp['path_xml'] . Helper::makeDirectoryCfdi($tmp['path_xml']) . '/' . $file_xml_pac));
            $tfd = $cfdi->getNode()->searchNode('cfdi:Complemento', 'tfd:TimbreFiscalDigital');

            //Actualiza los datos para guardar
            $tmp['uuid'] = $tfd['UUID'];
            $tmp['date'] = str_replace('T', ' ', $tfd['FechaTimbrado']);
            $tmp['file_xml_pac'] = Helper::makeDirectoryCfdi($tmp['path_xml']) . '/' . $file_xml_pac;

            return $tmp;
        } catch (\SoapFault $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Clase para obtener el estatus del UUID en pruebas
     *
     * @param $tmp
     * @param null $creator
     * @return mixed
     * @throws \Exception
     */
    public static function edicomTestStatus($tmp, $pac)
    {
        try {
            $company = Helper::defaultCompany(); //Empresa
            //
            $context_options = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $ssl_context = stream_context_create($context_options);
            $client = new SoapClient($pac->ws_url_cancel, array('stream_context' => $ssl_context));
            $params = [
                'user' => $pac->username,
                'password' => Crypt::decryptString($pac->password),
                'rfcE' => $company->taxid,
                'rfcR' => $tmp['rfcR'],
                'uuid' => $tmp['uuid'],
                'total' => $tmp['total'],
                'test' => true,
            ];
            $response = $client->__soapCall('getCFDiStatus', array('parameters' => $params));
            $result = $response->getCFDiStatusReturn;
            $data_status_sat = [];
            if(isset($result->status)){
                //Valida si el CFDI puede ser cancelado 1 Sin aceptacion, 2 Con Aceptacion, 3 no cancelable o si ya esta cancelado
                $cancelable = 1;
                if(isset($result->isCancelable) && in_array($result->isCancelable,['Cancelable con aceptación'])){
                    $cancelable = 2;
                }
                if(isset($result->isCancelable) && in_array($result->isCancelable,['No cancelable'])){
                    $cancelable = 3;
                }
                if(isset($result->status) && in_array($result->status,['Cancelado','No Encontrado'])){
                    $cancelable = 3;
                }
                //Valida si ya fue aceptado el proceso de cancelacion
                $status_cancelled = false;
                if(isset($result->cancelStatus) && in_array($result->cancelStatus,['Cancelado con aceptación','Plazo vencido','Cancelado sin aceptación'])){
                    $status_cancelled = true;
                }
                $data_status_sat = [
                    'cancelable' => $cancelable,
                    'status_cancelled' => $status_cancelled,
                    'pac_is_cancelable' => $result->isCancelable ?? '',
                    'pac_status' => $result->status ?? '',
                    'pac_status_cancelation' => $result->cancelStatus ?? ''
                ];
            }
            return $data_status_sat;
        } catch (\SoapFault $e) {
            throw new \Exception($e->getMessage());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Clase para cancelar timbrado Edicom de pruebas
     *
     * @param $tmp
     * @return mixed
     * @throws \Exception
     */
    public static function edicomTestCancel($tmp, $pac)
    {
        try {
            $company = Helper::defaultCompany(); //Empresa
            //
            $context_options = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $ssl_context = stream_context_create($context_options);
            $client = new SoapClient($pac->ws_url_cancel, array('stream_context' => $ssl_context));
            $params = array(
                'user' => $pac->username,
                'password' => Crypt::decryptString($pac->password),
                'rfcE' => $company->taxid,
                'rfcR' => $tmp['rfcR'],
                'uuid' => $tmp['uuid'],
                'total' => $tmp['total'],
                'pfx' => \Storage::get($company->pathFilePfx()),
                'pfxPassword' => Crypt::decryptString($company->password_key),
                'test' => true,
            );
            //Metodo de cancelacion de timbrado
            //$response = $client->__soapCall('cancelCFDiAsync', array('parameters' => $params));
            //$result = $response->cancelCFDiAsyncReturn;

            //Actualiza los datos para guardar
            $tmp['cancel_date'] = Helper::dateTimeToSql(\Date::now());
            $tmp['cancel_response'] = 'ok';

            return $tmp;
        } catch (\SoapFault $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Clase para timbrado con Edicom
     *
     * @param $tmp
     * @param null $creator
     * @return mixed
     * @throws \Exception
     */
    public static function edicom($tmp, &$creator = null)
    {
        try {
            $pac = $tmp['pac']; //PAC
            //
            $context_options = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $ssl_context = stream_context_create($context_options);
            $client = new SoapClient($pac->ws_url, array('stream_context' => $ssl_context));
            $params = array(
                'user' => $pac->username,
                'password' => Crypt::decryptString($pac->password),
                'file' => \Storage::get($tmp['path_xml'] . $tmp['file_xml']),
            );
            //Metodo de timbrado
            $response = $client->__soapCall('getCfdi', array('parameters' => $params));
            $result = $response->getCfdiReturn;

            //Crear archivo Zip con el contenido de la respuesta
            $path_temp = \Storage::path('temp-xml/');
            $file_zip = Str::random(40) . '.zip';
            \Storage::put('temp-xml/' . $file_zip, $result);

            //Renombra los archivos dentro del zip y los extrae en la carpeta de CFDI
            $file_xml_pac = Str::random(40) . '.xml';
            $list_tmp = Zipper::make($path_temp . $file_zip)->listFiles();
            $zip = new ZipArchive;
            $res = $zip->open($path_temp . $file_zip);
            if ($res == true) {
                if (!empty($list_tmp[0])) {
                    $zip->renameName($list_tmp[0], $file_xml_pac);
                }
                $zip->close();
            }
            Zipper::make($path_temp . $file_zip)->extractTo(\Storage::path($tmp['path_xml']) . Helper::makeDirectoryCfdi($tmp['path_xml']));

            //Obtiene datos del CFDI ya timbrado
            $cfdi = \CfdiUtils\Cfdi::newFromString(\Storage::get($tmp['path_xml'] . Helper::makeDirectoryCfdi($tmp['path_xml']) . '/' . $file_xml_pac));
            $tfd = $cfdi->getNode()->searchNode('cfdi:Complemento', 'tfd:TimbreFiscalDigital');

            //Actualiza los datos para guardar
            $tmp['uuid'] = $tfd['UUID'];
            $tmp['date'] = str_replace('T', ' ', $tfd['FechaTimbrado']);
            $tmp['file_xml_pac'] = Helper::makeDirectoryCfdi($tmp['path_xml']) . '/' . $file_xml_pac;

            return $tmp;
        } catch (\SoapFault $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Clase para obtener el estatus del UUID en pruebas
     *
     * @param $tmp
     * @param null $creator
     * @return mixed
     * @throws \Exception
     */
    public static function edicomStatus($tmp, $pac)
    {
        try {
            $company = Helper::defaultCompany(); //Empresa
            //
            $context_options = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $ssl_context = stream_context_create($context_options);
            $client = new SoapClient($pac->ws_url_cancel, array('stream_context' => $ssl_context));
            $params = [
                'user' => $pac->username,
                'password' => Crypt::decryptString($pac->password),
                'rfcE' => $company->taxid,
                'rfcR' => $tmp['rfcR'],
                'uuid' => $tmp['uuid'],
                'total' => $tmp['total'],
                'test' => false,
            ];
            $response = $client->__soapCall('getCFDiStatus', array('parameters' => $params));
            $result = $response->getCFDiStatusReturn;
            $data_status_sat = [];
            if(isset($result->status)){
                //Valida si el CFDI puede ser cancelado 1 Sin aceptacion, 2 Con Aceptacion, 3 no cancelable o si ya esta cancelado
                $cancelable = 1;
                if(isset($result->isCancelable) && in_array($result->isCancelable,['Cancelable con aceptación'])){
                    $cancelable = 2;
                }
                if(isset($result->isCancelable) && in_array($result->isCancelable,['No cancelable'])){
                    $cancelable = 3;
                }
                if(isset($result->status) && in_array($result->status,['Cancelado','No Encontrado'])){
                    $cancelable = 3;
                }
                //Valida si ya fue aceptado el proceso de cancelacion
                $status_cancelled = false;
                if(isset($result->cancelStatus) && in_array($result->cancelStatus,['Cancelado con aceptación','Plazo vencido','Cancelado sin aceptación'])){
                    $status_cancelled = true;
                }
                $data_status_sat = [
                    'cancelable' => $cancelable,
                    'status_cancelled' => $status_cancelled,
                    'pac_is_cancelable' => $result->isCancelable ?? '',
                    'pac_status' => $result->status ?? '',
                    'pac_status_cancelation' => $result->cancelStatus ?? ''
                ];
            }
            return $data_status_sat;
        } catch (\SoapFault $e) {
            throw new \Exception($e->getMessage());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Clase para cancelar timbrado Edicom de pruebas
     *
     * @param $tmp
     * @return mixed
     * @throws \Exception
     */
    public static function edicomCancel($tmp, $pac)
    {
        try {
            $company = Helper::defaultCompany(); //Empresa
            //
            $context_options = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $ssl_context = stream_context_create($context_options);
            $client = new SoapClient($pac->ws_url_cancel, array('stream_context' => $ssl_context));
            $params = array(
                'user' => $pac->username,
                'password' => Crypt::decryptString($pac->password),
                'rfcE' => $company->taxid,
                'rfcR' => $tmp['rfcR'],
                'uuid' => $tmp['uuid'],
                'total' => $tmp['total'],
                'pfx' => \Storage::get($company->pathFilePfx()),
                'pfxPassword' => Crypt::decryptString($company->password_key),
                'test' => false,
            );
            //Metodo de cancelacion de timbrado
            $response = $client->__soapCall('cancelCFDiAsync', array('parameters' => $params));
            $result = $response->cancelCFDiAsyncReturn;
            $tmp_response = 'ok';
            if(!empty($result->ack)){
                $tmp_response = $result->ack;
            }

            //Actualiza los datos para guardar
            $tmp['cancel_date'] = Helper::dateTimeToSql(\Date::now());
            $tmp['cancel_response'] = $tmp_response;

            return $tmp;
        } catch (\SoapFault $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Clase para timbrado con Finkok pruebas
     *
     * @param $tmp
     * @param null $creator
     * @return mixed
     * @throws \Exception
     */
    public static function finkokTest($tmp, &$creator = null)
    {
        try {
            $pac = $tmp['pac']; //PAC
            //
            $client = new SoapClient($pac->ws_url);
            /*
            $params = [
                'username' => $pac->username,
                'password' => Crypt::decryptString($pac->password),
                'xml' => \Storage::get($tmp['path_xml'] . $tmp['file_xml']),
            ];
            */
            $params = [
                'username' => $pac->username,
                'password' => $pac->password,
                'xml' => \Storage::get($tmp['path_xml'] . $tmp['file_xml']),
            ];
            //Metodo de timbrado
            $response = $client->__soapCall('stamp', ['parameters' => $params]);

            if (isset($response->stampResult->Incidencias->Incidencia)) {
                throw new \Exception($response->stampResult->Incidencias->Incidencia->MensajeIncidencia);
            }else{
                $tmp_xml = $response->stampResult->xml;
                $file_xml_pac = Str::random(40) . '.xml';
                \Storage::put($tmp['path_xml'] . Helper::makeDirectoryCfdi($tmp['path_xml']) . '/' . $file_xml_pac, $tmp_xml);
            }

            //Obtiene datos del CFDI ya timbrado
            $cfdi = \CfdiUtils\Cfdi::newFromString(\Storage::get($tmp['path_xml'] . Helper::makeDirectoryCfdi($tmp['path_xml']) . '/' . $file_xml_pac));
            $tfd = $cfdi->getNode()->searchNode('cfdi:Complemento', 'tfd:TimbreFiscalDigital');

            //Actualiza los datos para guardar
            $tmp['uuid'] = $tfd['UUID'];
            $tmp['date'] = str_replace('T', ' ', $tfd['FechaTimbrado']);
            $tmp['file_xml_pac'] = Helper::makeDirectoryCfdi($tmp['path_xml']) . '/' . $file_xml_pac;

            return $tmp;
        } catch (\SoapFault $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Clase para obtener el estatus del UUID en pruebas
     *
     * @param $tmp
     * @param null $creator
     * @return mixed
     * @throws \Exception
     */
    public static function finkokTestStatus($tmp, $pac)
    {
        try {
            $company = Helper::defaultCompany(); //Empresa

            $client = new SoapClient($pac->ws_url_cancel);
            $params = [
                'username' => $pac->username,
                'password' => Crypt::decryptString($pac->password),
                'taxpayer_id' => $company->taxid,
                'rtaxpayer_id' => $tmp['rfcR'],
                'uuid' => $tmp['uuid'],
                'total' => $tmp['total'],
            ];
            $response = $client->__soapCall('get_sat_status', ['parameters' => $params]);
            $data_status_sat = [];
            if(isset($response->get_sat_statusResult->sat)){
                //Valida si el CFDI puede ser cancelado 1 Sin aceptacion, 2 Con Aceptacion, 3 no cancelable o si ya esta cancelado
                $cancelable = 1;
                if(isset($response->get_sat_statusResult->sat->EsCancelable) && in_array($response->get_sat_statusResult->sat->EsCancelable,['Cancelable con aceptación'])){
                    $cancelable = 2;
                }
                if(isset($response->get_sat_statusResult->sat->EsCancelable) && in_array($response->get_sat_statusResult->sat->EsCancelable,['No cancelable'])){
                    $cancelable = 3;
                }
                if(isset($response->get_sat_statusResult->sat->Estado) && in_array($response->get_sat_statusResult->sat->Estado,['Cancelado','No Encontrado'])){
                    $cancelable = 3;
                }
                //Valida si ya fue aceptado el proceso de cancelacion
                $status_cancelled = false;
                if(isset($response->get_sat_statusResult->sat->EstatusCancelacion) && in_array($response->get_sat_statusResult->sat->EstatusCancelacion,['Cancelado con aceptación','Plazo vencido','Cancelado sin aceptación'])){
                    $status_cancelled = true;
                }
                $data_status_sat = [
                    'cancelable' => $cancelable,
                    'status_cancelled' => $status_cancelled,
                    'pac_is_cancelable' => $response->get_sat_statusResult->sat->EsCancelable ?? '',
                    'pac_status' => $response->get_sat_statusResult->sat->Estado ?? '',
                    'pac_status_cancelation' => $response->get_sat_statusResult->sat->EstatusCancelacion ?? ''
                ];
            }
            return $data_status_sat;
        } catch (\SoapFault $e) {
            throw new \Exception($e->getMessage());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Clase para cancelar timbrado Finkok de pruebas
     *
     * @param $tmp
     * @return mixed
     * @throws \Exception
     */
    public static function finkokTestCancel($tmp, $pac)
    {
        try {
            $company = Helper::defaultCompany(); //Empresa

            //Crear archivos key.finkok.pass.pem con la clave del usuario como lo solicita finkok
            //Convertir en PEM con contraseña
            $path_file_key = $company->pathFileKey();
            $path_file_key_pem = $path_file_key . '.pem';
            $path_file_key_finkok_pass_pem = $path_file_key . '.finkok.pass.pem';
            if (\Storage::exists($path_file_key) && \Storage::exists($path_file_key_pem) && !\Storage::exists($path_file_key_finkok_pass_pem)) {
                $process = new Process('openssl rsa -in ' . \Storage::path($path_file_key_pem) . ' -des3 -out ' . \Storage::path($path_file_key_finkok_pass_pem) . ' -passout pass:' . Crypt::decryptString($pac->password));
                $process->run();
                if (!$process->isSuccessful()) {
                    throw new ProcessFailedException($process);
                }
            }

            //
            $uuids = [$tmp['uuid']];
            $client = new SoapClient($pac->ws_url_cancel);
            $params = [
                'UUIDS' => ['uuids' => $uuids],
                'username' => $pac->username,
                'password' => Crypt::decryptString($pac->password),
                'taxpayer_id' => $company->taxid,
                'cer' => \Storage::get($company->pathFileCerPem()),
                'key' => \Storage::exists($path_file_key_finkok_pass_pem) ? \Storage::get($path_file_key_finkok_pass_pem) : null,
            ];
            //Metodo de cancelacion de timbrado
            $response = $client->__soapCall('cancel', ['parameters' => $params]);
            $tmp_response = 'ok';
            if(isset($response->cancelResult->Folios->Folio->EstatusUUID) && in_array($response->cancelResult->Folios->Folio->EstatusUUID,['201','202'])){
                if(!empty($response->cancelResult->Acuse)){
                    $tmp_response = $response->cancelResult->Acuse;
                }else{
                    $tmp_response = 'Sin acuse';
                }
            }else{ //En caso de errores
                if(!empty($response->cancelResult->Folios->Folio->EstatusUUID)){
                    $ms_error = $response->cancelResult->Folios->Folio->EstatusUUID;
                    if($ms_error == '708'){
                        $ms_error = 'Error 708: No se pudo conectar al SAT';
                    }
                    throw new \Exception($ms_error);
                }elseif(!empty($response->cancelResult->CodEstatus)){
                    throw new \Exception($response->cancelResult->CodEstatus);
                }
                throw new \Exception(__('general.error_ws_cfdi'));
            }

            //Actualiza los datos para guardar
            $tmp['cancel_date'] = Helper::dateTimeToSql(\Date::now());
            $tmp['cancel_response'] = $tmp_response;

            return $tmp;
        } catch (\SoapFault $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Clase para timbrado con Finkok pruebas
     *
     * @param $tmp
     * @param null $creator
     * @return mixed
     * @throws \Exception
     */
    public static function finkok($tmp, &$creator = null)
    {
        try {
            $pac = $tmp['pac']; //PAC

            //
            $client = new SoapClient($pac->ws_url);
            $params = [
                'username' => $pac->username,
                'password' => Crypt::decryptString($pac->password),
                'xml' => \Storage::get($tmp['path_xml'] . $tmp['file_xml']),
            ];
            //Metodo de timbrado
            $response = $client->__soapCall('stamp', ['parameters' => $params]);

            if (isset($response->stampResult->Incidencias->Incidencia)) {
                throw new \Exception($response->stampResult->Incidencias->Incidencia->MensajeIncidencia);
            }else{
                $tmp_xml = $response->stampResult->xml;
                $file_xml_pac = Str::random(40) . '.xml';
                \Storage::put($tmp['path_xml'] . Helper::makeDirectoryCfdi($tmp['path_xml']) . '/' . $file_xml_pac, $tmp_xml);
            }

            //Obtiene datos del CFDI ya timbrado
            $cfdi = \CfdiUtils\Cfdi::newFromString(\Storage::get($tmp['path_xml'] . Helper::makeDirectoryCfdi($tmp['path_xml']) . '/' . $file_xml_pac));
            $tfd = $cfdi->getNode()->searchNode('cfdi:Complemento', 'tfd:TimbreFiscalDigital');

            //Actualiza los datos para guardar
            $tmp['uuid'] = $tfd['UUID'];
            $tmp['date'] = str_replace('T', ' ', $tfd['FechaTimbrado']);
            $tmp['file_xml_pac'] = Helper::makeDirectoryCfdi($tmp['path_xml']) . '/' . $file_xml_pac;

            return $tmp;
        } catch (\SoapFault $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Clase para obtener el estatus del UUID en pruebas
     *
     * @param $tmp
     * @param null $creator
     * @return mixed
     * @throws \Exception
     */
    public static function finkokStatus($tmp, $pac)
    {
        try {
            $company = Helper::defaultCompany(); //Empresa

            $client = new SoapClient($pac->ws_url_cancel);
            $params = [
                'username' => $pac->username,
                'password' => Crypt::decryptString($pac->password),
                'taxpayer_id' => $company->taxid,
                'rtaxpayer_id' => $tmp['rfcR'],
                'uuid' => $tmp['uuid'],
                'total' => $tmp['total'],
            ];
            $response = $client->__soapCall('get_sat_status', ['parameters' => $params]);
            $data_status_sat = [];
            if(isset($response->get_sat_statusResult->sat)){
                //Valida si el CFDI puede ser cancelado 1 Sin aceptacion, 2 Con Aceptacion, 3 no cancelable o si ya esta cancelado
                $cancelable = 1;
                if(isset($response->get_sat_statusResult->sat->EsCancelable) && in_array($response->get_sat_statusResult->sat->EsCancelable,['Cancelable con aceptación'])){
                    $cancelable = 2;
                }
                if(isset($response->get_sat_statusResult->sat->EsCancelable) && in_array($response->get_sat_statusResult->sat->EsCancelable,['No cancelable'])){
                    $cancelable = 3;
                }
                if(isset($response->get_sat_statusResult->sat->Estado) && in_array($response->get_sat_statusResult->sat->Estado,['Cancelado','No Encontrado'])){
                    $cancelable = 3;
                }
                //Valida si ya fue aceptado el proceso de cancelacion
                $status_cancelled = false;
                if(isset($response->get_sat_statusResult->sat->EstatusCancelacion) && in_array($response->get_sat_statusResult->sat->EstatusCancelacion,['Cancelado con aceptación','Plazo vencido','Cancelado sin aceptación'])){
                    $status_cancelled = true;
                }
                $data_status_sat = [
                    'cancelable' => $cancelable,
                    'status_cancelled' => $status_cancelled,
                    'pac_is_cancelable' => $response->get_sat_statusResult->sat->EsCancelable ?? '',
                    'pac_status' => $response->get_sat_statusResult->sat->Estado ?? '',
                    'pac_status_cancelation' => $response->get_sat_statusResult->sat->EstatusCancelacion ?? ''
                ];
            }
            return $data_status_sat;
        } catch (\SoapFault $e) {
            throw new \Exception($e->getMessage());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Clase para cancelar timbrado Finkok de pruebas
     *
     * @param $tmp
     * @return mixed
     * @throws \Exception
     */
    public static function finkokCancel($tmp, $pac)
    {
        try {
            $company = Helper::defaultCompany(); //Empresa

            //Crear archivos key.finkok.pass.pem con la clave del usuario como lo solicita finkok
            //Convertir en PEM con contraseña
            $path_file_key = $company->pathFileKey();
            $path_file_key_pem = $path_file_key . '.pem';
            $path_file_key_finkok_pass_pem = $path_file_key . '.finkok.pass.pem';
            if (\Storage::exists($path_file_key) && \Storage::exists($path_file_key_pem) && !\Storage::exists($path_file_key_finkok_pass_pem)) {
                $process = new Process('openssl rsa -in ' . \Storage::path($path_file_key_pem) . ' -des3 -out ' . \Storage::path($path_file_key_finkok_pass_pem) . ' -passout pass:' . Crypt::decryptString($pac->password));
                $process->run();
                if (!$process->isSuccessful()) {
                    throw new ProcessFailedException($process);
                }
            }

            //
            $uuids = [$tmp['uuid']];
            $client = new SoapClient($pac->ws_url_cancel);
            $params = [
                'UUIDS' => ['uuids' => $uuids],
                'username' => $pac->username,
                'password' => Crypt::decryptString($pac->password),
                'taxpayer_id' => $company->taxid,
                'cer' => \Storage::get($company->pathFileCerPem()),
                'key' => \Storage::exists($path_file_key_finkok_pass_pem) ? \Storage::get($path_file_key_finkok_pass_pem) : null,
            ];
            //Metodo de cancelacion de timbrado
            $response = $client->__soapCall('cancel', ['parameters' => $params]);
            $tmp_response = 'ok';
            if(isset($response->cancelResult->Folios->Folio->EstatusUUID) && in_array($response->cancelResult->Folios->Folio->EstatusUUID,['201','202'])){
                if(!empty($response->cancelResult->Acuse)){
                    $tmp_response = $response->cancelResult->Acuse;
                }else{
                    $tmp_response = 'Sin acuse';
                }
            }else{ //En caso de errores
                if(!empty($response->cancelResult->Folios->Folio->EstatusUUID)){
                    $ms_error = $response->cancelResult->Folios->Folio->EstatusUUID;
                    if($ms_error == '708'){
                        $ms_error = 'Error 708: No se pudo conectar al SAT';
                    }
                    throw new \Exception($ms_error);
                }elseif(!empty($response->cancelResult->CodEstatus)){
                    throw new \Exception($response->cancelResult->CodEstatus);
                }
                throw new \Exception(__('general.error_ws_cfdi'));
            }

            //Actualiza los datos para guardar
            $tmp['cancel_date'] = Helper::dateTimeToSql(\Date::now());
            $tmp['cancel_response'] = $tmp_response;

            return $tmp;
        } catch (\SoapFault $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
