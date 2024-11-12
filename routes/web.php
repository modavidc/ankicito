<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnkiController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Route to convert notes into flashcards
Route::get('/convert', [AnkiController::class, 'convert'])->name('convert');

// Route to generate flashcards from notes
Route::post('/generate', [AnkiController::class, 'generate'])->name('generate');

// Route to preview generated flashcards
Route::get('/preview', [AnkiController::class, 'preview'])->name('preview');

// Route to download flashcards as a JSON file
Route::post('/downloadAsJSON', [AnkiController::class, 'downloadAsJSON'])->name('downloadAsJSON');

// Route to synchronize flashcards with Anki (optional)
Route::post('/sync-with-anki', [AnkiController::class, 'syncWithAnki'])->name('syncWithAnki');

Route::get('/success', function () {
    return view('success');
})->name('success');