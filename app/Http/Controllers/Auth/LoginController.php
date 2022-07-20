<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Alert;


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
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:customer')->except('logout');
        // $this->middleware('guest:writer')->except('logout')
    }
    public function showCustomerLoginForm($usertype=null)
    {
        $type = $usertype;
        return view('clients.login', ['url' => 'customers','usertype'=>$type]);
    }
    public function customerLogin(Request $request)
    {
        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required|min:6'
        ]);
        // $credentials = $request->only('', 'password');
        if (Auth::guard('customer')->attempt(['username' => $request->username, 'password' => $request->password])) {
            toast('Login success','success');
            return redirect()->intended('/client/bundles');
        }else{
            return redirect()->back()->with("error","Wrong username or password");//->withInput($request->only('username', 'remember'));
        }
    }

    public function redirectTo(){
        $role_id=Auth::user()->role_id;
        $role="";
        if($role_id==1){
            $role='admin';
        }else{
            $role="notadmin";
        }
        switch ($role) {
            case 'admin':
                return '/home';
                break;
            case 'notadmin':
            return '/manager/dashboard';
            default:
                return '/manager/dashboard';
                break;
        }
    }
}
