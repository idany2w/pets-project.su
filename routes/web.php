<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'index');

/**
 * Я бы вынес все в /api/, но насколько я понял ТЗ, все нужно сюда
 */

Route::prefix('animal_kinds')->name('animal_kinds')->group(function () {
    Route::get('/', function () {
        return '[{
            "kind": "cat",
            "max_size": 25,
            "max_age": 100,
            "growth_factor": 1.3
        }]';
    })->name('');
});

Route::prefix('animals')->name('animals')->group(function () {
    Route::get('/', function () {
        return '[{
            "kind": "cat",
            "name": "Simon",
            "age": 1,
            "size": 1
        }]';
    })->name('');

    Route::get('/{$name}', function ($user) {
        return '{
            "name": "Simon",
            "kind": "cat",
            "age": 1,
            "size": 1
        }';
    })->name('.single');

    Route::post('/', function ($name, $kind) {
        return '{
            "error": null
            "data": "ok"
        }';
    })->name('.create');

    Route::post('/age', function ($name) {
        return '{
            "error": null
            "data": "ok"
        }';
    })->name('.age');
});