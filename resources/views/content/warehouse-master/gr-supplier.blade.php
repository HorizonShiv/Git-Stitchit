@extends('layouts.layoutMaster')

@section('title', 'GR To Supplier')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>

@endsection

@section('page-script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left"></span>GR To Supplier
    </h4>
    <form id="formid" class="source-item" action="{{ route('addGrToSupplier') }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="row invoice-add">
            <!-- Invoice Add-->
            <div class="col-lg-12 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">

                    <div class="card-body">
                        <div class="users-list-filter">
                            <div class="row">

                                <div class="col-12 col-sm-4 col-lg-4">
                                    <label for="users-list-verified">GRN No</label>
                                    <fieldset class="form-group">
                                        <select class="form-control select2" onchange="getGrnItem();" name="grnNo"
                                            id="grnNo" data-placeholder="Select GRN">
                                            <option value="">GRN</option>
                                            {{-- @foreach (\App\Models\GrnItem::all() as $GrnData) --}}
                                            @foreach (\App\Models\GrnItem::select('grn_no')->groupBy('grn_no')->get() as $group => $GrnData)
                                                <option value="{{ $GrnData->grn_no }}">{{ $GrnData->grn_no }}</option>
                                            @endforeach

                                        </select>
                                    </fieldset>
                                </div>


                                <div class="col-12 col-sm-4 col-lg-4">
                                    <label class="form-label" for="OrderId">From Warehouse</label>
                                    <select required id="SelectWarehouse" name="WarehouseId"
                                        class="select2 select21 form-select" data-allow-clear="true"
                                        data-placeholder="Select Warehouse">
                                        <option value="" selected>Select Warehouse</option>

                                        @foreach (\App\Models\WareHouse::all() as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }} -
                                                {{ $data->contact_person_name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-12 col-sm-4 col-lg-4" style="display: block" id="ToSupplier">
                                    <label class="form-label" for="OrderId">To Supplier</label>
                                    <select required id="SelectSupplier" name="SupplierId"
                                        class="select2 select21 form-select" data-allow-clear="true"
                                        data-placeholder="Select Supplier">
                                        <option value="" selected>Select Supplier</option>

                                        @foreach (App\Models\User::where('is_active', '1')->where('vendor_type', 'SUPPLIER')->get() as $user)
                                            <option value="{{ $user->id }}">{{ $user->company_name }} -
                                                {{ $user->person_name }}</option>
                                        @endforeach

                                    </select>
                                </div>


                                <div id="withoutPoContainer" class="mt-3" style="display: block;">
                                    <div class="form-group col-sm-12 mt-3">
                                        <table id="Gr_To_SupplyTable"
                                            class="responsive table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <td scope="row">Item Name</td>
                                                    <td scope="row">Received Quantity</td>
                                                    <td scope="row">Return Quantity</td>
                                                    <td scope="row">Action</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <input type="hidden" name="option_count" id="option_count" />
                                            </tfoot>
                                        </table>
                                        <div class="col-lg-3 col-12 invoice-actions mt-3 mb-3">
                                            <button type="button" class="btn btn-outline-primary" onclick="addItem()">Add
                                                another
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 col-lg-4" id="withoutPo" style="display: none;">
                                    <label for="users-list-verified">Supplier</label>
                                    <fieldset class="form-group">
                                        <select class="form-control select2" name="Supplier" id="Supplier">
                                            {{--                      @foreach ($Suppliers as $Supplier) --}}
                                            {{--                        <option value="{{ $Supplier->id }}"> --}}
                                            {{--                          {{ $Supplier->company_name . ' : ' . $Supplier->person_name }} --}}
                                            {{--                        </option> --}}
                                            {{--                      @endforeach --}}
                                        </select>
                                    </fieldset>
                                </div>

                            </div>

                            <div class="col-12 mt-5">
                                <label for="note">Remark:</label>
                                <textarea class="form-control" rows="2" id="remark" name="remark" placeholder="remark"></textarea>
                            </div>
                            <div class="row px-0 mt-3">
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary d-grid w-100">Save</button>
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    <button type="submit" name="AddMore" value="1"
                                        class="btn btn-label-primary waves-effect d-grid w-100">Save & Add more
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Invoice Add-->
            </div>
        </div>
    </form>

    <!-- Offcanvas -->
    @include('_partials._offcanvas.offcanvas-send-invoice')
    <!-- /Offcanvas -->
@endsection

<script>
    function getGrnItem() {
        $('#Gr_To_SupplyTable tbody').empty();
    }

    var counter = 0;

    function addItem() {
        counter++;
        var grnNo = document.getElementById('grnNo').value;

        $.ajax({
            type: "POST",
            url: "{{ route('getGrnItemForWarehouse') }}",
            data: {
                grnNo: grnNo,
                "_token": "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(response) {
                var htmlContent = '<tr id="row_' + counter + '">' + // Add unique ID to the row
                    '<td scope="row">' +
                    '<select onchange="getGrnItemQty(' + counter +
                    ');" class="select2 form-select form-control" name="item[' + counter +
                    ']" id="items_' + counter +
                    '"> <option value="">Select Item</option>';

                $.each(response.GrnItem, function(key, value) {
                    console.log(value.item.name);
                    htmlContent += '<option value="' + value.item.id + '">' + value.item.name +
                        '</option>';
                });

                htmlContent += '</select>' +
                    '</td>' +
                    '<td scope="row">' +
                    '<input type="number" id="receivedQty_' + counter +
                    '" value="" name="receivedQty[' + counter +
                    ']" class="form-control" placeholder=" Received Qty" readonly/>' +
                    '</td>' +
                    '<td scope="row">' +
                    '<input required type="number" id="returnQty_' + counter +
                    '" value="" name="returnQty[' + counter +
                    ']" class="form-control" onkeyup="validateQty(' + counter +
                    ')" placeholder="Return Qty" />' +
                    '</td>' +
                    '<td><button type="button" class="btn rounded-pill btn-icon btn-label-danger waves-effect" onclick="removeItem(' +
                    counter + ')"><span class="ti ti-trash"></span></button></td>' +
                    '</tr>';

                $('#Gr_To_SupplyTable tbody').append(htmlContent);
                $('.select2').select2();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function validateQty(id) {
        var receivedQty = document.getElementById('receivedQty_' + id).value;
        var returnQty = document.getElementById('returnQty_' + id).value;

        if (parseFloat(receivedQty) < parseFloat(returnQty)) {
            toastr.error("You cannot add more then you received");
            $('#returnQty_' + id).val(receivedQty);
        }

    }

    function getGrnItemQty(id) {
        var grnNo = document.getElementById('grnNo').value;
        var itemsId = document.getElementById('items_' + id).value;

        $.ajax({
            type: "POST",
            url: "{{ route('getGrnItemQty') }}",
            data: {
                grnNo: grnNo,
                itemsId: itemsId,
                "_token": "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(response) {
                console.log(response.receivedQty);
                $('#receivedQty_' + id).val(response.receivedQty);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function removeItem(rowId) {
        // Remove the row with the given rowId
        $('#row_' + rowId).remove();
    }

    document.addEventListener("DOMContentLoaded", function() {
        const checkAll = document.getElementById('checkAll');


        checkAll.addEventListener('change', checkAllFun);

        if (checkAll.checked) {
            console.log("Checkbox is checked");
        }

        function checkAllFun() {
            const checkboxes = document.querySelectorAll('.empCheckbox');

            checkboxes.forEach(checkbox => checkbox.checked = document.getElementById('checkAll').checked);
        }
    });
</script>
