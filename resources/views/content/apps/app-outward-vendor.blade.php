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
  <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script>
  <script src="{{ asset('assets/js/app-invoice-add.js') }}"></script>
  <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
  <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
  <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
@endsection

@section('content')
  @php
    // dd($VendorSupplier);
  @endphp
  <form id="formid" class="source-item" action="{{ route('poAddStore') }}" method="post"
        enctype="multipart/form-data">
    @csrf
    <div class="row invoice-add">
      <!-- Invoice Add-->
      <div class="col-lg-12 col-12 mb-lg-0 mb-4">
        <div class="card invoice-preview-card">

          <div class="card-body">
            <div class="row m-sm-4 m-0">

              <div class="col-md-12 mb-md-0 mb-4 ps-0">

                <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                  @include('_partials.macros', ['height' => 22, 'withbg' => ''])
                  <span class="app-brand-text fw-bold fs-4">
                                        Outward To Vendor
                                    </span>
                </div>
                <div class="form-check form-check-primary mt-3 mb-3">
                  <input class="form-check-input" type="checkbox" name="ToSupplier"
                         onchange="toggleTableVisibility()" value="1" id="ToSupplier">
                  <label class="form-check-label" for="customCheckPrimary">for Service Provider's
                    Shippping</label>
                </div>
                <div class="row">
                  <div class="col-3 col-sm-4 col-lg-3">
                    <label for="users-list-status">Date</label>
                    <fieldset class="form-group">
                      <input type="date" class="form-control" value="<?= date('Y-m-d') ?>"
                             name="date" id="date" required>
                    </fieldset>
                  </div>
                  <div class="mb-3 md-3 col-3">
                    <label class="form-label" for="form-repeater-1-1">Company</label>
                    <select id="company_id" name="company_id" onchange="getCompanyDetails();"
                            class="select2 form-select" data-placeholder="Select Company">
                      <option value="">Select company</option>
                      @foreach (App\Models\Company::all() as $company)
                        <option value="{{ $company->id }}">{{ $company->b_name }}</option>
                      @endforeach
                    </select>
                    <div class="col-md-12 col-sm-5 col-12 mb-sm-0 mb-4" id="getCompanyBillDetails">
                    </div>
                  </div>
                  <div class="mb-3 md-3 col-3" id="CompanyShipping">
                    <label class="form-label" for="form-repeater-1-1">Shipping Address</label>
                    <select id="shipping_id" name="shipping_id" onchange="Complate();"
                            class="select2 form-select" data-placeholder="Select Shipping Address">

                      <option value="">Select Shipping Address</option>
                      <option value="">XYZ</option>
                      <option value="">ABC</option>
                      {{--                      @foreach ($ShippingAddress as $address)--}}
                      {{--                        <option value="{{ $address->id }}">--}}
                      {{--                          {{ $address->address1 }}-{{ $address->address2 }}-{{ $address->city }}--}}
                      {{--                        </option>--}}
                      {{--                      @endforeach--}}
                    </select>
                    <div class="col-md-12 col-sm-7 " id="getCompanyShipDetails">
                  </div>


                  <div class="mb-3 md-3 col-3" id="VendorShipping" style="display:none;">
                    <label class="form-label" for="form-repeater-1-1">Service Provider's Shipping
                      Address</label>
                    <select id="vendor_id" name="vendor_id" onchange="getVendorShippingDetails();"
                            class="select2 form-select" data-placeholder="Select Shipping Address">
                      <option value="">Select Service Provider's Shipping Address</option>


                      {{--                      @foreach ($Users as $user)--}}
                      {{--                        @foreach ($user->UserAddress as $address)--}}
                      {{--                          <option value="{{ $address->id }}">{{ $user->company_name }}--}}
                      {{--                            {{ $address->b_address1 }}-{{ $address->b_address2 }}-{{ $address->b_city }}--}}
                      {{--                          </option>--}}
                      {{--                        @endforeach--}}
                      {{--                      @endforeach--}}
                    </select>
                    </div>
                  </div>

                  <div class="mb-6 col-3">
                    <label class="form-label" for="form-repeater-1-1">Vendor</label>
                    <select id="user_id" name="user_id" onchange="getVendorDetails();"
                            class="select2 form-select" data-placeholder="Select Vendor">
                      <option value="">Select Vendor</option>
                      @foreach (App\Models\User::where('is_active', '1')->where('role', 'vendor')->get() as $user)
                        <option value="{{ $user->id }}">{{ $user->company_name }}</option>
                      @endforeach
                    </select>

                    <div id="getVendorDetails" class="col-8">
                    </div>
                  </div>
                  <br>

                </div>

              </div>
            </div>

            <hr class="my-3 mx-n4" />

            <div class="row p-sm-4 p-0">


              <div class="mb-3" data-repeater-list="group-a">
                <div class="repeater-wrapper pt-0 pt-md-4 col-12" data-repeater-item>
                  <div class="d-flex border rounded position-relative pe-0">
                    <div class="item-box col-12">
                      <div class="item row w-100 p-3" id="items">


                        <div class="mb-3 col-md-3">
                          <label class="form-label" for="form-repeater-1-1">Job Order No.</label>
                          <select id="job_order_no" name="job_order_no" onchange="getCompanyDetails();"
                                  class="select2 form-select" data-placeholder="Select Job Order">
                            <option value="">Job Order</option>
                            @foreach (App\Models\Company::all() as $company)
                              <option value="{{ $company->id }}">{{ $company->b_name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="mb-3 col-md-3 ">
                          <label class="form-label" for="form-repeater-1-1">Process</label>
                          <select id="select_process" name="select_process" onchange="getCompanyDetails();"
                                  class="select2 form-select" data-placeholder="Select Process">
                            <option value="">Select Process</option>
                            @foreach (App\Models\Company::all() as $company)
                              <option value="{{ $company->id }}">{{ $company->b_name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="mt-4 col-md-3">
                          <input type="number" step="any" value="0"
                                 onchange="calculateItemAmount(this)" name="qty"
                                 class="quantity form-control mb-1" placeholder="qty" />
                        </div>
                        <div class="col-md-3 ">
                          <label for="note">Remark:</label>
                          <textarea class="form-control" rows="2" id="remark" name="remark"
                                    placeholder="remark"></textarea>
                        </div>
                      </div>
                    </div>
                    <div
                      class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                      <i class="ti ti-x cursor-pointer" onclick="deleteElement(this)"
                         data-repeater-delete></i>

                    </div>
                  </div>
                </div>
              </div>
              <div class="row pb-4">
                <div class="col-12">
                  <button type="button" class="btn btn-primary" data-repeater-create>Add Item</button>
                </div>
              </div>
            </div>


            <hr class="my-3 mx-n4" />

            <div class="row p-0 p-sm-4">
              {{--              <div class="col-md-6 mb-md-0 mb-3">--}}
              {{--                <label class="form-label" for="pancard_number">Document File</label>--}}
              {{--                <input type="file" name="po_file" id="po_file" class="mt-1 mb-4 form-control">--}}
              {{--                <div class="row mt-5 t_item">--}}
              {{--                  <div class="col-md-6 col-lg-4 mb-md-0 mb-8">--}}
              {{--                    <label>Expected Delivery Date</label>--}}
              {{--                    <input type="date" name="d_date" id="d_date"--}}
              {{--                           class="form-control w-px-150 date-picker" placeholder="YYYY-MM-DD" />--}}
              {{--                  </div>--}}
              {{--                  <input type="hidden" onchange="calculateTransportationTax(this)" step="any"--}}
              {{--                         name="t_charge" id="t_charge" value="0" class="t_charge form-control"--}}
              {{--                         placeholder="" />--}}
              {{--                  <input type="hidden" name="t_tax" id="t_tax" value="0"--}}
              {{--                         onchange="calculateTransportationTax(this)" class="t_tax" />--}}
              {{--                  <input type="hidden" readonly step="any" value="0" name="t_amount"--}}
              {{--                         id="t_amount" class="t_amount form-control" placeholder="" />--}}
              {{--                </div>--}}
              {{--              </div>--}}

              <div class="col-md-12 d-flex justify-content-end">
                <div class="invoice-calculations">
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-150">Subtotal Amount:</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="number" readonly step="any" name="sub_total_amount"
                             class="sub_total_amount form-control w-px-150" placeholder="" />
                    </dd>
                  </div>
                  <div class="d-flex justify-content-between mb-2" hidden>
                    <span class="w-px-150" hidden>Discount Amount:</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="hidden" name="discount_amount" step="any" readonly
                             class="discount_amount form-control w-px-150" placeholder="" />
                    </dd>
                  </div>

                  <hr />
                  <div class="d-flex justify-content-between">
                    <span class="w-px-150">Total Amount:</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="number" name="po_amount" id="po_amount" step="any"
                             readonly class="po_amount form-control w-px-150" placeholder="" />
                    </dd>
                  </div>
                </div>
              </div>
            </div>

            <hr class="my-3 mx-n4" />

            <div class="row px-0 px-sm-4">
              <div class="col-12">
                <div class="mb-3">
                  <label for="note" class="form-label fw-medium">Note:</label>
                  <textarea class="form-control" rows="2" id="note" name="note" placeholder="Note"></textarea>
                </div>
              </div>
              <div class="col-lg-3 col-md-12 col-sm-12">
                <button type="submit" onclick="submitBtn();"
                        class="btn btn-primary d-grid w-100">Save
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /Invoice Add-->
    </div>
    </div>
  </form>

  <!-- Offcanvas -->
  @include('_partials/_offcanvas/offcanvas-send-invoice')
  <!-- /Offcanvas -->
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  function deleteElement(element) {
    var repeaterWrapper = element.closest('.repeater-wrapper');

    // Remove the repeater-wrapper element from the DOM
    if (repeaterWrapper) {
      repeaterWrapper.remove();
    }
    calculateTotalAmount();
  }
</script>

<script>
  function calculateTransportationTax(input) {
    const t_item = input.closest('.t_item');
    let t_charge = 0;
    const t_chargeInput = t_item.querySelector('.t_charge');
    if (t_chargeInput) {
      t_charge = parseFloat(t_chargeInput.value) || 0;
    }

    let t_tax = 0;
    const t_taxInput = t_item.querySelector('.t_tax');
    if (t_taxInput) {
      t_tax = parseFloat(t_taxInput.value) || 0;
    }
    const t_taxValue = (t_charge * t_tax / 100).toFixed(2);
    const t_amount = (t_charge + parseFloat(t_taxValue)).toFixed(2);

    const itemAmountElement = t_item.querySelector('.t_amount');
    if (itemAmountElement) {
      itemAmountElement.value = t_amount;
      const itemAmounts = document.querySelectorAll('.itemAmount');
      let totalAmount = 0;
      for (let i = 0; i < itemAmounts.length; i++) {
        totalAmount += parseFloat(itemAmounts[i].value) || 0;
      }
      totalAmount = totalAmount.toFixed(2);
      $('#po_amount').val((t_amount + parseFloat(totalAmount)).toFixed(2));
    } else {
      console.log('.itemAmount element not found in the current item.');
    }
  }


  function calculateItemAmount(input) {
    const item = input.closest('.item');
    let rate = 0;
    const costInput = item.querySelector('.rate');

    if (costInput) {
      rate = parseFloat(costInput.value) || 0;
    }

    let quantity = 0;
    const quantityInput = item.querySelector('.quantity');
    if (quantityInput) {
      quantity = parseFloat(quantityInput.value) || 0;
    }

    let tax = 0;
    const taxInput = item.querySelector('.tax');
    if (taxInput) {
      tax = parseFloat(taxInput.value) || 0;
    }

    let discount = 0;
    const discountInput = item.querySelector('.discount');
    if (discountInput) {
      discount = parseFloat(discountInput.value) || 0;
    }

    const taxValue = (((quantity * rate) - discount) * (tax / 100)).toFixed(2);
    item.querySelector('.taxValue').value = taxValue;

    const itemAmount = (parseFloat((quantity * rate).toFixed(2)) + parseFloat(taxValue) - discount).toFixed(2);

    const itemAmountElement = item.querySelector('.itemAmount');
    if (itemAmountElement) {
      itemAmountElement.value = itemAmount;
    } else {
      console.log('.itemAmount element not found in the current item.');
    }
    item.querySelector('.itemAmountWithRateQty').value = (quantity * rate).toFixed(2);
    calculateTotalAmount();
  }


  function calculateTotalAmount() {
    const itemAmounts = document.querySelectorAll('.itemAmount');
    let totalAmount = 0;
    for (let i = 0; i < itemAmounts.length; i++) {
      totalAmount += parseFloat(itemAmounts[i].value) || 0;
    }
    totalAmount = parseFloat(totalAmount.toFixed(2));

    const itemAmountWithRateQty = document.querySelectorAll('.itemAmountWithRateQty');
    let itemAmountWithRateQtyValue = 0;
    for (let i = 0; i < itemAmountWithRateQty.length; i++) {
      itemAmountWithRateQtyValue += parseFloat(itemAmountWithRateQty[i].value) || 0;
    }
    itemAmountWithRateQtyValue = parseFloat(itemAmountWithRateQtyValue.toFixed(2));

    const discount = document.querySelectorAll('.discount');
    let discount_amount = 0;
    for (let i = 0; i < discount.length; i++) {
      discount_amount += parseFloat(discount[i].value) || 0;
    }
    discount_amount = parseFloat(discount_amount.toFixed(2));

    const taxValue = document.querySelectorAll('.taxValue');
    let igst_amount = 0;
    for (let i = 0; i < taxValue.length; i++) {
      igst_amount += parseFloat(taxValue[i].value) || 0;
    }
    igst_amount = parseFloat(igst_amount.toFixed(2));

    let c_gst_two = document.getElementById('c_gst_two').value;
    let v_gst_two = document.getElementById('v_gst_two').value;
    if (c_gst_two === v_gst_two) {
      $('.cgst_amount').val((igst_amount / 2).toFixed(2));
      $('.sgst_amount').val((igst_amount / 2).toFixed(2));
      $('.igst_amount').val(0);
    } else {
      $('.igst_amount').val(igst_amount.toFixed(2));
      $('.cgst_amount').val(0);
      $('.sgst_amount').val(0);
    }

    $('.sub_total_amount').val(itemAmountWithRateQtyValue.toFixed(2));

    let t_charge = parseFloat($('#t_charge').val());
    const t_taxValue = (t_charge * ($('#t_tax').val() / 100)).toFixed(2);
    const t_amount = parseFloat((t_charge + parseFloat(t_taxValue)).toFixed(2)) || 0;

    $('.po_amount').val((totalAmount + t_amount).toFixed(2));
    $('.discount_amount').val(discount_amount.toFixed(2));
  }


  function submitBtn(e) {
    let d_date = document.forms['formid']['d_date'].value;
    let po_number = document.forms['formid']['po_number'].value;
    let user_id = document.forms['formid']['user_id'].value;
    let company_id = document.forms['formid']['company_id'].value;
    if (user_id === '') {
      toastr.error('Select Vendor');
      document.getElementById('user_id').style.border = '1px solid red';
      return false;
    } else if (company_id === '') {
      toastr.error('Select Company');
      document.getElementById('company_id').style.border = '1px solid red';
      return false;
    } else if (d_date === '') {
      toastr.error('Expected Delivery Date must be filled out');
      document.getElementById('d_date').style.border = '1px solid red';
      return false;
    } else {
      $('#formid')[0].submit();
    }
  }

  function getVendorDetails() {

    var user_id = document.getElementById('user_id').value;
    $.ajax({
      type: 'POST',
      url: '{{ route('getVendorDetails') }}',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        user_id: user_id,
        '_token': "{{ csrf_token() }}"
      },
      success: function(result) {
        $('#getVendorDetails').html(result);
      },
      error: function(data) {
        console.log(data);
        alert(data);
      }
    });
    calculateTotalAmount();
  }

  function getCompanyDetails() {
    var company_id = document.getElementById('company_id').value;
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: '{{ route('getCompanyDetails') }}',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        company_id: company_id,
        '_token': "{{ csrf_token() }}"
      },
      success: function(result) {
        $('#getCompanyBillDetails').html(result.billto);
        // $("#getCompanyShipDetails").html(result.shipto);
        $('#po_number').val(result.po_number);

        $('#shipping_id').empty();
        $('#shipping_id').append('<option value="">Select shipping address</option>');
        $.each(result.shippingAddresses, function(key, value) {
          $('#shipping_id').append('<option value="' + value.id +
            '">' + value.address1 + ' ' + value.address2 + ' ' + value.city +
            '</option>');
        });
      },
      error: function(data) {
        console.log(data);
        alert(data);
      }
    });
    calculateTotalAmount();
  }

  function getCompanyShippingDetails() {
    var shipping_id = document.getElementById('shipping_id').value;
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: '{{ route('getCompanyShippingDetails') }}',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        shipping_id: shipping_id,
        '_token': "{{ csrf_token() }}"
      },
      success: function(result) {
        // $("#getCompanyBillDetails").html(result.billto);
        $('#getCompanyShipDetails').html(result.shipto);
        // $("#po_number").val(result.po_number);

      },
      error: function(data) {

        console.log(data);
        alert(data);
      }
    });
    calculateTotalAmount();
  }

  function getVendorShippingDetails() {
    var vendor_id = document.getElementById('vendor_id').value;
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: '{{ route('getVendorShippingDetails') }}',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        vendor_id: vendor_id,
        '_token': "{{ csrf_token() }}"
      },
      success: function(result) {
        // $("#getCompanyBillDetails").html(result.billto);
        $('#getCompanyShipDetails').html(result.shipto);
        // $("#po_number").val(result.po_number);

      },
      error: function(data) {

        console.log(data);
        alert(data);
      }
    });
    // calculateTotalAmount();
  }
</script>
<script>
  $(document).ready(function() {
    $(document).on('change', '.repeater-wrapper .item_name', function() {
      var itemId = $(this).val();
      var itemName = $(this).attr('name');
      var modifiedItemName = itemName.replace(/\[item_name]/, '');
      if (itemId) {
        $.ajax({
          url: "{{ route('fetchItemData') }}",
          type: 'POST',
          data: {
            item_id: itemId,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            // Populate other fields based on the response within this box
            // Example:
            console.log(response.uom);
            $('input[name="' + modifiedItemName + '[rate]"]').val(response
              .rate);
            $('select[name="' + modifiedItemName + '[uom]"]').val(response.uom);
            $('select[name="' + modifiedItemName + '[tax]"]').val(response
              .gst_rate);
            calculateItemAmount($('select[name="' + modifiedItemName +
              '[tax]"]'));
          }
        });
        calculateTotalAmount();
      }
    });
  });
</script>

<script>
  function toggleTableVisibility() {
    var CompanyShipping = document.getElementById('CompanyShipping');
    // var GetCompanyShipping = document.getElementById("getCompanyShipDetails");

    var VendorShipping = document.getElementById('VendorShipping');
    var checkbox = document.getElementById('ToSupplier');
    if (checkbox.checked) {
      CompanyShipping.style.display = 'None'; // Hide the table when checkbox is checked
      // GetCompanyShipping.style.display = "None";

      VendorShipping.style.display = 'Block';
    } else {
      CompanyShipping.style.display = 'Block'; // Hide the table when checkbox is checked
      // GetCompanyShipping.style.display = "Block";

      VendorShipping.style.display = 'None';
    }
  }
</script>
