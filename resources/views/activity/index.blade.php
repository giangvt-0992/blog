
<?php 
use Illuminate\Support\Facades\Config;
?>
@extends('master')
@section('title', 'View all Posts')
@section('content')

    <div class="container col-md-12 col-md-offset-0 mt-5">
        @if ($events->isEmpty())
            <p> There is no activity.</p>
        @else
            @foreach($events as $event)
            <?php
                $message = "";

                $message .= "Bạn đã ";
                
                switch ($event->eventable_type) {
                        case \Config::get('constants.type.post.key') :
                            if($event->eventable_type == $event->action->actionable_type){
                                $message = $message . "đăng tải một" . " <a href='" . route('post.show', $event->eventable_id) . "'> " . \Config::get('constants.type.post.value') . ' </a>';
                            }else{
                                if($event->action->actionable_type == 'App\Model\Comment'){
                                    $message = $message . "bình luận về " . "<a href='" . route('post.show', $event->eventable_id) . "'> " . \Config::get("constants.model.$event->eventable_type") . '</a>' . " của " . (($event->owner_id==$event->creator_id)?"chính mình.":$event->owner->name);
                                }
                            }
                            break;
                        case \Config::get('constants.type.ticket.key') :
                            if($event->eventable_type == $event->action->actionable_type){
                                $message = $message . "đăng tải một" . " <a href='" . route('ticket.show', $event->eventable_id) . "'> " . \Config::get('constants.type.ticket.value') . ' </a>';
                            }else{
                                if($event->action->actionable_type == 'App\Model\Comment'){
                                    $message = $message . "bình luận về " . "<a href='" . route('ticket.show', $event->eventable_id) . "'> " . \Config::get("constants.model.$event->eventable_type") . '</a>' . " của " . (($event->owner_id==$event->creator_id)?"chính mình.":$event->owner->name);
                                }
                            }
                            break;
                        case \Config::get('constants.type.comment.key') :
                            $message = "trả lời bình luận của ...";
                            
                            break;
                        
                        default:
                            break;
                    }
            ?>
                <div class="card">
                    <div class="card-header ">
                        <?php print_r($message); ?>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

@endsection