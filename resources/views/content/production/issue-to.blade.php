@extends('layouts.layoutMaster')

@section('title', 'Issue To')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />

@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>

@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left"></span>Issue To
    </h4>
    <form class="source-item" action="{{ route('issue.issueToStore') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row invoice-add">
            <!-- Invoice Add-->
            <input type="hidden" value="{{ $job_id }}" name="job_id">
            <input type="hidden" value="{{ $d_id }}" name="d_id">
            <div class="col-lg-12 col-12 mb-lg-0 mb-4">
                <div class="card">
                    {{-- <h5 class="card-header">Applicable Categories</h5> --}}
                    <div class="card-body">

                        <div class="content">

                            <div class="content-header mb-4">
                                <h4 class="mb-1">Primary Information</h4>
                            </div>
                            <div class="row g-3">

                                <div class="col-md-2">
                                    <label class="form-label" for="JobOrderDate">Date</label>
                                    <input type="date" class="form-control date-picker" id="JobOrderDate"
                                        name="JobOrderDate" readonly value="{{ $JobOrders->date }}" />
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="OrderId">Job Order No.</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $JobOrders->job_order_no }}" />
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="StyleId">Style No.</label>
                                    <select readonly id="StyleNo" name="StyleNo" class="select2 select21 form-select"
                                        data-allow-clear="true" data-placeholder="Select Style"
                                        onchange="getStyleDetails()">
                                        <option value="">Select</option>
                                        @if ($JobOrders->type == 'regular')
                                            <option selected value="{{ $StyleMaster->id }}">
                                                {{ $JobOrders->SalesOrderStyleInfo->StyleMaster->style_no ?? '' }}
                                                / {{ $JobOrders->SalesOrderStyleInfo->customer_style_no ?? '' }}
                                            </option>
                                        @else
                                            <option selected value="{{ $StyleMaster->id }}">
                                                {{ $StyleMaster->style_no ?? '' }}
                                                / {{ $StyleMaster->customer_style_no ?? '' }}
                                            </option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-2 mb-4">
                                    <label for="select2Primary" class="form-label">Job Card Qty</label>
                                    <input type="text" class="form-control" value="{{ $JobOrders->qty }}" readonly />
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label" for="Rate">Rate</label>
                                    <input type="text" class="form-control" value="{{ $JobOrders->rate }}"
                                        placeholder="Rate" readonly />
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

                <div class="accordion accordion-margin mt-2 mb-2">
                    {!! $htmlTableOld !!}
                </div>

                <div class="card invoice-preview-card">

                    <div class="card-body">
                        <div class="users-list-filter">

                            <h4>Currently, JobCard Available in <b>{{ $currentDepartmentName }}</b> Department
                            </h4>
                            {!! $htmlTable !!}
                        </div>
                    </div>
                </div>
                <div class="mt-2 card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="row align-item-center">
                                    {{-- <div class="form-check form-check-primary col-md-5">
                                        <input class="form-check-input" type="radio" name="issueType" id="departmentRadio"
                                            checked onchange="checkIssueType()" value="department" />
                                        <label class="form-check-label" for="WithJobOrder">Department</label>
                                    </div> --}}
                                    {{-- <div class="form-check form-check-primary col-md-7">
                                        <input class="form-check-input" type="radio" name="issueType" id="jobCenterRadio"
                                            onchange="checkIssueType()" value="service">
                                        <label class="form-check-label" for="WithJobOrder">Service Provider</label>
                                    </div> --}}


                                    <div class="form-check custom-option custom-option-basic col-md-12">
                                        <label class="form-check-label custom-option-content" for="departmentRadio">
                                            <input name="issueType" class="form-check-input" type="radio"
                                                value="department" onchange="checkIssueType()" id="departmentRadio"
                                                checked />
                                            <span class="custom-option-header">
                                                <span class="h6 mb-0">Department</span>
                                                {{-- <span class="text-muted">Free</span> --}}
                                            </span>
                                            {{-- <span class="custom-option-body">
                                              <small>Get 1 project with 1 teams members.</small>
                                          </span> --}}
                                        </label>
                                    </div>



                                </div>
                            </div>
                            <div class="col-md-3" id="departmentDropDown">
                                <label class="form-label" for="form-repeater-1-1">Issue to Department</label>
                                <select id="department_id" name="department_id" onchange="getDepartmentDetails();"
                                    class="select2 form-select" data-placeholder="Select Issue to Department">
                                    <option value="">Select Issue to Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3" id="serviceDropDown">
                                <label class="form-label" for="form-repeater-1-1">Service Provider</label>
                                <select id="service_id" name="service_id" onchange="getVendorDetails();"
                                    class="select2 form-select" data-placeholder="Select Service">
                                    <option value="">Select Service Provider</option>
                                    @foreach ($serviceProviders as $serviceProvider)
                                        <option value="{{ $serviceProvider->id }}">{{ $serviceProvider->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3" id="emptyDropDown">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label for="select2Primary" class="form-label">Total Cut Qty</label>
                                <input type="text" class="form-control" id="TotalQty" name="Qty"
                                    placeholder="Total qty" {{ $JobOrders->type == 'regular' ? 'readonly' : '' }}>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="row align-item-center">
                                    <div class="form-check custom-option custom-option-basic col-md-12">
                                        <label class="form-check-label custom-option-content" for="jobCenterRadio">
                                            <input name="issueType" class="form-check-input" type="radio"
                                                value="service" id="jobCenterRadio" onchange="checkIssueType()" />
                                            <span class="custom-option-header">
                                                <span class="h6 mb-0">Service Provider</span>
                                                {{-- <span class="text-muted">$ 5.00</span> --}}
                                            </span>
                                            {{-- <span class="custom-option-body">
                                        <small>Get 5 projects with 5 team members.</small>
                                    </span> --}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2"></div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label" for="Cost Per Pisces">Value added Cost Per Piece</label>
                                <input required="" type="text" value="0" id="cost"
                                    onkeyup="ValueAddedCostToTotal();" name="cost" class="form-control"
                                    placeholder="Cost Per Piece">
                            </div>
                            <div class="col-md-9 mb-2"></div>
                            <div class="col-md-3 mb-2">
                                <label for="select2Primary" class="form-label">Total Amount</label>
                                <input type="text" class="form-control" id="totalAmount" name="totalAmount"
                                    placeholder="Total Amount" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($processMasterType == 'cutting')
                    <div class="mt-2 card">
                        <div class="card-body">
                            <div id="Stiching" class="mt-3 content">
                                <div class="content-header mb-4">
                                    <h4 class="mb-1">Raw Material</h4>
                                </div>
                                <HR>
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
                                        <div class="col-md-2" hidden>
                                            <label class="form-label">Per Pc Qty</label>
                                            <input type="number" step="any" onkeyup="bomCalculateValue(0)"
                                                id="rawPerPcQty0" name="bomListData[0][rawPerPcQty]" class="form-control"
                                                value="1" placeholder="Per Pc Qty" />
                                        </div>
                                        <div class="col-md-1">
                                            <label class="form-label">Consume Qty</label>
                                            <input type="number" step="any" onkeyup="bomCalculateValue(0)"
                                                id="rawOrderQty0" name="bomListData[0][rawOrderQty]" class="form-control"
                                                value="0" placeholder="Consume Qty" />
                                        </div>
                                        <div class="col-md-2" hidden>
                                            <label class="form-label">Required Qty</label>
                                            <input type="number" step="any" onkeyup="bomCalculateValue(0)"
                                                id="rawRequiredQty0" value="0" name="bomListData[0][rawRequiredQty]"
                                                class="form-control" placeholder="Qty" />
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Available Qty</label>
                                            <input type="number" step="any" id="rawAvailableQty0"
                                                name="bomListData[0][rawAvailableQty]" value="0"
                                                class="form-control" placeholder="Qty" />
                                        </div>

                                        <div class="col-md-1" style="float: right">
                                            <label class="form-label">Rate</label>
                                            <input type="number" step="any" id="rawRate0"
                                                name="bomListData[0][rawRate]" class="form-control"
                                                onkeyup="bomCalculateValue(0)" value="0" placeholder="Total Rate" />
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Total</label>
                                            <input type="number" step="any" id="rawTotal0"
                                                name="bomListData[0][rawTotal]" value="0" class="form-control"
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
                @elseif($processMasterType == 'cad')
                    <div class="mt-2 card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="content-header">
                                        <h4 class="">Process</h4>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="content-header">
                                        <h4 class="">Attachment</h4>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="content-header">
                                        <h4 class="">Instruction</h4>
                                    </div>
                                </div>
                                <hr>


                                <div class="col-lg-4 mt-4">
                                    <h5><label class="form-label" for="CadInstruction">
                                            CAD Instruction
                                        </label></h5>
                                </div>
                                <div class="col-lg-4 mt-4">
                                    <input type="file" id="cad" name="cad" class="form-control"
                                        placeholder="">
                                    @if (!empty($JobOrders->cad))
                                        <p class="mt-2"><a target="_blank"
                                                href="{{ url('jobOrders/' . $JobOrders->id . '/' . $JobOrders->cad) }}">{{ $JobOrders->cad }}</a>
                                        </p>
                                    @endif
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <textarea class="form-control" id="cad_desc" name="cad_desc" placeholder="CAD Instruction">{{ $JobOrders->cad_desc }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div id="withPoContainer" class="mt-4">
                    <div class="form-group col-sm-12 mt-3">

                        <div class="row px-0 mt-4">
                            <div class="col-lg-2 col-md-12 col-sm-12">
                                <button type="submit" class="btn btn-primary d-grid w-100">Save</button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Offcanvas -->
    @include('_partials._offcanvas.offcanvas-send-invoice')
    <!-- /Offcanvas -->
@endsection
<script>
    window.onload = function() {
        calculateTotalSum();
        getStyleDetails();
        checkIssueType();
    };

    function ValueAddedCostToTotal() {
        var cost = parseFloat(document.getElementById('cost').value);
        var TotalQty = parseFloat(document.getElementById('TotalQty').value);
        var value = TotalQty * cost;
        document.getElementById('totalAmount').value = value.toFixed(2);
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
        var jobType = '{{ $JobOrders->type }}';
        var setUrl = '{{ route('getPlanningStyleDetails') }}';
        if (jobType === 'regular') {
            setUrl = '{{ route('getSampleStyleDetails') }}';
        }
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: setUrl,
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

    function calculateColorTotal(color) {

        var isPacking = {!! json_encode($isPacking) !!};
        var total = 0;
        if (isPacking) {

            let FStotal = 0;
            document.querySelectorAll(`input[name^='FSSizeWiseQty[${color}]']`).forEach(function(inputElement) {
                FStotal += Number(inputElement.value);
            });
            document.getElementById(`TotalColorFS${color}`).innerText = FStotal;

            let SStotal = 0;
            document.querySelectorAll(`input[name^='SSaleSizeWiseQty[${color}]']`).forEach(function(inputElement) {
                SStotal += Number(inputElement.value);
            });
            document.getElementById(`TotalColorSS${color}`).innerText = SStotal;

            let Rtotal = 0;
            document.querySelectorAll(`input[name^='RejectSizeWiseQty[${color}]']`).forEach(function(inputElement) {
                Rtotal += Number(inputElement.value);
            });
            document.getElementById(`TotalColorR${color}`).innerText = Rtotal;
            total = FStotal + SStotal + Rtotal;
        } else {
            document.querySelectorAll(`input[name^='SizeWiseQty[${color}]']`).forEach(function(inputElement) {
                total += Number(inputElement.value);
            });
        }

        document.getElementById(`TotalColor${color}`).innerText = total;
        ValueAddedCostToTotal();
        calculateTotalSum();
    }

    function calculateTotalSum() {
        let colors = document.querySelectorAll(`input[name^="colorWiseCheckBox[]"]`);
        let totalSum = 0;

        // Iterate through each color checkbox
        colors.forEach(function(colorCheckbox) {
            let color = colorCheckbox.value;
            // If the color checkbox is checked
            if (colorCheckbox.checked) {
                var isPacking = {!! json_encode($isPacking) !!};

                if (isPacking) {
                    document.querySelectorAll(`input[name^='FSSizeWiseQty[${color}]']`).forEach(function(
                        inputElement) {
                        totalSum += Number(inputElement.value);
                    });

                    document.querySelectorAll(`input[name^='SSaleSizeWiseQty[${color}]']`).forEach(function(
                        inputElement) {
                        totalSum += Number(inputElement.value);
                    });

                    document.querySelectorAll(`input[name^='RejectSizeWiseQty[${color}]']`).forEach(function(
                        inputElement) {
                        totalSum += Number(inputElement.value);
                    });
                } else {
                    document.querySelectorAll(`input[name^='SizeWiseQty[${color}]']`).forEach(function(
                        inputElement) {
                        totalSum += Number(inputElement.value);
                    });
                }
            }
        });

        $('#TotalQty').val(totalSum);
    }

    var categoryMasters = {!! json_encode($categoryMasters) !!};
    var subcategoryMasters = {!! json_encode($subcategoryMasters) !!};


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

    function addBomListItem(dataId) {

        var container = document.getElementById(dataId);
        var rowCount = container.getElementsByClassName('row').length;
        var oldRowCount = parseInt(rowCount) - 1;
        if (oldRowCount < 0) {
            oldRowCount = 0;
        }
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
<div class="col-md-2" hidden>
    <label class="form-label">Per Pc Qty</label>
    <input type="number" step="any" onkeyup="bomCalculateValue(${rowCount})" id="rawPerPcQty${rowCount}" name="bomListData[${rowCount}][rawPerPcQty]" value="1" class="form-control" placeholder="Per Pc Qty" />
                  </div>
                  <div class="col-md-1">
                      <label class="form-label">Consume Qty</label>
                      <input type="number" step="any" onkeyup="bomCalculateValue(${rowCount})" id="rawOrderQty${rowCount}" name="bomListData[${rowCount}][rawOrderQty]" class="form-control" placeholder="Consume Qty" />
                  </div>
                  <div class="col-md-2" hidden>
                      <label class="form-label">Required Qty</label>
                      <input type="number" step="any" id="rawRequiredQty${rowCount}" onkeyup="bomCalculateValue(${rowCount})" name="bomListData[${rowCount}][rawRequiredQty]" class="form-control" placeholder="Qty"/>
                  </div>
                   <div class="col-md-2">
                      <label class="form-label">Available Qty</label>
                      <input type="number" step="any" id="rawAvailableQty${rowCount}" name="bomListData[${rowCount}][rawAvailableQty]" class="form-control" placeholder="Qty"/>
                  </div>
                  <div class="col-md-1" style="float: right">
                      <label class="form-label">Rate</label>
                      <input type="number" step="any" id="rawRate${rowCount}" onkeyup="bomCalculateValue(${rowCount})" name="bomListData[${rowCount}][rawRate]" class="form-control" placeholder="Total Rate"/>
                  </div>
                  <div class="col-md-2">
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

    function getDepartmentDetails() {

    }

    function getVendorDetails() {

    }

    function checkIssueType() {
        // Get the selected radio button
        const issueType = document.querySelector('input[name="issueType"]:checked').value;

        // Get the dropdowns
        const departmentDropDown = document.getElementById('departmentDropDown');
        const serviceDropDown = document.getElementById('serviceDropDown');
        const emptyDropDown = document.getElementById('emptyDropDown');

        // Check the selected issue type and show the appropriate dropdown
        if (issueType === 'department') {
            departmentDropDown.style.display = 'block'; // Show department dropdown
            serviceDropDown.style.display = 'none'; // Hide service dropdown
            emptyDropDown.style.display = 'block'; // Hide service dropdown
        } else if (issueType === 'service') {
            // departmentDropDown.style.display = 'none'; // Hide department dropdown
            serviceDropDown.style.display = 'block'; // Show service dropdown
            emptyDropDown.style.display = 'none'; // Show service dropdown
        }
    }
</script>
