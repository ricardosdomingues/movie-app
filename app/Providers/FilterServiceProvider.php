<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FilterServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $filters = [
            \App\Filters\Contracts\MovieFilter::class => \App\Filters\MovieFilter::class,
            \App\Filters\Contracts\GenreFilter::class => \App\Filters\GenreFilter::class,
        ];

        foreach ($filters as $interface => $concrete) {
            $this->app->singleton($interface, function () use ($concrete) {
                return new $concrete();
            });
        }
    }
}
