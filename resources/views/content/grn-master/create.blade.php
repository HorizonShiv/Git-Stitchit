@extends('layouts/layoutMaster')

@section('title', 'GRN-Master')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}"/>
@endsection

@section('page-script')
  <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
  <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection

@section('vendor-script')
  <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

@section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light float-left">Master / GRN /</span> Add
  </h4>
  <!-- Invoice List Widget -->


  <div class="card">
    {{-- <h5 class="card-header">Applicable Categories</h5> --}}
    <div class="card-body">
      <div class="content">


        <div class="content-header mb-4">
          <h3 class="mb-1">GRN Create</h3>
        </div>
        <form method="post" action="{{ route('grn-master.store') }}" enctype="multipart/form-data">
          @csrf

          <div class="row">

            <div class="col-md-3">
              <label class="form-label" for="OrderId">Select Warehouse</label>
              <select required id="SelectWarehouse" name="SelectWarehouse" class="select2 select21 form-select"
                      data-allow-clear="true" data-placeholder="Select Order">
                <option value="AB-1" selected>AB-1</option>

                @foreach (\App\Models\Buyer::all() as $data)
                  <option value="{{ $data->id }}">{{ $data->company_name }} -
                    {{ $data->buyer_name }}</option>
                @endforeach

              </select>
            </div>
          </div>
          <br>
          <div class="d-grid gap-2 col-lg-3 mx-auto mt-3">
            <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light"
                    type="button">Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>



@endsection

