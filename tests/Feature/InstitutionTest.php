<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Institution;

class InstitutionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function institutionsListIsPaginated()
    {
        factory(Institution::class, 30)->create();

        $this->assertCount(30, Institution::all());

        $response = $this->json('GET', '/api/institutions/');

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
        $response = $this->json('POST', 'api/institutions', []);

        $response->assertJsonValidationErrors('name');
        $response->assertJsonValidationErrors('acronym');
    }

    /**
     * @test
     */
    public function aInstitutionCanBeCreated()
    {
        $institutionFake = factory(Institution::class)->make();

        $response = $this->json('POST', '/api/institutions', $institutionFake->toArray());

        $response->assertStatus(201);

        $this->assertCount(1, Institution::all());

        $this->assertDatabaseHas('institutions', $institutionFake->getAttributes());
    }

    /**
     * @test
     */
    public function aInstitutionCanBeDisplayed()
    {
        $institutionFake = factory(Institution::class)->make();
        $this->json('POST', '/api/institutions', $institutionFake->toArray());

        $institution  = Institution::first();

        $response = $this->json('GET', '/api/institutions/'. $institution->id);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function aInstitutionCanBeUpdated()
    {
        $institutionFakes = factory(Institution::class, 2)->make();
        $this->json('POST', '/api/institutions', $institutionFakes->first()->toArray());

        $institution  = Institution::first();

        $response = $this->json('PUT', '/api/institutions/' . $institution->id, $institutionFakes->last()->toArray());

        $response->assertStatus(200);

        $this->assertDatabaseHas('institutions', $institutionFakes->last()->getAttributes());
    }

    /**
     * @test
     */
    public function aInstitutionCanBeDeleted()
    {
        $institutionFake = factory(Institution::class)->make();
        $this->json('POST', '/api/institutions', $institutionFake->toArray());

        $this->assertCount(1, Institution::all());

        $institution  = Institution::first();

        $response = $this->json('DELETE', '/api/institutions/' . $institution->id);

        $response->assertStatus(204);
        $this->assertCount(0, Institution::all());

        $this->assertDatabaseMissing('institutions', $institutionFake->getAttributes());
    }
}
