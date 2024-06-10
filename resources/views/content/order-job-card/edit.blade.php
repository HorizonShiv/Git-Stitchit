@extends('layouts/layoutMaster')

@section('title', 'Job Order Add')

@section('vendor-style')

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />


    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/rateyo/rateyo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/wizard-ex-checkout.css') }}" />

    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>

    <script src="{{ asset('assets/js/config.js') }}"></script>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
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
        <span class="text-muted fw-light float-left">Job Order/</span> Edit
    </h4>
    <form action="{{ route('order-job-card.update', $JobOrders->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12">

                <input type="hidden" value="{{ $planingOrder->sale_order_id }}" name="salesOrderId">
                <input type="hidden" value="{{ $planingOrder->id }}" name="planingOrderId">
                <div class="card">
                    {{-- <h5 class="card-header">Applicable Categories</h5> --}}
                    <div class="card-body">

                        <div class="content">

                            <div class="content-header mb-4">
                                <h4 class="mb-1">Primary Information</h4>
                            </div>
							<div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="JobCardNo">Job Card No.</label>
                                    <input type="text" class="form-control" id="JobCardNo" name="PlaningOrderNo"
                                        placeholder="Planing Order No" readonly
                                        value="{{ $JobOrders->job_order_no }}" />
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="OrderId">Planing Order No.</label>
                                    <input type="text" class="form-control" id="PlaningOrderNo" name="PlaningOrderNo"
                                        placeholder="Planing Order No" readonly
                                        value="{{ $planingOrder->planing_order_no }}" />
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="SalesOrderNo">Sales Order No.</label>
                                    <input type="text" class="form-control" id="SalesOrderNo" name="PlaningOrderNo"
                                        placeholder="Planing Order No" readonly
                                        value="{{ $planingOrder->SalesOrders->sales_order_no }}" />
                                </div>
                            </div>

                            <div class="divider mt-4">
                                <div class="divider-text">Fillable Details</div>
                            </div>
                            <div class="row g-3">
   <div class="col-md-2">
                                    <label class="form-label" for="JobOrderDate">Date</label>
                                    <input type="date" class="form-control date-picker" id="JobOrderDate"
                                        name="JobOrderDate" placeholder="YYYY-MM-DD"
                                        value="{{ $planingOrder->date ?? '' }}" readonly />
                                </div>


                                <div class="col-md-4">
                                    <label class="form-label" for="Customer">Customer</label>
                                    <input type="text" class="form-control" id="Customer" name="Customer"
                                        placeholder="Planing Order No" readonly
                                        value="{{ $planingOrder->SalesOrders->Customer[0]->company_name }}" />
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label" for="Brand">Brand</label>
                                    <input type="text" class="form-control" id="Brand" name="Brand"
                                        placeholder="Planing Order No" readonly
                                        value="{{ $planingOrder->SalesOrders->Brand[0]->name }}" />
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label" for="StyleId">Style No.</label>
                                    <select id="StyleNo" name="StyleNo" class="select2 select21 form-select"
                                        data-allow-clear="true" data-placeholder="Select Style"
                                        onchange="getStyleDetails()">
                                        <option value="">Select</option>
                                        @if (!empty($planingOrder))
                                            <option selected value="{{ $planingOrder->sales_order_style_id }}">
                                                {{ $planingOrder->SalesOrderStyleInfo[0]->StyleMaster->style_no ?? '' }}
                                                / {{ $planingOrder->SalesOrderStyleInfo[0]->customer_style_no ?? '' }}
                                            </option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-2 mb-4">
                                    <label for="select2Primary" class="form-label">Qty</label>
                                    <input type="text" class="form-control" id="TotalQty"
                                        value="{{ $JobOrders->qty }}" name="Qty" readonly="" />
                                </div>

                                <div class="col-md-2" hidden>
                                    <label class="form-label" for="Rate">Rate</label>
                                    <input type="rate" class="form-control date-picker" id="Rate"
                                        value="{{ $JobOrders->rate }}" name="Rate" placeholder="Rate" />
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

                {{-- Style Container --}}
                <div class="col-lg-12 col-md-6 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="content">
                                <div class="content-header mb-4">
                                    <h4 class="mb-1">Selected List</h4>
                                </div>

                                <div class="card-datatable table-responsive pt-0">
                                    {!! $htmlTable !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{-- End of Style Container --}}

                <div class="col-lg-12 col-md-6 mt-4">
                    <div class="card">
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
                                    <label class="form-label" for="CadInstruction">
                                        <h5>CAD Instruction</h5>
                                    </label>
                                </div>
                                <div class="col-lg-4 mt-4">
                                    <input type="file" id="cad" name="cad" class="form-control"
                                        placeholder="" />
                                    @if (!empty($JobOrders->cad))
                                        <p class="mt-2"><a target="_blank"
                                                href="{{ url('jobOrders/' . $JobOrders->id . '/' . $JobOrders->cad) }}">{{ $JobOrders->cad }}
                                                :-- Download</a></p>
                                    @endif
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <textarea class="form-control" id="cad_desc" name="cad_desc" placeholder="CAD Instruction">{{ $JobOrders->cad_desc }}</textarea>
                                </div>


                                <div class="col-lg-4 mt-4">
                                    <label class="form-label" for="Cutting_Instruction">
                                        <h5>Cutting Instruction</h5>
                                    </label>
                                </div>
                                <div class="col-lg-4 mt-4">
                                    <input type="file" id="cutting" name="cutting" class="form-control"
                                        placeholder="Specs Sheet" />
                                    @if (!empty($JobOrders->cutting))
                                        <p class="mt-2"><a target="_blank"
                                                href="{{ url('jobOrders/' . $JobOrders->id . '/' . $JobOrders->cutting) }}">{{ $JobOrders->cutting }}
                                                :-- Download</a></p>
                                    @endif
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <textarea class="form-control" id="cutting_desc" name="cutting_desc" placeholder="Cutting Instruction">{{ $JobOrders->cutting_desc }}</textarea>
                                </div>


                                <div class="col-lg-4 mt-4">
                                    <label class="form-label" for="Stitching_Instruction">
                                        <h5>Stitching Instruction</h5>
                                    </label>
                                </div>
                                <div class="col-lg-4 mt-4">
                                    <input type="file" id="stitching" name="stitching" class="form-control"
                                        placeholder="Specs Sheet" />
                                    @if (!empty($JobOrders->stitching))
                                        <p class="mt-2"><a target="_blank"
                                                href="{{ url('jobOrders/' . $JobOrders->id . '/' . $JobOrders->stitching) }}">{{ $JobOrders->stitching }}
                                                :-- Download</a></p>
                                    @endif
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <textarea class="form-control" id="stitching_desc" name="stitching_desc" placeholder="Stitching Instruction">{{ $JobOrders->stitching_desc }}</textarea>
                                </div>


                                <div class="col-lg-4 mt-4">
                                    <label class="form-label" for="Washing_Instruction">
                                        <h5>Washing Instruction</h5>
                                    </label>
                                </div>
                                <div class="col-lg-4 mt-4">
                                    <input type="file" id="washing" name="washing" class="form-control"
                                        placeholder="Specs Sheet" />
                                    @if (!empty($JobOrders->washing))
                                        <p class="mt-2"><a target="_blank"
                                                href="{{ url('jobOrders/' . $JobOrders->id . '/' . $JobOrders->washing) }}">{{ $JobOrders->washing }}
                                                :-- Download</a></p>
                                    @endif
                                </div>
                                <div class="col-lg-4">
                                    <textarea class="form-control" id="washing_desc" name="washing_desc" placeholder="Washing Instruction">{{ $JobOrders->washing_desc }}</textarea>
                                </div>

                            </div>
                            {{-- end cardd-body --}}
                        </div>
                        {{--          end card --}}
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 text-center">
                        <textarea class="form-control" name="note" cols="55" rows="4" placeholder="Note">{{ $JobOrders->note }}</textarea>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                            Submit
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection
<script>
    window.onload = function() {
        getStyleDetails();
    };

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
                $('#Rate').val(result.rate);
            }
        });
    }

    function calculateTotalSum() {

        var inputs = document.querySelectorAll('input[name^="SizeWiseQty["]');
        // var totalSumElement = document.getElementById('totalSum');
        var totalSum = 0;

        inputs.forEach(function(input) {
            var value = parseFloat(input.value);
            if (!isNaN(value)) {
                totalSum += value;
            }
        });

        // Display the total sum
        $('#TotalQty').val(totalSum);
    }
</script>
