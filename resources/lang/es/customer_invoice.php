<?php

return [

    // Titulo
    'document_title' => 'Facturas',

    // Textos generales
    'text_status_open' => 'Por cobrar',
    'text_status_paid' => 'Pagada',
    'text_status_cancel' => 'Cancelada',
    'text_status_cancel_per_authorized' => 'Por Cancelar',
    'text_mark_open' => 'Marcar como abierta',
    'text_mark_sent' => 'Marcar como enviada',
    'text_mark_paid' => 'Marcar como pagada',
    'text_cancel_authorized' => 'Cancelación autorizada',
    'text_cancel_rejected' => 'Cancelación rechazada',
    'text_payment_history' => 'Historial de pagos',
    'text_mail_text_00' => '<strong>Notificación</strong>',
    'text_mail_text_0' => 'Hola <strong>%s</strong>',
    'text_mail_text_1' => 'Le remitimos adjunta la siguiente factura:',
    'text_mail_text_2' => 'Folio: <b>%s</b><br/>Fecha: %s<br/>Total: %s %s<br/>Referencia: %s',
    'text_mail_text_3' => 'Si tiene alguna pregunta no dude en contactarnos.',
    'text_mail_text_4' => '<br><strong>%s</strong>',
    'text_mail_text_5' => '<br>Tel.: %s',
    'text_mail_text_6' => '<br>Correo electrónico: %s',
    'text_mail_text_7' => '<br><span style="">Sitio Web  <a href="%s" target="_blank" >%s</a></span>',
    'text_mail_text_8' => 'Este mensaje ha sido enviado desde una dirección de correo electrónico exclusivamente de notificación, que no admite mensajes. Por favor, no responda al mismo.',
    'text_modal_send_mail' => 'Enviar',
    'text_modal_cancel' => 'Cancelar %s',
    'text_modal_status_sat' => 'Estatus SAT - %s',
    'text_modal_cancel_help1' => '¿Esta seguro de cancelar la <strong>%s</strong>?',
    'text_modal_cancel_help1_1' => 'La <strong>%s</strong> no puede ser cancelada',
    'text_modal_cancel_help2' => 'Esta acción no se podrá deshacer una vez confirmada la cancelación',
    'text_modal_payment_history' => 'Historial de pagos',
    'text_modal_status_sat_help1' => '¿Que estatus tiene el CFDI en el SAT?',

    // Textos alertas
    'text_success_send_mail' => 'La factura <strong>%s</strong> se ha enviado con éxito',

    // Textos ayuda

    // Textos tabs
    'tab_products' => 'Productos/Servicios',
    'tab_relations' => 'CFDI\'s relacionados',
    'tab_payments' => 'Pagos',

    // Textos formulario
    'entry_name' => 'Folio',
    'entry_customer_id' => 'Cliente',
    'entry_branch_office_id' => 'Sucursal',
    'entry_date' => 'Fecha',
    'entry_date_due' => 'Fecha de vencimiento',
    'entry_salesperson_id' => 'Vendedor',
    'entry_currency_id' => 'Moneda',
    'entry_currency_value' => 'TC',
    'entry_payment_term_id' => 'Términos de pago',
    'entry_payment_way_id' => 'Forma de pago',
    'entry_payment_method_id' => 'Método de pago',
    'entry_cfdi_use_id' => 'Uso de CFDI',
    'entry_cfdi_relation_id' => 'Tipo de relación',
    'entry_reference' => 'Referencia',
    'entry_amount_total' => 'Total',
    'entry_balance' => 'Saldo',
    'entry_reconciled' => 'Conciliado',
    'entry_comment' => 'Comentarios',
    'entry_sort_order' => 'Orden',
    'entry_status' => 'Estatus',
    'column_relation_relation_id' => 'CFDI',
    'column_relation_uuid' => 'UUID',

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
    'column_date_due' => 'Fecha Vencimiento',
    'column_currency' => 'Moneda',
    'column_amount_total' => 'Total',
    'column_balance' => 'Saldo',
    'column_mail_sent' => 'Enviada',
    'column_sort_order' => 'Orden',
    'column_status' => 'Estatus',
    'column_payment_method' => 'Método de pago',

    // Columnas sub-listado
    'column_line_product_id' => 'Producto',
    'column_line_name' => 'Descripción',
    'column_line_unit_measure_id' => 'U. M.',
    'column_line_sat_product_id' => 'Prod/Serv SAT',
    'column_line_quantity' => 'Cantidad',
    'column_line_price_unit' => 'Precio',
    'column_line_discount' => 'Desc. %',
    'column_line_taxes' => 'Impuestos',
    'column_line_amount_untaxed' => 'Total',

    // Textos error
    // ---General

    // ---Formulario
    'error_name' => 'Debes ingresar un nombre',
    'error_customer_id' => 'Debes seleccionar un cliente',
    'error_branch_office_id' => 'Debes seleccionar una sucursal',
    'error_date' => 'Debes ingresar una fecha',
    'error_date_format' => 'El formato de la fecha es incorrecto',
    'error_date_due_format' => 'El formato de la fecha es incorrecto',
    'error_date_due_after' => 'La fecha de vencimiento no puede ser menor a la fecha',
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
    'error_line_discount' => 'El descuento es incorrecto',
    'error_relation_relation_id' => 'Debes seleccionar un CFDI',

    // ---Otros
    'error_change_status' => 'No se puede cambiar el estatus',
    'error_download_xml' => 'Error al descargar el archivo XML',
    'error_read_xml' => 'Error al leer el archivo XML',

    'document_title_simple' => 'Factura'
];
