@extends('layouts/layoutMaster')

@section('title', 'PO Invoice List')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/toastr/toastr.css')}}"/>
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/toastr/toastr.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>

@endsection

@section('page-script')
  <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
  <script src="{{asset('assets/js/app-invoice-list.js')}}"></script>
@endsection

@section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light float-left">PO / Invoice</span> List
  </h4>
  <!-- Invoice List Widget -->
  <form method="post" action="{{ route('grnInvoiceView') }}">
    @csrf
    <div class="card">
      <div class="card-datatable table-responsive pt-0">
        <div class="row mt-3 float-right col-12" id="show_data" style="display: none">
          <div class="col-4">
          </div>
          <div class="col-1">
            <div class="float-right">
              <div class="btn btn-primary text-bold checkBoxCount"></div>
            </div>
          </div>
          <div class="col-2">
            <button type="submit" class="btn btn-primary">Generate</button>
            <input type="hidden" id="samePo">
          </div>
        </div>
        <table class="datatables-basic table" id="datatable-list">
          <thead>
          <tr>
            <th>CB</th>
            <th>Vendor</th>
            <th>PO No</th>
            <th>GRN Date</th>
            <th>Item</th>
            <th>PO Qty</th>
            <th>GRN Qty</th>
            <th>Remaining Invoice Qty</th>
            <th>Remark</th>
          </tr>
          </thead>
          <tbody>
          @php $num = 1 @endphp
          @foreach($poItems as $poItem)
            @if(isset($poItem->Po) && !empty($poItem->Po))
              @php
                $grnQty = 0;
                if(isset($poItem->GrnItem)){
                   $grnQty = array_sum(array_column(($poItem->GrnItem)->toArray(),'qty'));
                }

                $invoiceQty = 0;
                if(isset($poItem->InvoiceItem)){
                   $invoiceQty = array_sum(array_column(($poItem->InvoiceItem)->toArray(),'qty'));
                }
              @endphp
              @php
                $remainingInvoiceQty = ($grnQty-$invoiceQty);
               if($remainingInvoiceQty <= 0){
                   $checkBoxShow = "<b>?</b>";
               }else{
                 $checkBoxShow = '<input type="checkbox" onclick="showSubmitButton('.$poItem->id.')" class="cursor-pointer largerCheckbox checkBoxList" name="ids[]" value="' . $poItem->id . '" id="OUTWD' . $poItem->id . '" data-partyName = "' . ($poItem->Po->User->company_name ?? '') . '">';
               }
              @endphp
              <tr>
                <td class="text-bold"><?= $checkBoxShow ?></td>
                <td>
                  <div class="d-flex justify-content-start align-items-center">
                    <div class="avatar-wrapper">
                      <div class="avatar me-2"><span
                          class="avatar-initial rounded-circle bg-label-info">{{ substr($poItem->Po->User->company_name, 0, 2) }}</span>
                      </div>
                    </div>
                    <div class="d-flex flex-column"><span
                        class="fw-medium">{{ $poItem->Po->User->company_name }}</span><small
                        class="text-truncate text-muted">{{ $poItem->Po->User->person_name }}</small>
                      <small
                        class="text-truncate text-muted">{{ $poItem->Po->User->person_mobile }}</small>
                    </div>
                  </div>
                </td>
                <td class="text-bold"><a
                    href="{{ route('app-po-preview',$poItem->po_id) }}"> {{ $poItem->Po->po_no ?? '' }}</a></td>
                <td>{{ date("D, d M Y", strtotime($poItem->Po->po_date ?? "" )) }}</td>
                <td>{{ $poItem->item_name }}</td>
                <td>{{ $poItem->qty }}</td>
                <td>{{ $grnQty }}</td>
                <td>{{ $remainingInvoiceQty }}</td>
                <td>{{ $poItem->remark }}</td>
              </tr>
              @php $num++ @endphp
            @endif
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </form>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>

  $("#select_all").click(function () {
    $('#show_data').show();
    $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    updateCounter();
  });

  function showSubmitButton(id) {
    $('#show_data').show();

    var len = $('input[name="ids[]"]:checked').length;
    if (len > 1) {
      var samePo = $('#samePo').val();
      let anotherPartyName = $("#OUTWD" + id + ":checked").attr('data-partyName');
      if (samePo === anotherPartyName || anotherPartyName === undefined) {
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        updateCounter();
      } else {
        $("#OUTWD" + id).prop('checked', false);
        toastr.error('The Vendor is different only the same Vendor is allowed.');
      }
    } else {
      firstPartyName = $("#OUTWD" + id + ":checked").attr('data-partyName');
      $('#samePo').val(firstPartyName);
      $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
      updateCounter();
    }
  }

  function updateCounter() {
    var len = $('input[name="ids[]"]:checked').length;
    if (len > 0) {
      $(".checkBoxCount").text(len);
    } else {
      $(".checkBoxCount").text(' ');
      $('#show_data').hide();
    }
  }

  $(document).ready(function () {
    $('#datatable-list').DataTable();
  });
</script>
