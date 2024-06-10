@extends('layouts/layoutMaster')

@section('title', 'Item Master List')

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
        <span class="text-muted fw-light float-left">Master / Item /</span> Edit
    </h4>
    <!-- Invoice List Widget -->


    <div class="card">
        {{-- <h5 class="card-header">Applicable Categories</h5> --}}
        <div class="card-body">

            <form method="post" action="{{ route('item-master-update', $Item->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="content">
                    <div class="content-header mb-4">
                        <h3 class="mb-1">Item Information</h3>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label" for="ItemName">Name</label>
                            <input required type="text" id="ItemName" name="ItemName" value="{{ $Item->name }}"
                                class="form-control" placeholder="Item name" />
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="Category">Category</label>
                            <select required id="Category" name="Category" class="select2 select21 form-select"
                                data-allow-clear="true" onchange="" data-placeholder="Select Category">
                                <option value="">Select</option>
                                @foreach ($categoryData as $category)
                                    <option @php if($category->id==$Item->item_category_id){ echo 'selected';} @endphp
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="SubCategory">Sub Category</label>
                            <select required id="SubCategory" name="SubCategory" class="select2 form-select"
                                data-allow-clear="true" data-placeholder="Select Sub Category">
                                <option value="">Select</option>
                                @foreach ($SubCategoryData as $SubCategory)
                                    <option @php if($SubCategory->id==$Item->item_subcategory_id){ echo 'selected';} @endphp
                                        value="{{ $SubCategory->id }}">{{ $SubCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label" for="GstRate">GST Rate</label>
                            <select required id="GstRate" name="GstRate" class="select2 select21 form-select"
                                data-allow-clear="true" onchange="" data-placeholder="Select GST Rate">
                                <option value="">Select</option>
                                <option {{ $Item->gst_rate == 0 ? 'selected' : '' }} value="0">0% </option>
                                <option {{ $Item->gst_rate == 5 ? 'selected' : '' }} value="5">5% </option>
                                <option {{ $Item->gst_rate == 10 ? 'selected' : '' }} value="10">10%</option>
                                <option {{ $Item->gst_rate == 12 ? 'selected' : '' }} value="12">12%</option>
                                <option {{ $Item->gst_rate == 15 ? 'selected' : '' }} value="15">15%</option>
                                <option {{ $Item->gst_rate == 18 ? 'selected' : '' }} value="18">18%</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <span>UOM</span>
                            <select name="uom" class="select2 form-select">
                                <option value="">select umo</option>
                                <option {{ $Item->uom == 'MTRS' ? 'selected' : '' }} value="MTRS">MTRS</option>
                                <option {{ $Item->uom == 'PIECES' ? 'selected' : '' }} value="PIECES">PIECES</option>
                                <option {{ $Item->uom == 'CONE' ? 'selected' : '' }} value="CONE">CONE</option>
                                <option {{ $Item->uom == 'TUBE' ? 'selected' : '' }} value="TUBE">TUBE</option>
                                <option {{ $Item->uom == 'KGS' ? 'selected' : '' }} value="KGS">KGS</option>
                                <option {{ $Item->uom == 'PKTS' ? 'selected' : '' }} value="PKTS">PKTS</option>
                                <option {{ $Item->uom == 'BOX' ? 'selected' : '' }} value="PKTS">BOX</option>
                                <option {{ $Item->uom == 'YARDS' ? 'selected' : '' }} value="YARDS">YARDS</option>
                                <option {{ $Item->uom == 'LTR' ? 'selected' : '' }} value="LTR">LTR</option>
                            </select>
                        </div>


                        <div class="col-md-2">
                            <label class="form-label" for="rate">Rate</label>
                            <input type="text" id="rate" name="rate" value="{{ $Item->rate }}"
                                class="form-control" placeholder="Rate" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="item_short_code">Short Code</label>
                            <input type="text" id="item_short_code" name="item_short_code"
                                value="{{ $Item->short_code }}" class="form-control" placeholder="Short Code" />
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="Photo">Photo</label>
                            <input type="file" id="Photo" name="Photo" class="form-control"
                                placeholder="Photo" />
                            @if (!empty($Item->photo))
                                <p class="mt-2"><a target="_blank"
                                        href="{{ url('itemPhoto/' . $Item->id . '/' . $Item->photo) }}">
                                        :-- Download</a></p>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="item-description">Item Description</label>
                            <textarea class="form-control" id="item-description" name="item_description">{{ $Item->item_description }}</textarea>
                        </div>




                    </div>
                    <div class="col-md-2 mt-3">

                        <input class="form-check-input" type="checkbox" value="1"
                            {{ $Item->consume_status == 1 ? 'checked' : '' }} id="issue_as_consume"
                            name="issue_as_consume">
                        <label class="form-check-label" for="defaultCheck1"> Issue as Consume </label>

                    </div>
                    <div class="d-grid gap-2 col-md-2  mt-3">
                        <button type="button" class="btn btn-outline-primary btn-md waves-effect waves-light"
                            data-bs-toggle="modal" data-bs-target="#addParameter" type="button">Add Parameter
                        </button>
                    </div>

                </div>
                <br>

                <div class="d-grid gap-2 col-lg-3 mx-auto mt-3">
                    <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light" type="button">Save
                    </button>

                </div>


                <div class="modal fade" id="addParameter" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                        <div class="modal-content p-3 p-md-5">
                            <div class="modal-body">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                <div class="text-center mb-4">
                                    <h3 class="mb-2">Add New Parameter Information</h3>
                                    <p class="text-muted">This item will be added directly to the inventory for Style</p>
                                </div>
                                <table>
                                    <tbody>
                                        @php
                                            // dd($Item->ParameterConnection->toArray());
                                        @endphp


                                        @foreach ($Parameters as $Parameter)
                                            <tr>
                                                <div class="col-md-2 mt-2">
                                                    {{-- <input class="form-check-input" type="checkbox"
                                                        @foreach ($Item->ParameterConnection as $connection)
                                                        {{ $connection['parameter_master_id'] == $Parameter->id ? 'checked' : '' }} @endforeach
                                                        value="{{ $Parameter->id }}_{{ $Parameter->name }}"
                                                        id="Parameters" name="Parameters[]"> --}}

                                                    <input class="form-check-input" type="radio"
                                                        value="{{ $Parameter->id }}_{{ $Parameter->name }}"
                                                        name="Parameters"
                                                        @foreach ($Item->ParameterConnection as $connection)
                                                        {{ $connection['parameter_master_id'] == $Parameter->id ? 'checked' : '' }} @endforeach
                                                        id="Parameters">
                                                    <label class="form-check-label"
                                                        for="defaultCheck1">{{ $Parameter->name }} </label>
                                                </div>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col-12 text-center">
                                    {{-- <button type="submit" class="btn btn-primary me-sm-3 me-1"
                                      onclick="subm itForm()">Submit
                                  </button> --}}
                                    <button type="button" onclick="clearCheckboxes()" class="btn btn-label-danger">
                                        Clear All
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </form>

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
    function getSubcategories() {
        // Get the selected category ID
        var categoryId = $('#Category').val();

        // Make an AJAX request to get subcategories
        $.ajax({
            url: '/app/item/subCategory', // Replace with your actual route
            method: 'GET',
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
