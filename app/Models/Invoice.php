<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'user_id',
    'company_id',
    'by_user_id',
    'is_export',
    'invoice_no',
    'challane_no',
    'invoice_date',
    'invoice_amount',
    'sub_total_amount',
    'discount_amount',
    'tax_amount',
    'igst_amount',
    'cgst_amount',
    'sgst_amount',
    't_charge',
    't_tax',
    't_amount',
    'invoice_file',
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

  public function InvoiceItem()
  {
    return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
  }

  public function ByUser()
  {
    return $this->belongsTo(User::class, 'by_user_id', 'id');
  }

}
