<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerAddress extends Model
{
  use SoftDeletes;
  public $table = 'buyer_addresses';
  protected $fillable = [
    'buyer_id',
    'b_address1',
    'b_address2',
    'b_city',
    'b_state',
    'b_pincode',
  ];
  use HasFactory;
}
