@extends('layouts/layoutMaster')

@section('title', 'Add - PO')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('page-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />
@endsection

@section('vendor-script')
  <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

@section('page-script')
  {{-- <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script> --}}
  {{-- <script src="{{ asset('assets/js/app-grn-add.js') }}"></script> --}}
  <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
  <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
  <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
@endsection

@section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light float-left">GR TO Supplier</span>
  </h4>
  <form id="formid" class="source-item" action="{{ route('grnAddStore') }}" method="post"
        enctype="multipart/form-data">
    @csrf
    <div class="row invoice-add">
      <!-- Invoice Add-->
      <div class="col-lg-12 col-12 mb-lg-0 mb-4">
        <div class="card invoice-preview-card">

          <div class="card-body">
            <div class="users-list-filter">
              <div class="row">

                <div class="col-12 col-sm-4 col-lg-4" id="withPo">
                  <label for="users-list-verified">GRN No</label>
                  <fieldset class="form-group">
                    <select class="form-control select2" name="grnNo" id="grnNo"
                            onchange="getPODetailForGRN();"
                            data-placeholder="Select GRN">
                      <option value="">GRN </option>
                      {{--                      @foreach ($pos as $po)--}}
                      {{--                        <option value="{{ $po->id }}">--}}
                      {{--                          {{ $po->po_no . ' : ' . $po->User->company_name }}</option>--}}
                      {{--                      @endforeach--}}
                    </select>
                  </fieldset>
                </div>

                <div class="col-12 col-sm-4 col-lg-4">
                  <label class="form-label" for="OrderId">Select Supplier</label>
                  <select required id="SelectSupplier" name="SelectSupplier"
                          class="select2 select21 form-select" data-allow-clear="true"
                          data-placeholder="Select Supplier">
                    <option value="" selected></option>

                    @foreach (\App\Models\WareHouse::all() as $data)
                      <option value="{{ $data->id }}">{{ $data->name }} -
                        {{ $data->contact_person_name }}</option>
                    @endforeach

                  </select>
                </div>

                <div id="withoutPoContainer" class="mt-3" style="display: block;">
                  <div class="form-group col-sm-12 mt-3">
                    <table id="WithoutPoTable"
                           class="responsive table table-striped table-bordered table-hover">
                      <thead>
                      <tr>
                        <td scope="row">Sr.No</td>
                        <td scope="row">Item Name</td>
                        <td scope="row">Quantity</td>
                        <td scope="row">Rate</td>
                        <td scope="row">Action</td>
                        {{-- <td scope="row">Add</td> --}}
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                      <input type="hidden" name="option_count" id="option_count" />
                      </tfoot>
                    </table>
                    <div class="col-lg-3 col-12 invoice-actions mt-3">
                      <button type="button" class="btn btn-outline-primary" onclick="addItem()">Add
                        another</button>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-sm-4 col-lg-4" id="withoutPo" style="display: none;">
                  <label for="users-list-verified">Supplier</label>
                  <fieldset class="form-group">
                    <select class="form-control select2" name="Supplier" id="Supplier">
{{--                      @foreach ($Suppliers as $Supplier)--}}
{{--                        <option value="{{ $Supplier->id }}">--}}
{{--                          {{ $Supplier->company_name . ' : ' . $Supplier->person_name }}--}}
{{--                        </option>--}}
{{--                      @endforeach--}}
                    </select>
                  </fieldset>
                </div>

              </div>

              <div class="col-12 mt-3">
                <div class="mb-3">
                  <label for="note">Remark:</label>
                  <textarea class="form-control" rows="2" id="remark" name="remark" placeholder="remark"></textarea>
                </div>
              </div>
              <div class="row px-0 mt-3">
                <div class="col-lg-2 col-md-12 col-sm-12">
                  <button type="submit" class="btn btn-primary d-grid w-100">Save</button>
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12">
                  <button type="submit" name="AddMore" value="1"
                          class="btn btn-label-primary waves-effect d-grid w-100">Save & Add more</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /Invoice Add-->
      </div>
  </form>

  <!-- Offcanvas -->
  @include('_partials/_offcanvas/offcanvas-send-invoice')
  <!-- /Offcanvas -->
@endsection

<script>
  var counter = 0;

  function addItem() {
    // Increment counter
    counter++;

    // HTML content with dynamic IDs and names
    var htmlContent = '<tr id="row_' + counter + '">' + // Add unique ID to the row
      '<td scope="row">' + counter + '</td>' +
      '<td scope="row">' +
      '<select class="select2 form-select form-control" name="item[' + counter + ']" id="items_' + counter +
      '">' +
      {{--'@foreach ($Item as $data)' +--}}
      {{--'<option value="{{ $data->id }}"> {{ $data->name }}</option>' +--}}
      {{--'@endforeach' +--}}
      '</select>' +
      '</td>' +
      '<td scope="row">' +
      '<input type="text" id="qty_' + counter +
      '" value="" name="qty[' + counter + ']" class="form-control" placeholder="Qty" />' +
      '</td>' +
      '<td scope="row">' +
      '<input type="number" id="rate_' + counter +
      '" value="" name="rate[' + counter + ']" class="form-control" placeholder="Rate" />' +
      '</td>' +
      '<td><button type="button" class="btn rounded-pill btn-icon btn-label-danger waves-effect" onclick="removeItem(' +
      counter + ')"><span class="ti ti-trash"></span></button></td>' +
      // Add remove button
      '</tr>';

    // Append the content to the table with ID "WithoutPoTable"
    $('#WithoutPoTable tbody').append('<tr>' + htmlContent + '</tr>');
    $(".select2").select2();
  }

  function removeItem(rowId) {
    // Remove the row with the given rowId
    $('#row_' + rowId).remove();
  }



  function toggleTableVisibility() {
    var withPo = document.getElementById("withPo");
    var withPoContainer = document.getElementById("withPoContainer");

    var withoutPo = document.getElementById("withoutPo");
    var withoutPoContainer = document.getElementById("withoutPoContainer");

    var checkbox = document.getElementById("WithOutPO");
    if (checkbox.checked) {
      withPo.style.display = "None"; // Hide the table when checkbox is checked
      withPoContainer.style.display = "None"; // Hide the table when checkbox is checked

      withoutPo.style.display = "Block";
      withoutPoContainer.style.display = "Block";
    } else {
      withPo.style.display = "Block"; // Show the table when checkbox is unchecked
      withPoContainer.style.display = "Block"; // Hide the table when checkbox is checked

      withoutPo.style.display = "None";
      withoutPoContainer.style.display = "None";
    }
  }
</script>

<script>
  function getPODetailForGRN() {
    $('#option-value tbody').empty();
    var poNo = document.getElementById('poNo').value;
    // $body.addClass("loading");
    $.ajax({
      dataType: 'JSON',
      type: 'POST',
      url: '{{ route('getPODetailForGRN') }}',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        poNo: poNo,
        "_token": "{{ csrf_token() }}"
      },
      success: function(data) {
        if (data === 3) {
          $('#option-value tbody').empty();
        } else {
          $('#option-value tbody').append(data);
        }
      },
      error: function(data) {
        $('#option-value tbody').empty();
      }
    });
  }

  function qtyCheck(qty, id) {
    var currentQty = qty || 0;
    var insertQty = $('#qty' + id).val();
    if (insertQty > currentQty) {
      Swal.fire('Opps !', 'Qty is greater than invoice Qty!!!', 'error');
      $("#qty" + id).val(currentQty);
    }
  }

  function goodBadCheck(qty, id) {
    var currentQty = qty || 0;
    var gQty = $('#g_qty' + id).val() || 0;
    var bQty = $('#b_qty' + id).val() || 0;
    var total = parseFloat(gQty) + parseFloat(bQty);
    if (total > currentQty) {
      Swal.fire('Opps !', 'Qty is greater than invoice Qty!!!', 'error');
      $("#qty" + id).val(0);
      $('#g_qty' + id).val(0);
      $('#b_qty' + id).val(0)
      0;
    } else {
      $("#qty" + id).val(total);
    }
  }
</script>
