@extends('layouts/layoutMaster')

@section('title', 'User - List')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
    <!-- Form Validation -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <!-- Flat Picker -->
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <!-- Form Validation -->
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
@endsection

@section('page-script')
    {{-- <script src="{{asset('assets/js/tables-datatables-basic.js')}}"></script> --}}
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">User /</span> List
    </h4>

    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table" id="datatable-list">
                <thead>
                    <tr>
                        <th>SR No.</th>
                        <th>Company Name</th>
                        <th>Role</th>
                        <th>Person Name</th>
                        <th>Mobile No</th>
                        <th>GST/Pan Card No</th>
                        <th>Vendor Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $num = 1 @endphp
                    @if ($users)
                        @foreach ($users as $user)
                            <tr>
                               {{-- <td class="text-bold">
									<a href="{{ route('app-user-view', base64_encode($user->id)) }}">{{ $user->id }}</a>
                                </td>--}}
								<td class="text-bold"><a href="">{{ $num }}</a></td>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="avatar-wrapper">
                                            <div class="avatar me-2"><span
                                                    class="avatar-initial rounded-circle bg-label-info">{{ substr($user->company_name, 0, 2) }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column"><span
                                                class="fw-medium">{{ $user->company_name }}</span><small
                                                class="text-truncate text-muted">{{ $user->person_name }}</small></div>
                                    </div>

                                </td>
                                <td>
                                    @if ($user->role == 'admin')
                                        <span
                                            class="badge badge-center rounded-pill bg-label-secondary me-3 w-px-30 h-px-30"><i
                                                class="ti ti-device-laptop ti-sm"></i></span>
                                    @elseif($user->role == 'account')
                                        <span
                                            class="badge badge-center rounded-pill bg-label-primary me-3 w-px-30 h-px-30"><i
                                                class="ti ti-chart-pie-2 ti-sm"></i></span>
                                    @else
                                        <span
                                            class="badge badge-center rounded-pill bg-label-warning me-3 w-px-30 h-px-30"><i
                                                class="ti ti-user ti-sm"></i></span>
                                    @endif
                                    {{ $user->role }}
                                </td>
                                <td>{{ $user->person_name }}</td>
                                <td>{{ $user->person_mobile }}</td>
                                <td>
                                    {{ !empty($user->gst_no) ? $user->gst_no : $user->pancard_no }}
                                    @if (!empty($user->gst_file))
                                        <a target="_blank"
                                            href="{{ url('gst/' . $user->id . '/' . $user->gst_file) }}"><br>Download
                                            File</a>
                                    @elseif(!empty($user->pancard_file))
                                        <a target="_blank"
                                            href="{{ url('pancard/' . $user->id . '/' . $user->pancard_file) }}"><br>Download
                                            File</a>
                                    @endif
                                </td>

                                <td>
                                    @if (empty($user->vendor_type))
                                        @if ($user->role === "vendor")
                                            @if (Auth::user()->role == 'admin')
                                                <select name="uom" style="width:30px;"
                                                    id="VendorName_{{ $user->id }}" name="VendorName"
                                                    onchange="setVendorType({{ $user->id }});"
                                                    class="select2 form-select">
                                                    <option value="">Vendor Type</option>
                                                    <option value="SERVICE">Service Provider</option>
                                                    <option value="SUPPLIER">Supplier</option>
                                                </select>
                                            @endif
                                        @endif
                                    @else

                                        <span class="badge rounded bg-label-primary">{{ $user->vendor_type }}</span>
                                    @endif
                                </td>
                                <td><span
                                        class="badge rounded bg-label-{{ $user->is_active == '1' ? 'success' : 'warning' }}">{{ $user->is_active == '1' ? 'Active' : 'In Active' }}</span>
                                </td>
                                <td>
                                    @if (Auth::user()->role == 'admin' && $user->is_active != '1')
                                        <button class="btn btn-sm btn-outline-success waves-effect"
                                            onclick="vendorApprove({{ $user->id }});">
                                            Activate
                                        </button>
                                    @endif
									 <a class="btn btn-icon btn-label-primary mx-2 mt-1"
                                        href="{{ route('app-user-view', base64_encode($user->id)) }}"><i
                                            class="ti ti-eye mx-2 ti-sm"></i></a>
                                </td>
                            </tr>
                            @php $num++ @endphp
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal to add new record -->
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#datatable-list').DataTable({
            order: [
                [0, 'desc']
            ],
        });
    });
    $(document).ready(function() {
        $(".select2").select2();
    });

    function vendorApprove(user_id) {
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
                    url: '{{ route('vendorApprove') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        user_id: user_id,
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
</script>
<script>
    function setVendorType(VendorId) {
        // var VendorName = document.getElementById('VendorName').value;
        // var VendorName = document.querySelector('#VendorName').value;

        var VendorName = document.getElementById('VendorName_' + VendorId).value;


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
                    url: '{{ route('setVendorType') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        vendor_d: VendorId,
                        vendor_name: VendorName,
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
</script>
