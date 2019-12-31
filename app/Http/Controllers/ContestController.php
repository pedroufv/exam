<?php

namespace App\Http\Controllers;

use App\Contest;
use App\Http\Requests\ContestStoreRequest;
use App\Http\Requests\ContestUpdateRequest;
use App\Http\Resources\ContestResource;
use App\Http\Resources\ContestCollection;

use Exception;
use Illuminate\Http\JsonResponse;

class ContestController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"contests"},
     *     summary="Display a listing of the resource",
     *     description="get all contest on database and paginate then",
     *     path="/contests",
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
     *         response="200", description="List of contests"
     *     )
     * )
     *
     * @return ContestCollection
     */
    public function index()
    {
        $limit = request()->has('limit') ? request()->get('limit') : null;
        return new ContestCollection(Contest::paginate($limit));
    }

    /**
     * @OA\Post(
     *     tags={"contests"},
     *     summary="Store a newly created resource in storage.",
     *     description="store a new contest on database",
     *     path="/contests",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="year", type="string"),
     *             @OA\Property(property="number", type="integer"),
     *             @OA\Property(property="institution_id", type="integer"),
     *             @OA\Property(property="applicator_id", type="integer"),
     *       )
     *     ),
     *     @OA\Response(
     *         response="201", description="New contest created"
     *     )
     * )
     *
     * @param  ContestStoreRequest $request
     * @return ContestResource
     */
    public function store(ContestStoreRequest $request)
    {
        return new ContestResource(Contest::create($request->validated()));
    }

    /**
     * @OA\Get(
     *     tags={"contests"},
     *     summary="Display the specified resource.",
     *     description="show contest",
     *     path="/contests/{contest}",
     *     @OA\Parameter(
     *         description="Contest id",
     *         in="path",
     *         name="contest",
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
     *         response="200", description="Show contest"
     *     )
     * )
     *
     * @param  Contest $contest
     * @return ContestResource
     */
    public function show(Contest $contest)
    {
        return new ContestResource($contest);
    }

    /**
     * @OA\Put(
     *     tags={"contests"},
     *     summary="Update the specified resource in storage",
     *     description="update a contest on database",
     *     path="/contests/{contest}",
     *     @OA\Parameter(
     *         description="Contest id",
     *         in="path",
     *         name="contest",
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
     *             @OA\Property(property="year", type="string"),
     *             @OA\Property(property="number", type="integer"),
     *             @OA\Property(property="institution_id", type="integer"),
     *             @OA\Property(property="applicator_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="201", description="Contest updated"
     *     )
     * )
     *
     * @param  ContestUpdateRequest $request
     * @param  Contest $contest
     *
     * @return ContestResource
     */
    public function update(ContestUpdateRequest $request, Contest $contest)
    {
        $contest->update($request->validated());

        return new ContestResource($contest);
    }

    /**
     * @OA\Delete(
     *     tags={"contests"},
     *     summary="Remove the specified resource from storage.",
     *     description="remove a contest on database",
     *     path="/contests/{contest}",
     *     @OA\Parameter(
     *         description="Contest id",
     *         in="path",
     *         name="contest",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200", description="Contest deleted"
     *     )
     * )
     *
     * @param  Contest $contest
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Contest $contest)
    {
        $contest->delete();

        return response()->json(null, 204);
    }
}
