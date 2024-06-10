<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerBillAddress;
use App\Models\CustomerShipAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\apps\Master;
use Illuminate\Support\Facades\Mail;


class CustomerMasterController extends Controller
{
  public function index()
  {
    return view('content.customer-master.list');
  }

  public function create()
  {
    return view('content.customer-master.create');
  }

  public function store(Request $request)
  {

    $this->validate(request(), [
      'CompanyName' => 'required',
      'BuyerName' => 'required',
      'BuyerMobile' => 'required',
      'email' => 'required',
      'billing_gst_no' => 'required',
      'billing_address_line1' => 'required',
      'billing_city' => 'required',
      'billing_state' => 'required',
      'billing_pincode' => 'required',
    ]);

    $Customer = new Customer([
      'company_name' => $request->CompanyName,
      'buyer_name' => $request->BuyerName,
      'buyer_number' => $request->BuyerMobile,
      'email' => $request->email,
      'gst_no' => $request->billing_gst_no,
    ]);

    $CustomerResult = $Customer->save();

    if ($CustomerResult) {
      $CustomerId = $Customer->id;


      $CustomerBillAddress = new CustomerBillAddress([
        'customer_id' => $CustomerId,
        'b_address1' => $request->billing_address_line1,
        'b_address2' => $request->billing_address_line2,
        'b_city' => $request->billing_city,
        'b_state' => $request->billing_state,
        'b_pincode' => $request->billing_pincode,
      ]);
      $CustomerBillAddress->save();

      $ShppingAddressLine1 = $request->ShppingAddressLine1;
      $ShppingAddressLine2 = $request->ShppingAddressLine2;
      $ShippingCity = $request->ShippingCity;
      $ShippingState = $request->ShippingState;
      $ShippingPincode = $request->ShippingPincode;
      $GSTNumber = $request->GSTNumber;
      $ShippingBuyerName = $request->ShippingBuyerName;
      $ShippingBuyerMobile = $request->ShippingBuyerMobile;
      $ShippingEmail = $request->ShippingEmail;

      if (count($ShppingAddressLine1) > 0) {
        $shippingCount = 1;
        for ($i = 0; $i < count($ShppingAddressLine1); $i++) {

          $CustomerShipAddress = new CustomerShipAddress([
            'customer_id' => $CustomerId,
            'name' => $ShippingBuyerName[$i],
            'mobile' => $ShippingBuyerMobile[$i],
            'email' => $ShippingEmail[$i],
            's_address1' => $ShppingAddressLine1[$i],
            's_address2' => $ShppingAddressLine2[$i],
            's_city' => $ShippingCity[$i],
            's_state' => $ShippingState[$i],
            's_pincode' => $ShippingPincode[$i],
            'gst_number' => $GSTNumber[$i],
            'shipping_count' => $shippingCount,
          ]);
          $shippingCount++;
          $CustomerShipAddress->save();
        }
      }
      if (!empty($Customer->email)) {
        Mail::send('content.authentications.auth-register-mail', ['name' => $Customer->person_name], function ($message) use ($Customer) {
          $message->to($Customer->email)
            ->subject('Your Registration Successfully');
        });
      }
      if ($request->AddMore) {
        return redirect()->action([CustomerMasterController::class, 'create'])->withSuccess('Successfully Done');
      } else {
        return redirect()->action([CustomerMasterController::class, 'index'])->withSuccess('Successfully Done');
      }
    } else {
      return redirect()->action([CustomerMasterController::class, 'index'])->withErrors('Poor Data entry');
    }
  }

  public function delete(Request $request)
  {
    $Customer = Customer::where('id', $request->customerId)->delete();
    if ($Customer) {
      $CustomerBillAddress = CustomerBillAddress::where('customer_id', $request->customerId)->delete();
      $CustomerShipAddress = CustomerShipAddress::where('customer_id', $request->customerId)->delete();

      return redirect()->action([CustomerMasterController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([CustomerMasterController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }
  public function edit($id)
  {
    $Customer = Customer::with('CustomerBillAddress', 'CustomerShipAddress')->where('id', $id)->first();
    return view('content.customer-master.edit', compact("Customer"));
  }

  public function update(Request $request, $id)
  {
    $this->validate(request(), [
      'CompanyName' => 'required',
      'BuyerName' => 'required',
      'BuyerMobile' => 'required',
      'email' => 'required',
      'billing_gst_no' => 'required',
      'billing_address_line1' => 'required',
      'billing_city' => 'required',
      'billing_state' => 'required',
      'billing_pincode' => 'required',
    ]);

    $Customer = Customer::where('id', $id)->update([
      'company_name' => $request->CompanyName,
      'buyer_name' => $request->BuyerName,
      'buyer_number' => $request->BuyerMobile,
      'email' => $request->email,
      'gst_no' => $request->billing_gst_no,
    ]);

    $ShippingId = $request->ShippingId;
    $ShippingCounter = $request->ShippingCounter;
    $ShippingBuyerName = $request->ShippingBuyerName;
    $ShippingBuyerMobile = $request->ShippingBuyerMobile;
    $ShippingEmail = $request->ShippingEmail;
    $ShppingAddressLine1 = $request->ShppingAddressLine1;
    $ShppingAddressLine2 = $request->ShppingAddressLine2;
    $ShippingCity = $request->ShippingCity;
    $ShippingState = $request->ShippingState;
    $ShippingPincode = $request->ShippingPincode;
    $GSTNumber = $request->GSTNumber;

    // $NewShippingCounter = $request->NewShippingCounter;
    $NewShippingBuyerName = $request->NewShippingBuyerName;
    $NewShippingBuyerMobile = $request->NewShippingBuyerMobile;
    $NewShippingEmail = $request->NewShippingEmail;
    $NewShppingAddressLine1 = $request->NewShppingAddressLine1;
    $NewShppingAddressLine2 = $request->NewShppingAddressLine2;
    $NewShippingCity = $request->NewShippingCity;
    $NewShippingState = $request->NewShippingState;
    $NewShippingPincode = $request->NewShippingPincode;
    $NewGSTNumber = $request->NewGSTNumber;

    if ($Customer) {
      $CustomerBillAddress = CustomerBillAddress::where('id', $request->BillingId)
        ->where('customer_id', $id)
        ->update([
          'customer_id' => $id,
          'b_address1' => $request->billing_address_line1,
          'b_address2' => $request->billing_address_line2,
          'b_city' => $request->billing_city,
          'b_state' => $request->billing_state,
          'b_pincode' => $request->billing_pincode,
        ]);
      // if ($CustomerBillAddress) {
      //   echo 'Done';
      // }

      if (!empty($request->ShippingId)) {
        foreach ($request->ShippingId as $shipKey => $shipData) {
          $CustomerShipAddress = CustomerShipAddress::where('id', $shipData)
            ->where('customer_id', $id)
            ->where('shipping_count', $ShippingCounter[$shipKey])
            ->update([
              'customer_id' => $id,
              'name' => $ShippingBuyerName[$shipKey] ?? NULL,
              'mobile' => $ShippingBuyerMobile[$shipKey] ?? NULL,
              'email' => $ShippingEmail[$shipKey] ?? NULL,
              's_address1' => $ShppingAddressLine1[$shipKey] ?? NULL,
              's_address2' => $ShppingAddressLine2[$shipKey] ?? NULL,
              's_city' => $ShippingCity[$shipKey] ?? NULL,
              's_state' => $ShippingState[$shipKey] ?? NULL,
              's_pincode' => $ShippingPincode[$shipKey] ?? NULL,
              'gst_number' => $GSTNumber[$shipKey] ?? NULL,
            ]);
        }
      }

 	if (!empty($NewShippingBuyerName)) {
        foreach ($NewShippingBuyerName as $ShipKey => $NewShipData) {
          if (!empty($NewShipData) || !empty($NewShippingBuyerMobile[$ShipKey]) || !empty($NewShppingAddressLine1[$ShipKey]) || !empty($NewShippingEmail[$ShipKey])) {
            $NewCustomerShipAddress = new CustomerShipAddress([
              'customer_id' => $id,
              'name' => $NewShipData,
              'mobile' => $NewShippingBuyerMobile[$ShipKey] ?? NULL,
              'email' => $NewShippingEmail[$ShipKey] ?? NULL,
              's_address1' => $NewShppingAddressLine1[$ShipKey] ?? NULL,
              's_address2' => $NewShppingAddressLine2[$ShipKey] ?? NULL,
              's_city' => $NewShippingCity[$ShipKey] ?? NULL,
              's_state' => $NewShippingState[$ShipKey] ?? NULL,
              's_pincode' => $NewShippingPincode[$ShipKey] ?? NULL,
              'gst_number' => $NewGSTNumber[$ShipKey] ?? NULL,
            ]);
            $NewCustomerShipAddress->save();
          }
        }
      }
      return redirect()->action([CustomerMasterController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([CustomerMasterController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  public function shippingDelete(Request $request)
  {
    $CustomerId = CustomerShipAddress::where('id', $request->shippingAddressId)->value('customer_id');
    $CustomerShipAddress = CustomerShipAddress::where('id', $request->shippingAddressId)->delete();

    $Customer = Customer::with('CustomerBillAddress', 'CustomerShipAddress')->where('id', $CustomerId)->first();

    // echo $CustomerId;
    if ($CustomerShipAddress) {
      return redirect()->route('customer-edit', ['id' => $CustomerId])->withSuccess('Successfully Done')->with(compact('Customer'));
    } else {
      return redirect()->route('customer-edit', ['id' => $CustomerId])->withSuccess('Successfully Done')->with(compact('Customer'));
    }
  }

  public function view($id)
  {
    $Customer = Customer::with('CustomerBillAddress', 'CustomerShipAddress')->where('id', $id)->first();
    return view('content.customer-master.view', compact("Customer"));
  }
}
