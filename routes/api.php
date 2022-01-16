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
Route::post('/login',[AuthController::class,'login']);
Route::post('/nyoba',[AuthController::class,'nyoba']);
Route::put('/user/nonaktif',[UserController::class,'nonaktif']);
Route::put('/tahun-ajaran/nonaktif',[TahunAjaranController::class,'nonaktif']);

//delete data
Route::delete('/managemen-user/delete',[UserController::class,'delete']);
Route::delete('/tahunajaran/delete',[TahunAjaranController::class,'delete']);
Route::delete('/kelas/delete',[KelasController::class,'delete']);
Route::delete('/managemen-guru/delete',[GuruController::class,'delete']);
Route::delete('/managemen-jurusan/delete',[JurusanController::class,'delete']);
Route::delete('/managemen-siswa/delete',[SiswaController::class,'delete']);
Route::delete('/managemen-wali/delete',[WaliController::class,'delete']);
Route::delete('/mapel/delete',[MapelController::class,'delete']);
Route::delete('/mapel-guru/delete',[MapelGuruController::class,'delete']);
Route::delete('/jadwal/delete',[DetailJadwalController::class,'delete']);
Route::delete('/hari/delete',[HariController::class,'delete']);
Route::delete('/jam/delete',[PeriodController::class,'delete']);
Route::delete('/kelas-siswa/delete',[KelasSiswaController::class,'delete']);



// Auth by sanctum
Route::post('/register',[AuthController::class, 'register']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/authme', [AuthController::class ,'authMe']);
    

    
    //Fitur admin
    Route::middleware('role:admin|guru')->group(function () {

            
        Route::resource('jadwal', DetailJadwalController::class);
        Route::resource('jam', PeriodController::class);
        Route::resource('hari', HariController::class);
        Route::resource('managemen-siswa', SiswaController::class);
        Route::resource('managemen-user', UserController::class);
        Route::resource('managemen-guru', GuruController::class);
        Route::resource('managemen-wali', WaliController::class);
        Route::resource('kelas', KelasController::class);
        Route::resource('tahunajaran', TahunAjaranController::class);
        Route::resource('mapel', MapelController::class);
        Route::resource('jurusan', JurusanController::class);
        Route::resource('mapel-guru', MapelGuruController::class);
        Route::resource('kelas-siswa', KelasSiswaController::class);

        // export & import
        Route::get('export-user', [UserController::class,'export']);
        Route::post('import-user', [UserController::class,'import']);
    });


    Route::middleware('role:guru')->group(function () {
        Route::resource('jadwal-guru', JadwalController::class);
        Route::get('jadwal-guru:hari={hari}', [JadwalController::class,'perhari']);
        Route::get('jadwal-guru:jam={jam}', [JadwalController::class,'perjam']);
        Route::resource('jadwal-guru', JadwalController::class);
        Route::resource('absensi', AbsensiController::class);
        Route::get("absensi/create/{id}", [AbsensiController::class,'create']);
        
    });
});