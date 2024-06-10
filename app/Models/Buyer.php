<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
  use SoftDeletes;
  public $table = 'buyers';
  protected $fillable = [
    'company_name',
    'buyer_name',
    'number',
    'email',
    'gst_no',
    'gst_file',
    'pancard_no',
    'pancard_file',
  ];

  use HasFactory;
}
