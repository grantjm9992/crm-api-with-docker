<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('task', 'TaskCrudController');
    Route::crud('user', 'UserCrudController');
    Route::crud('tasktype', 'TaskTypeCrudController');
    Route::crud('taskstatus', 'TaskStatusCrudController');
    Route::crud('taskcomments', 'TaskCommentsCrudController');
    Route::crud('school', 'SchoolCrudController');
    Route::crud('campaigns', 'CampaignsCrudController');
}); // this should be the absolute last line of this file