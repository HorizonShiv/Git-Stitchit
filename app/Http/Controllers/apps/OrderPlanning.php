<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Http\Controllers\masters\ItemMaster;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Helpers\Helpers;
use App\Models\ItemSubCategory;
use App\Models\JobOrderParameters;
use App\Models\JobOrders;
use App\Models\PlaningOrderMaterials;
use App\Models\PlaningOrderProcesses;
use App\Models\PlaningOrders;
use App\Models\PoPlaningOrders;
use App\Models\ProcessMaster;
use App\Models\SalesOrderParameters;
use App\Models\SalesOrders;
use App\Models\SalesOrderStyleInfo;
use App\Models\Setting;
use App\Models\StyleMaster;
use App\Models\User;
use App\Models\CategoryMasters;
use Illuminate\Http\Request;
use PDF;

class OrderPlanning extends Controller
{
  //
  public function index()
  {
    $PlaningOrders = PlaningOrders::with('PlaningOrderProcesses', 'SalesOrderStyleInfo', 'SalesOrders')->orderBy("id", "desc")->get();
    return view('content.order-planing.list', compact("PlaningOrders"));
  }

  public function pendinglist()
  {
    $SalesOrders = SalesOrders::with('SalesOrderStyleInfo.StyleMaster.StyleCategory', 'SalesOrderParameters', 'Customer', 'Brand', 'Season')
      ->whereHas('SalesOrderStyleInfo', function ($query) {
        $query->where("order_planing_status", "pending");
      })
      ->orderBy("id", "desc")
      ->get();
    return view('content.order-planing.pendinglist', compact("SalesOrders"));
  }

  public function create($sale_id, $planing_order_id = "", $actionType = "")
  {
    $salesOrderStyleInfos = SalesOrderStyleInfo::where("order_planing_status", "pending")->with('StyleMaster')->where("sales_order_id", $sale_id)->get();
    $salesOrderDetails = SalesOrders::where("id", $sale_id)->first();
    $UserData = User::where('role', '=', 'vendor')->get();
    $categoryData = CategoryMasters::all();
    $processMasters = ProcessMaster::all();
    $itemMasters = Item::all();
    $categoryMasters = ItemCategory::all();
    $subcategoryMasters = ItemSubCategory::all();
    $planingOrders = [];
    if (!empty($planing_order_id)) {
      $planingOrders = PlaningOrders::with([
        "SalesOrderStyleInfo.StyleMaster",
        "PlaningOrderMaterials.Item",
        "PlaningOrderProcesses.ProcessMaster",
        "PlaningOrderProcesses" => function ($query) {
          $query->orderBy('sr_no', 'asc');
        }
      ])->where("id", $planing_order_id)->first();
    }
    if ($actionType === "view") {
      return view('content.order-planing.view', compact("subcategoryMasters", "categoryMasters", "salesOrderDetails", 'UserData', 'categoryData', "salesOrderStyleInfos", "sale_id", "planing_order_id", "processMasters", "itemMasters", "planingOrders", "actionType"));
    } else {
      return view('content.order-planing.create', compact("subcategoryMasters", "categoryMasters", "salesOrderDetails", 'UserData', 'categoryData', "salesOrderStyleInfos", "sale_id", "planing_order_id", "processMasters", "itemMasters", "planingOrders", "actionType"));
    }
  }

  public function getStyleDetailsForSample(Request $request)
  {
    $StyleId = $request->StyleId;
    $rawData = StyleMaster::with("StyleCategory", "StyleSubCategory", "Fit", "Season")->where('id', $StyleId)->first();
    $rate = $rawData->rate;
    $qty = 'NA';
    if (!empty($rawData)) {


      $NewHtml = '<div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1">
                <div class="col-md-3 col-sm-12 text-center">';
      if (!empty($rawData->sample_photo)) {
        $NewHtml .= '<img style="width:80%"
                src="' . Helpers::getSamplePhoto($rawData->id, $rawData->sample_photo) . '"
                alt="">';
      } else {
        $NewHtml .= '<span class="badge rounded bg-label-danger">Image Not Available</span>';
      }

      $NewHtml .= '</div>
                <hr class="d-none d-sm-block d-lg-none me-4">
                <div class="col-md-9 col-sm-12">
                    <div class="row gy-sm-2">
                        <div class="col-sm-6 col-lg-4">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                <div>
                                    <p class="mb-0  font-weight-bold">Fabric</p>

                                </div>
                                <span class="me-sm-4 btn-sm btn btn-outline-info">' . $rawData->febric . '</span>

                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                <div>
                                    <p class="mb-0  font-weight-bold">Category</p>

                                </div>
                                <span class="me-sm-4 btn-sm btn btn-outline-primary">' . $rawData->StyleCategory->name . '</span>

                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                <div>
                                    <p class="mb-0  font-weight-bold">Designer</p>

                                </div>
                                <span class="me-sm-4 btn-sm btn btn-outline-info">' . ($rawData->Designer->person_name ?? 'NA') . '</span>

                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                <div>
                                    <p class="mb-0  font-weight-bold">Color</p>

                                </div>
                                <span class="me-sm-4 btn-sm btn btn-outline-info">' . ($rawData->color ?? 'NA') . '</span>

                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                <div>
                                    <p class="mb-0  font-weight-bold">Sub-Category</p>

                                </div>
                                <span class="me-sm-4 btn-sm btn btn-outline-primary">' . $rawData->StyleSubCategory->name . '</span>

                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                <div>
                                    <p class="mb-0  font-weight-bold">Customer Style No</p>

                                </div>
                                <span class="me-sm-4 btn-sm btn btn-outline-info"> NA </span>

                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                <div>
                                    <p class="mb-0  font-weight-bold">Order Qty</p>

                                </div>
                                <span class="me-sm-4 btn-sm btn btn-outline-success">' . $qty . '</span>

                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                <div>
                                    <p class="mb-0  font-weight-bold">Fit</p>

                                </div>
                                <span class="me-sm-4 btn-sm btn btn-outline-info">' . $rawData->Fit->name . '</span>

                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                <div>
                                    <p class="mb-0  font-weight-bold">Ship Date</p>

                                </div>
                                <span class="me-sm-4 btn-sm btn btn-outline-danger"><i class="fa fa-clock mx-1"></i> NA </span>

                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                    </div>
                </div>
            </div>
        </div>';
      $result['showStyleDetails'] = $NewHtml;
    }

    echo json_encode($result);
  }

  public function getStyleDetails(Request $request)
  {
    $StyleId = $request->StyleId;
    $rate = 0;
    $qty = 0;
    $html = '';
    if (!empty($StyleId)) {
      $salesOrderStyleInfo = SalesOrderStyleInfo::where('id', '=', $StyleId)->first();

      if ($salesOrderStyleInfo) {
        $style_master_id = $salesOrderStyleInfo->style_master_id;
      } else {
        $style_master_id = $StyleId;
      }
      $sales_order_id = $salesOrderStyleInfo->sales_order_id;

      $rawData = StyleMaster::with("StyleCategory", "StyleSubCategory", "Fit", "Season")->where('id', $style_master_id)->first();
      $rate = $rawData->rate;
      $qty = $salesOrderStyleInfo->total_qty ?? 'NA';

      $NewHtml = '<div class="card-body card-widget-separator">
              <div class="row gy-4 gy-sm-1">
                  <div class="col-md-3 col-sm-12 text-center">';
      if (!empty($rawData->sample_photo)) {
        $NewHtml .= '<img style="width:80%"
                          src="' . Helpers::getSamplePhoto($rawData->id, $rawData->sample_photo) . '"
                          alt="">';
      } else {
        $NewHtml .= '<span class="badge rounded bg-label-danger">Image Not Available</span>';
      }

      $NewHtml .= '</div>
                  <hr class="d-none d-sm-block d-lg-none me-4">
                  <div class="col-md-9 col-sm-12">
                      <div class="row gy-sm-2">
                          <div class="col-sm-6 col-lg-4">
                              <div
                                  class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                  <div>
                                      <p class="mb-0  font-weight-bold">Fabric</p>

                                  </div>
                                  <span class="me-sm-4 btn-sm btn btn-outline-info">' . $rawData->febric . '</span>

                              </div>
                              <hr class="d-none d-sm-block d-lg-none me-4">
                          </div>
                          <div class="col-sm-6 col-lg-4">
                              <div
                                  class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                  <div>
                                      <p class="mb-0  font-weight-bold">Category</p>

                                  </div>
                                  <span class="me-sm-4 btn-sm btn btn-outline-primary">' . $rawData->StyleCategory->name . '</span>

                              </div>
                              <hr class="d-none d-sm-block d-lg-none me-4">
                          </div>
                          <div class="col-sm-6 col-lg-4">
                              <div
                                  class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                  <div>
                                      <p class="mb-0  font-weight-bold">Merchant</p>

                                  </div>
                                  <span class="me-sm-4 btn-sm btn btn-outline-info">' . ($rawData->Designer->person_name ?? 'NA') . '</span>

                              </div>
                              <hr class="d-none d-sm-block d-lg-none me-4">
                          </div>
                          <div class="col-sm-6 col-lg-4">
                              <div
                                  class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                  <div>
                                      <p class="mb-0  font-weight-bold">Color</p>

                                  </div>
                                  <span class="me-sm-4 btn-sm btn btn-outline-info">' . ($rawData->color ?? 'NA') . '</span>

                              </div>
                              <hr class="d-none d-sm-block d-lg-none me-4">
                          </div>
                          <div class="col-sm-6 col-lg-4">
                              <div
                                  class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                  <div>
                                      <p class="mb-0  font-weight-bold">Sub-Category</p>

                                  </div>
                                  <span class="me-sm-4 btn-sm btn btn-outline-primary">' . $rawData->StyleSubCategory->name . '</span>

                              </div>
                              <hr class="d-none d-sm-block d-lg-none me-4">
                          </div>
                          <div class="col-sm-6 col-lg-4">
                              <div
                                  class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                  <div>
                                      <p class="mb-0  font-weight-bold">Customer Style No</p>

                                  </div>
                                  <span class="me-sm-4 btn-sm btn btn-outline-info">' . ($salesOrderStyleInfo->customer_style_no ?? 'NA') . '</span>

                              </div>
                              <hr class="d-none d-sm-block d-lg-none me-4">
                          </div>
                          <div class="col-sm-6 col-lg-4">
                              <div
                                  class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                  <div>
                                      <p class="mb-0  font-weight-bold">Order Qty</p>

                                  </div>
                                  <span class="me-sm-4 btn-sm btn btn-outline-success">' . $qty . '</span>

                              </div>
                              <hr class="d-none d-sm-block d-lg-none me-4">
                          </div>
                          <div class="col-sm-6 col-lg-4">
                              <div
                                  class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                  <div>
                                      <p class="mb-0  font-weight-bold">Fit</p>

                                  </div>
                                  <span class="me-sm-4 btn-sm btn btn-outline-info">' . $rawData->Fit->name . '</span>

                              </div>
                              <hr class="d-none d-sm-block d-lg-none me-4">
                          </div>
                          <div class="col-sm-6 col-lg-4">
                              <div
                                  class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-2 pb-sm-0">
                                  <div>
                                      <p class="mb-0  font-weight-bold">Ship Date</p>

                                  </div>
                                  <span class="me-sm-4 btn-sm btn btn-outline-danger"><i class="fa fa-clock mx-1"></i>' . ($salesOrderStyleInfo->ship_date ?? 'NA') . '</span>

                              </div>
                              <hr class="d-none d-sm-block d-lg-none me-4">
                          </div>
                      </div>
                  </div>
              </div>
          </div>';


      $processMasters = ProcessMaster::all();
      $itemMasters = Item::all();
      $categoryMasters = ItemCategory::all();
      $subcategoryMasters = ItemSubCategory::all();
      $StyleMaster = StyleMaster::with(["StyleMasterProcesses", "StyleMasterMaterials"])->where("id", $style_master_id)->first();
      $htmlProcess = '';
      if (!empty($StyleMaster)) {
        $num = 0;
        foreach ($StyleMaster->StyleMasterProcesses as $OrderProcess) {
          $htmlProcess .= '<div class="row g-3">';
          $htmlProcess .= '<div class="col-md-2">';
          $htmlProcess .= '<label class="form-label">SR No.</label>';
          $htmlProcess .= '<input type="text" id="srNo' . $num . '" name="processData[' . $num . '][srNo]" class="form-control" placeholder="Sr NO." value="' . $OrderProcess->sr_no . '" />';
          $htmlProcess .= '<input type="hidden" id="planingOrderProcessesId' . $num . '" name="processData[' . $num . '][planingOrderProcessesId]" value="' . $OrderProcess->id . '">';
          $htmlProcess .= '</div>';
          $htmlProcess .= '<div class="col-md-2">';
          $htmlProcess .= '<label class="form-label">Process List</label>';
          $htmlProcess .= '<select id="processItem' . $num . '" name="processData[' . $num . '][processItem]" class="select2 form-select" data-allow-clear="true">';
          $htmlProcess .= '<option value="">Select</option>';
          foreach ($processMasters as $processMaster) {
            $selected = ($OrderProcess->process_master_id == $processMaster->id) ? 'selected' : '';
            $htmlProcess .= '<option ' . $selected . ' value="' . $processMaster->id . '">' . $processMaster->name . '</option>';
          }
          $htmlProcess .= '</select>';
          $htmlProcess .= '</div>';
          $htmlProcess .= '<div class="col-md-2">';
          $htmlProcess .= '<label class="form-label">Qty</label>';
          $htmlProcess .= '<input type="text" onkeyup="processCalculateValue(' . $num . ')" id="processQty' . $num . '" name="processData[' . $num . '][processQty]" class="form-control" value="' . $OrderProcess->qty . '" placeholder="Quantity" />';
          $htmlProcess .= '</div>';
          $htmlProcess .= '<div class="col-md-2">';
          $htmlProcess .= '<label class="form-label">Rate</label>';
          $htmlProcess .= '<input type="text" onkeyup="processCalculateValue(' . $num . ')" id="processRate' . $num . '" name="processData[' . $num . '][processRate]" class="form-control" value="' . $OrderProcess->rate . '" placeholder="Rate" />';
          $htmlProcess .= '</div>';
          $htmlProcess .= '<div class="col-md-2">';
          $htmlProcess .= '<label class="form-label">Qty</label>';
          $htmlProcess .= '<input type="text" onkeyup="processCalculateValue(' . $num . ')" id="processValue' . $num . '" name="processData[' . $num . '][processValue]" class="form-control" value="' . $OrderProcess->value . '" placeholder="Value" />';
          $htmlProcess .= '</div>';
          $htmlProcess .= '<div class="col-md-2">';
          $htmlProcess .= '<label class="form-label">Qty</label>';
          $htmlProcess .= '<input type="text" onkeyup="processCalculateValue(' . $num . ')" id="processDuration' . $num . '" name="processData[' . $num . '][processDuration]" class="form-control" value="' . $OrderProcess->duration . '" placeholder="duration" />';
          $htmlProcess .= '</div>';
          $num++;
          $htmlProcess .= '</div>';
        }
      }


      $htmlRawMaterial = '';
      if (!empty($StyleMaster)) {
        $num = 0;
        foreach ($StyleMaster->StyleMasterMaterials as $OrderMaterials) {
          $htmlRawMaterial .= '<div class="row g-3">';

          $htmlRawMaterial .= '<div class="col-md-2">
                               <label class="form-label">Category</label>
                               <select id="rawCategoryId' . $num . '" name="bomListData[' . $num . '][category_id]" onchange="getCategoryDetails(' . $num . ')" class="select2 form-select" data-allow-clear="true">
                               <option value="">Select</option>';
          foreach ($categoryMasters as $categoryMaster) {
            $selected = ($OrderMaterials->Item->item_category_id == $categoryMaster->id) ? 'selected' : '';
            $htmlRawMaterial .= '<option ' . $selected . ' value="' . $categoryMaster->id . '">' . $categoryMaster->name . '</option>';
          }
          $htmlRawMaterial .= '</select></div>';

          $htmlRawMaterial .= '<div class="col-md-2">
                               <label class="form-label">Sub Category</label>
                               <select id="rawSubcategoryId' . $num . '" name="bomListData[' . $num . '][subcategory_id]" onchange="getSubCategoryDetails(' . $num . ')" class="select2 form-select" data-allow-clear="true">
                               <option value="">Select</option>';
          foreach ($subcategoryMasters as $subcategoryMaster) {
            $selected = ($OrderMaterials->Item->item_subcategory_id == $subcategoryMaster->id) ? 'selected' : '';
            $htmlRawMaterial .= '<option ' . $selected . ' value="' . $subcategoryMaster->id . '">' . $subcategoryMaster->name . '</option>';
          }
          $htmlRawMaterial .= '</select></div>';

          $htmlRawMaterial .= '<div class="col-md-2">
                               <label class="form-label">Item</label>
                               <select id="rawItem' . $num . '" name="bomListData[' . $num . '][rawItem]" onchange="getItemDetails(' . $num . ')" class="select2 form-select" data-allow-clear="true">
                               <option value="">Select</option>';
          foreach ($itemMasters as $itemMaster) {
            $selected = ($OrderMaterials->Item->item_id == $itemMaster->id) ? 'selected' : '';
            $htmlRawMaterial .= '<option ' . $selected . ' value="' . $itemMaster->id . '">' . $itemMaster->name . '</option>';
          }
          $htmlRawMaterial .= '</select>
                             <input type="hidden" id="planingOrderMaterialsId' . $num . '" name="bomListData[' . $num . '][planingOrderMaterialsId]" value="' . $OrderMaterials->id . '">
                             </div>';

          // Per Pc Qty column
          $htmlRawMaterial .= '<div class="col-md-2">';
          $htmlRawMaterial .= '<label class="form-label">Per Pc Qty</label>';
          $htmlRawMaterial .= '<input type="number" step="any" onkeyup="bomCalculateValue(' . $num . ')" id="rawPerPcQty' . $num . '" name="bomListData[' . $num . '][rawPerPcQty]" class="form-control" placeholder="Per Pc Qty" value="' . $OrderMaterials->per_pc_qty . '" />';
          $htmlRawMaterial .= '</div>';

          // Order Qty column
          $htmlRawMaterial .= '<div class="col-md-2">';
          $htmlRawMaterial .= '<label class="form-label">Order Qty</label>';
          $htmlRawMaterial .= '<input type="number" step="any" onkeyup="bomCalculateValue(' . $num . ')" id="rawOrderQty' . $num . '" name="bomListData[' . $num . '][rawOrderQty]" class="form-control" placeholder="Order Qty" value="' . $OrderMaterials->order_qty . '" />';
          $htmlRawMaterial .= '</div>';

          // Required Qty column
          $htmlRawMaterial .= '<div class="col-md-2">';
          $htmlRawMaterial .= '<label class="form-label">Required Qty</label>';
          $htmlRawMaterial .= '<input type="number" step="any" onkeyup="bomCalculateValue(' . $num . ')" id="rawRequiredQty' . $num . '" name="bomListData[' . $num . '][rawRequiredQty]" class="form-control" placeholder="Qty" value="' . $OrderMaterials->required_qty . '" />';
          $htmlRawMaterial .= '</div>';

          $htmlRawMaterial .= '<div class="col-md-2"></div>';
          $htmlRawMaterial .= '<div class="col-md-2"></div>';
          $htmlRawMaterial .= '<div class="col-md-2"></div>';

          // Available Qty column
          $htmlRawMaterial .= '<div class="col-md-2">';
          $htmlRawMaterial .= '<label class="form-label">Available Qty</label>';
          $htmlRawMaterial .= '<input type="number" step="any" id="rawAvailableQty' . $num . '" name="bomListData[' . $num . '][rawAvailableQty]" class="form-control" placeholder="Qty" value="' . $OrderMaterials->available_qty . '" />';
          $htmlRawMaterial .= '</div>';

          // Rate column
          $htmlRawMaterial .= '<div class="col-md-2" style="float: right">';
          $htmlRawMaterial .= '<label class="form-label">Rate</label>';
          $htmlRawMaterial .= '<input type="number" step="any" id="rawRate' . $num . '" name="bomListData[' . $num . '][rawRate]" class="form-control" onkeyup="bomCalculateValue(' . $num . ')" placeholder="Total Rate" value="' . $OrderMaterials->rate . '" />';
          $htmlRawMaterial .= '</div>';

          // Total column
          $htmlRawMaterial .= '<div class="col-md-2">';
          $htmlRawMaterial .= '<label class="form-label">Total</label>';
          $htmlRawMaterial .= '<input type="number" step="any" id="rawTotal' . $num . '" name="bomListData[' . $num . '][rawTotal]" class="form-control" placeholder="Total" value="' . $OrderMaterials->total . '" />';
          $htmlRawMaterial .= '</div>';

          // Similar conversion can be done for remaining fields...

          $htmlRawMaterial .= '</div><HR>';
          $num++;
        }
      }
      $JobOrderCheck = JobOrders::where("sale_order_id", $sales_order_id)->where("sales_order_style_id", $StyleId)->get();
      $JobOrderQtyOld = 0;
      $htmlTableOld = '';
      $Checker = 0;
      if ($JobOrderCheck) {
        $htmlTableOld .= '<div>
          <table id="SizeRatios" class="table border table-responsive mb-0">';
        foreach ($JobOrderCheck as $JobOrders) {
          $JobOrderParameters = JobOrderParameters::where('job_order_id', '=', $JobOrders->id)->get();
          $groupedSizesJobOrder = $JobOrderParameters->groupBy('size');
          $groupedColorJobOrder = $JobOrderParameters->groupBy('color');

          if ($Checker == 0) {
            $htmlTableOld .= '
              <thead>
              <tr><th class="border text-primary">Color</th><th class="text-primary">Size</th>';
            foreach ($groupedSizesJobOrder as $size => $groupedSize) {
              if (isset($OldSumOfQty[$size]) && is_array($OldSumOfQty[$size])) {
                $OldSumOfQty[$size] = array_sum($OldSumOfQty[$size]);
              } else {
                $OldSumOfQty[$size] = 0;
              }
              $htmlTableOld .= '<th class="border">' . $size . '</th>';
            }

            $htmlTableOld .= '<th class="border text-primary" colspan="2">Total</th></tr></thead>';
          }

          foreach ($groupedColorJobOrder as $colorKey => $colorwiseData) {
            $JobOrderQtyOld = $JobOrderQtyOld + $colorwiseData->sum('qty');
            $colorwiseQtyData = $colorwiseData->sum('qty');
            $htmlTableOld .= '<tbody>
                        <tr><td rowspan="2" class="border">' . $colorKey . '</td><td class="text-primary">Qty</td>';
            $counterQty = 0;

            foreach ($groupedSizesJobOrder as $size => $groupedSize) {
              $htmlTableOld .= '<td class="border">' . array_column($colorwiseData->toArray(), 'qty')[$counterQty] . '</td>';
              $counterQty++;
            }

            $htmlTableOld .= '<td>' . $colorwiseQtyData . '</td></tr>';
          }

          $Checker++;
        }
        $htmlTableOld .= '</table></div>';
      }

      $salesOrderParameters = SalesOrderParameters::where('sales_order_style_id', '=', $StyleId)->get();
      $groupedSizes = $salesOrderParameters->groupBy('size');
      $groupedColors = $salesOrderParameters->groupBy('color');

      $htmlTable = '';
      $htmlTable .= '<div>
    <table id="SizeRatios" class="table border table-responsive mb-5">
    <thead>
    <tr><th class="border text-primary">Color</th><th></th>';
      foreach ($groupedSizes as $size => $groupedSize) {
        $htmlTable .= '<th class="border">' . $size . '</th>';
      }
      $htmlTable .= '<th class="border text-primary" colspan="2">Total</th></tr></thead>';

      $firstIndex = 1;

      foreach ($groupedColors as $colorKey => $colorwiseData) {
        $minusChecker = [];
        $JobOrderParametersData = JobOrderParameters::whereHas('JobOrders', function ($query) use ($sales_order_id, $StyleId) {
          $query->where("sale_order_id", $sales_order_id)->where("sales_order_style_id", $StyleId);
        })->where("color", $colorKey)->get();

        $resultDetails = $JobOrderParametersData->groupBy('size')->map(function ($item, $key) {
          return $item->sum('qty');
        });

        $colorwiseQtyData = $colorwiseData->sum('planned_qty');
        $htmlTable .= '<tbody>
                        <tr><td rowspan="2" class="border">' . $colorKey . '</td><td class="text-primary">Qty</td>';

        $counterQty = 0;
        $rQtyTotal = 0;
        foreach ($groupedSizes as $size => $groupedSize) {
          if (!empty($resultDetails[$size])) {
            $minusChecker[] = $resultDetails[$size];
          } else {
            $minusChecker[] = 0;
          }
          $rQty = max(0, array_column($colorwiseData->toArray(), 'planned_qty')[$counterQty] - ($resultDetails[$size] ?? 0));
          $rQtyTotal += $rQty;
          $htmlTable .= '
              <td class="border"><input class="form-control" type="number" onkeyup="calculateTotalSum(); setSiderSum(\'' . $colorKey . '\');" name="SizeWiseQty[' . $colorKey . '][' . $size . ']" value="' . max(0, array_column($colorwiseData->toArray(), 'planned_qty')[$counterQty] - ($resultDetails[$size] ?? 0)) . '" ></td>';
          $counterQty++;
        }
        $htmlTable .= '
        <td id="colorwiseQtyData_' . $colorKey . '">' . $rQtyTotal . '</td></tr>';

        $htmlTable .= '<tr><td class="text-primary">Available Qty</td>';
        $mQtyTotal = 0;
        foreach ($colorwiseData as $CheckKey => $data) {
          $mQty = $data->planned_qty;
          $mQtyTotal += $mQty;
          $htmlTable .= '<td class="border">' . $mQty . '</td>';
        }
        $htmlTable .= '<td>' . $mQtyTotal . '</td></tr>
      </tbody>';
      }
      // dd($htmlTable);
      $htmlTable .= '</table></div>';


      $result["oldHtmlSizeWise"] = $htmlTableOld;
      $result["htmlSizeWise"] = $htmlTable;
      $result['showHtmlRawMaterials'] = $htmlRawMaterial;
      $result['showHtmlProcess'] = $htmlProcess;
      $result['showStyleDetails'] = $NewHtml;
      $result['qty'] = $qty;
      $result['rate'] = $rate;

    }

    echo json_encode($result);
  }


  public function getItemDetails(Request $request)
  {
    $rawItem = $request->rawItem;
    if (!empty($rawItem)) {
      $item = Item::with("Inventory")->where('id', '=', $rawItem)->first();
    }
    $result['item'] = $item;
    $result['inventory'] = $item->Inventory;
    echo json_encode($result);
  }


  public function getCategoryDetails(Request $request)
  {

    $rawCategoryId = $request->rawCategoryId;
    if (!empty($rawCategoryId)) {
      $items = Item::where('item_category_id', '=', $rawCategoryId)->get();
      $subcategories = ItemSubCategory::where('item_category_id', '=', $rawCategoryId)->get();
      $result['items'] = $items;
      $result['subcategories'] = $subcategories;
      echo json_encode($result);
    }
  }

  public function getSubCategoryDetails(Request $request)
  {
    $rawSubcategoryId = $request->rawSubcategoryId;
    if (!empty($rawSubcategoryId)) {
      $items = Item::where('item_subcategory_id', '=', $rawSubcategoryId)->get();
      $result['items'] = $items;
      echo json_encode($result);
    }
  }

  public function store(Request $request)
  {
    $request->validate([
      'StyleNo' => 'required|string|max:250',
    ]);

    $SalesOrderId = $request->salesOrderId;
    $planingOrderId = $request->planingOrderId;
    $StyleNo = $request->StyleNo;

    $Setting = Setting::orderBy('id', 'desc')->first();

    if (!empty($planingOrderId)) {
      PlaningOrders::where('id', $planingOrderId)->update([
        'date' => $request->JobOrderDate,
        'sale_order_id' => $SalesOrderId,
        'sales_order_style_id' => $request->StyleNo,
        'qty' => $request->TotalQty,
      ]);
    } else {
      $planingOrderDetails = $Setting->toArray();
      $planingOrderCount = $planingOrderDetails['order_planning_no_set'] + 1;
      $planingOrderNo = $planingOrderDetails['order_planning_pre_fix'] . '' . $planingOrderCount;

      $planingOrders = new PlaningOrders([
        'date' => $request->JobOrderDate,
        'sale_order_id' => $SalesOrderId,
        'planing_order_no' => $planingOrderNo,
        'sales_order_style_id' => $request->StyleNo,
        'qty' => $request->TotalQty,
      ]);
      $planingOrders->save();

      SalesOrderStyleInfo::where('id', $request->StyleNo)->update([
        'order_planing_status' => "done",
      ]);

      Setting::where('id', $planingOrderDetails['id'])->update([
        'order_planning_no_set' => $planingOrderCount,
      ]);
      $planingOrderId = $planingOrders->id;
    }


    if (!empty($request->processData)) {
      $totalProcessDataArray = count($request->processData);
    } else {
      $totalProcessDataArray = 0;
    }
    if ($totalProcessDataArray > 0) {
      $processDatas = $request->processData;

      foreach ($processDatas as $processData) {
        if (!empty($processData['processItem'])) {
          if (!empty($processData['planingOrderProcessesId'])) {
            PlaningOrderProcesses::where('id', $processData['planingOrderProcessesId'])->update([
              'rate' => $processData['processRate'],
              'duration' => $processData['processDuration'],
              'sr_no' => $processData['srNo'],
              'qty' => $processData['processQty'],
              'value' => $processData['processValue'],
              'process_master_id' => $processData['processItem'],
              'sales_order_id' => $SalesOrderId,
              'sales_order_style_id' => $StyleNo,
              'planing_order_id' => $planingOrderId,
            ]);
          } else {
            $planingOrderProcesses = new PlaningOrderProcesses([
              'rate' => $processData['processRate'],
              'duration' => $processData['processDuration'],
              'sr_no' => $processData['srNo'],
              'qty' => $processData['processQty'],
              'value' => $processData['processValue'],
              'process_master_id' => $processData['processItem'],
              'sales_order_id' => $SalesOrderId,
              'sales_order_style_id' => $StyleNo,
              'planing_order_id' => $planingOrderId,
            ]);
            $planingOrderProcesses->save();
          }
        }
      }
    }

    if (!empty($request->bomListData)) {
      $totalBomListDataArray = count($request->bomListData);
    } else {
      $totalBomListDataArray = 0;
    }

    if ($totalBomListDataArray > 0) {
      $bomListDatas = $request->bomListData;

      foreach ($bomListDatas as $bomListData) {
        if (!empty($bomListData['rawItem'])) {
          if (!empty($bomListData['planingOrderMaterialsId'])) {
            PlaningOrderMaterials::where('id', $bomListData['planingOrderMaterialsId'])->update([
              'item_id' => $bomListData['rawItem'],
              'required_qty' => $bomListData['rawRequiredQty'],
              'per_pc_qty' => $bomListData['rawPerPcQty'],
              'order_qty' => $bomListData['rawOrderQty'],
              'available_qty' => $bomListData['rawAvailableQty'],
              'rate' => $bomListData['rawRate'],
              'total' => $bomListData['rawTotal'],
              'sales_order_id' => $SalesOrderId,
              'sales_order_style_id' => $StyleNo,
              'planing_order_id' => $planingOrderId,
            ]);
          } else {
            $planingOrderMaterials = new PlaningOrderMaterials([
              'item_id' => $bomListData['rawItem'],
              'per_pc_qty' => $bomListData['rawPerPcQty'],
              'order_qty' => $bomListData['rawOrderQty'],
              'required_qty' => $bomListData['rawRequiredQty'],
              'available_qty' => $bomListData['rawAvailableQty'],
              'rate' => $bomListData['rawRate'],
              'total' => $bomListData['rawTotal'],
              'sales_order_id' => $SalesOrderId,
              'sales_order_style_id' => $StyleNo,
              'planing_order_id' => $planingOrderId,
            ]);
            $planingOrderMaterials->save();
          }
        }
      }
    }
    return redirect()->route('order-planning-create', [$SalesOrderId . '/' . $planingOrderId . '/store'])->withSuccess('Successfully Done');
  }

  public function processDelete(Request $request)
  {
    $id = $request->id;
    PlaningOrderProcesses::where('id', $id)->delete();
    echo 'success';
  }

  public function processEdit(Request $request)
  {
    $rawData = PlaningOrderProcesses::where('id', '=', $request->id)->first();
    $PlaningOrderProcesses = $rawData->toArray();
    return response()->json(['success' => true, 'PlaningOrderProcesses' => $PlaningOrderProcesses]);
  }

  public function bomListDelete(Request $request)
  {
    $id = $request->id;
    PlaningOrderMaterials::where('id', $id)->delete();
    echo 'success';
  }


  public function bomListEdit(Request $request)
  {
    $rawData = PlaningOrderMaterials::where('id', '=', $request->id)->first();
    $PlaningOrderMaterials = $rawData->toArray();
    return response()->json(['success' => true, 'PlaningOrderMaterials' => $PlaningOrderMaterials]);
  }


  public function requestPO(Request $request)
  {
    $item_id = $request->item_id;
    $order_planing_id = $request->order_planing_id;
    $qty = $request->qty;

    try {
      $poPlaningOrder = new PoPlaningOrders([
        'item_id' => intval($item_id),
        'order_planing_id' => intval($order_planing_id),
        'qty' => intval($qty)
      ]);
      $poPlaningOrder->save();
      return 'success';
    } catch (\Exception $e) {
      return $e->getMessage(); // or log the error for further investigation
    }
  }
}
