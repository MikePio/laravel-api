<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TechnologyController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Guest\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

//* rotte dei guest/utenti non loggati
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/projects', [PageController::class, 'projects'])->name('projects');
Route::get('/contacts', [PageController::class, 'contacts'])->name('contacts');

//* rotte degli admin/utenti loggati
Route::middleware(['auth', 'verified'])
    //! SBAGLIATO rotte senza punto (ORMAI RESTA SBAGLIATO IN QUESTO PROGETTO)
    ->name('admin')
    //* CORRETTO rotte con il punto
    // ->name('admin.')
    ->prefix('admin')
    ->group(function(){
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::resource('projects', ProjectController::class);
        Route::resource('types', TypeController::class);
        Route::get('type-projects', [ProjectController::class, 'typeProjects'])->name('type_projects');
        Route::get('technologies-projects', [ProjectController::class, 'technologiesProjects'])->name('technologies_projects');
        Route::resource('technologies', TechnologyController::class);
        Route::get('projects/orderby/{direction}/{column}', [ProjectController::class, 'orderby'])->name('.projects.orderby');
    });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// far funzionare tutte le rotte vue //* QUESTO CODICE SERVE QUANDO C'è un progetto unico laravel + vite per far funzionare le rotte di vue INVECE è INUTILE SE CI SONO I 2 PROGETTI SEPARATI (1 di laravel e un altro di vite)
// Route::get('{any?}',function(){
//   return view('guest.home');
// })->where('any','.*')->name('home');
