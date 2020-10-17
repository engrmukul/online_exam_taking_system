<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['auth']], function () {
    //RESET PASSWORD
    Route::get('/change-password', 'HomeController@changePassword')->name('change-password');
    Route::put('/reset-password', 'HomeController@resetPassword')->name('reset-password');

    Route::resource('users', 'UserController', ['except' => ['show']]);
    Route::get('users/get-data', 'UserController@getData');


    Route::resource('subjects', 'SubjectController', ['except' => ['show']]);
    Route::get('subjects/get-data', 'SubjectController@getData');
    Route::get('subjects/restore', 'SubjectController@restore')->name('subjects.restore');

    Route::resource('questions', 'QuestionController', ['except' => ['show']]);
    Route::get('questions/get-data', 'QuestionController@getData');
    Route::get('questions/restore', 'QuestionController@restore')->name('questions.restore');

    Route::resource('exams', 'ExamController', ['except' => ['show']]);
    Route::get('exams/get-data', 'ExamController@getData');
    Route::get('exams/restore', 'ExamController@restore')->name('exams.restore');

    Route::resource('question-papers', 'QuestionPaperController', ['except' => ['show']]);
    Route::get('question-papers/get-data', 'QuestionPaperController@getData');
    Route::get('question-papers/restore', 'QuestionPaperController@restore')->name('question-papers.restore');

    Route::resource('question-assigns', 'QuestionAssignController', ['except' => ['show']]);
    Route::get('question-assigns/get-data', 'QuestionAssignController@getData');
    Route::get('question-assigns/restore', 'QuestionAssignController@restore')->name('question-assigns.restore');

    Route::resource('tests', 'TestController', ['except' => ['show']]);
    Route::get('tests/get-data', 'TestController@getData');

});


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');


//FALLBACK ROUTE
Route::fallback(function () {
    return response()->view('error.404');
});
