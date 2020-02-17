<?php 
namespace App\Repositories;

use App\Model\Action;
use App\Model\Comment;
use App\Model\Post;
use App\Model\Taggable;
use App\Model\Ticket;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ActionRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Action();
    }

    public function store($data){
        // type, actionable_type, actionable_id

        $action =[
            'type' => $data['type'],
            'content' => ''
        ];
        switch ($data['actionable_type']) {
            case Config::get('constants.post.actionable_type'):
                $actionable = Post::find($data['actionable_id']);
                $result = $actionable->action()->updateOrCreate($action);
                break;
            case Config::get('constants.ticket.actionable_type'):
                $actionable = Ticket::find($data['actionable_id']);
                $result = $actionable->action()->updateOrCreate($action);
                break;
            case Config::get('constants.comment.actionable_type'):
                $actionable = Comment::find($data['actionable_id']);
                $result = $actionable->action()->updateOrCreate($action);
                break;
            default:
                # code...
                break;
        }
        return $result;
    }

    public function delete($actionable){
        DB::transaction(function() use ($actionable){
            // $actionable->action()->event()->delete();
            $actionable->action()->delete();
            
        });
    }
}

?>