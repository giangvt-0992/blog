@extends('master')
@section('title', 'View a post')
@section('content')
<?php 
use Illuminate\Support\Facades\Config;
?>
    <div class="container col-md-8 col-md-offset-2 mt-5">
        <div class="card">
            <div class="card-header ">
                <h5 class="float-left">{{ $post->title }}</h5>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                <p> <strong>Status</strong>: {{ $post->status ? 'Pending' : 'Answered' }}</p>
                <p> {{ $post->content }} </p>
                <p>Tags: @foreach($tags as $tag) <a href="{{route('tag.show', $tag->name)}}">#{{$tag->name}}</a> @endforeach</p> 
                <a href="{{ action('Web\PostController@edit', $post->id) }}" class="btn btn-info">Edit</a>
                @if($post->status == 1)
                <form method="post" action="{{ action('Web\PostController@destroy', $post->id) }}" class="float-left">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div>
                        <button type="submit" class="btn btn-warning">Delete</button>
                    </div>
                </form>
                @else
                <a href="{{ route('post.publish', $post->id) }}" class="btn btn-primary">Publish</a>
                @endif
                <div class="clearfix"></div>
                {{-- <a href="{{ action('postsController@destroy', $post->slug) }}" class="btn btn-info">Delete</a> --}}
            </div>
        </div>
        <?php $user = Auth::user(); ?>
        
            
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
                            <?php $user_comment = $comment->user()->firstOrFail(); ?>
                            {{$user_comment->name}}
                            @if( isset($user) && $user->id == $user_comment->id) <span class="float-right"> <a href="{{route('comment.delete', ['id' => $comment->id])}}">Delete</a> </span>  @endif
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
            
        @if($post->status)
        @include('comment.form', [
            'commentable_id' => $post->id,
            'commentable_type' => \Config::get('constants.post.commentable_type')
        ])
        @endif
    </div>

@endsection