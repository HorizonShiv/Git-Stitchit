<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoicePrint extends Controller
{
  public function index($id)
  {
    $id = base64_decode($id);
    $invoice = Invoice::with(["Company", "InvoiceItem", "User"])->where('id', $id)->first();
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.apps.app-invoice-print', ['pageConfigs' => $pageConfigs], compact("invoice"));
  }
}
