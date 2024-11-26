<?php

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Event;

test('should_get_rooms', function () {
    Sanctum::actingAs(User::find(1), ['*']);

    $response = $this->getJson('/api/rooms');

    $response->assertStatus(200);
});

test('should_get_one_room', function () {
    Sanctum::actingAs(User::find(1), ['*']);

    $response = $this->getJson('/api/room/1');

    $response->assertStatus(200);
});

test('should_send_message', function () {
    Sanctum::actingAs(User::find(2), ['*']);

    Event::fake();    

    $response = $this->postJson('/api/message/1/store', [
        'text_content' => 'test usersasdasdas',
    ]);

    Event::assertDispatched(MessageSent::class);

    $response->assertStatus(200);
});
