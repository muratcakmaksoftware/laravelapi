## Laravel API With Sanctum

Laravel Version 8.22.1

https://laravel.com/docs/8.x/sanctum#installation

##Authentication
- composer require laravel/sanctum
- php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
- php artisan migrate
- App/Http/Kernel.php -> $middlewareGroups > api > Add
> \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,

- App/Models/Users.php -> add
>use Laravel\Sanctum\HasApiTokens;

>use HasApiTokens, HasFactory, Notifiable; // HasApiTokens add

- config/auth.php -> auth ayarlarının yapıldığı yer.
> 'defaults' => [
    'guard' => 'api',
    'passwords' => 'users',
], //'guard' => 'web' to 'guard' => 'api',


- Example Request
> http://laravelapi.test/api/auth/getUser

> Headers -> Authorization : Bearer 5|wtfuj9LcHt94WhdeMx4FHXh6g5lWB1BQriB7yE9W
