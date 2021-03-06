<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Model\Post;
use App\Model\Role_Permission;
use App\Model\Tag;
use App\Model\Taggable;
use App\Repositories\ActionRepository;
use App\Repositories\EventRepository;
use App\Repositories\PostRepository;
use App\Repositories\TaggableRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate as FacadesGate;

class PostController extends Controller
{
    protected $taggableRepo;
    protected $actionRepo;
    protected $eventRepo;
    protected $postRepo;

    public function __construct(
        TaggableRepository $taggableRepo, 
        ActionRepository $actionRepo,
        EventRepository $eventRepo,
        PostRepository $postRepo
        )
    {
        $this->taggableRepo = $taggableRepo;
        $this->actionRepo = $actionRepo;
        $this->eventRepo = $eventRepo;
        $this->postRepo = $postRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $posts = $user->posts()->get();
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
        
        $this->postRepo->createPost($request);
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
        $post = Post::find($id);
        $list_tagged = $post->tags->pluck('id')->toArray();
        $tags = Tag::all();
        $comments = $post->comments()->with('user:id,name')->get();
        if(FacadesGate::check('edit-post', $post)){
            return view('post.edit', compact('post', 'tags', 'list_tagged'));
        }else{
            echo "Ban khong co quyen chinh sua bai viet nay";
        }
        
    }
    // public function edit($id)
    // {
    //     $post = Post::with(['tags:id', 'comments', 'comments.user'])->where('id', $id)->first();
    //     $list_tagged = $post->tags->toArray();
    //     $comments = $post->comments;
    //     $tags = Tag::all();
    //     if(FacadesGate::check('edit-post', $post)){
    //         return view('post.edit', compact('post', 'tags', 'list_tagged'));
    //     }else{
    //         echo "Ban khong co quyen chinh sua bai viet nay";
    //     }
        
    // }
    
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
        $this->postRepo->updatePost($request, $id);
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
            $this->postRepo->deletePost($post);
            return redirect()->route('post.index');
        }else{
            return "Ban khong the xoa bai viet nay";
        }
        
    }
}
