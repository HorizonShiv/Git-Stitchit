@extends('layouts/layoutMaster')

@section('title', 'Ware House Menu')

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
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Warehouse /</span> Dashboard</h4>

            <!-- Block UI -->
            <div class="row">

                <!-- User Data -->
                <div class="col-xl-12 col-12">
                    <div class="card mb-4" id="card-block">
                        <h5 class="card-header">Information</h5>
                        <div class="card-body">
                            <div class="block-ui-btn demo-inline-spacing">

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-primary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>GRN Manage
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ url('app/grn/add') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ url('app/grn/list') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-primary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>Invenotry
                                    </button>
                                    <div class="dropdown-menu" style="">

                                        <a class="dropdown-item" href="{{ route('inventory-list') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>

                                        <a class="dropdown-item" href="{{ route('inventory-history') }}"><i
                                                class="ti ti-book me-1"></i>
                                            History</a>

                                        <a class="dropdown-item" href="#"><i class="ti ti-clock me-1"></i>
                                            Back-Up</a>
                                    </div>
                                </div>


                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-primary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>Outward
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ url('/app/outward') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ route('warehouse-outward-list') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-primary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>GR TO Supplier
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ route('warehouse-gr-supplier') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ route('gr-supplier-list') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-label-primary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="menu-icon tf-icons ti ti-truck"></i>Warehouse Transfer
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{ url('/app/app-warehouse-transfer') }}"><i
                                                class="ti ti-pencil me-1"></i>
                                            Add</a>
                                        <a class="dropdown-item" href="{{ route('warehouse-transfer-list') }}"><i
                                                class="ti ti-eye me-1"></i>
                                            View</a>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Data -->


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
