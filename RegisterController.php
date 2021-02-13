<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::dashboard;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'cellno' => ['required', 'string', 'max:255', 'unique:users'],
            'workno' => ['required', 'string', 'max:255', 'unique:users'],
            'address' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User


// Use this code to upload pictures when registering a user

     */
    protected function create(array $data){

        
   
         $user =  User::create([
               'name' => $data['name'],
               'email' => $data['email'],
               'cellno' => $data['cellno'],
               'workno' => $data['workno'],
               'address' => $data['address'],
               'password' => Hash::make($data['password']),
            
           ]);

           if (request()->hasFile( key: 'payslip')) {
               $payslip = request()->file(key: 'payslip')->getClientOriginalName();
               request()->file(key: 'payslip')->storeAs(path: 'payslip', name: $user->id . '/' . $payslip, options: '');
               $user->update(['payslip' => $payslip]);
           }

     
           if (request()->hasFile( key: 'id_image')) {
               $id_image = request()->file(key: 'id_image')->getClientOriginalName();
               request()->file(key: 'id_image')->storeAs(path: 'id_image', name: $user->id . '/' . $id_image, options: '');
               $user->update(['id_image' => $id_image]);
           }

     
           if (request()->hasFile( key: 'proof_of_res')) {
               $proof_of_res = request()->file(key: 'proof_of_res')->getClientOriginalName();
               request()->file(key: 'proof_of_res')->storeAs(path: 'proof_of_res', name: $user->id . '/' . $proof_of_res, options: '');
               $user->update(['proof_of_res' => $proof_of_res]);
           }

           return $user;

     
    }

}

