<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\StyleMaster;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
  public function index()
  {
    return view('content.apps.app-inventory-list');
  }

  public function delete(Request $request)
  {
    dd($request->inventoryId);
    $Inventory = Inventory::where('id', $request->inventoryId)->delete();
    if ($Inventory) {
      return redirect()->action([InventoryController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([InventoryController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  public function historyList()
  {
    return view('content.apps.app-inventory-history');
  }

  public function inventoryHistory(Request $request)
  {
    $InventoryHistory = InventoryHistory::with("item", "User", "WareHouse");
    // dd($request->category_id);
    if (!empty($request->item_id)) {
      $InventoryHistory->where('item_id', $request->item_id);
    }

    if (!empty($request->warehouse_id)) {
      $InventoryHistory->where('warehouse_master_id', $request->warehouse_id);
    }

    if (!empty($request->type)) {
      $InventoryHistory->where('type', $request->type);
    }


    if (!empty($request->category_id)) {
      $InventoryHistory->whereHas('item.ItemCategory', function ($query) use ($request) {
        $query->where('id', $request->category_id);
      });
    }

    if (!empty($request->subCategory_id)) {
      $InventoryHistory->whereHas('item.ItemSubCategory', function ($query) use ($request) {
        $query->where('id', $request->subCategory_id);
      });
    }

    if (!empty($request->startDate) && !empty($request->endDate)) {
      $InventoryHistory->whereBetween('created_date', [$request->startDate, $request->endDate]);
    }

    $filteredInventories = $InventoryHistory->get();

    // dd($filteredInventories->toArray());

    $num = 1;
    $result = array("data" => array());

    foreach ($filteredInventories as $Inventory) {

      if ($Inventory->type == 'Add') {
        $color = 'success';
      } elseif ($Inventory->type == 'Change') {
        $color = 'warning';
      } elseif ($Inventory->type == 'Remove') {
        $color = 'danger';
      } elseif ($Inventory->type == 'Transfer') {
        $color = 'info';
      } elseif ($Inventory->type == 'Replace') {
        $color = 'dark';
      }
      $Type = '<span class="badge bg-label-' . $color . '" text-capitalized="">' . $Inventory->type . '</span>';

      $Qty = '<div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-primary me-3 p-2">
                    <i class="ti ti-shopping-cart ti-sm"></i>
                </div>
                <div class="card-info">
                    <h5 class="mb-0">' . $Inventory->qty . '</h5>
                    <small>Quantity</small>
                </div>
            </div>';

      $AvgRate = '<div class="d-flex align-items-center">
                    <div class="badge rounded-pill bg-label-dark me-3 p-2">
                        <i class="ti ti-currency-rupee ti-sm"></i>
                    </div>
                    <div class="card-info">
                        <h5 class="mb-0">' . $Inventory->rate . '</h5>
                        <small>Rate</small>
                    </div>
                </div>';
      $GoodInventory = '<div class="d-flex align-items-center">
                    <div class="badge rounded-pill bg-label-success me-3 p-2">
                        <i class="ti ti-shopping-cart ti-sm"></i>
                    </div>
                    <div class="card-info">
                        <h5 class="mb-0">' . $Inventory->inventoryGood . '</h5>
                        <small>Good</small>
                    </div>
                </div>';

      $AllotedInventory = '<div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-info me-3 p-2">
                    <i class="ti ti-shopping-cart ti-sm"></i>
                </div>
                <div class="card-info">
                    <h5 class="mb-0">' . $Inventory->inventoryAllotted . '</h5>
                    <small>Alloted</small>
                </div>
            </div>';

      $RequiredInventory = '<div class="d-flex align-items-center">
                  <div class="badge rounded-pill bg-label-warning me-3 p-2">
                      <i class="ti ti-shopping-cart ti-sm"></i>
                  </div>
                  <div class="card-info">
                      <h5 class="mb-0">' . $Inventory->inventoryRequired . '</h5>
                      <small>Required</small>
                  </div>
              </div>';

      $UserDate = '<div class="d-flex align-items-center">
                  <div class="badge rounded-pill bg-label-primary me-3 p-2">
                      <i class="ti ti-User ti-sm"></i>
                  </div>
                  <div class="card-info">
                      <h5 class="mb-0">' . ($Inventory->User->person_name ?? '') . '</h5>
                      <small>' . ($Inventory->User->company_name ?? '') . '</small>
                  </div>
              </div>';


      array_push($result["data"], array($num, ($Inventory->WareHouse->name ?? ''), $Inventory->item->name, $Type, $Qty, $AvgRate, $GoodInventory, $AllotedInventory, $RequiredInventory, $UserDate));
      $num++;
    }
    echo json_encode($result);
  }

  public function inventoryList(Request $request)
  {
    // dd($request);
    $Invenotries = Inventory::with("item", "WareHouse");

    if (!empty($request->item_id)) {
      $Invenotries->where('item_id', $request->item_id);
    }

    if (!empty($request->warehouse_id)) {
      $Invenotries->where('warehouse_master_id', $request->warehouse_id);
    }


    if (!empty($request->category_id)) {
      $Invenotries->whereHas('item.ItemCategory', function ($query) use ($request) {
        $query->where('id', $request->category_id);
      });
    }

    if (!empty($request->subCategory_id)) {
      $Invenotries->whereHas('item.ItemSubCategory', function ($query) use ($request) {
        $query->where('id', $request->subCategory_id);
      });
    }
    $filteredInventories = $Invenotries->selectRaw('*, (good_inventory * avg_rate) as goodValuation, (bad_inventory * avg_rate) as badValuation, (allotted_inventory * avg_rate) as allotedValuation, (required_inventory * avg_rate) as requiredValuation')->get();

    $num = 1;
    $result = array("data" => array());
    $Sum = [
      'good' => $filteredInventories->sum('good_inventory'),
      'bad' => $filteredInventories->sum('bad_inventory'),
      'alloted' => $filteredInventories->sum('allotted_inventory'),
      'required' => $filteredInventories->sum('required_inventory'),
    ];

    $ValueOfGood = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", round($filteredInventories->sum('goodValuation'), 2));
    $ValueOfBad =  preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", round($filteredInventories->sum('badValuation'), 2));
    $ValueOfAlloted =  preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", round($filteredInventories->sum('allotedValuation'), 2));
    $ValueOfRequired =  preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", round($filteredInventories->sum('requiredValuation'), 2));


    foreach ($filteredInventories as $Inventory) {

      $total = '<div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-primary me-3 p-2">
                    <i class="ti ti-shopping-cart ti-sm"></i>
                </div>
                <div class="card-info">
                    <h5 class="mb-0">' . $Inventory->total . '</h5>
                    <small>Total</small>
                </div>
            </div>';

      $AvgRate = '<div class="d-flex align-items-center">
                    <div class="badge rounded-pill bg-label-dark me-3 p-2">
                        <i class="ti ti-currency-rupee ti-sm"></i>
                    </div>
                    <div class="card-info">
                        <h5 class="mb-0"> ₹' . $Inventory->avg_rate . '</h5>
                        <small>Rate</small>
                    </div>
                </div>';
      $GoodInventory = '<div class="d-flex align-items-center">
                    <div class="badge rounded-pill bg-label-success me-3 p-2">
                        <i class="ti ti-shopping-cart ti-sm"></i>
                    </div>
                    <div class="card-info">
                        <h5 class="mb-0">' . $Inventory->good_inventory . '</h5>
                        <small>Good</small>
                    </div>
                </div>';
      $BadInventory = '<div class="d-flex align-items-center">
                    <div class="badge rounded-pill bg-label-danger me-3 p-2">
                        <i class="ti ti-shopping-cart ti-sm"></i>
                    </div>
                    <div class="card-info">
                        <h5 class="mb-0">' . $Inventory->bad_inventory . '</h5>
                        <small>Bad</small>
                    </div>
                </div>';

      $AllotedInventory = '<div class="d-flex align-items-center">
                    <div class="badge rounded-pill bg-label-info me-3 p-2">
                        <i class="ti ti-shopping-cart ti-sm"></i>
                    </div>
                    <div class="card-info">
                        <h5 class="mb-0">' . $Inventory->allotted_inventory . '</h5>
                        <small>Alloted</small>
                    </div>
                </div>';
      $RequiredInventory = '<div class="d-flex align-items-center">
                      <div class="badge rounded-pill bg-label-warning me-3 p-2">
                          <i class="ti ti-shopping-cart ti-sm"></i>
                      </div>
                      <div class="card-info">
                          <h5 class="mb-0">' . $Inventory->required_inventory . '</h5>
                          <small>Required</small>
                      </div>
                  </div>';

      array_push($result["data"], array($num, $Inventory->WareHouse->name, $Inventory->item->name, $total, $AvgRate, $GoodInventory, $BadInventory, $AllotedInventory, $RequiredInventory));
      $num++;
    }
    $result["SumData"] = $Sum;
    $result["ValueDate"] = [
      'ValueOfGood' => $ValueOfGood,
      'ValueOfBad' => $ValueOfBad,
      'ValueOfAlloted' => $ValueOfAlloted,
      'ValueOfRequired' => $ValueOfRequired,
    ];
    echo json_encode($result);
  }
}
