<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\WeightController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\SettingsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dash', function () {return view('dash');})->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');




Route::get('/dash', [SectionController::class,'dash']) -> name('dash');

Route::get('/settings', [SectionController::class,'settings']) -> name('settings');

Route::prefix('weight')->group(function(){
    Route::get('/', [WeightController::class, 'index'])->name('weight.index');

    Route::post('/', [WeightController::class, 'store'])->name('weight.store');

    Route::delete('/{id}', [WeightController::class, 'destroy'])->name('weight.destroy');
});

Route::prefix('workouts')->group(function (){
        Route::get('/', [WorkoutController::class, 'index'])->name('workouts.index');

        Route::get('/day', [WorkoutController::class, 'dayExercises']);

        Route::get('/create', [WorkoutController::class, 'create'])->name('workouts.create');

        Route::post('/', [WorkoutController::class, 'store'])->name('workouts.store');

        Route::get('/{id}/edit', [WorkoutController::class, 'edit'])->name('workouts.edit');

        Route::put('/{id}', [WorkoutController::class, 'update'])->name('workouts.update');

        Route::delete('/{id}', [WorkoutController::class, 'destroy'])->name('workouts.destroy');
});

Route::prefix('settings')->group(function (){
        Route::get('/', [SettingsController::class, 'index'])->name('settings');
        Route::post('/theme', [SettingsController::class, 'updateTheme'])->name('settings.theme');
        //Route::post('/unit', [SettingsController::class, 'updateUnit'])->name('settings.unit');

});




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
