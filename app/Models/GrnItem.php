<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class GrnItem extends Model
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  public $table = 'grn_items';
  protected $fillable = [
    'po_item_id',
    'grn_no',
    'warehouse_master_id',
    'item_master_id',
    'supplier_id',
    'rate',
    'amount',
    'without_tax_amount',
    'tax',
    'tax_percentage',
    'hsn',
    'uom',
    'item_description',
    'po_no',
    'date',
    'printNumber',
    'qty',
    'challanNumber',
    'invoiceNumber',
    'remark'
  ];

  protected $dates = ['deleted_at'];

  public function PoItem()
  {
    return $this->belongsTo(PoItem::class, 'po_item_id', 'id');
  }

  public function Item()
  {
    return $this->belongsTo(Item::class, 'item_master_id', 'id');
  }
  public function User()
  {
    return $this->belongsTo(User::class, 'supplier_id', 'id');
  }
}
