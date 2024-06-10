@extends('layouts/layoutMaster')

@section('title', __('Issue All Details'))
@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}"
        xmlns="http://www.w3.org/1999/html">
  <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />

  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
  <link rel="stylesheet" href="{{ URL::asset('css/daterangepicker.css') }}" />
  <!-- Row Group CSS -->
@endsection
@section('content')
  {{-- Data list view starts --}}
  <section class="invoice-list-wrapper">
    <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Issue / </span>List
    </h4>
    <!-- DataTable with Buttons -->
    <div class="card">
      <div class="card-body border-bottom d-none" id="filter-search">
        <h4 class="card-title">Search &amp; Filter</h4>
        <div class="row">
          <div class="col-md-2 user_status">
            <label class="form-label" for="type">Date range</label>
            <span class="form-group form-control-sm">
                                <div id="dateRange" class="pull-right"
                                     style="background: #fff; cursor: pointer; padding: 8px 10px; border: 1px solid #ccc; width: 100%">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                    <span></span> <b class="caret"></b>
                                </div>
                                <input type="hidden" id="startDateShow">
                                <input type="hidden" id="endDateShow">
                            </span>
          </div>
          <div class="col-md-2 user_role"><label class="form-label" for="company">Company</label>
            <select id="company" onchange="getData()"
                    class="form-select select2 text-capitalize mb-md-0 mb-2">
              <option value=""> Select Company</option>
              @foreach($data["customers"] as $customer)
                <option value="{{ $customer->id }}"
                        class="text-capitalize">{{ $customer->company_name }}</option>
              @endforeach
            </select></div>
          <div class="col-md-2 user_plan"><label class="form-label" for="designer">Designer</label>
            <select id="designer" onchange="getData()" class="form-select text-capitalize mb-md-0 mb-2">
              <option value=""> Select Designer</option>
              @foreach($data["designers"] as $designer)
                <option value="{{ $designer->id }}"
                        class="text-capitalize">{{ $designer->company_name." - ".$designer->person_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2 user_role"><label class="form-label" for="Category">Category</label>
            <select id="category" onchange="getData()"
                    class="form-select select2 text-capitalize mb-md-0 mb-2">
              <option value=""> Select Category</option>
              @foreach($data["styleCategories"] as $styleCategory)
                <option value="{{ $styleCategory->id }}"
                        class="text-capitalize">{{ $styleCategory->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-2 user_role"><label class="form-label" for="Category">Sub Category</label>
            <select id="subcategory" onchange="getData()"
                    class="form-select select2 text-capitalize mb-md-0 mb-2">
              <option value=""> Select Sub Category</option>
              @foreach($data["styleSubCategories"] as $styleSubCategory)
                <option value="{{ $styleSubCategory->id }}"
                        class="text-capitalize">{{ $styleSubCategory->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-2 user_status"><label class="form-label" for="type">Type</label>
            <select id="type" onchange="getData()" class="form-select text-capitalize mb-md-0 mb-2xx">
              <option value=""> Select Type</option>
              <option value="sample" class="text-capitalize">Sample</option>
              <option value="regular" class="text-capitalize">Regular</option>
            </select>
          </div>


        </div>
      </div>
      <div class="row container">
        <p><b>Filters</b> :-
          <small class="m-2" id="dateFilterShow"></small>
          <small class="m-3" id="companyFilterShow"></small>
          <small class="m-3" id="designerFilterShow"></small>
          <small class="m-3" id="categoryFilterShow"></small>
          <small class="m-3" id="subcategoryFilterShow"></small>
          <small class="m-3" id="typeFilterShow"></small>
        </p>
      </div>
      <div class="card card-datatable table-responsive">


        <table class="invoice-list-table dataTable table" id="job-card-datatable-list">
          <thead class="table-secondary text-bold">
          <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Job Card No</th>
            <th>Issue Qty</th>
            <th>Department Name</th>
            <th>User Name</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </section>

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
            <button type="submit" class="btn btn-default bg-primary">Submit</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

  <div class="modal fade" id="modal-issue-history" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-edit-user modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="text-center mb-4">
            <h4 class="modal-title">All Transfer Process</h4>
          </div>
        </div>
        <div class="modal-body">
        </div>
        <div class="col-12 text-center">
          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                  aria-label="Close">
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>

@endsection
@section('vendor-script')
  <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/daterangepicker.js') }}"></script>
  <!-- Flat Picker -->
  <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
  <script>
    function formatDate(dateStr) {
      return dateStr.split('-').reverse().join('-');
    }

    const start = moment().subtract(29, 'days');
    const end = moment().subtract(0, 'days');

    function getDateFind(start, end) {
      $('#dateRange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      var startDateFormat = new Date(start.format('MMMM D, YYYY'));
      var startDate = new Date(startDateFormat.getTime() - (startDateFormat.getTimezoneOffset() * 60000))
        .toISOString()
        .split('T')[0];

      var endDateFormat = new Date(end.format('MMMM D, YYYY'));
      var endDate = new Date(endDateFormat.getTime() - (endDateFormat.getTimezoneOffset() * 60000))
        .toISOString()
        .split('T')[0];
      $('#startDateShow').val(startDate);
      $('#endDateShow').val(endDate);
      getData(startDate, endDate);
    }

    $('#dateRange').daterangepicker({
      startDate: start,
      endDate: end,
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
    }, getDateFind);
    getDateFind(start, end);

    function getData(startDate = '', endDate = '') {
      if (startDate === undefined || startDate === '') {
        startDate = $('#startDateShow').val();
      }
      if (endDate === undefined || endDate === '') {
        endDate = $('#endDateShow').val();
      }
      if ($.fn.DataTable.isDataTable('#job-card-datatable-list')) {
        $('#job-card-datatable-list').DataTable().destroy();
      }

      var dtInvoiceTable = $('#job-card-datatable-list');
      var company = $('#company');
      var designer = $('#designer');
      var category = $('#category');
      var subcategory = $('#subcategory');
      var type = $('#type');
      // datatable
      if (startDate !== '') {
        $('#dateFilterShow').html('<b>Date Range</b> : ' + formatDate(startDate) + ' to ' + formatDate(endDate));
      }
      if (company.val() !== '') {
        $('#companyFilterShow').html('<b>Company</b> : ' + company.find('option:selected').text());
      } else {
        $('#companyFilterShow').html('');
      }
      if (designer.val() !== '') {
        $('#designerFilterShow').html('<b>Designer</b> : ' + designer.find('option:selected').text());
      } else {
        $('#designerFilterShow').html('');
      }
      if (category.val() !== '') {
        $('#categoryFilterShow').html('<b>Category</b> : ' + category.find('option:selected').text());
      } else {
        $('#categoryFilterShow').html('');
      }
      if (subcategory.val() !== '') {
        $('#subcategoryFilterShow').html('<b>Subcategory</b> : ' + subcategory.find('option:selected').text());
      } else {
        $('#subcategoryFilterShow').html('');
      }
      if (type.val() !== '') {
        $('#typeFilterShow').html('<b>Type </b> : ' + type.find('option:selected').text());
      } else {
        $('#typeFilterShow').html('');
      }

      if (dtInvoiceTable.length) {
        var dtInvoice = dtInvoiceTable.DataTable({
          autoWidth: false,
          processing: true,
          serverSide: true,
          ajax: {
            'url': "{{ route('issue.all-listing') }}",
            'type': 'POST',
            'headers': '{ \'X-CSRF-TOKEN\': $(\'meta[name=\'csrf-token\']\').attr(\'content\') }',
            'data': {
              'party_name': $('#party_name').val(),
              'inward_number': $('#inward_number').val(),
              'startDate': $('#startDate').val(),
              'endDate': $('#endDate').val(),
              'statusType': '',
              'job_order_id': {{ $id }},
              'department_id': $('#department_id').val(),
              'action': $('#action').val(),
              '_token': "{{ csrf_token() }}"
            }
          },
          order: [[1, 'desc']],
          dom:
            '<"row me-2"' +
            '<"col-md-2"<"me-3"l>>' +
            '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
            '>t' +
            '<"row mx-2"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
          language: {
            sLengthMenu: '_MENU_',
            search: '',
            searchPlaceholder: 'Search..'
          },
          // Buttons with Dropdown
          buttons: [
            {
              extend: 'collection',
              className: 'btn btn-label-primary dropdown-toggle mx-3',
              text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
              buttons: [
                {
                  extend: 'print',
                  text: '<i class="ti ti-printer me-2" ></i>Print',
                  className: 'dropdown-item',
                  exportOptions: {
                    format: {
                      body: function(inner, coldex, rowdex) {
                        if (inner.length <= 0) return inner;
                        var el = $.parseHTML(inner);
                        var result = '';
                        $.each(el, function(index, item) {
                          if (item.classList !== undefined && item.classList.contains('user-name')) {
                            result = result + item.lastChild.firstChild.textContent;
                          } else if (item.innerText === undefined) {
                            result = result + item.textContent;
                          } else result = result + item.innerText;
                        });
                        return result;
                      }
                    }
                  },
                  customize: function(win) {
                    //customize print view for dark
                    $(win.document.body)
                      .css('color', headingColor)
                      .css('border-color', borderColor)
                      .css('background-color', bodyBg);
                    $(win.document.body)
                      .find('table')
                      .addClass('compact')
                      .css('color', 'inherit')
                      .css('border-color', 'inherit')
                      .css('background-color', 'inherit');
                  }
                },
                {
                  extend: 'csv',
                  text: '<i class="ti ti-file-text me-2" ></i>Csv',
                  className: 'dropdown-item',
                  exportOptions: {
                    format: {
                      body: function(inner, coldex, rowdex) {
                        if (inner.length <= 0) return inner;
                        var el = $.parseHTML(inner);
                        var result = '';
                        $.each(el, function(index, item) {
                          if (item.classList !== undefined && item.classList.contains('user-name')) {
                            result = result + item.lastChild.firstChild.textContent;
                          } else if (item.innerText === undefined) {
                            result = result + item.textContent;
                          } else result = result + item.innerText;
                        });
                        return result;
                      }
                    }
                  }
                },
                {
                  extend: 'excel',
                  text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                  className: 'dropdown-item',
                  exportOptions: {
                    format: {
                      body: function(inner, coldex, rowdex) {
                        if (inner.length <= 0) return inner;
                        var el = $.parseHTML(inner);
                        var result = '';
                        $.each(el, function(index, item) {
                          if (item.classList !== undefined && item.classList.contains('user-name')) {
                            result = result + item.lastChild.firstChild.textContent;
                          } else if (item.innerText === undefined) {
                            result = result + item.textContent;
                          } else result = result + item.innerText;
                        });
                        return result;
                      }
                    }
                  }
                },
                {
                  extend: 'pdf',
                  text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                  className: 'dropdown-item',
                  exportOptions: {
                    format: {
                      body: function(inner, coldex, rowdex) {
                        if (inner.length <= 0) return inner;
                        var el = $.parseHTML(inner);
                        var result = '';
                        $.each(el, function(index, item) {
                          if (item.classList !== undefined && item.classList.contains('user-name')) {
                            result = result + item.lastChild.firstChild.textContent;
                          } else if (item.innerText === undefined) {
                            result = result + item.textContent;
                          } else result = result + item.innerText;
                        });
                        return result;
                      }
                    }
                  }
                },
                {
                  extend: 'copy',
                  text: '<i class="ti ti-copy me-2" ></i>Copy',
                  className: 'dropdown-item',
                  exportOptions: {
                    format: {
                      body: function(inner, coldex, rowdex) {
                        if (inner.length <= 0) return inner;
                        var el = $.parseHTML(inner);
                        var result = '';
                        $.each(el, function(index, item) {
                          if (item.classList !== undefined && item.classList.contains('user-name')) {
                            result = result + item.lastChild.firstChild.textContent;
                          } else if (item.innerText === undefined) {
                            result = result + item.textContent;
                          } else result = result + item.innerText;
                        });
                        return result;
                      }
                    }
                  }
                }
              ]
            },
            {
              text: '<i class="ti ti-filter me-md-1"></i><span class="d-md-inline-block d-none"></span>',
              className: 'btn btn-primary',
              action: function(e, dt, button, config) {
                $('#filter-search').toggleClass('d-none');
              }
            }
          ],
          // For responsive popup
          responsive: {
            details: {
              display: $.fn.dataTable.Responsive.display.modal({
                header: function(row) {
                  var data = row.data();
                  return 'Details of Job Card';
                }
              }),
              type: 'column',
              renderer: function(api, rowIdx, columns) {
                var data = $.map(columns, function(col, i) {
                  return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                    ? '<tr data-dt-row="' +
                    col.rowIndex +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                    : '';
                }).join('');

                return data ? $('<table class="table"/><tbody />').append(data) : false;
              }
            }
          }
        });
      }
    }

    function viewIssueModel(id) {
      $.ajax({
        type: 'POST',
        url: "{{ route('issue.viewIssuePopup') }}",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { id: id, '_token': "{{ csrf_token() }}" },
        success: function(data) {
          $('.modal-body').html(data);
          $('#modal-issue').modal('show');
          $('.select2').select2();
        },
        error: function(data) {
          alert(data);
        }
      });
    }
  </script>
  <script>
    function viewIssueReceive(id) {
      $body.addClass('loading');
      $('#showIssueNoForPackingReceive').html(id);
      $.ajax({
        type: 'POST',
        url: "{{ route('issue.viewIssueReceivePopup') }}",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { id: id, '_token': "{{ csrf_token() }}" },
        success: function(data) {
          $('.modal-body').html(data);
          $('#modal-issue-packing-receive').modal('show');
          $('.select2').select2();
          $body.removeClass('loading');
        },
        error: function(data) {
          alert(data);
          $body.removeClass('loading');
        }
      });
    }

    function viewIssueModelForTransfer(id) {
      $body.addClass('loading');
      $('#showIssueNoForTransfer').html(id);
      $.ajax({
        type: 'POST',
        url: "{{ route('issue.viewIssuePopupForTransfer') }}",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { id: id, '_token': "{{ csrf_token() }}" },
        success: function(data) {
          $('.modal-body').html(data);
          $('#modal-issue-transfer').modal('show');
          $('.select2').select2();
          $body.removeClass('loading');
        },
        error: function(data) {
          alert(data);
          $body.removeClass('loading');
        }
      });
    }

    function viewIssueHistory(id) {
      $('#showIssueNoForHistory').html(id);
      $.ajax({
        type: 'POST',
        url: "{{ route('issue.viewIssueHistoryPopup') }}",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { id: id, '_token': "{{ csrf_token() }}" },
        success: function(data) {
          $('.modal-body').html(data);
          $('#modal-issue-history').modal('show');
        },
        error: function(data) {
          alert(data);
        }
      });
    }

  </script>
@endsection
