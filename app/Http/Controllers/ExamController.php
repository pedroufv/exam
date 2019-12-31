<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Http\Requests\ExamStoreRequest;
use App\Http\Requests\ExamUpdateRequest;
use App\Http\Resources\ExamResource;
use App\Http\Resources\ExamCollection;

use Exception;
use Illuminate\Http\JsonResponse;

class ExamController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"exams"},
     *     summary="Display a listing of the resource",
     *     description="get all exam on database and paginate then",
     *     path="/exams",
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
     *         response="200", description="List of exams"
     *     )
     * )
     *
     * @return ExamCollection
     */
    public function index()
    {
        $limit = request()->has('limit') ? request()->get('limit') : null;
        return new ExamCollection(Exam::paginate($limit));
    }

    /**
     * @OA\Post(
     *     tags={"exams"},
     *     summary="Store a newly created resource in storage.",
     *     description="store a new exam on database",
     *     path="/exams",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="amount", type="integer"),
     *             @OA\Property(property="finished_at", type="string"),
     *             @OA\Property(property="filters", type="string"),
     *             @OA\Property(property="user_id", type="integer"),
     *       )
     *     ),
     *     @OA\Response(
     *         response="201", description="New exam created"
     *     )
     * )
     *
     * @param  ExamStoreRequest $request
     * @return ExamResource
     */
    public function store(ExamStoreRequest $request)
    {
        return new ExamResource(Exam::create($request->validated()));
    }

    /**
     * @OA\Get(
     *     tags={"exams"},
     *     summary="Display the specified resource.",
     *     description="show exam",
     *     path="/exams/{exam}",
     *     @OA\Parameter(
     *         description="Exam id",
     *         in="path",
     *         name="exam",
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
     *         response="200", description="Show exam"
     *     )
     * )
     *
     * @param  Exam $exam
     * @return ExamResource
     */
    public function show(Exam $exam)
    {
        return new ExamResource($exam);
    }

    /**
     * @OA\Put(
     *     tags={"exams"},
     *     summary="Update the specified resource in storage",
     *     description="update a exam on database",
     *     path="/exams/{exam}",
     *     @OA\Parameter(
     *         description="Exam id",
     *         in="path",
     *         name="exam",
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
     *             @OA\Property(property="amount", type="integer"),
     *             @OA\Property(property="finished_at", type="string"),
     *             @OA\Property(property="filters", type="string"),
     *             @OA\Property(property="user_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="201", description="Exam updated"
     *     )
     * )
     *
     * @param  ExamUpdateRequest $request
     * @param  Exam $exam
     *
     * @return ExamResource
     */
    public function update(ExamUpdateRequest $request, Exam $exam)
    {
        $exam->update($request->validated());

        return new ExamResource($exam);
    }

    /**
     * @OA\Delete(
     *     tags={"exams"},
     *     summary="Remove the specified resource from storage.",
     *     description="remove a exam on database",
     *     path="/exams/{exam}",
     *     @OA\Parameter(
     *         description="Exam id",
     *         in="path",
     *         name="exam",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200", description="Exam deleted"
     *     )
     * )
     *
     * @param  Exam $exam
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return response()->json(null, 204);
    }
}
