<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class BuyerBank extends Model
{
  use SoftDeletes;
  public $table = 'buyer_banks';
  protected $fillable = [
    'buyer_id',
    'account_no',
    'account_name',
    'bank_name',
    'ifsc',
    'cancel_cheque',
  ];
  use HasFactory;
}
