@extends('layouts/layoutMaster')

@section('title', 'Pending List')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
  <!-- Row Group CSS -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
  <!-- Form Validation -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('vendor-script')
  <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
  <!-- Flat Picker -->
  <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
  <!-- Form Validation -->
  <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
@endsection

@section('page-script')
  {{-- <script src="{{asset('assets/js/tables-datatables-basic.js')}}"></script> --}}
@endsection

@section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Pending /</span> List
  </h4>

  <!-- DataTable with Buttons -->
  <div class="card">
    <div class="card-datatable table-responsive pt-0">
      <table class="datatables-basic table" id="datatable-list">
        <thead>
        <tr>
          <th>SR No.</th>
          {{--<th>SO Date</th>--}}
          <th>Sales Order No</th>
          <th>Customer Name</th>
          <th>Brand</th>
          <th>Style Cat.</th>
          <th>Style No.</th>
          <th>Quantity</th>
          <th>Ship Date</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @php

          @endphp
        @php $num = 1 @endphp
        @foreach ($SalesOrders as $SalesOrder)
          @php
            $styleCount = 0;
            $styleTotalQty = 0;
            $styleShipDate = '<ul>';
          @endphp
          @foreach ($SalesOrder->SalesOrderStyleInfo as $SalesOrderStyle)
            @php
              $styleCount++;
              $styleTotalQty += $SalesOrderStyle->total_qty;
              $orderPlaningStatus =
                  $SalesOrderStyle->order_planing_status == 'done'
                      ? $SalesOrderStyle->order_planing_status
                      : '';
              $styleShipDate .=
                  '<li>' .
                  Helper::formateDate($SalesOrderStyle->ship_date) .
                  ' <span class="badge rounded bg-label-success">' .
                  $orderPlaningStatus .
                  '</span></li>';
            @endphp
          @endforeach
          @php
            $styleShipDate .= '</ul>';
          @endphp
          <tr>
            <td class="text-bold"><a href="">{{ $num }}</a></td>
            {{--<td>{{ Helper::formateDate($SalesOrder->date) }}</td>--}}
            <td>{{ $SalesOrder->sales_order_no }}</td>
            <td>
              <div class="d-flex justify-content-start align-items-center">
                <div class="avatar-wrapper">
                  <div class="avatar me-2"><span
                      class="avatar-initial rounded-circle bg-label-info">{{ substr($SalesOrder->Customer[0]->company_name ?? '-', 0, 2) }}</span>
                  </div>
                </div>
                <div class="d-flex flex-column"><span
                    class="fw-medium">{{ $SalesOrder->Customer[0]->company_name ?? '' }}</span><small
                    class="text-truncate text-muted">{{ $SalesOrder->Customer[0]->buyer_name ?? '' }}</small>
                </div>
              </div>
            </td>
            <td>
              {{ $SalesOrder->Brand[0]->name ?? '' }}
            </td>
            <td>
              <ul>
                @foreach ($SalesOrder->SalesOrderStyleInfo as $SalesOrderStyle)
                  <li>{{ $SalesOrderStyle->StyleMaster->StyleCategory->name ?? '' }} </li>
                @endforeach
              </ul>
            </td>
            <td>
              <ul>
                @foreach ($SalesOrder->SalesOrderStyleInfo as $SalesOrderStyle)
                  <li>{{ $SalesOrderStyle->StyleMaster->style_no ?? '' }} </li>
                @endforeach
              </ul>
            </td>
            <td>
              <ul>
                @foreach ($SalesOrder->SalesOrderStyleInfo as $SalesOrderStyle)
                  <li>{{ $SalesOrderStyle->total_qty }}</li>
                @endforeach
              </ul>
            </td>
            <td>
              {!! $styleShipDate !!}
            </td>
            <td>
              <a href="{{ route('order-planning-create', ['sale_id' => $SalesOrder->id]) }}"
                 type="button" class="btn btn-outline-success waves-effect">
                <span class="ti-xs ti ti-note me-1"></span>Create
              </a>
            </td>
          </tr>
          @php $num++ @endphp
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <!-- Modal to add new record -->
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>
  $(document).ready(function() {
    $('#datatable-list').DataTable({
    });
  });
</script>
