<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseTransfer extends Model
{
  use SoftDeletes;
  public $table = 'warehouse_transfer';
  protected $fillable = [
    'date',
    'transfer_from',
    'transfer_to',
    'remark',
    'user_id',
  ];

  public function WareHouseFrom()
  {
    return $this->belongsTo(Department::class, 'transfer_from', 'id');
  }
  public function WareHouseTO()
  {
    return $this->belongsTo(Department::class, 'transfer_to', 'id');
  }

  public function User()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }
  public function WarehouseTransferParameter()
  {
    return $this->hasMany(WarehouseTransferParameter::class, 'warehouse_transfer_id', 'id');
  }

  use HasFactory;
}
