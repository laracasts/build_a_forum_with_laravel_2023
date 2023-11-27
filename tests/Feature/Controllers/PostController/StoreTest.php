<?php

use App\Models\Post;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

beforeEach(function () {
    $this->validData = [
        'title' => 'Hello World',
        'body' => 'This is my very first post!'
    ];
});

it('requires authentication', function () {
    post(route('posts.store'))->assertRedirect(route('login'));
});

it('stores a post', function () {
    $user = User::factory()->create();

    actingAs($user)->post(route('posts.store'), $this->validData);

    $this->assertDatabaseHas(Post::class, [
        ...$this->validData,
        'user_id' => $user->id,
    ]);
});

it('redirects to the post show page', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('posts.store'), $this->validData)
        ->assertRedirect(route('posts.show', Post::latest('id')->first()));
});

it('requires valid data', function (array $badData, array|string $errors) {
    actingAs(User::factory()->create())
        ->post(route('posts.store'), [...$this->validData, ...$badData])
        ->assertInvalid($errors);
})->with([
    [['title' => null], 'title'],
    [['title' => true], 'title'],
    [['title' => 1], 'title'],
    [['title' => 1.5], 'title'],
    [['title' => str_repeat('a', 121)], 'title'],
    [['title' => str_repeat('a', 9)], 'title'],
    [['body' => null], 'body'],
    [['body' => true], 'body'],
    [['body' => 1], 'body'],
    [['body' => 1.5], 'body'],
    [['body' => str_repeat('a', 10_001)], 'body'],
    [['body' => str_repeat('a', 99)], 'body'],
]);
