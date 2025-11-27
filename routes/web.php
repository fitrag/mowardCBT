<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', Login::class)->name('login')->middleware('guest');
Route::get('/register', Register::class)->name('register')->middleware('guest');

Route::get('/dashboard', \App\Livewire\Dashboard::class)->middleware('auth')->name('dashboard');
Route::get('/groups', \App\Livewire\Groups\Index::class)->middleware('auth')->name('groups.index');
Route::get('/students', \App\Livewire\Students\Index::class)->middleware('auth')->name('students.index');
Route::get('/modules', \App\Livewire\Modules\Index::class)->middleware('auth')->name('modules.index');
Route::get('/subjects', \App\Livewire\Subjects\Index::class)->middleware('auth')->name('subjects.index');
Route::post('/upload-image', [\App\Http\Controllers\ImageUploadController::class, 'upload'])->middleware('auth')->name('upload.image');
Route::get('/questions', \App\Livewire\Questions\Index::class)->middleware('auth')->name('questions.index');

Route::post('/logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');
