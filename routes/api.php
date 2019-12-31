<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('applicators', 'ApplicatorController');

Route::apiResource('institutions', 'InstitutionController');

Route::apiResource('contests', 'ContestController');

Route::apiResource('categories', 'CategoryController');

Route::apiResource('sub-categories', 'SubCategoryController');

Route::apiResource('subjects', 'SubjectController');

Route::apiResource('questions', 'QuestionController');

Route::apiResource('options', 'OptionController');
