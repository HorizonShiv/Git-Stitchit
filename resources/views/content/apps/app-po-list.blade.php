@extends('layouts/layoutMaster')

@section('title', 'PO List - Pages')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>

@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/app-invoice-list.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection

@section('content')

    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left">Filter</span>
    </h4>
    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">

            <div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1 mb-1">

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <label for="users-list-verified">Select Vendor</label>
                        <fieldset class="form-group">
                            <select required id="VendorId" name="VendorId" class="select2 select21 form-select"
                                data-allow-clear="true" onchange="getAllData();" data-placeholder="Select Vendor">
                                <option value="">All</option>
                                @foreach (\App\Models\User::where('role', 'vendor')->get() as $data)
                                    <option value="{{ $data->id }}">{{ $data->company_name }} -
                                        {{ $data->person_name }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <label for="users-list-verified">Select Item</label>
                        <fieldset class="form-group">
                            <select required id="Item" name="Item" class="select2 form-select"
                                data-allow-clear="true" onchange="getAllData();" data-placeholder="Select Item">
                                <option value="">All</option>
                                @foreach (\App\Models\Item::all() as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <label for="users-list-verified">Select Category</label>
                        <fieldset class="form-group">
                            <select required id="CategoryId" name="CategoryId" class="select2 form-select"
                                data-allow-clear="true" onchange="getAllData();" data-placeholder="Select Category">
                                <option value="">All</option>
                                @foreach (\App\Models\ItemCategory::all() as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <label for="users-list-verified">Select Sub Category</label>
                        <fieldset class="form-group">
                            <select required id="SubCategoryId" name="SubCategoryId" class="select2 select21 form-select"
                                data-allow-clear="true" onchange="getAllData();" data-placeholder="Select Sub Category">
                                <option value="">All</option>
                                @foreach (\App\Models\ItemSubCategory::all() as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>



                </div>
            </div>
        </div>
    </div>


    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left">PO /</span> List
    </h4>
    <p class="float-right">
        {{-- <button onclick="getDeniMaxPo()" class="btn btn-sm btn-primary float-right">DeniMax PO Sync.</button> --}}
    </p>
    <!-- Invoice List Widget -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table" id="datatable-list">
                <thead>
                    <tr>
                        <th>SR No.</th>
                        <th>Vendors</th>
                        <th>Our Company</th>
                        <th>PO No</th>
                        <th>PO Date</th>
                        <th>PO Sub Total</th>
                        <th>PO Amount</th>
                        <th>Status</th>
                        <th>PO File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @php $num = 1 @endphp
                    @foreach ($pos as $po)
                        <tr>
                            <td class="text-bold"><a href="">{{ $po->id }}</a></td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar-wrapper">
                                        <div class="avatar me-2"><span
                                                class="avatar-initial rounded-circle bg-label-info">{{ substr($po->User->company_name, 0, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column"><span
                                            class="fw-medium">{{ $po->User->company_name }}</span><small
                                            class="text-truncate text-muted">{{ $po->User->person_name }}</small>
                                        <small class="text-truncate text-muted">{{ $po->User->person_mobile }}</small>
                                    </div>
                                </div>

                            </td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar-wrapper">
                                        <div class="avatar me-2"><span
                                                class="avatar-initial rounded-circle bg-label-info">{{ substr($po->Company->b_name ?? '-', 0, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column"><span
                                            class="fw-medium">{{ $po->Company->b_name ?? '' }}</span><small
                                            class="text-truncate text-muted">{{ $po->Company->b_mobile ?? '' }}</small>
                                    </div>
                                </div>

                            </td>
                            <td>{{ $po->po_no }}</td>
                            <td>{{ date('D, d M Y', strtotime($po->po_date)) }}</td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="d-flex flex-column"><span
                                            class="fw-medium">{{ $po->sub_total_amount }}</span>
                                        <small class="text-truncate text-muted">Discount
                                            : {{ $po->discount_amount }}</small>
                                        <small
                                            class="text-truncate text-muted">{{ !empty($po->igst_amount) ? 'IGST' : 'CGST/SGST' }}
                                            Tax
                                            : {{ $po->igst_amount + $po->sgst_amount + $po->cgst_amount }}</small>
                                    </div>
                                </div>

                            </td>
                            <td>
                                <span>{{ $po->po_amount }}</span><br>
                                <small class="mt-2 text-truncate text-muted">Qty :
                                    : {{ array_sum(array_column($po->PoItem->toArray(), 'qty')) }}</small>
                            </td>
                            <td>
                                <span
                                    class="badge rounded bg-label-{{ $po->is_approve == '1' ? 'success' : 'warning' }}">{{ $po->is_approve == '1' ? 'Approved' : 'Pending' }}</span>
                                </br></br>
                                @if ($po->is_approve != '1')
                                    <button class="btn btn-sm btn-outline-success waves-effect"
                                        onclick="vendorApprove({{ $po->id }});">
                                        Approve
                                    </button>
                                @endif
                            </td>
                            <td>
                                @if (!empty($po->po_file))
                                    <a target="_blank" href="{{ url('po/' . $po->id . '/' . $po->po_file) }}">Download
                                        File</a>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('app-po-preview', $po->id) }}"><i
                                            class="ti ti-eye mx-2 ti-sm"></i></a>
                                    <div class="dropdown"><a href="javascript:;"
                                            class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"
                                            aria-expanded="false"><i class="ti ti-dots-vertical ti-sm"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end" style="">
                                            @if ($po->is_approve != '1')
                                                <a href="{{ route('app-po-edit', $po->id) }}"
                                                    class="dropdown-item">Edit</a>
                                            @endif
                                            <a href="{{ route('app-po-print', $po->id) }}"
                                                class="dropdown-item">Print</a>
                                            <a onclick="" class="dropdown-item">Po Wise GRN Syn</a>
                                            <div class="dropdown-divider"></div>
                                            @if ($po->is_approve != '1')
                                                <a onclick="poDelete({{ $po->id }});"
                                                    class="dropdown-item delete-record text-danger">Delete</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @php $num++ @endphp
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        getAllData();
    });

    function getAllData() {
        let grn_receive = $('input[name="grn_receive"]:checked').val() || "0";
        $("#overlay").fadeIn(100);
        $('#datatable-list').DataTable({
            autoWidth: false,
            order: [
                [0, 'desc']
            ],
            lengthMenu: [
                [10, 20, 100, 50000],
                [10, 20, 100, "All"]
            ],
            order: [
                [0, 'desc']
            ],
            "ajax": {
                "url": "{{ route('app-po-filter') }}",
                "type": "POST",
                "headers": "{ 'X-CSRF-TOKEN': $('meta[name='csrf-token']').attr('content') }",
                "data": {
                    "category_id": $('#CategoryId').val(),
                    "subCategory_id": $('#SubCategoryId').val(),
                    "item_id": $('#Item').val(),
                    "vendor_id": $('#VendorId').val(),
                    "_token": "{{ csrf_token() }}"
                },
            },

            "initComplete": function(setting, json) {
                $("#overlay").fadeOut(100);
            },
            bDestroy: true
        });
    }

    // $(document).ready(function() {
    //     $('#datatable-list').DataTable({
    //         "ordering": false
    //     });
    // });

    function vendorApprove(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Approve!',
            reverseButtons: true,
            cancelButtonColor: '#d33',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: true
        }).then(function(result) {
            if (result.value) {
                $("#overlay").fadeIn(100);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('poApprove') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(resultData) {
                        Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                            location.reload();
                            $("#overlay").fadeOut(100);
                        });
                    }
                });
            } else if (result.dismiss === 'cancel') {
                Swal.fire(
                    'Cancelled',
                    'Your request has been Cancelled !!',
                    'error'
                )
            }
        });
    }

    function getDeniMaxPo() {
        $("#overlay").fadeIn(100);
        $.ajax({
            "url": "{{ route('getDeniMaxPo') }}",
            "type": "POST",
            "headers": "{ 'X-CSRF-TOKEN': $('meta[name='csrf-token']').attr('content') }",
            "data": {
                "_token": "{{ csrf_token() }}"
            },
            success: function(output) {
                Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                    $("#overlay").fadeOut(100);
                    location.reload();
                });
            }
        })
    }

    function poDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete!',
            reverseButtons: true,
            cancelButtonColor: '#d33',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: true
        }).then(function(result) {
            if (result.value) {
                $("#overlay").fadeIn(100);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('poDelete') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(resultData) {
                        Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                            location.reload();
                            $("#overlay").fadeOut(100);
                        });
                    }
                });
            } else if (result.dismiss === 'cancel') {
                Swal.fire(
                    'Cancelled',
                    'Your request has been Cancelled !!',
                    'error'
                )
            }
        });
    }
</script>
