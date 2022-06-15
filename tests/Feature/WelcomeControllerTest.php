<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WelcomeControllerTest extends TestCase
{
    /**
     * Testing index function.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('welcome'));
        $response->assertOk();
    }
}
