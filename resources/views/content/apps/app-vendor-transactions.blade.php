@extends('layouts/layoutMaster')

@section('title', 'Vendor - Transactions')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />
@endsection

@section('vendor-script')
  <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
  <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection

@section('page-script')
  {{-- <script src="{{asset('assets/js/tables-datatables-basic.js')}}"></script> --}}
  <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>

@endsection

@section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Vendor /</span> Transactions
  </h4>

  <div class="card mb-4">
    <div class="card-widget-separator-wrapper">

      <div class="card-body card-widget-separator">
        <div class="row gy-4 gy-sm-1 mb-1">

          <div class="col-lg-3 col-md-6 col-sm-6">
            <label for="users-list-verified">Select Ware House</label>
            <fieldset class="form-group">
              <select required id="WareHouse" name="WareHouse" class="select2 select21 form-select"
                      data-allow-clear="true" onchange="getAllData();" data-placeholder="Select Ware House">
                <option value="">All</option>
                @foreach (\App\Models\WareHouse::all() as $data)
                  <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </fieldset>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-6">
            <label for="users-list-verified">Select Item</label>
            <fieldset class="form-group">
              <select required id="Item" name="Item" class="select2 select21 form-select"
                      data-allow-clear="true" onchange="getAllData()" data-placeholder="Select Item">
                <option value="">All</option>
                @foreach (\App\Models\Item::all() as $data)
                  <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </fieldset>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-6">
            <label for="users-list-verified">Select Category</label>
            <fieldset class="form-group">
              <select required id="CategoryId" name="CategoryId" class="select2 select21 form-select"
                      data-allow-clear="true" onchange="getAllData();" data-placeholder="Select Category">
                <option value="">All</option>
                @foreach (\App\Models\ItemCategory::all() as $data)
                  <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </fieldset>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-6">
            <label for="users-list-verified">Select Sub Category</label>
            <fieldset class="form-group">
              <select required id="SubCategoryId" name="SubCategoryId" class="select2 select21 form-select"
                      data-allow-clear="true" onchange="getAllData();" data-placeholder="Select Sub Category">
                <option value="">All</option>
                @foreach (\App\Models\ItemSubCategory::all() as $data)
                  <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </fieldset>
          </div>

          <div class="col-lg-4 col-md-6 col-sm-6">
            <label for="users-list-verified">Select Type</label>
            <fieldset class="form-group">
              <select required id="Type" name="Type" class="select2 select21 form-select"
                      data-allow-clear="true" onchange="getAllData();" data-placeholder="Select Item">
                <option value="">All</option>
                <option value="Add">Add</option>
                <option value="Remove">Remove</option>
                <option value="Replace">Replace</option>
                <option value="Change">Change</option>
              </select>
            </fieldset>
          </div>


          <div class="col-sm-3 col-lg-4">
            <label>Start Date</label>
            <input type="date" class="form-control"
                   value="{{ Auth::user()->role == 'account' ? Auth::user()->invoice_export_date : '' }}"
                   name="startDate" onchange="getAllData();" id="startDate">
          </div>
          <div class="col-sm-3 col-lg-4">
            <label>End Date</label>
            <input type="date" onchange="getAllData();" class="form-control" name="endDate" id="endDate">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- DataTable with Buttons -->
  <div class="card">
    <div class="card-datatable table-responsive pt-0">
      <table class="datatables-basic table" id="datatable-list">
        <thead>
        <tr>
          <th>SR No.</th>
          <th>Ware House</th>
          <th>Item Name</th>
          <th>Type</th>
          <th>Qty</th>
          <th>Rate</th>
          <th>Good Inventory</th>
          <th>Alloted Inventory</th>
          <th>Required Inventory</th>
          <th>Action Done By</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>

@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>
  $(document).ready(function() {
    getAllData();
  });

  function getAllData() {
    let grn_receive = $('input[name="grn_receive"]:checked').val() || "0";
    $("#overlay").fadeIn(100);
    $('#datatable-list').DataTable({
      autoWidth: false,
      order: [
        [0, 'desc']
      ],
      lengthMenu: [
        [10, 20, 100, 50000],
        [10, 20, 100, "All"]
      ],
      "ajax": {
        "url": "{{ route('inventoryHistory') }}",
        "type": "POST",
        "headers": "{ 'X-CSRF-TOKEN': $('meta[name='csrf-token']').attr('content') }",
        "data": {
          "startDate": $('#startDate').val(),
          "endDate": $('#endDate').val(),
          "item_id": $('#Item').val(),
          "category_id": $('#CategoryId').val(),
          "subCategory_id": $('#SubCategoryId').val(),
          "warehouse_id": $('#WareHouse').val(),
          "type": $('#Type').val(),
          "_token": "{{ csrf_token() }}"
        },
      },

      "initComplete": function(setting, json) {
        $("#overlay").fadeOut(100);
      },
      bDestroy: true
    });
  }
</script>
<script>
  $(document).ready(function() {
    $('#CategoryId').change(function() {
      var categoryId = $(this).val();
      if (categoryId) {
        $.ajax({
          type: "GET",
          url: "{{ route('getItemSubCategories') }}",
          data: {
            categoryId: categoryId
          },
          dataType: 'json',
          success: function(response) {
            $('#SubCategoryId').empty();
            $('#SubCategoryId').append('<option value="">Select</option>');
            $.each(response, function(key, value) {
              $('#SubCategoryId').append('<option value="' + value
                  .id +
                '">' + value.name + '</option>');
            });
          }
        });
      } else {
        $('#SubCategoryId').empty();
      }
    });
  });
</script>
