<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Subject;

class SubjectTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function subjectsListIsPaginated()
    {
        factory(Subject::class, 30)->create();

        $this->assertCount(30, Subject::all());

        $response = $this->json('GET', '/api/subjects/');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'name',
                    'description',
                    'subcategory_id',
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
        $response = $this->json('POST', 'api/subjects', []);

        $response->assertJsonValidationErrors('name');
        $response->assertJsonValidationErrors('description');
        $response->assertJsonValidationErrors('subcategory_id');
    }

    /**
     * @test
     */
    public function aSubjectCanBeCreated()
    {
        $subjectFake = factory(Subject::class)->make();

        $response = $this->json('POST', '/api/subjects', $subjectFake->toArray());

        $response->assertStatus(201);

        $this->assertCount(1, Subject::all());

        $this->assertDatabaseHas('subjects', $subjectFake->getAttributes());
    }

    /**
     * @test
     */
    public function aSubjectCanBeDisplayed()
    {
        $subjectFake = factory(Subject::class)->make();
        $this->json('POST', '/api/subjects', $subjectFake->toArray());

        $subject  = Subject::first();

        $response = $this->json('GET', '/api/subjects/'. $subject->id);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function aSubjectCanBeUpdated()
    {
        $subjectFakes = factory(Subject::class, 2)->make();
        $this->json('POST', '/api/subjects', $subjectFakes->first()->toArray());

        $subject  = Subject::first();

        $response = $this->json('PUT', '/api/subjects/' . $subject->id, $subjectFakes->last()->toArray());

        $response->assertStatus(200);

        $this->assertDatabaseHas('subjects', $subjectFakes->last()->getAttributes());
    }

    /**
     * @test
     */
    public function aSubjectCanBeDeleted()
    {
        $subjectFake = factory(Subject::class)->make();
        $this->json('POST', '/api/subjects', $subjectFake->toArray());

        $this->assertCount(1, Subject::all());

        $subject  = Subject::first();

        $response = $this->json('DELETE', '/api/subjects/' . $subject->id);

        $response->assertStatus(204);
        $this->assertCount(0, Subject::all());

        $this->assertDatabaseMissing('subjects', $subjectFake->getAttributes());
    }
}
