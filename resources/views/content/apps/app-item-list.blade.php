@extends('layouts/layoutMaster')

@section('title', 'Master-Item')

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
    <span class="text-muted fw-light">Master / Item /</span> List
  </h4>

  <!-- DataTable with Buttons -->
  <div class="card">
    <div class="card-datatable table-responsive pt-0">
      <table class="datatables-basic table" id="datatable-list">
        <thead>
        <tr>
          <th>SR No.</th>
          <th>Item Name</th>
          <th>Category</th>
          <th>Sub-Category</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @php $num = 1 @endphp
        @foreach(\App\Models\Item::all() as $Item)
          <tr>
            <td class="text-bold"><a href="">{{ $Item->id }}</a></td>
            <td>{{ $Item->company_name }}</td>
            <td>{{ $Item->SubCategory->name }}</td>
            <td>{{ $Item->SubCategory->CategoryMasters->name }}</td>

            <td>
              <a href="{{ route('app-company-view',$Item->id) }}"><i
                  class="ti ti-eye mx-2 ti-sm"></i></a>
              <a href="{{ route('app-company-edit',$Item->id) }}"><i
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
