@extends('layouts/layoutMaster')

@section('title', 'Style')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>

@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection


@section('content')

    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left">Item /</span> View
    </h4>
    <div class="row">
        <div class="col-12">


            <div class="card">
                {{-- <h5 class="card-header">Applicable Categories</h5> --}}
                <div class="card-body">
                    <div class="content">
                        <div class="content-header mb-4">
                            <h3 class="mb-1">Item (Sample) Information</h3>
                        </div>

                        <div class="row g-4">

                        </div>
                        <div class="row">
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label class="form-label" for="ItemName">Name</label>
                                    <input required type="text" id="ItemName" name="ItemName"
                                        value="{{ $Item->name }}" class="form-control" placeholder="Item name"
                                        readonly />
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="Category">Category</label>
                                    <input required type="text" id="Category" name="Category"
                                        value="{{ $Item->ItemCategory->name }}" class="form-control"
                                        placeholder="Item name" readonly />
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="SubCategory">Sub Category</label>
                                    <input required type="text" id="SubCategory" name="SubCategory"
                                        value="{{ $Item->ItemSubCategory->name }}" class="form-control"
                                        placeholder="Item name" readonly />
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label" for="GstRate">GST Rate</label>
                                    <input type="text" id="GstRate" name="GstRate" value="{{ $Item->gst_rate }} %"
                                        class="form-control" placeholder="GstRate" readonly />
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label" for="uom">UOM</label>
                                    <input type="text" id="uom" name="uom" value="{{ $Item->uom }}"
                                        class="form-control" placeholder="uom" readonly />
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label" for="rate">Rate</label>
                                    <input type="text" id="rate" name="rate" value="{{ $Item->rate }}"
                                        class="form-control" placeholder="Rate" readonly />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="item_short_code">Short Code</label>
                                    <input type="text" id="item_short_code" name="item_short_code"
                                        value="{{ $Item->short_code }}" class="form-control" placeholder="Short Code"
                                        readonly />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="item_short_code">Item Description</label>
                                    <textarea class="form-control" id="item-description" name="item_description" readonly>{{ $Item->item_description }}</textarea>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="Photo">Photo</label>
                                    @if (!empty($Item->photo))
                                        <p class="mt-2"><a target="_blank"
                                                href="{{ url('itemPhoto/' . $Item->id . '/' . $Item->photo) }}">
                                                Photo :-- Download</a></p>
                                    @else
                                        <br>
                                        <span class="badge rounded bg-label-danger">Photo was not
                                            uploaded</span>
                                    @endif
                                </div>

                            </div>

                            <div class="col-md-2 mt-3">
                                <input class="form-check-input" type="checkbox" value="1" id="issue_as_consume"
                                    name="issue_as_consume" {{ $Item->consume_status == 1 ? 'checked' : '' }} disabled>
                                <label class="form-check-label" for="defaultCheck1"> Issue as Consume </label>
                            </div>
                            <div class="divider text-start mt-5">
                                <div class="divider-text">Selected Parameter Details</div>
                            </div>
                            <h6>
                                @foreach ($Item->ParameterConnection as $Parameter)
                                    <span
                                        class="badge rounded bg-label-primary">{{ $Parameter->parameter_master_name }}</span>&nbsp;&nbsp;&nbsp;
                                @endforeach

                            </h6>

                            <div class="col-lg-3 col-12 invoice-actions mt-5">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
    // $(".select21").select2();
    // Check selected custom option
    window.Helpers.initCustomOptionCheck();

    $(document).ready(function() {
        $(".select21").select2();
    });
</script>
<script>
    // // Add this code to generate CSRF token
    // var csrfToken = "{{ csrf_token() }}";

    // // Add CSRF token to AJAX headers
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': csrfToken
    //     }
    // });

    function getSubcategories() {
        // Get the selected category ID
        var categoryId = $('#Category').val();

        // Make an AJAX request to get subcategories
        $.ajax({
            url: '/style-master/subCategory', // Replace with your actual route
            method: 'get',
            data: {
                categoryId: categoryId
            },
            success: function(data) {
                // Clear the existing options in the SubCategory dropdown
                $('#SubCategory').empty();

                // Add the default "Select" option
                $('#SubCategory').append('<option value="">Select</option>');

                // Add the retrieved subcategories to the dropdown
                $.each(data, function(index, SubCategoryData) {
                    $('#SubCategory').append('<option value="' + SubCategoryData.id + '">' +
                        SubCategoryData
                        .name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                // Handle error if needed
                console.error(error);
            }
        });
    }
</script>
