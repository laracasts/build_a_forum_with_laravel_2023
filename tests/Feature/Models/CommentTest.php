<?php

use App\Models\Comment;

it('generates the html', function () {
    $comment = Comment::factory()->make(['body' => '## Hello world']);

    $comment->save();

    expect($comment->html)->toEqual(str($comment->body)->markdown());
});
