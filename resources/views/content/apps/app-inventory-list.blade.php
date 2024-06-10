@extends('layouts/layoutMaster')

@section('title', 'Inventory')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
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
        <span class="text-muted fw-light">Invertory /</span> List
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
                                data-allow-clear="true" onchange="getAllData();" data-placeholder="Select Item">
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

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-success">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-success"><i
                                    class="ti ti-shopping-cart ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0" id="GoodInventory"></h4>
                    </div>
                    <p class="mb-1">Good Inventory</p>
                    <p class="mb-0">
                        <span class="fw-medium me-1" id="GoodValuation">: </span>
                        <small class="text-muted">In valuation <i class="ti ti-info-square-rounded ti-sm"
                                data-bs-toggle="tooltip" data-bs-placement="right"
                                data-bs-original-title="Rate * Good Inventory Qty"></i></small>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-danger"><i
                                    class="ti ti-shopping-cart ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0" id="BadInventory"></h4>
                    </div>
                    <p class="mb-1">Bad Inventory</p>
                    <p class="mb-0">
                        <span class="fw-medium me-1" id="BadValuation">: </span>
                        <small class="text-muted">In valuation <i class="ti ti-info-square-rounded ti-sm"
                                data-bs-toggle="tooltip" data-bs-placement="right"
                                data-bs-original-title="Rate * Bad Inventory Qty"></i></small>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-info">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-info"><i
                                    class="ti ti-shopping-cart ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0" id="AllotedInventory"></h4>
                    </div>
                    <p class="mb-1">Alloted Inventory</p>
                    <p class="mb-0">
                        <span class="fw-medium me-1" id="AllotedValuation">: </span>
                        <small class="text-muted">In valuation <i class="ti ti-info-square-rounded ti-sm"
                                data-bs-toggle="tooltip" data-bs-placement="right"
                                data-bs-original-title="Rate * Alloted Inventory Qty"></i></small>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-warning"><i
                                    class="ti ti-shopping-cart ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0" id="RequiredInventory"></h4>
                    </div>
                    <p class="mb-1">Required Inventory</p>
                    <p class="mb-0">
                        <span class="fw-medium me-1" id="RequiredValuation">: </span>
                        <small class="text-muted">In valuation <i class="ti ti-info-square-rounded ti-sm"
                                data-bs-toggle="tooltip" data-bs-placement="right"
                                data-bs-original-title="Rate * Required Inventory Qty"></i></small>
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="dataTable table" id="datatable-list">
                <thead>
                    <tr>
                        <th>SR No.</th>
                        <th>Ware House</th>
                        <th>Item Name</th>
                        <th>Total</th>
                        <th>Avg Rate</th>
                        <th>Good Inventory</th>
                        <th>Bad Inventory</th>
                        <th>Alloted Inventory</th>
                        <th>Required Inventory</th>

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
                "url": "{{ route('inventoryFilter') }}",
                "type": "POST",
                "headers": "{ 'X-CSRF-TOKEN': $('meta[name='csrf-token']').attr('content') }",
                "data": {
                    "category_id": $('#CategoryId').val(),
                    "subCategory_id": $('#SubCategoryId').val(),
                    "item_id": $('#Item').val(),
                    "warehouse_id": $('#WareHouse').val(),
                    "_token": "{{ csrf_token() }}"
                },
            },

            "initComplete": function(setting, json) {
                $("#GoodInventory").html(json.SumData.good);
                $("#BadInventory").html(json.SumData.bad);
                $("#AllotedInventory").html(json.SumData.alloted);
                $("#RequiredInventory").html(json.SumData.required);

                $("#GoodValuation").html(json.ValueDate.ValueOfGood);
                $("#BadValuation").html(json.ValueDate.ValueOfBad);
                $("#AllotedValuation").html(json.ValueDate.ValueOfAlloted);
                $("#RequiredValuation").html(json.ValueDate.ValueOfRequired);
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
