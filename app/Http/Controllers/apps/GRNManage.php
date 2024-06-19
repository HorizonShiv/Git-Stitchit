<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Http\Controllers\masters\ItemMaster;
use App\Models\Company;
use App\Models\GrnItem;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Po;
use App\Models\PoItem;
use App\Models\Setting;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

use App\Models\UserAddress;
use App\Models\UserBank;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class GRNManage extends Controller
{
  public function index()
  {
    return view('content.apps.app-grn-list');
  }

  public function grnListing(Request $request)
  {
    // dd($request->all());
    $grnItems = GrnItem::with('User');

    if (!empty($request->warehouse_id)) {
      $grnItems->where('warehouse_master_id', $request->warehouse_id);
    }
    if (!empty($request->item_id)) {
      $grnItems->where('item_master_id', $request->item_id);
    }

    if (!empty($request->vendor_id)) {
      $grnItems->where('supplier_id', $request->vendor_id);
    }

    if (!empty($request->type)) {
      if ($request->type == 1) {
        $grnItems->whereNotNull('po_item_id');
      } else {
        $grnItems->whereNull('po_item_id');
      }
    }

    if (!empty($request->category_id)) {
      $grnItems->whereHas('item.ItemCategory', function ($query) use ($request) {
        $query->where('id', $request->category_id);
      });
    }

    if (!empty($request->subCategory_id)) {
      $grnItems->whereHas('item.ItemSubCategory', function ($query) use ($request) {
        $query->where('id', $request->subCategory_id);
      });
    }
    $filteredGrnItem = $grnItems->get();


    $num = 1;
    $result = array("data" => array());
    foreach ($filteredGrnItem as $grnItem) {

      // Script for fetching Item Id , rate and supplier id from purchase order table
      // $PoItems = PoItem::where('id', $grnItem->po_item_id)->get();
      // foreach ($PoItems as $poitem) {

      //   GrnItem::where('id', $grnItem->id)->update([
      //     'item_master_id' => $poitem->item_id,
      //     'rate' => $poitem->rate,
      //     'supplier_id' =>  $grnItem->PoItem->Po->user_id,
      //   ]);
      // }

      if (!empty($grnItem->PoItem->Po->id)) {
        $poNumber = ' - <a href="/app/po/preview/' . $grnItem->PoItem->Po->id . '">' . $grnItem->PoItem->Po->po_no . '</a>';
        $statusOfPo = '<span class="badge rounded bg-label-success">With Po</span>';
      } else {
        $poNumber = '';
        $statusOfPo = '<span class="badge rounded bg-label-primary">Without Po</span>';
      }

      $rate = $grnItem->rate;

      $Rollback = '<button type="button" class="btn btn-icon btn-label-warning mx-2" onclick="rollbackGrnItem(' . $grnItem->id . ')"><i class="ti ti-arrow-back-up-double mx-2 ti-sm"></i></button>';


      $grnPoIndex = $grnItem->grn_no . '' . $poNumber;

      if (!empty($grnItem->PoItem)) {
        $companyName = $grnItem->PoItem->Po->User->company_name;
        $personName = $grnItem->PoItem->Po->User->person_name;
        $personMobile = $grnItem->PoItem->Po->User->person_mobile;
        $avatar = substr($grnItem->PoItem->Po->User->company_name, 0, 2);
      } else {
        $companyName = $grnItem->User->company_name;
        $personName = $grnItem->User->person_name;
        $personMobile = $grnItem->User->person_mobile;
        $avatar = substr($grnItem->User->company_name, 0, 2);
      }

      $vendor = '<div class="d-flex justify-content-start align-items-center">
                    <div class="avatar-wrapper">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded-circle bg-label-info">
                            ' . $avatar . '
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="fw-medium">
                        ' . $companyName . '
                        </span>
                        <small class="text-truncate text-muted">
                        ' . $personName . '
                        </small>
                        <small class="text-truncate text-muted">
                        ' . $personMobile . '
                        </small>
                    </div>
                </div>';

      $grnDate = date('D, d M Y', strtotime($grnItem->date));

      if (!empty($grnItem->PoItem)) {
        $item = $grnItem->PoItem->item_name;
      } else {
        $item = $grnItem->Item->name;
      }

      $grnQty = $grnItem->qty;

      $invoiceNumber = $grnItem->invoiceNumber . '<br/><span class="text-secondary">' . $grnItem->challanNumber . '</span>';

      $remark = $grnItem->remark;



      array_push($result["data"], array($num, $grnPoIndex, $vendor, $grnDate, $item, $grnQty, $rate, $statusOfPo, $invoiceNumber, $remark, $Rollback));
      $num++;
    }
    echo json_encode($result);
  }

  public function getPODetailForGRN(Request $request)
  {
    if (!empty($request->poNo)) {
      $poItems = PoItem::where('po_id', $request->poNo)->get();
      $check_num = 1;
      $html = "";

      foreach ($poItems as $poItem) {
        $grnQty = GrnItem::where('po_item_id', $poItem->id)->sum('qty');
        $pendingDispatch = ($poItem->qty - $grnQty);
        $html .= '<tr id="option-value-row' . $check_num . '">';
        $html .= '  <td>' . $check_num . '</td>';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input type="text" readonly name="option_value[' . $check_num . '][item]" value="' . $poItem->item_name . '" placeholder="SKU NO" class="form-control" />';
        $html .= '      <input type="hidden" readonly name="option_value[' . $check_num . '][id]" value="' . $poItem->id . '" />';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input type="text" name="option_value[' . $check_num . '][poQty]"  placeholder="Po Number" value="' . $poItem->qty . '" class="form-control" readonly />';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input type="text" name="option_value[' . $check_num . '][recQty]"  placeholder="recQty" value="' . $grnQty . '" class="form-control" readonly />';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input type="text" name="option_value[' . $check_num . '][rQty]"  placeholder="rQty" value="' . $pendingDispatch . '" class="form-control" readonly />';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input required type="number" name="option_value[' . $check_num . '][qty]" id="qty' . $check_num . '"  placeholder="Qty" class="form-control" required />';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '</tr>';
        $check_num++;
      }
      echo json_encode($html);
    }
  }

  public function grnAddView()
  {
    $pos = Po::with("User")->where("is_approve", "1")->orderBy('id', 'desc')->get();
    $Item = Item::with("ItemSubCategory")->orderBy('id', 'asc')->get();
    $Suppliers = User::where('vendor_type', 'SUPPLIER')->orderBy('id', 'asc')->get();
    return view('content.apps.app-grn-add', compact("pos", "Item", "Suppliers"));
  }

  public function grnAddStore(Request $request)
  {
    $request->validate([
      // 'poNo' => 'required|string|max:250',
      'date' => 'required',
    ]);
    $userID = Auth::id();

    $date = $_REQUEST['date'];
    $remark = $_REQUEST['remark'];

    $Setting = Setting::orderBy('id', 'desc')->first();
    $GRNDetails = $Setting->toArray();


    $grnCount = $GRNDetails['gnr_no_set'] + 1;
    $grnNo = $GRNDetails['grn_pre_fix'] . '' . $grnCount;


    if ($request->WithOutPO != 1) { //Check With Out PO or Not
      $request->validate([
        'poNo' => 'required',
      ]);
      $option_values = $_REQUEST['option_value'];
      if (empty($option_values)) {
        if (empty($request['option_value'][1]['qty'])) {
          return redirect()->action([GRNManage::class, 'grnAddView'])->withErrors('you are not add any items!');
        }
      }
      if (count($option_values) > 0) {
        foreach ($option_values as $option_value) {

          if ($option_value['qty'] > 0) {

            $PoItem = PoItem::where('id', $option_value['id'])->first();
            $Po = Po::where('id', $PoItem->po_id)->first();
            $grnItem = new GrnItem([
              'po_item_id' => $option_value['id'],
              // 'item_name' => $option_value['item'],
              'warehouse_master_id' => $request->SelectWarehouse,
              'item_master_id' => $PoItem->item_id,
              'supplier_id' => $Po->user_id,
              'rate' => $PoItem->rate,
              'qty' => $option_value['qty'],
              'date' => $date,
              'grn_no' => $grnNo,
              'challanNumber' => $_REQUEST['challanNumber'],
              'invoiceNumber' => $_REQUEST['invoiceNumber'],
              'remark' => $remark,
            ]);
            $grnItem->save();
            $grnItemId = $grnItem->id;

            $POitems = PoItem::where('id', $option_value['id'])->first();

            $existingRates = Inventory::where('item_id', $POitems->item_id)->first();

            if ($existingRates !== null) {

              $OldTotalWithRate = $existingRates->total * $existingRates->avg_rate;
              $NewTotalWithRate = $option_value['qty'] * $POitems->rate;

              $Total = $existingRates->total + $option_value['qty'];
              $GoodInventory = $existingRates->good_inventory + $option_value['qty'];

              $AvgRate = ($OldTotalWithRate + $NewTotalWithRate) / $Total;

              $Inventory = Inventory::where('id', $existingRates->id)->update([
                'total' => $Total,
                'good_inventory' => $GoodInventory,
                'avg_rate' => $AvgRate,
                'last_instock_date' => Carbon::now()->format('Y-m-d'),
                'updated_date' => date('Y-m-d'),
              ]);

              $InventoryHistory = new InventoryHistory([
                'grnitem_id' => $grnItemId,
                'inventory_id' => $existingRates->id,
                'warehouse_master_id' => $request->SelectWarehouse,
                'user_id' => $userID,
                'item_id' =>  $POitems->item_id,
                'type' => 'Change',
                'qty' => $option_value['qty'],
                'rate' => $POitems->rate,
                'inventoryGood' => $option_value['qty'],
                'inventoryAllotted' => $existingRates->allotted_inventory,
                'inventoryRequired' => $existingRates->required_inventory,
                'created_date' => date('Y-m-d'),
              ]);
              $InventoryHistory->save();
            } else {

              $Inventory = new Inventory([
                'warehouse_master_id' => $request->SelectWarehouse,
                'item_id' => $POitems->item_id,
                'total' => $option_value['qty'],
                'good_inventory' => $option_value['qty'],
                'avg_rate' => $POitems->rate,
                'created_date' => date('Y-m-d'),
                'last_instock_date' => Carbon::now()->format('Y-m-d'),
              ]);
              $Inventory->save();
              $InventoryId = $Inventory->id;

              $InventoryHistory = new InventoryHistory([
                'grnitem_id' => $grnItemId,
                'inventory_id' => $InventoryId,
                'warehouse_master_id' => $request->SelectWarehouse,
                'user_id' => $userID,
                'item_id' => $option_value['id'],
                'type' => 'Add',
                'qty' => $option_value['qty'],
                'rate' => $POitems->rate,
                'inventoryGood' => $option_value['qty'],
                'created_date' => date('Y-m-d'),
              ]);
              $InventoryHistory->save();
            }
          }
        }
      } else {
        return redirect()->action([GRNManage::class, 'index'])->withErrors('Error Occurred!');
      }
    } else {
      $request->validate([
        'Supplier' => 'required',
      ]);
      if (!empty($request['item'])) {
        if (count($request['item']) > 0) {
          foreach ($request['item'] as $Key => $Item) {
            $GrnItem = new GrnItem([
              'warehouse_master_id' => $request->SelectWarehouse,
              'date' => $date,
              'item_master_id' => $Item,
              'supplier_id' => $request->Supplier,
              'qty' => $request['qty'][$Key],
              'rate' => $request['rate'][$Key],
              'grn_no' => $grnNo,
              'challanNumber' => $_REQUEST['challanNumber'],
              'invoiceNumber' => $_REQUEST['invoiceNumber'],
              'remark' => $remark,
            ]);
            $GrnItem->save();
            $grnItemId = $GrnItem->id;

            $existingRates = Inventory::where('item_id', $Item)->first();

            if ($existingRates !== null) {

              $OldTotalWithRate = $existingRates->total * $existingRates->avg_rate;
              $NewTotalWithRate = $request['qty'][$Key] * $request['rate'][$Key];

              $Total = $existingRates->total + $request['qty'][$Key];
              $GoodInventory = $existingRates->good_inventory + $request['qty'][$Key];

              $AvgRate = ($OldTotalWithRate + $NewTotalWithRate) / $Total;

              $Inventory = Inventory::where('id', $existingRates->id)->update([
                'total' => $Total,
                'good_inventory' => $GoodInventory,
                'avg_rate' => $AvgRate,
                'updated_date' => date('Y-m-d'),
              ]);

              $InventoryHistory = new InventoryHistory([
                'grnitem_id' => $grnItemId,
                'inventory_id' => $existingRates->id,
                'warehouse_master_id' => $request->SelectWarehouse,
                'user_id' => $userID,
                'item_id' => $Item,
                'type' => 'Change',
                'qty' => $request['qty'][$Key],
                'rate' => $request['rate'][$Key],
                'inventoryGood' => $request['qty'][$Key],
                'inventoryAllotted' => $existingRates->allotted_inventory,
                'inventoryRequired' => $existingRates->required_inventory,
                'created_date' => date('Y-m-d'),
              ]);
              $InventoryHistory->save();
            } else {

              $Inventory = new Inventory([
                'warehouse_master_id' => $request->SelectWarehouse,
                'item_id' => $Item,
                'total' => $request['qty'][$Key],
                'good_inventory' => $request['qty'][$Key],
                'avg_rate' => $request['rate'][$Key],
                'created_date' => date('Y-m-d'),

              ]);
              $Inventory->save();
              $InventoryId = $Inventory->id;

              $InventoryHistory = new InventoryHistory([
                'grnitem_id' => $grnItemId,
                'inventory_id' => $InventoryId,
                'warehouse_master_id' => $request->SelectWarehouse,
                'user_id' => $userID,
                'item_id' => $Item,
                'type' => 'Add',
                'qty' => $request['qty'][$Key],
                'rate' => $request['rate'][$Key],
                'inventoryGood' => $request['qty'][$Key],
                'created_date' => date('Y-m-d'),
              ]);
              $InventoryHistory->save();
            }
          }
        }
      } else {
        return redirect()->action([GRNManage::class, 'grnAddView'])->withErrors('Item was not selected');
      }
    }
    $Setting = Setting::where('id', $GRNDetails['id'])->update([
      'gnr_no_set' => $grnCount,
    ]);

    if ($request->AddMore) {
      return redirect()->action([GRNManage::class, 'grnAddView'])->withSuccess('Done Successfully!');
    } else {
      return redirect()->action([GRNManage::class, 'index'])->withSuccess('Done Successfully!');
    }
  }

  public function getGRNQtyByOrderInward()
  {
    $token = Controller::getDeniMaxToken();
    for ($i = 1; $i <= 3; $i++) {
      $client = new \GuzzleHttp\Client();

      //      "from" => date('Y-m-d', strtotime('-30 days')) . "T18:30:00.000Z",
      //            "to" => date('Y-m-d', strtotime('-30 days')) . "T18:30:00.000Z",

      $responseDataResult = $client->post(
        "http://103.92.122.78:8080/denimaxone/api//inventory/getstoremovements",
        [
          'form_params' => [
            "from" => date('Y-m-d', strtotime('-35 days')) . "T18:30:00.000Z",
            "to" => date('Y-m-d', strtotime('-10 days')) . "T18:30:00.000Z",
            "storeLocationId" => $i
          ],
          'headers' => [
            'Authorization' => 'Bearer ' . $token . ''
          ],
        ]
      );
      $responseDatas = json_decode($responseDataResult->getBody()->getContents());
      //dd($responseDatas);
      if (!empty($responseDatas)) {
        foreach ($responseDatas as $responseData) {
          if ($responseData->eventType == "Order Inward" && !empty($responseData->eventId)) {
            $checkGrn = GrnItem::where('printNumber', $responseData->eventId)->first();
            if (!$checkGrn && !empty($responseData->orderId)) {

              $poItem = PoItem::where('po_no', $responseData->orderId)->where('item_name', $responseData->material)
                ->select('purchase_order_items.*', 'purchase_orders.po_no', 'purchase_orders.id as po_id')
                ->leftJoin('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_items.po_id')
                ->first();

              if ($poItem && ($poItem->po_no == $responseData->orderId)) {
                $po_item_id = $poItem->id;
                $g_date = date('Y-m-d', strtotime($responseData->sortDate));
                $g_qty = $responseData->quantity;
                $g_po_number = $responseData->orderId;

                $getInvoiceChallanByPOs = $this->getInvoiceChallanByPO($responseData->orderId, $token);
                if (!empty($getInvoiceChallanByPOs)) {
                  if (isset($getInvoiceChallanByPOs->inwardOutwards)) {
                    foreach ($getInvoiceChallanByPOs->inwardOutwards as $inwardOutward) {

                      $po_g_date = date('Y-m-d', strtotime($inwardOutward->sortDate));
                      $po_g_qty = $inwardOutward->quantity;
                      $po_g_po_number = $inwardOutward->orderId;

                      if (($g_po_number == $po_g_po_number) && ($g_qty == $po_g_qty) && ($g_date == $po_g_date)) {
                        $grn = new GrnItem([
                          'printNumber' => $responseData->eventId,
                          'invoiceNumber' => $inwardOutward->invoiceNumber,
                          'challanNumber' => $inwardOutward->challanNumber,
                          'qty' => $g_qty,
                          'remark' => 'Vendor Name : ' . $responseData->vendorName,
                          'date' => $g_date,
                          'po_no' => $g_po_number,
                          'po_item_id' => $po_item_id
                        ]);
                        $grn->save();
                      }
                    }
                  }
                } else {
                  // single po not found
                }
              }
            }
          }
        }
        //return back()->with('success', __('Your Data Saved Successfully!!!'));
      } else {
        //return back()->withError('Data Not Found OR Data is Uptodate')->withInput();
      }
    }
  }

  public function getInvoiceChallanByPO($poNo, $token)
  {
    $client = new \GuzzleHttp\Client();
    $responseDataResult = $client->get(
      "http://103.92.122.78:8080/denimaxone/api/order/getorder/{$poNo}",
      [
        'headers' => [
          'Authorization' => 'Bearer ' . $token . ''
        ],
      ]
    );
    return json_decode($responseDataResult->getBody()->getContents());
  }

  public function grnRollback(Request $request)
  {
    if (!empty($request->grnId)) {
      $InventoryHistory = InventoryHistory::where('grnitem_id', $request->grnId)->first();
      if (!empty($InventoryHistory)) {
        $Inventory = Inventory::where('item_id', $InventoryHistory->item_id)->first();


        // Finding Rate for previous and history rate wise qty
        $OldTotalWithRate = $Inventory->total * $Inventory->avg_rate;
        $NewTotalWithRate = $InventoryHistory->qty * $InventoryHistory->rate;

        //Calculating Qty by removing it from inventory
        $newInventoryTotalQty = $Inventory->total - $InventoryHistory->qty;
        $newInventoryGoodQty = $Inventory->good_inventory - $InventoryHistory->qty;

        if (!$newInventoryTotalQty == 0) {
          $NewAvgRate = ($OldTotalWithRate - $NewTotalWithRate) / $newInventoryTotalQty;
          $Inventory = Inventory::where('item_id', $InventoryHistory->item_id)->update([
            'total' => $newInventoryTotalQty,
            'good_inventory' => $newInventoryGoodQty,
            'avg_rate' => $NewAvgRate,
            'updated_date' => date('Y-m-d'),
          ]);
        } else {
          $Inventory = Inventory::where('item_id', $InventoryHistory->item_id)->delete();
        }

        $InventoryHistory = InventoryHistory::where('grnitem_id', $request->grnId)->delete();
        $GrnItem = GrnItem::where('id', $request->grnId)->delete();

        if ($Inventory) {
          return response()->json(['success' => true]);
        } else {
          return response()->json(['success' => false]);
        }
      }
      return response()->json(['success' => false]);
    } else {
      return response()->json(['success' => false]);
    }
  }
}
