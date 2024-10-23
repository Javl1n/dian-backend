<?php
use App\Models\User;
use Laravel\Sanctum\Sanctum;

// test('should_upload_post', function () {
//     Sanctum::actingAs(User::factory()->create(), ['*']);
    
//     $response = $this->postJson('/api/post', [
//         'text_content' => 'Admin123', 
//         'profile' => false
//     ]);

//     $response->assertStatus(204);
// });

test('should_get_posts', function () {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    $responsePost = $this->postJson('/api/post', [
        'text_content' => 'Admin123', 
        'profile' => false
    ]);

    $responsePost->assertStatus(204);

    $responseGet = $this->getJson('/api/posts');

    $responseGet->dump();

    $responseGet->assertStatus(200);
});
