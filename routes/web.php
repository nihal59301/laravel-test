<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;

use Illuminate\Support\Facades\Route;
use App\Models\ProductModel;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $data=ProductModel::where('is_active',1)->get();
    return view('dashboard',compact('data'));
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/sellerhome', function () {
    return view('sellerhome');
})->middleware(['auth', 'verified'])->name('sellerhome');
Route::get('/adminhome', function () {
    return view('adminhome');
})->middleware(['auth', 'verified'])->name('adminhome');




Route::post('product', [ProductController::class, 'store']);
Route::post('productlist', [ProductController::class, 'productlist']);
Route::get('productedit', [ProductController::class, 'productedit']);
Route::post('productdelete', [ProductController::class, 'productdelete']);
Route::post('deleteuser', [ProductController::class, 'deleteuser']);
Route::get('/editProduct/{id}', [ProductController::class, 'update']);
Route::get('{any}/getData/{id}', [ProductController::class, 'getData']);
Route::post('productupdate', [ProductController::class, 'updateData']);




Route::get('userlist', [ProductController::class, 'userlist']);
Route::get('itemlist', [ProductController::class, 'itemlist']);











Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
