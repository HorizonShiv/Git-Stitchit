<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StyleMasterProcesses extends Model
{

  use SoftDeletes;

  public $table = 'style_master_processes';
  protected $fillable = [
    'style_master_id',
    'process_master_id',
    'sr_no',
    'duration',
    'value',
    'rate',
    'qty'
  ];

  public function StyleMaster()
  {
    return $this->belongsTo(StyleMaster::class, 'style_master_id', 'id');
  }

  public function ProcessMaster()
  {
    return $this->belongsTo(ProcessMaster::class, 'process_master_id', 'id');
  }
  use HasFactory;
}
