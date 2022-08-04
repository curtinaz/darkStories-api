<?php

use App\Http\Controllers\CardsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// darkstories.com/api/cards
Route::get('cards', [CardsController::class, "index"]);
Route::get('cards/random', [CardsController::class, "getRandomCard"]);
