<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\GrnItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\PoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceAdd extends Controller
{
  public function index()
  {
    return view('content.apps.app-invoice-add');
  }

  public function itemAdd()
  {
    return view('content.apps.app-invoice-with-item-add');
  }

  public function grnInvoiceView(Request $request)
  {
    $poItems = PoItem::with(["Po"])->whereIn('id', $request->ids)->get();
    return view('content.apps.app-invoice-with-item-add', compact("poItems"));
  }


  public function itemStore(Request $request)
  {
    // dd($request->user_id);
    $request->validate([
      'user_id' => 'required',
      'invoice_no' => 'required|unique:invoices,invoice_no,NULL,id,user_id,' . $request->user_id . ',deleted_at,NULL',
      'company_id' => 'required',
      'invoice_date' => 'required'
    ]);
    // dd($request);
    $invoice = new Invoice([
      'user_id' => $request->user_id,
      'by_user_id' => Auth::user()->id,
      'invoice_no' => $request->invoice_no,
      'challane_no' => $request->challane_no,
      'invoice_date' => $request->invoice_date,
      'company_id' => $request->company_id,
      'invoice_amount' => $request->invoice_amount,
      'sub_total_amount' => $request->sub_total_amount,
      'discount_amount' => $request->discount_amount,
      'igst_amount' => $request->igst_amount,
      'sgst_amount' => $request->sgst_amount,
      'cgst_amount' => $request->cgst_amount,
      't_charge' => $request->t_charge,
      't_tax' => $request->t_tax,
      't_amount' => $request->t_amount,
      'note' => $request->note,
    ]);
    $result = $invoice->save();
    if ($result) {
      $invoiceId = $invoice->id;
      // dd($request['group-a']);
      if (count($request['group-a']) > 0) {
        foreach ($request['group-a'] as $item) {
          $po_item_id = !empty($item['po_item_id']) ? $item['po_item_id'] : Null;
          $invoiceItem = new InvoiceItem([
            'invoice_id' => $invoiceId,
            'po_item_id' => $po_item_id,
            'item_name' => $item['item_name'],
            'item_description' => $item['item_description'],
            'hsn' => $item['hsn'],
            'tax' => $item['taxValue'],
            'tax_percentage' => $item['tax'],
            'rate' => $item['rate'],
            'qty' => $item['qty'],
            'discount' => $item['discount'],
            'uom' => $item['uom'],
            'without_tax_amount' => $item['qty'] * $item['rate'],
            'amount' => $item['amount']
          ]);
          $invoiceItem->save();

//          if (!empty($po_item_id)) {
//            PoItem::where('id', $po_item_id)->update([
//              "invoice_status" => 1,
//            ]);
//          }

        }
        if (!empty($request->t_charge)) {
          $invoiceItemForTranpotation = new InvoiceItem([
            'invoice_id' => $invoiceId,
            'item_name' => "Transportation Charge",
            'item_description' => "Transportation Charge",
            'tax' => (intval($request->t_amount) - intval($request->t_charge)),
            'tax_percentage' => $request->t_tax,
            'rate' => $request->t_charge,
            'qty' => 0,
            'without_tax_amount' => $request->t_charge,
            'amount' => $request->t_amount
          ]);
          $invoiceItemForTranpotation->save();
        }
      }

      if ($request->invoice_file) {
        $this->validate(request(), [
          'invoice_file.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->invoice_file;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/invoice/' . $invoiceId . '/');
        if (!is_dir(public_path('/invoice'))) {
          mkdir(public_path('/invoice'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);
        Invoice::where('id', $invoiceId)->update([
          "invoice_file" => $new_file_name,
        ]);
      }
      return redirect()->action([InvoiceList::class, 'index'])->withSuccess('Invoice Generate successfully');
    } else {
      return response()->json(['status' => 'error', 'message' => 'Provide proper details']);
    }
  }
}
