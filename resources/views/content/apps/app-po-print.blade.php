@extends('layouts/layoutMaster')

@section('title', 'PO (Print version) - Pages')

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice-print.css') }}" />
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/app-invoice-print.js') }}"></script>
@endsection
<style>
    @media print {
        body {
            visibility: hidden;
        }

        #invoice-print {
            visibility: visible;
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>

@section('content')
    @if (isset($po))
        <div class="invoice-print p-5" id="invoice-print">
            <div class="d-flex justify-content-between flex-row">
                <div class="mb-4">
                    <div class="d-flex svg-illustration mb-3 gap-2">
                        @include('_partials.macros', ['height' => 20, 'withbg' => ''])
                        <span class="app-brand-text fw-bold">
                            {{ $po->User->company_name ?? '' }}
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
                    <h4 class="fw-medium mb-2">Purchase Code : #{{ $po->po_no ?? '' }}</h4>
                    <div class="mb-2 pt-1">
                        <span>Po Date:</span>
                        <span class="fw-medium">{{ date('D, d M Y', strtotime($po->po_date ?? '')) }}</span>
                        </br>
                        </br>
                        Delivery Terms And Condition : <p><b>45 DAYS</b></p>
                    </div>
                </div>
            </div>
            <hr />
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
                    <div class="col-xl-6 col-md-12 col-sm-7 col-12">
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
                            <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                                <h6 class="mb-3">Ship To:</h6>
                                <p class="mb-1">{{ $po->CompanyShipAddress->company_name }}</p>
                                <p class="mb-1">
                                    {{ $po->CompanyShipAddress->address1 . ' , ' . $po->CompanyShipAddress->address2 }}</p>
                                <p class="mb-1">
                                    {{ $po->CompanyShipAddress->city . ' , ' . $po->CompanyShipAddress->state . ' - ' . $po->CompanyShipAddress->pincode }}
                                </p>
                                <p class="mb-1">T : {{ $po->CompanyShipAddress->mobile }}</p>
                                <p class="mb-0">E-Mail : {{ $po->CompanyShipAddress->email }}</p>
                                <p class="mb-0">GSTIN : {{ $po->CompanyShipAddress->gst_number }}</p>
                            </div>
                        @endif
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
                            <tr>
                                <td>{{ $num }}</td>
                                <td class="text-nowrap"><?= wordwrap($item->item_name, 20, '<br />', true) ?></td>
                                <td class="text-nowrap"><?= wordwrap($item->item_description, 20, '<br />', true) ?></td>
                                <td>{{ $item->uom }}</td>
                                <td>{{ $item->hsn }}</td>
                                <td>{{ $item->excessInwardAllowedPercent }}</td>
                                <td>{{ $item->qty }}</td>
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
                                        <a href="{{ url('invoice/' . $po->id . '/' . $po->po_file) }}">Download
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
                        words)<br><b> <?= \App\Http\Controllers\Controller::getIndianCurrency($po->po_amount) ?> Only</b>
                        <br><br>Tax is payable on reverse charge basis: No
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
                        <br>
                        <p>*This is a Computer Generated Purchase Order</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
