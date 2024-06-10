@extends('layouts/layoutMaster')

@section('title', 'Job Order List')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}"/>
  <style>
    /*body {font-family:Arial, Helvetica, sans-serif;}*/
    .header {
      border-collapse: collapse;
      width: 100%;
    }

    h4,
    h3 {
      font-size: 18px;
    }

    .header,
    th,
    td {
      border: 1px solid slategray;
      text-align: center;
    }

    .signature {
      display: inline;
      width: 30%
    }

    .full {
      width: 100%
    }

    .no-margin {
      margin: 0;
      padding: 0;
      /* You can adjust this if needed */
    }

    .text-center {
      text-align: center;
    }

    .table-container {
      display: flex;
      padding: 0;
      /* margin: 10px; */
      margin-bottom: 60px;
    }

    .table-container table {
      margin-left: 10px;
      border-collapse: collapse;
      width: 100%;
    }

    .table-container table,
    h4,
    h3 {
      font-size: 18px;
    }

    .table-container table,
    th,
    td {
      border: 1px solid slategray;
      /* text-align: ;eft; */
    }

    .table-container table,
    td {
      vertical-align: middle !important;
      margin: 0px 5px;
    }

    .table-container tr {
      border: 1px solid slategray;
    }
  </style>
@endsection

@section('vendor-script')
  <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>

@endsection

@section('page-script')
  <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
  <script src="{{ asset('assets/js/app-invoice-list.js') }}"></script>
  <script src="{{ asset('assets/js/app-invoice-add.js') }}"></script>
@endsection


@section('content')
  {{-- <h4 class="py-3 mb-4">
      <span class="text-muted fw-light float-left">Job Order/</span> List
  </h4> --}}

  <div class="row">
    <div class="col-12">

      <div class="card">
        <div class="card-body">
          <div class="row g-3">
            <div class="col-4">
              <img src="{{ asset('assets/img/pdf/Nuvate.jpeg') }}" width="90" height="70"
                   class="no-margin">
            </div>
            <div class="col-4 text-center">
              <h3>JOB ORDER</h3>
              <img src="{{ asset('assets/img/pdf/barcode.gif') }}" width="150" height="70"
                   class="no-margin">
            </div>
          </div>
        </div>
      </div>

      <div class="table-container">
        <table style="margin-top: 50px">
          <!-- Table 1 content -->
          <tr style="border: 1px solid slategray; margin: 5px;">
            <td style="border: 1px solid slategray; background-color: #7367f0; color:white;" colspan="4">
              <h3 style="color:white !important;margin: 5px">Order e Kyc</h3>
            </td>
          </tr>
          <tr>
            <td>Company Name</td>
            <td>Brand</td>
            <td>Style</td>
            <td>Color</td>
          </tr>
          <tr>
            <td>Temp</td>
            <td>Temp.io</td>
            <td>#102 - Classic</td>
            <td>Red | Black</td>
          </tr>
          <tr>
            <td>Temp</td>
            <td>Temp.io</td>
            <td>#103 - Regular</td>
            <td>Red | Black | Yellow</td>
          </tr>
          <tr>
            <td>Temp</td>
            <td>Temp.io</td>
            <td>#104 - Rocky</td>
            <td>Blue</td>
          </tr>
        </table>
      </div>

      <div class="table-container">
        <table>
          <!-- Table 1 content -->
          <tr style="border: 1px solid slategray; margin: 5px;">
            <td style="border: 1px solid slategray;  background-color: #7367f0;font-size:1.3rem; color:white;"
                colspan="4">
              Cutting
            </td>
          </tr>
          <tr>
            <td>Item</td>
            <td>Qty</td>
            <td>Date</td>
          </tr>
          <tr>
            <td>
              Febric - Denim
            </td>
            <td>
              2000
            </td>
            <td>

            </td>
          </tr>
        </table>

        <table>
          <!-- Table 2 content -->
          <tr style="border: 1px solid slategray; margin: 5px;">
            <td style="border: 1px solid slategray;  background-color: #7367f0; font-size:1.3rem; color:white;"
                colspan="4">
              Stitching
            </td>
          </tr>
          <tr>
            <td>Item</td>
            <td>Qty</td>
            <td>Date</td>
          </tr>
          <tr>
            <td>
              Febric - Denim
            </td>
            <td>
              2000
            </td>
            <td>

            </td>
          </tr>
        </table>

        <table>
          <!-- Table 3 content -->
          <tr style="border: 1px solid slategray; margin: 5px;">
            <td style="border: 1px solid slategray;  background-color: #7367f0; font-size:1.3rem; color:white;"
                colspan="4">
              Washing
            </td>
          </tr>
          <tr>
            <td>Item</td>
            <td>Qty</td>
            <td>Date</td>
          </tr>
          <tr>
            <td>
              Febric - Denim
            </td>
            <td>
              2000
            </td>
            <td>

            </td>
          </tr>
        </table>
      </div>

      <div class="table-container">
        <table>
          <!-- Table 1 content -->
          <tr style="border: 1px solid slategray; margin: 5px;">
            <td style="border: 1px solid slategray;  background-color: #7367f0; font-size:1.3rem; color:white;"
                colspan="4">
              Finishing
            </td>
          </tr>
          <tr>
            <td>Item</td>
            <td>Qty</td>
            <td>Date</td>
          </tr>
          <tr>
            <td>
              Febric - Denim
            </td>
            <td>
              2000
            </td>
            <td>

            </td>
          </tr>
        </table>

        <table>
          <!-- Table 2 content -->
          <tr style="border: 1px solid slategray; margin: 5px;">
            <td style="border: 1px solid slategray;  background-color: #7367f0; font-size:1.3rem; color:white;"
                colspan="4">
              Packaging
            </td>
          </tr>
          <tr>
            <td>Item</td>
            <td>Qty</td>
            <td>Date</td>
          </tr>
          <tr>
            <td>
              Febric - Denim
            </td>
            <td>
              2000
            </td>
            <td>

            </td>
          </tr>
        </table>

      </div>
    </div>
  </div>

@endsection
