@extends('layouts.layoutMaster')

@section('title', 'Job Card Report')
@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice-print.css') }}" />
@endsection
@section('page-script')
    <script src="{{ asset('assets/js/app-invoice-print.js') }}"></script>
@endsection
@section('vendor-style')
    <style>
        .dark {
            font-weight: bold;
            background-color: rgba(75, 70, 98, 0.04) !important;
        }

        @media print {
            body {
                visibility: hidden;
            }

            #invoice-print {
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
            }

            .container {
                page-break-before: always;
            }

            .container:first-of-type {
                page-break-before: auto;
            }
        }
    </style>
@endsection

@php
    if ($JobOrders->type == 'regular') {
        $StyleData = $JobOrders->SalesOrderStyleInfo->StyleMaster;
    } else {
        $StyleData = $JobOrders->StyleMaster;
    }
@endphp


@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left"></span>Job Card Report
    </h4>
    <form class="source-item" action="{{ route('qcAddStore') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row invoice-add" id="invoice-print">
            <!-- Invoice Add-->
            <div class="col-lg-12 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">

                    <div class="card-body">
                        <div class="users-list-filter">
                            <div class="row">
                                <div class="form-group col-sm-12 mt-3">
                                    <table id="printreport" class="responsive table  table-bordered  mt-5">
                                        <thead>
                                            <tr>
                                                <td scope="row" class="text-center">
                                                    <svg width="40" height="40" viewBox="0 0 32 22" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                                                            fill="#7367F0"></path>
                                                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                                                            fill="#161616"></path>
                                                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                                                            fill="#161616"></path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                                                            fill="#7367F0"></path>
                                                    </svg>
                                                </td>
                                                <td colspan="6" class="text-center fs-2 text-bold">Stitchit -
                                                    {{ $JobOrders->job_order_no }}</td>
                                                <td scope="row" class="text-center fs-5">Date-
                                                    {{ Helper::formateDate($JobOrders->date) }}</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="dark">Customer</td>
                                                <td scope="row">
                                                    {{ $JobOrders->SalesOrders->Customer[0]->company_name ?? '' }} -
                                                    {{ $JobOrders->SalesOrders->Customer[0]->buyer_name ?? '' }}
                                                </td>
                                                <td scope="row" class="dark">Brand</td>
                                                <td scope="row">
                                                    {{ $JobOrders->SalesOrders->Brand[0]->name ?? '' }}
                                                </td>
                                                <td scope="row" class="dark">Season</td>
                                                <td scope="row" class="">SS 24</td>
                                                <td scope="row" class="dark">Category</td>
                                                <td scope="row" class="">
                                                    {{ $StyleData->StyleCategory->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td scope="row" class="dark">Sub Category</td>
                                                <td scope="row">
                                                    {{ $StyleData->StyleSubCategory->name }}
                                                </td>
                                                <td scope="row" class="dark">FIT</td>
                                                <td scope="row">
                                                    {{ $StyleData->Fit->name }}</td>
                                                <td scope="row" class="dark">Style</td>
                                                <td scope="row">
                                                    {{ $StyleData->style_no }}</td>
                                                <td scope="row" class="dark">Size Range</td>
                                                <td scope="row">
                                                    @php
                                                        $lengthOfSize = count($groupedSizes);
                                                        $lengthMatch = 1;
                                                    @endphp
                                                    @foreach ($groupedSizes as $keys => $groupedSize)
                                                        @if ($lengthMatch == 1)
                                                            {{ $keys }}-
                                                            @php
                                                                $baseSize = $keys;
                                                            @endphp
                                                        @endif
                                                        @if ($lengthMatch == $lengthOfSize)
                                                            {{ $keys }}
                                                        @endif
                                                        @php
                                                            $lengthMatch++;
                                                        @endphp
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td scope="row" class="dark">Designer</td>
                                                <td scope="row">
                                                    @if ($StyleData->designer_name == null)
                                                        {{ $StyleData->User->company_name ?? '' }}
                                                        -
                                                        {{ $StyleData->User->person_name ?? '' }}
                                                    @else
                                                        {{ $StyleData->designer_name }}
                                                    @endif

                                                </td>
                                                <td scope="row" class="dark">Remark</td>
                                                <td scope="row">{{ $JobOrders->note }}</td>
                                                <td scope="row" class="dark">Job Order No.</td>
                                                <td scope="row">{{ $JobOrders->job_order_no }}</td>
                                                <td scope="row"></td>
                                                <td scope="row"></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    @if ($JobOrders->type == 'regular')
                                        <table id="size-table"
                                            class="responsive table table-striped table-bordered table-hover mt-5">
                                            <thead>
                                                <tr style="font-weight: bold">
                                                    <td>Color</td>
                                                    @foreach ($groupedSizes as $keys => $groupedSize)
                                                        <td>{{ $keys }}</td>
                                                    @endforeach
                                                    <td>Total</td>
                                                </tr>
                                            </thead>
                                            @foreach ($groupedColors as $color => $colorwise)
                                                @php
                                                    $colorwiseQtyData = $colorwise->sum('qty');
                                                @endphp
                                                <tr>
                                                    <td>{{ $color }}</td>
                                                    @foreach ($colorwise as $data)
                                                        <td class="border">{{ $data->qty }}</td>
                                                    @endforeach
                                                    <td>{{ $colorwiseQtyData }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @endif


                                    <table id="image-table"
                                        class="responsive table table-striped table-bordered table-hover mt-5">
                                        <thead>
                                            <tr>
                                                <td scope="row" class="text-center">STYLE FEATURES
                                                </td>
                                            </tr>
                                        </thead>
                                        <tr>

                                            <td scope="row" class="text-center">
                                                {{-- @if (!empty($StyleData->sample_photo))
                                                    <img width="1024px" height="400px"
                                                        src="{{ Helper::getSamplePhoto($StyleData->id, $StyleData->sample_photo) }}"
                                                        alt="">
                                                @endif --}}
                                                <div class="row">
                                                    @if (!empty($SamplePhotos))
                                                        @php
                                                            $count = count($SamplePhotos);
                                                            $colClass = 'col-md-4'; // Default class for 3 or more photos
                                                            $width = '250px'; // Default width for 3 or more photos
                                                            $height = '150px'; // Default height for 3 or more photos
                                                            if ($count === 1) {
                                                                $colClass = 'col-md-12';
                                                                $width = '400px';
                                                                $height = '300px';
                                                            } elseif ($count === 2) {
                                                                $colClass = 'col-md-6';
                                                                $width = '250px';
                                                                $height = '150px';
                                                            }
                                                        @endphp

                                                        @foreach ($SamplePhotos as $name => $photos)
                                                            <div class="{{ $colClass }} mt-3">
                                                                <img width="{{ $width }}"
                                                                    height="{{ $height }}" src="{{ $photos }}"
                                                                    alt="">
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>


                                            </td>

                                        </tr>
                                    </table>


                                    <table id="process-table"
                                        class="responsive table table-striped table-bordered table-hover mt-5">
                                        <thead>
                                            <tr>
                                                <td scope="row" colspan="5" class="text-center"><b>PROCESSES</b>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td scope="row" class="text-center"><b>SR NO.</b></td>
                                                <td scope="row" class="text-center"><b>PROCESS</b></td>
                                                <td scope="row" class="text-center"><b>QTY</b></td>
                                                <td scope="row" class="text-center"><b>DATE</b></td>
                                                <td scope="row" class="text-center"><b>Signature</b></td>
                                            </tr>
                                            @php
                                                $num = 1;
                                            @endphp
                                            @if ($JobOrders->type == 'regular')
                                                @foreach ($PlaningOrders->PlaningOrderProcesses as $PlaningOrderProcesses)
                                                    <tr>
                                                        <td scope="row" class="text-center">{{ $num }}</td>
                                                        <td scope="row" class="text-center">
                                                            {{ $PlaningOrderProcesses->ProcessMaster->name ?? '' }}</td>
                                                        <td scope="row" class="text-center">
                                                            {{ $PlaningOrderProcesses->qty }}</td>
                                                        <td scope="row" class="text-center"></td>
                                                        <td scope="row" class="text-center"></td>
                                                    </tr>
                                                    @php
                                                        $num++;
                                                    @endphp
                                                @endforeach
                                            @else
                                                @foreach ($StyleData->StyleMasterProcesses as $StyleMaster)
                                                    <tr>
                                                        <td scope="row" class="text-center">{{ $num }}</td>
                                                        <td scope="row" class="text-center">
                                                            {{ $StyleMaster->ProcessMaster->name }}</td>
                                                        <td scope="row" class="text-center">
                                                            {{ $StyleMaster->qty }}</td>
                                                        <td scope="row" class="text-center"></td>
                                                        <td scope="row" class="text-center"></td>
                                                    </tr>
                                                    @php
                                                        $num++;
                                                    @endphp
                                                @endforeach
                                            @endif
                                        </thead>

                                    </table>

                                    <table id="instruction-table"
                                        class="responsive table table-striped table-bordered table-hover mt-5">
                                        <thead>
                                            <tr>
                                                <td scope="row" colspan="3" class="text-center"><b>INSTRUCTIONS</b>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td scope="row" class="text-center"><b>SR NO.</b></td>
                                                <td scope="row" class="text-center"><b>TYPE</b></td>
                                                <td scope="row" class="text-center"><b>INSTRUCTION</b></td>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td scope="row" class="text-center">1</td>
                                            <td scope="row" class="text-center">CAD Instruction</td>
                                            <td scope="row" class="text-center">{{ $JobOrders->cad_desc ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row" class="text-center">2</td>
                                            <td scope="row" class="text-center">Cutting Instruction</td>
                                            <td scope="row" class="text-center">{{ $JobOrders->cutting_desc ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row" class="text-center">3</td>
                                            <td scope="row" class="text-center">Stitching Instruction</td>
                                            <td scope="row" class="text-center">{{ $JobOrders->stitching_desc ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row" class="text-center">4</td>
                                            <td scope="row" class="text-center">Washing Instruction</td>
                                            <td scope="row" class="text-center">{{ $JobOrders->washing_desc ?? '' }}
                                            </td>
                                        </tr>
                                    </table>

                                    <table id="item/raw-material-table"
                                        class="responsive table table-striped table-bordered table-hover mt-5">
                                        <thead>
                                            <tr>
                                                <td scope="row" colspan="3" class="text-center"><b>RAW
                                                        MATERIALS</b>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td scope="row" class="text-center"><b>Sr No.</b></td>
                                                <td scope="row" class="text-center"><b>ITEMS</b></td>
                                                <td scope="row" class="text-center"><b>Qty</b></td>
                                            </tr>
                                        </thead>
                                        {{-- {{ dd($PlaningOrders->PlaningOrderMaterials) }} --}}
                                        @php
                                            $num = 1;
                                        @endphp
                                        @if ($JobOrders->type == 'regular')

                                            @foreach ($PlaningOrders->PlaningOrderMaterials as $PlaningOrderMaterials)
                                                <tr>
                                                    <td scope="row" class="text-center">{{ $num }}</td>
                                                    <td scope="row" class="text-center">
                                                        {{ $PlaningOrderMaterials->Item->name }}</td>
                                                    <td scope="row" class="text-center">
                                                        {{ $PlaningOrderMaterials->order_qty }}</td>
                                                </tr>
                                                @php
                                                    $num++;
                                                @endphp
                                            @endforeach
                                        @else
                                            @foreach ($StyleData->StyleMasterMaterials as $StyleMaster)
                                                <tr>
                                                    <td scope="row" class="text-center">{{ $num }}</td>
                                                    <td scope="row" class="text-center">
                                                        {{ $StyleMaster->Item->name }}</td>
                                                    <td scope="row" class="text-center">
                                                        {{ $StyleMaster->available_qty }}</td>
                                                </tr>
                                                @php
                                                    $num++;
                                                @endphp
                                            @endforeach
                                        @endif
                                    </table>

                                    <table id="attachment-table"
                                        class="responsive table table-striped table-bordered table-hover mt-5">
                                        <thead>
                                            <tr>
                                                <td scope="row" colspan="2" class="text-center"><b>RAW MATERIAL
                                                        ATTACHMENTS</b></td>

                                            </tr>
                                            <tr>
                                                <td scope="row" class="text-center"><b>Sr No.</b></td>
                                                <td scope="row" class="text-center"><b>ATTACHMENT</b></td>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td scope="row" height="50px" class="text-center"></td>
                                            <td scope="row" height="50px" class="text-center"></td>
                                        </tr>
                                        <tr>
                                            <td scope="row" height="50px" class="text-center"></td>
                                            <td scope="row" height="50px" class="text-center"></td>
                                        </tr>
                                        <tr>
                                            <td scope="row" height="50px" class="text-center"></td>
                                            <td scope="row" height="50px" class="text-center"></td>
                                        </tr>

                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Invoice Add-->
        </div>
    </form>


    <!-- Offcanvas -->
    @include('_partials._offcanvas.offcanvas-send-invoice')
    <!-- /Offcanvas -->
@endsection
