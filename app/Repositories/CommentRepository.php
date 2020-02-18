<?php 
namespace App\Repositories;

use App\Model\Comment;
use App\Model\Post;
use App\Model\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CommentRepository
{
    protected $model;
    protected $eventRepo;
    protected $actionRepo;
    public function __construct(ActionRepository $actionRepo, EventRepository $eventRepo)
    {
        $this->actionRepo = $actionRepo;
        $this->eventRepo = $eventRepo;
        $this->model = new Comment();
    }

    public function storeCommentAction(Comment $comment){
        $data_action = [
            'actionable_type' => Config::get('constants.comment.actionable_type'), 
            'actionable_id' => $comment->id, 
            'type' => Config::get('constants.method.create'),
        ];
        return $this->actionRepo->store($data_action);
    }

    public function storeCommentEvent($commentable, $creator = null, $action, $eventable_type){
        $data_event = [
                        'eventable_type' => $eventable_type, 
                        'eventable_id' => $commentable->id, 
                        'owner_id' => $commentable->user_id, 
                        'creator_id' => $creator == null ? null : $creator->id, 
                        'action_id' => $action->id
                    ];
        return $this->eventRepo->store($data_event);
    }

    
    public function storeComment($data)
    {   
        
        $creator = Auth::check() ? Auth::user() : null;
        $comment = new Comment([
            'content' => $data['content'],
            'user_id' => $creator == null ? null : $creator->id,
        ]);
        DB::transaction(function() use ($comment, $creator, $data){
            $eventable_type = "";
            switch ($data['commentable_type']) {
                case Config::get('constants.post.commentable_type'):
                    $commentable = Post::find($data['commentable_id']);
                    $commentable->comments()->save($comment);
                    $eventable_type = Config::get('constants.post.eventable_type');
                    break;
                case Config::get('constants.ticket.commentable_type'):
                    $commentable = Ticket::find($data['commentable_id']);
                    $commentable->comments()->save($comment);
                    $eventable_type = Config::get('constants.ticket.eventable_type');
                    break;
                default:
                    echo('<pre>');
                    print_r("commentrepostiory storeComment");
                    echo('</pre>');
                    exit();
                    break;
            }
            $action = $this->storeCommentAction($comment);
            $this->storeCommentEvent($commentable, $creator, $action, $eventable_type);
        });
    }

    public function deleteComment(Comment $comment){
        // DB::transaction
        DB::transaction(function () use ($comment){
            $action_id = $comment->action()->firstOrFail()->id;
            $this->eventRepo->delete($action_id);
            $this->actionRepo->delete($comment);
            $comment->delete();
        });
        
    }


}

?>