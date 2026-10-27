<?php

use App\Http\Controllers\categoriaController;
use App\Http\Controllers\clienteController;
use App\Http\Controllers\compraController;
use App\Http\Controllers\ExPDFController;
use App\Http\Controllers\ExportPDFController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\marcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\proveedorController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\userController;
use App\Http\Controllers\ventaController;
use App\Models\Categoria;
use Illuminate\Support\Facades\Route;

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

// Todas estas rutas requieren sesión iniciada
Route::middleware('auth')->group(function () {
    Route::get('/',[homeController::class,'index'])->name('panel');

    Route::resource('categorias', categoriaController::class )->except('show');
    Route::resource('marcas', marcaController::class )->except('show');
    Route::resource('productos', ProductoController::class )->except('show');
    Route::post('productos/reporte', [ProductoController::class, 'reporte_productos'])->name('productos.reporte');
    Route::resource('clientes', clienteController::class );
    Route::resource('proveedores', proveedorController::class )->except('show');
    Route::resource('compras', compraController::class )->except('edit', 'update');
    Route::resource('ventas', ventaController::class )->except('edit', 'update');
    Route::resource('users', userController::class )->except('show');
    Route::resource('roles', roleController::class )->except('show');
    // Route::resource('profiles',profileController::class )->only('index', 'update');
    Route::resource('inventario', InventarioController::class);

    Route::post('/ventas/date', [ventaController::class, 'showByDateRange'])->name('venta.showByDateRange');

    Route::get('/export-pdf-comprobante-venta/{id}', [ExportPDFController::class, 'exportPdfComprobanteVenta'])
    ->name('export.pdf-comprobante-venta');

    Route::get('/export-pdf-venta-producto', [ExportPDFController::class, 'exportPdfVentaProducto'])
    ->name('export.pdf-venta-producto');

    // Cambio de contraseña: solo de la cuenta con sesión iniciada
    Route::get('/forgot/password', [userController::class, 'showForgotPassword'])->name('showForgotPassword');
    Route::post('/edit/password', [userController::class, 'editPassword'])->name('editPassword');
    Route::post('/update/password', [userController::class, 'updatePassword'])->name('updatePassword');
});

// dd(view()->exists('pdf.comprobante-venta'));


Route::get('/login',[loginController::class,'index'])->name('login');
Route::post('/login',[loginController::class,'login'])->middleware('throttle:5,1')->name('login.login');
Route::get('/logout',[logoutController::class,'logout'])->name('logout');

//Reportes






Route::get('/401', function () {
    return view('pages.401');
});

Route::get('/404', function () {
    return view('pages.404');
});

Route::get('/500', function () {
    return view('pages.500');
});

