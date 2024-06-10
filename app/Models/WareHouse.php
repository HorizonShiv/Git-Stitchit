<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WareHouse extends Model
{
  use SoftDeletes;
  public $table = 'Warehouse_master';
  protected $fillable = [
    'name',
    'contact_person_name',
    'contact_person_number',
    'address1',
    'address2',
    'city',
    'state',
    'pincode',
  ];

  // public function CategoryMasters()
  // {
  //   return $this->belongsTo(CategoryMasters::class, 'id', 'category_id');
  // }

  use HasFactory;
}
