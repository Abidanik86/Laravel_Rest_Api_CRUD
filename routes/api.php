<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::apiResource('users' , UserController::class);

//use this route for get the speciic data from index ,get a $flag variable in index then check info.
//Route::get('users/get/{flag}' , [UserController::class , 'index']);

// Normal Way Api Starts...................
// Route::get('/user' , function(){
//    return response()->json([
//     'success' => true,
//     'message' => 'Hello World',
//     'data' => [],
//    ]);
// });

// Route::delete('/user_delete/{id}' , function($id){
//     return response()->json([
//         'id' =>  $id, 
//         'message'=> 'user deleted successfully',
//         'data' => [],
//     ], 200);
// });
// Route::put('/user_put/{id}' , function($id){
//     return response()->json([
//         'id' =>  $id,
//         'message'=> 'user updated successfully ' . $id,
//         'data' => [],
//     ], 200);
// });

//Second Way
//Route::post('/user/store',[UserController::class, 'store']);

//Testing if helper.php file function p is workign orking
// Route::get('/test', function(){
//     p("working");
// });
//Normal Way Starts...................

