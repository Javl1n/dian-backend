<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Room $room ,Request $request)
    {
        $request->validate([
            'text_content' => 'required|string',
        ]);

        $user =  $request->user();

        $message = $user->messages()->create([
            'content' => $request->text_content,
            'room_id' => $room->id,
        ]);

        // dd($message->with(['user'])->find($message->id));

        $message = Message::where('id', $message->id)->first();

        broadcast(new MessageSent($message));

        return response()->noContent(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
