<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'index');

/**
 * Я бы вынес все в /api/, но насколько я понял ТЗ, все нужно сюда
 */

Route::prefix('animal_kinds')->name('animal_kinds')->group(function () {
    Route::get('/', [App\Http\Controllers\AnimalKindController::class, 'index'])->name('index');
});

Route::prefix('animals')->name('animals')->group(function () {
    Route::get('/', [App\Http\Controllers\AnimalController::class, 'index'])->name('index');

    Route::get('/{$name}', [App\Http\Controllers\AnimalController::class, 'show'])->name('.show');

    Route::post('/', [App\Http\Controllers\AnimalController::class, 'store'])->name('.store');

    Route::post('/age', [App\Http\Controllers\AnimalController::class, 'age'])->name('.age');
});