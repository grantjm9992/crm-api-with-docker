<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', 'API\AuthController@register');
Route::post('login', 'API\AuthController@login')->name('login');

Route::get('routes', 'API\AuthController@routes');

Route::resource('users', 'API\UserController');
Route::resource('companies', 'API\CompanyController');
Route::resource('clients', 'API\ClientController');
Route::resource('schools', 'API\SchoolController');
Route::resource('students', 'API\StudentController');

Route::resource('contact-types', 'API\ContactTypeController');
Route::resource('contact-status', 'API\ContactStatusController');
Route::resource('interests', 'API\InterestController');
Route::resource('campaigns', 'API\CampaignController');
Route::resource('products', 'API\ProductsController');
Route::resource('tasks', 'API\TasksController');

Route::resource('channels', 'API\ChannelController');

Route::post('tasks/update-order', 'API\TasksController@updateTaskOrder');
Route::post('templates/fill', 'API\TemplatesController@fill');
Route::post('templates/send', 'API\TemplatesController@send');
Route::get('templates', 'API\TemplatesController@get');
Route::post('templates/{id}', 'API\TemplatesController@getTemplate');


Route::get('documents', 'API\DocumentsController@get');


Route::group(['middleware' => 'auth.api'], function () {
    Route::resource('contacts', 'API\ContactController');
    // Route::resource('messages', 'API\MessageController');
    // Route::resource('tasks', 'API\TaskController');
    // Route::resource('reservations', 'API\ReservationController');
    // Route::resource('notifications', 'API\NotificationController');
});
