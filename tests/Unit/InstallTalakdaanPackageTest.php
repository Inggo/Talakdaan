<?php

namespace Inggo\Talakdaan\Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Inggo\Talakdaan\Tests\TestCase;

class InstallTalakdaanPackageTest extends TestCase
{
    protected static $dummy_content = <<<DUMMY
<?php

return [
    'dummy' => 'value'
];

DUMMY;

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function the_install_command_copies_the_configuration()
    {
        // make sure we're starting from a clean state
        if (File::exists(config_path('talakdaan.php'))) {
            unlink(config_path('talakdaan.php'));
        }
    
        $this->assertFalse(File::exists(config_path('talakdaan.php')));

        Artisan::call('talakdaan:install');
        
        $this->assertTrue(File::exists(config_path('talakdaan.php')));
    }

    /** @test */
    public function when_a_config_file_is_present_users_can_choose_to_not_overwrite_it()
    {
        // Given we have already have an existing config file
        File::put(config_path('talakdaan.php'), self::$dummy_content);

        $this->assertTrue(File::exists(config_path('talakdaan.php')));

        // When we run the install command
        $this->artisan('talakdaan:install')
            ->expectsConfirmation(
                // We expect a warning that our configuration file exists
                'Config file already exists. Do you want to overwrite it?',
                // When answered with "no"
                'no'
            )
            // We should see a message that our file was not overwritten
            ->expectsOutput('Existing configuration was not overwritten');

        $this->assertEquals(
            file_get_contents(config_path('talakdaan.php')),
            self::$dummy_content
        );

        // Clean up
        unlink(config_path('talakdaan.php'));
    }

    /** @test */
    public function when_a_config_file_is_present_users_can_choose_to_do_overwrite_it()
    {
        // Given we have already have an existing config file
        File::put(config_path('talakdaan.php'), self::$dummy_content);

        $this->assertTrue(File::exists(config_path('talakdaan.php')));

        // When we run the install command
        $this->artisan('talakdaan:install')
            // We expect a warning that our configuration file exists
            ->expectsConfirmation(
                'Config file already exists. Do you want to overwrite it?',
                // When answered with "yes"
                'yes'
            )
            ->expectsOutput('Overwriting configuration file...')
            ->expectsOutput('Installed Talakdaan');

        $this->assertEquals(
            file_get_contents(__DIR__.'/../../config/config.php'),
            file_get_contents(config_path('talakdaan.php'))
        );

        // Clean up
        unlink(config_path('talakdaan.php'));
    }
}
