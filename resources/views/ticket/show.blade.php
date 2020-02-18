@extends('master')
@section('title', 'View a post')
@section('content')
<?php 
use Illuminate\Support\Facades\Config;
?>
    <div class="container col-md-8 col-md-offset-2 mt-5">
        <div class="card">
            <div class="card-header ">
                <h5 class="float-left">{{ $ticket->title }}</h5>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                <p> <strong>Status</strong>: {{ $ticket->status ? 'Pending' : 'Answered' }}</p>
                <p> {{ $ticket->content }} </p>
                <p>Tags: @foreach($list_tagged as $tag) <a href="{{route('tag.show', $tag->name)}}">#{{$tag->name}}</a> @endforeach</p> 
                <a href="{{ action('Web\TicketController@edit', $ticket->id) }}" class="btn btn-info">Edit</a>
                @if($ticket->status == 1)
                <form method="post" action="{{ action('Web\TicketController@destroy', $ticket->id) }}" class="float-left">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div>
                        <button type="submit" class="btn btn-warning confirm-before-delete">Delete</button>
                    </div>
                </form>
                @else
                <a href="{{ route('ticket.publish', $ticket->id) }}" class="btn btn-primary">Publish</a>
                @endif
                <div class="clearfix"></div>
                {{-- <a href="{{ action('postsController@destroy', $ticket->slug) }}" class="btn btn-info">Delete</a> --}}
            </div>
        </div>
        <?php 
        $user = Auth::user(); 
        ?>
        
            
            <div class="card mt-3">
                <div class="card-header">
                    <h4>Has {{count($comments)}} comments.</h4>
                </div>
                <div class="card-body">
                    @foreach($comments as $comment)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6>
                            @if($comment->user_id != null)
                            {{$comment->user->name}}
                            @if($user->id == $comment->user->id) <span class="float-right"> <a href="{{route('comment.delete', ['id' => $comment->id])}}">Delete</a> </span>  @endif
                        @else
                        Anonymous
                        @endif
                        
                        </h6>
                        </div>
                            
                            <div class="card-body">
                                <p class="ml-2">- {{ $comment->content }}</p>
                            </div>
                    </div>
                    @endforeach
                </div>
                
            </div>
            
        @if($ticket->status)
        @include('comment.form', [
            'commentable_id' => $ticket->id,
            'commentable_type' => \Config::get('constants.ticket.commentable_type')
        ])
        @endif
    </div>

@endsection