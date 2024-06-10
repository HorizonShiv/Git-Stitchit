<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Po extends Model
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  public $table = 'purchase_orders';
  protected $fillable = [
    'user_id',
    'company_id',
    'company_shipping_id',
	'vendor_shiping_id',
    'denimax_po_id',
    'is_approve',
    'po_no',
    'po_date',
    'd_date',
    'po_amount',
    'sub_total_amount',
    'discount_amount',
    'tax_amount',
    'igst_amount',
    'cgst_amount',
    'sgst_amount',
    't_charge',
    't_tax',
    't_amount',
    'po_file',
    'note'
  ];

  protected $dates = ['deleted_at'];

  public function User()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function Company()
  {
    return $this->belongsTo(Company::class, 'company_id', 'id');
  }

  public function CompanyShipAddress()
  {
    return $this->belongsTo(CompanyShipAddress::class, 'company_shipping_id', 'id');
  }

  public function PoItem()
  {
    return $this->hasMany(PoItem::class, 'po_id', 'id');
  }
	
  public function UserAddress()
  {
    return $this->belongsTo(UserAddress::class, 'vendor_shiping_id', 'id');
  }
}
