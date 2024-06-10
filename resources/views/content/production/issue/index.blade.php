@extends('layouts.master')

@section('title', __('Issue Details'))

@section('content')
{{-- Data list view starts --}}

<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-10 col-xs-12">
                        <h3 class="card-title"><a href="{{ route('issue.create') }}">
                                <button type="button"
                                        class="btn btn-default mr-4"><i
                                            class="fa fa-backward"></i>&nbsp;{{ __('Back') }}
                                </button>
                            </a>{{__('Filters')}}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-lg-3 col-md-6 col-sm-6">
                        <label for="input-number">{{__('Users')}}</label>
                        <select name="user_id" id="user_id"
                                class="form-control select2 employee-placeholder-multiple"
                                onchange="getAllLots();">
                            @hasanyrole('Manager|Super Admin|Account Assistant|Account')
                            @if(!empty($users))
                            <option selected value>{{__('-- Select Users --')}}</option>
                            @endif
                            @endhasanyrole();
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" @if(Session::has(
                            'issueFilter') && Session::get('issueFilter')['user_id'] ==
                            $user->id){{'selected'}}@endif>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-3 col-md-6 col-sm-6">
                        <label for="input-number">{{__('Party Name')}}</label>
                        <select name="party_name" id="party_name" class="form-control select2"
                                onchange="getAllLots();">
                            @if(!empty($partyMaster))
                            <option selected value>{{__('-- Select Party Name --')}}</option>
                            @endif
                            @foreach($partyMaster as $party)
                            <option value="{{ $party->id }}" @if(Session::has('issueFilter') && Session::get('issueFilter')['party_name'] == $party->id){{'selected'}}@endif>{{ $party->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-sm-3">
                        <label for="input-number">{{__('Party Name - C-No - P Inward - C-Date')}}</label>
                        <select class="form-control select2" name="fk_inward_id" id="fk_inward_id" onchange="getAllLots();">
                            <option value="">--All Party Name - C-No - P Inward - C-Date--</option>
                        </select>
                    </div>

                <div class="form-group col-lg-3 col-md-6 col-sm-6">
                    <label for="input-number">{{__('Action')}}</label>
                    <select name="action" id="action"
                            class="form-control select2 lot-placeholder-multiple" onchange="getAllLots();">
                        <option selected value>{{__('-- Select --')}}</option>
                        <option value="transfer" @if(Session::has('issueFilter') && Session::get('issueFilter')['action'] == 'transfer'){{'selected'}}@endif>Transfer</option>
                        <option value="receive" @if(Session::has('issueFilter') && Session::get('issueFilter')['action'] == 'receive'){{'selected'}}@endif>Receive</option>
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


            </div>
        </div>

        <div class="card-body">
            <table id="table-devices" class="table table-bordered table-striped ">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Party Name</th>
                    <th>Challan No</th>
                    <th>Style No</th>
                    <th>Inward No.</th>
                    <th>V Inward No.</th>
                    <th>ID</th>
                    <th>Jobcard Qty</th>
                    <th>Issue Qty</th>
                    <th>Department Name</th>
                    <th>Operation Name</th>
                    <th>User Name</th>
                    <th>History</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<form action="{{ route('issue.receive') }}" method="POST">
    <div class="modal fade" id="modal-issue-receive" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">Receive</h4>
                    <h4 class="modal-title ml-3">Inward No. : <span class="text-bold"
                                                                    id="showIssueNoForReceive"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-default bg-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form action="{{ route('issue.packingReceive') }}" method="POST">
    <div class="modal fade" id="modal-issue-packing-receive" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">Packing Receive</h4>
                    <h4 class="modal-title ml-3">Inward No. : <span class="text-bold"
                                                                    id="showIssueNoForPackingReceive"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-default bg-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form action="{{ route('issue.changeDepartment') }}" method="POST">
    <div class="modal fade" id="modal-issue-transfer" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-light">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">Transfer Process</h4>
                    <h4 class="modal-title ml-3">Issue No. : <span class="text-bold"
                                                                   id="showIssueNoForTransfer"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-default bg-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="modal-issue-history" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-light">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">All Transfer Process</h4>
                <h4 class="modal-title ml-3">Inward No. : <span class="text-bold" id="showIssueNoForHistory"></span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
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
    $("#fk_inward_id").select2({
        ajax: {
            url: "{{ route('issue.getInwardById') }}",
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
        placeholder: 'Enter Inward No',
        minimumInputLength: 2,
    });
    function storeSelectedUser(userId, issueId) {
        // Send an AJAX request to the storeSelectedUser route
        $.ajax({
            url: "{{ route('issue.storeSelectedUser') }}",
            method: "POST",
            data: {
                selectedUserId: userId,
                id: issueId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    console.log('User stored successfully');
                    // You may want to perform some action upon successful storage, like refreshing the page or updating UI
                } else {
                    console.error('Error storing user:', response.error);
                    // You may want to handle errors here, like displaying an error message to the user
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                // You may want to handle AJAX errors here, like displaying an error message to the user
            }
        });
    }
    function viewIssueReceive(id) {
        $body.addClass("loading");
        $('#showIssueNoForReceive').html(id);
        $.ajax({
            type: 'POST',
            url: "{{ route('issue.viewIssueReceivePopup') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id: id, "_token": "{{ csrf_token() }}"},
            success: function (data) {
                $('.modal-body').html(data);
                $('#modal-issue-receive').modal('show');
                $(".select2").select2();
                $body.removeClass("loading");
            },
            error: function (data) {
                alert(data);
                $body.removeClass("loading");
            }
        });
    }

    function viewIssuePackingReceive(id) {
        $body.addClass("loading");
        $('#showIssueNoForPackingReceive').html(id);
        $.ajax({
            type: 'POST',
            url: "{{ route('issue.viewIssueReceivePopup') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id: id, "_token": "{{ csrf_token() }}"},
            success: function (data) {
                $('.modal-body').html(data);
                $('#modal-issue-packing-receive').modal('show');
                $(".select2").select2();
                $body.removeClass("loading");
            },
            error: function (data) {
                alert(data);
                $body.removeClass("loading");
            }
        });
    }


    function viewIssueModelForTransfer(id) {
        $body.addClass("loading");
        $('#showIssueNoForTransfer').html(id);
        $.ajax({
            type: 'POST',
            url: "{{ route('issue.viewIssuePopupForTransfer') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id: id, "_token": "{{ csrf_token() }}"},
            success: function (data) {
                $('.modal-body').html(data);
                $('#modal-issue-transfer').modal('show');
                $(".select2").select2();
                $body.removeClass("loading");
            },
            error: function (data) {
                alert(data);
                $body.removeClass("loading");
            }
        });
    }

    function viewIssueHistory(id) {
        $body.addClass("loading");
        $('#showIssueNoForHistory').html(id);
        $.ajax({
            type: 'POST',
            url: "{{ route('issue.viewIssueHistoryPopup') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id: id, "_token": "{{ csrf_token() }}"},
            success: function (data) {
                $('.modal-body').html(data);
                $('#modal-issue-history').modal('show');
                $body.removeClass("loading");
            },
            error: function (data) {
                alert(data);
                $body.removeClass("loading");
            }
        });
    }

    getAllLots();

    function getAllLots() {
        const table = $('#table-devices').DataTable({
            order: [[0, 'desc']],
            processing: true,
            serverSide: true,
            paging: true,
            pageLength: 10,
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'pdf',
                    orientation: 'portrait', //landscape,portrait
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
                                        text: 'Lot Details',
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
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                }
            ],
            lengthMenu: [[10, 20, 100, 500000], [10, 20, 100, "All"]],
            "ajax": {
                "url": "{{ route('issue.listing') }}",
                "type": "POST",
                "headers": "{ 'X-CSRF-TOKEN': $('meta[name='csrf-token']').attr('content') }",
                "data": {
                    "party_name": $('#party_name').val(),
                    "inward_number": $('#inward_number').val(),
                    "fk_inward_id": $('#fk_inward_id').val(),
                    "startDate": $('#startDate').val(),
                    "endDate": $('#endDate').val(),
                    "statusType": "",
                    "user_id": $('#user_id').val(),
                    "action": $('#action').val(),
                    "_token": "{{ csrf_token() }}"
                },
            },
            bDestroy: true
        });
    }
</script>
@endsection
