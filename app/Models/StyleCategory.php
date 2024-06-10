<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StyleCategory extends Model
{
  use SoftDeletes;

  public $table = 'style_category_master';
  protected $fillable = [
    'name',
  ];

  public function StyleSubCategory()
  {
    return $this->hasMany(StyleSubCategory::class, 'style_category_id', 'id');
  }

  public function StyleMaster()
  {
    return $this->hasMany(StyleMaster::class, 'style_categories_id', 'id');
  }

  use HasFactory;
}
