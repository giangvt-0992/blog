@extends('master')
@section('title', 'View a post')
@section('content')
<?php 

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
                <a href="{{ action('PostController@edit', $post->id) }}" class="btn btn-info">Edit</a>
                @if($post->status == 1)
                <form method="post" action="{{ action('PostController@destroy', $post->id) }}" class="float-left">
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
                            @if($user->id == $user_comment->id) <span class="float-right"> <a href="{{route('comment.delete', ['id' => $comment->id])}}">Delete</a> </span>  @endif
                        @else
                        Ho bao cao chon
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
        <div class="card mt-3">
            <form method="post" action="/comment">
        
                @foreach($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
        
                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
        
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="post_id" value="{{ $post->id }}">
        
                <fieldset>
                    <legend class="ml-3">Reply</legend>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <textarea class="form-control" rows="3" id="content" name="content"></textarea>
                        </div>
                    </div>
        
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="reset" class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-primary">Post</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        @endif
    </div>

@endsection