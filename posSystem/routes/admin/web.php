<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryStatusController;
use Illuminate\Support\Facades\Route;

Route::get("/categories", [CategoryController::class,"index"])->name("categories_index");
Route::get('/category_review', [CategoryController::class,'reviewCategory'])->name('category_review');
Route::get('/category_import', [CategoryController::class ,'importCategoryIndex'])->name('category_import');
Route::post('/category_import', [CategoryController::class ,'importExcelWithReview'])->name('category_import');
Route::post('/category_submit', [CategoryController::class,'store'])->name('category_submit');

Route::get('/category_status', [CategoryStatusController::class, 'index'])->name('category_status');
Route::post('/category_status_import', [CategoryStatusController::class, 'importExcelReview'])->name('category_status_import');


Route::get('/add_category', [CategoryController::class,'addCategoryIndex'])->name('add_category');
