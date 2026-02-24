<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// 1. Ruta principal: Muestra el dashboard con los datos actuales
Route::get('/', [DashboardController::class, 'index'])->name('home');

// 2. Ruta de Procesamiento: Analiza los datos y muestra los resultados en pantalla
Route::post('/procesar', [DashboardController::class, 'process'])->name('taller.procesar');

// 3. Ruta de Exportación: Genera el PDF filtrado por el módulo activo
Route::post('/descargar-pdf', [DashboardController::class, 'downloadPdf'])->name('taller.pdf');


// 4. Guardar Datos: Recibe la información del Modal (Pop-up) y la guarda en la sesión
Route::post('/store-data', [DashboardController::class, 'storeData'])->name('data.store');

// 5. Eliminar Datos: Borra un registro específico de la sesión usando su ID único
Route::get('/delete-data/{type}/{id}', [DashboardController::class, 'deleteData'])->name('data.delete');