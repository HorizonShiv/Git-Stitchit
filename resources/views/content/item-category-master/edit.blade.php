@extends('layouts/layoutMaster')

@section('title', 'Item Category')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script src="{{ asset('assets/js/forms-extras.js') }}"></script>

@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/app-invoice-list.js') }}"></script>
    <script src="{{ asset('assets/js/app-invoice-add.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left">Master / Item Category /</span> Edit
    </h4>
    <!-- Invoice List Widget -->


    <div class="card">
        {{-- <h5 class="card-header">Applicable Categories</h5> --}}
        <div class="card-body">
            <div class="content">


                <div class="content-header mb-4">
                    <h3 class="mb-1">Item Category Information</h3>

                </div>
                @foreach ($ItemCategorys as $ItemCategory)
                    <form method="post" action="{{ route('item-category-update', $ItemCategory->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <label class="form-label" for="categoryName">Category Name</label>
                                    <input type="text" id="categoryName" name="categoryName" class="form-control"
                                        value="{{ $ItemCategory->name }}" placeholder="Category Name" />
                                </div>
                            </div>

                        </div>
                        <br>

                        <div class="divider">
                            <div class="divider-text">Sub Category</div>
                        </div>

                        <div class="row">
                            @foreach ($ItemCategory->ItemSubCategory as $subcategory)
                                <div class="col-md-6 mt-2">
                                    <div class="row">
                                        <div class="col-10">
                                            <label class="form-label" for="SubCategoryId">Subcategory Name</label>
                                            <input type="text" id="SubCategoryId" name="SubCategoryId[]"
                                                value="{{ $subcategory->id }}" class="form-control"
                                                placeholder="Sub Category Name" readonly hidden />
                                            <input type="text" id="SubCategoryCounter" name="SubCategoryCounter[]"
                                                value="{{ $subcategory->subcategory_counter }}" class="form-control"
                                                placeholder="Sub Category Name" readonly hidden />
                                            <input type="text" id="SubCategoryName" name="SubCategoryName[]"
                                                value="{{ $subcategory->name }}" class="form-control"
                                                placeholder="Sub Category Name">
                                        </div>
                                        <div class="col-2 mt-1">
                                            <div class="demo-inline-spacing">
                                                <button type="button" onclick="deleteSubCategory({{ $subcategory->id }})"
                                                    class="btn rounded-pill btn-icon btn-label-danger waves-effect">
                                                    <span class="ti ti-trash"></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <div class="divider mt-5">
                            <div class="divider-text">New Sub Category Section</div>
                        </div>

                        <div id="AddItemContainer" style="display:bloack;">
                            <div class="row" id="dynamicFormContainer">
                                <div class="col-md-6 mt-2">
                                    <div class="col-md-10">
                                        <label class="form-label" for="NewSubCategoryName">Subcategory Name</label>
                                        <input type="text" id="NewSubCategoryName" name="NewSubCategoryName[]"
                                            class="form-control" placeholder="Sub Category Name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-12 invoice-actions mt-3">
                                <button type="button" class="btn btn-outline-primary" onclick="addItem()">Add
                                    another</button>
                            </div>
                        </div>



                        <div class="d-grid gap-2 col-lg-3 mx-auto mt-3">
                            <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light"
                                type="button">Save
                            </button>

                        </div>
                @endforeach


                </form>

            </div>
        </div>
    </div>


@endsection
<script>
    function deleteSubCategory(SubCategory) {
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
                    url: '{{ route('item-subcategory-delete') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        subCategoryId: SubCategory,
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
    function toggleAddItemContainer() {
        var checkbox = document.getElementById("AddItemStatus");
        var addItemContainer = document.getElementById("AddItemContainer");
        if (checkbox.checked) {
            addItemContainer.style.display = "block";
        } else {
            addItemContainer.style.display = "none";
        }
    }
</script>
<script>
    var counter = 0;

    function addItem() {
        counter++;
        // Create a new div element with the specified HTML code
        var newDiv = document.createElement("div");
        newDiv.className = "col-md-6";
        newDiv.id = "item_" + counter;
        newDiv.innerHTML = `
            <div class="row">
              <div class="col-md-10 mt-2">
                  <label class="form-label" for="NewSubCategoryName_` + counter + `">Subcategory Name</label>
                  <input required type="text" id="NewSubCategoryName_` + counter + `" name="NewSubCategoryName[` +
                    counter + `]" value="" class="form-control" placeholder="Sub Category Name" autofocus/>
              </div>
              <div class="col-md-2 mt-3">
                <div class="demo-inline-spacing">
                    <button type="button" onclick="removeItem(` + counter + `)"
                        class="btn rounded-pill btn-icon btn-label-danger waves-effect">
                        <span class="ti ti-trash"></span></button>
                </div>
              </div>
            </div>
          `;

        // Append the new div to the container
        document.getElementById("dynamicFormContainer").appendChild(newDiv);

        // Set focus to the input field
        newDiv.querySelector("input").focus();

    }

    function removeItem(counter) {
        var elementToRemove = document.getElementById("item_" + counter);
        elementToRemove.remove();
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
