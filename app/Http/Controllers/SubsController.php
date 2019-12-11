<?php

namespace App\Http\Controllers;

use App\Mail\SubscribeMail;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubsController extends Controller
{
    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required|unique:subscriptions'
        ]);
        $subs = Subscription::add($request->get('email'));
        $subs -> genereteToken();
        Mail::to($subs)->send(new SubscribeMail($subs));

        return redirect()->back()->with('status', 'Проверьтк вашу почту');
    }

    public function confirm($token)
    {
        $subs = Subscription::where('token', $token)->firstOrFail();
        $subs -> token = null;
        $subs -> save();

        return redirect('/')->with('status', 'Ваша почта подтверждена!');
    }
}
