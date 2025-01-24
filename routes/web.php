<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VicidialController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/campaigns', [VicidialController::class, 'showCampaigns'])->name('campaigns');
Route::post('/execute', [VicidialController::class, 'executeCommand'])->name('execute.command');

Route::get('/real-time-table-refresh', [VicidialController::class, 'refreshTable'])->name('real-time-table-refresh');
Route::get('/real-time-stateInfo-refresh', [VicidialController::class, 'refreshStateInfo'])->name('real-time-stateInfo-refresh');
Route::get('/real-time-queueDetail-refresh', [VicidialController::class, 'refreshQueueDetail'])->name('real-time-queueDetail-refresh');
Route::get('/real-time-allCampaings-refresh', [VicidialController::class, 'refreshAllCampaings'])->name('real-time-allCampaings-refresh');