@extends('layouts.master')

@section('title', __('Without Scan'))

@section('content')
    <style>

    </style>
    {{-- Data list view starts --}}

        <form method="POST" id="" action="{{ route('issue.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card card-primary">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-10 col-xs-12">
                        <h3 class="card-title">
                            <a href="{{ route('issue.index') }}">
                                <button type="button"
                                        class="btn btn-default mr-4"><i
                                        class="fa fa-backward"></i>&nbsp;{{ __('Back') }}</button>
                            </a>{{__('filters')}}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-lg-3 col-md-6 col-sm-6">
                        <label for="input-number">{{__('Users')}}</label>
                        <select name="user_id" id="user_id"
                                class="form-control select2 employee-placeholder-multiple">
                            @hasanyrole('Manager|Super Admin|Account Assistant|Account')
                            @if(!empty($users))
                                <option selected value>{{__('-- Select Users --')}}</option>
                            @endif
                            @endhasanyrole();
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-3 col-md-6 col-sm-6">
                        <label>Enter Inward No</label>
                        <input type="text" class="form-control" autofocus name="fk_inward_id" id="fk_inward_id" required placeholder="Enter Inward No">
                    </div>

                </div>
                    <div class="form-group col-sm-2">
                        <button type="submit" class="btn btn-primary form-control" id="btnSubmit"><i class="fas fa-paper-plane"></i>&nbsp;{{__('Submit')}} </button>
                    </div>

            </div>
        </div>
    </form>

{{--    <form action="{{ route("chemicaltoday.storeWashingUseChemical") }}" method="POST">--}}
{{--        <div id="dataListWashing" class="card"></div>--}}
{{--    </form>--}}


@endsection


@section('scripts')
    <script type="text/javascript">

    </script>
@endsection
