<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StyleSubCategory extends Model
{
  use SoftDeletes;

  public $table = 'style_subcategory_master';
  protected $fillable = [
    'style_category_id',
    'name',
    'subcategory_counter',
  ];


  public function StyleCategory()
  {
    return $this->belongsTo(StyleCategory::class, 'style_category_id', 'id');
  }

  public function StyleMaster()
  {
    return $this->hasMany(StyleMaster::class, 'style_subcategories_id', 'id');
  }

  use HasFactory;
}
