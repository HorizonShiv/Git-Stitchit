@extends('layouts.master')

@section('title', __('Transfer'))

@section('content')
    {{-- Data list view starts --}}

    <div class="row">

        <form action="{{ route('issue.store') }}" method="POST">
            <div class="modal fade" id="modal-issue" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-light">
                        <div class="modal-header bg-primary">
                            <h4 class="modal-title">Transfer Process</h4>
                            <h4 class="modal-title ml-3">Inward No. : <span class="text-bold" id="showInwardNo"></span>
                            </h4>
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
        @endsection


        @section('scripts')
            <script type="text/javascript">
                var type = '<?php echo $type?>';
                var id = '<?php echo $id;?>';
                var uid = '<?php echo $uid;?>';
                if (type === 'receive') {
                    viewIssueReceive(id);
                    function viewIssueReceive(id) {
                        $body.addClass("loading");
                        $('#showIssueNoForReceive').html(id);
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('issue.viewIssueReceivePopup') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {id: id,uid: uid, "_token": "{{ csrf_token() }}"},
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
                }
            </script>
@endsection
