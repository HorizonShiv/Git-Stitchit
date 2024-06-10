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

        @if (Auth::user()->role == 'admin')
            <li class="menu-item ">
                <a href="{{ url('/app/master/view') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-menu"></i><i class=""></i>
                    <div>Master</div>
                </a>
            </li>
        @endif




        @if (Auth::user()->role == 'admin')
            <li class="menu-item ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-calendar"></i>
                    <div>Sales Order</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item ">
                        <a href="{{ route('sales-order.create') }}" class="menu-link">
                            <div>Add</div>
                        </a>
                    </li>
                    <li class="menu-item ">
                        <a href="{{ route('sales-order.index') }}" class="menu-link">
                            <div>List</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-clipboard"></i>
                    <div>Order Planing</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item ">
                        <a href="{{ url('/order-planing/pendinglist') }}" class="menu-link">
                            <div>Pending List</div>
                        </a>
                    </li>
                    <li class="menu-item ">
                        <a href="{{ route('order-planning.index') }}" class="menu-link">
                            <div>List</div>
                        </a>
                    </li>

                </ul>
            </li>
        @endif


        @if (Auth::user()->role == 'admin')
            {{-- <li class="menu-item ">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons ti ti-truck"></i>
              <div>Order Confirmation</div>
          </a>
          <ul class="menu-sub">
              <li class="menu-item ">
                  <a href="{{ url('/app/order/add') }}" class="menu-link">
                      <div>Add</div>
                  </a>
              </li>
              <li class="menu-item ">
                  <a href="{{ url('/app/order/list') }}" class="menu-link">
                      <div>List</div>
                  </a>
              </li>
          </ul>
      </li> --}}
        @endif

        <li class="menu-item ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-clipboard-check"></i>
                <div>Order Job Card</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item ">
                    <a href="{{ url('/order-job-card/pendinglist') }}" class="menu-link">
                        <div>Pending List</div>
                    </a>
                  <a href="{{ url('/order-job-card/saleOrder/create') }}" class="menu-link">
                    <div>Create By SaleOrder</div>
                  </a>
                    <a href="{{ url('/order-job-card/sample/create') }}" class="menu-link">
                        <div>Sample</div>
                    </a>
                    <a href="{{ url('/order-job-card/list') }}" class="menu-link">
                        <div>List</div>
                    </a>
                </li>
                {{--              <li class="menu-item "> --}}
                {{--                <a href="{{ url('/order-job-card/create') }}" class="menu-link"> --}}
                {{--                  <div>Create</div> --}}
                {{--                </a> --}}
                {{--              </li> --}}
            </ul>
        </li>
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'warehouse' || Auth::user()->role == 'account')
            <li class="menu-item ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                    <div>PO Manage</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item ">
                        <a href="{{ url('app/po/add') }}" class="menu-link">
                            <div>Add</div>
                        </a>
                    </li>
                    <li class="menu-item ">
                        <a href="{{ url('app/po/list') }}" class="menu-link">
                            <div>List</div>
                        </a>
                    </li>
                    <li class="menu-item ">
                        <a href="{{ url('app/po/requestlist') }}" class="menu-link">
                            <div>Po Request List</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (Auth::user()->role == 'admin')
            <li class="menu-item ">
                <a href="{{ url('/app/warehouse/view') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-truck"></i>
                    <div>Warehouse</div>
                </a>
            </li>
        @endif

        <li class="menu-item ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-tools"></i>
                <div>Production</div>
            </a>
            @foreach(App\Models\ProcessMaster::all() as $process)
                @php
                    $id = $process->id;
                        $issueManage = App\Models\IssueManage::query();
                         $issueManage->where("rQty", ">", 0);
                         $issueManage->whereHas('Department', function ($query) use ($id) {
                           $query->where('process_master_id', $id);
                         });
                         $totalProcessCount = $issueManage->count();
                @endphp
                <ul class="menu-sub">
                    <li class="menu-item ">
                        <a href="{{ Route('production',$process->id) }}" class="menu-link ">
                            <div>{{ $process->name }}</div>
                            <div class="badge bg-primary rounded-pill ms-auto">{{ $totalProcessCount }}</div>
                        </a>
                    </li>
                </ul>
            @endforeach
        </li>

        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'warehouse')
            <li class="menu-item ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-book"></i>
                    <div>QC Manage</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item ">
                        <a href="{{ url('app/qc/add') }}" class="menu-link">
                            <div>Add</div>
                        </a>
                    </li>
                    <li class="menu-item ">
                        <a href="{{ url('app/qc/list') }}" class="menu-link">
                            <div>List</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        @if (Auth::user()->role == 'vendor' || Auth::user()->role == 'admin' || Auth::user()->role == 'account')
            <li class="menu-item" style="">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-file-dollar"></i>
                    <div>Invoice</div>
                </a>
                <ul class="menu-sub">
                    @if (Auth::user()->direct_invoice == '1')
                        <li class="menu-item ">
                            <a href="{{ url('app/invoice/item/add') }}" class="menu-link">
                                <div>Add</div>
                            </a>
                        </li>
                    @endif
                    <li class="menu-item ">
                        <a href="{{ url('app/po/invoice/list') }}" class="menu-link">
                            <div>PO Invoice</div>
                        </a>
                    </li>
                    <li class="menu-item ">
                        <a href="{{ url('app/invoice/list') }}" class="menu-link">
                            <div>List</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (Auth::user()->role == 'admin')
            <li class="menu-item ">
                <a href="{{ url('/app/settings/details') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-settings"></i>
                    <div>Setting</div>
                </a>
            </li>
        @endif
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; right: 4px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
        </div>
    </ul>
    {{--  <ul class="menu-inner py-1"> --}}
    {{--    @foreach ($menuData[0]->menu as $menu) --}}

    {{--    --}}{{-- adding active and open class if child is active --}}

    {{--    --}}{{-- menu headers --}}
    {{--    @if (isset($menu->menuHeader)) --}}
    {{--    <li class="menu-header small text-uppercase"> --}}
    {{--      <span class="menu-header-text">{{ $menu->menuHeader }}</span> --}}
    {{--    </li> --}}
    {{--    @else --}}

    {{--    --}}{{-- active menu method --}}
    {{--    @php --}}
    {{--    $activeClass = null; --}}
    {{--    $currentRouteName = Route::currentRouteName(); --}}

    {{--    if ($currentRouteName === $menu->slug) { --}}
    {{--    $activeClass = 'active'; --}}
    {{--    } --}}
    {{--    elseif (isset($menu->submenu)) { --}}
    {{--    if (gettype($menu->slug) === 'array') { --}}
    {{--    foreach($menu->slug as $slug){ --}}
    {{--    if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) { --}}
    {{--    $activeClass = 'active open'; --}}
    {{--    } --}}
    {{--    } --}}
    {{--    } --}}
    {{--    else{ --}}
    {{--    if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) { --}}
    {{--    $activeClass = 'active open'; --}}
    {{--    } --}}
    {{--    } --}}

    {{--    } --}}
    {{--    @endphp --}}

    {{--    --}}{{-- main menu --}}
    {{--    <li class="menu-item {{$activeClass}}"> --}}
    {{--      <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif> --}}
    {{--        @isset($menu->icon) --}}
    {{--        <i class="{{ $menu->icon }}"></i> --}}
    {{--        @endisset --}}
    {{--        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div> --}}
    {{--        @isset($menu->badge) --}}
    {{--        <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div> --}}

    {{--        @endisset --}}
    {{--      </a> --}}

    {{--      --}}{{-- submenu --}}
    {{--      @isset($menu->submenu) --}}
    {{--      @include('layouts.sections.menu.submenu',['menu' => $menu->submenu]) --}}
    {{--      @endisset --}}
    {{--    </li> --}}
    {{--    @endif --}}
    {{--    @endforeach --}}
    {{--  </ul> --}}

</aside>
