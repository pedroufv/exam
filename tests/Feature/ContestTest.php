<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Contest;

class ContestTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function contestsListIsPaginated()
    {
        factory(Contest::class, 30)->create();

        $this->assertCount(30, Contest::all());

        $response = $this->json('GET', '/api/contests/');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'name',
                    'year',
                    'number',
                    'institution_id',
                    'applicator_id',
                ]
            ],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => [
                'current_page', 'last_page', 'from', 'to',
                'path', 'per_page', 'total'
            ]
        ]);
    }

    /**
     * @test
     */
    public function checkRequiredFields()
    {
        $response = $this->json('POST', 'api/contests', []);

        $response->assertJsonValidationErrors('name');
        $response->assertJsonValidationErrors('year');
        $response->assertJsonValidationErrors('number');
        $response->assertJsonValidationErrors('institution_id');
        $response->assertJsonValidationErrors('applicator_id');
    }

    /**
     * @test
     */
    public function aContestCanBeCreated()
    {
        $contestFake = factory(Contest::class)->make();

        $response = $this->json('POST', '/api/contests', $contestFake->toArray());

        $response->assertStatus(201);

        $this->assertCount(1, Contest::all());

        $this->assertDatabaseHas('contests', $contestFake->getAttributes());
    }

    /**
     * @test
     */
    public function aContestCanBeDisplayed()
    {
        $contestFake = factory(Contest::class)->make();
        $this->json('POST', '/api/contests', $contestFake->toArray());

        $contest  = Contest::first();

        $response = $this->json('GET', '/api/contests/'. $contest->id);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function aContestCanBeUpdated()
    {
        $contestFakes = factory(Contest::class, 2)->make();
        $this->json('POST', '/api/contests', $contestFakes->first()->toArray());

        $contest  = Contest::first();

        $response = $this->json('PUT', '/api/contests/' . $contest->id, $contestFakes->last()->toArray());

        $response->assertStatus(200);

        $this->assertDatabaseHas('contests', $contestFakes->last()->getAttributes());
    }

    /**
     * @test
     */
    public function aContestCanBeDeleted()
    {
        $contestFake = factory(Contest::class)->make();
        $this->json('POST', '/api/contests', $contestFake->toArray());

        $this->assertCount(1, Contest::all());

        $contest  = Contest::first();

        $response = $this->json('DELETE', '/api/contests/' . $contest->id);

        $response->assertStatus(204);
        $this->assertCount(0, Contest::all());

        $this->assertDatabaseMissing('contests', $contestFake->getAttributes());
    }
}
