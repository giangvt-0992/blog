<?php 
namespace App\Repositories;

use App\Model\Action;
use App\Model\Comment;
use App\Model\Event;
use App\Model\Post;
use App\Model\Taggable;
use App\Model\Ticket;
use Illuminate\Support\Facades\Config;

class EventRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Event();
    }

    public function store($data){
        $event = [
            'creator_id' => $data['creator_id'],
            'owner_id' => $data['owner_id'],
            'action_id' => $data['action_id'],
        ];
        switch ($data['eventable_type']) {
            case Config::get('constants.post.eventable_type'):
                $eventable = Post::find($data['eventable_id']);
                $result = $eventable->events()->updateOrCreate($event);
                break;
            case Config::get('constants.ticket.eventable_type'):
                $eventable = Ticket::find($data['eventable_id']);
                $result = $eventable->events()->updateOrCreate($event);
                break;
            case Config::get('constants.comment.eventable_type'):
                $eventable = Comment::find($data['eventable_id']);
                $result = $eventable->events()->updateOrCreate($event);
                break;
            default:
                # code...
                break;
        }
        return $result;
    }

    public function delete($action_id){

        Event::where('action_id', '=', $action_id)->delete();
    }
}

?>