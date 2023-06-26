<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//* importato il controller Api\ProjectController
use App\Http\Controllers\Api\ProjectController;

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

// rotta inserita di default
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//* test api con controller
Route::get('/test-api', [ProjectController::class, 'testApi'])->name('test-api');

//* test api senza controller
// Route::get('/test-api', function(){

//   $test = [
//     'name' => 'Mario',
//     'surname' => 'Rossi'
//   ];
//   return response()->json($test);
// });

//* test api: cercare sul browser o in thunder client
//* http://127.0.0.1:8000/api/test-api

//-----------------------------------------------------

//* rotta collegata al controller per le api
Route::namespace('api')
        ->prefix('projects')
        ->group(function(){
          Route::get('/', [ProjectController::class, 'index']);
        });

//* cercare sul browser o in thunder client
//* http://127.0.0.1:8000/api/projects















