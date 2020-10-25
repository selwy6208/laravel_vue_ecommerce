<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminController extends Controller
{  
    use AuthenticatesUsers;

    // protected $redirectTo = '/admin';
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        // $this->middleware('guest:admin')->except('logout');

    }
    
    public function getContent()
    {
        return \view('admin_layout');
    }
    
    public function getLoginForm()
    {
        return \view('admin_login');
    }
    protected function createAdmin(Request $request)
    {
        $this->validator($request->all())->validate();
        $admin = Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->intended('login/admin');
    }

    public function logout()
    {
        try {
            Auth::guard('admin')->user()->logout();
            // session()->flush();
            return response()->json([
                'success' => true ,
                'message' => 'Admin Logout Successfully'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false ,
                'message' => 'Admin Logout Failed'
            ], 401);
        }
    }
    protected function guard(){
        return Auth::guard('admin');
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        $hasAccount = Admin::where('email',$request->email)->first();
        if (!$hasAccount) {
            return response()->json([
                'errors' => [
                    'email' => ['There has no account with this email']
                ]
            ] , 422);
        }

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {

            return response()->json([
                'success' => true ,
                'message' => 'Admin Login Successfully',
                'user' => Auth::guard('admin')->user()
            ], 200);
        }
        return response()->json([
            'errors' => [
                'password' => ['Your Password is incorrect']
            ]
        ] , 422);
        
    }



}
