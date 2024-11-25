<?php

use MongoDB\Driver\Manager;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('tasks', TaskController::class)->middleware('auth');

Route::get('/info', function () {
    phpinfo();
}); 

Route::get('/ping', function (Request  $request) {    
    $connection = DB::connection('mongodb');
    $msg = 'You are connected to MongoDB!';
    try {  
        $connection->command(['ping' => 1]);  
    } catch (\Exception  $e) {  
        $msg = 'You are note connected to MongoDB. Error: ' . $e->getMessage();
    }
    return ['msg' => $msg];
});

require __DIR__.'/auth.php';