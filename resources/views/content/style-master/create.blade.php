@extends('layouts/layoutMaster')

@section('title', 'Add Style')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />


    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/wizard-ex-checkout.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>


    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script src="{{ asset('assets/js/wizard-ex-checkout.js') }}"></script>
@endsection


@section('content')

    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left">Style /</span> Add
    </h4>
    <form method="post" action="{{ route('style-master.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-12">


                <div class="card">
                    {{-- <h5 class="card-header">Applicable Categories</h5> --}}
                    <div class="card-body">
							<div class="content">
                            <div class="content-header mb-4">
                                <h3 class="mb-1">Style (Sample) Information</h3>
                            </div>
                        </div>
                        <div class="content">
                            <div class="col-md-3" id="CopyFromStyleNoDiv" style="display: none;">
                                <label class="form-label" for="CopyStyleNoId">Copy Style No</label>
                                <select id="CopyStyleNoId" name="CopyStyleNoId" class="select2 select21 form-select"
                                    data-allow-clear="true" data-placeholder="Select Style No" onchange="getStyleDetails()">
                                    <option value="">Select</option>
                                    @foreach (\App\Models\StyleMaster::all() as $data)
                                        <option value="{{ $data->id }}">{{ $data->style_no }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="content">
                           
                            <div class="form-check form-check-primary mt-3 mb-3">
                                <input class="form-check-input" style="height:25px;width:25px;" type="checkbox" name="CopyFromStyleCheck"
                                       onchange="toggleCopyStyleVisibility()" value="1" id="CopyFromStyleCheck">
								<label class="form-check-label m-2 h5" for="customCheckPrimary"><strong>Copy From Other Style</strong></label>
                            </div>
							
							<div class="divider mt-2">
                                    <div class="divider-text">Style Information</div>
                                </div>
	
                            <div class="row g-4 mt-2">

                                <div class="col-md-3">
                                    <label class="form-label" for="Style_date">Date</label>
                                    <input type="date" class="form-control date-picker" id="Style_date"
                                           name="Style_date"
                                           placeholder="YYYY-MM-DD" value="{{ date('Y-m-d') }}" />
                                </div>
								@php
                                    $Setting = \App\Models\Setting::orderBy('id', 'desc')->first();
                                    if (!empty($Setting)) {
                                        $StyleNoDetails = $Setting->toArray();

                                        $StyleNoCount = $StyleNoDetails['style_number_no_set'] + 1;
                                        $StyleNo = $StyleNoDetails['style_number_pre_fix'] . '' . $StyleNoCount;
                                    }
                                @endphp

                                <div class="col-md-3">
                                    <label class="form-label" for="Style_No">Style No</label>
                                    <input required type="text" id="Style_No" name="Style_No" class="form-control" 
                                           value="{{ $StyleNo ?? '' }}" placeholder="Style No" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="Febric">Fabric</label>
                                    <input type="text" id="Febric" name="Febric" class="form-control"
                                           placeholder="Fabric" />
                                </div>

								 <div class="col-md-3">
                                    <label class="form-label" for="Brand">Brand</label>
                                    <select required id="Brand" name="Brand" class="select2 select21 form-select"
                                        data-allow-clear="true" data-placeholder="Select Brand">
                                        <option value="">Select</option>
                                        @foreach (\App\Models\Brand::all() as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
								
                                <div class="col-md-3">
                                    <label class="form-label" for="Customer">Customer</label>
                                    <select required id="Customer" name="Customer" class="select2 select21 form-select"
                                            data-allow-clear="true" data-placeholder="Select Customer">
                                        <option value="">Select</option>
                                        @foreach (\App\Models\Customer::all() as $data)
                                            <option value="{{ $data->id }}">{{ $data->company_name }} -
                                                {{ $data->buyer_name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="Category">Category</label>
                                    <select required id="Category" name="Category" class="select2 select21 form-select"
                                            data-allow-clear="true" onchange="" data-placeholder="Select Category">
                                        <option value="">Select</option>
                                        @foreach ($categorys as $category)
                                            <option @php if($category->id==old('Category')){ echo 'selected';} @endphp
                                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="SubCategory">Sub Category</label>
                                    <select required id="SubCategory" name="SubCategory" class="select2 form-select"
                                            data-allow-clear="true" data-placeholder="Select Sub Category">
                                        <option value="">Select</option>
                                        @foreach ($SubCategoryData as $SubCategory)
                                            <option @php if($SubCategory->id==old('SubCategory')){ echo 'selected';} @endphp
                                                    value="{{ $SubCategory->id }}">{{ $SubCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="Demographic">Demographic</label>
                                    <select required id="Demographic" name="Demographic"
                                            class="select2 select21 form-select" data-allow-clear="true"
                                            data-placeholder="Select Demographic">
                                        <option value="">Select</option>
                                        @foreach (\App\Models\Demographic::all() as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="Fit">Fit</label>
                                    <select required id="Fit" name="Fit" class="select2 select21 form-select"
                                            data-allow-clear="true" data-placeholder="Select Fit">
                                        <option value="">Select</option>
                                        @foreach (\App\Models\Fit::all() as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="Season">Season</label>
                                    <select required id="Season" name="Season" class="select2 select21 form-select"
                                            data-allow-clear="true" data-placeholder="Select Season">
                                        <option value="">Select</option>
                                        @foreach (\App\Models\Season::all() as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="Designer">Designer</label>
                                    <select id="Designer" name="Designer" class="select2 select21 form-select"
                                            data-allow-clear="true" data-placeholder="Select Designer">
                                        <option value="">Select</option>
                                        @foreach (\App\Models\User::where('role','designer')->get() as $user)
                                            <option value="{{ $user->id }}">{{ $user->company_name }} -
                                                {{ $user->person_name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                {{-- <div class="col-md-3">
                                    <label class="form-label" for="Designer">Designer</label>
                                    <input required type="text" id="Designer" name="DesignerName"
                                        class="form-control" placeholder="Enter Designer Name" />
                                </div>--}}
								 <div class="col-md-3">
                                    <label class="form-label" for="Merchant">Merchant</label>
                                    <select id="Merchant" name="Merchant" class="select2 select21 form-select"
                                        data-allow-clear="true" data-placeholder="Select Merchant">
                                        <option value="">Select</option>
                                        @foreach (\App\Models\User::where('role', 'merchant')->get() as $user)
                                            <option value="{{ $user->id }}">{{ $user->company_name }} -
                                                {{ $user->person_name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="Color">Color</label>
                                    <input class="form-control" name="Color" placeholder="Color" id="Color"
                                           type="text">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="rate">Rate</label>
                                    <input class="form-control" name="rate" placeholder="Rate" id="rate"
                                           type="text">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="production-weight">Production Weight</label>
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <input class="form-control" name="SampleWeight" placeholder="Sample"
                                                   id="SampleWeight" type="number">
                                        </div>
                                        <div class="col-lg-1">:</div>
                                        <div class="col-lg-5">
                                            <input class="form-control" name="ProductionWeight" placeholder="Production"
                                                   id="ProductionWeight" type="number">
                                        </div>
                                    </div>
                                </div>

                                <div class="divider mt-5">
                                    <div class="divider-text">Other Information</div>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="sample_photo">Sample Photo</label>
                                    <input type="file" id="sample_photo" name="sample_photo" class="form-control"
                                           placeholder="Sample Photo" />
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="tech_pack">Tech Pack</label>
                                    <input type="file" id="tech_pack" name="tech_pack" class="form-control"
                                           placeholder="Tech Pack" />
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="trim_card">Trim Card</label>
                                    <input type="file" id="trim_card" name="trim_card" class="form-control"
                                           placeholder="Trim Card" />
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="spec_sheet">Specs Sheet</label>
                                    <input type="file" id="spec_sheet" name="spec_sheet" class="form-control"
                                           placeholder="Specs Sheet" />
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="bom_sheet">BOM(Cost) Sheet</label>
                                    <input type="file" id="bom_sheet" name="bom_sheet" class="form-control"
                                           placeholder="BOM Sheet" />


                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="final_image">Final Image</label>
                                    <input type="file" id="final_image" name="final_image" class="form-control"
                                           placeholder="Final Image" />
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div id="bomSheetContainer">

            <h4 class="mt-5">
                <span class="text-muted fw-light float-left">BOM Sheet/</span> Add
            </h4>
                <div class="card">
                        <div id="wizard-checkout" class="bs-stepper wizard-icons wizard-icons-example">
                            <div class="bs-stepper-header m-auto border-0 py-4">
                                <div class="step" data-target="#process">
                                    <button type="button" class="step-trigger">
                                    <span class="bs-stepper-icon">
                                        <svg viewBox="0 0 58 54">
                                            <use xlink:href="../../assets/svg/icons/wizard-checkout-cart.svg#wizardCart">
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
                            {{-- Alternative Raw Material Design --}}
                            <div class="bs-stepper-content border-top" id="wizard-checkout-form">
                                <!-- Cart -->
                                <div id="process" class="content">
                                    <div id="processData">


                                        <div class="row g-3">
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
                                                <input type="text" onkeyup="processCalculateValue(0)" id="processQty0"
                                                       name="processData[0][processQty]" class="form-control"
                                                       placeholder="Quantity" />
                                            </div>
                                            <div class="col-md-2" style="float: right">
                                                <label class="form-label">Rate</label>
                                                <input type="text" onkeyup="processCalculateValue(0)" id="processRate0"
                                                       name="processData[0][processRate]" class="form-control"
                                                       placeholder="Rate" />
                                            </div>

                                            <div class="col-md-2" style="float: right">
                                                <label class="form-label">Value</label>
                                                <input type="text" id="processValue0"
                                                       name="processData[0][processValue]"
                                                       class="form-control" placeholder="Value" />
                                            </div>

                                            <div class="col-md-2" style="float: right">
                                                <label class="form-label">Duration</label>
                                                <input type="number" id="processDuration0"
                                                       name="processData[0][processDuration]" class="form-control"
                                                       placeholder="Duration" />
                                            </div>

                                        </div>

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

                                        <div class="row g-3">
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
                                                       class="form-control"
                                                       placeholder="Per Pc Qty" />
                                            </div>
                                            <div class="col-md-2 col-lg-1">
                                                <label class="form-label">Order Qty</label>
                                                <input type="number" step="any" onkeyup="bomCalculateValue(0)"
                                                       id="rawOrderQty0" name="bomListData[0][rawOrderQty]"
                                                       class="form-control"
                                                       placeholder="Order Qty" />
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
                            </div>
                        </div>

                </div>

        </div>

        <div class="row px-0 mt-5">
            <div class="col-lg-2 col-md-12 col-sm-12">
                <button type="submit" class="btn btn-primary d-grid w-100">Save</button>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
                <button type="submit" name="AddMore" value="1"
                        class="btn btn-label-primary waves-effect d-grid w-100">Save & Add
                    more
                </button>
            </div>
        </div>
    </form>


    <script>
      // Define JavaScript variables from PHP


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


      var categoryMasters = {!! json_encode($categoryMasters) !!};
      var subcategoryMasters = {!! json_encode($subcategoryMasters) !!};

      function addBomListItem(dataId) {
        // var categoryMasters = {
        //     !!json_encode($categoryMasters) !!
        // };
        // var subcategoryMasters = {
        //     !!json_encode($subcategoryMasters) !!
        // };
        // var itemMasters = {
        //     !!json_encode($itemMasters) !!
        // };
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

    </script>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
  function getStyleDetails() {
    var CopyStyleNoId = document.getElementById('CopyStyleNoId').value;
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: '{{ route('getStyleDetails') }}',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        styleId: CopyStyleNoId,
        '_token': "{{ csrf_token() }}"
      },
      success: function(result) {
        // $("#getCompanyBillDetails").html(result.billto);
          $('#Brand').val(result.StyleData.brand_id);
                $('#Febric').val(result.StyleData.febric);
                $('#Customer').val(result.StyleData.customer_id);
                $('#Category').val(result.StyleData.style_category_id);
                $('#SubCategory').val(result.StyleData.style_subcategory_id);
                $('#Fit').val(result.StyleData.fit_id);
                $('#Demographic').val(result.StyleData.demographic_master_id);

                $('#Season').val(result.StyleData.season_id);
                $('#Designer').val(result.StyleData.designer_id);
                $('#Merchant').val(result.StyleData.merchant_id);
                $('#rate').val(result.StyleData.rate);
                $('#SampleWeight').val(result.StyleData.sample);
                $('#ProductionWeight').val(result.StyleData.production);
                $('#Color').val(result.StyleData.color);
                // $("#po_number").val(result.po_number);

                $('#Brand').trigger('change');
                $('#Febric').trigger('change');
                $('#Customer').trigger('change');
                $('#Category').trigger('change');
                $('#SubCategory').trigger('change');
                $('#Fit').trigger('change');
                $('#Season').trigger('change');
                $('#Designer').trigger('change');
                $('#Merchant').trigger('change');
                $('#Demographic').trigger('change');

                // Refresh Select2
                $('#Brand').select2('refresh');
                $('#Febric').select2('refresh');
                $('#Customer').select2('refresh');
                $('#Category').select2('refresh');
                $('#SubCategory').select2('refresh');
                $('#Fit').select2('refresh');
                $('#Season').select2('refresh');
                $('#Designer').select2('refresh');
                $('#Merchant').select2('refresh');
                $('#Demographic').select2('refresh');

      }
    });
  }

  function toggleCopyStyleVisibility() {
    var copyStyleCheck = document.getElementById('CopyFromStyleCheck');
    var copyStyleContainer = document.getElementById('CopyFromStyleNoDiv');

    if (copyStyleCheck.checked) {
      copyStyleContainer.style.display = 'Block'; // Hide the table when checkbox is checked
    } else {
      copyStyleContainer.style.display = 'None'; // Show the table when checkbox is unchecked
    }
  }

  function toggleDivisionVisibility() {
    var bomCheck = document.getElementById('FillBomSheet');
    var bomSheetContainer = document.getElementById('bomSheetContainer');

    if (bomCheck.checked) {
      bomSheetContainer.style.display = 'Block'; // Hide the table when checkbox is checked
    } else {
      bomSheetContainer.style.display = 'None'; // Show the table when checkbox is unchecked
    }

  }
</script>
<script>
  $(document).ready(function() {
    $('#Category').change(function() {
      var categoryId = $(this).val();
      if (categoryId) {
        $.ajax({
          type: 'GET',
          url: "{{ route('getStyleSubCategories') }}",
          data: {
            categoryId: categoryId
          },
          dataType: 'json',
          success: function(response) {
            $('#SubCategory').empty();
            $.each(response, function(key, value) {
              $('#SubCategory').append('<option value="' + value.id +
                '">' + value.name + '</option>');
            });
          }
        });
      } else {
        $('#SubCategory').empty();
      }
    });
  });
</script>
<script>
  // $(".select21").select2();
  // Check selected custom option
  window.Helpers.initCustomOptionCheck();

  $(document).ready(function() {
    $('.select21').select2();
  });
</script>
<script>
  // // Add this code to generate CSRF token
  // var csrfToken = "{{ csrf_token() }}";

  // // Add CSRF token to AJAX headers
  // $.ajaxSetup({
  //     headers: {
  //         'X-CSRF-TOKEN': csrfToken
  //     }
  // });

  function getSubcategories() {
    // Get the selected category ID
    var categoryId = $('#Category').val();

    // Make an AJAX request to get subcategories
    $.ajax({
      url: '/style-master/subCategory', // Replace with your actual route
      method: 'get',
      data: {
        categoryId: categoryId
      },
      success: function(data) {
        // Clear the existing options in the SubCategory dropdown
        $('#SubCategory').empty();

        // Add the default "Select" option
        $('#SubCategory').append('<option value="">Select</option>');

        // Add the retrieved subcategories to the dropdown
        $.each(data, function(index, SubCategoryData) {
          $('#SubCategory').append('<option value="' + SubCategoryData.id + '">' +
            SubCategoryData
              .name + '</option>');
        });
      },
      error: function(xhr, status, error) {
        // Handle error if needed
        console.error(error);
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
</script>
