<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class EcommerceSettingsDetails extends Controller
{
  public function index()
  {
    $setting = Setting::where('id', 1)->first();
    return view('content.apps.app-ecommerce-settings-details', compact("setting"));
  }

  public function settingFormSubmit(Request $request)
  {
    $invoiceType = $request->invoiceType;
    Setting::where('id', 1)->update([
      'invoice_type' => $invoiceType
    ]);
    echo 'success';
  }
  public function setSettingAutoNumber(Request $request)
  {
    Setting::where('id', 1)->update([
      'auto_sales_status' => $request->autoSalesNumberCheckbox,
      'auto_order_planning_status' => $request->autoJobPlanningNumberCheckbox,
      'auto_job_card_status' => $request->autoJobCardNumberCheckbox,
      'auto_style_number_status' => $request->autoStyleNumberCheckbox,
    ]);
    return response()->json(['success' => true]);
  }

}
