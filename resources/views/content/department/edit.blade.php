@extends('layouts/layoutMaster')

@section('title', 'Department-Master')

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
        <span class="text-muted fw-light float-left">Master / Department /</span> Edit
    </h4>
    <!-- Invoice List Widget -->


    <div class="card">
        {{-- <h5 class="card-header">Applicable Categories</h5> --}}
        <div class="card-body">
            <div class="content">


                <div class="content-header mb-4">
                    <h3 class="mb-1">Department Edit</h3>
                </div>
                <form method="post" action="{{ route('department-update', $Department->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label" for="processMaster">Process</label>
                            <select id="processMaster" name="processMaster" class="select2 form-select"
                                data-placeholder="Select Process">
								
                                <option value="">Select Vendor</option>
                                @foreach (App\Models\ProcessMaster::all() as $data)
                                    <option {{ $Department->process_master_id == $data->id ? 'Selected' : '' }}
                                        value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="demographicName">Department Name</label>
                            <input type="text" id="departmentName" name="departmentName" class="form-control"
                                value="{{ $Department->name }}" placeholder="Department Name" />
                        </div>
                    </div>

            </div>
            <br>
            <div class="d-grid gap-2 col-lg-3 mx-auto mt-3" style="float: left">
                <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light" type="button">Save
                </button>
            </div>
            </form>
        </div>
    </div>




@endsection
<script>
    function getVendorDetails() {

        var user_id = document.getElementById('user_id').value;
        $.ajax({
            type: 'POST',
            url: '{{ route('getVendorDetails') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                user_id: user_id,
                "_token": "{{ csrf_token() }}"
            },
            success: function(result) {
                $("#getVendorDetails").html(result);
            },
            error: function(data) {
                console.log(data);
                alert(data);
            }
        });
        calculateTotalAmount();
    }

    function showJobCenterFields() {
        var inHouseRadio = document.getElementById("inlineRadio1");
        var outSourceRadio = document.getElementById("inlineRadio2");
        var vendorDropdown = document.getElementById("vendorDropdown");

        if (outSourceRadio.checked) {
            vendorDropdown.style.display = "block";
        } else if (inHouseRadio.checked) {
            vendorDropdown.style.display = "none";
        }
    }
</script>
