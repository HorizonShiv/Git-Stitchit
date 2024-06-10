<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class QcItem extends Model
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  public $table = 'qc_items';
  protected $fillable = [
    'po_item_id',
    'date',
    'item_name',
    'qty',
    'g_qty',
    'b_qty',
    'invoice_status',
    'remark'
  ];

  protected $dates = ['deleted_at'];

  public function PoItem()
  {
    return $this->belongsTo(PoItem::class, 'po_item_id', 'id');
  }
}
