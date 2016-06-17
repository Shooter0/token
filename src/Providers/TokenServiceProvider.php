<?php

namespace Vuer\Token\Providers;

use Illuminate\Support\ServiceProvider;

class TokenServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish the migration
        $timestamp = date('Y_m_d_His', time());

        $this->publishes([
            __DIR__ . '/../../database/migrations/create_tokens_table.php' => database_path('migrations/' . $timestamp . '_create_tokens_table.php'),
        ], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
