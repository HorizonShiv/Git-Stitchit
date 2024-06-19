<?php

namespace App\Http\Controllers\apps;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Department;
use App\Models\JobOrders;
use App\Models\JobOrderParameters;
use App\Models\OrderJobCard;
use App\Models\PlaningOrders;
use App\Models\ProcessMaster;
use App\Models\SalesOrderParameters;
use App\Models\SalesOrders;
use App\Models\SalesOrderStyleInfo;
use App\Models\Setting;
use App\Models\StyleCategory;
use App\Models\StyleSubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OrderJobCardController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function JobCardReportPrint($id)
  {
    $JobOrders = JobOrders::with('JobOrderParameters', 'SalesOrderStyleInfo.StyleMaster.StyleMasterProcesses.ProcessMaster', 'SalesOrders')->where('id', $id)->first();
    $PlaningOrders = PlaningOrders::where("id", $JobOrders->planing_order_id)->with('PlaningOrderProcesses', 'SalesOrderStyleInfo', 'SalesOrders', 'JobOrders')->first();
    $groupedSizes = $JobOrders->JobOrderParameters->groupBy('size');
    $groupedColors = $JobOrders->JobOrderParameters->groupBy('color');

    if ($JobOrders->type == 'regular') {
      $StyleData = $JobOrders->SalesOrderStyleInfo->StyleMaster;
    } else {
      $StyleData = $JobOrders->StyleMaster;
    }

    $directory = public_path('/samplePhoto/' . $StyleData->id . '/');
    $SamplePhotos = [];
    // if (is_dir(public_path($directory))) {

    if (file_exists($directory)) {

      $files = File::files($directory);
      foreach ($files as $file) {
        $SamplePhotos[$file->getFilename()] = asset('/samplePhoto/' . $StyleData->id . '/' . $file->getFilename());
      }
    }

    return view('content.order-job-card.printReport', compact("JobOrders", "groupedSizes", "groupedColors", "PlaningOrders", "SamplePhotos"));
  }

  public function index()
  {
    $PlaningOrders = PlaningOrders::where("status", "pending")->with('PlaningOrderProcesses', 'SalesOrderStyleInfo', 'SalesOrders', 'JobOrders')->get();
    return view('content.order-job-card.pendinglist', compact("PlaningOrders"));
  }

  public function list()
  {
    $customers = Customer::all();
    $designers = User::where('role', '=', 'designer')->get();
    $styleCategories = StyleCategory::all();
    $styleSubCategories = StyleSubCategory::all();
    $ProcessMasters = ProcessMaster::all();
    $Departments = Department::all();

    $data["customers"] = $customers;
    $data["designers"] = $designers;
    $data["styleCategories"] = $styleCategories;
    $data["styleSubCategories"] = $styleSubCategories;
    $data["ProcessMasters"] = $ProcessMasters;
    $data["Departments"] = $Departments;

    //$JobOrders = JobOrders::with('SalesOrderStyleInfo.StyleMaster.StyleCategory', 'SalesOrderStyleInfo.StyleMaster.StyleSubCategory', 'SalesOrders')->get();
    return view('content.order-job-card.list', compact("data"));
  }

  public function listAjax(Request $request)
  {
    $JobQuery = JobOrders::query();

    if (!empty($request->category)) {
      $JobQuery->whereHas('SalesOrderStyleInfo.StyleMaster.StyleCategory', function ($query) use ($request) {
        $query->where('id', $request->category);
      });
    }

    if (!empty($request->subcategory)) {
      $JobQuery->whereHas('SalesOrderStyleInfo.StyleMaster.StyleSubCategory', function ($query) use ($request) {
        $query->where('id', $request->subcategory);
      });
    }

    if (!empty($request->Department)) {
      $JobQuery->whereHas('IssueManage', function ($query) use ($request) {
        $query->where('department_id', $request->Department);
        $query->orderBy('id', "desc");
      });
    }

    if (!empty($request->ProcessMaster)) {
      $JobQuery->whereHas('IssueManage.Department', function ($query) use ($request) {
        $query->where('process_master_id', $request->ProcessMaster);
      });
    }

    if (!empty($request->company)) {
      $JobQuery->whereHas('SalesOrders', function ($query) use ($request) {
        $query->where('customer_id', $request->company);
      });
    }

    if (!empty($request->designer)) {
      $JobQuery->whereHas('SalesOrderStyleInfo.StyleMaster', function ($query) use ($request) {
        $query->where('designer_id', $request->designer);
      });
    }

    if (!empty($request['startDate']) && !empty($request['endDate'])) {
      $startDate = date('Y-m-d', strtotime($request['startDate']));
      $endDate = date('Y-m-d', strtotime($request['endDate']));
      $JobQuery->whereBetween('job_orders.date', [$startDate, $endDate]);
    }

    if (!empty($request->type)) {
      $JobQuery->where('job_orders.type', $request->type);
    }

    $JobOrders = $JobQuery->OrderBy("job_orders.date", "desc")->get();

    $result = array("data" => array());
    if ($JobOrders != null) {
      $num = 1;

      foreach ($JobOrders as $JobOrder) {
        if ($JobOrder->type == 'regular') {
          $SalesOrderStyle = $JobOrder->SalesOrderStyleInfo;
        } else {
          $SalesOrderStyle = $JobOrder;
        }
        $date = Helpers::formateDate($JobOrder->date);

        if ($JobOrder->type == 'regular') {
          $jobOrderNo = '<a class="waves-effect mx-1"
                                        href="' . route('order-job-card.view', $JobOrder->id) . '">#' . $JobOrder->job_order_no . '</a>';
        } else {
          $jobOrderNo = '<a class="waves-effect mx-1"
                                        href="' . route('order-job-card.sample.view', $JobOrder->id) . '">#' . $JobOrder->job_order_no . '</a>';
        }
        $companyHtml = "";
        if (!empty($JobOrder->SalesOrders->Customer[0]->company_name)) {
          $companyHtml .= '<div class="d-flex justify-content-start align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-2"><span
                        class="avatar-initial rounded-circle bg-label-info">' . substr($JobOrder->SalesOrders->Customer[0]->company_name ?? '-', 0, 2) . '</span>
                    </div>
                  </div>
                  <div class="d-flex flex-column"><span
                      class="fw-medium">' . ($JobOrder->SalesOrders->Customer[0]->company_name ?? '') . '</span><small
                      class="text-truncate text-muted">' . ($JobOrder->SalesOrders->Customer[0]->buyer_name ?? '') . '</small>
                  </div>
                </div>';
        } else {
          $companyHtml .= '<span class="badge rounded bg-label-danger">-</span>';
        }


        $processHtml = "";
        if (!empty($JobOrder->IssueManage[0]->Department->ProcessMaster->name)) {
          $lastIssueManage = $JobOrder->IssueManage->last();
          $processHtml .= '<div class="d-flex justify-content-start align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-2"><span
                        class="avatar-initial  bg-label-warning">' . substr($lastIssueManage->Department->ProcessMaster->name ?? '-', 0, 2) . '</span>
                    </div>
                  </div>
                  <div class="d-flex flex-column"><span
                      class="fw-medium">' . ($lastIssueManage->Department->ProcessMaster->name ?? '') . '</span><small
                      class="text-truncate text-muted">' . ($lastIssueManage->Department->name ?? '') . '</small>
                  </div>
                </div>';
        } else {
          $processHtml .= '<span class="badge rounded bg-label-danger">-</span>';
        }


        $dHtml = "";
        if (!empty($SalesOrderStyle->StyleMaster->designer_name)) {
          $dHtml .= '<div class="d-flex justify-content-start align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-2"><span
                        class="avatar-initial rounded-circle bg-label-dark">' . substr($SalesOrderStyle->StyleMaster->designer_name ?? ' - ', 0, 2) . '</span>
                    </div>
                  </div>
                  <div class="d-flex flex-column"><span
                      class="fw-medium">' . ($SalesOrderStyle->StyleMaster->designer_name ?? '') . '</span>
                  </div>
                </div>';
        } else {
          $dHtml .= '<span class="badge rounded bg-label-danger">-</span>';
        }
        $attachmentHtml = "";
        $validate = ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'];
        if (!empty($SalesOrderStyle->StyleMaster->sample_photo)) {
          $file_extension = pathinfo(
            $SalesOrderStyle->StyleMaster->sample_photo,
            PATHINFO_EXTENSION,
          );
          if (in_array($file_extension, $validate)) {
            $attachmentHtml .= '<a href="' . Helpers::getSamplePhoto($SalesOrderStyle->StyleMaster->id, $SalesOrderStyle->StyleMaster->sample_photo) . '">
                    <img height="80"
                         src="' . Helpers::getSamplePhoto($SalesOrderStyle->StyleMaster->id, $SalesOrderStyle->StyleMaster->sample_photo) . '"
                         alt="">
                  </a>';
          } else {
            $attachmentHtml .= '<a download class="btn btn-icon btn-label-primary waves-effect"
                     href = "' . Helpers::getSamplePhoto($SalesOrderStyle->StyleMaster->id, $SalesOrderStyle->StyleMaster->sample_photo) . '" ><i
                      class="ti ti-download ti-sm" ></i ></a >';
          }
        } else {
          $attachmentHtml .= '<span class="badge rounded bg-label-danger">-</span>';
        }
        $styleNo = $SalesOrderStyle->StyleMaster->style_no ?? "";
        $JobOrderQty = $JobOrder->qty;

        $catSubCateHtml = '<div class="d-flex flex-column"><span
                  class="fw-medium">' . ($SalesOrderStyle->StyleMaster->StyleCategory->name ?? "") . '</span><small
                  class="text-truncate text-muted">' . ($SalesOrderStyle->StyleMaster->StyleSubCategory->name ?? "") . '</small>
              </div>';

        $jobType = '<span class="badge rounded bg-label-' . (($JobOrder->type == "regular") ? 'primary' : "warning") . '">' . ucfirst($JobOrder->type) . '</span>';


        $fileHtml = '';
        if (!empty($SalesOrderStyle->StyleMaster->sample_photo)) {
          $fileHtml .= '<a class="btn btn-icon btn-label-success mt-1 waves-effect"
                   href="' . Helpers::getSamplePhoto($SalesOrderStyle->StyleMaster->id, $SalesOrderStyle->StyleMaster->sample_photo) . '"
                   target="_blank" title="Sample Photo">
                <i class="ti ti-camera mx-2 ti-sm"></i></a>';
        }
        if (!empty($SalesOrderStyle->StyleMaster->tech_pack)) {

          $fileHtml .= '<a class="btn btn-icon btn-label-info mt-1 waves-effect"
                 href="' . Helpers::getTechPack($SalesOrderStyle->StyleMaster->id, $SalesOrderStyle->StyleMaster->tech_pack) . '"
                 target="_blank" title="Tech Pack">
                <i class="ti ti-ruler mx-2 ti-sm"></i></a>';
        }
        if (!empty($SalesOrderStyle->StyleMaster->trim_card)) {
          $fileHtml .= '<a class="btn btn-icon btn-label-dark mt-1 waves-effect"
                 href="' . Helpers::getTrimCard($SalesOrderStyle->StyleMaster->id, $SalesOrderStyle->StyleMaster->trim_card) . '"
                 target="_blank" title="Trim Card"><i class="ti ti-cut mx-2 ti-sm"></i></a>';
        }
        $actionHtml = "";
        $actionHtml .= ' <a class="btn btn-icon btn-label-primary mt-1 waves-effect mx-1"
                 href="' . route('JobCardReportPrint', $JobOrder->id) . '"><i class="ti ti-printer ti-sm"></i></a>';
        if ($JobOrder->type == 'regular') {
          $actionHtml .= '<a class="btn btn-icon btn-label-primary mt-1 waves-effect mx-1" href="' . route('order-job-card.edit', $JobOrder->id) . '"><i
                    class="ti ti-edit ti-sm"></i></a>';
        } else {
          $actionHtml .= '<a class="btn btn-icon btn-label-primary mt-1 waves-effect mx-1"
                   href = "' . route('order-job-card.sample.edit', $JobOrder->id) . '" ><i
                    class="ti ti-edit ti-sm" ></i ></a >';
        }

        if ($JobOrder->type == 'regular') {
          $actionHtml .= '<a class="btn btn-icon btn-label-primary mt-1 waves-effect mx-1"
                                        href="' . route('order-job-card.view', $JobOrder->id) . '"><i
                                            class="ti ti-eye ti-sm"></i></a>';
        } else {
          $actionHtml .= '<a class="btn btn-icon btn-label-primary mt-1 waves-effect mx-1"
                                        href="' . route('order-job-card.sample.view', $JobOrder->id) . '"><i
                                            class="ti ti-eye ti-sm"></i></a>';
        }

        $actionHtml .= '<button type="button" class="btn btn-icon btn-label-danger mt-1 mx-1"
                      onclick="deleteSalesOrder(' . $JobOrder->id . ')"><i
                  class="ti ti-trash mx-2 ti-sm"></i></button>';

        $actionHtml .= '<button type="button" class="btn btn-icon btn-label-warning mt-1 mx-1"
                      onclick="viewIssueModel(' . $JobOrder->id . ')"><i
                  class="ti ti-transfer-in mx-2 ti-sm"></i></button>';

        $actionHtml .= '<a class="btn btn-icon btn-label-success mt-1 mx-1"
                      href="' . route('issue.all-index', $JobOrder->id) . '"><i
                  class="ti ti-history mx-2 ti-sm"></i></button>';

        $result["data"][] = array($num, $date, $jobOrderNo, $companyHtml, $dHtml, $attachmentHtml, $styleNo, $JobOrderQty, $catSubCateHtml, $processHtml, $jobType, $fileHtml, $actionHtml);
        $num++;
      }
    }
    echo json_encode($result);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create($planing_order_id)
  {
    $planingOrder = PlaningOrders::with([
      "SalesOrders",
      "SalesOrderStyleInfo.StyleMaster",
      "PlaningOrderMaterials.Item",
      "PlaningOrderProcesses.ProcessMaster",
      "JobOrders"
    ])->where("id", $planing_order_id)->first();

    $JobOrderQtyOld = 0;
    $htmlTableOld = '';
    $JobOrderData = [];
    $Checker = 0;
    if ($planingOrder->JobOrders->isNotEmpty()) {
      $htmlTableOld .= '<div>
      <table id="SizeRatios" class="table border table-responsive mb-0">';
      foreach ($planingOrder->JobOrders as $JobOrders) {

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

        $firstIndex = 1;

        foreach ($groupedColorJobOrder as $colorKey => $colorwiseData) {
          $JobOrderQtyOld = $JobOrderQtyOld + $colorwiseData->sum('qty');
          $colorwiseQtyData = $colorwiseData->sum('qty');
          $htmlTableOld .= '<tbody>
                        <tr><td rowspan="2" class="border">' . $colorKey . '</td><td class="text-primary">Qty</td>';
          $counterQty = 0;

          foreach ($groupedSizesJobOrder as $size => $groupedSize) {
            $htmlTableOld .= '
                  <td class="border">' . array_column($colorwiseData->toArray(), 'qty')[$counterQty] . '</td>';
            $JobOrderData[$colorKey][$counterQty] = array_column($colorwiseData->toArray(), 'qty')[$counterQty];
            $counterQty++;
          }

          $htmlTableOld .= '<td rowspan="2">' . $colorwiseQtyData . '</td></tr>';
        }

        $Checker++;
      }
      $htmlTableOld .= '</table></div>';
    }

    $salesOrderParameters = SalesOrderParameters::where('sales_order_style_id', '=', $planingOrder->sales_order_style_id)->get();
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
      $JobOrderParametersData = JobOrderParameters::whereHas('JobOrders', function ($query) use ($planing_order_id) {
        $query->where('planing_order_id', $planing_order_id);
      })->where("color", $colorKey)->get();

      $resultDetails = $JobOrderParametersData->groupBy('size')->map(function ($item, $key) {
        return $item->sum('qty');
      });

      $colorwiseQtyData = $colorwiseData->sum('planned_qty');
      $htmlTable .= '<tbody>
                        <tr><td rowspan="2" class="border">' . $colorKey . '</td><td class="text-primary">Qty</td>';

      $counterQty = 0;
      foreach ($groupedSizes as $size => $groupedSize) {
        if (!empty($resultDetails[$size])) {
          $minusChecker[] = $resultDetails[$size];
        } else {
          $minusChecker[] = 0;
        }
        $htmlTable .= '
              <td class="border"><input class="form-control" type="number" onkeyup="calculateTotalSum(); setSiderSum(\'' . $colorKey . '\');" name="SizeWiseQty[' . $colorKey . '][' . $size . ']" value="' . max(0, array_column($colorwiseData->toArray(), 'planned_qty')[$counterQty] - ($resultDetails[$size] ?? 0)) . '" ></td>';
        $counterQty++;
      }
      $htmlTable .= '
      <td rowspan="2" id="colorwiseQtyData_' . $colorKey . '">' . $colorwiseQtyData . '</td></tr>';

      $htmlTable .= '<tr><td class="text-primary">Available Qty</td>';
      $counterQty = 0;
      foreach ($colorwiseData as $CheckKey => $data) {
        $htmlTable .= '
              <td class="border">' . max(0, $data->planned_qty - ($minusChecker[$CheckKey] ?? 0)) . '</td>';
        $counterQty++;
      }
      $htmlTable .= '<td></td></tr>
      </tbody>';
    }
    // dd($htmlTable);
    $htmlTable .= '</table></div>';
    return view('content.order-job-card.create', compact("planingOrder", "htmlTable", "htmlTableOld", "JobOrderQtyOld"));
  }

  public function createBySaleOrder()
  {
    $planingSaleOrderIds = PlaningOrders::pluck('sale_order_id')->all();
    $saleOrders = SalesOrders::whereNotIn("id", $planingSaleOrderIds)->get();
    return view('content.order-job-card.create-sale-order', compact("saleOrders"));
  }

  public function sampleCreate()
  {
    $StyleMasters = \App\Models\StyleMaster::orderBy('id', 'desc')->get();
    return view('content.order-job-card.sample-create', compact("StyleMasters"));
  }

  public function sampleEdit($id)
  {
    $JobOrders = JobOrders::with('SalesOrderStyleInfo.StyleMaster')->where('id', $id)->first();
    return view('content.order-job-card.sample-edit', compact("JobOrders"));
  }

  public function sampleView($id)
  {
    $JobOrders = JobOrders::with('SalesOrderStyleInfo.StyleMaster')->where('id', $id)->first();
    return view('content.order-job-card.sample-view', compact("JobOrders"));
  }

  public function sampleUpdate(Request $request, $id)
  {
    $request->validate([
      'StyleNo' => 'required|string|max:250',
    ]);
    $StyleNo = $request->StyleNo;

    JobOrders::where('id', $id)->update([
      'type' => "sample",
      'date' => $request->sampleDate,
      'sales_order_style_id' => $StyleNo,
      'note' => $request->note,
      'qty' => $request->TotalQty,
      'rate' => $request->Rate,
      'cad_desc' => $request->cad_desc,
      'cutting_desc' => $request->cutting_desc,
      'stitching_desc' => $request->stitching_desc,
      'washing_desc' => $request->washing_desc,
    ]);

    $jobOrderId = $id;

    if ($request->cad) {
      $this->validate(request(), [
        'cad.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->cad;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/jobOrders/' . $jobOrderId . '/');
      if (!is_dir(public_path('/jobOrders'))) {
        mkdir(public_path('/jobOrders'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      JobOrders::where('id', $jobOrderId)->update([
        "cad" => $new_file_name,
      ]);
    }

    if ($request->cutting) {
      $this->validate(request(), [
        'cutting.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->cutting;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/jobOrders/' . $jobOrderId . '/');
      if (!is_dir(public_path('/jobOrders'))) {
        mkdir(public_path('/jobOrders'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      JobOrders::where('id', $jobOrderId)->update([
        "cutting" => $new_file_name,
      ]);
    }

    if ($request->stitching) {
      $this->validate(request(), [
        'stitching.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->stitching;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/jobOrders/' . $jobOrderId . '/');
      if (!is_dir(public_path('/jobOrders'))) {
        mkdir(public_path('/jobOrders'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      JobOrders::where('id', $jobOrderId)->update([
        "stitching" => $new_file_name,
      ]);
    }

    if ($request->washing) {
      $this->validate(request(), [
        'washing.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->washing;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/jobOrders/' . $jobOrderId . '/');
      if (!is_dir(public_path('/jobOrders'))) {
        mkdir(public_path('/jobOrders'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      JobOrders::where('id', $jobOrderId)->update([
        "washing" => $new_file_name,
      ]);
    }

    return redirect()->route('order-job-list')->withSuccess('Successfully Done');
  }

  public function getSaleOrderDetails(Request $request)
  {
    $sale_id = $request->saleOrder;
    $salesOrderStyleInfos = SalesOrderStyleInfo::with('StyleMaster')->where("sales_order_id", $sale_id)->get();
    echo json_encode($salesOrderStyleInfos);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'StyleNo' => 'required|string|max:250',
    ]);

    $SalesOrderId = $request->salesOrderId;
    $planingOrderId = $request->planingOrderId;
    $StyleNo = $request->StyleNo;

    $ConditionCheker = false;
    $Setting = Setting::orderBy('id', 'desc')->where('auto_job_card_status', '1')->first();
    if (empty($Setting)) {
      $request->validate([
        'JobCardNumber' => 'required|string|max:250',
      ]);
    } else {
      $jobOrderDetails = $Setting->toArray();
      $jobOrderCount = $jobOrderDetails['job_order_no_set'] + 1;
      $jobOrderNo = $jobOrderDetails['job_order_pre_fix'] . '' . $jobOrderCount;

      Setting::where('id', 1)->where('auto_job_card_status', '1')->update([
        'job_order_no_set' => $jobOrderCount,
      ]);
    }
    // foreach ($request->SizeWiseQty as $ColorKey => $Color) {
    //   foreach ($Color as $QtyKey => $Qty) {
    //     if ($Qty > 0) {
    //       $ConditionCheker = true;
    //     }
    //   }
    // }
    $ConditionCheker = true;

    if ($ConditionCheker == true) {


      $jobOrders = new JobOrders([
        'date' => $request->JobOrderDate,
        'planing_order_id' => $planingOrderId,
        'sale_order_id' => $SalesOrderId,
        'job_order_no' => $request->JobCardNumber,
        'sales_order_style_id' => $request->StyleNo,
        'note' => $request->note,
        'cad_desc' => $request->cad_desc,
        'cutting_desc' => $request->cutting_desc,
        'stitching_desc' => $request->stitching_desc,
        'qty' => $request->Qty,
        'rate' => $request->Rate,
        'washing_desc' => $request->washing_desc,
      ]);
      $jobOrders->save();

      foreach ($request->SizeWiseQty as $ColorKey => $Color) {
        foreach ($Color as $QtyKey => $Qty) {
          // if ($Qty > 0) {
          $JobOrderParameters = new JobOrderParameters([
            'job_order_id' => $jobOrders->id,
            'sales_order_style_id' => $request->StyleNo,
            'color' => $ColorKey,
            'qty' => $Qty,
            'size' => $QtyKey,
          ]);
          $JobOrderParameters->save();
          // }
        }
      }

      $jobOrderId = $jobOrders->id;

      if ($request->cad) {
        $this->validate(request(), [
          'cad.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->cad;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/jobOrders/' . $jobOrderId . '/');
        if (!is_dir(public_path('/jobOrders'))) {
          mkdir(public_path('/jobOrders'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);

        JobOrders::where('id', $jobOrderId)->update([
          "cad" => $new_file_name,
        ]);
      }

      if ($request->cutting) {
        $this->validate(request(), [
          'cutting.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->cutting;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/jobOrders/' . $jobOrderId . '/');
        if (!is_dir(public_path('/jobOrders'))) {
          mkdir(public_path('/jobOrders'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);

        JobOrders::where('id', $jobOrderId)->update([
          "cutting" => $new_file_name,
        ]);
      }

      if ($request->stitching) {
        $this->validate(request(), [
          'stitching.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->stitching;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/jobOrders/' . $jobOrderId . '/');
        if (!is_dir(public_path('/jobOrders'))) {
          mkdir(public_path('/jobOrders'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);

        JobOrders::where('id', $jobOrderId)->update([
          "stitching" => $new_file_name,
        ]);
      }

      if ($request->washing) {
        $this->validate(request(), [
          'washing.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->washing;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/jobOrders/' . $jobOrderId . '/');
        if (!is_dir(public_path('/jobOrders'))) {
          mkdir(public_path('/jobOrders'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);

        JobOrders::where('id', $jobOrderId)->update([
          "washing" => $new_file_name,
        ]);
      }
    } else {
      return redirect()->route('order-job-list')->withErrors('Failed');
    }

    return redirect()->route('order-job-list')->withSuccess('Successfully Done');
  }

  public function storeBySaleOrder(Request $request)
  {
    $request->validate([
      'StyleNo' => 'required',
      'saleOrder' => 'required',
    ]);

    $SalesOrderId = $request->saleOrder;
    $StyleNo = $request->StyleNo;

    $Setting = Setting::orderBy('id', 'desc')->where('auto_job_card_status', '1')->first();
    if (empty($Setting)) {
      $request->validate([
        'JobCardNumber' => 'required|string|max:250',
      ]);
    } else {
      $jobOrderDetails = $Setting->toArray();
      $jobOrderCount = $jobOrderDetails['job_order_no_set'] + 1;
      Setting::where('id', 1)->where('auto_job_card_status', '1')->update([
        'job_order_no_set' => $jobOrderCount,
      ]);
    }

    $jobOrders = new JobOrders([
      'date' => $request->JobOrderDate,
      'sale_order_id' => $SalesOrderId,
      'job_order_no' => $request->JobCardNumber,
      'sales_order_style_id' => $StyleNo,
      'note' => $request->note,
      'cad_desc' => $request->cad_desc,
      'cutting_desc' => $request->cutting_desc,
      'stitching_desc' => $request->stitching_desc,
      'qty' => $request->Qty,
      'washing_desc' => $request->washing_desc,
    ]);
    $jobOrders->save();

    foreach ($request->SizeWiseQty as $ColorKey => $Color) {
      foreach ($Color as $QtyKey => $Qty) {
        $Qty = ($Qty < 0) ? 0 : $Qty;
        if ($Qty >= 0) {
          $JobOrderParameters = new JobOrderParameters([
            'job_order_id' => $jobOrders->id,
            'sales_order_style_id' => $StyleNo,
            'color' => $ColorKey,
            'qty' => $Qty,
            'size' => $QtyKey,
          ]);
          $JobOrderParameters->save();
        }
      }
    }

    $jobOrderId = $jobOrders->id;

    if ($request->cad) {
      $this->validate(request(), [
        'cad.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->cad;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/jobOrders/' . $jobOrderId . '/');
      if (!is_dir(public_path('/jobOrders'))) {
        mkdir(public_path('/jobOrders'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      JobOrders::where('id', $jobOrderId)->update([
        "cad" => $new_file_name,
      ]);
    }

    if ($request->cutting) {
      $this->validate(request(), [
        'cutting.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->cutting;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/jobOrders/' . $jobOrderId . '/');
      if (!is_dir(public_path('/jobOrders'))) {
        mkdir(public_path('/jobOrders'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      JobOrders::where('id', $jobOrderId)->update([
        "cutting" => $new_file_name,
      ]);
    }

    if ($request->stitching) {
      $this->validate(request(), [
        'stitching.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->stitching;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/jobOrders/' . $jobOrderId . '/');
      if (!is_dir(public_path('/jobOrders'))) {
        mkdir(public_path('/jobOrders'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      JobOrders::where('id', $jobOrderId)->update([
        "stitching" => $new_file_name,
      ]);
    }

    if ($request->washing) {
      $this->validate(request(), [
        'washing.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->washing;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/jobOrders/' . $jobOrderId . '/');
      if (!is_dir(public_path('/jobOrders'))) {
        mkdir(public_path('/jobOrders'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      JobOrders::where('id', $jobOrderId)->update([
        "washing" => $new_file_name,
      ]);
    }

    return redirect()->route('order-job-list')->withSuccess('Successfully Done');
  }


  public function sampleStore(Request $request)
  {
    $request->validate([
      'StyleNo' => 'required|string|max:250',
    ]);
    $StyleNo = $request->StyleNo;
    $Setting = Setting::orderBy('id', 'desc')->first();

    $jobOrderDetails = $Setting->toArray();
    $jobOrderCount = $jobOrderDetails['job_order_no_set'] + 1;
    $jobOrderNo = $jobOrderDetails['job_order_pre_fix'] . '' . $jobOrderCount;

    $jobOrders = new JobOrders([
      'type' => "sample",
      'date' => $request->sampleDate,
      'job_order_no' => $jobOrderNo,
      'sales_order_style_id' => $StyleNo,
      'note' => $request->note,
      'qty' => $request->TotalQty,
      'rate' => $request->Rate,
      'cad_desc' => $request->cad_desc,
      'cutting_desc' => $request->cutting_desc,
      'stitching_desc' => $request->stitching_desc,
      'washing_desc' => $request->washing_desc,
    ]);
    $jobOrders->save();

    Setting::where('id', 1)->update([
      'job_order_no_set' => $jobOrderCount,
    ]);
    $jobOrderId = $jobOrders->id;

    if ($request->cad) {
      $this->validate(request(), [
        'cad.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->cad;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/jobOrders/' . $jobOrderId . '/');
      if (!is_dir(public_path('/jobOrders'))) {
        mkdir(public_path('/jobOrders'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      JobOrders::where('id', $jobOrderId)->update([
        "cad" => $new_file_name,
      ]);
    }

    if ($request->cutting) {
      $this->validate(request(), [
        'cutting.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->cutting;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/jobOrders/' . $jobOrderId . '/');
      if (!is_dir(public_path('/jobOrders'))) {
        mkdir(public_path('/jobOrders'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      JobOrders::where('id', $jobOrderId)->update([
        "cutting" => $new_file_name,
      ]);
    }

    if ($request->stitching) {
      $this->validate(request(), [
        'stitching.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->stitching;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/jobOrders/' . $jobOrderId . '/');
      if (!is_dir(public_path('/jobOrders'))) {
        mkdir(public_path('/jobOrders'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      JobOrders::where('id', $jobOrderId)->update([
        "stitching" => $new_file_name,
      ]);
    }

    if ($request->washing) {
      $this->validate(request(), [
        'washing.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->washing;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/jobOrders/' . $jobOrderId . '/');
      if (!is_dir(public_path('/jobOrders'))) {
        mkdir(public_path('/jobOrders'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      JobOrders::where('id', $jobOrderId)->update([
        "washing" => $new_file_name,
      ]);
    }

    return redirect()->route('order-job-list')->withSuccess('Successfully Done');
  }

  /**
   * Display the specified resource.
   */
  public function show(OrderJobCard $orderJobCard)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $JobOrders = JobOrders::with('JobOrderParameters')->where('id', $id)->first();

    $planingOrder = PlaningOrders::with([
      "SalesOrders",
      "SalesOrderStyleInfo.StyleMaster",
      "PlaningOrderMaterials.Item",
      "PlaningOrderProcesses.ProcessMaster"
    ])->where("id", $JobOrders->planing_order_id)->first();

    // dd($JobOrders->JobOrderParameters->toArray());

    $JobOrderQtyOld = 0;
    $htmlTable = '';
    if ($JobOrders->JobOrderParameters->isNotEmpty()) {

      $htmlTable .= '<div>
        <table id="SizeRatios" class="table border table-responsive mb-0">
        <thead>
        <tr><th class="border text-primary">Color</th><th class="text-primary">Size</th>';
      $JobOrderParameters = JobOrderParameters::where('job_order_id', '=', $id)->get();

      $groupedSizesJobOrder = $JobOrderParameters->groupBy('size');
      $groupedColorJobOrder = $JobOrderParameters->groupBy('color');
      // dd($groupedSizesJobOrder);

      foreach ($groupedSizesJobOrder as $size => $groupedSize) {
        $htmlTable .= '<th class="border">' . $size . '</th>';
      }
      $htmlTable .= '<th class="border text-primary" colspan="2">Total</th></tr></thead>';

      $firstIndex = 1;

      foreach ($groupedColorJobOrder as $colorKey => $colorwiseData) {
        $JobOrderQtyOld = $JobOrderQtyOld + $colorwiseData->sum('qty');
        $colorwiseQtyData = $colorwiseData->sum('qty');
        $htmlTable .= '<tbody>
                        <tr><td rowspan="2" class="border">' . $colorKey . '</td><td class="text-primary">Qty</td>';
        $counterQty = 0;

        // dd($groupedSizesJobOrder);
        foreach ($colorwiseData as $size => $groupedSize) {
          $htmlTable .= '<td class="border"><input class="form-control" type="text" onkeyup="calculateTotalSum()" name="SizeWiseQty[' . $colorKey . '][' . $size . ']" value="' . $groupedSize->qty . '" ><input type="hidden" name="JobOrderParameters[' . $colorKey . '][' . $size . ']" value="' . $groupedSize->id . '" ></td>';
          $counterQty++;
        }

        $htmlTable .= '<td rowspan="2">' . $colorwiseQtyData . '</td></tr>';
        $htmlTable .= '<tr><td class="text-primary">Available Qty</td>';
        foreach ($colorwiseData as $data) {
          $htmlTable .= '
                <td class="border">' . $data->qty . '</td>';
        }
        $htmlTable .= '<td></td></tr>
        </tbody>';
      }


      $htmlTable .= '</table></div>';
    }
    return view('content.order-job-card.edit', compact("planingOrder", "htmlTable", "JobOrders"));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {

    $JobOrders = JobOrders::where('id', $id)->update([
      'date' => $request->JobOrderDate,
      'sales_order_style_id' => $request->StyleNo,
      'note' => $request->note,
      'cad_desc' => $request->cad_desc,
      'cutting_desc' => $request->cutting_desc,
      'stitching_desc' => $request->stitching_desc,
      'qty' => $request->Qty,
      'rate' => $request->Rate,
      'washing_desc' => $request->washing_desc,
    ]);

    foreach ($request->SizeWiseQty as $ColorKey => $Color) {
      foreach ($Color as $SizeKey => $Qty) {
        $JobOrderParameters = JobOrderParameters::where('id', $request->JobOrderParameters[$ColorKey][$SizeKey])->update([
          'sales_order_style_id' => $request->StyleNo,
          'color' => $ColorKey,
          'qty' => $Qty,
          'size' => $SizeKey,
        ]);
      }
    }

    if ($request->cad) {
      $this->validate(request(), [
        'cad.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->cad;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/jobOrders/' . $id . '/');
      if (!is_dir(public_path('/jobOrders'))) {
        mkdir(public_path('/jobOrders'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      JobOrders::where('id', $id)->update([
        "cad" => $new_file_name,
      ]);
    }

    if ($request->cutting) {
      $this->validate(request(), [
        'cutting.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->cutting;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/jobOrders/' . $id . '/');
      if (!is_dir(public_path('/jobOrders'))) {
        mkdir(public_path('/jobOrders'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      JobOrders::where('id', $id)->update([
        "cutting" => $new_file_name,
      ]);
    }

    if ($request->stitching) {
      $this->validate(request(), [
        'stitching.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->stitching;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/jobOrders/' . $id . '/');
      if (!is_dir(public_path('/jobOrders'))) {
        mkdir(public_path('/jobOrders'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      JobOrders::where('id', $id)->update([
        "stitching" => $new_file_name,
      ]);
    }

    if ($request->washing) {
      $this->validate(request(), [
        'washing.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->washing;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/jobOrders/' . $id . '/');
      if (!is_dir(public_path('/jobOrders'))) {
        mkdir(public_path('/jobOrders'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      JobOrders::where('id', $id)->update([
        "washing" => $new_file_name,
      ]);
    }

    return redirect()->route('order-job-list')->withSuccess('Successfully Done');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(OrderJobCard $orderJobCard)
  {
    //
  }

  public function view($id)
  {
    $JobOrders = JobOrders::with('JobOrderParameters')->where('id', $id)->first();

    $planingOrder = PlaningOrders::with([
      "SalesOrders",
      "SalesOrderStyleInfo.StyleMaster",
      "PlaningOrderMaterials.Item",
      "PlaningOrderProcesses.ProcessMaster",
      "JobOrders",
    ])->where("id", $JobOrders->planing_order_id)->first();

    $JobOrderQtyOld = 0;
    $htmlTable = '';
    $JobOrderData = [];
    if ($JobOrders->JobOrderParameters->isNotEmpty()) {

      $htmlTable .= '<div>
        <table id="SizeRatios" class="table border table-responsive mb-0">
        <thead>
        <tr><th class="border text-primary">Color</th><th class="text-primary">Size</th>';
      $JobOrderParameters = JobOrderParameters::where('job_order_id', '=', $id)->get();

      $groupedSizesJobOrder = $JobOrderParameters->groupBy('size');
      $groupedColorJobOrder = $JobOrderParameters->groupBy('color');
      // dd($groupedSizesJobOrder);

      foreach ($groupedSizesJobOrder as $size => $groupedSize) {
        $htmlTable .= '<th class="border">' . $size . '</th>';
      }
      $htmlTable .= '<th class="border text-primary" colspan="2">Total</th></tr></thead>';

      $firstIndex = 1;

      foreach ($groupedColorJobOrder as $colorKey => $colorwiseData) {
        $JobOrderQtyOld = $JobOrderQtyOld + $colorwiseData->sum('qty');
        $colorwiseQtyData = $colorwiseData->sum('qty');
        $htmlTable .= '<tbody>
                        <tr><td rowspan="2" class="border">' . $colorKey . '</td><td class="text-primary">Qty</td>';
        $counterQty = 0;

        foreach ($groupedSizesJobOrder as $size => $groupedSize) {
          // dd($groupedSize[$counterQty]);
          $htmlTable .= '
                  <td class="border">' . array_column($colorwiseData->toArray(), 'qty')[$counterQty] . '</td>';
          $JobOrderData[$colorKey][$counterQty] = array_column($colorwiseData->toArray(), 'qty')[$counterQty];
          $counterQty++;
        }

        $htmlTable .= '<td rowspan="2">' . $colorwiseQtyData . '</td></tr>';
      }


      $htmlTable .= '</table></div>';
    }


    return view('content.order-job-card.view', compact("planingOrder", "htmlTable", "JobOrders"));
  }
}
