<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $senderUserId;
    public $receiverUserId;
    public $message;
    public $channelName;

    public function __construct($senderUserId, $receiverUserId, $message, $channelName)
    {
        $this->senderUserId = $senderUserId;
        $this->receiverUserId = $receiverUserId;
        $this->message = $message;
        $this->channelName = $channelName;
    }

    public function broadcastOn()
    {
        return [$this->channelName];
    }

    public function broadcastAs(): string
    {
        return 'chat-event';
    }
}
