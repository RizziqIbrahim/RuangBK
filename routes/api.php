<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    SiswaController,
    UserController,
    GuruController,
    ImageController,
    AdminController,
    SoalController,
    JawabanController,
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

    Route::post("siswa/update", [SiswaController::class, 'update']);
    Route::post("guru/update", [GuruController::class, 'update']);
    Route::post("admin/update", [AdminController::class, 'update']);
    
    Route::post("siswa/nisn", [SiswaController::class, 'npsn']);
    Route::post("guru/npsn", [GuruController::class, 'npsn']);
    Route::post("admin/npsn", [AdminController::class, 'npsn']);

    Route::get('/user/export/xlsx', [UserController::class ,'export']);
    Route::post('/import-users', [UserController::class ,'import']);

    Route::post('user/upload/data' , [UserController::class ,'uploadData']);
    Route::post('register-user', [GuruController::class, 'registerUser']);

    Route::get('profile', [UserController::class, 'showLogin']);

    Route::get('getSiswa', [GuruController::class ,'getSiswa']);
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