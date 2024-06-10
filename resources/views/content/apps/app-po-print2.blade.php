@extends('layouts/layoutMaster')

@section('title', 'PO (Print version) - Pages')

@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-invoice-print.css')}}"/>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/app-invoice-print.js')}}"></script>
@endsection
<style>
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
  }
</style>

@section('content')
  <div class="invoice-print p-5" id="invoice-print">

    <table width="861" cellspacing="0" border="0">
      <tr>
        <th colspan="10"><p align="center">Purchase Order</p></th>
      </tr>
      <tr>
        <td colspan="2" rowspan="2" width="50">
          Sender<br><br><b><?= $po->User->company_name ?></b>
          <br><?= $po->User->UserAddress->b_address1; ?>
          <br><?= $po->User->UserAddress->b_address2; ?>
          <br><?= $invoice->getState(); ?> -<?= $invoice->getPinCode(); ?>
          <br><?= $invoice->getPhoneNo(); ?><br>GSTIN:<?= $invoice->getGstNo(); ?></td>
        <td height="30" colspan="4">Purchase Code :- <b><?= $po->getPono(); ?></b></td>
        <td colspan="5">Po Date:- <b><?= date_format(date_create($po->getPoDate()), 'd-m-Y') ?></b></td>
      </tr>
      <tr>
        <td height="122" colspan="4" align="center" valign="top">Purchase No: <b><?= $po->getPono(); ?></b><br>Order
          Date::
          <b><?= date_format(date_create($po->getPoDate()), 'd-m-Y') ?>
            <b><br><br><? echo ''; ?></td>
        <td colspan="4" valign="top"><br><b><?= ''; ?></b><br><br><br><b></b></td>
      </tr>
      <tr>
        <td height="160" colspan="2" valign="top">Bill
          To:<br><br><b><?= $po->getPartyName() ?></b><br><?= $po->getAddress() ?>
          <br>T: <?= $po->getMobileNo() ?><br>E-Mail: <?= $po->getEmailId() ?><br>GSTIN: <?= $po->getGstNo() ?></td>
        <td height="160" colspan="4" valign="top">Ship
          To:<br><br><b><?= $po->getShipToName() ?></b><br><?= $po->getShipToAddress(); ?>
          <br>T: <?= $po->getShipToMobileNo() ?><br>E-Mail: <?= $po->getShipToEmailId() ?>
          <br>GSTIN: <?= $po->getShipToGstNo() ?></td>
        <td colspan="4" valign="top">Delivery Terms And Condition : <br><br><?= $po->getDeliveryTermsAndCondition() ?>
          <br>
      </tr>
      <tr>
        <td width="35" align="center">Sr</td>
        <td width="400" align="center">Descriptions of Goods</td>
        <td width="168" align="center">SKU</td>
        <td width="68" align="center">Qty</td>
        <td width="60" align="center">Rate</td>
        <td width="60" align="center">Discount</td>
        <td width="62" align="center">Taxable Value</td>
        <td width="57" align="center">CGST</td>
        <td width="60" align="center">SGST</td>
        <td width="69" align="center">Amount</td>
      </tr>
      <?php

      $totalTaxable = 0;
      $totalQty = 0;
      $totalAmount = 0;
      $totaCgst = 0;
      $totalSgst = 0;
      $productDetails = po_products::where('po_products.poId', $po->getId())->read_all();
      $num = 1;
      foreach ($productDetails as $productDetail){
      ?>
      <tr>
        <td height="40" align="center"><?= $num ?></td>
        <td><?= $productDetail->getDescription() . '-' . $productDetail->getFabric() ?></td>
        <td><?= $productDetail->getVendorSkuCode() ?></td>
        <td align="center"><?= $quantity = !empty($productDetail->getQty()) ? $productDetail->getQty() : 0 ?></td>
        <td align="right"><?= $productDetail->getUnitPrice()?></td>
        <td align="center"><?= '-'; ?></td>
        <td align="right"><?= $productDetail->getAmount() ?></td>
        <? if($po->getPoDate() >= '2021-05-05'){ ?>
        <? $igsts = ($productDetail->getTax()); $finalgst = $igsts / 2;?>
        <td align="right"><?= $sgst = round($finalgst, 2, PHP_ROUND_HALF_UP);  ?></td>
        <td align="right"><?= $cgst = round($finalgst, 2, PHP_ROUND_HALF_UP);  ?></td>
        <?}else{?>
        <? $igsts = ($productDetail->getAmount() * $po->getGst()) / 100; $finalgst = $igsts / 2;?>
        <td align="right"><?= $sgst = round($finalgst, 2, PHP_ROUND_HALF_UP);  ?></td>
        <td align="right"><?= $cgst = round($finalgst, 2, PHP_ROUND_HALF_UP);  ?></td>
        <?}?>
        <? $amounts = $productDetail->getAmount() + $igsts;
        $amount = round($amounts, 2, PHP_ROUND_HALF_UP);  ?>
        <td align="right"><?= ceil($amount); ?></td>
      </tr>
      <?php

      $num++;
      $totalQty += $quantity;
      $totalTaxable += $productDetail->getAmount();
      $totalSgst += $sgst;
      $totaCgst += $cgst;
      $totalAmount += $amount;
      }?>
      <tr>
        <td height="40"></td>
        <td><b></b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
      </tr>
      <tr>
        <td height="25"></td>
        <td>Total</td>
        <td></td>
        <td align="center"><?= $totalQty; ?></td>
        <td></td>
        <td align="right"></td>
        <td align="right"><?= $totalTaxable; ?></td>
        <td align="right"><?= $totaCgst?></td>
        <td align="right"><?= $totalSgst?></td>
        <? $roundValue = round($totalAmount, 2, PHP_ROUND_HALF_UP); $amountWord = ceil($roundValue);  ?>
        <td align="right"><?= $amountWord;?></td>
      </tr>
      <tr>
        <td height="85" colspan="10" style="border-bottom:0px ">
          <div style="text-align: end"><b>E. & O.E</b></div>
          Amount Chargeable (in words)<br><b> <?= getIndianCurrency($amountWord)  ?> Only</b><br><br>Tax is payable on
          reverse charge basis: No</br></td>
      </tr>
      <tr>
        <td height="113" colspan="5" style="border-top:0px "><b><u>Declaration</u></b><br><br><b>
            1. We declare that this Purchase Order shows the actual price of
            the goods described and that all particulars are true and
            correct.<br>
            2. All Disputes are subject to <?= $companies->getJurisdiction(); ?>
            jurisdiction only.</b>
        </td>
        <td colspan="6" valign="bottom" align="center">
          <div style="margin-bottom: 70px"><b>For <?= $companies->getBillingName(); ?></b></div>
          <b>Authorised Signatory</b></td>
      </tr>
    </table>
    <p><b>*This is a Computer Generated Purchase Order</b></p>
    <p></p>
  </div>
@endsection
