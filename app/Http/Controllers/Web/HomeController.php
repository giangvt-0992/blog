<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index()
    {
        $posts = Post::where('status', '=', 1)->with('comments', 'user')->get(); // eager loading
        // $query = $this->model->where([
        //     $condition
        // ]);
        // return $query->with(['user', 'tags', 'comment'])->get();
        return view('blog.index', compact('posts'));
    }
}
