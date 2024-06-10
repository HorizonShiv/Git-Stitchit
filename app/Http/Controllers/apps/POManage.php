<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Po;
use App\Models\PoItem;
use App\Models\PoPlaningOrders;
use App\Models\User;
use App\Models\CompanyShipAddress;

use App\Models\UserAddress;
use App\Models\UserBank;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\Item;

class POManage extends Controller
{
  public function index()
  {
    $pos = Po::with(["PoItem"])->orderBy("id", "desc")->get();
    return view('content.apps.app-po-list', compact("pos"));
  }

  public function poListing(Request $request)
  {
    $pos = Po::with(["PoItem"]);

    // if (!empty($request->item_id)) {
    //   $pos->where('item_master_id', $request->item_id);
    // }

    // if (!empty($request->category_id)) {
    //   $pos->whereHas('item.ItemCategory', function ($query) use ($request) {
    //     $query->where('id', $request->category_id);
    //   });
    // }

    // if (!empty($request->subCategory_id)) {
    //   $pos->whereHas('item.ItemSubCategory', function ($query) use ($request) {
    //     $query->where('id', $request->subCategory_id);
    //   });
    // }

    if (!empty($request->vendor_id)) {
      $pos->where('user_id', $request->vendor_id);
    }

    $filteredPo = $pos->get();


    $num = 1;
    $result = array("data" => array());
    foreach ($filteredPo as $po) {
      $vendor = '<div class="d-flex justify-content-start align-items-center">
                    <div class="avatar-wrapper">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded-circle bg-label-info">
                            ' . substr($po->User->company_name, 0, 2) . '
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="fw-medium">
                        ' . $po->User->company_name . '
                        </span>
                        <small class="text-truncate text-muted">
                        ' . $po->User->person_name . '
                        </small>
                        <small class="text-truncate text-muted">
                        ' . $po->User->person_mobile . '
                        </small>
                    </div>
                </div>';

      $company = '<div class="d-flex justify-content-start align-items-center">
                <div class="avatar-wrapper">
                    <div class="avatar me-2">
                        <span class="avatar-initial rounded-circle bg-label-info">
                        ' . substr($po->Company->b_name ?? '-', 0, 2) . '
                        </span>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <span class="fw-medium">
                    ' . $po->Company->b_name . '
                    </span>
                    <small class="text-truncate text-muted">
                    ' . $po->Company->b_mobile . '
                    </small>
                </div>
            </div>';

      $poNumber = $po->po_no;

      $poDate = date('D, d M Y', strtotime($po->po_date));

      // Action For TAX AMOUNT Check
      if (!empty($po->igst_amount)) {
        $TaxType = 'IGST';
      } else {
        $TaxType = 'CGST/SGST';
      }
      $POSubTotal = ' <div class="d-flex justify-content-start align-items-center">
                          <div class="d-flex flex-column"><span
                                  class="fw-medium">' . $po->sub_total_amount  . '</span>
                              <small class="text-truncate text-muted">Discount : ' . $po->discount_amount . '</small>
                              <small class="text-truncate text-muted">' . $TaxType . ' Tax : ' . $po->igst_amount + $po->sgst_amount + $po->cgst_amount . '</small>
                          </div>
                      </div>';

      //PO AMOUNT
      $POAmount = '<span>' . $po->po_amount . '</span><br>
                   <small class="mt-2 text-truncate text-muted">Qty : ' . array_sum(array_column($po->PoItem->toArray(), 'qty')) . '</small>';


      // Action For Status Check
      if ($po->is_approve == '1') {
        $colorCode = 'success';
        $text = 'Approved';
      } else {
        $colorCode = 'warning';
        $text = 'Pending';
      }

      // Action For Apporve Button Check
      if ($po->is_approve != '1') {
        $status = '<span class="badge rounded bg-label-' . $colorCode . '">' . $text . '</span></br></br>
                  <button class="btn btn-sm btn-outline-success waves-effect"
                      onclick="vendorApprove(' . $po->id . ');">
                      Approve
                  </button>';
      } else {
        $status = ' <span class="badge rounded bg-label-' . $colorCode . '">' . $text . '</span>';
      }

      // Action For Po File Check
      if (!empty($po->po_file)) {
        $poFile = '<a target="_blank" href="' . url('po/' . $po->id . '/' . $po->po_file) . '">Download
        File</a>';
      } else {
        $poFile = null;
      }

      if ($po->is_approve != '1') {
        $actions = ' <div class="d-flex align-items-center">
                      <a href="' . route('app-po-preview', $po->id) . '"><i class="ti ti-eye mx-2 ti-sm"></i></a>
                      <div class="dropdown"><a href="javascript:;"
                            class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"
                            aria-expanded="false"><i class="ti ti-dots-vertical ti-sm"></i></a>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <a href="' . route('app-po-edit', $po->id) . '"
                                class="dropdown-item">Edit</a>
                            <a href="' . route('app-po-print', $po->id) . '"
                                class="dropdown-item">Print</a>
                            <a onclick="" class="dropdown-item">Po Wise GRN Syn</a>
                            <div class="dropdown-divider"></div>
                                <a onclick="poDelete(' . $po->id . ');"
                                    class="dropdown-item delete-record text-danger">Delete</a>
                        </div>
                      </div>
                    </div>';
      } else {
        $actions = ' <div class="d-flex align-items-center">
                      <a href="' . route('app-po-preview', $po->id) . '"><i class="ti ti-eye mx-2 ti-sm"></i></a>
                      <div class="dropdown"><a href="javascript:;"
                            class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"
                            aria-expanded="false"><i class="ti ti-dots-vertical ti-sm"></i></a>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <a href="' . route('app-po-print', $po->id) . '"
                                class="dropdown-item">Print</a>
                            <a onclick="" class="dropdown-item">Po Wise GRN Syn</a>
                        </div>
                      </div>
                    </div>';
      }


      array_push($result["data"], array($num, $vendor, $company, $poNumber, $poDate, $POSubTotal, $POAmount, $status, $poFile, $actions));
      $num++;
    }
    echo json_encode($result);
  }


  public function requestlist()
  {
    $poPlaningOrders = PoPlaningOrders::with("Item","PlaningOrders")->get();
    return view('content.apps.app-po-requestlist',compact("poPlaningOrders"));
  }

  public function indexWithInvoice()
  {
    if ((Auth::user()->role == 'vendor')) {
      $poItems = PoItem::whereNull("invoice_status")->with(["Po" => function ($query) {
        $query->where('purchase_orders.is_approve', 1);
        $query->where('purchase_orders.user_id', Auth::user()->id);
      }])
        ->get();
    } else {
      $poItems = PoItem::whereNull("invoice_status")->with(["Po" => function ($query) {
        $query->where('purchase_orders.is_approve', 1);
      }])->orderBy('purchase_order_items.id', 'desc')->get();
    }

    return view('content.apps.app-po-invoice-list', compact("poItems"));
  }

//  public function poDelete(Request $request)
//  {
//    $id = $request->id;
//    PoItem::where('po_id', $id)->delete();
//    Po::where('id', $id)->delete();
//    echo 'success';
//  }


  public function getVendorDetails(Request $request)
  {
    $userId = $request->user_id;
    $html = '';
    $user = User::with(['UserAddress'])->where('id', $userId)->first();
    $html .= ' <p class="mb-2">' . $user->company_name . '</p>
                <p class="mb-2">' . $user->UserAddress->b_address1 . '</p>
                <p class="mb-2">' . $user->UserAddress->b_address2 . '</p>
                <p class="mb-2">' . $user->UserAddress->b_city . '</p>
                <p class="mb-2">' . $user->UserAddress->b_state . '</p>
                <p class="mb-3">' . $user->UserAddress->b_pincode . '</p>
                <p class="mb-3">GST No. : ' . $user->gst_no . '</p>';
    $html .= '<input type="hidden" name="v_gst_two" id="v_gst_two" value="' . substr($user->gst_no, 0, 2) . '">';
    echo $html;
  }


  public function viewPOMail(Request $request)
  {
    $id = $request->id;
    $html = '';

    $html .= '<div class="text-center mb-4">
          <h3 class="mb-2">Send Po Mail</h3>
        </div>
        <form id="addPermissionForm" action="' . route('storeInvoiceDetails') . '" class="row" method="post">
          <div class="col-12 mb-3">
            <label class="form-label" for="modalPermissionName">Email</label>
            <input type="email" required id="email" name="email" class="select2 form-control"
                    data-allow-clear="true"/>
          </div>
          <div class="col-12 text-center demo-vertical-spacing">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
          </div>
          <input type="hidden" name="id" value="' . $id . '">
          <input type="hidden" name="_token" id="csrf-token" value="' . Session::token() . '" />
        </form>';
    echo $html;
  }

  public function storeInvoiceDetails(Request $request)
  {
    $id = $request->id;
    $status = $request->invoice_status;

    Invoice::where('id', $id)->update([
      "status" => $status,
    ]);
    return redirect()->action([InvoiceList::class, 'index']);
  }


  public function getCompanyDetails(Request $request)
  {
    $companyId = $request->company_id;
    $html = '';
    $html1 = '';
    $company = Company::with(['User'])->where('id', $companyId)->first();

    $html .= '   <div class="col-md-6 col-sm-5 col-12 mb-sm-0 mb-4">
                <h6 class="mb-4">Bill To:</h6>
                <p class="mb-1">' . $company->b_name . '</p>
                <p class="mb-1">' . $company->b_address1 . ', ' . $company->b_address2 . '</p>
                <p class="mb-1">' . $company->b_city . ', ' . $company->b_state . '</p>
                <p class="mb-1">' . $company->b_mobile . '</p>
                <p class="mb-0">' . $company->b_email . '</p>
                <p class="mb-0">GST No. : ' . $company->pancard_gst_no . '</p>
              </div>';
    $html1 .= ' <div class="col-md-6 col-sm-7">
                <h6 class="mb-4">Ship To:</h6>
                 <p class="mb-1">' . $company->s_name . '</p>
                <p class="mb-1">' . $company->s_address1 . ', ' . $company->s_address2 . '</p>
                <p class="mb-1">' . $company->s_city . ', ' . $company->s_state . '</p>
                <p class="mb-1">' . $company->s_mobile . '</p>
                <p class="mb-0">' . $company->s_email . '</p>
              </div>';
    $html .= '<input type="hidden" name="c_gst_two" id="c_gst_two" value="' . substr($company->pancard_gst_no, 0, 2) . '">';

    $result['billto'] = $html;
    $result['shipto'] = $html1;
    echo json_encode($result);
  }


  public function getDeniMaxPo()
  {
    $token = Controller::getDeniMaxToken();
    $client = new \GuzzleHttp\Client();
    $responseDataResult = $client->post(
      'http://103.92.122.78:8080/denimaxone/api/order/getorders',
      [
        'form_params' => [
          "orderStatusDesc" => "history",
          "fromDate" => date('Y-m-d', strtotime('-90 days')) . "T18:30:00.000Z",
          "toDate" => date('Y-m-d') . "T18:30:00.000Z"
        ],
        'headers' => [
          'Authorization' => 'Bearer ' . $token . ''
        ],
      ]
    );
    $responseDatas = json_decode($responseDataResult->getBody()->getContents());
    if (!empty($responseDatas)) {
      foreach ($responseDatas as $responseData) {

        $vendorName = $responseData->vendorName;
        $isCancelled = $responseData->isCancelled;
        $user = User::where('company_name', $vendorName)->first();
        if ($user) {
          $user_id = $user->id;
        } else {
          $user = new User([
            'company_name' => $vendorName,
            'role' => "vendor",
          ]);
          $user->save();
          $user_id = $user->id;

          $userAddress = new UserAddress([
            'user_id' => $user_id,
          ]);
          $userAddress->save();
          $userBank = new UserBank([
            'user_id' => $user_id,
          ]);
          $userBank->save();

        }
        $checkPo = Po::where('denimax_po_id', $responseData->id)->first();
        if (!$checkPo) {
          if ($isCancelled == false) {
            $po = new Po([
              'user_id' => $user_id,
              'denimax_po_id' => $responseData->id,
              'po_no' => $responseData->id,
              'po_date' => date('Y-m-d', strtotime($responseData->placedDate)),
              'is_approve' => 1,
              'company_id' => 2,
              'po_amount' => $responseData->orderAmount,
              'sub_total_amount' => $responseData->orderAmount,
              'discount_amount' => 0,
              'igst_amount' => 0,
              'sgst_amount' => 0,
              'cgst_amount' => 0,
              'b_mobile' => "",
              'note' => "",
            ]);
            $result = $po->save();
            if ($result) {
              $poId = $po->id;
              $poItem = new PoItem([
                'po_id' => $poId,
                'item_name' => $responseData->rmName,
                'item_description' => $responseData->rmName,
                'hsn' => "",
                'rate' => $responseData->itemPrice,
                'qty' => $responseData->quantity, //quantity
                'uom' => $responseData->measurement,
                'excessInwardAllowedPercent' => $responseData->excessInwardAllowedPercent,
                'amount' => $responseData->orderAmount
              ]);
              $poItem->save();
            } else {
              return response()->json(['status' => 'error', 'message' => 'Provide proper details']);
            }
          }
        }
      }
      return back()->with('success', __('Your Data Saved Successfully!!!'));
    } else {
      return back()->withError('Data Not Found OR Data is Uptodate')->withInput();
    }
  }

  public function poAddView()
  {
    $Item = Item::with("ItemSubCategory")->orderBy('id', 'asc')->get();
    $ShippingAddress =  CompanyShipAddress::orderBy('id', 'asc')->get();
    $Users =  User::with("UserAddress")->where('vendor_type','SUPPLIER')->orderBy('id', 'asc')->get();
    // $VendorSupplier = $Users->toArray();
    return view('content.apps.app-po-add',compact("Item",'ShippingAddress','Users'));
  }

  public function poAddStore(Request $request)
  {
    $request->validate([
      'po_number' => 'required|string|max:250',
      'po_date' => 'required',
    ]);

    if (empty($request['group-a'][0]['item_name'])) {
      return redirect()->action([POManage::class, 'poAddView'])->withErrors('you are not add any items!');
    }

    $poCheck = Po::where('po_no', $request->po_number)->first();
    if ($poCheck) {
      return redirect()->action([POManage::class, 'poAddView'])->withErrors('PO Number Already Exit!');
    }

    if(empty($request->vendor_id)){
      $VendorShipping=null;
    }else{
      $VendorShipping=$request->vendor_id;
    }

    if(empty($request->shipping_id)){
      $shippingId=null;
    }else{
      $shippingId=$request->shipping_id;
    }

    // dd($request);
    $po = new Po([
      'user_id' => $request->user_id,
      'po_no' => $request->po_number,
      'po_date' => $request->po_date,
      'd_date' => $request->d_date,
      'company_id' => $request->company_id,
      'company_shipping_id' => $shippingId,
      'vendor_shiping_id'=> $VendorShipping,
      'po_amount' => $request->po_amount,
      'sub_total_amount' => $request->sub_total_amount,
      'discount_amount' => 0,
      'igst_amount' => $request->igst_amount,
      'sgst_amount' => $request->sgst_amount,
      'cgst_amount' => $request->cgst_amount,
      't_charge' => $request->t_charge,
      't_tax' => $request->t_tax,
      't_amount' => $request->t_amount,
      'note' => $request->note,
    ]);
    $result = $po->save();
    if ($result) {
      $poId = $po->id;

      $company = Company::with(['User'])->where('id', $request->company_id)->first();
      if ($company) {
        $poNo = $company->po_no_set;
        Company::where('id', $company->id)->update([
          "po_no_set" => intval($poNo) + 1
        ]);
      }

      // dd($request['group-a']);
      $temp=1;
      if (count($request['group-a']) > 0) {
        foreach ($request['group-a'] as $item) {

          $parts = explode('_', $item['item_name']);
            if (isset($parts[0]) && isset($parts[1])) {
                $poItem = new PoItem([
                    'po_id' => $poId,
                    'item_id' => $parts[0],
                    'item_name' => $parts[1],
                    'item_description' => $item['item_description'],
                    'excessInwardAllowedPercent' => $item['excessInwardAllowedPercent'],
                    'hsn' => $item['hsn'],
                    'rate' => $item['rate'],
                    'qty' => $item['qty'],
                    'without_tax_amount' => $item['itemAmountWithRateQty'],
                    'tax' => $item['taxValue'],
                    'tax_percentage' => isset($item['tax']) ? $item['tax'] : 0,
                    'uom' => $item['uom'],
                    'amount' => $item['amount']
                ]);
                $poItem->save();
            }
        }
      }
      // dd($temp);

      if ($request->po_file) {
        $this->validate(request(), [
          'po_file.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->po_file;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/po/' . $poId . '/');
        if (!is_dir(public_path('/po'))) {
          mkdir(public_path('/po'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);
        Po::where('id', $poId)->update([
          "po_file" => $new_file_name,
        ]);
      }

      return redirect()->action([POManage::class, 'index'])->withSuccess('You have done successfully');
    } else {
      return response()->json(['status' => 'error', 'message' => 'Provide proper details']);
    }
  }

  public function show($id)
  {
    $po = Po::with(["Company", "PoItem.GrnItem","CompanyShipAddress","UserAddress.User"])->where('id', $id)->first();
    // dd($po->toArray());
    return view('content.apps.app-po-preview', compact("po"));
  }

  public function edit($id)
  {
    $po = Po::with(["Company", "PoItem", "User"])->where('id', $id)->first();
    return view('content.apps.app-po-edit', compact("po"));
  }

  public function update(Request $request, $id)
  {

    $request->validate([
      'po_number' => 'required|string|max:250',
      'po_date' => 'required',
    ]);

    if (empty($request['group-a'][0]['item_name'])) {
      return redirect()->action([POManage::class, 'poAddView'])->withErrors('you are not add any items!');
    }
    //dd($request);

    $po = Po::where('id', $id)->update([
      'user_id' => $request->user_id,
      'po_no' => $request->po_number,
      'po_date' => $request->po_date,
      'd_date' => $request->d_date,
      'company_id' => $request->company_id,
      'po_amount' => $request->po_amount,
      'sub_total_amount' => $request->sub_total_amount,
      'discount_amount' => 0,
      'igst_amount' => $request->igst_amount,
      'sgst_amount' => $request->sgst_amount,
      'cgst_amount' => $request->cgst_amount,
      't_charge' => $request->t_charge,
      't_tax' => $request->t_tax,
      't_amount' => $request->t_amount,
      'note' => $request->note,
    ]);
    if ($po) {
      $poId = $id;
      if (count($request['group-a']) > 0) {
        foreach ($request['group-a'] as $item) {
          $po_item_id = $item['po_item_id'];
          if (!empty($po_item_id)) {
            //dd($item['uom']);
            PoItem::where('id', $po_item_id)->update([
              'po_id' => $poId,
              'item_name' => $item['item_name'],
              'item_description' => $item['item_description'],
              'excessInwardAllowedPercent' => $item['excessInwardAllowedPercent'],
              'hsn' => $item['hsn'],
              'rate' => $item['rate'],
              'qty' => $item['qty'],
              'without_tax_amount' => $item['itemAmountWithRateQty'],
              'tax' => $item['taxValue'],
              'tax_percentage' => $item['tax'],
              'uom' => $item['uom'],
              'amount' => $item['amount']
            ]);
          } else {
            $poItem = new PoItem([
              'po_id' => $poId,
              'item_name' => $item['item_name'],
              'item_description' => $item['item_description'],
              'excessInwardAllowedPercent' => $item['excessInwardAllowedPercent'],
              'hsn' => $item['hsn'],
              'rate' => $item['rate'],
              'without_tax_amount' => $item['itemAmountWithRateQty'],
              'tax' => $item['taxValue'],
              'tax_percentage' => $item['tax'],
              'qty' => $item['qty'],
              'uom' => $item['uom'],
              'amount' => $item['amount']
            ]);
            $poItem->save();
          }
        }
      }

      if ($request->po_file) {
        $this->validate(request(), [
          'po_file.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->po_file;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/po/' . $poId . '/');
        if (!is_dir(public_path('/po'))) {
          mkdir(public_path('/po'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);
        Po::where('id', $poId)->update([
          "po_file" => $new_file_name,
        ]);
      }
      return redirect()->action([POManage::class, 'index'])->withSuccess('Data Update successfully');
    } else {
      return redirect()->action([POManage::class, 'index'])->withErrors('Data Update successfully');
    }
  }

  public function printPO($id)
  {
    // $po = Po::with(["Company","CompanyShipAddress"])->where('id', $id)->first();
    $po = Po::with(["Company", "PoItem.GrnItem","CompanyShipAddress","UserAddress.User"])->where('id', $id)->first();
    return view('content.apps.app-po-print', compact("po"));
  }

  public function printPO2($id)
  {
    $po = Po::with(["Company"])->where('id', $id)->first();
    return view('content.apps.app-po-print2', compact("po"));
  }

  public function poApprove(Request $request)
  {
    $id = $request->id;

    $po = Po::with(["User.UserAddress", "PoItem"])->where("id", $id)->first();
    Po::where('id', $id)->update([
      'is_approve' => 1,
    ]);
    //dd($po);
    // Send the email
    if ($po) {
      $pdf = PDF::loadView('content.apps.app-po-pdf', compact("po"));
      //return $pdf->output();
      if (!empty($po->User->email)) {
        Mail::send('content.apps.app-po-approval-mail', ['name' => $po->User->person_name, $po], function ($message) use ($po, $pdf) {
          $message->to($po->User->email)
            ->subject('Approve Successfully')
            ->attachData($pdf->output(), 'PO-Approved.pdf', [
              'mime' => 'application/pdf',
            ]);
          if (!empty($po->Company->b_email)) {
            $message->cc([$po->Company->b_email]);
          }
        });
      }
    }
    echo 'success';
  }

}
