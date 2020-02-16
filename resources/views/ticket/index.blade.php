@extends('master')
@section('title', 'View all Tickets')
@section('content')

    <div class="container col-md-8 col-md-offset-2 mt-5">
        <div class="card">
            <div class="card-header ">
                <h5 class="float-left">Tickets</h5>
                <a href="{{route('ticket.create')}}"><h5 class="float-right">Create Ticket</h5></a>
                <div class="clearfix"></div>
            </div>
            <div class="card-body mt-2">
                @if ($tickets->isEmpty())
                    <p> There is no Ticket.</p>
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
                        @foreach($tickets as $ticket)
                            <tr>
                                
                                <td><a href="{{ route('ticket.show', $ticket->id) }}">{{ $ticket->id }} </a></td>
                                <td>{{ $ticket->title }}</td>
                                <td>{{ $ticket->content }}</td>
                                <td>{{ $ticket->status == 1 ? 'publish' : 'hidden' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

@endsection