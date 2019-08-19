<?php

return [

    // Titulo
    'document_title' => 'Pagos',

    // Textos generales
    'text_status_open' => 'Por conciliar',
    'text_status_reconciled' => 'Conciliado',
    'text_status_cancel' => 'Cancelado',
    'text_mark_open' => 'Marcar como abierto',
    'text_mark_sent' => 'Marcar como enviado',
    'text_mark_reconciled' => 'Marcar como conciliado',
    'text_mail_text_00' => '<strong>Notificación</strong>',
    'text_mail_text_0' => 'Hola <strong>%s</strong>',
    'text_mail_text_1' => 'Le remitimos adjunto el siguiente recibo de pago:',
    'text_mail_text_2' => 'Folio: <b>%s</b><br/>Fecha: %s<br/>Total: %s %s<br/>Número de operación: %s',
    'text_mail_text_3' => 'Si tiene alguna pregunta no dude en contactarnos.',
    'text_mail_text_4' => '<br><strong>%s</strong>',
    'text_mail_text_5' => '<br>Tel.: %s',
    'text_mail_text_6' => '<br>Correo electrónico: %s',
    'text_mail_text_7' => '<br><span style="">Sitio Web  <a href="%s" target="_blank" >%s</a></span>',
    'text_mail_text_8' => 'Este mensaje ha sido enviado desde una dirección de correo electrónico exclusivamente de notificación, que no admite mensajes. Por favor, no responda al mismo.',
    'text_modal_send_mail' => 'Enviar %s',
    'text_modal_cancel' => 'Cancelar %s',
    'text_modal_status_sat' => 'Estatus SAT - %s',
    'text_modal_cancel_help1' => '¿Esta seguro de cancelar la <strong>%s</strong>?',
    'text_modal_cancel_help2' => 'Esta acción no se podrá deshacer una vez confirmada la cancelación',
    'text_modal_reconciled' => 'Conciliar %s',
    'text_per_reconciled' => 'Por conciliar',
    'text_reconciled' => 'Conciliado',
    'text_payment_complement' => 'Complemento de pago',
    'text_ordenante' => 'Ordenante',
    'text_beneficiario' => 'Beneficiario',
    'text_RfcEmisorCtaOrd' => 'RFC Banco',
    'text_NomBancoOrdExt' => 'Nombre Banco',
    'text_CtaOrdenante' => 'Número de cuenta',
    'text_RfcEmisorCtaBen' => 'RFC Banco',
    'text_CtaBeneficiario' => 'Número de cuenta',
    'text_TipoCadPago' => 'Tipo cadena del pago',
    'text_CertPago' => 'Certificado del pago',
    'text_CadPago' => 'Cadena original del comprobante de pago',
    'text_SelloPago' => 'Sello del pago',
    'text_modal_status_sat_help1' => '¿Que estatus tiene el CFDI en el SAT?',



    // Textos alertas
    'text_success_send_mail' => 'El recibo de pago <strong>%s</strong> se ha enviado con éxito',
    'text_success_reconciled' => 'El recibo de pago <strong>%s</strong> se ha conciliado con éxito',

    // Textos ayuda

    // Textos tabs
    'tab_reconcileds' => 'Facturas',
    'tab_spei' => 'SPEI',
    'tab_relations' => 'CFDI\'s relacionados',

    // Textos formulario
    'entry_name' => 'Folio',
    'entry_company_bank_account_id' => 'Cuenta beneficiaria',
    'entry_customer_id' => 'Cliente',
    'entry_customer_bank_account_id' => 'Cuenta ordenante',
    'entry_branch_office_id' => 'Sucursal',
    'entry_date' => 'Fecha',
    'entry_date_payment' => 'Fecha de pago',
    'entry_currency_id' => 'Moneda',
    'entry_currency_value' => 'TC',
    'entry_payment_way_id' => 'Forma de pago',
    'entry_cfdi_relation_id' => 'Tipo de relación',
    'entry_reference' => 'Número de operación',
    'entry_amount' => 'Monto',
    'entry_cfdi' => 'Complemento de pago',
    'entry_comment' => 'Comentarios',
    'entry_sort_order' => 'Orden',
    'entry_status' => 'Estatus',
    'entry_tipo_cadena_pago' => 'Tipo cadena de pago',
    'entry_certificado_pago' => 'Certificado de pago',
    'entry_cadena_pago' => 'Cadena original del complemento de pago',
    'entry_sello_pago' => 'Sello del pago',

    // Textos filtros

    // Columnas listado
    'column_name' => 'Folio',
    'column_date' => 'Fecha',
    'column_uuid' => 'UUID',
    'column_customer' => 'Cliente',
    'column_branch_office' => 'Sucursal',
    'column_payment_way' => 'Forma de pago',
    'column_date_payment' => 'Fecha de pago',
    'column_company_bank_account' => 'Cuenta beneficiaria',
    'column_customer_bank_account' => 'Cuenta ordenante',
    'column_currency' => 'Moneda',
    'column_amount' => 'Monto',
    'column_balance' => 'Por conciliar',
    'column_mail_sent' => 'Enviado',
    'column_sort_order' => 'Orden',
    'column_status' => 'Estatus',

    // Columnas sub-listado
    'column_reconciled_date' => 'Fecha',
    'column_reconciled_name' => 'Factura',
    'column_reconciled_date_due' => 'Fecha de vencimiento',
    'column_reconciled_currency' => 'Moneda',
    'column_reconciled_amount_total' => 'Total',
    'column_reconciled_balance' => 'Saldo',
    'column_reconciled_currency_value' => 'TC de pago',
    'column_reconciled_currency_value2' => 'TC',
    'column_reconciled_amount_reconciled' => 'Monto conciliado',
    'column_reconciled_amount_reconciled2' => 'Monto pagado',
    'column_reconciled_uuid' => 'UUID',
    'column_reconciled_serie' => 'Serie',
    'column_reconciled_folio' => 'Folio',
    'column_reconciled_payment_method' => 'Método de pago',
    'column_reconciled_number_of_payment' => 'Parcialidad',
    'column_reconciled_last_balance' => 'Saldo anterior',
    'column_reconciled_currenct_balance' => 'Saldo insoluto',
    'column_relation_relation_id' => 'CFDI',
    'column_relation_uuid' => 'UUID',

    // Textos error
    // ---General

    // ---Formulario
    'error_name' => 'Debes ingresar un nombre',
    'error_date' => 'Debes ingresar una fecha',
    'error_date_format' => 'El formato de la fecha es incorrecto',
    'error_date_payment' => 'Debes ingresar una fecha de pago',
    'error_date_payment_format' => 'El formato de la fecha es incorrecto',
    'error_customer_id' => 'Debes seleccionar un cliente',
    'error_payment_way_id' => 'Debes seleccionar una forma de pago',
    'error_branch_office_id' => 'Debes seleccionar una sucursal',
    'error_currency_id' => 'Debes seleccionar una moneda',
    'error_currency_value' => 'El tipo de cambio es incorrecto',
    'error_amount' => 'El monto es incorrecto',
    'error_cfdi_relation_id' => 'Debes seleccionar el tipo de relación',
    'error_reconciled_currency_value' => 'El tipo de cambio es incorrecto',
    'error_reconciled_amount_reconciled' => 'El monto conciliado es incorrecto',
    'error_reconciled_amount_reconciled_customer_invoice_balance' => 'El monto supera el saldo de la factura',
    'error_relation_relation_id' => 'Debes seleccionar un CFDI',

    'error_certificado_pago' => 'Debes ingresar el certificado de pago',
    'error_cadena_pago' => 'Debes ingresar la cadena original del complemento de pago',
    'error_sello_pago' => 'Debes ingresar el sello del pago',

    // ---Otros
    'error_change_status' => 'No se puede cambiar el estatus',
    'error_download_xml' => 'Error al descargar el archivo XML',
    'error_currency_id_company_bank_account_id' => 'La moneda de la cuenta debe ser igual a la de pago',
    'error_pattern_account_company_bank_account_id' => 'El patrón de la cuenta beneficiaria es incorrecta para el método de pago',
    'error_currency_id_customer_bank_account_id' => 'La moneda de la cuenta debe ser igual a la de pago',
    'error_pattern_account_customer_bank_account_id' => 'El patrón de la cuenta ordenante es incorrecta para el método de pago',
    'error_amount_amount_reconciled' => 'El monto conciliado supera el monto de pago',

];
