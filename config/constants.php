<?php 

return [
    'method' => [
        'create' => 1,
        'update' => 1,
        'delete' => 0,
    ],
    'type' => [
        'post' => ['key' => 'App\Model\Post', 'value' => 'bài viết'],
        'ticket' => ['key' => 'App\Model\Ticket', 'value' => 'vé'],
        'comment' => ['key' => 'App\Model\Comment', 'value' => 'bình luận']
    ],
    'model' => [
        'App\Model\Post' => 'bài viết',
        'App\Model\Ticket' => 'vé',
        'App\Model\Comment' => 'binh luan ve',
        'App\Model\Reaction' => ''
    ],
    'ticket' => [
        'actionable_type' => 'App\Model\Ticket',
        'eventable_type' => 'App\Model\Ticket',
        'commentable_type' => 'App\Model\Ticket',
    ],
    'comment' => [
        'actionable_type' => 'App\Model\Comment',
        'eventable_type' => 'App\Model\Comment',
        'commentable_type' => 'App\Model\Comment',
    ],
    'post' => [
        'actionable_type' => 'App\Model\Post',
        'eventable_type' => 'App\Model\Post',
        'commentable_type' => 'App\Model\Post',
    ],

];