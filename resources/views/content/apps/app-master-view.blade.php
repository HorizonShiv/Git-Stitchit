@extends('layouts/layoutMaster')

@section('title', 'Master Menu')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
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

            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Master /</span> List</h4>

            <!-- Block UI -->
            <div class="row">

                <!-- User Data -->
                <div class="col-xl-6 col-12">
                    <div class="card mb-4" id="card-block">
                        <h5 class="card-header">User Data</h5>
                        <div class="card-body">
                            <div class="block-ui-btn demo-inline-spacing">

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-dark dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-users"></i>Customer
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ route('customer.create') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ route('customer.index') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-dark dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>Vendor
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ url('/auth/register-multisteps') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ url('/app/vendor/list') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-dark dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>User
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ route('app-user-add') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ url('/app/user/list') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-dark dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-square"></i>Company
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ url('app/company/add') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ url('app/company/list') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Data -->

                <!-- Style Data -->
                <div class="col-xl-6 col-12">
                    <div class="card mb-4" id="page-block">
                        <h5 class="card-header">Style Data</h5>
                        <div class="card-body">
                            <div class="block-ui-btn demo-inline-spacing">

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-primary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>Brand
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ route('brand-master.create') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ route('brand-master.index') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>


                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-primary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>Season
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ route('season.create') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ route('season.index') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-primary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>Fit
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ route('fit.create') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ route('fit.index') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-primary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>Demographic
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ route('demographic.create') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ route('demographic.index') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Style Data -->

                <!--  Data -->
                <div class="col-xl-6 col-12 General">
                    <div class="card mb-4" id="page-block">
                        <h5 class="card-header">General Data</h5>

                        <div class="card-body">
                            <div class="block-ui-btn demo-inline-spacing">

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-warning dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>Department
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ route('department.create') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ route('department.index') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-warning dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>Process
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ route('process-master.create') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ route('process-master.index') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>




                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-warning dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>Warehouse
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ route('warehouse-master.create') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ route('warehouse-master.index') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <!-- General Data -->

                <!-- Material Data -->
                <div class="col-xl-6 col-12">
                    <div class="card mb-4" id="page-block">
                        <h5 class="card-header">Material Data</h5>
                        <div class="card-body">
                            <div class="block-ui-btn demo-inline-spacing">


                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-success dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>Style Category
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ route('style-category.create') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ route('style-category.index') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-success dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>Style
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ route('style-master.create') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ route('style-master.index') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>


                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-success dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>Parameter
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ route('parameter-master.create') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ route('parameter-master.index') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-success dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>Item Category
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ route('item-category.create') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ route('item-category.index') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-success dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>Item
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ route('item-master.create') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ route('item-master.index') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
                <!-- Material Data -->

            </div>
            <!-- /Block UI -->
@endsection
<script>
    // Function to add a new row to the table's tbody
    function addItem(tableId) {
        // Reference to the table's tbody
        var tbody = $('#' + tableId + ' tbody');

        // Clone the last row and remove the values
        var newRow = tbody.find('tr:last').clone().find('input').val('').end();

        // Increment the SRL NO value by 1
        var lastSrlNo = parseInt(newRow.find('[name="pcs1[]"]').val());
        newRow.find('[name="pcs1[]"]').val(lastSrlNo + 1);

        // Append the new row to the tbody
        tbody.append(newRow);
    }

    // Function to remove the last added row
    function removeItem(tableId) {
        var tbody = $('#' + tableId + ' tbody');
        if (tbody.find('tr').length > 1) {
            tbody.find('tr:last').remove();
        }
    }

    // Function to remove a specific row
    function removeRow(button) {
        $(button).closest('tr').remove();
    }
</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
