<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseTransferParameter extends Model
{
  use SoftDeletes;
  public $table = 'warehouse_transfer_parameter';
  protected $fillable = [
    'warehouse_transfer_id',
    'item_id',
    'qty',
    'rate',
    'user_id',
  ];

  public function WarehouseTransfer()
  {
    return $this->belongsTo(WarehouseTransfer::class, 'warehouse_transfer_id', 'id');
  }
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
