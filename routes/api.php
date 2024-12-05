<?php

use App\Http\Controllers\NumberController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

//Route::get('/getNumber', [NumberController::class, 'getNumber']);
//Route::get('/getSms', [NumberController::class, 'getSms']);
//Route::get('/cancelNumber', [NumberController::class, 'cancelNumber']);
//Route::get('/getStatus', [NumberController::class, 'getStatus']);

Route::get('/{path}', function (Request $request) {
    try {
        $response = Http::withOptions(['verify' => false])->get('https://postback-sms.com/api/', $request);
    } catch (\Exception $e) {
        return response()->json([
            'code' => 'error',
            'message' => 'Connection Error: ' . $e->getMessage()
        ]);
    }
    return response()->json($response->json());
})->whereIn('path', ['getNumber', 'getSms', 'cancelNumber', 'getStatus']);
