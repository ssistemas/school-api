<?php

return [
    'name' => env('APP_NAME', 'School'),

    'env' => env('APP_ENV', 'production'),

    'debug' => env('APP_DEBUG', false),

    'url' => env('APP_URL', 'https://didati.co'),

    'timezone' => 'UTC',

    'locale' => 'pt_BR',

    'fallback_locale' => 'en',

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    'log' => env('APP_LOG', 'single'),

    'log_level' => env('APP_LOG_LEVEL', 'debug'),

    'providers' => [
        // Laravel Framework Service Providers...
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        ResultSystems\Validation\ValidationServiceProvider::class,

        // Package Service Providers...
        Laravel\Tinker\TinkerServiceProvider::class,
        Migrator\MigrationServiceProvider::class,
        Spatie\Fractal\FractalServiceProvider::class,
        Codecasts\Auth\JWT\ServiceProvider::class,
        ResultSystems\Cors\CorsServiceProvider::class,

        // Support Service Providers...
        Emtudo\Support\Helpers\HelperServiceProvider::class,
        Emtudo\Support\Domain\Providers\FakerServiceProvider::class,
        Emtudo\Support\Validators\CustomValidatorServiceProvider::class,
        Emtudo\Support\Hash\IDServiceProvider::class,
        Emtudo\Support\Http\ServiceProvider::class,

        // Domains
        Emtudo\Domains\Tenants\Providers\DomainServiceProvider::class,
        Emtudo\Domains\Users\Providers\DomainServiceProvider::class,
        Emtudo\Domains\Files\Providers\DomainServiceProvider::class,
        Emtudo\Domains\Calendars\Providers\DomainServiceProvider::class,
        Emtudo\Domains\Courses\Providers\DomainServiceProvider::class,
        Emtudo\Domains\Transports\Providers\DomainServiceProvider::class,

        // Units
        Emtudo\Units\Core\Providers\UnitServiceProvider::class,
        Emtudo\Units\Auth\Providers\UnitServiceProvider::class,
        Emtudo\Units\Search\Providers\UnitServiceProvider::class,
        Emtudo\Units\Settings\Providers\UnitServiceProvider::class,

        // Units School
        Emtudo\Units\School\Providers\UnitServiceProvider::class,
        Emtudo\Units\Tenant\Providers\UnitServiceProvider::class,

        // Units Student
        Emtudo\Units\Student\Providers\UnitServiceProvider::class,

        // Units Responsible
        Emtudo\Units\Responsible\Providers\UnitServiceProvider::class,

        // Units Teacher
        Emtudo\Units\Teacher\Providers\UnitServiceProvider::class,
    ],

    'aliases' => [
        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
    ],
];
