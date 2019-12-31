<?php

namespace App\Http\Controllers;

use App\Applicator;
use App\Http\Requests\ApplicatorStoreRequest;
use App\Http\Requests\ApplicatorUpdateRequest;
use App\Http\Resources\ApplicatorResource;
use App\Http\Resources\ApplicatorCollection;

use Exception;
use Illuminate\Http\JsonResponse;

class ApplicatorController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"applicators"},
     *     summary="Display a listing of the resource",
     *     description="get all applicator on database and paginate then",
     *     path="/applicators",
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
     *         response="200", description="List of applicators"
     *     )
     * )
     *
     * @return ApplicatorCollection
     */
    public function index()
    {
        $limit = request()->has('limit') ? request()->get('limit') : null;
        return new ApplicatorCollection(Applicator::paginate($limit));
    }

    /**
     * @OA\Post(
     *     tags={"applicators"},
     *     summary="Store a newly created resource in storage.",
     *     description="store a new applicator on database",
     *     path="/applicators",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="acronym", type="string"),
     *       )
     *     ),
     *     @OA\Response(
     *         response="201", description="New applicator created"
     *     )
     * )
     *
     * @param  ApplicatorStoreRequest $request
     * @return ApplicatorResource
     */
    public function store(ApplicatorStoreRequest $request)
    {
        return new ApplicatorResource(Applicator::create($request->validated()));
    }

    /**
     * @OA\Get(
     *     tags={"applicators"},
     *     summary="Display the specified resource.",
     *     description="show applicator",
     *     path="/applicators/{applicator}",
     *     @OA\Parameter(
     *         description="Applicator id",
     *         in="path",
     *         name="applicator",
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
     *         response="200", description="Show applicator"
     *     )
     * )
     *
     * @param  Applicator $applicator
     * @return ApplicatorResource
     */
    public function show(Applicator $applicator)
    {
        return new ApplicatorResource($applicator);
    }

    /**
     * @OA\Put(
     *     tags={"applicators"},
     *     summary="Update the specified resource in storage",
     *     description="update a applicator on database",
     *     path="/applicators/{applicator}",
     *     @OA\Parameter(
     *         description="Applicator id",
     *         in="path",
     *         name="applicator",
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
     *         response="201", description="Applicator updated"
     *     )
     * )
     *
     * @param  ApplicatorUpdateRequest $request
     * @param  Applicator $applicator
     *
     * @return ApplicatorResource
     */
    public function update(ApplicatorUpdateRequest $request, Applicator $applicator)
    {
        $applicator->update($request->validated());

        return new ApplicatorResource($applicator);
    }

    /**
     * @OA\Delete(
     *     tags={"applicators"},
     *     summary="Remove the specified resource from storage.",
     *     description="remove a applicator on database",
     *     path="/applicators/{applicator}",
     *     @OA\Parameter(
     *         description="Applicator id",
     *         in="path",
     *         name="applicator",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200", description="Applicator deleted"
     *     )
     * )
     *
     * @param  Applicator $applicator
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Applicator $applicator)
    {
        $applicator->delete();

        return response()->json(null, 204);
    }
}
