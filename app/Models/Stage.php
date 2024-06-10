<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
  use SoftDeletes;
  public $table = 'stage_master';
  protected $fillable = [
    'stage_name',
  ];

  use HasFactory;
}
