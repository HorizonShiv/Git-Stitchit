<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CustomerShipAddress extends Model
{
  use SoftDeletes;
  public $table = 'customer_ship_address';
  protected $fillable = [
    'customer_id',
    'name',
    'email',
    'mobile',
    's_address1',
    's_address2',
    's_city',
    's_state',
    's_pincode',
    'gst_number',
    'shipping_count',
  ];

  public function Customer()
  {
    return $this->belongsTo(Customer::class, 'customer_id', 'id');
  }
  use HasFactory;
}
