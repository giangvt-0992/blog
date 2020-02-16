@extends('master')
@section('title', 'View all Posts')
@section('content')

    <div class="container col-md-12 col-md-offset-0 mt-5">
        <h3>| POSTS</h3>
        @if ($posts->isEmpty())
            <p> There is no post.</p>
        @else
            @foreach($posts as $post)
                <div class="card">
                    <div class="card-header ">
                        <h5 class="float-left"> {{$post->user->name}} - {{$post->title}} </h5><a href="{{route('post.show', ['id' => $post->id])}}"><span class="float-right"> READ MORE</span></a>
                    </div>
                    <div class="card-body mt-2">
                        <p>{{$post->content}}</p>
                        <div style="border: 1px solid #7f7f7f;">
                            <?php $comments = $post->comments;?>
                            @foreach($comments as $comment)
                            <div class="card">
                                <div class="card-header">{{$comment->user_id != null ? $comment->user->name : "Anonymous"}} - {{$comment->content}}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        <h3>| TICKETS</h3>
        @if ($tickets->isEmpty())
            <p> There is no post.</p>
        @else
            @foreach($tickets as $ticket)
                <div class="card">
                    <div class="card-header ">
                        <h5 class="float-left"> {{$ticket->user->name}} - {{$ticket->title}} </h5><a href="{{route('ticket.show', ['ticket_id' => $ticket->id])}}"><span class="float-right"> READ MORE</span></a>
                    </div>
                    <div class="card-body mt-2">
                        <p>{{$ticket->content}}</p>
                        <div style="border: 1px solid #7f7f7f;">
                            <?php $comments = $ticket->comments;?>
                            @foreach($comments as $comment)
                            <div class="card">
                                <div class="card-header">{{$comment->user_id != null ? $comment->user->name : "Anonymous"}} - {{$comment->content}}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        
    </div>

@endsection