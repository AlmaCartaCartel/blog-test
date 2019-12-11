<?php

namespace App\Http\Controllers\Admin;

use App\Mail\SubscribeMail;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class SubscribesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscribes = Subscription::all();
        return view('admin.subscribes.index', compact('subscribes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subscribes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'email' => 'email|required|unique:subscriptions'
        ]);

        $subs = Subscription::add($request->get('email'));
        $subs -> token = null;


        return redirect()->back()->with('status', 'Новый подписчик добавлен!');
    }

}
