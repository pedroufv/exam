<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\SubCategory;

class SubCategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function sub_categoriesListIsPaginated()
    {
        factory(SubCategory::class, 30)->create();

        $this->assertCount(30, SubCategory::all());

        $response = $this->json('GET', '/api/sub-categories/');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'name',
                    'description',
                    'category_id',
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
        $response = $this->json('POST', 'api/sub-categories', []);

        $response->assertJsonValidationErrors('name');
        $response->assertJsonValidationErrors('description');
        $response->assertJsonValidationErrors('category_id');
    }

    /**
     * @test
     */
    public function aSubCategoryCanBeCreated()
    {
        $sub_categoryFake = factory(SubCategory::class)->make();

        $response = $this->json('POST', '/api/sub-categories', $sub_categoryFake->toArray());

        $response->assertStatus(201);

        $this->assertCount(1, SubCategory::all());

        $this->assertDatabaseHas('sub_categories', $sub_categoryFake->getAttributes());
    }

    /**
     * @test
     */
    public function aSubCategoryCanBeDisplayed()
    {
        $sub_categoryFake = factory(SubCategory::class)->make();
        $this->json('POST', '/api/sub-categories', $sub_categoryFake->toArray());

        $sub_category  = SubCategory::first();

        $response = $this->json('GET', '/api/sub-categories/'. $sub_category->id);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function aSubCategoryCanBeUpdated()
    {
        $sub_categoryFakes = factory(SubCategory::class, 2)->make();
        $this->json('POST', '/api/sub-categories', $sub_categoryFakes->first()->toArray());

        $sub_category  = SubCategory::first();

        $response = $this->json('PUT', '/api/sub-categories/' . $sub_category->id, $sub_categoryFakes->last()->toArray());

        $response->assertStatus(200);

        $this->assertDatabaseHas('sub-categories', $sub_categoryFakes->last()->getAttributes());
    }

    /**
     * @test
     */
    public function aSubCategoryCanBeDeleted()
    {
        $sub_categoryFake = factory(SubCategory::class)->make();
        $this->json('POST', '/api/sub-categories', $sub_categoryFake->toArray());

        $this->assertCount(1, SubCategory::all());

        $sub_category  = SubCategory::first();

        $response = $this->json('DELETE', '/api/sub-categories/' . $sub_category->id);

        $response->assertStatus(204);
        $this->assertCount(0, SubCategory::all());

        $this->assertDatabaseMissing('sub-categories', $sub_categoryFake->getAttributes());
    }
}
