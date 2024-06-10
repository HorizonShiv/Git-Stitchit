@extends('layouts.layoutMaster')

@section('title', 'Add - PO')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

@section('page-script')
    {{-- <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/app-grn-add.js') }}"></script> --}}
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
    <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left">Outward/</span> ADD
    </h4>
    <form id="formid" class="source-item" action="{{ route('outward-add') }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="row invoice-add">
            <!-- Invoice Add-->
            <div class="col-lg-12 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">

                    <div class="card-body">
                        <div class="users-list-filter">

                            <div class="row card-body">

                                <div class="form-check form-check-primary mt-3 col-md-3">
                                    <input class="form-check-input" type="radio" name="radio" value="Department"
                                        id="departmentRadio" checked onchange="toggle()" />
                                    <label class="form-check-label" for="WithJobOrder">Department</label>
                                </div>

                                <div class="form-check form-check-primary mt-3 col-md-3">
                                    <input class="form-check-input" type="radio" name="radio" value="JobCenter"
                                        id="jobCenterRadio" onchange="toggle()">
                                    <label class="form-check-label" for="WithJobOrder">Job Center</label>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6" id="warehouseDropDown">

                                    <label class="form-label" for="form-repeater-1-1">From</label>
                                    <select id="warehouse_id" name="warehouse_id" class="select2 form-select"
                                        data-placeholder="Select Warehouse">
                                        <option value="">Select Warehouse</option>
                                        @foreach (App\Models\WareHouse::all() as $WareHouse)
                                            <option value="{{ $WareHouse->id }}">{{ $WareHouse->name }}</option>
                                        @endforeach
                                    </select>

                                </div>


                                <div class="col-md-6" id="departmentDropDown">
                                    <label class="form-label" for="form-repeater-1-1">To</label>
                                    <select id="department_id" name="department_id" class="select2 form-select"
                                        data-placeholder="Select Department">
                                        <option value=""></option>
                                        @foreach (App\Models\Department::all() as $Department)
                                            <option value="{{ $Department->id }}">{{ $Department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6" id="serviceDropDown">
                                    <label class="form-label" for="form-repeater-1-1">To</label>
                                    <select id="service_id" name="service_id" class="select2 form-select"
                                        data-placeholder="Select Service">
                                        <option value=""></option>
                                        @foreach (App\Models\User::where('is_active', '1')->where('vendor_type', 'SERVICE')->get() as $user)
                                            <option value="{{ $user->id }}">{{ $user->company_name }} -
                                                {{ $user->person_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>


                            <div id="withPoContainer" class="mt-3" style="display: block;">
                                <div class="form-group col-sm-12 mt-3">
                                    <table id="outward_Table"
                                        class="responsive table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td scope="row">Job Order No.</td>
                                                <td scope="row">Item Name</td>
                                                <td scope="row">Inventory Qty</td>
                                                <td scope="row">Required Qty</td>
                                                <td scope="row">Already Issued Qty</td>
                                                <td scope="row">Remaining to Issue</td>
                                                <td scope="row">Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <input type="hidden" name="option_count" id="option_count">
                                        </tfoot>
                                    </table>
                                    <div class="col-lg-3 col-12 invoice-actions mt-3 ">
                                        <button type="button" class="btn btn-outline-primary waves-effect"
                                            onclick="addItem()">Add
                                            another
                                        </button>
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
                    </div>

                </div>
            </div>
        </div>
        </div>
    </form>

    <!-- Offcanvas -->
    @include('_partials._offcanvas.offcanvas-send-invoice')
    <!-- /Offcanvas -->
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // On page load, show the department dropdown and hide the service dropdown
        var departmentDropDown = document.getElementById('departmentDropDown');
        var serviceDropDown = document.getElementById('serviceDropDown');
        departmentDropDown.style.display = 'block';
        serviceDropDown.style.display = 'none';
    });


    function toggle() {
        var DepartmentRadio = document.getElementById('departmentRadio');
        var JobCenterRadio = document.getElementById('jobCenterRadio');

        var departmentDropDown = document.getElementById('departmentDropDown');
        var serviceDropDown = document.getElementById('serviceDropDown');

        if (DepartmentRadio.checked) {
            departmentDropDown.style.display = 'block';
            serviceDropDown.style.display = 'none';
        }
        if (JobCenterRadio.checked) {
            departmentDropDown.style.display = 'none';
            serviceDropDown.style.display = 'block';
        }
    }

    // Initialize counter
    var counter = 0;

    function addItem() {


        counter++; // Increment counter
        // <input type="text" id="items_${counter}" name="item[${counter}]" class="form-control" placeholder="Item Name">
        // Construct HTML content for a new row
        var htmlContent = `<tr id="row_${counter}">
        <td>
                 <select onchange="getJobOrderItem(${counter});" class="select2 form-select form-control item-select" name="joborder[${counter}]" id="joborder_${counter}">
                  <option value="">Select Job Order</option>
                  @foreach (App\Models\JobOrders::all() as $JobOrder)
                      <option value="{{ $JobOrder->id }}">{{ $JobOrder->job_order_no }}</option>
                  @endforeach
                <!-- Populate options dynamically -->
            </select>
        </td>
        <td style="min-width: 350px;">
            <select onchange="getJobOrderItemQty(${counter});" class="select2 form-select form-control item-select w-100" name="item[${counter}]" id="items_${counter}">
              <option value="">Select Items</option>
                @foreach (\App\Models\Item::all() as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" id="invetoryQty_${counter}" name="invetoryQty[${counter}]" class="form-control" placeholder="Inventory Qty" readonly></td>
        <td><input type="number" id="requiredQty_${counter}" name="requriedQty[${counter}]" class="form-control" placeholder="Required Qty" readonly></td>
        <td><input type="number" value="0" id="isuueQty_${counter}" name="issueQty[${counter}]" class="form-control" placeholder="Issued  Qty" readonly></td>
        <td><input type="number" id="remainToIssueQty_${counter}" onkeyup="checkQty(${counter})" name="remainToIssueQty[${counter}]" class="form-control" placeholder="Remaning to Issue"></td>
        <td><button type="button" class="btn rounded-pill btn-icon btn-label-danger waves-effect" onclick="removeItem(${counter})"><span class="ti ti-trash"></span></button></td>
    </tr>`;

        // Append the content to the table body
        $('#outward_Table tbody').append(htmlContent);

        // Initialize select2 for the newly added select element
        // $(`#items_${counter}`).select2();
        $('.select2').select2();
    }

    // Handle "Check All" functionality
    // $(document).on('change', '#checkAll', function() {
    //   const isChecked = $(this).prop('checked');
    //   console.log('Checked:', isChecked); // Log checked state
    //   $('.item-checkbox').prop('checked', isChecked); // Set checked state for item checkboxes
    // });

    document.querySelector('.maincheckbox').addEventListener('change', function() {
        console.log('Check All checkbox changed');

        var isChecked = this.checked;
        console.log('Check All checkbox state:', isChecked);

        var checkboxes = document.getElementsByClassName('item-checkbox');
        console.log('Total checkboxes:', checkboxes.length);

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = isChecked;
            console.log(`Checkbox ${i + 1} state set to:`, isChecked);
        }
    });


    function removeItem(rowId) {
        // Remove the row with the given rowId
        $('#row_' + rowId).remove();
    }
</script>

<script>
    function checkQty(id) {
        var invetoryQty = document.getElementById('invetoryQty_' + id).value;
        var qty = document.getElementById('remainToIssueQty_' + id).value;

        if (parseFloat(invetoryQty) < parseFloat(qty)) {
            toastr.error("You cannot add more then inventory qty");
            $('#remainToIssueQty_' + id).val(invetoryQty);
        }
    }

    function getJobOrderItem(id) {
        var joborderId = document.getElementById('joborder_' + id).value;
        console.log(joborderId);
        $.ajax({
            type: "POST",
            url: "{{ route('getJobOrderItem') }}",
            data: {
                joborder: joborderId,
                "_token": "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                $('#requiredQty_' + id).val('');
                $('#isuueQty_' + id).val('');
                $('#invetoryQty_' + id).val('');
                $('#remainToIssueQty_' + id).val('');
                $('#items_' + id).empty();
                $('#items_' + id).append('<option value="">Select item</option>');
                $.each(response, function(key, value) {
                    $('#items_' + id).append('<option value="' + value.item.id +
                        '">' + value.item.name + '</option>');
                });


            },
            error: function(xhr, status, error) { // Add an error handler
                console.error(xhr.responseText); // Log the error for debugging
            }
        });
    }

    function getJobOrderItemQty(id) {
        var joborderId = document.getElementById('joborder_' + id).value;
        var itemsId = document.getElementById('items_' + id).value;

        $.ajax({
            type: "POST",
            url: "{{ route('getJobOrderItemQty') }}", // Update the URL to the correct route
            data: {
                joborder: joborderId,
                itemsId: itemsId,
                "_token": "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(response) {

                var reaminQty = response.required_qty - response.issued_qty;

                // console.log(reaminQty);
                $('#requiredQty_' + id).val(Math.round(response.required_qty));
                $('#isuueQty_' + id).val(response.issued_qty);

                if (response.invetory_qty == 0) {
                    toastr.error("Inventory is not available");
                }
                $('#invetoryQty_' + id).val(response.invetory_qty);

                if (reaminQty > 0) {
                    $('#remainToIssueQty_' + id).val(Math.round(reaminQty));
                } else {
                    $('#remainToIssueQty_' + id).val(0);
                }


            },
            error: function(xhr, status, error) { // Add an error handler
                console.error(xhr.responseText); // Log the error for debugging
            }
        });

    }


    function getPODetailForGRN() {
        $('#option-value tbody').empty();
        var poNo = document.getElementById('poNo').value;

        // $body.addClass("loading");
        $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url: '{{ route('getPODetailForGRN') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                poNo: poNo,
                '_token': "{{ csrf_token() }}"
            },
            success: function(data) {
                if (data === 3) {
                    $('#option-value tbody').empty();
                } else {
                    $('#option-value tbody').append(data);
                }
            },
            error: function(data) {
                $('#option-value tbody').empty();
            }
        });
    }

    function qtyCheck(qty, id) {
        var currentQty = qty || 0;
        var insertQty = $('#qty' + id).val();
        if (insertQty > currentQty) {
            Swal.fire('Opps !', 'Qty is greater than invoice Qty!!!', 'error');
            $('#qty' + id).val(currentQty);
        }
    }

    function goodBadCheck(qty, id) {
        var currentQty = qty || 0;
        var gQty = $('#g_qty' + id).val() || 0;
        var bQty = $('#b_qty' + id).val() || 0;
        var total = parseFloat(gQty) + parseFloat(bQty);
        if (total > currentQty) {
            Swal.fire('Opps !', 'Qty is greater than invoice Qty!!!', 'error');
            $('#qty' + id).val(0);
            $('#g_qty' + id).val(0);
            $('#b_qty' + id).val(0);
            0;
        } else {
            $('#qty' + id).val(total);
        }
    }
</script>
