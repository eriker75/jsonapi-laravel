<?php

use Illuminate\Support\Facades\Route;
use App\Jobs\LogAccessJob;
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
    LogAccessJob::dispatch();
    return view('welcome');
});

Route::get('/hola', function() {
    // Tus datos en formato JSON
    $data = [
        'mensaje' => 'Respuesta en formato JSON con status en Laravel',
        'status' => 'success', // Puedes personalizar el status como desees
    ];

    // Devolver una respuesta JSON con un status code específico (por ejemplo, 200 OK)
    return response()->json($data, 200);
});
