@extends('layouts/layoutMaster')

@section('title', 'Panding List')

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
        <span class="text-muted fw-light">Pending /</span> List
    </h4>

    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table" id="datatable-list">
                <thead>
                    <tr>
                        <th>SR No.</th>
                        <th>OP Date</th>
                        <th>Order Planing No</th>
                        <th>Customer Name</th>
                        <th>Customer Styles</th>
                        <th>Styles</th>
                        <th>Pending Qty</th>
                        <th>ShipDate</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php

                    @endphp
                    @php $num = 1 @endphp
                    @foreach ($PlaningOrders as $PlaningOrder)
                        @php
                            $styleShipDate = '';
                        @endphp
                        @foreach ($PlaningOrder->SalesOrderStyleInfo as $SalesOrderStyle)
                            @php
                                $styleShipDate = $SalesOrderStyle->ship_date . '<br>';
                            @endphp
                        @endforeach
                        <tr>
                            <td class="text-bold"><a href="">{{ $num }}</a></td>
                            <td>{{ $PlaningOrder->date }}</td>
                            <td>{{ $PlaningOrder->planing_order_no }}</td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar-wrapper">
                                        <div class="avatar me-2"><span
                                                class="avatar-initial rounded-circle bg-label-info">{{ substr($PlaningOrder->SalesOrders->Customer[0]->company_name ?? '-', 0, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column"><span
                                            class="fw-medium">{{ $PlaningOrder->SalesOrders->Customer[0]->company_name ?? '' }}</span><small
                                            class="text-truncate text-muted">{{ $PlaningOrder->SalesOrders->Customer[0]->buyer_name ?? '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>

                                @foreach ($PlaningOrder->SalesOrderStyleInfo as $SalesOrderStyle)
                                    {{ $SalesOrderStyle->customer_style_no }}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($PlaningOrder->SalesOrderStyleInfo as $SalesOrderStyle)
                                    {{ $SalesOrderStyle->StyleMaster->style_no }} -
                                    {{ $SalesOrderStyle->StyleMaster->StyleCategory->name }}<br>
                                @endforeach
                            </td>
                            <td>
                                @php
                                    $JobOrderQty = 0;
                                    $CalculatedQty = 0;
                                    $JobOrderQty = $PlaningOrder->JobOrders->sum('qty');
                                    $CalculatedQty = $PlaningOrder->qty - $JobOrderQty;
                                @endphp
                                {{ $CalculatedQty }}
                            </td>
                            <td><?php echo $styleShipDate; ?></td>
                            <td>
                                @if ($CalculatedQty > 0)
								 	<a href="{{ route('order-job-card.create', ['planing_order_id' => $PlaningOrder->id]) }}"
                                        type="button" class="btn btn-outline-success waves-effect">
                                        <span class="ti-xs ti ti-note me-1"></span>Create
                                    </a>
                                @else
                                    @php
                                        \App\Models\PlaningOrders::where('id', $PlaningOrder->id)->update([
                                            'status' => 'done',
                                        ]);
                                    @endphp
                                @endif

                            </td>
                        </tr>
                        @php $num++ @endphp
                    @endforeach
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
        $('#datatable-list').DataTable({
            order: [
                [0, 'desc']
            ],
        });
    });
</script>
