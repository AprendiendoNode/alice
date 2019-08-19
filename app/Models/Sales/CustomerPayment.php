<?php

namespace App\Models\Sales;
use App\Helpers\Helper;
use App\Models\Base\BranchOffice;
use App\Models\Base\CompanyBankAccount;
use App\Models\Base\DocumentType;
use App\Models\Catalogs\CfdiRelation;
use App\Models\Catalogs\Currency;
use App\Models\Catalogs\PaymentWay;
use Illuminate\Database\Eloquent\Model;

use App\Models\Sales\Customer;
use App\Models\Sales\CustomerBankAccount;

use App\Models\Sales\CustomerPaymentReconciled;
use App\Models\Sales\CustomerPaymentRelation;
use App\Models\Sales\CustomerPaymentCfdi;
class CustomerPayment extends Model
{
    protected $table = 'customer_payments';

    const PATH_XML_FILES = 'files/customer_payments/xml';

    //Por timbrar
    const OPEN = 2; //Abierto
    const RECONCILED = 3; //Conciliado
    const CANCEL = 4; //Cancelada
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'serie',
        'folio',
        'date',
        'date_payment',
        'reference',
        'company_bank_account_id',
        'customer_id',
        'customer_bank_account_id',
        'branch_office_id',
        'payment_way_id',
        'currency_id',
        'currency_value',
        'amount',
        'balance',
        'document_type_id',
        'cfdi_relation_id',
        'cfdi',
        'comment',
        'mail_sent',
        'sort_order',
        'status',
        'confirmacion',
        'tipo_cadena_pago',
        'certificado_pago',
        'cadena_pago',
        'sello_pago',
    ];
    public function companyBankAccount()
    {
        return $this->belongsTo(CompanyBankAccount::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerBankAccount()
    {
        return $this->belongsTo(CustomerBankAccount::class);
    }

    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class);
    }

    public function paymentWay()
    {
        return $this->belongsTo(PaymentWay::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function cfdiRelation()
    {
        return $this->belongsTo(CfdiRelation::class);
    }
    public function customerPaymentReconcileds()
    {
        return $this->hasMany(CustomerPaymentReconciled::class);
    }

    public function customerPaymentRelations()
    {
        return $this->hasMany(CustomerPaymentRelation::class);
    }

    public function customerPaymentCfdi()
    {
        return $this->hasOne(CustomerPaymentCfdi::class);
    }

}
