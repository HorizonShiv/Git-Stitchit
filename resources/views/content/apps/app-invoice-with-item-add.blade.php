@extends('layouts/layoutMaster')

@section('title', 'Add - Invoice')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/toastr/toastr.css')}}"/>
@endsection

@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-invoice.css')}}"/>
  <style>
    #poHeader {
      font-weight: 800;
      margin-bottom: 15px;
      font-size: 1.2rem;
      margin-left: 5px;
    }
  </style>
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/toastr/toastr.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/offcanvas-send-invoice.js')}}"></script>
  <script src="{{asset('assets/js/app-invoice-add.js')}}"></script>
  <script src="{{asset('assets/js/forms-selects.js')}}"></script>
  <script src="{{asset('assets/js/forms-tagify.js')}}"></script>
  <script src="{{asset('assets/js/forms-typeahead.js')}}"></script>
@endsection

@section('content')
  <form id="formid" class="source-item" action="{{ route('app-invoice-with-item-store') }}"
        method="post" enctype="multipart/form-data">
    @csrf
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
                Invoice Create
              </span>
                </div>
                @php
                  use Illuminate\Support\Facades\Auth;
                    if((Auth::user()->role == 'vendor')){
                    $users = App\Models\User::where('role',"vendor")->where('id',Auth::user()->id)->where('is_active',1)->get();
                    }else{
                        $users = App\Models\User::where('role',"vendor")->where('is_active',1)->get();
                    }
                @endphp
                <div class="mb-6 md-6 col-6">
                  <label class="form-label" for="form-repeater-1-1">Vendor</label>
                  <select id="user_id" name="user_id" onchange="getVendorDetails();"
                          class="select2 form-select" data-placeholder="Select Vendor">
                    <option value="">Select Vendor</option>
                    @foreach($users as $user)
                      @if(isset($poItems) && !$poItems->isEmpty())
                        <option
                          value="{{ $user->id }}" @if($poItems[0]->Po->user_id == $user->id) {{ "selected" }} @endif>{{ $user->company_name }}</option>
                      @else
                        <option value="{{ $user->id }}">{{ $user->company_name }}</option>
                      @endif
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
                    <span class="h5 text-capitalize mb-0 text-nowrap">Invoice Number : </span>
                  </dt>
                  <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                    <div class="input-group input-group-merge disabled w-px-150">
                      <span class="input-group-text">#</span>
                      <input type="text" class="form-control" id="invoice_no" autofocus name="invoice_no"/>
                    </div>
                  </dd>
                  <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end ps-0">
                    <span class="h5 text-capitalize mb-0 text-nowrap">Challane Number : </span>
                  </dt>
                  <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                    <div class="input-group input-group-merge disabled w-px-150">
                      <span class="input-group-text">#</span>
                      <input type="text" class="form-control" id="challane_no" name="challane_no"/>
                    </div>
                  </dd>
                  <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end ps-0">
                    <span class="fw-normal">Date:</span>
                  </dt>
                  <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                    <input type="date" class="form-control w-px-150 date-picker" id="invoice_date" name="invoice_date"
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
                    @if(isset($poItems) && !$poItems->isEmpty())
                      <option
                        value="{{ $company->id }}" @if($poItems[0]->Po->company_id == $company->id) {{ "selected" }} @endif>{{ $company->b_name }}</option>
                    @else
                      <option value="{{ $company->id }}">{{ $company->b_name }}</option>
                    @endif
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
              @if(isset($poItems))
                @foreach($poItems as $poItem)

                  @php
                    @endphp
                  <div class="repeater-wrapper pt-0 pt-md-4" data-repeater-item>
                    <div class="d-flex border rounded position-relative pe-0">
                      <div class="item row w-100 p-3" id="items">
                        <div class="col-12" id="poHeader">{{ $poItem->po->po_no }}</div>
                        <div class="col-md-4 col-12 mb-md-0 mb-3">
                          <p class="mb-2 repeater-title">Item</p>
                          <input type="text" readonly value="{{ $poItem->item_name }}" name="item_name"
                                 class="form-control mb-3" placeholder="item name"/>
                          <input type="hidden" value="{{ $poItem->id }}" name="po_item_id"/>
                          <textarea class="form-control" name="item_description" rows="2"
                                    placeholder="Item Information">{{ $poItem->item_description }}</textarea>
                        </div>
                        <div class="col-md-2 col-12 mb-md-0 mb-3">
                          <p class="mb-2 repeater-title">Cost</p>
                          <input type="number" step="any" value="{{ $poItem->rate }}"
                                 onchange="calculateItemAmount(this)"
                                 name="rate"
                                 class="rate form-control" placeholder="00"/>
                          <span>HSN</span>
                          <input type="number" value="{{ $poItem->hsn }}" name="hsn" class="form-control mb-1"
                                 placeholder="hsn"/>
                        </div>
                        <div class="col-md-2 col-12 mb-md-0 mb-3">
                          <p class="mb-2 repeater-title">Qty</p>
                          <input type="number" value="{{ $poItem->qty }}" onchange="calculateItemAmount(this)"
                                 name="qty"
                                 class="quantity form-control mb-1" placeholder="qty"/>
                          <soan>Amount</soan>
                          <input type="text" value="{{ ($poItem->rate*$poItem->qty) }}" readonly
                                 class="form-control itemAmountWithRateQty"/>
                        </div>
                        <div class="col-md-1 col-12 mb-md-0 mb-3">
                          <p class="mb-2 repeater-title">Discount Amt</p>
                          <input type="number" step="any" value="0" onchange="calculateItemAmount(this)" name="discount"
                                 class="discount form-control" placeholder="discount"/>
                        </div>
                        <div class="col-md-1 col-12 mb-md-0 mb-3">
                          <p class="mb-2 repeater-title">Tax</p>
                          <select name="tax" onchange="calculateItemAmount(this)" class="tax form-select mb-1">
                            <option value="{{ $poItem->tax_percentage }}">{{ $poItem->tax_percentage }}</option>
                            <option value="0">0%</option>
                            <option value="5">5%</option>
                            <option value="10">10%</option>
                            <option value="12">12%</option>
                            <option value="18">18%</option>
                            <option value="24">24%</option>
                            <option value="28">28%</option>
                          </select>
                          <span>Tax Amt</span>
                          <input type="text" readonly value="{{ $poItem->tax }}"
                                 class="form-control taxValue" name="taxValue"/>
                        </div>
                        <div class="col-md-2 col-12 pe-0">
                          <p class="mb-2 repeater-title">Total</p>

                          <input type="number" readonly step="any" name="amount" value="{{ $poItem->amount }}"
                                 class="form-control itemAmount"
                                 placeholder="amount"/>
                          <span>UOM</span>
                          <select name="uom" class="select2 form-select" required>
                            <option value="{{ $poItem->uom }}">{{ $poItem->uom }}</option>
                            <option value="">Select UMO</option>
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
                      </div>
                      <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                        <i class="ti ti-x cursor-pointer" data-repeater-delete></i>
                      </div>
                    </div>
                  </div>
                @endforeach
              @else
                <div class="repeater-wrapper pt-0 pt-md-4" data-repeater-item>
                  <div class="d-flex border rounded position-relative pe-0">
                    <div class="item row w-100 p-3" id="items">
                      <div class="col-md-4 col-12 mb-md-0 mb-3">
                        <p class="mb-2 repeater-title">Item</p>
                        <input type="text" name="item_name" class="form-control mb-3" placeholder="item name"/>
                        <textarea class="form-control" name="item_description" rows="2"
                                  placeholder="Item Information"></textarea>
                      </div>
                      <div class="col-md-2 col-12 mb-md-0 mb-3">
                        <p class="mb-2 repeater-title">Cost</p>
                        <input type="number" step="any" value="0" onchange="calculateItemAmount(this)" name="rate"
                               class="rate form-control" placeholder="00"/>
                        <span>HSN</span>
                        <input type="number" required name="hsn" class="form-control mb-1" placeholder="hsn"/>
                      </div>
                      <div class="col-md-2 col-12 mb-md-0 mb-3">
                        <p class="mb-2 repeater-title">Qty</p>
                        <input type="number" value="0" onchange="calculateItemAmount(this)" name="qty"
                               class="quantity form-control  mb-1" placeholder="qty"/>
                        <soan>Amount</soan>
                        <input type="text" readonly class="form-control itemAmountWithRateQty"/>
                      </div>
                      <div class="col-md-1 col-12 mb-md-0 mb-3">
                        <p class="mb-2 repeater-title">Discount Amt</p>
                        <input type="number" step="any" value="0" onchange="calculateItemAmount(this)" name="discount"
                               class="discount form-control" placeholder="discount"/>
                      </div>
                      <div class="col-md-1 col-12 mb-md-0 mb-3">
                        <p class="mb-2 repeater-title">Tax</p>
                        <select name="tax" onchange="calculateItemAmount(this)" class="tax form-select mb-1">
                          <option value="0">0%</option>
                          <option value="5">5%</option>
                          <option value="10">10%</option>
                          <option value="12">12%</option>
                          <option value="18">18%</option>
                          <option value="24">24%</option>
                          <option value="28">28%</option>
                        </select>
                        <span>Tax Amt</span>
                        <input type="text" readonly class="form-control taxValue" name="taxValue" id="taxValue"/>
                      </div>
                      <div class="col-md-2 col-12 pe-0">
                        <p class="mb-2 repeater-title">Total</p>

                        <input type="number" readonly step="any" name="amount" class="form-control itemAmount"
                               placeholder="amount"/>
                        <span>UOM</span>
                        <select name="uom" class="select2 form-select">
                          <option value="">Select UMO</option>
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
                    </div>
                    <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                      <i class="ti ti-x cursor-pointer" data-repeater-delete></i>
                    </div>
                  </div>
                </div>

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
                <label class="form-label" for="pancard_number">Invoice Upload</label>
                <input type="file" name="invoice_file" id="invoice_file" class="mt-1 mb-4 form-control">
                <div class="row mt-5 t_item">
                  <div class="col-md-4 mb-md-0 mb-3">
                    <label>Transportation Charge</label>
                    <input type="number" onchange="calculateTransportationTax(this)" step="any" name="t_charge"
                           id="t_charge"
                           class="t_charge form-control"
                           placeholder=""/>
                  </div>
                  <div class="col-md-4 mb-md-0 mb-3">
                    <label>Tax</label>
                    <select name="t_tax" id="t_tax" onchange="calculateTransportationTax(this)"
                            class="t_tax select2 form-select">
                      <option value="0">0%</option>
                      <option value="5">5%</option>
                      <option value="10">10%</option>
                      <option value="12">12%</option>
                      <option value="18">18%</option>
                      <option value="24">24%</option>
                      <option value="28">28%</option>
                    </select>
                  </div>
                  <div class="col-md-4 mb-md-0 mb-3">
                    <label>Transportation Amt</label>
                    <input type="number" readonly step="any" name="t_amount" id="t_amount"
                           class="t_amount form-control"
                           placeholder=""/>
                  </div>
                </div>

              </div>
              <div class="col-md-6 d-flex justify-content-end">
                <div class="invoice-calculations">
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-150">Subtotal Amount:</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="number"
                             value="@php if(isset($poItems)){ echo array_sum(array_column($poItems->toarray(), "amount")); }else{ echo 0; } @endphp"
                             id="sub_total_amount" readonly step="any" name="sub_total_amount"
                             class="sub_total_amount form-control w-px-150"
                             placeholder=""/>
                    </dd>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-150">Discount Amount:</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input
                        value="@php if(isset($poItems)){ echo $poItems[0]->Po->discount_amount; }else{ echo 0; } @endphp"
                        type="number" name="discount_amount" step="any" readonly
                        class="discount_amount form-control w-px-150"
                        placeholder=""/>
                    </dd>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-150">IGST Amount :</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input
                        value="@php if(isset($poItems)){ echo $poItems[0]->Po->igst_amount; }else{ echo 0; } @endphp"
                        type="number" name="igst_amount" step="any" readonly
                        class="igst_amount form-control w-px-150"
                        placeholder=""/>
                    </dd>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-150">CGST Amount :</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input
                        value="@php if(isset($poItems)){ echo $poItems[0]->Po->cgst_amount; }else{ echo 0; } @endphp"
                        type="number" name="cgst_amount" step="any" readonly
                        class="cgst_amount form-control w-px-150"
                        placeholder=""/>
                    </dd>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-150">SGST Amount :</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="number" readonly
                             value="@php if(isset($poItems)){ echo $poItems[0]->Po->sgst_amount; }else{ echo 0; } @endphp"
                             name="sgst_amount" step="any"
                             class="sgst_amount form-control w-px-150" placeholder=""/>
                    </dd>
                  </div>
                  <hr/>
                  <div class="d-flex justify-content-between">
                    <span class="w-px-150">Total Amount:</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      {{--                      {{ dd($poItems->toarray()) }}--}}
                      <input type="number" readonly
                             value="@php if(isset($poItems)){ echo array_sum(array_column($poItems->toarray(), "amount")); }else{ echo 0; } @endphp"
                             name="invoice_amount" id="invoice_amount" step="any"
                             class="invoice_amount form-control w-px-150"
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
                  <textarea class="form-control" rows="2" id="note" name="note" placeholder="Invoice note"></textarea>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  @if(isset($poItems))
  $(function () {
    getVendorDetails();
    getCompanyDetails();
  });

  @endif

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
      $("#invoice_amount").val(t_amount + parseFloat(totalAmount));

      const itemAmountWithRateQty = document.querySelectorAll('.itemAmountWithRateQty');
      let itemAmountWithRateQtyValue = 0;
      for (let i = 0; i < itemAmountWithRateQty.length; i++) {
        itemAmountWithRateQtyValue += parseFloat(itemAmountWithRateQty[i].value) || 0;
      }
      $("#sub_total_amount").val(t_charge + parseFloat(itemAmountWithRateQtyValue));

      const taxValue = document.querySelectorAll('.taxValue');
      let igst_amount = 0;
      for (let i = 0; i < taxValue.length; i++) {
        igst_amount += parseFloat(taxValue[i].value) || 0;
      }

      let c_gst_two = document.getElementById("c_gst_two").value;
      let v_gst_two = document.getElementById("v_gst_two").value;
      if (c_gst_two === v_gst_two) {
        $(".cgst_amount").val((igst_amount + parseFloat(t_taxValue)) / 2);
        $(".sgst_amount").val((igst_amount + parseFloat(t_taxValue)) / 2);
        $(".igst_amount").val(0);
      } else {
        $(".igst_amount").val(igst_amount + parseFloat(t_taxValue));
        $(".cgst_amount").val(0);
        $(".sgst_amount").val(0);
      }
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


    let c_gst_two = document.getElementById("c_gst_two").value;
    let v_gst_two = document.getElementById("v_gst_two").value;
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

    $(".invoice_amount").val(totalAmount + t_amount);
    $(".discount_amount").val(discount_amount);
  }


  function submitBtn(e) {
    let invoice_no = document.forms["formid"]["invoice_no"].value;
    let challane_no = document.forms["formid"]["challane_no"].value;
    let invoice_date = document.forms["formid"]["invoice_date"].value;
    if (invoice_no === "") {
      toastr.error("Invoice Number must be filled out");
      document.getElementById("invoice_no").style.border = "1px solid red";
      return false;
    }
    if (challane_no === "") {
      toastr.error("challane Number must be filled out");
      document.getElementById("challane_no").style.border = "1px solid red";
      return false;
    } else if (invoice_date === "") {
      toastr.error("Invoice Date must be filled out");
      document.getElementById("invoice_date").style.border = "1px solid red";
      return false;
    } else {
      $("#formid")[0].submit();
    }
  }

  function getVendorDetails() {
      @if(isset($grnItems) && !$grnItems->isEmpty())
    var user_id = '{{ $grnItems[0]->PoItem->Po->user_id }}';
      @else
    var user_id = document.getElementById('user_id').value;
    @endif
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
  }

  function getCompanyDetails() {

      @if(isset($grnItems) && !$grnItems->isEmpty())
    var company_id = '{{ $grnItems[0]->PoItem->Po->company_id }}';
      @else
    var company_id = document.getElementById('company_id').value;
    @endif
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
  }
</script>
