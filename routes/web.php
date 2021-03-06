<?php

use App\Http\Livewire\CreateGame;
use App\Http\Livewire\ManageGame;
use Illuminate\Support\Facades\Route;

Route::get('/games/new', CreateGame::class)->name('littlefinger.games.create');
Route::get('/games/{game}/setup', CreateGame::class)->name('littlefinger.games.setup');
Route::get('/games/{game}', ManageGame::class)->name('littlefinger.games.show');
