<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use App\Model\Tag;
use App\Model\Ticket;
use App\Repositories\TagRepository;
use App\Repositories\TicketRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    protected $ticketRepo, $tagRepo;

    public function __construct(TicketRepository $ticketRepo, TagRepository $tagRepo)
    {
        $this->ticketRepo = $ticketRepo;
        $this->tagRepo = $tagRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Auth::user()->tickets;
        return view('ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tags = Tag::all();
        return view('ticket.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketRequest $request)
    {
        //
        $ticket = $request->Ticket;
        $tags = $request->tags;
        $this->ticketRepo->store($ticket, $tags);
        return redirect()->route('ticket.index')->with('status', 'The ticket has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $list_tagged = $ticket->tags;
        $comments = $ticket->comments()->with('user:id,name')->get();
        return view('ticket.show', compact(['ticket', 'list_tagged', 'comments']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
        $user = Auth::user();
        if($user->cant('update', $ticket)){
            abort(404);
        }

        $tags = $this->tagRepo->getAll();
        $list_tagged = $ticket->tags->pluck('id')->toArray();
        return view('ticket.edit', compact(['tags' , 'list_tagged', 'ticket']));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(TicketRequest $request, Ticket $ticket)
    {
        $user = Auth::user();
        if($user->cant('update', $ticket)){
            abort(404);
        }
        $data = $request->Ticket;
        $tags = $request->tags;
        $this->ticketRepo->update($ticket, $data, $tags);
        return redirect()->route('ticket.index')->with('status', 'Cap nhat bai viet thanh cong');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        $user = Auth::user();
        if($user->can('delete', $ticket)){
            $ticket->tags()->detach();
            $ticket->delete();
            return redirect()->route('ticket.index')->with('status', 'Xoa bai viet thanh cong');
        }else{
            abort(403);
        }
    }

}
