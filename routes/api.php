<?php

use App\Http\Middleware\AuthSchoolMiddleware;
use App\Http\Middleware\AuthStudentMiddleware;
use App\Http\Middleware\AuthTeacherMiddleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

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

Route::middleware('auth:api')->group(function () {
    Route::post('/message/to', 'PusherController@to');
    Route::middleware(AuthSchoolMiddleware::class)->group(function () {
        Route::get('/school/list', 'UserController@getSchoolList');
        Route::get('/teacher/list', 'SchoolController@getTeacherList');
        Route::post('/inviter/teacher', 'SchoolController@inviteTeacher');
    });
    Route::middleware(AuthTeacherMiddleware::class)->group(function () {
        Route::get('/student/list', 'TeacherController@getStudentList');
        Route::get('/teacher/follow/list', 'TeacherController@getFollowList');
    });
    Route::middleware(AuthStudentMiddleware::class)->group(function () {
        Route::post('/teacher/follow', 'StudentController@followTeacher');
        Route::put('/teacher/unfollow', 'StudentController@unFollowTeacher');
        Route::get('/teacher/alllist', 'StudentController@getAllTeacherList');
    });
});


Route::post('/register', 'RegisterController@register');
Route::put('/oauth/refresh', 'AuthController@refreshToken');
Route::get('/login', 'AuthController@login');
