<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  use SoftDeletes;
  public $table = 'customers';
  protected $fillable = [
    'company_name',
    'buyer_name',
    'buyer_number',
    'email',
    'gst_no',
    'gst_file',
    'pancard_no',
    'pancard_file',
  ];

  public function StyleMaster()
  {
    return $this->hasMany(StyleMaster::class, 'customer_id', 'id');
  }

  public function CustomerBillAddress()
  {
    return $this->hasMany(CustomerBillAddress::class, 'customer_id', 'id');
  }

  public function CustomerShipAddress()
  {
    return $this->hasMany(CustomerShipAddress::class, 'customer_id', 'id');
  }


    use HasFactory;
}
