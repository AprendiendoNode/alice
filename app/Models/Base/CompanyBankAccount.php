<?php

namespace App\Models\Base;

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
}
