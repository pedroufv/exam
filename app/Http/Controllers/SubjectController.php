<?php

namespace App\Http\Controllers;

use App\Subject;
use App\Http\Requests\SubjectStoreRequest;
use App\Http\Requests\SubjectUpdateRequest;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\SubjectCollection;

use Exception;
use Illuminate\Http\JsonResponse;

class SubjectController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"subjects"},
     *     summary="Display a listing of the resource",
     *     description="get all subject on database and paginate then",
     *     path="/subjects",
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
     *         response="200", description="List of subjects"
     *     )
     * )
     *
     * @return SubjectCollection
     */
    public function index()
    {
        $limit = request()->has('limit') ? request()->get('limit') : null;
        return new SubjectCollection(Subject::paginate($limit));
    }

    /**
     * @OA\Post(
     *     tags={"subjects"},
     *     summary="Store a newly created resource in storage.",
     *     description="store a new subject on database",
     *     path="/subjects",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="subcategory_id", type="integer"),
     *       )
     *     ),
     *     @OA\Response(
     *         response="201", description="New subject created"
     *     )
     * )
     *
     * @param  SubjectStoreRequest $request
     * @return SubjectResource
     */
    public function store(SubjectStoreRequest $request)
    {
        return new SubjectResource(Subject::create($request->validated()));
    }

    /**
     * @OA\Get(
     *     tags={"subjects"},
     *     summary="Display the specified resource.",
     *     description="show subject",
     *     path="/subjects/{subject}",
     *     @OA\Parameter(
     *         description="Subject id",
     *         in="path",
     *         name="subject",
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
     *         response="200", description="Show subject"
     *     )
     * )
     *
     * @param  Subject $subject
     * @return SubjectResource
     */
    public function show(Subject $subject)
    {
        return new SubjectResource($subject);
    }

    /**
     * @OA\Put(
     *     tags={"subjects"},
     *     summary="Update the specified resource in storage",
     *     description="update a subject on database",
     *     path="/subjects/{subject}",
     *     @OA\Parameter(
     *         description="Subject id",
     *         in="path",
     *         name="subject",
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
     *             @OA\Property(property="subcategory_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="201", description="Subject updated"
     *     )
     * )
     *
     * @param  SubjectUpdateRequest $request
     * @param  Subject $subject
     *
     * @return SubjectResource
     */
    public function update(SubjectUpdateRequest $request, Subject $subject)
    {
        $subject->update($request->validated());

        return new SubjectResource($subject);
    }

    /**
     * @OA\Delete(
     *     tags={"subjects"},
     *     summary="Remove the specified resource from storage.",
     *     description="remove a subject on database",
     *     path="/subjects/{subject}",
     *     @OA\Parameter(
     *         description="Subject id",
     *         in="path",
     *         name="subject",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200", description="Subject deleted"
     *     )
     * )
     *
     * @param  Subject $subject
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return response()->json(null, 204);
    }
}
