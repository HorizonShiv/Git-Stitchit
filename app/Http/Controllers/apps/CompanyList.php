<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyShipAddress;
use Illuminate\Http\Request;
use App\Models\Setting;

class CompanyList extends Controller
{
  public function index()
  {
    $companies = Company::all();
    return view('content.apps.app-company-list', compact("companies"));
  }

  public function store(Request $request)
  {
    // dd($request);
	$this->validate(request(), [
      'po_no_set' => 'required|numeric',
      'gnr_no_set' => 'required|numeric',
      'sales_order_no_set' => 'required|numeric',
      'order_planning_no_set' => 'required|numeric',
      'job_order_no_set' => 'required|numeric',
    ]);
	  
    $userId = '1';
    $company = new Company([
      'user_id' => $userId,
      'b_name' => $request->b_name,
      'pre_fix' => $request->pre_fix,
      'po_no_set' => $request->po_no_set,
      'c_name' => $request->c_name,
      'pancard_gst_no' => $request->pancard_gst_no,
      'check_document' => $request->check_document,
      'b_address1' => $request->b_address1,
      'b_address2' => $request->b_address2,
      'b_city' => $request->b_city,
      'b_state' => $request->b_state,
      'b_pincode' => $request->b_pincode,
      'b_email' => $request->b_email,
      'b_mobile' => $request->b_mobile,
    ]);
    $result = $company->save();
    // $result='123';
    if ($result) {
      $company_id = $company->id;

      $Setting = new Setting([
        'invoice_type' => '1',
        'company_id' => $company_id,
        'po_pre_fix' => $request->pre_fix,
        'po_no_set' => $request->po_no_set,
        'grn_pre_fix' => $request->grn_pre_fix,
        'gnr_no_set' => $request->gnr_no_set,
        'sales_order_pre_fix' => $request->sales_order_pre_fix,
        'sales_order_no_set' => $request->sales_order_no_set,
        'order_planning_pre_fix' => $request->order_planning_pre_fix,
        'order_planning_no_set' => $request->order_planning_no_set,
        'job_order_pre_fix' => $request->job_order_pre_fix,
        'job_order_no_set' => $request->job_order_no_set,
      ]);

      $resultSetting = $Setting->save();

      $ShppingAddressLine1 = $request->s_address1;
      $ShppingAddressLine2 = $request->s_address2;
      $ShippingCity = $request->s_city;
      $ShippingState = $request->s_state;
      $ShippingPincode = $request->s_pincode;

      $GSTNumber = $request->gst_no;
      // $ShippingName = $request->s_name;
      $ShippingCompanyName = $request->s_company_name;
      $ShippingMobile = $request->s_mobile;
      $ShippingEmail = $request->s_email;

      // dd($request->toArray());

      if (count($ShppingAddressLine1) > 0) {
        $shippingCount = 1;
        for ($i = 0; $i < count($ShppingAddressLine1); $i++) {

          $CompanyShipAddress = new CompanyShipAddress([
            'company_id' => $company_id,
            // 'name' => $ShippingName[$i],
            'company_name' => $ShippingCompanyName[$i],
            'mobile' => $ShippingMobile[$i],
            'email' => $ShippingEmail[$i],
            'address1' => $ShppingAddressLine1[$i],
            'address2' => $ShppingAddressLine2[$i],
            'city' => $ShippingCity[$i],
            'state' => $ShippingState[$i],
            'pincode' => $ShippingPincode[$i],
            'gst_number' => $GSTNumber[$i],
            'shipping_count' => $shippingCount,
          ]);
          $shippingCount++;
          $CompanyShipAddress->save();
        }
      }


      if ($request->pancard_gst_file) {
        $this->validate(request(), [
          'pancard_gst_file.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->pancard_gst_file;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/pancard_gst_file/' . $company_id . '/');
        if (!is_dir(public_path('/pancard_gst_file'))) {
          mkdir(public_path('/pancard_gst_file'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);
        Company::where('id', $company_id)->update([
          "pancard_gst_file" => $new_file_name,
        ]);
      }
      return redirect()->action([CompanyList::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([CompanyList::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  public function view($id)
  {
    $company = Company::with("CompanyShipAddress","Setting")->where('id', $id)->first();
    return view('content.apps.app-company-view', compact("company"));
  }

  public function edit($id)
  {
    $company = Company::with("CompanyShipAddress")->where('id', $id)->first();
    //dd($company);
    return view('content.apps.app-company-edit', compact("company"));
  }

  public function update(Request $request, $id)
  {
    $userId = '1';
	  $this->validate(request(), [
      'po_no_set' => 'required|numeric',
      'gnr_no_set' => 'required|numeric',
      'sales_order_no_set' => 'required|numeric',
      'order_planning_no_set' => 'required|numeric',
      'job_order_no_set' => 'required|numeric',
    ]);
    $company = Company::where('id', $id)->update([
      'user_id' => $userId,
      'c_name' => $request->c_name,
      'pre_fix' => $request->pre_fix,
      'po_no_set' => $request->po_no_set,
      'pancard_gst_no' => $request->pancard_gst_no,
      'check_document' => $request->check_document,
      'b_name' => $request->b_name,
      'b_address1' => $request->b_address1,
      'b_address2' => $request->b_address2,
      'b_city' => $request->b_city,
      'b_state' => $request->b_state,
      'b_pincode' => $request->b_pincode,
      'b_email' => $request->b_email,
      'b_mobile' => $request->b_mobile,
    ]);

    $Setting = Setting::where('company_id', $id)->update([
      'po_pre_fix' => $request->pre_fix,
      'po_no_set' => $request->po_no_set,
      'grn_pre_fix' => $request->grn_pre_fix,
      'gnr_no_set' => $request->gnr_no_set,
      'sales_order_pre_fix' => $request->sales_order_pre_fix,
      'sales_order_no_set' => $request->sales_order_no_set,
      'order_planning_pre_fix' => $request->order_planning_pre_fix,
      'order_planning_no_set' => $request->order_planning_no_set,
      'job_order_pre_fix' => $request->job_order_pre_fix,
      'job_order_no_set' => $request->job_order_no_set,
      'style_number_pre_fix' => $request->style_number_pre_fix,
      'style_number_no_set' => $request->style_number_no_set,
    ]);
    if ($company) {

      $ShippingId = $request->s_id;
      $ShippingCounter = $request->s_counter;

      $ShppingAddressLine1 = $request->s_address1;
      $ShppingAddressLine2 = $request->s_address2;
      $ShippingCity = $request->s_city;
      $ShippingState = $request->s_state;
      $ShippingPincode = $request->s_pincode;

      $GSTNumber = $request->gst_no;
      // $ShippingName = $request->s_name;
      $ShippingCompanyName = $request->s_company_name;
      $ShippingMobile = $request->s_mobile;
      $ShippingEmail = $request->s_email;

      if (!empty($ShippingId)) {
        for ($i = 0; $i < count($ShippingId); $i++) {
          $CompanyShipAddress = CompanyShipAddress::where('id', $ShippingId[$i])
            ->where('company_id', $id)
            ->where('shipping_count', $ShippingCounter[$i])
            ->update([
              // 'name' => $ShippingName[$i],
              'company_name' => $ShippingCompanyName[$i],
              'mobile' => $ShippingMobile[$i],
              'email' => $ShippingEmail[$i],
              'address1' => $ShppingAddressLine1[$i],
              'address2' => $ShppingAddressLine2[$i],
              'city' => $ShippingCity[$i],
              'state' => $ShippingState[$i],
              'pincode' => $ShippingPincode[$i],
              'gst_number' => $GSTNumber[$i],
            ]);

          if ($i == (count($ShippingId) - 1)) {
            $counter = $ShippingCounter[$i] + 1;
          }
        }
      } else {
        $counter = '1';
      }

      // $NewShippingName = $request->new_s_name;
      $NewShippingCompanyName = $request->new_s_company_name;
      $NewShippingMobile = $request->new_s_mobile;
      $NewShippingEmail = $request->new_s_email;

      $NewShppingAddressLine1 = $request->new_s_address1;
      $NewShppingAddressLine2 = $request->new_s_address2;
      $NewShippingCity = $request->new_s_city;
      $NewShippingState = $request->new_s_state;
      $NewShippingPincode = $request->new_s_pincode;
      $NewGSTNumber = $request->new_gst_no;

      if (!empty($NewShippingCompanyName[0])) {
        for ($i = 0; $i < count($NewShippingCompanyName); $i++) {
          $CompanyShipAddress = new CompanyShipAddress([
            'company_id' => $id,
            // 'name' => $NewShippingName[$i],
            'company_name' => $NewShippingCompanyName[$i],
            'mobile' => $NewShippingMobile[$i],
            'email' => $NewShippingEmail[$i],
            'address1' => $NewShppingAddressLine1[$i],
            'address2' => $NewShppingAddressLine2[$i],
            'city' => $NewShippingCity[$i],
            'state' => $NewShippingState[$i],
            'pincode' => $NewShippingPincode[$i],
            'gst_number' => $NewGSTNumber[$i],
            'shipping_count' => $counter,
          ]);
          $counter++;
          $CompanyShipAddress->save();
        }
      }


      if ($request->pancard_gst_file) {
        $this->validate(request(), [
          'pancard_gst_file.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->pancard_gst_file;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/pancard_gst_file/' . $id . '/');
        if (!is_dir(public_path('/pancard_gst_file'))) {
          mkdir(public_path('/pancard_gst_file'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);
        Company::where('id', $id)->update([
          "pancard_gst_file" => $new_file_name,
        ]);
      }
      return redirect()->action([CompanyList::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([CompanyList::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  public function deleteShipAddress(Request $request)
  {

   $CompanyId = CompanyShipAddress::where('id', $request->shippingAddressId)->value('company_id');
    $CompanyShipAddress = CompanyShipAddress::where('id', $request->shippingAddressId)->delete();

    $company = Company::with("CompanyShipAddress")->where('id', $CompanyId)->first();

    // echo $CustomerId;
    if ($CompanyShipAddress) {
      return redirect()->route('app-company-edit', ['id' => $CompanyId])->withSuccess('Successfully Done')->with(compact('company'));
    } else {
      return redirect()->route('app-company-edit', ['id' => $CompanyId])->withSuccess('Successfully Done')->with(compact('company'));
    }
  }
}
