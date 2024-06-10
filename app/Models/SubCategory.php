<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{

  use SoftDeletes;
  public $table = 'sub_category';
  protected $fillable = [
    'category_id',
    'name',
  ];

  public function CategoryMasters()
  {
    return $this->belongsTo(CategoryMasters::class, 'id', 'category_id');
  }

  use HasFactory;
}
