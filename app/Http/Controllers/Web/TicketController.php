<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use App\Model\Tag;
use App\Model\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tickets = Auth::user()->tickets;
        // $tickets = $user->tickets;
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
        $ticket = new Ticket([
            'title' => $ticket['title'],
            'content' => $ticket['content'],
            'user_id' => Auth::user()->id,
        ]);
        $ticket->save();
        $ticket->tags()->attach($tags);
        return 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    // public function show(Ticket $ticket)
    // {
    //     //
    //     // $data = $ticket->with('tags', 'comments', 'comments.user')->firstOrFail();
    //     $list_tagged = $ticket->tags;
    //     $comments = $ticket->comments;
    //     return view('ticket.show', compact(['ticket', 'list_tagged', 'comments']));
    // }
    public function show(Ticket $ticket)
    {
        //
        $data = $ticket->with('tags', 'comments', 'comments.user:id,name')->firstOrFail();
        $list_tagged = $data->tags;
        $comments = $data->comments;
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
        $tags = Tag::all();
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
        $data = $request->Ticket;
        $tags = $request->tags;
        $ticket->title = $data['title'];
        $ticket->status = $data['content'];
        $ticket->status = isset($data['status'])?0:1;
        $ticket->save();
        $ticket->tags()->sync($tags);
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
