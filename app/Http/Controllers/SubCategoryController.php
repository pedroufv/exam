<?php

namespace App\Http\Controllers;

use App\SubCategory;
use App\Http\Requests\SubCategoryStoreRequest;
use App\Http\Requests\SubCategoryUpdateRequest;
use App\Http\Resources\SubCategoryResource;
use App\Http\Resources\SubCategoryCollection;

use Exception;
use Illuminate\Http\JsonResponse;

class SubCategoryController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"sub-categories"},
     *     summary="Display a listing of the resource",
     *     description="get all sub_category on database and paginate then",
     *     path="/sub-categories",
     *     @OA\Parameter(
     *          name="only",
     *          in="query",
     *          description="filter results using field1;field2;field3...",
     *          @OA\Schema(type="string"),
     *          style="form"
     *     ),
     *     @OA\Parameter(
     *          name="search",
     *          in="query",
     *          description="search results using key:value",
     *          @OA\Schema(type="string"),
     *          style="form"
     *     ),
     *     @OA\Parameter(
     *          name="operators",
     *          in="query",
     *          description="set fileds operators using field1:operator1",
     *          @OA\Schema(type="string"),
     *          style="form"
     *     ),
     *     @OA\Parameter(
     *          name="sort",
     *          in="query",
     *          description="order results using field:direction",
     *          @OA\Schema(type="string"),
     *          style="form"
     *     ),
     *     @OA\Parameter(
     *          name="with",
     *          in="query",
     *          description="get relations using relation1;relation2;relation3...",
     *          @OA\Schema(type="string"),
     *          style="form"
     *     ),
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="define page",
     *          @OA\Schema(type="string"),
     *          style="form"
     *     ),
     *     @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="limit per page",
     *          @OA\Schema(type="int"),
     *          style="form"
     *     ),
     *     @OA\Response(
     *         response="200", description="List of sub_categories"
     *     )
     * )
     *
     * @return SubCategoryCollection
     */
    public function index()
    {
        $limit = request()->has('limit') ? request()->get('limit') : null;
        return new SubCategoryCollection(SubCategory::paginate($limit));
    }

    /**
     * @OA\Post(
     *     tags={"sub-categories"},
     *     summary="Store a newly created resource in storage.",
     *     description="store a new sub_category on database",
     *     path="/sub-categories",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="category_id", type="integer"),
     *       )
     *     ),
     *     @OA\Response(
     *         response="201", description="New sub_category created"
     *     )
     * )
     *
     * @param  SubCategoryStoreRequest $request
     * @return SubCategoryResource
     */
    public function store(SubCategoryStoreRequest $request)
    {
        return new SubCategoryResource(SubCategory::create($request->validated()));
    }

    /**
     * @OA\Get(
     *     tags={"sub-categories"},
     *     summary="Display the specified resource.",
     *     description="show sub_category",
     *     path="/sub-categories/{sub_category}",
     *     @OA\Parameter(
     *         description="SubCategory id",
     *         in="path",
     *         name="sub_category",
     *         required=true,
     *        @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Parameter(
     *          name="only",
     *          in="query",
     *          description="filter results using field1;field2;field3...",
     *          @OA\Schema(type="string"),
     *          style="form"
     *     ),
     *     @OA\Parameter(
     *          name="with",
     *          in="query",
     *          description="get relations using relation1;relation2;relation3...",
     *          @OA\Schema(type="string"),
     *          style="form"
     *     ),
     *     @OA\Response(
     *         response="200", description="Show sub_category"
     *     )
     * )
     *
     * @param  SubCategory $sub_category
     * @return SubCategoryResource
     */
    public function show(SubCategory $sub_category)
    {
        return new SubCategoryResource($sub_category);
    }

    /**
     * @OA\Put(
     *     tags={"sub-categories"},
     *     summary="Update the specified resource in storage",
     *     description="update a sub_category on database",
     *     path="/sub-categories/{sub_category}",
     *     @OA\Parameter(
     *         description="SubCategory id",
     *         in="path",
     *         name="sub_category",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="category_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="201", description="SubCategory updated"
     *     )
     * )
     *
     * @param  SubCategoryUpdateRequest $request
     * @param  SubCategory $sub_category
     *
     * @return SubCategoryResource
     */
    public function update(SubCategoryUpdateRequest $request, SubCategory $sub_category)
    {
        $sub_category->update($request->validated());

        return new SubCategoryResource($sub_category);
    }

    /**
     * @OA\Delete(
     *     tags={"sub-categories"},
     *     summary="Remove the specified resource from storage.",
     *     description="remove a sub_category on database",
     *     path="/sub-categories/{sub_category}",
     *     @OA\Parameter(
     *         description="SubCategory id",
     *         in="path",
     *         name="sub_category",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200", description="SubCategory deleted"
     *     )
     * )
     *
     * @param  SubCategory $sub_category
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(SubCategory $sub_category)
    {
        $sub_category->delete();

        return response()->json(null, 204);
    }
}
