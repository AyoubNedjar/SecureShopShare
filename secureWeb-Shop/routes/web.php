<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ModerationController;

Route::get('/', function () {
    return view('welcome');
});

// Route pour afficher le tableau de bord
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




// Routes pour gérer les boutiques (CRUD complet)
Route::middleware('auth')->group(function () {
    Route::resource('boutiques', BoutiqueController::class);
});

// Routes pour gérer les articles (CRUD complet)
Route::middleware('auth')->group(function () {
    Route::resource('articles', ArticleController::class);
});

// Routes pour la modération (uniquement pour les modérateurs)
Route::middleware(['auth', 'moderator'])->group(function () {
    Route::resource('moderations', ModerationController::class)->only(['index', 'update']);
});





//fin logique du shop


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->middleware('throttle:10,1');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard')->with('status', 'Email verified successfully.');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

require __DIR__.'/auth.php';
