<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garment extends Model
{
  use SoftDeletes;

  public $table = 'garment_master';
  protected $fillable = [
    'name',
  ];

  use HasFactory;
}
