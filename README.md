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

- Example Register - POST
>http://laravelapi.test/api/auth/register
```json
{
  "username": "muratcakmak",
  "name": "Murat Çakmak",
  "email": "muratcakmak@hotmail.com",
  "password": "1234"
}
```
- Example Login - POST
>http://laravelapi.test/api/auth/login
```json
{
  "username": "muratcakmak",
  "password": "1234",
  "device_name": "galaxy s7"
}
```
- Example Get User - GET
> http://laravelapi.test/api/auth/getUser
```
> Headers Add
Authorization : Bearer 7|9cROpRF7vOu2ShkWwNTMzdOhOQDFEi9yadgJRZ5f
```
