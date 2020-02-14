@extends('master')
@section('title', 'View all Posts')
@section('content')

    <div class="container col-md-8 col-md-offset-2 mt-5">
        <div class="card">
            <div class="card-header ">
                <h5 class="float-left">Posts</h5>
                <a href="{{route('post.create')}}"><h5 class="float-right">Create Post</h5></a>
                <div class="clearfix"></div>
            </div>
            <div class="card-body mt-2">
                @if ($posts->isEmpty())
                    <p> There is no post.</p>
                @else
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
                                <td>{{ $post->status == 1 ? 'publish' : 'hidden' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

@endsection