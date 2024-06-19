@php
    $configData = Helper::appClasses();
@endphp
<style>
    #overlay {
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0, 0, 0, 0.6);
    }

    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px #ddd solid;
        border-top: 4px #2e93e6 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }

    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }

    .is-hide {
        display: none;
    }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    @if (!isset($navbarFull))
        <div class="app-brand demo">
            <a href="{{ url('/') }}" class="app-brand-link">
                <span class="app-brand-logo demo">
                    @include('_partials.macros', ['height' => 20])
                </span>
                <span class="app-brand-text demo menu-text fw-bold">{{ config('variables.templateName') }}</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
        </div>
    @endif


    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1 ps">

        @php
            $currentUrl = request()->url();
            $masterUrl = url('/app/master/view');
            $salesOrderCreateUrl = route('sales-order.create');
            $salesOrderIndexUrl = route('sales-order.index');
            $orderPlaningPendingListUrl = url('/order-planing/pendinglist');
            $orderPlaningIndexUrl = route('order-planning.index');
            $orderJobCardPendingListUrl = url('/order-job-card/pendinglist');
            $orderJobCardSampleCreateUrl = url('/order-job-card/sample/create');
            $orderJobCardListUrl = url('/order-job-card/list');
            $orderJobCardSalesOrderCreateUrl = url('/order-job-card/saleOrder/create');
            $poAddUrl = url('app/po/add');
            $poListUrl = url('app/po/list');
            $poRequestListUrl = url('app/po/requestlist');
            $warehouseUrl = url('/app/warehouse/view');
            $qcAddUrl = url('app/qc/add');
            $qcListUrl = url('app/qc/list');
            $invoiceItemAddUrl = url('app/invoice/item/add');
            $poInvoiceListUrl = url('app/po/invoice/list');
            $invoiceListUrl = url('app/invoice/list');
            $settingsUrl = url('/app/settings/details');

            $packagingListUrl = url('/packaging/list');
            $packagingAddUrl = url('/packaging/add');
        @endphp


        <li class="menu-item {{ $currentUrl == $masterUrl ? 'active' : '' }}">
            <a href="{{ $masterUrl }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-menu"></i><i class=""></i>
                <div>Master</div>
            </a>
        </li>



        <li
            class="menu-item {{ $currentUrl == $salesOrderCreateUrl || $currentUrl == $salesOrderIndexUrl ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-calendar"></i>
                <div>Sales Order</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $currentUrl == $salesOrderCreateUrl ? 'active' : '' }}">
                    <a href="{{ $salesOrderCreateUrl }}" class="menu-link">
                        <div>Add</div>
                    </a>
                </li>
                <li class="menu-item {{ $currentUrl == $salesOrderIndexUrl ? 'active' : '' }}">
                    <a href="{{ $salesOrderIndexUrl }}" class="menu-link">
                        <div>List</div>
                    </a>
                </li>
            </ul>
        </li>
        <li
            class="menu-item {{ $currentUrl == $orderPlaningPendingListUrl || $currentUrl == $orderPlaningIndexUrl ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-clipboard"></i>
                <div>Order Planing</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $currentUrl == $orderPlaningPendingListUrl ? 'active' : '' }}">
                    <a href="{{ $orderPlaningPendingListUrl }}" class="menu-link">
                        <div>Pending List</div>
                    </a>
                </li>
                <li class="menu-item {{ $currentUrl == $orderPlaningIndexUrl ? 'active' : '' }}">
                    <a href="{{ $orderPlaningIndexUrl }}" class="menu-link">
                        <div>List</div>
                    </a>
                </li>
            </ul>
        </li>


        <li
            class="menu-item {{ $currentUrl == $orderJobCardPendingListUrl || $currentUrl == $orderJobCardSampleCreateUrl || $currentUrl == $orderJobCardListUrl || $currentUrl == $orderJobCardSalesOrderCreateUrl ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-clipboard-check"></i>
                <div>Order Job Card</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $currentUrl == $orderJobCardPendingListUrl ? 'active' : '' }}">
                    <a href="{{ $orderJobCardPendingListUrl }}" class="menu-link">
                        <div>Pending List</div>
                    </a>
                </li>
                <li class="menu-item {{ $currentUrl == $orderJobCardSalesOrderCreateUrl ? 'active' : '' }}">
                    {{-- <a href="{{ $orderJobCardPendingListUrl }}" class="menu-link"> --}}
                    <a href="{{ $orderJobCardSalesOrderCreateUrl }}" class="menu-link">
                        <div>Create By SaleOrder</div>
                    </a>
                </li>
                <li class="menu-item {{ $currentUrl == $orderJobCardSampleCreateUrl ? 'active' : '' }}">
                    <a href="{{ $orderJobCardSampleCreateUrl }}" class="menu-link">
                        <div>Sample</div>
                    </a>
                </li>
                <li class="menu-item {{ $currentUrl == $orderJobCardListUrl ? 'active' : '' }}">
                    <a href="{{ $orderJobCardListUrl }}" class="menu-link">
                        <div>List</div>
                    </a>
                </li>
            </ul>
        </li>

        <li
            class="menu-item {{ $currentUrl == $poAddUrl || $currentUrl == $poListUrl || $currentUrl == $poRequestListUrl ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                <div>PO Manage</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $currentUrl == $poAddUrl ? 'active' : '' }}">
                    <a href="{{ $poAddUrl }}" class="menu-link">
                        <div>Add</div>
                    </a>
                </li>
                <li class="menu-item {{ $currentUrl == $poListUrl ? 'active' : '' }}">
                    <a href="{{ $poListUrl }}" class="menu-link">
                        <div>List</div>
                    </a>
                </li>
                <li class="menu-item {{ $currentUrl == $poRequestListUrl ? 'active' : '' }}">
                    <a href="{{ $poRequestListUrl }}" class="menu-link">
                        <div>Po Request List</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ $currentUrl == $warehouseUrl ? 'active' : '' }}">
            <a href="{{ $warehouseUrl }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-truck"></i>
                <div>Warehouse</div>
            </a>
        </li>

        <li class="menu-item ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-tools"></i>
                <div>Production</div>
            </a>
            @foreach (App\Models\ProcessMaster::all() as $process)
                @php
                    $id = $process->id;
                    $issueManage = App\Models\IssueManage::query();
                    $issueManage->where('rQty', '>', 0);
                    $issueManage->whereHas('Department', function ($query) use ($id) {
                        $query->where('process_master_id', $id);
                    });
                    $totalProcessCount = $issueManage->count();
                @endphp
                <ul class="menu-sub">
                    <li class="menu-item ">
                        <a href="{{ Route('production', $process->id) }}" class="menu-link ">
                            <div>{{ $process->name }}</div>
                            <div class="badge bg-primary rounded-pill ms-auto">{{ $totalProcessCount }}</div>
                        </a>
                    </li>
                </ul>
            @endforeach
        </li>

        <li
            class="menu-item {{ $currentUrl == $packagingListUrl || $currentUrl == $packagingAddUrl ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-package"></i>
                <div>Packaging</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $currentUrl == $packagingAddUrl ? 'active' : '' }}">
                    <a href="{{ $packagingAddUrl }}" class="menu-link">
                        <div>Add</div>
                    </a>
                </li>
                <li class="menu-item {{ $currentUrl == $packagingListUrl ? 'active' : '' }}">
                    <a href="{{ $packagingListUrl }}" class="menu-link">
                        <div>List</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ $currentUrl == $qcAddUrl || $currentUrl == $qcListUrl ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-book"></i>
                <div>QC Manage</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $currentUrl == $qcAddUrl ? 'active' : '' }}">
                    <a href="{{ $qcAddUrl }}" class="menu-link">
                        <div>Add</div>
                    </a>
                </li>
                <li class="menu-item {{ $currentUrl == $qcListUrl ? 'active' : '' }}">
                    <a href="{{ $qcListUrl }}" class="menu-link">
                        <div>List</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ $currentUrl == $invoiceItemAddUrl || $currentUrl == $poInvoiceListUrl || $currentUrl == $invoiceListUrl ? 'active' : '' }}"
            style="">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-file-dollar"></i>
                <div>Invoice</div>
            </a>
            <ul class="menu-sub">
                @if (Auth::user()->direct_invoice == '1')
                    <li class="menu-item {{ $currentUrl == $invoiceItemAddUrl ? 'active' : '' }}">
                        <a href="{{ $invoiceItemAddUrl }}" class="menu-link">
                            <div>Add</div>
                        </a>
                    </li>
                @endif
                <li class="menu-item {{ $currentUrl == $poInvoiceListUrl ? 'active' : '' }}">
                    <a href="{{ $poInvoiceListUrl }}" class="menu-link">
                        <div>PO Invoice</div>
                    </a>
                </li>
                <li class="menu-item {{ $currentUrl == $invoiceListUrl ? 'active' : '' }}">
                    <a href="{{ $invoiceListUrl }}" class="menu-link">
                        <div>List</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ $currentUrl == $settingsUrl ? 'active' : '' }}">
            <a href="{{ $settingsUrl }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div>Setting</div>
            </a>
        </li>


        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; right: 4px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
        </div>
    </ul>
</aside>
