<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
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



Route::match(['get','post'],'/',[HomeController::class, 'index'])->name('blog.show');
// Route::post('/blog/search',[HomeController::class, 'searchBlog'])->name('blog.search');
Route::post('/blog/search',[HomeController::class, 'searchBlog'])->name('blog.search.show');
Route::get('/blog/{slug}',[HomeController::class, 'searchBlogbyuser'])->name('blog.user.show');
Route::get('/blog/{slug}/search/{id}',[HomeController::class, 'searchArtributeBlog'])->name('blog.search');
Route::match(['get','post'],'/post/{slug}',[HomeController::class, 'show'])->name('post.show');
Route::post('/add/comment/{slug}',[HomeController::class, 'addcomment'])->name('add.comment');
Route::get('/add/like/{slug}',[HomeController::class, 'addlike'])->name('add.like');
Route::get('/add/dislike/{slug}',[HomeController::class, 'removelike'])->name('add.dislike');


Route::match(['get','post'],'/user/panel',[UserController::class, 'index'])->name('user.panel');
Route::match(['get','post'],'/admin/users',[UserController::class, 'getUsers'])->name('admin.view.users');
Route::match(['get','post'],'/admin/user/approve',[UserController::class, 'getUserApprove'])->name('admin.view.user.approve');
Route::delete('/admin/delete/user/{slug}',[UserController::class, 'deleteUsers'])->name('admin.delete.users');
Route::get('/user/post/comments',[UserController::class, 'getComment'])->name('post.comment');
Route::match(['get','post'],'/user/post/views',[UserController::class, 'getView'])->name('post.view');
Route::delete('/user/delete/comments/{id}',[UserController::class, 'deleteComment'])->name('comment.delete');

Route::post('/add/tag',[BlogController::class, 'addTag'])->name('add.tag');
Route::post('/add/category',[BlogController::class, 'addCategory'])->name('add.category');
Route::get('/create/post',[BlogController::class, 'show']);
Route::post('/create/post',[BlogController::class, 'store'])->name('create.post');
Route::post('/update/post/{slug}',[BlogController::class, 'update'])->name('update.post');
Route::get('/edit/post/{slug}',[BlogController::class, 'edit'])->name('edit.post');
Route::get('/view/post',[BlogController::class, 'index'])->name('post.admin.view');
Route::delete('/delete/post/{slug?}',[BlogController::class, 'delete'])->name('post.delete');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
