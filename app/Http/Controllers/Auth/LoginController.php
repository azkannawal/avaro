<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

// Call Models
use App\Models\Account\account;
use App\Models\Account\role;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * After login, redirect to the user's profile page
     *
     * @return string
     */
    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'login' => 'required',
            'password' => 'required|min:8',
        ], [
            'login.required' => 'Username or Email is required',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
        ]);

        if ($validator->fails()) {
            toastr()->error('username or password is incorrect');
            return redirect()->route('login');
        }

        
        // login with email or username
        $login = request()->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        if (auth()->attempt(array($field => $input['login'], 'password' => $input['password'])))
        {   
            $role = auth()->user()->role;
            
            if (isset($role)) {
                return redirect()->route(auth()->user()->getRole->nama_role.'.dashboard')->with('success', 'Login Successfully');
            } else {
                auth()->logout();
                return redirect()->route('login')->with('error', 'username or password is incorrect');
            }
        }
        else{
            Auth::logout();
            return redirect()->route('login')->with('error', 'username or password is incorrect');
        }
    }

    /**
     * After logout, redirect to the login page
     *
     * @return string
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout Successfully');
    }

    /**
     * After logout, redirect to the login page
     *
     * @return string
     */
    public function showLoginForm(){
        return view('auth.login');
    }
}
