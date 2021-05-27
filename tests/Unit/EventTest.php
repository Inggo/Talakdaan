<?php

namespace Inggo\Talakdaan\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inggo\Talakdaan\Tests\TestCase;
use Inggo\Talakdaan\Models\Event;

class EventTest extends TestCase
{
    use RefreshDatabase;
  
    /** @test */
    function an_event_has_a_name()
    {
        $event = Event::factory()->create(['name' => 'Event Name']);
        $this->assertEquals('Event Name', $event->name);
    }
}
