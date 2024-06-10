@extends('layouts/layoutMaster')

@section('title', 'QC List')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}"/>
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
    <span class="text-muted fw-light float-left">Master / Item /</span> Add
  </h4>
  <!-- Invoice List Widget -->


  <div class="card">
    {{-- <h5 class="card-header">Applicable Categories</h5> --}}
    <div class="card-body">

      <form method="post" action="{{ route('app-item-store') }}" enctype="multipart/form-data">
        @csrf

        <div class="content">


          <div class="content-header mb-4">
            <h3 class="mb-1">Item Information</h3>
          </div>

          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label" for="ItemName">Name</label>
              <input required type="text" id="ItemName" name="ItemName" value="{{ old('ItemName') }}"
                     class="form-control" placeholder="Item name"/>
            </div>

            <div class="col-md-4">
              <label class="form-label" for="Category">Category</label>
              <select required id="Category" name="Category" class="select2 select21 form-select"
                      data-allow-clear="true" onchange="getSubcategories()" data-placeholder="Select Category">
                <option value="">Select</option>
                @foreach ($categoryData as $category)
                  <option @php if($category->id==old('Category')){ echo 'selected';} @endphp
                          value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach

              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label" for="SubCategory">Sub Category</label>
              <select required id="SubCategory" name="SubCategory" class="select2 form-select"
                      data-allow-clear="true" data-placeholder="Select Sub Category">
                <option value="">Select</option>
                {{-- @foreach ($SubCategoryData as $SubCategory)
                    <option @php if($SubCategory->id==old('SubCategory')){ echo 'selected';} @endphp value="{{ $SubCategory->id }}">{{ $SubCategory->name }}</option>
                @endforeach --}}
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label" for="Stage">Stage</label>
              <select id="Stage" name="Stage" class="select2 select21 form-select"
                      data-allow-clear="true" data-placeholder="Select Stage">
                <option value="">Select</option>
                @foreach(\App\Models\Stage::all() as $stage)
                  <option @php if($stage->id==old('Stage')){ echo 'selected';} @endphp
                          value="{{ $stage->id }}">{{ $stage->stage_name }}</option>
                @endforeach

              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label" for="rate">Rate</label>
              <input type="text" id="rate" name="rate" value="{{ old('rate') }}"
                     class="form-control" placeholder="Rate"/>
            </div>

            <div class="col-md-4">
              <label class="form-label" for="AvgCost">Avg Cost</label>
              <input type="text" id="AvgCost" value="{{ old('AvgCost') }}" name="AvgCost"
                     class="form-control" placeholder="Average Cost"/>
            </div>

          </div>
        </div>
        <br>

        <div class="d-grid gap-2 col-lg-3 mx-auto mt-3">
          <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light"
                  type="button">Save
          </button>

        </div>


      </form>

    </div>
  </div>



@endsection
<script>
  // $(".select21").select2();
  // Check selected custom option
  window.Helpers.initCustomOptionCheck();

  $(document).ready(function () {
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
      success: function (data) {
        // Clear the existing options in the SubCategory dropdown
        $('#SubCategory').empty();

        // Add the default "Select" option
        $('#SubCategory').append('<option value="">Select</option>');

        // Add the retrieved subcategories to the dropdown
        $.each(data, function (index, SubCategoryData) {
          $('#SubCategory').append('<option value="' + SubCategoryData.id + '">' +
            SubCategoryData
              .name + '</option>');
        });
      },
      error: function (xhr, status, error) {
        // Handle error if needed
        console.error(error);
      }
    });
  }
</script>
