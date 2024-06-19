<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\WareHouse;
use App\Models\JobOrders;
use App\Models\Outward;
use App\Models\OutwardParameter;
use App\Models\WarehouseTransfer;
use App\Models\WarehouseTransferParameter;
use App\Models\GrnItem;
use App\Models\GrToSupplier;
use App\Models\GrToSupplierParameter;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\WarehouseInward;
use App\Models\WarehouseInwardParameter;
use App\Models\Item;
use App\Models\PlaningOrderMaterials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\apps\Master;
use App\Models\Po;

class WareHouseController extends Controller
{
  /**
   * Display a listing of the resource.
   */


  public function getOutwardData(Request $request)
  {
    if (!empty($request->challanNumber)) {
      $WarehouseTransfer = WarehouseTransfer::with('WarehouseTransferParameter.Item')->where('id', $request->challanNumber)->first();
      $Item = Item::all();
      $check_num = 1;
      $html = "";


      // dd($WarehouseTransfer);

      foreach ($WarehouseTransfer->WarehouseTransferParameter as $Parameter) {
        $html .= '<tr id="option-value-row' . $check_num . '">';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input type="text" readonly name="warehouseParamterName[' . $check_num . ']" value="' . $Parameter->warehouse_transfer_id . '" class="form-control"  hidden/>';
        $html .= '      <input type="text" readonly name="itemId[' . $check_num . ']" value="' . $Parameter->Item->id . '" class="form-control" hidden />';
        $html .= '      <input type="text" readonly name="itemName[' . $check_num . ']" value="' . $Parameter->Item->name . '" class="form-control" />';
        // $html .= '      <select disabled class="select2 form-select form-control" name="item[]"><option value="">Select Item</option>';
        // foreach ($Item as $itemData) {
        //   $html .= '<option ' . ($itemData->id == $Parameter->item_id ? 'Selected ' : '') . 'value="' . $itemData->id . '">' . $itemData->name . '</option>';
        // }

        // $html .= '      </select>';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input type="text" id="TransferQty_' . $check_num . '" name=TransferQty[' . $check_num . ']""  placeholder="Transfer Qty" value="' . $Parameter->qty . '" class="form-control" readonly />';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input type="text" name="Rate[' . $check_num . ']"  placeholder="Rate" value="' . $Parameter->rate . '" class="form-control" />';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input type="number" onkeyup="validateQty(' . $check_num . ')" id="Qty_' . $check_num . '" name="InwardQty[' . $check_num . ']"  placeholder="Inward Qty" value="" class="form-control" />';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '</tr>';
        $check_num++;
      }
      echo json_encode($html);
    }
  }



  public function warehouseInwardList()
  {
    $Warehouseinwards = Warehouseinward::with('User', 'WarehouseInwardParameter.Item', 'WareHouseFrom', 'WareHouseTO')->get();
    return view('content.warehouse-master.warehouse-inward-list', compact('Warehouseinwards'));
  }


  public function warehouseTransfer()
  {
    return view('content.warehouse-master.warehouse-transfer');
  }

  public function warehouseInward()
  {
    return view('content.warehouse-master.warehouse-inward');
  }

  public function warehouseTransferList()
  {
    $WarehouseTransfers = WarehouseTransfer::with('User', 'WareHouseFrom', 'WarehouseTransferParameter.Item', 'WareHouseTO')->get();
    // $WarehouseTransfers = WarehouseTransfer::with('User', 'WareHouseFrom', 'WarehouseTransferParameter.Item', 'WareHouseTO')->where('inward_status', 'pending')->get();
    return view('content.warehouse-master.warehouse-transfer-list', compact('WarehouseTransfers'));
  }

  public function warehouseOutward()
  {
    return view('content.warehouse-master.warehouse-outward');
  }
  public function warehouseOutwardList()
  {
    $Outwards = Outward::with('User', 'Department', 'OutwardParameter.Item', 'WareHouse', 'UserInfo')->get();
    return view('content.warehouse-master.warehouse-outward-list', compact('Outwards'));
  }

  public function grSupplier()
  {
    return view('content.warehouse-master.gr-supplier');
  }

  public function grSupplierList()
  {
    $GrToSuppliers = GrToSupplier::with('User', 'WareHouse', 'GrToSupplierParameter.Item', 'UserInfo')->get();
    return view('content.warehouse-master.gr-supplier-list', compact('GrToSuppliers'));
  }


  public function index()
  {
    $WareHouses = WareHouse::all();
    return view('content.warehouse-master.list', compact('WareHouses'));
  }

  public function warehouseView()
  {
    return view('content.apps.app-warehouse-view');
  }

  public function getGrnItemForWarehouse(Request $request)
  {
    $GrnItem = GrnItem::with('Item')->where('grn_no', $request->grnNo)->get();
    return response()->json(['success' => true, 'GrnItem' => $GrnItem]);
  }

  public function addWareHouseInward(Request $request)
  {
    $this->validate(request(), [
      'ChallanNumber' => 'required',
      'InWarehouse' => 'required',
    ]);

    if (!empty($request->InWarehouse)) {
      $userID = Auth::id();

      $WarehouseInward = new WarehouseInward([
        'date' => $request->date,
        'warehouse_transfer_id' => $request->ChallanNumber,
        'warehouse_id' => $request->InWarehouse,
        'remark' => $request->remark,
        'user_id' => $userID,
      ]);
      $WarehouseInward->save();


      if ($WarehouseInward) {
        $WarehouseInwardId = $WarehouseInward->id;

        foreach ($request->itemId as $key => $itemId) {
          $WarehouseInwardParameter = new WarehouseInwardParameter([
            'warehouse_inward_id' => $WarehouseInwardId,
            'item_id' => $itemId,
            'transfered_qty' => $request->TransferQty[$key],
            'rate' => $request->Rate[$key],
            'inward_qty' => $request->InwardQty[$key],
            'user_id' => $userID,
          ]);
          $WarehouseInwardParameter->save();



          $Inventory = Inventory::where('item_id', $itemId)->first();

          $OldTotalWithRate = $Inventory->total * $Inventory->avg_rate;
          $NewTotalWithRate = $request->InwardQty[$key] * $request->Rate[$key];

          $Total = $Inventory->total + $request->InwardQty[$key];
          $GoodInventory = $Inventory->good_inventory + $request->InwardQty[$key];

          $AvgRate = ($OldTotalWithRate + $NewTotalWithRate) / $Total;

          $InventoryUpdate = Inventory::where('id', $Inventory->id)->update([
            'total' => $Total,
            'good_inventory' => $GoodInventory,
            'avg_rate' => $AvgRate,
            'last_instock_date' => Carbon::now()->format('Y-m-d'),
            'updated_date' => date('Y-m-d'),
          ]);

          $InventoryHistory = new InventoryHistory([
            'inventory_id' => $Inventory->id,
            'user_id' => $userID,
            'item_id' =>  $itemId,
            'type' => 'Inward',
            'qty' =>  $request->InwardQty[$key],
            'rate' => $request->Rate[$key],
            'inventoryGood' => $request->InwardQty[$key],
            'inventoryAllotted' => $Inventory->allotted_inventory,
            'inventoryRequired' => $Inventory->required_inventory,
            'created_date' => date('Y-m-d'),
          ]);
          $InventoryHistory->save();
        }

        $WarehouseTransfer = WarehouseTransfer::where('id', $request->ChallanNumber)->update([
          'inward_status' => 'done',
        ]);

        if ($request->AddMore) {
          return redirect()->action([WareHouseController::class, 'warehouseInward'])->withSuccess('Successfully Done');
        } else {
          return redirect()->action([WareHouseController::class, 'warehouseInwardList'])->withSuccess('Successfully Done');
          // return view('content.warehouse-master.warehouse-inward-list')->withSuccess('Successfully Done');
        }
      }
      return redirect()->action([WareHouseController::class, 'warehouseInward'])->withErrors('Something went Wrong');
    }
  }


  public function addwarehouseTransfer(Request $request)
  {

    $userID = Auth::id();
    $this->validate(request(), [
      'FromWarehouse' => 'required',
      'ToWarehouse' => 'required',
    ]);

    $items = $request->item;
    if (!empty($items)) {
      $WarehouseTransfer = new WarehouseTransfer([
        'date' => $request->date,
        'transfer_from' => $request->FromWarehouse ?? null,
        'transfer_to' => $request->ToWarehouse ?? null,
        'remark' => $request->remark ?? null,
        'user_id' => $userID,
      ]);
      $WarehouseTransfer->save();
      foreach ($items as $itemKey => $item) {

        $this->validate(request(), [
          'item.*' => 'required',
        ]);
        if (!empty($item)) {
          $Inventory = Inventory::where('item_id', $item)->first();
          if ($Inventory->good_inventory >= $request->qty[$itemKey]) {
            $WarehouseTransferParameter = new WarehouseTransferParameter([
              'warehouse_transfer_id' => $WarehouseTransfer->id,
              'item_id' => $item,
              'qty' => $request->qty[$itemKey],
              'rate' => $request->rate[$itemKey],
              'user_id' => $userID,
            ]);
            $WarehouseTransferParameter->save();

            $ReaminingQty = $Inventory->good_inventory - $request->qty[$itemKey];
            $totalReamingQty = $Inventory->total - $request->qty[$itemKey];;
            Inventory::where('item_id', $item)->update([
              'total' => $totalReamingQty,
              'good_inventory' => $ReaminingQty,
              'last_instock_date' => Carbon::now()->format('Y-m-d'),
              'updated_date' => Carbon::now()->format('Y-m-d'),
            ]);

            $InventoryHistory = new InventoryHistory([
              'inventory_id' => $Inventory->id,
              'warehouse_master_id' => $request->ToWarehouse,
              'user_id' => $userID,
              'item_id' => $item,
              'type' => 'Transfer',
              'qty' => $request->qty[$itemKey],
              'inventoryGood' => $ReaminingQty,
              'created_date' => date('Y-m-d'),
            ]);
            $InventoryHistory->save();
          }
        }
      }

      if ($request->AddMore) {
        return redirect()->action([WareHouseController::class, 'warehouseTransfer'])->withSuccess('Successfully Done');
      } else {
        return redirect()->action([WareHouseController::class, 'warehouseTransferList'])->withSuccess('Successfully Done');
      }
    }
    return redirect()->action([WareHouseController::class, 'warehouseTransfer'])->withErrors('Not Item was selected');
  }

  public function addGrToSupplier(Request $request)
  {
    // dd($request->all());
    $userID = Auth::id();
    $this->validate(request(), [
      'grnNo' => 'required',
      'WarehouseId' => 'required',
      'SupplierId' => 'required',
    ]);

    $items = $request->item;
    if (!empty($items)) {
      $GrToSupplier = new GrToSupplier([
        'grn_no' => $request->grnNo,
        'warehouse_id' => $request->WarehouseId ?? null,
        'supplier_id' => $request->SupplierId ?? null,
        'remark' => $request->remark ?? null,
        'user_id' => $userID,
      ]);
      $GrToSupplier->save();

      foreach ($items as $itemKey => $item) {
        $this->validate(request(), [
          'item.*' => 'required',
        ]);
        if (!empty($item)) {
          $Inventory = Inventory::where('item_id', $item)->first();
          if ($Inventory->good_inventory >= $request->returnQty[$itemKey]) {
            $GrToSupplierParameter = new GrToSupplierParameter([
              'gr_to_supplier_id' => $GrToSupplier->id,
              'item_id' => $item,
              'received_qty' => $request->receivedQty[$itemKey],
              'return_qty' => $request->returnQty[$itemKey],
              'user_id' => $userID,
            ]);
            $GrToSupplierParameter->save();

            $ReaminingQty = $Inventory->good_inventory - $request->returnQty[$itemKey];
            $totalReamingQty = $Inventory->total - $request->returnQty[$itemKey];;
            Inventory::where('item_id', $item)->update([
              'total' => $totalReamingQty,
              'good_inventory' => $ReaminingQty,
              'last_instock_date' => Carbon::now()->format('Y-m-d'),
              'updated_date' => Carbon::now()->format('Y-m-d'),
            ]);

            $InventoryHistory = new InventoryHistory([
              'inventory_id' => $Inventory->id,
              'warehouse_master_id' => $request->WarehouseId,
              'user_id' => $userID,
              'item_id' => $item,
              'type' => 'Remove',
              'qty' => $request->returnQty[$itemKey],
              'inventoryGood' => $ReaminingQty,
              'created_date' => date('Y-m-d'),
            ]);
            $InventoryHistory->save();
          }
        }
      }

      if ($request->AddMore) {
        return redirect()->action([WareHouseController::class, 'grSupplier'])->withSuccess('Successfully Done');
      } else {
        return redirect()->action([WareHouseController::class, 'grSupplierList'])->withSuccess('Successfully Done');
      }
    }
    return redirect()->action([WareHouseController::class, 'grSupplier'])->withErrors('Not Item was selected');
  }

  public function getGrnItemQty(Request $request)
  {
    $GrnItem = GrnItem::with('Item')->where('grn_no', $request->grnNo)->where('item_master_id', $request->itemsId)->first();
    $Data['receivedQty'] =  $GrnItem->qty;
    // dd($request->toArray());
    return response()->json($Data);
  }

  public function outwardAdd(Request $request)
  {
    // dd($request->all());
    $userID = Auth::id();

    $this->validate(request(), [
      'warehouse_id' => 'required',
    ]);

    if (strtolower($request->radio) == 'department') {
      $this->validate(request(), [
        'department_id' => 'required',
      ]);
    } elseif (strtolower($request->radio) == 'jobcenter') {
      $this->validate(request(), [
        'service_id' => 'required',
      ]);
    }

    if (!empty($items)) {
      $Outward = new Outward([
        'type' => $request->radio,
        'outward_from' => $request->warehouse_id,
        'outward_to_department' => $request->department_id ?? null,
        'outward_to_service' => $request->service_id ?? null,
        'user_id' => $userID,
      ]);
      $Outward->save();



      foreach ($items as $itemKey => $item) {
        $this->validate(request(), [
          'item.*' => 'required',
        ]);

        if (!empty($item)) {
          $Inventory = Inventory::where('item_id', $item)->first();

          if ($Inventory->good_inventory >= $request->remainToIssueQty[$itemKey]) {
            $OutwardParameter = new OutwardParameter([
              'outward_id' => $Outward->id,
              'job_order_id' => $request->joborder[$itemKey] ?? NULL,
              'item_id' => $item,
              'required_qty' => $request->requriedQty[$itemKey],
              'already_issued_qty' => $request->remainToIssueQty[$itemKey],
              'remaining_to_issue' => $request->remainToIssueQty[$itemKey],
              'user_id' => $userID,
            ]);
            $OutwardParameter->save();

            $ReaminingQty = $Inventory->good_inventory - $request->remainToIssueQty[$itemKey];
            $totalReamingQty = $Inventory->total - $request->remainToIssueQty[$itemKey];;
            Inventory::where('item_id', $item)->update([
              'total' => $totalReamingQty,
              'good_inventory' => $ReaminingQty,
              'last_instock_date' => Carbon::now()->format('Y-m-d'),
              'updated_date' => Carbon::now()->format('Y-m-d'),
            ]);

            $InventoryHistory = new InventoryHistory([
              'inventory_id' => $Inventory->id,
              'warehouse_master_id' => $request->warehouse_id,
              'user_id' => $userID,
              'item_id' => $item,
              'type' => 'Remove',
              'qty' => $request->remainToIssueQty[$itemKey],
              'inventoryGood' => $ReaminingQty,
              'created_date' => date('Y-m-d'),
            ]);
            $InventoryHistory->save();
          }
        }
      }

      if ($request->AddMore) {
        return redirect()->action([WareHouseController::class, 'warehouseOutward'])->withSuccess('Successfully Done');
      } else {
        return redirect()->action([WareHouseController::class, 'warehouseOutwardList'])->withSuccess('Successfully Done');
      }
    }
    return redirect()->action([WareHouseController::class, 'warehouseOutward'])->withErrors('Not Item was selected');
  }
  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('content.warehouse-master.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $this->validate(request(), [
      'WarehouseName' => 'required',
      'ContactPersonName' => 'required',
      'ContactPersonMobile' => 'required',
      'address_line1' => 'required',
      'city' => 'required',
      'state' => 'required',
      'pincode' => 'required',
    ]);

    $WareHouse = new WareHouse([
      'name' => $request->WarehouseName,
      'contact_person_name' => $request->ContactPersonName,
      'contact_person_number' => $request->ContactPersonMobile,
      'address1' => $request->address_line1,
      'address2' => $request->address_line2,
      'city' => $request->city,
      'state' => $request->state,
      'pincode' => $request->pincode,
    ]);
    if ($WareHouse->save()) {
      if ($request->AddMore) {
        return redirect()->action([WareHouseController::class, 'create'])->withSuccess('Successfully Done');
      } else {
        return redirect()->action([WareHouseController::class, 'index'])->withSuccess('Successfully Done');
      }
    } else {
      return redirect()->action([WareHouseController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(WareHouse $wareHouse)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $WareHouse = WareHouse::where('id', $id)->first();
    return view('content.warehouse-master.edit', compact("WareHouse"));
  }

  public function getJobOrderItem(Request $request)
  {
    // dd($request->all());
    $JobOrder = JobOrders::where('id', $request->joborder)->first();

    $PlaningOrderMaterialsItem = PlaningOrderMaterials::with('Item')->where('planing_order_id', $JobOrder->planing_order_id)->get();

    // dd($PlaningOrderMaterialsItem->toArray());
    return response()->json($PlaningOrderMaterialsItem);
  }

  public function getJobOrderItemQty(Request $request)
  {
    // dd($request->all());
    $Data = [];
    $Inventory = Inventory::where('item_id', $request->itemsId)->first();
    if (!empty($request->joborder)) {
      $JobOrder = JobOrders::where('id', $request->joborder)->first();
      $PlaningOrderMaterialsItem = PlaningOrderMaterials::with('Item')->where('planing_order_id', $JobOrder->planing_order_id)->where('item_id', $request->itemsId)->first();
      $OutwardParameter = OutwardParameter::where('job_order_id', $request->joborder)->where('item_id', $request->itemsId)->get();
      $SumOfItemsQty = $OutwardParameter->sum('remaining_to_issue');
      $Data['required_qty'] = $PlaningOrderMaterialsItem->required_qty;
      $Data['issued_qty'] = $SumOfItemsQty;
    }
    // dd($SumOfItemsQty);



    $Data['invetory_qty'] = $Inventory->good_inventory ?? 0;
    // dd($PlaningOrderMaterialsItem->toArray());
    return response()->json($Data);
  }
  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $this->validate(request(), [
      'WarehouseName' => 'required',
      'ContactPersonName' => 'required',
      'ContactPersonMobile' => 'required',
      'address_line1' => 'required',
      'city' => 'required',
      'state' => 'required',
      'pincode' => 'required',
    ]);
    $WareHouse = WareHouse::where('id', $id)->update([
      'name' => $request->WarehouseName,
      'contact_person_name' => $request->ContactPersonName,
      'contact_person_number' => $request->ContactPersonMobile,
      'address1' => $request->address_line1,
      'address2' => $request->address_line2,
      'city' => $request->city,
      'state' => $request->state,
      'pincode' => $request->pincode,
    ]);

    if ($WareHouse) {
      return redirect()->action([WareHouseController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([WareHouseController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }
  public function delete(Request $request)
  {
    $WareHouse = WareHouse::where('id', $request->warehouseId)->delete();
    if ($WareHouse) {
      return redirect()->action([WareHouseController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([WareHouseController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function fetchQtyInventory(Request $request)
  {
    // dd($request->fromWarehouse);

    $Inventory = Inventory::where('item_id', $request->itemsId)->where('warehouse_master_id', $request->fromWarehouse)->first();
    $Data['availableQty'] = $Inventory->good_inventory ?? 0;
    return response()->json($Data);
  }
}
