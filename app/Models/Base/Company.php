<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

use App\Helpers\Helper;
use App\Models\Catalogs\City;
use App\Models\Catalogs\country;
use App\Models\Catalogs\State;
use App\Models\Catalogs\TaxRegimen;

class Company extends Model
{
  protected $table = 'companies';

  const PATH_IMAGES = 'images/companies';
  const PATH_FILES = 'files/companies';

  protected $fillable = [
          'name',
          'image',
          'taxid',
          'tax_regimen_id',
          'email',
          'phone',
          'phone_mobile',
          'address_1',
          'address_2',
          'address_3',
          'address_4',
          'address_5',
          'address_6',
          'city_id',
          'state_id',
          'country_id',
          'postcode',
          'file_cer',
          'file_key',
          'password_key',
          'file_pfx',
          'certificate_number',
          'date_start',
          'date_end',
          'comment',
          'sort_order',
          'status'
      ];
      /**
       * @return string
       */
      public function pathImage(){
          return '/app-images/' . self::PATH_IMAGES . '/' . $this->image;
      }

      /**
       * @return string
       */
      public function pathFileCer(){
          $tmp = Helper::setDirectory(self::PATH_FILES). '/' . str_replace('.pem', '', $this->file_cer);
          return $tmp;
      }

      /**
       * @return string
       */
      public function pathFileCerPem(){
          $tmp = Helper::setDirectory(self::PATH_FILES). '/' . $this->file_cer;
          return $tmp;
      }

      /**
       * @return string
       */
      public function pathFileKey(){
          $tmp = Helper::setDirectory(self::PATH_FILES). '/' . str_replace('.pass.pem', '', $this->file_key);
          return $tmp;
      }

      /**
       * @return string
       */
      public function pathFileKeyPem(){
          $tmp = Helper::setDirectory(self::PATH_FILES). '/' . str_replace('.pass.pem', '.pem', $this->file_key);
          return $tmp;
      }

      /**
       * @return string
       */
      public function pathFileKeyPassPem(){
          $tmp = Helper::setDirectory(self::PATH_FILES). '/' . $this->file_key;
          return $tmp;
      }

      /**
       * @return string
       */
      public function pathFilePfx(){
          $tmp = Helper::setDirectory(self::PATH_FILES). '/' . $this->file_pfx;
          return $tmp;
      }

      //Relaciones eloquent
      public function taxRegimen()
      {
          return $this->belongsTo(TaxRegimen::class);
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
          return $this->belongsTo(country::class);
      }

      public function companyBankAccounts()
      {
          return $this->hasMany(CompanyBankAccount::class);
      }

      public function companyActiveBankAccounts()
      {
          return $this->hasMany(CompanyBankAccount::class)->where('status','=','1');
      }

}
