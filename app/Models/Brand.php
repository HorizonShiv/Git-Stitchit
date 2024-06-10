<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
  use SoftDeletes;
  public $table = 'brand_master';
  protected $fillable = [
    'name',
    'buyer_id',
  ];


  use HasFactory;
}
