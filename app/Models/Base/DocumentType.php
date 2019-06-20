<?php

namespace App\Models\Base;
use App\Models\Catalogs\CfdiType;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
  protected $table = 'document_types';

  const NO_NATURE = 1;
  const DEBIT = 2;
  const CREDIT = 3;

  protected $fillable = [
        'name',
        'code',
        'prefix',
        'current_number',
        'increment_number',
        'nature',
        'cfdi_type_id',
        'sort_order',
        'status'
    ];
  public function cfdiType()
  {
      return $this->belongsTo(CfdiType::class);
  }
}
