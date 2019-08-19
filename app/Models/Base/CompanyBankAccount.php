<?php

namespace App\Models\Base;
use App\Models\Base\Company;
use App\Models\Catalogs\Bank;
use App\Models\Catalogs\Currency;
use Illuminate\Database\Eloquent\Model;

class CompanyBankAccount extends Model
{
  protected $table = 'company_bank_accounts';

  protected $fillable = [
      'company_id',
      'name',
      'account_number',
      'bank_id',
      'currency_id',
      'sort_order',
      'status'
  ];

  public function company()
  {
      return $this->belongsTo(Company::class);
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
