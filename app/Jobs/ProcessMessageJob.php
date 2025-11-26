<?php

namespace App\Jobs;
use App\Models\Message;
use App\Events\MessageReceived;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class ProcessMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
	public $messageId;
    
    public function __construct($messageId)
    {
         $this->messageId = $messageId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = Message::find($this->messageId);

        if (!$message) return;

        //  Sanitize message
        $message->message = strip_tags($message->message);
        //$message->processed_at = now();
        $message->save();

        //  Broadcast event
        broadcast(new MessageReceived($message));
    }
}
