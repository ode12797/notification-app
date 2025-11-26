<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Jobs\ProcessMessageJob;

class MessageController extends Controller
{
	public function store(Request $request)
    {
		$request->validate([
            'sender_id' => 'required|integer',
            'message'   => 'required|string',
        ]);

        //  Store message
        $message = Message::create([
            'sender_id' => $request->sender_id,
            'message'   => $request->message,
        ]);

        //  Dispatch job for background processing
        ProcessMessageJob::dispatch($message->id);

        //  Return message ID
        return response()->json([
            'message_id' => $message->id,
            'status' => 'queued'
        ]);
    }
}
?>
