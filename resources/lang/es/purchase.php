<?php

return [

    // Titulo
    'document_title' => 'Notas de crédito',

    // Textos generales
    'text_status_elaborado' => 'Elaborado',
    'text_status_revisado' => 'Revisado',
    'text_status_autorizado' => 'Autorizado',
    'text_status_cancelado' => 'Cancelado',

    'text_status_open' => 'Por conciliar',
    'text_status_paid' => 'Pagada',
    'text_status_reconciled' => 'Conciliada',
    'text_status_cancel' => 'Cancelada',
    'text_mark_open' => 'Marcar como abierta',
    'text_mark_sent' => 'Marcar como enviada',
    'text_mark_reconciled' => 'Marcar como conciliada',
    'text_mail_text_00' => '<strong>Notificación</strong>',
    'text_mail_text_0' => 'Hola <strong>%s</strong>',
    'text_mail_text_1' => 'Le remitimos adjunta la siguiente nota de crédito:',
    'text_mail_text_2' => 'Folio: <b>%s</b><br/>Fecha: %s<br/>Total: %s %s<br/>Referencia: %s',
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
    'text_per_reconciled' => 'Por conciliar',
    'text_reconciled' => 'Conciliado',
    'text_modal_status_sat_help1' => '¿Que estatus tiene el CFDI en el SAT?',

    // Textos alertas
    'text_success_send_mail' => 'La nota de crédito <strong>%s</strong> se ha enviado con éxito',

    // Textos ayuda

    // Textos tabs
    'tab_products' => 'Productos/Servicios',
    'tab_reconcileds' => 'Facturas',
    'tab_relations' => 'CFDI\'s relacionados',

    // Textos formulario
    'entry_name' => 'Folio',
    'entry_customer_id' => 'Cliente',
    'entry_branch_office_id' => 'Sucursal',
    'entry_date' => 'Fecha',
    'entry_salesperson_id' => 'Vendedor',
    'entry_currency_id' => 'Moneda',
    'entry_currency_value' => 'TC',
    'entry_payment_term_id' => 'Términos de pago',
    'entry_payment_way_id' => 'Forma de pago',
    'entry_payment_method_id' => 'Método de pago',
    'entry_cfdi_use_id' => 'Uso de CFDI',
    'entry_cfdi_relation_id' => 'Tipo de relación',
    'entry_reference' => 'Referencia',
    'entry_comment' => 'Comentarios',
    'entry_sort_order' => 'Orden',
    'entry_status' => 'Estatus',
    'entry_amount_total' => 'Monto total',

    // Textos filtros

    // Columnas listado
    'column_name' => 'Folio',
    'column_date' => 'Fecha',
    'column_uuid' => 'UUID',
    'column_customer' => 'Cliente',
    'column_salesperson' => 'Vendedor',
    'column_branch_office' => 'Sucursal',
    'column_payment_term' => 'Términos de pago',
    'column_payment_way' => 'Forma de pago',
    'column_cfdi_use' => 'Uso de CFDI',
    'column_currency' => 'Moneda',
    'column_amount_total' => 'Total',
    'column_balance' => 'Por conciliar',
    'column_mail_sent' => 'Enviada',
    'column_sort_order' => 'Orden',
    'column_status' => 'Estatus',

    // Columnas sub-listado
    'column_line_product_id' => 'Producto',
    'column_line_name' => 'Descripción',
    'column_line_unit_measure_id' => 'U. M.',
    'column_line_sat_product_id' => 'Prod/Serv SAT',
    'column_line_quantity' => 'Cantidad',
    'column_line_price_unit' => 'Precio',
    'column_line_taxes' => 'Impuestos',
    'column_line_amount_untaxed' => 'Total',

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
    'error_customer_id' => 'Debes seleccionar un cliente',
    'error_branch_office_id' => 'Debes seleccionar una sucursal',
    'error_date' => 'Debes ingresar una fecha',
    'error_date_format' => 'El formato de la fecha es incorrecto',
    'error_currency_id' => 'Debes seleccionar una moneda',
    'error_currency_value' => 'El tipo de cambio es incorrecto',
    'error_payment_term_id' => 'Debes seleccionar un término de pago',
    'error_payment_way_id' => 'Debes seleccionar una forma de pago',
    'error_payment_method_id' => 'Debes seleccionar un método de pago',
    'error_cfdi_use_id' => 'Debes seleccionar un uso de CFDI',
    'error_cfdi_relation_id' => 'Debes seleccionar el tipo de relación',
    'error_item' => 'Debes ingresar por lo menos un producto/servicio válido',
    'error_line_name' => 'Debes ingresar una descripción',
    'error_line_unit_measure_id' => 'Debes seleccionar una unidad de medida',
    'error_line_sat_product_id' => 'Debes seleccionar un producto/servicio del SAT',
    'error_line_quantity' => 'La cantidad es incorrecta',
    'error_line_price_unit' => 'El precio es incorrecto',
    'error_reconciled_amount_reconciled' => 'El monto conciliado es incorrecto',
    'error_reconciled_amount_reconciled_customer_invoice_balance' => 'El monto supera el saldo de la factura',
    'error_relation_relation_id' => 'Debes seleccionar un CFDI',

    // ---Otros
    'error_change_status' => 'No se puede cambiar el estatus',
    'error_download_xml' => 'Error al descargar el archivo XML',
    'error_amount_total_amount_reconciled' => 'El monto conciliado supera el monto total',

];
