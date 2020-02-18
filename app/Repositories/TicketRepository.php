<?php 
namespace App\Repositories;

use App\Model\Action;
use App\Model\Post;
use App\Model\Ticket;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TicketRepository
{
    protected $model, $user;
    protected $eventRepo, $tagRepo;
    protected $actionRepo;
    public function __construct(ActionRepository $actionRepo, EventRepository $eventRepo, TagRepository $tagRepo)
    {
        $this->actionRepo = $actionRepo;
        $this->eventRepo = $eventRepo;
        $this->tagRepo = $tagRepo;
        
        $this->model = new Ticket();
    }

    public function createTicket($ticket = [])
    {
        $item = new Ticket([
            'title' => $ticket['title'],
            'content' => $ticket['content'],
            'user_id' => Auth::user()->id,
        ]);
        $item->save();
        return $item;
    }

    public function store($ticket = [], $tags = [])
    {
        $creator = Auth::user();
        $method = Config::get('constants.method.create');
        DB::transaction(function() use ($ticket, $tags, $method, $creator){
            $item = $this->createTicket($ticket);
            $this->tagRepo->attachTags($item,$tags);
            $action = $this->storeTicketAction($item, $method);
            $this->storeTicketEvent($item, $creator, $action);
        });
    }


    public function storeTicketAction($ticket, $method)
    {
        $data = [
            'actionable_type' => Config::get('constants.ticket.actionable_type'), 
            'actionable_id' => $ticket->id, 
            'type' => $method
        ];
        return $this->actionRepo->store($data);
    }

    public function storeTicketEvent(Ticket $ticket,User $creator,Action $action)
    {
        $data_event = [
            'eventable_type' => Config::get('constants.ticket.eventable_type'),
            'eventable_id' => $ticket->id, 
            'owner_id' => $ticket->user_id, 
            'creator_id' => $creator->id, 
            'action_id' => $action->id
        ];
        return $this->eventRepo->store($data_event);
    }


    public function updateTicket(Ticket $ticket, $data = [])
    {
        $ticket->title = $data['title'];
        $ticket->status = $data['content'];
        $ticket->status = isset($data['status'])?0:1;
        $ticket->save();
        return $ticket;
    }

    public function update(Ticket $ticket, $data, $tags){
        $creator = Auth::user();
        $method = Config::get('constants.method.update');
        DB::transaction(function() use ($ticket, $tags, $method, $creator){
            $item = $this->createTicket($ticket);
            $this->tagRepo->syncTags($item,$tags);
            $action = $this->storeTicketAction($item, $method);
            $this->storeTicketEvent($item, $creator, $action);
        });
    }

    public function deleteTicket(Ticket $ticket){
        // DB::transaction
        DB::transaction(function () use ($ticket){
            $ticket->events()->delete();
            $ticket->action()->delete();
            $this->deleteComments($ticket);
            $ticket->delete();
        });
        
    }

    public function deleteComments(Ticket $ticket){
        $comments = $ticket->comments()->pluck('id')->toArray();
        $actionable_type = Config::get('constants.comment.actionable_type');
        Action::where('actionable_type', '=',$actionable_type)->whereIn('actionable_id', $comments)->delete();
        $ticket->comments()->delete();
    }
}

?>