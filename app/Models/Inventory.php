<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
  use SoftDeletes;

  public $table = 'inventory';
  protected $fillable = [
    'warehouse_master_id',
    'item_id',
    'total',
    'good_inventory',
    'bad_inventory',
    'allotted_inventory',
    'required_inventory',
    'last_instock_date',
    'avg_rate',
    'created_date',
    'updated_date',
    'updated_at',
    'deleted_at',
    'created_at',
  ];

  public function Item()
  {
    return $this->belongsTo(Item::class, 'item_id', 'id');
  }

  public function WareHouse()
  {
    return $this->belongsTo(WareHouse::class, 'warehouse_master_id', 'id');
  }

  use HasFactory;
}
