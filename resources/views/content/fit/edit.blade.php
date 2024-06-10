@extends('layouts/layoutMaster')

@section('title', 'Fit-Master')

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
    <span class="text-muted fw-light float-left">Master / Fit /</span> Edit
  </h4>
  <!-- Invoice List Widget -->


  <div class="card">
    {{-- <h5 class="card-header">Applicable Categories</h5> --}}
    <div class="card-body">
      <div class="content">


        <div class="content-header mb-4">
          <h3 class="mb-1">Fit Edit</h3>
        </div>
        <form method="post" action="{{ route('Fit-update',$Fit->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="row">

            <div class="col-md-6">
              <div class="col-md-12">
                <label class="form-label" for="demographicName">Fit Name</label>
                <input type="text" id="fitName" name="fitName"
                       class="form-control" value="{{ $Fit->name }}" placeholder="Fit Name"/>
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

