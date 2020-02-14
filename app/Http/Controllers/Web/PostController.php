<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Model\Post;
use App\Model\Role_Permission;
use App\Model\Tag;
use App\Model\Taggable;
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
        $tags = Tag::all();
        return view('post.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = $request->Post;
        $tags = $request->tags;
        $post = new Post(array(
            'title' => $post['title'],
            'content' => $post['content'],
            'user_id' => Auth::user()->id
        ));
        $post->save();
        $array = array();
        foreach($tags as $tag){
            $array[] = [
                'tag_id' => $tag,
                'taggable_type' => 'App\Model\Post',
                'taggable_id' => $post->id
            ];
        }
        Taggable::insert($array);
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
        $tags = $post->tags;
        // print_r($tags);
        // exit();
        return view('post.show', compact('post', 'comments', 'tags'));
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
        $post = Post::find($id);

        if($user->can('delete', $post)){
            // $post->status = 0;
            // $post->save();
            $post->delete();
            return redirect()->route('post.index');
        }else{
            return "Ban khong the xoa bai viet nay";
        }
        
    }
}
