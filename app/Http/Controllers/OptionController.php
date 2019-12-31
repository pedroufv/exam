<?php

namespace App\Http\Controllers;

use App\Option;
use App\Http\Requests\OptionStoreRequest;
use App\Http\Requests\OptionUpdateRequest;
use App\Http\Resources\OptionResource;
use App\Http\Resources\OptionCollection;

use Exception;
use Illuminate\Http\JsonResponse;

class OptionController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"options"},
     *     summary="Display a listing of the resource",
     *     description="get all option on database and paginate then",
     *     path="/options",
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
     *         response="200", description="List of options"
     *     )
     * )
     *
     * @return OptionCollection
     */
    public function index()
    {
        $limit = request()->has('limit') ? request()->get('limit') : null;
        return new OptionCollection(Option::paginate($limit));
    }

    /**
     * @OA\Post(
     *     tags={"options"},
     *     summary="Store a newly created resource in storage.",
     *     description="store a new option on database",
     *     path="/options",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="statement", type="string"),
     *             @OA\Property(property="correct", type="boolean"),
     *             @OA\Property(property="question_id", type="integer"),
     *       )
     *     ),
     *     @OA\Response(
     *         response="201", description="New option created"
     *     )
     * )
     *
     * @param  OptionStoreRequest $request
     * @return OptionResource
     */
    public function store(OptionStoreRequest $request)
    {
        return new OptionResource(Option::create($request->validated()));
    }

    /**
     * @OA\Get(
     *     tags={"options"},
     *     summary="Display the specified resource.",
     *     description="show option",
     *     path="/options/{option}",
     *     @OA\Parameter(
     *         description="Option id",
     *         in="path",
     *         name="option",
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
     *         response="200", description="Show option"
     *     )
     * )
     *
     * @param  Option $option
     * @return OptionResource
     */
    public function show(Option $option)
    {
        return new OptionResource($option);
    }

    /**
     * @OA\Put(
     *     tags={"options"},
     *     summary="Update the specified resource in storage",
     *     description="update a option on database",
     *     path="/options/{option}",
     *     @OA\Parameter(
     *         description="Option id",
     *         in="path",
     *         name="option",
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
     *             @OA\Property(property="statement", type="string"),
     *             @OA\Property(property="correct", type="boolean"),
     *             @OA\Property(property="question_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="201", description="Option updated"
     *     )
     * )
     *
     * @param  OptionUpdateRequest $request
     * @param  Option $option
     *
     * @return OptionResource
     */
    public function update(OptionUpdateRequest $request, Option $option)
    {
        $option->update($request->validated());

        return new OptionResource($option);
    }

    /**
     * @OA\Delete(
     *     tags={"options"},
     *     summary="Remove the specified resource from storage.",
     *     description="remove a option on database",
     *     path="/options/{option}",
     *     @OA\Parameter(
     *         description="Option id",
     *         in="path",
     *         name="option",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200", description="Option deleted"
     *     )
     * )
     *
     * @param  Option $option
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Option $option)
    {
        $option->delete();

        return response()->json(null, 204);
    }
}
