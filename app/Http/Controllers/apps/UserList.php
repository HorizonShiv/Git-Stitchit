<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserBank;
use App\Models\VendorCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserList extends Controller
{
  public function index()
  {
    if ((Auth::user()->role == 'vendor')) {
      $users = User::where("id", Auth::user()->id)->get();
    } else {
      $users = User::where('role', '!=', 'vendor')->get();
    }
    return view('content.apps.app-user-list', compact("users"));
  }
	
	
  public function UserCreate()
  {
    return view('content.apps.app-user-add');
  }
	
	
  public function UserStore(Request $request)
  {
	  
	    $this->validate(request(), [
      'company_name' => 'required',
      'contact_person_name' => 'required',
      'contact_person_mobile' => 'required',
      'email' => 'required',
      'gst_no' => 'required',
      'b_address1' => 'required',
      'b_city' => 'required',
      'b_state' => 'required',
      'b_pincode' => 'required',
    ]);

    $user = new User([
      'company_name' => $request->company_name,
      'person_name' => $request->contact_person_name,
      'email' => $request->email,
      'password' => Hash::make($request->contact_person_mobile),
      'gst_no' => $request->gst_no,
      'pancard_no' => $request->pancard_no,
      'role' => $request->role,
      'is_active' => !empty($request->status) ?  1 : 0,
      'person_mobile' => $request->contact_person_mobile,
    ]);

    $user->save();
    $user_id = $user->id;
    if ($user) {
      $userAddress = new UserAddress([
        'user_id' => $user_id,
        'b_address1' => $request->b_address1,
        'b_address2' => $request->b_address2,
        'b_city' => $request->b_city,
        'b_state' => $request->b_state,
        'b_pincode' => $request->b_pincode,
        'b_mobile' => $request->b_mobile,
        's_address1' => $request->s_address1,
        's_address2' => $request->s_address2,
        's_city' => $request->s_city,
        's_state' => $request->s_state,
        's_pincode' => $request->s_pincode,
        's_mobile' => $request->s_mobile
      ]);
      $userAddress->save();

      $userBank = new UserBank([
        'user_id' => $user_id,
        'account_no' => $request->account_number,
        'bank_name' => $request->account_bank_name,
        'account_name' => $request->account_name,
        'ifsc' => $request->account_ifsc,
      ]);
      $userBank->save();

      if ($request->gst_file) {
        $this->validate(request(), [
          'gst_file.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->gst_file;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/gst/' . $user_id . '/');
        if (!is_dir(public_path('/gst'))) {
          mkdir(public_path('/gst'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);

        User::where('id', $user_id)->update([
          "gst_file" => $new_file_name,
        ]);
      }

      if ($request->pancard_file) {
        $this->validate(request(), [
          'pancard_file.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        //  $files = array();
        //foreach ($request->pancard_file as $key => $pancard_number) {
        $file = $request->pancard_file;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/pancard/' . $user_id . '/');
        if (!is_dir(public_path('/pancard'))) {
          mkdir(public_path('/pancard'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);
        //array_push($files, public_path('/pancard/' . $userId . '/' . $new_file_name));
        User::where('id', $user_id)->update([
          "pancard_file" => $new_file_name,
        ]);
        //}
      }

      if ($request->cancelled_cheque) {
        $this->validate(request(), [
          'cancelled_cheque.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->cancelled_cheque;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/cheque/' . $user_id . '/');
        if (!is_dir(public_path('/cheque'))) {
          mkdir(public_path('/cheque'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);
        UserBank::where('user_id', $user_id)->update([
          "cancel_cheque" => $new_file_name,
        ]);
      }


      return redirect()->action([UserList::class, 'index'])->withSuccess('Data Update successfully');
    } else {
      return redirect()->action([UserList::class, 'UserCreate'])->withError('Something went wrong');
    }
  }

	public function vendorIndex()
  {
    if ((Auth::user()->role == 'vendor')) {
      $users = User::where("id", Auth::user()->id)->get();
    } else {
      $users = User::where('role', 'vendor')->get();
    }
    return view('content.apps.app-vendor-list', compact("users"));
  }

  public function vendorApprove(Request $request)
  {
    $userId = $request->user_id;
    $user = User::where("id", $userId)->first();
    if ($user->is_active == 1) {
      $status = Null;
    } else {
      $status = 1;
    }
    User::where('id', $userId)->update([
      'is_active' => $status,
    ]);
    // Send the email
    if (!empty($user->email)) {
      Mail::send('content.authentications.auth-approval-mail', ['name' => $user->person_name, $user], function ($message) use ($user) {
        $message->to($user->email)
          ->subject('Approve Successfully');
      });
    }
    echo 'success';
  }


  public function viewModelUserEdit(Request $request)
  {
    $id = $request->id;
    $companies = Company::all();
    $userCompanies = Company::where('user_id', $id)->get();

    $user = User::with(["UserAddress"])->where('id', $id)->first();
    $status = !empty($user->is_active) ? "checked" : "";
    $statusLabel = !empty($user->is_active) ? "Active" : "In Active";

    $statusDirectInvoice = !empty($user->direct_invoice) ? "checked" : "";
    $statusDirectInvoiceLabel = !empty($user->direct_invoice) ? "Yes" : "No";

    $html = '';
    $html .= '<form method="post" action="' . route('app-user-update', $id) . '" enctype="multipart/form-data">';

    $html .= '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="content">
          <div class="content-header mb-4">
            <h3>Update Vendor Details</h3>
          </div>';
    $html .= '<div class="row g-3 mt-2">';
    if (Auth::user()->role == 'admin') {
      $html .= '<div class="col-sm-6">Status : <label class="switch switch-success">
                            <input type="checkbox" name="status" class="switch-input" value="1" ' . $status . '>
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check mt-1"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x mt-1"></i>
                              </span>
                            </span>
                            <span class="switch-label">' . $statusLabel . '</span>
                          </label></div>

                           <div class="col-sm-6">
              <label class="form-label" for="role">Role</label>
              <select id="role" name="role" class="select2 form-select" data-allow-clear="role">
                 <option ' . (($user->role == 'vendor') ? "Selected" : "") . ' value="vendor">Vendor</option>
                <option ' . (($user->role == 'account') ? "Selected" : "") . ' value="account">Account</option>
                <option ' . (($user->role == 'warehouse') ? "Selected" : "") . ' value="warehouse">Warehouse</option>
                <option ' . (($user->role == 'admin') ? "Selected" : "") . ' value="admin">Admin</option>
                <option ' . (($user->role == 'merchant') ? "Selected" : "") . ' value="merchant">Merchant</option>
                <option ' . (($user->role == 'designer') ? "Selected" : "") . ' value="designer">Designer</option>
                </select>
                </div>
                <div class="col-sm-6">Direct Invoice Generate : <label class="switch switch-success">
                            <input type="checkbox" name="direct_invoice" class="switch-input" value="1" ' . $statusDirectInvoice . '>
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check mt-1"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x mt-1"></i>
                              </span>
                            </span>
                            <span class="switch-label">' . $statusDirectInvoiceLabel . '</span>
                          </label></div>
                          ';
    }

    $html .= '<div class="col-sm-6">
              <label class="form-label" for="company_name">Company Name </label>
              <input type="text" name="company_name" id="company_name" value="' . $user->company_name . '" class="form-control"
                     placeholder="enter company name"/>
            </div>';
    $html .= '<div class="col-sm-6">
              <label class="form-label" for="contact_person_name">Contact Person Name </label>
              <input type="text" name="contact_person_name" value="' . $user->person_name . '" id="contact_person_name" class="form-control"
                     placeholder="enter contact person name"/>
            </div>
            <div class="col-sm-6">
              <label class="form-label" for="contact_person_mobile">Contact Person Mobile </label>
              <input type="text" name="contact_person_mobile" value="' . $user->person_mobile . '" id="contact_person_mobile" class="form-control"
                     placeholder="enter contact person mobile"/>
            </div>
            <div class="col-sm-6">
              <label class="form-label" for="email">Email</label>
              <input type="email" name="email" id="email" value="' . $user->email . '" class="form-control"
                     placeholder="john.doe@email.com" aria-label="john.doe"/>
            </div>';
    $html .= '<div class="col-sm-6">
              <label class="form-label" for="email">GST</label>
              <input type="text" name="gst_no" id="gst_no" value="' . $user->gst_no . '" class="form-control"
                     placeholder="GST No"/>
            </div>';

    $html .= '<div class="col-sm-6">
              <label class="form-label" for="email">GST Certificate File</label>
              <input type="file" name="gst_file" id="gst_file" class="form-control"/>';
    if (!empty($user->gst_file)) {
      $html .= '<a target ="_blank" href="' . url('gst / ' . $user->id . ' / ' . $user->gst_file) . '" > Download
                    File </a >';
    }
    $html .= '</div>';

    $html .= '<div class="col-sm-6">
              <label class="form-label" for="pancard_no">PanCard</label>
              <input type="text" name="pancard_no" id="pancard_no" value="' . $user->pancard_no . '" class="form-control"
                     placeholder="pancard no"/>
            </div>';

    $html .= '<div class="col-sm-6">
              <label class="form-label" for="pancard_file">PanCard File</label>
              <input type="file" name="pancard_file" id="pancard_file" class="form-control"/>';
    if (!empty($user->pancard_file)) {
      $html .= '<a target ="_blank" href="' . url('pancard / ' . $user->id . ' / ' . $user->pancard_file) . '" >Download
                    File </a >';
    }
    $html .= '</div>';


    $html .= '</div>
        </div>
        <div class="mt-2 content">
          <div class="content-header">
            <h3 class="mb-1">Billing Information</h3>
            <p>Enter Your Billing Information</p>
          </div>
          <div class="row g-3">

            <div class="col-md-12">
              <label class="form-label" for="b_address1">Address Line 1</label>
              <input type="text" id="b_address1" value="' . ($user->UserAddress->b_address1 ?? '') . '" name="b_address1" class="form-control"
                     placeholder="Address Line 1"/>
            </div>
            <div class="col-md-12">
              <label class="form-label" for="b_address2">Address Line 2</label>
              <input type="text" id="b_address2" name="b_address2" value="' . ($user->UserAddress->b_address2 ?? '') . '" class="form-control"
                     placeholder="Address Line 2"/>
            </div>
            <div class="col-sm-4">
              <label class="form-label" for="b_city">City</label>
              <input type="text" id="b_city" name="b_city" class="form-control" value="' . ($user->UserAddress->b_city ?? '') . '" placeholder="city"/>
            </div>
            <div class="col-sm-4">
              <label class="form-label" for="b_state">State</label>
              <select id="b_state" name="b_state" class="select2 form-select" data-allow-clear="true">
                <option value="' . ($user->UserAddress->b_state ?? '') . '">' . ($user->UserAddress->b_state ?? '') . '</option>
                <option value="">Select</option>
                <option value="Andra Pradesh">Andra Pradesh</option>
                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="Madya Pradesh">Madya Pradesh</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Manipur">Manipur</option>
                <option value="Meghalaya">Meghalaya</option>
                <option value="Mizoram">Mizoram</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Orissa">Orissa</option>
                <option value="Punjab">Punjab</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Sikkim">Sikkim</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Telangana">Telangana</option>
                <option value="Tripura">Tripura</option>
                <option value="Uttaranchal">Uttaranchal</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="West Bengal">West Bengal</option>
                <option disabled style="background-color:#aaa; color:#fff">UNION Territories</option>
                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                <option value="Daman and Diu">Daman and Diu</option>
                <option value="Delhi">Delhi</option>
                <option value="Lakshadeep">Lakshadeep</option>
                <option value="Pondicherry">Pondicherry</option>
              </select>
            </div>

            <div class="col-sm-4">
              <label class="form-label" for="b_pincode">Pincode</label>
              <input type="text" id="b_pincode" value="' . ($user->UserAddress->b_pincode ?? '') . '" name="b_pincode"
                     class="form-control multi-steps-pincode" placeholder="Pin Code" maxlength="6"/>
            </div>
          </div>
        </div>

        <div class="mt-3 content" hidden>
          <div class="content-header">
            <h3 class="mb-1">Shipping Information</h3>
            <p>Enter Your Shipping Information</p>
          </div>
          <div class="row g-3">
            <div class="col-md-12">
              <label class="form-label" for="s_address1">Address Line 1</label>
              <input type="text" id="s_address1" value="' . ($user->UserAddress->s_address1 ?? '') . '" name="s_address1" class="form-control"
                     placeholder="Address Line 1"/>
            </div>
            <div class="col-md-12">
              <label class="form-label" for="s_address2">Address Line 2</label>
              <input type="text" id="s_address2" name="s_address2" value="' . ($user->UserAddress->s_address2 ?? '') . '" class="form-control"
                     placeholder="Address Line 2"/>
            </div>
            <div class="col-sm-4">
              <label class="form-label" for="s_city">City</label>
              <input type="text" id="s_city" name="s_city" value="' . ($user->UserAddress->s_city ?? '') . '" class="form-control" placeholder="city"/>
            </div>
            <div class="col-sm-4">
              <label class="form-label" for="s_state">State</label>
              <select id="s_state" name="s_state" class="select2 form-select" data-allow-clear="true">
               <option value="' . ($user->UserAddress->s_state ?? '') . '">' . ($user->UserAddress->s_state ?? '') . '</option>
                <option value="">Select</option>
                <option value="Andra Pradesh">Andra Pradesh</option>
                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="Madya Pradesh">Madya Pradesh</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Manipur">Manipur</option>
                <option value="Meghalaya">Meghalaya</option>
                <option value="Mizoram">Mizoram</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Orissa">Orissa</option>
                <option value="Punjab">Punjab</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Sikkim">Sikkim</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Telangana">Telangana</option>
                <option value="Tripura">Tripura</option>
                <option value="Uttaranchal">Uttaranchal</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="West Bengal">West Bengal</option>
                <option disabled style="background-color:#aaa; color:#fff">UNION Territories</option>
                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                <option value="Daman and Diu">Daman and Diu</option>
                <option value="Delhi">Delhi</option>
                <option value="Lakshadeep">Lakshadeep</option>
                <option value="Pondicherry">Pondicherry</option>
              </select>
            </div>

            <div class="col-sm-4">
              <label class="form-label" for="s_pincode">Pincode</label>
              <input type="text" id="s_pincode" name="s_pincode"
                     class="form-control multi-steps-pincode" value="' . ($user->UserAddress->s_pincode ?? '') . '" placeholder="Pin Code" maxlength="6"/>
            </div>
          </div>
        </div>';

    $html .= '<div class="content-header mt-4">
            <h3>Bank Details</h3>
          </div>
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-label" for="account_number">Account No </label>
              <input type="text" name="account_number" id="account_number" value="' . ($user->UserBank->account_no ?? '') . '" class="form-control"
                     placeholder="enter Account No"/>
            </div>
            <div class="col-sm-6">
              <label class="form-label" for="account_name">Account Name </label>
              <input type="text" name="account_name" value="' . ($user->UserBank->account_name ?? '') . '" id="account_name" class="form-control"
                     placeholder="enter account name"/>
            </div>
            <div class="col-sm-6">
              <label class="form-label" for="account_bank_name">Bank Name </label>
              <input type="text" name="account_bank_name" value="' . ($user->UserBank->bank_name ?? '') . '" id="account_bank_name" class="form-control"
                     placeholder="Enter Account Bank Name"/>
            </div>
            <div class="col-sm-6">
              <label class="form-label" for="account_ifsc">IFSC</label>
              <input type="text" name="account_ifsc" id="account_ifsc" value="' . ($user->UserBank->ifsc ?? '') . '" class="form-control"/>
            </div>';
    $html .= '<div class="col-sm-6">
              <label class="form-label" for="cancel_cheque">Cancel Cheque</label>
              <input type="file" name="cancelled_cheque" id="cancelled_cheque" class="form-control"/>';
    if (!empty($user->pancard_file)) {
      $html .= '<a target ="_blank" href="' . url('cheque / ' . $user->id . ' / ' . $user->cancel_cheque) . '" >Download
                    File </a >';
    }
    $html .= '</div>';


    $html .= ' </div>
        </div>';
    $vendorCompanies = VendorCompany::where("user_id", $id)->get();
    $vendorCompanyId = array();
    foreach ($vendorCompanies as $vendorCompany) {
      array_push($vendorCompanyId, $vendorCompany->company_id);
    }

    $html .= '<div class="content-header mt-4">
            <h3>Assign Company</h3>
          </div>
          <div class="row g-3">

                <select class="form-control select2" name="vendor_company_id[]" multiple
                            id="vendor_company_id">
                        <option value="">Select Company</option>';

    if (!empty($companies)) {
      foreach ($companies as $company) {

        $html .= '<option  value="' . $company->id . '"';
        if (in_array($company->id, $vendorCompanyId)) {
          $html .= 'selected';
        }
        $html .= '>' . $company->c_name . '</option>';
      }
    }
    $html .= '</select>
          </div>
        </div>';


    $html .= '<button type="submit" class="mt-3 btn btn-primary me-3 waves-effect waves-light" name="submit">Submit</button>';
    $html .= '<input type="hidden" name="id" value="' . $id . '">
            <input type="hidden" name="_method" value="PUT">
          <input type="hidden" name="_token" id="csrf-token" value="' . Session::token() . '" />
        </form>';
    echo $html;
  }

  public function update(Request $request, $id)
  {
    VendorCompany::where("user_id", $id)->delete();
    if (isset($request->vendor_company_id) && count($request->vendor_company_id) >= 1) {
      foreach ($request->vendor_company_id as $vc_id) {
        if (!empty($vc_id)) {
          $vendorCompany = new VendorCompany([
            'user_id' => $id,
            'company_id' => $vc_id,
          ]);
          $vendorCompany->save();
        }
      }
    }
    $checkUser = User::where("id", $id)->first();
    if ($checkUser) {
      if (isset($request->status)) {
        $status = $request->status;
      } else {
        $status = $checkUser->is_active;
      }

      if (isset($request->direct_invoice)) {
        $directInvoice = $request->direct_invoice;
      } else {
        $directInvoice = $checkUser->direct_invoice;
      }

      if (isset($request->role)) {
        $role = $request->role;
      } else {
        $role = $checkUser->role;
      }
      User::where('id', $id)->update([
        'company_name' => $request->company_name,
        'person_name' => $request->contact_person_name,
        'email' => $request->email,
        'gst_no' => $request->gst_no,
        'pancard_no' => $request->pancard_no,
        'role' => $role,
        'is_active' => $status,
        'direct_invoice' => $directInvoice,
        'person_mobile' => $request->contact_person_mobile,
      ]);


      $checkUserBank = UserBank::where("user_id", $id)->first();
      if ($checkUserBank) {
        $bank_id = $checkUserBank->id;
        UserBank::where('user_id', $id)->update([
          'account_no' => $request->account_number,
          'bank_name' => $request->account_bank_name,
          'account_name' => $request->account_name,
          'ifsc' => $request->account_ifsc,
        ]);
      } else {
        $userBank = new UserBank([
          'user_id' => $id,
          'account_no' => $request->account_number,
          'bank_name' => $request->account_bank_name,
          'account_name' => $request->account_name,
          'ifsc' => $request->account_ifsc,
        ]);
        $userBank->save();
        $bank_id = $userBank->id;
      }
      $checkUserAddress = UserAddress::where("user_id", $id)->first();
      if ($checkUserAddress) {
        UserAddress::where('user_id', $id)->update([
          'b_address1' => $request->b_address1,
          'b_address2' => $request->b_address2,
          'b_city' => $request->b_city,
          'b_state' => $request->b_state,
          'b_pincode' => $request->b_pincode,
          'b_mobile' => $request->b_mobile,
          's_address1' => $request->s_address1,
          's_address2' => $request->s_address2,
          's_city' => $request->s_city,
          's_state' => $request->s_state,
          's_pincode' => $request->s_pincode,
          's_mobile' => $request->s_mobile
        ]);
      } else {
        $userAddress = new UserAddress([
          'user_id' => $id,
          'b_address1' => $request->b_address1,
          'b_address2' => $request->b_address2,
          'b_city' => $request->b_city,
          'b_state' => $request->b_state,
          'b_pincode' => $request->b_pincode,
          'b_mobile' => $request->b_mobile,
          's_address1' => $request->s_address1,
          's_address2' => $request->s_address2,
          's_city' => $request->s_city,
          's_state' => $request->s_state,
          's_pincode' => $request->s_pincode,
          's_mobile' => $request->s_mobile
        ]);
        $userAddress->save();
      }

      if ($request->gst_file) {
        $this->validate(request(), [
          'gst_file.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->gst_file;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/gst/' . $id . '/');
        if (!is_dir(public_path('/gst'))) {
          mkdir(public_path('/gst'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);

        User::where('id', $id)->update([
          "gst_file" => $new_file_name,
        ]);
      }

      if ($request->pancard_file) {
        $this->validate(request(), [
          'pancard_file.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        //  $files = array();
        //foreach ($request->pancard_file as $key => $pancard_number) {
        $file = $request->pancard_file;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/pancard/' . $id . '/');
        if (!is_dir(public_path('/pancard'))) {
          mkdir(public_path('/pancard'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);
        //array_push($files, public_path('/pancard/' . $userId . '/' . $new_file_name));
        User::where('id', $id)->update([
          "pancard_file" => $new_file_name,
        ]);
        //}
      }

      if ($request->cancelled_cheque) {
        $this->validate(request(), [
          'cancelled_cheque.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->cancelled_cheque;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/cheque/' . $bank_id . '/');
        if (!is_dir(public_path('/cheque'))) {
          mkdir(public_path('/cheque'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);
        UserBank::where('id', $bank_id)->update([
          "cancel_cheque" => $new_file_name,
        ]);
      }


      return redirect()->action([UserList::class, 'index'])->withSuccess('Data Update successfully');

    } else {
      return response()->json(['status' => 'error', 'message' => 'Already Exit email ID']);
    }
  }

	public function setVendorType(Request $request)
	{

    $User = User::where('id', $request->vendor_d)->update([
      'vendor_type' => $request->vendor_name,
    ]);

    // dd($request->toArray());

    if($User){
      echo 'success';
    }
  }

}
