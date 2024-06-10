<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBillAddress extends Model
{
  use SoftDeletes;
  public $table = 'customer_bill_address';
  protected $fillable = [
    'customer_id',
    'b_address1',
    'b_address2',
    'b_city',
    'b_state',
    'b_pincode',
  ];
  public function Customer()
  {
    return $this->belongsTo(Customer::class, 'customer_id', 'id');
  }
  use HasFactory;
}
