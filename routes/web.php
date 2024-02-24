<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RentLogController;
use App\Http\Controllers\BookRentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewBookController;

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

Route::get('/', [PublicController::class, 'index']);


Route::middleware('only_guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticating']);
    Route::get('register', [AuthController::class, 'register']);
    Route::post('register', [AuthController::class, 'registerProcess']);
});

Route::middleware('auth')->group(function () {
    Route::get('registerAdmin', [AuthController::class, 'registerAdmin']);
    Route::post('registerAdmin', [AuthController::class, 'registerProcessAdmin']);

    Route::get('logout', [AuthController::class, 'logout']);

    Route::get('profile', [UserController::class, 'profile'])->middleware('only_client');
    Route::get('rent-logs', [RentLogController::class, 'index']);


    Route::get('koleksi', [RatingController::class, 'indexCollection'])->middleware('only_client');;
    Route::get('book-collect/{slug}', [RatingController::class, 'collect'])->name('book.collect');
    Route::get('koleksi-destroy/{slug}', [RatingController::class, 'destroy'])->name('koleksi-destroy');
    Route::get('book-detail/{slug}', [RatingController::class, 'detail'])->name('book.detail');
    Route::post('book-rent/{slug}', [RatingController::class, 'rent'])->name('book.rent');
    
    Route::post('book-rating/{slug}', [ReviewBookController::class, 'store'])->name('book.rating');
    Route::post('book-rating/{slug}/rating/update', [RatingController::class, 'updateRate'])->name('book.rating.update');
    Route::post('rating-destroy/{slug}', [RatingController::class, 'destroyRate'])->name('rating-destroy');

    Route::get('book-rent', [BookRentController::class, 'index']);
    Route::post('book-rent', [BookRentController::class, 'store']);
    Route::get('book-return', [BookRentController::class, 'returnBook']);
    Route::post('book-return', [BookRentController::class, 'saveReturnBook']);


    Route::middleware('only_petugas')->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->middleware('only_admin');;

    Route::get('books', [BookController::class, 'index']);
    Route::get('book-add', [BookController::class, 'add']);
    Route::post('book-add', [BookController::class, 'store']);
    Route::get('book-edit/{slug}', [BookController::class, 'edit']);
    Route::post('book-edit/{slug}', [BookController::class, 'update']);
    Route::get('book-delete/{slug}', [BookController::class, 'delete']);
    Route::get('book-destroy/{slug}', [BookController::class, 'destroy']);
    Route::get('book-deleted', [BookController::class, 'deletedBook']);
    Route::get('book-restore/{slug}', [BookController::class, 'restore']);
    Route::get('book-force/{slug}', [BookController::class, 'force']);
    Route::get('book-stock/{slug}', [BookController::class, 'stock']);
    Route::put('books/{slug}/update-stock', [BookController::class, 'updateStock'])->name('books.updateStock');

    Route::get('categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('category-add', [CategoryController::class, 'add']);
    Route::post('category-add', [CategoryController::class, 'store']);
    Route::get('category-edit/{slug}', [CategoryController::class, 'edit']);
    Route::put('category-edit/{slug}', [CategoryController::class, 'update']);
    Route::get('category-delete/{slug}', [CategoryController::class, 'delete']);
    Route::get('category-destroy/{slug}', [CategoryController::class, 'destroy']);
    Route::get('category-deleted', [CategoryController::class, 'deletedCategory']);
    Route::get('category-restore/{slug}', [CategoryController::class, 'restore']);
    Route::get('category-force/{slug}', [CategoryController::class, 'force']);

    Route::get('users', [UserController::class, 'index']);
    Route::get('officers', [UserController::class, 'officer']);
    Route::get('registered-users', [UserController::class, 'registeredUser']);
    Route::get('user-detail/{slug}', [UserController::class, 'show']);
    Route::get('user-approve/{slug}', [UserController::class, 'approve']);
    Route::get('user-ban/{slug}', [UserController::class, 'delete']);
    Route::get('user-destroy/{slug}', [UserController::class, 'destroy']);
    Route::get('user-banned', [UserController::class, 'bannedUser']);
    Route::get('user-restore/{slug}', [UserController::class, 'restore']);
    Route::get('user-force/{slug}', [UserController::class, 'force']);

    
    });
});
