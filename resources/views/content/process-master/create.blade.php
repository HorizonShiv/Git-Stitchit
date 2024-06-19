@extends('layouts/layoutMaster')

@section('title', 'Process-Master')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
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
        <span class="text-muted fw-light float-left">Master / Process /</span> Add
    </h4>
    <!-- Invoice List Widget -->


    <div class="card">
        {{-- <h5 class="card-header">Applicable Categories</h5> --}}
        <div class="card-body">
            <div class="content">


                <div class="content-header mb-4">
                    <h3 class="mb-1">Process Create</h3>
                </div>
                <form method="post" action="{{ route('process-master.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-md-6">
                            <div class="col-md-12">
                                <label class="form-label" for="demographicName">Process Name</label>
                                <input type="text" id="processName" name="processName" class="form-control"
                                    value="{{ old('processName') }}" placeholder="Process Name" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="container">
                                    <div class="row">
                                        <label class="form-label" for="demographicName">Connect With</label>
                                        <div class="col-md-2">
                                            <div class="form-check form-check-primary">
                                                <input type="radio" id="customColorRadio1" name="processConnect"
                                                    class="form-check-input" value="cad">
                                                <label class="form-check-label" for="customColorRadio1">CAD</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check form-check-secondary">
                                                <input type="radio" id="customColorRadio2" name="processConnect"
                                                    class="form-check-input" value="cutting">
                                                <label class="form-check-label" for="customColorRadio2">Cutting</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check form-check-success">
                                                <input type="radio" id="customColorRadio3" name="processConnect"
                                                    class="form-check-input" value="stitching">
                                                <label class="form-check-label" for="customColorRadio3">Stitching</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check form-check-danger">
                                                <input type="radio" id="customColorRadio4" name="processConnect"
                                                    class="form-check-input" value="washing">
                                                <label class="form-check-label" for="customColorRadio4">Washing</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check form-check-secondary">
                                                <input type="radio" id="customColorRadio5" name="processConnect"
                                                    class="form-check-input" value="packing">
                                                <label class="form-check-label" for="customColorRadio5">Packing</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check form-check-info">
                                                <input type="radio" id="customColorRadio6" name="processConnect"
                                                    class="form-check-input" value="wearhouse">
                                                <label class="form-check-label" for="customColorRadio6">Wearhouse</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check form-check-warning mt-2">
                                                <input type="radio" id="customColorRadio7" name="processConnect"
                                                    class="form-check-input" value="service">
                                                <label class="form-check-label" for="customColorRadio7">Service</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row px-0 mt-3">
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <button type="submit" class="btn btn-primary d-grid w-100">Save</button>
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <button type="submit" name="AddMore" value="1"
                                class="btn btn-label-primary waves-effect d-grid w-100">Save & Add more</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection
