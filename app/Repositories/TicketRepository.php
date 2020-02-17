<?php 
namespace App\Repositories;

use App\Model\Ticket;
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
        $this->model = new Ticket();
    }

    public function deleteTicket(Ticket $ticket){
        // DB::transaction
        DB::transaction(function () use ($ticket){
            $action_id = $ticket->action()->firstOrFail()->id;
            $this->eventRepo->delete($action_id);
            $this->actionRepo->delete($ticket);
            $ticket->delete();
        });
        
    }


}

?>