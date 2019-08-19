<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 28/02/2019
 * Time: 08:45 PM
 */

namespace App\Helpers;


class Cfdi33Helper
{
    /**
     * Obtiene la cadena original del Tfd
     *
     * @param $cfdi
     * @return string
     */
    public static function getTfdCadenaOrigen($cfdi)
    {
        $tfd = $cfdi->getNode()->searchNode('cfdi:Complemento', 'tfd:TimbreFiscalDigital');
        $tfd_xml_string = \CfdiUtils\Nodes\XmlNodeUtils::nodeToXmlString($tfd);
        //$builder->setXsltBuilder($myXsltBuilder);
        $builder = new \CfdiUtils\TimbreFiscalDigital\TfdCadenaDeOrigen();
        $builder->setXmlResolver(PacHelper::resourcePathCfdiUtils());
        return $builder->build($tfd_xml_string);
    }

    /**
     * Obtener texto de codigo QR
     *
     * @param $cfdi
     * @return string
     */
    public static function getCadenaQr($cfdi)
    {
        $comprobante = $cfdi->getNode();
        $parameters = new \CfdiUtils\ConsultaCfdiSat\RequestParameters(
            $comprobante['Version'],
            $comprobante->searchAttribute('cfdi:Emisor', 'Rfc'),
            $comprobante->searchAttribute('cfdi:Receptor', 'Rfc'),
            $comprobante['Total'],
            $comprobante->searchAttribute('cfdi:Complemento', 'tfd:TimbreFiscalDigital', 'UUID'),
            $comprobante['Sello']
        );
        return $parameters->expression();
    }

    /**
     * Convierte en arreglo el Cfdi
     *
     * @param $cfdi
     * @return array
     */
    public static function getQuickArrayCfdi($cfdi)
    {
        $data = [];
        $data['cfdi33'] = $cfdi->getQuickReader();
        $data['qr_cadena'] = self::getCadenaQr($cfdi);
        $data['tfd_cadena_origen'] = self::getTfdCadenaOrigen($cfdi);

        return $data;
    }

}