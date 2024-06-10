@extends('layouts/layoutMaster')

@section('title', 'QC List')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}"/>
@endsection

@section('vendor-script')
  <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>

@endsection

@section('page-script')
  <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
  <script src="{{ asset('assets/js/app-invoice-list.js') }}"></script>
  <script src="{{ asset('assets/js/app-invoice-add.js') }}"></script>
@endsection

@section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light float-left">Order Confirmation /</span> Add
  </h4>
  <!-- Invoice List Widget -->
  <div class="row">
    <div class="col-12">


      <div class="card">
        {{-- <h5 class="card-header">Applicable Categories</h5> --}}
        <div class="card-body">
          <form method="post" action="{{ route('app-company-store') }}" enctype="multipart/form-data">
            @csrf

            <div class="card-body">
              <div class="content">


                <div class="content-header mb-4">
                  <h3 class="mb-1">Order Information</h3>
                </div>

                <div class="row g-3">
                  <div class="col-md-3">
                    <label class="form-label" for="c_name">LOT Dev</label>
                    <input required type="text" id="c_name" name="c_name" class="form-control"
                           placeholder="LOT Dev" readonly=""/>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label" for="b_name">Style</label>
                    <input type="text" id="pancard_gst_no" name="pancard_gst_no" class="form-control"
                           placeholder="Style Type"/>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label" for="b_name">Buyer</label>
                    <input type="text" id="pancard_gst_no" name="pancard_gst_no" class="form-control"
                           placeholder="Buyer Name"/>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label" for="b_name">Brand</label>
                    <input type="text" id="pancard_gst_no" name="pancard_gst_no" class="form-control"
                           placeholder="Brand Name"/>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label" for="b_name">Season</label>
                    <input type="text" id="pancard_gst_no" name="pancard_gst_no" class="form-control"
                           placeholder="Season Name"/>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label" for="b_state">Demographic</label>
                    <select required id="b_state" name="b_state" class="select2 form-select"
                            data-allow-clear="true">
                      <option value="">Select</option>
                      <option value="Andra Pradesh">Andra Pradesh</option>
                      <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                    </select>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label" for="b_state">Garment Tyep</label>
                    <select required id="b_state" name="b_state" class="select2 form-select"
                            data-allow-clear="true">
                      <option value="">Select</option>
                      <option value="Andra Pradesh">Andra Pradesh</option>
                      <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                    </select>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label" for="b_name">Ship Date</label>
                    <input type="date" class="form-control date-picker" id="ship_date"
                           name="ship_date" placeholder="YYYY-MM-DD"/>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label" for="b_name">Designer</label>
                    <input type="text" id="pancard_gst_no" name="pancard_gst_no" class="form-control"
                           placeholder="Designer Name"/>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label" for="b_name">Merchat (optional)</label>
                    <input type="text" id="pancard_gst_no" name="pancard_gst_no"
                           class="form-control" placeholder="Merchat Name"/>
                  </div>

                  <div class="col-md-4">
                    <label class="form-label" for="b_name">Sample</label>
                    <input type="file" id="pancard_gst_file" name="Sample" class="form-control"
                           placeholder="Pan Card / Gst No Name"/>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label" for="b_name">Marker</label>
                    <input type="file" id="pancard_gst_file" name="Marker" class="form-control"
                           placeholder="Marker"/>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label" for="b_name">Printing</label>
                    <input type="file" id="pancard_gst_file" name="Printing" class="form-control"
                           placeholder="Printing"/>
                  </div>
                  <div class="col-md-3">
                    <label class="form-label" for="b_name">Order Quntity</label>
                    <input type="text" id="pancard_gst_no" name="pancard_gst_no"
                           class="form-control" placeholder="Designer Name"/>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label" for="b_name">Extra %</label>
                    <input type="text" id="pancard_gst_no" name="pancard_gst_no"
                           class="form-control" placeholder="Designer Name"/>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label" for="b_state">Order Price</label>
                    <input type="text" id="pancard_gst_no" name="pancard_gst_no"
                           class="form-control" placeholder="Season Name"/>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label" for="b_name">Marker Average</label>
                    <input type="text" id="pancard_gst_no" name="pancard_gst_no"
                           class="form-control" placeholder="Designer Name"/>
                  </div>


                </div>
              </div>


              <div class="col-lg-3 col-12 invoice-actions mt-5">
                <button type="submit" class="btn btn-primary d-grid w-100">Save</button>

              </div>


              <p class="card-text mt-5">Applicable Categories</p>


              <p class="demo-inline-spacing">
                {{-- <a class="btn btn-primary me-1" data-bs-toggle="collapse" href="#multiCollapseExample1"
            role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Toggle first
            element</a> --}}
                <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse"
                        data-bs-target="#SizeRatios" aria-expanded="false" aria-controls="SizeRatios">
                  Size Ratios Form
                </button>
                <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse"
                        data-bs-target="#Threads" aria-expanded="false" aria-controls="Threads">
                  Threads Form
                </button>
                <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse"
                        data-bs-target="#Fabric" aria-expanded="false" aria-controls="Fabric">
                  Fabric Form
                </button>
                <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse"
                        data-bs-target="#Zipper" aria-expanded="false" aria-controls="Zipper">
                  Zipper Form
                </button>
                <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse"
                        data-bs-target="#Buttons" aria-expanded="false" aria-controls="Buttons">
                  Button Form
                </button>
                <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse"
                        data-bs-target="#Label" aria-expanded="false" aria-controls="Label">
                  Label Form
                </button>

                <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse"
                        data-bs-target="#Polybag" aria-expanded="false" aria-controls="Polybag">
                  Polybag Form
                </button>

                <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse"
                        data-bs-target="#Carton" aria-expanded="false" aria-controls="Carton">
                  Carton Form
                </button>

                <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse"
                        data-bs-target="#Elastic" aria-expanded="false" aria-controls="Elastic">
                  Elastic Form
                </button>
                {{-- <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse"
                    data-bs-target="#Tag" aria-expanded="false" aria-controls="Tag">
                    Tag Form
                </button> --}}
                <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse"
                        data-bs-target=".multi-collapse" aria-expanded="false"
                        aria-controls="Style SizeRatios Threads Fabric Button Label">
                  Show All
                </button>
              </p>

              <div class="row">

                <div class="col-12 col-md-12 mt-2 mb-2">
                  <div class="collapse multi-collapse" id="SizeRatios">
                    <div class="content-header mt-3 mb-3">
                      <h3 class="mb-1">Size Ratios Information</h3>
                    </div>
                    <div class="row g-3">
                      <div class="col-md-12">
                        <table class="table table-responsive mb-0 dataTable" id="SizeRatios"
                               role="grid">
                          <thead>
                          <tr role="row">

                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 92.4px;">
                              <input type="text"
                                     class="form-control font-weight-bold" name="pcs1[]"
                                     readonly="" value="Size">
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1"
                                colspan="1" style="width: 92.4px;"><input
                                type="text" class="form-control font-weight-bold"
                                name="pcs1[]" readonly="" value="Order Share">
                            </th>

                            <th scope="col" class="sorting_disabled" rowspan="1"
                                colspan="1" style="width: 92.4px;"><input
                                type="text" class="form-control font-weight-bold"
                                name="pcs1[]" readonly=""
                                value="Final Qty (Planned)">
                            </th>
                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 92.4px;">
                              <input type="text"
                                     class="form-control font-weight-bold" name="pcs1[]"
                                     readonly="" value="Ratio">
                            </th>
                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 20px;">
                            </th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr role="row" class="odd">

                            <td><input type="number" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td><input type="number" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td><input type="number" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td><input type="number" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td></td>
                          </tr>
                          </tbody>
                          <tfoot>
                          <tr role="row" class="odd">

                            <td><input type="text"
                                       class="form-control font-weight-bold" name="pcs1[]"
                                       readonly="" value="Total"></td>
                            <td><input type="text"
                                       class="form-control font-weight-bold" name="pcs1[]"
                                       readonly=""></td>
                            <td><input type="text"
                                       class="form-control font-weight-bold" name="pcs1[]"
                                       readonly=""></td>
                            <td><input type="text"
                                       class="form-control font-weight-bold" name="pcs1[]"
                                       readonly=""></td>
                            <td></td>
                          </tr>
                          </tfoot>
                        </table>
                      </div>
                      <div class="row pb-4">
                        <div class="col-12">

                          <button type="button" class="btn btn-primary"
                                  onclick="addItem('SizeRatios')" data-repeater-create>Add
                            Item
                          </button>
                          <button type="button" class="btn btn-danger"
                                  onclick="removeItem('SizeRatios')">Remove Last Item
                          </button>
                        </div>
                      </div>

                    </div>
                    <hr>
                  </div>
                </div>

                <div class="col-12 col-md-12 mt-2 mb-2">
                  <div class="collapse multi-collapse" id="Threads">
                    <div class="content-header mt-3 mb-3">
                      <h3 class="mb-1">Threads Information</h3>
                    </div>
                    <div class="row g-3">
                      <div class="col-md-12">
                        <table class="table table-responsive mb-0 dataTable" id="Threads"
                               role="grid">
                          <thead>
                          <tr role="row">

                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 92.4px;">
                              <input type="text"
                                     class="form-control font-weight-bold" name="pcs1[]"
                                     readonly="" value="Threads Items">
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1"
                                colspan="1" style="width: 92.4px;"><input
                                type="text" class="form-control font-weight-bold"
                                name="" readonly="" value="Threads Qty">
                            </th>
                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 20px;">
                            </th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr role="row" class="odd">

                            <td><input type="text" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td><input type="number" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td></td>
                          </tr>
                          </tbody>
                          <tfoot>
                          <tr role="row" class="odd">

                            <td><input type="text"
                                       class="form-control font-weight-bold" name="pcs1[]"
                                       readonly="" value="Total"></td>
                            <td><input type="text"
                                       class="form-control font-weight-bold" name="pcs1[]"
                                       readonly=""></td>
                            <td></td>
                          </tr>
                          </tfoot>
                        </table>
                      </div>
                      <div class="row pb-4">
                        <div class="col-12">

                          <button type="button" class="btn btn-primary"
                                  onclick="addItem('Threads')" data-repeater-create>Add Item
                          </button>
                          <button type="button" class="btn btn-danger"
                                  onclick="removeItem('Threads')">Remove Last Item
                          </button>
                        </div>
                      </div>

                    </div>
                    <hr>
                  </div>
                </div>

                <div class="col-12 col-md-12 mt-2 mb-2">
                  <div class="collapse multi-collapse" id="Fabric">
                    <div class="content-header mt-3 mb-3">
                      <h3 class="mb-1">Fabric Information</h3>
                    </div>
                    <div class="row g-3">
                      <div class="col-md-12">
                        <table class="table table-responsive mb-0 dataTable" id="Fabric"
                               role="grid">
                          <thead>
                          <tr role="row">

                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 92.4px;">
                              <input type="text"
                                     class="form-control font-weight-bold" name="pcs1[]"
                                     readonly="" value="Fabric Items">
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1"
                                colspan="1" style="width: 92.4px;"><input
                                type="text" class="form-control font-weight-bold"
                                name="" readonly="" value="Fabric Qty">
                            </th>
                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 20px;">
                            </th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr role="row" class="odd">

                            <td><input type="text" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td><input type="number" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td></td>
                          </tr>
                          </tbody>
                          <tfoot>
                          <tr role="row" class="odd">

                            <td><input type="text"
                                       class="form-control font-weight-bold" name="pcs1[]"
                                       readonly="" value="Total"></td>
                            <td><input type="text"
                                       class="form-control font-weight-bold" name="pcs1[]"
                                       readonly=""></td>
                            <td></td>
                          </tr>
                          </tfoot>
                        </table>
                      </div>
                      <div class="row pb-4">
                        <div class="col-12">

                          <button type="button" class="btn btn-primary"
                                  onclick="addItem('Fabric')" data-repeater-create>Add Item
                          </button>
                          <button type="button" class="btn btn-danger"
                                  onclick="removeItem('Fabric')">Remove Last Item
                          </button>
                        </div>
                      </div>

                    </div>
                    <hr>
                  </div>
                </div>

                <div class="col-12 col-md-12 mt-2 mb-2">
                  <div class="collapse multi-collapse" id="Buttons">
                    <div class="content-header mt-3 mb-3">
                      <h3 class="mb-1">Button Information</h3>
                    </div>
                    <div class="row g-3">
                      <div class="col-md-12">
                        <table class="table table-responsive mb-0 dataTable" id="Buttons"
                               role="grid">
                          <thead>
                          <tr role="row">

                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 92.4px;">
                              <input type="text"
                                     class="form-control font-weight-bold" name="pcs1[]"
                                     readonly="" value="Button Items">
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1"
                                colspan="1" style="width: 92.4px;"><input
                                type="text" class="form-control font-weight-bold"
                                name="" readonly="" value="Qty">
                            </th>
                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 20px;">
                            </th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr role="row" class="odd">

                            <td><input type="text" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td><input type="number" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td></td>
                          </tr>
                          </tbody>

                        </table>
                      </div>
                      {{-- <div class="row pb-4">
                          <div class="col-12">

                              <button type="button" class="btn btn-primary"
                                  onclick="addItem('Buttons')" data-repeater-create>Add Item</button>
                              <button type="button" class="btn btn-danger"
                                  onclick="removeItem('Buttons')">Remove Last Item</button>
                          </div>
                      </div> --}}

                    </div>
                    {{-- <hr> --}}
                  </div>
                </div>

                <div class="col-12 col-md-12 mt-2 mb-2">
                  <div class="collapse multi-collapse" id="Label">
                    <div class="content-header mt-3 mb-3">
                      <h3 class="mb-1">Label Information</h3>
                    </div>
                    <div class="row g-3">
                      <div class="col-md-12">
                        <table class="table table-responsive mb-0 dataTable" id="Label"
                               role="grid">
                          <thead>
                          <tr role="row">

                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 92.4px;">
                              <input type="text"
                                     class="form-control font-weight-bold" name="pcs1[]"
                                     readonly="" value="Label Items">
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1"
                                colspan="1" style="width: 92.4px;"><input
                                type="text" class="form-control font-weight-bold"
                                name="" readonly="" value="Qty">
                            </th>
                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 20px;">
                            </th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr role="row" class="odd">

                            <td><input type="text" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td><input type="number" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td></td>
                          </tr>
                          </tbody>
                          {{-- <tfoot>
                              <tr role="row" class="odd">

                                  <td><input type="text"
                                          class="form-control font-weight-bold" name="pcs1[]"
                                          readonly="" value="Total"></td>
                                  <td><input type="text"
                                          class="form-control font-weight-bold" name="pcs1[]"
                                          readonly=""></td>
                                  <td></td>
                              </tr>
                          </tfoot> --}}
                        </table>
                      </div>
                      {{-- <div class="row pb-4">
                          <div class="col-12">

                              <button type="button" class="btn btn-primary"
                                  onclick="addItem('Label')" data-repeater-create>Add Item</button>
                              <button type="button" class="btn btn-danger"
                                  onclick="removeItem('Label')">Remove Last Item</button>
                          </div>
                      </div> --}}

                    </div>
                    {{-- <hr> --}}
                  </div>
                </div>

                <div class="col-12 col-md-12 mt-2 mb-2">
                  <div class="collapse multi-collapse" id="Polybag">
                    <div class="content-header mt-3 mb-3">
                      <h3 class="mb-1">Polybag Information</h3>
                    </div>
                    <div class="row g-3">
                      <div class="col-md-12">
                        <table class="table table-responsive mb-0 dataTable" id="Polybag"
                               role="grid">
                          <thead>
                          <tr role="row">

                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 92.4px;">
                              <input type="text"
                                     class="form-control font-weight-bold" name="pcs1[]"
                                     readonly="" value="Polybag Items">
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1"
                                colspan="1" style="width: 92.4px;"><input
                                type="text" class="form-control font-weight-bold"
                                name="" readonly="" value="Qty">
                            </th>
                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 20px;">
                            </th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr role="row" class="odd">

                            <td><input type="text" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td><input type="number" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td></td>
                          </tr>
                          </tbody>
                          {{-- <tfoot>
                              <tr role="row" class="odd">

                                  <td><input type="text"
                                          class="form-control font-weight-bold" name="pcs1[]"
                                          readonly="" value="Total"></td>
                                  <td><input type="text"
                                          class="form-control font-weight-bold" name="pcs1[]"
                                          readonly=""></td>
                                  <td></td>
                              </tr>
                          </tfoot> --}}
                        </table>
                      </div>
                      {{-- <div class="row pb-4">
                          <div class="col-12">

                              <button type="button" class="btn btn-primary"
                                  onclick="addItem('Polybag')" data-repeater-create>Add Item</button>
                              <button type="button" class="btn btn-danger"
                                  onclick="removeItem('Polybag')">Remove Last Item</button>
                          </div>
                      </div> --}}

                    </div>
                    {{-- <hr> --}}
                  </div>
                </div>

                <div class="col-12 col-md-12 mt-2 mb-2">
                  <div class="collapse multi-collapse" id="Carton">
                    <div class="content-header mt-3 mb-3">
                      <h3 class="mb-1">Carton Information</h3>
                    </div>
                    <div class="row g-3">
                      <div class="col-md-12">
                        <table class="table table-responsive mb-0 dataTable" id="Carton"
                               role="grid">
                          <thead>
                          <tr role="row">

                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 92.4px;">
                              <input type="text"
                                     class="form-control font-weight-bold" name="pcs1[]"
                                     readonly="" value="Carton Items">
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1"
                                colspan="1" style="width: 92.4px;"><input
                                type="text" class="form-control font-weight-bold"
                                name="" readonly="" value="Qty">
                            </th>
                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 20px;">
                            </th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr role="row" class="odd">

                            <td><input type="text" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td><input type="number" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td></td>
                          </tr>
                          </tbody>
                          {{-- <tfoot>
                              <tr role="row" class="odd">

                                  <td><input type="text"
                                          class="form-control font-weight-bold" name="pcs1[]"
                                          readonly="" value="Total"></td>
                                  <td><input type="text"
                                          class="form-control font-weight-bold" name="pcs1[]"
                                          readonly=""></td>
                                  <td></td>
                              </tr>
                          </tfoot> --}}
                        </table>
                      </div>
                      {{-- <div class="row pb-4">
                          <div class="col-12">

                              <button type="button" class="btn btn-primary"
                                  onclick="addItem('Carton')" data-repeater-create>Add Item</button>
                              <button type="button" class="btn btn-danger"
                                  onclick="removeItem('Carton')">Remove Last Item</button>
                          </div>
                      </div> --}}

                    </div>
                    {{-- <hr> --}}
                  </div>
                </div>

                <div class="col-12 col-md-12 mt-2 mb-2">
                  <div class="collapse multi-collapse" id="Elastic">
                    <div class="content-header mt-3 mb-3">
                      <h3 class="mb-1">Elastic Information</h3>
                    </div>
                    <div class="row g-3">
                      <div class="col-md-12">
                        <table class="table table-responsive mb-0 dataTable" id="Elastic"
                               role="grid">
                          <thead>
                          <tr role="row">

                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 92.4px;">
                              <input type="text"
                                     class="form-control font-weight-bold" name="pcs1[]"
                                     readonly="" value="Elastic Items">
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1"
                                colspan="1" style="width: 92.4px;"><input
                                type="text" class="form-control font-weight-bold"
                                name="" readonly="" value="Qty">
                            </th>
                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 20px;">
                            </th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr role="row" class="odd">

                            <td><input type="text" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td><input type="number" class="form-control 2"
                                       name="pcs1[]" id="2.1"></td>
                            <td></td>
                          </tr>
                          </tbody>
                          {{-- <tfoot>
                              <tr role="row" class="odd">

                                  <td><input type="text"
                                          class="form-control font-weight-bold" name="pcs1[]"
                                          readonly="" value="Total"></td>
                                  <td><input type="text"
                                          class="form-control font-weight-bold" name="pcs1[]"
                                          readonly=""></td>
                                  <td></td>
                              </tr>
                          </tfoot> --}}
                        </table>
                      </div>
                      {{-- <div class="row pb-4">
                          <div class="col-12">

                              <button type="button" class="btn btn-primary"
                                  onclick="addItem('Elastic')" data-repeater-create>Add Item</button>
                              <button type="button" class="btn btn-danger"
                                  onclick="removeItem('Elastic')">Remove Last Item</button>
                          </div>
                      </div> --}}

                    </div>
                    {{-- <hr> --}}
                  </div>
                </div>

                <div class="col-12 col-md-12 mt-2 mb-2">
                  <div class="collapse multi-collapse" id="Zipper">
                    <div class="content-header mt-3 mb-3">
                      <h3 class="mb-1">Zipper Information</h3>
                    </div>
                    <div class="row g-3">
                      <div class="col-md-12">
                        <div class="row g-3">
                          <div class="col-md-3 mb-4">
                            <input type="text" id="zipperName" name="zipperName"
                                   class="form-control" placeholder="Zipper Name"/>
                          </div>
                          <div class="col-md-3">
                            <button type="button" class="btn btn-primary"
                                    onclick="addItemToTable('ZipperTable', 'zipperName')"
                                    data-repeater-create>Add Item
                            </button>
                          </div>
                        </div>

                        <table class="table table-responsive mb-0 dataTable" id="ZipperTable"
                               role="grid">
                          <thead>
                          <tr role="row">
                            <th scope="col"
                                class="text-center font-weight-bold sorting_disabled"
                                rowspan="1" colspan="1" style="width: 92.4px;">
                              <input type="text"
                                     class="form-control font-weight-bold" name="pcs1[]"
                                     readonly="" value="Size">
                            </th>
                            <th scope="col" class="sorting_disabled" rowspan="1"
                                colspan="1" style="width: 92.4px;">
                              <input type="text"
                                     class="form-control font-weight-bold" name=""
                                     readonly="" value="Plan Pics">
                            </th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr role="row" class="odd">
                            <td><input type="text" class="form-control size"
                                       name="size[]" id="size_1"></td>
                            <td><input type="number" class="form-control plan-pics"
                                       name="plan_pics[]" id="plan_pics_1"></td>
                          </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="row pb-4">
                        <div class="col-12">
                          <button type="button" class="btn btn-primary"
                                  onclick="addItemRowToTable('ZipperTable')">Add Item
                          </button>
                          <button type="button" class="btn btn-danger"
                                  onclick="removeLastItemRowFromTable('ZipperTable')">Remove Last
                            Item
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection
<script>
  // Function to add a new row to the table's tbody
  function addItem(tableId) {
    // Reference to the table's tbody
    var tbody = $('#' + tableId + ' tbody');

    // Clone the last row and remove the values
    var newRow = tbody.find('tr:last').clone().find('input').val('').end();

    // Increment the SRL NO value by 1
    var lastSrlNo = parseInt(newRow.find('[name="pcs1[]"]').val());

    // Check if lastSrlNo is NaN, and set it to 1
    // if (isNaN(lastSrlNo)) {
    //     lastSrlNo = 1;
    // }

    newRow.find('[name="pcs1[]"]').val('');

    // Append the new row to the tbody
    tbody.append(newRow);
  }

  // Function to remove the last added row
  function removeItem(tableId) {
    var tbody = $('#' + tableId + ' tbody');
    if (tbody.find('tr').length > 1) {
      tbody.find('tr:last').remove();
    }
  }

  // Function to remove a specific row
  function removeRow(button) {
    $(button).closest('tr').remove();
  }
</script>

<script>
  function addItemToTable(tableId, inputId) {
    var itemName = document.getElementById(inputId).value;
    var table = document.getElementById(tableId);

    // Create a new th element with the input value and input field
    var th = document.createElement("th");
    th.setAttribute("scope", "col");
    th.setAttribute("class", "text-center font-weight-bold sorting_disabled");
    th.setAttribute("rowspan", "1");
    th.setAttribute("colspan", "1");
    th.setAttribute("style", "width: 92.4px;");

    var inputTh = document.createElement("input");
    inputTh.setAttribute("type", "text");
    inputTh.setAttribute("class", "form-control font-weight-bold");
    inputTh.setAttribute("name", "newColumn[]");
    inputTh.setAttribute("readonly", "");
    inputTh.setAttribute("value", itemName);

    th.appendChild(inputTh);

    // Add the new th element to the table header row
    var tableHeader = table.querySelector("thead tr");
    tableHeader.appendChild(th);

    // Loop through each table row and add a new td element with an input field to match the new column
    var tableRows = table.querySelectorAll("tbody tr");
    for (var i = 0; i < tableRows.length; i++) {
      var td = document.createElement("td");

      var inputTd = document.createElement("input");
      inputTd.setAttribute("type", "text");
      inputTd.setAttribute("class", "form-control");
      inputTd.setAttribute("name", "newData[]");

      td.appendChild(inputTd);

      tableRows[i].appendChild(td);
    }
  }

  function addItemRowToTable(tableId) {
    var table = document.getElementById(tableId);
    var lastRow = table.querySelector("tbody tr:last-child");
    var newRow = lastRow.cloneNode(true);

    // Clear the input values in the new row
    var inputs = newRow.querySelectorAll("input");
    inputs.forEach(function (input) {
      input.value = "";
    });

    // Increment IDs to avoid duplicates
    var rowCount = table.querySelectorAll("tbody tr").length + 1;
    inputs.forEach(function (input) {
      var currentId = input.getAttribute("id");
      if (currentId) {
        var parts = currentId.split("_");
        var newId = parts[0] + "_" + rowCount;
        input.setAttribute("id", newId);
      }
    });

    // Append the new row to the table
    table.querySelector("tbody").appendChild(newRow);
  }

  function removeLastItemRowFromTable(tableId) {
    var table = document.getElementById(tableId);
    var lastRow = table.querySelector("tbody tr:last-child");

    if (lastRow && table.querySelectorAll("tbody tr").length > 1) {
      lastRow.remove();
    }
  }
</script>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
