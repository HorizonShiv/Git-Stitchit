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
    <span class="text-muted fw-light float-left">Outward /</span> ADD
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
                <div class="col-2">
                  <div class="form-check form-check-primary mt-3">
                    <input class="form-check-input" type="radio" name="JobOrderRadio" id="WithJobOrder"
                           onchange="toggle()">
                    <label class="form-check-label" for="WithJobOrder">With Job Order</label>
                  </div>
                </div>

                <div class="col-2">
                  <div class="form-check form-check-primary mt-3 mb-3" id="WithoutJobOrderDiv">
                    <input class="form-check-input" type="radio" name="JobOrderRadio" id="WithoutJobOrder"
                           onchange="toggle()">
                    <label class="form-check-label" for="WithoutJobOrder">Without Job Order</label>
                  </div>
                </div>
              </div>

              <div id="OptionalLabel" style="display: none;">
                <div class="col-12 col-sm-4 col-lg-4" id="Job_Order_No_Container">
                  <label class="form-label" for="OrderId">Job Order No.</label>
                  <select required id="SelectJobOrder" name="SelectJobOrder"
                          class="select2 select21 form-select" data-allow-clear="true"
                          data-placeholder="Select Job Order">
                    <option value="" selected></option>

                    @foreach (\App\Models\WareHouse::all() as $data)
                      <option value="{{ $data->id }}">{{ $data->name }} -
                        {{ $data->contact_person_name }}</option>
                    @endforeach

                  </select>
                </div>
              </div>

              <div id="withPoContainer" class="mt-3" style="display: block;">
                <div class="form-group col-sm-12 mt-3">
                  <table id="option-value" class="responsive table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                      <td scope="row">Check</td>
                      <td scope="row">Item ID</td>
                      <td scope="row">Item Name</td>
                      <td scope="row">Qty</td>
                      <td scope="row">Avaiable</td>
                      <td scope="row">Rate</td>
                      <td scope="row">Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id="option-value-row1">
                      <td>
                        <div class="form-check form-check-primary mt-3 mb-3">
                          <input class="form-check-input" type="checkbox" name="WithOutPO"
                                 onchange="toggleTableVisibility()" value="1" id="WithOutPO">
                          <label class="form-check-label" for="customCheckPrimary"></label>
                        </div>
                      </td>
                      <td>
                        <div class="input-group"><input type="text" name="option_value[1][poQty]"
                                                        placeholder="Po Number" value="5" class="form-control"
                                                        readonly=""></div>
                      </td>
                      <td>
                        <div class="input-group"><input type="text" readonly="" name="option_value[1][item]"
                                                        value="AIRFORCE DYED" placeholder="SKU NO" class="form-control">
                          <input type="hidden" readonly="" name="option_value[1][id]" value="81"></div>
                      </td>
                      <td>
                        <div class="input-group"><input type="text" name="option_value[1][recQty]" placeholder="recQty"
                                                        value="6" class="form-control" readonly=""></div>
                      </td>
                      <td>
                        <div class="input-group"><input type="text" name="option_value[1][rQty]" placeholder="rQty"
                                                        value="-1" class="form-control" readonly=""></div>
                      </td>
                      <td>
                        <div class="input-group"><input type="text" name="option_value[1][qty]" id="qty1"
                                                        placeholder="100" class="form-control" required=""></div>
                      </td>
                      <td></td>
                    </tr>
                    <tr id="option-value-row2">
                      <td>
                        <div class="form-check form-check-primary mt-3 mb-3">
                          <input class="form-check-input" type="checkbox" name="WithOutPO"
                                 onchange="toggleTableVisibility()" value="1" id="WithOutPO">
                          <label class="form-check-label" for="customCheckPrimary"></label>
                        </div>
                      </td>
                      <td>
                        <div class="input-group"><input type="text" name="option_value[2][poQty]"
                                                        placeholder="Po Number" value="5" class="form-control"
                                                        readonly=""></div>
                      </td>
                      <td>
                        <div class="input-group"><input type="text" readonly="" name="option_value[2][item]"
                                                        value="RFD - 908" placeholder="SKU NO" class="form-control">
                          <input type="hidden" readonly="" name="option_value[2][id]" value="82"></div>
                      </td>
                      <td>
                        <div class="input-group"><input type="text" name="option_value[2][recQty]" placeholder="recQty"
                                                        value="6" class="form-control" readonly=""></div>
                      </td>
                      <td>
                        <div class="input-group"><input type="text" name="option_value[2][rQty]" placeholder="rQty"
                                                        value="-1" class="form-control" readonly=""></div>
                      </td>
                      <td>
                        <div class="input-group"><input type="text" name="option_value[2][qty]" id="qty2"
                                                        placeholder="200" class="form-control" required=""></div>
                      </td>
                      <td></td>
                    </tr>
                    <tr id="option-value-row3">
                      <td>
                        <div class="form-check form-check-primary mt-3 mb-3">
                          <input class="form-check-input" type="checkbox" name="WithOutPO"
                                 onchange="toggleTableVisibility()" value="1" id="WithOutPO">
                          <label class="form-check-label" for="customCheckPrimary"></label>
                        </div>
                      </td>
                      <td>
                        <div class="input-group"><input type="text" name="option_value[3][poQty]"
                                                        placeholder="Po Number" value="5" class="form-control"
                                                        readonly=""></div>
                      </td>
                      <td>
                        <div class="input-group"><input type="text" readonly="" name="option_value[3][item]"
                                                        value="RFD - 909" placeholder="SKU NO" class="form-control">
                          <input type="hidden" readonly="" name="option_value[3][id]" value="83"></div>
                      </td>
                      <td>
                        <div class="input-group"><input type="text" name="option_value[3][recQty]" placeholder="recQty"
                                                        value="6" class="form-control" readonly=""></div>
                      </td>
                      <td>
                        <div class="input-group"><input type="text" name="option_value[3][rQty]" placeholder="rQty"
                                                        value="-1" class="form-control" readonly=""></div>
                      </td>
                      <td>
                        <div class="input-group"><input type="text" name="option_value[3][qty]" id="qty3"
                                                        placeholder="500" class="form-control" required=""></div>
                      </td>
                      <td></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <input type="hidden" name="option_count" id="option_count">
                    </tfoot>
                  </table>
                  <div class="col-lg-3 col-12 invoice-actions mt-3">
                    <button type="button" class="btn btn-outline-primary waves-effect" onclick="addItem()">Add
                      another
                    </button>
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
          </div>

        </div>
      </div>
    </div>
  </form>

  <!-- Offcanvas -->
  @include('_partials/_offcanvas/offcanvas-send-invoice')
  <!-- /Offcanvas -->
@endsection


<script>
  function toggle() {
    var withJobOrderSelected = document.getElementById('WithJobOrder').checked;
    var optionalLabel = document.getElementById('OptionalLabel');
    if (withJobOrderSelected) {
      optionalLabel.style.display = 'block';
    } else {
      optionalLabel.style.display = 'none';
    }
  }

  var counter = 0;

  function addItem() {
    // Increment counter
    counter++;

    // HTML content with dynamic IDs and names
    var htmlContent = '<tr id="row_' + counter + '">' + // Add unique ID to the row
      '<td scope="row"><input class="form-check-input" type="checkbox" name="checkbox1" id="checkbox[0]"></input></td>' +
      '<td scope="row">' +
      '<select class="select2 form-select form-control" name="item[' + counter + ']" id="items_' + counter +
      '">' +
      '@foreach (\App\Models\Item::all() as $data)' +
      '<option value="{{ $data->id }}"> {{ $data->name }}</option>' +
      '@endforeach' +
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
      '<td scope="row">' +
      '<input type="number" id="rate_' + counter +
      '" value="" name="rate[' + counter + ']" class="form-control" placeholder="Rate" />' +
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
    $('#option-value tbody').append('<tr>' + htmlContent + '</tr>');
    $('.select2').select2();
  }

  function removeItem(rowId) {
    // Remove the row with the given rowId
    $('#row_' + rowId).remove();
  }


  function toggleTableVisibility() {
    var WithJobOrder = document.getElementById('SelectJobOrder');
    var withPoContainer = document.getElementById('withPoContainer');

    var withoutPo = document.getElementById('withoutPo');
    var withoutPoContainer = document.getElementById('withoutPoContainer');

    var checkbox = document.getElementById('WithOutPO');
    if (checkbox.checked) {
      withPo.style.display = 'None'; // Hide the table when checkbox is checked
      withPoContainer.style.display = 'None'; // Hide the table when checkbox is checked

      withoutPo.style.display = 'Block';
      withoutPoContainer.style.display = 'Block';
    } else {
      withPo.style.display = 'Block'; // Show the table when checkbox is unchecked
      withPoContainer.style.display = 'Block'; // Hide the table when checkbox is checked

      withoutPo.style.display = 'None';
      withoutPoContainer.style.display = 'None';
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
        '_token': "{{ csrf_token() }}"
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
      $('#qty' + id).val(currentQty);
    }
  }

  function goodBadCheck(qty, id) {
    var currentQty = qty || 0;
    var gQty = $('#g_qty' + id).val() || 0;
    var bQty = $('#b_qty' + id).val() || 0;
    var total = parseFloat(gQty) + parseFloat(bQty);
    if (total > currentQty) {
      Swal.fire('Opps !', 'Qty is greater than invoice Qty!!!', 'error');
      $('#qty' + id).val(0);
      $('#g_qty' + id).val(0);
      $('#b_qty' + id).val(0);
      0;
    } else {
      $('#qty' + id).val(total);
    }
  }
</script>
