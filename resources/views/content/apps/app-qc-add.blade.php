@extends('layouts/layoutMaster')

@section('title', 'Add - PO')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/toastr/toastr.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}"/>
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bloodhound/bloodhound.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/forms-selects.js')}}"></script>
  <script src="{{asset('assets/js/forms-tagify.js')}}"></script>
  <script src="{{asset('assets/js/forms-typeahead.js')}}"></script>
@endsection

@section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light float-left">QC /</span> ADD
  </h4>
  <form class="source-item" action="{{ route('qcAddStore') }}"
        method="post" enctype="multipart/form-data">
    @csrf
    <div class="row invoice-add">
      <!-- Invoice Add-->
      <div class="col-lg-12 col-12 mb-lg-0 mb-4">
        <div class="card invoice-preview-card">

          <div class="card-body">
            <div class="users-list-filter">
              <div class="row">
                <div class="col-12 col-sm-6 col-lg-6">
                  <label for="users-list-status">Date</label>
                  <fieldset class="form-group">
                    <input type="date" class="form-control"
                           value="<?= date('Y-m-d')?>" name="date" id="date" required>
                  </fieldset>
                </div>
                <div class="col-12 col-sm-6 col-lg-6">
                  <label for="users-list-verified">PO No</label>
                  <fieldset class="form-group">
                    <select class="select2 form-select" data-allow-clear="true" name="poNo" id="poNo"
                            onchange="getPODetailForQC();">
                      <option value="">PO No</option>
                      @foreach ($pos as $po) {
                      <option value="{{ $po->id }}">{{ $po->po_no }}</option>
                      @endforeach
                    </select>
                  </fieldset>
                </div>

                <div class="form-group col-sm-12 mt-3">
                  <table id="option-value"
                         class="responsive table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                      <td scope="row">Sr.No</td>
                      <td width="300px">Item Name</td>
                      <td scope="row">PO Qty</td>
                      <td scope="row">GRN Qty</td>
                      <td scope="row">Received Qty</td>
                      <td scope="row">Remaining to Rec. Qty</td>
                      <td scope="row">Good Quantity</td>
                      <td scope="row">Bad Quantity</td>
                      <td scope="row">Total Quantity</td>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <input type="hidden" name="option_count" id="option_count"/>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-12 mt-3">
              <div class="mb-3">
                <label for="note">Remark:</label>
                <textarea class="form-control" rows="2" id="remark" name="remark" placeholder="remark"></textarea>
              </div>
            </div>
            <div class="row px-0 mt-3">
              <div class="col-lg-3 col-md-12 col-sm-12">
                <button type="submit" class="btn btn-primary d-grid w-100">Save</button>
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
  function getPODetailForQC() {
    $('#option-value tbody').empty();
    var poNo = document.getElementById('poNo').value;
    // $body.addClass("loading");
    $.ajax({
      dataType: 'JSON',
      type: 'POST',
      url: '{{ route('getPODetailForQC') }}',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {poNo: poNo, "_token": "{{ csrf_token() }}"},
      success: function (data) {
        if (data === 3) {
          $('#option-value tbody').empty();
        } else {
          $('#option-value tbody').append(data);
        }
      },
      error: function (data) {
        $('#option-value tbody').empty();
      }
    });
  }

  function qtyCheck(qty, id) {
    var currentQty = qty || 0;
    var insertQty = $('#qty' + id).val();
    if (insertQty > currentQty) {
      Swal.fire('Opps !', 'Qty is greater than invoice Qty!!!', 'error');
      $("#qty" + id).val(currentQty);
    }
  }

  function goodBadCheck(qty, id) {
    var currentQty = qty || 0;
    var gQty = $('#g_qty' + id).val() || 0;
    var bQty = $('#b_qty' + id).val() || 0;
    var total = parseFloat(gQty) + parseFloat(bQty);
    if (total > currentQty) {
      Swal.fire('Opps !', 'Qty is greater than invoice Qty!!!', 'error');
      $("#qty" + id).val(0);
      $('#g_qty' + id).val(0);
      $('#b_qty' + id).val(0)
      0;
    } else {
      $("#qty" + id).val(total);
    }
  }
</script>
