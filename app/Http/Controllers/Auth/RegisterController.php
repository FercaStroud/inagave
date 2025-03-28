<?php

namespace App\Http\Controllers\Auth;

use App\Mail\CreatePreferenceMail;
use App\Mail\CreateUserMail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/';

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
            'name' => 'required|string|max:25',
            'lastname' => 'required|string|max:15',
            'address' => 'required|string|max:400',
            'state' => 'required|string|max:75',
            'municipality' => 'required|string|max:75',
            'city' => 'required|string|max:75',
            'country' => 'required|string|max:75',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6|confirmed',
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
        $user = User::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'second_lastname' => $data['second_lastname'],
            'email' => $data['email'],
            'address' => $data['address'],
            'state' => $data['state'],
            'municipality' => $data['municipality'],
            'city' => $data['city'],
            'country' => $data['country'],
            'type_id' => 2,
            'password' => bcrypt($data['password']),
        ]);

        Mail::send(new CreateUserMail($user));
        return $user;
    }
}
