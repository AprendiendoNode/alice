<?php

namespace App\Helpers;

use App\Models\Base\Company;
use App\Models\Base\DocumentType;
use App\Models\Base\Pac;
use App\Models\Sales\CustomerInvoice;
use App\Models\Sales\CustomerInvoice as CustomerCreditNote;
use App\Models\Sales\CustomerInvoice as CustomerTransfer;
use App\Models\Sales\CustomerInvoice as CustomerLease;
use App\Models\Sales\CustomerInvoice as CustomerFee;
use App\Models\Sales\CustomerPayment;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use NumberToWords\NumberToWords;
use SoapClient;
use ZipArchive;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

use App\Models\Purchases\Purchase;

class SalesHelper
{

    /**
     * Estatus de factura en html
     *
     * @param $status
     * @return string
     */
    public static function statusCustomerInvoiceHtml($status)
    {
        $html = '';
        if ((int)$status == CustomerInvoice::OPEN) {
            $html = '<label class="label label-info">' . __('customer_invoice.text_status_open') . '</label>';
        } elseif ((int)$status == CustomerInvoice::PAID) {
            $html = '<label class="label label-primary">' . __('customer_invoice.text_status_paid') . '</label>';
        } elseif ((int)$status == CustomerInvoice::CANCEL) {
            $html = '<label class="label label-default">' . __('customer_invoice.text_status_cancel') . '</label>';
        } elseif ((int)$status == CustomerInvoice::CANCEL_PER_AUTHORIZED) {
            $html = '<label class="label label-dark">' . __('customer_invoice.text_status_cancel_per_authorized') . '</label>';
        } elseif ((int)$status == CustomerInvoice::RECONCILED) {
            $html = '<label class="label label-success">' . __('customer_credit_note.text_status_reconciled') . '</label>';
        } else {

        }

        return $html;
    }

    /**
     * Estatus de factura en html
     *
     * @param $status
     * @return string
     */
    public static function statusCustomerCreditNoteHtml($status)
    {
        $html = '';
        if ((int)$status == CustomerCreditNote::OPEN) {
            $html = '<label class="label label-success">' . __('customer_credit_note.text_status_open') . '</label>';
        } elseif ((int)$status == CustomerCreditNote::PAID) {
            $html = '<label class="label label-info">' . __('customer_credit_note.text_status_paid') . '</label>';
        } elseif ((int)$status == CustomerCreditNote::CANCEL) {
            $html = '<label class="label label-default">' . __('customer_credit_note.text_status_cancel') . '</label>';
        } elseif ((int)$status == CustomerCreditNote::RECONCILED) {
            $html = '<label class="label label-info">' . __('customer_credit_note.text_status_reconciled') . '</label>';
        } else {

        }

        return $html;
    }
    /**
     * Estatus de nota de credito compras en html
     *
     * @param $status
     * @return string
     */
    public static function statusCustomerCreditNoteComprasHtml($status)
    {
        $html = '';
        if ((int)$status == Purchase::ELABORADO) {
            $html = '<label class="label label-primary">' . __('purchase.text_status_elaborado') . '</label>';
        } elseif ((int)$status == Purchase::REVISADO) {
            $html = '<label class="label label-success">' . __('purchase.text_status_revisado') . '</label>';
        } elseif ((int)$status == Purchase::AUTORIZADO) {
            $html = '<label class="label label-warning">' . __('purchase.text_status_autorizado') . '</label>';
        } elseif ((int)$status == Purchase::CANCELADO) {
            $html = '<label class="label label-danger">' . __('purchase.text_status_cancelado') . '</label>';
        } elseif ((int)$status == Purchase::CONCILIADA) {
            $html = '<label class="label label-dark">' . __('purchase.text_status_conciliada') . '</label>';
        }
         else {

        }

        return $html;
    }
    /**
     * Estatus de pagos en html
     *
     * @param $status
     * @return string
     */
    public static function statusCustomerPaymentHtml($status)
    {
        $html = '';
        if ((int)$status == CustomerPayment::OPEN) {
            $html = '<label class="label label-success">' . __('customer_payment.text_status_open') . '</label>';
        } elseif ((int)$status == CustomerPayment::RECONCILED) {
            $html = '<label class="label label-info">' . __('customer_payment.text_status_reconciled') . '</label>';
        } elseif ((int)$status == CustomerPayment::CANCEL) {
            $html = '<label class="label label-default">' . __('customer_payment.text_status_cancel') . '</label>';
        } else {

        }

        return $html;
    }

    /**
     * Estatus de pagos en html
     *
     * @param $status
     * @return string
     */
    public static function statusCustomerTransferHtml($status)
    {
        $html = '';
        if ((int)$status == CustomerTransfer::OPEN) {
            $html = '<label class="label label-success">' . __('customer_transfer.text_status_open') . '</label>';
        } elseif ((int)$status == CustomerTransfer::CANCEL) {
            $html = '<label class="label label-default">' . __('customer_transfer.text_status_cancel') . '</label>';
        } else {

        }

        return $html;
    }

    /**
     * Estatus de recibos de arrendamiento en html
     *
     * @param $status
     * @return string
     */
    public static function statusCustomerLeaseHtml($status)
    {
        $html = '';
        if ((int)$status == CustomerLease::OPEN) {
            $html = '<label class="label label-info">' . __('customer_lease.text_status_open') . '</label>';
        } elseif ((int)$status == CustomerLease::PAID) {
            $html = '<label class="label label-primary">' . __('customer_lease.text_status_paid') . '</label>';
        } elseif ((int)$status == CustomerLease::CANCEL) {
            $html = '<label class="label label-default">' . __('customer_lease.text_status_cancel') . '</label>';
        } elseif ((int)$status == CustomerLease::CANCEL_PER_AUTHORIZED) {
            $html = '<label class="label label-dark">' . __('customer_lease.text_status_cancel_per_authorized') . '</label>';
        } elseif ((int)$status == CustomerLease::RECONCILED) {
            $html = '<label class="label label-success">' . __('customer_credit_note.text_status_reconciled') . '</label>';
        } else {

        }

        return $html;
    }

    /**
     * Estatus de recibos de honorarios en html
     *
     * @param $status
     * @return string
     */
    public static function statusCustomerFeeHtml($status)
    {
        $html = '';
        if ((int)$status == CustomerFee::OPEN) {
            $html = '<label class="label label-info">' . __('customer_fee.text_status_open') . '</label>';
        } elseif ((int)$status == CustomerFee::PAID) {
            $html = '<label class="label label-primary">' . __('customer_fee.text_status_paid') . '</label>';
        } elseif ((int)$status == CustomerFee::CANCEL) {
            $html = '<label class="label label-default">' . __('customer_fee.text_status_cancel') . '</label>';
        } elseif ((int)$status == CustomerFee::CANCEL_PER_AUTHORIZED) {
            $html = '<label class="label label-dark">' . __('customer_fee.text_status_cancel_per_authorized') . '</label>';
        } elseif ((int)$status == CustomerFee::RECONCILED) {
            $html = '<label class="label label-success">' . __('customer_credit_note.text_status_reconciled') . '</label>';
        } else {

        }

        return $html;
    }

}
