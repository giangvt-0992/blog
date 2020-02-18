<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Post;
use App\Model\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index()
    {
        $posts = Post::where('status', '=', 1)->with(['comments', 'comments.user:id,name', 'user:id,name'])->get(); // eager loading
        $tickets = Ticket::where('status', '=', 1)->with(['comments', 'comments.user:id,name', 'user:id,name'])->get();
        return view('blog.index', compact('posts', 'tickets'));
    }
}
