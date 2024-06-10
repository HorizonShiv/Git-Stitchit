<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'user_id',
    'account_no',
    'bank_name',
    'account_name',
    'ifsc',
    'cancel_cheque',
  ];

  protected $dates = ['deleted_at'];

  public function User()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

}
