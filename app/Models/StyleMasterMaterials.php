<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StyleMasterMaterials extends Model
{

  use SoftDeletes;

  public $table = 'style_master_materials';
  protected $fillable = [
    'style_master_id',
    'item_id',
    'available_qty',
    'rate'
  ];

  public function StyleMaster()
  {
    return $this->belongsTo(StyleMaster::class, 'style_master_id', 'id');
  }
  public function Item()
  {
    return $this->belongsTo(Item::class, 'item_id', 'id');
  }

  use HasFactory;
}
