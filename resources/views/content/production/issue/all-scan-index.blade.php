@extends('layouts.master')

@section('title', __('Scan Tracking Details'))

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
                        <div class="col-md-2 col-xs-12">
                            <input type="checkbox" class="" id="single" value="single" name="single" onclick="getAllLots()"
                                   placeholder="Single">
                            <label for="takenBefore">Without Details</label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-3 col-md-6 col-sm-6">
                            <label for="input-number">{{__('Users')}} Select Multiple ...</label>
                            <select name="user_id" id="user_id"
                                    class="form-control select2 employee-placeholder-multiple" multiple
                                    onchange="getAllLots();">
                                @hasanyrole('Manager|Super Admin|Account Assistant|Account')
{{--                                @if(!empty($users))--}}
{{--                                    <option selected value>{{__('-- All Users --')}}</option>--}}
{{--                                @endif--}}
                                @endhasanyrole();
                                @foreach($users as $user)
                                    <option
                                        value="{{ $user->id }}" @if(Session::has('issueFilter') && Session::get('issueFilter')['user_id'] == $user->id){{'selected'}}@endif>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-6 col-sm-6">
                            <label for="input-number">{{__('Party Name')}}</label>
                            <select name="party_name" id="party_name" class="form-control select2"
                                    onchange="getAllLots();">
                                @if(!empty($inwardDetails))
                                    <option selected value>{{__('-- All Party Name --')}}</option>
                                @endif
                                @foreach($partyMaster as $party)
                                    <option
                                        value="{{ $party->id }}" @if(Session::has('issueFilter') && Session::get('issueFilter')['party_name'] == $party->id){{'selected'}}@endif>{{ $party->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-sm-6">
                            <label for="input-number">{{__('Process Inward')}}</label>
                            <select name="inward_number" id="inward_number"
                                    title="Party Name - C-No - Process Inward - C-Date"
                                    class="form-control select2 lot-placeholder-multiple" onchange="getAllLots();">
                                @if(!empty($inwardDetails))
                                    <option selected
                                            value>{{__('Party Name - C-No - Process Inward - C-Date')}}</option>
                                @endif
                                @foreach($inwardDetails as $inwardDetail)
                                    <option
                                        value="{{ $inwardDetail->fk_inward_id }}">{{ $inwardDetail->name.' - '.$inwardDetail->partyChallan.' - '.$inwardDetail->fk_inward_id.' - '.date('d/m/Y',strtotime($inwardDetail->inwardDate))}}</option>
                                @endforeach
                            </select>
                        </div>
                        @php $checkIsBlueInward = \App\Http\Controllers\Controller::isBlueInward(); @endphp
                        <div class="form-group col-lg-3 col-md-6 col-sm-6"
                             @if($checkIsBlueInward == '1') hidden @endif>
                            <label for="input-number">{{__('Status Type')}}</label>
                            <select name="statusType" id="statusType"
                                    class="form-control lot-placeholder-multiple"
                                    onchange="getAllLots();">
                                @if($checkIsBlueInward != '1')
                                    <option selected value>{{__('-- All Status Type --')}}</option>
                                    <option value="blue">{{__('Blue')}}</option>
                                @endif
                                <option value="white">{{__('White')}}</option>
                            </select>
                        </div>
{{--                        <div class="form-group col-lg-3 col-md-6 col-sm-6">--}}
{{--                            <label for="input-number">{{__('Action')}}</label>--}}
{{--                            <select name="action" id="action"--}}
{{--                                    class="form-control select2 lot-placeholder-multiple" onchange="getAllLots();">--}}
{{--                                <option selected value>{{__('-- Select --')}}</option>--}}
{{--                                <option--}}
{{--                                    value="transfer" @if(Session::has('issueFilter') && Session::get('issueFilter')['action'] == 'transfer'){{'selected'}}@endif>--}}
{{--                                    Transfer--}}
{{--                                </option>--}}
{{--                                <option--}}
{{--                                    value="receive" @if(Session::has('issueFilter') && Session::get('issueFilter')['action'] == 'receive'){{'selected'}}@endif>--}}
{{--                                    Receive--}}
{{--                                </option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="form-group col-lg-3 col-md-6 col-sm-6">
                            <label for="input-number">{{__('Inward Type')}}</label>
                            <select name="inwardPart" id="inwardPart"
                                    class="form-control" onchange="getAllLots();">
                                <option value>{{__('-- All Inward Type --')}}</option>
                                <option value="sample">{{__('Sample')}}</option>
                                <option value="bulk" selected>{{__('Bulk')}}</option>
                                <option value="rewash">{{__('Rewash')}}</option>

                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-6 col-sm-6">
                            <label for="input-number">{{__('Department')}}</label>
                            <select name="department_id" id="department_id" class="form-control select2"
                                    onchange="getAllLots();">
                                <option selected value>{{__('-- All Department --')}}</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-6 col-sm-6">
                            <label for="input-number">{{__('WIP Status')}}</label>
                            <select name="wipStatus" id="wipStatus"
                                    class="form-control"
                                    onchange="getAllLots();">
                                <option value="2" >{{__('WIP')}}</option>
                                <option value="1" hidden>{{__('NON-WIP')}}</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-sm-6">
                            <label for="input-number">{{__('Operations')}} Select Multiple ...</label>
                            <select name="operation_id" id="operation_id" class="form-control select2" multiple
                                    onchange="getAllLots();">
{{--                                <option selected value>{{__('-- All Operations --')}}</option>--}}
                                @foreach($operations as $operation)
                                    <option value="{{ $operation->id }}">{{ $operation->description }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-sm-6">
                            <label for="input-number">{{__('Start Date')}}</label>
                            <input type="date" id="startDate" name="startDate"
                                   value="{{ Session::has('issueFilter') && !empty(Session::get('issueFilter')['startDate']) ? Session::get('issueFilter')['startDate'] : date('Y-m-01') }}"
                                   class="form-control"
                                   onchange="getAllLots();">
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-sm-6">
                            <label for="input-number">{{__('End Date')}}</label>
                            <input type="date" id="endDate" name="endDate" class="form-control"
                                   onchange="getAllLots();"
                                   value="{{Session::has('issueFilter') && !empty(Session::get('issueFilter')['endDate']) ? Session::get('issueFilter')['endDate'] : date('Y-m-d')}}">
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-sm-6">
                            <label for="input-number">{{__('O/W Start Date')}}</label>
                            <input type="date" id="outwardStartDate" name="outwardStartDate"
                                   value="{{ date('Y-m-01') }}"
                                   class="form-control"
                                   onchange="getAllLots();">
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-sm-6">
                            <label for="input-number">{{__('O/W  End Date')}}</label>
                            <input type="date" id="outwardEndDate" name="outwardEndDate" class="form-control"
                                   onchange="getAllLots();"
                                   value="{{ date('Y-m-d')}}">
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="table-devices" class="table table-bordered table-striped">
                        <thead>
                        <tr>
{{--                            <th id="pi-div">P Inward No.</th>--}}
                            <th>G-P Inward No.</th>
                            <th>V Inward No.</th>

                            <th>Issue Date</th>
                            <th>Style</th>
                            <th>Dep-Category-Type</th>
                            <th>User Name</th>
                            <th>Party Name</th>
                            <th>Department</th>
                            <th>Operation</th>
{{--                            <th>Operation Rate * Qty = Total</th>--}}
{{--                            <th>Packing Qty</th>--}}
                            <th>Packing Date</th>
                            <th>Outward Details</th>
                            <th>Inward Qty</th>
                            <th>V Pcs</th>
                            <th>Scan</th>
                            <th>Packing</th>
                            <th>Out</th>
                            <th>Bill Qty</th>
                            <th>Rate</th>
                            <th>Payment</th>
                            <th>Balance</th>
                            <th>After Outward Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script type="text/javascript">
        $("#party_name").select2({
            ajax: {
                url: "{{ route('partyMaster.getPartyById') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,// search term
                        matchSku: 0
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            placeholder: 'Enter Party Name',
            minimumInputLength: 2,
        });

        getAllLots();

        function getAllLots() {

            let urlAction = '';
            let single = $('input[name="single"]:checked').val();
            if (single === 'single') {
                urlAction = "{{ route('issue.all-scan-listing-single') }}";
                //$("#pi-div").hide();
                $('#table-devices').DataTable({
                    order: [[0, 'desc']],
                    processing: true,
                    serverSide: true,
                    paging: true,
                    pageLength: 10,
                    dom: 'lBfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            text: '<i class="fa fa-file-excel-o" style="color: green;"></i>  Excel',
                            titleAttr: 'Excel',
                            action: newexportaction,

                        },
                        {
                            extend: 'csv',
                            text: '<i class="fa fa-file-excel-o" style="color: green;"></i>  Excel',
                            titleAttr: 'Excel',
                            action: newexportaction,
                        },

                        {
                            extend: 'print',

                        },
                        {
                            extend: 'pdf',
                            orientation: 'landscape', //landscape,portrait
                            pageSize: 'A4',
                            customize: function (doc) {
                                doc.content.splice(0, 1);
                                var now = new Date();
                                var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear();
                                var logo = logoBase64();
                                console.log(logo);
                                doc.pageMargins = [20, 60, 20, 30];
                                doc.defaultStyle.fontSize = 9;
                                doc.styles.tableHeader.fontSize = 12;
                                doc.defaultStyle.alignment = 'center';
                                doc['header'] = (function () {
                                    return {
                                        columns: [
                                            {
                                                image: logo,
                                                width: 60
                                            },
                                            {
                                                alignment: 'center',
                                                italics: true,
                                                text: 'Scan Report Details',
                                                fontSize: 18,
                                                margin: [10, 0]
                                            },
                                        ],
                                        margin: 20
                                    }
                                });

                                var objLayout = {};
                                objLayout['hLineWidth'] = function (i) {
                                    return .5;
                                };
                                objLayout['vLineWidth'] = function (i) {
                                    return .5;
                                };
                                objLayout['hLineColor'] = function (i) {
                                    return '#aaa';
                                };
                                objLayout['vLineColor'] = function (i) {
                                    return '#aaa';
                                };
                                objLayout['paddingLeft'] = function (i) {
                                    return 4;
                                };
                                objLayout['paddingRight'] = function (i) {
                                    return 4;
                                };
                                doc.content[0].layout = objLayout;
                            },

                        }
                    ],

                    lengthMenu: [[10, 20, 100, 1000000], [10, 20, 100, "All"]],
                    "ajax": {
                        "url": urlAction,
                        "type": "POST",
                        "headers": "{ 'X-CSRF-TOKEN': $('meta[name='csrf-token']').attr('content') }",
                        "data": {
                            "party_name": $('#party_name').val(),
                            "inward_number": $('#inward_number').val(),
                            "startDate": $('#startDate').val(),
                            "endDate": $('#endDate').val(),
                            "outwardStartDate": $('#outwardStartDate').val(),
                            "outwardEndDate": $('#outwardEndDate').val(),
                            "statusType": $('#statusType').val(),
                            "wipStatus": $('#wipStatus').val(),
                            "user_id": $('#user_id').val(),
                            "department_id": $('#department_id').val(),
                            "operation_id": $('#operation_id').val(),
                            "action": $('#action').val(),
                            "inwardPart": $('#inwardPart').val(),
                            "_token": "{{ csrf_token() }}"
                        },
                    },
                    bDestroy: true
                });
            } else {
                urlAction = "{{ route('issue.all-scan-listing') }}";
                //$("#pi-div").show();
                var groupColumn = 1;
                $('#table-devices').DataTable({
                    order: [[0, 'desc']],
                    processing: true,
                    serverSide: true,
                    paging: true,
                    pageLength: 10,
                    dom: 'lBfrtip',
                    drawCallback: function (settings) {
                        var api = this.api();
                        var rows = api.rows({page: 'current'}).nodes();
                        var last = null;
                        api.column(groupColumn, {page: 'current'}).data().each(function (group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before(
                                    '<tr class="group"><td colspan="19" align="left" class="text-bold h4 bg-light text-black">' + group + '</td></tr>'
                                );
                                last = group;
                            }
                        });
                    },
                    buttons: [
                        {
                            extend: 'excel',
                            text: '<i class="fa fa-file-excel-o" style="color: green;"></i>  Excel',
                            titleAttr: 'Excel',
                            action: newexportaction,

                        },
                        {
                            extend: 'csv',
                            text: '<i class="fa fa-file-excel-o" style="color: green;"></i>  Excel',
                            titleAttr: 'Excel',
                            action: newexportaction,
                        },

                        {
                            extend: 'print',

                        },
                        {
                            extend: 'pdf',
                            orientation: 'landscape',
                            text: '<i class="fa fa-file-excel-o" style="color: green;"></i>  PDF',
                            titleAttr: 'PDF',
                            fontSize: 12,
                            action: newexportaction,

                        },
                        // {
                        //     extend: 'pdf',
                        //     orientation: 'landscape', //landscape,portrait
                        //     pageSize: 'A4',
                        //     customize: function (doc) {
                        //         doc.content.splice(0, 1);
                        //         var now = new Date();
                        //         var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear();
                        //         var logo = logoBase64();
                        //         console.log(logo);
                        //         doc.pageMargins = [20, 60, 20, 30];
                        //         doc.defaultStyle.fontSize = 9;
                        //         doc.styles.tableHeader.fontSize = 12;
                        //         doc.defaultStyle.alignment = 'center';
                        //         doc['header'] = (function () {
                        //             return {
                        //                 columns: [
                        //                     {
                        //                         image: logo,
                        //                         width: 60
                        //                     },
                        //                     {
                        //                         alignment: 'center',
                        //                         italics: true,
                        //                         text: 'Scan Report Details',
                        //                         fontSize: 18,
                        //                         margin: [10, 0]
                        //                     },
                        //                 ],
                        //                 margin: 20
                        //             }
                        //         });
                        //
                        //         var objLayout = {};
                        //         objLayout['hLineWidth'] = function (i) {
                        //             return .5;
                        //         };
                        //         objLayout['vLineWidth'] = function (i) {
                        //             return .5;
                        //         };
                        //         objLayout['hLineColor'] = function (i) {
                        //             return '#aaa';
                        //         };
                        //         objLayout['vLineColor'] = function (i) {
                        //             return '#aaa';
                        //         };
                        //         objLayout['paddingLeft'] = function (i) {
                        //             return 4;
                        //         };
                        //         objLayout['paddingRight'] = function (i) {
                        //             return 4;
                        //         };
                        //         doc.content[0].layout = objLayout;
                        //     },
                        //
                        // }
                    ],
                    lengthMenu: [[10, 20, 100, 1000000], [10, 20, 100, "All"]],
                    "ajax": {
                        "url": urlAction,
                        "type": "POST",
                        "headers": "{ 'X-CSRF-TOKEN': $('meta[name='csrf-token']').attr('content') }",
                        "data": {
                            "party_name": $('#party_name').val(),
                            "inward_number": $('#inward_number').val(),
                            "startDate": $('#startDate').val(),
                            "endDate": $('#endDate').val(),
                            "outwardStartDate": $('#outwardStartDate').val(),
                            "outwardEndDate": $('#outwardEndDate').val(),
                            "statusType": $('#statusType').val(),
                            "wipStatus": $('#wipStatus').val(),
                            "user_id": $('#user_id').val(),
                            "inwardPart": $('#inwardPart').val(),
                            "department_id": $('#department_id').val(),
                            "operation_id": $('#operation_id').val(),
                            "action": $('#action').val(),
                            "_token": "{{ csrf_token() }}"
                        },
                    },
                    bDestroy: true
                });
            }
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
