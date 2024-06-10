@extends('layouts.layoutMaster')

@section('title', 'List')

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
    <span class="text-muted fw-light">Production/</span>History
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
          <th>Department</th>
          <th>Job Center</th>
          <th>Created Date</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td class="text-bold"><a href="{{ route('app-user-view',base64_encode(1)) }}">1</a>
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex flex-column"><span
                  class="fw-medium">JOB:3530</span></div>
            </div>
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex flex-column"><span
                  class="fw-medium">Cutting</span></div>
            </div>
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex flex-column"><span
                  class="fw-medium">Job Center</span></div>
            </div>
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex flex-column"><span
                  class="fw-medium">15-Aug-2024</span></div>
            </div>
          </td>
          <td>
            <a class="btn btn-icon btn-label-primary mt-1 waves-effect" href="{{route('process-transfer-preview')}}"><i class="ti ti-printer  mx-2 ti-sm"></i></a>
          </td>
        </tr>
        <tr>
          <td class="text-bold"><a href="{{ route('app-user-view',base64_encode(1)) }}">2</a>
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex flex-column"><span
                  class="fw-medium">JOB:3542</span></div>
            </div>
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex flex-column"><span
                  class="fw-medium">Cutting</span></div>
            </div>
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex flex-column"><span
                  class="fw-medium">Job Center</span></div>
            </div>
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex flex-column"><span
                  class="fw-medium">05-Jun-2023</span></div>
            </div>
          </td>

          <td>
            <a class="btn btn-icon btn-label-primary mt-1 waves-effect"
               href="{{route('process-transfer-departmentPrintPreview')}}"><i class="ti ti-printer  mx-2 ti-sm"></i></a>
          </td>
        </tr>
        <tr>
          <td class="text-bold"><a href="{{ route('app-user-view',base64_encode(1)) }}">3</a>
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex flex-column"><span
                  class="fw-medium">JOB:3982</span></div>
            </div>
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex flex-column"><span
                  class="fw-medium">Stitching</span></div>
            </div>
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex flex-column"><span
                  class="fw-medium">Job Center</span></div>
            </div>
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex flex-column"><span
                  class="fw-medium">01-Apr-2022</span></div>
            </div>
          </td>
          <td>
            <a class="btn btn-icon btn-label-primary mt-1 waves-effect" href="{{route('process-transfer-preview')}}"><i class="ti ti-printer  mx-2 ti-sm"></i></a>
          </td>
        </tr>
        <tr>
          <td class="text-bold"><a href="{{ route('app-user-view',base64_encode(1)) }}">4</a>
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex flex-column"><span
                  class="fw-medium">JOB:4420</span></div>
            </div>
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex flex-column"><span
                  class="fw-medium">Washing</span></div>
            </div>
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex flex-column"><span
                  class="fw-medium">Job Center</span></div>
            </div>
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex flex-column"><span
                  class="fw-medium">25-May-2023</span></div>
            </div>
          </td>
          <td>
            <a class="btn btn-icon btn-label-primary mt-1 waves-effect" href="{{route('process-transfer-preview')}}"><i class="ti ti-printer  mx-2 ti-sm"></i></a>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
@endsection

@section('extraScripts')
  {{--  Add Script Here Table Reltaed--}}

  <script>
    $(document).ready(function() {
      $('#datatable-list').DataTable({
        order: [[0, 'desc']]
      });
    });

    function redirectpage() {
      window.location.href = "{{route('issue-to',1)}}";
    }
  </script>
@endsection
