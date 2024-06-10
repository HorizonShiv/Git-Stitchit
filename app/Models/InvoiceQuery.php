<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class InvoiceQuery extends Model
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'invoice_id',
    'user_id',
    'admin_id',
    'message_by',
    'description'
  ];

  protected $dates = ['deleted_at'];

  public function Invoice()
  {
    return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
  }

  public function User()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function Admin()
  {
    return $this->belongsTo(User::class, 'admin_id', 'id');
  }

}
