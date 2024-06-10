@extends('layouts/layoutMaster')

@section('title', 'Sales Order List')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
    <!-- Form Validation -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

<style>
    th {
        white-space: nowrap !important;
    }
</style>

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Sales Order /</span> List
    </h4>

    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-body border-bottom d-none" id="filter-search">
            <h4 class="card-title">Search &amp; Filter</h4>
            <div class="row">
                <div class="col-md-3 user_status">
                    <label class="form-label" for="type">Date range</label>
                    <span class="form-group form-control-sm">
                        <div id="dateRange" class="pull-right"
                            style="background: #fff; cursor: pointer; padding: 8px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                            <span></span> <b class="caret"></b>
                        </div>
                        <input type="hidden" id="startDateShow">
                        <input type="hidden" id="endDateShow">
                    </span>
                </div>
                <div class="col-md-3 user_role"><label class="form-label" for="company">Customer</label>
                    <select id="company" onchange="getData()" class="form-select select2 text-capitalize mb-md-0 mb-2">
                        <option value=""> Select Customer</option>
                        @foreach (\App\Models\Customer::all() as $data)
                            <option value="{{ $data->id }}">{{ $data->company_name }} -
                                {{ $data->buyer_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 user_status"><label class="form-label" for="brand">Brand</label>
                    <select id="brand" onchange="getData()" class="form-select text-capitalize mb-md-0 mb-2xx">
                        <option value=""> Select Brand</option>
                        @foreach (\App\Models\Brand::all() as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 user_role"><label class="form-label" for="StyleCategory">Style Category</label>
                    <select id="StyleCategory" onchange="getData()"
                        class="form-select select2 text-capitalize mb-md-0 mb-2">
                        <option value=""> Select Category</option>
                        @foreach (\App\Models\StyleCategory::all() as $data)
                            <option @php if($data->id==old('Category')){ echo 'selected';} @endphp
                                value="{{ $data->id }}">{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>


                {{-- <div class="col-md-2 user_plan"><label class="form-label" for="designer">Designer</label>
                    <select id="designer" onchange="getData()" class="form-select text-capitalize mb-md-0 mb-2">
                        <option value=""> Select Designer</option>
                        @foreach (\App\Models\User::where('role', 'designer')->get() as $user)
                            <option value="{{ $user->id }}">{{ $user->company_name }} -
                                {{ $user->person_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 user_role"><label class="form-label" for="Category">Category</label>
                    <select id="category" onchange="getData()" class="form-select select2 text-capitalize mb-md-0 mb-2">
                        <option value=""> Select Category</option>
                        @foreach (\App\Models\StyleCategory::all() as $data)
                            <option @php if($data->id==old('Category')){ echo 'selected';} @endphp
                                value="{{ $data->id }}">{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 user_role"><label class="form-label" for="Category">Sub Category</label>
                    <select id="subcategory" onchange="getData()" class="form-select select2 text-capitalize mb-md-0 mb-2">
                        <option value=""> Select Sub Category</option>
                        @foreach (\App\Models\StyleSubCategory::all() as $data)
                            <option @php if($data->id==old('Category')){ echo 'selected';} @endphp
                                value="{{ $data->id }}">{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div> --}}



            </div>
        </div>
        <div class="row container">
            <p> <b>Filters</b> :-
                <small class="m-2" id="dateFilterShow"></small>
                <small class="m-3" id="companyFilterShow"></small>
                <small class="m-3" id="brandFilterShow"></small>
                <small class="m-3" id="styleCategoryFilterShow"></small>
            </p>
        </div>
        <div class="card card-datatable table-responsive">


            <table class="invoice-list-table dataTable table" id="job-card-datatable-list">
                <thead class="table-secondary text-bold">
                    <tr>
                        <th>Sr.No</th>
                        <th>Created Date</th>
                        <th>Sales Order No</th>
                        <th>Company Name</th>
                        <th>Brand</th>
                        <th>Style No</th>
                        <th>Total Qty</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

@endsection
@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <!-- Flat Picker -->
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>

    <script type="text/javascript" src="{{ URL::asset('js/daterangepicker.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('css/daterangepicker.css') }}" />

    <!-- Form Validation -->
    <script>
        function formatDate(dateStr) {
            return dateStr.split('-').reverse().join('-');
        }
        const start = moment().subtract(29, 'days');
        const end = moment().subtract(0, 'days');

        function getDateFind(start, end) {
            $('#dateRange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            var startDateFormat = new Date(start.format('MMMM D, YYYY'));
            var startDate = new Date(startDateFormat.getTime() - (startDateFormat.getTimezoneOffset() * 60000))
                .toISOString()
                .split('T')[0];

            var endDateFormat = new Date(end.format('MMMM D, YYYY'));
            var endDate = new Date(endDateFormat.getTime() - (endDateFormat.getTimezoneOffset() * 60000))
                .toISOString()
                .split('T')[0];
            $('#startDateShow').val(startDate);
            $('#endDateShow').val(endDate);
            getData(startDate, endDate);
        }

        $('#dateRange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')]
            }
        }, getDateFind);
        getDateFind(start, end);


        // getData();

        function getData(startDate = '', endDate = '') {
            if (startDate === undefined || startDate === '') {
                startDate = $('#startDateShow').val();
            }
            if (endDate === undefined || endDate === '') {
                endDate = $('#endDateShow').val();
            }
            if ($.fn.DataTable.isDataTable('#job-card-datatable-list')) {
                $('#job-card-datatable-list').DataTable().destroy();
            }

            var dtInvoiceTable = $('#job-card-datatable-list');
            var company = $('#company');
            var brand = $('#brand');
            var styleCategory = $('#StyleCategory');
            // datatable
            if (startDate !== '') {
                $('#dateFilterShow').html('<b>Date Range</b> : ' + formatDate(startDate) + ' to ' + formatDate(endDate));
            }
            if (company.val() !== '') {
                $('#companyFilterShow').html('<b>Company</b> : ' + company.find('option:selected').text());
            } else {
                $('#companyFilterShow').html('');
            }
            if (brand.val() !== '') {
                $('#brandFilterShow').html('<b>Designer</b> : ' + brand.find('option:selected').text());
            } else {
                $('#brandFilterShow').html('');
            }
            if (styleCategory.val() !== '') {
                $('#styleCategoryFilterShow').html('<b>Category</b> : ' + styleCategory.find('option:selected').text());
            } else {
                $('#styleCategoryFilterShow').html('');
            }


            if (dtInvoiceTable.length) {
                var dtInvoice = dtInvoiceTable.DataTable({
                    autoWidth: false,
                    ajax: {
                        'url': "{{ route('sales-order-fliter') }}",
                        'type': 'POST',
                        'headers': '{ \'X-CSRF-TOKEN\': $(\'meta[name=\'csrf-token\']\').attr(\'content\') }',
                        'data': {
                            'company': company.val(),
                            'brand': brand.val(),
                            'styleCategory': styleCategory.val(),
                            'startDate': startDate,
                            'endDate': endDate,
                            '_token': "{{ csrf_token() }}"
                        }
                    },
                    dom: '<"row me-2"' +
                        '<"col-md-2"<"me-3"l>>' +
                        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
                        '>t' +
                        '<"row mx-2"' +
                        '<"col-sm-12 col-md-6"i>' +
                        '<"col-sm-12 col-md-6"p>' +
                        '>',
                    language: {
                        sLengthMenu: '_MENU_',
                        search: '',
                        searchPlaceholder: 'Search..'
                    },
                    // Buttons with Dropdown
                    buttons: [{
                            extend: 'collection',
                            className: 'btn btn-label-primary dropdown-toggle mx-3',
                            text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
                            buttons: [{
                                    extend: 'print',
                                    text: '<i class="ti ti-printer me-2" ></i>Print',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        format: {
                                            body: function(inner, coldex, rowdex) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result = '';
                                                $.each(el, function(index, item) {
                                                    if (item.classList !== undefined && item
                                                        .classList.contains('user-name')) {
                                                        result = result + item.lastChild
                                                            .firstChild.textContent;
                                                    } else if (item.innerText === undefined) {
                                                        result = result + item.textContent;
                                                    } else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    },
                                    customize: function(win) {
                                        //customize print view for dark
                                        $(win.document.body)
                                            .css('color', headingColor)
                                            .css('border-color', borderColor)
                                            .css('background-color', bodyBg);
                                        $(win.document.body)
                                            .find('table')
                                            .addClass('compact')
                                            .css('color', 'inherit')
                                            .css('border-color', 'inherit')
                                            .css('background-color', 'inherit');
                                    }
                                },
                                {
                                    extend: 'csv',
                                    text: '<i class="ti ti-file-text me-2" ></i>Csv',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        format: {
                                            body: function(inner, coldex, rowdex) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result = '';
                                                $.each(el, function(index, item) {
                                                    if (item.classList !== undefined && item
                                                        .classList.contains('user-name')) {
                                                        result = result + item.lastChild
                                                            .firstChild.textContent;
                                                    } else if (item.innerText === undefined) {
                                                        result = result + item.textContent;
                                                    } else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    }
                                },
                                {
                                    extend: 'excel',
                                    text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        format: {
                                            body: function(inner, coldex, rowdex) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result = '';
                                                $.each(el, function(index, item) {
                                                    if (item.classList !== undefined && item
                                                        .classList.contains('user-name')) {
                                                        result = result + item.lastChild
                                                            .firstChild.textContent;
                                                    } else if (item.innerText === undefined) {
                                                        result = result + item.textContent;
                                                    } else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        format: {
                                            body: function(inner, coldex, rowdex) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result = '';
                                                $.each(el, function(index, item) {
                                                    if (item.classList !== undefined && item
                                                        .classList.contains('user-name')) {
                                                        result = result + item.lastChild
                                                            .firstChild.textContent;
                                                    } else if (item.innerText === undefined) {
                                                        result = result + item.textContent;
                                                    } else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    }
                                },
                                {
                                    extend: 'copy',
                                    text: '<i class="ti ti-copy me-2" ></i>Copy',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        format: {
                                            body: function(inner, coldex, rowdex) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result = '';
                                                $.each(el, function(index, item) {
                                                    if (item.classList !== undefined && item
                                                        .classList.contains('user-name')) {
                                                        result = result + item.lastChild
                                                            .firstChild.textContent;
                                                    } else if (item.innerText === undefined) {
                                                        result = result + item.textContent;
                                                    } else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    }
                                }
                            ]
                        },
                        {
                            text: '<i class="ti ti-filter me-md-1"></i><span class="d-md-inline-block d-none"></span>',
                            className: 'btn btn-primary',
                            action: function(e, dt, button, config) {
                                $('#filter-search').toggleClass('d-none');
                            }
                        }
                    ],
                    // For responsive popup
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data();
                                    return 'Details of Job Card';
                                }
                            }),
                            type: 'column',
                            renderer: function(api, rowIdx, columns) {
                                var data = $.map(columns, function(col, i) {
                                    return col.title !==
                                        '' // ? Do not show row in modal popup if title is blank (for check box)
                                        ?
                                        '<tr data-dt-row="' +
                                        col.rowIndex +
                                        '" data-dt-column="' +
                                        col.columnIndex +
                                        '">' +
                                        '<td>' +
                                        col.title +
                                        ':' +
                                        '</td> ' +
                                        '<td>' +
                                        col.data +
                                        '</td>' +
                                        '</tr>' :
                                        '';
                                }).join('');

                                return data ? $('<table class="table"/><tbody />').append(data) : false;
                            }
                        }
                    }
                });
            }
        }
    </script>
    <script>
        function deleteSalesOrder(SalesOrderId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#overlay").fadeIn(100);
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('sales-order-delete') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            salesOrderId: SalesOrderId,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(resultData) {
                            if (resultData.success) {
                                Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                                    location.reload();
                                    $("#overlay").fadeOut(100);
                                });
                            } else {
                                Swal.fire('Error',
								    'Job Planning or Job Card Has been created for this Sales Order !',
                                    'error').then(() => {
                                    $("#overlay").fadeOut(100);
                                });
                            }

                        }
                    });
                }
            });
        }
    </script>
@endsection
