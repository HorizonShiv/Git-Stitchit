<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobOrderParameters extends Model
{
  use SoftDeletes;
  public $table = 'job_order_parameters';
  protected $fillable = [
    'job_order_id',
    'sales_order_style_id',
    'color',
    'qty',
    'size',
  ];
	 public function JobOrders()
  {
    return $this->hasMany(JobOrders::class, 'id', 'job_order_id');
  }

  use HasFactory;
}
