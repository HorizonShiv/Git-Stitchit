@extends('layouts/layoutMaster')

@section('title', 'Master-Garment')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}"/>
@endsection

@section('vendor-script')
  <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>

@endsection

@section('page-script')
  <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
  <script src="{{ asset('assets/js/app-invoice-list.js') }}"></script>
  <script src="{{ asset('assets/js/app-invoice-add.js') }}"></script>
@endsection

@section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light float-left">Master / Garment /</span> Add
  </h4>
  <!-- Invoice List Widget -->


  <div class="card">
    {{-- <h5 class="card-header">Applicable Categories</h5> --}}
    <div class="card-body">
      <div class="content">


        <div class="content-header mb-4">
          <h3 class="mb-1">Garment Information</h3>
        </div>
        <form method="post" action="{{ route('app-garment-store') }}" enctype="multipart/form-data">
          @csrf

          <div class="row">

            <div class="col-md-6">
              <div class="col-md-12">
                <label class="form-label" for="garmentName">Garment Name</label>
                <input type="text" id="garmentName" value="{{ old('garmentName') }}" name="garmentName" value=""
                       class="form-control" placeholder="Garment Name"/>
              </div>
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


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script src="../../assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
