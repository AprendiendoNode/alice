<?php

namespace App\Models\Sales;

use App\Models\Catalogs\PaymentTerm;
use App\Models\Catalogs\PaymentWay;
use App\Models\Catalogs\PaymentMethod;
use App\Models\Catalogs\CfdiUse;
use App\Models\Catalogs\Salesperson;
use App\Models\Catalogs\City;
use App\Models\Catalogs\State;
use App\Models\Catalogs\Country;
use App\Models\Catalogs\CustomerBankAccount;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $table = 'customers';

  protected $fillable = [
        'name',
        'taxid',
        'numid',
        'email',
        'payment_term_id',
        'payment_way_id',
        'payment_method_id',
        'cfdi_use_id',
        'salesperson_id',
        'address_1',
        'city_id',
        'state_id',
        'country_id',
        'postcode',
        'sort_order',
        'status'
  ];

  public function paymentTerm()
  {
      return $this->belongsTo(PaymentTerm::class);
  }

  public function paymentWay()
  {
      return $this->belongsTo(PaymentWay::class);
  }

  public function paymentMethod()
  {
      return $this->belongsTo(PaymentMethod::class);
  }

  public function cfdiUse()
  {
      return $this->belongsTo(CfdiUse::class);
  }

  public function salesperson()
  {
      return $this->belongsTo(Salesperson::class);
  }

  public function city()
  {
      return $this->belongsTo(City::class);
  }

  public function state()
  {
      return $this->belongsTo(State::class);
  }

  public function country()
  {
      return $this->belongsTo(Country::class);
  }

  public function customerBankAccounts()
  {
      return $this->hasMany(CustomerBankAccount::class);
  }

  public function customerActiveBankAccounts()
  {
      return $this->hasMany(CustomerBankAccount::class)->where('status','=','1');
  }
}
