<?php

use App\Models\Room;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('testChannel', function () {
    return true;
});

Broadcast::channel('room.1', function ($user, $id) {
    // $room = Room::find($id);

    return true;

    // return $room->participants
    //         ->map(function ($participant) {
    //             return $participant->user_id;
    //         })->contains(fn (int $value, int $key) => $value == $user->id);
});