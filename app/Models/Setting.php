<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  public $table = 'settings';
  protected $fillable = [
    'id',
    'invoice_type',
    'company_id',
    'po_pre_fix',
    'po_no_set',
    'grn_pre_fix',
    'gnr_no_set',
    'sales_order_pre_fix',
    'sales_order_no_set',
    'auto_sales_status',
    'order_planning_pre_fix',
    'order_planning_no_set',
    'auto_order_planning_status',
    'job_order_pre_fix',
    'job_order_no_set',
    'auto_job_card_status',
    'style_number_pre_fix',
    'style_number_no_set',
    'auto_style_number_status',
  ];
}
