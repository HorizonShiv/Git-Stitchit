@extends('layouts/layoutMaster')

@section('title', 'Sample Job Order')

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
        <span class="text-muted fw-light float-left">Sample Job Order/</span> Edit
    </h4>
    <form action="{{ route('order-job-card.sampleUpdate', $JobOrders->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-3 col-lg-3">
                        <label class="form-label" for="sampleDate">Date</label>
                        <input type="date" class="form-control date-picker" id="sampleDate" name="sampleDate"
                            placeholder="YYYY-MM-DD" value="{{ $JobOrders->date }}" readonly />
                    </div>
                    <div class="col-3 col-lg-3">
                        <label class="form-label" for="StyleNo">Style No</label>
                        <select class="form-control select2" name="StyleNo" onchange="getStyleDetails();" readonly
                            id="StyleNo">
                            <option value="">Select Style</option>
                            @foreach (\App\Models\StyleMaster::all() as $data)
                                <option {{ $JobOrders->sales_order_style_id == $data->id ? 'Selected' : '' }}
                                    value="{{ $data->id }}">{{ $data->style_no }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3 col-lg-3">
                        <label class="form-label" for="Price">Rate</label>
                        <input required type="number" id="Price" name="Price" class="form-control" readonly
                            placeholder="Rate" value="{{ $JobOrders->rate }}" readonly />
                    </div>

                    <div class="col-3 col-lg-3">
                        <label class="form-label" for="TotalQty">Total Qty</label>
                        <div class="input-group">
                            <input required type="number" value="{{ $JobOrders->qty }}" readonly id="TotalQty"
                                name="TotalQty" class="form-control" placeholder="Total Qty" />
                        </div>
                    </div>
                    <div class="col-12 col-lg-12 mt-3" id="showStyleDetails">
                        <label class="form-label" for="TotalQty">Style Details</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
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
                                    @if (!empty($JobOrders->cad))
                                        <a type="button" target="_blank"
                                            href="{{ url('jobOrders/' . $JobOrders->id . '/' . $JobOrders->cad) }}"
                                            class="btn rounded-pill btn-label-primary waves-effect">
                                            <i class="tf-icons ti ti-xs me-1"></i> {{ $JobOrders->cad }} View
                                        </a>
                                    @else
                                        <button type="button" class="btn rounded-pill btn-label-pinterest waves-effect">
                                            <i class="tf-icons ti ti-xs me-1"></i> CAD Instruction was not
                                            uploaded
                                        </button>
                                    @endif
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <textarea readonly class="form-control" id="cad_desc" name="cad_desc" placeholder="CAD Instruction">{{ $JobOrders->cad_desc }}</textarea>
                                </div>


                                <div class="col-lg-4 mt-4">
                                    <label class="form-label" for="Cutting_Instruction">
                                        <h5>Cutting Instruction</h5>
                                    </label>
                                </div>
                                <div class="col-lg-4 mt-4">
                                    @if (!empty($JobOrders->cutting))
                                        <a type="button" target="_blank"
                                            href="{{ url('jobOrders/' . $JobOrders->id . '/' . $JobOrders->cutting) }}"
                                            class="btn rounded-pill btn-label-primary waves-effect">
                                            <i class="tf-icons ti ti-xs me-1"></i> {{ $JobOrders->cutting }} View
                                        </a>
                                    @else
                                        <button type="button" class="btn rounded-pill btn-label-pinterest waves-effect">
                                            <i class="tf-icons ti ti-xs me-1"></i> Cutting Instruction was not
                                            uploaded
                                        </button>
                                    @endif
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <textarea readonly class="form-control" id="cutting_desc" name="cutting_desc" placeholder="Cutting Instruction">{{ $JobOrders->cutting_desc }}</textarea>
                                </div>


                                <div class="col-lg-4 mt-4">
                                    <label class="form-label" for="Stitching_Instruction">
                                        <h5>Stitching Instruction</h5>
                                    </label>
                                </div>
                                <div class="col-lg-4 mt-4">
                                    @if (!empty($JobOrders->stitching))
                                        <a type="button" target="_blank"
                                            href="{{ url('jobOrders/' . $JobOrders->id . '/' . $JobOrders->stitching) }}"
                                            class="btn rounded-pill btn-label-primary waves-effect">
                                            <i class="tf-icons ti ti-xs me-1"></i> {{ $JobOrders->stitching }} View
                                        </a>
                                    @else
                                        <button type="button" class="btn rounded-pill btn-label-pinterest waves-effect">
                                            <i class="tf-icons ti ti-xs me-1"></i> Stitching Instruction was not
                                            uploaded
                                        </button>
                                    @endif
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <textarea readonly class="form-control" id="stitching_desc" name="stitching_desc"
                                        placeholder="Stitching Instruction">{{ $JobOrders->stitching_desc }}</textarea>
                                </div>


                                <div class="col-lg-4 mt-4">
                                    <label class="form-label" for="Washing_Instruction">
                                        <h5>Washing Instruction</h5>
                                    </label>
                                </div>
                                <div class="col-lg-4 mt-4">
                                    @if (!empty($JobOrders->washing))
                                        <a type="button" target="_blank"
                                            href="{{ url('jobOrders/' . $JobOrders->id . '/' . $JobOrders->washing) }}"
                                            class="btn rounded-pill btn-label-primary waves-effect">
                                            <i class="tf-icons ti ti-xs me-1"></i> {{ $JobOrders->washing }} View
                                        </a>
                                    @else
                                        <button type="button" class="btn rounded-pill btn-label-pinterest waves-effect">
                                            <i class="tf-icons ti ti-xs me-1"></i> Washing Instruction was not
                                            uploaded
                                        </button>
                                    @endif
                                </div>
                                <div class="col-lg-4">
                                    <textarea readonly class="form-control" id="washing_desc" name="washing_desc" placeholder="Washing Instruction">{{ $JobOrders->washing_desc }}</textarea>
                                </div>

                            </div>
                            {{-- end cardd-body --}}
                        </div>
                        {{--          end card --}}
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 text-center">
                        <textarea readonly class="form-control" name="note" cols="55" rows="4" placeholder="Note">{{ $JobOrders->note }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        </div>
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
                url: '{{ route('getSampleStyleDetails') }}',
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
                }
            });
        }
    </script>
