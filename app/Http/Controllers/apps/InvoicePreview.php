<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoicePreview extends Controller
{
  public function index($id)
  {
    $id = base64_decode($id);
    $invoice = Invoice::with(["Company"])->where('id', $id)->first();

    // dd($invoice);
    return view('content.apps.app-invoice-preview', compact("invoice"));
  }
}
