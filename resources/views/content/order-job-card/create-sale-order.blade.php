@extends('layouts/layoutMaster')

@section('title', 'Job Order Create')

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
    <span class="text-muted fw-light float-left">Job Order/</span> Add
  </h4>
  <form action="{{ route('storeBySaleOrder') }}" method="post" enctype="multipart/form-data">
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
                @php
                  $Setting = \App\Models\Setting::orderBy('id', 'desc')
                      ->where('auto_job_card_status', '1')
                      ->first();
                  if (!empty($Setting)) {
                      $JobCardNoDetail = $Setting->toArray();
                      $JobCardNoCount = $JobCardNoDetail['job_order_no_set'] + 1;
                      $JobCardNo = $JobCardNoDetail['job_order_pre_fix'] . '' . $JobCardNoCount;
                  }
                @endphp
                <div class="col-md-3 mb-4">
                  <label class="form-label" for="OrderId">Job Card No.</label>
                  <input type="text" class="form-control" id="JobCardNumber" name="JobCardNumber"
                         placeholder="Job Card No"
                         @if (!empty($JobCardNo))
                           {{ 'readonly' }}
                         @endif
                         value="{{ $JobCardNo ?? '' }}" />
                </div>

                <div class="col-md-3 mb-4">
                  <label class="form-label" for="saleOrder">Sale Order No.</label>
                  <select id="saleOrder" name="saleOrder" class="select2 select21 form-select"
                          data-allow-clear="true" data-placeholder="Select Sale Order"
                          onchange="getSaleOrderDetails()">
                    <option value="">Select Sale Order</option>
                    @if (!empty($saleOrders))
                      @foreach($saleOrders as $saleOrder)
                        <option value="{{ $saleOrder->id }}">
                          {{ $saleOrder->sales_order_no ?? '' }}
                        </option>
                      @endforeach
                    @endif
                  </select>
                </div>

                <div class="col-md-3 mb-4">
                  <label class="form-label" for="StyleId">Style No./Customer Style No.</label>
                  <select id="StyleNo" name="StyleNo" class="select2 select21 form-select"
                          data-allow-clear="true" data-placeholder="Select Style"
                          onchange="getStyleDetails()">
                    <option value="">Select Style</option>
                  </select>
                </div>
                <div class="col-md-3 mb-4">
                  <label for="select2Primary" class="form-label">Total Qty</label>
                  <div class="select2-primary">
                    <input type="text" class="form-control" id="TotalQty" name="TotalQty" placeholder="Qty">
                  </div>
                </div>
              </div>
              <div class="divider mt-4">
                <div class="divider-text">Fillable Details</div>
              </div>

              <div>
                <!-- Invoice List Widget/Board -->
                <div class=" mb-4" id="showStyleDetails">
                </div>

                <div class="row">
                  <div class="col-lg-12 col-md-6 mt-4">
                    <div id="accordionPayment" class="accordion">
                      <div class="card accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionPayment-2" aria-controls="accordionPayment-2">
                            Previously Created Job Order
                          </button>
                        </h2>
                        <div id="accordionPayment-2" class="accordion-collapse collapse">
                          <div class="accordion-body">
                            <div id="oldHtmlSizeWise"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <div class="col-lg-12 col-md-6 mt-4">
              <div class="card">
                <div class="card-body">
                  <div class="content">
                    <div class="content-header mb-4">
                      <h4 class="mb-1">Selected List</h4>
                    </div>

                    <div class="card-datatable table-responsive pt-0">
                      <div id="htmlSizeWise"></div>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            {{-- card body ending --}}
          </div>
          {{-- card end --}}
        </div>

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
                </div>
                <div class="col-lg-4 mb-2">
                  <textarea class="form-control" id="cad_desc" name="cad_desc" placeholder="CAD Instruction"></textarea>
                </div>


                <div class="col-lg-4 mt-4">
                  <label class="form-label" for="Cutting_Instruction">
                    <h5>Cutting Instruction</h5>
                  </label>
                </div>
                <div class="col-lg-4 mt-4">
                  <input type="file" id="cutting" name="cutting" class="form-control"
                         placeholder="Specs Sheet" />
                </div>
                <div class="col-lg-4 mb-2">
                  <textarea class="form-control" id="cutting_desc" name="cutting_desc"
                            placeholder="Cutting Instruction"></textarea>
                </div>


                <div class="col-lg-4 mt-4">
                  <label class="form-label" for="Stitching_Instruction">
                    <h5>Stitching Instruction</h5>
                  </label>
                </div>
                <div class="col-lg-4 mt-4">
                  <input type="file" id="stitching" name="stitching" class="form-control"
                         placeholder="Specs Sheet" />
                </div>
                <div class="col-lg-4 mb-2">
                  <textarea class="form-control" id="stitching_desc" name="stitching_desc"
                            placeholder="Stitching Instruction"></textarea>
                </div>


                <div class="col-lg-4 mt-4">
                  <label class="form-label" for="Washing_Instruction">
                    <h5>Washing Instruction</h5>
                  </label>
                </div>
                <div class="col-lg-4 mt-4">
                  <input type="file" id="washing" name="washing" class="form-control"
                         placeholder="Specs Sheet" />
                </div>
                <div class="col-lg-4">
                  <textarea class="form-control" id="washing_desc" name="washing_desc"
                            placeholder="Washing Instruction"></textarea>
                </div>

              </div>
              {{-- end cardd-body --}}
            </div>
            {{--          end card --}}
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-12 text-center">
            <textarea class="form-control" name="note" cols="55" rows="4" placeholder="Note"></textarea>
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
        $('#htmlSizeWise').html(result.htmlSizeWise);
        $('#oldHtmlSizeWise').html(result.oldHtmlSizeWise);
        $('#processQty0').val(result.qty);
        $('#rawOrderQty0').val(result.qty);
        $('#TotalQty').val((result.qty - {{ $JobOrderQtyOld ?? 0 }}));
        $('#Rate').val(result.rate);
      }
    });
  }

  function getSaleOrderDetails() {
    var saleOrder = document.getElementById('saleOrder').value;
    const select = document.getElementById('StyleNo');
    select.innerHTML = '';
    $('#showStyleDetails').html('');
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: '{{ route('getSaleOrderDetails') }}',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        saleOrder: saleOrder,
        '_token': "{{ csrf_token() }}"
      },
      success: function(data) {
        appendOptions(data);
      }
    });
  }

  function appendOptions(options) {
    var $select = $('#StyleNo');
    var $optD = $('<option>', {
      value: "",  // Replace 'value' with the actual property name from your data
      text: "Select Style"     // Replace 'text' with the actual property name from your data
    });
    $select.append($optD);

    $.each(options, function(index, option) {
      var $opt = $('<option>', {
        value: option.id,  // Replace 'value' with the actual property name from your data
        text: option.customer_style_no     // Replace 'text' with the actual property name from your data
      });
      $select.append($opt);
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

  function setSiderSum(ColorKey) {
    var inputs = document.querySelectorAll(`input[name^='SizeWiseQty[${ColorKey}]']`);
    var totalSum = 0;

    let Rtotal = 0;
    document.querySelectorAll(`input[name^='SizeWiseQty[${ColorKey}]']`).forEach(function(inputElement) {
      Rtotal += Number(inputElement.value);
    });

    $('#colorwiseQtyData_' + ColorKey).html(Rtotal);

  }
</script>
