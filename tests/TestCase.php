<?php

namespace Inggo\Talakdaan\Tests;

use Inggo\Talakdaan\TalakdaanServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
  public function setUp(): void
  {
    parent::setUp();
    // additional setup
  }

  protected function getPackageProviders($app)
  {
    return [
        TalakdaanServiceProvider::class,
    ];
  }

  protected function getEnvironmentSetUp($app)
  {
    // perform environment setup
    // import the CreateEventsTable class from the migration
    include_once __DIR__ . '/../database/migrations/create_events_table.php.stub';

    // run the up() method of that migration class
    (new \CreateEventsTable)->up();
  }
}
