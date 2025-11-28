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
Route::get('/tests', \App\Livewire\Tests\Index::class)->middleware('auth')->name('tests.index');
Route::get('/tests/create', \App\Livewire\Tests\Create::class)->middleware('auth')->name('tests.create');
Route::get('/tests/{test}/edit', \App\Livewire\Tests\Edit::class)->middleware('auth')->name('tests.edit');
Route::get('/tests/{test}/results', \App\Livewire\Tests\Results\Index::class)->middleware('auth')->name('tests.results');
Route::get('/tokens', \App\Livewire\Tokens\Index::class)->middleware('auth')->name('tokens.index');

// Student Routes
Route::get('/student/dashboard', \App\Livewire\StudentDashboard::class)->middleware('auth')->name('student.dashboard');
Route::get('/student/tests/{test}', \App\Livewire\TestDetail::class)->middleware('auth')->name('student.test.detail');
Route::get('/student/tests/{test}/take', \App\Livewire\TakeTest::class)->middleware('auth')->name('student.test.take');
Route::get('/student/tests/{test}/result', \App\Livewire\TestResult::class)->middleware('auth')->name('student.test.result');

Route::post('/logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');
