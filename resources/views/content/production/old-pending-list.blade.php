@extends('layouts/layoutMaster')

@section('title', 'Panding List')

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
    <span class="text-muted fw-light">Pending /</span> List
  </h4>

  <!-- DataTable with Buttons -->
  <div class="card">
    <div class="card-datatable table-responsive pt-0">
      <table class="datatables-basic table" id="datatable-list">
        <thead>
        <tr>
          <th>SR No.</th>
          <th>OP Date</th>
          <th>Customer Name</th>
          <th>Style Name</th>
          <th>Pending Quantity</th>
          <th>Ship Date</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td class="text-bold"><a href="{{ route('app-user-view',base64_encode(1)) }}">1</a>
          </td>
          <td class="text-bold">23 April 2024
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="avatar-wrapper">
                <div class="avatar me-2"><span
                    class="avatar-initial rounded-circle bg-label-info">EF</span>
                </div>
              </div>
              <div class="d-flex flex-column"><span
                  class="fw-medium">EFGH</span><small
                  class="text-truncate text-muted">cc</small></div>
            </div>

          </td>
          <td>
            Style#123
          </td>
          <td>
            <div class="d-flex flex-column"><span
                class="fw-medium">300</span><small
                class="text-truncate text-muted">500</small></div>
          </td>
          <td class="text-bold text-success">25 June 2024
          </td>
          <td>
            <a href="" class="btn btn-lg btn-outline-warning waves-effect" data-bs-toggle="modal"
               data-bs-target="#addvalue" type="button">
              Complate
            </a>
          </td>
        </tr>

        <tr>
          <td class="text-bold"><a href="{{ route('app-user-view',base64_encode(1)) }}">2</a>
          </td>
          <td class="text-bold">23 March 2024
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="avatar-wrapper">
                <div class="avatar me-2"><span
                    class="avatar-initial rounded-circle bg-label-info">EF</span>
                </div>
              </div>
              <div class="d-flex flex-column"><span
                  class="fw-medium">EFGH</span><small
                  class="text-truncate text-muted">cc</small></div>
            </div>

          </td>
          <td>
            #style2
          </td>
          <td>
            <div class="d-flex flex-column"><span
                class="fw-medium">200</span><small
                class="text-truncate text-muted">500</small></div>
          </td>
          <td class="text-bold text-warning">28 April 2024
          </td>
          <td>

            <a href="" class="btn btn-lg btn-outline-warning waves-effect" data-bs-toggle="modal"
               data-bs-target="#addvalue" type="button">
              Complete
            </a>

          </td>
        </tr>
        <tr>
          <td class="text-bold"><a href="{{ route('app-user-view',base64_encode(1)) }}">3</a>
          </td>
          <td class="text-bold">23 FEB 2024
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="avatar-wrapper">
                <div class="avatar me-2"><span
                    class="avatar-initial rounded-circle bg-label-info">EF</span>
                </div>
              </div>
              <div class="d-flex flex-column"><span
                  class="fw-medium">EFGH</span><small
                  class="text-truncate text-muted">cc</small></div>
            </div>

          </td>
          <td>
            #Style3
          </td>
          <td>
            <div class="d-flex flex-column"><span
                class="fw-medium">900</span><small
                class="text-truncate text-muted">1000</small></div>
          </td>
          <td class="text-bold text-success">28 MAY 2024
          </td>


          <td>

            <a href="" class="btn btn-lg btn-outline-warning waves-effect" data-bs-toggle="modal"
               data-bs-target="#addvalue" type="button">
              Complate
            </a>

          </td>
        </tr>
        <tr>
          <td class="text-bold"><a href="{{ route('app-user-view',base64_encode(1)) }}">4</a>
          </td>
          <td class="text-bold">23 MAY 2024
          </td>
          <td>
            <div class="d-flex justify-content-start align-items-center">
              <div class="avatar-wrapper">
                <div class="avatar me-2"><span
                    class="avatar-initial rounded-circle bg-label-info">EF</span>
                </div>
              </div>
              <div class="d-flex flex-column"><span
                  class="fw-medium">EFGH</span><small
                  class="text-truncate text-muted">cc</small></div>
            </div>

          </td>
          <td>
            #Style45
          </td>
          <td>
            <div class="d-flex flex-column"><span
                class="fw-medium">550</span><small
                class="text-truncate text-muted">850</small></div>
          </td>
          <td class="text-bold text-success">20 DECEMBER 2024
          </td>


          <td>

            <a href="" class="btn btn-lg btn-outline-warning waves-effect" data-bs-toggle="modal"
               data-bs-target="#addvalue" type="button">
              Complate
            </a>

          </td>
        </tr>


        </tbody>
      </table>
    </div>

    <div class="modal fade" id="addvalue" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
          <div class="modal-body">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="text-center mb-4">
              <h3 class="mb-2">Add Value</h3>
            </div>
            <form id="editUserForm" class="row g-3">

              <div class="col-12 col-md-12 text-center">
                <label class="form-label" for="ModelAddValue">Add Value</label>
                <input required type="text" id="ModelAddValue" name="ModelAddValue" class="form-control"
                       placeholder="Add Value" />
              </div>

              <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary me-sm-3 me-1" onclick="AddValue();"
                        data-bs-dismiss="modal">Save
                </button>
                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                  Cancel
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
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
