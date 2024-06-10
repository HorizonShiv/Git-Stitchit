<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Season extends Model
{
  use SoftDeletes;

  public $table = 'season';
  protected $fillable = [
    'name',
  ];

  public function StyleMaster()
  {
    return $this->hasMany(StyleMaster::class, 'season_id', 'id');
  }

  use HasFactory;
}
