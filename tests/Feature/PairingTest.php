<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

test('must_pair', function () {
    Sanctum::actingAs(User::find(1), ['*']);

    $response = $this->postJson('/api/user/follow', [
        'follow' => 'follow',
        'person' => 2,
    ]);

    // $response->dump();

    $response->assertStatus(200);
});
