<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index()
    {
        $posts = Post::where('status', '=', 1)->with('comments', 'user')->get(); // eager loading
        // $posts = Post::with('comments')->references('comments')->where('comments.status', '=', 1);
        // Post->all().includes(:posts).references(:posts).where("posts.title  = ?" , "Hoa")
        // $posts = Post::where('status', '=', 1)
        //                 ->with(['comments' => function($query){
        //                     $query->where('status', 1);
        //                 }], 'user')->get();
        // print_r($posts);
        // return view('blog.index', compact('posts'));

        // $posts = Post::with(
        //                     ['comments' => function($query){
        //                                             $query->where('status', 1);
        //                                         }], 
        //                     'user'
        //                     )->get();
        //                 echo "<pre>";
        //                 print_r($posts);
        //                 echo "</pre>";
        //                 exit();
        return view('blog.index', compact('posts'));
    }
}
