<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;


//  Immediately redirects to login page
Route::get('/', [UserController::class, 'checkLogIn'])->name('user.check'); 

/** Log in routes
 *  Once logged in, redirected to /feed/{name}/{id}
 */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

/** Sign up routes
 *  Redirects to log in page
 */ 
Route::get('/signup', [AuthController::class, 'showRegister'])->name('signup');
Route::post('/signup', [AuthController::class, 'register'])->name('signup');

/** Log out route
 *  Redirects to log in page
 */ 
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/** Feed routes
 *  Main page according to logged user
 */ 
Route::middleware(['auth'])->group(function () {
    Route::get('/feed/{name}/{user_id}', [ContentController::class, 'showFeed'])->name('user.feed');
});
Route::post('/store', [ContentController::class, 'store'])->name('store.post');
Route::get('content/{content_id}', [ContentController::class, 'show'])->name('content.show');
Route::get('/content/{content_id}/edit', [ContentController::class, 'edit'])->name('content.edit');
Route::put('/content/{content_id}', [ContentController::class, 'update'])->name('content.update');
Route::delete('/content/{content_id}', [ContentController::class, 'destroy'])->name('content.delete');


//Route::post('/content/newContent',[UserController::class,'makepost'])->name('contents.store');
//Route::get('/content/{content}',[UserController::class,'getPost'])->name('contents.show');
//Route::get('/content/{content}/delete',[UserController::class,'deletepost'])->name('contents.delete');
//Route::resource('contents', ContentController::class)->except(['index']);
//Route::get('/home', [ContentController::class, 'index'])->name('home');
Route::get('/explore', [ContentController::class, 'explore'])->name('contents.explore');

Route::middleware(['auth', 'can:manage,App\Models\User'])->group(function () {
    Route::resource('users', UserController::class)->except(['index']);
});
Route::middleware(['auth', 'can:manage,App\Models\User'])->group(function () {
    Route::get('/admindashboard', [AuthController::class, 'admindashboard'])->name('admindashboard');
    Route::resource('users', UserController::class);
});

// Individual Route for Editing Users
Route::middleware(['auth', 'can:manage,App\Models\User'])->group(function () {
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('edit');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/userTable', [UserController::class, 'index'])->name('userTable');
});

Route::get('/create', [UserController::class, 'create'])->name('create');

// User profile routes
Route::get('/users/{users}', [UserController::class, 'show'])->name('users.profile');
//Route::get('/users/{users}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{users}', [UserController::class, 'update'])->name('users.update');

//Likes Route
Route::post('/contents/{content}', [LikeController::class, 'like'])->name('post.like');
Route::delete('/contents/{content}', [LikeController::class, 'unlike'])->name('post.unlike');

// Comment routes
Route::post('/contents/{content}/comments', [UserController::class, 'writecomment'])->name('comments.store');
Route::delete('/comments/{comment}', [UserController::class, 'writecomment'])->name('comments.destroy');

Route::get('/contentsDashBoard',[UserController::class,'loadContent']);