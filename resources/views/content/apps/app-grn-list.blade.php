@extends('layouts/layoutMaster')

@section('title', 'GRN List - Pages')

{{-- @section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/app-invoice-list.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection --}}

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection

@section('page-script')
    {{-- <script src="{{asset('assets/js/tables-datatables-basic.js')}}"></script> --}}
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>

@endsection


@section('content')

    <!-- Invoice List Widget -->
    <p class="float-right">
        {{-- <button onclick="getGRNQtyByOrderInward()" class="btn btn-sm btn-primary float-right">DeniMax GRN Sync.</button> --}}
    </p>

    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left">Filter</span>
    </h4>
    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">

            <div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1 mb-1">

                    <div class="col-lg-4 col-md-6 col-sm-6 mt-2">
                        <label for="users-list-verified">Select Ware House</label>
                        <fieldset class="form-group">
                            <select required id="WareHouse" name="WareHouse" class="select2 select21 form-select"
                                data-allow-clear="true" onchange="getAllData();" data-placeholder="Select Ware House">
                                <option value="">All</option>
                                @foreach (\App\Models\WareHouse::all() as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 mt-2">
                        <label for="users-list-verified">Select Vendor</label>
                        <fieldset class="form-group">
                            <select required id="Vendor" name="Vendor" class="select2 select21 form-select"
                                data-allow-clear="true" onchange="getAllData();" data-placeholder="Select Vendor">
                                <option value="">All</option>
                                @foreach (\App\Models\User::where('role', 'vendor')->get() as $data)
                                    <option value="{{ $data->id }}">{{ $data->company_name }} -
                                        {{ $data->person_name }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 mt-2">
                        <label for="users-list-verified">Select Type</label>
                        <fieldset class="form-group">
                            <select required id="Type" name="Type" class="select2 select21 form-select"
                                data-allow-clear="true" onchange="getAllData();" data-placeholder="Select Item">
                                <option value="">All</option>
                                <option value="1">With PO</option>
                                <option value="2">Without PO</option>
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 mt-2">
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

                    <div class="col-lg-4 col-md-6 col-sm-6 mt-2">
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

                    <div class="col-lg-4 col-md-6 col-sm-6 mt-2">
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
        <span class="text-muted fw-light float-left">GRN /</span> List
    </h4>
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="dt-row-grouping table" id="datatable-list">
                <thead>
                    <tr>
                        <th>SR No.</th>
                        <th>GRN - PO No</th>
                        <th>VENDORS</th>
                        <th>GRN Date</th>
                        <th>Item</th>
                        <th>Total Qty</th>
                        <th>Rate</th>
                        <th>Type</th>
                        <th>Invoice No<br><span class="text-secondary">Challan No</span></th>
                        <th>Remark</th>
                        <th>Rollback</th>

                    </tr>
                </thead>
                <tbody>
                    {{-- @php $num = 1 @endphp
                    @foreach ($grnItems as $grnItem)
                        <tr>
                            <td class="text-bold">{{ $num }}</td>
                            <td class="text-bold">
                                {{ $grnItem->grn_no ?? '' }} - <a
                                    href="{{ route('app-po-preview', $grnItem->PoItem->Po->id ?? '') }}">{{ $grnItem->PoItem->Po->po_no ?? '' }}</a>
                            </td>

                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar-wrapper">
                                        <div class="avatar me-2">
                                            <span class="avatar-initial rounded-circle bg-label-info">
                                                @if (!empty($grnItem->PoItem))
                                                    {{ substr($grnItem->PoItem->Po->User->company_name, 0, 2) }}
                                                @else
                                                    SP
                                                @endif
                                            </span>

                                        </div>
                                    </div>
                                    <div class="d-flex flex-column"><span class="fw-medium">
                                            @if (!empty($grnItem->PoItem))
                                                {{ $grnItem->PoItem->Po->User->company_name }}
                                            @else
                                                {{ $grnItem->User->company_name ?? '' }}
                                            @endif
                                        </span><small class="text-truncate text-muted">
                                            @if (!empty($grnItem->PoItem))
                                                {{ $grnItem->PoItem->Po->User->person_name }}
                                            @else
                                                {{ $grnItem->User->person_name ?? '' }}
                                            @endif
                                        </small>
                                        <small class="text-truncate text-muted">
                                            @if (!empty($grnItem->PoItem))
                                                {{ $grnItem->PoItem->Po->User->person_mobile }}
                                            @else
                                                {{ $grnItem->User->person_mobile ?? '' }}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>{{ date('D, d M Y', strtotime($grnItem->date)) }}</td>
                            <td>
                                @if (!empty($grnItem->PoItem))
                                    {{ $grnItem->PoItem->item_name ?? '' }}
                                @else
                                    {{ $grnItem->Item->name ?? '' }}
                                @endif
                            </td>
                            <td>{{ $grnItem->qty }}</td>
                            <td><?= $grnItem->invoiceNumber . '<br/><span class="text-secondary">' . $grnItem->challanNumber . '</span>' ?>
                            </td>
                            <td>{{ $grnItem->remark }}</td>
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
            rowGroup: {
                dataSrc: 1 //index of the "PO No" column, adjust accordingly if index is not 1
            },
            order: [
                [0, 'desc']
            ],
            "ajax": {
                "url": "{{ route('app-grn-filter') }}",
                "type": "POST",
                "headers": "{ 'X-CSRF-TOKEN': $('meta[name='csrf-token']').attr('content') }",
                "data": {
                    "category_id": $('#CategoryId').val(),
                    "subCategory_id": $('#SubCategoryId').val(),
                    "item_id": $('#Item').val(),
                    "vendor_id": $('#Vendor').val(),
                    "type": $('#Type').val(),
                    "warehouse_id": $('#WareHouse').val(),
                    "_token": "{{ csrf_token() }}"
                },
            },

            "initComplete": function(setting, json) {
                $("#overlay").fadeOut(100);
            },
            bDestroy: true
        });
    }
</script>
<script>
	 function rollbackGrnItem(id) {
        console.log(id);
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to remove item data from inventory!!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, rollback it!',
            customClass: {
                confirmButton: 'btn btn-primary me-3',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $("#overlay").fadeIn(100);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('grnRollback') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        grnId: id,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(resultData) {
                        if (resultData.success) {
                            Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                                location.reload();
                                $("#overlay").fadeOut(100);
                            });
                        } else {
                            Swal.fire('Error',
                                'opps something went wrong!',
                                'error').then(() => {
                                $("#overlay").fadeOut(100);
                            });
                        }

                    }

                });
            }
        });
    }
    function getGRNQtyByOrderInward() {
        $("#overlay").fadeIn(100);
        $.ajax({
            "url": "{{ route('getGRNQtyByOrderInward') }}",
            "type": "POST",
            "headers": "{ 'X-CSRF-TOKEN': $('meta[name='csrf-token']').attr('content') }",
            "data": {
                "_token": "{{ csrf_token() }}"
            },
            success: function(output) {
                Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                    location.reload();
                    $("#overlay").fadeOut(100);
                });
            }
        })
    }

    // $(document).ready(function() {
    //     $('#datatable-list').DataTable({
    //         rowGroup: {
    //             dataSrc: 1 //index of the "PO No" column, adjust accordingly if index is not 1
    //         },
    //         order: [
    //             [0, 'desc']
    //         ],
    //     });
    // });
</script>
