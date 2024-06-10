<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demographic extends Model
{
  use SoftDeletes;

  public $table = 'demographic_master';
  protected $fillable = [
    'name',
  ];

  use HasFactory;
}
