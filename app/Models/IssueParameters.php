<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IssueParameters extends Model
{
  use SoftDeletes;

  public $table = 'issue_parameters';
  protected $fillable = [
    'job_order_id',
    'department_id',
    'issue_manage_history_id',
    'color',
    'qty',
    'qty_type',
    'size',
  ];

  public function Department()
  {
    return $this->belongsTo(Department::class, 'deparment_id', 'id');
  }

  public function IssueManageHistory()
  {
    return $this->belongsTo(IssueManageHistory::class, 'issue_manage_history_id', 'id');
  }

  public function JobOrders()
  {
    return $this->belongsTo(JobOrders::class, 'job_order_id', 'id');
  }

  use HasFactory;
}
