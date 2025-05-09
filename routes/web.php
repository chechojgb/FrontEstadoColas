<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VicidialController;
use Illuminate\Http\Request;

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


Route::get('/', [VicidialController::class, 'showCampaigns'])->name('campaigns');
Route::get('/campaigns', [VicidialController::class, 'showCampaigns'])->name('campaigns');
Route::post('/execute', [VicidialController::class, 'executeCommand'])->name('execute.command');
Route::get('/execute', function () {
    return redirect('/');
});

Route::get('/real-time-table-refresh', [VicidialController::class, 'refreshTable'])->name('real-time-table-refresh');
Route::get('/real-time-stateInfo-refresh', [VicidialController::class, 'refreshStateInfo'])->name('real-time-stateInfo-refresh');
Route::get('/real-time-queueDetail-refresh', [VicidialController::class, 'refreshQueueDetail'])->name('real-time-queueDetail-refresh');
Route::get('/real-time-allCampaings-refresh', [VicidialController::class, 'refreshAllCampaings'])->name('real-time-allCampaings-refresh');


Route::get('/real-time-agent-data', [VicidialController::class, 'getAgentData']);


Route::post('/save-sort-state', function (Request $request) {
    session([
        'lastSortedColumn' => $request->input('column'),
        'lastSortOrder' => $request->input('order')
    ]);
    return response()->json(['message' => 'Sort state saved']);
});
