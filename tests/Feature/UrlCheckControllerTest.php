<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UrlCheckControllerTest extends TestCase
{
    /**
     * Testing store function.
     *
     * @return void
     */
    public function testStore()
    {
        $faker = \Faker\Factory::create();
        $url_id = $faker->randomDigitNotZero();
        $response = $this->post(route('url_checks.store', ['id' => $url_id]));

        $this->assertDatabaseHas('url_checks', ['url_id' => $url_id]);
        $response->assertRedirect(route('urls.show', ['id' => $url_id]));
        $response->assertSessionHasNoErrors();
    }
}
