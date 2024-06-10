@extends('layouts/layoutMaster')

@section('title', ' Po Request List')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}"/>
  <!-- Row Group CSS -->
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')}}">
  <!-- Form Validation -->
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/toastr/toastr.css')}}"/>
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
    <span class="text-muted fw-light">Po Request /</span> List
  </h4>

  <!-- DataTable with Buttons -->
  <div class="card">
    <div class="card-datatable table-responsive pt-0">
      <table class="datatables-basic table" id="datatable-list">
        <thead>
        <tr>
          <th>Job Order No.</th>
          <th>Order Planing</th>
          <th>Style No.</th>
          <th>Item Name</th>
          <th>Required Quantity</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td class="text-bold"><a href="{{ route('app-user-view',base64_encode(1)) }}">1</a>
          </td>
          <td></td>
          <td></td>
          <td class="text-bold">ABC
          </td>
          <td>
            <div class="avatar-wrapper">
              <div class="avatar me-2"><span
                  class="avatar-initial rounded-circle bg-label-success">5</span>
              </div>
            </div>

          </td>
          <td>
            <a href="{{ url('/app/po/add') }}" class="btn btn-lg btn-outline-warning waves-effect">
              Generate PO
            </a>
          </td>
        </tr>

        <tr>
          <td class="text-bold"><a href="{{ route('app-user-view',base64_encode(1)) }}">2</a>
          </td>
          <td></td>
          <td></td>
          <td class="text-bold">CDF
          </td>
          <td>
            <div class="avatar-wrapper">
              <div class="avatar me-2"><span
                  class="avatar-initial rounded-circle bg-label-success">25</span>
              </div>
            </div>

          </td>
          <td>
            <a href="{{ url('/app/po/add') }}" class="btn btn-lg btn-outline-warning waves-effect">
              Generate PO
            </a>
          </td>
        </tr>

        <tr>
          <td class="text-bold"><a href="{{ route('app-user-view',base64_encode(1)) }}">3</a>
          </td>
          <td></td>
          <td></td>
          <td class="text-bold">XYZ
          </td>
          <td>
            <div class="avatar-wrapper">
              <div class="avatar me-2"><span
                  class="avatar-initial rounded-circle bg-label-success">30</span>
              </div>
            </div>

          </td>
          <td>
            <a href="{{ url('/app/po/add') }}" class="btn btn-lg btn-outline-warning waves-effect">
              Generate PO
            </a>
          </td>
        </tr>

        <tr>
          <td class="text-bold"><a href="{{ route('app-user-view',base64_encode(1)) }}">4</a>
          </td>
          <td></td>
          <td></td>
          <td class="text-bold">MNO
          </td>
          <td>
            <div class="avatar-wrapper">
              <div class="avatar me-2"><span
                  class="avatar-initial rounded-circle bg-label-success">85</span>
              </div>
            </div>

          </td>
          <td>
            <a href="{{ url('/app/po/add') }}" class="btn btn-lg btn-outline-warning waves-effect">
              Generate PO
            </a>
          </td>
        </tr>

        <tr>
          <td class="text-bold"><a href="{{ route('app-user-view',base64_encode(1)) }}">5</a>
          </td>
          <td></td>
          <td></td>
          <td class="text-bold">CVF
          </td>
          <td>
            <div class="avatar-wrapper">
              <div class="avatar me-2"><span
                  class="avatar-initial rounded-circle bg-label-success">36</span>
              </div>
            </div>

          </td>
          <td>
            <a href="{{ url('/app/po/add') }}" class="btn btn-lg btn-outline-warning waves-effect">
              Generate PO
            </a>
          </td>
        </tr>


        </tbody>
      </table>
    </div>
  </div>
  <!-- Modal to add new record -->
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>
  $(document).ready(function () {
    $('#datatable-list').DataTable({
      order: [[0, 'desc']],
    });
  });

</script>
