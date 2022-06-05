<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class UrlControllerTest extends TestCase
{
    /**
     * Test of index function.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }

    /**
     * Testing index function.
     *
     * @return void
     */
    public function testStore()
    {
        // $response = $this->get('/');
        // $response = $this->post(route('urls.store'), );
        // $response->assertRedirect(route('urls.show'));
        // $response->assertSessionHasNoErrors();

        // $this->assertDatabaseHas('urls', );
    }
}
