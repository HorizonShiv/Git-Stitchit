@extends('layouts/layoutMaster')

@section('title', 'QC List')


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
    <div class="errors" id="errors">

    </div>
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left">Sales Order /</span> View
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
                            <h4 class="mb-1">Sales Order Information</h4>
                        </div>
                        <div class="row g-3">

                            <div class="col-md-2">
                                <label class="form-label" for="SalesOrderDate">Date</label>
                                <input type="date" class="form-control date-picker" id="SalesOrderDate"
                                    name="SalesOrderDate" value="{{ $SalesOrders->date }}" placeholder="YYYY-MM-DD"
                                    readonly />
                            </div>
							
							 <div class="col-md-2">
                                <label class="form-label" for="SalesOrderNo">Sale order No</label>
                                <input type="text" class="form-control date-picker" id="SalesOrderNo"
                                    name="SalesOrderDate" value="{{ $SalesOrders->sales_order_no }}" placeholder=""
                                    readonly />
                            </div>


                            <div class="col-md-4">
                                <label class="form-label" for="CustomerName">Customer Name</label>
                                <input type="text" class="form-control date-picker" id="CustomerName" name="CustomerName"
                                    value="{{ $SalesOrders->Customer[0]->company_name }} - {{ $SalesOrders->Customer[0]->buyer_name }}"
                                    readonly />
                            </div>

                            <div class="col-md-2">
                                <label class="form-label" for="Brand">Brand</label>
                                <input type="text" class="form-control date-picker" id="Brand" name="Brand"
                                    value="{{ $SalesOrders->Brand[0]->name ?? '' }}" readonly />
                            </div>

                            <div class="col-md-2">
                                <label class="form-label" for="Season">Season</label>
                                <input type="text" class="form-control date-picker" id="Season" name="Season"
                                    value="{{ $SalesOrders->Season[0]->name ?? '' }}" readonly />
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            {{-- Style Container --}}
            <div class="col-12 col-md-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        <div class="content">
                            <div class="content-header mb-4">
                                <h4 class="mb-1">Style Information</h4>
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
                                            <th>Remarks</th>
                                            <th>Parameters</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $counter = 0;
                                    @endphp
                                    <tbody id="styleInformation">
                                        @foreach ($SalesOrders->SalesOrderStyleInfo as $SalesOrderStyle)
                                            <tr>
                                                {{-- {{ dd($SalesOrderStyle->id) }} --}}
                                                <td>{{ $SalesOrderStyle->StyleMaster->style_no ?? '' }} </td>
                                                <td>{{ $SalesOrderStyle->total_qty }} </td>
                                                <td>{{ $SalesOrderStyle->price }} </td>
                                                <td>{{ $SalesOrderStyle->total_qty * $SalesOrderStyle->price }} </td>
                                                <td>{{ $SalesOrderStyle->StyleMaster->StyleCategory->name }} </td>
                                                <td>{{ $SalesOrderStyle->details }} </td>
                                                <td><a type="button" href="#"
                                                        class="btn rounded-pill btn-icon btn-label-primary waves-effect"
                                                        onclick="getSalesData({{ $SalesOrderStyle->id }});"
                                                        style="margin-left: 10%" data-bs-toggle="modal"
                                                        data-bs-target="#addSize"><span class="ti ti-eye"></span></a></td>
                                            </tr>
                                            @php
                                                $counter++;
                                            @endphp
                                        @endforeach
                                        {{-- <tr id="saleRow_2">
                                            <td>qwe </td>
                                            <td>1351235</td>
                                            <td>1235135</td>
                                            <td>2024-04-17</td>
                                            <td>Temp - ANKLE FIT</td>
                                            <td><a type="button" href="#"
                                                    class="btn rounded-pill btn-icon btn-label-primary waves-effect"
                                                    onclick="getSalesData(60);" style="margin-left: 10%"><span
                                                        class="ti ti-plus"></span></a></td>
                                        </tr>
                                        <tr id="saleRow_2">
                                            <td>qwe </td>
                                            <td>1351235</td>
                                            <td>1235135</td>
                                            <td>2024-04-17</td>
                                            <td>Temp - ANKLE FIT</td>
                                            <td><a type="button" href="#"
                                                    class="btn rounded-pill btn-icon btn-label-primary waves-effect"
                                                    onclick="getSalesData(62);" style="margin-left: 10%"><span
                                                        class="ti ti-plus"></span></a></td>
                                        </tr> --}}
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

    <div class="modal fade" id="addSize" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-simple modal-edit-user">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Parameter Information</h3>
                        {{-- <p class="text-muted">Updating user details will receive a privacy audit.</p> --}}
                    </div>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <form id="ModelParameter">
                                <div class="col-12 col-md-6" hidden>
                                    <label class="form-label" for="StyelParameterId">Style Parameter Id</label>
                                    <input required type="number" id="StyelParameterId" name="StyelParameterId"
                                        class="form-control" placeholder="Customer Style No" />
                                </div>
                                <div id="table-container"></div>
                            </form>
                        </div>
                        <div class="row pb-4">
                            <div class="col-12">
                                {{-- <button type="button" class="btn btn-primary" onclick="addRowInModel()"
                                    data-repeater-create>Add
                                    Item
                                </button> --}}
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


<script>
    function getSalesData(id) {
        // Use the id parameter as needed
        // console.log("ID received:", id);

            $('#saleRow_' + id).remove();
            $.ajax({
                url: "{{ route('getSalesParameterDataView') }}", // Replace with your actual backend endpoint
                method: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}',
                }, // Send the id of the removed row to identify the data to fetch
                success: function(response) {

                    $('#table-container').empty();
                    $('#table-container').html(response.htmlTable);

                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                    // Handle error case, if needed
                }
            });
            // Add your AJAX request or other logic here
    }
</script>

{{--  --}}

<script>
    // Function to add a new row to the table's tbody
    function addItem(tableId) {
        // Reference to the table's tbody
        var tbody = $('#' + tableId + ' tbody');

        // Clone the last row and remove the values
        var newRow = tbody.find('tr:last').clone().find('input').val('').end();

        // Increment the SRL NO value by 1
        var lastSrlNo = parseInt(newRow.find('[name="pcs1[]"]').val());

        // Check if lastSrlNo is NaN, and set it to 1
        // if (isNaN(lastSrlNo)) {
        //     lastSrlNo = 1;
        // }

        newRow.find('[name="pcs1[]"]').val('');

        // Append the new row to the tbody
        tbody.append(newRow);
    }

    // Function to remove the last added row
    function removeItem(tableId) {
        var tbody = $('#' + tableId + ' tbody');
        if (tbody.find('tr').length > 1) {
            tbody.find('tr:last').remove();
        }
    }

    // Function to remove a specific row
    function removeRow(button) {
        $(button).closest('tr').remove();
    }
</script>


<!-- Include jQuery -->
{{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
