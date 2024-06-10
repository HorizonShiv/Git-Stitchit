<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
  use SoftDeletes;

  public $table = 'item_master';
  protected $fillable = [
    'name',
    'item_category_id',
    'item_subcategory_id',
    'stage_id',
    'rate',
    'avg_cost',
    'gst_rate',
    'photo',
    'uom',
    'short_code',
    'item_description',
    'consume_status',
  ];


  public function ItemCategory()
  {
    return $this->belongsTo(ItemCategory::class, 'item_category_id', 'id');
  }

  public function ItemSubCategory()
  {
    return $this->belongsTo(ItemSubCategory::class, 'item_subcategory_id', 'id');
  }

  public function ParameterConnection()
  {
    return $this->hasMany(ParameterConnection::class, 'item_master_id', 'id');
  }
  public function Inventory()
  {
    return $this->belongsTo(Inventory::class, 'id', 'item_id');
  }

  use HasFactory;
}
