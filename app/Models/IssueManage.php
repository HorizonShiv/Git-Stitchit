<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueManage extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'job_order_id', 'department_id', 'issueQty','rQty', 'receiveQty', 'user_id'
  ];

  public function JobOrders()
  {
    return $this->belongsTo(JobOrders::class, 'job_order_id', 'id');
  }

  public function User()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function Department()
  {
    return $this->belongsTo(Department::class, 'department_id', 'id');
  }

  public function IssueManageHistory()
  {
    return $this->hasMany(IssueManageHistory::class, 'issue_id', 'id');
  }

  protected $primaryKey = 'id';

}
