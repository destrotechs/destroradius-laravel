<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Customer;
use DB;
use Alert;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
        $this->middleware('guest:customer');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function showCustomerRegisterForm()
    {
        $zones = DB::table('zones')->get();
        return view('clients.register', ['url' => 'customers'],compact('zones'));
    }
    protected function createCustomer(Request $request)
    {
        // $this->validator($request->all())->validate();
        $writer = Customer::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone'=>$request['phone'],
            'username'=>$request['username'],
            'zone'=>$request['zone'],
            'gender'=>$request['gender'],
            'cleartextpassword'=>$request['password'],
            'password' => Hash::make($request['password']),
            'type' => $request['type'],
        ]);
        $useraccount = DB::table('customer_accounts')->updateOrInsert(
                ['owner'=>$request['username'],'account_no'=>$request['username']],
                ['status'=>'inactive']
            );
        alert()->success("Account created successfully, Please login");
        return redirect()->intended('customer/login');

    }
}
