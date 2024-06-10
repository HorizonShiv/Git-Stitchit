<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrToSupplierParameter extends Model
{
  use SoftDeletes;

  public $table = 'gr_to_supplier_parameters';
  protected $fillable = [
    'gr_to_supplier_id',
    'item_id',
    'received_qty',
    'return_qty',
    'user_id',
  ];

  public function User()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function GrToSupplier()
  {
    return $this->belongsTo(GrToSupplier::class, 'gr_to_supplier_id', 'id');
  }

  public function Item()
  {
    return $this->belongsTo(Item::class, 'item_id', 'id');
  }
  use HasFactory;
}
