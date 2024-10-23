<?php
use App\Models\User;
use Laravel\Sanctum\Sanctum;

test('should_get_people', function () {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    $response = $this->getJson('/api/users');

    $response->dump();

    $response->assertStatus(200);
});
