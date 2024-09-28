# Laravel Fortify

1.  composer global require laravel/installer (if already > skip)
2.  laravel new fortify-feature
3.  composer create-project --prefer-dist laravel/laravel:^10.0 laravel-fortify
4.  cd laravel-fortify
5.  composer require laravel/fortify
6.  php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
7.  php artisan migrate
8.  php artisan fortify:install
9.  modify file config/app.php
    ```
        'providers' => [
            App\Providers\FortifyServiceProvider::class,
        ]
    ```
10. modify file app/Providers/FortifyServiceProvider.php
    ```
        Fortify::registerView(function () {
            return view('auth.register');
        });
    ```
11. php artisan make:controller HomeController
12. php artisan make:controller ProfileController
13. php artisan make:controller VerifyEmailController
    ```
        public function _invoke(EmailVerificationRequest $request): RedirectResponse
        {
            // Mark the user's email as verified
            if ($request->user()->hasVerifiedEmail()) {
                return redirect()->route('home.index')->with('status', 'Already verified. Cannot verify again.');
            }

            $request->fulfill(); // Complete the email verification

            // Return a success response after verification
            return redirect()->route('home.index')->with('status', 'Verification successful. You can now access the application.');
        }

        Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
            ->middleware(['auth', 'signed', 'throttle:6,1'])
            ->name('verification.verify');
    ```

    ```
        Middleware throttle:6,1 di Laravel digunakan untuk membatasi jumlah permintaan yang dapat dilakukan ke suatu rute dalam periode waktu tertentu. Ini membantu mencegah penyalahgunaan atau spam (misalnya, percobaan verifikasi yang berlebihan).

        Rincian throttle:6,1:
        6: Ini adalah jumlah maksimum permintaan yang dapat dilakukan ke rute dalam periode waktu yang diberikan.
        1: Ini adalah periode waktu dalam menit untuk aturan throttling. Dalam hal ini, berarti 1 menit.

        Jadi, throttle:6,1 berarti pengguna dapat melakukan maksimum 6 permintaan per menit ke rute tersebut. Jika pengguna melebihi batas ini, Laravel secara otomatis akan mengembalikan respons 429 Too Many Requests, mencegah permintaan lebih lanjut selama periode waktu tersebut.

        __invoke Method: Memungkinkan Anda membuat kontroler yang hanya memiliki satu metode yang dipanggil secara langsung, menyederhanakan penanganan rute yang memerlukan aksi tunggal.
    ```

14. php artisan make:controller TwoFactorAuthController
15. php artisan make:migration add_two_factor_confirmed_to_users_table --table=users
    ```
        public function up(): void
        {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('two_factor_confirmed')->default(false);
            });
        }
        public function down(): void
        {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('two_factor_confirmed');
            });
        }
    ```
16. php artisan make:controller RecoveryTwoFactorAuthController
17. reload helper : composer dump-autoload
18. php artisan make:migration add_recovery_codes_generated_at_to_users_table --table=users
    ```
        public function up(): void
        {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('recovery_codes_generated_at')->nullable();
            });
        }
        public function down(): void
        {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('recovery_codes_generated_at');

            });
        }
    ```
# Laravel-Fortify-2FA
