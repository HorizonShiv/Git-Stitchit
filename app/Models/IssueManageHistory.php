<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueManageHistory extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'issue_id', 'remark', 'qty', 'issueTo', 'issueFrom', 'userTo', 'userFrom','va_cost','issue_type'
  ];

  public function IssueManage()
  {
    return $this->belongsTo(IssueManage::class, 'issue_id', 'id');
  }

  public function issueFromDeparment()
  {
    return $this->belongsTo(Department::class, 'issueFrom', 'id');
  }


  public function issueToDepartment()
  {
    return $this->belongsTo(Department::class, 'issueTo', 'id');
  }

  public function userToData()
  {
    return $this->belongsTo(User::class, 'userTo', 'id');
  }

  public function userFromData()
  {
    return $this->belongsTo(User::class, 'userFrom', 'id');
  }

  public function IssueParameters()
  {
    return $this->hasMany(IssueParameters::class, 'issue_manage_history_id', 'id');
  }

  public function IssueMaterials()
  {
    return $this->hasMany(IssueMaterials::class, 'issue_manage_history_id', 'id');
  }

  protected $primaryKey = 'id';

}
