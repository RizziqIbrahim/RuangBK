<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    SiswaController,
    UserController,
    GuruController,
    ImageController,
    AdminController
};
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/login', function () {
    return response()->json([
        'message' => 'Hayoo Antum Mau Ngapain?, halaman ini terlarang buat antum masuki'
    ], 401);
});

Route::post('/login-email',[AuthController::class,'loginEmail']);
Route::post('/login-nomor',[AuthController::class,'loginNomor']);

Route::resource('images', ImageController::class);


// Auth by sanctum
Route::post('/register',[AuthController::class, 'register']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/authme', [AuthController::class ,'authMe']);
    Route::resource('siswa', SiswaController::class);
    Route::resource('users', UserController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('admin', AdminController::class);
    //delete
    

    //Fitur admin
    Route::middleware('role:admin')->group(function () {
            
    });


    Route::middleware('role:guru')->group(function () {
        
        
    });

    Route::middleware('role:siswa')->group(function () {
        
        
    });

    //sementara
    
});