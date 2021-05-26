<?php

namespace Inggo\Talakdaan;

use Illuminate\Support\ServiceProvider;

class TalakdaanServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'talakdaan');
  }

  public function boot()
  {
    if ($this->app->runningInConsole()) {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('talakdaan.php'),
        ], 'config');
    }
  }
}
