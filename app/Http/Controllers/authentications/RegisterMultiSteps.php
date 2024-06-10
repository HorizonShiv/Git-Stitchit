<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserBank;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class RegisterMultiSteps extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-register-multisteps', ['pageConfigs' => $pageConfigs]);
  }

  public function store(Request $request)
  {
    $checkUser = User::where("email", $request->email)->first();
    if (!$checkUser) {
      $user = new User([
        'company_name' => $request->company_name,
        'person_name' => $request->contact_person_name,
        'email' => $request->email,
        'role' => "vendor",
        'gst_no' => $request->gst_number,
        'pancard_no' => $request->pancard_number,
        'person_mobile' => $request->contact_person_mobile
      ]);
      $result = $user->save();

      if ($result) {
        $userId = $user->id;
        $userAddress = new UserAddress([
          'user_id' => $userId,
          'b_address1' => $request->b_address1,
          'b_address2' => $request->b_address2,
          'b_city' => $request->b_city,
          'b_state' => $request->b_state,
          'b_pincode' => $request->b_pincode,
          'b_mobile' => $request->b_mobile
        ]);
        $userAddress->save();
        $userBank = new UserBank([
          'user_id' => $userId,
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
          $destination_path = public_path('/gst/' . $userId . '/');
          if (!is_dir(public_path('/gst'))) {
            mkdir(public_path('/gst'), 0755, true);
          }
          $file->move($destination_path, $new_file_name);

          User::where('id', $userId)->update([
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
          $destination_path = public_path('/pancard/' . $userId . '/');
          if (!is_dir(public_path('/pancard'))) {
            mkdir(public_path('/pancard'), 0755, true);
          }
          $file->move($destination_path, $new_file_name);
          //array_push($files, public_path('/pancard/' . $userId . '/' . $new_file_name));
          User::where('id', $userId)->update([
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
          $destination_path = public_path('/cheque/' . $userId . '/');
          if (!is_dir(public_path('/cheque'))) {
            mkdir(public_path('/cheque'), 0755, true);
          }
          $file->move($destination_path, $new_file_name);
          UserBank::where('id', $userBank->id)->update([
            "cancel_cheque" => $new_file_name,
          ]);
        }
        // Send the email
        if (!empty($user->email)) {
          Mail::send('content.authentications.auth-register-mail', ['name' => $user->person_name], function ($message) use ($user) {
            $message->to($user->email)
              ->subject('Your Registration Successfully');
          });
        }

        return response()->json(['status' => 'success', 'message' => 'Data stored successfully']);
      } else {
        return response()->json(['status' => 'error', 'message' => 'Provide proper details']);
      }
    } else {
      return response()->json(['status' => 'error', 'message' => 'Already Exit email ID']);
    }
  }
}
