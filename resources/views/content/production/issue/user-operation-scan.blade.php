@extends('layouts.master')

@section('title', __('User Wise Efficiency Report'))

@section('content')
    {{-- Data list view starts --}}

    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10 col-xs-12">
                            <h3 class="card-title">{{__('Filters')}}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-6 col-sm-6">
                            <label>Working Departments</label>
                            <select class="form-control form-control-sm select2" name="working_department"
                                    id="working_department"
                                    onchange="getAllLots();">
                                <option value="" selected>All Working Departments</option>
                                @if(!empty($workingDepartments))
                                    @foreach($workingDepartments as $workingDepartment)
                                        <option
                                            value="{{ $workingDepartment->id }}">{{ strtoupper($workingDepartment->name) }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-lg-2 col-md-6 col-sm-6">
                            <label for="input-number">{{__('Department')}}</label>
                            <select name="department_id" id="department_id" class="form-control form-control-sm select2"
                                    onchange="getAllLots();">
                                <option selected value>{{__('-- All Department --')}}</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-2 col-md-6 col-sm-6">
                            <label for="input-number">{{__('Inward Type')}}</label>
                            <select name="inwardPart" id="inwardPart"
                                    class="form-control form-control-sm select2"
                                    onchange="getAllLots();">
                                <option selected value>{{__('-- All Inward Type --')}}</option>
                                <option
                                    value="sample">{{__('Sample')}}</option>
                                <option
                                    value="bulk">{{__('Bulk')}}</option>
                                <option
                                    value="rewash">{{__('ReWash')}}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-2 col-md-6 col-sm-6" hidden>
                            <label for="input-number">{{__('WIP Status')}}</label>
                            <select name="wipStatus" id="wipStatus"
                                    class="form-control form-control-sm"
                                    onchange="getAllLots();">
                                <option value="2" selected>{{__('WIP')}}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-2 col-md-6 col-sm-6">
                            <label for="input-number">{{__('Status')}}</label>
                            <select name="status" id="status"
                                    class="form-control form-control-sm select2"
                                    onchange="getAllLots();">
                                <option selected value>{{__('-- All Status--')}}</option>
                                <option
                                    value="complete">{{__('Complete')}}</option>
                                <option
                                    value="pending">{{__('Pending')}}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-2 col-md-6 col-sm-6">
                            <label for="input-number">{{__('Start Date')}}</label>
                            <input type="datetime-local" id="startDate" value="{{ date('Y-m-d 00:00:00') }}"
                                   name="startDate" class="form-control form-control-sm" onchange="getAllLots();">
                        </div>
                        <div class="form-group col-lg-2 col-md-6 col-sm-6">
                            <label for="input-number">{{__('End Date')}}</label>
                            <input type="datetime-local" id="endDate" value="{{ date('Y-m-d 23:59') }}" name="endDate"
                                   class="form-control form-control-sm" onchange="getAllLots();">
                        </div>
                    </div>
                    Note :
                    <button type="button" class="btn btn-outline-warning btn-sm"> 1 = Scan Quantity</button>
                    <button type="button" class="btn btn-outline-success btn-sm"> 2 = Complete Qty</button>
                    <button type="button" class="btn btn-outline-primary btn-sm"> 3 = Amount</button>
                </div>
                <HR>
                <div class="card-body">
                    <div id="table-details">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script type="text/javascript">

        getAllLots();

        function getAllLots() {
            $('#table-details').empty();
            $.ajax({
                type: 'POST',
                url: '{{ route('issue.user-operation-scan-list') }}',
                dataType: 'JSON',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    "department_id": $('#department_id').val(),
                    "inwardPart": $('#inwardPart').val(),
                    "working_department": $('#working_department').val(),
                    "startDate": $('#startDate').val(),
                    "endDate": $('#endDate').val(),
                    "wipStatus": $('#wipStatus').val(),
                    "status": $('#status').val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    $('#table-details').append(data);
                    $body.removeClass("loading");

                    $('#table-devices').DataTable({
                        paging: true,
                        pageLength: 20,
                        dom: 'lBfrtip',
                        buttons: [
                            'csv'
                        ],
                        lengthMenu: [[10, 20, 100, 1000000], [10, 20, 100, "All"]],
                        bDestroy: true
                    });
                },
                error: function (data) {
                    $('#table-details').empty();
                }
            });

        }

        function newexportaction(e, dt, button, config) {
            var self = this;

            var oldStart = dt.settings()[0]._iDisplayStart;
            dt.one('preXhr', function (e, s, data) {
                // Just this once, load all data from the server...
                data.start = 0;
                data.length = 2147483647;
                dt.one('preDraw', function (e, settings) {
                    // Call the original action function
                    if (button[0].className.indexOf('buttons-copy') >= 0) {
                        $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                        $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                        $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                        $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-print') >= 0) {
                        $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                    }
                    dt.one('preXhr', function (e, s, data) {
                        // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                        // Set the property to what it was before exporting.
                        settings._iDisplayStart = oldStart;
                        data.start = oldStart;
                    });
                    // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                    setTimeout(dt.ajax.reload, 0);
                    // Prevent rendering of the full data to the DOM
                    return false;
                });
            });
            // Requery the server with the new one-time export settings
            dt.ajax.reload();
        }
    </script>
@endsection
