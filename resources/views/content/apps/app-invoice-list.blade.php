@extends('layouts/layoutMaster')

@section('title', 'Invoice List - Pages')

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
    <span class="text-muted fw-light float-left">Invoice /</span> List
  </h4>
  <div class="card mb-4">
    <div class="card-widget-separator-wrapper">

      <div class="card-body card-widget-separator">
        <div class="row gy-4 gy-sm-1 mb-1">
          <div class="col-sm-6 col-lg-2">
            <label>GRN Received</label></br>
            <input type="checkbox"
                   style="width: 26px;height: 26px"
                   class=""
                   onclick="getAllData();"
                   value="1" name="grn_receive"
                   id="grn_receive">
          </div>

          <div class="col-lg-2 col-md-6 col-sm-6">
            <label for="users-list-verified">Select Status</label>
            <fieldset class="form-group">
              <select class="form-control form-control-sm" name="approve_status" id="approve_status"
                      onchange="getAllData()">
                <option value="">All</option>
                <option value="1">Approve</option>
                <option value="2">Pending</option>
              </select>
            </fieldset>
          </div>

          <div class="col-sm-6 col-lg-3">
            <label>Start Date</label>
            <input type="date" class="form-control form-control-sm"
                   value="{{ (Auth::user()->role == 'account')?Auth::user()->invoice_export_date:"" }}"
                   name="startDate"
                   onchange="getAllData();"
                   id="startDate">
          </div>
          <div class="col-sm-6 col-lg-3">
            <label>End Date</label>
            <input type="date" onchange="getAllData();" class="form-control form-control-sm" name="endDate"
                   id="endDate">
          </div>
          <div class="col-sm-6 col-lg-2">
            @if((Auth::user()->role == 'account') || (Auth::user()->role == 'admin'))
              <button onclick="invoiceExcelExport()" class="btn btn-success btn-sm mt-4">Invoice Export</button>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Invoice List Widget -->

  <div class="card mb-4">
    <div class="card-widget-separator-wrapper">
      <div class="card-body card-widget-separator">
        <div class="row gy-4 gy-sm-1">
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
              <div>
                <h3 class="mb-1">{{ $data['invoiceCount'] }}</h3>
                <p class="mb-0">Unpaid Invoices</p>
              </div>
              <span class="avatar me-sm-4">
              <span class="avatar-initial bg-label-secondary rounded"><i class="ti ti-user ti-md"></i></span>
            </span>
            </div>
            <hr class="d-none d-sm-block d-lg-none me-4">
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
              <div>
                <h3
                  class="mb-1">{{ $data['invoiceVendors'] }}</h3>
                <p class="mb-0">Vendors</p>
              </div>
              <span class="avatar me-lg-4">
              <span class="avatar-initial bg-label-secondary rounded"><i class="ti ti-file-invoice ti-md"></i></span>
            </span>
            </div>
            <hr class="d-none d-sm-block d-lg-none">
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
              <div>
                <h3 class="mb-1">{{ $data['invoiceAmount'] }}</h3>
                <p class="mb-0">Paid</p>
              </div>
              <span class="avatar me-sm-4">
              <span class="avatar-initial bg-label-secondary rounded"><i class="ti ti-checks ti-md"></i></span>
            </span>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h3 class="mb-1">{{ $data['invoiceUnPaidAmount'] }}</h3>
                <p class="mb-0">Unpaid</p>
              </div>
              <span class="avatar">
              <span class="avatar-initial bg-label-secondary rounded"><i class="ti ti-circle-off ti-md"></i></span>
            </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- DataTable with Buttons -->
  <div class="card">
    <div class="card-datatable table-responsive pt-0">
      <table class="dataTable table" id="datatable-list">
        <thead>
        <tr>
          <th>Sr.No.</th>
          <th>Vendors</th>
          <th>Our Company</th>
          <th><span>Invoice</span><br><span class="text-secondary">Challan</span></th>
          <th>Invoice Date</th>
          <th>Invoice Sub Total</th>
          <th>Invoice Amount</th>
          <th>Payment Status</th>
          <th>Status</th>
          <th>Invoice File</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
  @include('_partials/_modals/modal-add-permission')
  <form action="{{ route('storeInvoiceQuery') }}" method="post">
    @csrf
    @include('_partials/_modals/modal-invoice-query')
  </form>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>
  $(document).ready(function () {
    getAllData();
  });

  function getAllData() {
    let grn_receive = $('input[name="grn_receive"]:checked').val() || "0";
    $("#overlay").fadeIn(100);
    $('#datatable-list').DataTable({
      autoWidth: false,
      order: [[0, 'desc']],
      lengthMenu: [[10, 20, 100, 50000], [10, 20, 100, "All"]],
      "ajax": {
        "url": "{{ route('listingInvoice') }}",
        "type": "POST",
        "headers": "{ 'X-CSRF-TOKEN': $('meta[name='csrf-token']').attr('content') }",
        "data": {
          "startDate": $('#startDate').val(),
          "endDate": $('#endDate').val(),
          "approve_status": $('#approve_status').val(),
          "grn_receive": grn_receive,
          "_token": "{{ csrf_token() }}"
        },
      },
      "initComplete": function (setting, json) {
        $("#overlay").fadeOut(100);
      },
      bDestroy: true
    });
  }

  function viewInvoiceStatusChange(id, status) {
    $.ajax({
      type: 'POST',
      url: "{{ route('getInvoiceDetails') }}",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {id: id, status: status, "_token": "{{ csrf_token() }}"},
      success: function (data) {
        $('.modal-body').html(data);
        $('#modal-stock-add').modal('show');
      },
      error: function (data) {
        alert(data);
      }
    });
  }

  function viewInvoiceQuery(id, invoiceQty, grnQty, invoiceAmount, poAmount, checkInvoiceNumberShow, checkInvoiceQtyShow, poAvailabilityShow) {
    $("#overlay").fadeIn(100);
    $('.modal-body').html("");
    $.ajax({
      type: 'POST',
      url: "{{ route('viewInvoiceQuery') }}",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {
        id: id,
        invoiceQty: invoiceQty,
        grnQty: grnQty,
        invoiceAmount: invoiceAmount,
        poAmount: poAmount,
        checkInvoiceNumberShow: checkInvoiceNumberShow,
        checkInvoiceQtyShow: checkInvoiceQtyShow,
        poAvailabilityShow: poAvailabilityShow,
        "_token": "{{ csrf_token() }}"
      },
      success: function (data) {
        $('.modal-body').html(data);
        $('#modal-stock-add').modal('show');
        $("#overlay").fadeOut(100);
      },
      error: function (data) {
        alert(data);
        $("#overlay").fadeOut(100);
      }
    });
  }


  function viewApprove(id) {
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
        $("#overlay").fadeIn(100);
        $.ajax({
          type: 'POST',
          url: '{{route('invoiceApprove')}}',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: {id: id, "_token": "{{ csrf_token() }}"},
          success: function (resultData) {
            Swal.fire('Done', 'Approved Done', 'success').then(() => {
              location.reload();
              $("#overlay").fadeOut(100);
            });
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

  function invoiceExcelExport() {
    var startDate = $("#startDate").val();
    var endDate = $("#endDate").val();

    if (startDate === "") {
      toastr.error("enter start date");
      return false;
    } else if (endDate === "") {
      toastr.error("enter end date");
      return false;
    } else {
      $("#overlay").fadeIn(100);
      $.ajax({
        "url": "{{ route('invoiceExcelExport') }}",
        "type": "POST",
        "headers": "{ 'X-CSRF-TOKEN': $('meta[name='csrf-token']').attr('content') }",
        "data": {
          "endDate": endDate,
          "startDate": startDate,
          "_token": "{{ csrf_token() }}"
        },
        beforeSend: function () {
          Swal.fire('Done', 'Successfully! your request is process! click refresh and download file', 'success').then(() => {
          });
        },
        success: function (output) {
          $("#overlay").fadeOut(100);
          var win = window.open('', '_self');
          win.location.href = encodeURI(output);
        }
      })
    }
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
        $("#overlay").fadeIn(100);
        $.ajax({
          type: 'POST',
          url: '{{route('invoiceDelete')}}',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: {id: id, "_token": "{{ csrf_token() }}"},
          success: function (resultData) {

            Swal.fire('Done', 'Successfully! Deleted', 'success').then(() => {
              location.reload();
              $("#overlay").fadeOut(100);
            });
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
