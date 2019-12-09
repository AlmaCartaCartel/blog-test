<?php

namespace App\Http\Controllers;

use Auth;
use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function add(Request $request)
    {
        $this->validate($request, [
           'comment' => 'required'
        ]);
        $comment = new Comment();
        $comment -> text = $request->get('comment');
        $comment -> user_id = Auth::user() -> id;
        $comment -> post_id = $request->get('post_id');
        $comment -> save();

        return redirect()->back()->with('status', 'Ваш комментарий будет скоро добавлен');
    }
}
