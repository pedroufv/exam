<?php

namespace App\Http\Controllers;

use App\Institution;
use App\Http\Requests\InstitutionStoreRequest;
use App\Http\Requests\InstitutionUpdateRequest;
use App\Http\Resources\InstitutionResource;
use App\Http\Resources\InstitutionCollection;

use Exception;
use Illuminate\Http\JsonResponse;

class InstitutionController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"institutions"},
     *     summary="Display a listing of the resource",
     *     description="get all institution on database and paginate then",
     *     path="/institutions",
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
     *         response="200", description="List of institutions"
     *     )
     * )
     *
     * @return InstitutionCollection
     */
    public function index()
    {
        $limit = request()->has('limit') ? request()->get('limit') : null;
        return new InstitutionCollection(Institution::paginate($limit));
    }

    /**
     * @OA\Post(
     *     tags={"institutions"},
     *     summary="Store a newly created resource in storage.",
     *     description="store a new institution on database",
     *     path="/institutions",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="acronym", type="string"),
     *       )
     *     ),
     *     @OA\Response(
     *         response="201", description="New institution created"
     *     )
     * )
     *
     * @param  InstitutionStoreRequest $request
     * @return InstitutionResource
     */
    public function store(InstitutionStoreRequest $request)
    {
        return new InstitutionResource(Institution::create($request->validated()));
    }

    /**
     * @OA\Get(
     *     tags={"institutions"},
     *     summary="Display the specified resource.",
     *     description="show institution",
     *     path="/institutions/{institution}",
     *     @OA\Parameter(
     *         description="Institution id",
     *         in="path",
     *         name="institution",
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
     *         response="200", description="Show institution"
     *     )
     * )
     *
     * @param  Institution $institution
     * @return InstitutionResource
     */
    public function show(Institution $institution)
    {
        return new InstitutionResource($institution);
    }

    /**
     * @OA\Put(
     *     tags={"institutions"},
     *     summary="Update the specified resource in storage",
     *     description="update a institution on database",
     *     path="/institutions/{institution}",
     *     @OA\Parameter(
     *         description="Institution id",
     *         in="path",
     *         name="institution",
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
     *             @OA\Property(property="acronym", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="201", description="Institution updated"
     *     )
     * )
     *
     * @param  InstitutionUpdateRequest $request
     * @param  Institution $institution
     *
     * @return InstitutionResource
     */
    public function update(InstitutionUpdateRequest $request, Institution $institution)
    {
        $institution->update($request->validated());

        return new InstitutionResource($institution);
    }

    /**
     * @OA\Delete(
     *     tags={"institutions"},
     *     summary="Remove the specified resource from storage.",
     *     description="remove a institution on database",
     *     path="/institutions/{institution}",
     *     @OA\Parameter(
     *         description="Institution id",
     *         in="path",
     *         name="institution",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200", description="Institution deleted"
     *     )
     * )
     *
     * @param  Institution $institution
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Institution $institution)
    {
        $institution->delete();

        return response()->json(null, 204);
    }
}
