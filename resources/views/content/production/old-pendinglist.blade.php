@extends('layouts/layoutMaster')

@section('title', 'List')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet"
        href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
  <!-- Row Group CSS -->
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')}}">
  <!-- Form Validation -->
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/toastr/toastr.css')}}" />
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/toastr/toastr.js')}}"></script>
  <!-- Flat Picker -->
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
  <!-- Form Validation -->
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
@endsection

@section('page-script')
  {{--<script src="{{asset('assets/js/tables-datatables-basic.js')}}"></script>--}}
@endsection

@section('content')
  <h4 class="py-3 mb-4">
    <span
      class="text-muted fw-light">Production/ {{ $department->ProcessMaster->name }} / {{ $department->name }} /</span>
    Pending List
  </h4>


  <!-- DataTable with Buttons -->
  <div class="card">
    <div class="card-datatable table-responsive pt-0">
      <table class="datatables-basic table" id="datatable-list">
        <thead>
        <tr>
          <th>SR No.</th>
          <th>Job Card No.</th>
          <th>Department</th>
          <th>Style No.</th>
          <th>Pieces</th>
          <th>Remaining Pieces</th>
          <th>Type</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @php  $num = 1; @endphp
        @foreach ($IssueManages as $IssueManage)
          @if (!empty($IssueManage->JobOrders->id))
            @php
              if ($IssueManage->JobOrders->type == 'regular') {
                 $SalesOrderStyle = $IssueManage->JobOrders->SalesOrderStyleInfo;
               } else {
                 $SalesOrderStyle = $IssueManage->JobOrders;
               }
             $styleNo =  $SalesOrderStyle->StyleMaster->style_no ?? "";

            @endphp
            <tr>
              <td class="text-bold"><a href="{{ route('app-user-view',base64_encode(1)) }}">{{ $num }}</a>
              </td>
              <td>
                <div class="d-flex justify-content-start align-items-center">
                  <div class="d-flex flex-column"><span
                      class="fw-medium">{{ $IssueManage->JobOrders->job_order_no }}</span>
                  </div>
                </div>
              </td>
              <td>
                <div class="d-flex justify-content-start align-items-center">
                  <div class="d-flex flex-column"><span
                      class="fw-medium">{{ $department->name }}</span></div>
                </div>
              </td>
              <td>
                <div class="d-flex justify-content-start align-items-center">
                  <div class="d-flex flex-column"><span
                      class="fw-medium">{{ $styleNo }}</span></div>
                </div>
              </td>
              <td>
                <div class="d-flex justify-content-start align-items-center">
                  <div class="d-flex flex-column"><span
                      class="fw-medium"> {{ $IssueManage->issueQty }}</span></div>
                </div>
              </td>
              <td>
                <div class="d-flex justify-content-start align-items-center">
                  <div class="d-flex flex-column"><span
                      class="fw-medium"> {{ $IssueManage->rQty }}</span></div>
                </div>
              </td>
              <td>
                <div class="d-flex justify-content-start align-items-center">
                  <div class="d-flex flex-column"><span
                      class="badge rounded bg-label-{{ (($IssueManage->JobOrders->type == "regular") ? 'primary' : "warning") }}">{{ ucfirst($IssueManage->JobOrders->type) }}</span>
                  </div>
                </div>
              </td>
              @php
                if(!empty($issueParameterFirst = $IssueManage->IssueManageHistory->first()?->IssueParameters->first())) {
                $ids = ['d_id' => $department->id, 'j_id' => $IssueManage->JobOrders->id, 'imh_id' => $issueParameterFirst->issue_manage_history_id];
                $routeNameIssueTo = route('issue-to-on-floor', $ids);
                } else {
                $ids = ['d_id' => $department->id, 'j_id' => $IssueManage->JobOrders->id];
                $routeNameIssueTo = route('issue-to',$ids);
                }
              @endphp
              <td>
                <a class="btn mx-1 btn-icon btn-label-primary mt-1 waves-effect"
                   href="{{route('process-transfer-preview')}}"><i
                    class="ti ti-printer  mx-2 ti-sm"></i></a>
                <a href="{{ $routeNameIssueTo }}"
                   class="btn mx-1 btn-outline-primary waves-effect"
                   type="button">
                  Send
                </a>
              </td>
            </tr>
            @php $num++; @endphp
          @endif
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>
  $(document).ready(function() {
    $('#datatable-list').DataTable({});
  });

</script>

