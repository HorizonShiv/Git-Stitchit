@extends('layouts/layoutMaster')

@section('title', 'GRN Invoice List - Pages')

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
    <span class="text-muted fw-light float-left">GRN /</span> List
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
            <th>checkBox</th>
            <th>SR No.</th>
            <th>PO No</th>
            <th>GRN Date</th>
            <th>Item</th>
            <th>Good Qty</th>
            <th>Bad Qty</th>
            <th>Total Qty</th>
            <th>Remark</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          @php $num = 1 @endphp
          @foreach($grnItems as $grnItem)
            @php
              $checkBoxShow = '<input type="checkbox" onclick="showSubmitButton()" class="cursor-pointer largerCheckbox checkBoxList" name="ids[]" value="' . $grnItem->PoItem->id . '">';
            @endphp
            <tr>
              <td class="text-bold"><?= $checkBoxShow ?></td>
              <td class="text-bold">{{ $num }}</td>
              <td class="text-bold">{{ $grnItem->PoItem->Po->po_no }}</td>
              <td>{{ date("D, d M Y", strtotime($grnItem->date)) }}</td>
              <td>{{ $grnItem->PoItem->item_name }}</td>
              <td>{{ $grnItem->g_qty }}</td>
              <td>{{ $grnItem->b_qty }}</td>
              <td>{{ $grnItem->qty }}</td>
              <td>{{ $grnItem->remark }}</td>
              <td>
                <div class="d-flex align-items-center">
                  <a href="{{ route('app-po-preview',$grnItem->id) }}"><i
                      class="ti ti-eye mx-2 ti-sm"></i></a>
                  <div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0"
                                           data-bs-toggle="dropdown" aria-expanded="false"><i
                        class="ti ti-dots-vertical ti-sm"></i></a>
                    <div class="dropdown-menu dropdown-menu-end" style="">
                      <a href="app-invoice-edit.html" class="dropdown-item">Edit</a>
                      <a href="{{ route('app-po-print2',$grnItem->id) }}" class="dropdown-item">Print</a>
                      <div class="dropdown-divider"></div>
                      <a onclick="invoiceDelete({{ $grnItem->id }});"
                         class="dropdown-item delete-record text-danger">Delete</a>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            @php $num++ @endphp
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
        toastr.error('The PO is different only the same PO is allowed.');
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

  function vendorApprove(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You want to?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, Approve!',
      reverseButtons: true,
      cancelButtonColor: '#d33',
      confirmButtonClass: 'btn btn-primary',
      cancelButtonClass: 'btn btn-danger ml-1',
      buttonsStyling: true
    }).then(function (result) {
      if (result.value) {

        $.ajax({
          type: 'POST',
          url: '{{route('poApprove')}}',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: {id: id, "_token": "{{ csrf_token() }}"},
          success: function (resultData) {
            // var data = JSON.parse(resultData);
            // if (data.status === 'success') {
            //   Swal.fire('Done', data.msg, 'success');
            location.reload();
            // } else if (data.status === 'error') {
            //   Swal.fire('Error !', data.msg, 'error');
            // }
          }
        });
      } else if (result.dismiss === 'cancel') {
        Swal.fire(
          'Cancelled',
          'Your request has been Cancelled !!',
          'error'
        )
      }
    });
  }

  function getDeniMaxPo() {
    $.ajax({
      "url": "{{ route('getDeniMaxPo') }}",
      "type": "POST",
      "headers": "{ 'X-CSRF-TOKEN': $('meta[name='csrf-token']').attr('content') }",
      "data": {
        "_token": "{{ csrf_token() }}"
      },
      success: function (output) {
        Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
        });
      }
    })
  }


  function invoiceDelete(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You want to?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, Delete!',
      reverseButtons: true,
      cancelButtonColor: '#d33',
      confirmButtonClass: 'btn btn-primary',
      cancelButtonClass: 'btn btn-danger ml-1',
      buttonsStyling: true
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          type: 'POST',
          url: '{{route('invoiceDelete')}}',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: {id: id, "_token": "{{ csrf_token() }}"},
          success: function (resultData) {
            toastr.success('successfully Deleted');
            location.reload();
          }
        });
      } else if (result.dismiss === 'cancel') {
        Swal.fire(
          'Cancelled',
          'Your request has been Cancelled !!',
          'error'
        )
      }
    });
  }
</script>
