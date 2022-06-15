<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
        $url = $faker->url();

        $urlId = DB::table('urls')->insertGetId(
            [
                'name' => $url,
                'created_at' => Carbon::now()->toDateTimeString()
            ]
        );

        $html = file_get_contents(__DIR__ . '/../Fixtures/test.html');
        Http::fake([$url => Http::response($html, 200)]);

        $expectedData = [
            'url_id' => $urlId,
            'status_code' => 200,
            'h1' => 'test_header',
            'title' => 'test_title',
            'description' => 'test_description'
        ];

        $response = $this->post(route('url_checks.store', ['id' => $urlId]));
        $response->assertRedirect(route('urls.show', ['id' => $urlId]));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('url_checks', $expectedData);
    }
}
