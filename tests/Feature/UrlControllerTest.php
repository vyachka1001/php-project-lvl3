<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UrlControllerTest extends TestCase
{
    private int $urlId;
    private \Faker\Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = \Faker\Factory::create();
        $this->urlId = DB::table('urls')->insertGetId(
            [
                'name' => $this->faker->url(),
                'created_at' => Carbon::now()->toDateTimeString()
            ]
        );
    }

    /**
     * Testing index function.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }

    /**
     * Testing store function.
     *
     * @return void
     */
    public function testStore()
    {
        $url = $this->faker->url();
        $response = $this->post(route('urls.store'), [
            'url' => [
                'name' => $url
            ]
        ]);

        $this->assertDatabaseHas('urls', ['name' => $url]);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    /**
     * Testing show function.
     *
     * @return void
     */
    public function testShow()
    {
        $response = $this->get(route('urls.show', ['id' => $this->urlId]));
        $response->assertOk();
    }
}
