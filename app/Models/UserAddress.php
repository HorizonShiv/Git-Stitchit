<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'user_id',
    'b_address1',
    'b_address2',
    'b_city',
    'b_state',
    'b_mobile',
    'b_pincode',
    's_firstname',
    's_lastname',
    's_address1',
    's_address2',
    's_city',
    's_state',
    's_mobile',
    's_pincode'
  ];

  protected $dates = ['deleted_at'];

  public function User()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

}
