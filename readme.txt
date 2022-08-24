
**Step by Step API with Laravel & Vue**

**Backend Service :**
1. Install kebutuhan Laravel & siapkan database engine (Mysql) + Database baru
2. Buat Project bernama Backend
    composer create-project laravel/laravel backend
3. Masuk ke directory backend, kemudian install sanctum
    composer require laravel/sanctum
4. Publish Sanctum Configuration File
    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
5. Konfigurasi Koneksi DB (.env)
6. Jalankan perintah migrate
    php artisan migrate
7. Tambahkan / Aktifkan middleware sanctum di kernel.php  (middlewareGroups - api)
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
8. Buat 1 Table bernama products
    php artisan make:migration create_products_table
9. Tambahkan kolom name (string) dan detail (text) pada file migrate
    $table->string('name');
    $table->text('detail');
10. Jalankan perintah migrate
    php artisan migrate
11. Buat Model Product
    php artisan make:model Product
12. Ubah Model Product dengan :
    protected $fillable = [
        'name', 'detail'
    ];
13. Atur skema routing untuk API :
    Route::controller(RegisterController::class)->group(function(){
        Route::post('register', 'register');
        Route::post('login', 'login');
    });
            
    Route::middleware('auth:sanctum')->group( function () {
        Route::resource('products', ProductController::class);
    });
14. Buat directory API di Controllers, kemudian buat 3 Controller BaseController, ProductController & UserController
15. Isi Controller silahkan lihat di controller masing - masing
16. Buat ProductResource untuk menormalisasi data produk
    php artisan make:resource ProductResource
17. Run Server & check setiap endpoint
18. Membuat handler 404 apabila endpoint tidak ditemukan : buka routes/api.php :
    Route::fallback(function () {
        return response()->json(['success'=>false, 'message'=>'Endpoint Not Found'], 404);
    });

**IP Restriction**
19. Buat middleware penanganan whitelist IP 
    php artisan make:middleware RestrictIpAddressMiddleware
20. Daftarkan middleware pada kernel.php (bagian API)
    \App\Http\Middleware\RestrictIpAddressMiddleware::class,
21. Mengatur expired Sanctum Token : config/sanctum.php => ubah expiration dengan satuan menit
22. Menambah kolom access_by table products dengan migration
    php artisan make:migration add_access_by_to_products_table --table=products
    Buka file migrate & tambahkan :
    $table->string('access_by')->after('detail');
    php artisan migrate
23. edit Model Product, tambahkan access_by di fillable
24. Menambahkan siapa yang menambahkan data tersebut :
    use Laravel\Sanctum\PersonalAccessToken;
    di function store :
    $token = PersonalAccessToken::findToken($request->bearerToken());    
    $input = array_merge($request->all(),['access_by'=>$token->tokenable['name']]);
25. Memastikan seluruh error di response kedalam JSON :
    php artisan make:middleware ForceJsonResponseMiddleware
    Daftarkan di kernel.php
    buat function exception di handler.php

**Frontend Service :**


