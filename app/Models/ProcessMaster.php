<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessMaster extends Model
{
  use SoftDeletes;

  public $table = 'process_master';
  protected $fillable = [
    'name',"type"
  ];

  public function Department()
  {
    return $this->hasMany(Department::class, 'process_master_id', 'id');
  }

  use HasFactory;
}
