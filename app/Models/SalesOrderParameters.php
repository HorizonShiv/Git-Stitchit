<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrderParameters extends Model
{

  use SoftDeletes;

  public $table = 'sales_order_parameters';
  protected $fillable = [
    'sales_order_id',
    'sales_order_style_id',
    'color',
    'size',
    'ratio',
    'planned_qty',
  ];

  public function SalesOrderStyleInfo()
  {
    return $this->hasMany(SalesOrderStyleInfo::class, 'sales_order_style_id', 'id');
  }
  use HasFactory;
}
