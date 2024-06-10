<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\GrnItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceQuery;
use App\Models\PoItem;
use App\Models\Setting;
use App\Models\CompanyShipAddress;
use App\Models\User;
use App\Models\UserAddress;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InvoiceList extends Controller
{
  public function index()
  {
    if ((Auth::user()->role == 'vendor')) {
      //$invoices = Invoice::with(["InvoiceItem"])->where("user_id", Auth::user()->id)->get();
      $invoiceCount = Invoice::where("user_id", Auth::user()->id)->where("status", 'unpaid')->count();
      $invoiceVendors = Invoice::where("user_id", Auth::user()->id)->where("status", 'unpaid')->distinct()->count('company_id');
      $invoiceAmount = Invoice::where("user_id", Auth::user()->id)->where("status", 'paid')->sum('invoice_amount');
      $invoiceUnPaidAmount = Invoice::where("user_id", Auth::user()->id)->where("status", 'unpaid')->sum('invoice_amount');
    } else {
      //$invoices = Invoice::with("InvoiceItem")->orderBy("id", "desc")->get();
      $invoiceCount = Invoice::where("status", 'unpaid')->count();
      $invoiceVendors = Invoice::where("status", 'unpaid')->distinct()->count('company_id');
      $invoiceAmount = Invoice::where("status", 'paid')->sum('invoice_amount');
      $invoiceUnPaidAmount = Invoice::where("status", 'unpaid')->sum('invoice_amount');
    }
    $data["invoiceCount"] = $invoiceCount;
    $data["invoiceVendors"] = $invoiceVendors;
    $data["invoiceAmount"] = $invoiceAmount;
    $data["invoiceUnPaidAmount"] = $invoiceUnPaidAmount;
    return view('content.apps.app-invoice-list', compact("data"));
  }

  public function listingInvoice(Request $request)
  {
    if (isset($request['grn_receive'])) {
      $invoicesQ = Invoice::with(["InvoiceItem"]);
      if ((Auth::user()->role == 'vendor')) {
        $invoicesQ->where("user_id", Auth::user()->id);
      }
      if (isset($request->approve_status) && !empty($request->approve_status)) {
        if ($request->approve_status == '1') {
          $invoicesQ->where('is_approve', '1');
        }
        if ($request->approve_status == '2') {
          $invoicesQ->whereNull('is_approve');
        }
      }
      if (!empty($request->startDate) && !empty($request->endDate)) {
        $invoicesQ->where('invoice_date', '>=', $request->startDate);
        $invoicesQ->where('invoice_date', '<=', $request->endDate);
      }
      $invoices = $invoicesQ->orderBy("id", "asc")->get();
    }
    $result = array("data" => array());
    $num = 1;
    if ($invoices != null) {
      $setting = Setting::where('id', 1)->first();
      foreach ($invoices as $invoice) {

        $invoiceId = '<a href="' . route('app-invoice-preview', base64_encode($invoice->id)) . '">' . $invoice->id . '</a>';
        $vendor = '<div class="d-flex justify-content-start align-items-center">
                <div class="avatar-wrapper">
                  <div class="avatar me-2"><span
                      class="avatar-initial rounded-circle bg-label-info">' . substr($invoice->User->company_name, 0, 2) . '</span>
                  </div>
                </div>
                <div class="d-flex flex-column"><span
                    class="fw-medium">' . $invoice->User->company_name . '</span><small
                    class="text-truncate text-muted">' . $invoice->User->person_name . '</small><small
                    class="text-truncate text-muted">' . $invoice->User->person_mobile . '</small>
                </div>
              </div>';
        $company = '<div class="d-flex justify-content-start align-items-center">
                <div class="avatar-wrapper">
                  <div class="avatar me-2"><span
                      class="avatar-initial rounded-circle bg-label-info">' . substr($invoice->Company->b_name, 0, 2) . '</span>
                  </div>
                </div>
                <div class="d-flex flex-column"><span
                    class="fw-medium">' . $invoice->Company->b_name . '</span><small
                    class="text-truncate text-muted">' . $invoice->Company->b_mobile . '</small>
                </div>
              </div>';
        $taxShow = !empty($invoice->igst_amount) ? 'IGST' : "CGST/SGST";
        $invoiceSubTotal = '<div class="d-flex justify-content-start align-items-center">
                <div class="d-flex flex-column"><span
                    class="fw-medium">' . $invoice->sub_total_amount . '</span>
                  <small class="text-truncate text-muted">Discount
                    : ' . $invoice->discount_amount . '</small>
                  <small class="text-truncate text-muted">' . $taxShow . '
                    : ' . ($invoice->igst_amount + $invoice->sgst_amount + $invoice->cgst_amount) . '</small>
                </div>
              </div>';
        $invoiceQty = array_sum(array_column($invoice->InvoiceItem->toArray(), 'qty'));
        $invoiceQtyShow = '<span>' . round($invoice->invoice_amount) . '</span><br>
              <small class="mt-4 text-truncate text-muted">Qty :
                : ' . $invoiceQty . '</small>';

        if ($invoice->status == 'unpaid') {
          $color = "secondary";
        } elseif ($invoice->status == 'paid') {
          $color = "success";
        } else {
          $color = "warning";
        }

        $paymentStatus = "";
        $paymentStatus .= '<span class="badge bg-label-' . $color . '" text-capitalized="">' . $invoice->status . '</span>';
        if ((Auth::user()->role == 'admin')) {
          $status = "'" . $invoice->status . "'";
          $paymentStatus .= '</br></br>
              <button class="btn btn-primary btn-sm edit-address waves-effect waves-light" type="button"
                      data-bs-toggle="modal" data-bs-target="#addPermissionModal"
                      onclick="viewInvoiceStatusChange(' . $invoice->id . ',' . $status . ')">
                        Change
              </button>';
        }
        $is_approve_color = ($invoice->is_approve == '1') ? 'success' : 'warning';
        $is_approve = ($invoice->is_approve == '1') ? 'Approved' : 'Pending';
        $approveStatus = '<span class="badge rounded bg-label-' . $is_approve_color . '">' . $is_approve . '</span>
              </br></br>';
        if ($invoice->is_approve != '1') {
          $queryName = "Query Generate";
          $buttonColor = "btn-warning";
        } else {
          $queryName = "Query History";
          $buttonColor = "btn-secondary";
        }

        $invoiceRate = "";
        $checkRate = "";
        $checkInvoiceNumber = [];
        $checkInvoiceQty = [];
        $poRate = "";
        $grnQty = 0;
        $poItemIds = [];
        foreach ($invoice->InvoiceItem as $item) {
          $poNo = "";
          if (isset($item->PoItem->po_id)) {
            $poNo .= $item->PoItem->Po->po_no;
            $checkRate .= ($item->PoItem->rate != $item->rate) ? 'notMatch' : '';
            $poRate = $item->PoItem->rate;
            $invoiceRate = $item->rate;
          }
          //dd($item->PoItem->GrnItem);
          if (isset($item->PoItem->GrnItem)) {
            //dd($invoice->invoice_no);
            $grnItemsQ = GrnItem::where('purchase_orders.user_id', $invoice->user_id);
            if ($setting->invoice_type == 1) {
              $grnItemsQ->where('invoiceNumber', $invoice->invoice_no);
            } else {
              $grnItemsQ->where('challanNumber', $invoice->challane_no);
            }
            $grnItemsQ->where('grn_items.po_item_id', $item->PoItem->id)
              ->select('grn_items.*')
              ->leftJoin('purchase_order_items', 'purchase_order_items.id', '=', 'grn_items.po_item_id')
              ->leftJoin('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_items.po_id');
            $grnItems = $grnItemsQ->get();

            if (isset($grnItems) && count($grnItems) > 0) {
              foreach ($grnItems as $grnItem) {
                //dd(22);
                //echo $grnItem->qty.'<br>';
                if ($setting->invoice_type == 1) {
                  ($grnItem->invoiceNumber != $invoice->invoice_no) ? (array_push($checkInvoiceNumber, "notMatch")) : (array_push($checkInvoiceNumber, "match"));
                  ($grnItem->qty != $item->qty) ? (array_push($checkInvoiceQty, "notMatch")) : (array_push($checkInvoiceQty, "match"));
                } else {
                  ($grnItem->challanNumber != $invoice->challane_no) ? (array_push($checkInvoiceNumber, "notMatch")) : (array_push($checkInvoiceNumber, "match"));
                  ($grnItem->qty != $item->qty) ? (array_push($checkInvoiceQty, "notMatch")) : (array_push($checkInvoiceQty, "match"));
                }
                //$num_g++;
              }
            } else {
              array_push($checkInvoiceNumber, "notMatch");
            }
            //dd($checkInvoiceNumber);
            $grnQty += array_sum(array_column(($item->PoItem->GrnItem)->toArray(), 'qty'));
            //}
          }
          array_push($poItemIds, $item->po_item_id);
        }
        $poAvailability = "";
        if (empty($poNo)) {
          $poAvailability = '<span class="badge bg-label-success mt-1" text-capitalized="">Without PO</span>';
        }
        $invoiceQtyChecking = InvoiceItem::whereIn('po_item_id', $poItemIds)->sum('qty');
        if (($checkRate == 'notMatch') || (in_array("notMatch", $checkInvoiceNumber)) || (in_array("notMatch", $checkInvoiceQty))) {
          $invoiceQuery = InvoiceQuery::where("invoice_id", $invoice->id)->first();
          $checkInvoiceNumberShow = (in_array("notMatch", $checkInvoiceNumber)) ? "'notMatch'" : "''";
          $checkInvoiceQtyShow = (in_array("notMatch", $checkInvoiceQty)) ? "'notMatch'" : "''";
          $poAvailabilityShow = !empty($poAvailability) ? "'available'" : "''";

          if ($invoiceQuery || (Auth::user()->role == 'admin')) {
            $approveStatus .= '<button class="mt-2 btn btn-sm ' . $buttonColor . ' waves-effect" type = "button"
                          data-bs-toggle = "modal" data-bs-target = "#queryInvoiceModal"
                          onclick = "viewInvoiceQuery(' . $invoice->id . ',' . $invoiceQtyChecking . ',' . $grnQty . ',' . $invoiceRate . ',' . $poRate . ',' . $checkInvoiceNumberShow . ',' . $checkInvoiceQtyShow . ',' . $poAvailabilityShow . ')" >' . $queryName . '</button >';
          } else {
            if ((Auth::user()->role == 'admin') && ($invoice->is_approve != '1')) {
              $approveStatus .= '<button class="btn btn-sm btn-outline-success waves-effect"
                          onclick = "viewApprove(' . $invoice->id . ');" >
                            Approve
                  </button >';
            }
          }
        } else {
          if ((Auth::user()->role == 'admin') && ($invoice->is_approve != '1')) {
            $approveStatus .= '<button class="btn btn-sm btn-outline-success waves-effect"
                          onclick = "viewApprove(' . $invoice->id . ');" >
                            Approve
                  </button >';
          }
        }
        $invoiceFile = "";
        if (!empty($invoice->invoice_file)) {
          $fileUrl = url('invoice/' . $invoice->id . '/' . $invoice->invoice_file);
          $invoiceFile = '<a target="_blank" href="' . $fileUrl . '">Download
                  File</a>';
        }

        $action = '';
        $action .= '<div class="d-flex align-items-center">
                <a href="' . route('app-invoice-preview', base64_encode($invoice->id)) . '"><i
                    class="ti ti-eye mx-2 ti-sm"></i></a>';
        if ($invoice->is_approve != '1') {
          $action .= '<a onclick = "invoiceDelete(' . $invoice->id . ');"
                     class="dropdown-item cursor-pointer delete-record text-danger" ><i class="fa fa-trash" ></i > </a >';
        }
        $action .= '</div >';


        if ($request['grn_receive'] == 1) {
          if ($grnQty > 0) {
            array_push($result["data"], array($num, $vendor, $company, '<span>' . $invoice->invoice_no . '</span><br/><small class="text-truncate text-muted text-secondary">' . $invoice->challane_no . '</small><br/>' . $poAvailability, date("D, d M Y", strtotime($invoice->invoice_date)), $invoiceSubTotal, $invoiceQtyShow, $paymentStatus, $approveStatus, $invoiceFile, $action));
            $num++;
          }
        } else {
          array_push($result["data"], array($num, $vendor, $company, '<span>' . $invoice->invoice_no . '</span><br/><small class="text-truncate text-muted text-secondary">' . $invoice->challane_no . '</small><br/>' . $poAvailability, date("D, d M Y", strtotime($invoice->invoice_date)), $invoiceSubTotal, $invoiceQtyShow, $paymentStatus, $approveStatus, $invoiceFile, $action));
          $num++;
        }
      }
    }
    echo json_encode($result);
  }

  public
  function invoiceQueryMail()
  {
    $invoices = Invoice::with("InvoiceItem")->orderBy("id", "desc")->get();
    foreach ($invoices as $invoice) {
      $checkRate = "";
      $checkQty = "";
      $grnQty = 0;
      $poItemIds = [];
      foreach ($invoice->InvoiceItem as $item) {
        if (isset($item->PoItem->po_id)) {
          $checkRate .= ($item->PoItem->rate != $item->rate) ? 'notMatch' : '';
        }
        if (isset($item->PoItem->GrnItem)) {
          $grnQty += array_sum(array_column(($item->PoItem->GrnItem)->toArray(), 'qty'));
        }
        array_push($poItemIds, $item->po_item_id);
      }
      $invoiceQtyChecking = InvoiceItem::whereIn('po_item_id', $poItemIds)->sum('qty');
      // dd($invoiceQtyChecking);
      if (($invoiceQtyChecking > $grnQty) || ($checkRate == 'notMatch')) {
        $description = '';
        $description .= ($checkRate == 'notMatch') ? 'Invoice rate and po rate not matched!' : "";
        $description .= ($checkQty == 'notMatch') ? 'GRN Qty and Po Qty not matched!' : "";
        $user_id = $invoice->user_id;
        $admin_id = Auth::user()->id;
        $role = Auth::user()->role;
        $invoiceQuery = new InvoiceQuery([
          'invoice_id' => $invoice->id,
          'user_id' => $user_id,
          'admin_id' => $admin_id,
          'message_by' => $role,
          'description' => $description,
        ]);
        $result = $invoiceQuery->save();
        if ($result) {
          if (!empty($invoice->User->email)) {
            Mail::send('content.apps.app-invoice-query-mail', ['name' => ($invoice->User->person_name ?? "Sir"), 'query' => $description], function ($message) use ($invoice) {
              $message->to('shivpatel3035@gmail.com')
                ->subject('Invoice Query');
              if (!empty($invoice->Company->b_email)) {
                $message->cc([$invoice->Company->b_email]);
              }
            });
            // $mailResult = Mail::send('content.apps.app-invoice-query-mail', ['name' => ($invoice->User->person_name ?? "Sir"), 'query' => $description], function ($message) use ($invoice) {
            //   $message->to('shivpatel3035@gmail.com')
            //     ->subject('Invoice Query');

            //   if (!empty($invoice->Company->b_email)) {
            //     $message->cc([$invoice->Company->b_email]);
            //   }
            // });
          }
        }
      }
    }
  }

  public function sendQueryMailCronJob()
  {

    try {
      $yesterday = date('Y-m-d', strtotime('-1 day'));


      $invoices = Invoice::with("InvoiceItem")->where('invoices.created_at', 'like', $yesterday . '%')->orderBy("id", "desc")->get();
      if ($invoices->count() > 0) {
        foreach ($invoices as $invoice) {
          $checkRate = "";
          $checkQty = "";
          $grnQty = 0;
          $poItemIds = [];


          // dd($invoice);
          foreach ($invoice->InvoiceItem as $item) {
            if (isset($item->PoItem->po_id)) {
              $checkRate .= ($item->PoItem->rate != $item->rate) ? 'notMatch' : '';
            }
            if (isset($item->PoItem->GrnItem)) {
              $grnQty += array_sum(array_column(($item->PoItem->GrnItem)->toArray(), 'qty'));
            }
            array_push($poItemIds, $item->po_item_id);
            // dd($item);
          }

          $invoiceQtyChecking = InvoiceItem::whereIn('po_item_id', $poItemIds)->sum('qty');

          // dd($invoiceQtyChecking);
          if (($invoiceQtyChecking > $grnQty) || ($checkRate == 'notMatch')) {
            $description = '';
            $description .= ($checkRate == 'notMatch') ? 'Invoice rate and po rate not matched!' : "";
            $description .= ($checkQty == 'notMatch') ? 'GRN Qty and Po Qty not matched!' : "";
            $user_id = $invoice->user_id;

            // $invoiceQuery = new InvoiceQuery([
            //   'invoice_id' => $invoice->id,
            //   'user_id' => $user_id,
            //   'description' => $description,
            // ]);
            // echo $invoice->User->email;
            // dd($description);
            // $result = $invoiceQuery->save();

            // dd($description);

            // if ($result) {
            if (!empty($invoice->User->email)) {
              $mailResult = Mail::send('content.apps.app-invoice-query-mail', ['name' => ($invoice->User->person_name ?? "Sir"), 'query' => $description], function ($message) use ($invoice) {
                $message->to($invoice->User->email)
                  ->subject('Invoice Query');

                if (!empty($invoice->Company->b_email)) {
                  $message->cc([$invoice->Company->b_email]);
                }
              });
            }
            // }
            // exit();
          }
        }
      }
      // else{
      //   echo 'data not available';
      // }
    } catch (\Exception $e) {
      \Illuminate\Support\Facades\Log::error('Error in invoiceQueryMail: ' . $e->getMessage());
    }
  }


  public
  function invoiceDelete(Request $request)
  {
    $id = $request->id;
    $invoiceItem = InvoiceItem::where('invoice_id', $id)->first();
    if ($invoiceItem) {
      PoItem::where('id', $invoiceItem->po_item_id)->update([
        "invoice_status" => null,
      ]);
    }
    InvoiceItem::where('invoice_id', $id)->delete();
    Invoice::where('id', $id)->delete();
    echo 'success';
  }

  // only file uploaded invoice
  public
  function store(Request $request)
  {
    $invoice = new Invoice([
      'user_id' => $request->user_id,
      'invoice_no' => $request->invoice_number,
      'invoice_date' => $request->invoice_date,
      'company_id' => $request->company_id,
      'invoice_amount' => $request->invoice_amount,
      'sub_total_amount' => $request->sub_total_amount,
      'discount_amount' => $request->discount_amount,
      'igst_amount' => $request->igst_amount,
      'sgst_amount' => $request->sgst_amount,
      'cgst_amount' => $request->cgst_amount,
      'b_mobile' => $request->b_mobile,
      'note' => $request->note,
    ]);
    $result = $invoice->save();
    if ($result) {
      $invoiceId = $invoice->id;
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


      return redirect()->action([InvoiceList::class, 'index']);
    } else {
      return response()->json(['status' => 'error', 'message' => 'Provide proper details']);
    }
  }

  public
  function getVendorDetails(Request $request)
  {
    $userId = $request->user_id;
    $html = '';
    if (!empty($userId)) {
      $user = User::with("UserAddress")->where('id', $userId)->first();
      $html .= ' <p class="mb-2">' . $user->company_name . '</p>';
      if ($user && isset($user->UserAddress)) {

        // dd($user->toArray());

        $html .= ' <p>' . $user->UserAddress->b_address1 . ', ' . $user->UserAddress->b_address2 . '</br>
          ' . $user->UserAddress->b_city . ', ' . $user->UserAddress->b_state . ' - ' . $user->UserAddress->b_pincode . '</p>
            <p>Email. : ' . $user->email . '</p>
            <p>GST No. : ' . $user->gst_no . '</p>';
      }
      $html .= '<input type="hidden" name="v_gst_two" id="v_gst_two" value="' . substr($user->gst_no, 0, 2) . '">';
    }
    echo $html;
  }


  public
  function viewInvoiceQuery(Request $request)
  {
    $html = '';
    $id = $request->id;
    $invoice = Invoice::with(["InvoiceItem"])->where("id", $id)->first();
    $html .= '<div class="card h-100">
        <div class="card-header d-flex justify-content-between">
          <h5 class="card-title m-0 me-2">Invoice : ' . $invoice->invoice_no . ' / Challan : ' . $invoice->challane_no . '</h5>
        </div>
        <div class="table-responsive">
          <table class="table table-borderless border-top">
            <thead class="border-bottom">
            <tr>
              <th>Po No.</th>
              <th>Invoice Qty</th>
              <th>GRN Qty</th>
              <th>GRN Invoice</th>
              <th>GRN Challan</th>
              <th>Invoice Amount</th>
              <th>PO Amount</th>
              <th>Status</th>

            </tr>
            </thead>
            <tbody>';


    foreach ($invoice->InvoiceItem as $item) {


      $poNoShow = "";
      if (isset($item->PoItem->id) && !empty($item->PoItem->id)) {
        $grnItems = GrnItem::where('invoiceNumber', $invoice->invoice_no)
          ->where('purchase_orders.user_id', $invoice->user_id)
          ->where('grn_items.po_item_id', $item->PoItem->id)
          ->select('grn_items.*')
          ->leftJoin('purchase_order_items', 'purchase_order_items.id', '=', 'grn_items.po_item_id')
          ->leftJoin('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_items.po_id')
          ->get();
        $invoiceWiseGrnQty = 0;
        $grnInvoiceNo = "<ul>";
        $grnChallanNo = "<ul>";
        // if(!empty($item->po_item_id)){
        //   $POItem = PoItem::where('purchase_order_items.id','=',$item->po_item_id)->get();
        // }

        if (isset($grnItems) && count($grnItems) > 0) {
          foreach ($grnItems as $grnItem) {
            $invoiceWiseGrnQty += $grnItem->qty;
            $grnInvoiceNo .= "<li>" . $grnItem->invoiceNumber . "</li>";
            $grnChallanNo .= "<li>" . $grnItem->challanNumber . "</li>";
          }
        }
        $poNoShow = '<a href="' . route('app-po-preview', $item->PoItem->po_id) . '">' . ($item->PoItem->PO->po_no ?? '') . '</a>';
      }
      $grnInvoiceNo .= "</ul>";
      $grnChallanNo .= "</ul>";

      $qtyStatus = ($invoiceWiseGrnQty != $item->qty) ? "Qty Not Matched" : "Qty Matched";
      $qtyStatusColor = ($invoiceWiseGrnQty != $item->qty) ? "danger" : "success";


      $grnStatus = (isset($grnInvoiceNo) && $grnInvoiceNo == $grnChallanNo) ? "GRN Matched" : "Mismatch GRN";
      $grnStatusColor = (isset($grnInvoiceNo) && $grnInvoiceNo == $grnChallanNo) ? "success" : "danger";

      $amountStatus = (isset($item->PoItem->rate) && $item->PoItem->rate == $item->rate) ? "Rate Matched" : "Mismatch Rate";
      $amountStatusColor = (isset($item->PoItem->rate) && $item->PoItem->rate == $item->rate) ? "success" : "danger";

      $html .= '<tr>
              <td>
                <div class="d-flex flex-column">
                  <p class="mb-0 fw-medium">' . $poNoShow . '</p>
                </div>
              </td>
              <td>' . $item->qty . '</td>
               <td>
                <p class="mb-0 fw-medium">' . $invoiceWiseGrnQty . '</p>
              </td>
              <td>
                <p class="mb-0 fw-medium">' . $grnInvoiceNo . '</p>
              </td>
               <td>
               <p class="mb-0 fw-medium">' . $grnChallanNo . '</p>
              </td>
              <td>
              <p class="mb-0 fw-medium">' . $item->rate . '</p>
             </td>
             <td>
             <p class="mb-0 fw-medium">' . ($item->PoItem->rate ?? 0) . '</p>
            </td>

              <td>
              <span class="badge bg-label-' . $qtyStatusColor . ' mb-1">' . $qtyStatus . '</span>
              <span class="badge bg-label-' . $grnStatusColor . ' mb-1">' . $grnStatus . '</span>
              <span class="badge bg-label-' . $amountStatusColor . '">' . $amountStatus . '</span>

              </td>


            </tr>';
    }
    $html .= '</tbody>
          </table>
        </div>
      </div>';


    // $invoiceQty = $request->invoiceQty;
    // $grnQty = $request->grnQty;
    // $poAmount = $request->poAmount;
    // $invoiceAmount = $request->invoiceAmount;


    //  $qtyStatus = ($invoiceQty == $grnQty) ? "Quantity Matched" : "Mismatch Quantity";
    //  $qtyStatusColor = ($invoiceQty == $grnQty) ? "success" : "danger";
    //   $amountStatus = ($invoiceAmount == $poAmount) ? "Rate Matched" : "Mismatch Rate";
    //   $amountStatusColor = ($invoiceAmount == $poAmount) ? "success" : "danger";
    //   $invoice = Invoice::where("id", $id)->first();
    //   $html .= !empty($request->checkInvoiceNumberShow) ? '<div class="alert alert-danger" role="alert"> ! Invoice Number and Grn Number is ' . $request->checkInvoiceNumberShow . '</div>' : "";
    //   $html .= !empty($request->checkInvoiceQtyShow) ? '<div class="alert alert-danger" role="alert"> ! Invoice Qty and Grn Qty is ' . $request->checkInvoiceQtyShow . '</div>' : "";
    //   if ($amountStatus != $poAmount) {
    //     $html .= '<div class="alert alert-' . $amountStatusColor . '" role="alert">' . $amountStatus . '</div>';
    //   }
    $html .= '<div class="text-center mb-4">';

    $html .= '<h3 class="mb-2 mt-5">Query Manage</h3>
        </div>';
    if ($invoice->is_approve != 1) {
      $html .= '<div class="col-12 mb-3 mt-3">
            <label class="form-label" for="modalPermissionName">Description</label>
            <textarea class="form-control" rows="5" required name="description"></textarea>
          </div>
          <div class="col-12 text-center demo-vertical-spacing">';
      $html .= '<button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>';
      // if (!empty($request->poAvailabilityShow)) {

      //   if ($invoice->is_approve != '1' && (Auth::user()->role == 'admin')) {
      //     $html .= '<button type="submit" name="btn_approval" value="btn_approval" class="btn btn-success me-sm-3 me-1">Author Approval</button>';
      //   }
      // }
      $html .= '</div>
          <input type="hidden" name="id" value="' . $id . '">
          <input type="hidden" name="_token" id="csrf-token" value="' . Session::token() . '" />';
    }

    $invoiceQueries = InvoiceQuery::with(["Admin", "User"])->where("invoice_id", $id)->get();
    //dd($invoiceQueries);
    foreach ($invoiceQueries as $invoiceQuery) {

      $html .= '<div class="mt-3 chat-history-body bg-body ps ps--active-y p-2">
                        <ul class="list-unstyled chat-history">';
      if ($invoiceQuery->message_by == "admin") {

        $html .= ' <li class="mb-1 chat-message chat-message-right">
                            <div class="d-flex overflow-hidden">
                              <div class="chat-message-wrapper flex-grow-1">
                                <div class="chat-message-text">
                                  <p class="mb-0 bg-primary p-2 text-white rounded-pill" style="float: right !important;">' . $invoiceQuery->description . '</p>
                                </div>
                                <br>
                                <div class="text-end text-muted mt-3">
                                  <small>' . $invoiceQuery->Admin->person_name . '</small>
                                  <p><small>' . $invoiceQuery->created_at . '</small></p>
                                </div>
                              </div>
                              <div class="user-avatar flex-shrink-0 ms-3">
                                <div class="avatar avatar-sm">
                                  <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle">
                                </div>
                              </div>
                            </div>
                          </li>';
      } else {
        $html .= '<li class="mb-1 chat-message">
                            <div class="d-flex overflow-hidden">
                              <div class="user-avatar flex-shrink-0 me-3">
                                <div class="avatar avatar-sm">
                                  <img src="../../assets/img/avatars/2.png" alt="Avatar" class="rounded-circle">
                                </div>
                              </div>
                              <div class="chat-message-wrapper flex-grow-1">
                                <div class="chat-message-text text-white bg-success p-2 rounded-pill">
                                  <p class="mb-0">' . $invoiceQuery->description . '</p>
                                </div>
                                <div class="text-muted mt-1">
                                  <small>' . $invoiceQuery->User->person_name . '</small>
                                  <p><small>' . $invoiceQuery->created_at . '</small></p>
                                </div>
                              </div>
                            </div>
                          </li>';

        $html .= '</ul></div>';
      }
    }
    echo $html;
  }


  public
  function storeInvoiceQuery(Request $request)
  {
    if (isset($request->btn_approval)) {
      $this->invoiceApprove($request);
    }
    $id = $request->id;
    $invoice = Invoice::where("id", $id)->first();
    if ($invoice) {
      $user_id = $invoice->user_id;
      $admin_id = Auth::user()->id;
      $role = Auth::user()->role;
      $invoiceQuery = new InvoiceQuery([
        'invoice_id' => $id,
        'user_id' => $user_id,
        'admin_id' => $admin_id,
        'message_by' => $role,
        'description' => $request->description,
      ]);
      $result = $invoiceQuery->save();
      if ($result) {
        if (!empty($invoice->User->email)) {
          Mail::send('content.apps.app-invoice-query-mail', ['name' => $invoice->User->person_name ?? "Sir", 'query' => $request->description], function ($message) use ($invoice) {
            $message->to($invoice->User->email)
              ->subject('Invoice Query');
            if (!empty($invoice->Company->b_email)) {
              $message->cc([$invoice->Company->b_email]);
            }
          });
        }
        return redirect()->action([InvoiceList::class, 'index'])->withSucces("Successfully Done!");
      } else {
        return response()->json(['status' => 'error', 'message' => 'Provide proper details']);
      }
    }
  }

  public
  function invoiceApprove(Request $request)
  {
    $id = $request->id;

    $invoice = Invoice::with(["User", "InvoiceItem", "Company"])->where("id", $id)->first();
    Invoice::where('id', $id)->update([
      'is_approve' => 1,
    ]);
    //dd($invoice->User->email);
    // Send the email
    if ($invoice) {
      $pdf = PDF::loadView('content.apps.app-invoice-pdf', compact('invoice'));
      if (!empty($invoice->User->email)) {
        Mail::send('content.apps.app-invoice-approval-mail', ['name' => $invoice->User->person_name, 'invoice' => $invoice], function ($message) use ($invoice, $pdf) {
          $message->to($invoice->User->email)
            ->subject('Invoice Approved')
            ->attachData($pdf->output(), 'invoice-approved.pdf', [
              'mime' => 'application/pdf',
            ]);
          if (!empty($invoice->Company->b_email)) {
            $message->cc([$invoice->Company->b_email]);
          }
        });
      }
    }
    echo 'success';
  }

  public
  function getInvoiceDetails(Request $request)
  {
    $id = $request->id;
    $status = $request->status;
    $html = '';

    $html .= '<div class="text-center mb-4">
          <h3 class="mb-2">Change Status</h3>
        </div>
        <form id="addPermissionForm" action="' . route('storeInvoiceDetails') . '" class="row" method="post">
          <div class="col-12 mb-3">
            <label class="form-label" for="modalPermissionName">Permission Name</label>
            <select required id="invoice_status" name="invoice_status" class="select2 form-select"
                    data-allow-clear="true">

              <option selected value="' . $status . '">' . $status . '</option>
              <option value="paid">Paid</option>
              <option value="unpaid">Unpaid</option>
              <option value="partialy paid">Partialy Paid</option>
            </select>
          </div>
          <div class="col-12 text-center demo-vertical-spacing">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
          </div>
          <input type="hidden" name="id" value="' . $id . '">
          <input type="hidden" name="_token" id="csrf-token" value="' . Session::token() . '" />
        </form>';
    echo $html;
  }

  public
  function storeInvoiceDetails(Request $request)
  {
    $id = $request->id;
    $status = $request->invoice_status;

    Invoice::where('id', $id)->update([
      "status" => $status,
    ]);
    return redirect()->action([InvoiceList::class, 'index']);
  }

  public function getVendorShippingDetails(Request $request){
    $vendorId = $request->vendor_id;

    $html1 = '';
    if (!empty($vendorId)) {
      $UserAddress = UserAddress::with('User')->where('id', $vendorId)->first();
      $html1 .= ' <div class="col-md-6 col-sm-7">
                  <h6 class="mb-4">Ship To:</h6>
                  <p class="mb-1">' . $UserAddress->User->company_name . '</p>
                  <p class="mb-1">' . $UserAddress->b_address1 . ', ' . $UserAddress->b_address2 . '</p>
                  <p class="mb-1">' . $UserAddress->b_city . ', ' . $UserAddress->b_state . ' - ' . $UserAddress->b_pincode . '</p>
                  <p class="mb-1">' . $UserAddress->User->mobile . '</p>
                  <p class="mb-0">' . $UserAddress->User->email . '</p>
                </div>';
    }
    $result['shipto'] = $html1;

    // dd($html1);
    echo json_encode($result);
  }

  public function getCompanyShippingDetails(Request $request)
  {

    $shippingID = $request->shipping_id;

    $html1 = '';
    if (!empty($shippingID)) {
      $CompanyShipAddress = CompanyShipAddress::where('id', $shippingID)->first();
      $html1 .= ' <div class="col-md-6 col-sm-7">
                  <h6 class="mb-4">Ship To:</h6>
                  <p class="mb-1">' . $CompanyShipAddress->company_name . '</p>
                  <p class="mb-1">' . $CompanyShipAddress->address1 . ', ' . $CompanyShipAddress->address2 . '</p>
                  <p class="mb-1">' . $CompanyShipAddress->city . ', ' . $CompanyShipAddress->state . ' - ' . $CompanyShipAddress->pincode . '</p>
                  <p class="mb-1">' . $CompanyShipAddress->mobile . '</p>
                  <p class="mb-0">' . $CompanyShipAddress->email . '</p>
                </div>';
    }
    $result['shipto'] = $html1;

    // dd($html1);
    echo json_encode($result);
  }
  public
  function getCompanyDetails(Request $request)
  {
    $companyId = $request->company_id;
    $html = '';
    $html1 = '';
    $html2 = '';
    if (!empty($companyId)) {
      $company = Company::with(['User'])->where('id', $companyId)->first();
      $shippingAddresses = CompanyShipAddress::where('company_id', $companyId)->get();

      // <div class="col-md-6 col-sm-5 col-12 mb-sm-0 mb-4"> </div> This is the div that has been removed from $HTML variable which is mentioned below

      $html .= '
                <h6 class="mb-4">Bill To:</h6>
                <p class="mb-1">' . $company->b_name . '</p>
                <p class="mb-1">' . $company->b_address1 . ', ' . $company->b_address2 . '</p>
                <p class="mb-1">' . $company->b_city . ', ' . $company->b_state . ' - ' . $company->b_pincode . '</p>
                <p class="mb-1">' . $company->b_mobile . '</p>
                <p class="mb-0">' . $company->b_email . '</p>
                <p class="mb-0">GST No. : ' . $company->pancard_gst_no . '</p>
              ';
      // $html1 .= ' <div class="col-md-6 col-sm-7">
      //           <h6 class="mb-4">Ship To:</h6>
      //            <p class="mb-1">' . $company->s_name . '</p>
      //           <p class="mb-1">' . $company->s_address1 . ', ' . $company->s_address2 . '</p>
      //           <p class="mb-1">' . $company->s_city . ', ' . $company->s_state . ' - ' . $company->s_pincode . '</p>
      //           <p class="mb-1">' . $company->s_mobile . '</p>
      //           <p class="mb-0">' . $company->s_email . '</p>
      //         </div>';
      $html .= '<input type="hidden" name="c_gst_two" id="c_gst_two" value="' . substr($company->pancard_gst_no, 0, 2) . '">';
      $html2 .= $company->pre_fix . '' . $company->po_no_set;
    }
    $result['billto'] = $html;
    // $result['shipto'] = $html1;
    $result['po_number'] = $html2;
    $result['shippingAddresses'] = $shippingAddresses;
    // dd($result['shippingAddresses']);
    echo json_encode($result);
  }

  public
  function invoiceExcelExport(Request $request)
  {

    if ((Auth::user()->role == 'vendor')) {
      $invoices = InvoiceItem::with(["Invoice" => function ($query) use ($request) {
        $query->where('invoices.is_approve', 1);
        $query->whereNull('invoices.is_export');
        if (!empty($request->startDate) && !empty($request->endDate)) {
          $query->where('invoice_date', '>=', $request->startDate);
          $query->where('invoice_date', '<=', $request->endDate);
        }
        $query->where('invoices.user_id', Auth::user()->id);
      }, "Invoice.User.UserAddress", "Invoice.Company"])->get();
    } else {
      $invoices = InvoiceItem::with(["Invoice" => function ($query) use ($request) {
        $query->where('invoices.is_approve', 1);
        if ((Auth::user()->role == 'account')) {
          $query->whereNull('invoices.is_export');
        }
        if (!empty($request->startDate) && !empty($request->endDate)) {
          $query->where('invoice_date', '>=', $request->startDate);
          $query->where('invoice_date', '<=', $request->endDate);
        }
      }, "Invoice.User.UserAddress", "Invoice.Company"])->get();;
    }
    //dd($invoices);

    $spreadsheet = new Spreadsheet();
    $spreadsheet->setActiveSheetIndex(0);
    $spreadsheet->getActiveSheet();
    $rowArray1 = ['Invoice Date', 'Invoice No', 'Supplier Invoice No', 'Voucher Type', 'Customer Name', 'Supplier Invoice Date', 'Address 1', 'Address 2', 'State', 'Country', 'GSTIN/UIN', 'GST Registration Type', 'Place of Supply', 'Consignee Name', 'Consignee  Add 1', 'Consignee  Add 2', 'Consignee  Add 3', 'Consignee  State', 'Consignee Country', 'Consignee  Pincode', 'Consignee GSTIN', 'Delivery Note No', 'Delivery Date', 'Doc No.', 'Dispatched Through', 'Destination', 'Order No', 'Order Due Date', 'Tracking No.', 'Other Ref Number', 'Mode of Payment', 'Terms of Delivery', 'LR/RR No.', ' LR/RR Date', 'Vehicle No.', 'Item Name', 'Item Description1', 'Item Description2', 'HSN CODE', 'Item Discount', 'Godown', 'Batch No', 'Expiry Date', 'MFG DATE', 'QTY', 'UOM', 'Item Rate', 'GST Rate', 'Purchase Ledger', 'Amount', 'SGST Ledger', 'SGST  Amount', 'CGST  Ledger', 'CGST Amount', 'IGST Ledger', 'IGST  Amount', 'Cess Ledger', 'Cess Amount', 'Discount Ledger', 'Discount Amount', 'Party PinCode', 'Credit Period', 'For Optional Voucher', 'PARTY ADDRESSTYPE', 'DIFFACTUALQTY', 'Cost Category 1', 'Cost Center 1', 'Cost Amount 1', 'Cost Category 2', 'Cost Center 2', 'Cost Amount 2', 'Cost Category 3', 'Cost Center 3', 'Cost Amount 3', 'Bill Ref Name ', 'Bill Ref Type', 'Bill Ref Amount', 'Bill Ref Name', 'Bill Ref Type', 'Bill Ref Amount'];
    $spreadsheet->getActiveSheet()
      ->fromArray(
        $rowArray1,
        NULL,
        'A1'
      );
    $rowArray = array();
    $invoiceIds = array();
    if ($invoices != null) {
      foreach ($invoices as $invoice) {
        if (isset($invoice->Invoice) && !empty($invoice->Invoice)) {
          $invoiceDate = $invoice->Invoice->invoice_date;
          $invoiceNo = $invoice->Invoice->invoice_no;
          $supplierInvoiceNo = $invoice->Invoice->invoice_no;
          $voucherType = "";

          $customerName = $invoice->Invoice->User->company_name;
          $supplierInvoiceDate = $invoice->Invoice->invoice_date;
          $address1 = $invoice->Invoice->User->UserAddress->b_address1 ?? '';
          $address2 = $invoice->Invoice->User->UserAddress->b_address2 ?? '';
          $state = $invoice->Invoice->User->UserAddress->b_state ?? '';
          $country = "India";
          $gSTINUIN = $invoice->Invoice->User->gst_no ?? '';
          $gSTRegistrationType = "";
          $placeOfSupply = "";
          $consigneeName = "";
          $consigneeAdd1 = "";
          $consigneeAdd2 = "";
          $consigneeAdd3 = "";
          $consigneeState = "";
          $consigneeCountry = "";
          $consigneePincode = "";
          $consigneeGSTIN = "";
          $deliveryNoteNo = "";
          $deliveryDate = "";
          $docNo = "";
          $dispatchedhrough = "";
          $destination = "";
          $orderNo = "";
          $orderDueDate = "";
          $trackingNo = "";
          $otherRefNumber = "";
          $modeofPayment = "";
          $termsofDelivery = "";
          $LRRRNo = "";
          $LRRRDate = "";
          $vehicleNo = "";
          $itemName = "";
          $itemDescription1 = "";
          $itemDescription2 = "";
          $HSNCODE = "";
          $itemDiscount = "";
          $godown = "";
          $batchNo = "";
          $expiryDate = "";
          $MFGDATE = "";
          $qTY = "";
          $UOM = "";
          $itemRate = "";
          $GSTRate = $invoice->tax_percentage . '%';
          $purchaseLedger = "";
          $amount = "";
          $SGSTLedger = "";
          $SGSTAmount = "";
          $CGSTLedger = "";
          $CGSTAmount = "";
          $IGSTLedger = "";
          $IGSTAmount = "";
          $CessLedger = "";
          $CessAmount = "";
          $DiscountLedger = "";
          $DiscountAmount = "";
          $PartyPinCode = "";
          $CreditPeriod = "";
          $ForOptionalVoucher = "";
          $PARTYADDRESSTYPE = "";
          $DIFFACTUALQTY = "";
          $CostCategory1 = "";
          $CostCenter1 = "";
          $CostAmount1 = "";
          $CostCategory2 = "";
          $CostCenter2 = "";
          $CostAmount2 = "";
          $CostCategory3 = "";
          $CostCenter3 = "";
          $CostAmount3 = "";
          $BillRefName = "";
          $BillRefType = "";
          $BillRefAmount = "";
          $BillRefName = "";
          $BillRefType = "";
          $BillRefAmount = "";

          if ($invoice->Invoice->igst_amount > 0) {
            $igstAmount = $invoice->tax;
            $cgstAmount = 0;
            $sgstAmount = 0;
          } else {
            $igstAmount = 0;
            $cgstAmount = ($invoice->tax / 2);
            $sgstAmount = ($invoice->tax / 2);
          }
          if (isset($invoice->PoItem->po_id)) {
            $orderNo = $invoice->PoItem->PO->po_no;
          }

          $nestedData = array();
          $nestedData[] = $invoiceDate;
          $nestedData[] = $invoiceNo;
          $nestedData[] = $supplierInvoiceNo;
          $nestedData[] = $voucherType;
          $nestedData[] = $customerName;
          $nestedData[] = $supplierInvoiceDate;
          $nestedData[] = $address1;
          $nestedData[] = $address2;
          $nestedData[] = $state;
          $nestedData[] = $country;
          $nestedData[] = $gSTINUIN;
          $nestedData[] = $gSTRegistrationType;
          $nestedData[] = $placeOfSupply;
          $nestedData[] = $consigneeName;
          $nestedData[] = $consigneeAdd1;
          $nestedData[] = $consigneeAdd2;
          $nestedData[] = $consigneeAdd3;
          $nestedData[] = $consigneeState;
          $nestedData[] = $consigneeCountry;
          $nestedData[] = $consigneePincode;
          $nestedData[] = $consigneeGSTIN;
          $nestedData[] = $deliveryNoteNo;
          $nestedData[] = $deliveryDate;
          $nestedData[] = $docNo;
          $nestedData[] = $dispatchedhrough;
          $nestedData[] = $destination;
          $nestedData[] = $orderNo;
          $nestedData[] = $orderDueDate;
          $nestedData[] = $trackingNo;
          $nestedData[] = $otherRefNumber;
          $nestedData[] = $modeofPayment;
          $nestedData[] = $termsofDelivery;
          $nestedData[] = $LRRRNo;
          $nestedData[] = $LRRRDate;
          $nestedData[] = $vehicleNo;
          $nestedData[] = $invoice->item_name;
          $nestedData[] = $invoice->item_description;
          $nestedData[] = $itemDescription2;
          $nestedData[] = $invoice->hsn;
          $nestedData[] = $itemDiscount;
          $nestedData[] = $godown;
          $nestedData[] = $batchNo;
          $nestedData[] = $expiryDate;
          $nestedData[] = $MFGDATE;
          $nestedData[] = $invoice->qty;
          $nestedData[] = $invoice->uom;
          $nestedData[] = $invoice->rate;
          $nestedData[] = $GSTRate;
          $nestedData[] = $purchaseLedger;
          $nestedData[] = ($invoice->qty * $invoice->rate);
          $nestedData[] = $SGSTLedger;
          $nestedData[] = $sgstAmount;
          $nestedData[] = $CGSTLedger;
          $nestedData[] = $cgstAmount;
          $nestedData[] = $IGSTLedger;
          $nestedData[] = $igstAmount;;
          $nestedData[] = $CessLedger;
          $nestedData[] = $CessAmount;
          $nestedData[] = $DiscountLedger;
          $nestedData[] = $invoice->discount;
          $nestedData[] = $PartyPinCode;
          $nestedData[] = $CreditPeriod;
          $nestedData[] = $ForOptionalVoucher;
          $nestedData[] = $PARTYADDRESSTYPE;
          $nestedData[] = $DIFFACTUALQTY;
          $nestedData[] = $CostCategory1;
          $nestedData[] = $CostCenter1;
          $nestedData[] = $CostAmount1;
          $nestedData[] = $CostCategory2;
          $nestedData[] = $CostCenter2;
          $nestedData[] = $CostAmount2;
          $nestedData[] = $CostCategory3;
          $nestedData[] = $CostCenter3;
          $nestedData[] = $CostAmount3;
          $nestedData[] = $BillRefName;
          $nestedData[] = $BillRefType;
          $nestedData[] = $BillRefAmount;
          $nestedData[] = $BillRefName;
          $nestedData[] = $BillRefType;
          $nestedData[] = $BillRefAmount;
          $data = $nestedData;
          array_push($rowArray, $data);
          array_push($invoiceIds, $invoice->invoice_id);
        }
      }
    }
    //    echo json_encode($rowArray);
    //    exit();
    $spreadsheet->getActiveSheet()
      ->fromArray(
        $rowArray,
        NULL,
        'A2'
      );

    $writer = new Xlsx($spreadsheet);
    $name = 'invoiceExport-' . date('d-m-Y') . time() . '-' . Auth::user()->role . '.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $name . '"');
    try {
      File::delete('exports/' . $name);
      $writer->save(public_path() . '/exports/' . $name);
      if (!empty($request->endDate) && (Auth::user()->role == 'account')) {
        User::where('id', Auth::user()->id)->update([
          'invoice_export_date' => $request->endDate,
        ]);
      }
      if ((Auth::user()->role == 'account')) {
        Invoice::whereIn('id', $invoiceIds)->update([
          'is_export' => 1,
        ]);
      }
    } catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
      echo $e->getMessage();
    }
    echo '/../exports/' . $name;
  }
}
