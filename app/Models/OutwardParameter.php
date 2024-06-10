<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutwardParameter extends Model
{
  use SoftDeletes;

  public $table = 'outward_parameters';
  protected $fillable = [
    'outward_id',
    'job_order_id',
    'item_id',
    'required_qty',
    'already_issued_qty',
    'remaining_to_issue',
    'user_id',
  ];

  public function Outward()
  {
    return $this->belongsTo(Outward::class, 'outward_id', 'id');
  }

  public function Item()
  {
    return $this->belongsTo(Item::class, 'item_id', 'id');
  }

  public function User()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }
  use HasFactory;
}
