<?php

namespace App\Http\Controllers;

use App\Question;
use App\Http\Requests\QuestionStoreRequest;
use App\Http\Requests\QuestionUpdateRequest;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionCollection;

use Exception;
use Illuminate\Http\JsonResponse;

class QuestionController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"questions"},
     *     summary="Display a listing of the resource",
     *     description="get all question on database and paginate then",
     *     path="/questions",
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
     *         response="200", description="List of questions"
     *     )
     * )
     *
     * @return QuestionCollection
     */
    public function index()
    {
        $limit = request()->has('limit') ? request()->get('limit') : null;
        return new QuestionCollection(Question::paginate($limit));
    }

    /**
     * @OA\Post(
     *     tags={"questions"},
     *     summary="Store a newly created resource in storage.",
     *     description="store a new question on database",
     *     path="/questions",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="statement", type="string"),
     *             @OA\Property(property="subject_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="contest_id", type="integer"),
     *       )
     *     ),
     *     @OA\Response(
     *         response="201", description="New question created"
     *     )
     * )
     *
     * @param  QuestionStoreRequest $request
     * @return QuestionResource
     */
    public function store(QuestionStoreRequest $request)
    {
        return new QuestionResource(Question::create($request->validated()));
    }

    /**
     * @OA\Get(
     *     tags={"questions"},
     *     summary="Display the specified resource.",
     *     description="show question",
     *     path="/questions/{question}",
     *     @OA\Parameter(
     *         description="Question id",
     *         in="path",
     *         name="question",
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
     *         response="200", description="Show question"
     *     )
     * )
     *
     * @param  Question $question
     * @return QuestionResource
     */
    public function show(Question $question)
    {
        return new QuestionResource($question);
    }

    /**
     * @OA\Put(
     *     tags={"questions"},
     *     summary="Update the specified resource in storage",
     *     description="update a question on database",
     *     path="/questions/{question}",
     *     @OA\Parameter(
     *         description="Question id",
     *         in="path",
     *         name="question",
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
     *             @OA\Property(property="subject_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="contest_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="201", description="Question updated"
     *     )
     * )
     *
     * @param  QuestionUpdateRequest $request
     * @param  Question $question
     *
     * @return QuestionResource
     */
    public function update(QuestionUpdateRequest $request, Question $question)
    {
        $question->update($request->validated());

        return new QuestionResource($question);
    }

    /**
     * @OA\Delete(
     *     tags={"questions"},
     *     summary="Remove the specified resource from storage.",
     *     description="remove a question on database",
     *     path="/questions/{question}",
     *     @OA\Parameter(
     *         description="Question id",
     *         in="path",
     *         name="question",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200", description="Question deleted"
     *     )
     * )
     *
     * @param  Question $question
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return response()->json(null, 204);
    }
}
