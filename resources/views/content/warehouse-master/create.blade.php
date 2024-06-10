@extends('layouts/layoutMaster')

@section('title', 'Master-Warehouse')

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
        <span class="text-muted fw-light float-left">Master / Warehouse /</span> Add
    </h4>
    <!-- Invoice List Widget -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('warehouse-master.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="content">


                            <div class="content-header mb-4">
                                <h3 class="mb-1">Warehouse Information</h3>
                            </div>


                            <div class="card-body ">

                                <div class="row">

                                    <div class="mb-3  col-lg-6 col-sm-6 ">
                                        <label class="form-label" for="basic-icon-default-company">Warehouse Name</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-company2" class="input-group-text"><i
                                                    class="ti ti-building"></i></span>
                                            <input type="text" id="WarehouseName" name="WarehouseName"
                                                value="{{ old('WarehouseName') }}" class="form-control"
                                                placeholder="Warehouse Name" aria-label="Warehouse Name"
                                                aria-describedby="basic-icon-default-company2" />
                                        </div>
                                    </div>
                                    <div class="mb-3 col-lg-6 col-sm-6">
                                        <label class="form-label" for="basic-icon-default-fullname">Contact Person
                                            Name</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                                    class="ti ti-user"></i></span>
                                            <input type="text" class="form-control" id="ContactPersonName"
                                                name="ContactPersonName" value="{{ old('ContactPersonName') }}"
                                                placeholder="John Doe" aria-label="ContactPersaonName"
                                                aria-describedby="basic-icon-default-fullname2" />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-lg-6 col-sm-6">
                                        <label class="form-label" for="basic-icon-default-phone">Contact Person
                                            Mobile</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-phone2" class="input-group-text"><i
                                                    class="ti ti-phone"></i></span>
                                            <input type="number" id="ContactPersonMobile" name="ContactPersonMobile"
                                                value="{{ old('ContactPersonMobile') }}" class="form-control phone-mask"
                                                placeholder="658 799 8941" aria-label="658 799 8941"
                                                aria-describedby="basic-icon-default-phone2" />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-lg-6 col-sm-6">
                                        <label class="form-label" for="collapsible-address">Address Line1</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="fa-regular fa-address-card"></i></span>
                                            <input type="text" id="address_line1" name="address_line1"
                                                value="{{ old('address_line1') }}" class="form-control"
                                                placeholder="Address" />
                                        </div>
                                    </div>


                                    <div class="mb-3 col-lg-6 col-sm-6">
                                        <label class="form-label" for="collapsible-address">Address Line2</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="fa-regular fa-address-card"></i></span>
                                            <input type="text" id="address_line2" name="address_line2"
                                                value="{{ old('address_line2') }}" class="form-control"
                                                placeholder="Address" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-3">
                                        <label class="form-label" for="city">City</label>
                                        <input required="" type="text" id="city" name="city"
                                            class="form-control" value="{{ old('city') }}" placeholder="city">
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <label class="form-label" for="state">State</label>
                                        <select required="" id="state" name="state" class="select2 form-select"
                                            data-allow-clear="true">
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
                                        <label class="form-label" for="pincode">State Pincode</label>
                                        <input type="number" id="pincode" name="pincode"
                                            value="{{ old('pincode') }}" class="form-control multi-steps-pincode"
                                            placeholder="PinCode" maxlength="6">
                                    </div>
                                </div>

                            </div>

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
{{-- <script>
  function addTag(event) {
    if (event.key === 'Enter' || event.key === ',') {
      event.preventDefault();
      const emailTagsContainer = document.getElementById('emailTagsContainer');
      const emailTagsInput = document.getElementById('emailTags');
      const email = emailTagsInput.value.trim();
      if (email !== '') {
        const tag = document.createElement('span');
        tag.textContent = email;
        tag.style.display = 'inline-block';
        tag.style.padding = '2px 6px';
        tag.style.margin = '2px';
        tag.style.backgroundColor = '#7367f0';
        tag.style.color = '#fff';
        tag.style.borderRadius = '3px';
        tag.style.cursor = 'pointer';
        tag.setAttribute('onclick', 'this.remove()');

        // Add a cross sign (✖) within the tag
        const crossSign = document.createElement('span');
        crossSign.textContent = ' ✖';
        crossSign.style.marginLeft = '5px';
        tag.appendChild(crossSign);

        emailTagsContainer.insertBefore(tag, emailTagsInput);
        emailTagsInput.value = '';
      }
    }
  }


</script> --}}

<script>
    function getEmailAddresses() {
        var emailInput = document.getElementById("basic-icon-default-email").value;
        var emailAddresses = emailInput.split(',').map(email => email.trim());
        console.log(emailAddresses);
        // Do further processing with emailAddresses here
    }


    function addItem() {
        // Create a new div element with the specified HTML code
        var newDiv = document.createElement("div");
        newDiv.className = "col-md-6";
        newDiv.innerHTML = `
        <div class="col-md-12 mt-2">
            <label class="form-label" for="BrandName">Brand</label>
            <input required type="text" id="BrandName" name="BrandName[]" value="" class="form-control" placeholder="Brand Name" />
        </div>
    `;

        // Append the new div to the container
        document.getElementById("dynamicFormContainer").appendChild(newDiv);
    }

    function removeItem() {
        var container = document.getElementById("dynamicFormContainer");

        // Check if there are items to remove
        if (container.children.length > 0) {
            // Remove the last child (last added item)
            container.removeChild(container.lastChild);
        }
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

{{-- @extends('layouts/layoutMaster') --}}

{{-- @section('title', 'Master-Buyer') --}}

{{-- @section('vendor-style') --}}
{{--    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}"> --}}
{{--    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}"> --}}
{{--    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" /> --}}
{{--    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}"> --}}
{{--    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" /> --}}
{{--    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" /> --}}
{{-- @endsection --}}

{{-- @section('page-script') --}}
{{--    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script> --}}
{{--    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script> --}}
{{--    <script src="{{ asset('assets/js/form-layouts.js') }}"></script> --}}
{{-- @endsection --}}

{{-- @section('vendor-script') --}}
{{--    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script> --}}
{{--    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script> --}}
{{-- @endsection --}}


{{-- @section('content') --}}
{{--    <h4 class="py-3 mb-4"> --}}
{{--        <span class="text-muted fw-light float-left">Master / Buyer /</span> Add --}}
{{--    </h4> --}}
{{--    <!-- Invoice List Widget --> --}}

{{--    <div class="row"> --}}
{{--        <div class="col-12"> --}}
{{--            <div class="card"> --}}
{{--                 <h5 class="card-header">Applicable Categories</h5> --}}
{{--                <div class="card-body"> --}}
{{--                    <form method="post" action="{{ route('app-buyerMaster-store') }}" enctype="multipart/form-data"> --}}
{{--                        @csrf --}}
{{--                        <div class="content"> --}}


{{--                            <div class="content-header mb-4"> --}}
{{--                                <h3 class="mb-1">Buyer Information</h3> --}}
{{--                            </div> --}}

{{--                            <div class="row g-3"> --}}
{{--                                <div class="col-sm-6"> --}}
{{--                                    <label class="form-label" for="company_name">Company Name </label> --}}
{{--                                    <input type="text" name="company_name" value="{{ old('company_name') }}" --}}
{{--                                        id="company_name" class="form-control" placeholder="enter Buyer name" /> --}}
{{--                                </div> --}}
{{--                                <div class="col-sm-6"> --}}
{{--                                    <label class="form-label" for="buyer_name">Buyer Name </label> --}}
{{--                                    <input type="text" name="buyer_name" id="buyer_name" class="form-control" --}}
{{--                                        placeholder="enter buyer name" onkeydown="return /[a-zA-Z ]/i.test(event.key)" --}}
{{--                                        value="{{ old('buyer_name') }}" /> --}}
{{--                                </div> --}}
{{--                                <div class="col-sm-6"> --}}
{{--                                    <label class="form-label" for="buyer_mobile">Buyer Mobile </label> --}}
{{--                                    <input type="number" name="buyer_mobile" id="buyer_mobile" class="form-control" --}}
{{--                                        placeholder="enter Buyer mobile" value="{{ old('buyer_mobile') }}" /> --}}
{{--                                </div> --}}
{{--                                <div class="col-sm-6"> --}}
{{--                                    <label class="form-label" for="email">Email</label> --}}
{{--                                    <input type="email" name="email" value="{{ old('email') }}" id="email" --}}
{{--                                        class="form-control" placeholder="enter email"> --}}
{{--                                </div> --}}
{{--                            </div> --}}

{{--                            <div class="divider"> --}}
{{--                                <div class="divider-text mt-4 mb-2">Address Details</div> --}}
{{--                            </div> --}}

{{--                            <div class="row g-3"> --}}
{{--                                <div class="col-md-6"> --}}
{{--                                    <label class="form-label" for="b_address1">Address Line 1</label> --}}
{{--                                    <input type="text" id="b_address1" name="b_address1" value="{{ old('b_address1') }}" --}}
{{--                                        class="form-control" placeholder="Address Line 1" /> --}}
{{--                                </div> --}}
{{--                                <div class="col-md-6"> --}}
{{--                                    <label class="form-label" for="b_address2">Address Line 2</label> --}}
{{--                                    <input type="text" id="b_address2" name="b_address2" value="{{ old('b_address2') }}" --}}
{{--                                        class="form-control" placeholder="Address Line 2" /> --}}
{{--                                </div> --}}


{{--                        </div> --}}


{{--                        <div class="col-lg-3 col-12 invoice-actions mt-5"> --}}
{{--                            <button type="submit" class="btn btn-primary d-grid w-100">Save</button> --}}

{{--                        </div> --}}
{{--                    </form> --}}
{{--                </div> --}}
{{--            </div> --}}
{{--        </div> --}}
{{--    </div> --}}


{{-- @endsection --}}
{{-- <script> --}}
{{--    function addItem() { --}}
{{--        // Create a new div element with the specified HTML code --}}
{{--        var newDiv = document.createElement("div"); --}}
{{--        newDiv.className = "col-md-6"; --}}
{{--        newDiv.innerHTML = ` --}}
{{--        <div class="col-md-12 mt-2"> --}}
{{--            <label class="form-label" for="BrandName">Brand</label> --}}
{{--            <input required type="text" id="BrandName" name="BrandName[]" value="" class="form-control" placeholder="Brand Name" /> --}}
{{--        </div> --}}
{{--    `; --}}

{{--        // Append the new div to the container --}}
{{--        document.getElementById("dynamicFormContainer").appendChild(newDiv); --}}
{{--    } --}}

{{--    function removeItem() { --}}
{{--        var container = document.getElementById("dynamicFormContainer"); --}}

{{--        // Check if there are items to remove --}}
{{--        if (container.children.length > 0) { --}}
{{--            // Remove the last child (last added item) --}}
{{--            container.removeChild(container.lastChild); --}}
{{--        } --}}
{{--    } --}}
{{-- </script> --}}


{{-- <script> --}}
{{--    // $(".select21").select2(); --}}
{{--    // Check selected custom option --}}
{{--    window.Helpers.initCustomOptionCheck(); --}}

{{--    $(document).ready(function() { --}}
{{--        $(".select21").select2(); --}}
{{--    }); --}}
{{-- </script> --}}
{{-- <script> --}}
{{--    function pageLoadCheck() { --}}
{{--        var gstCheckbox = document.getElementById('gst_available'); --}}
{{--        var gstNumberDiv = document.getElementById('gst_number_div'); --}}
{{--        var pancardNumberDiv = document.getElementById('pancard_number_div'); --}}

{{--        if (gstCheckbox.checked) { --}}
{{--            gstNumberDiv.style.display = 'block'; --}}
{{--            pancardNumberDiv.style.display = 'none'; --}}
{{--        } else { --}}
{{--            gstNumberDiv.style.display = 'none'; --}}
{{--            pancardNumberDiv.style.display = 'block'; --}}
{{--        } --}}
{{--    } --}}
{{-- </script> --}}
