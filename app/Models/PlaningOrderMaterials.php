<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaningOrderMaterials extends Model
{

  use SoftDeletes;

  public $table = 'planing_order_materials';
  protected $fillable = [
    'planing_order_id',
    'sales_order_id',
    'sales_order_style_id',
    'item_id',
    'required_qty',
    'available_qty',
    'per_pc_qty',
    'order_qty',
    'rate',
    'total'
  ];
  public function Item()
  {
    return $this->belongsTo(Item::class, 'item_id', 'id');
  }

//  public function SalesOrderStyleInfo()
//  {
//    return $this->hasMany(SalesOrderStyleInfo::class, 'sales_order_style_id', 'id');
//  }
  use HasFactory;
}
