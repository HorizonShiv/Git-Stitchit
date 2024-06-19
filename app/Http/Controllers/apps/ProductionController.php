<?php

namespace App\Http\Controllers\apps;

use App\Helpers\Helpers;
use App\Models\Customer;
use App\Models\Department;
use App\Models\IssueManage;
use App\Models\IssueManageHistory;
use App\Models\IssueMaterials;
use App\Models\IssueParameters;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemSubCategory;
use App\Models\JobOrderParameters;
use App\Models\JobOrders;
use App\Models\ProcessMaster;
use App\Models\StyleCategory;
use App\Models\StyleSubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductionController extends Controller
{
  public function issueTo($id, $job_id, $imh_id = "")
  {
    $d_id = $id;
    $currentDepartmentQuery = Department::with("ProcessMaster")->where("id", $d_id)->first();
    $currentDepartmentName = $currentDepartmentQuery->name;
    $processMasterType = $currentDepartmentQuery->ProcessMaster->type;
    $hiddenCAD = "";
    $readOnlyCAD = "";
    $checkedCAD = "";
    $firstQtyName = "O Qty";
    $secondQtyName = "Qty";
    $isCAD = false;
    if (isset($currentDepartmentQuery->ProcessMaster) && $processMasterType == "cad") {
      $readOnlyCAD = "readonly";
      $checkedCAD = "checked";
      $hiddenCAD = "hidden";
      $isCAD = true;
      $firstQtyName = "O Qty";
      $secondQtyName = "C Qty";
    }
    $isPacking = false;
    $rowspan = 2;
    $readOnlyPacking = "";
    if (isset($currentDepartmentQuery->ProcessMaster) && $processMasterType == "packing") {
      $isPacking = true;
      $rowspan = 5;
      $firstQtyName = "Qty";
      $secondQtyName = "C Qty";
      $readOnlyPacking = "readonly";
    }

    $isCutting = false;
    if (isset($currentDepartmentQuery->ProcessMaster) && $processMasterType == "cutting") {
      $isCutting = true;
      $firstQtyName = "O Qty";
      $secondQtyName = "C Qty";
    }

    $isStitching = false;
    if (isset($currentDepartmentQuery->ProcessMaster) && $processMasterType == "stitching") {
      $isStitching = true;
      $firstQtyName = "I/W Qty";
      $secondQtyName = "O/W Qty";
    }

    $isWashing = false;
    if (isset($currentDepartmentQuery->ProcessMaster) && $processMasterType == "washing") {
      $isWashing = true;
      $firstQtyName = "I/W Qty";
      $secondQtyName = "O/W Qty";
    }
    $departments = Department::whereNotIn("id", [$d_id])->get();
    $serviceProviders = User::where('is_active', '1')->where('vendor_type', 'SERVICE')->where('role', 'vendor')->get();
    $JobOrders = JobOrders::with('JobOrderParameters', "SalesOrderStyleInfo")->where('id', $job_id)->first();
    if ($JobOrders->type == 'regular') {
      $StyleMaster = $JobOrders->SalesOrderStyleInfo->StyleMaster;
    } else {
      $StyleMaster = $JobOrders->StyleMaster;
    }
    $htmlTable = '';
    $JobOrderQtyOld = 0;
    if ($JobOrders->JobOrderParameters->isNotEmpty()) {

      $htmlTable .= '<div>
        <table id="SizeRatios" class="center table border table-responsive mb-4">
        <thead>
        <tr><th class="border text-dark text-center">Color</th><th class="text-dark text-center">Size</th>';

      if (!empty($imh_id)) {
        $JobOrderParameters = IssueParameters::where('issue_manage_history_id', $imh_id)->where('job_order_id', $job_id)->where('department_id', $d_id)->get();
      } else {
        $JobOrderParameters = JobOrderParameters::where('job_order_id', $job_id)->get();
      }
      $groupedSizesJobOrder = $JobOrderParameters->groupBy('size');
      $groupedColorJobOrder = $JobOrderParameters->groupBy('color');

      foreach ($groupedSizesJobOrder as $size => $groupedSize) {
        $htmlTable .= '<th class="border text-center">' . $size . '</th>';
      }
      $htmlTable .= '<th class="border text-dark text-center" colspan="2">ColorWise Total Qty</th></tr></thead>';

      foreach ($groupedColorJobOrder as $colorKey => $colorwiseData) {
        $JobOrderQtyOld = $JobOrderQtyOld + $colorwiseData->sum('qty');
        $colorwiseQtyData = $colorwiseData->sum('qty');
        $htmlTable .= '<tbody>
                        <tr>
                        <td rowspan="' . $rowspan . '" class="text-center h6 border"><input style="width: 25px; height: 25px;" ' . $hiddenCAD . ' type="checkbox" ' . $checkedCAD . ' onclick="calculateTotalSum()" name="colorWiseCheckBox[]" value="' . $colorKey . '" class="m-2"><br>' . $colorKey . '</td>

                        <td class="text-dark text-center">' . $firstQtyName . '</td>';
        foreach ($colorwiseData as $data) {
          $htmlTable .= '<td class="border bg-light">' . $data->qty . '</td>';
        }


        $htmlTable .= '<td class="text-center">' . $colorwiseQtyData . '</td></tr>';

        $htmlTable .= '<tr ' . $hiddenCAD . '>
         <td class="text-dark text-center">' . $secondQtyName . '</td>';
        $rowWiseQty = 0;
        foreach ($colorwiseData as $groupedSize) {
          $fetchOld = $this->issueToEditDataManage($job_id, $d_id, $colorKey);
          $rQty = $groupedSize->qty - ($fetchOld[$groupedSize->size] ?? 0);
          $rowWiseQty += $rQty;
          $htmlTable .= '<td class="border"><input ' . $readOnlyPacking . ' class="form-control" ' . $readOnlyCAD . ' type="number" onkeyup="calculateColorTotal(\'' . $colorKey . '\')" name="SizeWiseQty[' . $colorKey . '][' . $groupedSize->size . ']" value="' . $rQty . '" ></td>';
        }
        $htmlTable .= '<td class="text-dark text-center" id="TotalColor' . $colorKey . '">' . $rowWiseQty . '</td>';
        if ($isPacking) {
          $htmlTable .= '<tr>
         <td class="text-dark text-center">FS Qty</td>';
          foreach ($colorwiseData as $groupedSize) {
            $htmlTable .= '<td class="border"><input class="form-control" type="number" onkeyup="calculateColorTotal(\'' . $colorKey . '\')" name="FSSizeWiseQty[' . $colorKey . '][' . $groupedSize->size . ']" value="0"></td>';
          }
          $htmlTable .= '<td class="text-dark text-center" id="TotalColorFS' . $colorKey . '">0</td>';
          $htmlTable .= '<tr>
         <td class="text-dark text-center">SS Qty</td>';
          foreach ($colorwiseData as $groupedSize) {
            $htmlTable .= '<td class="border"><input class="form-control" type="number" onkeyup="calculateColorTotal(\'' . $colorKey . '\')" name="SSaleSizeWiseQty[' . $colorKey . '][' . $groupedSize->size . ']" value="0"></td>';
          }
          $htmlTable .= '<td class="text-dark text-center" id="TotalColorSS' . $colorKey . '">0</td>';
          $htmlTable .= '<tr>
         <td class="text-dark text-center">R Qty</td>';
          foreach ($colorwiseData as $groupedSize) {
            $htmlTable .= '<td class="border"><input class="form-control" type="number" onkeyup="calculateColorTotal(\'' . $colorKey . '\')" name="RejectSizeWiseQty[' . $colorKey . '][' . $groupedSize->size . ']" value="0"></td>';
          }
          $htmlTable .= '<td class="text-dark text-center" id="TotalColorR' . $colorKey . '">0</td>';
        }
        $htmlTable .= '</tr>
        </tbody>';
      }


      $htmlTable .= '</table></div>';
    }

    $itemMasters = Item::all();
    $categoryMasters = ItemCategory::all();
    $subcategoryMasters = ItemSubCategory::all();
    $htmlTableOld = $this->issueHistoryViewByJobId($job_id, $d_id);
    return view('content.production.issue-to', compact("processMasterType", "isCutting", "isPacking", "isCAD", "htmlTableOld", "StyleMaster", "JobOrders", "job_id", "d_id", "departments", "serviceProviders", "htmlTable", "StyleMaster", "itemMasters", "categoryMasters", "subcategoryMasters", "currentDepartmentName"));
  }

  public function issueToAfterProductionStart($d_id, $job_id, $imh_id)
  {
    $currentDepartmentName = Department::where("id", $d_id)->first()->name;
    $departments = Department::whereNotIn("id", [$d_id])->get();
    $serviceProviders = User::where('is_active', '1')->where('vendor_type', 'SERVICE')->where('role', 'vendor')->get();
    $JobOrders = JobOrders::with('JobOrderParameters', "SalesOrderStyleInfo")->where('id', $job_id)->first();
    $IssueManage = IssueManage::with('JobOrders.JobOrderParameters', "JobOrders.SalesOrderStyleInfo")->where('id', $job_id)->first();
    if ($JobOrders->JobOrders->type == 'regular') {
      $StyleMaster = $JobOrders->SalesOrderStyleInfo->StyleMaster;
    } else {
      $StyleMaster = $JobOrders->StyleMaster;
    }
    $htmlTable = '';
    $JobOrderQtyOld = 0;
    if ($JobOrders->JobOrderParameters->isNotEmpty()) {

      $htmlTable .= '<div>
        <table id="SizeRatios" class="center table border table-responsive mb-4">
        <thead>
        <tr><th class="border text-dark text-center">Color</th><th class="text-dark text-center">Size</th>';

      $JobOrderParameters = JobOrderParameters::where('job_order_id', $job_id)->get();
      $groupedSizesJobOrder = $JobOrderParameters->groupBy('size');
      $groupedColorJobOrder = $JobOrderParameters->groupBy('color');

      foreach ($groupedSizesJobOrder as $size => $groupedSize) {
        $htmlTable .= '<th class="border text-center">' . $size . '</th>';
      }
      $htmlTable .= '<th class="border text-dark text-center" colspan="2">ColorWise Total Qty</th></tr></thead>';

      foreach ($groupedColorJobOrder as $colorKey => $colorwiseData) {
        $JobOrderQtyOld = $JobOrderQtyOld + $colorwiseData->sum('qty');
        $colorwiseQtyData = $colorwiseData->sum('qty');
        $htmlTable .= '<tbody>
                        <tr>
                        <td rowspan="2" class="text-center h5 border"><input style="width: 25px; height: 25px;" type="checkbox" onclick="calculateTotalSum()" name="colorWiseCheckBox[]" value="' . $colorKey . '" class="m-2"><br>' . $colorKey . '</td><td class="text-dark text-center">Cut Qty</td>';
        foreach ($colorwiseData as $size => $groupedSize) {
          $htmlTable .= '<td class="border"><input class="form-control" type="text" onkeyup="calculateColorTotal(\'' . $colorKey . '\')" name="SizeWiseQty[' . $colorKey . '][' . $groupedSize->size . ']" value="' . $groupedSize->qty . '" ></td>';
        }

        $htmlTable .= '<td rowspan="2" class="text-center" id="TotalColor' . $colorKey . '">' . $colorwiseQtyData . '</td></tr>';
        $htmlTable .= '<tr><td class="text-dark text-center">Job Card  Qty</td>';
        foreach ($colorwiseData as $data) {
          $htmlTable .= '
                <td class="border bg-light">' . $data->qty . '</td>';
        }
        $htmlTable .= '</tr>
        </tbody>';
      }


      $htmlTable .= '</table></div>';
      $htmlTable . '<div class="row">';
      $htmlTable . '<div class="col-lg-8"></div>';
      $htmlTable . '<div class="col-lg-4">ss</div>';
      $htmlTable . '<div class="col-lg-8"></div>';
      $htmlTable . '<div class="col-lg-4">ss</div>';
      $htmlTable . '</div>';
    }

    $itemMasters = Item::all();
    $categoryMasters = ItemCategory::all();
    $subcategoryMasters = ItemSubCategory::all();
    $htmlTableOld = $this->issueHistoryViewByJobId($job_id, $d_id);

    return view('content.production.issue-to', compact("htmlTableOld", "StyleMaster", "JobOrders", "job_id", "d_id", "departments", "serviceProviders", "htmlTable", "StyleMaster", "itemMasters", "categoryMasters", "subcategoryMasters", "currentDepartmentName"));
  }

  public function index($id = "")
  {
    $processMaster = ProcessMaster::where("id", $id)->first();
    return view('content.production.index', compact("id", "processMaster"));
  }

  public function process()
  {
    return view('content.production.process');
  }


  public function processHistory($id)
  {
    $department = Department::where("id", $id)->first();

    $IssueManageHistory = IssueManageHistory::query();
    $IssueManageHistory->where('issueFrom', $id);
    $IssueManageHistories = $IssueManageHistory->orderBy("id", "desc")->get();

    $customers = Customer::all();
    $designers = User::where('role', '=', 'designer')->get();
    $styleCategories = StyleCategory::all();
    $styleSubCategories = StyleSubCategory::all();

    $data["customers"] = $customers;
    $data["designers"] = $designers;
    $data["styleCategories"] = $styleCategories;
    $data["styleSubCategories"] = $styleSubCategories;

    return view('content.production.history-list', compact("department", "IssueManageHistories", "data", "id"));
  }

  public function processHistoryAjax(Request $request)
  {
    $department_id = $request->Department;

    $IssueManageHistory = IssueManageHistory::query();
    $IssueManageHistory->where('issueFrom', $department_id);
    if (!empty($request->category)) {
      $IssueManageHistory->whereHas('IssueManage.JobOrders.SalesOrderStyleInfo.StyleMaster.StyleCategory', function ($query) use ($request) {
        $query->where('id', $request->category);
      });
    }

    if (!empty($request->subcategory)) {
      $IssueManageHistory->whereHas('IssueManage.JobOrders.SalesOrderStyleInfo.StyleMaster.StyleSubCategory', function ($query) use ($request) {
        $query->where('id', $request->subcategory);
      });
    }

    if (!empty($request->ProcessMaster)) {
      $IssueManageHistory->whereHas('IssueManage.Department', function ($query) use ($request) {
        $query->where('process_master_id', $request->ProcessMaster);
      });
    }

    if (!empty($request->company)) {
      $IssueManageHistory->whereHas('IssueManage.JobOrders.SalesOrders', function ($query) use ($request) {
        $query->where('customer_id', $request->company);
      });
    }

    if (!empty($request->designer)) {
      $IssueManageHistory->whereHas('IssueManage.JobOrders.SalesOrderStyleInfo.StyleMaster', function ($query) use ($request) {
        $query->where('designer_id', $request->designer);
      });
    }

    if (!empty($request['startDate']) && !empty($request['endDate'])) {
      $startDate = date('Y-m-d', strtotime($request['startDate']));
      $endDate = date('Y-m-d', strtotime($request['endDate']));
      $IssueManageHistory->whereBetween('issue_manage_histories.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
    }

    if (!empty($request->type)) {
      $IssueManageHistory->whereHas('IssueManage.JobOrders', function ($query) use ($request) {
        $query->where('job_orders.type', $request->type);
      });
    }

    $IssueManageHistories = $IssueManageHistory->OrderBy("issue_manage_histories.id", "desc")->get();

    $result = array("data" => array());
    if ($IssueManageHistories != null) {
      $num = 1;
      foreach ($IssueManageHistories as $IssueManageHistory) {
        if ($IssueManageHistory->IssueManage->JobOrders->type == 'regular') {
          $SalesOrderStyle = $IssueManageHistory->IssueManage->JobOrders->SalesOrderStyleInfo;
        } else {
          $SalesOrderStyle = $IssueManageHistory->IssueManage->JobOrders;
        }
        $date = Helpers::formateDateLong($IssueManageHistory->created_at);

        if ($IssueManageHistory->IssueManage->JobOrders->type == 'regular') {
          $jobOrderNo = '<a class="waves-effect mx-1"
                                        href="' . route('order-job-card.view', $IssueManageHistory->IssueManage->JobOrders->id) . '">#' . $IssueManageHistory->IssueManage->JobOrders->job_order_no . '</a>';
        } else {
          $jobOrderNo = '<a class="waves-effect mx-1"
                                        href="' . route('order-job-card.sample.view', $IssueManageHistory->IssueManage->JobOrders->id) . '">#' . $IssueManageHistory->IssueManage->JobOrders->job_order_no . '</a>';
        }
        $companyHtml = "";
        if (!empty($IssueManageHistory->IssueManage->JobOrders->SalesOrders->Customer[0]->company_name)) {
          $companyHtml .= '<div class="d-flex justify-content-start align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-2"><span
                        class="avatar-initial rounded-circle bg-label-info">' . substr($IssueManageHistory->IssueManage->JobOrders->SalesOrders->Customer[0]->company_name ?? '-', 0, 2) . '</span>
                    </div>
                  </div>
                  <div class="d-flex flex-column"><span
                      class="fw-medium">' . ($IssueManageHistory->IssueManage->JobOrders->SalesOrders->Customer[0]->company_name ?? '') . '</span><small
                      class="text-truncate text-muted">' . ($IssueManageHistory->IssueManage->JobOrders->SalesOrders->Customer[0]->buyer_name ?? '') . '</small>
                  </div>
                </div>';
        } else {
          $companyHtml .= '<span class="badge rounded bg-label-danger">-</span>';
        }


        $processHtmlFrom = '<span class="badge rounded bg-label-danger">-</span>';
        if (!empty($IssueManageHistory->issueFromDeparment->name)) {
          $processHtmlFrom = '<div class="d-flex justify-content-start align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-2"><span
                        class="avatar-initial  bg-label-warning">' . substr($IssueManageHistory->issueFromDeparment->ProcessMaster->name ?? '-', 0, 2) . '</span>
                    </div>
                  </div>
                  <div class="d-flex flex-column"><span
                      class="fw-medium">' . ($IssueManageHistory->issueFromDeparment->ProcessMaster->name ?? '') . '</span><small
                      class="text-truncate text-muted">' . ($IssueManageHistory->issueFromDeparment->name ?? '') . '</small>
                  </div>
                </div>';
        }


        $processHtmlTo = '<span class="badge rounded bg-label-danger">-</span>';
        if (!empty($IssueManageHistory->issueToDepartment->name)) {
          $processHtmlTo = '<div class="d-flex justify-content-start align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-2"><span
                        class="avatar-initial  bg-label-primary">' . substr($IssueManageHistory->issueToDepartment->ProcessMaster->name ?? '-', 0, 2) . '</span>
                    </div>
                  </div>
                  <div class="d-flex flex-column"><span
                      class="fw-medium">' . ($IssueManageHistory->issueToDepartment->ProcessMaster->name ?? '') . '</span><small
                      class="text-truncate text-muted">' . ($IssueManageHistory->issueToDepartment->name ?? '') . '</small>
                  </div>
                </div>';
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
        $JobOrderQty = $IssueManageHistory->qty;

        $catSubCateHtml = '<div class="d-flex flex-column"><span
                  class="fw-medium">' . ($SalesOrderStyle->StyleMaster->StyleCategory->name ?? "") . '</span><small
                  class="text-truncate text-muted">' . ($SalesOrderStyle->StyleMaster->StyleSubCategory->name ?? "") . '</small>
              </div>';

        $jobType = '<span class="badge rounded bg-label-' . (($IssueManageHistory->IssueManage->JobOrders->type == "regular") ? 'primary' : "warning") . '">' . ucfirst($IssueManageHistory->IssueManage->JobOrders->type) . '</span>';


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
        $actionHtml .= '<a class="btn btn-icon btn-label-primary mt-1 waves-effect"
                   href="' . route('process-transfer-preview') . '"><i class="ti ti-printer  mx-2 ti-sm"></i></a>';

        $actionHtml .= ' <a title="View Details" class="btn btn-icon btn-label-primary mt-1 waves-effect"
                   href="' . route('processHistoryView', $IssueManageHistory->id) . '"><i
                    class="ti ti-eye  mx-2 ti-sm"></i></a>';

        if (empty($IssueManageHistory->issueToDepartment->name)) {
          $actionHtml .= '<button type="button" class="btn btn-icon btn-label-warning mt-1 mx-1"
                          onclick="viewIssueModel(' . $IssueManageHistory->IssueManage->job_order_id . ',' . $IssueManageHistory->id . ')"><i
                      class="ti ti-transfer-in mx-2 ti-sm"></i></button>';
        }

        $result["data"][] = array($num, $date, $jobOrderNo, $companyHtml, $dHtml, $attachmentHtml, $styleNo, $JobOrderQty, $catSubCateHtml, $processHtmlFrom, $processHtmlTo, $jobType, $fileHtml, $actionHtml);
        $num++;
      }
    }
    echo json_encode($result);
  }


  public function processHistoryView($id)
  {
    $IssueManageHistory = IssueManageHistory::with('IssueManage.JobOrders', 'IssueParameters', "issueFromDeparment.processMaster", "issueToDepartment")->where('id', $id)->first();
    $htmlTable = '';
    if (!empty($IssueManageHistory->IssueParameters)) {
      $htmlTable .= '<div>
        <table id="SizeRatios" class="table border table-responsive mb-0">
        <thead>
        <tr><th class="border text-primary">Color</th><th class="text-primary">Size</th>';
      $IssueParameters = IssueParameters::where('issue_manage_history_id', '=', $id)->get();

      $groupedSizesIssue = $IssueParameters->groupBy('size');
      $groupedColorIssue = $IssueParameters->groupBy('color');

      $groupedColorIssueQtyTypes = $IssueParameters->groupBy('qty_type')->map(function ($items) {
        return $items->groupBy('size');
      });


      $groupedColorIssueQtyTypesArray = $groupedColorIssueQtyTypes->toArray();
      foreach ($groupedSizesIssue as $size => $groupedSize) {
        $htmlTable .= '<th class="border">' . $size . '</th>';
      }
      $htmlTable .= '<th class="border text-primary">Total</th><th class="border text-primary">All Total</th></tr></thead>';

      foreach ($groupedColorIssue as $colorKey => $colorwiseData) {
        $colorWiseQtyData = 0;
        $htmlTable .= '<tbody>
                        <tr><td rowspan="5" class="border">' . $colorKey . '</td>';

        foreach ($groupedColorIssueQtyTypes as $sizeKey => $groupedSize) {
          if ($sizeKey == 'c') {
            $sizeKeyTitle = 'C Qty';
          } else if ($sizeKey == 'fs') {
            $sizeKeyTitle = 'FS Qty';
          } else if ($sizeKey == 'ss') {
            $sizeKeyTitle = 'SS Qty';
          } else if ($sizeKey == 'r') {
            $sizeKeyTitle = 'R Qty';
          } else {
            $sizeKeyTitle = 'Qty';
          }
          $htmlTable .= '<tr><td class="text-primary">' . $sizeKeyTitle . '</td>';
          $rowWiseTotal = 0;
          foreach ($groupedSizesIssue as $size => $groupedSize) {
            $colorWiseDetails = $groupedColorIssueQtyTypesArray[$sizeKey][$size];
            foreach ($colorWiseDetails as $colorWiseDetail) {
              $colorName = $colorWiseDetail['color'];
              $sizeShow = $colorWiseDetail['size'];
              if ($colorKey == $colorName && $sizeShow == $size) {
                if ($sizeKey != 'c') {
                  $colorWiseQtyData += ($colorWiseDetail['qty'] ?? 0);
                }
                $rowWiseTotal += ($colorWiseDetail['qty'] ?? 0);
                $htmlTable .= '<td class="border">' . ($colorWiseDetail['qty'] ?? 0) . '</td>';
              }
            }
          }
          $htmlTable .= '<td>' . $rowWiseTotal . '</td>';
        }
        $htmlTable .= '<td rowspan="5">' . $colorWiseQtyData . '</td></tr>';
      }


      $htmlTable .= '</table></div>';
    }

    $IssueMaterials = IssueMaterials::with(["Item.ItemCategory", "Item.ItemSubCategory"])->where('issue_manage_history_id', '=', $id)->get();

    return view('content.production.history-view', compact("IssueManageHistory", "htmlTable", "IssueMaterials"));
  }


  public function issueToEditDataManage($job_order_id, $department_id, $color)
  {
    $issueQuery = IssueManageHistory::whereNotNull("issueFrom")->where('issueFrom', $department_id);
    $issueQuery->whereHas('IssueManage', function ($query) use ($job_order_id) {
      $query->where('job_order_id', $job_order_id);
    });
    $issueHistoryIds = $issueQuery->pluck('id')->all();
    $IssueParameters = IssueParameters::where("color", $color)->whereIn('issue_manage_history_id', $issueHistoryIds)->get();
    $resultDetails = $IssueParameters->groupBy('size')
      ->map(function ($item, $key) {
        return $item->sum('qty');
      });
    return $resultDetails->toArray();
  }

  public function issueHistoryViewByJobId($job_order_id, $department_id)
  {
    $htmlTable = '';
    $issueQuery = IssueManageHistory::whereNotNull("issueFrom")->where('issueFrom', $department_id);
    $issueQuery->whereHas('IssueManage', function ($query) use ($job_order_id) {
      $query->where('job_order_id', $job_order_id);
    });
    $issueHistoryIds = $issueQuery->pluck('id')->all();
    foreach ($issueHistoryIds as $id) {
      $htmlTable .= '<div class="card accordion-item">
            <h2 class="accordion-header" id="paymentOne' . $id . '">
              <span class="accordion-button collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#faq-payment-one' . $id . '" aria-expanded="false" aria-controls="faq-payment-one' . $id . '">
                Previously Done Job Details
              </span>
            </h2>

            <div id="faq-payment-one' . $id . '" class="accordion-collapse collapse" aria-labelledby="paymentOne' . $id . '" data-bs-parent="#faq-payment-qna' . $id . '" style="">
              <div class="accordion-body">';


      $IssueManageHistory = IssueManageHistory::with('IssueManage.JobOrders', 'IssueParameters', "issueFromDeparment.processMaster", "issueToDepartment")->where('id', $id)->first();

      if (!empty($IssueManageHistory->IssueParameters)) {
        $htmlTable .= '<div>
        <table id="SizeRatios" class="table border table-responsive mb-0">
        <thead>
        <tr><th class="border text-primary">Color</th><th class="text-primary">Size</th>';
        $IssueParameters = IssueParameters::where('issue_manage_history_id', '=', $id)->get();

        $groupedSizesIssue = $IssueParameters->groupBy('size');
        $groupedColorIssue = $IssueParameters->groupBy('color');

        foreach ($groupedSizesIssue as $size => $groupedSize) {
          $htmlTable .= '<th class="border">' . $size . '</th>';
        }
        $htmlTable .= '<th class="border text-primary" colspan="2">Total</th></tr></thead>';

        foreach ($groupedColorIssue as $colorKey => $colorwiseData) {
          $colorwiseQtyData = $colorwiseData->sum('qty');
          $htmlTable .= '<tbody>
                        <tr><td rowspan="2" class="border">' . $colorKey . '</td><td class="text-primary">Qty</td>';
          $counterQty = 0;

          foreach ($groupedSizesIssue as $size => $groupedSize) {
            // dd($groupedSize[$counterQty]);
            $htmlTable .= '
                  <td class="border">' . (array_column($colorwiseData->toArray(), 'qty')[$counterQty] ?? 0) . '</td>';
            $counterQty++;
          }

          $htmlTable .= '<td rowspan="2">' . $colorwiseQtyData . '</td></tr>';
        }


        $htmlTable .= '</table></div>';
        $htmlTable .= '</div>
            </div>
          </div>';
      }
    }
    return $htmlTable;
  }

  public function issueToStore(request $request)
  {
    $this->validate(request(), [
      'job_id' => 'required',
      'Qty' => 'required',
      'colorWiseCheckBox' => 'required'
    ]);

    $job_order_id = $request->job_id;
    $old_department_id = $request->d_id;
    $department_id = $request->department_id ?? Null;

    $JobOrder = JobOrders::where('id', $job_order_id)->first();
    if ($JobOrder) {

      if ($request->cad_desc) {
        $JobOrders = JobOrders::where('id', $job_order_id)->update([
          'cad_desc' => $request->cad_desc,
        ]);
      }

      if ($request->cad) {
        $this->validate(request(), [
          'cad.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->cad;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/jobOrders/' . $job_order_id . '/');
        if (!is_dir(public_path('/jobOrders'))) {
          mkdir(public_path('/jobOrders'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);

        JobOrders::where('id', $job_order_id)->update([
          "cad" => $new_file_name,
        ]);
      }

      $issueQty = $request->Qty;
      $user_id = Auth::id();
      $previous_department_id = NUll;
      $IssueManage = IssueManage::where('job_order_id', $job_order_id)->where('department_id', $old_department_id)->orderBy("id", "desc")->first();
      if ($IssueManage) {
        $previous_department_id = $IssueManage->department_id;
        $previous_issue_id = $IssueManage->id;
        $queryIssueManage = new IssueManage([
          'job_order_id' => $job_order_id,
          'user_id' => $user_id,
          'issueQty' => $issueQty,
          'rQty' => $issueQty,
          'department_id' => $department_id
        ]);
        $queryIssueManage->save();
        $issue_id = $queryIssueManage->id;

        $fetchRQty = $IssueManage->rQty;
        $updateRQty = $fetchRQty - $issueQty;
        IssueManage::where("id", $previous_issue_id)->where("department_id", $previous_department_id)->update([
          'rQty' => $updateRQty
        ]);
      }

      if ($issue_id) {
        $queryIssueManageHistory = new IssueManageHistory([
          'issue_id' => $issue_id,
          'qty' => $issueQty,
          'issue_type' => $request->issueType,
          'va_cost' => $request->cost,
          'issueFrom' => $previous_department_id,
          'issueTo' => $department_id,
          'userFrom' => $user_id,
          'remark' => 'Issue'
        ]);
        $queryIssueManageHistory->save();
        $issue_manage_history_id = $queryIssueManageHistory->id;

        if (!empty($request->SizeWiseQty)) {
          $totalSizeDataArray = count($request->SizeWiseQty);
        } else {
          $totalSizeDataArray = 0;
        }
        if ($totalSizeDataArray > 0) {
          foreach ($request->SizeWiseQty as $ColorKey => $Color) {
            if (in_array($ColorKey, $request->colorWiseCheckBox)) {
              foreach ($Color as $QtyKey => $Qty) {
                if ($Qty >= 0) {
                  $IssueParameters = new IssueParameters([
                    'job_order_id' => $job_order_id,
                    'issue_manage_history_id' => $issue_manage_history_id,
                    'department_id' => $department_id,
                    'color' => $ColorKey,
                    'qty' => $Qty,
                    'size' => $QtyKey,
                  ]);
                  $IssueParameters->save();
                }
              }
            }
          }
        }


        if (!empty($request->FSSizeWiseQty)) {
          $totalFSSizeDataArray = count($request->FSSizeWiseQty);
        } else {
          $totalFSSizeDataArray = 0;
        }
        if ($totalFSSizeDataArray > 0) {
          foreach ($request->FSSizeWiseQty as $ColorKey => $Color) {
            if (in_array($ColorKey, $request->colorWiseCheckBox)) {
              foreach ($Color as $QtyKey => $Qty) {
                if ($Qty >= 0) {
                  $IssueParameters = new IssueParameters([
                    'job_order_id' => $job_order_id,
                    'issue_manage_history_id' => $issue_manage_history_id,
                    'department_id' => $department_id,
                    'color' => $ColorKey,
                    'qty' => $Qty,
                    'qty_type' => 'fs',
                    'size' => $QtyKey,
                  ]);
                  $IssueParameters->save();
                }
              }
            }
          }
        }

        if (!empty($request->SSaleSizeWiseQty)) {
          $totalSSSizeDataArray = count($request->SSaleSizeWiseQty);
        } else {
          $totalSSSizeDataArray = 0;
        }
        if ($totalSSSizeDataArray > 0) {
          foreach ($request->SSaleSizeWiseQty as $ColorKey => $Color) {
            if (in_array($ColorKey, $request->colorWiseCheckBox)) {
              foreach ($Color as $QtyKey => $Qty) {
                if ($Qty >= 0) {
                  $IssueParameters = new IssueParameters([
                    'job_order_id' => $job_order_id,
                    'issue_manage_history_id' => $issue_manage_history_id,
                    'department_id' => $department_id,
                    'color' => $ColorKey,
                    'qty' => $Qty,
                    'qty_type' => 'ss',
                    'size' => $QtyKey,
                  ]);
                  $IssueParameters->save();
                }
              }
            }
          }
        }


        if (!empty($request->RejectSizeWiseQty)) {
          $totalRSizeDataArray = count($request->RejectSizeWiseQty);
        } else {
          $totalRSizeDataArray = 0;
        }
        if ($totalRSizeDataArray > 0) {
          foreach ($request->RejectSizeWiseQty as $ColorKey => $Color) {
            if (in_array($ColorKey, $request->colorWiseCheckBox)) {
              foreach ($Color as $QtyKey => $Qty) {
                if ($Qty >= 0) {
                  $IssueParameters = new IssueParameters([
                    'job_order_id' => $job_order_id,
                    'issue_manage_history_id' => $issue_manage_history_id,
                    'department_id' => $department_id,
                    'color' => $ColorKey,
                    'qty' => $Qty,
                    'qty_type' => 'r',
                    'size' => $QtyKey,
                  ]);
                  $IssueParameters->save();
                }
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
              $IssueMaterials = new IssueMaterials([
                'item_id' => $bomListData['rawItem'],
                'available_qty' => $bomListData['rawAvailableQty'],
                'order_qty' => $bomListData['rawOrderQty'],
                'total' => $bomListData['rawTotal'],
                'rate' => $bomListData['rawRate'],
                'job_order_id' => $job_order_id,
                'issue_manage_history_id' => $issue_manage_history_id,
                'department_id' => $department_id
              ]);
              $IssueMaterials->save();
            }
          }
        }
        $ids = ['d_id' => $old_department_id];
        return redirect()->route('processHistory', $ids)->withSuccess('Transfer Done');
        // return redirect()->action([OrderJobCardController::class, 'list'])->withSuccess('Transfer Done');
      } else {
        $ids = ['d_id' => $old_department_id, 'j_id' => $job_order_id];
        return redirect()->route('issue-to', $ids)->withErrors('Something is wrong!!!');
      }
    } else {
      $ids = ['d_id' => $old_department_id, 'j_id' => $job_order_id];
      return redirect()->route('issue-to', $ids)->withErrors('Something is wrong!!!');
      //return redirect()->action([OrderJobCardController::class, 'list'])->withErrors('Something is wrong!!!');
    }
  }


  public function pendingList($id = "")
  {
    $customers = Customer::all();
    $designers = User::where('role', '=', 'designer')->get();
    $styleCategories = StyleCategory::all();
    $styleSubCategories = StyleSubCategory::all();

    $data["customers"] = $customers;
    $data["designers"] = $designers;
    $data["styleCategories"] = $styleCategories;
    $data["styleSubCategories"] = $styleSubCategories;

    $IssueManages = IssueManage::with(["IssueManageHistory.IssueParameters"])->where("rQty", ">", 0)->where('department_id', $id)->get();
    $department = Department::where("id", $id)->first();
    return view('content.production.pendinglist', compact("department", "IssueManages", "data", "id"));
  }

  public function pendingListAjax(Request $request)
  {
    $department_id = $request->Department;

    $issueQuery = IssueManage::query();
    $issueQuery->where('department_id', $department_id);
    $issueQuery->where("rQty", ">", 0);
    if (!empty($request->category)) {
      $issueQuery->whereHas('JobOrders.SalesOrderStyleInfo.StyleMaster.StyleCategory', function ($query) use ($request) {
        $query->where('id', $request->category);
      });
    }

    if (!empty($request->subcategory)) {
      $issueQuery->whereHas('JobOrders.SalesOrderStyleInfo.StyleMaster.StyleSubCategory', function ($query) use ($request) {
        $query->where('id', $request->subcategory);
      });
    }

    if (!empty($request->ProcessMaster)) {
      $issueQuery->whereHas('Department', function ($query) use ($request) {
        $query->where('process_master_id', $request->ProcessMaster);
      });
    }

    if (!empty($request->company)) {
      $issueQuery->whereHas('SalesOrders', function ($query) use ($request) {
        $query->where('customer_id', $request->company);
      });
    }

    if (!empty($request->designer)) {
      $issueQuery->whereHas('JobOrders.SalesOrderStyleInfo.StyleMaster', function ($query) use ($request) {
        $query->where('designer_id', $request->designer);
      });
    }

    if (!empty($request['startDate']) && !empty($request['endDate'])) {
      $startDate = date('Y-m-d', strtotime($request['startDate']));
      $endDate = date('Y-m-d', strtotime($request['endDate']));
      $issueQuery->whereBetween('issue_manages.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
    }

    if (!empty($request->type)) {
      $issueQuery->whereHas('JobOrders', function ($query) use ($request) {
        $query->where('job_orders.type', $request->type);
      });
    }

    $IssueManages = $issueQuery->OrderBy("issue_manages.id", "desc")->get();

    $result = array("data" => array());
    if ($IssueManages != null) {
      $num = 1;
      foreach ($IssueManages as $IssueManage) {
        if ($IssueManage->JobOrders->type == 'regular') {
          $SalesOrderStyle = $IssueManage->JobOrders->SalesOrderStyleInfo;
        } else {
          $SalesOrderStyle = $IssueManage->JobOrders;
        }
        $date = Helpers::formateDateLong($IssueManage->created_at);

        if ($IssueManage->JobOrders->type == 'regular') {
          $jobOrderNo = '<a class="waves-effect mx-1"
                                        href="' . route('order-job-card.view', $IssueManage->JobOrders->id) . '">#' . $IssueManage->JobOrders->job_order_no . '</a>';
        } else {
          $jobOrderNo = '<a class="waves-effect mx-1"
                                        href="' . route('order-job-card.sample.view', $IssueManage->JobOrders->id) . '">#' . $IssueManage->JobOrders->job_order_no . '</a>';
        }
        $companyHtml = "";
        if (!empty($IssueManage->JobOrders->SalesOrders->Customer[0]->company_name)) {
          $companyHtml .= '<div class="d-flex justify-content-start align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-2"><span
                        class="avatar-initial rounded-circle bg-label-info">' . substr($IssueManage->JobOrders->SalesOrders->Customer[0]->company_name ?? '-', 0, 2) . '</span>
                    </div>
                  </div>
                  <div class="d-flex flex-column"><span
                      class="fw-medium">' . ($IssueManage->JobOrders->SalesOrders->Customer[0]->company_name ?? '') . '</span><small
                      class="text-truncate text-muted">' . ($IssueManage->JobOrders->SalesOrders->Customer[0]->buyer_name ?? '') . '</small>
                  </div>
                </div>';
        } else {
          $companyHtml .= '<span class="badge rounded bg-label-danger">-</span>';
        }


        $processHtml = "";
        $rQty = 0;
        $processType = "";
        if (!empty($IssueManage->Department->ProcessMaster->name)) {
          $rQty = $IssueManage->rQty;
          $processType = $IssueManage->Department->ProcessMaster->type;
          $processHtml .= '<div class="d-flex justify-content-start align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-2"><span
                        class="avatar-initial  bg-label-warning">' . substr($IssueManage->Department->ProcessMaster->name ?? '-', 0, 2) . '</span>
                    </div>
                  </div>
                  <div class="d-flex flex-column"><span
                      class="fw-medium">' . ($IssueManage->Department->ProcessMaster->name ?? '') . '</span><small
                      class="text-truncate text-muted">' . ($IssueManage->Department->name ?? '') . '</small>
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
        $JobOrderQty = 'Order : ' . $IssueManage->issueQty . '<br> Rem. : ' . $rQty;

        $catSubCateHtml = '<div class="d-flex flex-column"><span
                  class="fw-medium">' . ($SalesOrderStyle->StyleMaster->StyleCategory->name ?? "") . '</span><small
                  class="text-truncate text-muted">' . ($SalesOrderStyle->StyleMaster->StyleSubCategory->name ?? "") . '</small>
              </div>';

        $jobType = '<span class="badge rounded bg-label-' . (($IssueManage->JobOrders->type == "regular") ? 'primary' : "warning") . '">' . ucfirst($IssueManage->JobOrders->type) . '</span>';


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

        if (!empty($issueParameterFirst = $IssueManage->IssueManageHistory->first()?->IssueParameters->first())) {
          $ids = ['d_id' => $department_id, 'j_id' => $IssueManage->JobOrders->id, 'imh_id' => $issueParameterFirst->issue_manage_history_id];
          $routeNameIssueTo = route('issue-to-on-floor', $ids);
        } else {
          $ids = ['d_id' => $department_id, 'j_id' => $IssueManage->JobOrders->id];
          $routeNameIssueTo = route('issue-to', $ids);
        }
        if ($processType == "cutting") {
          $actionName = "Process To Cut";
        } elseif ($processType == "cad") {
          $actionName = "Assign";
        } elseif ($processType == "stitching") {
          $actionName = "Process To Stitching";
        } elseif ($processType == "washing") {
          $actionName = "Process To Washing";
        } elseif ($processType == "packing") {
          $actionName = "Process To Packing";
        } else {
          $actionName = "Send";
        }
        $actionHtml .= ' <a class="btn btn-label-primary btn-sm mt-1 waves-effect mx-1"
                 href="' . $routeNameIssueTo . '"><i class="ti ti-arrow-forward ti-sm"></i> ' . $actionName . '</a>';

        $result["data"][] = array($num, $date, $jobOrderNo, $companyHtml, $dHtml, $attachmentHtml, $styleNo, $JobOrderQty, $catSubCateHtml, $processHtml, $jobType, $fileHtml, $actionHtml);
        $num++;
      }
    }
    echo json_encode($result);
  }


  public function departmentDashboard($id = "")
  {
    $IssueManages = IssueManage::with(["IssueManageHistory.IssueParameters"])->where("rQty", ">", 0)->where('department_id', $id)->get();
    $department = Department::where("id", $id)->first();
    return view('content.production.dashboard', compact("department", "IssueManages"));
  }


  public function packagingAdd()
  {
    return view('content.packaging.create');
  }

  public function packagingList()
  {
    return view('content.packaging.list');
  }

  public function getStylePackaging(Request $request)
  {
    $styleNos = [
      [
        'id' => 1,
        'name' => 'TEST1',
      ],
      [
        'id' => 2,
        'name' => 'TEST2',
      ],
      [
        'id' => 3,
        'name' => 'TEST3',
      ]
    ];
    return response()->json($styleNos);
  }

  public function getColorPackaging(Request $request)
  {
    $color = [
      [
        'id' => 'RED',
        'name' => 'RED',
      ],
      [
        'id' => 'BLACK',
        'name' => 'BLACK',
      ],
      [
        'id' => 'WHITE',
        'name' => 'WHITE',
      ]
    ];
    return response()->json($color);
  }

  public function getSizeWiseDataPackaging(Request $request)
  {

    $TableHtml = '
      <div>
          <table id="SizeRatios" class="center table border table-responsive mb-4">
              <thead>
                  <tr>
                  <th class="text-dark text-center">Carton Number</th>
                      <th class="text-dark text-center">Size</th>
                      <th class="border text-center">28</th>
                      <th class="border text-center">30</th>
                      <th class="border text-center">34</th>
                      <th class="border text-dark text-center" colspan="2">Total Qty</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td></td>
                      <td class="text-dark text-center">FG Qty</td>
                      <td class="border bg-light">5</td>
                      <td class="border bg-light">9</td>
                      <td class="border bg-light">7</td>
                      <td class="text-center">21</td>
                  </tr>
                  <tr class="filledRow">
                      <td class="text-center"><input type="text" class="form-control" value="" name="cartonNumber[]" id="cartonNumber" required></td>
                      <td class="text-dark text-center">Filled Qty</td>
                      <td class="border"><input class="form-control" type="number" name="SizeWiseQty[RED][28][]" value="2"></td>
                      <td class="border"><input class="form-control" type="number"  name="SizeWiseQty[RED][30][]" value="6"></td>
                      <td class="border"><input class="form-control" type="number"  name="SizeWiseQty[RED][34][]" value="4"></td>
                      <td class="text-dark text-center" id="TotalColorRED">12</td>
                  </tr>
              </tbody>
          </table>
      </div>
        <div class="col-lg-12 col-12 invoice-actions mt-3">
              <button type="button" onclick="AddRow()"
                  class="btn rounded-pill btn-icon btn-label-primary waves-effect">
                  <span class="ti ti-plus"></span>
              </button>

              <button type="button" onclick="removeRow()"
                  class="btn rounded-pill btn-icon btn-label-danger waves-effect">
                  <span class="ti ti-minus"></span>
              </button>

          </div>
      ';

    return response()->json(['html' => $TableHtml]);
  }
}
