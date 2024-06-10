@extends('layouts/layoutMaster')

@section('title', 'Process-Master')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection

@section('page-script')
    {{-- <script src="{{asset('assets/js/tables-datatables-basic.js')}}"></script> --}}
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Master / Process /</span> List
    </h4>

    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table" id="datatable-list">
                <thead>
                <tr>
                    <th>SR No.</th>
                    <th>Process Name</th>
                    <th>With</th>
                    <th>Departments</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @php  $num = 1 @endphp
                @foreach (\App\Models\ProcessMaster::with("Department")->get() as $Process)
                    <tr>
                        <td class="text-bold"><a href="">{{ $num }}</a></td>
                        <td>{{ $Process->name }}</td>
                        <td>{{ strtoupper($Process->type) }}</td>
                        <td width="350px">
                            @php
                                if(isset($Process->Department) && is_iterable($Process->Department)) {
                                   $htmlDetails = "";
                                  foreach ($Process->Department as $department) {
                                       $htmlDetails .= '<button type="button" class="m-2 btn btn-sm btn-outline-primary round waves-effect">'.$department->name.'</button>';
                                    }
                                  echo $htmlDetails;
                                }
                            @endphp
                        </td>
                        <td>
                            <a class="btn btn-icon btn-label-primary mx-2"
                               href="{{ route('process-master-edit', $Process->id) }}"><i
                                        class="ti ti-edit mx-2 ti-sm"></i></a>
                            <button type="button" class="btn btn-icon btn-label-danger mx-2"
                                    onclick="deleteProcess({{ $Process->id }})"><i
                                        class="ti ti-trash mx-2 ti-sm"></i></button>
                        </td>
                    </tr>
                    @php $num++ @endphp
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>
  function deleteProcess(ProcessId) {
    // var VendorName = document.getElementById('VendorName').value;
    // var VendorName = document.querySelector('#VendorName').value;
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: false,
      confirmButtonText: "Yes, Approve it!"
    }).then((result) => {
      if (result.isConfirmed) {
        $("#overlay").fadeIn(100);
        $.ajax({
          type: 'POST',
          url: '{{ route('process-master-delete') }}',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            processId: ProcessId,
            "_token": "{{ csrf_token() }}"
                    },
                    success: function(resultData) {
                        Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                            location.reload();
                            $("#overlay").fadeOut(100);
                        });
                    }
                });
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('#datatable-list').DataTable({
            order: [
                [0, 'desc']
            ],
        });
    });
</script>
