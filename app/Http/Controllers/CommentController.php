<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function newComment(CommentFormRequest $request)
    {
        $user_id = Auth::check() ? Auth::user()->id : null;
        $comment = new Comment(array(
            'post_id' => $request->get('post_id'),
            'content' => $request->get('content'),
            'user_id' => $user_id
        ));

        $comment->save();

        return redirect()->back()->with('status', 'Your comment has been created!');
    }

    public function destroy($id)
    {
        $comment = Comment::whereId($id)->firstOrFail();
        $comment->status = 0;
        $comment->save();
        return redirect()->back()->with('status', 'Your comment has been deleted!');
    }
}
