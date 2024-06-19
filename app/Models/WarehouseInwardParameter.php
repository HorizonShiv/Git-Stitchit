<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseInwardParameter extends Model
{
  use SoftDeletes;
  public $table = 'warehouse_inward_parameter';
  protected $fillable = [
    'warehouse_inward_id',
    'item_id',
    'transfered_qty',
    'rate',
    'inward_qty',
    'user_id',
  ];

  public function Item()
  {
    return $this->belongsTo(Item::class, 'item_id', 'id');
  }

  public function User()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }


  use HasFactory;
}
