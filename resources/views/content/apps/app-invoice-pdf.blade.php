<div class="invoice-print p-2">

  <div class="d-flex justify-content-between flex-row">
    <div class="mb-4">
      <div class="d-flex svg-illustration mb-3 gap-2">
        @include('_partials.macros',["height"=>20,"withbg"=>''])
        <span class="app-brand-text fw-bold">
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
      <h4 class="fw-medium">INVOICE #{{ $invoice->invoice_no }}</h4>
      <div class="mb-2">
        <span class="text-muted">Date:</span>
        <span class="fw-medium">{{ date("D, d M Y", strtotime($invoice->invoice_date)) }}</span>
      </div>
      {{--      <div>--}}
      {{--        <span class="text-muted">Date Due:</span>--}}
      {{--        <span class="fw-medium">May 25, 2021</span>--}}
      {{--      </div>--}}
    </div>
  </div>

  <hr/>

  <div class="row d-flex justify-content-between mb-4">
    <div class="col-sm-6 w-50">
      <h6>Bill To:</h6>
      <p class="mb-1">{{ $invoice->Company->b_name }}</p>
      <p class="mb-1">{{ $invoice->Company->b_address1.' , '.$invoice->Company->b_address2 }}</p>
      <p class="mb-1">{{ $invoice->Company->b_city.' , '.$invoice->Company->b_state }}</p>
      <p class="mb-1">{{ $invoice->Company->s_mobile }}</p>
      <p class="mb-0">{{ $invoice->Company->s_email }}</p>
    </div>
    <div class="col-sm-6 w-50">
      <h6>Ship To:</h6>
      <p class="mb-1">{{ $invoice->Company->s_name }}</p>
      <p class="mb-1">{{ $invoice->Company->s_address1.' , '.$invoice->Company->s_address2 }}</p>
      <p class="mb-1">{{ $invoice->Company->s_city.' , '.$invoice->Company->s_state }}</p>
      <p class="mb-1">{{ $invoice->Company->s_mobile }}</p>
      <p class="mb-0">{{ $invoice->Company->s_email }}</p>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table m-0">
      <thead class="table-light">
      <tr>
        <th>Item</th>
        <th>Description</th>
        <th>HSN</th>
        <th>UOM</th>
        <th>Cost</th>
        <th>Qty</th>
        <th>Tax</th>
        <th>Discount</th>
        <th>Price</th>
      </tr>
      </thead>
      <tbody>
      @foreach($invoice->InvoiceItem as $item)
        <tr>
          <td class="text-nowrap"><?= wordwrap($item->item_name, 20, '<br />', true) ?></td>
          <td class="text-nowrap"><?= wordwrap($item->item_description, 20, '<br />', true) ?></td>
          <td>{{ $item->hsn }}</td>
          <td>{{ $item->uom }}</td>
          <td>{{ $item->rate }}</td>
          <td>{{ $item->qty }}</td>
          <td>{{ $item->tax }}</td>
          <td>{{ $item->discount }}</td>
          <td>{{ $item->amount }}</td>
        </tr>
      @endforeach
      <tr>
        <td class="align-top px-4 py-4" colspan="7">
          @if(!empty($invoice->invoice_file))
            <p align="right text-bold">Download Invoice File here</p>
            <p class="text-nowrap" colspan="6"><p>
              <a href="{{ url('invoice/'.$invoice->id.'/'.$invoice->invoice_file) }}">Download
                File</a>
            </p>
            </p>
          @endif
        </td>
        <td class="text-end pe-3 py-4">
          <p class="mb-2 pt-3">Subtotal:</p>
          <p class="mb-2">Discount:</p>
          <p class="mb-2">IGST Amt:</p>
          <p class="mb-2">CGST Amt:</p>
          <p class="mb-2">SGST Amt:</p>
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

  <div class="row">
    <div class="col-12">
      <span class="fw-medium">Note:</span>
      <span>{{ $invoice->note }}</span>
    </div>
  </div>
</div>
