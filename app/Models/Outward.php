<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outward extends Model
{
  use SoftDeletes;

  public $table = 'outwards';
  protected $fillable = [
    'type',
    'outward_from',
    'outward_to_department',
    'outward_to_service',
    'user_id',
  ];

  public function User()
  {
    return $this->belongsTo(User::class, 'outward_to_service', 'id');
  }

  public function UserInfo()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function Department()
  {
    return $this->belongsTo(Department::class, 'outward_to_department', 'id');
  }

  public function WareHouse()
  {
    return $this->belongsTo(Department::class, 'outward_from', 'id');
  }

  public function OutwardParameter()
  {
    return $this->hasMany(OutwardParameter::class, 'outward_id', 'id');
  }

  use HasFactory;
}
