<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Comment;
use App\Http\Requests\CommentFormRequest;
use App\Model\Post;
use App\Model\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create(CommentFormRequest $request)
    {
        $data = $request->Comment;
        $user_id = Auth::check() ? Auth::user()->id : null;
        $comment = new Comment([
            'content' => $data['content'],
            'user_id' => $user_id
        ]);
        switch ($data['commentable_type']) {
            case 'post':
                $post = Post::find($data['commentable_id']);
                $post->comments()->save($comment);
                break;
            case 'ticket':
                $ticket = Ticket::find($data['commentable_id']);
                $ticket->comments()->save($comment);
                break;
            default:
                break;
        }
        return redirect()->back()->with('status', 'Your comment has been created!');
    }

    public function destroy($id)
    {
        // $comment = Comment::whereId($id)->firstOrFail();
        // $comment->status = 0;
        // $comment->save();
        // return redirect()->back()->with('status', 'Your comment has been deleted!');
    }
}
