<?php 
namespace App\Repositories;

use App\Model\Action;
use App\Model\Post;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class PostRepository
{
    protected $model;
    protected $eventRepo;
    protected $actionRepo;
    public function __construct(ActionRepository $actionRepo, EventRepository $eventRepo)
    {
        $this->actionRepo = $actionRepo;
        $this->eventRepo = $eventRepo;
        $this->model = new Post();
    }

    public function storePostAction(Post $post, $method)
    {
        $data = [
            'actionable_type' => Config::get('constants.post.actionable_type'), 
            'actionable_id' => $post->id, 
            'type' => $method
        ];
        return $this->actionRepo->store($data);
    }

    public function storePostEvent(Post $post,User $creator,Action $action)
    {
        $data_event = [
            'eventable_type' => Config::get('constants.post.eventable_type'),
            'eventable_id' => $post->id, 
            'owner_id' => $post->user_id, 
            'creator_id' => $creator->id, 
            'action_id' => $action->id
        ];
        return $this->eventRepo->store($data_event);
    }

    public function updatePost($request, $id)
    {
        $creator = Auth::user();
        $post = Post::whereId($id)->firstOrFail();
        $tags = $request->tags;
        $post->title = $request->Post['title'];
        $post->content = $request->Post['content'];

        DB::transaction(function() use ($post, $tags, $creator){
            $post->save();
            $post->tags()->sync($tags);
            $method = Config::get('constants.method.update');
            $action = $this->storePostAction($post, $method);
            $this->storePostEvent($post, $creator, $action);
        });
        
        
    }

    public function createPost($request)
    {
        $owner = Auth::user();
        $data = $request->Post;
        $tags = $request->tags;
        $post = new Post(array(
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => $owner->id
        ));
        DB::transaction(function() use ($post, $tags, $owner){
            $post->save();
            $post->tags()->attach($tags);
            $method = Config::get('constants.method.create');
            $action = $this->storePostAction($post, $method);
            $this->storePostEvent($post, $owner, $action);
        });
    }


    public function deletePost(Post $post){
        // DB::transaction
        DB::transaction(function () use ($post){
            // Xoa bai viet , xoa ca comment
            // $action_id = $post->action()->firstOrFail()->id;
            // $this->eventRepo->delete($action_id);
            
            // $this->actionRepo->delete($post);
            $post->events()->delete();
            $post->action()->delete();
            $this->deleteComments($post);
            $post->delete();
        });
        
    }

    public function deleteComments(Post $post){
        $comments = $post->comments()->pluck('id')->toArray();
        $actionable_type = Config::get('constants.comment.actionable_type');
        Action::where('actionable_type', '=',$actionable_type)->whereIn('actionable_id', $comments)->delete();
        $post->comments()->delete();
    }
}

?>