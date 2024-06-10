<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
  use SoftDeletes;

  public $table = 'item_category_master';
  protected $fillable = [
    'name',
  ];

  public function ItemSubCategory()
  {
    return $this->hasMany(ItemSubCategory::class, 'item_category_id', 'id');
  }

  public function Item()
  {
    return $this->hasMany(Item::class, 'item_category_id', 'id');
  }

  use HasFactory;
}
