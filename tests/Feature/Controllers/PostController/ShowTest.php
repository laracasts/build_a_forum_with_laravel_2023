<?php

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;

use function Pest\Laravel\get;

it('can show a post', function () {
    $post = Post::factory()->create();

    get(route('posts.show', $post))
        ->assertComponent('Posts/Show');
});

it('passes a post to the view', function () {
    $post = Post::factory()->create();

    $post->load('user');

    get(route('posts.show', $post))
        ->assertHasResource('post', PostResource::make($post));
});

it('passes comments to the view', function () {
    $post = Post::factory()->create();
    $comments = Comment::factory(2)->for($post)->create();

    $comments->load('user');

    get(route('posts.show', $post))
        ->assertHasPaginatedResource('comments', CommentResource::collection($comments->reverse()));
});
