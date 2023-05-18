<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'AssetController@index')->name('home');

    Route::resource('asset', AssetController::class);
    Route::resource('asset-location', AssetLocationController::class);
    Route::resource('asset-model', AssetModelController::class);
    Route::resource('asset-transactions', AssetTransactionsController::class);
    Route::resource('asset-type', AssetTypeController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('employee', EmployeeController::class);
    Route::resource('manufacturer', ManufacturerController::class);
    Route::resource('vendor', VendorController::class);
    Route::resource('asset-tracking', AssetTrackingController::class);

    $router->get('get-sn', 'AssetTrackingController@getSn');
});
