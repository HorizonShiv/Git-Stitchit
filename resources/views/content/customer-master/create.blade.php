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
                    <form method="post" action="{{ route('customer.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="content">


                            <div class="content-header mb-4">
                                <h3 class="mb-1">Customer Information</h3>
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
                                                aria-describedby="basic-icon-default-company2" />
                                        </div>
                                    </div>
                                    <div class="mb-3 col-lg-6 col-sm-6">
                                        <label class="form-label" for="basic-icon-default-fullname">Buyer Name</label>
                                        <div class="input-group input-group-merge">
                                            <span id="BuyerName" class="input-group-text"><i class="ti ti-user"></i></span>
                                            <input type="text" class="form-control" id="BuyerName" name="BuyerName"
                                                placeholder="John Doe" aria-label="John Doe"
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
                                                aria-label="658 799 8941" aria-describedby="basic-icon-default-phone2" />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-lg-6 col-sm-6">
                                        <label class="form-label" for="emailTags">Email</label>
                                        <div id="emailTagsContainer" class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                                            <input type="text" id="email" name="email" class="form-control"
                                                placeholder="Enter email addresses separated by commas"
                                                aria-label="Email addresses" aria-describedby="basic-icon-default-email2"
                                                onkeydown="addTag(event)" />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-lg-6 col-sm-6">
                                        <label class="form-label" for="b_name">Gst No</label>
                                        <input type="text" id="billing_gst_no" name="billing_gst_no" class="form-control"
                                            placeholder="Gst No Name" />
                                    </div>

                                    <div class="mb-3 col-lg-6 col-sm-6">
                                        <label class="form-label" for="collapsible-address"> Billing Address Line1</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="fa-regular fa-address-card"></i></span>
                                            <input type="text" id="billing_address_line1" name="billing_address_line1"
                                                class="form-control" placeholder="Address" />
                                        </div>
                                    </div>


                                    <div class="mb-3 col-lg-6 col-sm-6">
                                        <label class="form-label" for="collapsible-address">Billing Address Line2</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i
                                                    class="fa-regular fa-address-card"></i></span>
                                            <input type="text" id="billing_address_line2" name="billing_address_line2"
                                                class="form-control" placeholder="Address" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-3">
                                        <label class="form-label" for="City"> Billing City</label>
                                        <input required="" type="text" id="billing_city" name="billing_city"
                                            class="form-control" placeholder="city">
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <label class="form-label" for="state">Billing State</label>
                                        <select required="" id="billing_state" name="billing_state"
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
                                        <label class="form-label" for="state">Billing State Pincode</label>
                                        <input type="number" id="billing_pincode" name="billing_pincode"
                                            class="form-control multi-steps-pincode" placeholder="Pin Code"
                                            maxlength="6">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="divider mt-4">
                            <div class="divider-text">Shipping Details</div>
                        </div>

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
                                                    name="ShippingBuyerName[]" placeholder="John Doe"
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
                                                    class="form-control" placeholder="Enter email"
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
                                                    name="ShppingAddressLine1[]" class="form-control"
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
                                            <input type="number" id="ShippingPincode" name="ShippingPincode[]"
                                                class="form-control multi-steps-pincode" placeholder="Pin Code"
                                                maxlength="6">
                                        </div>
                                        <div class="col-lg-2 col-md-3">
                                            <label class="form-label" for="state">GST Number</label>
                                            <input type="text" id="GSTNumber" name="GSTNumber[]"
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
                        <div class="row px-0 mt-3">
                            <div class="col-lg-2 col-md-12 col-sm-12">
                                <button type="submit" class="btn btn-primary d-grid w-100">Save</button>
                            </div>
                            <div class="col-lg-2 col-md-12 col-sm-12">
                                <button type="submit" name="AddMore" value="1"
                                    class="btn btn-label-primary waves-effect d-grid w-100">Save & Add more</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


@endsection

<script>
    function getEmailAddresses() {
        var emailInput = document.getElementById("basic-icon-default-email").value;
        var emailAddresses = emailInput.split(',').map(email => email.trim());
        console.log(emailAddresses);
        // Do further processing with emailAddresses here
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
</script>


<script>
    // $(".select21").select2();
    // Check selected custom option
    window.Helpers.initCustomOptionCheck();

    $(document).ready(function() {
        $(".select2").select2();
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
