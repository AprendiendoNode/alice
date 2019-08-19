<?php

namespace App\Models\Sales;
use App\Models\Catalogs\Bank;
use App\Models\Catalogs\Currency;
use Illuminate\Database\Eloquent\Model;

class CustomerBankAccount extends Model
{
    protected $table = 'customer_bank_accounts';

    protected $fillable = [
      'customer_id',
      'name',
      'account_number',
      'bank_id',
      'currency_id',
      'sort_order',
      'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
