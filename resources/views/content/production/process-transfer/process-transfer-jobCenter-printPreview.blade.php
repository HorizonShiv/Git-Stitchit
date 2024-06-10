@extends('layouts.layoutMaster')

@section('title', 'Preview - Process Transfer Job Center')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('page-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />
@endsection

@section('content')
  <div class="card">

    <div class="row">
      <div class="col-md-12 p-3 float-right">
        <button class="btn btn-label-primary">
          Download
        </button>
        <a class="btn btn-label-primary" target="_blank" href="{{route('process-transfer-print')}}">
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
          <div
            class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
            <div class="mb-xl-0 mb-4">
              <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                @include('_partials.macros', ['height' => 20, 'withbg' => ''])
                <span class="app-brand-text fw-bold fs-4">
                  Job Center
                </span>
              </div>
              <p class="mb-2">ff-1, silver point complex, near sbi bank
                Narol, Ahmedabad</p>
              <p class="mb-2">ahmedabad, Gujarat - 382405</p>
              <p class="mb-1">city,state- 12345</p>
              <p class="mb-1">1234567890</p>
              <p class="mb-0">abc@gmail.com</p>
              <p class="mb-0">GSTIN : 24AAXFR1338K1ZQ</p>
            </div>
            <div>
              <h4 class="fw-medium mb-2">Service Order No: #ZCPLPO/28</h4>
              <div class="mb-2 pt-1">
                <span>Po Date:</span>
                <span class="fw-medium">24-May-2024</span>
                </br>
                </br>
                Delivery Terms And Condition : <p><b>45 DAYS</b></p>
              </div>
            </div>
          </div>
        </div>
        <hr class="my-0" />

        <div class="card-body">
          <div class="row p-sm-3 p-0">
            <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
              <h6 class="mb-3">Bill To:</h6>
              <p class="mb-1">ZEDEX CLOTHING PRIVATE LIMITED</p>
              <p class="mb-1">132/2 Balaji Estate, Near Gautam Furniture Lane, , Isanpur-Narol Highway, Isanpur,</p>
              <p class="mb-1">Ahmedabad , Gujarat - 382443
              </p>
              <p class="mb-1">Phone : 8488879888</p>
              <p class="mb-0">E-Mail : accounts@zedexclothing.com </p>
              <p class="mb-0">GSTIN : GSTIN : 24AAACZ2046E1ZP</p>
            </div>

            {{--            @if ($po->UserAddress)--}}
            <div class="col-xl-6 col-md-12 col-sm-7 col-12">
              <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                <h6 class="mb-3">Ship To:</h6>
                <p class="mb-1">ZEDEX CLOTHING PRIVATE LIMITED UNIT-II</p>
                <p class="mb-1">
                  ZEDEX CLOTHING PRIVATE LIMITED UNIT-II
                </p>
                <p class="mb-1">
                  Survey No. 360, Beside IOCL Pump, Near Sindhrej Patia, , Village Ranoda,
                  Dholka , Gujarat - 382225
                </p>
                <p class="mb-1">T : 8488879888</p>
                <p class="mb-0">E-Mail : accounts@zedexclothing.com</p>
                <p class="mb-0">GSTIN : 24AAACZ2046E1ZP</p>
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
              <th>Rate</th>
              <th>CGST</th>
              <th>SGST</th>
              <th>Taxable Value</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>1</td>
              <td class="text-nowrap">BB WOVEN BELT LBL</td>
              <td class="text-nowrap"></td>
              <td></td>
              <td></td>
              <td></td>
              <td>55.50</td>
              <td>2.68</td>
              <th>8.925</th>
              <th>8.925</th>
              <td>166.59</td>

            </tr>
            <tr>
              <td class="align-top px-4 py-4" colspan="8">
              </td>
              <td class="text-end pe-3 py-4" colspan="2">
                <p class="mb-2 pt-3">Subtotal:</p>
                <p class="mb-2">IGST Amount:</p>
                <p class="mb-2">CGST Amount:</p>
                <p class="mb-2">SGST Amount:</p>
                <p class="mb-0 pb-3">Total:</p>
              </td>
              <td class="ps-2 py-4">
                <p class="fw-medium mb-2 pt-3">148.74</p>
                <p class="fw-medium mb-2">0</p>
                <p class="fw-medium mb-2">8.93</p>
                <p class="fw-medium mb-2">8.93</p>
                <p class="fw-medium mb-0 pb-3">166.59</p>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

        <div class="card-body mx-3">
          <div class="row">
            <div class="col-12">
              <div style="text-align: end"><b>E. &amp; O.E</b></div>
              Amount Chargeable (in
              words)<br><b> One Hundred and Sixty Six Rupees .Five Nine Paise Only</b>
              <br>
              <br>
              <b><u>Declaration</u></b><br><b>
                1. We declare that this Purchase Order shows the actual price of
                the goods described and that all particulars are true and
                correct.<br>
                2. All Disputes are subject to Ahmedabad
                jurisdiction only.</b><br><br>
              <div style="text-align: end"><b>For ZEDEX CLOTHING PRIVATE LIMITED</b><br><br><br><b>Authorised
                  Signatory</b></div>
              <span class="fw-medium">Note:</span>
              <span></span>
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
  @include('_partials._offcanvas.offcanvas-send-invoice')
  @include('_partials._offcanvas.offcanvas-add-payment')
  <!-- /Offcanvas -->
@endsection
