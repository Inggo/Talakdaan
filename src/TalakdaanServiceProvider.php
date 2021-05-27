<?php

namespace Inggo\Talakdaan;

use Illuminate\Support\ServiceProvider;

class TalakdaanServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'talakdaan');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('talakdaan.php'),
            ], 'config');

            if (!class_exists('CreatePostsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_posts_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_posts_table.php'),
                    // you can add any number of migrations here
                ], 'migrations');
            }
        }
    }
}
