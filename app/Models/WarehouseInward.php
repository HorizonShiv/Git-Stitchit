<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseInward extends Model
{
  use SoftDeletes;
  public $table = 'warehouse_inwards';
  protected $fillable = [
    'date',
    'warehouse_transfer_id',
    'warehouse_id',
    'remark',
    'user_id',
  ];

  public function WareHouseFrom()
  {
    return $this->belongsTo(Department::class, 'warehouse_transfer_id', 'id');
  }
  public function WareHouseTO()
  {
    return $this->belongsTo(Department::class, 'warehouse_id', 'id');
  }

  public function User()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function WarehouseInwardParameter()
  {
    return $this->hasMany(WarehouseInwardParameter::class, 'warehouse_inward_id', 'id');
  }

  use HasFactory;
}
