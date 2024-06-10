<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'company_name',
    'password',
    'role',
    'vendor_type',
    'profile_photo_url',
    'person_mobile',
    'is_active',
    'direct_invoice',
    'email',
    'person_name',
    'pancard_no',
    'pancard_file',
    'invoice_export_date',
    'gst_no',
    'otp',
    'gst_file'
  ];
  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];
  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];


  public function UserAddressView()
  {
    return $this->belongsTo(UserAddress::class, 'id', 'user_id');
  }

  public function UserBank()
  {
    return $this->belongsTo(UserBank::class, 'id', 'user_id');
  }

  public function VendorCompany()
  {
    return $this->hasMany(VendorCompany::class, 'user_id', 'id');
  }

  public function UserAddress()
  {
    return $this->belongsTo(UserAddress::class, 'id', 'user_id');
  }
}
