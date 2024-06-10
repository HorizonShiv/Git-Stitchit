<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class InventoryHistory extends Model
{
  use SoftDeletes;
  public $table = 'inventory_history';
  protected $fillable = [
    'inventory_id',
    'grnitem_id',
    'warehouse_master_id',
    'user_id',
    'item_id',
    'type',
    'qty',
    'rate',
    'inventoryName',
    'inventoryGood',
    'inventoryAllotted',
    'inventoryRequired',
    'description',
    'remark',
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

  public function User()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function WareHouse()
  {
    return $this->belongsTo(WareHouse::class, 'warehouse_master_id', 'id');
  }

  use HasFactory;
}
