<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

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

}
