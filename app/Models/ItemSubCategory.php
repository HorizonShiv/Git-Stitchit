<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSubCategory extends Model
{
  use SoftDeletes;

  public $table = 'item_subcategory_master';
  protected $fillable = [
    'item_category_id',
    'name',
    'subcategory_counter',
  ];


  public function ItemCategory()
  {
    return $this->belongsTo(ItemCategory::class, 'item_category_id', 'id');
  }

  use HasFactory;
}
