@extends('layouts/layoutMaster')

@section('title', 'Production Menu')
@section('content')

  <div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="py-3 mb-4"><span class="text-muted fw-light">Production / {{ $processMaster->name }} / </span> Dashboard</h4>

      <!-- Block UI -->
      <div class="row">

        <!-- User Data -->
        <div class="col-xl-12 col-12">
          <div class="card mb-4" id="card-block">
            <h5 class="card-header">Department</h5>
            <div class="card-body">
              <div class="block-ui-btn demo-inline-spacing">
                @foreach(App\Models\Department::where("process_master_id",$id)->get() as $department)
                <div class="btn-group mb-2">
                  <button type="button" class="btn btn-label-primary dropdown-toggle"
                          data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="menu-icon tf-icons ti ti-truck"></i>{{ $department->name }}
                  </button>
                  <div class="dropdown-menu" style="">
                    <a class="dropdown-item" href="{{ route('pending-list-wise',$department->id) }}"><i
                        class="ti ti-pencil me-1"></i>
                      Create</a>
                    <a class="dropdown-item" href="{{route('pending-History')}}"><i
                        class="ti ti-eye me-1"></i>
                      View</a>
                  </div>
                </div>
                @endforeach

              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection
