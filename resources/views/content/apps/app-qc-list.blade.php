@extends('layouts/layoutMaster')

@section('title', 'QC List')

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
    <span class="text-muted fw-light float-left">QC /</span> List
  </h4>
  <!-- Invoice List Widget -->
  <div class="card">
    <div class="card-datatable table-responsive pt-0">
      <table class="datatables-basic table" id="datatable-list">
        <thead>
        <tr>
          <th>SR No.</th>
          <th>PO No</th>
          <th>QC Date</th>
          <th>Item</th>
          <th>Good Qty</th>
          <th>Bad Qty</th>
          <th>Total Qty</th>
          <th>Remark</th>
        </tr>
        </thead>
        <tbody>
        @php $num = 1 @endphp
        @foreach($qcItems as $qcItem)
          <tr>
            <td class="text-bold">{{ $num }}</td>
            <td class="text-bold">{{ $qcItem->PoItem->Po->po_no }}</td>
            <td>{{ date("D, d M Y", strtotime($qcItem->date)) }}</td>
            <td>{{ $qcItem->PoItem->item_name }}</td>
            <td>{{ $qcItem->g_qty }}</td>
            <td>{{ $qcItem->b_qty }}</td>
            <td>{{ $qcItem->qty }}</td>
            <td>{{ $qcItem->remark }}</td>
          </tr>
          @php $num++ @endphp
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>
  $(document).ready(function () {
    $('#datatable-list').DataTable({
      order: [[0, 'desc']],
    });
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
</script>
