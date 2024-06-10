<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyShipAddress extends Model
{
  use SoftDeletes;
  public $table = 'company_ship_address';
  protected $fillable = [
    'company_id',
    'name',
	'company_name',
    'email',
    'mobile',
    'address1',
    'address2',
    'city',
    'state',
    'pincode',
    'gst_number',
    'shipping_count',
  ];

  public function Company()
  {
    return $this->belongsTo(Company::class, 'company_id', 'id');
  }
  use HasFactory;
}
