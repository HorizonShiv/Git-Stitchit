@extends('layouts.master')

@section('title', __('Issue Manage'))

@section('content')
    <div class="preloader"></div>

    <form method="POST" action="{{ route('issue.store') }}">
        @csrf
        <div class="card card-primary">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-10 col-xs-12">
                        <h3 class="card-title"><a href="{{ route('issue.index') }}">
                                <button type="button"
                                        class="btn btn-default mr-4"><i
                                        class="fa fa-backward"></i>&nbsp;{{ __('Back') }}</button>
                            </a>{{__('Transfer')}}</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label>Inward Numbers</label>
                        <select class="form-control select2" name="fk_inward_id" id="fk_inward_id"
                                onchange="getInwardDetails();" required>
                            <option readonly>Select Inward Number</option>
                            @if(!empty($inwards))
                                @foreach($inwards as $inward)
                                    <option value="{{ $inward->id }}">{{ $inward->id }}
                                        - {{ ucfirst($inward->partyName) }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label>Total Pieces</label>
                        <input type="number" class="form-control" value="{{ old('qty') }}" id="qty"
                               name="qty" required
                               placeholder="Qty">
                    </div>


                    <div class="form-group col-sm-3">
                        <label>Issue To</label>
                        <select class="form-control select2" name="issueTo" id="issueTo" required>
                            <option value="">Select Issue To</option>
                            @if(!empty($departments))
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label>Issue From</label>
                        <select class="form-control select2" name="issueFrom" id="issueFrom" required>
                            <option value="">Select Issue From</option>
                            @if(!empty($departments))
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label>User To</label>
                        <select class="form-control select2" name="userTo" id="userTo" required>
                            <option value="">Select User To</option>
                            @if(!empty($users))
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" id="btn_issue" class="btn btn-primary"><i class="fas fa-paper-plane"></i>&nbsp;{{__('Submit')}}
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">

        $(".style-select2-main").select2();

        $("#checkboxPrimary1").change(function () {
            if (this.checked) {
                var TotalPics = '5';
                $("#lotTotalPics").val(TotalPics);
                getbundles();
                $("#btn_lot").prop("disabled", false);
            } else {
                $("#lotTotalPics").val();
            }
        });

        $('#datepicker').datepicker();

        function getInwardDetails() {
            $body.addClass("loading");
            var inward_id = $('#fk_inward_id').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('issue.getInwardDetails') }}',
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {id: inward_id, "_token": "{{ csrf_token() }}"},
                success: function (data) {
                    $("#qty").val(data.remainingQty);
                    $body.removeClass("loading");
                },
                error: function (data) {
                    alert(data);
                    $body.removeClass("loading");
                }
            });
        }

        $(document).ready(function () {
            $('.preloader').fadeOut(2000);
            $(function () {
                var today = new Date().toISOString().split('T')[0];
                document.getElementsByName("lotDate")[0].setAttribute('max', today);
            });

            $("input[type='radio']").click(function () {
                getbundles();
            });


            $("#lotTotalPics").keyup(function () {
                var bundletype = $("input[name='lotBundlesType']:checked").val();
                if (bundletype) {
                    getbundles();
                }
            });

            $('#select-operation').select2({
                placeholder: 'Select Operation',
                allowClear: true
            });
        });
    </script>
@endsection
