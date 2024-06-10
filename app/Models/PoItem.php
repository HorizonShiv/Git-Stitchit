<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PoItem extends Model
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  public $table = 'purchase_order_items';
  protected $fillable = [
    'po_id',
    'item_id',
    'item_name',
    'item_description',
    'hsn',
    'rate',
    'tax',
    'tax_percentage',
    'invoice_status',
    'qty',
    'uom',
    'excessInwardAllowedPercent',
    'without_tax_amount',
    'amount'
  ];

  protected $dates = ['deleted_at'];

  public function Po()
  {
    return $this->belongsTo(Po::class, 'po_id', 'id');
  }

  public function GrnItem()
  {
    return $this->hasMany(GrnItem::class, 'po_item_id', 'id');
  }

  public function InvoiceItem()
  {
    return $this->hasMany(InvoiceItem::class, 'po_item_id', 'id');
  }

}
