<?php

namespace MetaverseSystems\GandiClient;

use Illuminate\Support\ServiceProvider;

class GandiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(GandiClient::class, function ($app) {
            $config = $app['config']['gandi'] ?? [];
            
            return new GandiClient(
                $config['personal_access_token'] ?? env('GANDI_PERSONAL_ACCESS_TOKEN'),
                $config['base_url'] ?? env('GANDI_BASE_URL', 'https://api.gandi.net/v5')
            );
        });

        $this->app->alias(GandiClient::class, 'gandi');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish configuration file
        $this->publishes([
            __DIR__.'/../config/gandi.php' => config_path('gandi.php'),
        ], 'gandi-config');

        // Register the configuration file
        $this->mergeConfigFrom(
            __DIR__.'/../config/gandi.php',
            'gandi'
        );
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [
            GandiClient::class,
            'gandi',
        ];
    }
}
