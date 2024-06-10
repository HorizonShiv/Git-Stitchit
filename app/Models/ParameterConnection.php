<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterConnection extends Model
{
  use SoftDeletes;

  public $table = 'parameter_connection';
  protected $fillable = [
    'item_master_id',
    'parameter_master_id',
    'parameter_master_name',
  ];

  public function Item()
  {
    return $this->belongsTo(Item::class, 'item_master_id', 'id');
  }

  use HasFactory;
}
