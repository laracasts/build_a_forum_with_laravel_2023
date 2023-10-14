<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia;

class TestingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (! $this->app->runningUnitTests()) {
            return;
        }

        AssertableInertia::macro('hasResource', function (string $key, JsonResource $resource) {
            $props = $this->toArray()['props'];

            $compiledResource = $resource->response()->getData(true);

            expect($props)
                ->toHaveKey($key, message: "Key \"{$key}\" not passed as a property to Inertia.")
                ->and($props[$key])
                ->toEqual($compiledResource);

            return $this;
        });

        AssertableInertia::macro('hasPaginatedResource', function (string $key, ResourceCollection $resource) {
            $props = $this->toArray()['props'];

            $compiledResource = $resource->response()->getData(true);

            expect($props)
                ->toHaveKey($key, message: "Key \"{$key}\" not passed as a property to Inertia.")
                ->and($props[$key])
                ->toHaveKeys(['data', 'links', 'meta'])
                ->data
                ->toEqual($compiledResource);

            return $this;
        });

        TestResponse::macro('assertHasResource', function (string $key, JsonResource $resource) {
            return $this->assertInertia(fn (AssertableInertia $inertia) => $inertia->hasResource($key, $resource));
        });

        TestResponse::macro('assertHasPaginatedResource', function (string $key, ResourceCollection $resource) {
            return $this->assertInertia(fn (AssertableInertia $inertia) => $inertia->hasPaginatedResource($key, $resource));
        });
    }
}
