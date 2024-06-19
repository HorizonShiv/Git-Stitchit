@extends('layouts/layoutMaster')

@section('title', 'Add - GRN')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

@section('page-script')
    {{-- <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/app-grn-add.js') }}"></script> --}}
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
    <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left">Packaging /</span> Add
    </h4>


    <div class="row invoice-add">
        <!-- Invoice Add-->
        <div class="col-lg-12 col-12 mb-lg-0 mb-4">
            <div class="card invoice-preview-card">

                <div class="card-body">
                    <div class="users-list-filter">

                        <div class="row">
                            <div class="col-12 col-sm-3 col-lg-3">
                                <label for="users-list-status">Date</label>
                                <fieldset class="form-group">
                                    <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" name="date"
                                        id="date" required>
                                </fieldset>
                            </div>
                            <div class="col-12 col-sm-3 col-lg-3">
                                <label class="form-label" for="Customer">Select Customer</label>
                                <select required id="Customer" name="Customer" class="select2 select21 form-select"
                                    data-allow-clear="true" onchange="getStylePackagingData();"
                                    data-placeholder="Select Customer">
                                    <option value="" selected></option>

                                    @foreach (\App\Models\Customer::all() as $data)
                                        <option value="{{ $data->id }}">{{ $data->company_name }} -
                                            {{ $data->buyer_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-3 col-lg-3">
                                <label for="styleNo">Style No</label>
                                <fieldset class="form-group">
                                    <select class="form-control select2" name="styleNo" id="styleNo"
                                        onchange="getColorPackagingData()" data-placeholder="Select Style Number">


                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-12 col-sm-3 col-lg-3">
                                <label for="color">Color</label>
                                <fieldset class="form-group">
                                    <select class="form-control select2" name="color" id="color"
                                        onchange="getSizeWiseDataPackaging()" data-placeholder="Select Color">

                                    </select>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div id="SizeWiseData">

                            </div>
                        </div>



                        <div class="col-12 mt-3">
                            <div class="mb-3">
                                <label for="note">Remark:</label>
                                <textarea class="form-control" rows="2" id="remark" name="remark" placeholder="remark"></textarea>
                            </div>
                        </div>
                        <div class="row px-0 mt-3">
                            <div class="col-lg-2 col-md-12 col-sm-12">
                                <button type="submit" class="btn btn-primary d-grid w-100">Save</button>
                            </div>
                            <div class="col-lg-2 col-md-12 col-sm-12">
                                <button type="submit" name="AddMore" value="1"
                                    class="btn btn-label-primary waves-effect d-grid w-100">Save & Add more</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Invoice Add-->
        </div>
        </form>

        <!-- Offcanvas -->
        @include('_partials/_offcanvas/offcanvas-send-invoice')
        <!-- /Offcanvas -->
    @endsection


    <script>
        function getStylePackagingData() {

            var customerId = document.getElementById('Customer').value;
            if (customerId) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('getStylePackaging') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#styleNo').empty();
                        $('#styleNo').append('<option value=""> Select Style</option>');
                        $.each(response, function(key, value) {
                            $('#styleNo').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                        // getColorPackagingData();
                    }
                });
            } else {
                $('#styleNo').empty();
            }
        }

        function getColorPackagingData() {
            var styleNo = document.getElementById('styleNo').value;
            if (styleNo) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('getColorPackaging') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#color').empty();
                        $('#color').append('<option value=""> Select Color</option>');
                        $.each(response, function(key, value) {
                            $('#color').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#color').empty();
            }
        }

        function getSizeWiseDataPackaging() {
            var styleNo = document.getElementById('styleNo').value;
            var color = document.getElementById('color').value;

            $.ajax({
                type: 'POST',
                url: "{{ route('getSizeWiseDataPackaging') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    color: color,
                    styleNo: styleNo,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(response) {
                    $('#SizeWiseData').empty();
                    $('#SizeWiseData').append(response.html);
                }
            });
        }

        function AddRow() {
            var tableBody = document.querySelector('#SizeRatios tbody');

            // Clone the last filled row
            var lastFilledRow = tableBody.querySelector('.filledRow:last-child');
            var newRow = lastFilledRow.cloneNode(true);

            // Increment input names and IDs to ensure uniqueness
            var newInputs = newRow.querySelectorAll('input');
            newInputs.forEach(function(input) {
                var name = input.name;
                var newName = name.replace(/\[(\d+)\]/, function(match, p1) {
                    return `[${parseInt(p1) + 1}]`;
                });
                input.name = newName;
                input.value = 0; // Reset value to 0
            });
            // $('#TotalColorRED').empty();

            // Append the new row to the table body
            tableBody.appendChild(newRow);

            document.getElementById('date').setAttribute('readonly', true);
            document.getElementById('Customer').setAttribute('disabled', true);
            document.getElementById('styleNo').setAttribute('disabled', true);
            document.getElementById('color').setAttribute('disabled', true);

        }

        function removeRow() {
            var tableBody = document.querySelector('#SizeRatios tbody');

            // Get all filled rows
            var filledRows = tableBody.querySelectorAll('.filledRow');

            // Remove the last filled row if there is more than one
            if (filledRows.length > 1) {
                tableBody.removeChild(filledRows[filledRows.length - 1]);
            }

            if (filledRows.length === 2) { // This accounts for the row that was just removed
                document.getElementById('date').removeAttribute('readonly');
                document.getElementById('Customer').removeAttribute('disabled');
                document.getElementById('styleNo').removeAttribute('disabled');
                document.getElementById('color').removeAttribute('disabled');
            }

        }
    </script>
