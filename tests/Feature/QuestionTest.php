<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Question;

class QuestionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function questionsListIsPaginated()
    {
        factory(Question::class, 30)->create();

        $this->assertCount(30, Question::all());

        $response = $this->json('GET', '/api/questions/');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'statement',
                    'subject_id',
                    'user_id',
                    'contest_id',
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
        $response = $this->json('POST', 'api/questions', []);

        $response->assertJsonValidationErrors('statement');
        $response->assertJsonValidationErrors('subject_id');
        $response->assertJsonValidationErrors('user_id');
    }

    /**
     * @test
     */
    public function aQuestionCanBeCreated()
    {
        $questionFake = factory(Question::class)->make();

        $response = $this->json('POST', '/api/questions', $questionFake->toArray());

        $response->assertStatus(201);

        $this->assertCount(1, Question::all());

        $this->assertDatabaseHas('questions', $questionFake->getAttributes());
    }

    /**
     * @test
     */
    public function aQuestionCanBeDisplayed()
    {
        $questionFake = factory(Question::class)->make();
        $this->json('POST', '/api/questions', $questionFake->toArray());

        $question  = Question::first();

        $response = $this->json('GET', '/api/questions/'. $question->id);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function aQuestionCanBeUpdated()
    {
        $questionFakes = factory(Question::class, 2)->make();
        $this->json('POST', '/api/questions', $questionFakes->first()->toArray());

        $question  = Question::first();

        $response = $this->json('PUT', '/api/questions/' . $question->id, $questionFakes->last()->toArray());

        $response->assertStatus(200);

        $this->assertDatabaseHas('questions', $questionFakes->last()->getAttributes());
    }

    /**
     * @test
     */
    public function aQuestionCanBeDeleted()
    {
        $questionFake = factory(Question::class)->make();
        $this->json('POST', '/api/questions', $questionFake->toArray());

        $this->assertCount(1, Question::all());

        $question  = Question::first();

        $response = $this->json('DELETE', '/api/questions/' . $question->id);

        $response->assertStatus(204);
        $this->assertCount(0, Question::all());

        $this->assertDatabaseMissing('questions', $questionFake->getAttributes());
    }
}
