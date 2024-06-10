@php
  $customizerHidden = 'customizer-hide';
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Multi Steps Sign-up - Pages')

@section('vendor-style')
  <!-- Vendor -->
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/toastr/toastr.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}"/>
@endsection

@section('page-style')
  <!-- Page -->
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection
<style>
  #overlay {
    position: fixed;
    top: 0;
    z-index: 100;
    width: 100%;
    height: 100%;
    display: none;
    background: rgba(0, 0, 0, 0.6);
  }

  .cv-spinner {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .spinner {
    width: 40px;
    height: 40px;
    border: 4px #ddd solid;
    border-top: 4px #2e93e6 solid;
    border-radius: 50%;
    animation: sp-anime 0.8s infinite linear;
  }

  @keyframes sp-anime {
    100% {
      transform: rotate(360deg);
    }
  }

  .is-hide {
    display: none;
  }
</style>

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/toastr/toastr.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/pages-auth-multisteps.js')}}"></script>
@endsection
<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>
@section('content')
  <div class="authentication-wrapper authentication-cover authentication-bg">
    <div class="authentication-inner row">
      <!-- Left Text -->
      <div
        class="d-none d-lg-flex col-lg-4 align-items-center justify-content-center p-5 auth-cover-bg-color position-relative auth-multisteps-bg-height">
        <img src="{{ asset('assets/img/illustrations/auth-register-multisteps-illustration.png') }}"
             alt="auth-register-multisteps" class="img-fluid" width="280">

        <img src="{{ asset('assets/img/illustrations/bg-shape-image-'.$configData['style'].'.png') }}"
             alt="auth-register-multisteps" class="platform-bg"
             data-app-light-img="illustrations/bg-shape-image-light.png"
             data-app-dark-img="illustrations/bg-shape-image-dark.png">
      </div>
      <!-- /Left Text -->

      <!--  Multi Steps Registration -->
      <div class="d-flex col-lg-8 align-items-center justify-content-center p-sm-5 p-3">
        <div class="w-px-850">
          <div id="multiStepsValidation" class="bs-stepper shadow-none">
            <div class="bs-stepper-header border-bottom-0">
              <div class="step" data-target="#accountDetailsValidation">
                <button type="button" class="step-trigger">
                  <span class="bs-stepper-circle"><i class="ti ti-smart-home ti-sm"></i></span>
                  <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Vendor</span>
                  <span class="bs-stepper-subtitle">KYC Details</span>
                </span>
                </button>
              </div>
              <div class="line">
                <i class="ti ti-chevron-right"></i>
              </div>
              <div class="step" data-target="#personalInfoValidation">
                <button type="button" class="step-trigger">
                  <span class="bs-stepper-circle"><i class="ti ti-users ti-sm"></i></span>
                  <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Address</span>
                  <span class="bs-stepper-subtitle">Enter Information</span>
                </span>
                </button>
              </div>
              <div class="line">
                <i class="ti ti-chevron-right"></i>
              </div>
              <div class="step" data-target="#billingLinksValidation">
                <button type="button" class="step-trigger">
                  <span class="bs-stepper-circle"><i class="ti ti-file-text ti-sm"></i></span>
                  <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Bank</span>
                  <span class="bs-stepper-subtitle">Bank Details</span>
                </span>
                </button>
              </div>
            </div>
            <div class="bs-stepper-content">
              <form id="multiStepsForm" onSubmit="return false">
              @csrf
              <!-- Account Details -->
                <div id="accountDetailsValidation" class="content">
                  <div class="content-header mb-4">
                    <h3 class="mb-1">Vendor Information</h3>
                    <p>Enter Your Vendor Details</p>
                  </div>
                  <div class="row g-3">
                    <div class="col-sm-6">
                      <label class="form-label" for="company_name">Company Name </label>
                      <input type="text" name="company_name" id="company_name" class="form-control"
                             placeholder="enter company name"/>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="contact_person_name">Contact Person Name </label>
                      <input type="text" name="contact_person_name" id="contact_person_name" class="form-control"
                             placeholder="enter contact person name" onkeydown="return /[a-zA-Z ]/i.test(event.key)"/>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="contact_person_mobile">Contact Person Mobile </label>
                      <input type="number" name="contact_person_mobile" id="contact_person_mobile" class="form-control"
                             placeholder="enter contact person mobile"/>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="email">Email</label>
                      <input type="email" name="email" id="email" class="form-control"
                             placeholder="enter email">
                    </div>

                    <div class="col-12 d-flex justify-content-between mt-4">
                      <button class="btn btn-label-secondary btn-prev" disabled><i
                          class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                      </button>
                      <button class="btn btn-primary btn-next"><span
                          class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Next</span> <i
                          class="ti ti-arrow-right ti-xs"></i></button>
                    </div>
                  </div>
                </div>
                <!-- Personal Info -->
                <div id="personalInfoValidation" class="content">
                  <div class="content-header mb-4">
                    <h3 class="mb-1">Billing Information</h3>
                    <p>Enter Your Billing Information</p>
                  </div>
                  <div class="row g-3">

                    <div class="col-md-12">
                      <label class="form-label" for="b_address1">Address Line 1</label>
                      <input type="text" id="b_address1" name="b_address1" class="form-control"
                             placeholder="Address Line 1"/>
                    </div>
                    <div class="col-md-12">
                      <label class="form-label" for="b_address2">Address Line 2</label>
                      <input type="text" id="b_address2" name="b_address2" class="form-control"
                             placeholder="Address Line 2"/>
                    </div>
                    <div class="col-sm-4">
                      <label class="form-label" for="b_city">City</label>
                      <input type="text" id="b_city" name="b_city" class="form-control" placeholder="city"/>
                    </div>
                    <div class="col-sm-4">
                      <label class="form-label" for="b_state">State</label>
                      <select id="b_state" name="b_state" class="select2 form-select" data-allow-clear="true">
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

                    <div class="col-sm-4">
                      <label class="form-label" for="b_pincode">Pincode</label>
                      <input type="text" id="b_pincode" name="b_pincode"
                             class="form-control multi-steps-pincode" placeholder="Pin Code" maxlength="6"/>
                    </div>


                    <div class="col-md-12">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" onclick="pageLoadCheck();" id="gst_available"
                               name="gst_available">
                        <label class="form-check-label" for="gst_available">Do you have a GST Number?</label>
                      </div>
                    </div>
                    <div class="col-sm-12" id="gst_number_div">
                      <div class="row">
                        <div class="col-sm-6">
                          <label class="form-label" for="gst_number">GST Number</label>
                          <input type="text" name="gst_number" id="gst_number" class="form-control"
                                 placeholder="enter gst number"/>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label" for="gst_number">GST Certificate file</label>
                          <input type="file" name="gst_file" id="gst_file" class="mt-1 form-control"/>
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12" id="pancard_number_div">
                      <div class="row">
                        <div class="col-sm-6">
                          <label class="form-label" for="pancard_number">Pan Card Number</label>
                          <input type="text" name="pancard_number" id="pancard_number" class="form-control"
                                 placeholder="Pan Card Number"/>
                        </div>

                        <div class="col-sm-6">
                          <label class="form-label" for="pancard_number">Pan Card File</label>
                          <input type="file" name="pancard_file" id="pancard_file" class="mt-1 form-control"/>
                        </div>
                      </div>
                    </div>

                    <div class="row g-3">
                      <div class="col-12 d-flex justify-content-between mt-4">
                        <span class="btn btn-label-secondary btn-prev"><i
                            class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                          <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </span>
                        <button class="btn btn-primary btn-next"><span
                            class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Next</span> <i
                            class="ti ti-arrow-right ti-xs"></i></button>
                      </div>
                    </div>
                    <!-- Shipping Links -->
                  </div>
                </div>
                <!-- Billing Links -->
                <div id="billingLinksValidation" class="content">
                  <div class="content-header mb-4">
                    <h3 class="mb-1">Bank Information</h3>
                    <p>Enter your bank information</p>
                  </div>
                  <!-- Credit Card Details -->
                  <div class="row g-3">
                    <div class="col-md-12">
                      <label class="form-label w-100" for="account_number">Account Number</label>
                      <div class="input-group input-group-merge">
                        <input id="account_number" class="form-control multi-steps-card" name="account_number"
                               type="text" placeholder="enter account number"/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="account_name">Account Name</label>
                      <input type="text" id="account_name" class="form-control" name="account_name"
                             placeholder="enter account name"/>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="account_ifsc">IFS Code</label>
                      <input type="text" id="account_ifsc" class="form-control" name="account_ifsc"
                             placeholder="enter IFS code"/>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="account_bank_name">Bank Name</label>
                      <input type="text" id="account_bank_name" class="form-control" name="account_bank_name"
                             placeholder="enter account bank name"/>
                    </div>

                    <div class="col-md-12">
                      <label for="formFile" class="form-label">Upload Cancelled Cheque file</label>
                      <div class="input-group input-group-merge">
                        <input class="form-control" type="file" id="cancelled_cheque" name="cancelled_cheque">
                      </div>
                    </div>
                    <div class="col-12 d-flex justify-content-between mt-4">
                      <span class="btn btn-label-secondary btn-prev"><i
                          class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                      </span>
                      <button type="submit" class="btn btn-success btn-next btn-submit">Submit</button>
                    </div>
                  </div>
                  <!--/ Credit Card Details -->
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- / Multi Steps Registration -->
    </div>
  </div>
  <script>
    // Check selected custom option
    window.Helpers.initCustomOptionCheck();
  </script>
@endsection
