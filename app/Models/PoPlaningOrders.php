<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoPlaningOrders extends Model
{
  public $table = 'po_planing_orders';
  use SoftDeletes;
  protected $fillable = [
    'item_id','order_planing_id','qty'
  ];


  use HasFactory;

  public function Item()
  {
    return $this->belongsTo(Item::class, 'item_id', 'id');
  }


  public function PlaningOrders()
  {
    return $this->belongsTo(PlaningOrders::class, 'order_planing_id', 'id');
  }
}
