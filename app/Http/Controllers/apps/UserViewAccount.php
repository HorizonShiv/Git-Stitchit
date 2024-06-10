<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class UserViewAccount extends Controller
{
//  public function index($id)
//  {
//    $user = User::where('id',$id)->first();
//    return view('content.apps.app-user-view-account',compact('user'));
//  }

  public function show($id)
  {
    $id = base64_decode($id);
    $invoices = Invoice::orderBy("id", "desc")->where('user_id', $id)->get();
    $user = User::with(['UserAddress', 'UserBank'])->where('id', $id)->first();
    return view('content.apps.app-user-view-account', compact('user', 'invoices'));
  }

}
