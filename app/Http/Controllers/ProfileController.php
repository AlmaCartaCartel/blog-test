<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::user()-> id);
        $this->validate($request, [
           'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user -> id),
            ],
            'password' => 'required',
            'avatar' => 'nullable|image'

        ]);

        $user->edit($request->all());
        $user->uploadAvatar($request->file('avatar'));
        return redirect()->route('home');
    }
}
