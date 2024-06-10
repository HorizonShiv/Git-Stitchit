<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrderStyleInfo extends Model
{
  use SoftDeletes;

  public $table = 'sales_order_styleInfo';
  protected $fillable = [
    'sales_order_id',
    'style_master_id',
    'customer_style_no',
    'price',
    'total_qty',
    'style_image',
    'ship_date',
    'order_planing_status',
    'details',
  ];

  public function SalesOrders()
  {
    return $this->hasMany(SalesOrders::class, 'sales_order_id', 'id');
  }

  public function SalesOrderParameters()
  {
    return $this->hasMany(SalesOrderParameters::class, 'sales_order_style_id', 'id');
  }


  public function StyleMaster()
  {
    return $this->belongsTo(StyleMaster::class, 'style_master_id', 'id');
  }
  use HasFactory;
}
