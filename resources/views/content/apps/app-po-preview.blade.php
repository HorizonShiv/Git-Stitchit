@extends('layouts/layoutMaster')

@section('title', 'Preview - PO')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/offcanvas-add-payment.js') }}"></script>
    <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
@endsection

@section('content')
    <div class="card">

        <div class="row">
            <div class="col-md-12 p-3 float-right">
                <button class="btn btn-label-primary">
                    Download
                </button>
                <a class="btn btn-label-primary" target="_blank" href="{{ route('app-po-print', $po->id) }}">
                    Print
                </a>
            </div>
        </div>
    </div>
    <div class="row invoice-preview">
        <!-- Invoice -->
        <div class="col-xl-12 col-md-8 col-12 mb-md-0 mb-4">
            <div class="card invoice-preview-card">

                <div class="card-body">
                    <div class="row p-sm-3 p-0">
                        <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                            <h6 class="mb-3">Bill To:</h6>
                            <p class="mb-1">{{ $po->Company->b_name }}</p>
                            <p class="mb-1">{{ $po->Company->b_address1 . ' , ' . $po->Company->b_address2 }}</p>
                            <p class="mb-1">
                                {{ $po->Company->b_city . ' , ' . $po->Company->b_state . ' - ' . $po->Company->b_pincode }}
                            </p>
                            <p class="mb-1">T : {{ $po->Company->s_mobile }}</p>
                            <p class="mb-0">E-Mail : {{ $po->Company->s_email }}</p>
                            <p class="mb-0">GSTIN : {{ $po->Company->pancard_gst_no }}</p>
                        </div>

                        @if ($po->UserAddress)
                            <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                                <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                                    <h6 class="mb-3">Ship To:</h6>
                                    <p class="mb-1">{{ $po->UserAddress->User->company_name }}</p>
                                    <p class="mb-1">
                                        {{ $po->UserAddress->b_address1 . ' , ' . $po->UserAddress->s_address2 }}
                                    </p>
                                    <p class="mb-1">
                                        {{ $po->UserAddress->b_city . ' , ' . $po->UserAddress->b_state . ' - ' . $po->UserAddress->b_pincode }}
                                    </p>
                                    <p class="mb-1">T : {{ $po->UserAddress->User->person_mobile }}</p>
                                    <p class="mb-0">E-Mail : {{ $po->UserAddress->User->email }}</p>
                                    <p class="mb-0">GSTIN : {{ $po->UserAddress->User->gst_no }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($po->CompanyShipAddress)
                            <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                                <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                                    <h6 class="mb-3">Ship To:</h6>
                                    <p class="mb-1">{{ $po->CompanyShipAddress->company_name }}</p>
                                    <p class="mb-1">
                                        {{ $po->CompanyShipAddress->address1 . ' , ' . $po->CompanyShipAddress->address2 }}
                                    </p>
                                    <p class="mb-1">
                                        {{ $po->CompanyShipAddress->city . ' , ' . $po->CompanyShipAddress->state . ' - ' . $po->CompanyShipAddress->pincode }}
                                    </p>
                                    <p class="mb-1">T : {{ $po->CompanyShipAddress->mobile }}</p>
                                    <p class="mb-0">E-Mail : {{ $po->CompanyShipAddress->email }}</p>
                                    <p class="mb-0">GSTIN : {{ $po->CompanyShipAddress->gst_number }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <hr class="my-0" />

                <div class="card-body">
                    <div
                        class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
                        <div class="mb-xl-0 mb-4">
                            <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                                @include('_partials.macros', ['height' => 20, 'withbg' => ''])
                                <span class="app-brand-text fw-bold fs-4">
                                    {{ $po->User->company_name }}
                                </span>
                            </div>
                            <p class="mb-2">{{ $po->User->UserAddressView->b_address1 ?? '' }}</p>
                            <p class="mb-2">{{ $po->User->UserAddressView->b_address2 ?? '' }}</p>
                            <p class="mb-1">{{ $po->User->UserAddressView->b_city ?? '' }},
                                {{ $po->User->UserAddressView->b_state ?? '' }}
                                - {{ $po->User->UserAddressView->b_pincode ?? '' }}</p>
                            <p class="mb-1">{{ $po->User->person_mobile ?? '' }}</p>
                            <p class="mb-0">{{ $po->User->email ?? '' }}</p>
                            <p class="mb-0">GSTIN : {{ $po->User->gst_no ?? '' }}</p>
                        </div>
                        <div>
                            <h4 class="fw-medium mb-2">Purchase Code : #{{ $po->po_no }}</h4>
                            <div class="mb-2 pt-1">
                                <span>Po Date:</span>
                                <span class="fw-medium">{{ date('D, d M Y', strtotime($po->po_date)) }}</span>
                                </br>
                                </br>
                                Delivery Terms And Condition : <p><b>45 DAYS</b></p>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="table-responsive border-top">
                    <table class="table m-0">

                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Item</th>
                                <th>Description</th>
                                <th>UOM</th>
                                <th>HSN</th>
                                <th>Excess I/W Allow %</th>
                                <th>Qty</th>
                                <th>GRN Qty</th>
                                <th>Rate</th>
                                @if ($po->igst_amount > 0)
                                    <th colspan="2">IGST</th>
                                @else
                                    <th>CGST</th>
                                    <th>SGST</th>
                                @endif
                                <th>Taxable Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $num =1; @endphp
                            @foreach ($po->PoItem as $item)
                                @php
                                    $grnQty = 0;
                                    if (isset($item->GrnItem)) {
                                        $grnQty = array_sum(array_column($item->GrnItem->toArray(), 'qty'));
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $num }}</td>
                                    <td class="text-nowrap"><?= wordwrap($item->item_name, 10, '<br />', true) ?></td>
                                    <td class="text-nowrap"><?= wordwrap($item->item_description, 10, '<br />', true) ?>
                                    </td>
                                    <td>{{ $item->uom }}</td>
                                    <td>{{ $item->hsn }}</td>
                                    <td>{{ $item->excessInwardAllowedPercent }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $grnQty }}</td>
                                    <td>{{ $item->rate }}</td>
                                    @if ($po->igst_amount > 0)
                                        <th colspan="2">{{ $item->tax }}</th>
                                    @else
                                        <th>{{ $item->tax / 2 }}</th>
                                        <th>{{ $item->tax / 2 }}</th>
                                    @endif
                                    <td>{{ $item->amount }}</td>

                                </tr>
                                @php $num++; @endphp
                            @endforeach
                            <tr>
                                <td class="align-top px-4 py-4" colspan="8">
                                    @if (!empty($po->po_file))
                                        <p align="right text-bold">Download PO File here</p>
                                        <p class="text-nowrap" colspan="9">
                                        <p>
                                            <a target="_blank"
                                                href="{{ url('po/' . $po->id . '/' . $po->po_file) }}">Download
                                                File</a>
                                        </p>
                                        </p>
                                    @endif
                                </td>
                                <td class="text-end pe-3 py-4" colspan="2">
                                    <p class="mb-2 pt-3">Subtotal:</p>
                                    <p class="mb-2">IGST Amount:</p>
                                    <p class="mb-2">CGST Amount:</p>
                                    <p class="mb-2">SGST Amount:</p>
                                    <p class="mb-0 pb-3">Total:</p>
                                </td>
                                <td class="ps-2 py-4">
                                    <p class="fw-medium mb-2 pt-3">{{ $po->sub_total_amount ?? 0 }}</p>
                                    <p class="fw-medium mb-2">{{ $po->igst_amount ?? 0 }}</p>
                                    <p class="fw-medium mb-2">{{ $po->cgst_amount ?? 0 }}</p>
                                    <p class="fw-medium mb-2">{{ $po->sgst_amount ?? 0 }}</p>
                                    <p class="fw-medium mb-0 pb-3">{{ $po->po_amount ?? 0 }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-body mx-3">
                    <div class="row">
                        <div class="col-12">
                            <div style="text-align: end"><b>E. & O.E</b></div>
                            Amount Chargeable (in
                            words)<br><b> <?= \App\Http\Controllers\Controller::getIndianCurrency($po->po_amount) ?>
                                Only</b>
                            <br>
                            </br>
                            <b><u>Declaration</u></b><br><b>
                                1. We declare that this Purchase Order shows the actual price of
                                the goods described and that all particulars are true and
                                correct.<br>
                                2. All Disputes are subject to {{ $po->Company->b_city }}
                                jurisdiction only.</b></br></br>
                            <div style="text-align: end"><b>For <?= $po->Company->b_name ?></b><br><br><br><b>Authorised
                                    Signatory</b></div>
                            <span class="fw-medium">Note:</span>
                            <span>{{ $po->note }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Invoice -->

        <!-- Invoice Actions -->
        {{--    <div class="col-xl-3 col-md-4 col-12 invoice-actions"> --}}
        {{--      <div class="card"> --}}
        {{--        <div class="card-body"> --}}
        {{--          <button class="btn btn-primary d-grid w-100 mb-2" data-bs-toggle="offcanvas" --}}
        {{--                  data-bs-target="#sendInvoiceOffcanvas"> --}}
        {{--            <span class="d-flex align-items-center justify-content-center text-nowrap"><i --}}
        {{--                class="ti ti-send ti-xs me-2"></i>Send Invoice</span> --}}
        {{--          </button> --}}
        {{--          <button class="btn btn-label-secondary d-grid w-100 mb-2"> --}}
        {{--            Download --}}
        {{--          </button> --}}
        {{--          <a class="btn btn-label-secondary d-grid w-100 mb-2" target="_blank" --}}
        {{--             href="{{ route('app-po-print',$po->id) }}"> --}}
        {{--            Print --}}
        {{--          </a> --}}
        {{--        </div> --}}
        {{--      </div> --}}
        {{--    </div> --}}
        <!-- /Invoice Actions -->
    </div>

    <!-- Offcanvas -->
    @include('_partials/_offcanvas/offcanvas-send-invoice')
    @include('_partials/_offcanvas/offcanvas-add-payment')
    <!-- /Offcanvas -->
@endsection
