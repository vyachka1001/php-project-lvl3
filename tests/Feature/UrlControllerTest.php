<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $faker = \Faker\Factory::create();
        $email = $faker->email();
        $response = $this->post(route('urls.store'), [
            'url' => [
                'name' => $email
            ]
        ]);
        $this->assertDatabaseHas('urls', ['name' => $email]);
    
        $record = DB::table('urls')
            ->select('id')
            ->where('name', $email)
            ->get();
        $id = $record[0]->id;

        $response->assertRedirect(route('urls.show', ['id' => $id]));
        $response->assertSessionHasNoErrors();
    }
}
