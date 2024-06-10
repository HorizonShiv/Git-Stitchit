<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaningOrders extends Model
{
  use SoftDeletes;

   protected $fillable = [
    'date',
    'sale_order_id',
    'sales_order_style_id',
    'planing_order_no',
    'status',
    'qty',
  ];

  use HasFactory;

  public function PlaningOrderProcesses()
  {
    return $this->hasMany(PlaningOrderProcesses::class, 'planing_order_id', 'id');
  }

  public function PlaningOrderMaterials()
  {
    return $this->hasMany(PlaningOrderMaterials::class, 'planing_order_id', 'id');
  }

  public function SalesOrderStyleInfo()
  {
    return $this->hasMany(SalesOrderStyleInfo::class, 'id', 'sales_order_style_id');
  }

  public function SalesOrders()
  {
    return $this->belongsTo(SalesOrders::class, 'sale_order_id', 'id');
  }
public function JobOrders()
  {
    return $this->hasMany(JobOrders::class, 'planing_order_id', 'id');
  }

}
