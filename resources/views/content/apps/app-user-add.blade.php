@extends('layouts/layoutMaster')

@section('title', 'Add - Invoice')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection

@section('content')
    <form method="post" action="{{ route('app-user-store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row invoice-add">
            <!-- Invoice Add-->
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light float-left">User /</span> Add
            </h4>
            <div class="col-lg-12 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div class="content">
                            <div class="content">
                                <div class="row g-3 mt-2">
                                    <div class="col-sm-6">Status : <label class="switch switch-success">
                                            <input type="checkbox" name="status" class="switch-input" value="1"
                                                checked="">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on">
                                                    <i class="ti ti-check mt-1"></i>
                                                </span>
                                                <span class="switch-off">
                                                    <i class="ti ti-x mt-1"></i>
                                                </span>
                                            </span>
                                            <span class="switch-label">Active</span>
                                        </label></div>

                                    <div class="col-sm-6">
                                        <label class="form-label" for="role">Role</label>
                                        <select id="role" name="role" class="select2 form-select"
                                            data-allow-clear="role">
                                            <option value="account">Account</option>
                                            <option value="warehouse">Warehouse</option>
                                            <option value="admin">Admin</option>
                                            <option value="merchant">Merchant</option>
                                            <option value="designer">Designer</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="company_name">Company Name </label>
                                        <input type="text" name="company_name" id="company_name" class="form-control"
                                            placeholder="enter company name">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="contact_person_name">Contact Person Name
                                        </label>
                                        <input type="text" name="contact_person_name" value=""
                                            id="contact_person_name" class="form-control"
                                            placeholder="enter contact person name">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="contact_person_mobile">Contact Person
                                            Mobile </label>
                                        <input type="text" name="contact_person_mobile" value=""
                                            id="contact_person_mobile" class="form-control"
                                            placeholder="enter contact person mobile">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            placeholder="john.doe@email.com" aria-label="john.doe">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="email">GST</label>
                                        <input type="text" name="gst_no" id="gst_no" value=""
                                            class="form-control" placeholder="GST No">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="email">GST Certificate File</label>
                                        <input type="file" name="gst_file" id="gst_file" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="pancard_no">PanCard</label>
                                        <input type="text" name="pancard_no" id="pancard_no" value=""
                                            class="form-control" placeholder="pancard no">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="pancard_file">PanCard File</label>
                                        <input type="file" name="pancard_file" id="pancard_file"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 content">
                                <div class="content-header">
                                    <h3 class="mb-1">Billing Information</h3>
                                    <p>Enter Your Billing Information</p>
                                </div>
                                <div class="row g-3">

                                    <div class="col-md-12">
                                        <label class="form-label" for="b_address1">Address Line 1</label>
                                        <input type="text" id="b_address1" value="" name="b_address1"
                                            class="form-control" placeholder="Address Line 1">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="b_address2">Address Line 2</label>
                                        <input type="text" id="b_address2" name="b_address2" value=""
                                            class="form-control" placeholder="Address Line 2">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="b_city">City</label>
                                        <input type="text" id="b_city" name="b_city" class="form-control"
                                            value="" placeholder="city">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="b_state">State</label>
                                        <select id="b_state" name="b_state" class="form-select select2"
                                            data-allow-clear="true">
                                            <option value=""></option>
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
                                            <option disabled="" style="background-color:#aaa; color:#fff">
                                                UNION Territories</option>
                                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar
                                                Islands</option>
                                            <option value="Chandigarh">Chandigarh</option>
                                            <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli
                                            </option>
                                            <option value="Daman and Diu">Daman and Diu</option>
                                            <option value="Delhi">Delhi</option>
                                            <option value="Lakshadeep">Lakshadeep</option>
                                            <option value="Pondicherry">Pondicherry</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="form-label" for="b_pincode">Pincode</label>
                                        <input type="text" id="b_pincode" value="" name="b_pincode"
                                            class="form-control multi-steps-pincode" placeholder="Pin Code"
                                            maxlength="6">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 content" hidden="">
                                <div class="content-header">
                                    <h3 class="mb-1">Shipping Information</h3>
                                    <p>Enter Your Shipping Information</p>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label" for="s_address1">Address Line 1</label>
                                        <input type="text" id="s_address1" value="" name="s_address1"
                                            class="form-control" placeholder="Address Line 1">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="s_address2">Address Line 2</label>
                                        <input type="text" id="s_address2" name="s_address2" value=""
                                            class="form-control" placeholder="Address Line 2">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="s_city">City</label>
                                        <input type="text" id="s_city" name="s_city" value=""
                                            class="form-control" placeholder="city">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="s_state">State</label>
                                        <select id="s_state" name="s_state" class="select2 form-select"
                                            data-allow-clear="true">
                                            <option value=""></option>
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
                                            <option disabled="" style="background-color:#aaa; color:#fff">
                                                UNION Territories</option>
                                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar
                                                Islands</option>
                                            <option value="Chandigarh">Chandigarh</option>
                                            <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli
                                            </option>
                                            <option value="Daman and Diu">Daman and Diu</option>
                                            <option value="Delhi">Delhi</option>
                                            <option value="Lakshadeep">Lakshadeep</option>
                                            <option value="Pondicherry">Pondicherry</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="form-label" for="s_pincode">Pincode</label>
                                        <input type="text" id="s_pincode" name="s_pincode"
                                            class="form-control multi-steps-pincode" value=""
                                            placeholder="Pin Code" maxlength="6">
                                    </div>
                                </div>
                            </div>
                            <div class="content-header mt-4">
                                <h3>Bank Details</h3>
                            </div>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label" for="account_number">Account No </label>
                                    <input type="text" name="account_number" id="account_number" value=""
                                        class="form-control" placeholder="enter Account No">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="account_name">Account Name </label>
                                    <input type="text" name="account_name" value="" id="account_name"
                                        class="form-control" placeholder="enter account name">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="account_bank_name">Bank Name </label>
                                    <input type="text" name="account_bank_name" value="" id="account_bank_name"
                                        class="form-control" placeholder="Enter Account Bank Name">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="account_ifsc">IFSC</label>
                                    <input type="text" name="account_ifsc" id="account_ifsc" value=""
                                        class="form-control">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="cancel_cheque">Cancel Cheque</label>
                                    <input type="file" name="cancelled_cheque" id="cancelled_cheque"
                                        class="form-control">
                                </div>
                            </div>
                            {{-- <div class="content-header mt-4">
                                <h3>Assign Company</h3>
                            </div> --}}
                            {{-- <div class="row g-3">

                                <select class="form-control select2" name="vendor_company_id[]" multiple=""
                                    id="vendor_company_id">
                                    <option value="">Select Company</option>
                                </select>
                            </div> --}}


                        </div>
                        <div class="col-lg-3 col-12 invoice-actions mt-3">
                            <button type="submit" class="btn btn-primary d-grid w-100">Save</button>

                        </div>
    </form>

    <!-- Offcanvas -->
    <!-- /Offcanvas -->
@endsection
