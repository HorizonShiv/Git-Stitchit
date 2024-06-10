@extends('layouts.layoutMaster')

@section('title', 'History View')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
  <!-- Row Group CSS -->
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')}}">
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
  <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('page-script')
  {{--<script src="{{asset('assets/js/tables-datatables-basic.js')}}"></script>--}}
  <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
@endsection

@section('content')
  <h4 class="py-3 mb-4">
    <span
      class="text-muted fw-light">Production/ {{ $IssueManageHistory->issueFromDeparment->processMaster->name }}/ {{ $IssueManageHistory->issueFromDeparment->name  }} To {{ $IssueManageHistory->issueToDepartment->name ?? ""  }} /</span>View
  </h4>

  <div class="card">
    {{-- <h5 class="card-header">Applicable Categories</h5> --}}
    <div class="card-body">

      <div class="content">

        <div class="content-header mb-4">
          <h4 class="mb-1">Primary Information</h4>
        </div>
        <div class="row g-3">
          <h3 class="text-center">JobCard Transfer  "{{ $IssueManageHistory->issueFromDeparment->name  }}" To "{{ $IssueManageHistory->issueToDepartment->name ?? ""  }}" Department </h3>
          <div class="col-md-2">
            <label class="form-label" for="JobOrderDate">Issue Date</label>
            <input type="text" class="form-control date-picker" id="JobOrderDate" name="JobOrderDate" readonly value="{{ $IssueManageHistory->created_at }}" />
          </div>

          <div class="col-md-3">
            <label class="form-label" for="OrderId">Job Order No.</label>
            <input type="text" class="form-control" id="PlaningOrderNo" name="PlaningOrderNo"
                   placeholder="Planing Order No" readonly
                   value="{{ $IssueManageHistory->IssueManage->JobOrders->job_order_no }}" />
          </div>

          <div class="col-md-3">
            <label class="form-label" for="StyleId">Style No.</label>
            <select readonly id="StyleNo" name="StyleNo" class="select2 select21 form-select"
                    data-allow-clear="true" data-placeholder="Select Style" onchange="getStyleDetails()">
              <option value="">Select</option>
              @if (!empty($IssueManageHistory))
                <option selected value="{{ $IssueManageHistory->IssueManage->JobOrders->sales_order_style_id }}">
                  {{ $IssueManageHistory->IssueManage->JobOrders->SalesOrderStyleInfo->StyleMaster->style_no ?? '' }}
                  / {{ $IssueManageHistory->IssueManage->JobOrders->SalesOrderStyleInfo->customer_style_no ?? '' }}
                </option>
              @endif


            </select>
          </div>

          <div class="col-md-2 mb-4">
            <label for="select2Primary" class="form-label">Qty</label>
            <input type="text" class="form-control" id="TotalQty" name="Qty"
                   value="{{ $IssueManageHistory->qty }}" readonly />
          </div>

          <div class="col-md-2">
            <label class="form-label" for="Rate">Value added Cost Per Piece</label>
            <input type="text" class="form-control date-picker" id="Rate" name="Rate"
                   value="{{ $IssueManageHistory->va_cost }}" placeholder="Rate" readonly />
          </div>


        </div>

        <div>
          <!-- Invoice List Widget/Board -->
          <div class=" mb-4" id="showStyleDetails">

          </div>
        </div>
      </div>


      {{-- card body ending --}}
    </div>
    {{-- card end --}}
  </div>

  <div class="col-lg-12 col-md-6 mt-4">
    <div class="card">
      <div class="card-body">
        <div class="content">
          <div class="content-header mb-4">
            <h4 class="mb-1">Selected List</h4>

          </div>

          <div class="card-datatable table-responsive pt-0">
            {!! $htmlTable !!}
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- DataTable with Buttons -->
  <div class="row g-3">
    <div class="col-12 col-lg-12  col-md-12">
      <div class="card mt-2">
        <div class="card-header">
          <h4>Bom List</h4>
        </div>
        <div class="card-body table-responsive pt-0">
          <table class="datatables-basic table" id="datatable-list-bom">
            <thead class="table-secondary">
            <tr>
              <th>Sr.No</th>
              <th>Category</th>
              <th>Sub Category</th>
              <th>Item</th>
              <th>Per Pc Qty</th>
              <th>Order Qty</th>
              <th>Require Qty</th>
              <th>Available Qty</th>
              <th>Rate</th>
              <th>Total</th>
            </tr>
            </thead>
            <tbody id="dataTableBody">
            @php
              $totalRequiredQty = 0;
              $totalAvailableQty = 0;
              $totalRate = 0;
              $total = 0;
            @endphp
            @if ($IssueMaterials)
              @php $num =1; @endphp
              @foreach ($IssueMaterials as $IssueMaterial)
                @if (!empty($IssueMaterial->id))
                  @php
                    $totalRequiredQty += $IssueMaterial->required_qty;
                    $totalAvailableQty += $IssueMaterial->available_qty;
                    $totalRate += $IssueMaterial->rate;
                    $total += $IssueMaterial->total;
                  @endphp
                  <tr>
                    <td>{{ $num }}</td>
                    <td>{{ $IssueMaterial->Item->ItemCategory->name ?? '' }}</td>
                    <td>{{ $IssueMaterial->Item->ItemSubCategory->name ?? '' }}</td>
                    <td>{{ $IssueMaterial->Item->name ?? '' }}</td>
                    <td>{{ $IssueMaterial->per_pc_qty }}</td>
                    <td>{{ $IssueMaterial->order_qty }}</td>
                    <td>{{ $IssueMaterial->required_qty }}</td>
                    <td width="200">{{ $IssueMaterial->available_qty }}

                    </td>
                    <td>{{ $IssueMaterial->rate }}</td>
                    <td>{{ $IssueMaterial->total }}</td>
                  </tr>
                @endif
                @php $num ++; @endphp
              @endforeach
            @endif
            </tbody>
            <tfoot>
            <tr>
              <td colspan="6">All Total</td>
              <td>{{ $totalRequiredQty }}</td>
              <td>{{ $totalAvailableQty }}</td>
              <td>{{ $totalRate }}</td>
              <td>{{ $total }}</td>
            </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script type="text/javascript" charset="utf8"
          src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
  <script>
    $(document).ready(function() {
      var groupColumn = 1;
      $('#datatable-list-bom').DataTable({
        drawCallback: function(settings) {
          var api = this.api();
          var rows = api.rows({
            page: 'current'
          }).nodes();
          var last = null;
          api.column(groupColumn, {
            page: 'current'
          }).data().each(function(group, i) {
            if (last !== group) {

              last = group;
              var totalAmount = 0;
              var groupRows = api.rows({
                page: 'current'
              }).nodes().toArray().filter(function(row) {
                return api.cell(row, groupColumn).data() === group;
              });

              groupRows.forEach(function(row) {
                var rowData = api.row(row).data();
                totalAmount += parseFloat(rowData[
                  9]); // Replace 2 with the correct column index
              });
              $(rows).eq(i).before(
                '<tr class="total"><td colspan="22" align="right" class="text-bold font-size-large text-black"></td></tr>'
              );
              $(rows).eq(i).before(
                '<tr class="group"><td colspan="2" align="left" class="text-bold font-size-large text-black"># ' +
                group +
                '</td><td colspan="20" align="right" class="text-bold font-size-large text-black">Total Amount: ' +
                totalAmount.toFixed(2) + '</td></tr>'
              );

            }
          });
        }
      });
    });

    window.onload = function() {
      getStyleDetails();
    };

    function getStyleDetails() {
      var StyleNo = document.getElementById('StyleNo').value;
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '{{ route('getPlanningStyleDetails') }}',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          StyleId: StyleNo,
          '_token': "{{ csrf_token() }}"
        },
        success: function(result) {
          $('#showStyleDetails').html(result.showStyleDetails);
        }
      });
    }

  </script>
