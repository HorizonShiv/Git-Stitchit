@extends('layouts.layoutMaster')

@section('title', 'History List')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
  <!-- Row Group CSS -->
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')}}">
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
  <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('page-script')
  {{--<script src="{{asset('assets/js/tables-datatables-basic.js')}}"></script>--}}
  <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
@endsection

@section('content')
  <h4 class="py-3 mb-4">
    <span
      class="text-muted fw-light">Production/ {{ $department->processMaster->name }}/ {{ $department->name  }} /</span>History
  </h4>


  <div class="card mb-4">
    <div class="card-widget-separator-wrapper">

      <div class="card-body card-widget-separator">
        <div class="row gy-4 gy-sm-1 mb-1">

          <div class="col-12 col-sm-4 col-lg-4">
            <label for="users-list-status">Start Date</label>
            <fieldset class="form-group">
              <input type="date" class="form-control" value="<?= date('Y-m-d') ?>"
                     name="date" id="date" required>
            </fieldset>
          </div>
          <div class="col-12 col-sm-4 col-lg-4">
            <label for="users-list-status">End Date</label>
            <fieldset class="form-group">
              <input type="date" class="form-control" value="<?= date('Y-m-d') ?>"
                     name="date" id="date" required>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- DataTable with Buttons -->
  <div class="card">
    <div class="card-datatable table-responsive pt-0">
      <table class="datatables-basic table" id="datatable-list">
        <thead>
        <tr>
          <th>SR No.</th>
          <th>Job Card No.</th>
          <th>Issue Qty</th>
          <th>From Department</th>
          <th>To Department</th>
          <th>Issue Type</th>
          <th>Created Date</th>
          <th>User By</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @if($IssueManageHistories)
          @php $num =1; @endphp
          @foreach($IssueManageHistories as $IssueManageHistory)
            <tr>
              <td class="text-bold">{{ $num }}</td>
              <td>
                <div class="d-flex justify-content-start align-items-center">
                  <div class="d-flex flex-column"><span
                      class="fw-medium">{{ $IssueManageHistory->IssueManage->JobOrders->job_order_no }}</span></div>
                </div>
              </td>
              <td>
                <div class="d-flex justify-content-start align-items-center">
                  <div class="d-flex flex-column"><span
                      class="fw-medium">{{ $IssueManageHistory->qty }}</span></div>
                </div>
              </td>
              <td>
                <div class="d-flex justify-content-start align-items-center">
                  <div class="d-flex flex-column"><span
                      class="fw-medium">{{ $IssueManageHistory->issueFromDeparment->name }}</span></div>
                </div>
              </td>
              <td>
                <div class="d-flex justify-content-start align-items-center">
                  <div class="d-flex flex-column"><span
                      class="fw-medium">{{ $IssueManageHistory->issueToDepartment->name ?? "" }}</span></div>
                </div>
              </td>
              <td>
                <div class="d-flex justify-content-start align-items-center">
                  <div class="d-flex flex-column"><span
                      class="fw-medium">{{ ucfirst($IssueManageHistory->issue_type) }}</span></div>
                </div>
              </td>
              <td>
                <div class="d-flex justify-content-start align-items-center">
                  <div class="d-flex flex-column"><span
                      class="fw-medium">{{ $IssueManageHistory->created_at }}</span></div>
                </div>
              </td>

              <td>
                <div class="d-flex justify-content-start align-items-center">
                  <div class="d-flex flex-column"><span
                      class="fw-medium">{{ $IssueManageHistory->userFromData->person_name }}</span></div>
                </div>
              </td>
              <td>
                <a class="btn btn-icon btn-label-primary mt-1 waves-effect"
                   href="{{route('process-transfer-preview')}}"><i class="ti ti-printer  mx-2 ti-sm"></i></a>

                <a title="View Details" class="btn btn-icon btn-label-primary mt-1 waves-effect"
                   href="{{ route('processHistoryView',$IssueManageHistory->id) }}"><i
                    class="ti ti-eye  mx-2 ti-sm"></i></a>
                @if(empty($IssueManageHistory->issueToDepartment->name))
                  {!! '<button type="button" class="btn btn-icon btn-label-warning mt-1 mx-1"

                          onclick="viewIssueModel(' . $IssueManageHistory->IssueManage->job_order_id . ',' . $IssueManageHistory->id . ')"><i
                      class="ti ti-transfer-in mx-2 ti-sm"></i></button>' !!}
                @endif
              </td>
            </tr>
            @php $num++; @endphp
          @endforeach
        @endif
        </tbody>
      </table>
    </div>
  </div>

  <form action="{{ route('issue.store') }}" method="POST">
    <div class="modal fade" id="modal-issue" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content p-3 p-md-5">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="text-center mb-4">
              <h3 class="mb-2">Transfer To Department</h3>
            </div>
          </div>
          <div class="modal-body">
          </div>
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Save
            </button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                    aria-label="Close">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>

@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>
  $(document).ready(function() {
    $('#datatable-list').DataTable({});
  });

  function viewIssueModel(job_id, imh_id) {
    $.ajax({
      type: 'POST',
      url: "{{ route('issue.viewIssuePopup') }}",
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      data: { id: job_id, imh_id: imh_id, '_token': "{{ csrf_token() }}" },
      success: function(data) {
        $('.modal-body').html(data);
        $('#modal-issue').modal('show');
        $('.select2').select2();
      },
      error: function(data) {
        alert(data);
      }
    });
  }

</script>
