@extends('master')
@section('title', 'View all Posts')
@section('content')

    <div class="container col-md-12 col-md-offset-0 mt-5">
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
                                <div class="card-header">{{$comment->user_id != null ? $comment->user()->first()->name : "Nac danh"}} - {{$comment->content}}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        {{-- <div class="card">
            <div class="card-header ">
                <h5 class="float-left">Posts</h5>
                <a href="{{route('post.create')}}"><h5 class="float-right">Create Post</h5></a>
                <div class="clearfix"></div>
            </div>
            <div class="card-body mt-2">
                
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                
                                <td><a href="{{ route('post.show', $post->id) }}">{{ $post->id }} </a></td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->content }}</td>
                                <td>{{ $post->status ? 'Pending' : 'Answered' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div> --}}
    </div>

@endsection