<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'user_id',
    'pre_fix',
    'po_no_set',
    'c_name',
    'check_document',
    'pancard_gst_file',
    'pancard_gst_no',
    'b_name',
    'b_address1',
    'b_address2',
    'b_city',
    'b_state',
    'b_mobile',
    'b_email',
    'b_pincode',
    's_name',
    's_address1',
    's_address2',
    's_city',
    's_state',
    's_mobile',
    's_email',
    's_pincode'
  ];

  protected $dates = ['deleted_at'];

  public function User()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function CompanyShipAddress()
  {
    return $this->hasMany(CompanyShipAddress::class, 'company_id', 'id');
  }
	public function Setting()
  {
    return $this->belongsTo(Setting::class, 'id', 'company_id');
  }

}
