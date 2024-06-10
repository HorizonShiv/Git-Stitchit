<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrToSupplier extends Model
{
  use SoftDeletes;

  public $table = 'gr_to_suppliers';
  protected $fillable = [
    'grn_no',
    'warehouse_id',
    'supplier_id',
    'remark',
    'user_id',
  ];
  public function User()
  {
    return $this->belongsTo(User::class, 'supplier_id', 'id');
  }
  public function WareHouse()
  {
    return $this->belongsTo(Department::class, 'warehouse_id', 'id');
  }
  public function UserInfo()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }
  public function GrToSupplierParameter()
  {
    return $this->hasMany(GrToSupplierParameter::class, 'gr_to_supplier_id', 'id');
  }
  use HasFactory;
}
