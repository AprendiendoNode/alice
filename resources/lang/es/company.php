<?php

return [

    // Titulo
    'document_title' => 'Empresa',

    // Textos generales

    // Textos alertas

    // Textos ayuda
    'help_image' => 'La imagen debe ser (jpg,png) de preferencia de 240 x 120 pixeles',

    // Textos tabs
    'tab_files_sat' => 'Certificado de sello digital',

    // Textos formulario
    'entry_name' => 'Nombre',
    'entry_image' => 'Imagen',
    'entry_taxid' => 'RFC',
    'entry_tax_regimen_id' => 'Régimen fiscal',
    'entry_email' => 'Correo electrónico',
    'entry_phone' => 'Teléfono',
    'entry_phone_mobile' => 'Celular',
    'entry_comment' => 'Comentarios',
    'entry_address_1' => 'Dirección',
    'entry_address_2' => 'Num. Ext.',
    'entry_address_3' => 'Num. Int.',
    'entry_address_4' => 'Colonia',
    'entry_address_5' => 'Localidad',
    'entry_address_6' => 'Referencia',
    'entry_country_id' => 'País',
    'entry_state_id' => 'Estado',
    'entry_city_id' => 'Municipio',
    'entry_postcode' => 'C.P.',
    'entry_sort_order' => 'Orden',
    'entry_status' => 'Estatus',
    'entry_file_cer' => 'Certificado (.cer)',
    'entry_file_key' => 'Llave privada (.key)',
    'entry_password_key' => 'Contraseña de llave privada',
    'entry_file_pfx' => 'Archivo (.pfx)',
    'entry_certificate_number' => 'Número',
    'entry_date_start' => 'Fecha inicial',
    'entry_date_end' => 'Fecha final',

    // Textos filtros

    // Columnas listado
    'column_name' => 'Nombre',
    'column_image' => 'Imagen',
    'column_taxid' => 'RFC',
    'column_tax_regimen' => 'Régimen fiscal',
    'column_email' => 'Correo electrónico',
    'column_phone' => 'Teléfono',
    'column_country' => 'País',
    'column_sort_order' => 'Orden',
    'column_status' => 'Estatus',

    // Columnas sub-listado
    'column_bank_account_name' => 'Nombre',
    'column_bank_account_bank_id' => 'Banco',
    'column_bank_account_currency_id' => 'Moneda',
    'column_bank_account_account_number' => 'Número de cuenta',

    // Textos error
    // ---General

    // ---Formulario
    'error_name' => 'Debes ingresar un nombre',
    'error_image' => 'La imagen es inválida solo se permite (jpg,png)',
    'error_taxid' => 'Debes ingresar un RFC',
    'error_taxid_format' => 'El formato del RFC es inválido',
    'error_email_format' => 'El correo electrónico es invalido',
    'error_tax_regimen_id' => 'Debes seleccionar un régimen fiscal',
    'error_country_id' => 'Debes seleccionar un país',
    'error_postcode' => 'Debes ingresar un código postal',
    'error_file_cer' => 'El archivo es inválido solo se permite (cer)',
    'error_file_key' => 'El archivo es inválido solo se permite (key)',
    'error_file_pfx' => 'El archivo es inválido solo se permite (pfx)',
    'error_password_key' => 'Debes ingresar la contraseña de la llave privada',
    'error_file_key_validate_password' => 'La contraseña no corresponde a la llave privada',
    'error_file_key_validate_belong_to_file_cer' => 'El certificado no corresponde a la llave privada',
    'error_bank_account_name' => 'Debes ingresar un nombre',
    'error_bank_account_bank_id' => 'Debes seleccionar un banco',
    'error_bank_account_currency_id' => 'Debes seleccionar una moneda',
    'error_bank_account_account_number' => 'Debes ingresar un número de cuenta',
    'error_bank_account_account_number_format' => 'El formato del número de cuenta es incorrecto debe ser de 10,11,15,16 o 18 dígitos',

    // ---Otros
    'error_company_exists' => 'No se ha definido una empresa',
    'error_file_cer_empty' => 'La empresa no tiene un archivo de certificado (.cer)',
    'error_file_key_empty' => 'La empresa no tiene un archivo de llave privada (.key)',
    'error_file_pfx_empty' => 'La empresa no tiene un archivo PFX (.cer)',
    'error_file_cer_exists' => 'El archivo de certificado (.cer) no existe',
    'error_file_cer_validity' => 'El certificado (.cer) NO se encuentra vigente (%s al %s)',
    'error_file_key_exists' => 'El archivo de llave privada (.key) no existe',
    'error_file_pfx_exists' => 'El archivo de PFX (.pfx) no existe',
    'error_file_cer_pre_validity' => 'El certificado (.cer) esta próximo a vencer (%s al %s)',

];
