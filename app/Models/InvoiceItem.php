<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'invoice_id',
    'item_name',
    'po_item_id',
    'item_description',
    'hsn',
    'rate',
    'tax',
    'tax_percentage',
    'qty',
    'uom',
    'discount',
    'without_tax_amount',
    'amount'
  ];

  protected $dates = ['deleted_at'];

  public function Invoice()
  {
    return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
  }

  public function PoItem()
  {
    return $this->belongsTo(PoItem::class, 'po_item_id', 'id');
  }

  public function GrnItem()
  {
    return $this->belongsTo(GrnItem::class, 'po_item_id', 'po_item_id');
  }

}
