@extends('layouts/layoutMaster')

@section('title', 'Master-Customer')

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
        <span class="text-muted fw-light float-left">Master / Customer /</span> Add
    </h4>
    <!-- Invoice List Widget -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('customer-update', $Customer->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="content">


                            <div class="content-header mb-4">
                                <h3 class="mb-1">Customer Information</h3>
                                <div class="col-sm-6 mb-4">Add Shipping Address : <label class="switch switch-success">
                                        <input type="checkbox" id="AddShippingStatus" name="AddShippingStatus"
                                            class="switch-input" value="1" onchange="toggleAddShippingContainer()">
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
                                </div>
                            </div>


                            <div class="card-body ">
                                <div class="row">

                                    <div class="mb-3  col-lg-6 col-sm-6 ">
                                        <label class="form-label" for="basic-icon-default-company">Company Name</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-company2" class="input-group-text"><i
                                                    class="ti ti-building"></i></span>
                                            <input type="text" id="CompanyName" name="CompanyName" class="form-control"
                                                placeholder="ACME Inc." aria-label="ACME Inc."
                                                value="{{ $Customer->company_name }}"
                                                aria-describedby="basic-icon-default-company2" />
                                        </div>
                                    </div>
                                    <div class="mb-3 col-lg-6 col-sm-6">
                                        <label class="form-label" for="basic-icon-default-fullname">Buyer Name</label>
                                        <div class="input-group input-group-merge">
                                            <span id="BuyerName" class="input-group-text"><i class="ti ti-user"></i></span>
                                            <input type="text" class="form-control" id="BuyerName" name="BuyerName"
                                                placeholder="John Doe" aria-label="John Doe"
                                                value="{{ $Customer->buyer_name }}"
                                                aria-describedby="basic-icon-default-fullname2" />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-lg-6 col-sm-6">
                                        <label class="form-label" for="basic-icon-default-phone">Buyer Mobile</label>
                                        <div class="input-group input-group-merge">
                                            <span id="BuyerMobile" class="input-group-text"><i
                                                    class="ti ti-phone"></i></span>
                                            <input type="number" id="BuyerMobile" name="BuyerMobile"
                                                class="form-control phone-mask" placeholder="658 799 8941"
                                                value="{{ $Customer->buyer_number }}" aria-label="658 799 8941"
                                                aria-describedby="basic-icon-default-phone2" />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-lg-6 col-sm-6">
                                        <label class="form-label" for="emailTags">Email</label>
                                        <div id="emailTagsContainer" class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                                            <input type="text" id="email" name="email" class="form-control"
                                                placeholder="Enter email addresses separated by commas"
                                                value="{{ $Customer->email }}" aria-label="Email addresses"
                                                aria-describedby="basic-icon-default-email2" onkeydown="addTag(event)" />
                                            {{--                          <span id="basic-icon-default-email2" class="input-group-text">@example.com</span> --}}
                                        </div>
                                    </div>

                                    <div class="mb-3 col-lg-6 col-sm-6">
                                        <label class="form-label" for="b_name">Gst No</label>
                                        <input type="text" id="billing_gst_no" name="billing_gst_no"
                                            class="form-control" value="{{ $Customer->gst_no }}"
                                            placeholder="Gst No Name" />
                                    </div>
                                    {{-- @php
                                      dd($Customer->toArray());
                                    @endphp --}}
                                    @foreach ($Customer->CustomerBillAddress as $CustomerBillAddress)
                                        <div class="mb-3 col-lg-6 col-sm-6" hidden>
                                            <label class="form-label" for="collapsible-address"> Billing Id</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i
                                                        class="fa-regular fa-address-card"></i></span>
                                                <input type="text" id="BillingId" name="BillingId"
                                                    value="{{ $CustomerBillAddress->id }}" class="form-control"
                                                    placeholder="Address" />
                                            </div>
                                        </div>

                                        <div class="mb-3 col-lg-6 col-sm-6">
                                            <label class="form-label" for="collapsible-address"> Billing Address
                                                Line1</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i
                                                        class="fa-regular fa-address-card"></i></span>
                                                <input type="text" id="billing_address_line1"
                                                    name="billing_address_line1"
                                                    value="{{ $CustomerBillAddress->b_address1 }}" class="form-control"
                                                    placeholder="Address" />
                                            </div>
                                        </div>


                                        <div class="mb-3 col-lg-6 col-sm-6">
                                            <label class="form-label" for="collapsible-address">Billing Address
                                                Line2</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i
                                                        class="fa-regular fa-address-card"></i></span>
                                                <input type="text" id="billing_address_line2"
                                                    name="billing_address_line2"
                                                    value="{{ $CustomerBillAddress->b_address2 }}" class="form-control"
                                                    placeholder="Address" />
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-3">
                                            <label class="form-label" for="City"> Billing City</label>
                                            <input required="" type="text" id="billing_city" name="billing_city"
                                                value="{{ $CustomerBillAddress->b_city }}" class="form-control"
                                                placeholder="city">
                                        </div>
                                        <div class="col-lg-2 col-md-3">
                                            <label class="form-label" for="state">Billing State</label>
                                            <select required="" id="billing_state" name="billing_state"
                                                class="select2 form-select" data-allow-clear="true">
                                                <option value="">Select State</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Andra Pradesh' ? 'selected' : '' }}
                                                    value="Andra Pradesh">Andra Pradesh</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Arunachal Pradesh' ? 'selected' : '' }}
                                                    value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                <option {{ $CustomerBillAddress->b_state == 'Assam' ? 'selected' : '' }}
                                                    value="Assam">Assam</option>
                                                <option {{ $CustomerBillAddress->b_state == 'Bihar' ? 'selected' : '' }}
                                                    value="Bihar">Bihar</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Chhattisgarh' ? 'selected' : '' }}
                                                    value="Chhattisgarh">Chhattisgarh</option>
                                                <option {{ $CustomerBillAddress->b_state == 'Goa' ? 'selected' : '' }}
                                                    value="Goa">Goa</option>
                                                <option {{ $CustomerBillAddress->b_state == 'Gujarat' ? 'selected' : '' }}
                                                    value="Gujarat">Gujarat</option>
                                                <option {{ $CustomerBillAddress->b_state == 'Haryana' ? 'selected' : '' }}
                                                    value="Haryana">Haryana</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Himachal Pradesh' ? 'selected' : '' }}
                                                    value="Himachal Pradesh">Himachal Pradesh</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Jammu and Kashmir' ? 'selected' : '' }}
                                                    value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Jharkhand' ? 'selected' : '' }}
                                                    value="Jharkhand">Jharkhand</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Karnataka' ? 'selected' : '' }}
                                                    value="Karnataka">Karnataka</option>
                                                <option {{ $CustomerBillAddress->b_state == 'Kerala' ? 'selected' : '' }}
                                                    value="Kerala">Kerala</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Madya Pradesh' ? 'selected' : '' }}
                                                    value="Madya Pradesh">Madya Pradesh</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Maharashtra' ? 'selected' : '' }}
                                                    value="Maharashtra">Maharashtra</option>
                                                <option {{ $CustomerBillAddress->b_state == 'Manipur' ? 'selected' : '' }}
                                                    value="Manipur">Manipur</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Meghalaya' ? 'selected' : '' }}
                                                    value="Meghalaya">Meghalaya</option>
                                                <option {{ $CustomerBillAddress->b_state == 'Mizoram' ? 'selected' : '' }}
                                                    value="Mizoram">Mizoram</option>
                                                <option {{ $CustomerBillAddress->b_state == 'Nagaland' ? 'selected' : '' }}
                                                    value="Nagaland">Nagaland</option>
                                                <option {{ $CustomerBillAddress->b_state == 'Orissa' ? 'selected' : '' }}
                                                    value="Orissa">Orissa</option>
                                                <option {{ $CustomerBillAddress->b_state == 'Punjab' ? 'selected' : '' }}
                                                    value="Punjab">Punjab</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Rajasthan' ? 'selected' : '' }}
                                                    value="Rajasthan">Rajasthan</option>
                                                <option {{ $CustomerBillAddress->b_state == 'Sikkim' ? 'selected' : '' }}
                                                    value="Sikkim">Sikkim</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Tamil Nadu' ? 'selected' : '' }}
                                                    value="Tamil Nadu">Tamil Nadu</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Telangana' ? 'selected' : '' }}
                                                    value="Telangana">Telangana</option>
                                                <option {{ $CustomerBillAddress->b_state == 'Tripura' ? 'selected' : '' }}
                                                    value="Tripura">Tripura</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Uttaranchal' ? 'selected' : '' }}
                                                    value="Uttaranchal">Uttaranchal</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Uttar Pradesh' ? 'selected' : '' }}
                                                    value="Uttar Pradesh">Uttar Pradesh</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'West Bengal' ? 'selected' : '' }}
                                                    value="West Bengal">West Bengal</option>
                                                <option disabled="" style="background-color:#aaa; color:#fff">UNION
                                                    Territories</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Andaman and Nicobar Islands' ? 'selected' : '' }}
                                                    value="Andaman and Nicobar Islands">Andaman and Nicobar Islands
                                                </option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Chandigarh' ? 'selected' : '' }}
                                                    value="Chandigarh">Chandigarh</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Dadar and Nagar Haveli' ? 'selected' : '' }}
                                                    value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Daman and Diu' ? 'selected' : '' }}
                                                    value="Daman and Diu">Daman and Diu</option>
                                                <option {{ $CustomerBillAddress->b_state == 'Delhi' ? 'selected' : '' }}
                                                    value="Delhi">Delhi</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Lakshadeep' ? 'selected' : '' }}
                                                    value="Lakshadeep">Lakshadeep</option>
                                                <option
                                                    {{ $CustomerBillAddress->b_state == 'Pondicherry' ? 'selected' : '' }}
                                                    value="Pondicherry">Pondicherry</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-md-3">
                                            <label class="form-label" for="state">Billing State Pincode</label>
                                            <input type="number" id="billing_pincode" name="billing_pincode"
                                                class="form-control multi-steps-pincode" placeholder="Pin Code"
                                                value="{{ $CustomerBillAddress->b_pincode }}" maxlength="6">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        <div class="divider mt-4">
                            <div class="divider-text">Shipping Details</div>
                        </div>

                        @foreach ($Customer->CustomerShipAddress as $CustomerShipAddress)
                            <!-- Initially display shipping address once -->
                            <div class="card-action mb-4">
                                <div class="card-action-element">
                                </div>
                                <div class="card-body ">


                                    <div class="row">

                                        <div class="mb-3 col-lg-6 col-sm-6" hidden>
                                            <label class="form-label" for="collapsible-address"> Shipping Id</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i
                                                        class="fa-regular fa-address-card"></i></span>
                                                <input type="text" id="ShippingId" name="ShippingId[]"
                                                    value="{{ $CustomerShipAddress->id }}" class="form-control"
                                                    placeholder="Address" />
                                            </div>
                                        </div>

                                        <div class="mb-3 col-lg-6 col-sm-6" hidden>
                                            <label class="form-label" for="collapsible-address"> Shipping Counter</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i
                                                        class="fa-regular fa-address-card"></i></span>
                                                <input type="text" id="ShippingCounter" name="ShippingCounter[]"
                                                    value="{{ $CustomerShipAddress->shipping_count }}"
                                                    class="form-control" placeholder="Address" />
                                            </div>
                                        </div>


                                        <div class="mb-3 col-lg-6 col-sm-6">
                                            <label class="form-label" for="basic-icon-default-fullname">Buyer
                                                Name</label>
                                            <div class="input-group input-group-merge">
                                                <span id="BuyerName" class="input-group-text"><i
                                                        class="ti ti-user"></i></span>
                                                <input type="text" class="form-control" id="ShippingBuyerName"
                                                    name="ShippingBuyerName[]" placeholder="John Doe"
                                                    aria-label="John Doe" value="{{ $CustomerShipAddress->name }}"
                                                    aria-describedby="basic-icon-default-fullname2" />
                                            </div>
                                        </div>

                                        <div class="mb-3 col-lg-6 col-sm-6">
                                            <label class="form-label" for="basic-icon-default-phone">Buyer
                                                Mobile</label>
                                            <div class="input-group input-group-merge">
                                                <span id="BuyerMobile" class="input-group-text"><i
                                                        class="ti ti-phone"></i></span>
                                                <input type="number" id="ShippingBuyerMobile"
                                                    name="ShippingBuyerMobile[]" class="form-control phone-mask"
                                                    placeholder="658 799 8941" aria-label="658 799 8941"
                                                    value="{{ $CustomerShipAddress->mobile }}"
                                                    aria-describedby="basic-icon-default-phone2" />
                                            </div>
                                        </div>

                                        <div class="mb-3 col-lg-6 col-sm-6">
                                            <label class="form-label" for="emailTags">Email</label>
                                            <div id="emailTagsContainer" class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="ti ti-mail"></i></span>
                                                <input type="text" id="ShippingEmail" name="ShippingEmail[]"
                                                    class="form-control"
                                                    placeholder="Enter email addresses separated by commas"
                                                    aria-label="Email addresses"
                                                    aria-describedby="basic-icon-default-email2"
                                                    value="{{ $CustomerShipAddress->email }}"
                                                    onkeydown="addTag(event)" />
                                                {{--                          <span id="basic-icon-default-email2" class="input-group-text">@example.com</span> --}}
                                            </div>
                                        </div>

                                        <div class="mb-3 col-lg-6 col-sm-6 ">
                                            <label class="form-label" for="collapsible-address"> Shipping Address
                                                Line1</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i
                                                        class="fa-regular fa-address-card"></i></span>
                                                <input type="text" id="ShppingAddressLine1"
                                                    name="ShppingAddressLine1[]"
                                                    value="{{ $CustomerShipAddress->s_address1 }}" class="form-control"
                                                    placeholder="Address" />
                                            </div>
                                        </div>


                                        <div class="mb-3 col-lg-6 col-sm-6">
                                            <label class="form-label" for="collapsible-address">Shipping Address
                                                Line2</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i
                                                        class="fa-regular fa-address-card"></i></span>
                                                <input type="text" id="ShppingAddressLine2"
                                                    name="ShppingAddressLine2[]"
                                                    value="{{ $CustomerShipAddress->s_address2 }}" class="form-control"
                                                    placeholder="Address" />
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-3">
                                            <label class="form-label" for="City"> Shipping City</label>
                                            <input required="" type="text" id="ShippingCity"
                                                value="{{ $CustomerShipAddress->s_city }}" name="ShippingCity[]"
                                                class="form-control" placeholder="City">
                                        </div>
                                        <div class="col-lg-2 col-md-3">
                                            <label class="form-label" for="state">Shipping State</label>
                                            <select required="" id="ShippingState" name="ShippingState[]"
                                                class="select2 form-select" data-allow-clear="true">
                                                <option value="">Select State</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Andra Pradesh' ? 'selected' : '' }}
                                                    value="Andra Pradesh">Andra Pradesh</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Arunachal Pradesh' ? 'selected' : '' }}
                                                    value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                <option {{ $CustomerShipAddress->s_state == 'Assam' ? 'selected' : '' }}
                                                    value="Assam">Assam</option>
                                                <option {{ $CustomerShipAddress->s_state == 'Bihar' ? 'selected' : '' }}
                                                    value="Bihar">Bihar</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Chhattisgarh' ? 'selected' : '' }}
                                                    value="Chhattisgarh">Chhattisgarh</option>
                                                <option {{ $CustomerShipAddress->s_state == 'Goa' ? 'selected' : '' }}
                                                    value="Goa">Goa</option>
                                                <option {{ $CustomerShipAddress->s_state == 'Gujarat' ? 'selected' : '' }}
                                                    value="Gujarat">Gujarat</option>
                                                <option {{ $CustomerShipAddress->s_state == 'Haryana' ? 'selected' : '' }}
                                                    value="Haryana">Haryana</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Himachal Pradesh' ? 'selected' : '' }}
                                                    value="Himachal Pradesh">Himachal Pradesh</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Jammu and Kashmir' ? 'selected' : '' }}
                                                    value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Jharkhand' ? 'selected' : '' }}
                                                    value="Jharkhand">Jharkhand</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Karnataka' ? 'selected' : '' }}
                                                    value="Karnataka">Karnataka</option>
                                                <option {{ $CustomerShipAddress->s_state == 'Kerala' ? 'selected' : '' }}
                                                    value="Kerala">Kerala</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Madya Pradesh' ? 'selected' : '' }}
                                                    value="Madya Pradesh">Madya Pradesh</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Maharashtra' ? 'selected' : '' }}
                                                    value="Maharashtra">Maharashtra</option>
                                                <option {{ $CustomerShipAddress->s_state == 'Manipur' ? 'selected' : '' }}
                                                    value="Manipur">Manipur</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Meghalaya' ? 'selected' : '' }}
                                                    value="Meghalaya">Meghalaya</option>
                                                <option {{ $CustomerShipAddress->s_state == 'Mizoram' ? 'selected' : '' }}
                                                    value="Mizoram">Mizoram</option>
                                                <option {{ $CustomerShipAddress->s_state == 'Nagaland' ? 'selected' : '' }}
                                                    value="Nagaland">Nagaland</option>
                                                <option {{ $CustomerShipAddress->s_state == 'Orissa' ? 'selected' : '' }}
                                                    value="Orissa">Orissa</option>
                                                <option {{ $CustomerShipAddress->s_state == 'Punjab' ? 'selected' : '' }}
                                                    value="Punjab">Punjab</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Rajasthan' ? 'selected' : '' }}
                                                    value="Rajasthan">Rajasthan</option>
                                                <option {{ $CustomerShipAddress->s_state == 'Sikkim' ? 'selected' : '' }}
                                                    value="Sikkim">Sikkim</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Tamil Nadu' ? 'selected' : '' }}
                                                    value="Tamil Nadu">Tamil Nadu</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Telangana' ? 'selected' : '' }}
                                                    value="Telangana">Telangana</option>
                                                <option {{ $CustomerShipAddress->s_state == 'Tripura' ? 'selected' : '' }}
                                                    value="Tripura">Tripura</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Uttaranchal' ? 'selected' : '' }}
                                                    value="Uttaranchal">Uttaranchal</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Uttar Pradesh' ? 'selected' : '' }}
                                                    value="Uttar Pradesh">Uttar Pradesh</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'West Bengal' ? 'selected' : '' }}
                                                    value="West Bengal">West Bengal</option>
                                                <option disabled="" style="background-color:#aaa; color:#fff">UNION
                                                    Territories</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Andaman and Nicobar Islands' ? 'selected' : '' }}
                                                    value="Andaman and Nicobar Islands">Andaman and Nicobar Islands
                                                </option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Chandigarh' ? 'selected' : '' }}
                                                    value="Chandigarh">Chandigarh</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Dadar and Nagar Haveli' ? 'selected' : '' }}
                                                    value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Daman and Diu' ? 'selected' : '' }}
                                                    value="Daman and Diu">Daman and Diu</option>
                                                <option {{ $CustomerShipAddress->s_state == 'Delhi' ? 'selected' : '' }}
                                                    value="Delhi">Delhi</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Lakshadeep' ? 'selected' : '' }}
                                                    value="Lakshadeep">Lakshadeep</option>
                                                <option
                                                    {{ $CustomerShipAddress->s_state == 'Pondicherry' ? 'selected' : '' }}
                                                    value="Pondicherry">Pondicherry</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-md-3">
                                            <label class="form-label" for="state">Shipping State Pincode</label>
                                            <input type="number" id="ShippingPincode" name="ShippingPincode[]"
                                                value="{{ $CustomerShipAddress->s_pincode }}"
                                                class="form-control multi-steps-pincode" placeholder="Pin Code"
                                                maxlength="6">
                                        </div>
                                        <div class="col-lg-2 col-md-3">
                                            <label class="form-label" for="state">GST Number</label>
                                            <input type="text" id="GSTNumber" name="GSTNumber[]"
                                                value="{{ $CustomerShipAddress->gst_number }}"
                                                class="form-control multi-steps-pincode" placeholder="GST Number"
                                                maxlength="6">
                                        </div>
                                        <div class="col-lg-2 col-md-3 mt-2">
                                            <div class="demo-inline-spacing">
                                                <button type="button"
                                                    onclick="deleteShippingAddress({{ $CustomerShipAddress->id }})"
                                                    class="btn rounded-pill btn-icon btn-label-danger waves-effect">
                                                    <span class="ti ti-trash"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach

                        <div class="divider mt-4">
                            <div class="divider-text">New Shipping Details</div>
                        </div>

                        <div id="AddShippingItem">
                            <div id="shipping-address-container">
                                <!-- Initially display shipping address once -->
                                <div class="card1 card-action mb-4" id="ShippingContainer">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="mb-3 col-lg-6 col-sm-6">
                                                <label class="form-label" for="basic-icon-default-fullname">Shipping Buyer
                                                    Name</label>
                                                <div class="input-group input-group-merge">
                                                    <span id="BuyerName" class="input-group-text"><i
                                                            class="ti ti-user"></i></span>
                                                    <input type="text" class="form-control" id="ShippingBuyerName"
                                                        name="NewShippingBuyerName[]" placeholder="John Doe"
                                                        aria-label="John Doe"
                                                        aria-describedby="basic-icon-default-fullname2" />
                                                </div>
                                            </div>
                                            <div class="mb-3 col-lg-6 col-sm-6">
                                                <label class="form-label" for="basic-icon-default-phone">Shipping Buyer
                                                    Mobile</label>
                                                <div class="input-group input-group-merge">
                                                    <span id="BuyerMobile" class="input-group-text"><i
                                                            class="ti ti-phone"></i></span>
                                                    <input type="number" id="ShippingBuyerMobile"
                                                        name="NewShippingBuyerMobile[]" class="form-control phone-mask"
                                                        placeholder="658 799 8941" aria-label="658 799 8941"
                                                        aria-describedby="basic-icon-default-phone2" />
                                                </div>
                                            </div>
                                            <div class="mb-3 col-lg-6 col-sm-6">
                                                <label class="form-label" for="emailTags">Shipping Email</label>
                                                <div id="emailTagsContainer" class="input-group input-group-merge">
                                                    <span class="input-group-text"><i class="ti ti-mail"></i></span>
                                                    <input type="text" id="ShippingEmail" name="NewShippingEmail[]"
                                                        class="form-control"
                                                        placeholder="Enter email"
                                                        aria-label="Email addresses"
                                                        aria-describedby="basic-icon-default-email2"
                                                        onkeydown="addTag(event)" />
                                                </div>
                                            </div>
                                            <div class="mb-3 col-lg-6 col-sm-6 ">
                                                <label class="form-label" for="collapsible-address">Shipping Address
                                                    Line1</label>
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i
                                                            class="fa-regular fa-address-card"></i></span>
                                                    <input type="text" id="ShppingAddressLine1"
                                                        name="NewShppingAddressLine1[]" class="form-control"
                                                        placeholder="Address" />
                                                </div>
                                            </div>
                                            <div class="mb-3 col-lg-6 col-sm-6">
                                                <label class="form-label" for="collapsible-address">Shipping Address
                                                    Line2</label>
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i
                                                            class="fa-regular fa-address-card"></i></span>
                                                    <input type="text" id="ShppingAddressLine2"
                                                        name="NewShppingAddressLine2[]" class="form-control"
                                                        placeholder="Address" />
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3">
                                                <label class="form-label" for="City">Shipping City</label>
                                                <input type="text" id="ShippingCity" name="NewShippingCity[]"
                                                    class="form-control" placeholder="City">
                                            </div>
                                            <div class="col-lg-2 col-md-3">
                                                <label class="form-label" for="state">Shipping State</label>
                                                <select id="ShippingState" name="NewShippingState[]"
                                                    class="select2 form-select" data-allow-clear="true">
                                                    <option value="">Select State</option>
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
                                                    <option disabled="" style="background-color:#aaa; color:#fff">UNION
                                                        Territories</option>
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
                                            <div class="col-lg-2 col-md-3">
                                                <label class="form-label" for="state">Shipping State Pincode</label>
                                                <input type="number" id="ShippingPincode" name="NewShippingPincode[]"
                                                    class="form-control multi-steps-pincode" placeholder="Pin Code"
                                                    maxlength="6">
                                            </div>
                                            <div class="col-lg-2 col-md-3">
                                                <label class="form-label" for="state">GST Number</label>
                                                <input type="text" id="GSTNumber" name="NewGSTNumber[]"
                                                    class="form-control multi-steps-pincode" placeholder="GST Number">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-row-reverse">
                                <!-- Button to add more shipping addresses -->
                                <button type="button" onclick="addItem()" class="btn btn-sm btn-primary"
                                    style="margin-left: 7%">Add Shipping
                                    Address
                                </button>
                            </div>
                        </div>


                        <div class="col-lg-3 col-12 invoice-actions mt-3">
                            <button type="submit" class="btn btn-primary d-grid w-100">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


@endsection
<script>
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
                    url: '{{ route('customer-shipping-delete') }}',
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
              <div class="card1 card-action mb-4" id="ShippingContainer_` + counter + `">
                  <div class="card-body ">
                      <div class="row">
                          <div class="mb-3 col-lg-6 col-sm-6">
                              <label class="form-label" for="basic-icon-default-fullname">Shipping Buyer Name</label>
                              <div class="input-group input-group-merge">
                                  <span id="BuyerName" class="input-group-text"><i class="ti ti-user"></i></span>
                                  <input type="text" class="form-control" id="ShippingBuyerName"
                                      name="ShippingBuyerName[]" placeholder="John Doe"
                                      aria-label="John Doe"
                                      aria-describedby="basic-icon-default-fullname2" />
                              </div>
                          </div>
                          <div class="mb-3 col-lg-6 col-sm-6">
                              <label class="form-label" for="basic-icon-default-phone">Shipping Buyer Mobile</label>
                              <div class="input-group input-group-merge">
                                  <span id="BuyerMobile" class="input-group-text"><i class="ti ti-phone"></i></span>
                                  <input type="number" id="ShippingBuyerMobile"
                                      name="ShippingBuyerMobile[]" class="form-control phone-mask"
                                      placeholder="658 799 8941" aria-label="658 799 8941"
                                      aria-describedby="basic-icon-default-phone2" />
                              </div>
                          </div>
                          <div class="mb-3 col-lg-6 col-sm-6">
                              <label class="form-label" for="emailTags">Shipping Email</label>
                              <div id="emailTagsContainer" class="input-group input-group-merge">
                                  <span class="input-group-text"><i class="ti ti-mail"></i></span>
                                  <input type="text" id="ShippingEmail" name="ShippingEmail[]"
                                      class="form-control"
                                      placeholder="Enter email"
                                      aria-label="Email addresses"
                                      aria-describedby="basic-icon-default-email2"
                                      onkeydown="addTag(event)" />
                              </div>
                          </div>
                          <div class="mb-3 col-lg-6 col-sm-6 ">
                              <label class="form-label" for="collapsible-address">Shipping Address Line1</label>
                              <div class="input-group input-group-merge">
                                  <span class="input-group-text"><i class="fa-regular fa-address-card"></i></span>
                                  <input type="text" id="ShppingAddressLine1"
                                      name="ShppingAddressLine1[]" class="form-control"
                                      placeholder="Address" />
                              </div>
                          </div>
                          <div class="mb-3 col-lg-6 col-sm-6">
                              <label class="form-label" for="collapsible-address">Shipping Address Line2</label>
                              <div class="input-group input-group-merge">
                                  <span class="input-group-text"><i class="fa-regular fa-address-card"></i></span>
                                  <input type="text" id="ShppingAddressLine2"
                                      name="ShppingAddressLine2[]" class="form-control"
                                      placeholder="Address" />
                              </div>
                          </div>
                          <div class="col-lg-2 col-md-3">
                              <label class="form-label" for="City">Shipping City</label>
                              <input required="" type="text" id="ShippingCity" name="ShippingCity[]"
                                  class="form-control" placeholder="City">
                          </div>
                          <div class="col-lg-2 col-md-3">
                              <label class="form-label" for="state">Shipping State</label>
                              <select required="" id="ShippingState" name="ShippingState[]"
                                  class="select2 form-select" data-allow-clear="true">
                                  <option value="">Select State</option>
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
                                  <option disabled="" style="background-color:#aaa; color:#fff">UNION Territories</option>
                                  <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                  <option value="Chandigarh">Chandigarh</option>
                                  <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                                  <option value="Daman and Diu">Daman and Diu</option>
                                  <option value="Delhi">Delhi</option>
                                  <option value="Lakshadeep">Lakshadeep</option>
                                  <option value="Pondicherry">Pondicherry</option>
                              </select>
                          </div>
                          <div class="col-lg-2 col-md-3">
                              <label class="form-label" for="state">Shipping State Pincode</label>
                              <input type="number" id="ShippingPincode" name="ShippingPincode[]"
                                  class="form-control multi-steps-pincode" placeholder="Pin Code"
                                  maxlength="6">
                          </div>
                          <div class="col-lg-2 col-md-3">
                              <label class="form-label" for="state">GST Number</label>
                              <input type="text" id="GSTNumber" name="GSTNumber[]"
                                  class="form-control multi-steps-pincode" placeholder="GST Number">
                          </div>
                          <div class="col-md-2 mt-2">
                            <div class="demo-inline-spacing">
                                <button type="button" onclick="removeItem(` + counter + `)"
                                    class="btn rounded-pill btn-icon btn-label-danger waves-effect">
                                    <span class="ti ti-trash"></span></button>
                            </div>
                          </div>
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

    function toggleAddShippingContainer() {
        var checkbox = document.getElementById("AddShippingStatus");
        var addItemContainer = document.getElementById("AddShippingItem");

        var NewShippingBuyerName = document.getElementById("NewShippingBuyerName");
        var NewShippingBuyerMobile = document.getElementById("NewShippingBuyerMobile");
        var NewShippingEmail = document.getElementById("NewShippingEmail");
        var NewGSTNumber = document.getElementById("NewGSTNumber");

        if (checkbox.checked) {
            addItemContainer.style.display = "block";
            NewShippingBuyerName.setAttribute("required", "");
            NewShippingBuyerMobile.setAttribute("required", "");
            NewShippingEmail.setAttribute("required", "");
            NewGSTNumber.setAttribute("required", "");
        } else {
            addItemContainer.style.display = "none";
            NewShippingBuyerName.removeAttribute("required");
            NewShippingBuyerMobile.removeAttribute("required");
            NewShippingEmail.removeAttribute("required");
            NewGSTNumber.removeAttribute("required");
        }
    }
</script>
<script>
    // Function to add a new shipping address
    function addShippingAddress() {
        // Clone the shipping address card
        var newAddress = $('.card1.card-action').first().clone();

        // Clear input values if needed
        newAddress.find('input[type="text"]').val('');
        newAddress.find('input[type="number"]').val('');

        // Enable remove button of all cards
        $('.card-action-element button').prop('disabled', false);

        // Append the cloned shipping address card to the container
        $('#shipping-address-container').append(newAddress);
    }

    // Function to remove a shipping address
    function removeShippingAddress(button) {
        // Check if there's more than one shipping address card
        if ($('.card1.card-action').length > 1) {
            // Find the parent card and remove it
            $(button).closest('.card1.card-action').remove();
        }
    }
</script>
<script>
    function getEmailAddresses() {
        var emailInput = document.getElementById("basic-icon-default-email").value;
        var emailAddresses = emailInput.split(',').map(email => email.trim());
        console.log(emailAddresses);
        // Do further processing with emailAddresses here
    }
</script>


<script>
    // $(".select21").select2();
    // Check selected custom option
    window.Helpers.initCustomOptionCheck();

    $(document).ready(function() {
        $(".select21").select2();
    });
</script>
<script>
    function pageLoadCheck() {
        var gstCheckbox = document.getElementById('gst_available');
        var gstNumberDiv = document.getElementById('gst_number_div');
        var pancardNumberDiv = document.getElementById('pancard_number_div');

        if (gstCheckbox.checked) {
            gstNumberDiv.style.display = 'block';
            pancardNumberDiv.style.display = 'none';
        } else {
            gstNumberDiv.style.display = 'none';
            pancardNumberDiv.style.display = 'block';
        }
    }
</script>
