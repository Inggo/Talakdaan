<?php

namespace Inggo\Talakdaan\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallTalakdaanPackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'talakdaan:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Talakdaan package';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Installing Talakdaan...');

        $this->info('Publishing configuration...');

        if (! $this->configExists('talakdaan.php')) {
            $this->publishConfiguration();
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishConfiguration($force = true);
            } else {
                $this->info('Existing configuration was not overwritten');
                return;
            }
        }

        $this->info('Installed Talakdaan');
    }

    private function configExists($fileName)
    {
        return File::exists(config_path($fileName));
    }
    
    private function shouldOverwriteConfig()
    {
        return $this->confirm(
            'Config file already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publishConfiguration($forcePublish = false)
    {
        $params = [
            '--provider' => "Inggo\Talakdaan\TalakdaanServiceProvider",
            '--tag' => "config"
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

       $this->call('vendor:publish', $params);
    }
}
