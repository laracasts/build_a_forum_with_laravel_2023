<?php

use function Pest\Laravel\post;

it('requires authentication', function () {
    post(route('posts.store'))->assertRedirect(route('login'));
});

it('stores a post', function () {

});

it('redirects to the post show page', function () {

});

it('requires a valid title', function ($badTitle) {

})->with([

]);

it('requires a valid body', function ($badBody) {

})->with([

]);
