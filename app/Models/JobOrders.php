<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobOrders extends Model
{
  use SoftDeletes;
  protected $fillable = [
    'date',
    'job_order_no',
    'status',
    'sale_order_id',
    'planing_order_id',
    'sales_order_style_id',
    'cad',
    'cad_desc',
    'cutting',
    'cutting_desc',
    'stitching',
    'stitching_desc',
    'washing',
    'note',
    'qty',
    'rate',
    'type',
    'washing_desc',
  ];

  use HasFactory;


  public function JobOrderParameters()
  {
    return $this->hasMany(JobOrderParameters::class, 'job_order_id', 'id');
  }

  public function IssueManage()
  {
    return $this->hasMany(IssueManage::class, 'job_order_id', 'id');
  }

  public function PlaningOrders()
  {
    return $this->belongsTo(PlaningOrders::class, 'planing_order_id', 'id');
  }

  public function SalesOrderStyleInfo()
  {
    return $this->belongsTo(SalesOrderStyleInfo::class, 'sales_order_style_id', 'id');
  }

	 public function StyleMaster()
  {
    return $this->belongsTo(StyleMaster::class, 'sales_order_style_id', 'id');
  }

  public function SalesOrders()
  {
    return $this->belongsTo(SalesOrders::class, 'sale_order_id', 'id');
  }

}
