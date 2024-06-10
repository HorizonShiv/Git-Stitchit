<?php

namespace App\Http\Controllers\apps;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\CategoryMasters;
use App\Models\Customer;
use App\Models\Department;
use App\Models\IssueManage;
use App\Models\IssueManageHistory;
use App\Models\IssueMaterials;
use App\Models\IssueParameters;
use App\Models\Item;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IssueManageController extends Controller
{
  public function viewIssuePopup(Request $request)
  {
    $html = '';
    $job_id = $request->id;
    $imh_id = $request->imh_id;
    $JobOrders = JobOrders::where('id', $job_id)->first();
    $IssueManage = IssueManage::whereNotNull("department_id")->where('job_order_id', $job_id)->orderBy('id', 'desc')->first();
    $departmentName = " Job List ";
    $department_id = "";
    if ($IssueManage) {
      $departmentName = $IssueManage->department->name;
      $department_id = $IssueManage->department->id;
    }
    $departments = Department::all();
    if ($JobOrders) {
      $html .= '<div class="row">
                  <h4>Currently, JobCard Available in  "<b>' . $departmentName . '</b>" Department</h4>
                    <div class="col-sm-12">
                      <div class="form-group" data-children-count="1">
                        <label class="mb-1">All Departments</label>
                         <select class="form-control" name="department_id" id="department_id" required>
                            <option value="">Select Department</option>';
      $selectedStatus = "";
      foreach ($departments as $department) {
        if (empty($imh_id)) {
          if (!empty($department_id) && $department_id == $department->id) {
            $selectedStatus = "Selected";
          } else {
            $selectedStatus = "";
          }
        }
        $html .= "<option {$selectedStatus} value='{$department->id}'>" . $department->name . "</option>";
      }

      $html .= '</select></div>
                    </div>';
      if (!empty($imh_id)) {
        $html .= '<div class="mt-2 col-sm-12">
                  <label class="form-label" for="Cost Per Pisces">Value added Cost Per Piece</label>
                  <input required type="text" id="cost" value="0" name="cost" class="form-control" placeholder="Cost Per Piece">
                </div>';
      }

      $html .= '</div>
                    <input type="hidden" value="' . $job_id . '" name="job_id">
                    <input type="hidden" value="' . $imh_id . '" name="imh_id">
                    <input type="hidden" name="_token" id="csrf-token" value="' . Session::token() . '" />';
      echo $html;
    }
  }

  public function viewIssueReceivePopup(Request $request)
  {
    $inward_id = $request->id;
    $uid = $request->uid;
    $inwards = Inward::where('id', $inward_id)->first();
    $qty = $inwards->totalPics;
    $issueManage = IssueManage::where('fk_inward_id', $inward_id)->orderBy('id', 'desc')->first();
    if ($issueManage) {
      $qty = $issueManage->issueQty;
    }
    $html = '<div class="row">
                    <div class="col-sm-12">
                      <div class="form-group" data-children-count="1">
                        <label>Qty</label>
                        <input type="number" step="any" class="form-control" value="' . $qty . '" name="receiveQty" placholder="Receive Qty">
                      </div>
                    </div>';

    $html .= '</div>
                    <input type="hidden" value="' . $inward_id . '" name="inward_id">
                    <input type="hidden" value="' . $uid . '" name="user_id">
                    <input type="hidden" name="_token" id="csrf-token" value="' . Session::token() . '" />';
    echo $html;
  }

  public function viewIssuePopupForTransfer(Request $request)
  {
    $issue_id = $request->id;
    $issueManage = IssueManage::where('id', $issue_id)
      ->first();
    $issueRecieveQty = $issueManage->receiveQty;
    $users = User::where('users.isActive', 1)->get();
    $departments = Department::whereNotIn('name', ['Grey Inward', 'Process Inwards', 'Ready To Dispatch'])->get();

    $html = '<div class="row">
                    <div class="col-sm-12">
                      <div class="form-group" data-children-count="1">
                        <label>Qty</label>
                        <input type="number" step="any" class="form-control" value="' . $issueRecieveQty . '" name="issueQty" placholder="Issue Qty">
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group" data-children-count="1">
                        <label>Issue To</label>
                         <select class="form-control select2" name="issueTo" id="issueTo" required>
                            <option value="">Select Issue To</option>';

    foreach ($departments as $department) {
      $html .= "<option value='{$department->id}'>{$department->name}</option>";
    }
    $html .= '</select></div>
                    </div>';

    $html .= '<div class="col-sm-12">
                      <div class="form-group" data-children-count="1">
                        <label>User To</label>
                         <select class="form-control select2" name="userTo" id="userTo">
                            <option value="">Select User To</option>';
    foreach ($users as $user) {
      $html .= "<option value='{$user->id}'>{$user->name}</option>";
    }
    $html .= '</select></div>
                    </div>';

    $html .= '</div>
                    <input type="hidden" value="' . $issue_id . '" name="issue_id">
                    <input type="hidden" name="_token" id="csrf-token" value="' . Session::token() . '" />';
    echo $html;
  }

  public function viewIssueHistoryPopup(Request $request)
  {
    $html = '';
    $issue_id = $request->id;
    try {
      $html .= '<div class="table-responsive">
                        <table class="table zero-configuration" id="myTable1">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Date</th>
                                <th>Job No.</th>
                                <th>From Department Name</th>
                                <th>To Department Name</th>
                                <th>Qty</th>
                                <th>User</th>
                            </tr>
                            </thead>
                            <tbody>';
      $issues = IssueManageHistory::with(["issueToDepartment", "issueFromDeparment", "IssueManage.JobOrders", "userFromData"])->where('issue_manage_histories.issue_id', $issue_id)
        ->orderby('issue_manage_histories.id', 'asc')->get();
      foreach ($issues as $issue) {
        $date = date('d-m-Y', strtotime($issue['created_at']));
        $issue_id = $issue['id'];
        $qty = $issue['qty'];
        $ToDepartmentName = $issue['issueToDepartment']['name'] ?? "";
        $userFromName = $issue['userFromData']['person_name'] ?? "";
        $jobNo = $issue['IssueManage']['JobOrders']['job_order_no'] ?? "";
        $FromDepartmentName = $issue['issueFromDeparment']['name'] ?? "Job Card";
        $html .= '<tr>
            <td>' . $issue_id . '</td>
            <td>' . $date . '</td>
            <td>' . $jobNo . '</td>
            <td>' . $FromDepartmentName . '</td>
            <td>' . $ToDepartmentName . '</td>
            <td>' . $qty . '</td>
            <td>' . $userFromName . '</td>';

        $html .= '</tr>';
      }
      $html .= '</tbody >
                    </table >
                </div > ';
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    echo $html;
  }

  public function storeSelectedUser(Request $request)
  {

    $userId = $request->selectedUserId;
    $issue_id = $request->id;

    try {
      IssueManage::where('id', $issue_id)->update([
        'fk_user_id' => $userId,
      ]);
      return response()->json(['success' => true]);
    } catch (\Exception $e) {
      return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
  }

  public function index()
  {
//        $inwardDetails = IssueManage::leftJoin('inwards', 'issue_manages.fk_inward_id', '=', 'inwards.id')
//            ->leftJoin('party_masters', 'party_masters.id', '=', 'inwards.partymastersId')
//            ->leftJoin('grey_inwards', 'grey_inwards.id', '=', 'inwards.fk_grey_inward_id')
//            ->select(
//                'issue_manages.fk_inward_id',
//                'inwards.partyChallan',
//                'party_masters.name',
//                'grey_inwards.inwardDate'
//            )
//            ->orderBy('issue_manages.id', 'asc')
//            ->groupBy('issue_manages.fk_inward_id', 'party_masters.name', 'inwards.partyChallan', 'grey_inwards.inwardDate')
//            ->get();
    $partyMaster = PartyMasters::all();
    $existingUser = auth()->user();
    if ($existingUser->hasRole('Super Admin|Manager|Account Assistant|Account')) {
      $users = User::all();
    } else {
      $users = User::where('users.id', $existingUser->id)->get();
    }


//        $query = Users::select('issue_manages.fk_inward_id')
//            ->leftJoin('issue_manage_histories', function ($query) {
//                $query->on('issue_manages.id', '=', 'issue_manage_histories.fk_issue_id')
//                    ->whereRaw('issue_manage_histories.id IN (select MAX(imh.id) from issue_manage_histories as imh join issue_manages as im on im.id = imh.fk_issue_id group by im.id)');
//            })
//            ->get();

    return view('issue.index', compact("partyMaster", "users"));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $users = User::where('users.isActive', 1)->get();
    $departments = Department::all();
    $inwards = Inward::whereNull('inwards.notUse')->where('remaingTotalQty', '!=', 0)->select('id', 'partyName')->orderBy('id', 'desc')->get();
    return view('issue.create', compact("inwards", "users", "departments"));
  }

  /**
   * Store a newly created User in storage.
   *
   */
  public function store(request $request)
  {
    $this->validate(request(), [
      'job_id' => 'required',
      'department_id' => 'required'
    ]);

    $job_order_id = $request->job_id;
    $department_id = $request->department_id;
    if (!empty($request->imh_id)) {
      $imh_id = $request->imh_id;
      $IssueManageHistory = IssueManageHistory::where("id", $imh_id)->first();
      if ($IssueManageHistory) {
        $oldDepartment = $IssueManageHistory->issueFrom;
        IssueManageHistory::where("id", $imh_id)->update([
          'issueTo' => $department_id,
          'va_cost' => $request->cost
        ]);

        IssueManage::where("id", $IssueManageHistory->issue_id)->update([
          'department_id' => $department_id
        ]);

        IssueMaterials::where("issue_manage_history_id", $imh_id)->update([
          'department_id' => $department_id
        ]);

        IssueParameters::where("issue_manage_history_id", $imh_id)->update([
          'department_id' => $department_id
        ]);
        $ids = ['d_id' => $oldDepartment];
        return redirect()->route('processHistory', $ids)->withSuccess('Transfer Done');
      }
    } else {
      $JobOrder = JobOrders::where('id', $job_order_id)->first();
      if ($JobOrder) {
        $issueQty = $JobOrder->qty;
        $user_id = Auth::id();
        $previous_department_id = NUll;
        $IssueManage = IssueManage::where('job_order_id', $job_order_id)->first();
        if ($IssueManage) {
          $issue_id = $IssueManage->id;
          $previous_department_id = $IssueManage->department_id;
          IssueManage::where("id", $issue_id)->update([
            'job_order_id' => $job_order_id,
            'user_id' => $user_id,
            'issueQty' => $issueQty,
            'rQty' => $issueQty,
            'department_id' => $department_id
          ]);
        } else {
          $queryIssueManage = new IssueManage([
            'job_order_id' => $job_order_id,
            'user_id' => $user_id,
            'issueQty' => $issueQty,
            'rQty' => $issueQty,
            'department_id' => $department_id
          ]);
          $queryIssueManage->save();
          $issue_id = $queryIssueManage->id;
        }

        if ($issue_id) {
          $queryIssueManageHistory = new IssueManageHistory([
            'issue_id' => $issue_id,
            'qty' => $issueQty,
            'issueFrom' => $previous_department_id,
            'issueTo' => $department_id,
            'userFrom' => $user_id,
            'remark' => 'Issue'
          ]);
          $queryIssueManageHistory->save();

          return redirect()->action([OrderJobCardController::class, 'list'])->withSuccess('Transfer Done');
        } else {
          return redirect()->action([OrderJobCardController::class, 'list'])->withErrors('Something is wrong!!!');
        }

      } else {
        return redirect()->action([OrderJobCardController::class, 'list'])->withErrors('Something is wrong!!!');
      }
    }

  }

  public function listingIssue(Request $request)
  {
    $checkIsBlueInward = Controller::isBlueInward();
    $totalData = IssueManage::count();
    $totalFiltered = $totalData;
    $columns = array(
      0 => 'issue_manages.id',
      1 => 'inwards.fk_inward_verification_id',
      2 => 'inwards.fk_grey_inward_id',
      3 => 'created_at',
      4 => 'updated_at',
    );
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    config(['database.connections.mysql.strict' => false]);
    DB::reconnect();
    if (isset($request['party_name'])) {

      Session::put('issueFilter', [
        'action' => $request->get('action'),
        'user_id' => $request->get('user_id'),
        'endDate' => $request->get('endDate'),
        'startDate' => $request->get('startDate'),
        'inward_number' => $request->get('inward_number') ?? '',
        'party_name' => $request->get('party_name'),
      ]);

      $query = IssueManage::whereNotNull('issue_manages.id')
        ->leftJoin('inwards', 'issue_manages.fk_inward_id', '=', 'inwards.id')
        ->leftJoin('party_masters', 'party_masters.id', '=', 'inwards.partymastersId')
        ->leftJoin('inward_verifications', 'inward_verifications.id', '=', 'inwards.fk_inward_verification_id')
        ->select(DB::raw('max(issue_manages.id) as issue_manage_id'));
      if (!empty($checkIsBlueInward)) {
        $query->where('inwards.statusTypeBW', 'white');//temporary
      }
      if (!empty($request['statusType'])) {
        $query->where('inwards.statusTypeBW', $request['statusType']);
      }
      if (!empty($request['user_id'])) {
        $query->where('issue_manages.fk_user_id', $request['user_id']);
      }
      if (!empty($request['party_name'])) {
        $query->where('inwards.partymastersId', $request['party_name']);
      }
      if (!empty($request['fk_inward_id'])) {
        $query->where('inwards.id', $request['fk_inward_id']);
      }
      if (!empty($request['startDate']) && !empty($request['endDate'])) {
        $startDate = date('Y-m-d', strtotime($request['startDate']));
        $endDate = date('Y-m-d', strtotime($request['endDate']));
        $query->where('issue_manages.created_at', '>=', $startDate . ' 00:00:01');
        $query->where('issue_manages.created_at', '<=', $endDate . ' 23:59:59');
      }

      if (!empty($request->input('search.value'))) {
        $search = $request->input('search.value');
        $query->where(function ($query) use ($search) {
          return $query->where('inwards.fk_grey_inward_id', 'LIKE', "%{$search}%")
            ->orWhere('inwards.fk_inward_verification_id', 'LIKE', "%{$search}%")
            ->orWhere('inwards.id', 'LIKE', "%{$search}%");
        });
        $issueResultMax1 = $query->groupBy('issue_manages.fk_inward_id')->orderBy('issue_manages.id', 'desc');
        $totalFiltered = count($issueResultMax1->get());
        $issueResultMax1->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir);
      } else {
        $issueResultMax1 = $query->groupBy('issue_manages.fk_inward_id')->orderBy('issue_manages.id', 'desc');
        $totalFiltered = count($issueResultMax1->get());
        $issueResultMax1->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir);
        if ($totalFiltered <= 0) {
          $totalFiltered = $totalData;
        }
      }
      $issueResultMax = $issueResultMax1->get();
    }

    // $result = array("data" => array());
    $data = [];
    if ($issueResultMax != null) {
      foreach ($issueResultMax as $issueMax) {
        $query2 = IssueManage::where('issue_manages.id', $issueMax['issue_manage_id'])
          ->leftJoin('inwards', 'issue_manages.fk_inward_id', '=', 'inwards.id')
          ->leftJoin('party_masters', 'party_masters.id', '=', 'inwards.partymastersId')
          ->leftJoin('inward_verifications', 'inward_verifications.id', '=', 'inwards.fk_inward_verification_id')
          ->select(
            'issue_manages.*',
            'party_masters.name',
            'inwards.totalPics as inwardTotalPics',
            'inwards.partyChallan',
            'inward_verifications.totalPics',
            'inward_verifications.lotNumber as styleNo',
            'inward_verifications.id as verificationNumber'
          );
        $issue = $query2->first();
        $date = date('d-m-Y', strtotime($issue->created_at));
        $inwardNo = $issue->fk_inward_id;
        $inwardNoShow = '<a href="' . route('inwards.show', $inwardNo) . '"><b class="text-success">' . $inwardNo . '</b>
                            </a>';
        $issue_id = $issue->id;
        $inward_priority_id = $issue->inward_priority_id;
        $inwardPriorityDetails = InwardPriorityOperations::with('operations', 'operationsGroup')->where('id', $inward_priority_id)->first();
        $jobCardQty = $issue->inwardTotalPics;
        $issueQty = $issue->issueQty;
        $partyName = $issue->name;
        $challanNo = $issue->partyChallan;
        $styleNo = $issue->styleNo;
        $vNumber = $issue->verificationNumber;
        $operationName = $inwardPriorityDetails['operations']['description'] ?? 'PKG';
        $userName = Controller::getUserName($issue->fk_user_id);
        $departmentName = Controller::getDepartmentName($issue->fk_department_id);
        $history = '<span title="History" type="button" onclick="viewIssueHistory(' . $inwardNo . ')"><b class="action"><i class="nav-icon nav-icon-action fas fa-history text-info"></i></b></span>';

        $existingUser = auth()->user();
//                if ($existingUser->hasRole('Super Admin')) {
//                    if ($operationName != 'PKG') {
//                        $history .= '<span title="Packing Receive" type="button" onclick="viewIssuePackingReceive(' . $inwardNo . ')"><b class="action"><i class="nav-icon nav-icon-action fas fa-download text-info"></i></b></span>';
//                    }
//                }
        if ($existingUser->hasRole('Super Admin')) {
          $inward_department_histories = InwardDepartmentHistory::where('fk_inward_id', $inwardNo)->first();
          if ($inward_department_histories && $operationName != 'PKG' && $inward_department_histories->issueTo == '7') {
            $history .= '<span title="Packing Receive" type="button" onclick="viewIssuePackingReceive(' . $inwardNo . ')"><b class="action"><i class="nav-icon nav-icon-action fas fa-download text-info"></i></b></span>';
          }
        }
        $data[] = array($date, $partyName, $challanNo, $styleNo, $inwardNoShow, $vNumber, $issue_id, $jobCardQty, $issueQty, $departmentName, $operationName, $userName, $history);
        //dd($existingUser->id);
        /*if($existingUser->hasRole('Super Admin')){
            array_push($result["data"], array($date, $inwardNo, $issue_id, $issueQty, $receiveQty, $issueFrom, $issueTo, $userFrom, $userTo, $action, $history));
        }else{
            if($issueHistories->userTo == $existingUser->id){
                array_push($result["data"], array($date, $inwardNo, $issue_id, $issueQty, $receiveQty, $issueFrom, $issueTo, $userFrom, $userTo, $action, $history));
            }

        }*/


      }
    }
    $json_data = array(
      "draw" => intval($request->input('draw')),
      "recordsTotal" => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data" => $data
    );
    echo json_encode($json_data);

    config(['database.connections.mysql.strict' => true]);
    DB::reconnect();
  }

  public function allIndex($id)
  {
    $customers = Customer::all();
    $designers = User::where('role', '=', 'designer')->get();
    $styleCategories = StyleCategory::all();
    $styleSubCategories = StyleSubCategory::all();

    $data["customers"] = $customers;
    $data["designers"] = $designers;
    $data["styleCategories"] = $styleCategories;
    $data["styleSubCategories"] = $styleSubCategories;


    return view('content.production.issue.all-index', compact("data", "id"));
  }

  public function allListingIssue(Request $request)
  {
    $totalData = IssueManage::count();
    $totalFiltered = $totalData;
    $columns = array(
      0 => 'issue_manages.id',
      1 => 'issue_manages.id',
      2 => 'issue_manages.id',
      3 => 'created_at',
      4 => 'updated_at',
    );
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    $query = IssueManage::with(["JobOrders", "User", "Department"]);

    $query->where('issue_manages.job_order_id', $request['job_order_id']);
    if (!empty($request['user_id'])) {
      $query->where('issue_manages.user_id', $request['user_id']);
    }
    if (!empty($request['department_id'])) {
      $query->where('issue_manages.department_id', $request['department_id']);
    }

    if (!empty($request['startDate']) && !empty($request['endDate'])) {
      $startDate = date('Y-m-d', strtotime($request['startDate']));
      $endDate = date('Y-m-d', strtotime($request['endDate']));
      $query->where('issue_manages.created_at', '>=', $startDate . ' 00:00:01');
      $query->where('issue_manages.created_at', '<=', $endDate . ' 23:59:59');
    }

    if (!empty($request->input('search.value'))) {
      $search = $request->input('search.value');
      $query->where(function ($query) use ($search) {
        return $query->where('issue_manages.id', 'LIKE', "%{$search}%")
          ->orWhere('issue_manages.id', 'LIKE', "%{$search}%")
          ->orWhere('issue_manages.id', 'LIKE', "%{$search}%");
      })
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir);
      $totalFiltered = $query->count();
    } else {
      $query->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir);
      $totalFiltered = $query->count();
      if ($totalFiltered <= 0) {
        $totalFiltered = $totalData;
      }
    }
    $issueResultMax = $query->orderBy('issue_manages.id', 'desc')->get();

    // $result = array("data" => array());
    $data = [];
    if ($issueResultMax != null) {
      foreach ($issueResultMax as $issue) {
        $date = date('d-m-Y', strtotime($issue->created_at));
        $jobNo = $issue->JobOrders->job_order_no;
        $issue_id = $issue->id;
        $issueQty = $issue->issueQty;
        $userName = $issue->User->person_name ?? '';
        $departmentName = $issue->Department->name ?? '';
        $actionHtml = '<a class="btn btn-icon btn-label-success mt-1 mx-1"
                      onclick="viewIssueHistory(' . $issue_id . ')"><i
                  class="ti ti-history mx-2 ti-sm"></i></button>';
        $data[] = array($issue_id, $date, $jobNo, $issueQty, $departmentName, $userName, $actionHtml);
      }
    }
    $json_data = array(
      "draw" => intval($request->input('draw')),
      "recordsTotal" => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data" => $data
    );
    echo json_encode($json_data);
  }


}
