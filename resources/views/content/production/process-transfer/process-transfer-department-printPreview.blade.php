@extends('layouts.layoutMaster')

@section('title', 'Preview - Process Transfer Department')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('page-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />
@endsection

@section('content')
  <div class="card">

    <div class="row">
      <div class="col-md-12 p-3 float-right">
        <button class="btn btn-label-primary">
          Download
        </button>
        <a class="btn btn-label-primary" target="_blank" href="{{route('process-transfer-departmentPrint')}}">
          Print
        </a>
      </div>
    </div>
  </div>
  <div class="card card-primary">
    <div class="row">
      <div class="form-group col-sm-2">
      </div>
      <div class="form-group col-sm-8">
        <section class="invoice" id="invoice"
                 style="position:relative;padding: 20px;">
          <div class="main_div" style="width:100%;height:100%;text-align:center;">
            <table style="width: 100%; margin-top: 40px;">
              <tr style="border:0px solid #FFF; padding: 5px">
                <td style="text-align: left"></td>
                <td style="text-align: left"></td>
                <td class="fontData" style="text-align: left"><b>Zedex GST No : </b></td>
                <td style="text-align: left"></td>

              </tr>
              <tr style="border:0px solid #FFF; padding: 5px">
                <td style="text-align: left"><b>Party Name : </b></td>
                <td style="text-align: left"></td>
                <td class="fontData" style="text-align: left"><b>Ch No. : </b></td>
                <td style="text-align: left"></td>

              </tr>
              <tr style="border:0px solid #FFF">
                <td class="fontData" style="text-align: left"><b>Address : </b>ff-1, silver point complex, near sbi bank
                  Narol, Ahmedabad
                  ahmedabad, Gujarat - 382405
                </td>
                <td style="text-align: left" width="450px">
                  <p>
                  </p>
                </td>
                <td style="text-align: left"><b>Date:</b></td>
                <td style="text-align: left">24-05-24</td>
              </tr>
              <tr style="border:0px solid #FFF">
                <td class="fontData" style="text-align: left"><b>GST No:</b></td>
                <td style="text-align: left">gst no</td>
                <td style="text-align: left" width="150px"><b>Contact No: </b></td>
                <td style="text-align: left" width="150px">12345</td>

              </tr>
            </table>

            <table border="1px solid black" style="width: 100%">

              <tr>
                <th class="fontHeader">P Do No</th>
                <th class="fontHeader">P Do Qty</th>
                <th class="fontHeader">Type</th>
                <th class="fontHeader">Lot/Style</th>
                <th class="fontHeader">Process</th>
                <th class="fontHeader">Quantity</th>
                <th class="fontHeader">Balance</th>
                <th class="fontHeader">Bundles</th>
              </tr>


              <tr class="rm">
                <td>&nbsp</td>
                <td>&nbsp</td>
                <td>&nbsp</td>
                <td>&nbsp</td>
                <td>&nbsp</td>
                <td>&nbsp</td>
                <td>&nbsp</td>
                <td>&nbsp</td>
              </tr>

              <tr>
                <td colspan="5" class="fontData" style="text-align: right"><b>Total</b></td>
                <td class="fontData" style="text-align: center">total qty</td>
                <td class="fontData" style="text-align: center"></td>
                <td class="fontData" style="text-align: center"></td>
              </tr>
            </table>

            <table style="width: 100%; margin-top: 1px">
              <tr style="border:0px solid #FFF">
                <td style="text-align: left"><b>Remarks :</b></td>
                <td>
                  remark
                  <div><b>Challan No-challan123</b> / <b>Challan Date-</b>25-03-2024
                    / <b>Qty-</b> 20
                  </div>
                </td>
              </tr>
            </table>
            <table style="width: 100%; margin-top: 1px">
              <tr style="border:0px solid #FFF">
                <td style="text-align: left"><b>Dispatch To :</b> Stitching</td>
              </tr>
            </table>
            <table style="width: 100%;">
              <tr style="border:0px solid #FFF">
                <td style="text-align: left"><b>Receive From :</b>Cutting</td>

              </tr>
            </table>
            <table style="width: 100%; margin-top: 25px">
              <tr style="border:0px solid #FFF">
                <td style="text-align: left"><b>Receiver's Name/Signature</b></td>
                <td style="text-align: left"><b>Contact No</b>1234567890</td>
                <td style="text-align: right"><b>For Zedex Clothings Pvt. Ltd.</b></td>
              </tr>
            </table>
            <table style="width: 100%; margin-top: 1px">
              <tr style="border:0px solid #FFF">
                <td style="text-align: left"><b>Textile Garments Washing Jobwork</b></td>
              </tr>
            </table>
          </div>
        </section>
      </div>
      <div class="form-group col-sm-2">
      </div>
    </div>
  </div>

@endsection

