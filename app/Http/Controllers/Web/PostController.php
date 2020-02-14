<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Model\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate as FacadesGate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where([['user_id', Auth::user()->id]])->get();
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = request()->Post;
        $post = new Post(array(
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => Auth::user()->id
        ));
        $post->save();
        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $comments = $post->comments()->where('status', 1)->get();
        return view('post.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::whereId($id)->firstOrFail();
        if(FacadesGate::check('edit-post', $post)){
            return view('post.edit', compact('post'));
        }else{
            echo "Ban khong co quyen chinh sua bai viet nay";
        }
        
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function publish($id)
    {
        $post = Post::whereId($id)->firstOrFail();
        $post->status = 1;
        $post->save();
        return view('post.edit', compact('post'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        
        $post = Post::whereId($id)->firstOrFail();
        
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();
        return redirect()->back()->with('status', 'Cap nhat bai viet thanh cong' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $post = Post::whereId($id)->firstOrFail();
        
        if($user->can('delete', $post)){
            $post->status = 0;
            $post->save();
            return redirect()->route('post.index');
        }else{
            return "Ban khong the xoa bai viet nay";
        }
        
    }
}
