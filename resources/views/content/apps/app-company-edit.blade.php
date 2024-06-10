@extends('layouts/layoutMaster')

@section('title', 'Company - Edit')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

@section('content')
 <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left">Master / Company /</span> Edit
    </h4>
    <form method="post" action="{{ route('app-company-update', $company->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row invoice-add">
            <!-- Invoice Add-->

            <div class="col-lg-12 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div class="content">
                            <div class="content-header mb-4">
                                <h3 class="mb-1">Company Information</h3>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="c_name">Company Name</label>
                                    <input required type="text" id="c_name" name="c_name"
                                        value="{{ $company->c_name }}" class="form-control" placeholder="Company Name" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="c_name">Check Pancard / GST No</label><br>
                                    <input type="radio" value="pancard"
                                        @if ($company->check_document == 'pancard') {{ 'checked' }} @endif name="check_document"
                                        class="" /> Pancard
                                    <input type="radio" value="gst"
                                        @if ($company->check_document == 'gst') {{ 'checked' }} @endif name="check_document"
                                        class="" />
                                    GST
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="b_name">Pan Card / Gst No</label>
                                    <input type="text" id="pancard_gst_no" value="{{ $company->pancard_gst_no }}"
                                        name="pancard_gst_no" class="form-control" placeholder="Pan Card / Gst No Name" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="b_name">Pan Card / Gst File</label>
                                    <input type="file" id="pancard_gst_file" name="pancard_gst_file" class="form-control"
                                        placeholder="Pan Card / Gst No Name" />
                                    @if (!empty($company->pancard_gst_file))
                                        <p class="mt-2"><a target="_blank"
                                                href="{{ url('pancard_gst_file/' . $company->id . '/' . $company->pancard_gst_file) }}">{{ $company->pancard_gst_file }}
                                                :-- Download</a></p>
                                    @endif

                                </div>
                            </div>

                            <div class="content-header mt-2 mb-4">
                                <h3 class="mb-1">Billing Information</h3>
                                <p>Enter Your Billing Information</p>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="b_name">Billing Name</label>
                                    <input required type="text" id="b_name" name="b_name"
                                        value="{{ $company->b_name }}" class="form-control" placeholder="Billing Name" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="b_mobile">Billing Mobile No</label>
                                    <input required type="text" id="b_mobile" name="b_mobile"
                                        value="{{ $company->b_mobile }}" class="form-control" placeholder="Mobile" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="b_email">Billing Email</label>
                                    <input required type="text" id="b_email" name="b_email"
                                        value="{{ $company->b_email }}" class="form-control" placeholder="Email" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="b_address1">Address Line 1</label>
                                    <textarea required id="b_address1" name="b_address1" class="form-control" placeholder="Address Line 1">{{ $company->b_address1 }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="b_address2">Address Line 2</label>
                                    <textarea required id="b_address2" name="b_address2" class="form-control" placeholder="Address Line 2">{{ $company->b_address2 }}</textarea>
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label" for="b_city">City</label>
                                    <input required type="text" id="b_city" name="b_city"
                                        value="{{ $company->b_city }}" class="form-control" placeholder="city" />
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label" for="b_state">State</label>
                                    <select required id="b_state" name="b_state" class="select2 form-select"
                                        data-allow-clear="true">
                                        <option value="{{ $company->b_state }}">{{ $company->b_state }}</option>
                                        <option value="">Select</option>
                                        <option value="Andra Pradesh">Andra Pradesh</option>
                                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                        <option value="Assam">Assam</option>
                                        <option value="Bihar">Bihar</option>
                                        <option value="Chhattisgarh">Chhattisgarh</option>
                                        <option value="Goa">Goa</option>
                                        <option value="Gujarat">Gujarat</option>
                                        <option value="Haryana">Haryana</option>
                                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                        <option value="Jharkhand">Jharkhand</option>
                                        <option value="Karnataka">Karnataka</option>
                                        <option value="Kerala">Kerala</option>
                                        <option value="Madya Pradesh">Madya Pradesh</option>
                                        <option value="Maharashtra">Maharashtra</option>
                                        <option value="Manipur">Manipur</option>
                                        <option value="Meghalaya">Meghalaya</option>
                                        <option value="Mizoram">Mizoram</option>
                                        <option value="Nagaland">Nagaland</option>
                                        <option value="Orissa">Orissa</option>
                                        <option value="Punjab">Punjab</option>
                                        <option value="Rajasthan">Rajasthan</option>
                                        <option value="Sikkim">Sikkim</option>
                                        <option value="Tamil Nadu">Tamil Nadu</option>
                                        <option value="Telangana">Telangana</option>
                                        <option value="Tripura">Tripura</option>
                                        <option value="Uttaranchal">Uttaranchal</option>
                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                        <option value="West Bengal">West Bengal</option>
                                        <option disabled style="background-color:#aaa; color:#fff">UNION Territories
                                        </option>
                                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                        <option value="Chandigarh">Chandigarh</option>
                                        <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                                        <option value="Daman and Diu">Daman and Diu</option>
                                        <option value="Delhi">Delhi</option>
                                        <option value="Lakshadeep">Lakshadeep</option>
                                        <option value="Pondicherry">Pondicherry</option>
                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <label class="form-label" for="b_pincode">Pincode</label>
                                    <input required type="text" id="b_pincode" value="{{ $company->b_pincode }}"
                                        name="b_pincode" class="form-control multi-steps-pincode" placeholder="Pin Code"
                                        maxlength="6" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="content">
                            <div class="content-header mb-4">
                                <h3 class="mb-1">Shipping Information</h3>
                                <p>Enter Your Shipping Information</p>
                            </div>
                            @foreach ($company->CompanyShipAddress as $CompanyShipAddress)
                                <div class="row g-3 mb-5">
                                    <div class="col-md-4" hidden>
                                        <label class="form-label" for="s_id">Shipping ID</label>
                                        <input required type="text" id="s_id"
                                            value="{{ $CompanyShipAddress->id }}" name="s_id[]" class="form-control"
                                            placeholder="Shipping Name" />
                                    </div>

                                    <div class="col-md-4" hidden>
                                        <label class="form-label" for="s_counter">Shipping Counter</label>
                                        <input required type="text" id="s_counter"
                                            value="{{ $CompanyShipAddress->shipping_count }}" name="s_counter[]"
                                            class="form-control" placeholder="Shipping Name" />
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label" for="s_company_name">Shipping Company Name</label>
                                        <input required type="text" id="s_company_name"
                                            value="{{ $CompanyShipAddress->company_name }}" name="s_company_name[]"
                                            class="form-control" placeholder="Shipping Name" />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="s_mobile">Shipping Mobile No</label>
                                        <input required type="text" id="s_mobile" name="s_mobile[]"
                                            value="{{ $CompanyShipAddress->mobile }}" class="form-control"
                                            placeholder="Mobile" />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="s_email">Shipping Email</label>
                                        <input required type="text" id="s_email" name="s_email[]"
                                            value="{{ $CompanyShipAddress->email }}" class="form-control"
                                            placeholder="Email" />
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label" for="gst_no">GST Number</label>
                                        <input required type="text" id="gst_no" name="gst_no[]"
                                            value="{{ $CompanyShipAddress->gst_number }}" class="form-control"
                                            placeholder="Email" />
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label" for="s_address1">Address Line 1</label>
                                        <textarea required id="s_address1" name="s_address1[]" class="form-control" placeholder="Address Line 1">{{ $CompanyShipAddress->address1 }}</textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="s_address2">Address Line 2</label>
                                        <textarea required id="s_address2" value="" name="s_address2[]" class="form-control"
                                            placeholder="Address Line 2">{{ $CompanyShipAddress->address2 }}</textarea>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="s_city">City</label>
                                        <input required type="text" id="s_city"
                                            value="{{ $CompanyShipAddress->city }}" name="s_city[]" class="form-control"
                                            placeholder="city" />
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="b_state">State</label>
                                        <select required id="s_state" name="s_state[]" class="select2 form-select"
                                            data-allow-clear="true">
                                            <option value="{{ $CompanyShipAddress->state }}">
                                                {{ $CompanyShipAddress->state }}</option>
                                            <option value="">Select</option>
                                            <option value="Andra Pradesh">Andra Pradesh</option>
                                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                            <option value="Assam">Assam</option>
                                            <option value="Bihar">Bihar</option>
                                            <option value="Chhattisgarh">Chhattisgarh</option>
                                            <option value="Goa">Goa</option>
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Haryana">Haryana</option>
                                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                            <option value="Jharkhand">Jharkhand</option>
                                            <option value="Karnataka">Karnataka</option>
                                            <option value="Kerala">Kerala</option>
                                            <option value="Madya Pradesh">Madya Pradesh</option>
                                            <option value="Maharashtra">Maharashtra</option>
                                            <option value="Manipur">Manipur</option>
                                            <option value="Meghalaya">Meghalaya</option>
                                            <option value="Mizoram">Mizoram</option>
                                            <option value="Nagaland">Nagaland</option>
                                            <option value="Orissa">Orissa</option>
                                            <option value="Punjab">Punjab</option>
                                            <option value="Rajasthan">Rajasthan</option>
                                            <option value="Sikkim">Sikkim</option>
                                            <option value="Tamil Nadu">Tamil Nadu</option>
                                            <option value="Telangana">Telangana</option>
                                            <option value="Tripura">Tripura</option>
                                            <option value="Uttaranchal">Uttaranchal</option>
                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                            <option value="West Bengal">West Bengal</option>
                                            <option disabled style="background-color:#aaa; color:#fff">UNION Territories
                                            </option>
                                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands
                                            </option>
                                            <option value="Chandigarh">Chandigarh</option>
                                            <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                                            <option value="Daman and Diu">Daman and Diu</option>
                                            <option value="Delhi">Delhi</option>
                                            <option value="Lakshadeep">Lakshadeep</option>
                                            <option value="Pondicherry">Pondicherry</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="form-label" for="s_pincode">Pincode</label>
                                        <input type="text" id="s_pincode" value="{{ $CompanyShipAddress->pincode }}"
                                            name="s_pincode[]" class="form-control multi-steps-pincode"
                                            placeholder="Pin Code" maxlength="6" />
                                    </div>

                                    <div class="col-md-1 mt-4">
                                        <div class="demo-inline-spacing">
                                            <button type="button"
                                                onclick="deleteShippingAddress({{ $CompanyShipAddress->id }})"
                                                class="btn rounded-pill btn-icon btn-label-danger waves-effect">
                                                <span class="ti ti-trash"></span></button>
                                        </div>
                                    </div>


                                </div>
                            @endforeach
                        </div>
                    </div>


                    <div class="card-body">
                        <div id="shipping-address-container">
                            <div class="divider m-4">
                                <div class="divider-text">New Shipping Details 1</div>
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="form-label" for="s_company_name">Shipping Company Name</label>
                                    <input type="text" id="s_company_name" name="new_s_company_name[]"
                                        class="form-control" placeholder="Shipping Company Name" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="s_mobile">Shipping Person Mobile No</label>
                                    <input type="text" id="s_mobile" name="new_s_mobile[]"
                                        class="form-control" placeholder="Mobile" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="s_email">Shipping Person Email</label>
                                    <input type="text" id="s_email" name="new_s_email[]"
                                        class="form-control" placeholder="Email" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="gst_no">GST No</label>
                                    <input type="text" id="gst_no" name="new_gst_no[]"
                                        class="form-control" placeholder="GST Number" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="s_address1">Address Line 1</label>
                                    <textarea id="s_address1" name="new_s_address1[]" class="form-control" placeholder="Address Line 1"></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="s_address2">Address Line 2</label>
                                    <textarea id="s_address2" name="new_s_address2[]" class="form-control" placeholder="Address Line 2"></textarea>
                                </div>

                                <div class="col-sm-4">
                                    <label class="form-label" for="s_city">City</label>
                                    <input type="text" id="s_city" name="new_s_city[]"
                                        class="form-control" placeholder="city" />
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label" for="s_state">State</label>
                                    <select id="s_state" name="new_s_state[]" class="select2 form-select"
                                        data-allow-clear="true">
                                        <option value="">Select</option>
                                        <option value="Andra Pradesh">Andra Pradesh</option>
                                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                        <option value="Assam">Assam</option>
                                        <option value="Bihar">Bihar</option>
                                        <option value="Chhattisgarh">Chhattisgarh</option>
                                        <option value="Goa">Goa</option>
                                        <option value="Gujarat">Gujarat</option>
                                        <option value="Haryana">Haryana</option>
                                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                        <option value="Jharkhand">Jharkhand</option>
                                        <option value="Karnataka">Karnataka</option>
                                        <option value="Kerala">Kerala</option>
                                        <option value="Madya Pradesh">Madya Pradesh</option>
                                        <option value="Maharashtra">Maharashtra</option>
                                        <option value="Manipur">Manipur</option>
                                        <option value="Meghalaya">Meghalaya</option>
                                        <option value="Mizoram">Mizoram</option>
                                        <option value="Nagaland">Nagaland</option>
                                        <option value="Orissa">Orissa</option>
                                        <option value="Punjab">Punjab</option>
                                        <option value="Rajasthan">Rajasthan</option>
                                        <option value="Sikkim">Sikkim</option>
                                        <option value="Tamil Nadu">Tamil Nadu</option>
                                        <option value="Telangana">Telangana</option>
                                        <option value="Tripura">Tripura</option>
                                        <option value="Uttaranchal">Uttaranchal</option>
                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                        <option value="West Bengal">West Bengal</option>
                                        <option disabled style="background-color:#aaa; color:#fff">UNION Territories
                                        </option>
                                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands
                                        </option>
                                        <option value="Chandigarh">Chandigarh</option>
                                        <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                                        <option value="Daman and Diu">Daman and Diu</option>
                                        <option value="Delhi">Delhi</option>
                                        <option value="Lakshadeep">Lakshadeep</option>
                                        <option value="Pondicherry">Pondicherry</option>
                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <label class="form-label" for="s_pincode">Pincode</label>
                                    <input type="text" id="s_pincode" name="new_s_pincode[]"
                                        class="form-control multi-steps-pincode" placeholder="Pin Code" maxlength="6" />
                                </div>
                            </div>

                        </div>
                        <div class="d-flex flex-row-reverse mx-4 mt-4">
                            <!-- Button to add more shipping addresses -->
                            <button type="button" onclick="addItem()" class="btn btn-sm btn-primary">Add Shipping
                                Address
                            </button>
                        </div>
                    </div>




                    <div class="card-body">
                        <div class="content">
                            <div class="content-header mb-4">
                                <h3 class="mb-1">PO Setting</h3>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="s_name">PO Pre Fix</label>
                                    <input required type="text" id="pre_fix" value="{{ $company->pre_fix }}"
                                        name="pre_fix" class="form-control" placeholder="Enter PO Pre Fix" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="s_mobile">PO No Set</label>
                                    <input required type="text" id="po_no_set" value="{{ $company->po_no_set }}"
                                        name="po_no_set" class="form-control" placeholder="PO No Set" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="content">
                            <div class="content-header mb-4">
                                <h3 class="mb-1">GRN Setting</h3>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="grn_pre_fix">GRN Pre Fix</label>
                                    <input required type="text" id="grn_pre_fix" name="grn_pre_fix"
                                        class="form-control" placeholder="Enter PO Pre Fix"
                                        value="{{ $company->Setting->grn_pre_fix ?? '' }}" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="gnr_no_set">GRN No Set</label>
                                    <input required type="text" id="gnr_no_set" name="gnr_no_set"
                                        class="form-control" placeholder="PO No Set"
                                        value="{{ $company->Setting->gnr_no_set ?? '' }}" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="content">
                            <div class="content-header mb-4">
                                <h3 class="mb-1">Sales Order Setting</h3>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="sales_order_pre_fix">Sales Order Pre Fix</label>
                                    <input required type="text" id="sales_order_pre_fix" name="sales_order_pre_fix"
                                        class="form-control" value="{{ $company->Setting->sales_order_pre_fix ?? '' }}"
                                        placeholder="Enter Sales Order Pre Fix" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="sales_order_no_set">Sales Order No Set</label>
                                    <input required type="text" id="sales_order_no_set" name="sales_order_no_set"
                                        class="form-control" value="{{ $company->Setting->sales_order_no_set ?? '' }}"
                                        placeholder="Sales Order No Set" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="content">
                            <div class="content-header mb-4">
                                <h3 class="mb-1">Order Planning Setting</h3>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="order_planning_pre_fix">Order Planning Pre Fix</label>
                                    <input required type="text" id="order_planning_pre_fix"
                                        name="order_planning_pre_fix" class="form-control"
                                        value="{{ $company->Setting->order_planning_pre_fix ?? '' }}"
                                        placeholder="Enter Order Planning Pre Fix" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="order_planning_no_set">Order Planning No Set</label>
                                    <input required type="text" id="order_planning_no_set"
                                        name="order_planning_no_set" class="form-control"
                                        value="{{ $company->Setting->order_planning_no_set ?? '' }}"
                                        placeholder="Enter Order Planning No Set" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="content">
                            <div class="content-header mb-4">
                                <h3 class="mb-1">Job Order Setting</h3>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="job_order_pre_fix">Job Order Pre Fix</label>
                                    <input required type="text" id="job_order_pre_fix" name="job_order_pre_fix"
                                        class="form-control" value="{{ $company->Setting->job_order_pre_fix ?? '' }}"
                                        placeholder="Enter Job Order Pre Fix" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="job_order_no_set">Job Order No Set</label>
                                    <input required type="text" id="job_order_no_set" name="job_order_no_set"
                                        class="form-control" value="{{ $company->Setting->job_order_no_set ?? '' }}"
                                        placeholder="Job Order No Set" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="content">
                            <div class="content-header mb-4">
                                <h3 class="mb-1">Style No Setting</h3>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="style_number_pre_fix">Style Number Pre Fix</label>
                                    <input required type="text"
                                        value="{{ $company->Setting->style_number_pre_fix ?? '' }}"
                                        id="style_number_pre_fix" name="style_number_pre_fix" class="form-control"
                                        placeholder="Enter Style No Pre Fix" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="style_number_no_set">Style Number No Set</label>
                                    <input required type="number"
                                        value="{{ $company->Setting->style_number_no_set ?? '' }}"
                                        id="style_number_no_set" name="style_number_no_set" class="form-control"
                                        placeholder="Style No Set" />
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row g-3 mt-2">
                        <div class="col-md-4 mb-5" style="margin-left: 25px">
                            <button type="submit" class="btn btn-primary d-grid w-100">Save</button>
                        </div>
                    </div>
                </div>

                <!-- /Invoice Add-->
            </div>
        </div>

    </form>

    <!-- Offcanvas -->
    @include('_partials/_offcanvas/offcanvas-send-invoice')
    <!-- /Offcanvas -->
@endsection
<script>
    // Function to add a new shipping address
    function addShippingAddress() {
        var lastAddress = $('.shipping-address-card').last(); // Get the last shipping address card
        var newAddress = lastAddress.clone(); // Clone the last shipping address card

        newAddress.find('input[type="text"]').val(''); // Clear input values
        newAddress.find('button').prop('disabled', false); // Enable remove button

        $('#shipping-address-container').append(newAddress); // Append the cloned shipping address card

        updateRemoveButtonState(); // Update remove button state after adding address
    }

    // Function to remove a shipping address
    function removeShippingAddress(button) {
        var card = $(button).closest('.shipping-address-card');
        if ($('.shipping-address-card').length > 1) {
            card.remove(); // Remove the shipping address card
        }

        updateRemoveButtonState(); // Update remove button state after removing address
    }

    // Function to update remove button state
    function updateRemoveButtonState() {
        var removeButtons = $('.shipping-address-card .btn-danger');
        if (removeButtons.length === 1) {
            removeButtons.prop('disabled', true); // Disable remove button if only one address present
        } else {
            removeButtons.prop('disabled', false); // Enable remove button if more than one address present
        }
    }

    function deleteShippingAddress(shippingAddressId) {
        // var VendorName = document.getElementById('VendorName').value;
        // var VendorName = document.querySelector('#VendorName').value;
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: false,
            confirmButtonText: "Yes, Approve it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $("#overlay").fadeIn(100);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('app-company-ship-remove') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        shippingAddressId: shippingAddressId,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(resultData) {
                        Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                            location.reload();
                            $("#overlay").fadeOut(100);
                        });
                    }
                });
            }
        });
    }

    var counter = 0;

    function addItem() {
        // Create a new div element with the specified HTML code
        counter++;
        var shippingFormHTML = `
                  <div class="row g-3" id="ShippingContainer_` + counter + `">
                      <div class="divider mt-5">
                        <div class="divider-text">New Shipping Details ` + (counter + 1) + `</div>
                      </div>
                      <div class="col-md-4">
                          <label class="form-label" for="s_company_name">Shipping Company Name</label>
                          <input required type="text" id="s_company_name" name="new_s_company_name[]" class="form-control" placeholder="Shipping Company Name" />
                      </div>
                      <div class="col-md-4">
                          <label class="form-label" for="s_mobile">Shipping Person Mobile No</label>
                          <input required type="text" id="s_mobile" name="new_s_mobile[]" class="form-control" placeholder="Mobile" />
                      </div>
                      <div class="col-md-4">
                          <label class="form-label" for="s_email">Shipping Person Email</label>
                          <input required type="text" id="s_email" name="new_s_email[]" class="form-control" placeholder="Email" />
                      </div>
                      <div class="col-md-4">
                          <label class="form-label" for="gst_no">GST No</label>
                          <input required type="text" id="gst_no" name="new_gst_no[]" class="form-control" placeholder="GST Number" />
                      </div>
                      <div class="col-md-4">
                          <label class="form-label" for="s_address1">Address Line 1</label>
                          <textarea required id="s_address1" name="new_s_address1[]" class="form-control" placeholder="Address Line 1"></textarea>
                      </div>
                      <div class="col-md-4">
                          <label class="form-label" for="s_address2">Address Line 2</label>
                          <textarea required id="s_address2" name="new_s_address2[]" class="form-control" placeholder="Address Line 2"></textarea>
                      </div>
                      <div class="col-sm-4">
                          <label class="form-label" for="s_city">City</label>
                          <input required type="text" id="s_city" name="new_s_city[]" class="form-control" placeholder="city" />
                      </div>
                      <div class="col-sm-4">
                          <label class="form-label" for="s_state">State</label>
                          <select required id="s_state" name="new_s_state[]" class="select2 form-select" data-allow-clear="true">
                              <option value="">Select</option>
                              <option value="Andra Pradesh">Andra Pradesh</option>
                              <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                              <option value="Assam">Assam</option>
                              <option value="Bihar">Bihar</option>
                              <option value="Chhattisgarh">Chhattisgarh</option>
                              <option value="Goa">Goa</option>
                              <option value="Gujarat">Gujarat</option>
                              <option value="Haryana">Haryana</option>
                              <option value="Himachal Pradesh">Himachal Pradesh</option>
                              <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                              <option value="Jharkhand">Jharkhand</option>
                              <option value="Karnataka">Karnataka</option>
                              <option value="Kerala">Kerala</option>
                              <option value="Madya Pradesh">Madya Pradesh</option>
                              <option value="Maharashtra">Maharashtra</option>
                              <option value="Manipur">Manipur</option>
                              <option value="Meghalaya">Meghalaya</option>
                              <option value="Mizoram">Mizoram</option>
                              <option value="Nagaland">Nagaland</option>
                              <option value="Orissa">Orissa</option>
                              <option value="Punjab">Punjab</option>
                              <option value="Rajasthan">Rajasthan</option>
                              <option value="Sikkim">Sikkim</option>
                              <option value="Tamil Nadu">Tamil Nadu</option>
                              <option value="Telangana">Telangana</option>
                              <option value="Tripura">Tripura</option>
                              <option value="Uttaranchal">Uttaranchal</option>
                              <option value="Uttar Pradesh">Uttar Pradesh</option>
                              <option value="West Bengal">West Bengal</option>
                              <option disabled style="background-color:#aaa; color:#fff">UNION Territories</option>
                              <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                              <option value="Chandigarh">Chandigarh</option>
                              <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                              <option value="Daman and Diu">Daman and Diu</option>
                              <option value="Delhi">Delhi</option>
                              <option value="Lakshadeep">Lakshadeep</option>
                              <option value="Pondicherry">Pondicherry</option>
                          </select>
                      </div>
                      <div class="col-sm-3">
                          <label class="form-label" for="s_pincode">Pincode</label>
                          <input type="text" id="s_pincode" name="new_s_pincode[]" class="form-control multi-steps-pincode" placeholder="Pin Code" maxlength="6" />
                      </div>
                      <div class="col-md-1 mt-4">
                            <div class="demo-inline-spacing">
                                <button type="button" onclick="removeItem(` + counter + `)"
                                    class="btn rounded-pill btn-icon btn-label-danger waves-effect">
                                    <span class="ti ti-trash"></span></button>
                            </div>
                          </div>
                  </div>`;



        // Append the new div to the container
        // document.getElementById("shipping-address-container").appendChild(shippingFormHTML);
        $('#shipping-address-container').append(shippingFormHTML);
        $(".select2").select2();
        shippingFormHTML.querySelector("input").focus();

    }

    function removeItem(counter) {
        var elementToRemove = document.getElementById("ShippingContainer_" + counter);
        elementToRemove.remove();
    }
</script>
