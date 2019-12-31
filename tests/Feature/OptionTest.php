<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Option;

class OptionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function optionsListIsPaginated()
    {
        factory(Option::class, 30)->create();

        $this->assertCount(30, Option::all());

        $response = $this->json('GET', '/api/options/');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'statement',
                    'correct',
                    'question_id',
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
        $response = $this->json('POST', 'api/options', []);

        $response->assertJsonValidationErrors('statement');
        $response->assertJsonValidationErrors('correct');
        $response->assertJsonValidationErrors('question_id');
    }

    /**
     * @test
     */
    public function aOptionCanBeCreated()
    {
        $optionFake = factory(Option::class)->make();

        $response = $this->json('POST', '/api/options', $optionFake->toArray());

        $response->assertStatus(201);

        $this->assertCount(1, Option::all());

        $this->assertDatabaseHas('options', $optionFake->getAttributes());
    }

    /**
     * @test
     */
    public function aOptionCanBeDisplayed()
    {
        $optionFake = factory(Option::class)->make();
        $this->json('POST', '/api/options', $optionFake->toArray());

        $option  = Option::first();

        $response = $this->json('GET', '/api/options/'. $option->id);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function aOptionCanBeUpdated()
    {
        $optionFakes = factory(Option::class, 2)->make();
        $this->json('POST', '/api/options', $optionFakes->first()->toArray());

        $option  = Option::first();

        $response = $this->json('PUT', '/api/options/' . $option->id, $optionFakes->last()->toArray());

        $response->assertStatus(200);

        $this->assertDatabaseHas('options', $optionFakes->last()->getAttributes());
    }

    /**
     * @test
     */
    public function aOptionCanBeDeleted()
    {
        $optionFake = factory(Option::class)->make();
        $this->json('POST', '/api/options', $optionFake->toArray());

        $this->assertCount(1, Option::all());

        $option  = Option::first();

        $response = $this->json('DELETE', '/api/options/' . $option->id);

        $response->assertStatus(204);
        $this->assertCount(0, Option::all());

        $this->assertDatabaseMissing('options', $optionFake->getAttributes());
    }
}
