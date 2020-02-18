

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{route('index')}}">Blog</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          
            <li class="nav-item">
                <a class="nav-link" href="{{route('post.index')}}">Post</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('ticket.index')}}">Ticket</a>
            </li>
            
            @if(Auth::check())
            <li class="nav-item">
                <a class="nav-link" href="{{route('activity.index')}}">Activity Histories</a>
            </li>
            <li class="nav-item">
                <div class="dropdown show">
                    <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{count($news)}} <i class="fas fa-bell"></i>
                    </a>
                  
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        
                        @foreach ($news as $event)
                        <?php
                            $message = isset($event->creator) ? $event->creator->name : 'Bạn nữ giấu tên';
                            $message .=  " đã ";
                            $route = "#";
                            switch ($event->eventable_type) {
                                case \Config::get('constants.type.post.key') :
                                    $route = route( 'post.show', ['id' => $event->eventable_id]); 
                                    if($event->action->actionable_type == 'App\Model\Comment'){
                                        $message = $message . "bình luận về " . \Config::get("constants.model.$event->eventable_type") . " của ban";
                                    }
                                    break;
                                case \Config::get('constants.type.ticket.key') :
                                    $route = route( 'ticket.show', ['ticket_id' => $event->eventable_id]); 
                                    if($event->action->actionable_type == 'App\Model\Comment'){
                                        $message = $message . "bình luận về " . \Config::get("constants.model.$event->eventable_type") . " của ban";
                                    }
                                break;
                                case \Config::get('constants.type.comment.key') :
                                    $message = "trả lời bình luận của ...";
                                    break;
                                default:
                                    break;
                            }
                        ?>
                            <a class='dropdown-item' href="{{$route}}">{{$message}}</a>
                        
                        @endforeach
                    </div>
                  </div>
            </li>
            <li class="nav-item">
                <div class="dropdown show">
                    <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       {{Auth::user()->name}}
                    </a>
                  
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
                    </div>
                  </div>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{route('login')}}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('register')}}">Register</a>
            </li>
            @endif
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        
    </div>
</nav>