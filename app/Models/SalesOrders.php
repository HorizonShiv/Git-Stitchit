<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrders extends Model
{
  use SoftDeletes;

  public $table = 'sales_order';
  protected $fillable = [
    'date',
    'customer_id',
    'brand_id',
    'season_id',
	'sales_order_no',
  ];

  public function SalesOrderStyleInfo()
  {
    return $this->hasMany(SalesOrderStyleInfo::class, 'sales_order_id', 'id');
  }

  public function SalesOrderParameters()
  {
    return $this->hasMany(SalesOrderParameters::class, 'sales_order_id', 'id');
  }

  public function Customer()
  {
    return $this->hasMany(Customer::class, 'id', 'customer_id');
  }

  public function Brand()
  {
    return $this->hasMany(Brand::class, 'id', 'brand_id');
  }

  public function Season()
  {
    return $this->hasMany(Season::class, 'id', 'season_id');
  }


  use HasFactory;
}
