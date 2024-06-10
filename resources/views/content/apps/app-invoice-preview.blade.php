@extends('layouts/layoutMaster')

@section('title', 'Invoice Preview')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}"/>
@endsection

@section('page-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}"/>
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
                                    {{ $invoice->User->company_name }}
                                </span>
              </div>
              <p class="mb-2">{{ $invoice->User->UserAddress->b_address1 ?? '' }}</p>
              <p class="mb-2">{{ $invoice->User->UserAddress->b_address2 ?? '' }}</p>
              <p class="mb-1">{{ $invoice->User->UserAddress->b_city ?? '' }}
                , {{ $invoice->User->UserAddress->b_state ?? '' }}
                - {{ $invoice->User->UserAddress->b_pincode ?? '' }}</p>
              <p class="mb-1">{{ $invoice->User->person_mobile ?? '' }}</p>
              <p class="mb-0">{{ $invoice->User->email ?? '' }}</p>
              <p class="mb-0">GSTIN : {{ $invoice->User->gst_no ?? '' }}</p>
            </div>
            <div>
              <h4 class="fw-medium mb-2">INVOICE #{{ $invoice->invoice_no }}</h4>
              <h4 class="fw-medium mb-2">CHALLAN #{{ $invoice->challane_no }}</h4>
              <div class="mb-2 pt-1">
                <span>Date Issues:</span>
                <span class="fw-medium">{{ date('D, d M Y', strtotime($invoice->invoice_date)) }}</span>
              </div>
            </div>
          </div>
        </div>
        <hr class="my-0"/>
        <div class="card-body">
          <div class="row p-sm-3 p-0">
            <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
              <h6 class="mb-3">Invoice To:</h6>
              <p class="mb-1">{{ $invoice->Company->b_name }}</p>
              <p class="mb-1">{{ $invoice->Company->b_address1 . ' , ' . $invoice->Company->b_address2 }}
              </p>
              <p class="mb-1">{{ $invoice->Company->b_city . ' , ' . $invoice->Company->b_state }}</p>
              <p class="mb-1">{{ $invoice->Company->s_mobile }}</p>
              <p class="mb-0">{{ $invoice->Company->s_email }}</p>
            </div>
            <div class="col-xl-6 col-md-12 col-sm-7 col-12">
              <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                <h6 class="mb-3">Ship To:</h6>
                <p class="mb-1">{{ $invoice->Company->s_name }}</p>
                <p class="mb-1">
                  {{ $invoice->Company->s_address1 . ' , ' . $invoice->Company->s_address2 }}
                </p>
                <p class="mb-1">{{ $invoice->Company->s_city . ' , ' . $invoice->Company->s_state }}</p>
                <p class="mb-1">{{ $invoice->Company->s_mobile }}</p>
                <p class="mb-0">{{ $invoice->Company->s_email }}</p>
              </div>
            </div>
          </div>
        </div>


        <div class="table-responsive border-top">
          <table class="table m-0">

            <thead>
            <tr>
              <th>Item</th>
              <th>Description</th>
              <th>PONO</th>
              <th>HSN</th>
              <th>UOM</th>
              <th>Cost</th>
              <th>Qty</th>
              <th>GRN Qty</th>
              <th>Tax</th>
              <th>Discount</th>
              <th>Price</th>
            </tr>
            </thead>
            <tbody>
            @php

              @endphp

            @foreach ($invoice->InvoiceItem as $item)
              <?php
              // print_r($item->toArray());

              $invoiceWiseGrnQty = 0;

              if (isset($item->PoItem->id) && !empty($item->PoItem->id)) {
                $grnItems = App\Models\GrnItem::where('invoiceNumber', $invoice->invoice_no)
                  ->where('purchase_orders.user_id', $invoice->user_id)
                  ->where('grn_items.po_item_id', $item->PoItem->id)
                  ->select('grn_items.*')
                  ->leftJoin('purchase_order_items', 'purchase_order_items.id', '=', 'grn_items.po_item_id')
                  ->leftJoin('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_items.po_id')
                  ->get();

                if (isset($grnItems) && count($grnItems) > 0) {
                  foreach ($grnItems as $grnItem) {
                    $invoiceWiseGrnQty += $grnItem->qty;
                    // $temp=$grnItem->qty;
                  }
                }
              }
              ?>
              <tr>
                <td class="text-nowrap"><?= wordwrap($item->item_name, 20, '<br />', true) ?></td>
                <td class="text-nowrap"><?= wordwrap($item->item_description, 20, '<br />', true) ?>
                </td>
                <td>
                  @php $checkRate = ""; @endphp
                  @if (isset($item->PoItem->po_id))
                    <a
                      href="{{ route('app-po-preview', $item->PoItem->po_id) }}">{{ $item->PoItem->PO->po_no ?? '' }}</a>
                    <?php
                    $checkRate = $item->PoItem->rate != $item->rate ? '<span title="mismatch rate"><i class="ti ti-alert-triangle mb-4 bg-label-danger"></i></span>' : '';
                    ?>
                  @endif
                  @php

                    $checkQty = '';
                    $grnQty = 0;
                    if (isset($item->PoItem->GrnItem)) {
                        $grnQty = array_sum(
                            array_column($item->PoItem->GrnItem->toArray(), 'qty'),
                        );
                } @endphp



                  @if (isset($item->PoItem->po_id))
                    @if (isset($grnQty))
                      <?php

                      $checkQty = $invoiceWiseGrnQty != $item->qty ? '<span title="Mismatch Qty! Actual GRN Qty Is = ' . $invoiceWiseGrnQty . '"><i class="ti ti-alert-triangle mb-4 bg-label-danger"></i></span>' : '';
                      ?>
                    @endif
                  @endif
                </td>
                <td>{{ $item->hsn }}</td>
                <td>{{ $item->uom }}</td>
                <td>{{ $item->rate }} <?= $checkRate ?></td>
                <td>{{ $item->qty }} <?= $checkQty ?> </td>
                <td>{{ $invoiceWiseGrnQty }} </td>
                <td>{{ $item->tax ?? 0 }}<br/>({{ $item->tax_percentage ?? 0 }}%)</td>
                <td>{{ $item->discount }}</td>
                <td>{{ $item->amount }}</td>
              </tr>
            @endforeach
            <tr>
              <td class="align-top px-4 py-4" colspan="9">
                @if (!empty($invoice->invoice_file))
                  <p align="right text-bold">Download Invoice File here</p>
                  <p class="text-nowrap" colspan="6">
                  <p>
                    <a href="{{ url('invoice/' . $invoice->id . '/' . $invoice->invoice_file) }}">Download
                      File</a>
                  </p>
                  </p>
                @endif
              </td>
              <td class="text-end pe-3 py-4">
                <p class="mb-2 pt-3">Subtotal:</p>
                <p class="mb-2">Discount:</p>
                <p class="mb-2">IGST Amount:</p>
                <p class="mb-2">CGST Amount:</p>
                <p class="mb-2">SGST Amount:</p>
                <p class="mb-0 pb-3">Total:</p>
              </td>
              <td class="ps-2 py-4">
                <p class="fw-medium mb-2 pt-3">{{ $invoice->sub_total_amount ?? 0 }}</p>
                <p class="fw-medium mb-2">{{ $invoice->discount_amount ?? 0 }}</p>
                <p class="fw-medium mb-2">{{ $invoice->igst_amount ?? 0 }}</p>
                <p class="fw-medium mb-2">{{ $invoice->cgst_amount ?? 0 }}</p>
                <p class="fw-medium mb-2">{{ $invoice->sgst_amount ?? 0 }}</p>
                <p class="fw-medium mb-0 pb-3">{{ $invoice->invoice_amount ?? 0 }}</p>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

        <div class="card-body mx-3">
          <div class="row">
            <div class="col-12">
              <span class="fw-medium">Note:</span>
              <span>{{ $invoice->note }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-xl-3 col-md-4 col-12">
          <button class="btn btn-primary d-grid w-100 mb-2" data-bs-toggle="offcanvas"
                  data-bs-target="#sendInvoiceOffcanvas">
                        <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                            class="ti ti-send ti-xs me-2"></i>Send Invoice</span>
          </button>
        </div>
        <div class="col-xl-3 col-md-4 col-12">
          <a class="btn btn-label-secondary d-grid w-100 mb-2" target="_blank"
             href="{{ route('app-invoice-print', base64_encode($invoice->id)) }}">
            Print
          </a>
        </div>
      </div>
    </div>
    <!-- /Invoice -->
  </div>

  <!-- Offcanvas -->
  @include('_partials/_offcanvas/offcanvas-send-invoice')
  @include('_partials/_offcanvas/offcanvas-add-payment')
  <!-- /Offcanvas -->
@endsection
