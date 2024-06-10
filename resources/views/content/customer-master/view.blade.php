@extends('layouts/layoutMaster')

@section('title', 'Customer View - Pages')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-user-view.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/modal-edit-user.js') }}"></script>
    <script src="{{ asset('assets/js/app-user-view.js') }}"></script>
    <script src="{{ asset('assets/js/app-user-view-account.js') }}"></script>
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
    <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">User / View /</span> Customer
    </h4>
    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class=" d-flex align-items-center flex-column">
                            <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ asset('assets/img/avatars/15.png') }}"
                                height="100" width="100" alt="User avatar" />
                            <div class="user-info text-center">
                                <h4 class="mb-2">{{ $Customer->company_name }}</h4>
                                <span class="badge bg-label-secondary mt-1">Company Name</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around
        flex-wrap mt-3 pt-3 pb-4 border-bottom">
                        {{-- <div class="d-flex align-items-start me-4 mt-3 gap-2">
                            <span class="badge bg-label-primary p-2 rounded"><i class='ti ti-checkbox ti-sm'></i></span>
                            <div>
                                <p class="mb-0 fw-medium">1.23k</p>
                                <small>Total Amount</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mt-3 gap-2">
                            <span class="badge bg-label-primary p-2 rounded"><i class='ti ti-briefcase ti-sm'></i></span>
                            <div>
                                <p class="mb-0 fw-medium">568</p>
                                <small>Total Invoice</small>
                            </div>
                        </div> --}}
                    </div>

                    <p class="mt-4 small text-uppercase text-muted">Details</p>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="fw-medium me-1">Role:</span>
                                <span>Customer</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium me-1">Contact Person Name:</span>
                                <span>{{ $Customer->buyer_name }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">Email:</span>
                                <span>{{ $Customer->email }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">Mobile:</span>
                                <span>{{ $Customer->buyer_number }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">GST / Pan Card :</span>
                                <span>{{ !empty($Customer->gst_no) ? $Customer->gst_no : $Customer->pancard_no }}</span>
                            </li>

                            {{-- <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">GST Certificate File :</span>
                                @if (!empty($Customer->gst_file))
                                    <a target="_blank" href="{{ url('gst/' . $Customer->id . '/' . $Customer->gst_file) }}"><br>Download
                                        File</a>
                                @endif
                            </li> --}}
                            {{-- <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">Status:</span>
                                <span
                                    class="badge bg-label-{{ $Customer->is_active == '1' ? 'success' : 'danger' }}">{{ $Customer->is_active == '1' ? 'Active' : 'In Active' }}</span>
                            </li> --}}
                        </ul>
                        <div class="d-flex justify-content-center">
                          <a href="{{ route('customer-edit', $Customer->id) }}" class="btn btn-primary me-3">Edit</a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!--/ User Sidebar -->


        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">


            <!-- Billing Address -->
            @foreach ($Customer->CustomerBillAddress as $CustomerBillAddress)
                <div class="card caendforeachrd-action mb-4">
                    <div class="card-header align-items-center">
                        <h5 class="card-action-title mb-0">Billing Address</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-7 col-12">
                                <dl class="row mb-0">
                                    <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Company Name:</dt>
                                    <dd class="col-sm-8">{{ $Customer->company_name }}</dd>

                                    <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Billing Email:</dt>
                                    <dd class="col-sm-8">{{ $Customer->email }}</dd>
                                    {{--
                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Tax ID:</dt>
                                <dd class="col-sm-8">TAX-357378</dd>

                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">VAT Number:</dt>
                                <dd class="col-sm-8">SDF754K77</dd> --}}

                                    <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Billing Address:</dt>
                                    <dd class="col-sm-8">{{ $CustomerBillAddress->b_address1 }}
                                        <br>{{ $CustomerBillAddress->b_address2 }}
                                    </dd>
                                </dl>
                            </div>
                            <div class="col-xl-5 col-12">
                                <dl class="row mb-0">
                                    <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Contact:</dt>
                                    <dd class="col-sm-8">{{ $Customer->buyer_number }}</dd>

                                    <dt class="col-sm-4 mb-2 fw-medium text-nowrap">City:</dt>
                                    <dd class="col-sm-8">{{ $CustomerBillAddress->b_city }}</dd>

                                    <dt class="col-sm-4 mb-2 fw-medium text-nowrap">State:</dt>
                                    <dd class="col-sm-8">{{ $CustomerBillAddress->b_state }}</dd>

                                    <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Pincode:</dt>
                                    <dd class="col-sm-8">{{ $CustomerBillAddress->b_pincode }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="card caendforeachrd-action mb-4">
                <div class="card-header align-items-center">
                    <h5 class="card-action-title mb-0">Shipping Address</h5>
                    {{-- <div class="card-action-element">
                      <a href="javascript:;" class="btn btn-sm btn-primary me-3" data-bs-target="#editUser"
                          data-bs-toggle="modal" onclick="viewModelUserEdit({{ $Customer->id }});">Edit</a>
                  </div> --}}
                </div>
                @foreach ($Customer->CustomerShipAddress as $CustomerShipAddress)
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-7 col-12">
                                <dl class="row mb-0">
                                    <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Person Name:</dt>
                                    <dd class="col-sm-8">{{ $CustomerShipAddress->name }}</dd>

                                    <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Shipping Email:</dt>
                                    <dd class="col-sm-8">{{ $CustomerShipAddress->email }}</dd>

                                    <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Billing Address:</dt>
                                    <dd class="col-sm-8">{{ $CustomerShipAddress->s_address1 }}
                                        <br>{{ $CustomerShipAddress->s_address2 }}
                                    </dd>
                                </dl>
                            </div>
                            <div class="col-xl-5 col-12">
                                <dl class="row mb-0">
                                    {{-- <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Contact:</dt>
                              <dd class="col-sm-8">{{ $Customer->person_mobile }}</dd> --}}

                                    <dt class="col-sm-4 mb-2 fw-medium text-nowrap">City:</dt>
                                    <dd class="col-sm-8">{{ $CustomerShipAddress->s_city }}</dd>

                                    <dt class="col-sm-4 mb-2 fw-medium text-nowrap">State:</dt>
                                    <dd class="col-sm-8">{{ $CustomerShipAddress->s_state }}</dd>

                                    <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Zipcode:</dt>
                                    <dd class="col-sm-8">{{ $CustomerShipAddress->s_pincode }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
        <!--/ User Content -->
    </div>

    <!-- Modal -->
    @include('_partials/_modals/modal-edit-user')
    @include('_partials/_modals/modal-upgrade-plan')
    @include('_partials/_modals/modal-add-new-address')
    <!-- /Modal -->
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<script>
    // Function to add a new shipping address
    function addShippingAddress() {
        // Clone the shipping address card
        var newAddress = $('.card.card-action').first().clone();

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
        if ($('.card.card-action').length > 1) {
            // Find the parent card and remove it
            $(button).closest('.card.card-action').remove();
        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
