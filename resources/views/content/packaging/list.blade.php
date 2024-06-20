@extends('layouts/layoutMaster')

@section('title', 'List')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
    <!-- Form Validation -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <!-- Flat Picker -->
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <!-- Form Validation -->
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
@endsection

@section('page-script')
    {{-- <script src="{{asset('assets/js/tables-datatables-basic.js')}}"></script> --}}
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Packaging List</span>
    </h4>

    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table" id="datatable-list">
                <thead>
                    <tr>
                        <th>SR No.</th>
                        <th>Date</th>
                        <th>Customer Name</th>
                        <th>Style No</th>
                        <th>Style Image</th>
                        <th>Color</th>
                        <th>Carton Number - Qty</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>June 12, 2024</td>
                        <td>
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar-wrapper">
                                    <div class="avatar me-2"><span
                                            class="avatar-initial rounded-circle bg-label-info">Tw</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column"><span class="fw-medium">Twills Clothing Private
                                        Limited</span><small class="text-truncate text-muted">Ms. Mohanalaxmi</small>
                                </div>
                            </div>
                        </td>
                        <td>TEST1</td>
                        <td>
                            <img height="80px" width="50px" src="http://127.0.0.1:8000/samplePhoto/7/24001.jpg"
                                alt="">
                        </td>
                        <td>RED</td>
                        <td>CARTON TEST1 - 50</td>
                        <td>
                            <a href="http://127.0.0.1:8000/planning/create/148/135/edit"
                                class="btn btn-icon btn-label-primary mx-2 waves-effect">
                                <i class="ti ti-edit mx-2 ti-sm"></i>
                            </a>
                            <a href="http://127.0.0.1:8000/planning/create/148/135/view"
                                class="btn btn-icon btn-label-info mx-2 waves-effect">
                                <i class="ti ti-eye mx-2 ti-sm"></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>June 10, 2024</td>
                        <td>
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar-wrapper">
                                    <div class="avatar me-2"><span
                                            class="avatar-initial rounded-circle bg-label-info">Tw</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column"><span class="fw-medium">Twills Clothing Private
                                        Limited</span><small class="text-truncate text-muted">Ms. Mohanalaxmi</small>
                                </div>
                            </div>
                        </td>
                        <td>TEST2</td>
                        <td>
                            <img height="80px" width="50px" src="http://127.0.0.1:8000/samplePhoto/7/24001.jpg"
                                alt="">
                        </td>
                        <td>RED</td>
                        <td>CARTON TEST2 - 100</td>
                        <td>
                            <a href="http://127.0.0.1:8000/planning/create/148/135/edit"
                                class="btn btn-icon btn-label-primary mx-2 waves-effect">
                                <i class="ti ti-edit mx-2 ti-sm"></i>
                            </a>

                            <a href="http://127.0.0.1:8000/planning/create/148/135/view"
                                class="btn btn-icon btn-label-info mx-2 waves-effect">
                                <i class="ti ti-eye mx-2 ti-sm"></i>
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
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#datatable-list').DataTable({});
    });
</script>
