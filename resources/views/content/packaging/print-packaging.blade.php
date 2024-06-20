@extends('layouts.layoutMaster')

@section('title', 'Job Card Report')
@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice-print.css') }}" />
@endsection
@section('page-script')
    <script src="{{ asset('assets/js/app-invoice-print.js') }}"></script>
@endsection
@section('vendor-style')
    <style>
        .dark {
            font-weight: bold;
            background-color: rgba(75, 70, 98, 0.04) !important;
        }

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

            .container {
                page-break-before: always;
            }

            .container:first-of-type {
                page-break-before: auto;
            }
        }
    </style>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left"></span>Job Card Report
    </h4>
    <div class="row invoice-add" id="invoice-print">
        <!-- Invoice Add-->
        <div class="col-lg-12 col-12 mb-lg-0 mb-4">
            <div class="card invoice-preview-card">

                <div class="card-body">
                    <div class="users-list-filter">
                        <div class="users-list-filter">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Ship to:</p>
                                    <p class="mt-4">XYZ CLOTHING</p>
                                    <p>132 Balaji Estate, Near Gautam Furniture Lane, , Isanpur-Narol Highway, Isanpur,

                                        Ahmedabad , Gujarat - 382443</p>
                                    <p>T: <span id="itemName"></span> 8488879888</p>
                                    <p>E-Mail: <span id="colorType"></span><b>abc@gmail.com</b></p>
                                </div>
                                <div class="col-md-6 text-start">
                                    <p>Bill to:</p>
                                    <p class="mt-4">XYZ CLOTHING</p>
                                    <p>132 Balaji Estate, Near Gautam Furniture Lane, , Isanpur-Narol Highway, Isanpur,

                                        Ahmedabad , Gujarat - 382443</p>
                                    <p>T: <span id="itemName"></span> 8488879888</p>
                                    <p>E-Mail: <span id="colorType"></span><b>xyz@gmail.com</b></p>
                                </div>
                            </div>
                        </div>


                        <hr class="mb-4" />

                        <div class="mb-xl-0 mb-4">
                            <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                                <svg width="32" height="20" viewBox="0 0 32 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                                        fill="#7367F0"></path>
                                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                        d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                                        fill="#161616">
                                    </path>
                                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                                        fill="#161616">
                                    </path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                                        fill="#7367F0"></path>
                                </svg>
                                <span class="app-brand-text fw-bold fs-4">
                                    ENCOT FABRICS PVT LTD
                                </span>
                            </div>
                            <p class="mb-2">The Ruby, 5th Floor, SE,29, Senapati Bapat Marg,</p>
                            <p class="mb-2">Tulsi Pipe Line Road, Dadar (W),</p>
                            <p class="mb-1">Mumbai,
                                Maharashtra
                                - 400028</p>
                            <p class="mb-1">9320049449</p>
                            <p class="mb-0">info@encoat.in</p>
                            <p class="mb-4">GSTIN : 27AABCE5717C1ZZ</p>
                        </div>


                        <div class="table-responsive border-top">
                            <table class="table m-0">

                                <thead class="text-center">
                                    <tr>
                                        <th><b>No.</b></th>
                                        <th><b>No. of Carton</b></th>
                                        <th><b>Quantity</b></th>
                                        <th><b>Rate</b></th>
                                        <th><b>IGST</b></th>
                                        <th><b>Taxable Amount</b></th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td>1</td>
                                        <td>32</td>
                                        <td>500</td>
                                        <td>70000</td>
                                        <td>40</td>
                                        <td class="totalQty">192</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>40</td>
                                        <td>1000</td>
                                        <td>140000</td>
                                        <td>40</td>
                                        <td class="totalQty">187</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>32</td>
                                        <td>500</td>
                                        <td>70000</td>
                                        <td>40</td>
                                        <td class="totalQty">192</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top px-4 py-4" colspan="4">
                                        <td class="text-end pe-3 py-4">
                                            <p class="mb-2 pt-3">Subtotal:</p>
                                            <p class="mb-2">IGST Amount:</p>
                                            <p class="mb-2">CGST Amount:</p>
                                            <p class="mb-2">SGST Amount:</p>
                                            <p class="mb-0 pb-3">Total:</p>
                                        </td>
                                        <td class="ps-2 py-4 text-start">
                                            <p class="fw-medium mb-2 pt-3">140175</p>
                                            <p class="fw-medium mb-2">7008.75</p>
                                            <p class="fw-medium mb-2">0</p>
                                            <p class="fw-medium mb-2">0</p>
                                            <p class="fw-medium mb-0 pb-3">147183.75</p>
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
                                    words)<br><b>
                                        Only</b>
                                    <br>
                                    </br>
                                    <b><u>Declaration</u></b><br><b>
                                        1. We declare that this Purchase Order shows the actual price of
                                        the goods described and that all particulars are true and
                                        correct.<br>
                                        2. All Disputes are subject to
                                        jurisdiction only.</b></br></br>
                                    <div style="text-align: end"><b>For</b><br><br><br><b>Authorised
                                            Signatory</b></div>
                                    <span class="fw-medium">Note:</span>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Invoice Add-->
    </div>


    <!-- Offcanvas -->
    @include('_partials._offcanvas.offcanvas-send-invoice')
    <!-- /Offcanvas -->
@endsection
