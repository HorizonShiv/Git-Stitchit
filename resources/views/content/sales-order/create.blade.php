@extends('layouts/layoutMaster')

@section('title', 'Sales Order Add')


@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}"
        xmlns="http://www.w3.org/1999/html">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <style>
        .select2-container .select2-selection--single .select2-selection__rendered {
            min-width: 225px;
        }
    </style>
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
    @php
        $requiredHtml = Helper::requiredHtml();
    @endphp


    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left">Sales Order /</span> Add
    </h4>

    <div class="row">

        {{-- <form method="post" action="{{ route('app-company-store') }}" enctype="multipart/form-data"> --}}
        @csrf
        <!-- Primary Details -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="content">
                        <div class="content-header mb-4">
                            <h4 class="mb-1">Primary Information</h4>
                        </div>
                        <div class="row g-3">

                            <div class="col-md-3">
                                <label class="form-label" for="SalesOrderDate">Date</label>
                                {!! $requiredHtml !!}
                                <input type="date" class="form-control date-picker" id="SalesOrderDate"
                                    name="SalesOrderDate" value="{{ date('Y-m-d') }}" placeholder="YYYY-MM-DD" />
                            </div>


                            <div class="col-md-3">
                                <label class="form-label" for="CustomerName">Customer Name</label>
                                {!! $requiredHtml !!}
                                <select required id="CustomerName" name="CustomerName" class="select2 select21 form-select"
                                    data-allow-clear="true" data-placeholder="Select Customer Name">
                                    <option value="">Select</option>
                                    @foreach (\App\Models\Customer::all() as $data)
                                        <option value="{{ $data->id }}">{{ $data->company_name }} -
                                            {{ $data->buyer_name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="Brand">Brand</label>
                                {!! $requiredHtml !!}
                                <select required id="Brand" name="Brand" class="select2 select21 form-select"
                                    data-allow-clear="true" data-placeholder="Select Brand">
                                    <option value="">Select</option>
                                    @foreach (\App\Models\Brand::all() as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="Season">Season</label>
                                {!! $requiredHtml !!}
                                <select required id="Season" name="Season" class="select2 select21 form-select"
                                    data-allow-clear="true" data-placeholder="Select Season">
                                    <option value="">Select</option>
                                    @foreach (\App\Models\Season::all() as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" class="form-control date-picker" id="SalesOrderId" name="SalesOrderId"
                                value="" />

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="errors mt-5" id="errors"></div>
        <div class="row">
            {{-- Style Details --}}
            <div class="col-12 col-md-6 mt-4">
                <div class="card">
                    <div class="card-body">
                        <form id="StyleInformation">
                            <div class="content-header mb-4">
                                <h4 class="mb-1">Style Information</h4>

                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="card mb-4">
                                    </div>
                                </div>

                            </div>
                            <form id="StyleInformation">
                                <div class="row g-3">

                                    <input type="hidden" id="SalesStyleId" name="SalesStyleId" class="form-control"
                                        placeholder="Customer Style No" />

                                    <div class="col-12 col-md-6 col-lg-6">
                                        <label class="form-label" for="StyleNo">Style No &nbsp;
                                        </label>
                                        {!! $requiredHtml !!}
                                        <div class="input-group">
                                            <select class="col-lg-3 select2 form-select"
                                                style="min-width: 200px !important;" name="StyleNo"
                                                onchange="getItemParameter();" id="StyleNo"
                                                aria-label="Example select with button addon">
                                                {{-- <option selected="">-- Choose your style --</option> --}}
                                                @foreach (\App\Models\StyleMaster::all() as $data)
                                                    <option value="{{ $data->id }}">{{ $data->style_no }} </option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-outline-primary waves-effect" data-bs-toggle="modal"
                                                data-bs-target="#addStyle" type="button">Add
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="CustomerStyleNo">Customer Style No</label>
                                        {!! $requiredHtml !!}
                                        <input required type="text" id="CustomerStyleNo" name="CustomerStyleNo"
                                            class="form-control" placeholder="Customer Style No" />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="Price">Rate</label>
                                        {!! $requiredHtml !!}
                                        <input required type="text" id="Price" name="Price"
                                            class="form-control" placeholder="Rate" />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="TotalQty">Total Qty</label>
                                        {!! $requiredHtml !!}
                                        <div class="input-group">
                                            <input required type="number" id="TotalQty" name="TotalQty"
                                                class="form-control" placeholder="Total Qty" readonly />
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary waves-effect"
                                                    data-bs-toggle="modal" data-bs-target="#addSize" type="button">Add
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                    <form id="imageUploadForm" enctype="multipart/form-data">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <label class="form-label" for="StyleImageAttachment">Style Image
                                                attachment</label>
                                            <input type="file" id="StyleImageAttachment" name="StyleImageAttachment"
                                                class="form-control" placeholder="Images" />
                                        </div>
                                    </form>

                                    <div class="col-12 col-md-6 col-lg-6">
                                        <label class="form-label" for="ShipDate">Ship Date</label>
                                        {!! $requiredHtml !!}
                                        <input type="date" class="form-control date-picker" id="ShipDate"
                                            name="ShipDate" placeholder="YYYY-MM-DD" />
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <label class="form-label" for="Details">Remarks</label>
                                        <textarea class="form-control" id="Details" name="Details" placeholder="Enter your Remarks"></textarea>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6" id="StyleDetails">
                                    </div>
                                </div>
                            </form>


                            <div class="row g-3 pt-4">


                            </div>


                            <div class="col-md-12 demo-inline-spacing">
                                <button type="button" id="SalesStyleBtn"
                                    class="btn btn-primary waves-effect waves-light" onclick="storeSelectedStyle(0);">Save
                                </button>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
            {{-- end of style details --}}

            {{-- Style Container --}}
            <div class="col-12 col-md-6 mt-4">
                <div class="card">
                    <div class="card-body">
                        <div class="content">
                            <div class="content-header mb-4">
                                <h4 class="mb-1">Selected List</h4>
                            </div>

                            <div class="card-datatable table-responsive pt-0">
                                <table class="datatables-basic table" id="datatable-list">
                                    <thead>
                                        <tr>
                                            <th>Style No</th>
                                            <th>Total Qty</th>
                                            <th>Rate</th>
                                            <th>Value</th>
                                            <th>Cat-Fit</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody id="styleInformation">

                                    </tbody>
                                    </tbody>
                                    {{-- <tfoot>
                                        <tr>
                                            <td></td>
                                            <td>1200</td>
                                            <td>15</td>
                                            <td colspan="3">6000</td>
                                        </tr>
                                    </tfoot> --}}
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            {{-- End of Style Container --}}

        </div>
    </div>
    <div class="row g-3">
        <div class="d-grid gap-2 col-lg-2 mx-auto mt-5">
            <button id="SaveAndClose" value="SaveAndClose" onclick="closeTheSetup();"
                class="btn btn-danger btn-md waves-effect waves-light" type="button">Close</button>
        </div>
    </div>


    <div class="modal fade" id="addStyle" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-edit-user">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Add New Style Information</h3>
                        <p class="text-muted">This item will be added directly to the inventory for Style</p>
                    </div>
                    <form id="editUserForm" class="row g-3">

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="ModelDate">Date</label>
                            <input type="date" class="form-control date-picker" id="ModelDate" name="ModelDate"
                                placeholder="YYYY-MM-DD" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="ModelStyleNo">Style No</label>
                            <input required type="text" id="ModelStyleNo" name="ModelStyleNo" class="form-control"
                                placeholder="Style No" />
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="ModelFebric">Febric</label>
                            <input required type="text" id="ModelFebric" name="ModelFebric" class="form-control"
                                placeholder="Febric" />
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="ModelCustomer">Customer</label>
                            <select required id="ModelCustomer" name="ModelCustomer" class="select2 select21 form-select"
                                data-allow-clear="true" data-placeholder="Select Buyer">
                                <option value="">Select</option>
                                @foreach (\App\Models\Customer::all() as $data)
                                    <option value="{{ $data->id }}">{{ $data->company_name }} -
                                        {{ $data->buyer_name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="ModelStyleCategory">Category</label>
                            <select id="ModelStyleCategory" name="ModelStyleCategory"
                                class="select2 select21 form-select" onchange="getSubcategories();"
                                aria-label="Select Category">
                                <option value="">Select</option>
                                @foreach ($categoryData as $category)
                                    <option @php if($category->id==old('Category')){ echo 'selected';} @endphp
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="ModelStyleSubCategory">Sub Category</label>
                            <select id="ModelStyleSubCategory" name="ModelStyleSubCategory"
                                class="select2 select21 form-select" aria-label="Select Sub Category">
                                <option value="">Select</option>
                                @foreach ($SubCategoryData as $SubCategory)
                                    <option @php if($SubCategory->id==old('SubCategory')){ echo 'selected';} @endphp
                                        value="{{ $SubCategory->id }}">{{ $SubCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-12 col-md-6">

                            <label class="form-label" for="ModelFit">Fit</label>
                            <select id="ModelFit" name="ModelFit" class="select2 select21 form-select"
                                aria-label="Select Fit">
                                <option value="">Select</option>
                                @foreach (\App\Models\Fit::all() as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="ModelSeason">Season</label>
                            <select id="ModelSeason" name="ModelSeason" class="select2 select21 form-select"
                                aria-label="Select Season">
                                <option value="">Select</option>
                                @foreach (\App\Models\Season::all() as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="ModelDesigner">Designer</label>
                            <select id="ModelDesigner" name="ModelDesigner" class="select2 select21 form-select"
                                data-allow-clear="true" data-placeholder="Select Designer">
                                <option value="">Select</option>
                                @foreach ($UserData as $user)
                                    <option value="{{ $user->id }}">{{ $user->company_name }} -
                                        {{ $user->person_name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="ModelRate">Rate</label>
                            <input required type="text" id="ModelRate" name="ModelRate" class="form-control"
                                placeholder="Febric" />
                        </div>


                        <div class="col-12 text-center">
                            <button type="reset" class="btn btn-primary me-sm-3 me-1" onclick="AddNewStyleData();"
                                data-bs-dismiss="modal">Save
                            </button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade ValidateModelForTotalQty" id="addSize" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-simple modal-edit-user modal-dialog-scrollable">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Parameter Information</h3>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <form id="ModelParameter">
                                <div class="form-text">
                                    All size should be in comma separated
                                </div>
                                <label class="form-label" for="parameterDataSaperation">Insert Size Values here</label>
                                <input type="text" id="parameterDataSaperation" class="form-control mb-5"
                                    onkeyup="updateTable(this.value)" placeholder="28,30,32,34,36 / s,m,l,xl,xxl"
                                    name="parameterDataSaperation">

                                <div class="col-12 col-md-6" hidden>
                                    <label class="form-label" for="StyelParameterId">Style Parameter Id</label>
                                    <input required type="number" id="StyelParameterId" name="StyelParameterId"
                                        class="form-control" placeholder="Customer Style No" />
                                </div>
                                <div id="table-container"></div>
                                {{-- <table class="table table-responsive mb-0 dataTable" id="generated-table" role="grid">
                                    <!-- This is where the generated table will be inserted -->
                                </table> --}}

                            </form>
                        </div>
                        <div class="row pb-4">
                            <div class="col-12">

                                <button type="button" class="btn btn-primary" onclick="addRow()"
                                    data-repeater-create>Add
                                    Item
                                </button>
                                <button type="reset" class="btn btn-label-success ml-3" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Done
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    var rowCount = 0;

    function updateTable(input) {
        var rowCount = 1;
        var totalQty = $('#TotalQty').val();
        // Create a div to contain the table
        const tableContainer = document.createElement('div');
        const numbers = input.split(',');

        // Create table
        const table = document.createElement('table');
        table.setAttribute('id', 'SizeRatios');

        // Parse input string to extract numbers
        const thead = document.createElement('thead');
        table.appendChild(thead);

        const inputHeader = document.createElement('input');
        inputHeader.type = 'text';
        inputHeader.value = `Color`;
        inputHeader.readOnly = true;
        inputHeader.className = 'form-control';
        thead.appendChild(inputHeader);

        numbers.forEach((number, index) => {
            // Create input element
            const headerCell = document.createElement('th');
            const Headerinput = document.createElement('input');
            Headerinput.type = 'text';
            Headerinput.name = `Size[]`;
            Headerinput.value = number;
            Headerinput.readOnly = true;
            Headerinput.className = 'form-control';
            headerCell.appendChild(Headerinput);

            headerCell.appendChild(Headerinput);

            // Append header cell to thead
            thead.appendChild(headerCell);
        });

        const headerRow = table.insertRow();
        headerRow.className = 'odd';
        const dataRow = table.insertRow(); // Add a new row for data
        dataRow.className = 'odd';

        const dataCell = dataRow.insertCell();
        dataCell.rowSpan = 2; // Set the colspan attribute to 2
        const inputFirst = document.createElement('input');
        inputFirst.type = 'text';
        inputFirst.name = `Color[${rowCount}]`;
        inputFirst.placeholder = 'Color';
        inputFirst.style.height = '78px'; // Fixing the height
        inputFirst.className = 'form-control';
        dataCell.appendChild(inputFirst);

        const dataRowQty = table.insertRow();
        dataRowQty.className = 'odd';
        // Add columns with numbers as headings and input fields in data row
        numbers.forEach((number, index) => {
            const dataCellRatio = dataRow.insertCell();
            const inputRatio = document.createElement('input');
            inputRatio.type = 'text';
            inputRatio.placeholder = 'Ratio';
            inputRatio.setAttribute('onkeyup', `updateQuantities(${rowCount})`);
            inputRatio.name = `Ratio[${rowCount}][${index}]`;
            inputRatio.className = 'form-control';
            dataCellRatio.appendChild(inputRatio);
            dataCellRatio.rowSpan = 1; // Default rowspan value

            // Create a new row
            const dataCellQty = dataRowQty.insertCell(); // Insert a cell into the new row
            const inputQty = document.createElement('input');
            inputQty.type = 'text';
            inputQty.placeholder = 'Qty';
            inputQty.name = `Qty[${rowCount}][${index}]`;
            inputQty.className = 'form-control qty';
            inputQty.setAttribute('data-row', rowCount);
            inputQty.setAttribute('data-col', index);
            dataCellQty.appendChild(inputQty);
        });

        // Add empty cell in the header row
        const inputHeaderLast = document.createElement('input');
        inputHeaderLast.type = 'text';
        inputHeaderLast.value = `total`;
        inputHeaderLast.readOnly = true;
        inputHeaderLast.className = 'form-control total';
        thead.appendChild(inputHeaderLast);

        // Add empty cell in the data row
        const dataCellLast = dataRow.insertCell();
        const inputLast = document.createElement('input');
        inputLast.type = 'text';
        inputLast.name = `Total[${rowCount}]`;
        inputLast.value = totalQty;
        inputLast.placeholder = 'Total';
        inputLast.style.height = '78px'; // Fixing the height
        inputLast.className = 'form-control';
        inputLast.setAttribute('data-row', rowCount);
        inputLast.setAttribute('onkeyup', `updateQuantities(${rowCount}), checkTotalQty()`);
        dataCellLast.rowSpan = 2;
        dataCellLast.appendChild(inputLast);

        // const dataCellDelete = dataRow.insertCell();
        // const inputLastDelete = document.createElement('input');
        // inputLastDelete.type = 'text';
        // inputLastDelete.name = `Total[${rowCount}]`;
        // inputLastDelete.value = totalQty;
        // inputLastDelete.placeholder = 'Total';
        // inputLastDelete.style.height = '78px'; // Fixing the height
        // inputLastDelete.className = 'form-control';
        // inputLastDelete.setAttribute('data-row', rowCount);
        // inputLastDelete.setAttribute('onkeyup', `updateQuantities(${rowCount})`);
        // dataCellDelete.rowSpan = 2;
        // dataCellDelete.appendChild(inputLastDelete);

        // Increment row count for the next row
        rowCount++;

        // Append the table to the container div
        tableContainer.appendChild(table);

        // Clear previous table content
        document.getElementById('table-container').innerHTML = '';

        // Add the table container to the table-container div
        document.getElementById('table-container').appendChild(tableContainer);
    }

    function addRow() {
        const table = document.querySelector('#table-container table');
        const tbody = table.querySelector('tbody');
        const newTbody = tbody.cloneNode(true);
        const rows = newTbody.querySelectorAll('tr');

        const tbodyElements = table.querySelectorAll('tbody');
        const tbodyCount = tbodyElements.length;
        console.log("Number of tbody elements:", tbodyCount);

        newTbody.setAttribute('id', `TableContainer_${tbodyCount+1}`);

        rows.forEach((row, rowIndex) => {
            var newparameterIndex = 0;
            var newqtyIndex = 0;
            var newratioIndex = 0;
            const inputs = row.querySelectorAll('input');

            inputs.forEach((input, inputIndex) => {
                if (input.name.includes('Color')) {
                    input.name = `Color[${tbodyCount+1}]`; // Use color count for index
                    input.value = '';
                } else if (input.name.includes('Size')) {
                    input.name = `Size[${tbodyCount+1}][${inputIndex}]`;
                } else if (input.name.includes('Ratio')) {
                    input.name = `Ratio[${tbodyCount+1}][${newratioIndex}]`;
                    input.setAttribute('onkeyup', `updateQuantities(${tbodyCount+1})`);
                    newratioIndex++;
                } else if (input.name.includes('Qty')) {
                    input.name = `Qty[${tbodyCount+1}][${newqtyIndex}]`;
                    newqtyIndex++;
                } else if (input.name.includes('parameterIds')) {
                    input.name = `parameterIds[${tbodyCount+1}][${newparameterIndex}]`;
                    input.value = '';
                    newparameterIndex++;
                } else if (input.name.includes('Total')) {
                    input.name = `Total[${tbodyCount+1}]`;
                    input.setAttribute('onkeyup', `updateQuantities(${tbodyCount+1}), checkTotalQty()`);
                }
            });
        });

        table.appendChild(newTbody);
    }

    function updateQuantities(row) {
        const totalInput = document.querySelector(`input[name='Total[${row}]']`);
        const total = parseFloat(totalInput.value) || 0;

        const ratioInputs = document.querySelectorAll(`input[name^='Ratio[${row}]']`);
        const ratios = Array.from(ratioInputs).map(input => parseFloat(input.value) || 0);
        const sumOfRatios = ratios.reduce((acc, ratio) => acc + ratio, 0);

        const qtyInputs = document.querySelectorAll(`input[name^='Qty[${row}]']`);
        qtyInputs.forEach((qtyInput, index) => {
            const ratio = ratios[index];
            if (sumOfRatios > 0) {
                qtyInput.value = Math.round(((ratio / sumOfRatios) * total).toFixed(2));
            } else {
                qtyInput.value = '0.00';
            }
        });
    }

    function checkTotalQty() {
        var qtyData = [];

        // Initialize total sum variable
        $('#TotalQty').val(0);
        var totalSum = 0;

        // Collect values from Total fields and calculate the sum
        $('input[name^="Total"]').each(function() {
            var value = parseFloat($(this).val()) || 0; // Convert value to a float, default to 0 if NaN
            totalSum += value;
        });

        // Output the total sum
        console.log("Total Sum of All Totals:", totalSum);


        $('#TotalQty').val(totalSum);

    }

    function AddNewStyleData() {
        // Retrieving values from input fields
        var modelDate = $('#ModelDate').val();
        var modelStyleNo = $('#ModelStyleNo').val();
        var modelFebric = $('#ModelFebric').val();
        var modelCustomer = $('#ModelCustomer').val();
        var modelStyleCategory = $('#ModelStyleCategory').val();
        var modelStyleSubCategory = $('#ModelStyleSubCategory').val();
        var modelFit = $('#ModelFit').val();
        var modelSeason = $('#ModelSeason').val();
        var modelDesigner = $('#ModelDesigner').val();
        var modelRate = $('#ModelRate').val();

        // Sending AJAX request
        if (modelDate === '' || modelStyleNo === '' || modelFebric === '' || modelCustomer === '' ||
            modelStyleCategory === '' || modelStyleSubCategory === '' || modelFit === '' || modelSeason === '' ||
            modelDesigner === '' ||
            modelRate === '') {

            if (modelDate === '') {
                var errorMessage = 'Date should be filled out';
                toastr.error(errorMessage);
            }
            if (modelStyleNo === '') {
                var errorMessage = 'Style No should be filled out';
                toastr.error(errorMessage);
            }
            if (modelFebric === '') {
                var errorMessage = 'Febric should be filled out';
                toastr.error(errorMessage);
            }
            if (modelCustomer === '') {
                var errorMessage = 'Customer should be filled out';
                toastr.error(errorMessage);
            }
            if (modelStyleCategory === '') {
                var errorMessage = 'Style Category should be filled out';
                toastr.error(errorMessage);
            }
            if (modelStyleSubCategory === '') {
                var errorMessage = 'Style Sub-Category should be filled out';
                toastr.error(errorMessage);
            }
            if (modelFit === '') {
                var errorMessage = 'Fit should be filled out';
                toastr.error(errorMessage);
            }
            if (modelSeason === '') {
                var errorMessage = 'Season should be filled out';
                toastr.error(errorMessage);
            }
            if (modelDesigner === '') {
                var errorMessage = 'Designer should be filled out';
                toastr.error(errorMessage);
            }
            if (modelRate === '') {
                var errorMessage = 'Rate should be filled out';
            }
        } else {
            $.ajax({
                url: "{{ route('addNewStyleSalesOrder') }}", // Route for adding new style sales order
                method: "POST",
                data: {
                    modelDate: modelDate,
                    modelStyleNo: modelStyleNo,
                    modelFebric: modelFebric,
                    modelCustomer: modelCustomer,
                    modelStyleCategory: modelStyleCategory,
                    modelStyleSubCategory: modelStyleSubCategory,
                    modelFit: modelFit,
                    modelSeason: modelSeason,
                    modelDesigner: modelDesigner,
                    modelRate: modelRate,
                    _token: '{{ csrf_token() }}' // CSRF token for security
                },
                success: function(response) {
                    // If the request is successful
                    if (response.success) {
                        toastr.success('Style has been added'); // Logging the response style data
                        // $('#StyleNo').empty(); // Clearing previous options in #StyleNo select element
                        // Appending new options based on the response style data
                        $('#StyleNo').empty();
                        $.each(response.StyleData, function(index, style) {
                            $('#StyleNo').append('<option value="' + style.id + '">' +
                                '' + style.style_no + '</option>');
                        });

                        // $('#editUserForm').trigger('reset');
                        $('#ModelDate').val('');
                        $('#ModelStyleNo').val('');
                        $('#ModelFebric').val('');
                        $('#ModelCustomer').val('');
                        $('#ModelStyleCategory').val('');
                        $('#ModelStyleSubCategory').val('');
                        $('#ModelFit').val('');
                        $('#ModelSeason').val('');
                        $('#ModelDesigner').val('');
                        $('#ModelRate').val('');
                    }
                }
            });
        }
    }

    document.addEventListener('keydown', function(event) {
        if ((event.ctrlKey || event.metaKey) && event.key === 'r') {
            event.preventDefault(); // Prevent the default behavior (refreshing the page)

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Close it!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                        location.reload();
                    });
                }
            });
        }
    });


    function calculateDate() {
        var totalQty = parseFloat($('#TotalQty').val()); // Get the total quantity as a number
        var totalRatio = 0;
        var totalModelQty = 0;

        $('tr').each(function() {
            var ratio = parseFloat($(this).find('input[name="Ratio[]"]')
                .val()); // Get the ratio value for this row

            if (!isNaN(ratio)) { // Check if ratio is a valid number
                totalRatio += ratio; // Add ratio to totalRatio
            }

            var ModelQty = parseFloat($(this).find('input[name="Qty[]"]')
                .val()); // Get the ratio value for this row

            if (!isNaN(ModelQty)) { // Check if ratio is a valid number
                totalModelQty += ModelQty; // Add ratio to totalRatio
            }
        });

        var calculatedQty = totalQty / totalRatio; // Calculate the quantity

        // Iterate over each row
        $('tr').each(function() {
            var ratioModel = parseFloat($(this).find('input[name="Ratio[]"]')
                .val()); // Get the ratio value for this row
            var quantityInput = $(this).find(
                'input[name="Qty[]"]'); // Get the quantity input field for this row
            var totalModelQty = calculatedQty * ratioModel;
            if (ratioModel !== 0) {
                quantityInput.val(totalModelQty.toFixed(2)); // Set the calculated quantity in the input field

            } else {
                quantityInput.val(''); // If ratio is 0, clear the input field
            }
        });

        $('#totalRatioModel').val(totalRatio);
        $('#totalQtyModel').val(totalQty);
    }

    var counter = 1;

    function addRowInModel() {
        var htmlSnippet =
            '<tr class="odd" id="ModelRow_' + counter +
            '"><td><input type="text" class="form-control 2" name="Color[]" value=""></td><td><input type="number" class="form-control 2" name="Size[]" value=""></td><td><input type="number" class="form-control 2" onkeyup="calculateDate();" name="Ratio[]" value=""></td><td><input type="number" class="form-control 2"  name="Qty[]" value="" readonly></td><td><button type="button" class="btn rounded-pill btn-icon btn-label-danger waves-effect" onclick="removeRowInModel(' +
            counter + '); calculateDate();"><span class="ti ti-trash"></span></button></td></tr>';

        $('#SizeRatios tbody').append('<tr>' + htmlSnippet + '</tr>');
        counter++;

    }

    function removeRowInModel(rowId) {
        // Remove the row with the given rowId
        $('#ModelRow_' + rowId).remove();
    }

    function closeTheSetup() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Close it!',
            customClass: {
                confirmButton: 'btn btn-primary me-3',
                cancelButton: 'btn btn-label-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                    location.reload();
                });
            }
        });
    }


    function storeSelectedStyle(redirection) {

        // Initialize an empty array to store the data from input fields
        var dataArray = [];

        var tableData = {};
        var colorData = {};
        var ratioData = [];
        var qtyData = [];
        var parameterData = [];

        // Extract color data
        $('input[name^="Color"]').each(function() {
            var name = $(this).attr('name');
            var value = $(this).val();
            var index = parseInt(name.match(/\[(\d+)\]/)[1]); // Extract index from name

            colorData[index] = value;
        });


        // Extract ratio data
        $('input[name^="Ratio"]').each(function() {
            var name = $(this).attr('name');
            var value = $(this).val();
            var index = parseInt(name.match(/\[(\d+)\]/)[1]); // Extract index from name

            ratioData[index] = ratioData[index] || []; // Initialize array if not exists
            ratioData[index].push(value);
        });

        // Extract quantity data
        $('input[name^="Qty"]').each(function() {
            var name = $(this).attr('name');
            var value = $(this).val();
            var index = parseInt(name.match(/\[(\d+)\]/)[1]); // Extract index from name

            qtyData[index] = qtyData[index] || []; // Initialize array if not exists
            qtyData[index].push(value);
        });




        $('input[name^="parameterIds"]').each(function() {
            var name = $(this).attr('name');
            var value = $(this).val();
            var index = parseInt(name.match(/\[(\d+)\]/)[1]); // Extract index from name

            parameterData[index] = parameterData[index] || []; // Initialize array if not exists
            parameterData[index].push(value);
        });

        tableData['color'] = colorData;
        tableData['ratio'] = ratioData;
        tableData['qty'] = qtyData;
        tableData['parameterIds'] = parameterData;

        var requestData = {
            tableData: tableData
        };

        // Now you can pass the requestData through AJAX
        console.log(JSON.stringify(tableData));


        // This is the style data that going to be reset
        var styleNo = $('#StyleNo').val();
        var customerStyleNo = $('#CustomerStyleNo').val();
        var price = $('#Price').val();
        var totalQty = $('#TotalQty').val();

        var styleImage = $('#StyleImageAttachment').prop('files')[0];

        var shipDate = $('#ShipDate').val();
        var details = $('#Details').val();

        //Main Sale Order Data that should not get reset
        var saleOrderDate = $('#SalesOrderDate').val();
        var customerName = $('#CustomerName').val();
        var brand = $('#Brand').val();
        var season = $('#Season').val();

        var salesOrderId = $('#SalesOrderId').val();

        var value = 0;

        value = price * totalQty;

        //Just to print this into the table
        var styleText = $('#StyleNo option:selected').text();

        //For update data
        var salesStyleId = $('#SalesStyleId').val();
        var parameterDataSaperation = $('#parameterDataSaperation').val();

        var htmlData = '';

        var errorCounter = 0;
        var sameColorCounter = 0;
        var seenColors = new Set();

        $('input[name^="Color"]').each(function() {
            var name = $(this).attr('name');
            var value = $(this).val();
            var index = parseInt(name.match(/\[(\d+)\]/)[1]); // Extract index from name

            colorData[index] = value;

            // Simple validation: Check if the value is non-empty
            if (!value) {
                errorCounter++;
            }

            if (seenColors.has(value)) {
                sameColorCounter++;
            } else {
                seenColors.add(value);
            }
        });

        if (customerName === '' || brand === '' || season === '' || saleOrderDate === '' || styleNo === '' ||
            customerStyleNo === '' || price === '' || totalQty === '' || shipDate === '' || errorCounter != 0 ||
            parameterDataSaperation === '' || sameColorCounter != 0) {
            $('#validationErrorMessage').remove();
            if (customerName === '' || brand === '' || season === '' || saleOrderDate === '') {
                var errorMessage = 'Primary Information should be filled Out : ';
                if (customerName === '') errorMessage += 'Customer Name, ';
                if (brand === '') errorMessage += 'Brand, ';
                if (season === '') errorMessage += 'Season, ';
                if (saleOrderDate === '') errorMessage += 'Date, ';
                errorMessage = errorMessage.slice(0, -2);

                toastr.error(errorMessage);
            }

            if (styleNo === '') {
                var errorMessage = 'Style No should be filled out';
                toastr.error(errorMessage);
            }
            if (customerStyleNo === '') {
                var errorMessage = 'Customer No should be filled out';
                toastr.error(errorMessage);
            }
            if (price === '') {
                var errorMessage = 'Rate should be filled out';
                toastr.error(errorMessage);
            }
            if (totalQty === '') {
                var errorMessage = 'Qty should be filled out';
                toastr.error(errorMessage);
                $('#addSize').modal('show');
            }
            if (totalQty !== '') {
                if (parameterDataSaperation === '') {
                    toastr.error('Parameter should be added before moving further');
                    $('.ValidateModelForTotalQty').attr('id', 'addSize');
                    $('#addSize').modal('show');
                    $('.ValidateModelForTotalQty').removeAttr('id');
                }
                if (errorCounter != 0) {
                    toastr.error('Color Should be fill out!!');
                    $('.ValidateModelForTotalQty').attr('id', 'addSize');
                    $('#addSize').modal('show');
                    $('.ValidateModelForTotalQty').removeAttr('id');
                }
                if (sameColorCounter != 0) {
                    toastr.error('Color Should be Different!!');
                    $('.ValidateModelForTotalQty').attr('id', 'addSize');
                    $('#addSize').modal('show');
                    $('.ValidateModelForTotalQty').removeAttr('id');
                }
            }
            if (shipDate === '') {
                var errorMessage = 'Ship Date should be filled out';
                toastr.error(errorMessage);
            }
            // if (colorInput.length === 0) {
            //     var errorMessage = 'Parameter should be filled out';
            //     toastr.error(errorMessage);
            // }

        } else {
            $('#validationErrorMessage').remove();
            var formData = new FormData();
            formData.append('styleNo', styleNo);
            formData.append('salesStyleId', salesStyleId);
            formData.append('customerStyleNo', customerStyleNo);
            formData.append('price', price);
            formData.append('totalQty', totalQty);
            if (typeof styleImage !== 'undefined') {
                formData.append('styleImage', styleImage);
            }
            formData.append('shipDate', shipDate);
            formData.append('details', details);
            formData.append('saleOrderDate', saleOrderDate);
            formData.append('customerName', customerName);
            formData.append('dataArray', JSON.stringify(requestData));
            formData.append('brand', brand);
            formData.append('season', season);
            formData.append('parameterSizeData', parameterDataSaperation);
            formData.append('salesOrderId', salesOrderId);
            formData.append('redirection', redirection);
            formData.append('_token', '{{ csrf_token() }}');
            rowCount = 1;
            $.ajax({
                url: "{{ route('StoreSalesStyleData') }}",
                method: 'POST',
                data: formData,
                processData: false, // Prevent jQuery from automatically processing the data
                contentType: false, // Prevent jQuery from setting the content type

                success: function(response) {
                    console.log(response);
                    if (response.success) {

                        if (response.redirect == 1) {
                            Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            $('#SalesStyleBtn')
                                .removeClass('btn-success')
                                .addClass('btn-primary')
                                .text('Save')

                            toastr.success('Successfully done');

                            console.log(response);
                            $('#styleInformation').append('<tr id="saleRow_' + response.id + '">' +
                                '<td>' + styleText + '</td>' +
                                '<td>' + totalQty + '</td>' +
                                '<td>' + price + '</td>' +
                                '<td>' + value + '</td>' +
                                '<td>' + response.StyleData.style_category.name + ' - ' + response
                                .StyleData
                                .fit
                                .name + '</td>' +
                                '<td>' +
                                '<a type="button" href="#" class="btn rounded-pill btn-icon btn-label-primary waves-effect" onclick="getSalesData(' +
                                response.id +
                                ');" style="margin-left: 10%"><span class="ti ti-arrow-back-up"></span></a>' +
                                '</td>' +
                                '</tr>');

                            $('#ModelParameter').trigger('reset');

                            $('#StyleInformation').trigger('reset');

                            $('#SalesOrderId').val(response.SalesOrderId);
                            $('#SizeRatios tbody').empty();

                            counter++;
                            $("#StyleNo").val();
                            $("#StyleNo").trigger('change');
                            $("#StyleNo").select2('refresh');
                        }
                    } else {
                        console.error('Error storing user:', response.error);
                    }
                }
            });
        }

    }

    function getSalesData(id) {
        // Use the id parameter as needed
        // console.log("ID received:", id);
        if ($('#SalesStyleBtn').hasClass('btn-primary')) {
            $('#saleRow_' + id).remove();
            $.ajax({
                url: "{{ route('getSalesDataEdit') }}", // Replace with your actual backend endpoint
                method: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}',
                }, // Send the id of the removed row to identify the data to fetch
                success: function(response) {
                    toastr.success('Successfully fetched');
                    $('#SalesStyleBtn')
                        .removeClass('btn-primary')
                        .addClass('btn-success')
                        .text('Update')
                    // Populate the input fields with the fetched data
                    $('#SalesStyleId').val(response.id);
                    $('#CustomerStyleNo').val(response.StyleData.customer_style_no);
                    $('#Price').val(response.StyleData.price);
                    $('#TotalQty').val(response.StyleData.total_qty);

                    $('#ShipDate').val(response.StyleData.ship_date);
                    $('#Details').val(response.StyleData.details);
                    // console.log(response);


                    // var selectedStyleText = $('#StyleNo option:selected').text();
                    // $('#StyleNo').val(null).trigger('change');
                    $('#SizeRatios tbody').empty();

                    getItemParameter();
                    $('#table-container').html(response.htmlTable);
                    $('#parameterDataSaperation').val(response.sizesString);
                    rowCount = response.rowcount;

                    $('#StyleNo').val(response.StyleData.style_master_id);
                    $("#StyleNo").trigger('change');
                    $("#StyleNo").select2('refresh');

                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                    // Handle error case, if needed
                }
            });
            // Add your AJAX request or other logic here
        } else {
            toastr.error("Please Update the last data");
        }
    }
</script>

<script>
    function getItemParameter() {
        var StyleNo = document.getElementById('StyleNo').value;
        $("#StyleDetails").html('');
        $("#Price").val(0);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{{ route('getItemParameter') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                StyleId: StyleNo,
                "_token": "{{ csrf_token() }}"
            },
            success: function(result) {
                // $("#getCompanyBillDetails").html(result.billto);
                $("#StyleDetails").html(result.styleInfo);
                $("#Price").val(result.rate);
                // $("#po_number").val(result.po_number);

            },
        });
    }
</script>


<script>
    function submitForm() {
        // Fetch form values
        var styleNo = $('#ModelStyleNo').val();
        var buyerName = $('#ModelBuyer option:selected').text();
        var category = $('#ModelCategory option:selected').text();
        var fit = $('#ModelFit option:selected').text();
        var season = $('#ModelSeason option:selected').text();

        // Append data to the table
        var newRow = '<tr>' +
            '<td>' + styleNo + '</td>' +
            '<td>' + buyerName + '</td>' +
            '<td>' + category + '</td>' +
            '<td>' + fit + '</td>' +
            '<td>' + season + '</td>' +
            '<td><button type="button" onclick="deleteRow(this)" class="btn rounded-pill btn-icon btn-label-primary waves-effect"><span class="ti ti-trash"></span></button></td>' +
            '</tr>';

        $('#dataTableBody').append(newRow);

        // Clear form fields after submission
        $('#myForm')[0].reset();
    }

    // Optional: Add a function to delete a row
    function deleteRow(button) {
        $(button).closest('tr').remove();
    }
</script>

<!-- Include jQuery -->
{{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}

<!-- jQuery script to calculate and update totals -->
{{-- <script>
    $(document).ready(function() {
        // Function to calculate the sum of each column and update the total row
        function calculateColumnSum() {
            var totalSize = 0;
            var totalQty = 0;
            var totalRatio = 0;

            // Iterate through each row in the tbody
            $('tbody tr').each(function() {
                // Get the values from the current row
                var size = parseFloat($(this).find('input[name="Size[]"]').val()) || 0;
                var qty = parseFloat($(this).find('input[name="Qty[]"]').val()) || 0;
                var ratio = parseFloat($(this).find('input[name="Ratio[]"]').val()) || 0;

                // Update the total values
                totalSize += size;
                totalQty += qty;
                totalRatio += ratio;
            });
        }
        $('tfoot tr').find('td:nth-child(2)').text(totalSize.toFixed(2));
        $('tfoot tr').find('td:nth-child(3)').text(totalQty.toFixed(2));
        $('tfoot tr').find('td:nth-child(4)').text(totalRatio.toFixed(2));
        // Call the function initially and whenever the input values change
        calculateColumnSum();

        $('tbody input[name^="Size"], tbody input[name^="Qty"], tbody input[name^="Ratio"]').on('input',
            function() {
                calculateColumnSum();
            });
    });
</script> --}}
