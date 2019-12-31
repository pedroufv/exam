<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function categoriesListIsPaginated()
    {
        factory(Category::class, 30)->create();

        $this->assertCount(30, Category::all());

        $response = $this->json('GET', '/api/categories/');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'name',
                    'description',
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
        $response = $this->json('POST', 'api/categories', []);

        $response->assertJsonValidationErrors('name');
        $response->assertJsonValidationErrors('description');
    }

    /**
     * @test
     */
    public function aCategoryCanBeCreated()
    {
        $categoryFake = factory(Category::class)->make();

        $response = $this->json('POST', '/api/categories', $categoryFake->toArray());

        $response->assertStatus(201);

        $this->assertCount(1, Category::all());

        $this->assertDatabaseHas('categories', $categoryFake->getAttributes());
    }

    /**
     * @test
     */
    public function aCategoryCanBeDisplayed()
    {
        $categoryFake = factory(Category::class)->make();
        $this->json('POST', '/api/categories', $categoryFake->toArray());

        $category  = Category::first();

        $response = $this->json('GET', '/api/categories/'. $category->id);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function aCategoryCanBeUpdated()
    {
        $categoryFakes = factory(Category::class, 2)->make();
        $this->json('POST', '/api/categories', $categoryFakes->first()->toArray());

        $category  = Category::first();

        $response = $this->json('PUT', '/api/categories/' . $category->id, $categoryFakes->last()->toArray());

        $response->assertStatus(200);

        $this->assertDatabaseHas('categories', $categoryFakes->last()->getAttributes());
    }

    /**
     * @test
     */
    public function aCategoryCanBeDeleted()
    {
        $categoryFake = factory(Category::class)->make();
        $this->json('POST', '/api/categories', $categoryFake->toArray());

        $this->assertCount(1, Category::all());

        $category  = Category::first();

        $response = $this->json('DELETE', '/api/categories/' . $category->id);

        $response->assertStatus(204);
        $this->assertCount(0, Category::all());

        $this->assertDatabaseMissing('categories', $categoryFake->getAttributes());
    }
}
