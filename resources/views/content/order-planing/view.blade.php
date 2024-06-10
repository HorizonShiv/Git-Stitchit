@extends('layouts/layoutMaster')

@section('title', 'Job Order Planing Add')

@section('vendor-style')

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/rateyo/rateyo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/wizard-ex-checkout.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />

    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>

    <script src="{{ asset('assets/js/config.js') }}"></script>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/rateyo/rateyo.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->

    <script src="{{ asset('assets/js/modal-add-new-address.js') }}"></script>
    <script src="{{ asset('assets/js/wizard-ex-checkout.js') }}"></script>

@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection


@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left">Order Planing/</span> View
    </h4>

    <form action="{{ route('order-planning.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">


                <div class="card">
                    {{-- <h5 class="card-header">Applicable Categories</h5> --}}
                    <div class="card-body">

                        <div class="content">

                            <div class="content-header mb-4">
                                <h4 class="mb-1">Primary Information</h4>
                            </div>
                            <div class="row g-3">

                                <div class="col-md-3">
                                    <label class="form-label" for="JobOrderDate">Date</label>
                                    <input type="date" class="form-control date-picker" id="JobOrderDate"
                                        name="JobOrderDate" placeholder="YYYY-MM-DD" value="{{ date('Y-m-d') }}" />
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="OrderId">Sale Order No.</label>
                                    <input type="text" class="form-control date-picker" id="saleOrder" name="saleOrder"
                                        placeholder="Sale Order" value="{{ $salesOrderDetails->sales_order_no }}"
                                        readonly />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="StyleId">Style No./Customer Style No.</label>
                                    <select id="StyleNo" name="StyleNo" class="select2 select21 form-select"
                                        data-allow-clear="true" data-placeholder="Select Style"
                                        onchange="getStyleDetails()">
                                        <option value="">Select</option>
                                        @if (!empty($planingOrders))
                                            <option selected value="{{ $planingOrders->sales_order_style_id }}">
                                                {{ $planingOrders->SalesOrderStyleInfo[0]->StyleMaster->style_no ?? '' }}
                                                / {{ $planingOrders->SalesOrderStyleInfo[0]->customer_style_no ?? '' }}
                                            </option>
                                        @else
                                            @foreach ($salesOrderStyleInfos as $salesOrderStyleInfo)
                                                <option @if (!empty($planingOrders) && $planingOrders->sales_order_style_id == $salesOrderStyleInfo->id) {{ 'selected' }} @endif
                                                    value="{{ $salesOrderStyleInfo->id }}">
                                                    {{ $salesOrderStyleInfo->StyleMaster->style_no }}
                                                    / {{ $salesOrderStyleInfo->customer_style_no }}</option>
                                            @endforeach
                                        @endif


                                    </select>
                                </div>
                                <div class="col-md-3 mb-4">
                                    <label for="select2Primary" class="form-label">Master Style</label>
                                    <div class="select2-primary">
                                        <select id="select2Primary" class="select2 form-select" multiple>
                                            <option value="1">Red</option>
                                            <option value="2">Black</option>
                                            <option value="3">Green</option>
                                            <option value="4">Yellow</option>
                                            <option value="5">Blue</option>
                                        </select>
                                    </div>
                                </div>


                            </div>

                            <div>
                                <!-- Invoice List Widget -->

                                <div class="mb-4" id="showStyleDetails">
                                    <div class="card-widget-separator-wrapper">
                                        <div class="card-body card-widget-separator">
                                            <div class="row gy-4 gy-sm-1">
                                                <div class="col-sm-6 col-lg-3">
                                                    <div
                                                        class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                                        <div>
                                                            <p class="mb-0  font-weight-bold">Total Piceses</p>
                                                        </div>
                                                        <span class="avatar me-sm-4">
                                                            <div class="avatar me-2"><span
                                                                    class="avatar-initial rounded-circle bg-label-success">0</span>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <hr class="d-none d-sm-block d-lg-none me-4">
                                                </div>
                                                <div class="col-sm-6 col-lg-3">
                                                    <div
                                                        class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                                        <div>
                                                            <p class="mb-0 font-weight-bold">Category</p>
                                                        </div>
                                                        <span class="me-sm-4 btn-sm btn btn-outline-primary">- </span>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-lg-3">
                                                    <div
                                                        class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                                        <div>
                                                            <p class="mb-0 font-weight-bold">Fit</p>

                                                        </div>
                                                        <span class="me-sm-4 btn btn-outline-info btn-sm">- </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-lg-3">
                                                    <div
                                                        class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                                        <div>
                                                            <p class="mb-0 font-weight-bold">Discription</p>

                                                        </div>
                                                        <span class=" me-sm-4">
                                                            <p class="mb-0">-</p>
                                                        </span>
                                                    </div>
                                                </div>


                                                <div class="col-sm-6 col-lg-3">
                                                    <div
                                                        class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                                                        <div>
                                                            <p class="mb-0 font-weight-bold">Colors</p>

                                                        </div>
                                                        <span class="avatar me-sm-4">
                                                            <div class="avatar me-2"><span
                                                                    class="avatar-initial rounded-circle bg-label-success">0</span>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <hr class="d-none d-sm-block d-lg-none">
                                                </div>
                                                <div class="col-sm-6 col-lg-3">
                                                    <div
                                                        class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                                        <div>
                                                            <p class="mb-0 font-weight-bold">Sub-Category</p>

                                                        </div>
                                                        <span class="me-sm-4 btn btn-outline-primary btn-sm">- </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-lg-3">
                                                    <div
                                                        class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                                        <div>

                                                            <p class="mb-0 font-weight-bold">Customer Style No.</p>

                                                        </div>
                                                        <span class="me-sm-4 btn btn-outline-info btn-sm">- </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-lg-3">
                                                    <div
                                                        class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                                        <div>

                                                            <p class="mb-0 font-weight-bold">Ship Date</p>

                                                        </div>
                                                        <span class="me-lg-4">-</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="ti ti-truck ti-md"></i></span>
                            </div>
                            <h4 class="ms-1 mb-0" id="finalTotal">0</h4>
                        </div>
                        <p class="mb-1">Total Amount</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-warning"><i
                                        class="ti ti-alert-triangle ti-md"></i></span>
                            </div>
                            <h4 class="ms-1 mb-0" id="perPcCost">0</h4>
                        </div>
                        <p class="mb-1">Per Pcs Cost</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-danger"><i
                                        class="ti ti-git-fork ti-md"></i></span>
                            </div>
                            <h4 class="ms-1 mb-0">0</h4>
                        </div>
                        <p class="mb-1">Duration</p>

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-info"><i
                                        class="ti ti-clock ti-md"></i></span>
                            </div>
                            <h4 class="ms-1 mb-0">0</h4>
                        </div>
                        <p class="mb-1">Coming Soon</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-12 col-lg-12  col-md-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Process List</h4>
                    </div>
                    <div class="card-body table-responsive pt-0">
                        <table class="datatables-basic  table" id="datatable-list-process">
                            <thead class="table-light">
                                <tr>
                                    <th>Sr No</th>
                                    <th>Process</th>
                                    <th>Qty</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                    <th>Duration</th>
                                </tr>
                            </thead>
                            <tbody id="dataTableBody">
                                @php
                                    $totalQty = 0;
                                    $totalRate = 0;
                                    $totalValue = 0;
                                    $totalDuration = 0;
                                @endphp
                                @if (!empty($planingOrders))
                                    @foreach ($planingOrders->PlaningOrderProcesses as $planingOrderProcess)
                                        <tr>
                                            <td>{{ $planingOrderProcess->sr_no }}</td>
                                            <td>{{ $planingOrderProcess->ProcessMaster->name ?? '' }}</td>
                                            <td>{{ $planingOrderProcess->qty }}</td>
                                            <td>{{ $planingOrderProcess->rate }}</td>
                                            <td>{{ $planingOrderProcess->value }}</td>
                                            <td>{{ $planingOrderProcess->duration }}</td>
                                        </tr>
                                        @php
                                            $totalQty += $planingOrderProcess->qty;
                                            $totalRate += $planingOrderProcess->rate;
                                            $totalValue += $planingOrderProcess->value;
                                            $totalDuration += $planingOrderProcess->duration;
                                        @endphp
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $totalQty }}</td>
                                    <td>{{ $totalRate }}</td>
                                    <td>{{ $totalValue }}</td>
                                    <td>{{ $totalDuration }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        <h4>Bom List</h4>
                    </div>
                    <div class="card-body table-responsive pt-0">
                        <table class="datatables-basic table" id="datatable-list-bom">
                            <thead class="table-light">
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Item</th>
                                    <th>Per Pc Qty</th>
                                    <th>Order Qty</th>
                                    <th>Require Qty</th>
                                    <th>Available Qty</th>
                                    <th>Rate</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="dataTableBody">
                                @php
                                    $totalRequiredQty = 0;
                                    $totalAvailableQty = 0;
                                    $totalRate = 0;
                                    $total = 0;
                                @endphp
                                @if (!empty($planingOrders))
                                    @php $num =1; @endphp
                                    @foreach ($planingOrders->PlaningOrderMaterials as $planingOrderMaterials)
                                        @if (!empty($planingOrderMaterials->id))
                                            @php
                                                $totalRequiredQty += $planingOrderMaterials->required_qty;
                                                $totalAvailableQty += $planingOrderMaterials->available_qty;
                                                $totalRate += $planingOrderMaterials->rate;
                                                $total += $planingOrderMaterials->total;
                                            @endphp
                                            <tr>
                                                <td>{{ $num }}</td>
                                                <td>{{ $planingOrderMaterials->Item->ItemCategory->name ?? '' }}</td>
                                                <td>{{ $planingOrderMaterials->Item->ItemSubCategory->name ?? '' }}</td>
                                                <td>{{ $planingOrderMaterials->Item->name ?? '' }}</td>
                                                <td>{{ $planingOrderMaterials->per_pc_qty }}</td>
                                                <td>{{ $planingOrderMaterials->order_qty }}</td>
                                                <td>{{ $planingOrderMaterials->required_qty }}</td>
                                                <td width="200">{{ $planingOrderMaterials->available_qty }}

                                                </td>
                                                <td>{{ $planingOrderMaterials->rate }}</td>
                                                <td>{{ $planingOrderMaterials->total }}</td>
                                                <td>
                                                    <span class="ml-3 btn btn-outline-info btn-sm cursor-pointer"
                                                        onclick="requestPO({{ $planingOrderMaterials->item_id }},{{ $planingOrderMaterials->required_qty }} ,{{ $planingOrderMaterials->planing_order_id }});">
                                                        <i class="fa fa-forward mr-2"
                                                            title="Request PO With Item for Planing Order"></i> Request PO
                                                    </span>

                                                </td>
                                            </tr>
                                        @endif
                                        @php $num ++; @endphp
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">All Total</td>
                                    <td>{{ $totalRequiredQty }}</td>
                                    <td>{{ $totalAvailableQty }}</td>
                                    <td>{{ $totalRate }}</td>
                                    <td>{{ $total }}</td>
                                    <td></td> <!-- Adjust the colspan as needed -->
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @php
            $finalTotal = $totalValue + $total;

        @endphp
    @endsection


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {

            $('#datatable-list-process').DataTable({
                order: [
                    [0, 'desc']
                ]
            });
            var groupColumn = 1;
            $('#datatable-list-bom').DataTable({
                drawCallback: function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(groupColumn, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {

                            last = group;
                            var totalAmount = 0;
                            var groupRows = api.rows({
                                page: 'current'
                            }).nodes().toArray().filter(function(row) {
                                return api.cell(row, groupColumn).data() === group;
                            });

                            groupRows.forEach(function(row) {
                                var rowData = api.row(row).data();
                                totalAmount += parseFloat(rowData[
                                9]); // Replace 2 with the correct column index
                            });
                            $(rows).eq(i).before(
                                '<tr class="total"><td colspan="22" align="right" class="text-bold font-size-large text-black"></td></tr>'
                            );
                            $(rows).eq(i).before(
                                '<tr class="group"><td colspan="2" align="left" class="text-bold font-size-large text-black"># ' +
                                group +
                                '</td><td colspan="20" align="right" class="text-bold font-size-large text-black">Total Amount: ' +
                                totalAmount.toFixed(2) + '</td></tr>'
                            );

                        }
                    });
                }
            });

        });

        window.onload = function() {
            getStyleDetails();
        };


        function getStyleDetails() {
            var StyleNo = document.getElementById('StyleNo').value;
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '{{ route('getPlanningStyleDetails') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    StyleId: StyleNo,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(result) {
                    $('#showStyleDetails').html(result.showStyleDetails);
                    $('#processQty0').val(result.qty);
                    $('#rawOrderQty0').val(result.qty);

                    var finalTotal = '{{ $finalTotal }}';
                    $("#finalTotal").html(finalTotal);
                    var perPcCost = parseFloat(finalTotal) / parseFloat(result.qty);
                    $("#perPcCost").html(perPcCost);
                }
            });
        }

        function requestPO(item_id, qty, order_planing_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Process!',
                reverseButtons: true,
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-danger ml-1',
                buttonsStyling: true
            }).then(function(result) {
                if (result.value) {
                    $('#overlay').fadeIn(100);
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('requestPO') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            item_id: item_id,
                            qty: qty,
                            order_planing_id: order_planing_id,
                            '_token': "{{ csrf_token() }}"
                        },
                        success: function(resultData) {
                            Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                                location.reload();
                                $('#overlay').fadeOut(100);
                            });
                        }
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire(
                        'Cancelled',
                        'Your request has been Cancelled !!',
                        'error'
                    );
                }
            });
        }
    </script>
