<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Applicator;

class ApplicatorTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function applicatorsListIsPaginated()
    {
        factory(Applicator::class, 30)->create();

        $this->assertCount(30, Applicator::all());

        $response = $this->json('GET', '/api/applicators/');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'name',
                    'acronym',
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
        $response = $this->json('POST', 'api/applicators', []);

        $response->assertJsonValidationErrors('name');
        $response->assertJsonValidationErrors('acronym');
    }

    /**
     * @test
     */
    public function aApplicatorCanBeCreated()
    {
        $applicatorFake = factory(Applicator::class)->make();

        $response = $this->json('POST', '/api/applicators', $applicatorFake->toArray());

        $response->assertStatus(201);

        $this->assertCount(1, Applicator::all());

        $this->assertDatabaseHas('applicators', $applicatorFake->getAttributes());
    }

    /**
     * @test
     */
    public function aApplicatorCanBeDisplayed()
    {
        $applicatorFake = factory(Applicator::class)->make();
        $this->json('POST', '/api/applicators', $applicatorFake->toArray());

        $applicator  = Applicator::first();

        $response = $this->json('GET', '/api/applicators/'. $applicator->id);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function aApplicatorCanBeUpdated()
    {
        $applicatorFakes = factory(Applicator::class, 2)->make();
        $this->json('POST', '/api/applicators', $applicatorFakes->first()->toArray());

        $applicator  = Applicator::first();

        $response = $this->json('PUT', '/api/applicators/' . $applicator->id, $applicatorFakes->last()->toArray());

        $response->assertStatus(200);

        $this->assertDatabaseHas('applicators', $applicatorFakes->last()->getAttributes());
    }

    /**
     * @test
     */
    public function aApplicatorCanBeDeleted()
    {
        $applicatorFake = factory(Applicator::class)->make();
        $this->json('POST', '/api/applicators', $applicatorFake->toArray());

        $this->assertCount(1, Applicator::all());

        $applicator  = Applicator::first();

        $response = $this->json('DELETE', '/api/applicators/' . $applicator->id);

        $response->assertStatus(204);
        $this->assertCount(0, Applicator::all());

        $this->assertDatabaseMissing('applicators', $applicatorFake->getAttributes());
    }
}
