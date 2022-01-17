<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
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
Route::put('/user/nonaktif',[UserController::class,'nonaktif']);
Route::put('/tahun-ajaran/nonaktif',[TahunAjaranController::class,'nonaktif']);



// Auth by sanctum
Route::post('/register',[AuthController::class, 'register']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/authme', [AuthController::class ,'authMe']);
    

    
    //Fitur admin
    Route::middleware('role:admin|guru')->group(function () {

            
        
    });


    Route::middleware('role:guru')->group(function () {
        
        
    });
});