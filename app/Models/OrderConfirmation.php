<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderConfirmation extends Model
{
  use SoftDeletes;
  public $table = 'order_confirmation';
  use HasFactory;
}
