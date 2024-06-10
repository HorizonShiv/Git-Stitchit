@extends('layouts/layoutMaster')

@section('title', 'Update - PO')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}"/>
@endsection

@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-invoice.css')}}"/>
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/offcanvas-send-invoice.js')}}"></script>
  <script src="{{asset('assets/js/app-invoice-add.js')}}"></script>
  <script src="{{asset('assets/js/forms-selects.js')}}"></script>
  <script src="{{asset('assets/js/forms-tagify.js')}}"></script>
  <script src="{{asset('assets/js/forms-typeahead.js')}}"></script>
@endsection


@section('content')
  <form id="formid" method="post" class="source-item" action="{{ route('app-po-update',$po->id) }}"
        enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row invoice-add">
      <!-- Invoice Add-->
      <div class="col-lg-12 col-12 mb-lg-0 mb-4">
        <div class="card invoice-preview-card">
          <div class="card-body">
            <div class="row m-sm-4 m-0">
              <div class="col-md-7 mb-md-0 mb-4 ps-0">
                <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                  @include('_partials.macros',["height"=>22,"withbg"=>''])
                  <span class="app-brand-text fw-bold fs-4">
               PO Update
              </span>
                </div>
                <div class="mb-6 md-6 col-6">
                  <label class="form-label" for="form-repeater-1-1">Vendor</label>
                  <select id="user_id" name="user_id" onchange="getVendorDetails();"
                          class="select2 form-select" data-placeholder="Select Vendor">
                    <option value="">Select Vendor</option>
                    @foreach(App\Models\User::where('role',"vendor")->get() as $user)
                      <option
                        value="{{ $user->id }}" @if($po->user_id == $user->id){{ "selected" }}@endif>{{ $user->company_name }}</option>
                    @endforeach
                  </select>
                </div>
                <br>
                <div id="getVendorDetails">
                </div>
              </div>

              <div class="col-md-5">
                <dl class="row mb-2">
                  <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end ps-0">
                    <span class="h4 text-capitalize mb-0 text-nowrap">PO</span>
                  </dt>
                  <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                    <div class="input-group input-group-merge disabled w-px-150">
                      <span class="input-group-text">#</span>
                      <input type="text" autofocus readonly class="form-control" id="po_number" value="{{ $po->po_no }}"
                             name="po_number"/>
                    </div>
                  </dd>
                  <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end ps-0">
                    <span class="fw-normal">Date:</span>
                  </dt>
                  <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                    <input type="date" value="{{  $po->po_date }}" class="form-control w-px-150 date-picker"
                           name="po_date"
                           placeholder="YYYY-MM-DD"/>
                  </dd>
                </dl>
              </div>
            </div>

            <hr class="my-3 mx-n4"/>

            <div class="row p-sm-4 p-0">
              <div class="mb-3 col-12">
                <label class="form-label" for="form-repeater-1-1">Company</label>
                <select id="company_id" name="company_id" onchange="getCompanyDetails();"
                        class="select2 form-select" data-placeholder="Select Company">
                  <option value="">Select company</option>
                  @foreach(App\Models\Company::all() as $company)
                    <option
                      value="{{ $company->id }}" @if($po->company_id == $company->id) {{ "selected" }} @endif>{{ $company->b_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 col-sm-5 col-12 mb-sm-0 mb-4" id="getCompanyBillDetails">
              </div>
              <div class="col-md-6 col-sm-7" id="getCompanyShipDetails">
              </div>
            </div>

            <hr class="my-3 mx-n4"/>


            <div class="mb-3" data-repeater-list="group-a">
              @if(isset($po->PoItem))
                @foreach($po->PoItem as $poItem)
                  <div class="repeater-wrapper pt-0 pt-md-4" data-repeater-item>
                    <div class="d-flex border rounded position-relative pe-0">
                      <div class="item row w-100 p-3" id="items">
                        <div class="col-md-4 col-12 mb-md-0 mb-3">
                          <p class="mb-2 repeater-title">Item</p>
                          <input type="hidden" name="po_item_id" value="{{ $poItem->id }}"/>
                          <input type="text" name="item_name" value="{{ $poItem->item_name }}" class="form-control mb-3"
                                 placeholder="item name"/>
                          <textarea class="form-control" name="item_description" rows="2"
                                    placeholder="Item Information">{{ $poItem->item_description }}</textarea>
                        </div>
                        <div class="col-md-1 col-12 mb-md-0 mb-3">
                          <p class="mb-2 repeater-title">HSN</p>
                          <textarea rows="4" type="text" name="hsn" class="form-control mb-1"
                                    placeholder="hsn">{{ $poItem->hsn }}</textarea>

                        </div>
                        <div class="col-md-2 col-12 mb-md-0 mb-3">
                          <p class="mb-2 repeater-title">Cost</p>
                          <input type="number" value="{{ $poItem->rate }}" onchange="calculateItemAmount(this)"
                                 name="rate"
                                 class="rate form-control invoice-item-price" placeholder="00"/>
                          <span>UOM</span>
                          <select name="uom" class="select2 form-select">
                            <option value="{{ $poItem->uom }}">{{ $poItem->uom }}</option>
                            <option value="">select umo</option>
                            <option value="MTRS">MTRS</option>
                            <option value="PIECES">PIECES</option>
                            <option value="TEX">TEX</option>
                            <option value="MM THICKNESS">MM THICKNESS</option>
                            <option value="INCHES">INCHES</option>
                            <option value="CONE">CONE</option>
                            <option value="TUBE">TUBE</option>
                            <option value="KGS">KGS</option>
                            <option value="ROLL">ROLL</option>
                            <option value="PKTS">PKTS</option>
                            <option value="GROSS">GROSS</option>
                            <option value="SET">SET</option>
                            <option value="YARDS">YARDS</option>
                            <option value="LTR">LTR</option>
                          </select>
                        </div>
                        <div class="col-md-2 col-12 mb-md-0 mb-3">
                          <p class="mb-2 repeater-title">Qty</p>
                          <input type="number" value="{{ $poItem->qty }}" onchange="calculateItemAmount(this)"
                                 name="qty"
                                 class="quantity form-control invoice-item-qty mb-1" placeholder="qty"/>
                          <soan>Amount</soan>
                          <input type="text" value="{{ $poItem->without_tax_amount }}" readonly
                                 name="itemAmountWithRateQty"
                                 class="itemAmountWithRateQty form-control mb-1"/>
                        </div>
                        <div class="col-md-1 col-12 mb-md-0 mb-3">
                          <p class="mb-2 repeater-title">Tax</p>
                          <select name="tax" onchange="calculateItemAmount(this)" class="tax form-select mb-1">
                            <option value="{{ $poItem->tax_percentage }}">{{ $poItem->tax_percentage }}%</option>
                            <option value="0">0%</option>
                            <option value="5">5%</option>
                            <option value="10">10%</option>
                            <option value="12">12%</option>
                            <option value="18">18%</option>
                            <option value="24">24%</option>
                            <option value="28">28%</option>
                          </select>
                          <span>Tax Amt</span>
                          <input type="text" name="taxValue" value="{{ $poItem->tax }}" readonly
                                 class="form-control taxValue"/>
                        </div>
                        <div class="col-md-2 col-12 pe-0">
                          <p class="mb-2 repeater-title">Total</p>
                          <input type="number" readonly step="any" value="{{ $poItem->amount }}" name="amount"
                                 class="form-control itemAmount"
                                 placeholder="amount"/>
                          <span>Excess I/W%</span>
                          <input type="hidden" onchange="calculateItemAmount(this)" name="discount"
                                 class="discount form-control"/>
                          <input type="text" name="excessInwardAllowedPercent"
                                 value="{{ $poItem->excessInwardAllowedPercent }}"
                                 class="excessInwardAllowedPercent form-control"/>

                        </div>
                      </div>
                      <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                        <i class="ti ti-x cursor-pointer" data-repeater-delete></i>
                      </div>
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
            <div class="row pb-4">
              <div class="col-12">
                <button type="button" class="btn btn-primary" data-repeater-create>Add Item</button>
              </div>
            </div>


            <hr class="my-3 mx-n4"/>

            <div class="row p-0 p-sm-4">
              <div class="col-md-6 mb-md-0 mb-3">
                <label class="form-label" for="pancard_number">Document File</label>
                <input type="file" name="po_file" id="po_file" class="mt-1 mb-4 form-control">
                @if(!empty($po->po_file))
                  <p class="mt-2"><a target="_blank"
                                     href="{{ url('po/'.$po->id.'/'.$po->po_file) }}">{{ $po->po_file }}</a></p>
                @endif
                <div class="row mt-5 t_item">
                  <div class="col-md-6 col-lg-4 mb-md-0 mb-8">
                    <label>Expected Delivery Date</label>
                    <input type="date" name="d_date"
                           id="d_date"
                           value="{{ $po->d_date }}"
                           class="form-control w-px-150 date-picker"
                           placeholder="YYYY-MM-DD"/>
                  </div>
                  <input type="hidden" onchange="calculateTransportationTax(this)" step="any" name="t_charge"
                         id="t_charge"
                         value="0"
                         class="t_charge form-control"
                         placeholder=""/>
                  <input type="hidden" value="0" name="t_tax" id="t_tax" onchange="calculateTransportationTax(this)"
                         class="t_tax">
                  <input type="hidden" readonly step="any" value="0" name="t_amount" id="t_amount"
                         class="t_amount form-control"
                         placeholder=""/>
                </div>

              </div>
              <div class="col-md-6 d-flex justify-content-end">
                <div class="invoice-calculations">
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-150">Subtotal Amount:</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="number" readonly step="any" name="sub_total_amount"
                             class="sub_total_amount form-control w-px-150" value="{{ $po->sub_total_amount }}"
                             placeholder=""/>
                    </dd>
                  </div>
                  <div class="d-flex justify-content-between mb-2" hidden>
                    <span class="w-px-150" hidden>Discount Amount:</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="hidden" name="discount_amount" step="any"
                             class="discount_amount form-control w-px-150"
                             placeholder=""/>
                    </dd>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-150">IGST Amount :</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="number" name="igst_amount" id="igst_amount" step="any"
                             class="igst_amount form-control w-px-150" value="{{ $po->igst_amount }}"
                             placeholder=""/>
                    </dd>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-150">CGST Amount :</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="number" name="cgst_amount" id="cgst_amount" step="any"
                             class="cgst_amount form-control w-px-150" value="{{ $po->cgst_amount }}"
                             placeholder=""/>
                    </dd>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-150">SGST Amount :</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="number" name="sgst_amount" id="sgst_amount" step="any"
                             class="sgst_amount form-control w-px-150" placeholder="" value="{{ $po->sgst_amount }}"/>
                    </dd>
                  </div>
                  <hr/>
                  <div class="d-flex justify-content-between">
                    <span class="w-px-150">Total Amount:</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="number" name="po_amount" id="po_amount" value="{{ $po->po_amount }}" step="any"
                             class="po_amount form-control w-px-150"
                             placeholder=""/>
                    </dd>
                  </div>
                </div>
              </div>
            </div>

            <hr class="my-3 mx-n4"/>

            <div class="row px-0 px-sm-4">
              <div class="col-12">
                <div class="mb-3">
                  <label for="note" class="form-label fw-medium">Note:</label>
                  <textarea class="form-control" rows="2" id="note" name="note"
                            placeholder="Note">{{ $po->note }}</textarea>
                </div>
              </div>
              <div class="col-lg-3 col-md-12 col-sm-12">
                <button type="submit" onclick="submitBtn();" class="btn btn-primary d-grid w-100">Save</button>
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
  $(function () {
    getVendorDetails();
    getCompanyDetails();
  });

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
    //const t_taxValue = t_item.querySelector('.taxValue').value = (t_charge) * (t_tax / 100);
    const t_taxValue = (t_charge) * (t_tax / 100);
    const t_amount = (t_charge) + t_taxValue;

    const itemAmountElement = t_item.querySelector('.t_amount');
    if (itemAmountElement) {
      itemAmountElement.value = t_amount;
      const itemAmounts = document.querySelectorAll('.itemAmount');
      let totalAmount = 0;
      for (let i = 0; i < itemAmounts.length; i++) {
        totalAmount += parseFloat(itemAmounts[i].value) || 0;
      }
      $("#po_amount").val(t_amount + parseFloat(totalAmount));
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
    const taxValue = item.querySelector('.taxValue').value = ((quantity * rate) - discount) * (tax / 100);
    const itemAmount = (quantity * rate) + taxValue - discount;

    const itemAmountElement = item.querySelector('.itemAmount');
    if (itemAmountElement) {
      itemAmountElement.value = itemAmount;
    } else {
      console.log('.itemAmount element not found in the current item.');
    }
    item.querySelector('.itemAmountWithRateQty').value = (quantity * rate);
    calculateTotalAmount();
  }


  function calculateTotalAmount() {
    const itemAmounts = document.querySelectorAll('.itemAmount');
    let totalAmount = 0;
    for (let i = 0; i < itemAmounts.length; i++) {
      totalAmount += parseFloat(itemAmounts[i].value) || 0;
    }

    const itemAmountWithRateQty = document.querySelectorAll('.itemAmountWithRateQty');
    let itemAmountWithRateQtyValue = 0;
    for (let i = 0; i < itemAmountWithRateQty.length; i++) {
      itemAmountWithRateQtyValue += parseFloat(itemAmountWithRateQty[i].value) || 0;
    }

    const discount = document.querySelectorAll('.discount');
    let discount_amount = 0;
    for (let i = 0; i < discount.length; i++) {
      discount_amount += parseFloat(discount[i].value) || 0;
    }

    const taxValue = document.querySelectorAll('.taxValue');
    let igst_amount = 0;
    for (let i = 0; i < taxValue.length; i++) {
      igst_amount += parseFloat(taxValue[i].value) || 0;
    }


    let c_gst_two = 0;
    const cgsttwoInput = document.getElementById('.c_gst_two');
    if (cgsttwoInput) {
      c_gst_two = parseFloat(cgsttwoInput.value) || 0;
    }

    let v_gst_two = 0;
    const vgsttwoInput = document.getElementById('.v_gst_two');
    if (vgsttwoInput) {
      v_gst_two = parseFloat(vgsttwoInput.value) || 0;
    }

    if (c_gst_two === v_gst_two) {
      $(".cgst_amount").val(igst_amount / 2);
      $(".sgst_amount").val(igst_amount / 2);
      $(".igst_amount").val(0);
    } else {
      $(".igst_amount").val(igst_amount);
      $(".cgst_amount").val(0);
      $(".sgst_amount").val(0);
    }
    $(".sub_total_amount").val(itemAmountWithRateQtyValue);
    let t_charge = $("#t_charge").val();
    const t_taxValue = (t_charge) * ($("#t_tax").val() / 100);
    const t_amount = parseInt(t_charge) + t_taxValue || 0;

    $(".po_amount").val(totalAmount + t_amount);
    $(".discount_amount").val(discount_amount);
  }


  function submitBtn(e) {
    $("#formid")[0].submit();
  }

  function getVendorDetails() {

    var user_id = document.getElementById('user_id').value;
    $.ajax({
      type: 'POST',
      url: '{{route('getVendorDetails')}}',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {user_id: user_id, "_token": "{{ csrf_token() }}"},
      success: function (result) {
        $("#getVendorDetails").html(result);
      },
      error: function (data) {
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
      url: '{{route('getCompanyDetails')}}',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {company_id: company_id, "_token": "{{ csrf_token() }}"},
      success: function (result) {
        $("#getCompanyBillDetails").html(result.billto);
        $("#getCompanyShipDetails").html(result.shipto);
      },
      error: function (data) {
        console.log(data);
        alert(data);
      }
    });
    calculateTotalAmount();
  }
</script>
