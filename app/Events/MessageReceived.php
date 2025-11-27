<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class MessageReceived implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;

        \Log::info("EVENT CONSTRUCTED NEW", [
            'id' => $message->id,
            'text' => $message->message
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('messages.channel');
    }

    public function broadcastAs()
    {
        return 'message.received';
    }
}
