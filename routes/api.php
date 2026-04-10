<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/tickets',  [TicketController::class, 'indexApi'])->middleware('auth')->name('api.tickets.index');
Route::post('/tickets', [TicketController::class, 'storeApi'])->name('api.tickets.store');
