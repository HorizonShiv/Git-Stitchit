@extends('layouts/layoutMaster')

@section('title', 'Settings Details - Apps')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/app-ecommerce-settings.js') }}"></script>
@endsection

@section('content')

    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Admin /</span> Settings
    </h4>
    <form id="settingSubmit" method="post">
        <div class="row g-4">
            <!-- Navigation -->
            <div class="col-12 col-lg-4">
                <div class="d-flex justify-content-between flex-column mb-3 mb-md-0">
                    <ul class="nav nav-align-left nav-pills flex-column">
                        <li class="nav-item mb-1">
                            <a class="nav-link py-2 active" href="javascript:void(0);">
                                <i class="ti ti-building-store me-2"></i>
                                <span class="align-middle">Verification Method</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /Navigation -->
            <!-- Options -->
            <div class="col-12 col-lg-8 pt-4 pt-lg-0">
                <div class="tab-content p-0">
                    <!-- Checkout Tab -->
                    <div class="tab-pane fade show active" id="checkout" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="card-title m-0">
                                    <h5 class="m-0">Verification With GRN</h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" value="1"
                                        @if ($setting->invoice_type == 1) {{ 'checked' }} @endif name="invoiceType"
                                        id="invoice_wise">
                                    <label class="form-check-label" for="invoice_wise">
                                        Invoice Wise
                                    </label>
                                </div>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="radio" value="2"
                                        @if ($setting->invoice_type == 2) {{ 'checked' }} @endif name="invoiceType"
                                        id="challan_wise">
                                    <label class="form-check-label" for="challan_wise">
                                        Challan Wise
                                    </label>
                                </div>
                            </div>
                            <div class="card-header">
                                <div class="card-title m-0">
                                    <h5 class="m-0">Numbering Process</h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <label class="switch switch-success">
                                        <input type="checkbox" id="AutoStyleNumber" name="AutoStyleNumber"
                                            class="switch-input"
                                            @if ($setting->auto_style_number_status == 1) {{ 'checked' }} @endif value="1"
                                            onchange="setSettingAutoNumber()">
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on">
                                                <i class="ti ti-check mt-1"></i>
                                            </span>
                                            <span class="switch-off">
                                                <i class="ti ti-x mt-1"></i>
                                            </span>
                                        </span>
                                        <span class="switch-label"></span>
                                    </label>
                                    <label class="form-check-label" for="AutoStyleNumber">
                                        Auto Style Number
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <label class="switch switch-success">
                                        <input type="checkbox" id="AutoSalesNumber" name="AutoSalesNumber"
                                            class="switch-input"
                                            @if ($setting->auto_sales_status == 1) {{ 'checked' }} @endif value="1"
                                            onchange="setSettingAutoNumber()">
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on">
                                                <i class="ti ti-check mt-1"></i>
                                            </span>
                                            <span class="switch-off">
                                                <i class="ti ti-x mt-1"></i>
                                            </span>
                                        </span>
                                        <span class="switch-label"></span>
                                    </label>
                                    <label class="form-check-label" for="AutoSalesNumber">
                                        Auto Sales Number
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <label class="switch switch-success">
                                        <input type="checkbox" id="AutoJobPlanningNumber" name="AutoJobPlanningNumber"
                                            class="switch-input"
                                            @if ($setting->auto_order_planning_status == 1) {{ 'checked' }} @endif value="1"
                                            onchange="setSettingAutoNumber()">
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on">
                                                <i class="ti ti-check mt-1"></i>
                                            </span>
                                            <span class="switch-off">
                                                <i class="ti ti-x mt-1"></i>
                                            </span>
                                        </span>
                                        <span class="switch-label"></span>
                                    </label>
                                    <label class="form-check-label" for="AutoJobPlanningNumber">
                                        Auto Job Planning Number
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <label class="switch switch-success">
                                        <input type="checkbox" id="AutoJobCardNumber" name="AutoJobCardNumber"
                                            class="switch-input"
                                            @if ($setting->auto_job_card_status == 1) {{ 'checked' }} @endif value="1"
                                            onchange="setSettingAutoNumber()">
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on">
                                                <i class="ti ti-check mt-1"></i>
                                            </span>
                                            <span class="switch-off">
                                                <i class="ti ti-x mt-1"></i>
                                            </span>
                                        </span>
                                        <span class="switch-label"></span>
                                    </label>
                                    <label class="form-check-label" for="AutoJobCardNumber">
                                        Auto Job Card Number
                                    </label>
                                </div>



                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <span class="btn btn-primary" onclick="settingFormSubmit();">Save</span>
                        </div>

                    </div>

                </div>
            </div>
            <!-- /Options-->
        </div>
    </form>
@endsection
<script>
    function settingFormSubmit() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to?',
            showCancelButton: true,
            confirmButtonText: 'Yes, Submit!',
            reverseButtons: true,
            cancelButtonColor: '#d33',
            buttonsStyling: true
        }).then(function(result) {
            if (result.value) {
                var invoiceType = $('input[name="invoiceType"]:checked').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('settingFormSubmit') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "invoiceType": invoiceType,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(resultData) {
                        Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                            location.reload();
                            $("#overlay").fadeOut(100);
                        });
                    }
                });

            } else if (result.dismiss === 'cancel') {
                Swal.fire(
                    'Cancelled',
                    'Your request has been Cancelled !!',
                    'error'
                )
            }
        });
    }

    function setSettingAutoNumber() {
        const autoStyleNumberCheckbox = document.getElementById('AutoStyleNumber').checked ? 1 : 0;
        const autoSalesNumberCheckbox = document.getElementById('AutoSalesNumber').checked ? 1 : 0;
        const autoJobPlanningNumberCheckbox = document.getElementById('AutoJobPlanningNumber').checked ? 1 : 0;
        const autoJobCardNumberCheckbox = document.getElementById('AutoJobCardNumber').checked ? 1 : 0;

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{{ route('setSettingAutoNumber') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                autoStyleNumberCheckbox: autoStyleNumberCheckbox,
                autoSalesNumberCheckbox: autoSalesNumberCheckbox,
                autoJobPlanningNumberCheckbox: autoJobPlanningNumberCheckbox,
                autoJobCardNumberCheckbox: autoJobCardNumberCheckbox,
                "_token": "{{ csrf_token() }}"
            },
            // success: function(response) {
            //     // Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
            //     //     location.reload();
            //     //     $("#overlay").fadeOut(100);
            //     // });
            //     toastr.success('Successfully fetched');
            // },
            success: function(resultData) {
                toastr.success('Successfully Updated');
            }
        });
    }
</script>
