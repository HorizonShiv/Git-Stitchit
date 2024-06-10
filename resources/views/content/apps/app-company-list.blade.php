@extends('layouts/layoutMaster')

@section('title', 'Company')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}"/>
  <!-- Row Group CSS -->
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')}}">
  <!-- Form Validation -->
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}"/>
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
  <!-- Flat Picker -->
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
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
        <span class="text-muted fw-light">Master / Company /</span> List
    </h4>

  <!-- DataTable with Buttons -->
  <div class="card">
    <div class="card-datatable table-responsive pt-0">
      <table class="datatables-basic table" id="datatable-list">
        <thead>
        <tr>
          <th>SR No.</th>
          <th>Company Name</th>
          <th>PO Setting</th>
          <th>Billing Name</th>
          <th>Billing Email</th>
          <th>Billing Address</th>
          {{-- <th>Shipping Name</th>
          <th>Shipping Email</th>
          <th>Shipping Address</th> --}}
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @php $num = 1 @endphp
        @foreach(\App\Models\Company::all() as $company)
          <tr>
            <td class="text-bold"><a href="">{{ $num }}</a></td>
            <td>{{ $company->c_name }}</td>
            <td>
              <div class="d-flex justify-content-start align-items-center">
                <div class="d-flex flex-column"><span class="fw-medium">Pre Fix : {{ $company->pre_fix }}</span><small
                    class="text-truncate text-muted">PO No : {{ $company->po_no_set }}</small></div>
              </div>

            </td>
            <td>
              <div class="d-flex justify-content-start align-items-center">
                <div class="avatar-wrapper">
                  <div class="avatar me-2"><span
                      class="avatar-initial rounded-circle bg-label-info">{{ substr($company->b_name, 0, 2) }}</span>
                  </div>
                </div>
                <div class="d-flex flex-column"><span
                    class="fw-medium">{{ $company->b_name }}</span><small
                    class="text-truncate text-muted">{{ $company->b_mobile }}</small></div>
              </div>

            </td>

            <td>{{ $company->b_email }}</td>
            <td><?= $company->b_address1 . '<br>' . $company->b_address2 . '<br>' . $company->b_city . '<br>' . $company->b_state . '<br>' . $company->b_pincode?></td>
            {{-- <td>
              <div class="d-flex justify-content-start align-items-center">
                <div class="avatar-wrapper">
                  <div class="avatar me-2"><span
                      class="avatar-initial rounded-circle bg-label-warning">{{ substr($company->s_name, 0, 2) }}</span>
                  </div>
                </div>
                <div class="d-flex flex-column"><span
                    class="fw-medium">{{ $company->s_name }}</span><small
                    class="text-truncate text-muted">{{ $company->s_mobile }}</small></div>
              </div>

            </td> --}}
            {{-- <td>{{ $company->s_email  }}</td> --}}
            {{-- <td><?= $company->s_address1 . '<br>' . $company->s_address2 . '<br>' . $company->s_city . '<br>' . $company->s_state . '<br>' . $company->s_pincode?></td> --}}
            <td>
               <a class="btn btn-icon btn-label-primary mx-2 mt-1"
                                    href="{{ route('app-company-view', $company->id) }}"><i
                                        class="ti ti-eye mx-2 ti-sm"></i></a>

                                <a class="btn btn-icon btn-label-primary mx-2 mt-1"
                                    href="{{ route('app-company-edit', $company->id) }}"><i
                                        class="ti ti-edit mx-2 ti-sm"></i></a>
            </td>
          </tr>
          @php $num++ @endphp
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
  $(document).ready(function () {
    $('#datatable-list').DataTable({
      order: [[0, 'desc']],
    });
  });
</script>
