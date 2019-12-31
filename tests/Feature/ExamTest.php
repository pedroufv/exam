<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Exam;

class ExamTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function examsListIsPaginated()
    {
        factory(Exam::class, 30)->create();

        $this->assertCount(30, Exam::all());

        $response = $this->json('GET', '/api/exams/');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'amount',
                    'finished_at',
                    'filters',
                    'user_id',
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
        $response = $this->json('POST', 'api/exams', []);

        $response->assertJsonValidationErrors('amount');
        $response->assertJsonValidationErrors('user_id');
    }

    /**
     * @test
     */
    public function aExamCanBeCreated()
    {
        $examFake = factory(Exam::class)->make();

        $response = $this->json('POST', '/api/exams', $examFake->toArray());

        $response->assertStatus(201);

        $this->assertCount(1, Exam::all());

        $this->assertDatabaseHas('exams', $examFake->getAttributes());
    }

    /**
     * @test
     */
    public function aExamCanBeDisplayed()
    {
        $examFake = factory(Exam::class)->make();
        $this->json('POST', '/api/exams', $examFake->toArray());

        $exam  = Exam::first();

        $response = $this->json('GET', '/api/exams/'. $exam->id);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function aExamCanBeUpdated()
    {
        $examFakes = factory(Exam::class, 2)->make();
        $this->json('POST', '/api/exams', $examFakes->first()->toArray());

        $exam  = Exam::first();

        $response = $this->json('PUT', '/api/exams/' . $exam->id, $examFakes->last()->toArray());

        $response->assertStatus(200);

        $this->assertDatabaseHas('exams', $examFakes->last()->getAttributes());
    }

    /**
     * @test
     */
    public function aExamCanBeDeleted()
    {
        $examFake = factory(Exam::class)->make();
        $this->json('POST', '/api/exams', $examFake->toArray());

        $this->assertCount(1, Exam::all());

        $exam  = Exam::first();

        $response = $this->json('DELETE', '/api/exams/' . $exam->id);

        $response->assertStatus(204);
        $this->assertCount(0, Exam::all());

        $this->assertDatabaseMissing('exams', $examFake->getAttributes());
    }
}
