<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\authentications\TwoStepsCover;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LoginRegisterController extends Controller
{
  /**
   * Instantiate a new LoginRegisterController instance.
   */
  public function __construct()
  {
    $this->middleware('guest')->except([
      'logout', 'dashboard'
    ]);
  }

  /**
   * Store a new user.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'username' => 'required|string|max:250',
      'email' => 'required|email|max:250|unique:users',
      'password' => 'required|min:8|confirmed'
    ]);

    User::create([
      'name' => $request->username,
      'email' => $request->email,
      'company_name' => "Admin",
      'role' => "admin",
      'password' => Hash::make($request->password)
    ]);

    $credentials = $request->only('email', 'password');
    Auth::attempt($credentials);
    $request->session()->regenerate();
    return redirect()->route('auth-login-basic')
      ->withSuccess('You have successfully registered & logged in!');
  }

  /**
   * Display a login form.
   *
   * @return \Illuminate\Http\Response
   */
  public function login()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
  }

  /**
   * Authenticate the user.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function authenticate(Request $request)
  {

    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);
    $user = User::where('email', $request->email)->where('role', '!=', "vendor")->first();
    if ($user) {
      if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('dashboard-crm')
          ->withSuccess('You have successfully logged in!');
      }
      return back()->withErrors([
        'email' => 'Your provided credentials do not match in our records.',
      ])->onlyInput('email');
    } else {
      return back()->withErrors("you are not aright role contact to admin");
    }


  }

  public function authenticateWithEmail(Request $request)
  {

    $credentials = $request->validate([
      'email' => 'required',
      'password' => 'required'
    ]);

    $otp = rand(100000, 999999);
    Log::info("otp = " . $otp);
    $user = User::where('role', "vendor")->where('email', '=', $request->email)->orWhere('person_mobile', '=', $request->email)->first();
    if ($user) {
      User::where('email', '=', $user->email)->update(['otp' => $otp]);
      $request->session()->regenerate();
      Mail::send('content.authentications.otp-mail', ['name' => $user->person_name, 'otp' => $otp], function ($message) use ($user) {
        $message->to($user->email)
          ->subject('OTP Verification');
      });
      $request->session()->put('email', $user->email);
      return redirect()->action([TwoStepsCover::class, 'index'])->withSuccess('OTP sent successfully');;
    }

    return back()->withErrors([
      'email' => 'Your provided credentials do not match in our records.',
    ])->onlyInput('email');

  }

  public function resendOTP(Request $request)
  {
    $otp = rand(100000, 999999);
    Log::info("otp = " . $otp);
    $email = $request->session()->get('email');
    $user = User::where('email', '=', $email)->first();
    //dd($user);
    if ($user) {
      User::where('email', '=', $email)->update(['otp' => $otp]);
      // Send the email
      Mail::send('content.authentications.otp-mail', ['name' => $user->person_name, 'otp' => $otp], function ($message) use ($user) {
        $message->to($user->email)
          ->subject('OTP Verification');
      });
      $request->session()->put('email', $user->email);
      return redirect()->action([TwoStepsCover::class, 'index'])->withSuccess('OTP sent successfully');;
    } else {
      return response(["status" => 401, 'message' => 'Invalid']);
    }
  }

  public function verifyOtp(Request $request)
  {
    // dd(11);
    $email = $request->session()->get('email');
    // dd($request->otp);
    $user = User::where('email', $email)->where('otp', $request->otp)->first();
    if ($user) {
      Auth::login($user);
      $request->session()->regenerate();
      //User::where('email', '=', $email)->update(['otp' => null]);
      return redirect()->route('dashboard-analytics')
        ->withSuccess('You have successfully logged in!');

    } else {
      return back()->withErrors([
        'email' => 'Invalid OTP',
      ]);
    }
  }

  /**
   * Display a dashboard to authenticated users.
   *
   * @return \Illuminate\Http\Response
   */
  public function dashboard()
  {
    if (Auth::check()) {
      return view('auth.dashboard');
    }

    return redirect()->route('auth-login-basic')
      ->withErrors([
        'email' => 'Please login to access the dashboard.',
      ])->onlyInput('email');
  }

  /**
   * Log out the user from application.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function logout(Request $request)
  {
    $role = Auth::user()->role;
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    if ($role == 'admin' || $role == 'account' || $role == 'warehouse') {
      $routeName = 'auth-login-basic';
    } else {
      $routeName = 'auth-login-cover';
    }
    return redirect()->route($routeName)
      ->withSuccess('You have logged out successfully!');;
  }

}
