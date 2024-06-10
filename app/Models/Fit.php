<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fit extends Model
{
  use SoftDeletes;

  public $table = 'fit_master';
  protected $fillable = [
    'name',
  ];

  public function StyleMaster()
  {
    return $this->hasMany(StyleMaster::class, 'fit_id', 'id');
  }

  use HasFactory;
}
