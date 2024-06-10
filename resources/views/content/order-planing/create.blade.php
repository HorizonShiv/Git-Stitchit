@extends('layouts/layoutMaster')

@section('title', 'Job Order Planing Add')

@section('vendor-style')

  <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
  <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/rateyo/rateyo.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/wizard-ex-checkout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />

  <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

  <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>

  <script src="{{ asset('assets/js/config.js') }}"></script>
@endsection

@section('vendor-script')
  <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
  <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/rateyo/rateyo.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>

  <!-- Main JS -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <!-- Page JS -->

  <script src="{{ asset('assets/js/modal-add-new-address.js') }}"></script>
  <script src="{{ asset('assets/js/wizard-ex-checkout.js') }}"></script>

@endsection

@section('page-script')
  <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
  <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection


@section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light float-left">Order Planing/</span> Add
  </h4>

  <form action="{{ route('order-planning.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
      <div class="col-12">


        <div class="card">
          {{-- <h5 class="card-header">Applicable Categories</h5> --}}
          <div class="card-body">

            <div class="content">

              <div class="content-header mb-4">
                <h4 class="mb-1">Primary Information</h4>
              </div>
              <div class="row g-3">

                <div class="col-md-3">
                  <label class="form-label" for="JobOrderDate">Date</label>
                  <input type="date" class="form-control date-picker" id="JobOrderDate"
                         name="JobOrderDate" placeholder="YYYY-MM-DD" value="{{ date('Y-m-d') }}" />
                </div>

                <div class="col-md-3">
                  <label class="form-label" for="OrderId">Sale Order No.</label>
                  <input type="text" class="form-control date-picker" id="saleOrder" name="saleOrder"
                         placeholder="Sale Order" value="{{ $salesOrderDetails->sales_order_no }}"
                         readonly />
                </div>
                <div class="col-md-3">
                  <label class="form-label" for="StyleId">Style No./Customer Style No.</label>
                  <select id="StyleNo" name="StyleNo" class="select2 select21 form-select"
                          data-allow-clear="true" data-placeholder="Select Style"
                          onchange="getStyleDetails()">
                    <option value="">Select</option>
                    @if (!empty($planingOrders))
                      <option selected value="{{ $planingOrders->sales_order_style_id }}">
                        {{ $planingOrders->SalesOrderStyleInfo[0]->StyleMaster->style_no ?? '' }}
                        / {{ $planingOrders->SalesOrderStyleInfo[0]->customer_style_no ?? '' }}
                      </option>
                    @else
                      @foreach ($salesOrderStyleInfos as $salesOrderStyleInfo)
                        <option
                          @if (!empty($planingOrders) && $planingOrders->sales_order_style_id == $salesOrderStyleInfo->id)
                            {{ 'selected' }}
                          @endif
                          value="{{ $salesOrderStyleInfo->id }}">
                          {{ $salesOrderStyleInfo->StyleMaster->style_no }}
                          / {{ $salesOrderStyleInfo->customer_style_no }}</option>
                      @endforeach
                    @endif


                  </select>
                </div>
                <div class="col-md-3 mb-4">
                  <label for="select2Primary" class="form-label">Total Qty</label>
                  <div class="select2-primary">
                    <input type="text" class="form-control" id="TotalQty" name="TotalQty"
                           placeholder="Qty" />
                  </div>
                </div>


              </div>

              <div>
                <!-- Invoice List Widget -->

                <div class="mb-4" id="showStyleDetails">
                  <div class="card-widget-separator-wrapper">
                    <div class="card-body card-widget-separator">
                      <div class="row gy-4 gy-sm-1">
                        <div class="col-sm-6 col-lg-3">
                          <div
                            class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                            <div>
                              <p class="mb-0  font-weight-bold">Total Piceses</p>

                            </div>
                            <span class="avatar me-sm-4">
                                                            <div class="avatar me-2"><span
                                                                class="avatar-initial rounded-circle bg-label-success">0</span>
                                                            </div>
                                                        </span>
                          </div>
                          <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                          <div
                            class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                            <div>
                              <p class="mb-0 font-weight-bold">Category</p>
                            </div>
                            <span class="me-sm-4 btn-sm btn btn-outline-primary">- </span>
                          </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                          <div
                            class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                            <div>
                              <p class="mb-0 font-weight-bold">Fit</p>

                            </div>
                            <span class="me-sm-4 btn btn-outline-info btn-sm">- </span>
                          </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                          <div
                            class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                            <div>
                              <p class="mb-0 font-weight-bold">Discription</p>

                            </div>
                            <span class=" me-sm-4">
                                                            <p class="mb-0">-</p>
                                                        </span>
                          </div>
                        </div>


                        <div class="col-sm-6 col-lg-3">
                          <div
                            class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                            <div>
                              <p class="mb-0 font-weight-bold">Colors</p>

                            </div>
                            <span class="avatar me-sm-4">
                                                            <div class="avatar me-2"><span
                                                                class="avatar-initial rounded-circle bg-label-success">0</span>
                                                            </div>
                                                        </span>
                          </div>
                          <hr class="d-none d-sm-block d-lg-none">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                          <div
                            class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                            <div>
                              <p class="mb-0 font-weight-bold">Sub-Category</p>

                            </div>
                            <span class="me-sm-4 btn btn-outline-primary btn-sm">- </span>
                          </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                          <div
                            class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                            <div>

                              <p class="mb-0 font-weight-bold">Customer Style No.</p>

                            </div>
                            <span class="me-sm-4 btn btn-outline-info btn-sm">- </span>
                          </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                          <div
                            class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                            <div>

                              <p class="mb-0 font-weight-bold">Ship Date</p>

                            </div>
                            <span class="me-lg-4">-</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <h4 class="mt-5">
      <span class="text-muted fw-light float-left">BOM Sheet/</span> Add
    </h4>
    <div class="row g-3">
      <div
        class="col-@if ($actionType == 'edit') {{ '12' }}@else{{ '12' }} @endif col-lg-@if ($actionType == 'edit') {{ '12' }}@else{{ '12' }} @endif">
        <div class="row g-3">
          <div id="wizard-checkout" class="bs-stepper wizard-icons wizard-icons-example">
            <div class="bs-stepper-header m-auto border-0 py-4">
              <div class="step" data-target="#process">
                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-icon">
                                        <svg viewBox="0 0 58 54">
                                            <use
                                              xlink:href="../../assets/svg/icons/wizard-checkout-cart.svg#wizardCart">
                                            </use>
                                        </svg>
                                    </span>
                  <span class="bs-stepper-label">Process</span>
                </button>
              </div>
              <div class="line">
                <i class="ti ti-chevron-right"></i>
              </div>
              <div class="step" data-target="#Stiching">
                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-icon">
                                        <svg viewBox="0 0 54 54">
                                            <use
                                              xlink:href="../../assets/svg/icons/wizard-checkout-address.svg#wizardCheckoutAddress">
                                            </use>
                                        </svg>
                                    </span>
                  <span class="bs-stepper-label">Raw Material</span>
                </button>
              </div>
            </div>
            {{-- Original --}}
            {{--        Alternative Raw Material Design --}}
            <div class="bs-stepper-content border-top" id="wizard-checkout-form">
              <!-- Cart -->
              <div id="process" class="content">
                <div id="processData">
                  @if ($actionType == 'edit')
                    @if (!empty($planingOrders))
                      @php $num = 0; @endphp
                      @foreach ($planingOrders->PlaningOrderProcesses as $planingOrderProcess)
                        <div class="row g-3">
                          <div class="col-md-2">
                            <label class="form-label">SR No.</label>
                            <input type="text" id="srNo{{ $num }}"
                                   name="processData[{{ $num }}][srNo]"
                                   class="form-control" placeholder="Sr NO."
                                   value="{{ $planingOrderProcess->sr_no }}" />
                            <input type="hidden"
                                   id="planingOrderProcessesId{{ $num }}"
                                   name="processData[{{ $num }}][planingOrderProcessesId]"
                                   value="{{ $planingOrderProcess->id }}">
                          </div>
                          <div class="col-md-2">
                            <label class="form-label">Process List</label>
                            <select id="processItem{{ $num }}"
                                    name="processData[{{ $num }}][processItem]"
                                    class="select2 form-select" data-allow-clear="true">
                              <option value="">Select</option>
                              @foreach ($processMasters as $processMaster)
                                <option
                                  @if ($planingOrderProcess->process_master_id == $processMaster->id)
                                    {{ 'selected' }}
                                  @endif
                                  value="{{ $processMaster->id }}">
                                  {{ $processMaster->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-md-2">
                            <label class="form-label">Qty</label>
                            <input type="text"
                                   onkeyup="processCalculateValue({{ $num }})"
                                   id="processQty{{ $num }}"
                                   name="processData[{{ $num }}][processQty]"
                                   class="form-control"
                                   value="{{ $planingOrderProcess->qty }}"
                                   placeholder="Quantity" />
                          </div>
                          <div class="col-md-2" style="float: right">
                            <label class="form-label">Rate</label>
                            <input type="text"
                                   onkeyup="processCalculateValue({{ $num }})"
                                   id="processRate{{ $num }}"
                                   name="processData[{{ $num }}][processRate]"
                                   class="form-control"
                                   value="{{ $planingOrderProcess->rate }}"
                                   placeholder="Rate" />
                          </div>

                          <div class="col-md-2" style="float: right">
                            <label class="form-label">Value</label>
                            <input type="text" id="processValue{{ $num }}"
                                   name="processData[{{ $num }}][processValue]"
                                   class="form-control"
                                   value="{{ $planingOrderProcess->value }}"
                                   placeholder="Value" />
                          </div>

                          <div class="col-md-2" style="float: right">
                            <label class="form-label">Duration</label>
                            <input type="number" id="processDuration{{ $num }}"
                                   name="processData[{{ $num }}][processDuration]"
                                   class="form-control" placeholder="Duration"
                                   value="{{ $planingOrderProcess->duration }}" />
                          </div>

                        </div>
                        @php $num++; @endphp
                      @endforeach
                    @endif
                  @else
                    <div class="row g-3" id="showHtmlProcess">
                      <div class="col-md-2">
                        <label class="form-label">SR No.</label>
                        <input type="text" id="srNo0" name="processData[0][srNo]"
                               class="form-control" placeholder="Sr NO." value="1" />
                        <input type="hidden" id="planingOrderProcessesId"
                               name="processData[0][planingOrderProcessesId]">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Process List</label>
                        <select id="processItem0" name="processData[0][processItem]"
                                class="select2 form-select" data-allow-clear="true">
                          <option value="">Select</option>
                          @foreach ($processMasters as $processMaster)
                            <option value="{{ $processMaster->id }}">
                              {{ $processMaster->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Qty</label>
                        <input type="text" onkeyup="processCalculateValue(0)"
                               id="processQty0"
                               name="processData[0][processQty]" class="form-control"
                               placeholder="Quantity" />
                      </div>
                      <div class="col-md-2" style="float: right">
                        <label class="form-label">Rate</label>
                        <input type="text" onkeyup="processCalculateValue(0)"
                               id="processRate0" name="processData[0][processRate]"
                               class="form-control" placeholder="Rate" />
                      </div>

                      <div class="col-md-2" style="float: right">
                        <label class="form-label">Value</label>
                        <input type="text" id="processValue0"
                               name="processData[0][processValue]" class="form-control"
                               placeholder="Value" />
                      </div>

                      <div class="col-md-2" style="float: right">
                        <label class="form-label">Duration</label>
                        <input type="number" id="processDuration0"
                               name="processData[0][processDuration]" class="form-control"
                               placeholder="Duration" />
                      </div>

                    </div>

                  @endif
                </div>
                <div class="col-lg-12 col-12 invoice-actions mt-3">
                  <button type="button" onclick="addItem('processData')"
                          class="btn rounded-pill btn-icon btn-label-primary waves-effect">
                    <span class="ti ti-plus"></span>
                  </button>

                  <button type="button" onclick="removeItem('processData')"
                          class="btn rounded-pill btn-icon btn-label-danger waves-effect">
                    <span class="ti ti-minus"></span>
                  </button>

                </div>

              </div>
              <!-- Address -->
              <div id="Stiching" class="content">
                <div id="RawMaterialData">
                  @if ($actionType == 'edit')
                    @if (!empty($planingOrders))
                      @php $num = 0; @endphp
                      @foreach ($planingOrders->PlaningOrderMaterials as $planingOrderMaterials)
                        <div class="row g-3">
                          <div class="col-md-2">
                            <label class="form-label">Category</label>
                            <select id="rawCategoryId{{ $num }}"
                                    name="bomListData[{{ $num }}][category_id]"
                                    onchange="getCategoryDetails({{ $num }})"
                                    class="select2 form-select" data-allow-clear="true">
                              <option value="">Select</option>
                              @foreach ($categoryMasters as $categoryMaster)
                                <option
                                  @if ($planingOrderMaterials->Item->item_category_id == $categoryMaster->id)
                                    {{ 'selected' }}
                                  @endif
                                  value="{{ $categoryMaster->id }}">
                                  {{ $categoryMaster->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-md-2">
                            <label class="form-label">Sub Category</label>
                            <select id="rawSubcategoryId{{ $num }}"
                                    name="bomListData[{{ $num }}][subcategory_id]"
                                    onchange="getSubCategoryDetails({{ $num }})"
                                    class="select2 form-select" data-allow-clear="true">
                              <option value="">Select</option>
                              @foreach ($subcategoryMasters as $subcategoryMaster)
                                <option
                                  @if ($planingOrderMaterials->Item->item_subcategory_id == $subcategoryMaster->id)
                                    {{ 'selected' }}
                                  @endif
                                  value="{{ $subcategoryMaster->id }}">
                                  {{ $subcategoryMaster->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-md-2">
                            <label class="form-label">Item</label>
                            <select id="rawItem{{ $num }}"
                                    name="bomListData[{{ $num }}][rawItem]"
                                    onchange="getItemDetails({{ $num }})"
                                    class="select2 form-select" data-allow-clear="true">
                              <option value="">Select</option>
                              @foreach ($itemMasters as $itemMaster)
                                <option
                                  @if ($planingOrderMaterials->item_id == $itemMaster->id)
                                    {{ 'selected' }}
                                  @endif
                                  value="{{ $itemMaster->id }}">
                                  {{ $itemMaster->name }}</option>
                              @endforeach
                            </select>
                            <input type="hidden"
                                   id="planingOrderMaterialsId{{ $num }}"
                                   name="bomListData[{{ $num }}][planingOrderMaterialsId]"
                                   value="{{ $planingOrderMaterials->id }}">
                          </div>
                          <div class="col-md-2 col-lg-1">
                            <label class="form-label">Per Pc Qty</label>
                            <input type="number" step="any"
                                   onkeyup="bomCalculateValue({{ $num }})"
                                   id="rawPerPcQty{{ $num }}"
                                   name="bomListData[{{ $num }}][rawPerPcQty]"
                                   class="form-control" placeholder="Per Pc Qty"
                                   value="{{ $planingOrderMaterials->per_pc_qty }}" />
                          </div>
                          <div class="col-md-2 col-lg-1">
                            <label class="form-label">Order Qty</label>
                            <input type="number" step="any"
                                   onkeyup="bomCalculateValue({{ $num }})"
                                   id="rawOrderQty{{ $num }}"
                                   name="bomListData[{{ $num }}][rawOrderQty]"
                                   class="form-control" placeholder="Order Qty"
                                   value="{{ $planingOrderMaterials->order_qty }}" />
                          </div>
                          <div class="col-md-2 col-lg-1">
                            <label class="form-label">Required Qty</label>
                            <input type="number" step="any"
                                   onkeyup="bomCalculateValue({{ $num }})"
                                   id="rawRequiredQty{{ $num }}"
                                   name="bomListData[{{ $num }}][rawRequiredQty]"
                                   class="form-control" placeholder="Qty"
                                   value="{{ $planingOrderMaterials->required_qty }}" />
                          </div>
                          <div class="col-md-2 col-lg-1">
                            <label class="form-label">Available Qty</label>
                            <input type="number" step="any"
                                   id="rawAvailableQty{{ $num }}"
                                   name="bomListData[{{ $num }}][rawAvailableQty]"
                                   class="form-control" placeholder="Qty"
                                   value="{{ $planingOrderMaterials->available_qty }}" />
                          </div>

                          <div class="col-md-2 col-lg-1" style="float: right">
                            <label class="form-label">Rate</label>
                            <input type="number" step="any"
                                   id="rawRate{{ $num }}"
                                   name="bomListData[{{ $num }}][rawRate]"
                                   class="form-control"
                                   onkeyup="bomCalculateValue({{ $num }})"
                                   placeholder="Total Rate"
                                   value="{{ $planingOrderMaterials->rate }}" />
                          </div>
                          <div class="col-md-2 col-lg-1">
                            <label class="form-label">Total</label>
                            <input type="number" step="any"
                                   id="rawTotal{{ $num }}"
                                   name="bomListData[{{ $num }}][rawTotal]"
                                   class="form-control" placeholder="Total"
                                   value="{{ $planingOrderMaterials->total }}" />
                          </div>
                        </div>
                        <HR>
                        @php $num++; @endphp
                      @endforeach
                    @endif
                  @else
                    <div class="row g-3" id="showHtmlRawMaterials">
                      <div class="col-md-2">
                        <label class="form-label">Category</label>
                        <select id="rawCategoryId0" name="bomListData[0][category_id]"
                                onchange="getCategoryDetails(0)" class="select2 form-select"
                                data-allow-clear="true">
                          <option value="">Select</option>
                          @foreach ($categoryMasters as $categoryMaster)
                            <option value="{{ $categoryMaster->id }}">
                              {{ $categoryMaster->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Sub Category</label>
                        <select id="rawSubcategoryId0" name="bomListData[0][subcategory_id]"
                                onchange="getSubCategoryDetails(0)" class="select2 form-select"
                                data-allow-clear="true">
                          <option value="">Select</option>
                          @foreach ($subcategoryMasters as $subcategoryMaster)
                            <option value="{{ $subcategoryMaster->id }}">
                              {{ $subcategoryMaster->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Item</label>
                        <select id="rawItem0" name="bomListData[0][rawItem]"
                                onchange="getItemDetails(0)" class="select2 form-select"
                                data-allow-clear="true">
                          <option value="">Select</option>
                          @foreach ($itemMasters as $itemMaster)
                            <option value="{{ $itemMaster->id }}">{{ $itemMaster->name }}
                            </option>
                          @endforeach
                        </select>
                        <input type="hidden" id="planingOrderMaterialsId"
                               name="bomListData[0][planingOrderMaterialsId]">
                      </div>
                      <div class="col-md-2 col-lg-1">
                        <label class="form-label">Per Pc Qty</label>
                        <input type="number" step="any" onkeyup="bomCalculateValue(0)"
                               id="rawPerPcQty0" name="bomListData[0][rawPerPcQty]"
                               class="form-control" placeholder="Per Pc Qty" />
                      </div>
                      <div class="col-md-2 col-lg-1">
                        <label class="form-label">Order Qty</label>
                        <input type="number" step="any" onkeyup="bomCalculateValue(0)"
                               id="rawOrderQty0" name="bomListData[0][rawOrderQty]"
                               class="form-control" placeholder="Order Qty" />
                      </div>
                      <div class="col-md-2 col-lg-1">
                        <label class="form-label">Required Qty</label>
                        <input type="number" step="any" onkeyup="bomCalculateValue(0)"
                               id="rawRequiredQty0" name="bomListData[0][rawRequiredQty]"
                               class="form-control" placeholder="Qty" />
                      </div>
                      <div class="col-md-2 col-lg-1">
                        <label class="form-label">Available Qty</label>
                        <input type="number" step="any" id="rawAvailableQty0"
                               name="bomListData[0][rawAvailableQty]" class="form-control"
                               placeholder="Qty" />
                      </div>

                      <div class="col-md-2 col-lg-1" style="float: right">
                        <label class="form-label">Rate</label>
                        <input type="number" step="any" id="rawRate0"
                               name="bomListData[0][rawRate]" class="form-control"
                               onkeyup="bomCalculateValue(0)" placeholder="Total Rate" />
                      </div>
                      <div class="col-md-2 col-lg-1">
                        <label class="form-label">Total</label>
                        <input type="number" step="any" id="rawTotal0"
                               name="bomListData[0][rawTotal]" class="form-control"
                               placeholder="Total" />
                      </div>
                    </div>
                  @endif

                </div>
                <div class="col-lg-12 col-12 invoice-actions mt-3">
                  <button type="button" onclick="addBomListItem('RawMaterialData')"
                          class="btn rounded-pill btn-icon btn-label-primary waves-effect">
                    <span class="ti ti-plus"></span>
                  </button>

                  <button type="button" onclick="removeBomListItem('RawMaterialData')"
                          class="btn rounded-pill btn-icon btn-label-danger waves-effect">
                    <span class="ti ti-minus"></span>
                  </button>

                </div>
              </div>

              <div class="row justify-content-center">
                <div class="col-auto">
                  <button type="submit" id="saveBtn"
                          class="btn btn-primary waves-effect waves-light">
                    @if ($actionType == 'edit')
                      Update
                    @else
                      Save
                    @endif
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    @if ($actionType != 'edit')
      <div class="row g-3 mt-3">
        <div class="col-12 col-lg-12  col-md-12">

          <div class="card">
            <div class="card-header">
              <h4>Process List</h4>
            </div>
            <div class="card-body table-responsive pt-0">
              <table class="datatables-basic  table" id="datatable-list-process">
                <thead class="table-light">
                <tr>
                  <th>Sr No</th>
                  <th>Process</th>
                  <th>Qty</th>
                  <th>Rate</th>
                  <th>Amount</th>
                  <th>Duration</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody id="dataTableBody">
                @php
                  $totalQty = 0;
                  $totalRate = 0;
                  $totalValue = 0;
                  $totalDuration = 0;
                @endphp
                @if (!empty($planingOrders))
                  @foreach ($planingOrders->PlaningOrderProcesses as $planingOrderProcess)
                    <tr>
                      <td>{{ $planingOrderProcess->sr_no }}</td>
                      <td>{{ $planingOrderProcess->ProcessMaster->name ?? '' }}</td>
                      <td>{{ $planingOrderProcess->qty }}</td>
                      <td>{{ $planingOrderProcess->rate }}</td>
                      <td>{{ $planingOrderProcess->value }}</td>
                      <td>{{ $planingOrderProcess->duration }}</td>
                      <td>
                                                    <span class="text-danger cursor-pointer"
                                                          onclick="processDelete({{ $planingOrderProcess->id }});">
                                                        <i class="ti ti-trash" title="Delete Record"></i>
                                                    </span>

                        <span class="text-primary cursor-pointer"
                              onclick="processEdit({{ $planingOrderProcess->id }});">
                                                        <i class="ti ti-edit" title="Edit Record"></i>
                                                    </span>

                      </td>
                    </tr>
                    @php
                      $totalQty += $planingOrderProcess->qty;
                      $totalRate += $planingOrderProcess->rate;
                      $totalValue += $planingOrderProcess->value;
                      $totalDuration += $planingOrderProcess->duration;
                    @endphp
                  @endforeach
                @endif
                </tbody>
                <tfoot>
                <tr>
                  <td></td>
                  <td></td>
                  <td>{{ $totalQty }}</td>
                  <td>{{ $totalRate }}</td>
                  <td>{{ $totalValue }}</td>
                  <td>{{ $totalDuration }}</td>
                  <td></td> <!-- Adjust the colspan as needed -->
                </tr>
                </tfoot>
              </table>
            </div>
          </div>

          <div class="card mt-2">
            <div class="card-header">
              <h4>Bom List</h4>
            </div>
            <div class="card-body table-responsive pt-0">
              <table class="datatables-basic table" id="datatable-list-bom">
                <thead class="table-light">
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

                  <th>Action</th>

                </tr>
                </thead>
                <tbody id="dataTableBody">
                @php
                  $totalRequiredQty = 0;
                  $totalAvailableQty = 0;
                  $totalRate = 0;
                  $total = 0;
                @endphp
                @if (!empty($planingOrders))
                  @php $num =1; @endphp
                  @foreach ($planingOrders->PlaningOrderMaterials as $planingOrderMaterials)
                    @if (!empty($planingOrderMaterials->id))
                      @php
                        $totalRequiredQty += $planingOrderMaterials->required_qty;
                        $totalAvailableQty += $planingOrderMaterials->available_qty;
                        $totalRate += $planingOrderMaterials->rate;
                        $total += $planingOrderMaterials->total;
                      @endphp
                      <tr>
                        <td>{{ $num }}</td>
                        <td>{{ $planingOrderMaterials->Item->ItemCategory->name ?? '' }}</td>
                        <td>{{ $planingOrderMaterials->Item->ItemSubCategory->name ?? '' }}
                        </td>
                        <td>{{ $planingOrderMaterials->Item->name ?? '' }}</td>
                        <td>{{ $planingOrderMaterials->per_pc_qty }}</td>
                        <td>{{ $planingOrderMaterials->order_qty }}</td>
                        <td>{{ $planingOrderMaterials->required_qty }}</td>
                        <td width="200">{{ $planingOrderMaterials->available_qty }}

                        </td>
                        <td>{{ $planingOrderMaterials->rate }}</td>
                        <td>{{ $planingOrderMaterials->total }}</td>
                        <td>
                                                        <span class="text-danger cursor-pointer"
                                                              onclick="bomListDelete({{ $planingOrderMaterials->id }});">
                                                            <i class="ti ti-trash" title="Delete Record"></i>
                                                        </span>

                          <span class="text-primary cursor-pointer"
                                onclick="bomListEdit({{ $planingOrderMaterials->id }});">
                                                            <i class="ti ti-edit" title="Edit Record"></i>
                                                        </span>
                          <span class="ml-3 btn btn-outline-info btn-sm cursor-pointer"
                                onclick="requestPO({{ $planingOrderMaterials->item_id }},{{ $planingOrderMaterials->required_qty }} ,{{ $planingOrderMaterials->planing_order_id }});">
                                                            <i class="fa fa-forward mr-2"
                                                               title="Request PO With Item for Planing Order"></i> Request
                                                            PO
                                                        </span>

                        </td>
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
                  <td></td> <!-- Adjust the colspan as needed -->
                </tr>
                </tfoot>
              </table>
            </div>
          </div>

        </div>
      </div>

    @endif
    {{-- <div class="col-lg-3 col-12 invoice-actions mt-3">
  <button type="submit" class="btn btn-primary d-grid w-100">Save</button> --}}
    <div class="row mt-3">
      @if (!empty($planing_order_id) && $actionType != 'edit')
        <div class="col-md-12 text-center">
          <a href="{{ route('order-planning.index') }}">
            <button type="button" class="btn btn-primary waves-effect waves-light">
              Preview & Confirm
            </button>
          </a>
        </div>
      @endif
    </div>
    <input type="hidden" value="{{ $sale_id }}" name="salesOrderId">
    <input type="hidden" value="{{ $planing_order_id }}" name="planingOrderId">
  </form>
@endsection


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>
  $(document).ready(function() {
    $('#datatable-list-process').DataTable({
      order: [
        [0, 'desc']
      ]
    });
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

  function processCalculateValue(num) {
    var qty = parseFloat(document.getElementById('processQty' + num).value);
    var rate = parseFloat(document.getElementById('processRate' + num).value);
    var value = qty * rate;
    document.getElementById('processValue' + num).value = value.toFixed(2);
  }

  function bomCalculateValue(num) {
    var rawPerPcQty = parseFloat(document.getElementById('rawPerPcQty' + num).value);
    var rawOrderQty = parseFloat(document.getElementById('rawOrderQty' + num).value);
    var qty = rawPerPcQty * rawOrderQty;
    var rate = parseFloat(document.getElementById('rawRate' + num).value);
    var value = qty * rate;
    document.getElementById('rawRequiredQty' + num).value = qty.toFixed(2);
    document.getElementById('rawTotal' + num).value = value.toFixed(2);
  }


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
        $('#processQty0').val(result.qty);
        $('#rawOrderQty0').val(result.qty);
        $('#TotalQty').val(result.qty);
        if (result.showHtmlProcess !== '') {
          $('#showHtmlProcess').html(result.showHtmlProcess).removeClass("row");  ;
        }
        if (result.showHtmlRawMaterials !== '') {
          $('#showHtmlRawMaterials').html(result.showHtmlRawMaterials).removeClass("row");
        }
      }
    });
  }

  function getItemDetails(num) {
    var rawItem = document.getElementById('rawItem' + num).value;
    var rawCategoryId = document.getElementById('rawCategoryId' + num).value;
    var rawSubcategoryId = document.getElementById('rawSubcategoryId' + num).value;
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: '{{ route('getItemDetails') }}',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        rawItem: rawItem,
        rawCategoryId: rawCategoryId,
        rawSubcategoryId: rawCategoryId,
        '_token': "{{ csrf_token() }}"
      },
      success: function(result) {
        $('#rawRate' + num).val(result.item.rate);
        $('#rawAvailableQty' + num).val(result.inventory.good_inventory);
        bomCalculateValue(num);
      }
    });
  }


  function getCategoryDetails(num) {
    var rawCategoryId = document.getElementById('rawCategoryId' + num).value;
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: '{{ route('getCategoryDetails') }}',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        rawCategoryId: rawCategoryId,
        '_token': "{{ csrf_token() }}"
      },
      success: function(result) {
        var select = document.getElementById('rawItem' + num);

        select.innerHTML = '';

        var placeholderOption = document.createElement('option');
        placeholderOption.text = 'Select an item';
        placeholderOption.disabled = true;
        placeholderOption.selected = true;

        select.appendChild(placeholderOption);
        result.items.forEach(function(item) {
          var option = document.createElement('option');
          option.value = item.id;
          option.text = item.name;
          select.appendChild(option);
        });

        var selectForSubcategory = document.getElementById('rawSubcategoryId' + num);
        selectForSubcategory.innerHTML = '';

        var placeholderOptionSub = document.createElement('option');
        placeholderOptionSub.text = 'Select an sub category';
        placeholderOptionSub.disabled = true;
        placeholderOptionSub.selected = true;
        selectForSubcategory.appendChild(placeholderOptionSub);
        result.subcategories.forEach(function(subcategory) {
          var option = document.createElement('option');
          option.value = subcategory.id;
          option.text = subcategory.name;
          selectForSubcategory.appendChild(option);
        });
      }
    });
  }

  function getSubCategoryDetails(num) {
    var rawSubcategoryId = document.getElementById('rawSubcategoryId' + num).value;
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: '{{ route('getSubCategoryDetails') }}',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        rawSubcategoryId: rawSubcategoryId,
        '_token': "{{ csrf_token() }}"
      },
      success: function(result) {
        var select = document.getElementById('rawItem' + num);
        select.innerHTML = '';
        var placeholderOption = document.createElement('option');
        placeholderOption.text = 'Select an item';
        placeholderOption.disabled = true;
        placeholderOption.selected = true;

        select.appendChild(placeholderOption);
        result.items.forEach(function(item) {
          var option = document.createElement('option');
          option.value = item.id;
          option.text = item.name;
          select.appendChild(option);
        });
      }
    });
  }


  function addItem(dataId) {

    var container = document.getElementById(dataId);
    var rowCount = container.getElementsByClassName('row').length;

    var newRow = document.createElement('div');
    newRow.className = 'row g-3 mt-1';

    newRow.innerHTML = `
            <div class="col-md-2">
                <label class="form-label">SR No.</label>
                <input type="text" id="srNo${rowCount}" name="processData[${rowCount}][srNo]"
                       class="form-control" placeholder="Sr NO." value="${rowCount + 1}"/>
            </div>
            <div class="col-md-2">
                <label class="form-label">Process List</label>
                <select id="processItem${rowCount}" name="processData[${rowCount}][processItem]"
                        class="select2 form-select" data-allow-clear="true">
                    <option value="">Select</option>
                    @foreach ($processMasters as $processMaster)
    <option value="{{ $processMaster->id }}">{{ $processMaster->name }}</option>
                   @endforeach
    </select>
</div>
<div class="col-md-2">
    <label class="form-label">Qty</label>
    <input type="number" step="any" id="processQty${rowCount}" name="processData[${rowCount}][processQty]"
                       class="form-control" onkeyup="processCalculateValue(${rowCount})" placeholder="Quantity"/>
            </div>
            <div class="col-md-2" style="float: right">
                <label class="form-label">Rate</label>
                <input type="number" step="any" id="processRate${rowCount}" onkeyup="processCalculateValue(${rowCount})" name="processData[${rowCount}][processRate]"
                       class="form-control" placeholder="Rate"/>
            </div>

            <div class="col-md-2" style="float: right">
                <label class="form-label">Value</label>
                <input type="number" step="any" id="processValue${rowCount}" name="processData[${rowCount}][processValue]"
                       class="form-control" placeholder="Value"/>
            </div>

            <div class="col-md-2" style="float: right">
                <label class="form-label">Duration</label>
                <input type="number" step="any" id="processDuration${rowCount}" name="processData[${rowCount}][processDuration]"
                       class="form-control" placeholder="Duration"/>
            </div>
        `;

    container.appendChild(newRow);
    $('.select2').select2();
  }

  // Function to remove the last process item
  function removeItem(dataId) {
    var container = document.getElementById(dataId);
    var rowCount = container.getElementsByClassName('row').length;

    // Check if there's at least one item to remove
    if (rowCount > 1) {
      container.removeChild(container.lastChild);
    } else {
      alert('You cannot remove all items.');
    }
  }

  // Define JavaScript variables from PHP
  var categoryMasters = {!! json_encode($categoryMasters) !!};
  var subcategoryMasters = {!! json_encode($subcategoryMasters) !!};
  var itemMasters = {!! json_encode($itemMasters) !!};

  // Your JavaScript function
  function addBomListItem(dataId) {
    var container = document.getElementById(dataId);
    var rowCount = container.getElementsByClassName('row').length;
    var oldRowCount = parseInt(rowCount) - 1;
    var rawCategoryIdOld = document.getElementById('rawCategoryId' + oldRowCount).value;
    var rawSubcategoryIdOld = document.getElementById('rawSubcategoryId' + oldRowCount).value;
    console.log('oldRowCount: ', oldRowCount);
    console.log('rawCategoryIdOld: ', rawCategoryIdOld);
    console.log('rawSubcategoryIdOld: ', rawSubcategoryIdOld);
    var newRow = document.createElement('div');
    newRow.className = 'row g-3 mt-1';

    var categoryOptions = '';
    categoryMasters.forEach(function(categoryMaster) {
      categoryOptions +=
        `<option value="${categoryMaster.id}" ${rawCategoryIdOld == categoryMaster.id ? 'selected' : ''}>${categoryMaster.name}</option>`;
    });

    var subcategoryOptions = '';
    subcategoryMasters.forEach(function(subcategoryMaster) {
      subcategoryOptions +=
        `<option value="${subcategoryMaster.id}" ${rawSubcategoryIdOld == subcategoryMaster.id ? 'selected' : ''}>${subcategoryMaster.name}</option>`;
    });

    newRow.innerHTML = `<HR>
                <div class="col-md-2">
                    <label class="form-label">Category</label>
                    <select id="rawCategoryId${rowCount}" name="bomListData[${rowCount}][category_id]" onchange="getCategoryDetails(${rowCount})" class="select2 form-select" data-allow-clear="true">
                        <option value="">Select Category</option>
                        ${categoryOptions}
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sub Category</label>
                    <select id="rawSubcategoryId${rowCount}" name="bomListData[${rowCount}][subcategory_id]" onchange="getSubCategoryDetails(${rowCount})" class="select2 form-select" data-allow-clear="true">
                        <option value="">Select Sub Category</option>
                        ${subcategoryOptions}
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Item</label>
                    <select id="rawItem${rowCount}" name="bomListData[${rowCount}][rawItem]" class="select2 form-select" data-allow-clear="true" onchange="getItemDetails(${rowCount})">
                        <option value="">Select</option>
                        @foreach ($itemMasters as $itemMaster)
    <option value="{{ $itemMaster->id }}">{{ $itemMaster->name }}</option>
                        @endforeach
    </select>
</div>
<div class="col-md-2 col-lg-1">
    <label class="form-label">Per Pc Qty</label>
    <input type="number" step="any" onkeyup="bomCalculateValue(${rowCount})" id="rawPerPcQty${rowCount}" name="bomListData[${rowCount}][rawPerPcQty]" class="form-control" placeholder="Per Pc Qty" />
                </div>
                <div class="col-md-2 col-lg-1">
                    <label class="form-label">Order Qty</label>
                    <input type="number" step="any" onkeyup="bomCalculateValue(${rowCount})" id="rawOrderQty${rowCount}" name="bomListData[${rowCount}][rawOrderQty]" class="form-control" placeholder="Order Qty" />
                </div>
                <div class="col-md-2 col-lg-1">
                    <label class="form-label">Required Qty</label>
                    <input type="number" step="any" id="rawRequiredQty${rowCount}" onkeyup="bomCalculateValue(${rowCount})" name="bomListData[${rowCount}][rawRequiredQty]" class="form-control" placeholder="Qty"/>
                </div>
                <div class="col-md-2 col-lg-1">
                    <label class="form-label">Available Qty</label>
                    <input type="number" step="any" id="rawAvailableQty${rowCount}" name="bomListData[${rowCount}][rawAvailableQty]" class="form-control" placeholder="Qty"/>
                </div>
                <div class="col-md-2 col-lg-1" style="float: right">
                    <label class="form-label">Rate</label>
                    <input type="number" step="any" id="rawRate${rowCount}" onkeyup="bomCalculateValue(${rowCount})" name="bomListData[${rowCount}][rawRate]" class="form-control" placeholder="Total Rate"/>
                </div>
                <div class="col-md-2 col-lg-1">
                    <label class="form-label">Total</label>
                    <input type="number" step="any" id="rawTotal${rowCount}" name="bomListData[${rowCount}][rawTotal]" class="form-control" placeholder="Total"/>
                </div>

            `;

    container.appendChild(newRow);
    $('.select2').select2();

    getSubCategoryDetails(rowCount);

  }

  // Function to remove the last BOM list item for stitching
  function removeBomListItem(dataId) {
    var container = document.getElementById(dataId);
    var rowCount = container.getElementsByClassName('row').length;

    // Check if there's at least one item to remove
    if (rowCount > 1) {
      container.removeChild(container.lastChild);
    } else {
      alert('You cannot remove all items.');
    }
  }

  function processDelete(id) {
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
    }).then(function(result) {
      if (result.value) {
        $('#overlay').fadeIn(100);
        $.ajax({
          type: 'POST',
          url: '{{ route('processDelete') }}',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            id: id,
            '_token': "{{ csrf_token() }}"
          },
          success: function(resultData) {
            Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
              location.reload();
              $('#overlay').fadeOut(100);
            });
          }
        });
      } else if (result.dismiss === 'cancel') {
        Swal.fire(
          'Cancelled',
          'Your request has been Cancelled !!',
          'error'
        );
      }
    });
  }

  function processEdit(id) {
    $.ajax({
      url: "{{ route('processEdit') }}",
      method: 'POST',
      data: {
        id: id,
        _token: '{{ csrf_token() }}'
      },
      success: function(response) {
        toastr.success('Fetch Successfully');

        $('#saveBtn')
          .removeClass('btn-primary')
          .addClass('btn-success')
          .text('Update');

        $('#planingOrderProcessesId').val(response.PlaningOrderProcesses.id);
        $('#srNo0').val(response.PlaningOrderProcesses.sr_no);
        $('#processQty0').val(response.PlaningOrderProcesses.qty);
        $('#processRate0').val(response.PlaningOrderProcesses.rate);
        $('#processValue0').val(response.PlaningOrderProcesses.value);
        $('#processDuration0').val(response.PlaningOrderProcesses.duration);
        $('#processItem0').val(response.PlaningOrderProcesses.process_master_id).trigger('change')
          .select2('refresh');
      },
      error: function(xhr, status, error) {
        console.error('Error fetching data:', error);
      }
    });
  }

  function bomListDelete(id) {
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
    }).then(function(result) {
      if (result.value) {
        $('#overlay').fadeIn(100);
        $.ajax({
          type: 'POST',
          url: '{{ route('bomListDelete') }}',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            id: id,
            '_token': "{{ csrf_token() }}"
          },
          success: function(resultData) {
            Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
              location.reload();
              $('#overlay').fadeOut(100);
            });
          }
        });
      } else if (result.dismiss === 'cancel') {
        Swal.fire(
          'Cancelled',
          'Your request has been Cancelled !!',
          'error'
        );
      }
    });
  }

  function bomListEdit(id) {
    $.ajax({
      url: "{{ route('bomListEdit') }}",
      method: 'POST',
      data: {
        id: id,
        _token: '{{ csrf_token() }}'
      },
      success: function(response) {
        toastr.success('Fetch Successfully');

        $('#saveBtn')
          .removeClass('btn-primary')
          .addClass('btn-success')
          .text('Update');

        $('#planingOrderMaterialsId').val(response.PlaningOrderMaterials.id);
        $('#rawTotal0').val(response.PlaningOrderMaterials.total);
        $('#rawRate0').val(response.PlaningOrderMaterials.rate);
        $('#rawAvailableQty0').val(response.PlaningOrderMaterials.available_qty);
        $('#rawRequiredQty0').val(response.PlaningOrderMaterials.required_qty);

        $('#rawItem0').prop('onchange', null).val(response.PlaningOrderMaterials.item_id).trigger(
          'change').select2('refresh');
      },
      error: function(xhr, status, error) {
        console.error('Error fetching data:', error);
      }
    });
  }

  function requestPO(item_id, qty, order_planing_id) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You want to?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, Process!',
      reverseButtons: true,
      cancelButtonColor: '#d33',
      confirmButtonClass: 'btn btn-primary',
      cancelButtonClass: 'btn btn-danger ml-1',
      buttonsStyling: true
    }).then(function(result) {
      if (result.value) {
        $('#overlay').fadeIn(100);
        $.ajax({
          type: 'POST',
          url: '{{ route('requestPO') }}',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            item_id: item_id,
            qty: qty,
            order_planing_id: order_planing_id,
            '_token': "{{ csrf_token() }}"
          },
          success: function(resultData) {
            Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
              location.reload();
              $('#overlay').fadeOut(100);
            });
          }
        });
      } else if (result.dismiss === 'cancel') {
        Swal.fire(
          'Cancelled',
          'Your request has been Cancelled !!',
          'error'
        );
      }
    });
  }
</script>
