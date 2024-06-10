<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StyleMaster extends Model
{
  use SoftDeletes;

  public $table = 'style_masters';
  protected $fillable = [
    'style_no',
    'style_date',
    'customer_id',
    'brand_id',
    'febric',
    'style_category_id',
    'style_subcategory_id',
    'demographic_master_id',
    'fit_id',
    'season_id',
    'designer_id',
	  'merchant_id',
    'designer_name',
    'rate',
    'color',
    'sample',
    'production',
    'specs_sheet',
    'bom_sheet',
    'sample_photo',
    'tech_pack',
    'trim_card',
    'final_image',
  ];

  public function StyleCategory()
  {
    return $this->belongsTo(StyleCategory::class, 'style_category_id', 'id');
  }

  public function StyleSubCategory()
  {
    return $this->belongsTo(StyleSubCategory::class, 'style_subcategory_id', 'id');
  }

  public function Customer()
  {
    return $this->belongsTo(Customer::class, 'customer_id', 'id');
  }

  public function Brand()
  {
    return $this->belongsTo(Brand::class, 'brand_id', 'id');
  }

  public function Fit()
  {
    return $this->belongsTo(Fit::class, 'fit_id', 'id');
  }

  public function Season()
  {
    return $this->belongsTo(Season::class, 'season_id', 'id');
  }

  public function User()
  {
    return $this->belongsTo(User::class, 'customer_id', 'id');
  }

  public function Designer()
  {
    return $this->belongsTo(User::class, 'designer_id', 'id');
  }
	
  public function SalesOrderStyleInfo()
  {
    return $this->hasMany(SalesOrderStyleInfo::class, 'style_master_id', 'id');
  }

  public function Demographic()
  {
    return $this->belongsTo(Demographic::class, 'demographic_master_id', 'id');
  }


  public function StyleMasterMaterials()
  {
    return $this->hasMany(StyleMasterMaterials::class, 'style_master_id', 'id');
  }


  public function StyleMasterProcesses()
  {
    return $this->hasMany(StyleMasterProcesses::class, 'style_master_id', 'id');
  }

  use HasFactory;
}
