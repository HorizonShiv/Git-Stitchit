<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Department extends Model
{
  use SoftDeletes;

  public $table = 'department_master';
  protected $fillable = [
    'name',
    'process_master_id',
  ];

  public function ProcessMaster()
  {
    return $this->belongsTo(ProcessMaster::class, 'process_master_id', 'id');
  }
  use HasFactory;
}
