@extends('layouts.master')

@section('title', __('Lot'))

@section('content')
    @if(!empty($lot))
        <form method="post" action="{{ route('lots.update',$lot->id) }}">
            @csrf
            @method('PUT')
            <div class="card card-primary">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10 col-xs-12">
                            <h3 class="card-title"><a href="{{ route('lots.index') }}">
                                    <button type="button"
                                            class="btn btn-default mr-4"><i
                                            class="fa fa-backward"></i>&nbsp;{{ __('Back') }}</button>
                                </a>{{__('Update Lot Details')}}</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <div class="controls">
                                <label>Lot Date</label>
                                <input type="date" class="form-control" name="lotDate" value="{{ $lot->lotDate }}"
                                       placeholder="lot Date">
                            </div>
                        </div>

                        <div class="form-group col-sm-3">
                            <label>Inward Number</label>
                            <select class="form-control select2" name="lotInwardNumber" id="lotInwardNumber"
                                    onchange="getInwardDetails();" required @if($lot->isSampleLot == 1) disabled @endif>
                                <option selected disabled>Select Inward Number</option>
                                @if(!empty($inwards))
                                    @foreach($inwards as $inward)
                                        <option
                                            value="{{ $inward->id }}" <?php if ($lot->lotInwardNumber == $inward->id) {
                                            echo "Selected";
                                        }?> >{{ $inward->id }}- {{ ucfirst($inward->partyName) }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-sm-3">
                            <label>Lot Unit</label>
                            <select class="form-control select2-comapny" name="lotUnit"
                                    @if($lot->isSampleLot == 1) disabled @endif >
                                @if(!empty($companys))
                                    @foreach($companys as $company)
                                        <option value="{{ $company->id }}"
                                                @if(($lot->lotUnit == $company->id)) selected="selected" @endif>{{ $company->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-sm-3">
                            <div class="controls">
                                <label>Lot Number</label>
                                <input type="text" class="form-control" @if($lot->isSampleLot == 1) readonly
                                       @endif value="{{ $lot->lotNumber }}" name="lotNumber" id="lotNumber"
                                       placeholder="lot Number">
                            </div>
                        </div>

                        <div class="form-group col-sm-3">
                            <div class="controls">
                                <label>Party Name</label>
                                <input type="text" id="autocompleteparty" class="form-control"
                                       value="{{ $lot->lotParty }}" name="lotParty" placeholder="Party Name">
                                <div id="partyList"></div>
                            </div>
                        </div>

                        <div class="form-group col-sm-3">
                            <div class="controls">
                                <label>Brand</label>
                                <input type="text" class="form-control" value="{{ $lot->lotBrand }}" name="lotBrand"
                                       id="lotBrand" placeholder="lot Brand">
                            </div>
                        </div>


                        <div class="form-group col-sm-6">
                            <div class="controls">
                                <label>Style</label>
                                <select class="form-control style-select2-main" name="lotStyle" id="lotStyle" required
                                        onchange="fetchCreationCombo();">
                                    <option selected disabled>Select Creation Combo</option>
                                    @if(!empty($stylewisesAllData))
                                        @foreach($stylewisesAllData as $stylewisesSingleData)
                                            <option value="{{ $stylewisesSingleData->id }}"
                                                    @if(($lot->lotStyle == $stylewisesSingleData->id)) selected="selected" @endif>{{ $stylewisesSingleData->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div id="styleList"></div>
                            </div>
                        </div>

                        <div class="form-group col-sm-3">
                            <div class="controls">
                                <label>Total Pieces</label>
                                <input type="number" step="any" class="form-control" id="lotTotalPics" readonly
                                       value="{{ $lot->lotTotalPics }}" name="lotTotalPics" required
                                       placeholder="Total Pisces">
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class="controls">
                                <div class="radio">
                                    <label>Sample Lot</label>
                                    <div class="form-group form-control clearfix">
                                        <div class="icheck-primary d-inline" data-children-count="1">
                                            <input type="checkbox"
                                                   @if($lot->isSampleLot == 1 || $lot->isSampleLot == 0) disabled
                                                   @endif id="checkboxPrimary1" name="isSampleLot" value="1"
                                                   @if($lot->isSampleLot == 1) checked @endif>
                                            <label for="checkboxPrimary1">Sample
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-2">
                            <div class="controls">
                                <div class="radio">
                                    <label>Select Bundles</label>
                                    <span class="form-control"><input type="radio" disabled
                                                                      @if($lot->lotBundlesType == '50')checked
                                                                      @endif name="lotBundlesType" value="50">
           50</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class="controls">
                                <div class="radio">
                                    <label>&nbsp;</label>
                                    <span class="form-control"> <input type="radio" disabled
                                                                       @if($lot->lotBundlesType == '10') checked
                                                                       @endif name="lotBundlesType" value="10">
          10</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-2">
                            <div class="controls">
                                <label>Total Bundles</label>
                                <input type="text" readonly class="form-control" readonly
                                       value="{{ $lot->lotTotalBundles }}" name="lotTotalBundles" id="lotTotalBundles"
                                       required
                                       placeholder="Total Bundles">
                            </div>
                        </div>

                        <div class="form-group col-sm-3">
                            <label>Users</label>

                            <select class="form-control select2" name="user_id" id="user_id" required>
                                <option value="">Select User</option>
                                @if(!empty($users))
                                    @foreach($users as $user)
                                        <option @if(($lot->user_id == $user->id)) selected="selected" @endif value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-sm-3">
                            <label>Total Bundles</label>
                            <textarea class="form-control" name="remark" id="remark" required
                                      placeholder="Remark">{{ $lot->remark }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-primary">
                <div class="card-header button_fixed_avadat">
                    <div class="row">
                        <div class="col-md-10 col-xs-12">
                            <h3 class="card-title">{{__('You can add more Operations here')}}</h3>
                        </div>
                        <div class="col-md-2 col-xs-12">
                            <button type="button" id="actionADD" onclick="addOperationOptionValue();"
                                    title="Add Option Value" class="btn btn-block btn-default"><i
                                    class="fa fa-plus-circle"></i> ADD Opeartions
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <table id="option-value" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td class="required">Operation Short Code</td>
                                    <td>Operation Description</td>
                                    <td>Operation Rate</td>
                                    <td>Operation Group</td>
                                    <td>Action</td>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <?php
                                $check_num = 0;
                                foreach ($lotoperations as $lotoperation) {
                                    $html = '<tr id="option-value-row' . $check_num . '">';
                                    $html .= '<input type="hidden" name="option_value[' . $check_num . '][lot_operation_id]" value="' . $lotoperation->id . '" />';
                                    $html .= '  <td width="300"><input type="hidden" name="option_value[' . $check_num . '][option_value_id]" value="" />';
                                    $html .= '    <div class="input-group">';
                                    $html .= '      <select name="option_value[' . $check_num . '][operation]" onchange="fetchOperationsDetails(' . $check_num . ');" id="select-operation' . $check_num . '" class="form-control select2" required />';
                                    $html .= '    <option value="' . $lotoperation->fk_operation_id . '" selected>' . $lotoperation->shortCode . '</option>';
                                    foreach ($operations as $operation) {
                                        $html .= '    <option value="' . $operation->id . '">' . $operation->shortCode . '</option>';
                                    }
                                    $html .= '      </select>';
                                    $html .= '    </div>';
                                    $html .= '  </td>';
                                    $html .= '  <td>';
                                    $html .= '    <div class="input-group">';
                                    $html .= '      <input type="text" readonly name="option_value[' . $check_num . '][operation_description]" value="' . $lotoperation['description'] . '" id="get-operation-description' . $check_num . '" placeholder="Operation Description" class="form-control" />';
                                    $html .= '    </div>';
                                    $html .= '  </td>';
                                    $html .= '  <td>';
                                    $html .= '    <div class="input-group">';
                                    $html .= '      <input type="text" readonly name="option_value[' . $check_num . '][operation_rate]" id="get-operation-rate' . $check_num . '" placeholder="Operation Rate" value="' . $lotoperation['rate'] . '" class="form-control" required />';
                                    $html .= '    </div>';
                                    $html .= '  </td>';
                                    $html .= '  <td class="text-right"><input readonly type="text" name="option_value[' . $check_num . '][operation_group]" id="get-operation-group' . $check_num . '" placeholder="Operation Group" value="' . $lotoperation['groupName'] . '" class="form-control" /></td>';
                                    $html .= '<input readonly type="hidden" name="option_value[' . $check_num . '][operation_group_id]" id="get-operation-group-id' . $check_num . '" value="' . $lotoperation['operationGroup'] . '" class="form-control" /></td>';
                                    $html .= '  <td class="text-right"><button type="button" data-id="' . $lotoperation->id . '" title="Remove" class="btn btn-danger button-delete-lotoperation"><i class="fa fa-minus-circle"></i></button></td>';
                                    $html .= '</tr>';
                                    echo $html;
                                    $check_num++;
                                }
                                ?>
                                <input type="hidden" name="option_count" id="option_count" value="{{ $check_num }}"/>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i
                            class="fas fa-paper-plane"></i>&nbsp;{{__('Submit')}}
                    </button>
                </div>
            </div>
        </form>
    @endif

@endsection

@section('scripts')
    <script type="text/javascript">
        $(".style-select2-main").select2();
        // On Delete
        $('.button-delete-lotoperation').on("click", function (e) {
            e.stopPropagation();
            var delete_id = $(this).data('id');
            let removeFiled = $(this);
            deleteButton(delete_id, 'lotOperationDelete', 'Lot Operation has been deleted!', removeFiled);
        });

        $(".select2-comapny").select2({
            placeholder: "Select a Company",
            allowClear: true
        });


        function afterSampleApproveOperations(id) {
            //$body.addClass("loading");
            $.ajax({
                type: 'POST',
                url: '{{ route('lots.getSampleOperations') }}',
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {id: id, "_token": "{{ csrf_token() }}"},
                success: function (data) {
                    var i = 0;
                    $.each(data, function (item, value) {
                        if (i === 0) {
                            $('#option-value tbody').append(value);
                        } else if (i === 1) {
                            $('#thisPageCount').val(value)
                        }
                        i++;
                        $body.removeClass("loading");

                    });
                },
                error: function (data) {
                    alert(data);
                }
            });
        }

        //inward number fetch
        function getInwardDetails() {
            //$body.addClass("loading");
            var inward_id = $('#lotInwardNumber').val();
            $.ajax({
                type: 'POST',
                //url: '/washing/getInwardDetails/'+inward_id,
                url: '{{ route('lots.getInwardDetails') }}',
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {id: inward_id, "_token": "{{ csrf_token() }}"},
                success: function (data) {
                    if (data.showResult === 2) {
                        Swal.fire('Sample Approved!', 'Now work on remaining Product', 'success');
                        $("#checkboxPrimary1").prop("disabled", true);
                        $("#checkboxPrimary1").prop("checked", false);
                        $("#btn_lot").prop("disabled", false);
                        afterSampleApproveOperations(data.lot_id);
                        $body.removeClass("loading");
                    } else {
                        $("#checkboxPrimary1").prop("disabled", false);
                        $("#btn_lot").prop("disabled", true);
                        $('#option-value tbody').empty();
                        $body.removeClass("loading");
                    }
                    $("#autocompleteparty").val(data['partyName']); // The first name
                    $("#lotNumber").val(data['lotNumber']); // The first name
                    $("#lotBrand").val(data['brand']); // The first name
                    $("#lotTotalPics").val(data['totalPics'] - data['sampleTotalPics']); // The first name
                    $("#companyID").append('<option value="' + data['fk_company_id'] + '" selected>' + data['companyName'] + '</option>');
                    $body.removeClass("loading");
                },
                error: function (data) {
                    alert(data);
                }
            });

        }

        //Operation Option
        function addOperationOptionValue() {

            option_value_row = document.getElementById('option_count').value;
            html = '<tr id="option-value-row' + option_value_row + '">';
            html += '  <td width="300"><input type="hidden" name="option_value[' + option_value_row + '][option_value_id]" value="" />';
            html += '    <div class="input-group">';
            html += '      <select name="option_value[' + option_value_row + '][operation]" onchange="fetchOperationsDetails(' + option_value_row + ');" id="select-operation' + option_value_row + '" class="form-control operation-select2" required />';
            html += '      <option disabled selected value>Select Operation</option>';
            <?php foreach ($operations as $operation){?>
                html += '    <option value="{{ $operation->id }}">{{ $operation->shortCode }}</option>';
            <?php }?>
                html += '      </select>';
            html += '    </div>';
            html += '  </td>';
            html += '  <td>';
            html += '    <div class="input-group">';
            html += '      <input type="text" readonly name="option_value[' + option_value_row + '][operation_description]" id="get-operation-description' + option_value_row + '" placeholder="Operation Description" class="form-control" />';
            html += '    </div>';
            html += '  </td>';
            html += '  <td>';
            html += '    <div class="input-group">';
            html += '      <input type="text" readonly name="option_value[' + option_value_row + '][operation_rate]" id="get-operation-rate' + option_value_row + '" placeholder="Operation Rate" class="form-control" required />';
            html += '    </div>';
            html += '  </td>';
            //html += '  <td class="text-center"><div class="avatar-upload"><div class="avatar-edit"><input type="file" name="option_value[' + option_value_row + '][image]"  id="imageUploadNew'+ option_value_row +'" onchange="return fileValidationNew(' + option_value_row + ')" required><label for="imageUploadNew'+ option_value_row +'"></label></div><div class="avatar-preview"><div id="imagePreviewNew'+ option_value_row +'" style="background-image:url({{url('category')}}/no_image.jpg);"></div></div></div></td>';
            html += '  <td class="text-right"><input readonly type="text" name="option_value[' + option_value_row + '][operation_group]" id="get-operation-group' + option_value_row + '" placeholder="Operation Group" class="form-control" /></td>';
            html += '<input readonly type="hidden" name="option_value[' + option_value_row + '][operation_group_id]" id="get-operation-group-id' + option_value_row + '" class="form-control" />';
            html += '  <td class="text-right"><button type="button" onclick="$(\'#option-value-row' + option_value_row + '\').remove();" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#option-value tbody').append(html);
            $(".operation-select2").select2();
            option_value_row++;

            document.getElementById('option_count').value = option_value_row;
        }

        function getbundles() {
            var result = "";
            var bundletype = $("input[name='lotBundlesType']:checked").val();
            var lotTotalPics = $("#lotTotalPics").val();
            if (bundletype) {
                result = parseInt(lotTotalPics, 10) / parseInt(bundletype, 10);
                $("#lotTotalBundles").val(result);
            } else {
                alert('select bundle type');
            }
        }

        function fetchOperationsDetails(id) {
            //$body.addClass("loading");
            var operation_id = document.getElementById('select-operation' + id).value;
            var class_id = id;

            $.ajax({
                type: 'POST',
                url: '{{ route('operations.getOperationDetails') }}',
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {id: operation_id, "_token": "{{ csrf_token() }}"},
                success: function (data) {
                    $("#get-operation-description" + class_id).val(data['description']); // The first name
                    $("#get-operation-rate" + class_id).val(data['rate']); // The first name
                    $("#get-operation-group" + class_id).val(data['groupName']); // The first name
                    $("#get-operation-group-id" + class_id).val(data['operationGroup']); // The first name
                    $body.removeClass("loading");
                },
                error: function (data) {
                    alert(data);
                }
            });
        }

        //Operation comboo fetch
        function fetchCreationCombo() {
            //$body.addClass("loading");
            var id = document.getElementById('lotStyle').value;
            $.ajax({
                type: 'POST',
                url: '{{route('lots.creationCombo')}}',
                dataType: 'JSON',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {id: id, counter: $('#option_count').val(), "_token": "{{ csrf_token() }}"},
                success: function (data) {
                    var i = 0;
                    $.each(data, function (item, value) {
                        if (i === 0) {
                            $('#option-value tbody').append(value);
                        } else if (i === 1) {
                            $('#thisPageCount').val(value)
                        }
                        i++;
                        $body.removeClass("loading");
                        $(".style-select2").select2();
                    });
                    //var newdata =  $('#option_count').val();
                    //$('#thisPageCount').val(newdata);
                },
                error: function (data) {
                    alert(data);
                }
            });
        }


        $(document).ready(function () {

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

        //fetch style
        $(function () {
            var availableTags = <?= json_encode($stylewisesData) ?>;
            $("#autocompletestyle").autocomplete({
                source: availableTags
            });
        });

        // fetch party
        $(function () {
            var availableTags = <?= json_encode($partieData) ?>;
            $("#autocompleteparty").autocomplete({
                source: availableTags
            });
        });
    </script>
@endsection

