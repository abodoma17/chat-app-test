<?php

namespace App\Jobs;

use App\Events\ChatEvent;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $senderUserId;
    private $receiverUserId;
    private $message;

    /**
     * Create a new job instance.
     */
    public function __construct($senderUserId, $receiverUserId, $message)
    {
        $this->senderUserId = $senderUserId;
        $this->receiverUserId = $receiverUserId;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = [$this->receiverUserId, $this->senderUserId];
        $channelName = min($users) . '-CHAT-' . max($users);

        event(new ChatEvent($this->senderUserId, $this->receiverUserId, $this->message, $channelName));

        $message = new Message();
        $message->sender_user_id = $this->senderUserId;
        $message->receiver_user_id = $this->receiverUserId;
        $message->message = $this->message;
        $message->channel = $channelName;
        $message->sent_at = date('Y-m-d H:i:s');
        $message->save();
    }
}
