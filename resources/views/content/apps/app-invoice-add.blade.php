@extends('layouts/layoutMaster')

@section('title', 'Add - Invoice')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}"/>
@endsection

@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-invoice.css')}}"/>
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/offcanvas-send-invoice.js')}}"></script>
  <script src="{{asset('assets/js/app-invoice-add.js')}}"></script>
@endsection

@section('content')
  <form action="{{ route('app-invoice-store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row invoice-add">
      <!-- Invoice Add-->
      <div class="col-lg-9 col-12 mb-lg-0 mb-4">
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
                <div class="mb-6 md-6 col-6">
                  <label class="form-label" for="form-repeater-1-1">Vendor</label>
                  <select id="user_id" required name="user_id" onchange="getVendorDetails();"
                          class="select2 form-select">
                    <option value="">Select Vendor</option>
                    @foreach(App\Models\User::all() as $user)
                      <option value="{{ $user->id }}">{{ $user->company_name }}</option>
                    @endforeach
                  </select>
                </div>
                <br>
                <div id="getVendorDetails"></div>
              </div>
              <div class="col-md-5">
                <dl class="row mb-2">
                  <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end ps-0">
                    <span class="h4 text-capitalize mb-0 text-nowrap">Invoice</span>
                  </dt>
                  <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                    <div class="input-group input-group-merge disabled w-px-150">
                      <span class="input-group-text">#</span>
                      <input type="text" class="form-control" id="invoice_number" required name="invoice_number"/>
                    </div>
                  </dd>
                  <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end ps-0">
                    <span class="fw-normal">Date:</span>
                  </dt>
                  <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                    <input type="text" class="form-control w-px-150 date-picker" name="invoice_date"
                           placeholder="YYYY-MM-DD"/>
                  </dd>
                </dl>
              </div>
            </div>

            <hr class="my-3 mx-n4"/>


            <div class="row p-sm-4 p-0">
              <div class="mb-3 col-12">
                <label class="form-label" for="form-repeater-1-1">Company</label>
                <select id="company_id" required name="company_id" onchange="getCompanyDetails();"
                        class="select2 form-select" data-placeholder="Size">
                  <option value="">Select company</option>
                  @foreach(App\Models\Company::all() as $company)
                    <option value="{{ $company->id }}">{{ $company->b_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 col-sm-5 col-12 mb-sm-0 mb-4" id="getCompanyBillDetails">
              </div>
              <div class="col-md-6 col-sm-7" id="getCompanyShipDetails">
              </div>
            </div>

            <hr class="my-3 mx-n4"/>

            <form class="source-item">

              <div class="row pb-4">
                <div class="col-12">
                  <label class="form-label" for="pancard_number">Invoice Upload</label>
                  <input type="file" name="invoice_file" id="invoice_file" class="mt-1 form-control">
                  {{--              <button type="button" class="btn btn-primary" data-repeater-create>Add Item</button>--}}
                </div>
              </div>
            </form>

            <hr class="my-3 mx-n4"/>

            <div class="row p-0 p-sm-4">
              <div class="col-md-6 mb-md-0 mb-3">

              </div>
              <div class="col-md-6 d-flex justify-content-end">
                <div class="invoice-calculations">
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-150">Subtotal Amount:</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="number" step="any" readonly name="sub_total_amount" class="form-control w-px-150"
                             placeholder=""/>
                    </dd>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-150">Discount Amount:</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="number" name="discount_amount" step="any" class="form-control w-px-150"
                             placeholder=""/>
                    </dd>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-150">IGST Amount :</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="number" name="igst_amount" step="any" class="form-control w-px-150" placeholder=""/>
                    </dd>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-150">CGST Amount :</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="number" name="cgst_amount" step="any" class="form-control w-px-150" placeholder=""/>
                    </dd>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-150">SGST Amount :</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="number" name="sgst_amount" step="any" class="form-control w-px-150" placeholder=""/>
                    </dd>
                  </div>
                  <hr/>
                  <div class="d-flex justify-content-between">
                    <span class="w-px-150">Total Amount:</span>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                      <input type="number" name="invoice_amount" step="any" class="form-control w-px-150"
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
            </div>
          </div>
        </div>
      </div>
      <!-- /Invoice Add-->

      <!-- Invoice Actions -->
      <div class="col-lg-3 col-12 invoice-actions">
        <div class="card mb-4">
          <div class="card-body">
            <button type="submit" class="btn btn-primary d-grid w-100">Save</button>
          </div>
        </div>
      </div>
      <!-- /Invoice Actions -->
    </div>
  </form>

  <!-- Offcanvas -->
  @include('_partials/_offcanvas/offcanvas-send-invoice')
  <!-- /Offcanvas -->
@endsection
<script>
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
  }


</script>
