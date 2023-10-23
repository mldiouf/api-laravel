<?php

use App\Http\Controllers\Api\PostController;
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
// recupere la liste des posts
Route::get('posts', [PostController::class, 'index']);




// inscrire un nouvelle utilisateur
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    // ajouter un post
Route::post('posts/create', [PostController::class, 'store']);
// modifier un post
Route::put('posts/edit/{id}', [PostController::class, 'update']);
// supprimer un post
Route::delete('posts/{post}', [PostController::class, 'delete']);
    // retourner l'utilisqteur connecte actuellement
   Route::get('/user', function(Request $request){
        return $request;
   });
});
