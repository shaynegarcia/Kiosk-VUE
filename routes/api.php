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


Route::get('cart', 'API\OrderProcessingController@index');

Route::get('stock', 'API\StockController@search');

// // routes for user
// Route::apiResource('user','API\UserController');
// Route::get('findUser','API\UserController@search');
// Route::get('profile','API\UserController@profile');
// Route::put('profile', 'API\UserController@updateProfile');
// // routes for items
// Route::apiResource('item','API\ItemController')->only(['index','store','update']);
// Route::get('findItem','API\ItemController@search');
// Route::post('importCSV','API\ItemController@importCSV');
// // routes for invoice
// Route::apiResource('invoice', 'API\InvoiceController');//->only(['store']);
// Route::get('findInvoiceHistory', 'API\InvoiceController@search');
// // Route::put('softDelete', 'API\InvoiceController@softDelete');


// Route::get('itemavailability/{id}', 'Api\ItemAvailabilityController')
//     ->name('item.availability.show');
// // Route::post('exportinvoicebetween',)
// Route::get('searchForInvoicesExport' , 'Api\InvoiceController@searchForInvoicesExport');
// Route::post('softDelete', 'Api\InvoiceController@softDelete');


// Route::post('updateInvoice', 'Api\InvoiceController@updateInvoice');