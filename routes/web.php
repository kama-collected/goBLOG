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

/** Content related routes
 *  Main page according to logged user
 */ 
Route::middleware(['auth'])->group(function () {
    //Content routes
    Route::get('/feed/{name}/{user_id}', [ContentController::class, 'showFeed'])->name('user.feed');
    Route::post('/store', [ContentController::class, 'store'])->name('store.post');
    Route::get('/content/{content_id}', [ContentController::class, 'show'])->name('content.show');
    Route::get('/content/{content_id}/edit', [ContentController::class, 'edit'])->name('content.edit');
    Route::put('/content/{content_id}', [ContentController::class, 'update'])->name('content.update');
    Route::delete('/content/{content_id}', [ContentController::class, 'destroy'])->name('content.delete');
    //Explore routes
    Route::get('/explore', [ContentController::class, 'explore'])->name('content.explore');
    Route::get('/explore/{user_id}', [ContentController::class, 'exploreUser'])->name('content.exploreUser');
    //Likes routes
    Route::post('/contents/{content}', [LikeController::class, 'like'])->name('post.like');
    Route::delete('/contents/{content}', [LikeController::class, 'unlike'])->name('post.unlike');
    //Comments routes
    Route::post('/contents/{content_id}/comments', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
    //Edit user profile routes
    Route::get('/profile/edit', [UserController::class, 'editUser'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateUser'])->name('profile.update');

});

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
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

Route::get('/contentsDashBoard',[UserController::class,'loadContent']);