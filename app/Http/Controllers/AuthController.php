<?php

namespace App\Http\Controllers;
use App\Mail\RegistryMail;
use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('pages.register');
    }

    public function register(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        $user = User::add($request->all());
        $user -> genereteToken();
        Mail::to($user)->send( new RegistryMail($user));

        return redirect()->back()->with('status', 'Проверьтe вашу почту');
    }

    public function loginForm()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request -> get('email')) -> firstOrFail();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($user -> token !== null){
            return redirect()->back()->with('status', 'Подтвердите почту!');
        }

        if(Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ])){
            return redirect('/');
        }
        return redirect()->back()->with('status', 'Не правельный логин или пароль');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function verifications($token)
    {
        $user = User::where('token', $token)->firstOrFail();
        $user -> token = null;
        $user -> save();

        return redirect()->route('login')->with('status', 'Почта подтверждена');
    }
}
