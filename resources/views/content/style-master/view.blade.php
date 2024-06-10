@extends('layouts/layoutMaster')

@section('title', 'View Style')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>

@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection


@section('content')

    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left">Style /</span> View
    </h4>
    <div class="row">
        <div class="col-12">


            <div class="card">
                {{-- <h5 class="card-header">Applicable Categories</h5> --}}
                <div class="card-body">
                    <div class="content">
                        <div class="content-header mb-4">
                            <h3 class="mb-1">Style (Sample) Information</h3>
                        </div>

                        <div class="row g-4">

                        </div>
                        <div class="row">

                            <div class="row g-4 mt-4">
                                <div class="col-md-3">
                                    <label class="form-label" for="Style_date">Date</label>
                                    <input type="date" class="form-control date-picker" id="Style_date" name="Style_date"
                                        placeholder="YYYY-MM-DD" value="{{ $StyleMaster->style_date }}" readonly />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="Style_No">Style No</label>
                                    <input required type="text" id="Style_No" name="Style_No" class="form-control"
                                        placeholder="Style No" value="{{ $StyleMaster->style_no }}" readonly />
                                </div>
								 <div class="col-md-3">
                                    <label class="form-label" for="Febric">Fabric</label>
                                    <input required type="text" id="Febric" value="{{ $StyleMaster->febric }}"
                                        name="Febric" class="form-control" placeholder="Fabric" readonly />
                                </div>
								
								<div class="col-md-3">
                                    <label class="form-label" for="Brand">Brand</label>
                                    <input required type="text" id="Brand"
                                        value="{{ $StyleMaster->Brand->name ?? '' }}" name="Brand" class="form-control"
                                        placeholder="Brand" readonly />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="Customer">Customer</label>
                                    <input required type="text" id="Customer"
                                        value="{{ $StyleMaster->Customer->company_name }}-{{ $StyleMaster->Customer->buyer_name }}"
                                        name="Customer" class="form-control" placeholder="Customer" readonly />
                                </div>

                               

                                <div class="col-md-3">
                                    <label class="form-label" for="Category">Category</label>
                                    <input required type="text" id="Category"
                                        value="{{ $StyleMaster->StyleCategory->name ?? '' }}" name="Category"
                                        class="form-control" placeholder="Category" readonly />
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="SubCategory">Sub Category</label>
                                    <input required type="text" id="SubCategory" name="SubCategory"
                                        value="{{ $StyleMaster->StyleSubCategory->name ?? '' }}" class="form-control"
                                        placeholder="Sub-category" readonly />
                                </div>
								
                                <div class="col-md-3">
                                  <label class="form-label" for="Demographic">Demographic</label>
                                  <input required type="text" id="Demographic" value="{{ $StyleMaster->Demographic->name ?? '' }}"
                                      name="Demographic" class="form-control" placeholder="Demographic" readonly />
                              </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="Fit">Fit</label>
                                    <input required type="text" id="Fit" name="Fit"
                                        value="{{ $StyleMaster->Fit->name }}" class="form-control" placeholder="Fit"
                                        readonly />
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="Season">Season</label>
                                    <input required type="text" id="Season" value="{{ $StyleMaster->Season->name }}"
                                        name="Season" class="form-control" placeholder="Season" readonly />
                                </div>

								@if (!empty($StyleMaster->designer_id))
                                <div class="col-md-3">
                                    <label class="form-label" for="Designer">Designer</label>
                                    <input required type="text" id="Designer"
                                        value="{{ $StyleMaster->Designer->company_name }}-{{ $StyleMaster->Designer->person_name }}"
                                        name="Designer" class="form-control" placeholder="Designer" readonly />
                                </div>
								@else
								  <div class="col-md-3">
                                            <label class="form-label" for="Designer">Designer</label>
                                            <input required type="text" value="{{$StyleMaster->designer_name}}" id="Designer" name="DesignerName"
                                                class="form-control" placeholder="Select Designer" readonly/>
                                        </div>
                                    @endif
								
								 <div class="col-md-3">
                                    <label class="form-label" for="Merchant">Merchant</label>
                                    <select required id="Merchant" name="Merchant" class="select2 select21 form-select"
                                        data-allow-clear="true" data-placeholder="Select Merchant">
                                        <option value="">Select</option>
                                        @foreach (\App\Models\User::where('role', 'merchant')->get() as $user)
                                            <option {{ $StyleMaster->merchant_id == $user->id ? 'Selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->company_name }} -
                                                {{ $user->person_name }}</option>
                                        @endforeach

                                    </select>
                                </div>
								
                                <div class="col-md-3">
                                    <label class="form-label" for="Color">Color</label>
                                    <input class="form-control" name="Color" placeholder="Color"
                                        value="{{ $StyleMaster->color }}" id="Color" type="text" readonly>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="rate">Rate</label>
                                    <input class="form-control" name="rate" placeholder="Rate"
                                        value="{{ $StyleMaster->rate }}" id="rate" type="number" readonly>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="production-weight">Production Weight</label>
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <input class="form-control" name="SampleWeight" placeholder="Sample"
                                                id="SampleWeight" value="{{ $StyleMaster->sample }}" type="number"
                                                readonly>
                                        </div>
                                        <div class="col-lg-1">:</div>
                                        <div class="col-lg-5">
                                            <input class="form-control" name="ProductionWeight" placeholder="Production"
                                                value="{{ $StyleMaster->production }}" id="ProductionWeight"
                                                type="number" readonly>
                                        </div>
                                    </div>
                                </div>

                              <div class="row g-3 mt-3">
                                <div class="col-12 col-lg-12  col-md-12">
                                  <div class="card">
                                    <div class="card-header">
                                      <h4>Process List</h4>
                                    </div>
                                    <div class="card-body table-responsive pt-0">
                                      <table class="datatables-basic  table" id="datatable-list-process">
                                        <thead class="table-secondary">
                                        <tr>
                                          <th>Sr No</th>
                                          <th>Process</th>
                                          <th>Qty</th>
                                          <th>Rate</th>
                                          <th>Amount</th>
                                          <th>Duration</th>
                                        </tr>
                                        </thead>
                                        <tbody id="dataTableBody">
                                        @php
                                          $totalQty = 0;
                                          $totalRate = 0;
                                          $totalValue = 0;
                                          $totalDuration = 0;
                                        @endphp
                                          @foreach ($StyleMaster->StyleMasterProcesses as $StyleMasterProcesses)
                                            <tr>
                                              <td>{{ $StyleMasterProcesses->sr_no }}</td>
                                              <td>{{ $StyleMasterProcesses->ProcessMaster->name ?? '' }}</td>
                                              <td>{{ $StyleMasterProcesses->qty }}</td>
                                              <td>{{ $StyleMasterProcesses->rate }}</td>
                                              <td>{{ $StyleMasterProcesses->value }}</td>
                                              <td>{{ $StyleMasterProcesses->duration }}</td>
                                            </tr>
                                            @php
                                              $totalQty += $StyleMasterProcesses->qty;
                                              $totalRate += $StyleMasterProcesses->rate;
                                              $totalValue += $StyleMasterProcesses->value;
                                              $totalDuration += $StyleMasterProcesses->duration;
                                            @endphp
                                          @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                          <td></td>
                                          <td></td>
                                          <td>{{ $totalQty }}</td>
                                          <td>{{ $totalRate }}</td>
                                          <td>{{ $totalValue }}</td>
                                          <td>{{ $totalDuration }}</td>
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
                                        <thead class="table-secondary">
                                        <tr>
                                          <th>Sr.No</th>
                                          <th>Category</th>
                                          <th>Sub Category</th>
                                          <th>Item</th>
                                          <th>Available Qty</th>
                                          <th>Rate</th>
                                        </tr>
                                        </thead>
                                        <tbody id="dataTableBody">
                                        @php
                                          $totalAvailableQty = 0;
                                          $totalRate = 0;
                                        @endphp
                                          @php $num =1; @endphp
                                          @foreach ($StyleMaster->StyleMasterMaterials as $StyleMasterMaterials)
                                            @if (!empty($StyleMasterMaterials->id))
                                              @php
                                                $totalAvailableQty += $StyleMasterMaterials->available_qty;
                                                $totalRate += $StyleMasterMaterials->rate;
                                              @endphp
                                              <tr>
                                                <td>{{ $num }}</td>
                                                <td>{{ $StyleMasterMaterials->Item->ItemCategory->name ?? '' }}</td>
                                                <td>{{ $StyleMasterMaterials->Item->ItemSubCategory->name ?? '' }}
                                                </td>
                                                <td>{{ $StyleMasterMaterials->Item->name ?? '' }}</td>
                                                <td width="200">{{ $StyleMasterMaterials->available_qty }}
                                                </td>
                                                <td>{{ $StyleMasterMaterials->rate }}</td>
                                              </tr>
                                            @endif
                                            @php $num ++; @endphp
                                          @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                          <td colspan="4">All Total</td>
                                          <td>{{ $totalAvailableQty }}</td>
                                          <td>{{ $totalRate }}</td>
                                        </tr>
                                        </tfoot>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                              </div>


                                <div class="divider mt-5">
                                    <div class="divider-text">Other Information</div>
                                </div>


                              <div class="col-md-3">
                                    <label class="form-label" for="sample_photo">Sample Photo</label>
                                    @if (!empty($StyleMaster->sample_photo))
                                        <p class="mt-2"><a target="_blank"
                                                href="{{ Helper::getSamplePhoto($StyleMaster->id, $StyleMaster->sample_photo) }}"
                                                download>
                                                Sample Photo :-- Download</a></p>
                                        <p class="mt-2">
                                            <a href="{{ Helper::getSamplePhoto($StyleMaster->id, $StyleMaster->sample_photo) }}"
                                                target="_blank">
                                                <img width="100px" height="75px"
                                                    src="{{ Helper::getSamplePhoto($StyleMaster->id, $StyleMaster->sample_photo) }}"
                                                    alt="Sample Photo">
                                            </a>
                                        </p>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="tech_pack">Tech Pack</label>
                                    @if (!empty($StyleMaster->tech_pack))
                                        <p class="mt-2"><a target="_blank"
                                                href="{{ Helper::getTechPack($StyleMaster->id, $StyleMaster->tech_pack) }}"
                                                download>
                                                Tech Pack :-- Download</a></p>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="trim_card">Trim Card</label>
                                    @if (!empty($StyleMaster->trim_card))
                                        <p class="mt-2"><a target="_blank"
                                                href="{{ Helper::getTrimCard($StyleMaster->id, $StyleMaster->trim_card) }}"
                                                download>
                                                Trim Card :-- Download</a></p>
                                    @endif
                                </div>


                                <div class="col-md-3">
                                    <label class="form-label" for="spec_sheet">Specs Sheet</label>
                                    @if (!empty($StyleMaster->specs_sheet))
                                        <p class="mt-2"><a target="_blank"
                                                href="{{ Helper::getSpecSheet($StyleMaster->id, $StyleMaster->specs_sheet) }}"
                                                download>
                                                Spec Sheet :-- Download</a></p>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="bom_sheet">BOM(Cost) Sheet</label>
                                    @if (!empty($StyleMaster->bom_sheet))
                                        <p class="mt-2"><a target="_blank"
                                                href="{{ Helper::getBomSheet($StyleMaster->id, $StyleMaster->bom_sheet) }}"
                                                download>
                                                Bom Sheet :-- Download</a></p>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="final_image">Final Image</label>
                                    @if (!empty($StyleMaster->final_image))
                                        <p class="mt-2"><a target="_blank"
                                                href="{{ Helper::getFinalImage($StyleMaster->id, $StyleMaster->final_image) }}"
                                                download>
                                                Final Image Sheet :-- Download</a></p>
                                        <p class="mt-2">
                                            <a href="{{ Helper::getFinalImage($StyleMaster->id, $StyleMaster->final_image) }}"
                                                target="_blank">
                                                <img width="100px" height="75px"
                                                    src="{{ Helper::getFinalImage($StyleMaster->id, $StyleMaster->final_image) }}"
                                                    alt="Sample Photo">
                                            </a>
                                        </p>
                                    @endif

                                </div>

                            </div>
                            <div class="col-lg-3 col-12 invoice-actions mt-5">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
<script>
    // $(".select21").select2();
    // Check selected custom option
    window.Helpers.initCustomOptionCheck();

    $(document).ready(function() {
        $(".select21").select2();
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
</script>
