<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IssueMaterials extends Model
{

  use SoftDeletes;

  public $table = 'issue_materials';
  protected $fillable = [
    'job_order_id',
    'issue_manage_history_id',
    'department_id',
    'item_id',
    'available_qty',
    'total',
    'order_qty',
    'rate'
  ];

  public function Department()
  {
    return $this->belongsTo(Department::class, 'department_id', 'id');
  }
    public function IssueManageHistory()
  {
    return $this->belongsTo(IssueManageHistory::class, 'issue_manage_history_id', 'id');
  }

  public function JobOrders()
  {
    return $this->belongsTo(JobOrders::class, 'job_order_id', 'id');
  }
  public function Item()
  {
    return $this->belongsTo(Item::class, 'item_id', 'id');
  }

  use HasFactory;
}
