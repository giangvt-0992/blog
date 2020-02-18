<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Comment;
use App\Http\Requests\CommentFormRequest;
use App\Model\Post;
use App\Model\Ticket;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentRepo;
    public function __construct(CommentRepository $commentRepo)
    {
        $this->commentRepo = $commentRepo;
    }

    public function create(CommentFormRequest $request)
    {
        $data = $request->Comment;
        $this->commentRepo->storeComment($data);
        return redirect()->back()->with('status', 'Your comment has been created!');
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        $this->commentRepo->deleteComment($comment);
        return redirect()->back()->with('status', 'Your comment has been deleted!');
    }
}
