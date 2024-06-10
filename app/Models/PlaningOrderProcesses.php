<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaningOrderProcesses extends Model
{

  use SoftDeletes;

  public $table = 'planing_order_processes';
  protected $fillable = [
    'planing_order_id',
    'sales_order_id',
    'sales_order_style_id',
    'process_master_id',
    'sr_no',
    'duration',
    'value',
    'rate',
    'qty'
  ];

  public function ProcessMaster()
  {
    return $this->belongsTo(ProcessMaster::class, 'process_master_id', 'id');
  }

//  public function SalesOrderStyleInfo()
//  {
//    return $this->hasMany(SalesOrderStyleInfo::class, 'sales_order_style_id', 'id');
//  }
  use HasFactory;
}
